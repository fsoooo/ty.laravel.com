<?php

namespace App\Http\Controllers\FrontendControllers\GuestControllers;
use App\Helper\Issue;
use App\Http\Controllers\ApiControllers\InsApiController;
use App\Models\AddRecoginzee;
use App\Models\CancelWarrantyRecord;
use App\Models\CardType;
use App\Models\CodeType;
use App\Models\FormInfo;
use App\Models\MaintenanceRecord;
use App\Models\Order;
use App\Models\Product;
//use App\Models\RecognizeeGroup;
//use App\Models\RecognizeeRule;
use App\Models\User;
use App\Models\Warranty;
use App\Models\WarrantyPolicy;
use App\Models\WarrantyRecognizee;
use App\Models\WarrantyRelation;
use App\Models\WarrantyRule;
use Illuminate\Support\Facades\DB;
use League\Flysystem\Exception;
use Request,Validator;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\FrontendControllers\BaseController;
use App\Models\Bank;
use App\Models\Occupation;
use App\Models\Relation;
use App\Helper\RsaSignHelp;
use Ixudra\Curl\Facades\Curl;
use App\Models\MaintenanceInfo;
use Request as Requests;

class OrderController extends BaseController
{
    protected $issue;
    protected $uid;
    protected $isAuthentication;

    public function __construct()
    {
        $this->uid = $this->getId();
        $this->issue = new Issue();
//        $this->isAuthentication = $this->isAuthentication($this->uid);

    }

    //获取不同类型的订单
    public function index($order_type)
    {
        $input = Requests::all();
        if(isset($input['account'])){
            $account = User::where('phone',$input['account'])->first();
            $type = $account->type;
            setcookie('user_id',$account->id);
            setcookie('login_type',$account->type);
            setcookie('user_name',$account->name);
            setcookie('user_type','channel');
        }
        $id = $this->getId();
        //获取当前所需的状态类型码
        $status = config('attribute_status.order.'.$order_type);
        $type_array = array('all','insuring','feedback','renewal');

        if(!is_null($status)){
            $order_list = $this->getOrderList($status,$id);
        }else if(in_array($order_type,$type_array)){
            $order_list  = $this->getOrderList($order_type,$id);
        }else{//说明无该状态，非法操作
            return back()->withErrors('非法操作');
        }


        $count = count($order_list);
        $option_type = 'order';
        if( !$this->is_mobile() && $this->is_person($this->getId()) == 1){
            //pc个人
            return view('frontend.guests.order.index',compact('order_type','order_list','count','type','option_type'));
        }elseif($this->is_mobile() && $this->is_person($this->getId()) == 1){
            //移动个人
            return view('frontend.guests.mobile.personal.order',compact('order_type','order_list','count','type','option_type'));
        }elseif($this->is_mobile() && $this->is_person($this->getId() == 2)){
            //移动公司
            return view('frontend.guests.mobile.company.order',compact('order_type','order_list','count','type','option_type'));
        }else{
            //pc企业
            return view('frontend.guests.company.order.index',compact('order_type','order_list','count','type','option_type'));
        }

    }

    //获取保单的详细信息
    public function getOrderDetail($order_id)
    {
        $type = $_COOKIE['login_type'];
        $warranty_rule = $this->getWarrantyRuleByOid($order_id);
//        dd($warranty_rule);
        if($warranty_rule){
            //获取订单的详细信息
            $order_detail = Order::where('id',$order_id)->with('warranty_rule','warranty_rule.warranty_product','order_parameter')->first();
            $order_detail->order_parameter[0]['parameter'] = json_decode($order_detail->order_parameter[0]['parameter'],true);
            $order_detail['clause_chose'] = json_decode($order_detail->order_parameter[0]['parameter']['protect_item'],true);
            //获取产品的ty_product_id
            $product_id = $order_detail['ty_product_id'];
//            $uuid = json_decode(Product::where('ty_product_id',$product_id)->first()->json,true)->api_from_uuid;
            $policy_id = $warranty_rule->policy_id;
            //获取投保人的信息
            $policy = $this->getPolicyMessage($policy_id);
            //获取被保人的信息
            $recognizee = $this->getRecognizeeMessage($order_id);
            if(!$policy||!$recognizee){
                return "<script>alert('该订单异常');history.back();</script>";
            }
//            dd($order_detail);
            if($order_detail->status == config('attribute_status.order.payed')){
                $warranty_rule = WarrantyRule::where('order_id',$order_id)
                    ->with('warranty_product','warranty_rule_order')->first();
                $union_order_code = $warranty_rule->union_order_code;
                $warranty_id = $warranty_rule->warranty_id;
                if(!$warranty_id){
                    $warranty_id = $this->issue->issue($warranty_rule->warranty_product->api_from_uuid,$warranty_rule);
                    if(!$warranty_id){
                        $warranty = 0;
                    }else{
                        $warranty = Warranty::find($warranty_id);
                    }
                }else{
                    $warranty = Warranty::find($warranty_id);
                }

            }else{
                $warranty = 0;
            }
            $product_detail = Product::find($product_id);
            $product_detail['json'] = json_decode($product_detail['json'],true);
            $clauses = json_decode($product_detail['clauses'],true);
//            dd($order_detail);
            if($this->is_mobile()){
                return view('frontend.guests.company.order.detail',compact('product_detail','warranty','uuid','order_detail','policy','recognizee','coverage','union_order_code'));
            }
            return view('frontend.guests.order.detail',compact('product_detail','warranty','uuid','order_detail','policy','recognizee','coverage','union_order_code'));
        }else{
            return redirect('order/index/all')->withErrors('非法操作');
        }
    }

