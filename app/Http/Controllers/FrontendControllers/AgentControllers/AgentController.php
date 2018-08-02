<?php
/**
 * Created by PhpStorm.
 * User: dell01
 * Date: 2017/4/27
 * Time: 18:34
 */
namespace App\Http\Controllers\FrontendControllers\AgentControllers;

use App\Helper\RsaSignHelp;
use App\Helper\UploadFileHelper;
use App\Http\Controllers\FrontendControllers\BaseController;
use App\Models\Agent;
use App\Models\Authentication;
use App\Models\AuthenticationPerson;
use App\Models\CustRule;
use App\Models\MarketDitchRelation;
use App\Models\Messages;
use App\Models\OrderBrokerage;
use App\Models\Product;
use App\Models\TrueUserInfo;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
//use Doctrine\Common\Cache\Cache;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Ixudra\Curl\Facades\Curl;
use Mockery\CountValidator\Exception;
use Request;
use App\Models\ApplyRecords;
use App\Models\AgentCustRule;
use App\Models\ApplyRule;
use App\Models\Cust;
use App\Models\Evolve;
use App\Models\EvolveRule;
use Illuminate\Http\Request as Requests;
class  AgentController extends BaseController{

    protected $_signHelp;

    public function __construct(\Illuminate\Http\Request $request)
    {
        $this->_request = $request;
        $this->_signHelp = new RsaSignHelp();
    }
    //获取自己的id

    //默认跳转yemian
    public function agentindex()
    {
        $option = 'index';
        $dith_id = $this->getMyDitch($_COOKIE['agent_id']);
        $agent_user_id = $this->getAgentUserId();
        if($agent_user_id){
            $message_data = Messages::where([
                ['accept_id',$agent_user_id],
                ['status','<>',3]
            ])
                ->paginate(config('list_num.frontend.message'));
        }
        $data = OrderBrokerage::where('agent_id',$_COOKIE['agent_id'])
            ->sum('user_earnings');
        $count = count($data);
        $product_list = $this->getMyAgentProduct($_COOKIE['agent_id']);//获取所有的产品列表
//        dd($product_list);
        foreach($product_list as $k=>$v){
            $v['rate'] = $this->getMyAgentBrokerage($v->ty_product_id,$dith_id,$_COOKIE['agent_id']);
            $v['premium'] = $v['base_price'];
            foreach(json_decode($v->json,true)['clauses'] as $kk=>$vv){
                if($vv['type'] == 'main')
                {
                    $v['main_name'] = $vv['name'];
                }
            }
        }
        $product_count = count($product_list);
        $authentication = $this->isAuthentication($_COOKIE['agent_id']);
        //佣金
        $brokerage = OrderBrokerage::where('agent_id',$_COOKIE['agent_id'])
            ->groupBy(DB::raw('DATE_FORMAT(created_at, "%m")'))
            ->select(
                DB::raw('sum(user_earnings) as sum_earnings,Sum(order_pay) as pay,count(id) as math'),
                DB::raw('DATE_FORMAT(created_at, "%m") as month')
            )
            ->take(3)
            ->get();
        if($this->is_mobile()){
            return view('frontend.agents.mobile.index',compact('data','count','product_count','product_list','authentication','brokerage'));
        }
        return view('frontend.agents.agent_plan.index',compact('option','data','product_list','authentication','brokerage','message_data'));
    }

