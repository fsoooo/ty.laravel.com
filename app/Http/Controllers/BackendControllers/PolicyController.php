<?php
/**
 * Created by PhpStorm.
 * User: dell01
 * Date: 2017/5/2
 * Time: 18:12
 */
namespace App\Http\Controllers\BackendControllers;
use App\Http\Controllers\BackendControllers;
use App\Models\Agent;
use App\Models\Clause;
use App\Models\CodeType;
use App\Models\Company;
use App\Models\Ditch;
use App\Models\DitchAgent;
use App\Models\MarketDitchRelation;
use App\Models\Order;
use App\Models\OrderBrokerage;
use App\Models\Product;
use App\Models\Warranty;
use App\Models\CompanyBrokerage;
use App\Models\WarrantyPolicy;
use App\Models\WarrantyRecognizee;
use App\Models\WarrantyRelation;
use App\Models\WarrantyRule;
use App\Services\ReadExcel;
use App\Services\UploadImage;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Ixudra\Curl\Facades\Curl;
use Mockery\CountValidator\Exception;
use Illuminate\Support\Facades\DB;
use Excel;
use Log;
use Illuminate\Support\Facades\Auth;

class PolicyController extends BaseController
{
    //个人保单
    public function index()
    {
        $status_id = $this->request->id ??  "";//保单状态:全部保单-1，保障中1，失效2，待生效0，退保3
        $deal_type = $this->request->type ?? "";//成交方式：线上0，线下1，全部-2
        $agent = $this->request->agent ?? "";//代理人 全部-2
        $data_agent = Agent::where('work_status',1)
            ->with('user')
            ->get();
        //全部保单
        if($status_id == -1 || $status_id == ""){
            $warranty_res = WarrantyRule::with('warranty')->where('warranty_id','<>','')->get();
            $warranty_res = WarrantyRule::with([
                'warranty_rule_product',//产品信息
                'warranty',//保单信息
                'policy',//投保人信息
                'beneficiary',//受益人信息
                'warranty_rule_order'=>function($a){
                    $a->where('status','1');
                },//订单信息
                'warranty_rule_order.order_agent',//代理人信息
                'warranty_rule_order.warranty_recognizee',//被保人信息
                'warranty_rule_order.order_brokerage',//渠道佣金
                'warranty_rule_order.order_user',//订单关联佣金
            ])
                ->whereHas('warranty',function($a) use ($deal_type){
                    if($deal_type!='-2'){
                        $a->where('deal_type',$deal_type);
                    }
                })
                ->paginate(config('list_num.backend.agent'));
//            dd($warranty_res[9]);die;
        }else {
            //全部保单（成交方式）
            if($deal_type == -2 || $deal_type == ""){
                $warranty_res = WarrantyRule::with([
                    'warranty_product',//产品信息
                    'warranty',//保单信息
                    'policy',//投保人信息
                    'beneficiary',//受益人信息
                    'warranty_rule_order'=>function($a){
                        $a->where('status','1');
                    },//订单信息
                    'warranty_rule_order.order_agent',//代理人信息
                    'warranty_rule_order.warranty_recognizee',//被保人信息
                    'warranty_rule_order.order_brokerage',//渠道佣金
                    'warranty_rule_order.order_user',//订单关联佣金
                ])
                    ->where('status',$status_id)
                    ->whereHas('warranty',function($a) use ($deal_type){
                        if($deal_type!='-2'){
                            $a->where('deal_type',$deal_type);
                        }
                    })
                    ->paginate(config('list_num.backend.agent'));
            }elseif($agent == "" || $agent == -2){
                $warranty_res = WarrantyRule::with([
                    'warranty_product',//产品信息
                    'warranty',//保单信息
                    'policy',//投保人信息
                    'beneficiary',//受益人信息
                    'warranty_rule_order'=>function($a){
                        $a->where('status','1');
                    },//订单信息
                    'warranty_rule_order.order_agent',//代理人信息
                    'warranty_rule_order.warranty_recognizee',//被保人信息
                    'warranty_rule_order.order_brokerage',//渠道佣金
                    'warranty_rule_order.order_user',//订单关联佣金
                ])
                    ->where('status',$status_id)
                    ->paginate(config('list_num.backend.agent'));
            }else{
                $warranty_res = WarrantyRule::with([
                    'warranty_product',//产品信息
                    'warranty',//保单信息
                    'policy',//投保人信息
                    'beneficiary',//受益人信息
                    'warranty_rule_order'=>function($a){
                        $a->where('status','1');
                    },//订单信息
                    'warranty_rule_order.order_agent',//代理人信息
                    'warranty_rule_order.warranty_recognizee',//被保人信息
                    'warranty_rule_order.order_brokerage',//渠道佣金
                    'warranty_rule_order.order_user',//订单关联佣金
                ])
                    ->where('status',$status_id)
                    ->whereHas('agent',function($q) use ($agent){
                        $q->where('id',$agent);
                    })
                    ->whereHas('warranty',function($a) use ($deal_type){
                        $a->where('deal_type',$deal_type);
                    })
                    ->paginate(config('list_num.backend.agent'));
            }
        }
        $list = $warranty_res;
        return view('backend_v2.policy.index',compact("list","status_id","deal_type","data_agent","agent"));
    }
    //个人保单详情
    public function policy_details()
    {
        $id = $this->request->id;
        $warranty_res = WarrantyRule::with([
            'warranty_rule_product',//产品信息
            'warranty',//保单信息
            'policy',//投保人信息
            'beneficiary',//受益人信息
            'warranty_rule_order'=>function($a){
                $a->where('status','1');
            },//订单信息
            'warranty_rule_order.order_agent',//代理人信息
            'warranty_rule_order.warranty_recognizee',//被保人信息
            'warranty_rule_order.order_brokerage',//渠道佣金
            'warranty_rule_order.order_user',//订单关联客户
        ])
            ->whereHas('warranty',function($a) use ($id){
                $a->where('id',$id);
            })
            ->first();
        $product_res = $warranty_res['warranty_rule_product'] ?? "";
        if(!empty($product_res)){
            $json = json_decode($product_res['json'],true);
        }else{
            $json = [];
        }
        $warranty =  $warranty_res['warranty'] ?? "";
        $policy =  $warranty_res['policy'] ?? "";
        $beneficiary =  $warranty_res['beneficiary'] ?? "";
        $order =  $warranty_res['warranty_rule_order'] ?? "";
        if(!empty($order)){
            $order_agent = $order['order_agent'];
            $warranty_recognizee = $order['warranty_recognizee'];
            $order_brokerage = $order['order_brokerage'];
            $order_user = $order['order_user'];
        }
        return view('backend_v2.policy.policy_details')
            ->with('product_res',$product_res)
            ->with('json',$json)
            ->with('warranty',$warranty)
            ->with('policy',$policy)
            ->with('beneficiary',$beneficiary)
            ->with('order',$order)
            ->with('order_agent',$order_agent)
            ->with('warranty_recognizees',$warranty_recognizee)
            ->with('order_brokerage',$order_brokerage)
            ->with('order_user',$order_user);

    }

