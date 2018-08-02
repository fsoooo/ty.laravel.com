<?php

namespace App\Http\Controllers\BackendControllers;

use App\Models\DitchAgent;
use App\Models\MarketDitchRelation;
use App\Models\Product;
use App\Models\Scaling;
use App\Models\OrderBrokerage;
use App\Models\Task;
use App\Models\TaskDetail;
use App\Repositories\TaskRepository;
use DB, Auth, Validator, Image;
use App\Models\Ditch;
use App\Models\WarrantyRule;
use App\Models\Warranty;
use App\Models\Agent;
use App\Models\User;
use App\Models\TrueUserInfo;
use Mockery\CountValidator\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\EventListener\ValidateRequestListener;

class DitchAgentController extends BaseController
{
    //渠道管理列表
    public function channel()
    {
        $id = $_GET['id'] ?? "";
        $name = $_GET['name'] ?? "";
        $ditchQuery =Ditch::with(['agents','task_detail','order_brokerage']);
        $name && $ditchQuery->where('name', 'like', '%'.$name.'%');
        $id && $ditchQuery->where('id',$id); //$id &&的意思是  $id  不为空的话 才会执行后面的 where 语句
        $ditchQuery->where('status','on');
        $ditchQuery->select(DB::raw('*, concat(path,id) as npath'));
        $ditchQuery->orderBy('npath', 'asc');
        $channel = $ditchQuery->paginate(30);
//        读取代理人
        $ditch_agent = Agent::join('ditch_agent','agents.id', '=', 'ditch_agent.agent_id')->get();
        foreach($ditch_agent as $value){
            $agent_id[] = $value->agent_id;
        }
//        $people = Agent::whereNotIn('agents.id', $agent_id)
//            ->join('users','agents.user_id', '=', 'users.id')
//            ->select('agents.id','job_number','real_name')
//            ->get();
        $ditch = Ditch::select('name','id')->get();
        return view('backend_v2.channel.channel',compact('channel','name','ditch','id','people'));
    }
//
//    function data2arr($tree, $rootId = 0, $level = 0) {
//        foreach($tree as $leaf) {
//            if($leaf['pid'] == $rootId) {
//                echo str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $level) . $leaf['id'] . ' ' . $leaf['name'] . '<br/>';
//                foreach($tree as $l) {
//                    if($l['fid'] == $leaf['id']) {
//                        data2arr($tree, $leaf['id'], $level + 1);
//                        break;
//                    }
//                }
//            }
//        }
//    }




    //添加渠道
    public function add_channel()
    {
        $all = $this->request->all();
        $code = $all['codeArr'];
        $phone = $all['telArr'];
        $name = $all['nameArr'];
        $channel = $all['channel'];
        $agent_name = explode(',',$name);
        $agent_phone = explode(',',$phone);
        $agent_code = explode(',',$code);
        $time = date("Y-m-d H:i:s");

        //渠道的递归添加
        $ditchs = new Ditch();
        $ditchs->name = $channel;
        $ditchs->created_at = $time;
        $ditchs->updated_at = $time;
        $ditchs->display_name = $channel;
        $ditchs->path = ',' . 0 . ',';
        if(!empty($all['son_id'])){
            $parent = Ditch::where('status','on')->find($all['son_id']);
            $ditchs->pid = $parent->id;
            $ditchs->sort = $parent->sort + 1;
            $ditchs->path = $parent->path . $parent->id . ',';
        }
        $ditch_id = $ditchs->save();

        // 用户表
        foreach($agent_name as $k =>$val){
            $box['name'] = $val;
            $box['phone'] = $agent_phone[$k];
            $box['created_at'] = $time;
            $user_id = User::insertGetId($box); //用户id
            // 代理人
            $arr['phone'] = $agent_phone[$k];
            $arr['job_number'] = $agent_code[$k];
            $arr['user_id'] = $user_id;
            $arr['created_at'] = $time;
            $agent_id = Agent::insertGetId($arr); //代理人id
            // 关联表agent、ditch
            $ditch['agent_id']=$agent_id;
            $ditch['ditch_id']=$ditch_id;
            $res = DitchAgent::insert($ditch);
        }
        if($res){
            return 1;
        }else{
            return 2;
        }
    }


