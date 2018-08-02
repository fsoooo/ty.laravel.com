<?php

namespace App\Http\Controllers\FrontendControllers\GuestControllers;
use App\Helper\Uploader;
use App\Helper\UploadFileHelper;
use App\Http\Controllers\FrontendControllers\BaseController;
use App\Models\Authentication;
use App\Models\AuthenticationPerson;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\TrueFirmInfo;
use App\Models\User;
use App\Models\WarrantyRecognizee;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\Exception;
use Request,DB;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use App\Models\TrueUserInfo;
use App\Models\Channel;
use App\Models\UserChannel;
use Illuminate\Http\Request as Requests;
use App\Models\Product;
use Validator, Cache;

class InformationController extends BaseController
{
    //主页
    public function indexinfo(Requests $requests){

        $is_mobile = $this->is_mobile();
        if($is_mobile){
            return redirect('/');
        }
        //认证处理
        $auth = Authentication::where('user_id',$this->getId())->first();//企业
        $auth_person = AuthenticationPerson::where('user_id',$this->getId())->first();//个人
        //判断企业或个人用户
        $user_type = User::where('id',$_COOKIE['user_id'])
            ->with('UserThird')
            ->first();
        $option_type = 'index';
        if(isset($_GET['account'])&&isset($_GET['insure'])) {
            if($_GET['insure']=='0'){
                return redirect('/productlists/'.$_GET['insure']);
            }else{
                $product_code = Product::where('product_number',$_GET['insure'])->where('ty_product_id','>=',0)->first()->id;
                return redirect('/productinfo/'.$product_code);
            }
        }elseif(isset($_GET['account'])){
            return view('frontend.guests.user.information.index',compact('option_type','user_type','auth_person'));
        }elseif($user_type['type'] == 'company'){
            return view('frontend.guests.company.information.index',compact('option_type','user_type','auth'));
        }else{
            return view('frontend.guests.user.information.index',compact('option_type','user_type','auth_person'));
        }

    }
    public function channelsIndex(){
        $user_id = $_COOKIE['user_id'];
        $channel_user_res = UserChannel::with('channel')->where('user_id',$user_id)->get();
        $count = count($channel_user_res);
        return view('frontend.guests.user.information.channels_info')
            ->with('count',$count)
            ->with('res',$channel_user_res);
    }
    //查找客户的信息
    public function guestInfo()
    {
        $information = $this->getSelfInformation();
        $trueInfo = TrueFirmInfo::where('user_id',$_COOKIE['user_id'])
            ->first();
//        dd($trueInfo);
        $data = Authentication::where('user_id',$this->getId())->first();
//        dd($information);
        $addressData = explode('_',$information['address']);
        $information['inAddress'] = $addressData[0];
        $information['address'] = $addressData[0];
        $type = $information->type;
        $option_type = 'information';
        $authentication = $this->isAuthenticationPerson($_COOKIE['user_id']);
//        dd($information);
        if($type == 'user'){
            return view('frontend.guests.user.information.user_index',compact('information','option_type','authentication'));
        }else if($type == 'company'){
            return view('frontend.guests.company.information.info',compact('information','trueInfo','option_type','data','authentication'));
        }else{
            return view('frontend.guests.group.index',compact('information','type','option_type','authentication'));
        }
    }

//    用户修改
    public function modification(){
        $id = $this->getId();
        $email = $_POST['email'];
        $address = $_POST['address'];

        $res = user::where('id', $id)
            ->update(['address' => $address,'email'=>$email]);
        if($res){
            return '<script>alert("修改成功");location.href="/information/guest_info";</script>';
//            return redirect('/information/guest_info')->with('status','修改成功');
        }else{
            return redirect('/information/guest_info')->with('status','修改失败');
//            return back()->withErrors('修改失败');

        }
    }

    public function home_page(){
        $option_type = 'safety';
        if($this->is_person($this->getId()) == 1){
            return view('frontend.guests.user.information.modify_password',compact('option_type'));
        }else{
            return view('frontend.guests.company.information.modify_password',compact('option_type'));
        }

    }

    //公司修改密码
    public function changePass(\Illuminate\Http\Request $request)
    {
        $input = $request->all();
        if($input['newPass'] != $input['sureNewPass']){
            return '<script>alert("两次新密码不相同");location.href="/information/home_page";</script>';
        }
        $id=$this->getId();
        $selfInformation = $this->getSelfInformation();
        $email = $selfInformation['email'];
        if(Auth::attempt([ 'email'=>$email,'password' => $input['oldPass']])){
            $User = User::where('id',$id)->first();
            $change_array = array('password'=>bcrypt($input['newPass']));
            $result = $this->edit($User,$change_array);
            if($result){
                return '<script>alert("修改成功，请重新登录");location.href="/logout";</script>';
            }else{
                return back()->withErrors('修改失败');
            }
        }else{
            return '<script>alert("当前密码输入错误");location.href="/logout";</script>';
        }
    }

