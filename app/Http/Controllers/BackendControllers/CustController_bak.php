<?php
/**
 * Created by PhpStorm.
 * User: dell01
 * Date: 2017/4/26
 * Time: 10:27
 */

namespace App\Http\Controllers\BackendControllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Mockery\CountValidator\Exception;
use Validator;
use App\Models\Cust;
use App\Models\CustRule;
use App\Models\ApplyRule;
use App\Models\ApplyRecords;
use App\Models\AgentCustRule;
use App\Models\Agent;
class CustController extends BaseController{

    protected $id;
    protected function getId()
    {
        return 1;
    }

    //封装一个方法，通过类型查找客户
    public function getCustByType($type)
    {
        if($type == 'all'||$type == 'person'||$type == 'company'){
            //获取所有客户
            if($type == 'all'){
                $find_arr = [['from_type',1],['cust.status','=',0]];
            }else{
                //按个人和企业客户获取
                if($type == 'person'){
                    $type_id = 0;
                }else{
                    $type_id = 1;
                }
                $find_arr = [['from_type',1],['type',$type_id],['cust.status','=',0]];
            }
            $result = DB::table('cust_rule')
                ->join('cust','cust_rule.cust_id','=','cust.id')
                ->where($find_arr)
                ->select('cust.*','cust_rule.type')
                ->orderBy('created_at','desc')
                ->get();
        }else if($type == 'distribution'||$type == 'un_distribution'){
            //按是否被分配获取
            if($type == 'distribution'){
                //查找已分配的客户
                $result = DB::table('cust')
                    ->join('cust_rule','cust_rule.cust_id','=','cust.id')
                    ->join('agent_cust_rule','agent_cust_rule.code','=','cust.code')
                    ->where([
                        ['agent_cust_rule.from_id',1],
                        ['cust_rule.from_type',1],
                        ['cust_rule.from_id',1],
                    ])->select('cust.*','cust_rule.type')
                    ->distinct()
                    ->paginate(config('list_num.backend.permissions'));
            }else{
                //获取未分配的客户,所有客户减去已分配客户
                $AllCust = $this->getCustByType('all');
                $DistributionCust = $this->getCustByType('distribution');
                foreach($AllCust as $k=>$value){
                    foreach($DistributionCust as $value1){
                        if($value->id == $value1->id){
                            unset($AllCust[$k]);
                        }
                    }
                }
                $result = $AllCust;
            }
        }else{
            return false;
        }
        return $result;
    }
    //封装一个方法，通过cust_id判断是否是自己 的客户
    public function isMyCust($cust_id)
    {
        $isMyCust = DB::table('cust_rule')
            ->join('cust','cust.id','=','cust_rule.cust_id')
            ->where([
                ['cust_id',$cust_id],
                ['from_type',1],
                ['from_id',1],
            ])->count();
        return $isMyCust;
    }



    public function index($type){
        $list = $this->getCustByType($type);
        $count = count($list);
        foreach ($list as  $input){
            $code = $input->code;
            $result = AgentCustRule::where([
                ['code',$code],
                ['from_id',1],
                ['status',1],
            ])->count();
            $input->distribute = $result;
        }
        if($type == 'all'||$type == 'person'||$type == 'company'){
            return view('backend.relation.index',['list'=>$list,'type'=>$type,'count'=>$count]);
        }else if($type == 'distribution'||$type == 'un_distribution'){
            return view('backend.relation.isDistribution',['list'=>$list,'type'=>$type,'count'=>$count]);
        }else{
            return back()->withErrors('非法操作');
        }
    }


