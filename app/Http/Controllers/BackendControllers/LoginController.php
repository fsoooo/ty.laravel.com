<?php

namespace App\Http\Controllers\BackendControllers;

use App\Models\AdminUser;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LoginController extends BaseController
{

    //登陆页面展示
    public function index()
    {
        if(Auth::guard('admin')->check()){
            return redirect('/backend');
        }
        return view('backend_v2.login.login');
    }


    //执行登陆
    public function login(Request $request)
    {
        if(Auth::guard('admin')->check()){
            return redirect('/backend');
        }
        $email = $this->request->email;
        $password = $this->request->password;
        //验证登陆
        if (Auth::guard('admin')->attempt(['email' => $email, 'password' => $password])) {

            return redirect('/backend');
        } else {
            return back()->withErrors('账户或密码错误！');
        }
    }

    //退出登陆
    public function logout()
    {
        if(Auth::guard('admin')->user())
            \Cache::forget('user_roles_array' . Auth::guard('admin')->user()->email);
        Auth::guard('admin')->logout();
        return redirect('backend/login');
    }


    // 修改密码
    public function modify(){

        $old_pwd = $_GET['old_pwd'];
        $new_pwd = $_GET['new_pwd'];
        $two_pwd = $_GET['two_pwd'];

        $adminUsers =Auth::guard('admin')->user();
        if (Auth::guard('admin')->attempt(['email' => $adminUsers->email, 'password' => $old_pwd])) {
            if($new_pwd == $two_pwd){
                $res = AdminUser::where('id', $adminUsers->id)->update(['password' => bcrypt($two_pwd)]);
                if($res){
                    return 1;
                }else{
                    return 4;
                }

            }else{
                return 3;
            }

        }else{
            return 2;
        }

    }




}