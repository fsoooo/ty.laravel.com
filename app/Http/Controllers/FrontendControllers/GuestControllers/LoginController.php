<?php

namespace App\Http\Controllers\FrontendControllers\GuestControllers;

use Validator, Session, DB, Cache;
use App\Models\User;
use App\Models\UserThird;
use App\Models\Agent;
use App\Models\EmailInfo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Helper\Email;
use App\Helper\RsaSignHelp;
use Ixudra\Curl\Facades\Curl;
use \Illuminate\Support\Facades\Redis;


class LoginController extends Controller
{

    use AuthenticatesUsers;
    //判断是否是手机浏览器登录
    function is_mobile()
    {
        //正则表达式,批配不同手机浏览器UA关键词。
        $regex_match="/(nokia|iphone|android|motorola|^mot\-|softbank|foma|docomo|kddi|up\.browser|up\.link|";
        $regex_match.="htc|dopod|blazer|netfront|helio|hosin|huawei|novarra|CoolPad|webos|techfaith|palmsource|";
        $regex_match.="blackberry|alcatel|amoi|ktouch|nexian|samsung|^sam\-|s[cg]h|^lge|ericsson|philips|sagem|wellcom|bunjalloo|maui|";
        $regex_match.="symbian|smartphone|midp|wap|phone|windows ce|iemobile|^spice|^bird|^zte\-|longcos|pantech|gionee|^sie\-|portalmmm|";
        $regex_match.="jig\s browser|hiptop|^ucweb|^benq|haier|^lct|opera\s*mobi|opera\*mini|320x320|240x320|176x220";
        $regex_match.=")/i";
        return isset($_SERVER['HTTP_X_WAP_PROFILE']) or isset($_SERVER['HTTP_PROFILE']) or preg_match($regex_match, strtolower($_SERVER['HTTP_USER_AGENT'])); //如果UA中存在上面的关键词则返回真。
    }
    //登录主页
    public function login()
    {
        if(isset($_COOKIE['login_type'])){
            return redirect('/');
        }
        $is_mobile = $this->is_mobile();
        if($is_mobile){
            return view('frontend.guests.mobile.login_index');
        }
        return view('frontend.guests.login.login_index');
    }
    //个人登录
    public function loginPerson()
    {
        $is_mobile = $this->is_mobile();
        if($is_mobile){
            return view('frontend.guests.mobile.login_person');
        }
        return view('frontend.guests.login.login');
    }
    //企业登录
    public function loginCompany()
    {
        if($this->is_mobile()){
            return view('frontend.guests.mobile.login_company');
        }
        return view('frontend.guests.login.login_company');
    }
    //处理登录
    public function doLogin(Request $request)
    {
        $phone = $request->get('phone');
        $password = $request->get('password');
        //输入的为用户表 手机号码
        if (Auth::attempt(['phone' => $phone, 'password' => $password])|| Auth::attempt(['code' => $phone, 'password' => $password])){
            if(User::where('id',Auth::user()->id)->first()['type'] == 'company'){
                return back()->withErrors('请通过企业用户渠道登陆！');
            }
            // 认证通过...
            setcookie('user_id',Auth::user()->id,(time()+3600));
            setcookie('login_type',Auth::user()->type,(time()+3600));
            setcookie('user_name',Auth::user()->name,(time()+3600));
            if(isset($_COOKIE['identification']))
            {
                if(Redis::exists('prepare_order'.$_COOKIE['identification'])){
                    return redirect('/ins/insure_post');
                }else{
                    return redirect('/ins/insure/'.$_COOKIE['identification']);
                }
            }else{
                return redirect('/');
            }
            //输入的为代理人表 手机号码
        }else if($agent = Agent::where('phone', $phone)->first()) {
            if(Auth::attempt(['phone' => $agent->user->phone, 'password' => $password])){
                setcookie('user_id',Auth::user()->id,(time()+3600));
                setcookie('login_type',Auth::user()->type,(time()+3600));
                setcookie('user_name',Auth::user()->name,(time()+3600));
                if(isset($_COOKIE['identification']))
                {
                    if(Redis::exists('prepare_order'.$_COOKIE['identification'])){
                        return redirect('/ins/insure_post');
                    }else{
                        return redirect('/ins/insure/'.$_COOKIE['identification']);
                    }
                }else{
                    return redirect('/');
                }
            }
        }
        return back()->withErrors('账户或密码错误！');
    }
    //企业登陆 todo  还没做匿名投保
    public function doLoginCompany(Request $request)
    {
        $email = $request->get('email');
        $password = $request->get('password');
        //输入的为用户表 手机号码
        if (Auth::attempt(['email' => $email, 'password' => $password])|| Auth::attempt(['code' => $email, 'password' => $password])){
            if(User::where('id',Auth::user()->id)->first()['type'] == 'user'){
                return back()->withErrors('请通过个人用户渠道登陆！');
            }
            // 认证通过...
            setcookie('user_id',Auth::user()->id,(time()+3600));
            setcookie('login_type',Auth::user()->type,(time()+3600));
            setcookie('user_name',Auth::user()->name,(time()+3600));
            if(isset($_COOKIE['identification']) && !$this->is_mobile()) {
                if(Redis::exists('prepare_order'.$_COOKIE['identification'])){
                    return redirect('/ins/insure_post');
                }else{
                    return redirect('/ins/insure/'.$_COOKIE['identification']);
                }
            }elseif(isset($_COOKIE['identification']) && $this->is_mobile()){
                if(Redis::exists('prepare_order'.$_COOKIE['identification'])){
                    return redirect('/ins/group_ins/insure_post');
                }else{
                    return redirect('/ins/mobile_group_ins/insure/'.$_COOKIE['identification']);
                }
            }else{
                return redirect('/');
            }
        }
        return back()->withErrors('账户或密码错误！');
    }
    //手机号快捷登录
    public function doPhoneLogin(Request $request)
    {
        $input = $request->all();
        //验证表单
        $input['password'] = '******';
        $validator = $this->checkAddUserPost($input);
        if ($validator->fails()){
            return back()->withErrors($validator);
        }
        //手机验证码验证
        $check_phone = $this->checkPhoneCode($input['phone'], $input['phone_code']);
        $check_phone['status'] = 'success';
        if($check_phone['status'] != 'success'){
            return back()->withErrors([$check_phone['message']]);
        }else{
            $user = User::where('phone',$input['phone'])->first();
                setcookie('user_id',$user->id,(time()+3600));
                setcookie('login_type',$user->type,(time()+3600));
                setcookie('user_name',$user->name,(time()+3600));
            if(isset($_COOKIE['identification'])){
                if(Redis::exists('prepare_order'.$_COOKIE['identification'])){
                    return redirect('/ins/insure_post');
                }else{
                    return redirect('/ins/insure/'.$_COOKIE['identification']);
                }
            }else{
                return redirect('/information/');
            }
        }
    }
    //显示注册前的页面展示
    public function registerFront()
    {
        return view('frontend.guests.login.register_index');
    }
    //登出
    public function logOut(Request $request)
    {
        setcookie('login_type','',time()-1);
        setcookie('user_id','',time()-1);
        setcookie('user_name','',time()-1);
        setcookie('user_type','',time()-1);
        //删除redis
        if(isset($_COOKIE['identification'])){
            Redis::exists('prepare_order'.$_COOKIE['identification'])?Redis::del('prepare_order'.$_COOKIE['identification']):'';
        }
        Auth::logout();
        return redirect('/login')->with('status', '已退出登录!');
    }
    //注册页面
    public function register($type)
    {
        $is_mobile = $this->is_mobile();
        if($is_mobile){
            return view('frontend.guests.mobile.register_person',compact('type'));
        }
        return view('frontend.guests.login.register',compact('type'));
    }
    //注册提交
    public function registerPost(Request $request)
    {
        $input = $request->all();
       //验证表单
        if($input['identifying'] == 'person')
        {
            $validator = $this->checkAddUserPost($input);
            if ($validator->fails()) {
                return redirect('/register/person')
                    ->withErrors($validator);
            }
        }elseif($input['identifying'] == 'company'){
            $validator = $this->checkAddCompanyPoset($input);
            if ($validator->fails()) {
                return redirect('/register/company')
                    ->withErrors($validator);
            }
        }else{
            $validator = $this->checkAddUserPost($input);
            if ($validator->fails()) {
                return redirect('/register/group')
                    ->withErrors($validator);
            }
        }
        if($input['identifying'] == 'person'||$input['identifying'] == 'third'){
        //        手机验证码验证
        $check_phone = $this->checkPhoneCode($input['phone'], $input['phone_code']);
        if($check_phone['status'] != 'success'){
            return redirect('/register/person')
                ->withErrors([$check_phone['message']]);
        }
        }else{
            $check_email = $this->checkEmailCode($input['email'],$input['email_code']);
            if($check_email['status'] != 'success'){
                return redirect('/register/company')
                    ->withErrors([$check_email['message']]);
            }
        }
        if(isset($input['app_id'])&&!empty($input['app_id'])){
                $input['app_id'] = json_decode($input['app_id'],true);
                DB::beginTransaction();
                $user = new User();
                $user->name = $input['app_id']['name'];
                $user->phone = $input['phone'];
                $user->password = bcrypt($input['password']);
                $user->save();
                UserThird::where('app_id',$input['app_id']['app_id'])->update(['user_id'=>$user->id]);
                DB::commit();
                setcookie('user_id',$user->id,(time()+3600));
                setcookie('login_type','user',(time()+3600));
                setcookie('user_name',$input['app_id']['name'],(time()+3600));
                if(isset($_COOKIE['identification'])&&!empty($_COOKIE['identification']))
                {
                    if(Redis::exists('prepare_order'.$_COOKIE['identification'])){
                        return redirect('/ins/insure_post');
                    }else{
                        return redirect('/ins/insure/'.$_COOKIE['identification']);
                    }
                }else {
                    return redirect('/information/');
                }
        }else{
            //添加
            try{
                DB::beginTransaction();
                //add user
                if($input['identifying'] == 'person')
                {
                    $user = new User();
                    $user->name = ' ';
                    $user->phone = $input['phone'];
                    $user->password = bcrypt($input['password']);
                    $user->type = 'user';
                    $user->save();
                    DB::commit();
                    return redirect('/login_person')->with('status', '注册成功，请登录!');
                }elseif($input['identifying'] == 'company'){
                    $user = new User();
                    $user->email = $input['email'];
                    $user->name = ' ';
                    $user->password = bcrypt($input['password']);
                    $user->type = 'company';
                    $user->save();
                    DB::commit();
                    return redirect('/login_company')->with('status', '注册成功，请登录!');
                }else{
                    $user = new User();
                    $user->name = ' ';
                    $user->phone = $input['phone'];
                    $user->password = bcrypt($input['password']);
                    $user->type = 'group';
                    $user->save();
                    DB::commit();
                    return redirect('/login_person')->with('status', '注册成功，请登录!');
                }

            }catch (\Exception $e){
                DB::rollBack();
                return back()->withErrors($e->getMessage());
            }
        }
    }
    //获取随机数
    public function randChar()
    {
        $str = "";
        for ($i = 0; $i < 3; $i++) {
            $str .= '&#' . rand(19968, 40869) . ';';
        }
        return $str;
    }
    //企业注册验证信息
    protected function checkAddCompanyPoset($input){
        //规则
        $rules = [
            'email' => 'required',
            'email_code' => 'required',
            'password' => 'required|min:6',
        ];
        //自定义错误信息
        $messages = [
            'required' => 'The :attribute is null.',
            'size' => 'The :attribute mast exactly :size.',
            'min' => 'The :attribute length mast be greater than :min.',
        ];
        //验证
        $validator = Validator::make($input, $rules, $messages);
        return $validator;
    }
    //校验用户注册信息
    protected function checkAddUserPost($input)
    {
        //规则
        $rules = [
            'phone' => 'required|size:11',
            'phone_code' => 'required',
            'password' => 'required|min:6',
        ];

        //自定义错误信息
        $messages = [
            'required' => 'The :attribute is null.',
            'size' => 'The :attribute mast exactly :size.',
            'min' => 'The :attribute length mast be greater than :min.',
        ];
        //验证
        $validator = Validator::make($input, $rules, $messages);
        return $validator;
    }
    //校验手机验证
    protected function checkPhoneCode($phone, $phone_code)
    {
        if(!Cache::get("reg_code_".$phone))
            return ['status'=>'error', 'message'=>'验证码不存在，请重新发送'];
        if(Cache::get("reg_code_".$phone) != $phone_code)
            return ['status'=>'error', 'message'=>'验证码错误'];
        return ['status'=> 'success', 'message'=>'验证码正确'];
    }
    //校验邮件验证
    protected function checkEmailCode($email,$email_code){
        if(!session($email))
            return ['status'=>'error', 'message'=>'验证码不存在，请重新发送'];
        if(session($email) != $email_code)
            return ['status'=>'error', 'message'=>'验证码错误'];
        return ['status'=> 'success', 'message'=>'验证码正确'];
    }
    //检验手机号是否注册
    public function checkExistPhone(Request $request)
    {
        $data = $request->phone;
        $pattern = "/^([0-9A-Za-z\\-_\\.]+)@([0-9a-z]+\\.[a-z]{2,3}(\\.[a-z]{2})?)$/i";
            $res = User::where([
                ['phone',$request->phone],
                ['type','user'],
            ])->first();
        if($res){
            return response()->json(array('status'=> 1, 'message'=>'手机号已存在'), 200);
        }else{
            return response()->json(array('status'=> 0, 'message'=>'可注册'), 200);
        }
    }
    //找回密码
    public function  findPwd(){
        $is_mobile = $this->is_mobile();
        if($is_mobile){
            return view('frontend.guests.mobile.find_pwd');
        }
        return view('frontend.guests.login.find_pwd')->with('step','1');
    }
    //更新密码
    public function updatePwd(){
        $is_mobile = $this->is_mobile();
        if($is_mobile){
            return view('frontend.guests.mobile.update_pwd');
        }
    }
    //处理找回密码
    public function doFindPwd(Request $request)
    {
        $input = $request->all();
        //获取路由
        if(isset($input['account'])){
            $data = $input['account'];
            $pattern = "/^([0-9A-Za-z\\-_\\.]+)@([0-9a-z]+\\.[a-z]{2,3}(\\.[a-z]{2})?)$/i";
            if (preg_match($pattern, $data)) {
                $res = User::where('email',$data)->first();
                if(is_null($res)){
                    return back()->withErrors('账号不存在！!');
                }else{
                    if(empty($_COOKIE['user_account_email'])){
                        setcookie('user_account_email',$data,(time()+3600));
                    }
                    return view('frontend.guests.login.find_pwd')
                        ->with('user_account_phone',$res->phone)
                        ->with('user_account_email',$res->email)
                        ->with('step','2');
                }
            }else{
                $res = User::where('phone',$data)->first();
                if(is_null($res)){
                    return back()->withErrors('账号不存在！');
                }else{
                    if(empty($_COOKIE['user_account_phone'])){
                        setcookie('user_account_phone',$data,(time()+3600));
                    }
                    return view('frontend.guests.login.find_pwd')
                        ->with('user_account_phone',$res->phone)
                        ->with('user_account_email',$res->email)
                        ->with('step','2');
                }
            }
        }else if(isset($input['check_type'])){
            if(!isset($_COOKIE['user_account_phone'])&&!isset($_COOKIE['user_account_email'])){
                return json_encode(['status'=>'500','content'=>'请求不存在！'],JSON_UNESCAPED_UNICODE);
            }
            $check_type = $input['check_type'];
            if($check_type=='phone'){
                $data = $_COOKIE['user_account_phone'];
                $check_phone = $this->checkPhoneCode($input['phone'], $input['phone_code']);
            if($check_phone['status'] != 'success'){
                    return back()
                        ->withErrors([$check_phone['message']]);
                }else{
                    if(empty($_COOKIE['user_account_phone'])){
                        setcookie('user_account_phone',$data,(time()+3600));
                    }
                    return view('frontend.guests.login.find_pwd')->with('step','3');
                }
            }else{
                $data = $_COOKIE['user_account_email'];
                $email = $input['email'];
                $params = ['step'=>'3','email'=>$email,'time'=>time(),'expire'=>'3600'];
                $params =json_encode($params);
                $params = $this->encrypt($params);
                $send = env('TY_API_PRODUCT_SERVICE_URL');
                $file = '';
                $title = '找回密码';
                $content = "<p>尊敬的客户</p><p>您好</p><p>请点击以下地址重置密码：</p>
                    <p>http://dev312.inschos.com/doemailfindpwd/".$params."</p>"."<p>天眼互联</p>";
                $mail = new Email();
                $mail->setServer("smtp.exmail.qq.com", "galaxy@mengtiancai.com", "Shiqu521"); //设置smtp服务器
                $mail->setFrom("galaxy@mengtiancai.com"); //设置发件人
                $mail->setReceiver($email);
                $mail->setMailInfo($title,$content);// 设置邮件主题、内容
                $success =  $mail->sendMail(); //发送
                if($success){
                    EmailInfo::insert([
                        'send'=>$send,
                        'receive'=>$email,
                        'title'=>$title,
                        'content'=>$content,
                        'file'=>$file,
                        'created_at'=>date('YmdHis',time()),
                        'updated_at'=>date('YmdHis',time())
                    ]);
                    $sign_help = new RsaSignHelp();
                    $biz_content = array('email'=>$email,'title'=>$title,
                        'send'=>$send,'content'=>$content,'file'=>config('curl_product.email_file_url').$file);
                    $sign_help = new RsaSignHelp();
                    $data = $sign_help->tySign($biz_content);
                    $response = Curl::to(env('TY_API_SERVICE_URL') . '/saveemails')
                        ->returnResponseObject()
                        ->withData($data)
                        ->withTimeout(60)
                        ->post();
                    if($response->status == '200')
                    {
                        return json_encode(['status'=>'0','content'=>'邮件发送成功！'],JSON_UNESCAPED_UNICODE);
                    }
                }else{
                    return json_encode(['status'=>'1','content'=>'邮件发送失败！'],JSON_UNESCAPED_UNICODE);
                }
            }
        }else if(isset($input['password'])){
            $password = $input['password'];
            $confirm_password = $input['confirm_password'];
            if($password !== $confirm_password){
                return back()->withErrors('两次密码不相等！');
            }else{
                if(isset($_COOKIE['user_account_phone'])){
                    $phone = $_COOKIE['user_account_phone'];
                    User::where('phone',$phone)->update(['password'=>bcrypt($password)]);
                    if(empty($_COOKIE['user_new_password'])){
                        setcookie('user_new_password',$password,(time()+3600));
                    }
                }else if(isset($_COOKIE['user_account_email'])){
                    $email = $_COOKIE['user_account_email'];
                    User::where('email',$email)->update(['password'=>bcrypt($password)]);
                    if(empty($_COOKIE['user_new_password'])){
                        setcookie('user_new_password',$password,(time()+3600));
                    }
                }else{
                    if(isset($input['email'])){
                        User::where('email',$input['email'])->update(['password'=>bcrypt($password)]);

                        if(empty($_COOKIE['user_new_password'])){
                            setcookie('user_new_password',$password,(time()+3600));
                        }
                        $phone = User::where('email',$input['email'])->first();
                        if(!is_null($phone)){
                            $phone = $phone->phone;
                        }else{
                            return redirect('/findpwd')->withErrors('操作错误！');
                        }
                    }

                }
                $is_mobile = $this->is_mobile();
                if($is_mobile){
                    return redirect('/login_person')->withErrors('密码找回成功，请重新登录！');
                }
                return view('frontend.guests.login.find_pwd')
                    ->with('phone',$phone)
                    ->with('password',$password)
                    ->with('step','4');
            }
        }
    }
    //手机号找回密码
    public function doMobilePwd(Request $request)
    {
        $input = $request->all();
        $account  = $input['account'];
        $check_code  = $input['phone_code'];
        $account_type = $input['check_type'];
//                手机验证码验证
        $check_phone = $this->checkPhoneCode($input['account'], $input['phone_code']);
//        dd(Cache::get("reg_code_".$account));
        if($check_phone['status'] != 'success'){
            return redirect('/login_person')->withErrors([$check_phone['message']]);
        }
//        dd($input);
        if($account_type=='email'){
            setcookie('user_account_email',$account,(time()+3600));
            return view('frontend.guests.mobile.update_pwd')->with('step','3');
        }else if($account_type=='phone'){
            setcookie('user_account_phone',$account,(time()+3600));
            return view('frontend.guests.mobile.update_pwd')->with('step','3');
        }else{
            return redirect(' /login_person');
        }

    }
    //邮件找回密码
    public  function doEmailFindPwd($data){
        $data = $this->decrypt($data);
       $data = json_decode($data,true);
       if($data['time']+$data['expire']<time()){
           return view('frontend.guests.login.find_pwd')
               ->with('email',$data['email'])
               ->with('step','3');
       }else{
           return view('frontend.guests.login.find_pwd')
               ->with('step','5');
       }
    }
    //加密
    function encrypt($data)
    {
        $key = 'inschos';
        $key    =   md5($key);
        $x      =   0;
        $len    =   strlen($data);
        $l      =   strlen($key);
        $char = '';
        $str = '';
        for ($i = 0; $i < $len; $i++)
        {
            if ($x == $l)
            {
                $x = 0;
            }
            $char .= $key{$x};
            $x++;
        }
        for ($i = 0; $i < $len; $i++)
        {
            $str .= chr(ord($data{$i}) + (ord($char{$i})) % 256);
        }
        return base64_encode($str);
    }
    //解密
    function decrypt($data)
    {
        $key = 'inschos';
        $key = md5($key);
        $x = 0;
        $data = base64_decode($data);
        $len = strlen($data);
        $l = strlen($key);
        $char = '';
        $str = '';
        for ($i = 0; $i < $len; $i++)
        {
            if ($x == $l)
            {
                $x = 0;
            }
            $char .= substr($key, $x, 1);
            $x++;
        }
        for ($i = 0; $i < $len; $i++)
        {
            if (ord(substr($data, $i, 1)) < ord(substr($char, $i, 1)))
            {
                $str .= chr((ord(substr($data, $i, 1)) + 256) - ord(substr($char, $i, 1)));
            }
            else
            {
                $str .= chr(ord(substr($data, $i, 1)) - ord(substr($char, $i, 1)));
            }
        }
        return $str;
    }
    //三方登录
    public function doThirdLogin(Request $request){
        $code = $request->get('code');
        $appid	= '159802921abdeb';
        $token	= '2dfceddf0c58b30ed36ad25a40ee06e3';
            $params=array(
                'type'=>'get_user_info',
                'code'=>$code,
                'appid'=>$appid,
                'token'=>$token
            );
            $params = $this->http($params);
            if(empty($params)){
                return redirect('/login')->withErrors('登录超时！');
            }else{
                //三方登陆获取的信息
                $name = $params['name'];
                $img  =$params['img'];
                $sex = $params['sex'];//1男2女
                $uniq = $params['uniq'];
                $from = $params['from'];
                $res  = UserThird::where('app_id',$uniq)->first();
                //还没注册
                if(empty($res)){
                    $data = [
                        'user_id'=>'',
                        'api_type'=>$from,
                        'app_id'=>$uniq,
                        'name'=>$name,
                        'img'=>$img,
                        'sex'=>$sex,
                        'created_at'=>date('Y-m-d H:i:s',time()),
                        'updated_at'=>date('Y-m-d H:i:s',time()),
                    ];
                    UserThird::insert($data);
                    $data = json_encode($data);
                    $is_mobile = $this->is_mobile();
                    if($is_mobile){
                        return view('frontend.guests.mobile.login_third')
                            ->with('type','third')
                            ->with('user_third_register',$data);
                    }
                    return view('frontend.guests.login.register')
                        ->with('type','third')
                        ->with('user_third_register',$data);
                }else{
                    $data = UserThird::where('app_id',$uniq)->first();
                    if(empty($data['user_id'])){
                        $data = json_encode($data);
                        $is_mobile = $this->is_mobile();
                        if($is_mobile){
                            return view('frontend.guests.mobile.login_third')
                                ->with('type','third')
                                ->with('user_third_register',$data);
                        }
                        return view('frontend.guests.login.register')
                            ->with('type','third')
                            ->with('user_third_register',$data);
                    }else{
                        $user = User::where('id',$data['user_id'])->first();
                        setcookie('user_id',$user->id,(time()+3600));
                        setcookie('login_type',$user->type, (time()+3600));
                        setcookie('user_name',$user->name,(time()+3600));
                        setcookie('user_img',$data['img'],(time()+3600));
                        if(isset($_COOKIE['identification'])&&!empty($_COOKIE['identification']))
                        {
                            if(Redis::exists('prepare_order'.$_COOKIE['identification'])){
                                return redirect('/ins/insure_post');
                            }else{
                                return redirect('/ins/insure/'.$_COOKIE['identification']);
                            }
                        }else{
                            return redirect('/information/');
                        }
                    }
                }
            }
    }
    //解析三方登录
    private function http( $postfields='', $method='POST', $headers=array()){
        $url = 'http://open.51094.com/user/auth.html';
        $ci=curl_init();
        curl_setopt($ci, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ci, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ci, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ci, CURLOPT_TIMEOUT, 30);
        if($method=='POST'){
            curl_setopt($ci, CURLOPT_POST, TRUE);
            if($postfields!='')curl_setopt($ci, CURLOPT_POSTFIELDS, $postfields);
        }
        $headers[]="User-Agent: 51094PHP(open.51094.com)";
        curl_setopt($ci, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ci, CURLOPT_URL, $url);
        $response=curl_exec($ci);
        curl_close($ci);
        $json_r=array();
        if(!empty( $response ))$json_r=json_decode($response, true);
        return $json_r;
    }
    //注册用户须知
    public function registerNotice(){
        return view('frontend.guests.login.register_notice');
    }
    //微信第三方登录
    public function weChat(){
            if(isset($_GET['code']) && $_GET['state'] == '46F94C8DE14FB36680850768FF1B7F2A'){
                $code = $_GET['code'];
                $message = $this->message_request($code); //获取用户的基本信息
                $openid = $message['openid'];
                $res  = UserThird::where('app_id',$openid)->first();
                if(is_null($res)) {
                    $data = [
                        'user_id' => '',
                        'api_type' =>"weixin" ,//4微信
                        'app_id' => $openid,
                        'name' => $message['nickname'],
                        'img' => $message['headimgurl'],
                        'sex' =>  $message['sex'], //1男、2女
                        'created_at' => date('Y-m-d H:i:s', time()),
                        'updated_at' => date('Y-m-d H:i:s', time()),
                    ];
                    UserThird::insert($data);
                    $data = json_encode($data);
                    $is_mobile = $this->is_mobile();
                    if($is_mobile){
                        return view('frontend.guests.mobile.login_third')
                            ->with('type','third')
                            ->with('user_third_register',$data);
                    }
                    return view('frontend.guests.login.register')
                        ->with('type','third')
                        ->with('user_third_register',$data);
                 }else{
                    $data = UserThird::where('app_id',$openid)->first();
                    if(empty($data['user_id'])){
                        $data = json_encode($data);
                        $is_mobile = $this->is_mobile();
                        if($is_mobile){
                            return view('frontend.guests.mobile.login_third')
                                ->with('type','third')
                                ->with('user_third_register',$data);
                        }
                        return view('frontend.guests.login.register')
                            ->with('type','third')
                            ->with('user_third_register',$data);
                    }else{
                        $user = User::where('id',$data['user_id'])->first();
//                        Auth::user();
                        setcookie('user_id',$user->id,(time()+3600));
                        setcookie('login_type',$user->type, (time()+3600));
                        setcookie('user_name',$user->name,(time()+3600));
                        setcookie('user_img',$data['img'],(time()+3600));
                        if(isset($_COOKIE['identification'])&&!empty($_COOKIE['identification']))
                        {
                            return redirect('/product/insure/'.$_COOKIE['identification']);
                        }else{
                            return redirect('/information/');
                        }
                    }
                }
            }else{
                return redirect('/login')->withErrors("数据可疑，请联系管理员");
            }
        }
    //微信测试
    public function message_request($code){
            $appid = "wxe1d4164a739689d2";
            $appsecret ="0008d068a98ac6ad08952f7e459785db";
            $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=$appid&secret=$appsecret&code=$code&grant_type=authorization_code";
            $output = $this->httpsRequest($url);
            $jsoninfo = json_decode($output,true);
            $openid = $jsoninfo['openid'];
            $access_token = $jsoninfo['access_token'];

            //授权后接口调用
            $url2 = "https://api.weixin.qq.com/sns/userinfo?access_token=$access_token&openid=$openid";
            $out = $this->httpsRequest($url2);
            $message = json_decode($out,true);
            return $message;

        }
    //微信测试
    public function httpsRequest($url,$data = null){
            $curl = curl_init();
            curl_setopt($curl,CURLOPT_URL,$url);
            curl_setopt($curl,CURLOPT_SSL_VERIFYHOST,FALSE);
            curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,FALSE);
            if(!empty($data)){
                curl_setopt($curl,CURLOPT_POST,1);
                curl_setopt($curl,CURLOPT_POSTFIELDS_,$data);
            }
            curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
            $output = curl_exec($curl);
            curl_close($curl);
            return $output;
        }










}