    //下载个人保单
    public function exportPolicyPerson(Request $request)
    {
        $input = $request->all();
        $get = json_decode($input['get'],true);
        unset($input['_token']);
        unset($input['get']);
        $title = [
            'warranty_code'=>'保单号',
            'agent'=>'代理人(空代表没有代理人)',
            'start_time'=>'起保时间',
            'brokerage'=>'代理人佣金(空代表没有佣金,以分为单位)',
            'end_time'=>'截止时间',
            'policy_type'=>'保单来源(0代表线上，1代表线下)',
            'product_name'=>'保单产品',
            'phone'=>'投保人联系电话',
            'premium'=>'保费(以分为单位)',
            'created_at'=>'订单时间',
            'policy_status'=>'保单状态(待生效0,保障中1,失效2,退保3)'
        ];
        $conditions = [
            'warranty_code'=>'warranty.warranty_code',
            'agent'=>'users.name',
            'start_time'=>'warranty.start_time',
            'brokerage'=>'order_brokerage.user_earnings',
            'end_time'=>'warranty.end_time',
            'policy_type'=>'warranty.deal_type',
            'product_name'=>'product.product_name',
            'phone'=>'warranty_policy.phone',
            'premium'=>'warranty.premium',
            'created_at'=>'order.created_at',
            'policy_status'=>'warranty.status'
        ];
        foreach($input as $k=>$v){
            if(!$v){
                unset($title[$k]);
                unset($conditions[$k]);
            }
        }
        $final_data = [];
        $final_data[] = $title;
        $data = DB::table('warranty_rule')
            ->join('warranty','warranty.id','warranty_rule.warranty_id')
            ->join('warranty_policy','warranty_policy.id','warranty_rule.policy_id')
            ->join('product','product.ty_product_id','warranty_rule.ty_product_id')
            ->join('order','order.id','warranty_rule.order_id')
            ->leftJoin('agents','warranty_rule.agent_id','agents.id')
            ->leftJoin('users','users.id','agents.user_id')
            ->leftJoin('order_brokerage','order_brokerage.order_id','warranty_rule.order_id')->where('product.insure_type',1);
        if(isset($get['type']) && $get['type'] != -2){
            $data->where('warranty.deal_type',$get['type']);
        }
        if(isset($get['id']) && $get['id'] != -1){
            $data->where('warranty.status',$get['id']);
        }
        if(isset($get['agent']) && $get['agent'] != -2){
            $data->where('agents.id',$get['agent']);
        }
        $data = $data->select($conditions)->get();
        foreach($data as $k=>$v){
            $final_data[] = json_decode(json_encode($v),true);
        }
        $name = '保单数据'.date('YmdHis',time());
        $res = Excel::create(iconv('UTF-8', 'GBK', $name),function($excel) use ($final_data){
            $excel->sheet('score', function($sheet) use ($final_data){
                $sheet->rows($final_data);
            });
        })->store('xls',public_path('download/warranty'))->export('xls');
        if($res){
            return redirect(url('/download/warranty'.$name).'xls');
        }
    }