    //跳转到修改密码界面
    public function changePassword()
    {
        $option_type = 'safety';
        $information = $this->getSelfInformation();
        $type = $information->type;
        if($type == 'user'){
            $id = $this->getId();
            $phone = DB::table('users')->where('id',$id)->select('phone')->first();
            $mobile = substr_replace($phone->phone, '****', 3, 4);
            return view('frontend.guests.user.information.change_pwd',['phone'=>$phone,'mobile'=>$mobile,'option_type'=>$option_type]);
        }else if($type == 'company'){
            $id = $this->getId();
            $phone = DB::table('users')->where('id',$id)->select('phone')->first();
            return view('frontend.guests.company.information.change_pwd',['phone'=>$phone,'option_type'=>$option_type]);
        }
    }
//    发送验证码
    public function proving_code(){
        return response()->json(array('status'=> 0,'message'=>'可以发送验证码'), 200);
    }


    //修改密码表单提交
    public function changePasswordSubmit()
    {
        $id = $this->getId();
        $input = Request::all();
        $code = $_POST['code'];
        $phone = DB::table('users')->where('id',$id)->select('phone')->first();
        $code  = Cache::get("reg_code_".$phone->phone);
        if($_POST['code'] != $code){
            return back()->withErrors('验证码不正确');
        }
        $information = $this->getSelfInformation();
        //进行原密码判断
        $password = $input['old_password'];
        $phone = $information->phone;

        if(Auth::attempt(['phone' => $phone, 'password' => $password])){
            $new_password = $input['new_password'];
            $check_new_password = $input['check_new_password'];
            if($new_password == $check_new_password){
                $User = User::where('id',$id)->first();
                $change_array = array('password'=>bcrypt($new_password));
                $result = $this->edit($User,$change_array);
                if($result){
                    return '<script>alert("修改成功，请重新登录");location.href="/logout";</script>';
                }else{
                    return '<script>alert("修改失败");location.href="/information/change_password";</script>';
//                    return back()->withErrors('修改失败');
                }
            }else{
                return '<script>alert("两次密码不同");location.href="/information/change_password";</script>';
//                return back()->withErrors('两次密码不同');
            }
        }else{
            return '<script>alert("原密码错误");location.href="/information/change_password";</script>';
//            return back()->withErrors('原密码错误');
        }
    }

    //修改个人信息//跳转
    public function changeInformation()
    {
        $information = $this->getSelfInformation();
        $id = $this->getId();
        $cardData=TrueUserInfo::where('user_id',$id)
            ->first();
//        dd($cardData);
        $type = $information->type;
        if($type == 'user'){
            $data = TrueUserInfo::where('user_id',$id)
                ->first();
            if($data){
                $finalData = $data;
            }else{
                $finalData = '';
            }
            return view('frontend.guests.user.information.change_info',compact('information','type','cardData','finalData'));
        }else if($type == 'company'){

            $data = DB::table('true_firm_info')
                ->where('user_id','=',$id)
                ->first();
            if($data){
                $finalData = $data;
            }else{
                $finalData = "";
            }
            return view('frontend.guests.company.information.changeInformation',compact('information','finalData','type','cardData'));
        }else{
            $data = DB::table('true_firm_info')
                ->where('user_id','=',$id)
                ->first();
            if($data){
                $finalData = $data;
            }else{
                $finalData = "";
            }
            return view('frontend.guests.group.changeInformation',compact('information','finalData','cardData','type'));
        }
    }

    //    手机号修改
    public function phoneCheck(){
        $phone = $_GET['phone'];
        $code = $_GET['code'];
        $id = $this->getId();

        //判断验证码是否正确
        $User = User::where('id',$id)->first();
        $code  = Cache::get("reg_code_".$phone);
        if($_GET['code'] != $code){
            return back()->withErrors('验证码不正确');
        }else{
            $res = user::where('id', $id)->update(['phone' => $phone]);
            if($res){
                return 1;
            }else{
                return 2;
            }
        }
    }