    //关系管理（5.15,5.16） 用于中介公司查看所属客户及代理人的沟通记录
    public function getMyCust()
    {
        //获取自己的客户池信息，此客户池和代理信息无关
        $id = $this->getId();

    }


//    //获取所有的申请记录
//    public function getAllApply(){
//        $result=Apply::get();
//        var_dump($result);
//    }
    //获取未处理的申请记录,并查找相关信息
    public function getApply()
    {
        $result = $this->getApplyFunc('untreated');
        $count = count($result);
        $type = 'no';
        return view('backend.relation.applyList',['list'=>$result,'count'=>$count,'type'=>$type]);
    }
    //获取已经处理的申请列表
    public function getDealApply()
    {
        $result = $this->getApplyFunc('deal');
        $count = count($result);
        $type = 'deal';
        return view('backend.relation.applyList',['list'=>$result,'count'=>$count,'type'=>$type]);
    }
    //同意申请
    public function agreeApply($record_id)
    {
        $id = $this->getId();
        //读取记录
        $apply_record_array = ApplyRule::where('record_id',$record_id)
            ->first();
        //同意申请逻辑，1，该条申请通过，2.所有关于该客户的申请拒绝，
        $count = count($apply_record_array);

        if($count){
            $type = $apply_record_array->type;
            $code = $apply_record_array->code;
            $agent_id = $apply_record_array->agent_id;
            if($type == 1){
                $type_name = 'company';
            }else{
                $type_name = 'person';
            }
            DB::beginTransaction();
            try{
                //修改代理人客户关系表中的数据
                //获取该条申请的cust——id
                $cust_id = DB::table('apply_rule')
                    ->where([
                        ['code',$code],
                        ['agent_id',$agent_id],
                        ['status',0],
                        ['from_id',1],
                    ])->orderBy('created_at','desc')
                    ->first()->cust_id;
                //     //批量更新
                $this->changeRefuseApply($code);
                $this->changeAgreeApply($record_id);
                $this->changeAgentCustRule($code,$agent_id,$cust_id,$type);
                //判断自己的客户表中是否有该客户，如果没有，则添加
                $result4 = CustRule::where([
                    ['code',$code],
                    ['from_type',1],
                    ['from_id',1],
                ])->count();
                if($result4){

                }else{
                    $addArray = ApplyRecords::where('id',$record_id)
                        ->first();
                    $inputArray = array(
                        'name' => $addArray['name'],
                        'code' => $addArray['code'],
                        'phone' => $addArray['phone'],
                        'email' => $addArray['email'],
                        'type' => $type_name,
                        'from_type' => 1,
                    );
                    $this->addCustFunc($inputArray);
                }
                DB::commit();
                return back()->with('status','操作成功');
            }catch (Exception $e){
                DB::rollBack();
                return back()->withErrors('操作失败');
            }
        }else{
            return back()->withErrors('非法操作');
        }
    }
    //拒绝申请
    public function refuseApply($apply_id)
    {
        //aabbccd 进行判断，判断是否为管理员操作

        //改变状态
        $ApplyRule = ApplyRule::find($apply_id);
        $ApplyRule->status = 2;
        $result = $ApplyRule->save();
        if($result){
            return back()->with('stauts','操作成功');
        }else{
            return back()->withErrors('操作失败');
        }
    }

    //跳转添加客户页面
    public function addCust($type)
    {
        $type = $type;
        if($type != 'company'&&$type != 'person'){
            return back()->withErrors('非法操作');
        }else{
            $controller = 'add';
            return view('backend.relation.addCust',['type'=>$type,'controller'=>$controller]);
        }
    }
    //跳转修改客户信息页面
    public function editCust($type,$id)
    {
        $type = $type;
        if($type != 'company'&&$type != 'person'){
            return back()->withErrors('非法操作');
        }else{
            //判断是否是自己的客户
            $result = CustRule::where([
                ['from_id',1],
                ['from_type',1],
            ])->where('cust_id',$id)
                ->count();
            if($result){
                $controller = 'edit';
                //查找该客户的详细信息
                $detail = Cust::where('id',$id)
                    ->first();
                return view('backend.relation.addCust',['type'=>$type,'controller'=>$controller,'detail'=>$detail]);
            }else{
                return back()->withErrors('非法操作');
            }
        }
    }

