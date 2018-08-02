<?php
namespace App\Http\Controllers\BackendControllers;

use Illuminate\Http\Request;
use App\Models\LiabilityDemand;
use \Illuminate\Http\Request as Requests;
use App\Models\Comment;

use Illuminate\Support\Facades\DB;


/**
 * 工单管理
 */
class WorkOrderController extends BaseController
{
    //我收到的工单列表 、首页列表
    public function index($id){
        $status = $_GET['status'] ?? "";
        if($id == 1){
            $list =LiabilityDemand::whereNotIn('agent_id',[0]);
            $list->whereNotIn('agent_id',[0]);
            $status && $list->where('status',$status);
            $data = $list->paginate(config('list_num.frontend.demand'));
        }elseif($id == 2){
            $list = LiabilityDemand::where('agent_id',0);
            $status && $list->where('status',$status);
            $data =  $list->paginate(config('list_num.frontend.demand'));
        }
        return view('backend_v2.work.index',compact('data','id','status'));

    }

    //创建工单
    public function newWork(Requests $request){

        $input = $request->all();

        DB::beginTransaction();
        try{
            //添加到工单表
            $data = new LiabilityDemand();
            $data->module = $input['modular'];
            $data->recipient_id = $input['people'];
            $data->title = $input['title'];
            $data->agent_id = 0;
            $data->content = $input['content'];
            $data->status = 1;
            $data->save();
            //添加到内容表
            $comment = new Comment();
            $comment->commentable_type = 'App\Models\LiabilityDemand';
            $comment->commentable_id = $data->id;
            $comment->send_id = 0;
            $comment->recipient_id = $input['people'];
            $comment->content = $input['content'];
            $comment->status = 1;
            $comment->save();
            DB::commit();
            return ['status'=>200,'msg'=>'成功'];
        }catch (Exception $e){
            DB::rollBack();
            return ['status'=>400,'msg'=>'信息发送失败，请稍后再试'];
        }
    }


    //详情页面
    public function details($id){
        $status = $_GET['status'];

        $liability_demand = LiabilityDemand::where('id',$id)
        ->first();
        $comment = Comment::where('commentable_id',$id)
        ->first();
        if($liability_demand->status ==1){
            $read = LiabilityDemand::where('id', $id)
                ->update(['status' => 2]);
        }
        //        回复的内容
        $content = Comment::where('commentable_id',$id)
            ->get();

        return view('backend_v2.work.work_details',compact('liability_demand','comment','status','content'));
    }


//    回复
    public function addReply(Requests $request){
        $input = $request->all();

        DB::beginTransaction();
        try{
            $data = new Comment();
            $data->commentable_type = 'App\Models\LiabilityDemand';
            $data->commentable_id =$input['liability_demand_id'];
            $data->send_id = 0;
            $data->recipient_id = $input['recipient_id'];
            $data->content = $input['content'];
            $data->status = 1;
            $data->save();
            DB::commit();
            return ['status'=>200,'msg'=>'录入成功'];
        }catch (Exception $e){
            DB::rollBack();
            return ['status'=>400,'msg'=>'录入失败'];
        }

    }


    //结束需求
    public function addClose(Requests $request)
    {
        $input = $request->all();

        DB::beginTransaction();
        try{
            //关闭状态
            $data = LiabilityDemand::where('id',$input['liability_demand_id'])
                ->update(['status'=>3]);
            //关闭类型、关闭原因
            $data = LiabilityDemand::where('id',$input['liability_demand_id'])
                ->update(['close_status'=>$input['id'],'reason'=>$input['val']]);
            DB::commit();
            return ['status'=>200,'msg'=>'修改成功'];

        }catch (Exception $e){
            DB::rollBack();
            return ['status'=>400,'msg'=>'修改失败，请稍后再试'];
        }
    }




}