    //修改企业信息提交
    public function company_submit(Requests $request)
    {
        $input = $request->all();
//        dd($input);
        $oldData = Authentication::where('user_id',$this->getId())->first();
//        dd($oldData);
        if(isset($oldData) && $oldData['status'] == 0){
            return "<script>alert('您已经申请过认证了，请耐心等候审核');history.back();</script>";
        }elseif(isset($oldData) && $oldData['status'] == 2){
            return "<script>alert('您已经认证成功，不需要再次认证');history.back();</script>";
        }elseif(isset($oldData) && $oldData['status'] == 1){
            if(!isset($input['id_type']) || $input['id_type'] == 0){
                //三证合一
                $file_path = UploadFileHelper::uploadImage($input['upFile'],'upload/frontend/company_file/');
                DB::beginTransaction();
                try{
                    //添加认证表
                    $authentication = Authentication::where('user_id',$_COOKIE['user_id'])
                        ->update([
                            'name'=>$input['name'],
                            'credit_code'=>$input['credit_code'],
                            'status'=>0,
                        ]);
                    //添加到true_firm_info
                    $true_firm_info = TrueFirmInfo::where('user_id',$_COOKIE['user_id'])
                        ->update([
                            'license_group_id'=>$input['credit_code'],
                            'license_img'=>$file_path,
                        ]);
                    //添加到user表
                    $user_info = User::where('id',$_COOKIE['user_id'])
                        ->update([
                            'name'=>$input['real_name'],
                            'real_name'=>$input['real_name'],
                            'code'=>$input['credit_code']
                        ]);
                    DB::commit();
                    return "<script>alert('更新成功，请耐心等候审核');location.href = '/information/guest_info';</script>";
                }catch (Exception $e){
                    DB::rollBack();
                    return "<script>alert('数据录入失败，请稍后重试');location.href = '/information/guest_info';</script>";
                }
            }else{
                //非三证合一
                $file_path = UploadFileHelper::uploadImage($input['upFile'],'upload/frontend/company_file/');
                DB::beginTransaction();
                try{
                    //添加认证表
                    $authentication = Authentication::where('user_id',$_COOKIE['user_id'])
                        ->update([
                            'name'=>$input['name'],
                            'code'=>$input['code'],
                            'license_code'=>$input['license_code'],
                            'tax_code'=>$input['tax_code'],
                            'status'=>0,
                        ]);
                    //添加到true_firm_info
                    $true_firm_info = TrueFirmInfo::where('user_id',$_COOKIE['user_id'])
                        ->update([
                            'license_group_id'=>$input['license_code'],
                            'license_img'=>$file_path,
                        ]);
                    //添加到user表
                    $user_info = User::where('id',$_COOKIE['user_id'])
                        ->update([
                            'name'=>$input['real_name'],
                            'real_name'=>$input['real_name'],
                            'code'=>$input['license_code']
                        ]);
                    DB::commit();
                    return "<script>alert('更新成功，请耐心等候审核');location.href = '/information/guest_info';</script>";
                }catch (Exception $e){
                    DB::rollBack();
                    return "<script>alert('数据录入失败，请稍后重试');location.href = '/information/guest_info';</script>";
                }
            }
        }
        if(!isset($input['id_type']) || $input['id_type'] == 0){
            //三证合一
            $file_path = UploadFileHelper::uploadImage($input['upFile'],'upload/frontend/company_file/');
            DB::beginTransaction();
            try{
                //添加认证表
                $authentication = new Authentication();
                $authentication->user_id = $this->getId();
                $authentication->name = $input['name'];
                $authentication->credit_code = $input['credit_code'];
                $authentication->status = 0;
                $authenticationRes = $authentication->save();
                //添加到true_firm_info
                $true_firm_info = new TrueFirmInfo();
                $true_firm_info->user_id = $this->getId();
                $true_firm_info->license_group_id = $input['credit_code'];
                $true_firm_info->license_img = $file_path;
                $true_firm_infoRes = $true_firm_info->save();
                //添加到user表
                $user_info = User::where('id',$_COOKIE['user_id'])
                    ->update([
                        'name'=>$input['name'],
                        'real_name'=>$input['name'],
                        'code'=>$input['credit_code']
                    ]);
                DB::commit();
                return "<script>alert('信息录入成功，请耐心等候审核');location.href = '/information/guest_info';</script>";
            }catch (Exception $e){
                DB::rollBack();
                return "<script>alert('数据录入失败，请稍后重试');location.href = '/information/guest_info';</script>";
            }
        }else{
            //非三证合一
            $file_path = UploadFileHelper::uploadImage($input['upFile'],'upload/frontend/company_file/');
            DB::beginTransaction();
            try{
                //添加认证表
                $authentication = new Authentication();
                $authentication->user_id = $this->getId();
                $authentication->name = $input['name'];
                $authentication->code = $input['code'];
                $authentication->license_code = $input['license_code'];
                $authentication->tax_code = $input['tax_code'];
//                $authentication->credit_code = $input['credit_code'];
                $authentication->status = 0;
                $authenticationRes = $authentication->save();
                //添加到true_firm_info
                $true_firm_info = new TrueFirmInfo();
                $true_firm_info->user_id = $this->getId();
                $true_firm_info->license_group_id = $input['license_code'];
                $true_firm_info->license_img = $file_path;
                $true_firm_infoRes = $true_firm_info->save();
                //添加到user表
                $user_info = User::where('id',$_COOKIE['user_id'])
                    ->update([
                        'name'=>$input['real_name'],
                        'real_name'=>$input['real_name'],
                        'code'=>$input['license_code']
                    ]);
                DB::commit();
                return "<script>alert('信息录入成功，请耐心等候审核');location.href = '/information/guest_info';</script>";
            }catch (Exception $e){
                DB::rollBack();
                return "<script>alert('数据录入失败，请稍后重试');location.href = '/information/guest_info';</script>";
            }
        }




//        $input = Request::all();
//
//            $id = $this->getId();
//            $User = User::find($id);
//            $change_array = array(
//                'name'=>$input['name'],
//                'code'=>$input['code'],
//                'address'=>$input['province'].','.$input['city'].','.'_'.$input['inAddress']
//            );
//            $result = $this->edit($User,$change_array);
//            $path = UploadFileHelper::uploadImage($input['companyFile'],'upload/frontend/company_file/');
//        DB::beginTransaction();
//        try{
//            //添加信息到认证表
//            $user = new Authentication();
//            $user->user_id = Auth::user()->id;
//            $user->name = $input['name'];
//            $user->code = $input['code'];
//            $user->status = 1;
//            $userRes = $user->save();
//            //添加到证件信息表
//            $trueUser = new TrueFirmInfo();
//            $trueUser->user_id = Auth::user()->id;
//            $trueUser->license_group_id = $input['code'];
//            $trueUser->license_img = $path;
//            $trueRes = $trueUser->save();
//            if($userRes && $trueRes &&$result){
//                DB::commit();
//                return  "<script language=javascript>alert('提交成功');history.back();</script>";
//            }
//        }catch (Exception $e){
//            DB::rollBack();
//            return "<script language=javascript>alert('提交成功');history.back();</script>";
//        }
    }

