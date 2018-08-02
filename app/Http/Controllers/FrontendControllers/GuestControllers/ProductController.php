<?php

namespace App\Http\Controllers\FrontendControllers\GuestControllers;

use App\Helper\AgentAccountHelper;
use App\Helper\Issue;
use App\Helper\UploadFileHelper;
use App\Http\Controllers\FrontendControllers\BaseController;
use App\Helper\ChangeProductArray;
use App\Models\CardType;
use App\Models\CompanyBrokerage;
use App\Models\Label;
use App\Models\Bank;
use App\Models\Occupation;
use App\Models\LabelRelevance;
use App\Models\Relation;
use App\Models\Tariff;
use App\Models\MarketDitchRelation;
use App\Models\OrderBrokerage;
use App\Models\OrderParameter;
use App\Models\Warranty;
use App\Models\WarrantyRule;
use App\Models\Plan;
use App\Models\OnlineService;
//use Maatwebsite\Excel\Excel;
use Request as Requests;
use Illuminate\Http\Request as Request;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use Cache,Auth;
use App\Helper\RsaSignHelp;
use Ixudra\Curl\Facades\Curl;
use App\Models\Competition;
use App\Models\Order;
use App\Models\OrderPrepareParameter;
use App\Models\WarrantyPolicy;
use App\Models\WarrantyRecognizee;
use League\Flysystem\Exception;
use App\Helper\IdentityCardHelp;
use App\Helper\Relevance;
use App\Models\AgentAccount;
use App\Models\AgentAccountRecord;
use App\Models\FormInfo;
use App\Models\UserBank;
use App\Models\UserContact;
use App\Models\User;
use Excel;

class ProductController extends BaseController
{

    protected $changeProduct;
    protected $signHelp;
    protected $relevance;
    protected $issue;
    public function __construct()
    {
        $this->signHelp = new RsaSignHelp();
        $this->changeProduct = new ChangeProductArray();
        $this->relevance  = new Relevance();
        $this->issue = new Issue();

    }
    //按分类获取所有的产品列表
//    public function productLists($code)
//    {
//        $label = Label::get();
//        $res = Product::where('status','1')->where('ty_product_id','>=',0)->get();
//        $count = count($res);
//        return view('frontend.guests.product.product_lists')
//            ->with('count',$count)
//            ->with('label',$label)
//            ->with('res',$res);
//    }
    //预购订单，等待完善用户信息
    public function prepareOrder()
    {
        $input = Requests::all();
        if(!isset($input['tariff'])){
            return "<script>alert('请选择适合的参数！'); window.history.go(-1);</script>";
        }
        $agent_id = $input['agent_id'];//代理人ID
        $ditch_id = $input['ditch_id'];//渠道ID
        $date = date('Ymd',time());
        //通过‘product_id'查找id
        $ty_product_id = Product::where('ty_product_id',$input['ty_product_id'])
            ->first()->ty_product_id;
        $random = rand(0,9999999);
        $random_number = substr('0000000'.$random,-7);
        $identification = ($date.$random_number);
        unset($input['_token']);
        $parameter = json_encode($input);
        $OrderPrepareParameter = new OrderPrepareParameter();
        $prepare_parameter_array = array(
            'agent_id'=>$agent_id,
            'ditch_id'=>$ditch_id,
            'identification'=>$identification,
            'parameter'=>$parameter,
            'ty_product_id'=>$ty_product_id,
        );
        $prepare_id = $this->add($OrderPrepareParameter,$prepare_parameter_array);
        if($prepare_id){
            //预存成功,跳转到完善信息页面
            setcookie('identification',$identification,time()+3600,'/');
            $data = $this->productRight($identification);
            //判断移动端
            $is_mobile = $this->is_mobile();
            if($is_mobile){
                echo $this->insure($identification);
            }else{
                return view('frontend.guests.product.cover_notes')
//                    ->with('tariff_params',$data['tariff_params'])
                    ->with('parameter',$data['parameter'])
                    ->with('product_res',$data['product_res'])
                    ->with('identification',$identification);
            }
        }else{
            return back()->withErrors('出错了，请重新尝试');
        }
    }
    //通知告知页右侧栏信息
    public function productRight($identification){
        $prepare = OrderPrepareParameter::where('identification',$identification)
            ->first();
        $parameter = json_decode($prepare->parameter,true);
        $product_res = Product::where('ty_product_id',$prepare['ty_product_id'])->first();
        $data = [];
        $data['product_res'] = $product_res;
        $data['parameter'] = $parameter;
        return $data;
    }
    public function healthNotice($identification){
        $data = $this->productRight($identification);
//        dump($data);
        $is_mobile = $this->is_mobile();
        if($is_mobile){
            return view('frontend.guests.mobile.health_notice')
//                ->with('tariff_params',$data['tariff_params'])
                ->with('parameter',$data['parameter'])
                ->with('product_res',$data['product_res'])
                ->with('identification',$identification);
        }
        return view('frontend.guests.product.health_notice')
//            ->with('tariff_params',$data['tariff_params'])
            ->with('parameter',$data['parameter'])
            ->with('product_res',$data['product_res'])
            ->with('identification',$identification);
    }

