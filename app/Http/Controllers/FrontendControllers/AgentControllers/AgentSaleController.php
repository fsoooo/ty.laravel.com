<?php

namespace App\Http\Controllers\FrontendControllers\AgentControllers;

use App\Helper\Email;
use App\Helper\RsaSignHelp;
use App\Helper\UploadFileHelper;
use App\Models\Agent;
use App\Models\Authentication;
use App\Models\Comment;
use App\Models\Communication;
use App\Models\Cust;
use App\Models\CustRule;
use App\Models\Ditch;
use App\Models\LiabilityDemand;
use App\Models\MarketDitchRelation;
use App\Models\Messages;
use App\Models\Order;
use App\Models\OrderBrokerage;
use App\Models\PlanLists;
use App\Models\PlanPolicy;
use App\Models\PlanRecognizee;
use App\Models\Product;
use App\Models\Scaling;
use App\Models\Tariff;
use App\Models\Plan;
use App\Models\Task;
use App\Models\TrueFirmInfo;
use App\Models\User;
use App\Models\WarrantyPolicy;
use App\Models\WarrantyRecognizee;
use App\Repositories\TaskRepository;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\Validator;
use Ixudra\Curl\Facades\Curl;
use League\Flysystem\Exception;
use phpDocumentor\Reflection\Types\Scalar;
use Request,DB;
use App\Models\DitchAgent;
use \Illuminate\Http\Request as Requests;
use Validator as Validators;
use App\Models\UserThird;
use App\Repositories\MarketDitchRelationRepository;

class AgentSaleController extends AgentFuncController
{
//    protected $agent_id;
//    public function __construct()
//    {
//        $this->agent_id = $this->checkAgent();
//    }

    protected $_request;
    protected $_signHelp;

    public function __construct(Request $request, MarketDitchRelationRepository $marketDitchRelationRepository)
    {
        $this->_request = $request;
        $this->_signHelp = new RsaSignHelp();
        $this->marketDitchRelationRepository = $marketDitchRelationRepository;
    }
    /**
     * 制作计划书
     */
    public function addPlan(\Illuminate\Http\Request $request)
    {
        $input = $request->all();
//        dd($input);
        $option = 'plan';
        $cust_type = isset($_GET['cust_type'])?$_GET['cust_type'] : 0;
        if(isset($_GET['cust_type'])){
            if($input['cust_type'] == 1){
                switch($input['cust_search_type']){
                    case 1:
                        $where[] = ['users.name','like','%'.$input['cust_content'].'%'];
                        break;
                    case 2:
                        $where[] = ['users.code','like','%'.$input['cust_content'].'%'];
                        break;
                    case 3:
                        $where[] = ['users.phone','like','%'.$input['cust_content'].'%'];
                        break;
                    case 4:
                        $where[] = ['users.email','like','%'.$input['cust_content'].'%'];
                        break;
                }
                $cust = User::whereHas('custRule',function($q){
                    $q->where('from_id',$_COOKIE['agent_id'])
                        ->orWhere(function($query){
                            $query->where('agent_id',$_COOKIE['agent_id']);
                        });
                })
                    ->where($where)
                    ->where('type','user')
                    ->get();
            }else{
                switch($input['cust_search_type']){
                    case 1:
                        $where[] = ['users.name','like','%'.$input['cust_content'].'%'];
                        break;
                    case 2:
                        $where[] = ['users.code','like','%'.$input['cust_content'].'%'];
                        break;
                    case 3:
                        $where[] = ['users.phone','like','%'.$input['cust_content'].'%'];
                        break;
                    case 4:
                        $where[] = ['users.email','like','%'.$input['cust_content'].'%'];
                        break;
                }
                $cust = User::with('trueFirmInfo')
                    ->whereHas('custRule',function($q){
                    $q->where('from_id',$_COOKIE['agent_id'])
                        ->orWhere(function($query){
                            $query->where('agent_id',$_COOKIE['agent_id']);
                        });
                })
                    ->where($where)
                    ->where('type','company')
                    ->get();
            }
        }else{
            $cust = User::where('type','user')
                ->whereHas('custRule',function($q){
                $q->where('from_id',$_COOKIE['agent_id'])
                    ->orWhere(function($query){
                        $query->where('agent_id',$_COOKIE['agent_id']);
                    });
            })
                ->get();
        }
//        dd($cust);
        $count = count($cust);
        $agent_id = $this->checkAgent();//检测是否是代理人
        $ditch_id = $this->getMyDitch($agent_id);//获取渠道
        if(isset($_GET['product_type'])){
            switch($_GET['product_type']){
                case 1:
                    $where[] = ['product.product_name','like','%'.$_GET['product_content'].'%'];
                    break;
                case 2:
                    $where[] = ['product.company_name','like','%'.$_GET['product_content'].'%'];
                    break;
            }
            $market = MarketDitchRelation::where('agent_id', $agent_id)->pluck('ty_product_id');
            $product_list = Product::whereIn('ty_product_id',$market)
                ->where($where)
                ->get();
        }else{
            $product_list = $this->getMyAgentProduct($agent_id);//获取所有的产品列表
        }
//        dd($product_list);
        foreach($product_list as $k=>$v){
            $v['rate'] = $this->marketDitchRelationRepository->getMyAgentBrokerage($v->ty_product_id,$ditch_id,$agent_id);
            $v['premium'] = $v['base_price'];
            foreach(json_decode($v->json,true)['clauses'] as $kk=>$vv){
                if($vv['type'] == 'main')
                {
                    $v['main_name'] = $vv['name'];
                }
            }
        }
        $authentication = $this->isAuthentication($_COOKIE['agent_id']);
        $jurisdiction = Agent::where('id',$_COOKIE['agent_id'])
            ->whereHas('user.user_authentication_person',function($q){
                $q->where('status',2);
            })
            ->first();
        $product_count = count($product_list);
//        dd($product_list);
        if($this->is_mobile()){
            return view('frontend.agents.mobile.add_plan');
        }
//        dd($cust);
        return view('frontend.agents.agent_plan.add_plan',compact('cust','cust_type','count','product_list','product_count','jurisdiction','option','authentication'));
    }
    /**
     * 获取基础费率
     *
     */
    public function getProductPremium($id)
    {
        $biz_content = [
            'ty_product_id' => $id,    //投保产品ID
        ];
        //        dd($biz_content);
        //天眼接口参数封装
        $data = $this->_signHelp->tySign($biz_content);
        //        dd($data);
        //发送请求
        $response = Curl::to(env('TY_API_SERVICE_URL') . '/ins_curl/getapioption')
            ->returnResponseObject()
            ->withData($data)
            ->withTimeout(120)
            ->post();
        $return_data = json_decode($response->content, true);
//        dd($return_data);
        return $return_data['option']['price'];
    }

//    // 计算佣金比
//    /**
//     * @param $product_id
//     * @param $ditch_id
//     * @param $agent_id
//     * @return array
//     */
//    public function getMyAgentBrokerage($product_id, $ditch_id, $agent_id)
//    {
//        $condition = array(
////            'type'=>'agent',
//            'ty_product_id'=>$product_id,
//            'ditch_id'=>$ditch_id,
//            'agent_id'=>$agent_id,
//        );
//        $brokerage = MarketDitchRelation::where($condition)
//            ->first();
//        if(!$brokerage){
//            //进行渠道统一查询
//            $condition = array(
//                'ty_product_id'=>$product_id,
//                'ditch_id'=>$ditch_id,
//                'agent_id'=>0,
//            );
//            $brokerage = MarketDitchRelation::where($condition)
//                ->first();
//            if(!$brokerage){//产品统一查询
//                $condition = array(
////                    'type'=>'product',
//                    'ty_product_id'=>$product_id,
//                );
//                $brokerage = MarketDitchRelation::where($condition)
//                    ->first();
//            }
//        }
//        if($brokerage){
//            $earning = $brokerage->rate;
//        }else{
//            $earning = 0;
//        }
////        $scaling = Scaling::where($condition)
////            ->first();
////        if(!$scaling){
////            //进行渠道统一查询
////            $condition = array(
////                'product_id'=>$product_id,
////                'ditch_id'=>$ditch_id,
////                'agent_id'=>0,
////            );
////            $scaling = Scaling::where($condition)
////                ->first();
////            if(!$scaling){//产品统一查询
////                $condition = array(
////                    'type'=>'product',
////                    'product_id'=>$product_id,
////                );
////                $scaling = Scaling::where($condition)
////                    ->first();
////            }
////        }
////        if($scaling){
////            $scaling = $scaling->rate;
////        }else{
////            $scaling = 0;
////        }
////        dd($earning);
//        return array(
//            'earning'=>$earning,  //佣金比
////            'scaling'=>$scaling   //折标系数
//            'scaling'=>array()   //折标系数
//        );
//    }

    //移动端给企业制作计划书
    public function addPlanCompany()
    {
        return view('frontend.agents.agent_plan.mobile.add_plan_company');
    }

    //给企业制作计划书数据提交
    public function addPlanCompanySubmit(Requests $request)
    {
        $input = $request->all();
//        dd($input);
    }

    /**
     * 添加用户
     * @param \Illuminate\Http\Request $request
     * @return string
     */
    public function addCustSubmit(\Illuminate\Http\Request $request)
    {
        $input = $request->all();
//        dd($input);
            DB::beginTransaction();
            try{
                switch($input['company']){
                    case 1:
                        if($this->checkPhone($input['toubaoren_phone'],'company') || $this->checkCode($input['toubaoren_id_code'],'company') || $this->checkEmail($input['toubaoren_email'],'company')){
                            return "<script>alert('该用户已经存在');history.back();</script>";
                        }
                    break;
                    case 2:
                        if($this->checkPhone($input['toubaoren_phone'],'user') || $this->checkCode($input['toubaoren_id_code'],'user') || $this->checkEmail($input['toubaoren_email'],'user')){
                            return "<script>alert('该用户已经存在');history.back();</script>";
                        }
                }
                //添加到user表
                $user = new User();
                $user->name = $input['toubaoren_name'];
                $user->real_name = $input['toubaoren_name'];
                $user->email = $input['toubaoren_email'];
                $user->phone = $input['toubaoren_phone'];
                $user->code = $input['toubaoren_id_code'];
//                $user->occupation = $input['beibaoren_occupation'];
                $user->type = 'user';
                $user->password = bcrypt('123456');
                $user_res = $user->save();
                //添加到cust_rule表
                $cust_rule = new CustRule();
                $cust_rule->code = $input['toubaoren_id_code'];
                $cust_rule->user_id = $user->id;
                $cust_rule->from_id = $_COOKIE['agent_id'];
                $cust_rule->type = 0;
                $cust_rule->from_type = 0;
                $cust_rule->status = 0;
                $cust_rule_res = $cust_rule->save();
                DB::commit();
                return "<script>alert('该用户添加成功');location.href = '/agent_sale/add_plan'</script>";
            }catch (Exception $e){
                DB::rollBack();
                return "<script>alert('信息录入失败，请确认信息是否正确');location.href = '/agent_sale/add_plan'</script>";
            }
    }

    /**
     * 生成计划书提交
     */
    public function addPlanSubmit(\Illuminate\Http\Request $request)
    {
        $input = $request->all();
//        dd($input);
        $dith_id = Agent::with('ditches')
            ->where('id',$_COOKIE['agent_id'])
            ->first();
        $dith_id = $dith_id->ditches[0]['id'];
//        $url = url('')
        DB::beginTransaction();
        try{
            $plan_lists = new PlanLists();
            $plan_lists->name = $input['planName'];
            $plan_lists->plan_recognizee_id = $input['user'];//users表的id
            $plan_lists->ty_product_id = $input['product'];
            if(!empty($input['selling'])){
                $plan_lists->selling = json_encode($input['selling']);
            }
            $plan_lists->status = 0;
            $plan_lists->agent_id = $_COOKIE['agent_id'];
            $plan_lists_res = $plan_lists->save();
            $url = url('/ins/ins_info/'.$input['product'].'?agent_id='.$_COOKIE['agent_id'].'&plan_id='.$plan_lists->id.'&ditch_id='.$dith_id);
            $plan_list_data = PlanLists::find($plan_lists->id);
            $plan_list_data->url = $url;
            $plan_list_data_res = $plan_list_data->save();
            if($plan_lists_res && $plan_list_data_res)
            {
                DB::commit();
                if(isset($input['mobile']) && $input['mobile'] == 1){
                    return "<script>location.href = '/agent_sale/plan_detail/".$plan_lists->id."';</script>";
                }

                return "<script>location.href = '/agent_sale/plan_detail/".$plan_lists->id."';</script>";
            }
        }catch (Exception $e){
            DB::rollBack();
            return "<script>alert('信息录入失败，请确认信息是否正确');history.back();</script>";
        }
    }