    //封装一个添加客户的方法
    public function addCustFunc($input)
    {
        //判断是否有删除的客户信息
        $input = $input;
        $code = $input['code'];
        $is_del_cust = DB::table('cust_rule')
            ->join('cust','cust.id','=','cust_rule.cust_id')
            ->where([
                ['cust.code',$code],
                ['cust_rule.from_type',1],
                ['cust_rule.from_id',1],
                ['cust.status','!=',0],
            ])->select('cust.id')->first();
        $type = $input['type'];
        $validator = $this->checkAddCustPost($input);
        if ($validator->fails()) {
            echo returnJson('0','添加失败');
            return redirect('backend/relation/add_cust/'.$type)
                ->withErrors($validator)
                ->withInput();
        }else{
            if($is_del_cust){
                $Cust = Cust::find($is_del_cust->id);
                $Cust->name = $input['name'];
                $Cust->code = $input['code'];
                $Cust->email = $input['email'];
                $Cust->phone = $input['phone'];
                $Cust->status = 0;
                $result = $Cust->save();
                if($result){
                    return redirect('backend/relation/add_cust/'.$type)->with('status', '添加成功!');
                }else{
                    return false;
                }
            }else{
                //添加客户到客户池,同时添加到关系关联列表
                DB::beginTransaction();
                try{
                    if($type == 'company'){
                        $type_id = 1;
                    }else{
                        $type_id = 0;
                    }
                    $Cust = new Cust();
                    $CustArray = array(
                        'name'=>$input['name'],
                        'code'=>$input['code'],
                        'email'=>$input['email'],
                        'phone'=>$input['phone'],
                    );
                    $result1 = $this->add($Cust,$CustArray);
                    $CustRule = new CustRule();
                    $CustRuleArray = array(
                        'code'=>$input['code'],
                        'cust_id'=>$result1,
                        'agent_id'=>0,
                        'from_id'=>1,
                        'type'=>$type_id,
                        'status'=>0,
                        'from_type'=>1,
                    );
                    $result2 = $this->add($CustRule,$CustRuleArray);
                    if($result1&&$result2){
                        DB::commit();
                        return redirect('backend/relation/add_cust/'.$type)->with('status', '添加成功!');
                    }else{
                        DB::rollBack();
                        return false;
                    }
                }catch (Exception $e){
                    DB::rollBack();
                    return false;
                }
            }

        }
    }
    //用于添加客户池
    public function addCustSubmit($input=''){
        $input = Request::all();

        $validator = $this->checkAddCust($input);
        $type = $input['type'];
        if ($validator->fails()) {
            return redirect('backend/relation/add_cust/'.$type)
                ->withErrors($validator)
                ->withInput();
        }

        $result = $this->addCustFunc($input);
        if($result){
            return redirect('backend/relation/add_cust/'.$type)->with('status', '添加成功!');
        }else{
            return redirect('backend/relation/add_cust/'.$type)
                ->withErrors('status','添加失败')
                ->withInput();
        }
    }
    //修改客户信息
    public function editCustSubmit()
    {
        $input = Request::all();
        $id = $input['cust_id'];
        //对数据进行修改
        $Cust = Cust::find($id);
        $CustArray = array(
            'name'=>$input['name'],
            'phone'=>$input['phone'],
            'email'=>$input['email'],
        );
        $result = $this->edit($Cust,$CustArray);
        if($result){
            return redirect('/backend/relation/cust/all')->with('status','更新成功');
        }else{
            return back()->withErrors('更新失败');
        }
    }

    //获取客户的联系记录
    public function getEvolve($code,$cust_id)
    {
        //获取客户的名称
        $name = Cust::where('id',$cust_id)
            ->first();
        $cust_count = count($name);
        if($cust_count){
            $name = $name->name;
            //读取该客户的联系记录,同时查找当前的客户的联系状态
            $evolve_list = DB::table('evolve_rule')
                ->join('evolve','evolve_rule.evolve_id','=','evolve.id')
                ->leftjoin('status','evolve.evolve_status','=','status.id')
                ->join('agents','agents.id','=','evolve_rule.agent_id')
                ->join('users','agents.user_id','=','users.id')
                ->where([
                    ['evolve_rule.code',$code]
                ])->select('evolve.*','status.status_name','users.name as agent_name')
                ->orderBy('evolve.created_at','desc')
                ->paginate(config('list_num.backend.permissions'));
            $count = count($evolve_list);
            return view('backend.relation.EvolveList',['count'=>$count,'list'=>$evolve_list,'name'=>$name]);
        }else{
            return back()->withErrors('非法操作');
        }
    }
    //修改状态
    public function changeCustStatus()
    {

    }

