<?php

namespace App\Http\Controllers\FrontendControllers\AgentControllers;

use App\Helper\AgentBrokerage;
use App\Models\AgentAccount;
use App\Models\AgentAccountRecord;
use App\Models\Competition;
use App\Models\CompetitionCondition;
use App\Models\Order;
use App\Models\OrderBrokerage;
use App\Models\Scaling;
use League\Flysystem\Exception;
use Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\MarketDitchRelation;
use Illuminate\Support\Facades\DB;

class AgentBrokerageController extends AgentFuncController
{
    protected $agent_brokerage;
    public function __construct()
    {
        $this->agent_brokerage = new AgentBrokerage();

    }

    //前台代理人佣金默认界面,查看自己的佣金
    public function index()
    {
        //获得自己的所有的佣金
        $agent_id = $this->checkAgent();
        if(!$agent_id){
            return back()->withErrors('非法操作');
        }
        //查询自己的所有的订单
        $brokerage_list = OrderBrokerage::where('agent_id',$agent_id)->get();
        $brokerage_list_count = count($brokerage_list);
        return view('frontend.agents.agent_brokerage.index',compact('brokerage_list','brokerage_list_count'));
    }


    //佣金统计
    public function brokerageStatistics()
    {
        $agent_id = $this->checkAgent();
        //查询所有的佣金记录，1.查看当前的佣金总计，2，查看当前任务期间未结算的佣金，所有的佣金
        $brokerage = AgentAccount::where('agent_id',$agent_id)->first();
        if(!$brokerage){//说明没有账户，添加
            $AgentAccount = new AgentAccount();
            $agent_account_array = array(
                'sum'=>0,
                'settlement_date'=>0,
                'agent_id'=>$agent_id,
            );
            $this->add($AgentAccount,$agent_account_array);
            $brokerage = AgentAccount::where('agent_id',$agent_id)->first();
            $settlement_date = 0;
        }else{
            //根据最后结算时间查看任务结算情况，每天结算一次
            $settlement_date = $brokerage->settlement_date;
        }
        $date = date('Y-m-d',time());
//        if($settlement_date){
//            if($date>$settlement_date){
                //说明当天未结算过
                $this->settlementOrder();
//            }
//        }
        //修改时间
        $change_date_array = array(
            'settlement_date'=>$date,
        );
        $this->edit($brokerage,$change_date_array);
        //获取所有的收支明细
        $brokerage_detail = AgentAccountRecord::where('agent_id',$agent_id)
            ->orderBy('id','desc')
            ->paginate(10);
        $count = count($brokerage_detail);
        return view('frontend.agents.agent_brokerage.account',compact('brokerage','count','brokerage_detail'));
    }

    //未计算佣金任务统计
    public function noSettlementOrder()
    {
        $agent_id = $this->checkAgent();
        //查询所有的未计算佣金得任务
        $no_settlement_order = Order::where('agent_id',$agent_id)
            ->where('is_settlement',0)
            ->with('order_competition')
            ->paginate(config('frontend.list_num.order'));
        $count = count($no_settlement_order);
        return view('frontend.agents.agent_brokerage.NoSettlement',compact('count','no_settlement_order'));
    }