    //获取自己的客户池
    public function getMyCust($type)
    {
        //获取自己的客户池信息，此客户池和代理信息无关
        $agent_id = $this->checkAgent();
        if(!$agent_id){
            return redirect('/')->withErrors('非法操作');
        }
        $list = $this->getCustList($type,$agent_id);
        $count = count($list);
        return view('frontend.agents.agent.MyCust',['list'=>$list,'type'=>$type,'count'=>$count]);
    }
    //跳转到添加页面
    public function addCust($type)
    {
        $agent_id = $this->checkAgent();
        if(!$agent_id){
            return back()->withErrors('非法操作');
        }
        if($type!='person'&&$type != 'company'){
            return back()->withErrors('非法操作');
        }
        $controller = 'add';
        return view('frontend.agents.agent.add',compact('controller','type'));
    }
    //添加客户发送请求方法
    public function addCustSubmit()
    {
        $input = Request::all();
        $result = $this->addCustFunc($input);
        if($result){
            return back()->with('status','添加成功');
        }else{
            return back()->withErrors('添加失败');
        }
    }
    //跳转到编辑页面
    public function editCust($type,$cust_id)
    {
        $agent_id = $this->checkAgent();
        if($type!='person'&&$type!='company'){
            return back()->withErrors('非法操作');
        }
        if($type == 'person'){
            $type_id = 0;
        }else{
            $type_id = 1;
        }
        //判断该客户是否是自己的客户
        $result = CustRule::where([
            ['cust_id',$cust_id],
            ['agent_id',$agent_id],
            ['from_type',0],
            ['type',$type_id],
        ])->count();
        if($result){
            //获取该客户的详细信息
            $detail = Cust::where('id',$cust_id)->first();
            return view('frontend.agents.agent.edit',compact('controller','type','cust_id','detail'));
        }else{
            return back()->withErrors('非法操作');
        }
    }
    //修改客户信息
    public function editCustSubmit()
    {
        $input = Request::all();
        //修改客户的信息
        $Cust = Cust::find($input['cust_id']);
        $CustArray = array(
            'name'=>$input['name'],
            'phone'=>$input['phone'],
            'email'=>$input['email']
        );
        $result = $this->edit($Cust,$CustArray);
        if($result){
            return back()->with('status','更新成功');
        }else{
            return back()->withErrors('更新失败');
        }
    }
    //客户管理 5.25 5.26 查看所属的客户信息，申请客户，记录销售轨迹
    //获取自己代理的客户
    public function getCust($type)
    {
        $agent_id = $this->checkAgent();
        if(!$agent_id) {
            return back()->withErrors('非法操作');
        }
        $list = $this->getMyAgentCust($type,$agent_id);
        $count = count($list);
        return view('frontend.agents.agent.index',compact('count','list','type'));
    }
    //跳转申请页面
    public function apply($type)
    {
        $agent_id = $this->checkAgent();
        if(!$agent_id){
            return back()->withErrors('非法操作');
        }
//        if($type == 'person'){
//            $type_id = 0;
//        }else{
//            $type_id = 1;
//        }
        if($type != 'person'&&$type != 'company'){
            return back()->withErrors('非法操作');
        }
        $controller = 'apply';
        return view('frontend.agents.agent.apply',['agent_id'=>$agent_id,'type'=>$type,'controller'=>$controller,'data'=>0]);
    }
    //通过客户的cust_id进行申请
    public function applyByCustId($cust_id)
    {
        $agent_id = $this->checkAgent();
        if(!$agent_id){
            return back()->withErrors('非法操作');
        }
        $cust = CustRule::where('cust_id',$cust_id)->where('agent_id',$agent_id)->first();
        if($cust){
            //判断是否是自己的客户
            $code = $cust->code;
            $isCust = $this->isCust($code,$agent_id);
        }else{
            return back()->withErrors('错误');
        }
        if($isCust){
            //读取数据
            $cust_array = Cust::where('id',$cust_id)
                ->first();
            $cust_array = DB::table('cust')
                ->join('cust_rule','cust.id','=','cust_rule.cust_id')
                ->where('cust.id',$cust_id)
                ->select('cust.*','cust_rule.type')
                ->first();
            $type = $cust_array->type;
            if($type == 0){
                $type = 'person';
            }else{
                $type = 'company';
            }
            return view('frontend.agents.agent.apply',['agent_id'=>$agent_id,'controller'=>'apply','data'=>1,'type'=>$type,'value'=>$cust_array]);
        }else{
            return back()->withErrors('错误');
        }
    }
    //申请提交页面
    public function applySubmit()
    {
        $agent_id = $this->checkAgent();
        if(!$agent_id){
            return back()->withErrors('非法操作');
        }
        $input = Request::all();

        $code = $input['code'];
        $type = $input['type'];
        if($type == 'person'){
            $type_id = 0;
        }else if($type == 'company'){
            $type_id = 1;
        }else{
            return back()->withErrors('非法操作');
        }
        //判断是否已经被分配了
        $isDistribution = $this->isDistribution($code);
        if($isDistribution){
            //判断自己是否提交过申请
            $isSubmit = $this->isSubmit($agent_id,$code);
            if($isSubmit){
                return back()->withErrors('已经提交过申请了');
            }else{
                //判断cust中是否有记录
                $Cust = $this->isCust($code,$agent_id);
                $addArray = array(
                    'name'=>$input['name'],
                    'code'=>$input['code'],
                    'phone'=>$input['phone'],
                    'email'=>$input['email'],
                );
                DB::beginTransaction();
                try{
                    if($Cust){
                        $cust_id = $Cust->id;
                        //说明有记录，更新
                        Cust::where('id',$cust_id)
                            ->update($addArray);
                    }else{
                        $addArray['type'] = $type_id;
                        $cust_id = $this->addCustFunc($addArray);
                    }
                    //添加到申请记录表中
                    $ApplyRecordArray = array(
                        'code'=>$code,
                        'apply_remarks'=>$input['remarks'],
                        'name'=>$input['name'],
                        'phone'=>$input['phone'],
                        'email'=>$input['email'],
                    );
                    $ApplyRecord = new ApplyRecords();
                    $result1 = $this->add($ApplyRecord,$ApplyRecordArray);
                    //添加到申请关系表中
                    $ApplyRuleArray = array(
                        'type'=>$type_id,
                        'record_id'=>$result1,
                        'agent_id'=>$agent_id,
                        'code'=>$code,
                        'cust_id'=>$cust_id,
                        'status'=>0,
                        'from_id'=>1,
                    );
                    $ApplyRule = new ApplyRule();
                    $result2 = $this->add($ApplyRule,$ApplyRuleArray);
                    if($cust_id&&$result1&&$result2){
                        DB::commit();
                        return back()->with('status','申请成功');
                    }else{
                        DB::rollBack();
                        return back()->withErrors('申请失败');
                    }
                }catch (Exception $e){
                    DB::rollBack();
                    return back()->withErrors('申请失败');
                }

            }
        }else{
            return back()->withErrors('该客户已经被分配了');
        }
    }
    //查看联系记录
    public function getEvolve($code,$cust_id)
    {
        //获取联系记录
        $agent_id = $this->checkAgent();
        //判断是否有联系记录
        $list = EvolveRule::where([
            ['agent_id',$agent_id],
            ['code',$code],
        ])->get();
        $count = count($list);
        //查找客户的名称
        $name = Cust::where('id',$cust_id)
            ->select('name')->first()->name;
        if($count){
            //说明有联系记录，查询联系记录
            $list = DB::table('evolve')
                ->join('evolve_rule','evolve.id','=','evolve_rule.evolve_id')
                ->where([
                    ['evolve_rule.agent_id',$agent_id],
                    ['evolve_rule.code',$code],
                ])->select('evolve.*')
                ->get();
        }else{
            //无联系记录
            $list = '';
        }
        return view('frontend.agents.agent.EvolveList',['count'=>$count,'name'=>$name,'list'=>$list]);
    }
    //跳转添加联系记录页面
    public function addEvolve($cust_id)
    {
        $agent_id = $this->checkAgent();
        if(!$agent_id){
            return back()->withErrors('非法操作');
        }
        //判断是否是自己的客户
        $Cust = $this->checkCustId($cust_id,$agent_id);
        if($Cust){
            //添加联系状态
            $code = $Cust->code;
            $controller = 'add';
            //获取所有的状态
            $table = 'evolve';
            $field = 'status';
            $field_id = $this->getFieldId($table,$field);
            $status_list = $this->getStatusByFieldId($field_id);
            return view('frontend.agents.agent.evolve',compact('controller','status_list','cust_id','code'));
        }else{
            return redirect('/agent/index/all')->withErrors('非法操作');
        }
    }
    //添加联系记录
    public function addEvolveSubmit()
    {
        $input = Request::all();
        $cust_id = $input['cust_id'];
        $agent_id = $this->checkAgent();
        if(!$agent_id){
            return back()->withErrors('非法操作');
        }
        $Cust = $this->checkCustId($cust_id,$agent_id);
        $isCust = count($Cust);
        if($isCust){
            //添加到联系表和联系记录表中
            DB::beginTransaction();
            try{
                $Evolve = new Evolve();
                $EvolveArray = array(
                    'evolve_way'=>$input['evolve_way'],
                    'evolve_person'=>$input['evolve_person'],
                    'evolve_status'=>$input['evolve_status'],
                    'remarks'=>$input['remarks'],
                    'status'=>1
                );
                $evolve_id = $this->add($Evolve,$EvolveArray);
                $EvolveRule = new EvolveRule();
                $EvolveRuleArray = array(
                    'evolve_id'=>$evolve_id,
                    'agent_id'=>$agent_id,
                    'from_id'=>1,
                    'cust_id'=>$cust_id,
                    'code'=>$input['code'],
                    'status'=>1
                );
                $result = $this->add($EvolveRule,$EvolveRuleArray);
                if($cust_id && $result){
                    DB::commit();
                    return back()->with('status','添加成功');
                }else{
                    DB::rollBack();
                    return back()->withErrors('添加失败');
                }
            }catch (Exception $e){
                return back()->withErrors('添加失败');
            }
        }else{
            return back()->withErrors('错误');
        }
    }
    //查看个人的申请记录
    public function getApply($type)
    {
        //用来获取不同雷星的申请记录
        $apply_list = $this->getApplyListByType($type);
        $count = count($apply_list);
        return view('frontend.agents.agent.ApplyRecord',compact('apply_list','count','type'));
    }
    //封装一个方法，用来获取不同雷星的申请记录
    public function getApplyListByType($type)
    {
        $agent_id = $this->checkAgent();
        if($type == 'all'){
            $condition = [['agent_id',$agent_id]];
        }else if($type == 'agree'){
            $condition = [['agent_id',$agent_id],['status',1]];
        }else if($type == 'refuse'){
            $condition = [['agent_id',$agent_id],['status',2]];
        }else if($type == 'no_deal'){
            $condition = [['agent_id',$agent_id],['status',0]];
        }
        $result = ApplyRule::where($condition)->with('cust')->get();
        return $result;
    }


