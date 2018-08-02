<?php
/**
 * 业管后台： 代理人管理
 * Created by PhpStorm.
 * User: xyn
 * Date: 2017/9/26
 * Time: 12:46
 */

namespace App\Http\Controllers\BackendControllers;

use App\Models\Agent;
use App\Models\Ditch;
use App\Models\OrderBrokerage;
use App\Models\AuthenticationPerson;
use App\Models\TaskDetail;
use App\Models\User;
use App\Models\Order;
use App\Models\PlanLists;
use App\Repositories\TaskRepository;
use DB, Auth;

class AgentController extends BaseController
{
    /**
     * 代理人管理 列表
     * @return mixed
     */
    public function index()
    {
        $request = $this->request->all();
        $agents = Agent::with(['user','ditches', 'customers']);
        $where = array();
        //
        if(isset($request['pending_status']) && !is_null($request['pending_status']))
        $where[] = ['pending_status', '=', $request['pending_status']];
        if(isset($request['certification_status']) && $request['certification_status'] != -1)
            $where[] = ['certification_status', '=', $request['certification_status']];
        if(isset($request['work_status']) && !is_null($request['work_status']))
            $where[] = ['work_status', '=', $request['work_status']];
        if(isset($request['keyword'])){
            $keyword = $request['keyword'];
            switch($request['search_type']){
                case 'job_number':
                    $where[] = ['job_number', '=', $keyword];
                    break;
                case 'agent_name':
                    $agents->whereHas('user', function($q) use($keyword) {
                        $q->where('name', 'like', '%'. $keyword .'%');
                    });
                    break;
            }
        }
        if(isset($request['ditch_id'])){
            $ditch_id = $request['ditch_id'];
            if($ditch_id != 0){
                $agents->whereHas('ditches', function($q) use($ditch_id){
                    $q->where('ditch_id', $ditch_id);
                });
            }
        }
        $agents = $agents->where($where)->paginate(config('list_num.backend.agent'));
        $ditches = Ditch::where('status', 'on')
            ->with(['agents'=>function($q){
                $q->where('work_status', '1');
        }])->get();
        return view('backend_v2.agent.index', compact('agents', 'ditches', 'request'));
    }

    //添加代理提交
    public function addAgentPost()
    {
        $input = $this->request->all();
        DB::beginTransaction();
        try{
            //是否已存在该用户
            $user = User::where(['phone'=> $input['phone']])
                ->orWhere('email', $input['email'])
                ->first(); //根据手机号找关联账户
            if ($user) {
                return back()->withErrors('手机号或邮箱已存在');
            }
            $user = new User();
            $user->real_name = $user->name= $input['name'];    //名称
            $user->email = $input['email']; //邮箱
            $user->phone = $input['phone'];
            $user->password = bcrypt('123456');
            $user->save();

            //是否有关联代理人信息
            if($user->agent)
                return back()->withErrors('该代理人已存在！');

            $agent = new Agent();
//            $agent->create_id = Auth::guard('admin')->user()->id;
            $agent->user_id = $user->id;
            $agent->email = $input['email'];
            $agent->phone = $input['phone'];
            $agent->job_number = $input['job_number'];
            $agent->pending_status = 0; //审核状态 0待审核 1通过
            $agent->certification_status = 0;   //实名状态
            $agent->work_status = 1;    //是否在职 0离职 1在职
            $agent->save();
            $agent->ditches()->attach($input['add_agent_ditch_id']);
            DB::commit();
            return redirect('backend/agent/list?work_status=1')->with('status', '成功录入代理人信息!');
        } catch (\Exception $e){
            DB::rollBack();
            return back()->withErrors('信息录入出错，请稍后再试');
        }
    }

