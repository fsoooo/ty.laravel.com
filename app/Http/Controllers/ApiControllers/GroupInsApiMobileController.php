<?php
/**
 * Created by PhpStorm.
 * User: cyt
 * Date: 2018/1/2
 * Time: 10:57
 */
namespace App\Http\Controllers\ApiControllers;
use App\Helper\ErrorNotice;
use App\Helper\IsPhone;
use App\Helper\LogHelper;
use App\Helper\RsaSignHelp;
use App\Http\Controllers\Controller;
use App\Http\Controllers\FrontendControllers\BaseController;
use App\Models\ApiInfo;
use App\Models\Cust;
use App\Models\GroupInsCust;
use App\Models\Order;
use App\Models\OrderParameter;
use App\Models\OrderPrepareParameter;
use App\Models\Product;
use App\Models\User;
use App\Models\WarrantyPolicy;
use App\Models\WarrantyRecognizee;
use App\Models\WarrantyRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Session;
use Ixudra\Curl\Facades\Curl;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class GroupInsApiMobileController extends BaseController{
    protected $_request;
    protected $error;
    protected $_signHelp;
    protected $is_phone;

    public function __construct(Request $request)
    {
        $this->_request = $request;
        $this->error = new ErrorNotice();
        $this->_signHelp = new RsaSignHelp();
        $this->is_phone = isset($_SERVER['HTTP_USER_AGENT']) ? IsPhone::isPhone() : null;
    }



    //投保页
    public function insure($identification)
    {
        //判断是否有预存的信息
        $prepare = OrderPrepareParameter::where('identification', $identification)->first();
        if(!$prepare)
            return "<script>alert('订单不存在或已被删除'); window.history.go(-1);</script>";
        $api_info = ApiInfo::where('private_p_code', $prepare->private_p_code)->first()->toArray();
        $ins = json_decode($api_info['json'], true);
        $insurance_attributes = [];
        foreach($ins['insurance_attributes'] as $k=>$value){
            if($value['module_key']=='ty_base'){
                $insurance_attributes[0] = $value;
            }else if($value['module_key']=='ty_toubaoren'){
                $insurance_attributes[1] = $value;
            }else if($value['module_key']=='ty_beibaoren'){
                $insurance_attributes[2] = $value;
            }else{
                $insurance_attributes[3+$k] = $value;
            }
        }
        ksort($insurance_attributes);
        unset($ins['insurance_attributes']);
        /*
         * 通过循环将被保人模块中的与被保人的关系放到选项的第一项
         */
        $tmp = null;
        foreach ($insurance_attributes as $k => $v) {
            if ($v['module_key'] == 'ty_beibaoren') {
                foreach ($v['productAttributes'] as $key => $value) {
                    if ($value['ty_key'] == 'ty_relation') {
                        $tmp = $value;
                        unset($insurance_attributes[$k]['productAttributes'][$key]);
                    }
                }
                if (isset($tmp)) {
                    array_unshift($insurance_attributes[$k]['productAttributes'], $tmp);
                }
            }
        }
        $ins['insurance_attributes'] = $insurance_attributes;
//        if(Auth::user()->id){
//            $user_true_res = User::where('id',Auth::user()->id)->wherehas('user_authentication_person',function($a){
//                $a->where('status','2');
//            })->first();
//            $user_true['name'] = $user_true_res['real_name'];
//            $user_true['code'] = $user_true_res['code'];
//            $user_true['phone'] = $user_true_res['phone'];
//            $user_true['email'] = $user_true_res['email'];
//            $user_true['address'] = $user_true_res['address'];
//            $user_true['occupation'] = $user_true_res['occupation'];
//        }
//        $user_true = empty($user_true) ? [] : $user_true;
//        dd($_COOKIE);
        return view('frontend.guests.groupIns.mobile.company',compact('ins','identification','user_true'));
    }

    //投保被保人部分
    public function insureMobileCompanyInfo($identification)
    {
        if(isset($_GET['info']) && $_GET['info'] == 1){
            $input = json_decode(Redis::get('twoStepinfo'.$identification),true);
        }else{
            $input = $this->_request->all();
        }
        //判断是否有预存的信息
        $prepare = OrderPrepareParameter::where('identification', $identification)->first();
        if(!$prepare)
            return "<script>alert('订单不存在或已被删除'); window.history.go(-1);</script>";
        if(!file_exists(public_path('qrcodes'))){
            mkdir('qrcodes');
            chmod('qrcodes',0777);
        }
        //二维码
        $url = url('/ins/add_beibaoren/'.$identification);
        QrCode::size(100)->format('png')->generate($url,public_path('qrcodes/qrcodes'.$identification.'.png'));
        $qrcode_url = '/qrcodes/qrcodes'.$identification.'.png';
        //接口数据
        $ins = json_decode($input['ins'],true);
        $product = Product::where('ty_product_id', $prepare->ty_product_id)->first();
        $json = json_decode($product['json'], true);
        //存入投保人信息
        if(isset($input['insurance_attributes']['ty_toubaoren'])){
            unset($input['_token']);
            if(!isset($_GET['info']) || $_GET['info'] != 1){
                //添加第二部备用数据
                Redis::set('twoStepinfo'.$identification,json_encode($input));
                Redis::expire('twoStepinfo'.$identification,3600);
            }
            unset($input['ins']);
            Redis::set('oneStepdata'.$identification,json_encode($input));
            Redis::expire('oneStepdata'.$identification,3600);
            $toubaoren_data = $input;
        }else{
            $toubaoren_data = '';
        }
        $ins['template_url'] = url('download/group_excel/insureds.xlsx');
        //被保人数据
        $beibaoren_data = [];
        $mid = [];
        $old_beibaoren_data = GroupInsCust::where('union_order_code',$identification)->get();
        foreach($old_beibaoren_data as $v){
            $mid[$v['id']]['ty_beibaoren_name'] = $v['ty_beibaoren_name'];
            $mid[$v['id']]['ty_beibaoren_id_number'] = $v['ty_beibaoren_id_number'];
            $mid[$v['id']]['ty_beibaoren_job'] = $v['ty_beibaoren_job'];
            $mid[$v['id']]['ty_beibaoren_phone'] = $v['ty_beibaoren_phone'];
        }
        $beibaoren_data['insurance_attributes']['ty_beibaoren'] = $mid;
        return view('frontend.guests.groupIns.mobile.company_info',compact('ins','qrcode_url','product','json','identification','beibaoren_data','toubaoren_data'));
    }

    //添加被保人(二维码)
    public function addBeibaoren($identification)
    {
        return view('frontend.guests.groupIns.mobile.advertisement',compact('identification'));
    }

    //添加被保人信息
    public function addBeibaorenInfo($identification)
    {
        return view('frontend.guests.groupIns.mobile.informatifill',compact('identification'));
    }

    //修改被保人信息
    public function editInfo($id)
    {
        $data = GroupInsCust::where('id',$id)->first();
        return $data;
    }

    //修改被保人信息提交
    public function editInfoSubmit($id)
    {
        $input = $this->_request->all();
        if(!isset($input['ty_beibaoren_name']) || !isset($input['ty_beibaoren_id_number']) || !isset($input['ty_beibaoren_job']) || !isset($input['ty_beibaoren_phone'])){
            return ['code'=>400,'msg'=>'请填写所有必填项后提交'];
        }
        unset($input['_token']);
        DB::beginTransaction();
        try{
            $res = GroupInsCust::where('id',$id)->update($input);
            DB::commit();
        }catch (Exception $e){
            DB::rollBack();
            return "<script>alert('信息录入失败，请确认信息是否正确');history.back();</script>";
        }
        if($res){
            return ['code'=>200,'msg'=>'修改成功'];
        }
    }

    //删除被保人信息
    public function deleteInfo($id)
    {
        $input = $this->_request->all();
        DB::beginTransaction();
        try{
            $res = GroupInsCust::where('id',$id)->delete();
            DB::commit();
        }catch (Exception $e){
            DB::rollBack();
            return "<script>alert('信息录入失败，请确认信息是否正确');history.back();</script>";
        }
        if($res){
            return ['code'=>200,'msg'=>'删除成功'];
        }else{
            return ['code'=>400,'msg'=>'删除失败,请重新再试'];
        }
    }

    //添加被保人数据提交
    public function addBeibaorenInfoSubmit(Request $request)
    {
        $input = $request->all();
//        dd($input);
        $old_data = GroupInsCust::where([
            ['ty_beibaoren_id_number',$input['insurance_attributes']['ty_beibaoren']['ty_beibaoren_id_number']],
            ['union_order_code',$input['identification']]
        ])->first();
        if(isset($old_data)){
            return "<script>alert('此人信息已经填写');history.back();</script>";
        }else{
            DB::beginTransaction();
            try{
                $cust = new GroupInsCust();
                $cust->ty_beibaoren_name = $input['insurance_attributes']['ty_beibaoren']['ty_beibaoren_name'];
                $cust->ty_beibaoren_id_number = $input['insurance_attributes']['ty_beibaoren']['ty_beibaoren_id_number'];
                $cust->ty_beibaoren_job = $input['insurance_attributes']['ty_beibaoren']['ty_beibaoren_job'];
                $cust->ty_beibaoren_phone = $input['insurance_attributes']['ty_beibaoren']['ty_beibaoren_phone'];
                $cust->union_order_code = $input['identification'];
                $cust->save();
                DB::commit();
            }catch (Exception $e){
                DB::rollBack();
                return "<script>alert('信息录入失败，请确认信息是否正确');history.back();</script>";
            }
        }

        if(isset($input['manager']) && $input['manager'] == 1){
            return redirect('/ins/mobile_group_ins/insure_mobile_company_info/'.$input['identification'].'?info=1');
        }else{
            return redirect('/ins/add_beibaoren_success');
        }
    }

    //添加被保人信息成功
    public function addBeibaorenSuccess()
    {
        return view('frontend.guests.groupIns.mobile.success');
    }

    //信息确认
    public function mobileGroupConfirmForm(Request $request)
    {
        $input = $request->all();
        $input['insurance_attributes']['ty_toubaoren'] = json_decode($input['insurance_attributes']['ty_toubaoren'],true);
        $input['insurance_attributes']['ty_beibaoren'] = json_decode($input['insurance_attributes']['ty_beibaoren'],true);
        //11.7陈延涛添加投保人与当前账户为同一人的实现开始
        $product_type = json_decode($input['json'],true)['type'];
//        if(Auth::user()->id) {
//            $user_type = User::where('id', $_COOKIE['user_id'])->first()['type'];
//            if ($product_type == 1 && $user_type == 'company') {
//                return $this->error->error('当前登陆账户为企业账户，不可购买个体险', '1');
//            }
//            if ($product_type == 2 && $user_type == 'user') {
//                return $this->error->error('当前登陆账户为个人账户，不可购买团体险', '1');
//            }
//            $user_data = User::where('id', $_COOKIE['user_id'])
//                ->select('phone')
//                ->first();
//            if ($input['insurance_attributes']['ty_toubaoren']['ty_toubaoren_phone'] != $user_data['phone']) {
//                return $this->error->error('投保人的手机号必须是当前登陆用户的手机号', '1');
//            }
//            if ($product_type != 2) {
//                return $this->error->error('非团险产品', '1');
//            }
//        }
        $identification = $input['identification'];
        $insured_lists = $input['insurance_attributes']['ty_beibaoren'];
        $insurance_attributes = json_encode($input['insurance_attributes']);
        $prepare_order = [];
        $prepare_order['input'] = json_encode($input);
        $prepare_order['insurance_attributes'] = $insurance_attributes;
        $prepare_order['identification'] = $identification;
        if(!Redis::exists('prepare_order'.$identification)){
            Redis::set('prepare_order'.$identification,json_encode($prepare_order));
            Redis::expire('prepare_order'.$identification,3600);
        }
        //产品信息
        $product_data = json_decode($input['product'],true);
        //当前用户选择的价格
        $order_data = OrderPrepareParameter::where('identification',$identification)->first();
        $price = isset($order_data)? json_decode($order_data['parameter'],true)['price']:json_decode($input['product'],true)['base_price'];
        $final_price = $price * count(json_decode($insurance_attributes,true)['ty_beibaoren']);
        return view('frontend.guests.mobile.company.mobile_group_confirm_form')
            ->with('insurance_attributes',$insurance_attributes)
            ->with('input',$input)
            ->with('identification',$identification)
            ->with('product_data',$product_data)
            ->with('final_price',$final_price)
            ->with('insured_lists',$insured_lists);
    }

    //提交投保
    public function insurePost()
    {
        $input = $this->_request->all();
        if(empty($input)&&Redis::exists('prepare_order'.$_COOKIE['identification'])){
            $input = json_decode(Redis::get('prepare_order'.$_COOKIE['identification']),true);
        }
        $insurance_attributes = json_decode($input['insurance_attributes'],true);
        if( isset(Auth::user()->phone) && Auth::user()->phone != $insurance_attributes['ty_toubaoren']['ty_toubaoren_phone']){
            setcookie('login_type','',0);
            setcookie('user_id','',0);
            setcookie('user_name','',0);
            Auth::logout();
            return "<script>alert('当前登陆账户的信息与投保人的数据不一致');location.href='/ins/mobile_group_ins/insure/'+".$input['identification']."</script>";
        }
        $start_time = $insurance_attributes['ty_base']['ty_start_date']??'';
        $num = count($insurance_attributes['ty_beibaoren']);
        $prepare = OrderPrepareParameter::where('identification', $input['identification'])->first();
        if(!$prepare)
            return $this->error->error('订单不存在或已被删除','1');
        if(!empty($prepare->union_order_code)){
            $order_res = Order::where('order_code',$prepare->union_order_code)->first();
            return $this->paySettlement($order_res['order_code'],json_decode($order_res['pay_way'],true));
        }
        $parameter = json_decode($prepare->parameter, true);
        $data['price'] = $parameter['price'] * $num;
        $data['private_p_code'] = $prepare['private_p_code'];
        if($prepare['private_p_code']=='UXgtMTEyMkEwMUcwMQ'){
            return $this->error->error('待审产品，不能投保','1');
        }
        $data['insurance_attributes'] = json_decode($input['insurance_attributes'],true);
        $data['quote_selected'] = $parameter['selected'];
//        $policy_res = $data['insurance_attributes']['ty_toubaoren'];
//        $user_res = User::where('phone',$policy_res['ty_toubaoren_phone'])->select('phone')->first();
        $data = $this->_signHelp->tySign($data);
        //发送请求
        $response = Curl::to(env('TY_API_SERVICE_URL') . '/ins_curl/buy_ins')
            ->returnResponseObject()
            ->withData($data)
            ->withTimeout(600)
            ->post();
//         dd($response->content);die;
        if($response->status != 200){
            $response->content = preg_replace("/\]/",'',preg_replace("/\[/", '', $response->content));
            return $this->error->error($response->content,'/ins/group_ins/insure/'.$_COOKIE['identification']);
        }
        //订单信息录入
        $return_data = json_decode($response->content, true);
        $policy_res = json_decode($input['insurance_attributes'],true)['ty_toubaoren'];//投保人
        $add_res = $this->addOrder($return_data, $prepare,$policy_res, $start_time);
        if($add_res){
            OrderPrepareParameter::where('identification',$input['identification'])->update(['union_order_code'=>$return_data['union_order_code']]);
            return $this->paySettlement($return_data['union_order_code'], $return_data['pay_way']);
        }else{
            return $this->error_notice->error( '下单失败，重新尝试','1');
        }
    }

    //跳转到支付页面
    public function paySettlement($union_order_code, $pay_way){
        $warranty = WarrantyRule::where('union_order_code', $union_order_code)
            ->with(['order'])
            ->first();
        $product_res = ApiInfo::where('private_p_code',$warranty->private_p_code)
            ->with(['product'])
            ->first();
        $product = $product_res->product;
        $order = $warranty->order;
        $order_parameter = OrderParameter::where('order_id', $order->id)->first();
        $parameter = json_decode($order_parameter->parameter, true);
//        $banks = Bank::get();
//        $user_banks = UserBank::where('user_id',$_COOKIE['user_id'])->get();
//        $bank_res = count($user_banks);
        $json =  json_decode($product->json,true);
        $company = $json['company'];
        $clause = $json['clauses'];
        $order['premium'] = $order['premium']/100;
//        $is_mobile = $this->is_mobile();
//        dd($order);
        return view('frontend.guests.mobile.company.mobile_payment')
            ->with('order',$order)
            ->with('company',$company)
            ->with('clause',$clause)
            ->with('product',$product)
            ->with('warranty',$warranty)
            ->with('parameter',$parameter)
            ->with('private_p_code',$warranty->private_p_code)
            ->with('union_order_code',$union_order_code)
            ->with('pay_way', $pay_way['mobile']);
    }

    /**
     * 添加投保返回信息
     * @param $return_data $prepare
     * @return true/false
     */
    protected function addOrder($return_data, $prepare, $policy_res, $start_time)
    {
        try{
            //查询是否在竞赛方案中
            $private_p_code = $prepare->private_p_code;
//            $competition = $this->checkCompetition($private_p_code);
//            if($competition){
//                $competition_id = $competition->id;
//                $is_settlement = 0;
//            }else{
//                $is_settlement = 1;
//                $competition_id = 0;
//            }
            $ditch_id = $prepare->ditch_id;
            $agent_id = $prepare->agent_id;
            $plan_id = $prepare->plan_id;
            //订单信息录入

//            foreach ($return_data['order_list'] as $order_value){
            $order = new Order();
            $order->order_code = $return_data['union_order_code']; //订单编号
            $order->user_id = isset($_COOKIE['user_id'])?$_COOKIE['user_id']:' ';//用户id
            $order->agent_id = $agent_id;
            $order->ditch_id = $ditch_id;
            $order->plan_id = $plan_id;
            $order->competition_id = 0;//竞赛方案id，没有则为0
            $order->private_p_code = $private_p_code;
            $order->ty_product_id = $prepare->ty_product_id;
            $order->start_time = $start_time;
            $order->claim_type = 'online';
            $order->deal_type = 0;
            $order->is_settlement = 0;
            $order->premium = $return_data['total_premium'];
            $order->status = config('attribute_status.order.unpayed');
            $order->pay_way = json_encode($return_data['pay_way']);
            $order->save();
//            }
            //投保人信息录入
            $warrantyPolicy = new WarrantyPolicy();
            $warrantyPolicy->name = isset($policy_res['ty_toubaoren_name'])?$policy_res['ty_toubaoren_name']:'';
            $warrantyPolicy->card_type = isset($policy_res['ty_toubaoren_id_type'])?$policy_res['ty_toubaoren_id_type']:'';
            $warrantyPolicy->occupation = isset($policy_res['ty_toubaoren_occupation'])?is_array($policy_res['ty_toubaoren_occupation'])?json_encode($policy_res['ty_toubaoren_occupation']):$policy_res['ty_toubaoren_occupation']:'';  //投保人职业？？
            $warrantyPolicy->code = isset($policy_res['ty_toubaoren_id_number'])?$policy_res['ty_toubaoren_id_number']:'';
            $warrantyPolicy->phone =  isset($policy_res['ty_toubaoren_phone'])?$policy_res['ty_toubaoren_phone']:'';
            $warrantyPolicy->email =  isset($policy_res['ty_toubaoren_email'])?$policy_res['ty_toubaoren_email']:'';
            $warrantyPolicy->area =  isset($policy_res['ty_toubaoren_area'])?is_array($policy_res['ty_toubaoren_area'])?json_encode($policy_res['ty_toubaoren_area']):$policy_res['ty_toubaoren_area']:'';
            $warrantyPolicy->status = config('attribute_status.order.check_ing');
            $warrantyPolicy->save();
            //被保人信息录入
            foreach ($return_data['order_list'] as $recognizee_value){
                $warrantyRecognizee = new WarrantyRecognizee();
                $warrantyRecognizee->name = $recognizee_value['name'];
                $warrantyRecognizee->order_id = $order->id;
                $warrantyRecognizee->order_code = $recognizee_value['out_order_no'];
                $warrantyRecognizee->relation = $recognizee_value['relation'];
                $warrantyRecognizee->occupation =isset($recognizee_value['occupation'])?is_array($recognizee_value['occupation'])?json_encode($recognizee_value['occupation']):$recognizee_value['occupation']: ' ';
                $warrantyRecognizee->card_type = isset($recognizee_value['card_type'])?$recognizee_value['card_type']: ' ';
                $warrantyRecognizee->code = isset($recognizee_value['card_id'])?$recognizee_value['card_id']: ' ';
                $warrantyRecognizee->phone = isset($recognizee_value['phone'])?$recognizee_value['phone']: ' ';
                $warrantyRecognizee->email = isset($recognizee_value['email'])?$recognizee_value['email']: ' ';
                $warrantyRecognizee->start_time = isset($recognizee_value['start_time'])?$recognizee_value['start_time']: ' ';
                $warrantyRecognizee->end_time = isset($recognizee_value['end_time'])?$recognizee_value['end_time']: ' ';
                $warrantyRecognizee->status = config('attribute_status.order.unpayed');
                $warrantyRecognizee->save();
            }
            //添加投保参数到参数表
            $orderParameter = new OrderParameter();
            $orderParameter->parameter = $prepare->parameter;
            $orderParameter->order_id = $order->id;
            $orderParameter->ty_product_id = $order->ty_product_id;
            $orderParameter->private_p_code = $private_p_code;
            $orderParameter->save();
            //添加到关联表记录
            $WarrantyRule = new WarrantyRule();
            $WarrantyRule->agent_id = $agent_id;
            $WarrantyRule->ditch_id = $ditch_id;
            $WarrantyRule->order_id = $order->id;
            $WarrantyRule->ty_product_id = $order->ty_product_id;
            $WarrantyRule->premium = $order->premium;
            $WarrantyRule->union_order_code = $return_data['union_order_code'];//总订单号
            $WarrantyRule->parameter_id = $orderParameter->id;
            $WarrantyRule->policy_id = $warrantyPolicy->id;
            $WarrantyRule->private_p_code = $private_p_code;   //预留
            $WarrantyRule->save();
            DB::commit();
            return true;
        }catch (\Exception $e)
        {
            DB::rollBack();
            LogHelper::logError([$return_data, $prepare], $e->getMessage(), 'addOrder');
            return false;
        }
    }

    //获取支付方式
    public function getPayWayInfo()
    {
        $input = $this->_request->all();
        //是否为核保失败状态
        $order = Order::where('order_code',$input['union_order_code'])->first();
        if($order->status == 6)
            return (['status'=>'500','content'=>$order->pay_error_message]);
        $data['union_order_code'] = $input['union_order_code'];
        $data['pay_way'] = $input['pay_way'];
        $data['private_p_code'] = $input['private_p_code'];
        $data['redirect_url'] = env('APP_URL').'/order/index/all';  //支付结果跳转地址
        $data['is_phone'] = $this->is_phone ? 1 : 0;
        //天眼接口参数封装
        $data = $this->_signHelp->tySign($data);
        //发送请求
        $response = Curl::to(env('TY_API_SERVICE_URL') . '/ins_curl/get_pay_way_info')
            ->returnResponseObject()
            ->withData($data)
            ->withTimeout(60)
            ->post();
        //to
//        print_r($response->content);die;
        $status = $response->status;
        if($status== '200'){
            $content = json_decode($response->content,true);
            return (['status'=>'200','content'=>$content]);
        }else{
            return (['status'=>'500','content'=>$response->content]);
        }
    }

    public function getPayRes(){
        $input = $this->_request->all();
        $order_res  = Order::where('order_code',$input['union_order_code'])->first();
        if(is_null($order_res)){
            return (['status'=>'500','content'=>'订单失效！']);
        }else{
            $status = $order_res->status;
            if($status=='1'){
                return (['status'=>'200','content'=>'订单支付成功']);
            }elseif($status=='3'){
                return (['status'=>'500','content'=>'订单支付失败']);
            }
        }
    }
}