    public function insure($identification)
    {
        if(!isset($_COOKIE['login_type'])){
            return redirect('/login');
        }
        //判断是否有预存的信息
        $prepare = OrderPrepareParameter::where('identification',$identification)
            ->first();
        $forminfos = FormInfo::where('identification',$identification)->first();
        $contacts = UserContact::where('user_id',$_COOKIE['user_id'])->get();
        $user_info = User::where('id',$_COOKIE['user_id'])->first();
        $person_code = is_null($user_info['code']) ? null : $user_info['code'];
        if($prepare){
            $ty_product_id = $prepare->ty_product_id;
            $product = Product::where('ty_product_id',$ty_product_id)->first();
//            $uuid = json_decode($product->json)->api_from_uuid;
            $uuid = "Wk";
            $occupation = $this->relevance->getRelevance('occupation',$uuid);//职业
            $relation = $this->relevance->getRelevance('relation',$uuid);//亲属关系
            $card_type = $this->relevance->getRelevance('card_type',$uuid);//证件类型
            $bank = $this->relevance->getRelevance('bank',$uuid);//银行信息
            $parameter = json_decode($prepare->parameter,true);
            $json = json_decode($product->json);
            $comapny = $json->company;
            unset($parameter['clause_beishu_1']);
            unset($parameter['clause_ids']);
            unset($parameter['ditch_id']);
            unset($parameter['agent_id']);
            unset($parameter['product_id']);
            unset($parameter['s']);
            $tari_arr = config('tariff_parameter');//费率注释
            foreach ($parameter as $k=>$v){
                foreach ($tari_arr as $ks=>$vs){
                    if($k == $ks){
                        unset($parameter[$k]);
                        $parameter[$vs] = $v;
                    }
                }

            }
            $product['company_logo'] = $comapny->logo;
            if(!is_null($forminfos)){
                $forminfo = json_decode($forminfos['forminfo'],true);
                $forminfo['id'] = $forminfos['id'];
            }else{
                $forminfo = null;
            }
            $data = $this->productRight($identification);
            $is_mobile = $this->is_mobile();
            if($is_mobile){
                return view('frontend.guests.mobile.add_form')
                    ->with('uuid',$uuid)
                    ->with('contacts',$contacts)
                    ->with('occupation',$occupation['content'])
                    ->with('relation',$relation['content'])
                    ->with('card_type',$card_type['content'])
                    ->with('product',$product)
                    ->with('form',$forminfo)
                    ->with('user_info',$user_info)
                    ->with('person_code',$person_code)
                    ->with('identification',$identification)
                    ->with('parameter',$data['parameter'])
                    ->with('product_res',$data['product_res']);
            }
            return view('frontend.guests.product.add_form')
                ->with('uuid',$uuid)
                ->with('contacts',$contacts)
                ->with('occupation',$occupation['content'])
                ->with('relation',$relation['content'])
                ->with('card_type',$card_type['content'])
                ->with('product',$product)
                ->with('form',$forminfo)
                ->with('user_info',$user_info)
                ->with('person_code',$person_code)
                ->with('identification',$identification)
                ->with('parameter',$data['parameter'])
                ->with('product_res',$data['product_res']);
        }else {
            return "<script>alert('订单不存在或已被删除'); window.history.go(-1);</script>";
        }
    }


    public  function confirmForm(){
//        $file_data=[];
        $input = Requests::all();
        //11.7陈延涛添加投保人与当前账户为同一人的实现开始
        $product_type = json_decode($input['json'],true)['type'];
        $user_type = User::where('id',$_COOKIE['user_id'])->first()['type'];
//        dd($user_type);
        if($product_type == 1 && $user_type == 'company'){
            return "<script>alert('当前登陆账户为企业账户，不可购买个体险');history.back();</script>";
        }
        if($product_type == 2 && $user_type == 'user'){
            return "<script>alert('当前登陆账户为个人账户，不可购买团体险');history.back();</script>";
        }
        $user_data = User::where('id',$_COOKIE['user_id'])
            ->select('phone')
            ->first();
        if($input['insurance_attributes']['ty_toubaoren']['ty_toubaoren_phone'] != $user_data['phone']){
            return "<script>alert('投保人的手机号必须是当前登陆用户的手机号!');history.back();</script>";
        }
        if($product_type == 2){
            if(!isset($input['b_file'])){
                return "<script>alert('请按模板录入并上传被保人信息!');history.back();</script>";
            }
            $b_path = UploadFileHelper::uploadFile($input['b_file'],'beibaoren/file/');
            $arr = Excel::load($b_path, function ($reader) {
                $reader->noHeading();
            })->get()->first()->toArray();
            $field = array_shift($arr);
            unset($arr[0]);
            $insured_data = array();
            foreach($arr as $k => $v){
                foreach($v as $vk => $vv){
                    $insured_data[$k][$field[$vk]] = str_replace(array("\r\n", "\r", "\n"),  '', $vv);
                }
            }
            $input['insurance_attributes']['ty_beibaoren'] = $insured_data;
        }

        $identification = $input['identification'];
//        dd($input['insurance_attributes']);
        $insurance_attributes = json_encode($input['insurance_attributes']);
        $data = $this->productRight($identification);
        //判断移动端
        $is_mobile = $this->is_mobile();
        if(isset($input['b_file'])){
            if($is_mobile){
                return view('frontend.guests.mobile.confirm_form')
                    ->with('insurance_attributes',$insurance_attributes)
                    ->with('input',$input)
//                    ->with('b_path',$b_path)
//                    ->with('file_data',$file_data)
                    ->with('parameter',$data['parameter'])
                    ->with('product_res',$data['product_res'])
                    ->with('identification',$identification);
            }
            return view('frontend.guests.product.confirm_form')
                ->with('insurance_attributes',$insurance_attributes)
                ->with('input',$input)
//                ->with('b_path',$b_path)
//                ->with('file_data',$file_data)
                ->with('parameter',$data['parameter'])
                ->with('product_res',$data['product_res'])
                ->with('identification',$identification);
        }else{
            if($is_mobile){
                return view('frontend.guests.mobile.confirm_form')
                    ->with('insurance_attributes',$insurance_attributes)
                    ->with('input',$input)
                    ->with('parameter',$data['parameter'])
                    ->with('product_res',$data['product_res'])
                    ->with('identification',$identification);
            }
            return view('frontend.guests.product.confirm_form')
                ->with('insurance_attributes',$insurance_attributes)
                ->with('input',$input)
                ->with('parameter',$data['parameter'])
                ->with('product_res',$data['product_res'])
                ->with('identification',$identification);
        }
    }