    public function download($file)
    {
        return response()->download($file,'保单数据'.'.xls');
    }

    //企业保单
    public function policy_company()
    {
        $status_id = $this->request->id ?? "";
        $select = [
            'warranty.id',
            'warranty.warranty_code',
            'warranty.status',
            'warranty.premium',
            'warranty.created_at',
            'product.product_name',
            'users.name',
            'users.phone',
            'users.code',
            'company_brokerage.brokerage',
            'user.name as agent_name',
        ];
        if($status_id == -1 || $status_id ==""){
            $policy_company = WarrantyRule::join('product','warranty_rule.ty_product_id','product.ty_product_id');
            $policy_company->join('warranty','warranty_rule.warranty_id','warranty.id');
            $policy_company->join('order','warranty_rule.order_id','order.id');
            $policy_company->join('users','order.user_id','users.id');
            $policy_company->leftjoin('company_brokerage','warranty_rule.warranty_id','company_brokerage.warranty_id');
            $policy_company->leftjoin('agents','warranty_rule.agent_id','agents.id');
            $policy_company->leftjoin('users as user','agents.user_id','user.id');
            $policy_company->where('users.type','company');
            $policy_company->select($select);
            $list = $policy_company->paginate(config('list_num.backend.agent'));
        }else{
            $policy_company = WarrantyRule::join('product','warranty_rule.ty_product_id','product.ty_product_id');
            $policy_company->join('warranty','warranty_rule.warranty_id','warranty.id');
            $policy_company->join('order','warranty_rule.order_id','order.id');
            $policy_company->join('users','order.user_id','users.id');
            $policy_company->leftjoin('company_brokerage','warranty_rule.warranty_id','company_brokerage.warranty_id');
            $policy_company->leftjoin('agents','warranty_rule.agent_id','agents.id');
            $policy_company->leftjoin('users as user','agents.user_id','user.id');
            $policy_company->where('users.type','company');
            $policy_company->where('warranty.status',$status_id);
            $policy_company->select($select);
            $list = $policy_company->paginate(config('list_num.backend.agent'));
        }
        return view('backend_v2.policy.policy_company',compact("list","status_id"));
    }


    //企业保单详情
    public function policy_company_details()
    {
        $id = $this->request->id;
        $product = Warranty::where('warranty_id',$id)
            ->join('warranty_rule','warranty_rule.warranty_id','warranty.id')
            ->join('product','warranty_rule.ty_product_id','product.ty_product_id')
            ->join('order','warranty_rule.order_id','order.id')
            ->first();
        $item = json_decode($product->json, true);

        $brokerage = CompanyBrokerage::where('warranty_id',$id)->select('brokerage')->first();//佣金
        $ditches = WarrantyRule::where('warranty_id',$id)
            ->join('ditches','warranty_rule.ditch_id','ditches.id')
            ->select('name')->first(); //渠道

        //        渠道佣金
        $order_brokerage =  WarrantyRule::where('warranty_id',$id)
            ->join('order_brokerage','warranty_rule.order_id','order_brokerage.order_id')
            ->select("user_earnings")->first();

        //代理人
        $agent_name = WarrantyRule::where('warranty_id',$id)
            ->leftjoin('agents','warranty_rule.agent_id','agents.id')
            ->leftjoin('users as user','agents.user_id','user.id')
            ->select('real_name')->first();
        //受益人
        $warranty_beneficiary = WarrantyRule::where('warranty_id', $id)->with("beneficiary")->first();

        //被保人
        $warranty_recognizee = WarrantyRule::where('warranty_id', $id)
            ->join('warranty_recognizee','warranty_rule.order_id','warranty_recognizee.order_id')
            ->paginate(config('list_num.backend.ditches'));


        return view('backend_v2.policy.policy_company_details',compact('product','item','warranty_beneficiary','brokerage','ditches','order_brokerage','agent_name','warranty_recognizee'));
    }