    //渠道详情
    public function channel_details(TaskRepository $taskRepository)
    {
        $id = $_GET['id'];
        $channel_details = Ditch::where('id',$id)->with(['agents'])->first();
        // 客户人数
        $user_count = DitchAgent::where('ditch_agent.ditch_id',$id)
            ->join('order','ditch_agent.agent_id','order.agent_id')
            ->count();

        //本月销售额度
        $month_pay = Ditch::where('ditch_id',$id)
            ->join('order_brokerage','ditches.id','order_brokerage.ditch_id')
            ->where('order_brokerage.created_at', 'like', '%'.date("Y-m").'%')
            ->select(DB::raw("SUM(order_pay) as month"))->first();

        $year_pay = Ditch::where('ditch_id',$id)//年额度
            ->join('order_brokerage','ditches.id','order_brokerage.ditch_id')
            ->where('order_brokerage.created_at', 'like', '%'.date("Y").'%')
            ->select(DB::raw("SUM(order_pay) as year"))->first();

        $year = $yearly ?? date('Y');
        $arr = $this->chart($id,$year, $taskRepository);
        $task_arr = $arr[0];
        $finish_task_arr =$arr[1];


//        佣金设置
        $result =  Product::where('ty_product_id','>=',0)->select('id','product_name')->get();

        $p_id = $_GET['p_id'] ?? "3"; //接值
        $p = DB::table('product');
        $p_id && $p->where('id',$p_id);
        $res = $p->first();
        $p_brokerage = [];
        if($res){
            $p_json = json_decode($res->json, true);
            $p_brokerage = $p_json['brokerage']??"";
        }
        //渠道下所有代理人
        $man = DitchAgent::where(['ditch_id'=>$id,'status'=>'on'])
                ->join('agents','ditch_agent.agent_id','agents.id')
                ->join('users','agents.user_id','users.id')->get();

        return view('backend_v2.channel.channel_details',compact(['channel_details','id',
            'month_pay','year_pay','user_count','task_arr','finish_task_arr','result','p_brokerage','man']));
    }


    //佣金设置展示封装
    public function list_brokerage($p_id)
    {
        $p = DB::table('product');
        $p_id && $p->where('id',$p_id);
        $res = $p->first();
        $p_json = json_decode($res->json, true);
        $p_brokerage = $p_json['brokerage'];
        return $p_brokerage;
    }



    //佣金设置
    public function set_brokerage()
    {
        $p_id = $_GET['p_id'] ?? "1"; //接值
        $id = $_GET['id'];//接值
        $p = DB::table('product');
        $p_id && $p->where('id',$p_id);
        $res = $p->first();
        $p_json = json_decode($res->json, true);
        $p_brokerage = $p_json['brokerage'];
        return view('backend_v2.channel.refresh',compact(['p_brokerage','id']));
    }
//    佣金的添加
    public function add_brokerage(){
        $input = $this->request->all();
        $ty_product_id = $input['ty_product_id'][0];
        $man = $input['man'][0];
        $time = date("Y-m-d H:i:s");
        $ratio_for_agency = $input['ratio_for_agency'];
        $rate = $input['brokerage'];

        $arr = array();
        $ress=array();
        foreach($input['ratio_for_agency'] as $key=>$value){
            $arr['rate'] = $input['brokerage'][$key];//输入的佣金
            $arr['ditch_id'] = $input['ditch_id'][$key];
            $arr['by_stages_way'] = $input['by_stages_way'][$key];
            $arr['ty_product_id'] = $ty_product_id;
            $arr['agent_id'] = $man;
            $arr['created_at'] = $time;
            $ress[]=$arr;
            if(empty($arr['rate'])){
                return redirect(url()->previous())->withErrors('请输入全部比例');
            }
            MarketDitchRelation::where(['ditch_id'=>$arr['ditch_id'], 'ty_product_id'=>$arr['ty_product_id'], 'agent_id'=>$arr['agent_id']])->update(['status'=>'off','updated_at'=>$time]);
        }

        $ratio_for_msg="1";
        foreach($rate as $k => $v){
            if($v > $ratio_for_agency[$k]){
                $ratio_for_msg = false;
                return redirect(url()->previous())->withErrors('渠道/代理人比例 不得大于获益佣金比例');
            }
        }
        if($ratio_for_msg){
            MarketDitchRelation::insert($ress);
        }
        return redirect(url()->previous())->with('status', '成功修改佣金设置');
    }








    //销售记录
    public function channel_record()
    {
        $id = $_GET['id'];
        $search_type = $_GET['search_type'] ?? "";
        $search_name = $_GET['search_name'] ?? "";
        $up_date = $_GET['up_date'] ?? "";
        $end_date = $_GET['end_date'] ?? "";

        $up = date("Y-m-d",strtotime($up_date));
        $end = date("Y-m-d",strtotime($end_date));


        $mark = WarrantyRule::where('ditch_id',$id);
        $mark->with(['policy', 'brokerage']);
        $mark->leftjoin('product', 'warranty_rule.ty_product_id', '=', 'product.ty_product_id');
        $mark->leftjoin('agents', 'warranty_rule.agent_id', '=', 'agents.id');
        $mark->leftjoin('users', 'agents.user_id', '=', 'users.id');
        $mark->leftjoin('warranty', 'warranty_rule.warranty_id', '=', 'warranty.id');
        $search_type && $mark->where('product.insure_type',$search_type);
        $search_name && $mark->where('product.id',$search_name);
        $up_date && $mark->where('warranty.start_time','like',"%".$up."%");
        $end_date && $mark->where('warranty.end_time','like',"%".$end."%");
        $record = $mark->paginate(config('list_num.backend.ditches'));

        $product = Product::where(['status'=>1,'sale_status'=>0,'delete_id'=>0])->where('ty_product_id','>=',0)->get();

        return view('backend_v2.channel.channel_record',compact('record','id','search_type','product','search_name','up_date','end_date'));
    }


