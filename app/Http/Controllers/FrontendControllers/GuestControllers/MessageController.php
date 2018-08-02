<?php
/**
 * Created by PhpStorm.
 * User: dell01
 * Date: 2017/4/27
 * Time: 18:34
 */
namespace App\Http\Controllers\FrontendControllers\GuestControllers;
use App\Http\Controllers\FrontendControllers\BaseController;
use App\Models\Comment;
use App\Models\Messages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Validator;
use App\Models\Message;
use App\Models\MessageRule;
use App\Models\User;
class  MessageController extends BaseController
{
    //信息首页
    public function index(){
        if(isset($_GET['search']) && $_GET['search'] == 'unlooked'){
            $data = Messages::where([
                ['accept_id',$_COOKIE['user_id']],
                ['status','<>',3],
                ['timing','<',date('Y-m-d H:i:s',time())]
            ])->paginate(config('list_num.frontend.message'));
        }else{
            $data = Messages::where([
                ['accept_id',$_COOKIE['user_id']],
                ['timing','<',date('Y-m-d H:i:s',time())]
            ])
                ->paginate(config('list_num.frontend.message'));
        }
        $unlooked_data = Messages::where([
            ['accept_id',$_COOKIE['user_id']],
            ['status','<>',3],
            ['timing','<',date('Y-m-d H:i:s',time())]
        ])->get();
        $unlooked_count = count($unlooked_data);
        $count = count($data);
        $option_type = 'message';
        if($this->is_mobile()){
            return view('frontend.guests.mobile.message',compact('data','count'));
        }
        return view('frontend.guests.user.information.message',compact('data','count','option_type','unlooked_count'));
    }

    //信息详情页
    public function detail($id)
    {
        $data = Messages::where('id',$id)->first();
        if($data['status'] != 3){
            $res = Messages::where('id',$id)->update(['status'=>3,'look_time'=>date('Y-m-d H:i:s')]);
        }else{
            $res = true;
        }
        if($this->is_mobile()){
            return view('frontend.guests.mobile.personal.message_detail',compact('data'));
        }
        if($res){
            return ['status'=>200,'msg'=>'ok'];
        }else{
            return ['status'=>400,'msg'=>'error'];
        }

    }

    //删除消息(批量)
    public function delete(Request $request)
    {
        $input = $request->all();
        foreach($input['_arr'] as $v){
            $res_msg = Messages::where('id',$v)->delete();
            $res_comment = Comment::where('commentable_id',$v)->delete();
        }
        if($res_comment && $res_msg){
            return ['status'=>200,'msg'=>'删除成功'];
        }else{
            return ['status'=>400,'msg'=>'删除失败，请重试'];
        }
    }

    //单条删除
    public function deleteOne($id)
    {
        $res_msg = Messages::where('id',$id)->delete();
        $res_comment = Comment::where('commentable_id',$id)->delete();
        if($res_comment && $res_msg){
            return ['status'=>200,'msg'=>'删除成功'];
        }else{
            return ['status'=>400,'msg'=>'删除失败，请重试'];
        }
    }

    //标记已读
    public function looked(Request $request)
    {
        $input = $request->all();
        foreach($input['_arr'] as $v){
            $data = Messages::where('id',$v)->first();
            if($data['status'] != 3){
                $res = Messages::where('id',$v)->update(['status'=>3,'look_time'=>date('Y-m-d H:i:s')]);
            }else{
                $res = true;
            }
        }
        if($res){
            return ['status'=>200,'msg'=>'更改成功'];
        }else{
            return ['status'=>400,'msg'=>'更改失败'];
        }
    }