    /**
     * 代理人计划书列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function planLists()
    {
        $option = 'plan';
        $agent_id = $this->checkAgent();//检测是否是代理人
        $ditch_id = $this->getMyDitch($agent_id);//获取渠道
        if(isset($_GET['search']) && $this->is_mobile()) {
            $lists = DB::table('plan_lists')
                ->join('users', 'users.id', 'plan_lists.plan_recognizee_id')
                ->join('product','product.ty_product_id','plan_lists.ty_product_id')
                ->where('plan_lists.agent_id', $_COOKIE['agent_id'])
                ->where('plan_lists.name', 'like', '%' . $_GET['search'] . '%')
                ->select('product.base_price','plan_lists.name as plan_name', 'plan_lists.id as lists_id', 'plan_lists.created_at as plan_created_at', 'plan_lists.ty_product_id', 'plan_lists.send_time', 'plan_lists.status as plan_status', 'users.*')
                ->get();
        }elseif($this->is_mobile()){
            $lists = DB::table('plan_lists')
                ->join('users','users.id','plan_lists.plan_recognizee_id')
                ->join('product','product.ty_product_id','plan_lists.ty_product_id')
                ->where('plan_lists.agent_id',$_COOKIE['agent_id'])
                ->select('product.base_price','plan_lists.name as plan_name','plan_lists.id as lists_id','plan_lists.created_at as plan_created_at','plan_lists.ty_product_id','plan_lists.send_time','plan_lists.status as plan_status','users.*')
                ->get();
        }else{
            $lists = DB::table('plan_lists')
                ->join('users','users.id','plan_lists.plan_recognizee_id')
                ->join('product','product.ty_product_id','plan_lists.ty_product_id')
                ->where('plan_lists.agent_id',$_COOKIE['agent_id'])
                ->select('product.base_price','plan_lists.name as plan_name','plan_lists.id as lists_id','plan_lists.created_at as plan_created_at','plan_lists.ty_product_id','plan_lists.send_time','plan_lists.status as plan_status','users.*')
                ->paginate(config('list_num.frontend.plan_lists'));
        }
        foreach($lists as $k=>$v){
            $v->premium = $v->base_price;
            $v->age = date('Y',time())-substr($v->code,6,4);
            $v->rate = $this->marketDitchRelationRepository->getMyAgentBrokerage($v->ty_product_id,$this->getMyDitch($_COOKIE['agent_id']),$_COOKIE['agent_id']);
            $v->json = json_decode(Product::where('ty_product_id',$v->ty_product_id)->first()['json'],true);
        }
        $lists_count = count($lists);
        $authentication = $this->isAuthentication($_COOKIE['agent_id']);
        if($this->is_mobile()){
            return view('frontend.agents.agent_plan.mobile.plan_list',compact('lists_count','lists','authentication'));
        }
        return view('frontend.agents.agent_plan.plan_lists',compact('lists_count','lists','option','authentication'));
    }

    //移动端代理人订单
    public function agentOrder()
    {
        $agent_id = $this->checkAgent();//检测是否是代理人
        $ditch_id = $this->getMyDitch($agent_id);//获取渠道
        if(isset($_GET['search'])){
            $lists = DB::table('plan_lists')
                ->join('order','order.agent_id','plan_lists.agent_id')
                ->join('users','users.id','plan_lists.plan_recognizee_id')
                ->where([
                    ['plan_lists.agent_id',$_COOKIE['agent_id']],
                    ['order.status',1]
                ])
                ->where('plan_lists.name','like','%'.$_GET['search'].'%')
                ->select('plan_lists.name as plan_name','plan_lists.id as lists_id','plan_lists.created_at as plan_created_at','plan_lists.ty_product_id','plan_lists.send_time','plan_lists.status as plan_status','users.*')
                ->get();
        }else{
            $lists = PlanLists::where('agent_id',$_COOKIE['agent_id'])
                ->with('order.order_user','order.warranty_recognizee')
                ->whereHas('order',function($q){
                    $q->where('status',1);
                })->get();
        }
        foreach($lists as $k=>$v){
            $v->premium = $this->getProductPremium($v->ty_product_id);
            $v->age = date('Y',time())-substr($v->code,6,4);
            $v->rate = $this->marketDitchRelationRepository->getMyAgentBrokerage($v->ty_product_id,$this->getMyDitch($_COOKIE['agent_id']),$_COOKIE['agent_id']);
            $v->json = json_decode(Product::where('ty_product_id',$v->ty_product_id)->first()['json'],true);
        }
//        dd($lists);
        $lists_count = count($lists);
        return view('frontend.agents.mobile.agent_order',compact('lists_count','lists','authentication'));
    }

    //移动端代理人查看客户订单详情
    public function custOrderDetail($id)
    {
        $data = Order::where('id',$id)
            ->with('order_user','warranty_rule.warranty','product','warranty_recognizee','warranty_rule.policy')
            ->first();
        $data->product['clauses'] = json_decode($data->product['clauses'],true);
        $data->product['json'] = json_decode($data->product['json'],true);
        $data->clauses = json_decode($this->getClause($data->product['ty_product_id'])->content,true);
//        dd($data);
        if($data->order_user['type'] == 'user'){
            return view('frontend.agents.mobile.cust_order_detail',compact('data'));
        }else{
            return view('frontend.agents.mobile.cust_order_detail_company',compact('data'));
        }
    }

    //移动端计划书查看详情
    public function planDetailOther($id)
    {
        $data = PlanLists::where('id',$id)
            ->with('product','user.trueFirmInfo','order.warranty_recognizee','order.warranty_rule.warranty','order.warranty_rule.policy')
            ->first();
        $data->rate = $this->marketDitchRelationRepository->getMyAgentBrokerage($data->ty_product_id,$this->getMyDitch($_COOKIE['agent_id']),$_COOKIE['agent_id']);
//        dd($data);
        return view('frontend.agents.agent_plan.mobile.plan_detail_other',compact('data'));
    }

    //转化的计划书
    public function planChange()
    {
        $option = 'plan';
        $agent_id = $this->checkAgent();//检测是否是代理人
        $ditch_id = $this->getMyDitch($agent_id);//获取渠道
        $lists = DB::table('plan_lists')
            ->join('users','users.id','plan_lists.plan_recognizee_id')
            ->join('order','order.plan_id','plan_lists.id')
            ->where('plan_lists.agent_id',$_COOKIE['agent_id'])
            ->where('order.status',1)
            ->select('plan_lists.name as plan_name','plan_lists.send_time','plan_lists.id as lists_id','plan_lists.ty_product_id','plan_lists.status as plan_status','users.*','plan_lists.created_at as plan_created_at')
            ->paginate(config('list_num.frontend.plan_lists'));
        foreach($lists as $k=>$v){
            $v->premium = $this->getProductPremium($v->ty_product_id);
            $v->age = date('Y',time())-substr($v->code,6,4);
        }
        $lists_count = count($lists);
//        dd($lists);
        $authentication = $this->isAuthentication($_COOKIE['agent_id']);
        return view('frontend.agents.agent_plan.plan_change',compact('lists_count','lists','option','authentication'));
    }

    /**
     * 计划书详情
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function planDetail($id)
    {
        $plan_lists_id = $id;
        $option = 'plan';
        $agent_id = $this->checkAgent();//检测是否是代理人
        //计划书详情
        $detail = DB::table('plan_lists')
            ->join('users','plan_lists.plan_recognizee_id','users.id')
            ->where('plan_lists.id',$id)
            ->select('plan_lists.name as plan_name','plan_lists.status as plan_status','plan_lists.*','users.name as user_name','users.*')
            ->first();
//        dd($detail);
        //产品信息
        $product = DB::table('product')
            ->where('ty_product_id',$detail->ty_product_id)
            ->first();
//        dd($product);
        $detail->product_name = $product->product_name;//产品名称
        $detail->premium = $product->base_price;//产品保费
        $product->json = json_decode($product->json,true);
        //获取产品的条款
        $biz_content = [
            'ty_product_id' => $detail->ty_product_id,    //投保产品ID
        ];
        //天眼接口参数封装
        $data = $this->_signHelp->tySign($biz_content);
//        dd($data);
        //发送请求
        $response = Curl::to(env('TY_API_SERVICE_URL') . '/ins_curl/getapioption')
            ->returnResponseObject()
            ->withData($data)
            ->withTimeout(120)
            ->post();
        $return_data = json_decode($response->content, true);
        $detail->protect_items = $return_data['option']['protect_items'];
        $detail->age = date('Y',time())-substr($detail->code,6,4);
        //代理人信息
        $agent_detail = DB::table('agents')
            ->join('users','agents.user_id','users.id')
            ->select('users.*')
            ->first();
        $selling = explode(',',$detail->selling);
        $arr = array();
        $temporary = array();
        $res = array();
        foreach( $selling as $v){
            $arr[] = str_replace('"','',$v);
        }
        foreach($arr as $v){
            $temporary[] = str_replace("[",'',$v);
        }
        foreach($temporary as $v){
            $res[] = str_replace("]",'',$v);
        }
        $authentication = $this->isAuthentication($_COOKIE['agent_id']);
        if($this->is_mobile()){
            return view('frontend.agents.mobile.plan_agent',compact('detail','agent_detail','option','plan_lists_id','res','authentication','product'));
        }
        return view('frontend.agents.agent_plan.plan_detail',compact('detail','agent_detail','option','plan_lists_id','authentication','product'));
    }

    /**
     * 计划书说明
     * @param $id
     */
    public function planProspectus($id)
    {
        $ditch_id = $this->getMyDitch($_COOKIE['agent_id']);
        $option = 'plan';
        $agent_id = $this->checkAgent();//检测是否是代理人
        $detail = DB::table('plan_lists')
            ->join('users','plan_lists.plan_recognizee_id','users.id')
            ->where('plan_lists.id',$id)
            ->select('plan_lists.name as plan_name','users.email as user_email','users.phone as user_phone','plan_lists.id as lists_id','plan_lists.status as plan_status','plan_lists.*','users.name as user_name','users.*','plan_lists.created_at as plan_time')
            ->first();
//        dd($detail);
        //产品信息
        $product = DB::table('product')
            ->where('ty_product_id',$detail->ty_product_id)
            ->first();
        $detail->product_name = $product->product_name;//产品名称
        $detail->premium = $product->base_price;//产品保费
        //获取产品的条款
        $biz_content = [
            'ty_product_id' => $detail->ty_product_id,    //投保产品ID
        ];
        //天眼接口参数封装
        $data = $this->_signHelp->tySign($biz_content);
        //发送请求
        $response = Curl::to(env('TY_API_SERVICE_URL') . '/ins_curl/getapioption')
            ->returnResponseObject()
            ->withData($data)
            ->withTimeout(120)
            ->post();
        $return_data = json_decode($response->content, true);
//        dd($product);
        $detail->protect_items = $return_data['option']['protect_items'];
//        dd($detail);
        $detail->age = date('Y',time())-substr($detail->code,6,4);
        $prodcut_id = DB::table('plan_lists')
            ->join('product','plan_lists.ty_product_id','product.ty_product_id')
            ->where('plan_lists.id',$id)
            ->select('product.ty_product_id')
            ->first();
        $order_data = DB::table('order')
            ->join('plan_lists','order.plan_id','plan_lists.id')
            ->join('warranty_recognizee','order.id','warranty_recognizee.order_id')
            ->join('users','users.id','order.user_id')
            ->where('plan_lists.id',$id)
            ->where('order.status',1)
            ->select('order.created_at as order_time','order.*','users.name as user_name','users.*','warranty_recognizee.relation')
            ->first();
        $count_order = count($order_data);
        $detail->rate = $this->marketDitchRelationRepository->getMyAgentBrokerage($prodcut_id->ty_product_id,$ditch_id,$agent_id);
//        dd($detail);
        $authentication = $this->isAuthentication($_COOKIE['agent_id']);
        return view('frontend.agents.agent_plan.plan_prospectus',compact('detail','option','count_order','order_data','return_data','authentication'));
    }

    public function getProduct()
    {
        $agent_id = $this->checkAgent();
        //获取所有的产品列表
        $product_list = $this->getMyAgentProduct($agent_id);
        $count = count($product_list);

        return view('frontend.agents.agent_sale.ProductList',compact('product_list','count'));
    }

    //生成自己的网站
    public function createUrl($product_id)
    {

        $product = Product::where('id',$product_id)->first();
        $ditch = Ditch::get();
        return view('frontend.agents.agent_sale.CreateUrl',compact('product','ditch'));
    }

    //生成网址的submit
    public function createUrlSubmit()
    {
        $agent_id = $this->checkAgent();
        $input = Request::all();
        $ditch_id = $input['ditch_id']?$input['ditch_id']:0;
        $sole_code = $input['product_id'].','.$ditch_id.','.$agent_id;
        $sell_code = base64_encode($sole_code);
        $result =url('/productinfo?product_id='.$input['product_id'].'&sole_code='.$sell_code);
        echo returnJson('200',$result);
    }


    //获取产品的详细信息
    public function getProductDetail($product_id)
    {
        //判断是否是自己的产品
        $result = $this->isMyProduct($product_id);
        if($result){
            //说明可以进行销售,1,查找产品的详细信息，获取产品的所有渠道
//            $ditches = $this->getDitchByProduct($product_id);
            $product_detail = Product::where('id',$product_id)
                ->with('product_label')
                ->first();
            return view('frontend.agents.agent_sale.ProductDetail',compact('product_detail'));
        }else{
            return back()->withErrors('非法操作');
        }
    }


    //跳转到计划书界面
    public function plan()
    {
        $agent_id = $this->checkAgent();
        $plan_list = Plan::where('agent_id',$agent_id)
            ->with('product')
            ->paginate(10);
        $count  = count($plan_list);
        return view('frontend.agents.agent_sale.CreatePlan',compact('count','plan_list'));
    }
    //跳转到生成计划书界面
    public function createPlan($product_id)
    {
//        $agent_id = $this->checkAgent();
//        $product_detail = Product::where('id',$product_id)->where('delete_id', '0')->first();
//
//        $ditch_list = DitchAgent::where('agent_id',$agent_id)
//            ->with('ditch')->get();
//        $ditch_count = count($ditch_list);
//        $json = $product_detail['json'];
//        $clauses = $product_detail['clauses'];
//        $json = json_decode($json, true);
//        $clauses = json_decode($clauses, true);//条款关联的责任与费率
////        dump($clauses);
//        $clauses_ids = [];
//        $clauses_min_m = [];
//        foreach ($clauses as $v){
//            $clauses_ids[] = $v['id'];
//            $clauses_min_m[] = $v['min_m'];
//        }
//        $tari_arr = config('tariff_parameter');//费率注释
//        $tariffs = Tariff::wherein('clause_id',$clauses_ids)->get();//所有费率
//        $b = [];
//        $a = [];
//        foreach ($tariffs as $value) {
//            foreach ($tari_arr as $k=>$v){
//                $a[$k] = $value[$k];
//            }
//            $b[] = $a;
//        }
//        $vs = [];
//        foreach ($tari_arr as $key=>$v){
//            $k = '$'.$key ;
//            $k = [];
//            foreach ($b as $value){
//                if($value[$key]<>"#"||$value[$key]<>null){
//                    $k[] = $value[$key];
//                }
//
//            }
//            $k = array_unique($k);
//            $ke[$v]=[$key=>$k];
//        }
//
//        if(!empty($ke['费率']['tariff'])){
//            rsort($ke['费率']['tariff'], SORT_NUMERIC);
//            $tari = array_pop($ke['费率']['tariff']);
//        }
//        unset($ke['费率']);
//        unset($ke['状态']);
//        unset($ke['关联条款']);
//        unset($ke['源文件名']);
//        unset($ke['新文件名']);
//        $clauses = $json['clauses'];
//        return view('frontend.agents.agent_sale.PlanIndex',compact('ditch_list','ditch_count'))
//            ->with('product_detail',$product_detail)
//            ->with('ke',$ke)
//            ->with('clau',$clauses)
//            ->with('taris', $tari)
//            ->with('clauses',$clauses_ids);
        return view('frontend.guests.product.proinfo');
    }