    public function groupConfirmForm()
    {
        $input = Requests::all();
        //11.7陈延涛添加投保人与当前账户为同一人的实现开始
        $product_type = json_decode($input['json'],true)['type'];
        $user_type = User::where('id',$_COOKIE['user_id'])->first()['type'];
//        dd($user_type);
        if($product_type == 1 && $user_type == 'company'){
            return "<script>alert('当前登陆账户为企业账户，不可购买个体险');history.back();</script>";
        }
        if($product_type == 2 && $user_type == 'user'){
            return "<script>alert('当前登陆账户为个人账户，不可购买团体险');history.back();</script>";
        }
        $user_data = User::where('id',$_COOKIE['user_id'])
            ->select('phone')
            ->first();
        if($input['insurance_attributes']['ty_toubaoren']['ty_toubaoren_phone'] != $user_data['phone']){
            return "<script>alert('投保人的手机号必须是当前登陆用户的手机号!');history.back();</script>";
        }
        if($product_type != 2){
            return "<script>alert('非团险产品!');history.back();</script>";
//            if(!isset($input['b_file'])){
//                return "<script>alert('请按模板录入并上传被保人信息!');history.back();</script>";
//            }
//            $b_path = UploadFileHelper::uploadFile($input['b_file'], 'beibaoren/file/');
//            $arr = Excel::load($b_path, function ($reader) {
//                $reader->noHeading();
//            })->get()->first()->toArray();
//            $field = array_shift($arr);
//            unset($arr[0]);
//            $insured_data = array();
//            foreach($arr as $k => $v){
//                foreach($v as $vk => $vv){
//                    $insured_data[$k][$field[$vk]] = str_replace(array("\r\n", "\r", "\n"),  '', $vv);
//                }
//            }
//            $input['insurance_attributes']['ty_beibaoren'] = $insured_data;
//            dd($input);
        }

        $identification = $input['identification'];
//        dd($input['insurance_attributes']);
        $insured_lists = $input['insurance_attributes']['ty_beibaoren'];
        $insurance_attributes = json_encode($input['insurance_attributes']);
        $data = $this->productRight($identification);
        return view('frontend.guests.product.group_confirm_form')
            ->with('insurance_attributes',$insurance_attributes)
            ->with('input',$input)
            ->with('parameter',$data['parameter'])
            ->with('product_res',$data['product_res'])
            ->with('identification',$identification)
            ->with('insured_lists',$insured_lists);
    }



