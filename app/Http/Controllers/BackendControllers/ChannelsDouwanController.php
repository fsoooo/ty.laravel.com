<?php

namespace App\Http\Controllers\BackendControllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator, Image, Schema,DB;
use App\Models\Channel;
use App\Models\ChannelInsureInfo;
use App\Models\User;

class ChannelsDouwanController extends Controller
{
    //信息展示
    public function index()
    {
        $channel_res = ChannelInsureInfo::orderby('updated_at','esc')->paginate(config('list_num.backend.channel_user'));
        return view('backend_v2.channels.douwan.index')->with('channel_res',$channel_res);
    }
    //投保操作
    public function doInsure($id){
        $res = ChannelInsureInfo::where('id',$id)->update(['insure_status'=>'1']);
        $user_res = $this->addUser($id);
        if($res&&$user_res){
            return redirect('/backend/channels/douwan')->with('status','操作成功');
        }else{
            return redirect('/backend/channels/douwan')->withErrors('操作失败');
        }
    }
    //创建用户
    public function addUser($id){
       $user_info = ChannelInsureInfo::where('id',$id)->first();
       $user_res = user::where('code',$user_info['channel_user_code'])->first();
        if(empty($user_res)){
            User::insert([
                'name'=>$user_info['channel_user_name'],
                'real_name'=>$user_info['channel_user_name'],
                'email'=>isset($user_info['channel_user_email']) ? $user_info['channel_user_email'] : "",
                'phone'=>$user_info['channel_user_phone'],
                'address'=>isset($user_info['channel_user_address']) ? $user_info['channel_user_address'] : "",
                'type'=>'user',
                'code'=>$user_info['channel_user_code'],
                'password'=>bcrypt('123qwe'),
            ]);
        }
        return true;
    }

}