    //

    //客户管理(5.11,5.12 中介公司录入，分配，查看客户)
    //获得自己客户池的所有信息
    public function getAllCust(){
        $findarr["fid"]=1;
        //获得自己的所有的客户
        $cidarr=CustRule::where($findarr)->get(["cid"])->toArray();
        $custarr["id"]=$cidarr;
        $result=Cust::where($custarr)->get()->toArray();
        var_dump($result);
//        return view("backend.relation.index",["cust"=>$result]);
    }













    //保单管理5.23 5.24 用于中介公司录入，分配，查看客户的保单
    public function addWarranty()
    {
        $addarr=[];
    }
    //控制层验证
    protected function checkAddCustPost($input)
    {
        //规则
        $rules = [
            'name' => 'required',
            'code' => 'required',
        ];

        //自定义错误信息
        $messages = [
            'required' => 'The :attribute is null.',
        ];
        //验证
        $validator = Validator::make($input,$rules,$messages);
        return $validator;
    }




    //进行客户分配,跳转到分配页面
    public function distribute($type,$cust_id)
    {
        //判断是否是自己的客户
        $result = $this->isMyCust($cust_id);
        if($result){
            $cust = Cust::where('id',$cust_id)
                ->first();
            if(!is_null($cust)){
                $code = $cust->code;
            }
        }else{
            return back()->withErrors('非法操作');
        }
        if($type == 'apply'){
            //通过客户id获取客户的详细信息
            $cust_detail = Cust::where('id',$cust_id)
                ->first();
            //获取该客户的未处理申请，如果没有，则跳转到自由分配页面
            $result = $this->getApplyFunc($cust_id);
            $count = count($result);
        }else if($type == 'free'){
            $count = 1;
            //查找所有的代理人
            $result = $this->getAgent();
        }else if($type == 'rewrite'){
          $apply_rule = ApplyRule::where('code',$code)->get();
          $apply_records = ApplyRecords::where('code',$code)->get();
//          dump($apply_records);
//          dump($apply_rule);
            return view('backend.relation.oldapply',['type'=>$type,'list'=>$result,'cust'=>$cust,'cust_id'=>$cust_id])
                ->with('rule',$apply_rule)
                ->with('records',$apply_records);
        }
        if($count == 0){
            $type = 'free';
        }
        return view('backend.relation.distribute',['type'=>$type,'list'=>$result,'count'=>$count,'cust'=>$cust,'cust_id'=>$cust_id]);

    }