    //订单完善信息提交
    public function insureSubmit()
    {
        $user_id = $this->getId();
        $input = Requests::all();
        dump($input);
        exit;
        $input = json_decode($input['input'],true);
        //保存常用联系人
        if(isset($input['holderDefault'])){
            if($input['holderDefault']=="on"){
                $res = UserContact::where('id_code',$input['holderIdNumber'])->first();
                if(is_null($res)){
                    UserContact::insert([
                        'user_id'=>$user_id,
                        'name'=>$input['holderName'],
                        'id_type'=>$input['holderIdType'],
                        'id_code'=>$input['holderIdNumber'],
                        'phone'=>$input['holderPhone'],
                        'email'=>$input['holderEmail'],
                        'occupation'=>$input['holderOccupation'],
                        'address'=>isset($input['insuredAddress'])? $input['insuredAddress'] : "",
                        'uuid'=>$input['uuid'],
                        'created_at'=>date('Y-m-d H:i:s',time()),
                        'updated_at'=>date('Y-m-d H:i:s',time()),

                    ]);
                }else{
                    UserContact::where('id_code',$input['holderIdNumber'])->insert([
                        'user_id'=>$user_id,
                        'name'=>$input['holderName'],
                        'id_type'=>$input['holderIdType'],
                        'id_code'=>$input['holderIdNumber'],
                        'phone'=>$input['holderPhone'],
                        'email'=>$input['holderEmail'],
                        'occupation'=>$input['holderOccupation'],
                        'address'=>isset($input['insuredAddress'])? $input['insuredAddress'] : "",
                        'uuid'=>$input['uuid'],
                        'created_at'=>date('Y-m-d H:i:s',time()),
                        'updated_at'=>date('Y-m-d H:i:s',time()),

                    ]);
                }
            }
        }else if(isset($input['insureDefault'])){
            if($input['insureDefault']=="on"){
                $res = UserContact::where('id_code',$input['insuredIdNumber'])->first();
                if(is_null($res)){
                    UserContact::insert([
                        'user_id'=>$user_id,
                        'name'=>$input['insuredName'],
                        'id_type'=>$input['insuredIdType'],
                        'id_code'=>$input['insuredIdNumber'],
                        'phone'=>$input['insuredPhone'],
                        'email'=>$input['insuredEmail'],
                        'occupation'=>$input['insuredOccupation'],
                        'address'=>isset($input['insuredAddress'])? $input['insuredAddress'] : "",
                        'uuid'=>$input['uuid'],
                        'created_at'=>date('Y-m-d H:i:s',time()),
                        'updated_at'=>date('Y-m-d H:i:s',time()),

                    ]);
                }else{
                    UserContact::where('id_code',$input['insuredIdNumber'])->update([
                        'user_id'=>$user_id,
                        'name'=>$input['insuredName'],
                        'id_type'=>$input['insuredIdType'],
                        'id_code'=>$input['insuredIdNumber'],
                        'phone'=>$input['insuredPhone'],
                        'email'=>$input['insuredEmail'],
                        'occupation'=>$input['insuredOccupation'],
                        'address'=>isset($input['insuredAddress'])? $input['insuredAddress'] : "",
                        'uuid'=>$input['uuid'],
                        'created_at'=>date('Y-m-d H:i:s',time()),
                        'updated_at'=>date('Y-m-d H:i:s',time()),

                    ]);
                }

            }
        }
        DB::beginTransaction();//开启事务
        try{
            //生成订单号
            $random = rand(0,99999999);
            $date = date('Ymd',time());
            $random_number = substr('0000000'.$random,-8);
            $deal_type = 0;
            $order_code = ($date.$random_number.$deal_type);
            //查询是否在竞赛方案中
            $ty_product_id = $input['ty_product_id'];
            $product_number = $input['product_number'];
//            $product_number = '149559395942738681';
            $competition = $this->checkCompetition($ty_product_id);
            if($competition){
                $competition_id = $competition->id;
                $is_settlement = 0;
            }else{
                $is_settlement = 1;
                $competition_id = 0;
            }
            //通过产品预订单查找信息
            $prepare_parameter = OrderPrepareParameter::where('identification',$input['identification'])->first();
            if(is_null($prepare_parameter)){
                return "<script>alert('操作失败，重新尝试');window.history.go(-1);</script>";
            }
            $ditch_id = $prepare_parameter->ditch_id;
            $agent_id = $prepare_parameter->agent_id;
            $coverageMultiples = json_decode($prepare_parameter->parameter)->clause_beishu_1;
            $order_array = array(//订单详情
                'order_code'=>$order_code,//订单编号
                'user_id'=>$user_id,//用户id
                'agent_id'=>$agent_id,
                'competition_id'=>$competition_id,//竞赛方案id，没有则为0
                'ty_product_id'=>$ty_product_id,
                'start_time'=>$input['startTime'],
//                'end_time'=>$input['end_time'],                 //cccccc
                'claim_type'=>0,
                'is_settlement'=>$is_settlement,
                'agent_id'=>$agent_id,
            );
            $policy_array = array(//        //投保人信息
                'holderName'=>$input['holderName'],
                'holderIdType'=>$input['holderIdType'],
                'holderIdNumber'=>$input['holderIdNumber'],
                'holderPhone'=>$input['holderPhone'],
                'holderEmail'=>$input['holderEmail'],
                'holderArea'=>"110000,110100,110101",  //投保人所在地
//                'holderOccupation'=>'0803027',  //投保人职业编码
                'holderOccupation'=>$input['holderOccupation'],  //投保人职业编码
                'holderAddress'=>'北京市朝阳区南沙滩小区',
            );

            //判断被保人和投保人的关系，如果是本人，则投被保人信息相同
            $relation_type = $input['holdInsRelation'];
            if($relation_type == 'self') {
                $recognizee_array[] = $policy_array;
            }else{

                //添加被保人的信息
                $WarrantyRecognizee = new WarrantyRecognizee();
                //根据省份证返回信息
                $card_info = IdentityCardHelp::getIDCardInfo($input['insuredIdNumber']);
//                dd($card_info);
                if($card_info['status'] != 2){
                    return "<script>alert('被保人". $input['insuredIdNumber'] ."身份证信息有误！'); window.history.go(-1);</script>";
                }
                if(is_null($input['insuredPhone'])){
                    $input['insuredPhone'] = '';
                }

                $recognizee_array[] = array(
                    'holdInsRelation'=>$input['holdInsRelation'],
                    'insuredName'=>$input['insuredName'],
                    'insuredPhone'=>$input['insuredPhone'],
                    'insuredBirthday'=>$card_info['birthday'],
                    'insuredSex'=>$card_info['sex']='男'?1:0,     //性别
                    'insuredIdType'=>$input['insuredIdType'],
                    'insuredIdNumber'=>$input['insuredIdNumber'],
                    'insuredArea'=>"110000,110100,110101",   //被保人所在地，   暂无，写死
                    'insurePayWay' => 10,   //缴别[年]；分别为 10,15,20   暂无，写死
                    'coverageMultiples' => $coverageMultiples,   //基础保额倍数 ，分别为 100、200、300、400、500例如10万保额传（100）（基础保额是1000元）目前只支持10万、20万、30万、50万   暂无，写死
                    'durationPeriodType' => 0,   //保期类型  0：终身【只有终身，只为0】
                    "durationPeriodValue" => 0,   //保期值0：终身【只有终身，只为0】
                );
            }
            $curl_arr['productCode'] = $product_number;
            $curl_arr['merchantOrderCode'] = $order_code;
            $curl_arr['policyHolder'] = $policy_array;
            $curl_arr['policyInsuredList'] = $recognizee_array;
            $url = env('TY_API_SERVICE_URL') .'/ins_curl/buy_ins';
//            //天眼接口参数封装
            $api_from_uuid = $input['uuid'];
            $data = $this->signHelp->tySign($curl_arr, ['api_from_uuid'=> $api_from_uuid]);
            //发送请求
            $return_data = Curl::to($url)
                ->returnResponseObject()
                ->withData($data)
                ->withTimeout(60)
                ->post();
            $return_status = $return_data->status;
            if($return_status == 200){//说明验证通过，进行数据解析,并完善信息
                $return_data = json_decode($return_data->content);
                $union_order_code = $return_data->union_Order_code;//总订单号
                $premium = $return_data->total_premium;
                $order_array['premium'] = $premium;
                $order_array['status'] = config('attribute_status.order.unpayed');
                $order_list = $return_data->order_list;
                $Order = new Order();
                $OrderParameter = new OrderParameter();
                $WarrantyPolicy = new WarrantyPolicy();     //投保人表
                $WarrantyRecognizee = new WarrantyRecognizee();  //被保人表
                $WarrantyRule = new WarrantyRule();
                $order_id = $this->add($Order,$order_array);//添加订单
                $add_policy_array = array(
                    'name' => $policy_array['holderName'],
                    'card_type'=> $policy_array['holderIdType'],
                    'occupation'=>$policy_array['holderOccupation'],
                    'code'=> $policy_array['holderIdNumber'],
                    'phone'=> $policy_array['holderPhone'],
                    'email'=> $policy_array['holderEmail'],
                    'status'=>0
                );
                $policy_id = $this->add($WarrantyPolicy,$add_policy_array);//添加投保人
                $order_recognizee_list = $return_data->order_list;
                //添加被保人
                $add_recognizee_array = array();
                foreach($recognizee_array as $value)
                {
                    $recognizee_son_array = array();
                    $recognizee_son_array['order_id'] = $order_id;
                    $recognizee_son_array['occupation'] = 1;
                    $recognizee_son_array['name'] = $value['insuredName'];
                    $recognizee_son_array['relation'] = $value['holdInsRelation'];
                    $recognizee_son_array['card_type'] = $value['insuredIdType'];
                    $recognizee_son_array['code'] = $value['insuredIdNumber'];
                    $recognizee_son_array['phone'] = $value['insuredPhone'];
                    foreach($order_list as $value1){
                        if($value1->card_id == $value['insuredIdNumber']){
                            $recognizee_son_array['order_code'] = $value1->out_order_no;
                        }
                    }
                    array_push($add_recognizee_array,$recognizee_son_array);
                }
                $recognizee_id = WarrantyRecognizee::insert($add_recognizee_array); //批量添加被保人
                //添加投保参数到参数表
                $prepare = OrderPrepareParameter::where('identification',$input['identification'])
                    ->first();
                $parameter = $prepare->parameter;
                $order_parameter_array = array(
                    'parameter'=>$parameter,
                    'order_id'=>$order_id,
                );
                $parameter_id = $this->add($OrderParameter,$order_parameter_array);
//                //添加到关联表中
                $warranty_rule_array = array(
                    'agent_id'=>$agent_id,
                    'ditch_id'=>$ditch_id,
                    'order_id'=>$order_id,
                    'union_Order_code'=>$union_order_code,
                    'parameter_id'=>$parameter_id,
                    'policy_id'=>$policy_id,
                    'ty_product_id'=>$ty_product_id,   //预留
                );
                $this->add($WarrantyRule,$warranty_rule_array);
                DB::commit();
                $identification = $input['identification'];
                unset($input['product_id']);
                unset($input['identification']);
                unset($input['product_number']);
                unset($input['_token']);
                $input = json_encode($input);
                FormInfo::insert(['forminfo'=>$input,'identification'=>$identification,'union_order_code'=>$union_order_code]);
                return redirect('/product/pay_settlement/'.$union_order_code);
            }else {//说明验证未通过，返回错误信息,
                if($return_status == 500){
                    return "<script>alert('当前用户不适合投保，请更换后稍后重试'); window.history.go(-1);</script>";
                }
                $error_message = $return_data->content;
                 $pos = mb_strripos($error_message,'！');
                 if($pos){
                     $error_message = mb_substr($error_message,0,$pos+1);
                 }
                return "<script>alert('" .$error_message ."');window.history.go(-1);</script>";
            }
        }catch (Exception $e)
        {
            DB::rollBack();
            return "<script>alert('下单失败，重新尝试');window.history.go(-1);</script>";
        }
    }