    //计划书表单提交页面
    public function planSubmit()
    {
        $input = Request::all();
        $agent_id = $this->checkAgent();

        $plan_name = $input['plan_name'];
        $product_id = $input['product_id'];
        $ditch_id = $input['ditch_id'];

        $main = array();  //主险
        $attach = array();  //附加险

        foreach($input as $key=>$value)
        {
            $main_pos = stripos($key,'main');
            $attach_pos = stripos($key,'attach');
            if(is_integer($main_pos)&&$main_pos == 0){//添加主险
                $main_array = array(
                    $value=>$input['money_'.$value]
                );
                array_push($main,$main_array);
            }

            if(is_integer($attach_pos)&&$attach_pos == 0){//添加附加险
                $attach_array = array(
                    $value=>$input['money_'.$value]
                );
                array_push($main,$attach_array);
            }
        }
        $main_json = json_encode($main);
        $attach_json = json_encode($attach);


        unset($input['product_id']);
        unset($input['plan_name']);
        unset($input['ditch_id']);
        unset($input['_token']);
         DB::beginTransaction();
        try{
            $Plan = new Plan();
            $parameter = json_encode($input);
            $plan_array = array(
                'plan_name'=>$plan_name,
                'product_id'=>$product_id,
                'type'=>0,
                'parent_id'=>0,
                'ditch_id'=>$ditch_id,
                'agent_id'=>$agent_id,
                'main_clause'=>$main_json,
                'attach_clause'=>$attach_json,
                'parameter'=>$parameter,
            );
            $plan_id = $this->add($Plan,$plan_array);
            //生成唯一标识
            $sole_code_array = array(
                $product_id,$ditch_id,$agent_id,$plan_id,
            );
            $sole_code = base64_encode(json_encode($sole_code_array));
            $url = url('/productinfo?product_id=1&plan='.$sole_code);
            $Plan = Plan::find($plan_id);
            $Plan->sole_code = $sole_code;
            $Plan->url = $url;
            $result = $Plan->save();
            if($plan_id&&$result){
                DB::commit();
                return redirect('/agent_sale/plan')->with('status','添加成功');
            }else{
                DB::rollBack();
                return back()->withErrors('添加失败');
            }
        }catch (Exception $e){
            DB::rollBack();
            return back()->withErrors('添加失败');
        }
    }

    /**
     * 发送计划书
     */
    public function sendUrl(\Illuminate\Http\Request $request)
    {
        $input = $request->all();
        $title = "专属您的保险计划书";
        $mail = new Email();
        $mail->setServer("smtp.exmail.qq.com", "galaxy@mengtiancai.com", "Shiqu521"); //设置smtp服务器
        $mail->setFrom("galaxy@mengtiancai.com"); //设置发件人
        $mail->setReceiver($input['data']);
        $mail->setMailInfo($title,$input['url']);// 设置邮件主题、内容
        $success =  $mail->sendMail(); //发送
        if($success){
            $res = PlanLists::where('id',$input['id'])
                ->update(['send_time'=>time(),'status'=>1]);
            return ['status'=>200,'msg'=>'发送成功'];
        }else{
            return ['status'=>400,'msg'=>'发送失败'];
        }
    }



    /**
     * 代理人佣金
     */
    public function agentCommissioin(Requests $request,TaskRepository $task)
    {
        $option = 'commission';
        $input = $request->all();
//        查询
        if($input){
            switch(isset($input['search'])){
                case 1:
                    $data = Order::with(['warranty_rule','product','order_user','order_agent','warranty_recognizee','order_brokerage','order_parameter'])
                        ->where(['agent_id'=>$_COOKIE['agent_id'],'status'=>1])
                        ->whereBetween('created_at',[date('Y-m-d H:i:s',time()-7776000),date('Y-m-d H:i:s',time())])
                        ->paginate(config('list_num.frontend.agent_performance'));
                    break;
                case 2:
                    $data = Order::with(['warranty_rule','product','order_user','order_agent','warranty_recognizee','order_brokerage','order_parameter'])
                        ->where(['agent_id'=>$_COOKIE['agent_id'],'status'=>1])
                        ->whereBetween('created_at',[date('Y-m-d H:i:s',time()-12960000),date('Y-m-d H:i:s',time())])
                        ->paginate(config('list_num.frontend.agent_performance'));
                    break;
                case 3:
                    $data = Order::with(['warranty_rule','product','order_user','order_agent','warranty_recognizee','order_brokerage','order_parameter'])
                        ->where(['agent_id'=>$_COOKIE['agent_id'],'status'=>1])
                        ->whereBetween('created_at',[date('Y-m-d H:i:s',time()-31536000),date('Y-m-d H:i:s',time())])
                        ->paginate(config('list_num.frontend.agent_performance'));
                    break;
                default :
                    $data = Order::with(['warranty_rule','product','order_user','order_agent','warranty_recognizee','order_brokerage','order_parameter'])
                        ->where(['agent_id'=>$_COOKIE['agent_id'],'status'=>1])
                        ->paginate(config('list_num.frontend.agent_performance'));
                    break;
            }
        }else{
            $data = Order::with('warranty_rule','product','order_user','order_agent','warranty_recognizee','order_brokerage','order_parameter')
                ->where(['agent_id'=>$_COOKIE['agent_id'],'status'=>1])
                ->paginate(config('list_num.frontend.agent_performance'));
        }
        foreach($data as $value){
            $value['product']['jsons'] = json_decode($value['product']['json'],true);
        }
        //任务
        $agent_task = $task->getShouldDoneData(date('Y',time()),$this->getMyDitch($_COOKIE['agent_id']),$_COOKIE['agent_id']);
//        dd($agent_task);
        //佣金
        $brokerage = OrderBrokerage::where('agent_id',$_COOKIE['agent_id'])
            ->groupBy(DB::raw('DATE_FORMAT(created_at, "%m")'))
            ->select(
                DB::raw('sum(user_earnings) as sum_earnings,Sum(order_pay) as pay'),
                DB::raw('DATE_FORMAT(created_at, "%m") as month')
            )
            ->get();
//        dd($brokerage);
        $final_data = [];
        foreach($agent_task as $key=>$val){
            foreach($brokerage as $k=>$v){
                if($v['month'] == $key+1){
                    $final_data['month'][] = $v['month'];
                    $final_data['sum_earnings'][] = $v['sum_earnings'];
                    $final_data['pay'][] = $v['pay'];
                    $final_data['task'][] = $val;
                }else{
                    $final_data['month'][] = 0;
                    $final_data['sum_earnings'][] = 0;
                    $final_data['pay'][] = 0;
                    $final_data['task'][] = $val;
                }
            }
        }
//        dd($final_data);
        $count = count($data);
        $authentication = $this->isAuthentication($_COOKIE['agent_id']);
        return view('frontend.agents.agent_plan.prospectus',compact('option','final_data','data','count','money_res','month_res','brokerage','authentication','agent_task'));
    }

    //获取产品信息
    public function productDetail($id)
    {
        //产品信息
        $product = DB::table('product')
            ->where('ty_product_id',$id)
            ->first();
        //获取产品的条款
        $biz_content = [
            'ty_product_id' => $id,    //投保产品ID
        ];
        //天眼接口参数封装
        $data = $this->_signHelp->tySign($biz_content);
        //发送请求
        $response = Curl::to(env('TY_API_SERVICE_URL') . '/ins_curl/getapioption')
            ->returnResponseObject()
            ->withData($data)
            ->withTimeout(120)
            ->post();
        $return_data = json_decode($response->content, true);
        $return_data['product'] = $product;
        return $return_data;
    }

    /**
     * 移动端客户列表
     */
    public function searchClient()
    {
        $cust = User::whereHas('custRule',function($q){
            $q->where('from_id',$_COOKIE['agent_id'])
                ->orWhere('agent_id',$_COOKIE['agent_id']);
        })
            ->get();
//        dd($cust);
        $count = count($cust);
        return view('frontend.agents.mobile.search_client',compact('count','cust'));
    }

    //客户信息
    public function custDetail($id)
    {
        $data = User::where('id',$id)
            ->first();
        if($data['code']){
            $data['age'] = date('Y',time()) - substr($data['code'],6,4);
            if(substr($data['code'],16,1)%2 == 0){
                $data['sex'] = '女';
            }else{
                $data['sex'] = '男';
            }
        }
        $data = json_encode($data);
//        dd($data);
        return $data;
    }

    //产品列表移动端
    public function searchProduct()
    {
        $agent_id = $_COOKIE['agent_id'];
        $product_list = $this->getMyAgentProduct($agent_id);//获取所有的产品列表
        foreach($product_list as $k=>$v){
            $v['rate'] = $this->marketDitchRelationRepository->getMyAgentBrokerage($v->id,0,$agent_id);
            $v['premium'] = $this->getProductPremium($v->ty_product_id);
            foreach(json_decode($v->json,true)['clauses'] as $kk=>$vv){
                if($vv['type'] == 'main')
                {
                    $v['main_name'] = $vv['name'];
                }
            }
        }
//        dd($product_list);
        $product_count = count($product_list);
        return view('frontend.agents.mobile.search_product',compact('product_list','product_count'));
    }

    //移动端产品详情
    public function agentProductDetail($id)
    {
        //产品信息
        $product = DB::table('product')
            ->where('ty_product_id',$id)
            ->first();
        $product->price = $this->getProductPremium($id)/100;
        $product->json = json_decode($product->json,true);
        $data = json_encode($product);
        return $data;
    }

    //移动端添加客户
    public function makeAdd()
    {

        return view('frontend.agents.mobile.add_cust');
    }

    //添加被保人不是本人
    public function makeAddOther()
    {
        return view('frontend.agents.mobile.add_cust_other');
    }

    //移动端制作计划书投保人 被保人不是同一人
    public function makeAddOtherSubmit(Requests $request)
    {
        $input = $request->all();
//        dd($input);
        $ditch_id = $this->getMyDitch($_COOKIE['agent_id']);
        DB::beginTransaction();
        try{
            //录入user表
            if($this->checkPhone($input['toubaoren_phone'],'user') || $this->checkEmail($input['toubaoren_email'],'user')){

            }else{
                //录入的用户表
                $user_toubaoren = new User();
                $user_toubaoren->name = $input['toubaoren_name'];
                $user_toubaoren->real_name = $input['toubaoren_name'];
                $user_toubaoren->email = $input['toubaoren_email'];
                $user_toubaoren->phone = $input['toubaoren_phone'];
                $user_toubaoren->type = 'user';
                $user_toubaoren->password = bcrypt('123456');
                $user_toubaoren->save();
                //插入到关系表
                $cust_rule = new CustRule();
//                $cust_rule->code = $input['id_code'];
                $cust_rule->user_id = $user_toubaoren->id;
                $cust_rule->from_id = $_COOKIE['agent_id'];
                $cust_rule->type = 0;
                $cust_rule->from_type = 0;
                $cust_rule->status = 0;
                $cust_rule->save();
            }
            if($this->checkCode($input['beibaoren_code'],'user') || $this->checkPhone($input['beibaoren_phone'],'user') || $this->checkEmail($input['beibaoren_email'],'user')){
                $user_id = User::where('phone',$input['beibaoren_phone'])
                    ->pluck('id')->first();
                if(!$user_id){
                    $user_id = User::where('code',$input['beibaoren_code'])
                        ->pluck('id')->first();
                }else{
                    $user_id = User::where('email',$input['beibaoren_email'])
                        ->pluck('id')->first();
                }
                //录入计划书表
                $plan = new PlanLists();
                $plan->plan_recognizee_id = $user_id;
                $plan->name = $input['planName'];
                $plan->ty_product_id = $input['ty_product_id'];
                $plan->selling = json_encode($input['selling']);
                $plan->status = 0;
                $plan_res = $plan->save();
                $url = url('/ins/ins_info/'.$input['ty_product_id'].'?agent_id='.$_COOKIE['agent_id'].'&ditch_id='.$ditch_id.'&plan_id='.$plan->id);
                $updatePlan = PlanLists::where('id',$plan->id)
                    ->update(['url'=>$url]);
            }else{
                $user = new User();
                $user->name = $input['beibaoren_name'];
                $user->real_name = $input['beibaoren_name'];
                $user->email = $input['beibaoren_email'];
                $user->code = $input['beibaoren_code'];
                $user->phone = $input['beibaoren_phone'];
                $user->type = 'user';
                $user->password = bcrypt('123456');
                $user->save();
                //插入到关系表
                $cust_rule = new CustRule();
                $cust_rule->code = $input['beibaoren_code'];
                $cust_rule->user_id = $user->id;
                $cust_rule->from_id = $_COOKIE['agent_id'];
                $cust_rule->type = 0;
                $cust_rule->from_type = 0;
                $cust_rule->status = 0;
                $cust_rule->save();
                //录入计划书表
                $plan = new PlanLists();
                $plan->plan_recognizee_id = $user->id;
                $plan->name = $input['planName'];
                $plan->ty_product_id = $input['ty_product_id'];
                $plan->agent_id = $_COOKIE['agent_id'];
                if(!is_null($input['selling'])){
                    $plan->selling = json_encode($input['selling']);
                }
                $plan->status = 0;
                $plan_res = $plan->save();
                $url = url('/ins/ins_info/'.$input['product'].'?agent_id='.$_COOKIE['agent_id'].'&ditch_id='.$ditch_id.'&plan_id='.$plan->id);
                $updatePlan = PlanLists::where('id',$plan->id)
                    ->update(['url'=>$url]);
            }
            DB::commit();
            return "<script>alert('信息录入成功');location.href = '/agent_sale/plan_detail/".$plan->id."';</script>";
        }catch (Exception $e){
            DB::rollBack();
            return "<script>alert('信息录入失败，请确认信息是否正确');history.back();</script>";
        }


    }