    //移动端保单详情被保人
    public function getOrderDetailRecognizee($id)
    {
        $data = $this->getRecognizeeMessage($id);
//        dd($data);
        return view('frontend.guests.order.detail_recognizee',compact('data'));
    }

    //在保单详情页面进行添加员工
    public function detailRecognizeeAdd($id)
    {
        $data = Order::where('id',$id)
            ->first();
//        dd($data);
        return view('frontend.guests.order.detail_recognizee_add',compact('data'));
    }

    //添加人数据提交
    public function detailRecognizeeAddSubmit(\Illuminate\Http\Request $request)
    {
        $input = $request->all();
//        dd($input);
        DB::beginTransaction();
        try{
            $add = new AddRecoginzee();
            $add->user_id = $this->getId();
            $add->name = $input['name'];
            $add->sex = $input['sex'];
            $add->id_type = $input['id_type'];
            $add->date = date("Y-m-d",time());
            $add->project = $input['product'];
            $add->id_code = $input['id_code'];
            $add->phone = $input['phone'];
            $add->status = 1;
            $add->save();
            DB::commit();
            return "<script>location.href='/order/recognizee_add_submit_success'</script>";
        }catch (Exception $e){
            DB::rollBack();
            return "<script>alert('信息录入失败，请确认信息是否正确');history.back();</script>";
        }

    }

    //添加成功
    public function detailRecognizeeAddSubmitSuccess()
    {
        return view('frontend.guests.order.recognizee_add_success');
    }

    //封装一个方法，用来获取保单的信息
    public function getWarrantyDetailFunc($warranty_id)
    {
        $warranty_detail = Warranty::where('id',$warranty_id)
            ->first();
        return $warranty_detail;
    }
    //封装一个方法，用来获取一个保单的相关信息
    public function getWarrantyRuleByOid($order_id)
    {
        $warranty_rule = WarrantyRule::where('order_id',$order_id)
            ->first();
        return $warranty_rule;
    }
    //封装一个方法，用来获取一个保单的投保人信息
    public function getPolicyMessage($policy_id)
    {
        //获取被保人的信息，同时获取证件类型
        $result = WarrantyPolicy::where('id',$policy_id)
            ->first();

        return $result;
    }
    //封装一个方法，用来获取被保人的信息
    public function getRecognizeeMessage($order_id){
        $recognizee_detail = WarrantyRecognizee::where('order_id',$order_id)
            ->get();

        return $recognizee_detail;
    }
    //封装一个方法，用来获取不同状态的订单
    public function getOrderList($status,$id)
    {
        if(is_integer($status)){//获取特定条件的订单
            $order_list = Order::where('user_id',$id)
                ->where('status',$status)
                ->where('ty_product_id','>=',0)
                ->with('product','warranty_rule.warranty','warranty_recognizee')
                ->orderBy('created_at','desc')
                ->paginate(config('list_num.frontend.order'));
        }else{//获取所有的订单
            if($status == 'all'){
                $order_list = Order::where('user_id',$id)
                    ->where('ty_product_id','>=',0)
                    ->orderBy('created_at','desc')
                    ->with('product','warranty_recognizee','warranty_rule.warranty','order_parameter')
                    ->paginate(config('list_num.frontend.order'));
            }else if($status == 'insuring'){//保障中
                $order_list = Order::with('product','warranty_rule.warranty','warranty_recognizee')->where([['user_id',$id],['status',config('attribute_status.order.payed')],['end_time'=>function($q){
                $q->where('end_time','>',date('Y-m-d H:i:s'))
                        ->orwhere('end_time',null);
                }]])->where('ty_product_id','>=',0)->paginate(config('list_num.frontend.order'));
            }else if($status == 'renewal'){//已过期
                $order_list = Order::with('product','warranty_rule.warranty','warranty_recognizee')->where([['user_id',$id],['status',config('attribute_status.order.payed')],['end_time','<',date('Y-m-d H:i:s')]])->where('ty_product_id','>=',0)->paginate(config('list_num.frontend.order'));;
            }
        }
//        dd($order_list[0]['parameter']);
//        dd(json_decode($order_list[0]['parameter']['parameter'],true));
//        dd(json_decode($order_list[0]['parameter']['parameter'],true));
//        dd($order_list);
        return $order_list;
    }
    //写一个方法，用来获取证件类型
    public function getCardType($uuid,$number)
    {
        $result = CardType::where('api_from_uuid',$uuid)
            ->where('number',$number)->first();
        return $result;
    }
    //修改投保人信息 验证
    protected function checkPolicy($input)
    {
        //规则
        $rules = [
            'phone' => 'required',
            'email'=>'required|email',
        ];
        //自定义错误信息
        $messages = [
            'phone' => '手机格式错误',
            'email' => '邮箱地址错误',
        ];
        //验证
        $validator = Validator::make($input, $rules, $messages);
        return $validator;
    }