    //渠道代理人
    public function channel_agent(TaskRepository $taskRepository)
    {
        $id = $_GET['id'];

        $field = [
            'job_number',
            'name',
            'work_status',
            'agents.id',
            DB::raw("
                  count(com_order.user_id)as count,
                  SUM(user_earnings) as user_earnings,

                  SUM(order_pay) as order_pay,
                  SUM(brokerage) as brokerage
             ")
        ];

        $agent = DitchAgent::where('ditch_agent.ditch_id',$id)
            ->leftjoin('agents', 'ditch_agent.agent_id', '=', 'agents.id')
            ->leftjoin('users', 'agents.user_id', '=', 'users.id')
            ->leftjoin('order', 'agents.id', '=', 'order.agent_id')
            ->leftjoin('company_brokerage', 'order.id', '=', 'company_brokerage.order_id')
            ->leftjoin('order_brokerage', 'order.id', '=', 'order_brokerage.order_id')
            ->select($field)
            ->groupBy('order.user_id')
            ->paginate(config('list_num.backend.ditches'));


        $agent_name = DitchAgent::where('ditch_id', $id)
            ->join('agents', 'ditch_agent.agent_id', '=', 'agents.id')
            ->join('users', 'agents.user_id', '=', 'users.id')
            ->get();

        //任务图表
        $agent_id = $_GET['agent_id'] ?? "1";
        $year = $yearly ?? date('Y');
        $arr = $this->chart($agent_id,$year, $taskRepository);
        $task_arr = $arr[0];
        $finish_task_arr =$arr[1];

        //佣金设置
        $result =  Product::where('ty_product_id','>=',0)->select('id','product_name')->get();

        return view('backend_v2.channel.channel_agent', compact('agent', 'task_arr', 'finish_task_arr','id','agent_name','result','p_brokerage'));
    }




    //代理人佣金展示
    public function agent_brokerage()
    {
        $p_id = $_GET['p_id'] ?? ""; //接值
        $id = $_GET['id'];
        $p_brokerage = $this->list_brokerage($p_id);
        return view('backend_v2.channel.refresh',compact(['p_brokerage','id']));
    }
    //添加佣金
    public function agent_brokerage_addition()
    {
        $input = $this->request->all();

        $ty_product_id = $input['ty_product_id'][0];
        $man = $input['man'][0];
        $time = date("Y-m-d H:i:s");
        $ratio_for_agency = $input['ratio_for_agency'];
        $rate = $input['brokerage'];

        $arr = array();
        $ress=array();
        foreach($input['ratio_for_agency'] as $key=>$value){
            $arr['rate'] = $input['brokerage'][$key];//输入的佣金
            $arr['ditch_id'] = $input['ditch_id'][$key];
            $arr['by_stages_way'] = $input['by_stages_way'][$key];
            $arr['ty_product_id'] = $ty_product_id;
            $arr['agent_id'] = $man;
            $arr['created_at'] = $time;
            $ress[]=$arr;
            if(empty($arr['rate'])){
                return redirect(url()->previous())->withErrors('请输入全部比例');
            }
            MarketDitchRelation::where(['ditch_id'=>$arr['ditch_id'], 'ty_product_id'=>$arr['ty_product_id'], 'agent_id'=>$arr['agent_id']])->update(['status'=>'off','updated_at'=>$time]);
        }

        $ratio_for_msg="1";
        foreach($rate as $k => $v){
            if($v > $ratio_for_agency[$k]){
                $ratio_for_msg = false;
                return redirect(url()->previous())->withErrors('渠道/代理人比例 不得大于获益佣金比例');
            }
        }
        if($ratio_for_msg){
            MarketDitchRelation::insert($ress);
        }
        return redirect(url()->previous())->with('status', '成功修改佣金设置');

    }





    //活跃产品
    public function channel_active()
    {
        $id = $_GET['id'];
        $active = OrderBrokerage::where('ditch_id',$id)
                ->join('company_brokerage',   'order_brokerage.order_id', '=', 'company_brokerage.ty_product_id')
                ->join('product',   'company_brokerage.ty_product_id', '=', 'product.ty_product_id')
                ->groupBy('product_name')
                ->select(DB::raw("SUM(brokerage) as brokerage,SUM(order_pay) as order_pay,product_name,com_product.id"))
                ->paginate(config('list_num.backend.ditches'));

//       活跃产品de图表    销售额
        $year = $yearly ?? date('Y');
        $sale = OrderBrokerage::where('ditch_id', $id)
            ->where(DB::raw('DATE_FORMAT(created_at, "%Y")'), $year)
            ->groupBy(DB::raw('DATE_FORMAT(created_at, "%m")'))
            ->select(
                DB::raw('sum(order_pay) as sum_money'),
                DB::raw('DATE_FORMAT(created_at, "%m") as month')
            )
            ->get()->toArray();

        $sale_arr = array();
        for($i=0; $i<=11; $i++){
            foreach($sale as $k => $v){
                if((int)$v['month'] - 1 == $i){
                    $sale_arr[$i] = ($v['sum_money'] / 100);
                    break;
                } else{
                    $sale_arr[$i] = 0;
                }
            }
        }

        //产品的佣金
        $active_id = $_GET['active_id'] ?? "1";

        $brokerage = OrderBrokerage::where('ditch_id', $id)
            ->where('order_brokerage.ty_product_id',$active_id)
            ->join('company_brokerage','order_brokerage.order_id', '=', 'company_brokerage.order_id')
            ->where(DB::raw('DATE_FORMAT(com_company_brokerage.created_at, "%Y")'), $year)
            ->groupBy(DB::raw('DATE_FORMAT(com_company_brokerage.created_at, "%m")'))
            ->select(
                DB::raw('sum(brokerage) as order_pay'),
                DB::raw('DATE_FORMAT(com_company_brokerage.created_at, "%m") as month')
            )
            ->get()->toArray();

        $brokerage_arr = array();
        for($i=0; $i<=11; $i++){
            foreach($brokerage as $k => $v){
                if((int)$v['month'] - 1 == $i){
                    $brokerage_arr[$i] = ($v['order_pay'] / 100);
                    break;
                } else{
                    $brokerage_arr[$i] = 0;
                }
            }
        }


        $agent_name = DitchAgent::where(['ditch_id'=>$id,'status'=>'on'])
            ->join('agents','ditch_agent.agent_id','agents.id')
            ->join('users','agents.user_id','users.id')->get();

        $result =  Product::where('ty_product_id','>=',0)->select('id','product_name')->get();
        return view('backend_v2.channel.channel_active',compact('id','active','sale_arr','brokerage_arr','result','agent_name','p_brokerage'));

    }


    //活跃产品佣金展示
    public function active_brokerage()
    {
        $p_id = $_GET['p_id'] ?? ""; //接值
        $id = $_GET['id'];
        $p_brokerage = $this->list_brokerage($p_id);
        return view('backend_v2.channel.refresh',compact(['p_brokerage','id']));
    }


    //渠道任务
    public function channel_task()
    {
        $id = $_GET['id'];
        $year = $yearly ?? date('Y');
        $arr = $this->chart($id,$year);
        $task_arr = $arr[0];
        $finish_task_arr =$arr[1];
        return view('backend_v2.channel.channel_task',compact(['id','task_arr','finish_task_arr']));
    }

    //    封装图表
    public function chart($id,$year, TaskRepository $taskRepository){
        $task_arr = $taskRepository->getShouldDoneData($year, $id);
        $finish_task_arr = $taskRepository->getHaveDoneData($year, $id);
        return [$task_arr,$finish_task_arr];
    }










    /** 1.30  2.30 3.30  4.30  5.30
     * @return mixed
     * 渠道列表
     */
//    public function ditches()
//    {
//        $name = $_GET['name'] ?? "";
//        $ditches = Ditch::where('name', 'like', '%'.$name.'%')->with('agents','task_ditch')
//            ->paginate(config('list_num.backend.ditches'));
//        return view('backend.ditch_agent.ditches',compact(['ditches','name']));
//    }

//    public function deleteDitch($id)
//    {
//        Ditch::where('id', $id)->update(['status' => 'off']);
//        return ['code' => 200, 'data' => '删除成功'];
//    }

    /**
     * @return mixed
     * 添加渠道
     */
    public function addDitchPost()
    {
        //验证
        $this->checkAddDitchPost($this->request);

        try {
            $ditch = new Ditch();
//            $ditch->create_id = Auth::guard('admin')->user()->id;  //创建者的id
            $ditch->name = $this->request->input('name');
            $ditch->display_name = $ditch->name;
            $ditch->address = $this->request->input('address', '');
            $ditch->phone = $this->request->input('phone', '');
            $ditch->group_code = $this->request->input('group_code', '');
            $ditch->credit_code = $this->request->input('create_id', '');
            $ditch->type = $this->request->input('type');
            $ditch->save();
        } catch (\Exception $e) {
            return back()->withErrors('渠道录入失败！');
        }
        return redirect('backend/sell/ditch_agent/ditches')->with('status', '成功录入渠道信息!');
    }

    /**
     * @param $input
     * @return mixed
     * 渠道添加表单验证
     */
    protected function checkAddDitchPost(Request $request)
    {
        //规则
        $rules = [
            'name' => 'required|unique:ditches|max:100'
        ];

        //自定义错误信息
        $messages = [
            'name.required' => '渠道全称不能为空',
            'name.unique' => '渠道全称已存在',
            'name.max' => '渠道全称长度最多为100个字符'
        ];
        //验证
        $this->validate($request, $rules, $messages);
    }

    //渠道管理详情展示页面
//    public function details($id){
//        $name = $_GET['name'] ?? "";
//        $type = $_GET['type'] ?? "";
//        $up_time = $_GET['up_time'] ?? "";
//        $end_time = $_GET['end_time'] ?? "";
//        if(isset($_GET['type']) == "个险"){
//            $type = "1";
//        }else{
//            $type = "2";
//        }



//        $ditch = Ditch::where('id',$id)->first(); //渠道详情
//        $product = DitchAgent::where('ditch_agent.ditch_id',$id)
//            ->where('product_name', 'like', '%'.$name.'%')
//            ->join('warranty_rule','ditch_agent.agent_id','warranty_rule.agent_id')
//            ->join('warranty','warranty.id','warranty_rule.warranty_id')
//            ->join('product','warranty_rule.ty_product_id','product.ty_product_id')
//            ->join('warranty_policy','warranty_rule.policy_id','warranty_policy.id')
//            ->join('agents','warranty_rule.agent_id','agents.id')
//            ->join('users','agents.user_id','users.id')
//            ->join('order_brokerage','warranty_rule.order_id','order_brokerage.order_id')
//            ->paginate(config('list_num.backend.ditches'));
//        return view('backend.ditch_agent.details',compact(['id','ditch','product']));
//    }

    //活跃产品
//    public function active_products($id){
//        $date = date('Y');
//        $time = empty($_GET['time']) ? $date : $_GET['time'];
//        $product = Warranty::where('warranty.created_at', 'like', '%'.$time.'%')
//            ->where("ditch_id",$id)
//            ->join('warranty_rule', 'warranty.id', '=', 'warranty_rule.warranty_id')
//            ->join('product','warranty_rule.ty_product_id', '=', 'product.ty_product_id')
//            ->select(DB::raw("count(product_name) as count,SUM(com_warranty.premium) as premium,product_name,com_product.id"))
//            ->groupBy('product_name')
//            ->orderBy('warranty.created_at', 'desc')
//            ->paginate(config('list_num.backend.ditches'));
//        return view('backend.ditch_agent.active_products',compact(['product','id','time']));
//    }
//
//    //活跃产品详情
//    public function product_details($id){
//        $product_details = Product::where('id',$id)
//            ->paginate(config('list_num.backend.ditches'));
//        return view('backend.ditch_agent.product_details',compact(['product_details','id']));
//    }


    /**
     * @return mixed
     * 代理人列表
     */
    public function agents($id)
    {
        $name = $_GET['name'] ?? "";
        $agents = DB::table('ditch_agent')->where('ditch_id',$id)
                ->where('users.name', 'like', '%'.$name.'%')
                ->join('agents', 'ditch_agent.agent_id', '=', 'agents.id')
                ->join('users', 'agents.user_id', '=', 'users.id')
                ->paginate(config('list_num.backend.ditches'));
        return view('backend.ditch_agent.agents', compact('agents','id','name'));
    }

    public function createAgent()
    {
        $ditches = Ditch::where('status', 'on')->get();

        return view('backend.ditch_agent.create_agent', compact('ditches'));
    }

    /**
     * @return mixed
     * 添加代理人
     */
    public function addAgentPost()
    {
        $this->checkAddAgentPost();

        $input = $this->request->input();
        DB::beginTransaction();
        try{
            //是否已存在该用户
            $user = User::where([ 'phone'=> $input['phone']])->first(); //根据手机号找关联账户

            if ($user) {
                throw new \UnexpectedValueException('手机号已存在');
            }

            $user = new User();
            $user->real_name = $input['real_name'];
            $user->name = $user->real_name;
            $user->email = $input['email'];
            $user->code = '';
            $user->phone = $input['phone'];
            $user->address = '';
            $user->password = '';
            $user->save();

            //是否有关联代理人信息
            if(!$user->agent()->where('create_id', Auth::guard('admin')->user()->id)->first()){
                $agent = new Agent();
                $agent->create_id = Auth::guard('admin')->user()->id;
                $agent->user_id = $user->id;
                $agent->email = $input['email'];
                $agent->job_number = $input['job_number'];
                $agent->area = $input['area'];
                $agent->position = '';
                $agent->phone = $input['phone'];
                $agent->address = '';
                $agent->pending_status = 0;
                $agent->certification_status = 0;
                $agent->work_status = 0;
                $agent->save();
            } else {
                return back()->withErrors('该代理人已存在！');
            }
            DB::commit();
        } catch (\Exception $e){
            DB::rollBack();
            return back()->withErrors($e->getMessage());
        }

        return redirect('backend/sell/ditch_agent/agents')->with('status', '成功录入代理人信息!');
    }

    /**
     * @param $id user表的ID
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function editAgent($id)
    {
        $user = User::with('agent')->where('id', $id)->first();
        $ditches = Ditch::where('status', 'on')->get();

        return view('backend.ditch_agent.edit_agent', compact('user', 'ditches'));
    }

    /**
     * @param $id user表的ID
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function updateAgent($id)
    {
        $input = $this->request->input();
        DB::beginTransaction();
        try{
            //是否已存在该用户
            $user = User::where([ 'phone'=> $input['phone']])->where('id', '!=', $id)->first(); //根据手机号找关联账户
            if ($user) {
                throw new \UnexpectedValueException('手机号已存在');
            }
            $user = User::where('id', $id)->first();
            $user->real_name = $input['real_name'];
            $user->name = $user->real_name;
            $user->email = $input['email'];
            $user->code = '';
            $user->phone = $input['phone'];
            $user->address = '';
            $user->save();

            $agent = $user->agent;
            $agent->create_id = Auth::guard('admin')->user()->id;
            $agent->user_id = $user->id;
            $agent->email = $input['email'];
            $agent->job_number = $input['job_number'];
            $agent->area = $input['area'];
            $agent->position = '';
            $agent->phone = $input['phone'];
            $agent->address = '';
            $agent->save();
            DB::commit();
        }catch (\Exception $e){
            DB::rollBack();
            return back()->withErrors($e->getMessage());
        }

        return redirect('backend/sell/ditch_agent/agents')->with('status', '成功录入代理人信息!');
    }

    /*
     * 代理人添加表单验证
     */
    protected function checkAddAgentPost()
    {
        $rules = [
            'real_name' => 'required|unique:users|max:100',
            'job_number' => 'required',
            'area' => 'required',
            'email' => 'email|required',
//            'phone' => 'required|regex:/^(((d{3}))|(d{3}-))?13d{9}$/'
            'phone' => 'required|size:11',
        ];

        $messages = [
            'real_name.required' => '请输入姓名',
            'real_name.unique' => '用户名已存在',
            'real_name.max' => '用户名字符长度应小于100',
            'name.job_number' => '请输入工号',
            'area.required' => '请输入地区',
            'email.email' => '请输入正确的邮箱格式',
            'email.required' => '请输入邮箱',
            'phone.required' => '请输入手机号码',
            'phone.regex' => '请输入正确的手机号'
        ];

        $this->validate($this->request, $rules, $messages);
    }

    /**
     * @param $card_id
     * @return mixed
     * 是否已存在该用户
     */
    protected function exist_true_user($card_id){
        $user = User::whereHas('trueUserInfo', function($q) use ($card_id) {
            $q->where('card_id', $card_id);
        })->first();
        return $user;
    }

    /**
     * @param $files
     * @return array
     * @throws \Exception
     */
    protected function uploadCardImg($files){
        if(count($files) < 2)
            throw  new \Exception('请上传身份证图片');
        $types = array('jpg', 'jpeg', 'png');
        $image_path = array();
        foreach($files as $k => $v){
            $extension = $v->getClientOriginalExtension();
            if(!in_array($extension, $types)){
                throw  new \Exception('文件类型错误');
            }
            $path = 'upload/backend/user/card_image/' . date("Ymd") .'/';
            //创建目录777权限
            $arr = explode('/', $path);
            $aimDir = '';
            foreach ($arr as $str)
            {
                $aimDir .= $str . '/';
                if (!file_exists(public_path($aimDir))) {
                    mkdir($aimDir);
                    chmod($aimDir, 0777);
                }
            }
            $name = date("YmdHis") . rand(1000, 9999) . '.' . $extension;
            $v->move($path, $name);
            $image_path[] = $path . $name;
        }
        return $image_path;
    }


    public function ditchBindAgent(){
        $ditches = Ditch::all();
        return view('backend.ditch_agent.ditch_bind_agent',compact('ditches'));
    }

    public function ditchFindAgent(){
        $ditches = Ditch::all();
        $agents = Agent::all();
        $ditch_id = $this->request->get('ditch_id');
        //渠道及其已关联的代理人
        $ditch = Ditch::with(['agents'=>function($q){
//            $q->where('permission_id',3);  //渴求式加载
        },'agents.user'])->where('id',$ditch_id)->first();
        //拼接权限ID 数组
        $ditch_agent_ids = array();
        if($ditch && count($ditch->agents)){
            foreach($ditch->agents as $k => $v){
                $ditch_agent_ids[] = $v->id;
            }
        }
        return view('backend.ditch_agent.ditch_bind_agent', compact('ditches', 'agents', 'ditch', 'ditch_agent_ids'));
    }

    public function attachAgents(){
        $input = $this->request->all();
        //验证
        $validator = $this->checkAttachAgentsPost($input);
        if ($validator->fails()) {
            return redirect('backend/sell/ditch_agent/ditch_bind_agent')
                ->withErrors($validator)
                ->withInput();
        }

        $ditch = Ditch::find($input['check_ditch_id']);
        if(empty($input['agent_ids'])){
            $ditch->agents()->detach();
        } else {
            $ditch->agents()->sync($input['agent_ids']);
        }

        return redirect('backend/sell/ditch_agent/ditch_bind_agent')->with('status', '关联成功!');
    }

    protected function checkAttachAgentsPost($input){
        //规则
        $rules = [
            'check_ditch_id' => 'required|integer',
            'agent_ids' => 'array',
        ];

        //自定义错误信息
        $messages = [
            'required' => 'The :attribute is null.',
            'integer' => 'The :attribute mast be integer.',
        ];
        //验证
        $validator = Validator::make($input, $rules, $messages);
        return $validator;
    }



    //佣金管理,默认跳转界面
    public function brokerage()
    {
        //获取所有的产品
        $product_list = Product::where('ty_product_id','>=',0)->paginate(config('list_num.backend.product'));
        $count = count($product_list);
        return view('backend.ditch_agent.brokerage',compact('count','product_list'));
    }


    //搜索产品或id
    public function searchProductById()
    {
        $input = $this->request->all();
        //判断是否有该产品
        $product_id = $input['product_id'];
        $validator = $this->checkProductId($input);
        if ($validator->fails()) {
            return redirect('backend/sell/ditch_agent/brokerage')
                ->withErrors($validator)
                ->withInput();
        }
        $is_product = Product::where('id',$product_id)->first();
        if($is_product){
            return redirect('/backend/sell/ditch_agent/brokerage_detail/'.$product_id);
        }else{
            return back()->withErrors('产品错误');
        }
    }
    //产品详情
    public function brokerageDetail($product_id)
    {
        $product_detail = Product::where('id',$product_id)
            ->first();
        if($product_detail)
        {
            //获取所有的未绑定渠道的代理人的信息,结果返回一个数组
            $no_ditch_array = $this->getNoDitchAgent();
            $data = $this->getAllDitchWithEarningsScaling($product_id,$no_ditch_array);
            $product_detail['brokerage'] = $data['brokerage'];
            $product_detail['scaling'] = $data['scaling'];
            //获取所有渠道及对应的人员信息
            $ditch_agent = $data['ditch_agent'];
            //所有未绑定渠道的人员信息d
            $no_ditch_agent = $data['other_agent'];
            return view('backend.ditch_agent.SetBrokerage',compact('no_ditch_agent','ditch_agent','product_detail','product_id'));
        }else{
            return redirect('/backend/sell/ditch_agent/brokerage')->withErrors('错误');
        }

    }




    //设置佣金
    public function setBrokerage()
    {
        $input = $this->request->all();
        $earnings = $input['earnings']?$input['earnings']:0;
//        $scaling = $input['scaling']?$input['scaling']:0;
//        if(!$earnings&&!$scaling){
        if(!$earnings){
            return back()->withErrors('请设置参数');
        }
        $type = $input['type'];
        $add_array = array();
        //删除原先的佣金，设置新的佣金
        if($type == 'product')
        {
            $add_array['product_id'] = $input['product_id'];
        }else if($type == 'ditch')
        {
            $add_array['product_id'] = $input['product_id'];
            $add_array['ditch_id'] = $input['ditch_id'];
        }else if($type == 'agent')
        {
            $add_array['product_id'] = $input['product_id'];
            $add_array['ditch_id'] = $input['ditch_id'];
            $add_array['agent_id'] = $input['agent_id'];
        }else if($type == 'other')
        {
            $add_array['product_id'] = $input['product_id'];
            $add_array['ditch_id'] = 0;
            $add_array['agent_id'] = $input['agent_id'];
        }
        $add_array['type'] = $type;
        DB::beginTransaction();
        try{
            //删除所有的原先的佣金
            $del_result = $this->delEarnings($type,$input);
            //设置新的佣金,
            $MarketDitchRelation = new MarketDitchRelation();
            $add_earning_array = $add_array;
            $add_earning_array['rate'] = $earnings;
            $earning_result = $this->add($MarketDitchRelation,$add_earning_array);
//            $Scaling = new Scaling();
//            $add_scaling_array = $add_array;
//            $add_scaling_array['rate'] = $scaling;
//            $scaling_result = $this->add($Scaling,$add_scaling_array);
            DB::commit();
            return back()->with('status','设置成功');
        }catch (Exception $e){
            DB::rollBack();
            return back()->withErrors('删除失败');
        }
    }
    //封装一个方法，用来删除原先的佣金设置
    public function delEarnings($type,$array)
    {
        if($type == 'product'){
            $condition = ['product_id'=>$array['product_id']];
        }else if($type == 'ditch'){
            $condition = ['ditch_id'=>$array['ditch_id'],'product_id'=>$array['ditch_id']];
        }else if($type == 'agent'){
            $condition = ['ditch_id'=>$array['ditch_id'],'product_id'=>$array['ditch_id'],'agent_id'=>$array['agent_id']];
        }else if($type == 'other'){
            $agent_id = $array['agent_id'];
            if($agent_id){
                //说明是单个
                $condition = ['product_id'=>$array['product_id'],'type'=>'other','agent_id'=>$array['agent_id']];
            }else{
                //说明是全部
                $condition = ['product_id'=>$array['product_id'],'type'=>'other'];
            }
        }
        $result1 = MarketDitchRelation::where($condition)
            ->delete();
        $result2 = Scaling::where($condition)
            ->delete();
        return $result1&&$result2;
    }
    //封装一个方法，用来获取所有的渠道和渠道对应的代理人以及佣金和折标系数
    public function getAllDitchWithEarningsScaling($product_id,$no_bind_array)
    {
        $no_bind_agent_array = Agent::whereIn('id',$no_bind_array)->with('user')->get();
        $no_bind_agent = array();
        $result_array = array();
        $result_array['brokerage'] = 0;
        $result_array['scaling'] = 0;
        $no_bind_agent['agent'] = $no_bind_agent_array;
        $ditch = Ditch::where('status','on')   //获取所有已经绑定的
            ->with('agents', 'agents.user')
            ->paginate(5);
        //获取所有关于该产品的佣金设置
        $brokerage = MarketDitchRelation::where('product_id',$product_id)
            ->get();
        //获取素有关于该产品的折标系数设置
        $scaling = Scaling::where('product_id',$product_id)
            ->get();
        $brokerage_result = $this->Classify($brokerage,$ditch,$no_bind_agent,'brokerage',$result_array);
        $result = $this->Classify($scaling,$brokerage_result['ditch_agent'],$brokerage_result['other_agent'],'scaling',$brokerage_result);
        return $result;
    }
//封装一个方法，用来对渠道佣金进行分类
    public function Classify($array,$ditch,$no_bind_agent,$type,$result_array)
    {
        foreach($ditch as $value)
        {
            $value[$type] = 0;
        }
        $no_bind_agent[$type] = 0;
        foreach($array as $value1){
            if($value1->type == 'product')
            {
                $result_array[$type] = $value1->rate;
            }else if($value1->type == 'ditch'){
                //说明是对渠道统一的佣金
                foreach($ditch as $ditch_value){
                    if($value1->ditch_id == $ditch_value->id){
                        $ditch_value->$type = $value1->rate;
                        continue;
                    }
                }
            }else if($value1->type == 'agent'){
                //说明是对单个代理人设置的佣金
                foreach($ditch as $ditch_value){
                    if($value1->ditch_id == $ditch_value->id)
                    {
                        //说明没有代理人
                        if(!$ditch_value->agents){
                            continue;
                        }else{
                            foreach($ditch_value->agents as $agent_value)
                            {
                                if($value1->agent_id == $agent_value->id){
                                    $agent_value->$type = $value1->rate;
                                    continue;
                                }
                            }
                        }
                    }
                }
            }else if($value1->type == 'other')
            {
                //其他的佣金，是未绑定渠道的代理人
                if($value1->agent_id == 0)
                {
                    $no_bind_agent[$type] = $value1->rate;
                }else{
                    foreach($no_bind_agent['agent'] as $no_bind_agent_value)
                    {
                        if($no_bind_agent_value->id == $value1->agent_id){
                            $no_bind_agent_value->$type = $value1->rate;
                            continue;
                        }
                    }
                }
            }
        }
        $result_array['other_agent'] = $no_bind_agent;
        $result_array['ditch_agent'] = $ditch;
        return $result_array;
    }


    //封装一个方法，用来获取未绑定渠道的代理人
    public function getNoDitchAgent()
    {
        //获取所有的代理人
        $all_agent = Agent::select('id')->get();
        //获取所有已经绑定的代理人
        $bind_agent = DitchAgent::select('agent_id')->distinct()->get();
        $all_agent_array = array();
        foreach($all_agent as $value){
            array_push($all_agent_array,$value->id);
        }
        $bind_agent_array = array();
        foreach($bind_agent as $value)
        {
            array_push($bind_agent_array,$value->agent_id);
        }
        $no_bind_agent_array = array_diff($all_agent_array,$bind_agent_array);
        return $no_bind_agent_array;
    }

    /**
     * @param $input
     * @return mixed
     * 判断搜索产品表单验证
     */
    protected function checkProductId($input)
    {
        //规则
        $rules = [
            'product_id' => 'required|alpha_num',
        ];

        //自定义错误信息
        $messages = [
            'required' => '产品id错误',
        ];
        //验证
        $validator = Validator::make($input, $rules, $messages);
        return $validator;
    }



}