    //移动端添加客户提交
    public function custAddSubmit(Requests $request)
    {
        $input = $request->all();
        if($this->checkCode($input['id_code'],'user') || $this->checkPhone($input['phone'],'user') || $this->checkEmail($input['email'],'user')){
            return "<script>alert('该用户已经被添加过了!');history.back();</script>";
        }
        $ditch_id = $this->getMyDitch($_COOKIE['agent_id']);
//        dd($input);
        DB::beginTransaction();
        try{
            //录入user表
            $user = new User();
            $user->name = $input['name'];
            $user->real_name = $input['name'];
            $user->email = $input['email'];
            $user->phone = $input['phone'];
            $user->code = $input['id_code'];
            $user->occupation = $input['occupation'];
            $user->type = 'user';
            $user->password = bcrypt('123456');
            $user->save();
            //插入到关系表
            $cust_rule = new CustRule();
            $cust_rule->code = $input['id_code'];
            $cust_rule->user_id = $user->id;
            $cust_rule->from_id = $_COOKIE['agent_id'];
            $cust_rule->type = 0;
            $cust_rule->from_type = 0;
            $cust_rule->status = 0;
            $cust_rule->save();

            //录入计划书表
            $plan = new PlanLists();
            $plan->plan_recognizee_id = $user->id;
            $plan->name = $input['planName'];
            $plan->ty_product_id = $input['product'];
            $plan->agent_id = $_COOKIE['agent_id'];
            if(!is_null($input['selling'])){
                $plan->selling = json_encode($input['selling']);
            }
            $plan->status = 0;
            $plan_res = $plan->save();
            $url = url('/ins/ins_info/'.$input['product'].'?agent_id='.$_COOKIE['agent_id'].'&ditch_id='.$ditch_id.'&plan_id='.$plan->id);
            $updatePlan = PlanLists::where('id',$plan->id)
                ->update(['url'=>$url]);
            DB::commit();
            return "<script>alert('信息录入成功');location.href = '/agent_sale/plan_detail/".$plan->id."';</script>";
        }catch (Exception $e){
            DB::rollBack();
            return "<script>alert('信息录入失败，请确认信息是否正确');history.back();</script>";
        }
    }

    //计划书个人中心
    public function user()
    {
        $order_now = array();
        $sum = '';
        $sum_now = '';
        $res = Agent::with('user')
            ->where('id',$_COOKIE['agent_id'])
            ->first();
        $authentication = $this->isAuthentication($_COOKIE['agent_id']);
        $order = Order::where([
            ['agent_id',$_COOKIE['agent_id']],
            ['status',1]
        ])
            ->get();
//        dd($order);
        foreach($order as $v){
            if(substr($v['created_at'],5,2) == date('m',time())){
                $order_now[] = $v;
            }
            $sum += $v['premium'];
        }
        foreach($order_now as $vv){
            $sum_now += $vv['premium'];
        }

        if(isset($_COOKIE['code']) && $_COOKIE['state'] == 'STATE') {
            $userinfo = $_COOKIE['userinfo'];
            $arr = unserialize($userinfo);
            $info = UserThird::where('app_id',$arr['openid'])->first();
        }
        return view('frontend.agents.mobile.user',compact('res','order','order_now','sum','sum_now','authentication','info'));
    }



    /**
     * 代理人个人中心详情
     */
    public function userDetail()
    {
        $data = Agent::where('id',$_COOKIE['agent_id'])->with('user')->first();
        $ditch = Ditch::with(['agents'=>function($q){
            $q->where(['id'=>$_COOKIE['agent_id'],'work_status'=>1]);
        }])->first();
        $authentication = $this->isAuthentication($_COOKIE['agent_id']);
        return view('frontend.agents.mobile.user_detail',compact('authentication','data','ditch'));
    }


    /**
     * 代理人客户管理
     */
    public function agentCust($type)
    {
        $option = 'cust';
        if($type == 'payed'){
            if(isset($_POST['search_type']) && !is_null($_POST['content'])){
                switch($_POST['search_type']){
                    case 1:
                        $where[] = ['users.name','like','%'.$_POST['content'].'%'];
                        break;
                    case 2:
                        $where[] = ['users.code','like','%'.$_POST['content'].'%'];

                        break;
                    case 3:
                        $where[] = ['users.phone','like','%'.$_POST['content'].'%'];
                        break;
                    case 4 :
                        $where[] = ['users.email','like','%'.$_POST['content'].'%'];
                        break;
                }
                $res = DB::table('users')
                    ->join('warranty_policy','users.phone','warranty_policy.phone')
                    ->join('cust_rule','users.id','cust_rule.user_id')
                    ->groupBy('users.phone')
                    ->where([['users.type','user'],['cust_rule.agent_id',$_COOKIE['agent_id']]])
                    ->orWhere([['users.type','user'],['cust_rule.from_id',$_COOKIE['agent_id']]])
                    ->where($where)
                    ->select('users.*')
                    ->paginate(config('list_num.frontend.plan_lists'));
            }else{
                $res = DB::table('users')
                    ->join('warranty_policy','users.phone','warranty_policy.phone')
                    ->join('cust_rule','users.id','cust_rule.user_id')
                    ->groupBy('users.phone')
                    ->where([
                        ['users.type','user'],
                        ['cust_rule.agent_id',$_COOKIE['agent_id']]
                    ])
                    ->orWhere([['users.type','user'],['cust_rule.from_id',$_COOKIE['agent_id']]])
                    ->select('users.*')
                    ->paginate(config('list_num.frontend.plan_lists'));
            }
        }elseif($type == 'unpayed'){
            $data = WarrantyPolicy::whereHas('policy_users',function($q){
                $q->where('type','user');
            })
                ->groupBy('phone')
                ->pluck('phone');
            if(isset($_POST['search_type']) && !is_null($_POST['content'])){
                switch($_POST['search_type']){
                    case 1:
                        $where[] = ['users.name','like','%'.$_POST['content'].'%'];
                        break;
                    case 2:
                        $where[] = ['users.code','like','%'.$_POST['content'].'%'];

                        break;
                    case 3:
                        $where[] = ['users.phone','like','%'.$_POST['content'].'%'];
                        break;
                    case 4 :
                        $where[] = ['users.email','like','%'.$_POST['content'].'%'];
                        break;
                }
                $res = DB::table('users')
                    ->join('cust_rule','users.id','cust_rule.user_id')
                    ->select('users.*')
                    ->where([['users.type','user'],['cust_rule.agent_id',$_COOKIE['agent_id']]])
                    ->whereNotIn('users.phone',$data)
                    ->orWhere([['users.type','user'],['cust_rule.from_id',$_COOKIE['agent_id']]])
                    ->whereNotIn('users.phone',$data)
                    ->where($where)
                    ->groupBy('users.code')
                    ->paginate(config('list_num.frontend.plan_lists'));
            }else{
                $res = DB::table('users')
                    ->join('cust_rule','users.id','cust_rule.user_id')
                    ->where([['users.type','user'],['cust_rule.agent_id',$_COOKIE['agent_id']]])
                    ->whereNotIn('users.phone',$data)
                    ->orWhere([['users.type','user'],['cust_rule.from_id',$_COOKIE['agent_id']]])
                    ->whereNotIn('users.phone',$data)
                    ->select('users.*')
                    ->groupBy('users.phone')
                    ->paginate(config('list_num.frontend.plan_lists'));
//                dd($res);
            }
        }elseif($type == 'apply') {
            if(isset($_POST['search_type']) && !is_null($_POST['content'])){
                switch($_POST['search_type']){
                    case 1:
                        $where[] = ['users.name','like','%'.$_POST['content'].'%'];
                        break;
                    case 2:
                        $where[] = ['users.code','like','%'.$_POST['content'].'%'];

                        break;
                    case 3:
                        $where[] = ['users.phone','like','%'.$_POST['content'].'%'];
                        break;
                    case 4 :
                        $where[] = ['users.email','like','%'.$_POST['content'].'%'];
                        break;
                }
                $res = DB::table('users')
                    ->join('cust_rule','users.id','cust_rule.user_id')
                    ->select('users.*')
                    ->where([['users.type','user'],['cust_rule.from_id',$_COOKIE['agent_id']],['cust_rule.agent_id',0]])
                    ->where($where)
                    ->groupBy('users.code')
                    ->paginate(config('list_num.frontend.plan_lists'));
            }else{
                $res = DB::table('users')
                    ->join('cust_rule','users.id','cust_rule.user_id')
                    ->select('users.*')
                    ->where([['users.type','user'],['cust_rule.from_id',$_COOKIE['agent_id']],['cust_rule.agent_id',0]])
                    ->groupBy('users.phone')
                    ->paginate(config('list_num.frontend.plan_lists'));
            }
        }else{
            //历史客户
            $old_data = User::where('type','user')
                -> whereHas('custRule',function($q){
                $q->where('agent_id',$_COOKIE['agent_id']);
            })
                ->groupBy('users.id')
                ->pluck('id');
//            dd($old_data);
            if(isset($_POST['search_type']) && !is_null($_POST['content'])){
                switch($_POST['search_type']){
                    case 1:
                        $where[] = ['users.name','like','%'.$_POST['content'].'%'];
                        break;
                    case 2:
                        $where[] = ['users.code','like','%'.$_POST['content'].'%'];

                        break;
                    case 3:
                        $where[] = ['users.phone','like','%'.$_POST['content'].'%'];
                        break;
                    case 4 :
                        $where[] = ['users.email','like','%'.$_POST['content'].'%'];
                        break;
                }
                $res = DB::table('users')
                    ->join('order','order.user_id','users.id')
                    ->select('users.*')
                    ->where([['users.type','user'],['order.agent_id',$_COOKIE['agent_id']]])
                    ->where($where)
                    ->whereNotIn('users.id',$old_data)
                    ->groupBy('users.phone')
                    ->paginate(config('list_num.frontend.plan_lists'));
            }else{
                $res = DB::table('users')
                    ->join('order','order.user_id','users.id')
                    ->select('users.*')
                    ->where([['users.type','user'],['order.agent_id',$_COOKIE['agent_id']]])
                    ->whereNotIn('users.id',$old_data)
                    ->groupBy('users.phone')
                    ->paginate(config('list_num.frontend.plan_lists'));
            }
        }
        $authentication = $this->isAuthentication($_COOKIE['agent_id']);
        return view('frontend.agents.agent_cust.index',compact('option','res','type','authentication'));
    }

    /**
     *代理人添加客户数据提交
     */
    public function agentCustSubmit(\Illuminate\Http\Request $request)
    {
        $input = $request->all();
//        dd($input);
        if($input['company'] == 1){
            //更新数据
            if(isset($input['edit']) && $input['edit'] == 1){
                DB::beginTransaction();
                try{
                    $user_info = User::where('id',$input['id'])
                        ->update([
                            'name'=>$input['name_company'],
                            'real_name'=>$input['name_company'],
                            'email'=>$input['linkman_email'],
                            'phone'=>$input['linkman_phone'],
                            'code'=>isset($input['credit_code'])?$input['credit_code']:$input['license_code'],
                        ]);
                    $cust_rule_info = CustRule::where('user_id',$input['id'])
                        ->update([
                            'code'=>isset($input['credit_code'])?$input['credit_code']:$input['license_code'],
                        ]);
                    $authentication_info = Authentication::where('user_id',$input['id'])
                        ->update([
                            'name'=>$input['name_company'],
                            'code'=>isset($input['organization_code'])?$input['organization_code']:'',
                            'license_code'=>isset($input['license_code'])?$input['license_code']:'',
                            'tax_code'=>isset($input['taxpayer_code'])?$input['taxpayer_code']:'',
                            'credit_code'=>isset($input['credit_code'])?$input['credit_code']:'',
                        ]);
                    $up_path = UploadFileHelper::uploadImage($input['uploadImg'],'upload/frontend/companyLicense/');
                    $true_firm_info = TrueFirmInfo::where('user_id',$input['id'])
                        ->update([
                            'ins_principal'=>$input['linkman_name'],
                            'ins_phone'=>$input['linkman_phone'],
                            'ins_principal_code'=>$input['linkman_id_code'],
                            'ins_email'=>$input['linkman_email'],
                            'license_img'=>$up_path,
                        ]);
                    DB::commit();
                    return "<script>alert('更新成功');location.href='/agent_sale/agent_company/unpayed'</script>";
                }catch (Exception $e){
                    DB::rollBack();
                    return "<script>alert('信息录入失败，请确认信息是否正确');history.back();</script>";
                }
            }
            //添加企业客户
            DB::beginTransaction();
            try{
                if(!isset($input['uploadImg'])){
                    return "<script>alert('请上传图片，用于验证用户信息');history.back();</script>";
                }
                if($this->checkPhone($input['linkman_phone'],'company') || isset($input['credit_code'])?$this->checkCode($input['credit_code'],'company'):$this->checkCode($input['license_code'],'company') || $this->checkEmail($input['linkman_email'],'company')){
                    return "<script>alert('该用户已经录入');history.back();</script>";
                }
                //添加到user
                $user = new User();
                $user->name = $input['name_company'];
                $user->real_name = $input['name_company'];
                $user->email = $input['linkman_email'];
                $user->phone = $input['linkman_phone'];
                if(isset($input['credit_code'])){
                    $user->code = $input['credit_code'];
                }else{
                    $user->code = $input['license_code'];//营业执照
                }
                if(isset($input['address'])){
                    $user->address = $input['province'].'-'.$input['city'].'-'.$input['county'].'-'.$input['address'];
                }else{
                    $user->address = $input['province'].'-'.$input['city'].'-'.$input['county'];
                }
                $user->type = 'company';
                $user->password = bcrypt('123456');
                $user_res = $user->save();
                //添加到关系表
                $custRule = new CustRule();
                if(isset($input['credit_code'])){
                    $custRule->code = $input['credit_code'];
                }else{
                    $custRule->code = $input['license_code'];//营业执照
                }
                $custRule->user_id = $user->id;
                $custRule->from_id = $_COOKIE['agent_id'];
                $custRule->type = 1;
                $custRule->from_type = 0;
                $custRule->status = 0;
                $custRule_res = $custRule->save();
                //添加到认证表
                $authentication = new Authentication();
                $authentication->name = $input['name_company'];
                if(isset($input['credit_code'])){//三证合一
                    $authentication->credit_code = $input['credit_code'];
                }else{//非三证合一
                    $authentication->code = $input['organization_code'];
                    $authentication->license_code = $input['license_code'];
                    $authentication->tax_code = $input['taxpayer_code'];
                }
                $authentication->status = 0;
                $authentication->user_id = $user->id;
                $authentication_res = $authentication->save();
                //上传图片
                $companyPath = UploadFileHelper::uploadImage($input['uploadImg'],'upload/frontend/companyLicense/');
                //添加到企业信息表
                $true_info = new TrueFirmInfo();
                $true_info->user_id = $user->id;
                $true_info->ins_principal = $input['linkman_name'];
                $true_info->ins_phone = $input['linkman_phone'];
                $true_info->ins_principal_code = $input['linkman_id_code'];
                $true_info->ins_email = $input['linkman_email'];
                $true_info->license_img = $companyPath;
                $true_info_res = $true_info->save();
                DB::commit();
                return "<script>alert('信息录入成功');location.href = '/agent_sale/agent_company/unpayed';</script>";
            }catch (Exception $e){
                DB::rollBack();
                return "<script>alert('信息录入失败，请确认信息是否正确');history.back();</script>";
            }
        }else{
            //更新普通客户
            if(isset($input['edit']) && $input['edit'] == 1){
                DB::beginTransaction();
                try{
                //更新user表
                $edit_res = User::where('id',$input['id'])
                    ->update([
                        'name'=>$input['toubaoren_name'],
                        'real_name'=>$input['toubaoren_name'],
                        'email'=>$input['toubaoren_email'],
                        'phone'=>$input['toubaoren_phone'],
                        'code'=>$input['toubaoren_id_code'],
                    ]);
                //更新关系表
                $edit_rule_res = CustRule::where('user_id',$input['id'])
                    ->update([
                        'code'=>$input['toubaoren_id_code'],
                    ]);
                    DB::commit();
                    return "<script>alert('更新成功');history.back();</script>";
                }catch (Exception $e){
                    DB::rollBack();
                    return "<script>alert('信息录入失败，请确认信息是否正确');history.back();</script>";
                }
            }
            //添加普通客户
            if($this->checkCode($input['toubaoren_id_code'],'user') || $this->checkPhone($input['toubaoren_phone'],'user') || $this->checkEmail($input['toubaoren_email'],'user')){
                return "<script>alert('该用户已经被添加过了!');history.back();</script>";
            }
            DB::beginTransaction();
            try{
                //插入user表
                $user = new User();
                $user->name = $input['toubaoren_name'];
                $user->real_name = $input['toubaoren_name'];
                $user->email = $input['toubaoren_email'];
                $user->phone = $input['toubaoren_phone'];
                $user->code = $input['toubaoren_id_code'];
                $user->type = 'user';
                $user->password = bcrypt('123456');
                $user_res = $user->save();
                //插入关系表
                $cust_rule = new CustRule();
                $cust_rule->code = $input['toubaoren_id_code'];
                $cust_rule->user_id = $user->id;
                $cust_rule->from_id = $_COOKIE['agent_id'];
                $cust_rule->type = 0;
                $cust_rule->from_type = 0;
                $cust_rule->status = 1;
                $cust_rule_res = $cust_rule->save();
                if($user_res && $cust_rule_res){
                    DB::commit();
                    return "<script>alert('添加成功');location.href='/agent_sale/agent_cust/unpayed';</script>";
                }
            }catch (Exception $e){
                DB::rollBack();
                return "<script>alert('信息录入失败，请确认信息是否正确');history.back();</script>";
            }
        }
    }