    //跳转到支付页面
    public function paySettlement($union_order_code){

        $warranty = WarrantyRule::where('union_order_code', $union_order_code)
            ->with(['warranty_rule_product','warranty','warranty_rule_order'])
            ->first();
//        dd($warranty);
        $product = $warranty->warranty_rule_product;
        $order = $warranty->warranty_rule_order;
        $banks = Bank::get();
        $user_banks = UserBank::where('user_id',$_COOKIE['user_id'])->get();
        $bank_res = count($user_banks);
        $json =  json_decode($product->json,true);
        $company = $json['company'];
        $clause = $json['clauses'];
        $order['premium'] = $order['premium']/100;
        $is_mobile = $this->is_mobile();
        if($is_mobile){
            return view('frontend.guests.mobile.payment')
                ->with('banks',$banks)
                ->with('bank',$bank_res)
                ->with('user_bank',$user_banks)
                ->with('order',$order)
                ->with('company',$company)
                ->with('clause',$clause)
                ->with('product',$product)
                ->with('warranty',$warranty)
                ->with('union_order_code',$union_order_code);
        }
        return view('frontend.guests.product.payment')
            ->with('banks',$banks)
            ->with('bank',$bank_res)
            ->with('user_bank',$user_banks)
            ->with('order',$order)
            ->with('company',$company)
            ->with('clause',$clause)
            ->with('product',$product)
            ->with('warranty',$warranty)
            ->with('union_order_code',$union_order_code);
    }
    public function saveBank(){
        $input = Requests::all();
        $res = UserBank::where('user_id',$_COOKIE['user_id'])->where('bank_code',$input['bank_code'])->first();
        if(!is_null($res)){
            return back()->withErrors('您已添加过此银行卡信息');
        }
        UserBank::insert([
            'user_id'=>$_COOKIE['user_id'],
            'bank_code'=>$input['bank_code'],
            'bank_name'=>$input['bank_name'][0],
            'bank_phone'=>$input['bank_phone'],
            'created_at'=>date('Y-m-d H:i:s',time()),
            'updated_at'=>date('Y-m-d H:i:s',time())
        ]);
        return back()->with('添加成功');
    }
    //订单支付处理，进行支付和核保接口调用
    public function orderPaySettlement()
    {
        $input = Requests::all();

        $union_order_code = $input['order_code'];

        $bank = explode('-', $input['bank_code']);
        dump($input);
//        dump($bank);
//        exit;
        //判断是否是自己的订单
        $biz_content = array();
        $biz_content['unionOrderCode'] = $input['order_code'];  //合并的订单号
        $biz_content['bankCode'] = $bank[0];  //银行代号
        $biz_content['hengqinBankCode'] = isset($bank[1])?$bank[1]:$input['bank_num']; //银行编码  ,需要从数据库获取
        $biz_content['bankCardNum'] = $input['card_number'] ? $input['card_number'] : 11; //银行卡号

        //通过订单号，查找产品的简称    cccccccccc
        $warranty_rule = WarrantyRule::where('union_order_code',$union_order_code)
            ->with('warranty_product','warranty_rule_order')->first();
        $api_from_uuid = $warranty_rule->warranty_product->api_from_uuid;
        $data = $this->signHelp->tySign($biz_content, ['api_from_uuid'=> $api_from_uuid]);
        $response = Curl::to(env('TY_API_SERVICE_URL') .'/ins_curl/pay_ins')
            ->returnResponseObject()
            ->withData($data)
            ->withTimeout(60)
            ->post();
        $return_data = json_decode($response->content);
//        return view('frontend.guests.product.paysuccess');
        if(empty($return_data))
            return "<script>alert('".$response->content."'); location.href='/order/index/all';</script>";
        $status = $response->status;
        if($status == 200)
        {//数据返回成功，进行佣金结算和价格变更
            //佣金
            DB::beginTransaction();
            try{
                $order_id = $warranty_rule->order_id;
                $agent_id = $warranty_rule->agent_id;
                $ditch_id = $warranty_rule->ditch_id;
                $premium = $warranty_rule->warranty_rule_order->premium;
                $product_id = $warranty_rule->product_id;
                $is_competition = $this->checkCompetition($product_id); //检验是否在竞赛方案中
                if($is_competition){//说明在竞赛方案中
                    $is_settlement = 0; //代理人佣金为结算
                    $competition_id =$is_competition->id;
                }else{//不再竞赛方案中
                    $competition_id = 0;
                    $is_settlement = 1;  //代理人佣金已结算
                }
                //修改订单状态
                $Order = Order::find($order_id);
                $change = array(
                    'pay_time'=>date('Y-m-d H:i:s'),
                    'competition_id'=>$competition_id,
                    'is_settlement'=>$is_settlement,
                    'status'=>config('attribute_status.order.payed'),
                );
                $this->edit($Order,$change);
                if($agent_id){ //代理人佣金结算
                    //获取代理人的佣金
                    $arr = array(
                        'product_id'=>$product_id,
                        'ditch_id'=>$ditch_id
                    );
                    $brokerage = $this->getMyAgentBrokerage($product_id,$ditch_id,$agent_id);
                    $rate = $brokerage['earnings']; //佣金比
                    //判断是否进行账户余额结算
                    $money = ($premium*$rate)/100;
                    if($is_settlement){//添加到账户操作表中，修改账户余额
                        $this->changeAgentAccount($agent_id,$money);
                        $this->addAgentAccountRecord($agent_id,$money,'订单交易佣金',0);
                    }
                    $OrderBrokerage = new OrderBrokerage();
                    $order_brokerage_array = array(
                        'order_id'=>$order_id,
                        'order_pay'=>$premium,
                        'user_earnings'=>$money,
                        'rate'=>$rate,
                        'agent_id'=>$agent_id,
                        'ditch_id'=>$ditch_id,
                        'is_settlement'=>$is_settlement,
                        'status'=>'1'
                    );
                    $this->add($OrderBrokerage,$order_brokerage_array);
                }
                //通过产品查找佣金比率
                //公司佣金结算
                $CompanyBrokerage = new CompanyBrokerage();
                $company_brokerage_array = array(
                    'order_id'=>$order_id,        //订单id
                    'brokerage'=> $return_data->income,     //返回的佣金    //
                    'status'=>0,
                );
                $this->add($CompanyBrokerage,$company_brokerage_array);
                DB::commit();
                $result = $this->issue->issue($api_from_uuid,$warranty_rule);
                return view('frontend.guests.product.pay_success')
                    ->with('order_id',$order_id)
                    ->with('order_money',$premium/100);
//                return redirect('/order/index/all')->with('status','购买成功');
            }catch (Exception $e){
                DB::rollBack();
            }

        }else{
            //返回错误信息，同时修改订单状态
            $order_id = $warranty_rule->order_id;
            $warranty_id = $warranty_rule->id;
            $change_order = Order::find($order_id);
            $change_warranty = WarrantyRule::find($warranty_id);
            $change_status_array = array(
                'status'=>config('attribute_status.order.fail'),
            );
            $this->edit($change_order,$change_status_array);
            $this->edit($change_warranty,$change_status_array);
//            dd($return_data);
//            if(!is_object($return_data))
//                return "<script>alert('".$return_data."'); location.href='/order/index/all';</script>";
//            exit;
            //返回数组，说明是核保失败
            $data = $return_data->order_list;
            foreach($data as $value)
            {
                $error_person = array();
                $error_message = '以下人员核保失败：';
                if($value->status != 'pay_ing')
                {
                    $person_name = WarrantyRecognizee::where('code',$value->card_id)
                        ->first();
                    $error_message.=$person_name->name;
//                        array_push($error_person,$person_name->name);
                }
            }
            return "<script>alert('".$error_message."');window.history.go(-1);</script>";

        }
    }
    public function orderPaySuccess($order_code=null){
        $order_data = isset($order_code)?Order::where('order_code',$order_code)->first():'';
        $is_mobile = $this->is_mobile();
        if($is_mobile){
            return view('frontend.guests.mobile.pay_success',compact('order_data'));
        }
        return view('frontend.guests.product.pay_success');
    }
    public function addForms(){
        $identification = '201708228592224';
        $data = $this->productRight($identification);
        return view('frontend.guests.product.add_forms')
            ->with('tariff_params',$data['tariff_params'])
            ->with('parameter',$data['parameter'])
            ->with('product_res',$data['product_res'])
            ->with('identification',$identification);
    }
//    public  function insureClause(){
//        return view('frontend.guests.product.insure_clauses');
//    }
    //封装一个方法，用来发送url请求
    public function _curl($biz_content)
    {
        $sign_help = new RsaSignHelp();
        //=======业务参数封装=======
        $biz_content = $biz_content;
            //订单信息
        //=======天眼接口参数封装=======
        //业务数组 -> json->base64_url安全 -> 翻转后字符串
        $biz_content = strrev($sign_help->base64url_encode(json_encode($biz_content)));
        $data['account_id'] = '201706161843147185'; //id
        $data['timestamp'] = time();  //时间戳
        $data['biz_content'] = $biz_content;    //业务参数特殊字符串
        krsort($data);  //排序
        $data['sign'] = md5($sign_help->base64url_encode(json_encode($data)) . 'a62088c9eedfb88e33b16070422e0902'); //签名 todo 需要更安全
        //发送请求
        $response = Curl::to(config('curl_product.api_service_url') . '/check_ins')
            ->returnResponseObject()
            ->withData($data)
            ->withTimeout(60)
            ->post();
        echo "<pre>";
        var_dump(json_decode($response->content, true));
    }