    public function checkPhone(){
        $input = Request::all();
//        //手机验证码验证
//        $check_phone = $this->checkPhoneCode($input['phone'], $input['phone_code']);
//        if($check_phone['status'] != 'success'){
//            return back()->withErrors([$check_phone['message']]);
//        }
        //验证成功直接前往修改页面
        $order_code = $input['order_code'];//订单号
        $order_res = Order::where('order_code',$order_code)->first();
        $union_order_code = $input['union_order_code'];
        $warranty_code = $input['warranty_code'];//保单号
        $recognizee  = json_decode($input['recognizee'],true);//被保人信息
        $policy  = json_decode($input['policy'],true);//投保人信息
        $res = MaintenanceInfo::where('union_order_id',$union_order_code)->first();
        if(!is_null($res)){
            return back()->withErrors('您已经发起保全成功！');
        }
        $warranty_res = Warranty::with('warranty_rule')->where('warranty_code',$warranty_code )->first();
        $product_res = WarrantyRule::with('warranty_product')->where('union_order_code',$union_order_code)->first();
        $uuid = $product_res->warranty_product->api_form_uuid;
        $occupation = Occupation::get();//职业
        $relation = Relation::get();//亲属关系
        $card_type = CardType::get();//证件类型
        $form_info_res = FormInfo::where('union_order_code',$union_order_code)->first();
        if(is_null($form_info_res)){
            $form_info = '';
        }else{
            $form_info = json_decode($form_info_res->forminfo,true);
        }
        return view('frontend.guests.order.change_form')
            ->with('input',$input)
            ->with('forminfo',$form_info)
            ->with('order_res',$order_res)
            ->with('warranty_code',$warranty_code)
            ->with('order_code',$order_code)
            ->with('recognizees',$recognizee)
            ->with('policy',$policy)
            ->with('warranty_res',$warranty_res)
            ->with('union_order_code',$union_order_code)
            ->with('product_res',$product_res)
            ->with('occupation',$occupation)
            ->with('relation',$relation)
            ->with('card_type',$card_type);
    }

    protected function checkPhoneCode($phone, $phone_code)
    {
        if(!Cache::get("reg_code_".$phone))
            return ['status'=>'error', 'message'=>'验证码不存在，请重新发送'];
        if(Cache::get("reg_code_".$phone) != $phone_code)
            return ['status'=>'error', 'message'=>'验证码错误'];
        Cache::forget("reg_code_".$phone);
        return ['status'=> 'success', 'message'=>'验证码正确'];
    }

    public  function changeSubmit(){
        $input = Request::all();
        $union_order_code = $input['union_order_code'];
        $product_res = WarrantyRule::with('warranty_product')->where('union_order_code',$union_order_code)->first();
        $uuid = $product_res->warranty_product->api_form_uuid;
        $occupation = Occupation::get();//职业
        $relation = Relation::get();//亲属关系
        $card_type = CardType::get();//证件类型
        unset($input['_token']);
        $save_input = FormInfo::where('union_order_code',$union_order_code)->first();
        $save_input = json_decode($save_input['forminfo'],true);
        unset($save_input['forminfo_id']);
        $res = array_diff($save_input,$input);//修改后的不同
        return view('frontend.guests.order.check_form')
            ->with('union_order_code',$union_order_code)
            ->with('save_input',$input)
            ->with('input',$save_input)
            ->with('res',$res)
            ->with('occupation',$occupation)
            ->with('relation',$relation)
            ->with('card_type',$card_type);

    }