    //代理人添加客户数据提交验证
    protected function checkAgentCustSubmit($data){
        $rule_personal = [
            'relation'=>'required',
            'toubaoren_name'=>'required|between:3,10',
            'toubaoren_id_code'=>'required|size:18',
            'toubaoren_phone'=>'required|size:11',
            'toubaoren_email'=>'required|e-mail',
            'beibaoren_birthday'=>'required',
            'beibaoren_occupation'=>'required',
        ];
        $message = [
            'required'=>'标注红色*的为必填内容，请检查是否填写完整',
            'between'=>'名称长度必须在3-10位之间！',
            'toubaoren_id_code.size'=>'身份证的长度需要是18位数',
            'toubaoren_phone.size'=>'请填写11位数的手机号码',
            'toubaoren_email.e-mail'=>'请填写正确格式的邮箱',
        ];
        $validator = Validators::make($data,$rule_personal,$message);
        return $validator;
    }

    //代理人删除个人用户
    public function deletePersonalCust($id)
    {
        $res = DB::table('cust_rule')
            ->join('users','cust_rule.user_id','users.id')
            ->where('users.id',$id)
            ->delete();
        $data = User::where('id',$id)->delete();
        return ['status'=>200,'msg'=>'删除成功'];
    }

    //删除企业客户
    public function deleteCompanyCust($id)
    {
        $res_cust_rule = DB::table('cust_rule')
            ->join('users','cust_rule.user_id','users.id')
            ->where('users.id',$id)
            ->delete();
        $res_true_firm_info = DB::table('true_firm_info')
            ->join('users','true_firm_info.user_id','users.id')
            ->where('users.id',$id)
            ->delete();
        $res_authentication = DB::table('authentication')
            ->join('users','authentication.user_id','users.id')
            ->where('users.id',$id)
            ->delete();
        $res = User::where('id',$id)->delete();
        return ['status'=>200,'msg'=>'删除成功'];
    }

    //检测手机号是否已经注册
    protected function checkPhone($data,$type){
        $res = User::where([
            ['phone','=',$data],
            ['type','=',$type],
        ])
            ->first();
        return $res;
    }

    //检测身份证
    public function checkCode($code,$type)
    {
        $res = User::where([
            ['code',$code],
            ['type',$type],
        ])
            ->first();
        return $res;
    }

    //检测邮箱
    public function checkEmail($email,$type)
    {
        $res = User::where([
            ['email',$email],
            ['type',$type],
        ])
            ->first();
        return $res;
    }

    //重复客户报错
    public function error()
    {
        return "<script>alert('此号码已经添加');</script>";
    }


    /**
     * 添加企业客户
     */
    public function agentCompany($type)
    {
        $option = 'cust';
        if($type == 'payed'){
            if(isset($_POST['search_type']) && !is_null($_POST['content'])){
                switch($_POST['search_type']){
                    case 1:
                        $where[] = ['users.name','like','%'.$_POST['content'].'%'];
                        break;
                    case 2:
                        $where[] = ['authentication.credit_code','like','%'.$_POST['content'].'%'];

                        break;
                    case 3:
                        $where[] = ['authentication.code','like','%'.$_POST['content'].'%'];
                        break;
                    case 4 :
                        $where[] = ['authentication.license_code','like','%'.$_POST['content'].'%'];
                        break;
                }
                $res = DB::table('users')
                    ->join('warranty_policy','users.phone','warranty_policy.phone')
                    ->join('cust_rule','cust_rule.user_id','users.id')
                    ->join('warranty_rule','warranty_rule.policy_id','warranty_policy.id')
                    ->join('authentication','authentication.user_id','users.id')
                    ->join('true_firm_info','true_firm_info.user_id','users.id')
                    ->groupBy('users.phone')
                    ->where([['users.type','company'],['cust_rule.agent_id',$_COOKIE['agent_id']]])
                    ->orWhere([['users.type','company'],['cust_rule.from_id',$_COOKIE['agent_id']]])
                    ->where($where)
                    ->select('users.*','true_firm_info.ins_principal','true_firm_info.ins_phone','authentication.status as auth_status')
                    ->paginate(config('list_num.frontend.plan_lists'));
            }else{
                $res = DB::table('users')
                    ->join('cust_rule','cust_rule.user_id','users.id')
                    ->join('warranty_policy','users.phone','warranty_policy.phone')
                    ->join('warranty_rule','warranty_rule.policy_id','warranty_policy.id')
                    ->join('authentication','authentication.user_id','users.id')
                    ->join('true_firm_info','true_firm_info.user_id','users.id')
                    ->groupBy('users.phone')
                    ->where([['users.type','company'],['cust_rule.agent_id',$_COOKIE['agent_id']]])
                    ->orWhere([['users.type','company'],['cust_rule.from_id',$_COOKIE['agent_id']]])
                    ->select('users.*','true_firm_info.ins_principal','true_firm_info.ins_phone','authentication.status as auth_status')
                    ->paginate(config('list_num.frontend.plan_lists'));
            }
        }elseif($type == 'unpayed'){
            $data = WarrantyPolicy::whereHas('policy_users',function($q){
                $q->where('type','user');
            })
                ->groupBy('phone')
                ->pluck('phone');
            if(isset($_POST['search_type']) && !is_null($_POST['content'])){
                switch($_POST['search_type']){
                    case 1:
                        $where[] = ['users.name','like','%'.$_POST['content'].'%'];
                        break;
                    case 2:
                        $where[] = ['users.code','like','%'.$_POST['content'].'%'];

                        break;
                    case 3:
                        $where[] = ['users.phone','like','%'.$_POST['content'].'%'];
                        break;
                    case 4 :
                        $where[] = ['users.email','like','%'.$_POST['content'].'%'];
                        break;
                }
                $res = DB::table('users')
                    ->join('cust_rule','cust_rule.user_id','users.id')
                    ->join('authentication','authentication.user_id','users.id')
                    ->join('true_firm_info','true_firm_info.user_id','users.id')
                    ->groupBy('users.phone')
                    ->where([['users.type','company'],['cust_rule.agent_id',$_COOKIE['agent_id']]])
                    ->orWhere([['users.type','company'],['cust_rule.from_id',$_COOKIE['agent_id']]])
                    ->where($where)
                    ->whereNotIn('users.phone',$data)
                    ->select('users.*','true_firm_info.ins_principal','true_firm_info.ins_phone','authentication.status as auth_status')
                    ->paginate(config('list_num.frontend.plan_lists'));
            }else{
                $res = DB::table('users')
                    ->join('cust_rule','cust_rule.user_id','users.id')
                    ->join('authentication','authentication.user_id','users.id')
                    ->join('true_firm_info','users.id','true_firm_info.user_id')
                    ->groupBy('users.phone')
                    ->where([['users.type','company'],['cust_rule.agent_id',$_COOKIE['agent_id']]])
                    ->orWhere([['users.type','company'],['cust_rule.from_id',$_COOKIE['agent_id']]])
                    ->whereNotIn('users.phone',$data)
                    ->select('users.*','true_firm_info.ins_principal','true_firm_info.ins_phone','authentication.status as auth_status')
                    ->paginate(config('list_num.frontend.plan_lists'));
            }
//            dd($res);
        }elseif($type == 'apply'){
            if(isset($_POST['search_type']) && !is_null($_POST['content'])){
                switch($_POST['search_type']){
                    case 1:
                        $where[] = ['users.name','like','%'.$_POST['content'].'%'];
                        break;
                    case 2:
                        $where[] = ['users.code','like','%'.$_POST['content'].'%'];

                        break;
                    case 3:
                        $where[] = ['users.phone','like','%'.$_POST['content'].'%'];
                        break;
                    case 4 :
                        $where[] = ['users.email','like','%'.$_POST['content'].'%'];
                        break;
                }
                $res = DB::table('users')
                    ->join('cust_rule','cust_rule.user_id','users.id')
                    ->join('authentication','authentication.user_id','users.id')
                    ->join('true_firm_info','true_firm_info.user_id','users.id')
                    ->groupBy('users.phone')
                    ->orWhere([['users.type','company'],['cust_rule.from_id',$_COOKIE['agent_id']],['cust_rule.agent_id',0]])
                    ->where($where)
                    ->select('users.*','true_firm_info.ins_principal','true_firm_info.ins_phone','authentication.status as auth_status')
                    ->paginate(config('list_num.frontend.plan_lists'));
            }else{
                $res = DB::table('users')
                    ->join('cust_rule','cust_rule.user_id','users.id')
                    ->join('authentication','authentication.user_id','users.id')
                    ->join('true_firm_info','users.id','true_firm_info.user_id')
                    ->groupBy('users.phone')
                    ->where([['users.type','company'],['cust_rule.from_id',$_COOKIE['agent_id']],['cust_rule.agent_id',0]])
                    ->select('users.*','true_firm_info.ins_principal','true_firm_info.ins_phone','authentication.status as auth_status')
                    ->paginate(config('list_num.frontend.plan_lists'));
            }
        }else{
            //历史
            $old_data = User::where('type','company')
                ->whereHas('custRule',function($q){
                $q->where('agent_id',$_COOKIE['agent_id']);
            })
                ->groupBy('id')
                ->pluck('id');
            if(isset($_POST['search_type']) && !is_null($_POST['content'])){
                switch($_POST['search_type']){
                    case 1:
                        $where[] = ['users.name','like','%'.$_POST['content'].'%'];
                        break;
                    case 2:
                        $where[] = ['users.code','like','%'.$_POST['content'].'%'];

                        break;
                    case 3:
                        $where[] = ['users.phone','like','%'.$_POST['content'].'%'];
                        break;
                    case 4 :
                        $where[] = ['users.email','like','%'.$_POST['content'].'%'];
                        break;
                }
                $res = DB::table('users')
                    ->join('order','order.user_id','users.id')
                    ->join('authentication','authentication.user_id','users.id')
                    ->join('true_firm_info','true_firm_info.user_id','users.id')
                    ->groupBy('users.phone')
                    ->where([['users.type','company'],['order.agent_id',$_COOKIE['agent_id']]])
                    ->whereNotIn('users.id',$old_data)
                    ->where($where)
                    ->select('users.*','true_firm_info.ins_principal','true_firm_info.ins_phone','authentication.status as auth_status')
                    ->paginate(config('list_num.frontend.plan_lists'));
            }else{
                $res = DB::table('users')
                    ->join('order','order.user_id','users.id')
                    ->join('authentication','authentication.user_id','users.id')
                    ->join('true_firm_info','users.id','true_firm_info.user_id')
                    ->groupBy('users.phone')
                    ->where([['users.type','company'],['order.agent_id',$_COOKIE['agent_id']]])
                    ->whereNotIn('users.id',$old_data)
                    ->select('users.*','true_firm_info.ins_principal','true_firm_info.ins_phone','authentication.status as auth_status')
                    ->paginate(config('list_num.frontend.plan_lists'));
            }
        }
        $authentication = $this->isAuthentication($_COOKIE['agent_id']);
        return view('frontend.agents.agent_cust.company',compact('option','res','type','authentication'));
    }