    //修改组织信息提交
    public function groupChangeSubmit(Requests $request)
    {
        $input = $request->all();
//        dd($input);
        $id = $this->getId();
        if(!isset($input['license']))
        {
            return back()->withErrors('请上传公司营业执照的照片')->withInput();
        }
        $file = $request->file('license');//获取上传的文件
        $up = new UploadFileHelper();
        $real_path = 'upload/frontend/license/';
        $path = $up->uploadImage($file,$real_path);
        $user = User::where('id',$id)->first();
        if(!$user['code']){
            //第一次登陆
            DB::beginTransaction();
            try{
                //上传到企业信息表（true_firm_info）
                $array2 = array(
                    'user_id'=>$id,
                    'person_name'=>$input['boss'],
                    'license_img'=>$path,
                    'ins_principal'=>$input['ins_principal'],
                    'ins_phone'=>$input['ins_phone'],
                    'ins_principal_code'=>$input['ins_principal_code'],
                    'license_group_id'=>$input['code']
                );
                DB::table('true_firm_info')
                    ->insert($array2);
                //上传到企业信息验证表
                $array3 = array(
                    'name'=>$input['name'],
                    'code'=>$input['code'],
                    'boss'=>$input['boss'],
                    'status'=>1
                );
                DB::table('authentication')
                    ->insert($array3);

                $array = array(
                    'name'=>$input['boss'],
                    'real_name'=>$input['name'],
                    'email'=>$input['email'],
                    'address' => $input['address'],
                    'phone'=>$input['phone'],
                    'code'=>$input['code'],
                );
                $result = $this->edit($user,$array);
                $is_info = TrueUserInfo::where('user_id',$id);
                if(!$is_info){
                    $TrueUserInfo = new TrueUserInfo();
                    $true_user_info_array = array(
                        'user_id'=>$id,
                    );
                    $info = $this->add($TrueUserInfo,$true_user_info_array);
                }else{
                    $info = true;
                }
                if($result&&$info){
                    DB::commit();
                    return redirect('/information/index')->with('status','修改成功');
                }else{
                    DB::rollBack();
                    return back()->withErrors('修改失败')->withInput();
                }
            }catch (Exception $e){
                DB::rollBack();
                return back()->withErrors('修改失败')->withInput($input);
            }
        }else{
            DB::beginTransaction();
            try{
                //上传到企业信息表（true_firm_info）
                $array2 = array(
                    'user_id'=>$id,
                    'person_name'=>$input['boss'],
                    'license_img'=>$path,
                    'ins_principal'=>$input['ins_principal'],
                    'ins_phone'=>$input['ins_phone'],
                    'ins_principal_code'=>$input['ins_principal_code'],
                );
                $data1 = TrueFirmInfo::where('user_id',$id)->first();
                $res1 = $this->edit($data1,$array2);
                $array = array(
                    'name'=>$input['boss'],
                    'real_name'=>$input['name'],
                    'email'=>$input['email'],
                    'address' => $input['address'],
                    'phone'=>$input['phone'],
                );
                $result = $this->edit($user,$array);
                $is_info = TrueUserInfo::where('user_id',$id);
                if(!$is_info){
                    $TrueUserInfo = new TrueUserInfo();
                    $true_user_info_array = array(
                        'user_id'=>$id,
                    );
                    $info = $this->add($TrueUserInfo,$true_user_info_array);
                }else{
                    $info = true;
                }
                if($result&&$info && $res1){
                    DB::commit();
                    return redirect('/information/index')->with('status','修改成功');
                }else{
                    DB::rollBack();
                    return back()->withErrors('修改失败')->withInput();
                }
            }catch (Exception $e){
                DB::rollBack();
                return back()->withErrors('修改失败')->withInput($input);
            }
        }
    }
    //    个人信息
    public function personal(){
        $id = $this->getId();
        $phone = $_POST['phone'];
        $email = $_POST['email'];
        $result = DB::table('users')
            ->where('id', $id)
            ->update(['phone' =>$phone,'email'=>$email]);
        if($result){
            return redirect('/information/index')->with('status','修改成功');
        }else{
            return back()->withErrors('修改失败');
        }
    }