    public function productInfo($id){

        $ditch_id = 0;
        $agent_id = 0;
        //获取产品详细信息

//        //判断是否有代理人和渠道
//       if(isset($_GET['sole_code'])) {//说明有代理人
//            $sole_code = $_GET['sole_code'];
//            //进行解密
//            $parameter_arr = explode(',', base64_decode($sole_code));
//            //判断该代理是否有权卖此款产品
//            $ditch_id = $parameter_arr[1];
//            $agent_id = $parameter_arr[2];
//            $isMyProduct = $this->isMyProduct($product_id,$ditch_id,$agent_id);
//            if(!$isMyProduct){//说明无权
//                return "<script>alert('错误');window.history.go(-1);</script>";
//            }
//        }else if(isset($_GET['plan'])){//说明有计划书
//           $sole_code = $_GET['plan'];
//           $plan = Plan::where('sole_code',$sole_code)
//               ->first();
//           if(!$plan){
//               return "<script>alert('页面错误');window.history.go(-1);</script>";
//           }
//           $plan_detail = json_decode($plan->parameter);
//           $plan_detail = $this->objectarray_pre($plan_detail);
//           return view('frontend.guests.product.plan',compact('ditch_id','agent_id','plan_detail'))
//               ->with('res', $product_info['res'])
//               ->with('ke', $product_info['ke'])
//               ->with('tari', $product_info['math'])
//               ->with('labels', $product_info['labels'])
//               ->with('clause',$product_info['clause']);
//       }
//        $onlines = OnlineService::where('status','0')->get();
//        return view('frontend.guests.product.info',compact('ditch_id','agent_id'))
//            ->with('res', $product_info['res'])
//            ->with('ke', $product_info['ke'])
//            ->with('tari', $product_info['math'])
//            ->with('labels', $product_info['labels'])
//            ->with('clause',$product_info['clause'])
//            ->with('onlines',$onlines);
        //判断移动端
        $is_mobile = $this->is_mobile();
        if($is_mobile){
            return view('frontend.guests.mobile.product_info');
        }
            return view('frontend.guests.product.product_info');
    }
    public function selectTariff(Request $request){
        $clause_ids = trim($request->get('clause_ids'), ',');
        $clause_ids_arr = explode(',', $clause_ids);
        $clause_arr_beishu = array();
        //键为条款ID ，值为相对基本保额的倍数
        foreach($clause_ids_arr as $k => $v){
            $clause_arr_beishu[$v] = $request->get('clause_beishu_' . $v);
        }
//        dd($clause_arr_beishu);
        if(!isset($_GET['shebao'])){
            $_GET['shebao'] = "#";
        }
        if(!isset($_GET['age'])){
            $_GET['age'] = "#";
        }
        if(!isset($_GET['period'])){
            $_GET['period'] = "#";
        }
        if(!isset($_GET['by_stages'])){
            $_GET['by_stages'] = "#";
        }
        $age = trim($_GET['age']);
        $sex = trim($_GET['sex']);
        $shebao = trim($_GET['shebao']);
        $period = trim($_GET['period']);
        $by_stages = trim($_GET['by_stages']);

        $res = Tariff::whereIn("age", [$age, '#'])
            ->whereIn('clause_id', $clause_ids_arr)
            ->whereIn('sex', [$sex, '#'])
            ->whereIn('period', [$period, '#'])
            ->whereIn('by_stages', [$by_stages, '#'])
            ->whereIn('shebao',[$shebao, '#'])
            ->get()
            ->toArray();
        if(count($res)){
            $t = array();
            foreach($res as $k => $v){
                $t[] = $v['tariff'] / 100 * $clause_arr_beishu[$v['clause_id']];
            }
            $tari = array_sum($t);
        } else {
            $tari = '无结果';
        }
        return (['status'=>'0','tariff'=>$tari]);
    }
    //封装一个方法，用来判断是否是竞赛方案中
    public function checkCompetition($product_id)
    {
        $time = date('Y-m-d',time());
        $competition = Competition::where([
            ['product_id',$product_id],
            ['start_time','<=',$time],
            ['end_time','>=',$time],
        ])->orwhere([
            ['product_id',0],
            ['start_time','<=',$time],
            ['end_time','>=',$time],
        ])->first();
        return $competition;
    }