    //封装一个方法，用来结算当前可结算的未结算任务
    public function settlementOrder()
    {
        $agent_id = $this->checkAgent();
        //1.查询所有的未结算的任务,2.查找所有当前时间已经结束的活动，3.结算
        //获取所有的 未结算的竞赛方案id
        $competition_array = Order::where('agent_id',$agent_id)
            ->where('is_settlement',0)
            ->with('order_competition')
            ->distinct()
            ->get();
        //判断是否有未结算的竞赛方案，如果没有，返回false；
        if(!count($competition_array)){
            return false;
        }
        //遍历查询所有满足条件的竞赛方案
        $array = array();
        //获取当前时间，date格式
        $time = time();
        $date_time = date('Y-m-d',$time);
        //查找所有未结算的竞赛方案
        foreach($competition_array as $value){
            $end_time = $value->order_competition->end_time;
            if($end_time<$date_time){
                array_push($array,$value->competition_id);
            }
        }
        //结算当前的订单，和竞赛方案要求做对比，达到要求，则更改比率，未达到要求，则按原比例计算
//        分组获取符合条件的订单
        $order_group = Order::where('agent_id',$agent_id)
            ->where('is_settlement',0)
            ->with('order_order_brokerage')
            ->wherein('competition_id',$array)
           ->get();
        $order_group = $order_group->groupBy('competition_id');
            //计算所有的佣金
            foreach($order_group as $value)
            {
                //判断竞赛方案的类型
                //完成总单数
                $order_count = count($value);
                //计算完成总价格
                $order_sum = 0;
                foreach($value as $values){
                    $order_sum += $values->premium;
                }
                //获取竞赛方案的id
                $competition_id = $value[0]->competition_id;
                //判断完成情况,获取对应的佣金比率和金额
                $complete = $this->checkCondition($competition_id,$order_count,$order_sum);
                if(!$complete){
                    //说明没有完成的任务，则按原状态进行佣金结算
                    //获取所有的订单id
                    $order_id_array = array();
                    foreach($value as $values){
                        array_push($order_id_array,$values->id);
                    }
                    $result = $this->settlementBrokerage($agent_id,$order_id_array,$competition_id,'old');
                    if($result){
                        //结算成功
                    }else{
                        //结算失败
                    }
                }else{
                    //说明完成了条件，按完成条件的奖励进行计算
                    $reward = $complete->reward;
                    $rate = $complete->rate;
                    $order_id_array = array();
                    foreach($value as $values){
                        array_push($order_id_array,$values->id);
                    }
                    DB::beginTransaction();
                    try{
                        //结算
                        if($rate == 0){
                            //按原佣金比计算佣金
                            $result1 = $this->settlementBrokerage($agent_id,$order_id_array,$competition_id,'old');
                        }else{
                            //按新佣金比计算佣金,同时修改代理人佣金表
                            $new_rate = $rate/100;
                            $new_brokerage = $order_sum*$new_rate;
                            //修改比率，同时修改代理人赚的钱
                            //获取所有的未结算的
                            foreach($value as $values)
                            {
                                if(!$values){
                                    continue;
                                }
                                $OrderBrokerage = OrderBrokerage::find($values->order_order_brokerage->id);
                                $change_array = array(
                                    'rate'=>$rate,
                                    'user_earnings'=>$values->order_order_brokerage->order_pay*$rate/100,
                                );
                                $this->edit($OrderBrokerage,$change_array);
                            }
                            //修改所有状态，添加到佣金中
                            $result1 = $this->settlementBrokerage($agent_id,$order_id_array,$competition_id,$new_brokerage);
                        }
                        //结算固定奖金
                        if($reward == 0){
                            $result2 = true;
                        }else{
                            $this->addAgentAccountRecord($agent_id,$reward,'活动固定奖励',$competition_id);
                        }

                        DB::commit();
                        return true;
                    }catch (Exception $e){
                        DB::rollBack();
                        return false;
                    }
                }
            }
    }


    //产品佣金查询
    public function getRate()
    {
        //获取所有自己代理的产品，产品佣金查询界面
        $agent_id = $this->checkAgent();
        //获取代理的所有的渠道
        $ditch = $this->getMyDitch($agent_id);
        $product_list = $this->getMyAgentProduct($agent_id);
        $ditch_count = count($ditch);
        $count = count($product_list);
        return view('frontend.agents.agent_brokerage.rate',compact('ditch_count','ditch','product_list','count'));
    }
    //佣金查询,
    public function inquireRateAjax()
    {
        $input = Request::all();
        $agent_id = $this->checkAgent();
        $result = $this->getMyAgentBrokerage($input,$agent_id);
        if($result['earning']){
            echo returnJson('200',$result);
        }else{
            echo returnJson('0','无记录');
        }

    }
    //通过产品查找自己可以销售的渠道，ajax
    public function getDitchByProductAjax()
    {
        $input = Request::all();
        $isMyProduct = $this->isMyProduct($input['product_id']);
        if($isMyProduct){
            $ditch = $this->getDitchByProduct($input['product_id']);

            echo returnJson('200',$ditch);
        }else{
            echo returnJson('0','非法操作');
        }
    }


