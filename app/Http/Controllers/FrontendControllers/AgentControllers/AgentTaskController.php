<?php

namespace App\Http\Controllers\FrontendControllers\AgentControllers;
use App\Http\Controllers\FrontendControllers\BaseController;
use App\Models\TaskCondition;
use Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\Task;
class AgentTaskController extends BaseController
{
    //到任务主界面，默认为按月查看任务进度
    public function index($time_type)
    {
        $time_type = $time_type;
        $list = $this->getOrderByTime($time_type);
        $list = $list->paginate(config('list_num.frontend.task'));
        $count = count($list);
        if($time_type == 'all'){
            $condition = '所有订单';
        }else if($time_type == 'month'){
            $condition="本月订单";
        }else if($time_type == 'year'){
            $condition="年度订单";
        }else if($time_type == 'quarter'){
            $condition="季度订单";
        }
        return view('frontend.agents.agent_task.index',compact('list','count','condition'));
    }
    //获取指定时间的任务完成情况
    public function getTask(){
        $input = Request::all();
        $start_time = $input['start_time'];
        $end_time = $input['end_time'];
        $order = $this->getOrderByTime('designated',$start_time,$end_time);
        $list = $order->paginate(config('list_num.frontend.task'));
        $count = count($list);
        $condition = '指定时间';
        return view('frontend.agents.agent_task.index',compact('list','count','condition'));
    }

    //任务进展查看
    public function progress($type)
    {
        $time_type = $type;
        //如果是月，季度，年任务类型，则获取任务及任务详情，如果是其他条件的任务，则只获取任务列表
        if($type == 'month'||$type == 'quarter'||$type == 'year'){
            $task = $this->getTaskByType($type);
            $count = count($task);
            if($count){
                $task_id = $task->id;
            }else{
                return view('frontend.agents.agent_task.progress',compact('count'));
            }
        }else{
            $time_type = 'designated';
            $task_id = $type;
        }
        //获取该任务的条件要求
        $task_condition = $this->getConditionByTaskId($task_id);
        $count = 1;
        //获取该任务的基本信息
        $task_detail = $this->getTaskDetail($task_id);
        $task_type = $task_detail->task_type;
        //获取所有的订单情况\
        if($time_type == 'designated'){
            $order = $this->getOrderByTime($time_type,$task_detail->start_time,$task_detail->end_time);
        }else{
            $order = $this->getOrderByTime($time_type);
        }
        $order_list = $order->get();

        //循环，进行任务和当前进度比对
        foreach($task_condition as $value){
            $sum = 0;
            $product_id = $value->product_id;
//            $area_id = $value->area_id;
            $task_condition_type = $value->task_condition_type;
            foreach($order_list as $order){
                $order_product_id  = $order->product_id;
//                $order_area_id = $order->area_id;
//                &&($area_id==$order_area_id||$area_id==0)
                if(($product_id==$order_product_id||$product_id==0)){
                    if($task_condition_type == 1){
                        //说明不计算折标率
                        $sum += $order->order_order_brokerage->order_pay;
                    }else{dd('sdf');
                        $sum += $order->order_order_brokerage->order_pay*($order->order_order_brokerage->scaling/100);
                    }
                }
                $value['progress'] = $sum;
            }
        }
        return view('frontend.agents.agent_task.progress',compact('task_detail','task_condition','count'));
    }

    //用来获取特定任务列表
    public function getOtherTaskList()
    {
        //其他情况下只获得任务的列表
        $task = Task::where('task_type',4)->where('status',0);
        $count = $task->count();
        if($count){
            $task_list = $task->paginate(config('list_num.frontend.task'));
        }else{
            $task_list = '';
        }
        return view('frontend.agents.agent_task.OtherTaskList',compact('task_list','count'));
    }
    //通过任务id获取任务的基本信息
    public function getTaskDetail($task_id)
    {
        $task_detail = Task::where('id',$task_id)->first();
        return $task_detail;
    }



    //写一个方法，用来通过任务id查询任务及进度条件
    public function getConditionByTaskId($task_id)
    {
        //获取任务要求
        $task_condition = TaskCondition::where('task_id',$task_id)->get();
        return $task_condition;
    }


    //通过时间段进行已完成订单查看
    public function getOrderByTime($time_type,$start_time='',$end_time='')
    {
        $agent_id = $this->checkAgent();
        if($time_type == 'all'){
            $_time = 0;
        }else if($time_type == "month"){
            $_time=date(mktime(0, 0 , 0,date("m"),1,date("Y")));
        }else if($time_type == "year"){
            $_time=date(mktime(0, 0, 0,1,1,date('Y')));
        }else if($time_type == "quarter"){
            $season = ceil((date('n'))/3);//当月是第几季度
            $_time=date(mktime(0, 0, 0,$season*3-3+1,1,date('Y')));
        }else if($time_type == 'designated'){
            $result =  Order::where('agent_id',$agent_id)
                ->where('pay_time','>=',$start_time)
                ->where('pay_time','<=',$end_time)
                ->with('order_order_brokerage');
//                ->paginate(config('list_num.frontend.task'));
            return $result;
        }else{
            $_time=false;
        }
        $time = date('Y-m-d H:i:s',$_time);
        $result = Order::where('agent_id',$agent_id)
            ->where('pay_time','>=',$time)
            ->with('order_order_brokerage');
//            ->paginate(config('list_num.frontend.task'));
//        ->get();
        return $result;
    }

    //通过时间段，获取改时间段内的成交金额
    public function getOrderMoneyByTime($money_type,$time_type){
        $order_array = $this->getOrderByTime($time_type);
        $count = count($order_array);
        if($count){
            $sum = 0;
//            get_object_vars(
            foreach($order_array as $value){
                dd($value);
            }
            if($money_type == 1){
                //说明是不含折标率
                foreach($order_array as $value){

                    $sum+=$value->order_pay;
                }
            }else{
                //说明含折标率
                foreach($order_array as $value){
                    $sum+=$value->order_pay*($value->scaling/100);
                }
            }
        dd($sum);
        }else{
            return 0;
        }
        dd($count);
    }
    //通过类型进行任务查看,只能查询年月季度任务
    public function getTaskByType($type)
    {
        if($type == 'month'){
            $task_type = 1;
        }else if($type == 'quarter'){
            $task_type = 2;
        }else if($type == 'year'){
            $task_type = 3;
        }
        $result = Task::where('task_type',$task_type)
            ->where('status',0)
            ->with('task_condition','task_condition.task_product')->first();
        return $result;
    }
}