    //线下单列表页
    public function policyOffline()
    {
        //正在上传的文件名和进度
        $fileSession = is_null(session('result')) ? NULL : json_decode(session('result'),true);
        if(!is_null($fileSession)){
            $fileName = $fileSession['fileName'];
            $percent = $fileSession['percent'];
        }else{
            $fileName = $percent = NULL;
        }
        //如果文件上传失败
        $excelErrorMsg = is_null(session('excelErrorMsg')) ? NULL : session('excelErrorMsg');
        //获取线下单列表
        $warrantyList = DB::table('warranty_rule')
            ->leftJoin('agents','warranty_rule.agent_id', '=', 'agents.id')
            ->leftJoin('users','users.id', '=', 'agents.user_id')
            ->leftJoin('product','warranty_rule.ty_product_id', '=', 'product.ty_product_id')
            ->leftJoin('warranty','warranty_rule.warranty_id', '=', 'warranty.id')
            ->where('warranty.deal_type',1)
            ->select(
                'warranty.created_at',
                'warranty.start_time',
                'warranty.warranty_code',
                'product.product_name',
                'users.name',
                'warranty.status',
                'warranty_rule.id'
            )
            ->get();
        $list = NULl;
        if(!is_null($warrantyList)){
            $list = Warranty::where('deal_type',1)->paginate(config('list_num.backend.agent'));
        }
//        return $warrantyList;
        return view('backend_v2.policy.policy_offline',compact('list','fileName','percent','excelErrorMsg','warrantyList'));
    }

    //线下单详情页
    public function policyOfflineDetails(Request $request)
    {
        $warranty_rule_id = $request->get('warranty_rule_id');
        //更新失败弹出提示信息
        $errorMsg = is_null(session('errorMsg')) ? NULL : session('errorMsg');

        $warrantyDetail = DB::table('warranty_rule')
            ->leftJoin('agents','warranty_rule.agent_id', '=', 'agents.id')
            ->leftJoin('users','users.id', '=', 'agents.user_id')
            ->leftJoin('ditches','warranty_rule.ditch_id', '=', 'ditches.id')
            ->leftJoin('product','warranty_rule.ty_product_id', '=', 'product.ty_product_id')
            ->leftJoin('warranty','warranty_rule.warranty_id', '=', 'warranty.id')
            ->leftJoin('order_brokerage','warranty_rule.order_id', '=', 'order_brokerage.order_id')
            ->leftJoin('order','warranty_rule.order_id', '=', 'order.id')
            ->where('warranty_rule.id',$warranty_rule_id)
            ->where('warranty.deal_type',1)
            ->select(
                'product.company_name',
                'product.product_category',
                'product.insure_type',
                'product.product_name',
                'order_brokerage.by_stages_way',
                'order_brokerage.rate',
                'warranty.warranty_code',
                'warranty.premium',
                'warranty.start_time',
                'warranty.end_time',
                'order.pay_time',
                'users.name as agent_name',
                'ditches.name as ditch_name',
                'warranty.warranty_image'
            )
            ->get();
        $warrantyDetail = json_decode(json_encode($warrantyDetail), true)[0];
//        return $warrantyDetail;
        //渠道代理人二级联动
        $ditchId = $request->get('ditch_id');
        //所有的渠道列表
        $ditchList = Ditch::where('status','on')->get();
        //渠道对应的代理人列表
        if(is_null($ditchId)) {
            $ditchId = WarrantyRule::where('id',$warranty_rule_id)->select('ditch_id')->first()['ditch_id'];
        }
        $agentList = DitchAgent::with('agent.user:id,name')->where('ditch_id',$ditchId)->where('status','on')->get();
//        return $agentList;
        $agentId = $request->get('agent_id');
        if(is_null($agentId)) {
            $agentId = WarrantyRule::where('id',$warranty_rule_id)->select('agent_id')->first()['agent_id'];
        }
        //下次缴费时间
        if($warrantyDetail['by_stages_way'] != '0年'){
            $next_pay_time = substr($warrantyDetail['start_time'],0,4);
            do{
                $next_pay_time += $warrantyDetail['by_stages_way'];
            }while($next_pay_time <= date('Y'));
            $warrantyDetail['next_pay_time'] = $next_pay_time.substr($warrantyDetail['start_time'],4);
        }
        return view('backend_v2.policy.policy_offline_details',
            compact('warrantyDetail','ditchList','agentList','warranty_rule_id','ditchId','agentId','errorMsg'));
    }