    public function real_name(Requests $request){
        $input = $request->all();
        $data = AuthenticationPerson::where('user_id',$_COOKIE['user_id'])
            ->first();
        if(isset($data) && $data['status'] == 0){
            return "<script>alert('您已经申请过认证了，请耐心等候审核');history.back();</script>";
        }elseif(isset($data) && $data['status'] == 2){
            return "<script>alert('您已经认证成功，不需要再次认证');history.back();</script>";
        }elseif(isset($data) && $data['status'] == 1){
            if(!isset($input['real_name']) || !isset($input['id_code']) ||!isset($input['front']) || !isset($input['back']) || !isset($input['body'])){
                return "<script>alert('请按要求填写认证信息！否则认证可能再次不能通过');history.back();</script>";
            }
            $upPath = UploadFileHelper::uploadImage($input['front'],'upload/frontend/personal_id/');
            $downPath = UploadFileHelper::uploadImage($input['back'],'upload/frontend/personal_id/');
            $personPath = UploadFileHelper::uploadImage($input['body'],'upload/frontend/personal_id/');
            DB::beginTransaction();
            try{
                //更新信息到认证表
                $user = AuthenticationPerson::where('user_id',$_COOKIE['user_id'])
                    ->update([
                        'name'=>$input['real_name'],
                        'code'=>$input['id_code'],
                        'status'=>0,
                        'id_type'=>$input['id_type']
                    ]);
                //更新到user表
                $user_info = User::where('id',$_COOKIE['user_id'])
                    ->update([
                        'name'=>$input['real_name'],
                        'real_name'=>$input['real_name'],
                        'code'=>$input['id_code']
                    ]);
                //添加到证件信息表
                $trueUser = TrueUserInfo::where('user_id',$_COOKIE['user_id'])
                    ->update([
                        'card_id'=>$input['id_code'],
                        'card_img_front'=>$upPath,
                        'card_img_backend'=>$downPath,
                        'card_img_person'=>$personPath,
                    ]);
                DB::commit();
                return "<script>alert('更新成功！');history.back();</script>";
            }catch (Exception $e){
                DB::rollBack();
                return back()->withErrors('修改失败')->withInput($input);
            }
        }
        if(!isset($input['real_name']) || !isset($input['id_code']) ||!isset($input['front']) || !isset($input['back']) || !isset($input['body'])){
            if($this->is_mobile()){
                return "<script>alert('请重新选择上传图片！');history.back();</script>";
            }
            return "<script>alert('请按要求填写认证信息！');history.back();</script>";
        }
        $frontPath = UploadFileHelper::uploadImage($input['front'],'upload/frontend/personal_id/');
        $backPath = UploadFileHelper::uploadImage($input['back'],'upload/frontend/personal_id/');
        $bodyPath = UploadFileHelper::uploadImage($input['body'],'upload/frontend/personal_id/');

        DB::beginTransaction();
        try{
            //添加信息到认证表
            $user = new AuthenticationPerson();
            $user->user_id = Auth::user()->id;
            $user->name = $input['real_name'];
            $user->id_type = $input['id_type'];
            $user->code = $input['id_code'];
            $user->status = 0;
            $userRes = $user->save();
            //添加到user表
            $user_info = User::where('id',$_COOKIE['user_id'])
                ->update([
                    'name'=>$input['real_name'],
                    'real_name'=>$input['real_name'],
                    'code'=>$input['id_code']
                ]);
            //添加到证件信息表
            $trueUser = new TrueUserInfo();
            $trueUser->user_id = Auth::user()->id;
            $trueUser->card_id = $input['id_code'];
            $trueUser->card_img_front = $frontPath;
            $trueUser->card_img_backend = $backPath;
            $trueUser->card_img_person = $bodyPath;
            $trueRes = $trueUser->save();
            if($userRes && $trueRes){
                DB::commit();
                return  "<script language=javascript>alert('提交成功');location.href='/information/approvePerson';</script>";
            }
        }catch (Exception $e){
            DB::rollBack();
            return back()->withErrors('修改失败')->withInput($input);
        }
    }


