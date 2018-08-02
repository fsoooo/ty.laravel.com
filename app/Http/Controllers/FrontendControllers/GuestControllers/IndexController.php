<?php
namespace App\Http\Controllers\FrontendControllers\GuestControllers;

use App\Http\Controllers\FrontendControllers\AgentControllers\AgentLoginController;
use App\Http\Controllers\FrontendControllers\BaseController;
use App\Models\Agent;
use App\Models\Authentication;
use App\Models\AuthenticationPerson;
use App\Models\Label;
use App\Models\Product;
use App\Models\LabelRelevance;
use Excel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use App\Models\Setting;
use App\Models\User;
use App\Models\UserThird;

class IndexController extends BaseController
{
    public function index()
    {
        if(isset($_GET['code']) && $_GET['state'] == 'STATE') {
            $appid = "wxe68cee4744c211e7";
            $secret = "7542a37c4d82dc6c772b683815603a19";
            $code = $_GET["code"];

            //第二步：通过code换取网页授权access_token
            $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=$appid&secret=$secret&code=$code&grant_type=authorization_code";
            $token = $this->getJson($url);

            //第三步:取得openid
            $a = $token['refresh_token'];
            $oauth2Url = "https://api.weixin.qq.com/sns/oauth2/refresh_token?appid=$appid&grant_type=refresh_token&refresh_token=$a";
            $oauth2 = $this->getJson($oauth2Url);

            //第三步:根据全局access_token和openid查询用户信息
            $access_token = $token["access_token"];
            $openid = $oauth2['openid'];
            $get_user_info_url = "https://api.weixin.qq.com/sns/userinfo?access_token=$access_token&openid=$openid&lang=zh_CN";
            $userinfo = $this->getJson($get_user_info_url);

            //公众号登录
            $res  = UserThird::where('app_id',$userinfo['openid'])->first();
            if(is_null($res)) {
                $data = [
                    'user_id' => '',
                    'api_type' =>"Public number" ,//5微信公众号
                    'app_id' => $userinfo['openid'],
                    'name' => $userinfo['nickname'],
                    'img' => $userinfo['headimgurl'],
                    'sex' =>  $userinfo['sex'], //1男、2女
                    'created_at' => date('Y-m-d H:i:s', time()),
                    'updated_at' => date('Y-m-d H:i:s', time()),
                ];
                UserThird::insert($data);

                //存到cookie
                $userinfoarray = serialize($userinfo);
                setcookie('userinfo',$userinfoarray);
                setcookie('code',$_GET['code']);
                setcookie('state',$_GET['state']);

                //跳转到登陆，绑定页面
                 return view('frontend.agents.agent_login.mobile.index');

            }else{
                $data = UserThird::where('app_id',$openid)->first();
                if(empty($data['user_id'])){
                      return view('frontend.agents.agent_login.mobile.index');

                }else{
                    $user = User::where('id',$data['user_id'])->first();
                    setcookie('user_id',$user->id,(time()+3600));
                    setcookie('login_type',$user->type, (time()+3600));
                    setcookie('user_name',$user->name,(time()+3600));
                    setcookie('user_img',$data['img'],(time()+3600));
//                    if(isset($_COOKIE['identification'])&&!empty($_COOKIE['identification']))
//                    {
//                        return redirect('/product/insure/'.$_COOKIE['identification']);
//                    }else{
                        return redirect('/agent/');
//                    }
                }
            }

        }

        $is_mobile = $this->is_mobile();
        $is_person = $this->is_person($this->getId());
        //标签及产品
        $product = Product::where('status','1')
            ->where('ty_product_id','>=',0)
            ->with('label')
            ->get();
//        //查询缓存
//        if (\Cache::has('ty_product_categorys')) {
//            $categorys = \Cache::get('ty_product_categorys');
//        }else{
            $categorys = $this->productGetCategory($product);
//        }
        //todo  没有产品，还没处理

        if(empty($categorys)){
            return back()->withErrors('获取产品分类失败！');
        }
        $product_id = [];
        $product_categorys = [];
        $product_res = [];
        foreach ($product as $value) {
            foreach ($categorys['insurance'] as $key=>$v) {
                $product_id[] = $value['ty_product_id'];
                if(in_array(json_decode($value['json'], true)['category']['name'],explode('-',$v))){
                    $product_categorys['product']=$value;
                    $product_categorys['id']=json_decode($value['json'], true)['category']['id'];
                    $product_categorys['name']=json_decode($value['json'], true)['category']['name'];
                }
            }
            $product_res[] = $product_categorys;
        }
        $insure_categorys = [];
        foreach($product_res as $value){
            $insure_categorys[$value['name']][] = $value['product'];
        }
        //个人认证
        $status = AuthenticationPerson::where('user_id',$this->getId())->first();
        if($status){
            $status = $status['status'];
        }else{
            $status = false;
        }
        //代理人
        $agent_res = Agent::with('user')->get();
        $agent_count = count($agent_res);
        //查询是否存在缓存

        if($is_mobile){
            //个人移动首页
            return view('frontend.guests.mobile.index')
                ->with('agent_count',$agent_count)
                ->with('is_person',$is_person)
                ->with('agent_res',$agent_res)
                ->with('status',$status)
                ->with('product',$product)
                ->with('product_categorys',$product_categorys)
                ->with('labels',$product_res)
                ->with('product_res',$insure_categorys);
        }else{

            return view('frontend.guests.index.index')
                ->with('agent_count',$agent_count)
                ->with('agent_res',$agent_res)
                ->with('product',$product)
                ->with('product_categorys',$product_categorys)
                ->with('labels',$product_res)
                ->with('product_res',$insure_categorys);
        }

    }