    //封装一个方法，用来结算所有未计算的订单，$type如果等于0，则表示按原佣金比进行计算，如果不为0，则表示新的佣金总额
    public function settlementBrokerage($agent_id,$order_id_array,$competition_id,$type)
    {
        DB::beginTransaction();
        try{
            //佣金表
            $ChangeOrder = Order::wherein('id',$order_id_array)
                ->with('order_order_brokerage');
            $new_order_brokerage = $ChangeOrder->get();
            //订单表
            if($type == 'old'){
                $order_brokerage_sum = 0;
                foreach($new_order_brokerage as $value){
                    $order_brokerage_sum += $value->order_order_brokerage->user_earnings;
                }
            }else{
                $order_brokerage_sum = $type;
            }
            $this->addAgentAccountRecord($agent_id,$order_brokerage_sum,'活动结算',$competition_id);
            //批量更新订单佣金表数据
//            $this->edit($ChangeOrder,);
            $ChangeOrder->update(['is_settlement'=>1]);

            DB::commit();
            return true;
        }catch (Exception $e){
            DB::rollBack();
            return false;
        }
    }



    //封装一个方法，用来进行条件判断
    public function checkCondition($competition_id,$count,$sum)
    {
        $condition_type = Competition::where('id',$competition_id)
            ->first()->condition_type;
        //用当前条件进行判断
        if($condition_type == 1){
            //金额满足条件
            $complete_condition_result = $this->checkSum($competition_id,$sum);
            $complete_condition = array();
            foreach($complete_condition_result as $value)
            {
                array_push($complete_condition,$value);
            }
        }else if($condition_type == 2){
            //数量满足
            $complete_condition_result = $this->checkCount($competition_id,$count);
            $complete_condition = array();
            foreach($complete_condition_result as $key=>$value)
            {
                array_push($complete_condition,$value);
            }
        }else if($condition_type == 3){
            //金额和数量都满足,二者取交集
            $sumComplete = $this->checkSum($competition_id,$sum);
            $countComplete = $this->checkCount($competition_id,$count);
            $complete_condition = array();
            foreach($sumComplete as $key=>$value){
                foreach($countComplete as $value1){
                    if($value->id == $value1->id){
                        array_push($complete_condition,$value);
                    }
                }
            }
        }else if($condition_type == 4){
            //金额或数量满足，二者取并集
            $sumComplete = $this->checkSum($competition_id,$sum);
            $countComplete = $this->checkCount($competition_id,$count);
            $complete_condition1 = array();
            $complete_condition2 = array();
            $complete_condition = array();
            foreach($sumComplete as $key=>$value){
                array_push($complete_condition1,$value);
            }
            foreach($countComplete as $key=>$value1){
                array_push($complete_condition2,$value);
            }
            $complete_condition = array_merge($complete_condition1,$complete_condition2);
        }
        if(!count($complete_condition)){
            return false;
        }
        $result = $this->getHighRate($complete_condition);
        //返回最符合条件的奖励对应的id
        return $result;
    }

    //封装一个方法，用来获取最高佣金比
    public function getHighRate($complete_condition)
    {
        $count = count($complete_condition);
        if($count == 1){
            return $complete_condition[0];
        }else{
            $rate = 0;
            $result = 0;
            foreach($complete_condition as $value)
            {
                if($value->rate>$rate){
                    $rate = $value->rate;
                    $result = $value;
                }
            }
            if($rate == 0){
                foreach($complete_condition as $value)
                {
                    if($value->reward>$rate){
                        $rate = $value->rate;
                        $result = $value;
                    }
                }
            }
            return $result;
        }
    }