    //普通客户详情
    public function custDetails($id)
    {
        $option = 'cust';
        $res = User::where('id',$id)
            ->first();
        $data = DB::table('order')
            ->join('warranty_recognizee','order.id','warranty_recognizee.order_id')
            ->join('product','product.ty_product_id','order.ty_product_id')
            ->join('users','users.id','order.user_id')
            ->where([
                ['users.id',$id],
                ['order.status',1],
                ['order.plan_id','<>',0]
            ])
            ->select('order.plan_id','warranty_recognizee.relation as relation','order.created_at as deal_time','product.product_name','product.ty_product_id','product.json','order.agent_id as order_agent_id')
            ->paginate(config('list_num.frontend.plan_lists'));
//        dd($data);
        foreach($data as $v){
            $v->deal_time = strstr($v->deal_time,' ',1);
            $v->json = json_decode($v->json,true);
            $v->brokerage = $this->marketDitchRelationRepository->getMyAgentBrokerage($v->ty_product_id,1,$_COOKIE['agent_id']);
            $v->premium = $this->getProductPremium($v->ty_product_id);
            $v->clause = $this->getClause($v->ty_product_id);
            $v->clause->content = json_decode($v->clause->content,true);
            if($v->plan_id != 0){
                $v->plan_name = DB::table('plan_lists')->where('id',$v->plan_id)->first();
            }
            $res['price'] += $v->premium;
        }
        $authentication = $this->isAuthentication($_COOKIE['agent_id']);
        $count = count($data);
        return view('frontend.agents.agent_cust.detail',compact('option','res','data','count','authentication'));
    }

    //请求条款
    public function getClause($id)
    {
        //获取产品的条款
        $biz_content = [
            'ty_product_id' => $id,    //投保产品ID
        ];
        //天眼接口参数封装
        $data = $this->_signHelp->tySign($biz_content);
        //发送请求
        $response = Curl::to(env('TY_API_SERVICE_URL') . '/ins_curl/getapioption')
            ->returnResponseObject()
            ->withData($data)
            ->withTimeout(120)
            ->post();
        return $response;
    }

    //移动端客户模块
    //客户列表
    public function custLists(\Illuminate\Http\Request $request)
    {
        $input = $request->all();
        if($input)
        {
            if(isset($input['type']))
            {
                switch($input['type'])
                {
                    case 0:
                        $whereType[] = ['users.type','user'];
                        break;
                    case 1:
                        $whereType[] = ['users.type','company'];
                        break;
                }
            }else{
                $whereType[] = [];
            }
        }
        if(isset($_GET['cust_search_name'])){
            $res = User::where('name','like','%'.$_GET['cust_search_name'].'%')
            ->whereHas('custRule',function($q){
                $q->where('agent_id',$_COOKIE['agent_id']);
            })->get();
        }else{
            $res = User::whereHas('custRule',function($q){
                $q->where('agent_id',$_COOKIE['agent_id'])
                    ->orWhere('from_id',$_COOKIE['agent_id']);
            })->get();
        }
        foreach($res as $value){
            if($value['type'] == 'user'){
                $data = User::with('user_authentication_person')
                    ->whereHas('custRule',function($q){
                        $q->where('agent_id',$_COOKIE['agent_id'])
                            ->orWhere('from_id',$_COOKIE['agent_id']);
                    })->get();
//                dd($data);
            }else{
                $data = User::with('authentication')
                    ->whereHas('custRule',function($q){
                        $q->where('agent_id',$_COOKIE['agent_id'])
                            ->orWhere('from_id',$_COOKIE['agent_id']);
                    })->get();
//                dd($data);
            }
        }
//        dd($res);
        return view('frontend.agents.agent_cust.mobile.cust_lists',compact('res','data'));
    }

    //移动端添加客户(个人)
    public function clientAddPerson()
    {
        return view('frontend.agents.agent_cust.mobile.client_add_person');
    }

    //移动端添加客户(企业)
    public function clientAddCompany()
    {
        return view('frontend.agents.agent_cust.mobile.client_add_company');
    }

    //移动端添加客户（个人）数据提交
    public function clientAddPersonSubmit(\Illuminate\Http\Request $request)
    {
        $input = $request->all();
//        dd($input);
        DB::beginTransaction();
        try{
            //添加到user表
            if($this->checkPhone($input['phone'],'user') || $this->checkCode($input['id_code'],'user')){
                return "<script>alert('使用该手机号的客户已经添加');history.back();</script>";
            }
            $user = new User();
            $user->name = $input['name'];
            $user->real_name = $input['name'];
            $user->email = $input['email'];
            $user->phone = $input['phone'];
            $user->code = $input['id_code'];
            $user->type = 'user';
            $user->password = bcrypt('123456');
            $user_res = $user->save();
            //插入关系表
            $custRule = new CustRule();
            $custRule->code = $input['id_code'];
            $custRule->user_id = $user->id;
            $custRule->from_id = $_COOKIE['agent_id'];
            $custRule->type = 0;
            $custRule->from_type = 0;
            $custRule->status = 0;
            $custRule_res = $custRule->save();

            DB::commit();
            //添加头像
            if(isset($input['uploadImg'])){
                $headPath = UploadFileHelper::uploadImage($input['uploadImg'],'upload/frontend/touxiang');
            }
            return "<script>location.href = '/agent_sale/success_add_person';</script>";
        }catch (Exception $e){
            DB::rollBack();
            return "<script>alert('信息录入失败，请确认信息是否正确');history.back();</script>";
        }
    }

    //移动端添加客户成功
    public function successClientAddPerson()
    {
      return view('frontend.agents.mobile.success_add_client');
    }
    
    //移动端添加客户（企业）数据提交
    public function clientAddCompanySubmit(\Illuminate\Http\Request $request)
    {
        $input = $request->all();
//        dd($input);
        DB::beginTransaction();
        try{
            if($this->checkPhone($input['linkman_phone'],'company')){
                return "<script>alert('该手机号已经录入过');history.back();</script>";
            }
            //添加到user表
            $user = new User();
            $user->name = $input['name'];
            $user->real_name = $input['name'];
            $user->email = $input['linkman_email'];
            $user->phone = $input['linkman_phone'];
            if(isset($input['credit_code'])){
                $user->code = $input['credit_code'];
            }else{
                $user->code = $input['organization_code'];
            }
            $user->type = 'company';
            $user->password = bcrypt('123456');
            $user_res = $user->save();
            //添加到关系表
            $custRule = new CustRule();
            if(isset($input['credit_code'])){
                $custRule->code = $input['credit_code'];
            }else{
                $custRule->code = $input['organization_code'];
            }
            $custRule->user_id = $user->id;
            $custRule->from_id = $_COOKIE['agent_id'];
//            $custRule->agent_id = $_COOKIE['agent_id'];
            $custRule->type = 0;
            $custRule->from_type = 0;
            $custRule->status = 0;
            $custRule_res = $custRule->save();
            //添加到认证表
            $authentication = new Authentication();
            $authentication->name = $input['name'];
            if(isset($input['credit_code'])){
                $authentication->credit_code = $input['credit_code'];
            }else{
                $authentication->code = $input['organization_code'];
                $authentication->license_code = $input['register_code'];
                $authentication->tax_code = $input['taxpayer_code'];
            }
            $authentication->status = 0;
            $authentication->user_id = $user->id;
            $authentication_res = $authentication->save();
//            添加到true_firm_info
            $true_info = new TrueFirmInfo();
            $true_info->user_id = $user->id;
            $true_info->ins_principal = $input['linkman_name'];
            $true_info->ins_phone = $input['linkman_name'];
            $true_info->ins_principal_code = $input['linkman_name'];
            $true_info_res = $true_info->save();
            //上传头像
           if(isset($input['uploadImg'])){
               $touxiangPath = UploadFileHelper::uploadImage($input['uploadImg'],'upload/frontend/touxiang');
           }
            DB::commit();
            return "<script>location.href = '/agent_sale/success_add_person';</script>";
        }catch (Exception $e){
            DB::rollBack();
            return "<script>alert('信息录入失败，请确认信息是否正确');history.back();</script>";
        }
    }
    //移动端客户详情
    public function mobileCustDetail($id)
    {
        $dith_id = $this->getMyDitch($_COOKIE['agent_id']);
        $res = User::where('id',$id)
            ->first();
        $data = Order::with('product')
            ->whereHas('order_user',function($q) use ($id){
                $q->where('id',$id);
            })->get();
        foreach($data as $v){
            $v->rate = $this->marketDitchRelationRepository->getMyAgentBrokerage($v['ty_product_id'],$dith_id,$_COOKIE['agent_id']);
            $v->product['jsons'] = json_decode($v->product['json'],true);
        }
//        dd($data);
        $authentication = User::whereHas('user_authentication_person',function($q){
            $q->where('status',2);
        })
            ->where('id',$id)
            ->first();
//        dd($authentication);
        return view('frontend.agents.agent_cust.mobile.cust_detail',compact('res','data','id','authentication'));
    }

    //详细资料
    public function mobileCustDetailOther($id)
    {
        $res = User::where('id',$id)
            ->first();
//        dd($res);
      return view('frontend.agents.agent_cust.mobile.cust_client_detail',compact('res','id'));
    }

    //删除客户
    public function deleteCust($id)
    {
        $res = DB::table('cust_rule')
            ->join('users','cust_rule.user_id','users.id')
            ->where('users.id',$id)
            ->delete();
        $data = User::where('id',$id)->delete();
        return "<script>location.href='/agent_sale/cust_lists'</script>";
    }
    
    //编辑客户
    public function editCust($id)
    {
        $data = User::where('id',$id)
            ->first();
//        dd($data);
        if($data['type'] == 'user'){
            $detail = User::where('id',$id)
                ->with('trueUserInfo')
                ->first();
//            dd($detail);
            return view('frontend.agents.agent_cust.mobile.edit_cust',compact('detail','id'));
        }else{
            $detail = User::where('id',$id)
                ->with('trueFirmInfo')
                ->first();
            return view('frontend.agents.agent_cust.mobile.edit_cust_company',compact('detail','id'));
        }
    }

    //代理人获取客户信息
    public function getCustInfo($id,Requests $request)
    {
        $input = $request->all();
        if(isset($input['company']) && $input['company'] == 1){
            $data = User::with('trueFirmInfo','authentication')
                ->where('id',$id)
                ->first();
        }else{
            $data = User::where('id',$id)
                ->first();
        }
        if($data){
            return ['status'=>200,'msg'=>$data];
        }else{
            return ['status'=>500,'msg'=>'信息查询失败，请稍后再试'];
        }

    }

    //编辑客户提交数据
    public function editCustSubmit(Requests $request)
    {
        $input = $request->all();
        $data['name'] = isset($input['name'])?$input['name']:'';
        $data['real_name'] = isset($input['name'])?$input['name']:'';
        $data['code'] = isset($input['id_code'])?$input['id_code']:'';
        $data['occupation'] = isset($input['occupation'])?$input['occupation']:'';
        $data['phone'] = isset($input['phone'])?$input['phone']:'';
        $data['email'] = isset($input['email'])?$input['email']:'';
        $res = User::where('id',$input['id'])
            ->update($data);
        return "<script>location.href='/agent_sale/cust_lists'</script>";
    }

    //移动端代理人业绩
    public function agentPerformance(TaskRepository $task)
    {
        $data = Order::with(['warranty_rule','product','order_user','order_agent','warranty_recognizee','order_brokerage','order_parameter'])
            ->where(['agent_id'=>$_COOKIE['agent_id'],'status'=>1])
            ->get();
        foreach($data as $v){
            $v->product['jsons'] = json_decode($v->product['json'],true);
            foreach($v->order_parameter as $val){
                $val['parameter'] = json_decode($val['parameter'],true);
                $val['selected'] = json_decode($val['selected'],true);
            }
        }
        //任务
        $agent_task = $task->getShouldDoneData(date('Y',time()),$this->getMyDitch($_COOKIE['agent_id']),$_COOKIE['agent_id']);
        //佣金
        $brokerage = OrderBrokerage::where('agent_id',$_COOKIE['agent_id'])
            ->groupBy(DB::raw('DATE_FORMAT(created_at, "%m")'))
            ->select(
                DB::raw('sum(user_earnings) as sum_earnings,Sum(order_pay) as pay'),
                DB::raw('DATE_FORMAT(created_at, "%m") as month')
            )
            ->get();
        $final_data = [];
        foreach($agent_task as $key=>$val){
            foreach($brokerage as $k=>$v){
                if($v['month'] == $key+1){
                    $final_data['month'][] = $v['month'];
                    $final_data['sum_earnings'][] = $v['sum_earnings'];
                    $final_data['pay'][] = $v['pay'];
                    $final_data['task'][] = $val;
                }else{
                    $final_data['month'][] = 0;
                    $final_data['sum_earnings'][] = 0;
                    $final_data['pay'][] = 0;
                    $final_data['task'][] = $val;
                }
            }
        }
//        dd($final_data);
        $count = count($data);
        return view('frontend.agents.agent_performance.index',compact('data','final_data','agent_task','brokerage','count'));
    }