    //代理人信息
    public function agentInfo($id)
    {
        $input = $this->request->all();
        $agent = Agent::find($id);
        //图表数据封装
        $year = isset($input['year']) ? $input['year'] : date('Y');
        $sum = OrderBrokerage::where('agent_id', $id)
           ->where(DB::raw('DATE_FORMAT(created_at, "%Y")'), $year)
           ->groupBy(DB::raw('DATE_FORMAT(created_at, "%m")'))
           ->select(
               DB::raw('sum(user_earnings) as sum_earnings, Sum(order_pay) as pay'),
               DB::raw('DATE_FORMAT(created_at, "%m") as month')
           )
           ->get()->toArray();
        $pay = array();
        $sum_earnings = array();
        for($i=0; $i<=11; $i++){
            foreach($sum as $k => $v){
                if((int)$v['month']-1 == $i){
                    $pay[$i] = (int)($v['pay']/100);
                    $sum_earnings[$i] = ($v['sum_earnings']/100);
                    break;
                } else{
                    $pay[$i] = 0;
                    $sum_earnings[$i] = 0;
                }
            }
        }
        return view('backend_v2.agent.agent_info', compact('agent', 'pay', 'sum_earnings'));
    }

    //代理人业绩
    public function performance($id, TaskRepository $taskRepository)
    {
        $agent = Agent::where('id', $id)
            ->with(['orders'=>function($q){
                $q->where('status', config('attribute_status.order.payed'));
            },
                'orders.product', //产品
                'orders.warranty_recognizee',   //被保人
                'orders.warranty_rule', //关联表
                'orders.warranty_rule.warranty', //保单
                'orders.warranty_rule.policy',   //投保人
                'orders.companyBrokerage',
                'orders.order_brokerage'
            ])
            ->first();

        $year = isset($input['year']) ? $input['year'] : date('Y');
//        //应完成任务
//        $task = TaskDetail::where('agent_id', $id)
//            ->where(DB::raw('DATE_FORMAT(time, "%Y")'), $year)
//            ->groupBy(DB::raw('DATE_FORMAT(time, "%m")'))
//            ->select(
//                DB::raw('sum(money) as sum_money'),
//                DB::raw('DATE_FORMAT(time, "%m") as month')
//            )
//            ->get()->toArray();
//        $task_arr = array();
//        for($i=0; $i<=11; $i++){
//            foreach($task as $k => $v){
//                if((int)$v['month'] - 1 == $i){
//                    $task_arr[$i] = ($v['sum_money'] / 100);
//                    break;
//                } else{
//                    $task_arr[$i] = 0;
//                }
//            }
//        }
//        //任务完成进度
//        $finish_task = OrderBrokerage::where('agent_id', $id)
//            ->where(DB::raw('DATE_FORMAT(created_at, "%Y")'), $year)
//            ->groupBy(DB::raw('DATE_FORMAT(created_at, "%m")'))
//            ->select(
//                DB::raw('sum(order_pay) as order_pay'),
//                DB::raw('DATE_FORMAT(created_at, "%m") as month')
//            )
//            ->get()->toArray();
//        $finish_task_arr = array();
//        for($i=0; $i<=11; $i++){
//            foreach($finish_task as $k => $v){
//                if((int)$v['month'] - 1 == $i){
//                    $finish_task_arr[$i] = ($v['order_pay'] / 100);
//                    break;
//                } else{
//                    $finish_task_arr[$i] = 0;
//                }
//            }
//        }
        $task_arr = $taskRepository->getShouldDoneData($year, null, $id);
        $finish_task_arr = $taskRepository->getHaveDoneData($year, null, $id);
        return view('backend_v2.agent.performance', compact('agent', 'task_arr', 'finish_task_arr'));
    }

    //代理人客户
    public function clients($id)
    {
        $input = $this->request->all();
        $type = isset($input['type']) ? $input['type'] : 'user';
        $agent= Agent::where('id', $id)
            ->with(['customers'=>function($q)use($type){
                $q->whereHas('user', function($q) use($type){
                    $q->where('type', $type);
                });
            }, 'customers.user',
                'customers.user.order'=> function($q) use($id) {
                    $q->where(['status'=> config('attribute_status.order.payed')]);
                },
                'customers.user.order.order_brokerage'
            ])
            ->first();
        return view('backend_v2.agent.clients', compact('agent', 'input'));
    }

