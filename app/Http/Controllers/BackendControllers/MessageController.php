<?php
/**
 * Created by PhpStorm.
 * User: dell01
 * Date: 2017/4/27
 * Time: 17:06
 */

namespace App\Http\Controllers\BackendControllers;
use App\Helper\UploadFileHelper;
use App\Helper\WebMessage;
use App\Http\Controllers\backendControllers\BaseController;
use App\Models\Comment;
use App\Models\MessageRule;
use App\Models\Message;
use App\Models\Messages;
use App\Models\MessageStatistics;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mockery\CountValidator\Exception;
use Validator;
use Auth;

class MessageController extends BaseController{
    protected $webMessage;
    protected $_request;
    protected $messages;
    protected $comment;
    public function __construct(Request $request)
    {
        $this->_request = $request;
        $this->webMessage = new WebMessage();
        $this->messages = new Messages();
        $this->comment = new Comment();
    }
    //站内信后台 5.17,5.18
    //站内信主界面
    public function index()
    {
        $data = Messages::groupBy('created_at')
            ->paginate(config('list_num.backend.message'));
        $looked_data = Messages::where('status',3)
            ->groupBy('created_at')
            ->count();
        foreach($data as $v){
            $v['percentage'] = floor(Messages::where([
                    ['created_at',$v['created_at']],
                    ['status',3]
                ])->count()/Messages::where('created_at',$v['created_at'])->count()*100);
        }
        if(count($data)){
            $percentage = floor($looked_data/count($data)*100);
        }else{
            $percentage = 0;
        }
        $count = count($data);
        return view("backend_v2.messages.index",compact('data','count','percentage'));
    }

    //通知提交
    public function msgSubmit()
    {
        $input = $this->_request->all();
        $agents = User::whereHas('agent')->pluck('id');
        $users = User::whereNotIn('id',$agents)->pluck('id');
        if($input['rec'] == 0){ //发给代理人
            DB::beginTransaction();
            try{
                foreach($agents as $v){
                    //添加到messages表
                    $message = new Messages();
                    $message->send_id = 0; //业管发送
                    $message->accept_type = 3;
                    $message->accept_id = $v;
                    $message->timing = $input['timing'];
                    $message->status = 1;
                    $message->save();
                    //添加到comment表
                    $comments = new Comment();
                    $comments->commentable_type = 'App\Models\Messages';
                    $comments->commentable_id = $message->id;
                    $comments->send_id = 0;
                    $comments->recipient_id = $v;
                    $comments->content = $input['content'];
                    $comments->status = 1;
                    $comments->save();
                    DB::commit();
                }
                return redirect('/backend/sms/message')->withErrors('添加成功');
            }catch (Exception $e){
                DB::rollBack();
                return back()->withErrors('添加失败');
            }
        }else{
            DB::beginTransaction();
            try{
                foreach($users as $k=>$v){
                    //添加到messages表
                    $message = new Messages();
                    $message->send_id = 0; //业管发送
                    $message->accept_type = 0;
                    $message->accept_id = $v;
                    $message->timing = $input['timing'];
                    $message->status = 1;
                    $message->save();
                    //添加到comment表
                    $comments = new Comment();
                    $comments->commentable_type = 'App\Models\Messages';
                    $comments->commentable_id = $message->id;
                    $comments->send_id = 0;
                    $comments->recipient_id = $v;
                    $comments->content = $input['content'];
                    $comments->status = 1;
                    $comments->save();
                    DB::commit();
                }
                return redirect('/backend/sms/message')->withErrors('添加成功');
            }catch (Exception $e){
                DB::rollBack();
                return back()->withErrors('添加失败');
            }
        }
    }


    //定时发送消息
    public function sendMsg($id)
    {
        $data = Messages::where('id',$id)->update(['status'=>2,'send_time'=>date('Y-m-d H:i:s',time())]);
        if($data){
            return true;
        }else{
            return false;
        }
    }