    //封装方法，判断cust_id是否是自己的代理客户
    public function checkCustId($cust_id,$agent_id)
    {
        $isCust = AgentCustRule::where('cust_id',$cust_id)
            ->where('agent_id',$agent_id)->first();
        return $isCust;
    }
    //封装一个添加客户的方法
    public function addCustFunc($input)
    {
        $input = $input;
        $agent_id = $this->checkAgent();
        if(!$agent_id){
            return back()->withErrors('非法操作');
        }
        //判断该客户是否有删除记录
        $code = $input['code'];
        $is_del_cust = DB::table('cust_rule')
            ->join('cust','cust.id','=','cust_rule.cust_id')
            ->where([
                ['cust.code',$code],
                ['cust_rule.from_type',1],
                ['cust_rule.from_id',1],
                ['cust.status','!=',0],
            ])->select('cust.id')->first();
        //添加到cust表中，同时添加到cust_rule表中
        //判断是否已经添加过了
        $code = $input['code'];
            if($is_del_cust){
                $Cust = Cust::find($is_del_cust->id);
                $Cust->name = $input['name'];
                $Cust->code = $input['code'];
                $Cust->email = $input['email'];
                $Cust->phone = $input['phone'];
                $Cust->status = 0;
                $result = $Cust->save();
                if($result){
                    return redirect('backend/relation/add/'.$input['type'])->with('status', '添加成功!');
                }else{
                    return false;
                }
            }else {
                DB::beginTransaction();
                try {
                    $Cust = new Cust();
                    $CustArray = array(
                        'name' => $input['name'],
                        'code' => $code,
                        'email' => $input['email'],
                        'phone' => $input['phone'],
                        'status' => 0,
                    );
                    $cust_id = $this->add($Cust, $CustArray);
                    $CustRule = new CustRule();
                    $CustRuleArray = array(
                        'code' => $code,
                        'cust_id' => $cust_id,
                        'agent_id' => $agent_id,
                        'from_id' => 1,
                        'type' => $input['type'],
                        'from_type' => 0,
                        'status' => 0,
                    );
                    $result = $this->add($CustRule, $CustRuleArray);
                    if ($cust_id && $result) {
                        DB::commit();
                        return $cust_id;
                    } else {
                        DB::rollBack();
                        return false;
                    }
                } catch (Exception $e) {
                    DB::rollBack();
                    return false;
                }
            }
    }
    //删除客户
    public function delCust()
    {
        $input = Request::all();
        $cust_id = $input['cust_id'];
        //判断是否是自己的客户
        $is_my_cust = $this->isMyCust($cust_id);
        if($is_my_cust){
            $cust = Cust::where('id',$cust_id)->first();
            $cust->status = -1;
            $result = $cust->save();
            if($result){
                echo returnJson('200','删除成功');
            }else{
                echo returnJson('0','删除失败');
            }
        }else{
            echo returnJson('0','删除失败');
        }

    }



