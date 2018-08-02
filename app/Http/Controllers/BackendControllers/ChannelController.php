<?php

namespace App\Http\Controllers\BackendControllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator, Image, Schema,DB;


class ChannelController extends Controller
{
    //渠道展示
    public function index()
    {
        $result = DB::table('channel')
             ->where(['status'=>0])
             ->select('id','name', 'only_id','sign_key','email','created_at','url')
             ->paginate(config('list_num.backend.channel'));
        if($result){
            return view('backend.channel.index',compact(['result','result']));
        }
    }

    //录入验证
    public function  channel_check(Request $request){
        $array = $request->input();
        array_shift($array);
        $array['only_id'] = time() . mt_rand(1,1000000);
        $array['sign_key'] =MD5( 'TY'.time().mt_rand(1,1000000).MD5($array['code']));
        $array['created_at'] = date('Y-m-d H:i:s',time());

        $this->check($array);
        $res = DB::table('channel')->insert($array);
        if($res){
            return redirect('/backend/channel/addchannel')->with('status','添加成功');
        }else{
            return back()->withErrors('添加失败');
        }

    }

    //验证
    public function  check($parameter){
        $validator                 =   Validator::make($parameter, [
            'name'                 =>  'required|string',
            'describe'             =>  'required|string',
            'email'                => 'email',
            'url'                  => 'required|url', //url
            'code'                 => 'required|string', //code
        ],[
            'name.string'          =>  'The :attribute mast be string.',
            'describe.string'      =>  'The :attribute mast be string.',
            'email.string'         =>  'The :attribute  must be a email.',
            'url.string'           =>  'The :attribute mast be url.', //url
            'code.string'          =>  'The :attribute mast be code.', //code
        ]);
        if ($validator->fails()) {
            return $validator->errors();
        }
    }

//   删除
    public function  channel_omit($id){
        $res =DB::table('channel')->where(['id'=>$id])->update(['status' => 1]);
        if($res){
            return redirect('backend/channel/addchannel')->with('status', '成功删除渠道信息!');
        }else{
            return back()->withErrors('渠道删除失败！');
        }
    }

    /**
     * 更新数据
     *
     * @param  \Illuminate\Http\Request $request
     * @param $id
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function renew(Request $request, $id)
    {
        $data = $request->input();
        $name = $data['name'];
        $email = $data['email'];

        $result =DB::table('channel')->where(['id'=>$id])->update(['name' => $name,'email'=>$email]);
        return redirect('backend/channel/addchannel')->with('status', '更新成功');
    }

//    获取合作渠道的参数 根据代号返回参数（唯一id、密钥）
    public function channel_api(Request $request){
        $arr = $request->all();
        $code = $arr['code'];
        if(!empty($code)){
            $result = DB::table('channel')
                ->where(['code'=>$code,'status'=>0])
                ->select('only_id','sign_key')
                ->first();
            if($result){
                return json_encode($result); //输出JSON
            }
        }else{
            return json_encode("请填写参数");
        }



    }


}