    //消息详情
    public function msgDetail($id)
    {
        $data = Messages::where('id',$id)->first();
//        dd($data);
        return view('backend_v2.messages.detail',compact('data'));
    }
    public function search()
    {
        $name = $_GET['name'] ?? "";
        $user = DB::table('users')->where('name', 'like', '%'.$name.'%')->get();
        return json_encode($user);
    }

    //发送站内信
    public function sendMessage()
    {
        $input = Request::all();
        $Validator = $this->checkAddMessagePost($input);//表单验证
        if ($Validator->fails()) {
            return redirect('backend/sms/message')
                ->withErrors($Validator)
                ->withInput();
            echo returnJson('0','发送失败');
        }else{
            $title = $input['title'];
            $content = $input['content'];
            $receive_type = $input['receive_type'];  //类型 指定人员、全体成员、渠道、代理人等

            if($receive_type!=5){
                $receive_person = 0;
            }else{
                $arr = array_filter(explode(",",$input['id']));
                $receive_person = $arr;
            }

            if(isset($input['designated-time'])){
                $send_type = 1;
                $send_time = strtotime($input['designated-time']);
            }else{
                $send_type = 0;
                $send_time = time();
            }
            $result = $this->webMessage->sendMessage(0,$title,$content,$receive_type,$send_type,$receive_person,$send_time);

            $status = json_decode($result)->status;
            if($status == 200){
                echo returnJson(200,'发送成功');
            }else{
                echo returnJson(403,'发送失败');
            }
        }
    }

    //查看已经发送的站内信
    public function getSend()
    {
        $limit = config('list_num.backend.roles');//每页显示几条
        $params = "/backend/sms/has_send";
        if (isset($_GET['page'])) {
            $page = $_GET['page'];
            $res =  MessageRule::where('send_id',0)
                ->where([['receive_id','=',0],['read_time','!=',null]])
                ->orwhere([['receive_id',0]])->paginate($limit);
            $pages = $res->lastPage();//总页数
            $totals = $res->total();//总数
            $currentPage = $res->currentPage();//当前页码
            $result = MessageRule::where('send_id',0)
                ->where([['receive_id','=',0],['read_time','!=',null]])
                ->orwhere([['receive_id',0]])
                ->orderBy('id','desc')
                ->offset(($page - 1) * $limit)
                ->limit($limit)
                ->get();
            return view('backend.sms.hasSend')
                ->with('list', $result)
                ->with('params', $params)
                ->with('totals', $totals)
                ->with('currentPage', $currentPage)
                ->with('pages', $pages);
        } else {
            $page = '1';
            $res =  MessageRule::where('send_id',0)
                ->where([['receive_id','=',0],['read_time','!=',null]])
                ->orwhere([['receive_id',0]])->paginate($limit);
            $pages = $res->lastPage();//总页数
            $totals = $res->total();//总数
            $currentPage = $res->currentPage();//当前页码
            $result = MessageRule::where('send_id',0)
                ->where([['receive_id','=',0],['read_time','!=',null]])
                ->orwhere([['receive_id',0]])
                ->orderBy('id','desc')
                ->offset(($page - 1) * $limit)
                ->limit($limit)
                ->get();
            return view('backend.sms.hasSend')
                ->with('list', $result)
                ->with('params', $params)
                ->with('totals', $totals)
                ->with('currentPage', $currentPage)
                ->with('pages', $pages);
        }



    }
    //短信模板
    public function messageModel()
    {

    }
    //获取已发送站内信详情
    public function getDetail($message_id)
    {
        $detail = MessageRule::where('message_id',$message_id)
            ->where('send_id',0)
            ->with('get_detail')->first();
        if(!$detail){
            return back()->withErrors('错误');
        }
        return view('backend/sms/detail',compact('detail'));
    }




    //控制层验证
    protected function checkAddMessagePost($input)
    {
        //规则
        $rules = [
            'title' => 'required',
            'content' => 'required',
        ];

        //自定义错误信息
        $messages = [
            'required' => 'The :attribute is null.',
        ];
        //验证
        $validator = Validator::make($input,$rules,$messages);
        return $validator;
    }
}