    //ajax判断是否已经有该客户
    public function isMyCustAjax()
    {
        $input = Request::all();
        $code = $input['code'];
        $cust = DB::table('cust')
            ->join('cust_rule','cust.id','=','cust_rule.cust_id')
            ->where([
                ['cust.code',$code],
                ['cust_rule.from_type',0],
                ['cust_rule.from_id',1],
                ['cust.status',0]
            ])->first();
        $result = count($cust);
        if($result){
            echo returnJson('200',$cust->id);
        }else{
            echo returnJson('0','尚未添加过该客户');
        }
    }
    //封装一个方法，判断客户是否在cust表中
    public function isCust($code,$agent_id)
    {
        //判断是否在cust表中有记录
        $result = CustRule::where([
            ['code',$code],
            ['agent_id',$agent_id],
            ['from_type',0],
        ])->first();
        $count = count($result);
        if($count){
            return $result;
        }else{
            return false;
        }
    }

    //封装一个方法，用来判断是否是自己的客户
    public function isMyCust($cust_id){
        $agent_id = $this->checkAgent();
        $result = CustRule::where('cust_id',$cust_id)
            ->where('agent_id',$agent_id)
            ->first();
        return $result;
    }



    //控制层验证添加联系记录
    protected function checkAddEvolvePost($input)
    {
        //规则
        $rules = [
            'evolve_person' => 'required',
            'evolve_way' => 'required',
        ];

        //自定义错误信息
        $messages = [
            'required' => 'The :attribute is null.',
        ];
        //验证
        $validator = Validator::make($input,$rules,$messages);
        return $validator;
    }