    //
    public function changeInformationSubmit(Requests $request)
    {
        $id = $this->getId();
        $input = $request->all();
        $uType = User::where('id','=',$id)
            ->pluck('type');
        if($uType[0] == 'company'){ //公司信息更改
            if(!isset($input['license']))
            {
                return back()->withErrors('请上传公司营业执照的照片')->withInput();
            }
            $file = $request->file('license');//获取上传的文件
            $up = new UploadFileHelper();
            $real_path = 'upload/frontend/license/';
            $path = $up->uploadImage($file,$real_path);
            //公司user表的上传
            $user = User::where('id',$id)->first();
            if(!$user['code']){
                //第一次登陆修改
                DB::beginTransaction();
                try{
                    //上传到企业信息表（true_firm_info）
                    $array2 = array(
                       'user_id'=>$id,
                        'person_name'=>$input['name'],
                        'person_card_id'=>$input['id_code'],
                        'license_group_id'=>$input['code'],
                        'license_img'=>$path,
                        'ins_principal'=>$input['ins_principal'],
                        'ins_phone'=>$input['ins_phone'],
                        'ins_principal_code'=>$input['ins_principal_code']
                    );
                    DB::table('true_firm_info')
                        ->insert($array2);
                    //上传到企业信息验证表
                    $array3 = array(
                        'name'=>$input['real_name'],
                        'code'=>$input['code'],
                        'boss'=>$input['name'],
                        'status'=>1
                    );
                    DB::table('authentication')
                        ->insert($array3);

                    $array = array(
                        'name'=>$input['name'],
                        'real_name'=>$input['real_name'],
                        'email'=>$input['email'],
                        'address' => $input['address'],
                        'phone'=>$input['phone'],
                        'code'=>$input['code'],
                    );
                    $result = $this->edit($user,$array);
                    $is_info = TrueUserInfo::where('user_id',$id);
                    if(!$is_info){
                        $TrueUserInfo = new TrueUserInfo();
                        $true_user_info_array = array(
                            'user_id'=>$id,
                        );
                        $info = $this->add($TrueUserInfo,$true_user_info_array);
                    }else{
                        $info = true;
                    }
                    if($result&&$info){
                        DB::commit();
                        return redirect('/information/index')->with('status','修改成功');
                    }else{
                        DB::rollBack();
                        return back()->withErrors('修改失败')->withInput();
                    }
                }catch (Exception $e){
                    DB::rollBack();
                    return back()->withErrors('修改失败')->withInput($input);
                }
            }else{
                //非第一次登陆修改
                DB::beginTransaction();
                try{
                    $array2 = array(
                        'person_name'=>$input['name'],
                        'person_card_id'=>$input['id_code'],
                        'license_img'=>$path,
                        'ins_principal'=>$input['ins_principal'],
                        'ins_phone'=>$input['ins_phone'],
                        'ins_principal_code'=>$input['ins_principal_code']
                    );
                    DB::table('true_firm_info')
                        ->where('user_id',$id)
                        ->update($array2);
                    $array = array(
                        'name'=>$input['name'],
                        'email'=>$input['email'],
                        'address' => $input['address'],
                    );
                    $result = $this->edit($user,$array);
                    $is_info = TrueUserInfo::where('user_id',$id);
                    if(!$is_info){
                        $TrueUserInfo = new TrueUserInfo();
                        $true_user_info_array = array(
                            'user_id'=>$id,
                        );
                        $info = $this->add($TrueUserInfo,$true_user_info_array);
                    }else{
                        $info = true;
                    }
                    if($result&&$info){
                        DB::commit();
                        return redirect('/information/index')->with('status','修改成功');
                    }else{
                        DB::rollBack();
                        return back()->withErrors('修改失败')->withInput();
                    }

                }catch (Exception $e) {
                    DB::rollBack();
                    return back()->withErrors('修改失败')->withInput($input);
                }
            }
        }elseif($uType[0] == 'group'){
            if(!isset($input['license']))
            {
                return back()->withErrors('请上传组织/团体相关证件照片')->withInput();
            }
            $file = $request->file('license');//获取上传的文件
            $up = new UploadFileHelper();
            $real_path = 'upload/frontend/license/';
            $path = $up->uploadImage($file,$real_path);
            //组织/团体user表的上传
            $user = User::where('id',$id)->first();
            if(!$user['code']){
                //第一次登陆修改
                DB::beginTransaction();
                try{
                    $array2 = array(
                        'user_id'=>$id,
                        'person_name'=>$input['name'],
                        'person_card_id'=>$input['id_code'],
                        'license_group_id'=>$input['code'],
                        'license_img'=>$path,
                        'ins_principal'=>$input['ins_principal'],
                        'ins_phone'=>$input['ins_phone'],
                        'ins_principal_code'=>$input['ins_principal_code']
                    );
                    DB::table('true_firm_info')
                        ->insert($array2);
                    $array = array(
                        'name'=>$input['name'],
                        'real_name'=>$input['real_name'],
                        'email'=>$input['email'],
                        'address' => $input['address'],
                        'phone'=>$input['phone'],
                        'code'=>$input['code'],
                    );
                    $result = $this->edit($user,$array);
                    $is_info = TrueUserInfo::where('user_id',$id);
                    if(!$is_info){
                        $TrueUserInfo = new TrueUserInfo();
                        $true_user_info_array = array(
                            'user_id'=>$id,
                        );
                        $info = $this->add($TrueUserInfo,$true_user_info_array);
                    }else{
                        $info = true;
                    }
                    if($result&&$info){
                        DB::commit();
                        return redirect('/information/index')->with('status','修改成功');
                    }else{
                        DB::rollBack();
                        return back()->withErrors('修改失败')->withInput();
                    }
                }catch (Exception $e){
                    DB::rollBack();
                    return back()->withErrors('修改失败')->withInput($input);
                }
            }else{
                //非第一次登陆修改
                DB::beginTransaction();
                try{
                    $array2 = array(
                        'person_name'=>$input['name'],
                        'person_card_id'=>$input['id_code'],
                        'license_img'=>$path,
                        'ins_principal'=>$input['ins_principal'],
                        'ins_phone'=>$input['ins_phone'],
                        'ins_principal_code'=>$input['ins_principal_code']
                    );
                    DB::table('true_firm_info')
                        ->where('user_id',$id)
                        ->update($array2);
                    $array = array(
                        'name'=>$input['name'],
                        'email'=>$input['email'],
                        'address' => $input['address'],
                    );
                    $result = $this->edit($user,$array);
                    $is_info = TrueUserInfo::where('user_id',$id);
                    if(!$is_info){
                        $TrueUserInfo = new TrueUserInfo();
                        $true_user_info_array = array(
                            'user_id'=>$id,
                        );
                        $info = $this->add($TrueUserInfo,$true_user_info_array);
                    }else{
                        $info = true;
                    }
                    if($result&&$info){
                        DB::commit();
                        return redirect('/information/index')->with('status','修改成功');
                    }else{
                        DB::rollBack();
                        return back()->withErrors('修改失败')->withInput();
                    }

                }catch (Exception $e) {
                    DB::rollBack();
                    return back()->withErrors('修改失败')->withInput($input);
                }
            }
        }else{
            //个人信息更新
            $User = User::where('id',$id)->first();
            if($User){
                DB::beginTransaction();
                try{
                    if(!isset($input['card_img_front']) || !isset($input['card_img_backend']) || !isset($input['card_img_person']) ){
                        return back()->withErrors('请上传个人身份证照片')->withInput();
                    }
                    $card_img_front = $request->file('card_img_front');//获取上传的文件
                    $card_img_backend = $request->file('card_img_backend');//获取上传的文件
                    $card_img_person = $request->file('card_img_person');//获取上传的文件
                    $up = new UploadFileHelper();
                    $real_path = 'upload/frontend/license/';
                    $card_img_front_path = $up->uploadImage($card_img_front,$real_path);
                    $card_img_backend_path = $up->uploadImage($card_img_backend,$real_path);
                    $card_img_person_path = $up->uploadImage($card_img_person,$real_path);
                    if(!isset($User->code)){
                        $array = array(
                            'name'=>$input['name'],
                            'real_name'=>$input['real_name'],
                            'email'=>$input['email'],
                            'address' => $input['address'],
                            'phone'=>$input['phone'],
                            'code'=>$input['code'],
                        );
                        $arr2 = array(
                            'user_id'=>$id,
                            'card_id'=>$input['code'],
                            'card_img_front'=>$card_img_front_path,
                            'card_img_backend'=>$card_img_backend_path,
                            'card_img_person'=>$card_img_person_path
                        );
                        $res = TrueUserInfo::insert($arr2);
                    }else{
                        $array = array(
                            'name'=>$input['name'],
                            'email'=>$input['email'],
                            'address' => $input['address'],
                        );
                        $arr3 = array(
                            'card_id'=>$User['code'],
                            'card_img_front'=>$card_img_front_path,
                            'card_img_backend'=>$card_img_backend_path,
                            'card_img_person'=>$card_img_person_path
                        );
                        $res = TrueUserInfo::where('user_id',$id)->update($arr3);

                    }
                    $result = $this->edit($User,$array);

                    $person_data = DB::table('authentication_person')
                        ->where('user_id',$id)
                        ->first();
                    if(!isset($person_data))
                    {
                        $personDataArray = array(
                            'user_id'=>$id,
                            'name'=>$input['real_name'],
                            'code'=>$input['code'],
                            'status'=>1
                        );

                        $personRes = AuthenticationPerson::insert($personDataArray);
                    }

                    if($result && $res && $personRes){
                        DB::commit();
                        return redirect('/information/index')->with('status','修改成功');
                    }else{
                        DB::rollBack();
                        return back()->withErrors('修改失败')->withInput();
                    }
                }catch (Exception $e){
                    DB::rollBack();
                    return back()->withErrors('修改失败')->withInput($input);
                }
            }else{
                return back()->withErrors('非法操作');
            }
        }
    }

