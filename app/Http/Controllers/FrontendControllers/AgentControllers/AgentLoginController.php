<?php

namespace App\Http\Controllers\FrontendControllers\AgentControllers;

use App\Models\Agent;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cookie;
use App\Models\User;
use App\Models\UserThird;

class AgentLoginController extends Controller
{
    //
    public function agentLogin(Request $request)
    {
        $redirect = $request->get('redirect');
        if(Auth::check() && isset($_COOKIE['agent'])){
            return redirect('/agent/');
        }
        if($this->is_mobile()){
            return view('frontend.agents.agent_login.mobile.index',compact('redirect'));
        }
        return view('frontend.agents.agent_login.login',compact('redirect'));
    }
    public function agentDoLogin(Request $request)
    {
        $phone = $request->get('phone');
        $password = $request->get('password');
        $redirect = $request->get('redirect');
        if (Auth::attempt(['phone' => $phone, 'password' => $password])) {
            // 认证通过...
            //判断是否是在职代理人
            $result = Agent::where('user_id',Auth::user()->id)->where('work_status',1)->first();
            if($result){
                setcookie('agent','true',(time()+3600));
                setcookie('agent_id',$result->id,(time()+3600));
                setcookie('agent_name',Auth::user()->name,(time()+3600));
                //公众号登录
                if(isset($_COOKIE['code']) && $_COOKIE['state'] == 'STATE') {
                    $userinfo = $_COOKIE['userinfo'];
                    $arr = unserialize($userinfo);
                    //判断是否之前用户绑定过
                    $user_id = UserThird::where('user_id',Auth::user()->id)->first();
                    if(empty($user_id['user_id'])){
                        UserThird::where('app_id',$arr['openid'])->update(['user_id'=>Auth::user()->id]);
                    }else{
                         echo "<script>alert('账号已绑定，请联系管理员');</script>";
                         return view('frontend.agents.agent_login.mobile.index',compact('redirect'));
                    }
                }
                if(is_null($redirect)) {
                    return redirect('/agent/');
                }else{
                    return redirect($redirect);
                }
            }else{
                Auth::logout();
                return "<script>alert('身份错误');history.back();</script>";
            }
        }elseif($agent = Agent::where('phone', $phone)->first()) {
            if(Auth::attempt(['phone' => $agent->user->phone, 'password' => $password])){
                setcookie('agent','true',(time()+3600));
                setcookie('agent_id',$agent->id,(time()+3600));
                setcookie('agent_name',Auth::user()->name,(time()+3600));

                //公众号登录
                if(isset($_COOKIE['code']) && $_COOKIE['state'] == 'STATE') {
                    $userinfo = $_COOKIE['userinfo'];
                    $arr = unserialize($userinfo);
                    UserThird::where('app_id',$arr['openid'])->update(['user_id'=>$agent->user->id]);
                }

                if(is_null($redirect)) {
                    return redirect('/agent/');
                }else{
                    return redirect($redirect);
                }
            }
        }

        return "<script>alert('账号与密码不匹配');history.back();</script>";
    }

    public function agentLogOut()
    {
        setcookie('agent','',time()-1);
        setcookie('agent_id','',time()-1);
        setcookie('agent_name','',time()-1);
        Auth::logout();
        return redirect('/')->with('status', '已退出登录!');
    }

    //代理人忘记密码
    public function forgetPassword()
    {
        if($this->is_mobile()){
            return view('frontend.agents.agent_login.mobile.forget_password');
        }
        return view('frontend.agents.agent_login.forget_password');
    }

    //验证验证码
    public function checkCode(Request $request)
    {
        $input = $request->all();
        $phone = $input['phone'];
        $data = Agent::where('work_status',1)
            ->pluck('phone')->toArray();
        if(!in_array($phone,$data)){
            return "<script>alert('该账号不是代理人账号或您已离职');history.back();</script>";
        }
        $code = $input['code'];
        $res = $this->checkPhoneCode($phone,$code);
//        $res['status'] = 'success';
        if($res['status'] == 'success'){
            setcookie('find_password_num',$phone,time()+180);
            return "<script>location.href='/reset_password'</script>";
        }else{
            return "<script>alert('".$res["message"]."');history.back();</script>";
        }
    }

    //验证验证码
    protected function checkPhoneCode($phone, $phone_code)
    {
        if(!Cache::get("reg_code_".$phone))
            return ['status'=>'error', 'message'=>'验证码不存在，请重新发送'];
        if(Cache::get("reg_code_".$phone) != $phone_code)
            return ['status'=>'error', 'message'=>'验证码错误'];
        Cache::forget("reg_code_".$phone);
        return ['status'=> 'success', 'message'=>'验证码正确'];
    }

    //重设密码
    public function resetPassword()
    {
        if($this->is_mobile()){
            return view('frontend.agents.agent_login.mobile.reset_password');
        }
        return view('frontend.agents.agent_login.reset_password');
    }

    //重设密码提交
    public function resetPasswordSubmit(Request $request)
    {
        $input = $request->all();
//        dd($input);
        if($input['newPassword'] != $input['repeatPassword']){
            return ['status'=>1,'msg'=>'两次密码不同，请确认后再次提交'];
        }
        $nPsd = bcrypt($input['newPassword']);
        if(!isset($_COOKIE['find_password_num'])){
            return ['status'=>500,'msg'=>'验证已过期，请重新请求'];
        }
        $res = DB::table('users')
            ->join('agents','users.id','agents.user_id')
            ->where('users.phone',$_COOKIE['find_password_num'])
            ->where('agents.work_status',1)
            ->select('agents.*')
            ->update(['users.password'=>$nPsd]);
        if($res){
            return ['status'=>200,'msg'=>'更改成功'];
        }else{
            return ['status'=>400,'msg'=>'更改失败，请稍后再试'];
        }
    }

    //微信公众号
//    public function weChatAuthorize(){
//        $userinfo = getcookie('userinfo');
//        dd($userinfo);
//
//    }


}