    /**
     * 代理人工具（产品）
     */
    public function agentProduct()
    {
        $res = [];
        $company = [];
        $category = [];
        $data_category=[];
        $rate_data = [];
        $option = 'product';
        $dith_id = $this->getMyDitch($_COOKIE['agent_id']);
        //产品筛选
        if(isset($_GET['product_name'])){
            //通过产品名称搜索
            $where[] = ['product.product_name','like','%'.$_GET['product_name'].'%'];
        }elseif(isset($_GET['company_name'])){
            //通过公司名称检索
            $where[] = ['product.company_name','like','%'.$_GET['company_name'].'%'];
        }else{
            $where[]=['product.company_name','like','%'];
        }
        $data = $this->getMyProducts($_COOKIE['agent_id'],$where);
        foreach($data as $v){
            $v['json'] = json_decode($v['json'],true);
            $v['price'] = $this->getProductPremium($v['ty_product_id']);
            $v['rate'] = $this->marketDitchRelationRepository->getMyAgentBrokerage($v['ty_product_id'],$dith_id,$_COOKIE['agent_id']);
            $v['clauses'] = json_decode($v['clauses'],true);
        }
        $company_data = $this->getMyProducts($_COOKIE['agent_id']);
        foreach($company_data as $v){
            $v['json'] = json_decode($v['json'],true);
        }
        if(count($company_data) != 0){
            foreach($company_data as $v){
                $company[] = $v['json']['company'];
                $category[] = $v['json']['category'];
            }
            $company = $this->array_unique_company($company);
            $category = $this->array_unique_category($category);
        }
        if(isset($_GET['category'])){
            foreach($data as $v){
                if($v['json']['category']['id'] == $_GET['category']){
                    $data_category[] = $v;
                }
            }
            if($_GET['category'] == 0)
                $data_category = $data;
        }
//        dd($data);
        //佣金比筛选
        if(isset($_GET['rate'])){
            switch($_GET['rate']){
                case 1:
                    $rates = MarketDitchRelation::whereBetween('rate',[1,10])
                        ->where('status','on')
                        ->where('agent_id',$_COOKIE['agent_id'])
//                        ->groupBy('by_stages_way')
                        ->pluck('ty_product_id')->toArray();
                    break;
                case 2:
                    $rates = MarketDitchRelation::whereBetween('rate',[10,20])
                        ->where('status','on')
                        ->where('agent_id',$_COOKIE['agent_id'])
//                        ->groupBy('by_stages_way')
                        ->pluck('ty_product_id')->toArray();
                    break;
                case 3:
                    $rates = MarketDitchRelation::whereBetween('rate',[20,30])
                        ->where('status','on')
                        ->where('agent_id',$_COOKIE['agent_id'])
//                        ->groupBy('by_stages_way')
                        ->pluck('ty_product_id')->toArray();
                    break;
                case 4:
                    $rates = MarketDitchRelation::whereBetween('rate',[30,100])
                        ->where('status','on')
                        ->where('agent_id',$_COOKIE['agent_id'])
//                        ->groupBy('by_stages_way')
                        ->pluck('ty_product_id')->toArray();
                    break;
            }
//            dd($rates);
            if(isset($rates) && $rates != 0){
                foreach($data as $v){
                    if(in_array($v['ty_product_id'],$rates)){
                        $rate_data[] = $v;
                    }
                }
            }else{
               $rate_data = $data;
            }
        }
        if(isset($_GET['category'])) {
            $res[] = $data_category;
        }elseif(isset($_GET['rate'])){
            $res[] = $rate_data;
        }else{
            $res[] = $data;
        }
        $count = count($res[0]);
//        dd($data);
        $authentication = $this->isAuthentication($_COOKIE['agent_id']);
        if($this->is_mobile()){
            return view('frontend.agents.mobile.agent_product',compact('data','authentication'));
        }
//        dd($category);
        return view('frontend.agents.agent_product.index',compact('option','res','company','count','category','authentication'));
    }

    //代理人产品详情
    public function agentProDetail($id)
    {
        $ditch_id = $this->getMyDitch($_COOKIE['agent_id']);
        $count_sales = Order::where([
            ['ty_product_id',$id],
            ['status',1]
        ])
            ->count('id');
//        dd($count_sales);
        $sales = Order::where([
            ['ty_product_id',$id],
            ['status',1]
        ])
            ->groupBy(DB::raw('DATE_FORMAT(created_at, "%m")'))
            ->select(
                DB::raw('count(id) as count'),
                DB::raw('DATE_FORMAT(created_at, "%m") as month')
            )
            ->get();
        $option = 'product';
        $data = Product::where('ty_product_id',$id)->first();
        $data['json'] = json_decode($data['json'],true);
//        $data['clauses'] = json_decode($data['clauses'],true);
        $data['price'] = $this->getProductPremium($data['ty_product_id']);
        $data['rate'] = $this->marketDitchRelationRepository->getMyAgentBrokerage($data['ty_product_id'],1,$_COOKIE['agent_id']);
        //获取产品的条款
        $biz_content = [
            'ty_product_id' => $data['ty_product_id'],    //投保产品ID
        ];
        //天眼接口参数封装
        $res = $this->_signHelp->tySign($biz_content);
        //发送请求
        $response = Curl::to(env('TY_API_SERVICE_URL') . '/ins_curl/getapioption')
            ->returnResponseObject()
            ->withData($res)
            ->withTimeout(120)
            ->post();
        $return_data = json_decode($response->content, true);
        $data['defaultPrice'] = $return_data['option']['protect_items'][0];
        $url = url('/ins/ins_info/'.$data['ty_product_id'].'?agent_id='.$_COOKIE['agent_id'].'&ditch_id='.$ditch_id);
//        dd($url);
        $authentication = $this->isAuthentication($_COOKIE['agent_id']);
        if($this->is_mobile()){
            return view('frontend.agents.mobile.agent_product_detail',compact('ditch_id','data','return_data','url','count_sales','sales'));
        }
        return view('frontend.agents.agent_product.detail',compact('ditch_id','authentication','option','data','return_data','url'));
    }

    //移动端代理人邀请客户
    public function agentInvite()
    {
        $res = DB::table('users')
            ->join('agents','users.id','agents.user_id')
            ->where('agents.id',$_COOKIE['agent_id'])
            ->select('users.*')
            ->first();
        $url = url('/agent_sale/cust_info'.'?agent_id='.$_COOKIE['agent_id']);
//        dd($res);
        return view('frontend.agents.mobile.agent_invite_cust',compact('res','url'));
    }

    //邀请客户成功
    public function agentInviteSuccess()
    {
        return view('frontend.agents.mobile.invite_success');
    }

    //移动端客户看到的页面
    public function custInfo()
    {
        $res = DB::table('users')
            ->join('agents','users.id','agents.user_id')
            ->where('agents.id',$_GET['agent_id'])
            ->select('users.*')
            ->first();
        $url = url('/agent_sale/cust_info'.'?agent_id='.$_COOKIE['agent_id']);
        return view('frontend.agents.mobile.cust_info',compact('res','url'));
    }

    //客户提交数据
    public function custInfoSubmit(\Illuminate\Http\Request $request)
    {
        $input = $request->all();
        DB::beginTransaction();
        try{
            if($this->checkPhone($input['phone']) || $this->checkCode($input['id_code']))
            {
                return "<script>alert('您的信息已经录入过');location.href='/';</script>";
            }
            $user = new User();
            $user->name = $input['name'];
            $user->real_name = $input['name'];
            $user->email = $input['email'];
            $user->phone = $input['phone'];
            $user->code = $input['id_code'];
            $user->type = 'user';
            $user->password = bcrypt('123qwe');
            $user_res = $user->save();
            //插入关系表
            $custRule = new CustRule();
            $custRule->code = $input['id_code'];
            $custRule->user_id = $user->id;
            $custRule->from_id = $_GET['agent_id'];
            $custRule->type = 0;
            $custRule->from_type = 0;
            $custRule->status = 1;
            $custRule_res = $custRule->save();
            DB::commit();
            return "<script>location.href='/agent_sale/cust_info_submit_success?agent_id=".$input['agent_id']."'</script>";
        }catch (Exception $e){
            DB::rollBack();
            return "<script>alert('信息录入失败，请确认信息是否正确');history.back();</script>";
        }
    }

    //提交数据成功
    public function custInfoSubmitSuccess()
    {
        $url = url('/agent_sale/cust_info'.'?agent_id='.$_GET['agent_id']);
        return view('frontend.agents.mobile.client_submit_success',compact('url'));
    }

    //天眼后台获取产品分类
    public function productGetCategory($res){
        //直到五级分类
        $categorys = isset($res[0]['json']) ? json_decode($res[0]['json'],true)['categorys'] : $res;
        $one  = [];
        $two  = [];
        $three  = [];
        $four  = [];
        $five  = [];
        foreach($categorys as $v){
            $name = str_repeat('-' , $v['sort']) . $v['name'];
            if(preg_match('/-/', $name)){
                if(preg_match('/--/', $name)){
                    if(preg_match('/---/', $name)){
                        if(preg_match('/----/', $name)){
                            $five[$v['path'].'-'.$v['id']] = $name;
                        }else{
                            $four[$v['path'].'-'.$v['id']] = $name;
                        }
                    }else{
                        $three[$v['path'].'-'.$v['id']] = $name;
                    }
                }else{
                    $two[$v['path'].'-'.$v['id']] = $name;
                }
            }else{
                $one[$v['path'].'-'.$v['id']] = $name;
            }
        }
        foreach ($one as $key=>$value){
            foreach ($two as $key_two=>$value_two){
                if(explode("-", $key)[0].explode("-", $key)[1].','==explode("-", $key_two)[0]){
                    if(explode("-", $key)[1]=='1'){
                        $company_category[explode("-", $key_two)[1]] = $value_two;
                    }
                    if(explode("-", $key)[1]=='2'){
                        $insurance_category[explode("-", $key_two)[1]] = $value_two;
                    }
                    if(explode("-", $key)[1]=='3'){
                        $clause_category[explode("-", $key_two)[1]] = $value_two;
                    }
                    if(explode("-", $key)[1]=='4'){
                        $duty_category[explode("-", $key_two)[1]] = $value_two;
                    }
                }
            }
        }
        foreach ($three as $key_three=>$value_three){
            foreach ($company_category as $k_c=>$v_c){
                if(explode(',',explode("-", $key_three)[0])[3]==$k_c){
                    $company_category[$k_c.'-'.explode("-", $key_three)[1]]=$value_three;
                }
            }
        }
        foreach ($three as $key_three=>$value_three){
            foreach ($insurance_category as $k_c=>$v_c){
                if(explode(',',explode("-", $key_three)[0])[3]==$k_c){
                    $insurance_category[$k_c.'-'.explode("-", $key_three)[1]]=$value_three;
                }
            }
        }
        foreach ($four as $k=>$v){
            foreach ($company_category as $k_c=>$v_c){

                if(count(explode('-',$k_c))=='2'){
                    if(explode(',',explode('-',$k)[0])[4]==explode('-',$k_c)[1]){
                        $company_category[$k_c.'-'.explode("-", $k)[1]]=$v;
                    }
                }
            }
        }
        foreach ($four as $k=>$v){
            foreach ($insurance_category as $k_c=>$v_c){
                if(count(explode('-',$k_c))=='2'){
                    if(explode(',',explode('-',$k)[0])[4]==explode('-',$k_c)[1]){
                        $insurance_category[$k_c.'-'.explode("-", $k)[1]]=$v;
                    }
                }
            }
        }
        $return_data = array(
            'company' => isset($company_category)? $company_category : [],
            'insurance' => isset($insurance_category)? $insurance_category:[],
            'clause' => isset($clause_category)? $clause_category:[],
            'duty' => isset($duty_category)? $duty_category:[],
        );
        //存缓存（有效期为12小时）
        $expiresAt = \Carbon\Carbon::now()->addMinutes(24*60);
        Cache::forever('ty_product_categorys', $return_data,$expiresAt);
        return $return_data;
    }

    //代理人需求
    public function agentNeed()
    {
        $authentication = $this->isAuthentication($_COOKIE['agent_id']);
        $option = 'need';
        return view('frontend.agents.agent_need.index',compact('authentication','option'));
    }