    //封装一个方法，用来获取代理人的佣金比率
    public function getMyAgentBrokerage($product_id,$ditch_id,$agent_id)
    {
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
        return array(
            'earnings'=>$earning,
        );
    }
    //封装一个方法，用来判断是否是自己的可售产品
    public function isMyProduct($product_id,$ditch_id,$agent_id)
    {
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
            return true;
        }else{
            return false;
        }
    }
    //封装一个方法，添加到记录中
    public function addAgentAccountRecord($agent_id,$money,$operate,$competition_id)
    {
        $account_sum = AgentAccount::where('agent_id',$agent_id)  //账户余额
        ->first()->sum;
        //添加记录
        $AgentAccountRecord = new AgentAccountRecord();
        $AgentAccountRecord->money = $money;
        $AgentAccountRecord->agent_id = $agent_id;
        $AgentAccountRecord->operate = $operate;
        $AgentAccountRecord->status = 0;
        $AgentAccountRecord->balance = $account_sum;
        $AgentAccountRecord->competition_id = $competition_id;
        $result = $AgentAccountRecord->save();
        return $result;
    }
    //封装一个方法，修改账户余额
    public function changeAgentAccount($agent_id,$money)
    {
        $brokerage = AgentAccount::where('agent_id',$agent_id)->first();
        if(!$brokerage){//说明没有账户，添加
            $AgentAccount = new AgentAccount();
            $agent_account_array = array(
                'sum'=>0,
                'settlement_date'=>0,
                'agent_id'=>$agent_id,
            );
            $this->add($AgentAccount,$agent_account_array);
        }
        $brokerage = AgentAccount::where('agent_id',$agent_id)->first();
        $sum = $brokerage->sum+$money;
        $brokerage->sum = $sum;
        $result = $brokerage->save();
        return $result;
    }
    function objectarray_pre($object) {
        if (is_object($object)) {
            $arr = (array)($object);
        } else {
            $arr = &$object;
        }
        if (is_array($arr)) {
            foreach($arr as $varName => $varValue){
                $arr[$varName] = $this->objectarray_pre($varValue);
            }
        }
        return $arr;
    }
    public function checkAge(Request $request){
        $age = $request->get('age');
        $product_id = $request->get('product_id');
        $info = $this->getProductInfo($product_id);
        $ages = $info['ke']['年龄']['age'];
        if(in_array($age,$ages)){
            return (['status'=>'0']);
        }else{
            return (['status'=>'1']);
        }
    }
    public function saveFormInfo(Request $request){
        $input = $request->all();
        $identification = $input['identification'];
        unset($input['_token']);
        if(isset($input['forminfo_id'])){
            $forminfo_id = $input['forminfo_id'];
            $res = FormInfo::where('id',$forminfo_id)->first()->identification;
            $input = json_encode($input);
            if(!is_null($res)){
                FormInfo::where('id',$forminfo_id)->update(['forminfo'=>$input]);
                return (['status'=>'0','msg'=>'保存成功！']);
            }else{
                FormInfo::insert(['forminfo'=>$input,'identification'=>$identification]);
                return (['status'=>'0','msg'=>'保存成功！']);
            }
        }else{
            $input = json_encode($input);
            $res = FormInfo::where('identification',$identification)->first();
            if(!is_null($res)){
                FormInfo::where('identification',$identification)->update(['forminfo'=>$input]);
                return (['status'=>'0','msg'=>'保存成功！']);
            }else{
                FormInfo::insert(['forminfo'=>$input,'identification'=>$identification]);
                return (['status'=>'0','msg'=>'保存成功！']);
            }
        }
    }

    /**
     * 团险支付(pc/移动)
     */
    public function group_order_pay($order_id,$product_id)
    {

        //公司信息
        $companyOld = Product::where([
            ['ty_product_id',$product_id],
            ['insure_type',2]
        ])->first();
        $company = json_decode($companyOld['json'],true);
//        dd($company);
        $company_bank = $company['company'];
//        dd($company_bank);
        //订单信息
        $orderData = Order::where([
            ['order_code',$order_id],
            ['user_id',$this->getId()]
        ])->first();
//        dd($company_bank);
        if(!$this->is_mobile()){
            return view('frontend.guests.product.grouppayment',compact('company_bank','orderData','companyOld'));
        }else{
            return view('frontend.guests.mobile.group_pay',compact('company_bank','orderData','companyOld'));
        }
    }
}