    public function distributeCust($code,$agent_id)
    {
        //判断该代理人是否有该客户的申请，
        $record_id = $this->isAgentApplyCust($agent_id,$code);
        $cust_rule = CustRule::where([
            ['code',$code],
            ['from_type',1],
            ['from_id',1],
        ])->first();
        $company_cust_id = $cust_rule->cust_id;
        $cust = Cust::where('id',$company_cust_id)
            ->first();
        $type = $cust_rule->type;
        $cust_array = array(
            'name'=>$cust->name,
            'code'=>$cust->code,
            'email'=>$cust->email,
            'phone'=>$cust->phone,
            'status'=>0,
        );
        if($record_id){
            //说明申请了
            DB::beginTransaction();
            try{
                $this->changeRefuseApply($code);//将所有申请变为拒绝
                $this->changeAgreeApply($record_id);//将该代理人申请的记录变为通过
                //判断代理人是否有该客户的信息
                $result = $this->isAgentCust($agent_id,$code);
                if(!$result){
                    //说明没有，添加数据
                    $Cust = new Cust();
                    $cust_id = $this->add($Cust,$cust_array);
                    $CustRule = new CustRule();
                    $cust_rule_array = array(
                        'code'=>$code,
                        'cust_id'=>$cust_id,
                        'from_id'=>1,
                        'agent_id'=>$agent_id,
                        'type'=>$type,
                        'from_type'=>0,
                        'status'=>0,
                    );
                    $this->add($CustRule,$cust_rule_array);
                }else{
                    $cust_id = CustRule::where([
                        ['agent_id',$agent_id],
                        ['code',$code],
                        ['from_type',0],
                        ['from_id',1],
                    ])->first()->cust_id;
                }
                $this->changeAgentCustRule($code,$agent_id,$cust_id,$type);
                DB::commit();
                return back()->with('status','操作成功');
            }catch (Exception $e){
                DB::rollBack();
                return back()->withErrors('操作失败');
            }
        }else{
            //说明没有申请,则将所有申请拒绝，
            DB::beginTransaction();
            try{
                $this->changeRefuseApply($code);//将所有的申请变为拒绝
                $result = $this->isAgentCust($agent_id,$code);
                if(!$result){
                    //说明没有，添加数据
                    $Cust = new Cust();
                    $cust_id = $this->add($Cust,$cust_array);
                    $CustRule = new CustRule();
                    $cust_rule_array = array(
                        'code'=>$code,
                        'cust_id'=>$cust_id,
                        'from_id'=>1,
                        'agent_id'=>$agent_id,
                        'type'=>$type,
                        'from_type'=>0,
                        'status'=>0,
                    );
                    $this->add($CustRule,$cust_rule_array);
                }else{
                    $cust_id = CustRule::where([
                        ['agent_id',$agent_id],
                        ['code',$code],
                        ['from_type',0],
                        ['from_id',1],
                    ])->first()->cust_id;
                }
                $this->changeAgentCustRule($code,$agent_id,$cust_id,$type);
                DB::commit();
                return back()->with('status','操作成功');
            }catch (Exception $e){
                DB::rollBack();
                return back()->withErrors('操作失败');
            }
        }
    }
    //客户分配申请

    //删除客户
    public function delCust()
    {
        $input = Request::all();
        $cust_id = $input['cust_id'];
        //判断是否是自己的客户
        $is_my_cust = $this->isMyCust($cust_id);
        if($is_my_cust){
            $cust = Cust::where('id',$cust_id)->first();
            $parent_id = $cust->status;
            $status_id = -1;
//            $result = $this->changeStatus($parent_id,$status_id);
//            if($result){
                $cust->status = -1;
                $result = $cust->save();
                if($result){
                    echo returnJson('200','删除成功');
                }else{
                    echo returnJson('0','删除失败');
                }
//            }else{
//                echo returnJson('0','删除失败');
//            }


        }else{
            echo returnJson('0','删除失败');
        }

    }