    /**
     * 提交修改保单
     *
     * @param Request $request
     * @return string
     */
    public function updatePolicyOffline(Request $request)
    {
        $input = $request->all();
//        return $input;
        if(!is_null($input['warranty_image']) && $input['warranty_image'] != '') {
            $input['warranty_image'] = explode(',', $input['warranty_image']);
            foreach ($input['warranty_image'] as $key => $image) {
                $input['warranty_image'][$key] = strstr($image, '/upload');
            }
//            return $input['warranty_image'];
            $input['warranty_image'] = json_encode($input['warranty_image']);
        }
        $warrantyRuleList = WarrantyRule::with('warranty')->where('id',$input['warranty_rule_id'])->first();
//        return $warrantyRuleList;

        //判断要修改的保单号是否重复
        $warrantyList = Warranty::where('warranty_code',$input['warranty_code'])->where('id','<>',$warrantyRuleList['warranty_id'])->get();
        if(count($warrantyList) != 0){
            return redirect('/backend/policy/policy_offline_details?warranty_rule_id='.$input['warranty_rule_id'])->with('errorMsg', '保单号不允许重复！');
        }
        //判断要修改的佣金比是否高于渠道佣金比
        $marketDitchRelationList = MarketDitchRelation::where([
            'ty_product_id'=>$warrantyRuleList['ty_product_id'],
            'ditch_id'=>$warrantyRuleList['ditch_id'],
            'agent_id'=>0,
        ])->select('rate')->first();
        if(!is_null($marketDitchRelationList) && $marketDitchRelationList['rate'] < $input['rate']){
            return redirect('/backend/policy/policy_offline_details?warranty_rule_id='.$input['warranty_rule_id'])->with('errorMsg', '代理人佣金比不能高于所属渠道佣金比');
        }

        //结束时间的字符串拼接
        if(!is_null($input['end_time'])){
            $input['end_time'] = $input['end_time'].substr($warrantyRuleList['warranty']['end_time'],10);
        }

        $orderList = Order::where('id',$warrantyRuleList['order_id'])->select('pay_time')->first();
        //签订时间的字符串拼接
        if(!is_null($input['pay_time'])){
            $input['pay_time'] = $input['pay_time'].substr($orderList['pay_time'],10);
        }

        DB::beginTransaction();
        try{
            OrderBrokerage::where('order_id',$warrantyRuleList['order_id'])->update([
                'order_pay'=>$input['premium']*100,
                'by_stages_way'=>$input['by_stages_way'],
                'rate'=>$input['rate'],
                'user_earnings'=>$input['premium']*$input['rate'],
                'agent_id'=>$input['agent_id'],
                'ditch_id'=>$input['ditch_id'],
            ]);
            Warranty::where('id',$warrantyRuleList['warranty_id'])->update([
                'warranty_code'=>$input['warranty_code'],
                'premium'=>$input['premium']*100,
                'warranty_image'=>$input['warranty_image'],
                'start_time'=>$input['start_time'].substr($warrantyRuleList['warranty']['start_time'],10),
                'end_time'=>$input['end_time'],
            ]);
            Order::where('id',$warrantyRuleList['order_id'])->update([
                'by_stages_way'=>$input['by_stages_way'],
                'pay_time'=>$input['pay_time'],
                'premium'=>$input['premium']*100,
                'start_time'=>$input['start_time'].substr($warrantyRuleList['warranty']['start_time'],10),
                'end_time'=>$input['end_time'],
                'agent_id'=>$input['agent_id'],
                'ditch_id'=>$input['ditch_id'],

            ]);
            WarrantyRule::where('id',$input['warranty_rule_id'])->update([
                'premium'=>$input['premium']*100,
                'agent_id'=>$input['agent_id'],
                'ditch_id'=>$input['ditch_id'],
            ]);
            DB::commit();
        } catch (\Exception $e){
            DB::rollBack();
            return back()->withErrors($e->getMessage());
        }
        return redirect('/backend/policy/policy_offline');
    }