    //封装一个方法，金额满足条件
    public function checkSum($competition_id,$sum)
    {
        $award = CompetitionCondition::where([
            ['competition_id',$competition_id],
            ['min_sum','<',$sum],
            ['max_sum','>',$sum],
        ])->orwhere([
            ['competition_id',$competition_id],
            ['min_sum','<',$sum],
            ['max_sum',0],
        ])->get();
        return $award;
    }
    //封装一个方法，数量满足条件
    public function checkCount($competition_id,$count)
    {
        $award = CompetitionCondition::where([
            ['competition_id',$competition_id],
            ['min_count','<',$count],
            ['max_count','>',$count],
        ])->orwhere([
            ['competition_id',$competition_id],
            ['min_count','<',$count],
            ['max_count',0],
        ])->get();
        return $award;
    }
    //封装一个方法，用来修改代理人账户记录
    public function changeAgentAccount($agent_id,$sum)
    {
        $AgentAccount = AgentAccount::where('agent_id',$agent_id)->first();
        $agent_account_array = array(
            'sum'=>$sum,
        );
        $result = $this->edit($AgentAccount,$agent_account_array);
        return $result;
    }
    //封装一个方法，添加到记录中
    public function addAgentAccountRecord($agent_id,$money,$operate,$competition_id)
    {
        $account_sum = AgentAccount::where('agent_id',$agent_id)
            ->first()->sum;
        $balance = $account_sum + $money;
        //添加记录
        $AgentAccountRecord = new AgentAccountRecord();
        $agent_account_record_array = array(
            'money'=>$money,
            'agent_id'=>$agent_id,
            'operate'=>$operate,
            'status'=>0,
            'balance'=>$balance,
            'competition_id'=>$competition_id,
        );
        $result = $this->edit($AgentAccountRecord,$agent_account_record_array);
        //修改账户余额
        $this->changeAgentAccount($agent_id,$balance);
    }


    //封装一个方法，用来获取代理人的佣金和折标系数
    public function getMyAgentBrokerage($array,$agent_id)
    {
        $ditch_id = $array['ditch_id'];
        $product_id = $array['product_id'];
        $condition = array(
            'type'=>'agent',
            'product_id'=>$product_id,
            'ditch_id'=>$ditch_id,
            'agent_id'=>$agent_id,
        );
        $brokerage = MarketDitchRelation::where($condition)
            ->first();
        if(!$brokerage){
            //进行渠道统一查询
            $condition = array(
                'product_id'=>$product_id,
                'ditch_id'=>$ditch_id,
                'agent_id'=>0,
            );
            $brokerage = MarketDitchRelation::where($condition)
                ->first();
            if(!$brokerage){//产品统一查询
                $condition = array(
                    'type'=>'product',
                    'product_id'=>$product_id,
                );
                $brokerage = MarketDitchRelation::where($condition)
                    ->first();
            }
        }
        if($brokerage){
            $earning = $brokerage->rate;
        }else{
            $earning = 0;
        }
        $scaling = Scaling::where($condition)
            ->first();
        if(!$scaling){
            //进行渠道统一查询
            $condition = array(
                'product_id'=>$product_id,
                'ditch_id'=>$ditch_id,
                'agent_id'=>0,
            );
            $scaling = Scaling::where($condition)
                ->first();
            if(!$scaling){//产品统一查询
                $condition = array(
                    'type'=>'product',
                    'product_id'=>$product_id,
                );
                $scaling = Scaling::where($condition)
                    ->first();
            }
        }
        if($scaling){
            $scaling = $scaling->rate;
        }else{
            $scaling = 0;
        }
        return array(
            'earning'=>$earning,
            'scaling'=>$scaling
        );
    }


}