    //ajax判断客户是否已经被分配
    public function isDistributionAjax()
    {
        $input = Request::all();
        $code = $input['code'];
        //ccccccccc
        $result = AgentCustRule::where([
            ['code',$code],
            ['from_id',1],
            ['status',1],
        ])->count();
        if($result){
            echo returnJson('200','客户已经被分配了');
        }else{
            echo returnJson('0','客户尚未分配');
        }
    }
    //ajax判断自己的客户池总是否有该客户
    public function isMyCustAjax()
    {
        $input = Request::all();
        $code = $input['code'];
        $cust = DB::table('cust')
            ->join('cust_rule','cust.id','=','cust_rule.cust_id')
            ->where([
                ['cust.code',$code],
                ['cust_rule.from_type',1],
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

    //封装一个方法，用来判断该代理人是否申请了该客户
    public function isAgentApplyCust($agent_id,$code)
    {
        $result = DB::table('apply_rule')
            ->join('apply_record','apply_rule.record_id','=','apply_record.id')
            ->where('apply_rule.agent_id',1)
            ->where('apply_rule.code',1111)
            ->first();
        $count = count($result);
        if($count){
            //说明申请了
            return $result->record_id;
        }else{
            //说明没有申请
            return false;
        }
    }
    //封装一个方法，用来判断代理人是否有该客户的信息
    public function isAgentCust($agent_id,$code)
    {
        $result = DB::table('cust_rule')
            ->join('cust','cust.id','=','cust_rule.cust_id')
            ->where([
                ['agent_id',$agent_id],
                ['cust_rule.code',$code],
                ['from_id',1],

            ])->count();
        return $result;
    }
    //封装一个方法，用来修改申请记录
    public function changeAgreeApply($record_id)
    {
        //将同意的记录改为审核通过
        ApplyRule::where('record_id',$record_id)
            ->update(['status'=>1]);
    }
    //封装一个方法，把所有申请该客户的申请记录变为拒绝
    public function changeRefuseApply($code)
    {
        //批量更新
        ApplyRule::where('code',$code)
            ->update(['status'=>2]);
    }
    //封装一个方法，用来修改申请记录表中的数据
    public function changeAgentCustRule($code,$agent_id,$cust_id,$type)
    {
        //修改代理人客户关系表中的数据
        $old_rule = AgentCustRule::where('code',$code)
            ->count();
        if($old_rule){
            AgentCustRule::where('code',$code)
                ->update(['status'=>0]);
        }
        $count = AgentCustRule::where([
            ['code',$code],
            ['agent_id',$agent_id],
        ])->count();
        if($count){
            //说明已经有记录，更新
            AgentCustRule::where([
                ['code',$code],
                ['agent_id',$agent_id],
            ])->update(['status'=>1,'cust_id'=>$cust_id]);
        }else{
            //说明没有记录，添加
            $AgentCustRule = new AgentCustRule();
            $AgentCustRuleArray = array(
                'agent_id'=>$agent_id,
                'code'=>$code,
                'from_id'=>1,
                'status'=>1,
                'cust_id'=>$cust_id,
                'type'=>$type,
            );
            $this->add($AgentCustRule,$AgentCustRuleArray);
        }
    }
    //封装一个方法，获取申请记录
    public function getApplyFunc($type)
    {
        if($type == 'untreated'){
            //        aabbccd 需要关联 状态表和 代理人表
            $result = DB::table('apply_rule')
                ->join('apply_record','apply_rule.record_id','=','apply_record.id')
                ->join('agents','apply_rule.agent_id','=','agents.id')
                ->join('users','agents.user_id','=','users.id')
                ->orderBy('apply_rule.code')
                ->select('apply_record.*','apply_rule.type','users.real_name','users.code as user_code','apply_rule.id as apply_id')
                ->where('apply_rule.status','=','0')
                ->paginate(config('list_num.backend.cust'));
        }else if($type == 'deal'){
            //        aabbccd 需要关联 状态表和 代理人表
            $result = DB::table('apply_rule')
                ->join('apply_record','apply_rule.record_id','=','apply_record.id')
                ->join('agents','apply_rule.agent_id','=','agents.id')
                ->join('users','agents.user_id','=','users.id')
                ->orderBy('apply_rule.code')
                ->select('apply_record.*','apply_rule.type','users.real_name','users.code as user_code','apply_rule.id as apply_id','apply_rule.status')
                ->where('apply_rule.status','!=','0')
                ->paginate(config('list_num.backend.cust'));
        }else if(is_numeric($type)){
            //说明查找某个客户的申请记录
            $cust_array = Cust::where('id',$type)
                ->first();
            $code = $cust_array->code;
            //通过身份证查找所有的申请记录
            $result = DB::table('apply_rule')
                ->join('apply_record','apply_rule.record_id','=','apply_record.id')
                ->join('agents','apply_rule.agent_id','=','agents.id')
                ->join('users','agents.user_id','=','users.id')
                ->where('apply_rule.code',$code)
                ->where('apply_rule.status','=',0)
                ->select('apply_record.*','apply_rule.type','users.real_name','users.code as user_code','apply_rule.id as apply_id')
                ->paginate(config('list_num.backend.cust'));
        }else{
            return false;
        }
        return $result;
    }
    //封装一个方法，用来获取代理人和相关信息
    public function getAgent()
    {
        $result = DB::table('agents')
            ->join('users','agents.user_id','=','users.id')
            ->select('agents.*','users.real_name','users.code','users.name')
            ->get();
        return $result;
    }


    //添加客户验证
    protected function checkAddCust($input)
    {
        //规则
        $rules = [
            'name' => 'required|string|min:2|max:50',
        ];

        //自定义错误信息
        $messages = [
            'name.min' => '名称长度过短',
            'name.max' => '请输入正确长度的名称'
        ];
        //验证
        $validator = Validator::make($input, $rules, $messages);
        return $validator;
    }



}