    //导入excel
    public function importOffline(Request $request)
    {
        $file = $request->file('file');
//        var_export($_FILES['file']);
        if (empty($file)) {
            return redirect('/backend/policy/policy_offline')->with('excelErrorMsg','上传的文件不能为空');
        }
        //上传文件大小不超过1M
        $filesize = round((abs(filesize($file))) / 1024, 1);
        if ($filesize > config('offline.fileSize')) {
            return redirect('/backend/policy/policy_offline')->with('excelErrorMsg','上传的文件不能大于1M');
        }
        //获取上传文件的原始名称
        $fileOrigin = $file->getClientOriginalName();
        //获取上传文件的扩展名
        $exteninfo = explode('.', $fileOrigin);
        $extension = strtolower($exteninfo[count($exteninfo) - 1]);

        if (!in_array($extension,config('offline.fileType'))) {
            return redirect('/backend/policy/policy_offline')->with('excelErrorMsg','文件格式不正确');
        }
        Log::info('$_FILES: ' . json_encode($_FILES));

        $result = ReadExcel::readExcel($_FILES,1);
        if($result){
            return redirect('/backend/policy/check_import_status')->with('status', '1');
        }else{
            return redirect('/backend/policy/policy_offline')->with('excelErrorMsg','文件内容不能为空');
        }
    }

    /**
     * excel数据更新
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \PHPExcel_Exception
     * @throws \PHPExcel_Reader_Exception
     */
    public function updateOffline()
    {
        $adminId = Auth::guard('admin')->user()->id;//当前登陆业管的ID 因为不止一个业管登陆可以导入线下单
        $fileStorageName = \Cache::get('offlineStorageName' . $adminId);
        $file["file"]["tmp_name"] = base_path().'/'.$fileStorageName;
        $file["file"]["name"] = \Cache::get('offlineExcelFileName'.$adminId);
        Log::info('update File: '.$file["file"]["name"]);
        $result = ReadExcel::readExcel($file,0);
        if($result){
            return redirect('/backend/policy/check_import_status')->with('status', '1');
        }else{
            return redirect('/backend/policy/policy_offline')->with('excelErrorMsg','文件内容不能为空');
        }
    }

    //查看导入状态（每秒钟请求一次）
    public function checkImportStatus()
    {
        $adminId = Auth::guard('admin')->user()->id;//当前登陆业管的ID 因为不止一个业管登陆可以导入线下单
        $total = \Cache::get('offlineJobTotal'.$adminId);
        $success = \Cache::get('offlineJobSuccess'.$adminId);
        $update = \Cache::get('offlineJobUpdate'.$adminId);
        $fail = \Cache::get('offlineJobFail'.$adminId);
        if($total == 0){
            return ['total'=>$total,'success'=>$success,'update'=>$update,'fail'=>$fail,'percent'=>0];
        }
        if(($success + $update + $fail) == $total){
            \Cache::forget('offlineJobTotal'.$adminId);
            \Cache::forget('offlineJobSuccess'.$adminId);
            \Cache::forget('offlineJobUpdate'.$adminId);
            \Cache::forget('offlineJobFail'.$adminId);
            //如果没有更新则删除文件
            if($update == 0 && \Cache::has('offlineStorageName'.$adminId)){
                unlink(base_path().'/'.\Cache::get('offlineStorageName'.$adminId));
                \Cache::forget('offlineStorageName'.$adminId);
            }
        }
        $percent = ceil(($success + $update + $fail)/$total*100);
//        return ['total'=>$total,'success'=>$success,'update'=>$update,'fail'=>$fail];
        if(is_null(session('status'))){//第二次之后访问只需要提供count数据
            return ['total'=>$total,'success'=>$success,'update'=>$update,'fail'=>$fail,'percent'=>$percent];
        }else{//上传后第一次访问，需要跳转到列表页
            //文件原名（用于展示）
            $fileName = \Cache::get('offlineExcelFileName'.$adminId);
            return redirect('/backend/policy/policy_offline')->with('result', json_encode(['percent'=>$percent,'fileName'=>$fileName]));
        }
    }

}