    //代理人需求数据提交
    public function agentNeedSubmit(Requests $request)
    {
        $input = $request->all();
//        dd($input);
        DB::beginTransaction();
        try{
            //添加到工单表
            $data = new LiabilityDemand();
            $data->module = $input['module'];
            $data->recipient_id = $input['recipient_id'];
            $data->title = $input['title'];
            $data->agent_id = $_COOKIE['agent_id'];
            $data->content = $input['content'];
            $data->status = 1;
            $data->save();
            //添加到内容表
            $comment = new Comment();
            $comment->commentable_type = 'App\Models\LiabilityDemand';
            $comment->commentable_id = $data->id;
            $comment->send_id = $_COOKIE['agent_id'];
            $comment->recipient_id = $input['recipient_id'];
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

    //代理人需求列表
    public function agentNeedLists()
    {
        $authentication = $this->isAuthentication($_COOKIE['agent_id']);
        $option = 'need';
        //获取当前代理人发送的工单
        if(isset($_GET['search'])){
            switch($_GET['search']){
                case 1:
                    $where[] = ['status',3];
                    break;
                case 2:
                    $where[] = ['status','<>',3];
                    break;
                default:
                    $where = [];
            }
            $data = LiabilityDemand::where('agent_id',$_COOKIE['agent_id'])
                ->where($where)
                ->paginate(config('list_num.frontend.demand'));
        }else{
            $data = LiabilityDemand::where('agent_id',$_COOKIE['agent_id'])
                ->paginate(config('list_num.frontend.demand'));
        }
        return view('frontend.agents.agent_need.lists',compact('authentication','option','data'));
    }

    //代理人删除需求
    public function deleteNeed($id)
    {
        $data = LiabilityDemand::where('id',$id)
            ->delete();
        $res = Comment::where('commentable_id',$id)
            ->delete();
        return "<script>alert('删除成功');location.href='/agent_sale/agent_need'</script>";
    }

    //代理人需求详情
    public function agentNeedDetail($id)
    {
        $authentication = $this->isAuthentication($_COOKIE['agent_id']);
        $option = 'need';
        $data = LiabilityDemand::where('id',$id)
            ->first();
//        dd($data);
        return view('frontend.agents.agent_need.detail',compact('authentication','option','data'));
    }

    //结束需求
    public function agentNeedEnd($id)
    {
        DB::beginTransaction();
        try{
            $data = LiabilityDemand::where('id',$id)
                ->update(['status'=>3]);
            DB::commit();
            return ['status'=>200,'msg'=>'修改成功'];
        }catch (Exception $e){
            DB::rollBack();
            return ['status'=>400,'msg'=>'修改失败，请稍后再试'];
        }
    }

    //添加需求聊天记录
    public function agentNeedChat(Requests $request)
    {
        $input = $request->all();
        DB::beginTransaction();
        try{
            $data = new Comment();
            $data->commentable_type = 'App\Models\LiabilityDemand';
            $data->commentable_id =$input['id'];
            $data->send_id = $input['send_id'];
            $data->recipient_id = $input['recipient_id'];
            $data->content = $input['data'];
            $data->status = 1;
            $data->save();
            DB::commit();
            return ['status'=>200,'msg'=>'录入成功'];
        }catch (Exception $e){
            DB::rollBack();
            return ['status'=>400,'msg'=>'录入失败'];
        }
    }

    //代理人添加沟通记录
    public function communication()
    {
        if(isset($_GET['search'])){
            $data = Communication::where('agent_id',$_COOKIE['agent_id'])
                ->with('product')
                ->whereHas('user',function($q){
                    $q->where('real_name','like','%'.$_GET["search"].'%');
                })
                ->get();
        }else{
            $data = Communication::where('agent_id',$_COOKIE['agent_id'])
                ->with('user','product')
                ->get();
        }
        $message_data = Messages::where([
            ['accept_id',$_COOKIE['agent_id']],
            ['status','<>',3]
        ])
            ->paginate(config('list_num.frontend.message'));
        return view('frontend.agents.agent_communication.mobile.index',compact('data','message_data'));
    }

    //移动端代理人添加沟通记录
    public function communicationAdd()
    {
        if(isset($_GET['communication_id'])){
            $id = $_GET['communication_id'];
            $data = Communication::find($id);
//            dd($data);
            return view('frontend.agents.agent_communication.mobile.add',compact('data'));
        }else{
            return view('frontend.agents.agent_communication.mobile.add');
        }
    }

    //移动端代理人添加沟通记录数据提交
    public function communicationAddSubmit(Requests $request)
    {
        $input = $request->all();
        DB::beginTransaction();
        try{
            if(isset($input['communication_id'])){
                $res = Communication::where('id',$input['communication_id'])
                    ->update([
                        'grade'=>$input['grade'],
                        'content'=>$input['content'],
                        'user_id'=>$input['client_id'],
                        'ty_product_id'=>$input['product_id']
                    ]);
                DB::commit();
                return ['status'=>201,'msg'=>'信息更新成功'];
            }else{
                $data = new Communication();
                $data->user_id = $input['client_id'];
                $data->ty_product_id = $input['product_id'];
                $data->agent_id = $_COOKIE['agent_id'];
                $data->grade = $input['grade'];
                $data->content = $input['content'];
                $data->save();
                DB::commit();
                return ['status'=>200,'msg'=>'信息录入成功'];
            }
        }catch (Exception $e){
            DB::rollBack();
            return ['status'=>400,'msg'=>'信息录入失败，请稍后再试'];
        }

    }

    //移动端代理人添加沟通记录手动添加
    public function communicationAddClient()
    {
        return view('frontend.agents.agent_communication.mobile.add_client');
    }

    //手动添加数据提交
    public function communicationAddClientSubmit(Requests $request)
    {
        $array = [];
        $input = $request->all();
        foreach($input['data'] as $k=>$v){
            $array[$v['name']] = $v['value'];
        }
//        dd($array);
        if($this->checkPhone($array['phone'],'user') || $this->checkCode($array['id_code'],'user')){
            return ['status'=>400,'msg'=>'该用户已经存在'];
        }
        DB::beginTransaction();
        try{
            //录入user表
            $user = new User();
            $user->name = $array['name'];
            $user->real_name = $array['name'];
            $user->email = $array['email'];
            $user->phone = $array['phone'];
            $user->code = $array['id_code'];
            $user->occupation = $array['occupation'];
            $user->type = 'user';
            $user->password = bcrypt('123456');
            $user->save();
            //添加到关系表
            DB::commit();
            return ['status'=>200,'user_id'=>$user->id];
        }catch (Exception $e){
            DB::rollBack();
            return "<script>alert('信息录入失败，请确认信息是否正确');history.back();</script>";
        }
    }

    //移动端删除沟通记录
    public function communicationDelete()
    {
        $id = $_GET['id'];
        DB::beginTransaction();
        try{
            $res = Communication::find($id)
                ->delete();
            DB::commit();
            return "<script>alert('删除完成');location.href='/agent_sale/communication'</script>";
        }catch (Exception $e){
            DB::rollBack();
            return "<script>alert('删除失败，请稍后再试');</script>";
        }


    }

    //pc端代理人添加沟通记录的视图层
    public function communicationBase()
    {
        $authentication  = 'index';
        $cust_where = [];
        $product_where = [];
        $option  = 'index';
        $agent_id = $_COOKIE['agent_id'];
        $ditch_id = $this->getMyDitch($agent_id);
        if(isset($_GET['cust_search']) && $_GET['cust_search'] != ''){
            switch($_GET['cust_select']){
                case 1:
                    $cust_where = [
                        ['name','like','%'.$_GET['cust_search'].'%']
                    ];
                    break;
                case 2:
                    $cust_where = [
                        ['code','like','%'.$_GET['cust_search'].'%']
                    ];
                    break;
                case 3:
                    $cust_where = [
                        ['phone','like','%'.$_GET['cust_search'].'%']
                    ];
                    break;
                case 4:
                    $cust_where = [
                        ['email','like','%'.$_GET['cust_search'].'%']
                    ];
                    break;
            }
        }
        if(isset($_GET['product_search']) && $_GET['product_search'] != ''){
            switch($_GET['product_select']){
                case 1:
                    $product_where = [
                        ['product_name','like','%'.$_GET['product_search'].'%']
                    ];
                    break;
                case 2:
                    $product_where = [
                        ['company_name','like','%'.$_GET['product_search'].'%']
                    ];
                    break;
                case 3:
                    $product_where = [
                        ['phone','like','%'.$_GET['product_search'].'%']
                    ];
                    break;
                case 4:
                    $product_where = [
                        ['base_ratio',$_GET['product_search']]
                    ];
                    break;
            }
        }else{
            $product_where = [
                ['product_name','like','%']
            ];
        }
        //获取客户(个人)
        $cust = User::where('type','user')
            ->where($cust_where)->
            whereHas('custRule',function($q) use ($agent_id){
                $q->where('from_id',$agent_id)
                    ->orWhere(function($query) use ($agent_id){
                        $query->where('agent_id',$agent_id);
                    });
            })
                ->get();
        //获取企业客户
        $cust_company = User::where('type','company')
            ->with('trueFirmInfo')
            ->whereHas('custRule',function($q) use ($agent_id){
                $q->where('from_id',$agent_id)
                    ->orWhere(function($query) use ($agent_id){
                        $query->where('agent_id',$agent_id);
                    });
            })
            ->get();
        $count = count($cust);
        $count_company = count($cust_company);
        //获取产品列表
        $market = MarketDitchRelation::where([
            ['agent_id',$agent_id],
            ['status','on']
        ])->pluck('ty_product_id');
        $product_list = Product::where($product_where)
            ->whereIn('ty_product_id',$market)
            ->where('ty_product_id','>=',0)
            ->get();
        foreach($product_list as $k=>$v){
            $v['rate'] = $this->marketDitchRelationRepository->getMyAgentBrokerage($v->ty_product_id,$ditch_id,$agent_id);
            $v['premium'] = $this->getProductPremium($v->ty_product_id);
            $v['jsons'] = json_decode($v['json'],true);
            if(isset(json_decode($v->json,true)['clauses'])){
                foreach(json_decode($v->json,true)['clauses'] as $kk=>$vv){
                    if($vv['type'] == 'main')
                    {
                        $v['main_name'] = $vv['name'];
                    }
                }
            }
        }
        $count_product = count($product_list);
        //沟通记录
        if(isset($_GET['search'])){
            $data = Communication::where('agent_id',$_COOKIE['agent_id'])
                ->with('product')
                ->whereHas('user',function($q){
                    $q->where('real_name','like','%'.$_GET["search"].'%');
                })
                ->paginate(config('list_num.frontend.communication'));
        }else{
            $data = Communication::where('agent_id',$_COOKIE['agent_id'])
                ->with('user','product')
                ->paginate(config('list_num.frontend.communication'));
        }
        $message_data = Messages::where([
            ['accept_id',$_COOKIE['agent_id']],
            ['status','<>',3]
        ])
            ->paginate(config('list_num.frontend.message'));
        $count_data = count($data);
//        dd($data);
        return view('frontend.agents.agent_communication.index',compact('count_data','count_product','message_data','cust_company','data','authentication','option','cust','product_list','count','count_company'));
    }

    //    我的需求
    public function demand(){
        return view('frontend.agents.demand.demand');
    }

    //发送需求工单
    public function demandAdd(Requests $request){
        $input = $request->all();

        DB::beginTransaction();
        try{
            //添加到工单表
            $data = new LiabilityDemand();
            $data->module = $input['moduleId'];
            $data->recipient_id = $input['receiverId'];
            $data->title = $input['title'];
            $data->agent_id = $_COOKIE['agent_id'];
            $data->content = $input['content'];
            $data->status = 1;
            $data->save();

//            //添加到内容表
            $comment = new Comment();
            $comment->commentable_type = 'App\Models\LiabilityDemand';
            $comment->commentable_id = $data->id;
            $comment->send_id = $_COOKIE['agent_id'];
            $comment->recipient_id = $input['receiverId'];
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



//    我的工单列表
    public function workorder(){
        //获取当前代理人发送的工单
        $data = LiabilityDemand::where('agent_id',$_COOKIE['agent_id'])
            ->paginate(config('list_num.frontend.demand'));

        return view("frontend.agents.demand.workorder",compact('data'));
    }

    //   删除工单
    public function deleteWorkList($id){
        $data = LiabilityDemand::where('id',$id)
            ->delete();
        $res = Comment::where('commentable_id',$id)
            ->delete();
        return "<script>alert('删除成功');location.href='/agent_sale/workorder'</script>";
    }

    //详情页面
    public function workDetail($id){
        $data = LiabilityDemand::where('id',$id)
            ->first();
        $content = Comment::where('commentable_id',$id)
            ->first();
        return view("frontend.agents.demand.workdetail",compact('data','content'));
    }


    //结束需求
    public function endWorkList(Requests $request)
    {
        $id = $request->id;
        DB::beginTransaction();
        try{
            $data = LiabilityDemand::where('id',$id)
                ->update(['status'=>3]);
            DB::commit();
            return ['status'=>200,'msg'=>'修改成功'];
        }catch (Exception $e){
            DB::rollBack();
            return ['status'=>400,'msg'=>'修改失败，请稍后再试'];
        }
    }

    public function replyList(){
        $input = $_GET;
        $id = $_GET['id'];
        $content = Comment::where('commentable_id',$id)
            ->get();
        return view('backend_v2.work.workorderhandle',compact('input','content'));
    }

    //    回复
    public function addReply(Requests $request){
        $input = $request->all();

        DB::beginTransaction();
        try{
            $data = new Comment();
            $data->commentable_type = 'App\Models\LiabilityDemand';
            $data->commentable_id =$input['id'];
            $data->send_id = $_COOKIE['agent_id'];
            $data->recipient_id = $input['recipient_id'];
            $data->content = $input['a'];
            $data->status = 1;
            $data->save();
            DB::commit();
            return ['status'=>200,'msg'=>'录入成功'];
        }catch (Exception $e){
            DB::rollBack();
            return ['status'=>400,'msg'=>'录入失败'];
        }

    }






    //    收件人
    public function recipients(){
        return view("frontend.agents.demand.addressee");
    }

    //    所属模块
    public function subordinateModule(){
        return view("frontend.agents.demand.module");
    }

    //添加成功
    public function addSuccess(){
        return view("frontend.agents.demand.addsucceed");
    }

    //代理人消息
    public function agentMessage()
    {
        $id = User::whereHas('agent',function($q){
            $q->where('id',$_COOKIE['agent_id']);
        })->pluck('id')->first();
        $data = Messages::where([
            ['accept_id',$id],
            ['status','<>',3],
            ['timing','<',date('Y-m-d H:i:s',time())]
        ])->get();
        $count = count($data);
        if($this->is_mobile()){
            return view('frontend.agents.mobile.agent_message',compact('count'));
        }
    }

    //代理人通知
    public function agentInfo()
    {
        $authentication = $this->isAuthentication($_COOKIE['agent_id']);
        $option = 'message';
        $id = $this->getAgentUserId();
        if(isset($_GET['search']) && $_GET['search'] == 'unlooked'){
            $data = Messages::where([
                ['accept_id',$id],
                ['status','<>',3],
                ['timing','<',date('Y-m-d H:i:s')]
            ])->paginate(config('list_num.frontend.message'));
        }else{
            $data = Messages::where([
                ['accept_id',$id],
                ['timing','<',date('Y-m-d H:i:s')]
            ])->paginate(config('list_num.frontend.message'));
        }

        $unlooked_data = Messages::where([
            ['accept_id',$id],
            ['status','<>',3],
            ['timing','<',date('Y-m-d H:i:s',time())]
        ])->get();
        $unlooked_count = count($unlooked_data);
        $count = count($data);
        if($this->is_mobile()){
            return view('frontend.agents.mobile.agent_info',compact('data'));
        }
        return view('frontend.agents.agent_message.index',compact('authentication','option','data','unlooked_data','count','unlooked_count'));
    }

    //代理人通知详情
    public function agentInfoDetail($id)
    {
        $data = Messages::where('id',$id)->first();
        if($data['status'] != 3){
            $res = Messages::where('id',$id)->update(['status'=>3,'look_time'=>date('Y-m-d H:i:s')]);
        }
        return view('frontend.agents.mobile.agent_info_detail',compact('data'));
    }

    //代理人pc端查看详情状态更改
    public function agentInfoLooked($id)
    {
        $data = Messages::where('id',$id)->first();
        if($data['status'] != 3){
            $res = Messages::where('id',$id)->update(['status'=>3,'look_time'=>date('Y-m-d H:i:s')]);
        }else{
            $res = true;
        }
        if($res){
            return ['status'=>200,'msg'=>'ok'];
        }else{
            return ['status'=>400,'msg'=>'error'];
        }
    }

    //删除一跳消息
    public function agentInfoDeleteOne($id)
    {
        $res_msg = Messages::where('id',$id)->delete();
        $res_comment = Comment::where('commentable_id',$id)->delete();
        if($res_comment && $res_msg){
            return ['status'=>200,'msg'=>'删除成功'];
        }else{
            return ['status'=>400,'msg'=>'删除失败，请重试'];
        }
    }

    //删除消息
    public function agentInfoDelete(Requests $request)
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

    //标记成已读
    public function changeInfoStatus(Requests $request)
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
}