    public  function submitChange(){
        $input = Request::all();
        $union_order_code = $input['union_order_code'];
        $res = $input['change_res'];
        $biz_content = [];
        $biz_content['change_res'] = $res;
        $biz_content['union_order_code'] = $union_order_code;
        $sign_help = new RsaSignHelp();
        $data = $sign_help->tySign($biz_content);
        $response = Curl::to(env('TY_API_SERVICE_URL') . '/saveformchange')
            ->returnResponseObject()
            ->withData($data)
            ->withTimeout(60)
            ->post();
        $status = $response->status;
//        $status = '200';
        if($status == '200'){
            $content = $response->content;
            $input_res  = $input['input'];//new
            $input_save_res  = $input['save_input'];//old
            $input_change_res  = $input['change_res'];//old
            MaintenanceInfo::insert([
                'union_order_id'=>$union_order_code,
                'save_input'=>json_encode($input_res),
                'input'=>json_encode($input_save_res),
                'change_input'=>json_encode($input_change_res ),
                'status'=>$status,
                'created_at'=>date('Y-m-d H:i:s',time()),
                'updated_at'=>date('Y-m-d H:i:s',time())
            ]);
            FormInfo::where('union_order_code',$union_order_code)->update(['forminfo'=>$input_res]);
            return view('frontend.guests.order.change_submit_success')->with('new_code','13265496857498798');
        }else{
            $product_res = WarrantyRule::with('warranty_product')->where('union_order_code',$union_order_code)->first();
            $uuid = $product_res->warranty_product->api_form_uuid;
            $occupation = Occupation::get();//职业
            $relation = Relation::get();//亲属关系
            $card_type = CardType::get();//证件类型
            unset($input['_token']);
            $save_input = FormInfo::where('union_order_code',$union_order_code)->first();
            $save_input = json_decode($save_input['forminfo'],true);
            unset($save_input['forminfo_id']);
            $res = json_decode($input['change_res'],true);
            $input = json_decode($input['input'],true);
            return view('frontend.guests.order.checkform')
                ->with('union_order_code',$union_order_code)
                ->with('save_input',$input)
                ->with('input',$save_input)
                ->with('res',$res)
                ->with('occupation',$occupation)
                ->with('relation',$relation)
                ->with('card_type',$card_type)
                ->withErrors('操作失败，请重新尝试！');

        }
    }

//    //未支付订单去支付
//    public function payAgain($code)
//    {
//        $pay_way = Order::where('order_code',$code)->pluck('pay_way');
//        $ins = new InsApiController();
//        $ins->paySettlement($code,$pay_way[0]);
//
//    }

    //公司保单
    public function companyGuarantee($order_type)
    {
        $input = Requests::all();
        if(isset($input['account'])){
            $account = User::where('phone',$input['account'])->first();
            $type = $account->type;
            setcookie('user_id',$account->id);
            setcookie('login_type',$account->type);
            setcookie('user_name',$account->name);
            setcookie('user_type','channel');
        }
        $id = $this->getId();
        //获取当前所需的状态类型码
        $status = config('attribute_status.order.'.$order_type);
        $type_array = array('all','insuring','feedback','renewal');

        if(!is_null($status)){
            $order_list = $this->getOrderList($status,$id);
        }else if(in_array($order_type,$type_array)){
            $order_list  = $this->getOrderList($order_type,$id);
        }else{//说明无该状态，非法操作
            return back()->withErrors('非法操作');
        }

        $order_parameter = Order::where('user_id',$id)
            ->join('order_parameter', 'order.id', '=', 'order_parameter.order_id')->get();
        foreach ($order_parameter as $value){
            $parameter[] = json_decode($value->parameter, true);
        }
        $count = count($order_list);
        $option_type = 'guarantee';

        return view('frontend.guests.company.guarantee.index',compact('order_type','order_list','count','type','option_type'));
    }

    //保单详情
    public function companyGuaranteeDetail($id)
    {
        $option_type = 'guarantee';
        $data = Order::where('id',$id)
            ->with('agent.user','order_parameter','product','warranty_rule.warranty')
            ->whereHas('warranty_recognizee',function($q){
                $q->where('status','<>',4);
            })
            ->first();
        $data->product['json'] = json_decode($data->product['json'],true);
        $data->product['clauses'] = json_decode($data->product['clauses'],true);
//        $data->order_parameter[0]['parameter'] = json_decode($data->order_parameter[0]['parameter'],true);
//        foreach($data->order_parameter as $v){
//            $items = json_decode($v['parameter'],true);
//            $protect_item = json_decode($items['protect_item'],true);
////            dd($protect_item);
//            foreach($protect_item as $v){
//                echo $v['name'];echo $v['defaultValue'];
//            }
//        }
//        dd($data);
        return view('frontend.guests.company.guarantee.detail',compact('data','option_type'));
    }
}