    //前台查看站内信
    //封装一个方法，用来获取自己所有消息，返回数组
    public function getAllArr()
    {
        $type_array = [0,2,3];
        $uid = $this->getId();
        //获取当前时间，用来
        $time = time();
        //获取自己的所有可读的消息 cccccccc
        $result = DB::table('message_rule')
            ->where('read_time','<',$time)
            ->where(function ($q) use($type_array,$uid){
                $q->where(function($a)use($type_array){
                    $a->where('receive_id',0)
                        ->wherein('receive_type',$type_array);
                })->orwhere('receive_id',$uid);
            })->select('message_id')
        ->distinct()->get();
        $resultArr = array();
        foreach($result as $value)
        {
            array_push($resultArr,$value->message_id);
        }
        return $resultArr;
    }
    //封装一个方法，用来获取自己的已读消息，返回数组
    public function getReadArr()
    {
        $uid = $this->getId();
        //获取所有已读的消息
        $result = MessageRule::where('receive_id',$uid)
            ->where('status',1)
            ->select('message_id')
            ->get()
            ->toArray();
        $resultArr = array();
        foreach($result as $value)
        {
            array_push($resultArr,$value['message_id']);
        }
        return $resultArr;
    }
    //封装一个方法，用来获取自己的未读消息，返回数组
    public function getUnreadArr()
    {
        //获取所有满足条件的消息
        $allMessage = $this->getAllArr();
        //获取所有已读消息
        $readMessage = $this->getReadArr();
        //获取所有未读的消息
        $unReadMessage = array_diff($allMessage,$readMessage);
        return $unReadMessage;
    }
    //封装一个方法，通过数组获取消息列表
    public function getMessage($arr,$type='')
    {
        $user_id = $this->getId();
        if($type){
            $result = DB::table('message_rule')
                ->join('message','message_rule.message_id','=','message.id')
                ->whereIn('message_id',$arr)
                ->where('receive_id',$user_id)
                ->orderBy('id','desc')
                ->distinct()
                ->select('message_rule.send_id','message_rule.read_time','message.*')
                ->paginate(config('list_num.frontend.message'));
        }else{
            $result = DB::table('message_rule')
                ->join('message','message_rule.message_id','=','message.id')
                ->whereIn('message_id',$arr)
                ->distinct()
                ->select('message_rule.send_id','message_rule.read_time','message.*')
                ->paginate(config('list_num.frontend.message'));
        }



        $count = count($result);
        if($count){
            return $result;
        }else{
            return false;
        }
    }
    //封装一个方法，用来判断当前消息是否有权限访问
    public function isMyMessage($uid,$mid)
    {
        //判断当前的文章该用户是否可以访问
        $isMyMessage = MessageRule::where([
            ['receive_id',$uid],
            ['message_id',$mid]
        ])->orwhere([
            ['message_id',$mid],
            ['receive_id',0]
        ])->count();
        if($isMyMessage){
            return true;
        }else{
            return false;
        }
    }
    //判断当前文章是否已经读过
    public function isRead($uid,$mid)
    {
        //判断是否是已经阅读过的
        $isRead = MessageRule::where([
            ['receive_id',$uid],
            ['message_id',$mid],
            ['status',1],
        ])->count();
        if($isRead){
            return true;
        }else{
            return false;
        }
    }

    //获取自己的已读消息
    public function getReadMessage()
    {
        $readMessageArr = $this->getReadArr();
        $result = $this->getMessage($readMessageArr,'read');
        if($result){
            $count = 1;
        }else{
            $count = 0;
        }
        return view('frontend.guests.message.read',['list'=>$result,'count'=>$count]);
    }
    //获取自己的未读消息
    public function getUnreadMessage()
    {
        $unReadMessage = $this->getUnreadArr();
        //查询未读消息的详细信息 ,同时查找发信人的姓名
        $result = $this->getMessage($unReadMessage);
        if($result){
            $count = 1;
        }else{
            $count = 0;
        }
        return view('frontend.guests.message.un_read',['list'=>$result,'count'=>$count]);
    }

    //获取消息的详细信息
    public function getMessageDetail($mid)
    {
        $uid = $this->getId();
        $isMyMessage = $this->isMyMessage($uid,$mid);
        if($isMyMessage){
            $isRead = $this->isRead($uid,$mid);
            if(!$isRead){
                //说明未阅读过，修改信息，并且获取详细信息
                $isRecord = MessageRule::where([
                    ['receive_id',$uid],
                    ['message_id',$mid],
                    ['status',0],
                ])->first();
                if(!is_null($isRecord)){
                    $message_rule_id = $isRecord->id;
                    //说明是单对单发送
                    $message_rule = MessageRule::find($message_rule_id);
                    $message_rule->status = 1;
                    $message_rule->save();
                }else{
                    //说明是群发，添加一条自己的查看记录
                    $message_rule_detail = MessageRule::where([
                        ['message_id',$mid],
                        ['status',0]
                    ])->first();
                    $message_rule = new MessageRule();
                    $message_rule->receive_id = $uid;
                    $message_rule->send_id = $message_rule_detail['send_id'];
                    $message_rule->read_time = $message_rule_detail['read_time'];
                    $message_rule->message_id = $mid;
                    $message_rule->status = 1;
                    $message_rule->save();
                }
            }
            $result = Message::where('id',$mid)
                ->with('message_rule','message_rule.user')->first();


            return view('frontend.guests.message.detail',['detail'=>$result]);
        }else{
            return back()->withErrors('非法操作');
        }
    }
    //获取未读记录
    public function getMyMessage()
    {
        $result = $this->getUnreadArr();
        $count = count($result);
        if($count){
            $last_id = end($result);
            $message = MessageRule::where('message_id',$last_id)->with('get_detail','user')->first();

            if($message->send_id == 0){
                $message->send_name = '管理员';
            }else{
                $message->send_name = $message->user->name;
            }
            $message->title = $message->get_detail->title;
            $message->url = "/message/get_detail/".$message->message_id;
            echo returnJson('200',array('count'=>$count,'message'=>$message));
        }else{
            echo returnJson('0','暂无新消息');
        }
    }
    //发送站内信
    public function send()
    {
        return view('frontend.guests.message.send_message');
    }
}