    //封装一个方法，用来获取二级状态
    public function getStatus($status_name){
        $father_id_obj = DB::table('status_classify')
            ->where('status_name',$status_name)
            ->first();
        $count = count($father_id_obj);
        if($count){
            $father_id = $father_id_obj->id;
            $status_list = DB::table('status_classify')
                ->where('status_father_id',$father_id)
                ->get();
            return $status_list;
        }else{
            return back()->withErrors('错误');
        }
    }
    //封装一个方法，用来获取客户列表
    public function getCustList($type,$agent_id)
    {
        if($type == 'all'){
            $list = DB::table('cust_rule')
                ->join('cust','cust.id','=','cust_rule.cust_id')
                ->where([
                    ['agent_id',$agent_id],
                    ['from_id',1],
                    ['cust.status','<>','-1']
                ])->paginate(config('list_num.backend.permissions'));
        }else if($type == 'person'||$type == 'company'){
            if($type == 'person'){
                $type_id = 0;
            }else{
                $type_id = 1;
            }
            //获取个人客户或者是企业客户
            $list = DB::table('cust_rule')
                ->join('cust','cust.id','=','cust_rule.cust_id')
                ->where([
                    ['agent_id',$agent_id],
                    ['from_id',1],
                    ['type',$type_id],
                    ['cust.status','!=','-1']
                ])->paginate(config('list_num.backend.permissions'));
        }else{
            return false;
        }
        return $list;
    }
    //封装一个方法，验证是否已经被分配
    public function isDistribution($code)
    {
        $isDistribution = AgentCustRule::where([
            ['code',$code],
            ['status',1]
        ])->count();
        if($isDistribution){
            return false;
        }else{
            return true;
        }
    }
    //封装一个方法，判断是否已经提交过申请
    public function isSubmit($agent_id,$code)
    {
        $isSubmit = ApplyRule::where([
            ['agent_id',$agent_id],
            ['code',$code],
            ['status',0]
        ])->count();
        if($isSubmit){
            return true;
        }else{
            return false;
        }
    }
    //封装一个方法，用来按类型获取自己代理的客户
    public function getMyAgentCust($type,$agent_id)
    {
        if($type == 'all'){
            //获取自己代理的所有的客户
            $result = DB::table('agent_cust_rule')
                ->join('cust','agent_cust_rule.cust_id','=','cust.id')
                ->where([
                    ['agent_id',$agent_id],
                    ['agent_cust_rule.status',1],
                ])->select('cust.*','agent_cust_rule.type')
                ->orderBy('cust.created_at','desc')
                ->get();
        }else{
            if($type == 'person'){
                $type_id = 0;
            }else if($type == 'company'){
                $type_id = 1;
            }else{
                return false;
            }
            $result = DB::table('agent_cust_rule')
                ->join('cust','cust.id','=','agent_cust_rule.cust_id')
                ->where([
                    ['agent_cust_rule.type',$type_id],
                    ['agent_id',$agent_id],
                    ['agent_cust_rule.status',1],
                ])->select('cust.*','agent_cust_rule.type')
                ->orderBy('cust.created_at','desc')
                ->get();
        }
        return $result;
    }