    //个人实名认证
    public function approvePerson()
    {
        $option_type  = 'approvePerson';
        $data = AuthenticationPerson::where('user_id',$_COOKIE['user_id'])
            ->with('true_user_info')
            ->first();
//        dd($data);
        if($this->is_mobile() && $this->is_person(Auth::user()->id) == 1){
            //移动个人
            return view('frontend.guests.mobile.personal.certification',compact('count','data','option_type'));
        }elseif($this->is_mobile() && $this->is_person(Auth::user()->id) == 2){
            //移动团险
            return view('frontend.guests.mobile.company.certification',compact('count','data','option_type'));
        }else{
            //pc
            return view('frontend.guests.user.information.authentication',compact('count','data','option_type'));
        }
    }

    //跳转到完善个人信息
    public function profile()
    {
        $self_information = $this->getSelfInformation();
        $login_type = $_COOKIE['login_type'];
        return view('frontend.guests.user.information.profile',compact('self_information','login_type'));
    }
    //完善个人信息提交
    public function profileSubmit()
    {
        $input = Request::all();
        $id = $this->getId();
        $User = User::find($id);
        $change_array = array(
            'name'=>$input['phone'],
            'real_name'=>$input['phone//'],
            'phone'=>$input['phone'],
            'email'=>$input['email'],
            'postcode'=>$input['postcode'],
            'address'=>$input['province'].','.$input['city'].','.$input['county'].'_'.$input['in_address']
        );
        $result = $this->edit($User,$change_array);
        if($result){
            return ['status'=>200,'msg'=>'编辑成功'];
        }else{
            return ['status'=>400,'msg'=>'编辑失败'];
        }
    }