    //代理人计划书
    public function plans($id)
    {
        $agent= Agent::where('id', $id)->first();
        $lists = Order::where('agent_id', $id)
            ->where('status', config('attribute_status.order.payed'))
            ->with('planList', 'planList.planRecognizee', 'product','order_brokerage', 'companyBrokerage')
            ->paginate(config('list_num.backend.agent_plan'));
//        dd($lists);
        return view('backend_v2.agent.plans', compact('agent', 'lists'));
    }

    //代理人计划书详情
    public function plan($id)
    {
        $agent= Agent::where('id', $id)->first();
        $input = $this->request->all();
        $plan_id = $input['plan_id'];
        $res = PlanLists::where('id', $plan_id)
            ->whereHas('order', function($q){
                $q->where('status', config('attribute_status.order.payed'));
            })
            ->with(['planRecognizee', 'product','order',
                'order.order_brokerage', 'order.parameter',
                'order.companyBrokerage', 'order.warranty_rule',
                'order.warranty_rule.warranty', 'order.warranty_recognizee',
                'order.warranty_rule.policy'
            ])
            ->first();
        //解析保障内容
        $parameter = json_decode($res->order->parameter->parameter, true);
        $protect_item = json_decode($parameter['protect_item'], true);
        return view('backend_v2.agent.plan', compact('agent', 'res', 'protect_item'));
    }


    //代理人产品
    public function products($id)
    {
        $agent = Agent::with([
            'user', 'user.trueUserInfo','orders'=> function($q){
                $q->where('status', config('attribute_status.order.payed'));
            },
            'orders.product',
            'ditches'=>function($q){
                $q->wherePivot('status', 'on');
            },
            'orders.order_brokerage'=>function($q){
                $q->groupBy('ty_product_id')
                    ->select('order_id', DB::raw('count(order_id) as num, SUM(order_pay) as pay, SUM(user_earnings) as user_earnings, agent_id, ty_product_id'));
            },
            'orders.companyBrokerage'=>function($q){
                $q->groupBy('ty_product_id')->select('order_id', DB::raw('SUM(brokerage) as c_brokerage, ty_product_id'));
            }
        ])
            ->where('id', $id)
            ->first();
        return view('backend_v2.agent.products', compact('agent'));
    }

    //添加渠道
    public function addDitch()
    {
        $input = $this->request->all();
        $name = $input["ditch_name"];
        $ditch_check = Ditch::where(['name'=> $name, 'status'=> 'on'])->first();
        if($ditch_check)
            return -1;
        $ditch = new Ditch();
        $ditch->name = $ditch->display_name =  $name;
        $ditch->type = 'internal_group';
        $ditch->status = 'on';
        $ditch->save();
        return $ditch->id ? $ditch->id : 0;
    }

    //实名信息
    public function trueInfo($id)
    {
        $user = User::whereHas('agent', function($q) use($id){
                $q->where('id', $id);
            })
            ->with('agent','trueUserInfo')
            ->first();
        $agent = $user->agent;
        return view('backend_v2.agent.true_info', compact('agent' ,'user'));
    }

    //处理实名审核
    public function disposeAudit()
    {
        $input = $this->request->all();
        $agent = Agent::find($input['agent_id']);
        $user = $agent->user;
        $type = $input['type'];
        if ($type == 'pass') {
            $type = 2;  //通过
        } else {
            $type = 1;  //未通过
            $reject_msg = $input['reject_mag'];
        }

        $auth = AuthenticationPerson::where('user_id', $user->id)->first();
        if (empty($auth)) {
            AuthenticationPerson::create(['user_id' => $user->id, 'status' => $type]);
        } else {
            AuthenticationPerson::where('user_id', $user->id)->update(['status' => $type]);
            $agent->pending_status = 1;
            $agent->certification_status = 1;
            $agent->save();
        }
        return redirect('backend/agent/true_info/'.$input['agent_id']);
    }

    //离职
    public function changeWorkStatus()
    {
        $input = $this->request->all();
        Agent::where('id', $input['agent_id'])->update(['work_status'=> 0]);
        return 1;
    }
}