    // 计算佣金比
    /**
     * @param $product_id
     * @param $ditch_id
     * @param $agent_id
     * @return array
     */
    public function getMyAgentBrokerage($product_id, $ditch_id, $agent_id)
    {
        $condition = array(
//            'type'=>'agent',
            'ty_product_id'=>$product_id,
            'ditch_id'=>$ditch_id,
            'agent_id'=>$agent_id,
        );
        $brokerage = MarketDitchRelation::where($condition)
            ->first();
        if(!$brokerage){
            //进行渠道统一查询
            $condition = array(
                'ty_product_id'=>$product_id,
                'ditch_id'=>$ditch_id,
                'agent_id'=>0,
            );
            $brokerage = MarketDitchRelation::where($condition)
                ->first();
            if(!$brokerage){//产品统一查询
                $condition = array(
//                    'type'=>'product',
                    'ty_product_id'=>$product_id,
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
        return array(
            'earning'=>$earning,  //佣金比
//            'scaling'=>$scaling   //折标系数
            'scaling'=>array()   //折标系数
        );
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

    //代理人认证页面
    public function account()
    {
        $option = 'account';
        $data = Agent::with('user')
            ->where('id',$_COOKIE['agent_id'])
            ->first();
//        dd($data);
        $res = DB::table('users')
            ->join('agents','agents.user_id','users.id')
            ->join('authentication_person','authentication_person.user_id','users.id')
            ->where('agents.id',$_COOKIE['agent_id'])
            ->where('authentication_person.status','<>',1)
            ->select('users.*','agents.job_number as num')
            ->first();
        $agent_data = DB::table('users')
            ->join('agents','users.id','agents.user_id')
            ->join('true_user_info','users.id','true_user_info.user_id')
            ->where('agents.id',$_COOKIE['agent_id'])
            ->select('true_user_info.*')
            ->first();
//        dd($agent_data);
        $ditch = Agent::with('ditches')
            ->where('id',$_COOKIE['agent_id'])
            ->first();
        $authentication = $this->isAuthentication($_COOKIE['agent_id']);
        if($res){
            return view('frontend.agents.agent_account.account',compact('option','res','agent_data','ditch','authentication'));
        }else{
            return view('frontend.agents.agent_account.index',compact('option','data','ditch','authentication'));
        }
    }

    //去认证
    public function accountApprove()
    {
        $option = 'account';
        $data = Agent::with('user')
            ->where('id',$_COOKIE['agent_id'])
            ->first();
        $ditch = Agent::with('ditches')
            ->where('id',$_COOKIE['agent_id'])
            ->first();
        $authentication = $this->isAuthentication($_COOKIE['agent_id']);
        return view('frontend.agents.agent_account.account_approve',compact('option','data','ditch','authentication'));
    }

    //认证数据提交
    public function accountApproveSubmit(\Illuminate\Http\Request $request)
    {
        $data = Agent::with('user')
            ->where('id',$_COOKIE['agent_id'])
            ->first();
        $input = $request->all();
        if(!isset($input['email']) || !isset($input['up']) || !isset($input['down']) || !isset($input['person']) || !filter_var($input['email'],FILTER_VALIDATE_EMAIL)){
            return "<script>alert('请按要求填写完所有内容后再提交数据');history.back();</script>";
        }
        DB::beginTransaction();
        try{
            //添加到users表
            $user_res = User::where('phone',$data->user['phone'])
                ->update(['email'=>$input['email']]);
            //更改agent认证状态(部分地方未使用新的认证状态 条件判断)
            Agent::where('id',$_COOKIE['agent_id'])
                ->update(['certification_status'=>1]);
            //添加到认证表
            $authentication = new AuthenticationPerson();
            $authentication->user_id = $data->user['id'];
            $authentication->name = $data->user['name'];
            $authentication->status = 2;
            $authentication->id_type = 1;
            $authentication_res = $authentication->save();
            //添加到认证信息表
            $up_path = UploadFileHelper::uploadImage($input['up'],'upload/frontend/person_approve/');
            $down_path = UploadFileHelper::uploadImage($input['down'],'upload/frontend/person_approve/');
            $person_path = UploadFileHelper::uploadImage($input['person'],'upload/frontend/person_approve/');
            $true_person = new TrueUserInfo();
            $true_person->user_id = $data->user['id'];
            $true_person->card_img_front = $up_path;
            $true_person->card_img_backend = $down_path;
            $true_person->card_img_person = $person_path;
            $true_person_res = $true_person->save();
            DB::commit();
            return "<script>location.href='/agent/account_approve_success';</script>";
        }catch (Exception $e){
            DB::rollBack();
            return "<script>alert('信息录入失败，请确认信息是否正确');history.back();</script>";
        }
    }

    //认证成功页面
    public function accountApproveSuccess()
    {
        $option = 'account';
        $authentication = $this->isAuthentication($_COOKIE['agent_id']);
        return view('frontend.agents.agent_account.account_approve_success',compact('option','authentication'));
    }

    //认证完修改密码
    public function accountResetPassword()
    {
        $option = 'account';
        $data = Agent::with('user')
            ->where('id',$_COOKIE['agent_id'])
            ->first();
        $authentication = $this->isAuthentication($_COOKIE['agent_id']);
        return view('frontend.agents.agent_account.account_reset_password',compact('option','data','authentication'));
    }

    //修改密码
    public function resetPassword(\Illuminate\Http\Request $request)
    {
        $input = $request->all();
        $data = Agent::with('user')
            ->where('id',$_COOKIE['agent_id'])
            ->first();
        if(!Auth::attempt(['phone'=>$input['phone'],'password'=>$input['psw']])){
            return "<script>alert('您输入的密码错误，请重新输入！');history.back();</script>";
        }
        $authentication = $this->isAuthentication($_COOKIE['agent_id']);
        $option = 'account';
        return view('frontend.agents.agent_account.reset_password',compact('option','data','authentication'));
    }

    //修改密码数据提交
    public function resetPasswordSubmit(\Illuminate\Http\Request $request)
    {
        $input = $request->all();
        $email = User::with(['agent'=>function($q){
            $q->where('id',$_COOKIE['agent_id']);
        }])->first();
//        dd(session($input['']))
        if(!$input['npsw'] || !$input['renpsw'] || $input['npsw'] != $input['renpsw'])
        {
            return "<script>alert('两次输入的密码不同，请重新输入');history.back();</script>";
        }
        if($input['code'] != session($email['email']))
        {
            return "<script>alert('验证码输入错误');history.back();</script>";
        }
        $res = User::where('phone',$input['phone'])
            ->update(['password'=>bcrypt($input['npsw'])]);
        if($res){
            return "<script>location.href='/agent/reset_password_success'</script>";
        }else{
            return "<script>alert('修改失败，请稍后再试');</script>";
        }
    }

    //重新修改密码成功
    public function resetPasswordSuccess()
    {
        $option = 'account';
        $authentication = $this->isAuthentication($_COOKIE['agent_id']);
        return view('frontend.agents.agent_account.reset_password_success',compact('option','authentication'));
    }

    //移动端修改密码页面
    public function resetPsw()
    {
        $data = User::whereHas('agent',function($q){
            $q->where('id',$_COOKIE['agent_id']);
        })->first();
//        dd($data);
        return view('frontend.agents.mobile.reset_psw',compact('data'));
    }

    //移动端检验验证码
    public function checkCode(\Illuminate\Http\Request $request)
    {
        $input = $request->all();
        $phone = $input['phone'];
        $data = Agent::where('work_status',1)
            ->pluck('phone')->toArray();
        if(!in_array($phone,$data)){
            return "<script>alert('该账号不是代理人账号或您已离职');history.back();</script>";
        }
        $code = $input['code'];
        $res = $this->checkPhoneCode($phone,$code);
        return $res;
    }

    //重设密码第二部
    public function resetPswStepSecond()
    {
        return view('frontend.agents.mobile.reset_psw_step_second');
    }

    //移动端修改密码校验旧密码
    public function mobileCheckAgent(Requests $request)
    {
        $input = $request->all();
//        dd($input);
        $data = User::with(['agent'=>function($q){
            $q->where('id',$_COOKIE['agent_id']);
        }])->first();
//        dd($data);
        if(!Auth::attempt(['phone'=>$data['phone'],'password'=>$input['old']])){
            return ['status'=>401,'msg'=>'旧密码错误'];
        }
        if($input['new'] != $input['rePsw']){
            return ['status'=>402,'msg'=>'两次输入的密码不同'];
        }
        $agent = Agent::where('id',$_COOKIE['agent_id'])->first();
        $res = $agent->user->update(['users.password'=>bcrypt($input['new'])]);
        if($res){
            return ['status'=>200,'msg'=>'修改成功'];
        }else{
            return ['status'=>400,'msg'=>'修改失败，请稍后重试'];
        }
    }

    //修改密码成功
    public function resetPswSuccess()
    {
        return view('frontend.agents.mobile.reset_psw_success');
    }

    //验证验证码(封装的检测方法)
    protected function checkPhoneCode($phone, $phone_code)
    {
        if(!Cache::get("reg_code_".$phone))
            return ['status'=>'error', 'message'=>'验证码不存在，请重新发送'];
        if(Cache::get("reg_code_".$phone) != $phone_code)
            return ['status'=>'error', 'message'=>'验证码错误'];
        Cache::forget("reg_code_".$phone);
        return ['status'=> 'success', 'message'=>'验证码正确'];
    }

    //代理人修改个人信息
    public function accountEdit()
    {
        $option = 'account';
        $data = Agent::with('user')
            ->where('id',$_COOKIE['agent_id'])
            ->first();
        $res = Agent::where('id',$_COOKIE['agent_id'])
            ->with('user')->first();
        $agent_data = Agent::where('id',$_COOKIE['agent_id'])
            ->with('user.trueUserInfo')
            ->first();
        $ditch = Agent::with('ditches')
            ->where('id',$_COOKIE['agent_id'])
            ->first();
        $authentication = $this->isAuthentication($_COOKIE['agent_id']);
        if($this->is_mobile()){
            return view('frontend.agents.mobile.account_edit',compact('data','res','agent_data','ditch'));
        }
        return view('frontend.agents.agent_account.account_edit',compact('option','data','res','agent_data','ditch','authentication'));
    }

    //编辑数据提交
    public function accountEditSubmit(\Illuminate\Http\Request $request)
    {
        $data = Agent::with('user')
            ->where('id',$_COOKIE['agent_id'])
            ->first();
        $agent_data = Agent::where('id',$_COOKIE['agent_id'])
            ->with('user.user_authentication_person')
            ->first();
        if( isset($agent_data->user->user_authentication_person['status']) && $agent_data->user->user_authentication_person['status'] != 1){
            return "<script>alert('您已经提交过认证，不需要重新提交');history.back();</script>";
        }
        $input = $request->all();
        if(!isset($input['email']) || !isset($input['up']) || !isset($input['down']) || !isset($input['person']) || !filter_var($input['email'],FILTER_VALIDATE_EMAIL)){
            return "<script>alert('请按要求填写完所有内容后再提交数据');location.href='/agent/account_edit';</script>";
        }
        DB::beginTransaction();
        try{
            //添加到users表
            $user_res = User::where('phone',$data->user['phone'])
                ->update(['email'=>$input['email']]);
            //添加到认证表
            $authentication = new AuthenticationPerson();
            $authentication->user_id = $data->user['id'];
            $authentication->name = $data->user['name'];
            $authentication->status = 2;
            $authentication->id_type = 1;
            $authentication_res = $authentication->save();
            //添加到认证信息表
            $up_path = UploadFileHelper::uploadImage($input['up'],'upload/frontend/person_approve/');
            $down_path = UploadFileHelper::uploadImage($input['down'],'upload/frontend/person_approve/');
            $person_path = UploadFileHelper::uploadImage($input['person'],'upload/frontend/person_approve/');
            $true_person = new TrueUserInfo();
            $true_person->user_id = $data->user['id'];
            $true_person->card_img_front = $up_path;
            $true_person->card_img_backend = $down_path;
            $true_person->card_img_person = $person_path;
            $true_person_res = $true_person->save();
            DB::commit();
            return "<script>location.href='/agent/account_edit_success';</script>";
        }catch (Exception $e){
            DB::rollBack();
            return "<script>alert('信息录入失败，请确认信息是否正确');history.back();</script>";
        }
    }

    //修改成功
    public function accountEditSuccess()
    {
        $option = 'account';
        $authentication = $this->isAuthentication($_COOKIE['agent_id']);
        if($this->is_mobile()){
            return view('frontend.agents.mobile.success_edit');
        }
        return view('frontend.agents.agent_account.account_edit_success',compact('option','authentication'));
    }


}