    public function realNameCertification(){

        return view('frontend.guests.user.information.real_name_certification');
    }


    //封装一个方法，用来获取用户的个人信息
    public function getSelfInformation()
    {
        $id = $this->getId();
        $information = User::where('id',$id)->first();
        return $information;
    }

    //发票管理
    public function invoice()
    {
        $id = $this->getId();
        $data = DB::table('invoice')
            ->join('users','invoice.user_id','=','users.id')
            ->where([
                ['users.type','=','company'],
                ['invoice.user_id','=',$id]
            ])
            ->select('invoice.*','users.real_name')
            ->get();
        $count = count($data);
        return view('frontend.guests.company.information.invoice',compact('data','count'));
    }

    //认证管理
    public function authentication()
    {
        $information = $this->getSelfInformation();
//        dd($information);
        if(!$information['code']){
            return redirect('/information/change_information')->with('status','请填写基本信息');
        }
        $result = DB::table('authentication')
            ->where('code','=',$information->code)
            ->get();
        $math = count($result);
        if($math == 0) {
            $res['name'] = $information->real_name;
            $res['code'] = $information->code;
            $res['boss'] = $information->name;
            $res['status'] = 1;
            DB::table('authentication')
                ->insert($res);
        }
        return view('frontend.guests.company.information.authentication',compact('data','result','math'));
    }

    //企业用户个人中心数据统计
    public function datas()
    {
        $option_type = 'data';
        $data = WarrantyRecognizee::whereHas('order',function($q){
            $q->where('user_id',$_COOKIE['user_id']);
        })->get();
//        dd($data);

        return view('frontend.guests.company.information.datas',compact('option_type'));
    }


    //   （数据管理） 总人数、理赔详情
    public function dataManage(){
        $option_type = 'data';
        return view('frontend.guests.company.information.dataManage',compact('option_type'));
    }

    //（保障与人元管理）增员、减员详情
    public function staffManage(){
        $option_type = 'data';
        return view('frontend.guests.company.information.staffManage',compact('option_type'));
    }







    //企业用户个人中心数据统计详细信息
    public function payment()
    {
        $option_type = 'data';

        return view('frontend.guests.company.information.payment',compact('option_type'));
    }


}