    function getJson($url){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);
        return json_decode($output, true);
    }

    //关于我们
    public function about(){
        return view('frontend.guests.index.about');
    }
    //引导流程
    public function guide(){
        return view('frontend.guests.index.guide');
    }
    //获取分类
    public function productGetCategory($res){
        //直到五级分类
        $categorys = isset($res[0]) ? json_decode($res[0]['json'], true)['categorys'] : $res;
        $one  = [];
        $two  = [];
        $three  = [];
        $four  = [];
        $five  = [];
        foreach($categorys as $v){
            $name = str_repeat('-' , $v['sort']) . $v['name'];
            if(preg_match('/-/', $name)){
                if(preg_match('/--/', $name)){
                    if(preg_match('/---/', $name)){
                        if(preg_match('/----/', $name)){
                            $five[$v['path'].'-'.$v['id']] = $name;
                        }else{
                            $four[$v['path'].'-'.$v['id']] = $name;
                        }
                    }else{
                        $three[$v['path'].'-'.$v['id']] = $name;
                    }
                }else{
                    $two[$v['path'].'-'.$v['id']] = $name;
                }
            }else{
                $one[$v['path'].'-'.$v['id']] = $name;
            }
        }
        foreach ($one as $key=>$value){
            foreach ($two as $key_two=>$value_two){
                if(explode("-", $key)[0].explode("-", $key)[1].','==explode("-", $key_two)[0]){
                    if(explode("-", $key)[1]=='1'){
                        $company_category[explode("-", $key_two)[1]] = $value_two;
                    }
                    if(explode("-", $key)[1]=='2'){
                        $insurance_category[explode("-", $key_two)[1]] = $value_two;
                    }
                    if(explode("-", $key)[1]=='3'){
                        $clause_category[explode("-", $key_two)[1]] = $value_two;
                    }
                    if(explode("-", $key)[1]=='4'){
                        $duty_category[explode("-", $key_two)[1]] = $value_two;
                    }
                }
            }
        }
        foreach ($three as $key_three=>$value_three){
            foreach ($company_category as $k_c=>$v_c){
                if(explode(',',explode("-", $key_three)[0])[3]==$k_c){
                    $company_category[$k_c.'-'.explode("-", $key_three)[1]]=$value_three;
                }
            }
        }
        foreach ($three as $key_three=>$value_three){
            foreach ($insurance_category as $k_c=>$v_c){
                if(explode(',',explode("-", $key_three)[0])[3]==$k_c){
                    $insurance_category[$k_c.'-'.explode("-", $key_three)[1]]=$value_three;
                }
            }
        }
        foreach ($four as $k=>$v){
            foreach ($company_category as $k_c=>$v_c){

                if(count(explode('-',$k_c))=='2'){
                    if(explode(',',explode('-',$k)[0])[4]==explode('-',$k_c)[1]){
                        $company_category[$k_c.'-'.explode("-", $k)[1]]=$v;
                    }
                }
            }
        }
        foreach ($four as $k=>$v){
            foreach ($insurance_category as $k_c=>$v_c){
                if(count(explode('-',$k_c))=='2'){
                    if(explode(',',explode('-',$k)[0])[4]==explode('-',$k_c)[1]){
                        $insurance_category[$k_c.'-'.explode("-", $k)[1]]=$v;
                    }
                }
            }
        }
        $return_data = array(
            'company' => isset($company_category)? $company_category : [],
            'insurance' => isset($insurance_category)? $insurance_category:[],
            'clause' => isset($clause_category)? $clause_category:[],
            'duty' => isset($duty_category)? $duty_category:[],
        );
//        //存缓存（有效期为12小时）
//        $expiresAt = \Carbon\Carbon::now()->addMinutes(24*60);
//        \Cache::forever('ty_product_categorys', $return_data,$expiresAt);
        return $return_data;
    }
    //产品列表
    public function productList(Request $request)
    {
        $input = $request->all();
        $order_by = isset($input['order_by']) ? explode('-', $input['order_by']) : ['id', 'desc'];
        $res = DB::select("SELECT p.*,if(o.order_num is null,0, o.order_num) order_num FROM com_product p
        LEFT JOIN (SELECT ty_product_id,count(*) as order_num from com_order where status='1'  group by ty_product_id) as o
        ON p.ty_product_id=o.ty_product_id where status=1");
        //分页处理
        $count = count($res);
        $page_num = isset($input['page_num']) ? $input['page_num'] : 1;
        $limit = config('list_num.frontend.product_list');
        $without_num = ($page_num-1) * $limit;
        $sum_page = ceil($count / $limit);
        $data = DB::select("SELECT p.*,if(o.order_num is null,0, o.order_num) order_num FROM com_product p
        LEFT JOIN (SELECT ty_product_id,count(*) as order_num from com_order where status='1' group by ty_product_id ) as o
        ON p.ty_product_id=o.ty_product_id where status=1 and p.ty_product_id >= 0 order by $order_by[0] $order_by[1] LIMIT $without_num,$limit");
        return view('frontend.guests.product.product_lists', compact('count', 'page_num','sum_page', 'data', 'input'));
    }

    /**
     * 获取个性化设置信息
     *
     * @param Request $request
     * @return array
     */
    public function getSetting(Request $request)
    {
        $name = $request->get('name');
        $content = [];
        $setting_list = Setting::where('name', 'like', '%' . $name . '%')->get()->toArray();
        $is_mobile = $this->is_mobile();
        if ($name === 'insurance_banner') {//保险超市banner
            //默认图片
            if($is_mobile){
                $content[0] = $content[1] = $content[2] = config('view_url.view_url').'mobile/image/banner.png';
            }else{
                $content[0] = $content[1] = $content[2] = config('view_url.view_url') . 'image/index-banner1.png';
            }
            if (!empty($setting_list)) {
                foreach ($setting_list as $setting) {
                    $index = substr($setting['name'], strlen($setting['name']) - 1, strlen($setting['name']));
                    $content[$index] = 'upload/' . $setting['content'];
                }
            }
        } elseif ($name === 'agency_banner0') {//代理人的banner
            //默认图片
            if($is_mobile){
                $content[0] = config('view_url.agent_mob').'img/banner.png';
            }else{
                $content[0] = config('view_url.agent_url').'img/banner.png';
            }
            if (!empty($setting_list)) {
                $content[] = 'upload/' . $setting_list[0]['content'];
            }
        } else {
            if (!empty($setting_list)) {
                $content = $setting_list[0]['content'];
            }
        }
        return $content;
    }
}
