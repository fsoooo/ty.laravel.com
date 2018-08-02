<?php
/**
 * Created by PhpStorm.
 * User: xyn
 * Date: 2017/8/18
 * Time: 10:53
 */

namespace App\Http\Controllers\ApiControllers;

use App\Models\Agent;
use App\Models\MarketDitchRelation;
use App\Models\OrderBrokerage;
use App\Models\PlanLists;
use App\Models\Scaling;
use Cache, DB;
use Hamcrest\Core\Is;
use Illuminate\Http\Request;
use App\Helper\RsaSignHelp;
use App\Helper\LogHelper;
use Illuminate\Support\Facades\Auth;
use Ixudra\Curl\Facades\Curl;
use App\Models\Product;
use App\Models\ApiInfo;
use App\Models\Order;
use App\Models\Bank;
use App\Models\UserBank;
use App\Models\OrderParameter;
use App\Models\Competition;
use App\Models\WarrantyRule;
use App\Models\WarrantyPolicy;
use App\Models\CompanyBrokerage;
use App\Models\WarrantyRecognizee;
use App\Models\OrderPrepareParameter;
use App\Helper\IsPhone;
use App\Helper\Issue;
use App\Helper\ErrorNotice;
use App\Models\AuthenticationPerson;
use App\Models\User;
use Excel;
use \Illuminate\Support\Facades\Redis;

class InsApiController
{
    protected $_request;
    protected $_signHelp;
    protected $is_phone;

    public function __construct(Request $request)
    {
        $this->_request = $request;
        $this->_signHelp = new RsaSignHelp();
        $this->is_phone = isset($_SERVER['HTTP_USER_AGENT']) ? IsPhone::isPhone() : null;
        $this->error_notice = new ErrorNotice();

    }
    /**
     * 产品试算详情页
     * @return string
     */
    public function insInfo($id)
    {
        $input = $this->_request->all();
        $ins_type = $this->is_groupIns($id);
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
//        dd($response);
//        print_r($response->content);exit;
        if($response->status != 200){
            LogHelper::logError($biz_content, $response->content, 'ty', 'ins_api_info');
            return $this->error_notice->error('获取产品详情失败');
        }
        $return_data = json_decode($response->content, true);
//        dump($return_data);die;
        //健康告知是否验证
        $health_verify = $return_data['switch']['health_verify'] ?? 0;

        $ins = $this->insApiInfo($return_data);
        $restrict_genes = $return_data['option']['restrict_genes'];     //算费因子
       $selected_options = $return_data['option']['selected_options']; //默认算费选中项
        $protect_items = isset($return_data['option']['protect_items']) ? $return_data['option']['protect_items'] : ''; //保障内容
        $price = (int)$return_data['option']['price']; //默认费率
        if(!$ins)
            return $this->error_notice->error('获取产品详情失败');
//            return "<script>alert('获取产品详情失败！');location.href='/'</script>";
        $product_info = Product::where('ty_product_id',$id)->with('label.labels')->first();//产品详情
        $company = json_decode($product_info->json,true)['company'];
        $clauses = json_decode($product_info->clauses,true);
        $duty = [];
        foreach ($clauses as $value){
            if(isset($value['duties'])){
                $duty[] = $value['duties'];
            }
        }
        $option_html = $this->optionHtml($restrict_genes, $selected_options, $price);
        $protects = [];
        if(!empty($protect_items)){
            foreach ($protect_items as $key=>$value){
                $protects[$key]['value'] = $value['name'];
                $protects[$key]['text'] = $value['defaultValue'];
            }
        }

        $item_html = $protect_items ? $this->itemHtml($protect_items) : '';
        $object = Product::where('ty_product_id', $id)->first();
        $json = $object->json;
        $json = json_decode($json, true);
        if(!is_null($object['cover'])){
            $json['cover']= $object['cover'];
        }

        //计划书已读
        if(isset($input['agent_id']) && isset($input['ditch_id']) && isset($input['plan_id']))
            PlanLists::where(['id'=> $input['plan_id'], 'status'=> 1])->update(['status'=> 2, 'read_time'=> date("Y-m-d H:i:s")]);
//        dd($selected_options);
        if($this->is_phone){
            return view('frontend.guests.mobile.product_info')
                ->with('price',$price)
                ->with('duty',$duty)
                ->with('company',$company)
                ->with('clauses',$clauses)
                ->with('product_info',$product_info)
                ->with('option_html',$option_html)
                ->with('protect_items',$protect_items)
                ->with('protects',$protects)
                ->with('item_html',$item_html)
                ->with('ins_type',$ins_type)
                ->with('ty_product_id',$id)
                ->with('health_verify',$health_verify)
                ->with('ins',$ins);
        }
        //        dd($id);
        return view('frontend.guests.product.product_info')
            ->with('duty',$duty)
            ->with('company',$company)
            ->with('json',$json)
            ->with('clauses',$clauses)
            ->with('product_info',$product_info)
            ->with('option_html',$option_html)
            ->with('item_html',$item_html)
            ->with('ins_type',$ins_type)
            ->with('ty_product_id',$id)
            ->with('health_verify',$health_verify)
            ->with('ins',$ins);
    }
    /**
     * 算费
     * @return mixed
     */
    public function quote()
    {
        $biz_content = $this->_request->all();
//        $is_mobile = $this->is_mobile();
        //天眼接口参数封装
        $data = $this->_signHelp->tySign($biz_content);
        //发送请求
        $response = Curl::to(env('TY_API_SERVICE_URL') . '/ins_curl/quote')
            ->returnResponseObject()
            ->withData($data)
            ->withTimeout(60)
            ->post();
//        dd(json_decode($response->content));exit;
        if($response->status !== 200)
            return response($response->content, $response->status);
        $data = json_decode($response->content, true);
        //如果返回值中存在 其他受影响参数的选项 就覆盖原来选项
        $options = json_decode($this->_request->get('old_option'), true);
        if(isset($data['new_genes'])){
            foreach($data['new_genes'] as $return_k => $return_v){
                foreach($options as $k => $v){
                    if($return_v['name'] == $v['name']){
                        $options[$k] = $return_v;
                    }
                }
            }
        }

        //如果返回值中存在 保障内容有变化
        $old_protect_item = isset($this->_request->old_protect_item) ? json_decode($this->_request->get('old_protect_item'), true) : array();

        if(isset($data['protect_items']) && $data['protect_items']){
            //保障项目不是走接口返回的，不存在protectItemId，且数据为此次算费的所有保障内容
            if(!isset($data[0]['protectItemId'])){
                $old_protect_item = $data['protect_items'];
            } else {
                //接口返回的存在protectItemId，数据为此次被变更的保障内容
                foreach($data['protect_items'] as $it => $new_item){
                    foreach($old_protect_item as $old_k => $old_item){
                        if($new_item['protectItemId'] == $old_item['protectItemId']){
                            $old_protect_item[$old_k] = $new_item;
                        }
                    }
                }
            }
        }
        //生成HTML
        $option_html = $this->optionHtml($options, $data['selected_options'], $data['price']);
        $item_html = $old_protect_item ? $this->itemHtml($old_protect_item) : '';
        $return = ['option_html'=> $option_html, 'item_html'=> $item_html];
        return response($return, 200);
    }
    /**
     * 预购订单
     */
    public function prepareOrder()
    {
        //        echo "<pre>";
        //        print_r($this->_request->all());
        $input = $this->_request->all();
        $ty_product_id = $input['ty_product_id'];
        if($ty_product_id == 29 || $ty_product_id == 49){
            return "<script>alert('报备产品，不可投保');history.back();</script>";
        }
        $product_type = Product::where('ty_product_id',$ty_product_id)->pluck('insure_type')[0];

        //原有处理逻辑 团险时验证健康告知
        $res = $this->getProductType($ty_product_id);
        $input['health_verify'] =  $input['health_verify'] ?? '';
        if($input['health_verify']){
            $res = 3;
        }
        $agent_id = $input['agent_id'];
        $ditch_id = $input['ditch_id'];
        $plan_id = $input['plan_id'];
        $api_info =ApiInfo::where('private_p_code', $input['private_p_code'])->first();

        $product_res = Product::where('ty_product_id',$ty_product_id)->first();//投保须知
        $product_claes = json_decode($product_res['json'],true)['content'];
        //        $json = json_decode($api_info->json, true);
        //        dd($json);
        $random = rand(0,9999999);
        $random_number = substr('0000000'.$random,-7);
        $date = date('Ymd',time());
        $identification = ($date.$random_number);
        unset($input['_token']);
        $parameter = json_encode($input);
        $order_prepare_parameter = new OrderPrepareParameter();
        $order_prepare_parameter->agent_id = $agent_id;
        $order_prepare_parameter->ditch_id = $ditch_id;
        $order_prepare_parameter->plan_id = $plan_id;
        $order_prepare_parameter->identification = $identification;
        $order_prepare_parameter->parameter = $parameter;
        $order_prepare_parameter->ty_product_id = $api_info->ty_product_id;
        $order_prepare_parameter->private_p_code = $input['private_p_code'];
        if($order_prepare_parameter->save()){
            //预存成功,跳转到完善信息页面
            setcookie('identification',$identification,time()+3600,'/');
//            $is_mobile = $this->is_mobile();
            if($this->is_phone){
                return view('frontend.guests.mobile.cover_notes')
                    ->with('res',$res)
                    ->with('product_type',$product_type)
                    ->with('product_res',$product_claes)
                    ->with('ty_product_id',$ty_product_id)
                    ->with('identification',$identification);
            }
            $data = $this->productRight($identification);

            return view('frontend.guests.product.cover_notes')
                ->with('res',$res)
                ->with('parameter',$data['parameter'])
                ->with('product_claes',$product_claes)
                ->with('product_res',$data['product_res'])
                ->with('identification',$identification);
        }else{
            return back()->withErrors('出错了，请重新尝试');
        }
    }
    //健康须知
    public function healthNotice($identification){


        $data = $this->productRight($identification);

        //获取第三方健康告知  暂时只有惠泽一部分产品使用
        if($data['parameter']['health_verify']){
            $parameter = $this->_signHelp->tySign($data['parameter']);

//            print_r(json_encode($data['parameter']));die;
            //请求健康告知
            $response = Curl::to(env('TY_API_SERVICE_URL') . '/ins_curl/get_health_statement')
                ->returnResponseObject()
                ->withData($parameter)
                ->withTimeout(60)
                ->post();
//            dump(json_decode($response->content,true));
            if($response->status !== 200)
                return response($response->content, $response->status);

            $content = json_decode($response->content, true);

            $product_res = $content['healthyModules'][0];


            $selected = json_decode($data['parameter']['selected'],true);

            $ty_keys = [];
            foreach($selected['genes'] as $value){
                if(isset($value['ty_key'])) $ty_keys[$value['ty_key']] = $value['value'];
            }

            $params = [];
            $params['age'] =$this->countAge($ty_keys['ty_age']);//年龄
            $params['price'] = $data['parameter']['price'];//保费
            $params['sex'] = $ty_keys['sex']??"";//性别
            $params['pay_way'] = $ty_keys['ty_pay_way']??"";//缴别
            $params['period_value'] = $ty_keys['ty_duration_period_value']??"";//保障

            if($this->is_phone){
                return view('frontend.guests.mobile.health_notice_api')
                    ->with('parameter',$data['parameter'])
                    ->with('params',$params)
                    ->with('healthId',$content['healthId'])
                    ->with('transNo',$content['transNo'])
                    ->with('partnerId',$content['partnerId'])
                    ->with('product_res',$product_res)
                    ->with('identification',$identification);
            }else{
                return view('frontend.guests.product.health_notice_api')
                    ->with('parameter',$data['parameter'])
                    ->with('params',$params)
                    ->with('healthId',$content['healthId'])
                    ->with('transNo',$content['transNo'])
                    ->with('partnerId',$content['partnerId'])
                    ->with('product_res',$product_res)
                    ->with('identification',$identification);
            }
        }

        $health_res = json_decode($data['product_res']['json'],true)['insurance_health']??[];
       if(empty($health_res)&&count($health_res)==0){
            return redirect('/ins/insure/'.$identification);
       }
        $selected = json_decode($data['parameter']['selected'],true);
        $ty_keys = [];
        foreach($selected as $value){
            $ty_keys[$value['ty_key']] = $value['value'];
        }

        $params = [];

        $ty_keys['ty_birthday'] = $ty_keys['ty_birthday'] ?? '';
        if($ty_keys['ty_birthday']){
            $ty_keys['ty_age'] = $this->countAge($ty_keys['ty_birthday']);
        }

        if($ty_keys['ty_birthday'] || $ty_keys['ty_age']) $params['age'] = $ty_keys['ty_age'] ?? '';//年龄
        $params['price'] = $data['parameter']['price'];//保费
        $params['sex'] = $ty_keys['ty_sex']??"";//性别
        $params['pay_way'] = $ty_keys['ty_pay_way']??"";//缴别
        $params['period_value'] = $ty_keys['ty_period_value']??"";//保障
        if($this->is_phone){
            return view('frontend.guests.mobile.health_notice')
                ->with('parameter',$data['parameter'])
                ->with('product_res',$data['product_res'])
                ->with('health_res',$health_res)
                ->with('identification',$identification);
        }
        return view('frontend.guests.product.health_notice')
            ->with('parameter',$data['parameter'])
            ->with('product_res',$data['product_res'])
            ->with('health_res',$health_res)
            ->with('params',$params)
            ->with('identification',$identification);
    }

    /**
     * 提交健康告知   暂时只有惠泽使用
     */
    public function subHealthNotice(){
        $input = $this->_request->all();

        //格式化封装回答
        $qaAnswer = $input['qaAnswer'];
        $questionArr = $input['question'];
        $healthyQaModules['healthyQaQuestions'] = [];
        $healthyQaModules['moduleId'] = $input['moduleId'];
        $questionKey = array_keys($input['question']);

        foreach ($input['answer'] as $key=>$val){
            //封装答案
            $answer_data = [];
            foreach ($val as $kk=>$vv){
                $answer = [];
                $answer['answerId'] = $kk;
                $answer['answerValue'] = $vv[array_keys($vv)[0]];
                $answer['keyCode'] = array_keys($vv)[0];

                $answer_data[] = $answer;
            }

            if(is_int($key)){

                $question = [];
                $question['questionId'] = $key;
                $question['parentId'] = $questionArr[$key]['parentId'];
                $question['questionSort'] = $questionArr[$key]['questionSort'];
                $question['healthyQaAnswers'] = $answer_data;
                $healthyQaModules['healthyQaQuestions'][] = $question;

            }else{
                $questionIds = array_filter(explode(',', $key));

                foreach ($questionIds as $vo){
                    //有可能存在没返回的的问题id
                    if(in_array($vo, $questionKey)){
                        //封装问题
                        $question = [];
                        $question['questionId'] = $vo;
                        $question['parentId'] = $questionArr[$vo]['parentId'];
                        $question['questionSort'] = $questionArr[$vo]['questionSort'];
                        $question['healthyQaAnswers'] = $answer_data;
                        //$qaAnswer['healthyQaModules']['healthyQaQuestions'][] = $question;
                        $healthyQaModules['healthyQaQuestions'][] = $question;
                    }
                }
            }
        }
        $qaAnswer['healthyQaModules'][] = $healthyQaModules;


        $data = $this->productRight($input['identification']);
        $parameter = $data['parameter'];
        $parameter['transNo'] = $input['transNo'];
        $parameter['qaAnswer'] = $qaAnswer;

        $parameter = $this->_signHelp->tySign($parameter);
        //请求健康告知
        $response = Curl::to(env('TY_API_SERVICE_URL') . '/ins_curl/sub_health_statement')
            ->returnResponseObject()
            ->withData($parameter)
            ->withTimeout(60)
            ->post();
//        dump($response);

        if($response->status !== 200)
            return $this->error_notice->error($response->content, 1);

        $content = json_decode($response->content, true);

        $data['parameter']['healthId'] = $content['healthId'];

        if(OrderPrepareParameter::where('identification', $input['identification'])->update([
            'parameter'=> json_encode($data['parameter'])
        ])){
            //健康告知录入成功
            return redirect('ins/insure/'.$input['identification']);
        }
    }

    /**
     * 获取当前产品的类型
     */
    public function countAge($birthday){
        $year=date('Y');
        $month=date('m');
        if(substr($month,0,1)==0){
            $month=substr($month,1);
        }
        $day=date('d');
        if(substr($day,0,1)==0){
            $day=substr($day,1);
        }
        $arr=explode('-',$birthday);

        $age=$year-$arr[0];
        if($month<$arr[1]){
            $age=$age-1;

        }elseif($month==$arr[1]&&$day<$arr[2]){
            $age=$age-1;

        }
        return $age;
    }

    /**
     * 获取当前产品的类型
     */
    public function getProductType($id)
    {
        $res = Product::where('ty_product_id',$id)
            ->first();
        if($res['insure_type'] == 2){
            return 2;
        }
        return 1;
    }

    /**
     * 投保页
     * @param $identification
     * @return string
     * @throws \Exception
     */
    public function insure($identification)
    {
        //判断是否有预存的信息
        $prepare = OrderPrepareParameter::where('identification', $identification)->first();
        if(!$prepare)
            return $this->error_notice->error('订单不存在或已被删除','1');
        $product = Product::where('ty_product_id', $prepare->ty_product_id)->first();
        $api_info = ApiInfo::where('private_p_code', $prepare->private_p_code)->first()->toArray();
        $ins = json_decode($api_info['json'], true);
        $json = json_decode($product['json'], true);
        $data = $this->productRight($identification);
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
//        }else{
//            $user_true['name'] = '';
//            $user_true['code'] = '';
//            $user_true['phone'] = '';
//            $user_true['email'] = '';
//            $user_true['address'] = '';
//            $user_true['occupation'] = '';
//        }
        //没找到去除\n的方法
        if($prepare->private_p_code=='UXgtUVgwMDAwMDAwMDE2MTg'){
            unset($ins['jobs'][9]['name']);
            $ins['jobs'][9]['name'] = '新闻出版广告业';
        }
        $user_true = empty($user_true) ? [] : $user_true;
        $view = 'frontend.show_ins.add_form';
        if($product->insure_type == 2){
            $view = 'frontend.show_ins.group_add_form';
        }
        if($this->is_phone && $product->insure_type == 2){
            $view = 'frontend.guests.mobile.groupins';
        }
        if($this->is_phone){
            $view = 'frontend.guests.mobile.add_form';
        }

        return view($view)
            ->with('ins',$ins)
            ->with('json',$json)
            ->with('product',$product)
            ->with('parameter',$data['parameter'])
            ->with('product_res',$data['product_res'])
            ->with('user_true',$user_true)
            ->with('identification',$identification);
    }

    /**
     * 投保信息确认页（个险）
     *
     */
    public  function confirmForm(){
        $input = $this->_request->all();
        //11.7陈延涛添加投保人与当前账户为同一人的实现开始
        $product_type = json_decode($input['json'],true)['type'];
        //TODO 已登录
        if(isset($_COOKIE['user_id'])){
        $user_type = User::where('id',$_COOKIE['user_id'])->first()['type'];
        if($product_type == 1 && $user_type == 'company'){
            return $this->error_notice->error('当前登陆账户为企业账户，不可购买个体险','1');
        }
        if($product_type == 2 && $user_type == 'user'){
            return $this->error_notice->error('当前登陆账户为个人账户，不可购买团体险','1');
        }
        $user_data = User::where('id',$_COOKIE['user_id'])
            ->select('phone')
            ->first();
        if($input['insurance_attributes']['ty_toubaoren']['ty_toubaoren_phone'] != $user_data['phone']){
            return $this->error_notice->error('投保人的手机号必须是当前登陆用户的手机号','1');
        }
        if($product_type == 2){
            if(!isset($input['b_file'])){
                return $this->error_notice->error('请按模板录入并上传被保人信息','1');
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
        }
        $identification = $input['identification'];
        $policy_phone = $input['insurance_attributes']['ty_toubaoren']['ty_toubaoren_phone'];
        $insurance_attributes = json_encode($input['insurance_attributes']);
        $data = $this->productRight($identification);
        //判断移动端
        $is_mobile = $this->is_phone;
        $prepare_order = [];
        $prepare_order['input'] = json_encode($input);
        $prepare_order['insurance_attributes'] = $insurance_attributes;
        $prepare_order['identification'] = $identification;
        if(!Redis::exists('prepare_order'.$identification)){
            Redis::set('prepare_order'.$identification,json_encode($prepare_order));
            Redis::expire('prepare_order'.$identification,3600);
        }
        if(isset($input['b_file'])){
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
        }else{
            if($is_mobile){
                return view('frontend.guests.mobile.confirm_form')
                    ->with('insurance_attributes',$insurance_attributes)
                    ->with('input',$input)
                    ->with('parameter',$data['parameter'])
                    ->with('product_res',$data['product_res'])
                    ->with('identification',$identification);
            }
//            Redis::set('key','value'); //存入redis
//            Redis::get('key'); //获取redis中的值
//            Redis::lLen('key'); //队列的长度
//            Redis::rpop('key'); //右侧出队列
//            Redis::rpush('key','value'); //右侧存入队列
//            Redis::exists($key) //redis是否存在这个键
            return view('frontend.guests.product.confirm_form')
                ->with('insurance_attributes',$insurance_attributes)
                ->with('input',$input)
                ->with('parameter',$data['parameter'])
                ->with('product_res',$data['product_res'])
                ->with('identification',$identification);
        }
    }
    /**
     * 投保信息确认页（团险）
     *
     */
    public function groupConfirmForm()
    {
        $input = $this->_request->all();
        //11.7陈延涛添加投保人与当前账户为同一人的实现开始
        $product_type = json_decode($input['json'],true)['type'];
        if(isset($_COOKIE['user_id'])) {
            $user_type = User::where('id', $_COOKIE['user_id'])->first()['type'];
            if ($product_type == 1 && $user_type == 'company') {
                return $this->error_notice->error('当前登陆账户为企业账户，不可购买个体险', '1');
            }
            if ($product_type == 2 && $user_type == 'user') {
                return $this->error_notice->error('当前登陆账户为个人账户，不可购买团体险', '1');
            }
            $user_data = User::where('id', $_COOKIE['user_id'])
                ->select('phone')
                ->first();
            if ($input['insurance_attributes']['ty_toubaoren']['ty_toubaoren_phone'] != $user_data['phone']) {
                return $this->error_notice->error('投保人的手机号必须是当前登陆用户的手机号', '1');
            }
            if ($product_type != 2) {
                return $this->error_notice->error('非团险产品', '1');
            }
        }
        $identification = $input['identification'];
        $insured_lists = $input['insurance_attributes']['ty_beibaoren'];
        $insurance_attributes = json_encode($input['insurance_attributes']);
        $data = $this->productRight($identification);
        $prepare_order = [];
        $prepare_order['input'] = json_encode($input);
        $prepare_order['insurance_attributes'] = $insurance_attributes;
        $prepare_order['identification'] = $identification;
        if(!Redis::exists('prepare_order'.$identification)){
            Redis::set('prepare_order'.$identification,json_encode($prepare_order));
            Redis::expire('prepare_order'.$identification,3600);
        }
        return view('frontend.guests.product.group_confirm_form')
            ->with('insurance_attributes',$insurance_attributes)
            ->with('input',$input)
            ->with('parameter',$data['parameter'])
            ->with('product_res',$data['product_res'])
            ->with('identification',$identification)
            ->with('insured_lists',$insured_lists);
    }
    /**
     * 右侧展示块
     * @param $identification
     * @return string
     * @throws \Exception
     */
    //通知告知页右侧栏信息
    public function productRight($identification){
        $prepare = OrderPrepareParameter::where('identification',$identification)
            ->first();
        $parameter = json_decode($prepare->parameter, true);
        $product_res = Product::where('ty_product_id',$prepare['ty_product_id'])->first();
        $data = [];
        $data['product_res'] = $product_res;
        $data['parameter'] = $parameter;
        return $data;
    }
    /**
     * 提交投保
     * @return string
     */
    public function insurePost()
    {
        $input = $this->_request->all();
        $type = DB::table('order_prepare_parameter')
            ->join('product','order_prepare_parameter.ty_product_id','product.ty_product_id')
            ->where('order_prepare_parameter.identification',$_COOKIE['identification'])
            ->select('product.insure_type')
            ->first();
        switch($type->insure_type){
            case 1:
                if($_COOKIE['login_type'] == 'company'){
                    setcookie('login_type','',time()-1);
                    setcookie('user_id','',time()-1);
                    setcookie('user_name','',time()-1);
                    setcookie('user_type','',time()-1);
                    Auth::logout();
                    return $this->error_notice->error('企业客户不可以购买个险',2);
                }
                break;
            case 2:
                if($_COOKIE['login_type'] == 'user'){
                    setcookie('login_type','',time()-1);
                    setcookie('user_id','',time()-1);
                    setcookie('user_name','',time()-1);
                    setcookie('user_type','',time()-1);
                    Auth::logout();
                    return $this->error_notice->error('个人客户不可以购买团险',2);
                }
                break;
        }

        if(empty($input)&&Redis::exists('prepare_order'.$_COOKIE['identification'])){
            $input = json_decode(Redis::get('prepare_order'.$_COOKIE['identification']),true);
        }
        $phone = json_decode($input['input'],true)['insurance_attributes']['ty_toubaoren']['ty_toubaoren_phone'];
        $old_phone = User::where('id',Auth::user()->id)->select('phone')->first();
        if($phone != $old_phone['phone']){
            return $this->error_notice->error('当前登陆账户与投保账户必须保持一致',3);
        }
        $insurance_attributes = json_decode($input['insurance_attributes'],true);
        $start_time = $insurance_attributes['ty_base']['ty_start_date']??'';
        $num = count($insurance_attributes['ty_beibaoren']);
        $prepare = OrderPrepareParameter::where('identification', $input['identification'])->first();
        if(!$prepare)
            return $this->error_notice->error('订单不存在或已被删除','1');
        if(!empty($prepare->union_order_code)){
            $order_res = Order::where('order_code',$prepare->union_order_code)->first();
            return $this->paySettlement($order_res['order_code'],json_decode($order_res['pay_way'],true));
        }
        $parameter = json_decode($prepare->parameter, true);
        $data['price'] = $parameter['price'] * $num;
        $data['private_p_code'] = $prepare['private_p_code'];
        if($prepare['private_p_code']=='UXgtMTEyMkEwMUcwMQ'){
            return $this->error_notice->error('待审产品，不能投保','1');
        }
        $data['insurance_attributes'] = json_decode($input['insurance_attributes'],true);
        $data['quote_selected'] = $parameter['selected'];

//        $data['insurance_attributes']['ty_toubaoren']['ty_toubaoren_area'] =  "110000,110100,110101";
        //健康告知id
        $data['healthId'] = $parameter['healthId'] ?? '';
//        $policy_res = $data['insurance_attributes']['ty_toubaoren'];
//        $user_res = User::where('phone',$policy_res['ty_toubaoren_phone'])->select('phone')->first();
        $data = $this->_signHelp->tySign($data);
        //发送请求
        $response = Curl::to(env('TY_API_SERVICE_URL') . '/ins_curl/buy_ins')
            ->returnResponseObject()
            ->withData($data)
            ->withTimeout(600)
            ->post();
//        print_r($response);die;
        if($response->status != 200){
            $response->content = preg_replace("/\]/",'',preg_replace("/\[/", '', $response->content));
            return $this->error_notice->error($response->content,'/ins/insure/'.$_COOKIE['identification']);
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
    //返回移动端被保人模板
    public function groupModel($ins)
    {
        return view('frontend.show_ins.group_ins_beibaoren',compact('ins'))->render();
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
        if($this->is_phone){
            return view('frontend.guests.mobile.payment')
//                ->with('banks',$banks)
//                ->with('bank',$bank_res)
//                ->with('user_bank',$user_banks)
                ->with('order',$order)
                ->with('company',$company)
                ->with('clause',$clause)
                ->with('product',$product)
                ->with('warranty',$warranty)
                ->with('parameter',$parameter)
                ->with('private_p_code',$warranty->private_p_code)
                ->with('union_order_code',$union_order_code)
//                ->with('pay_way',$pay_way);
                ->with('pay_way', $pay_way['mobile']);
        }
        return view('frontend.guests.product.payment')
//            ->with('banks',$banks)
//            ->with('bank',$bank_res)
//            ->with('user_bank',$user_banks)
            ->with('order',$order)
            ->with('company',$company)
            ->with('clause',$clause)
            ->with('product',$product)
            ->with('warranty',$warranty)
            ->with('parameter',$parameter)
            ->with('private_p_code',$warranty->private_p_code)
            ->with('union_order_code',$union_order_code)
//            ->with('pay_way',$pay_way);
            ->with('pay_way', $pay_way['pc']);

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
        //todo
//        print_r($response->content);die;
        $status = $response->status;
        if($status== '200'){
            $content = json_decode($response->content,true);
            return (['status'=>'200','content'=>$content]);
        }else{
            return (['status'=>'500','content'=>$response->content]);
        }
    }
    //支付回调
    public function callBack()
    {
        $input = $this->_request->all();
        $notice_type = $input['notice_type'];
        switch($notice_type){
            case 'check_call_back':
                $order = Order::where('order_code', $input['data']['union_order_code'])->first();
                if($input['data']['status']){
                    LogHelper::logSuccess($input, 'ty', 'check_call_back');
                    $order->status = 3;
                    $order->save();
                    WarrantyRecognizee::where('order_id', $order->id)->update(['status'=>2]);
                } else {
                    LogHelper::logError($input, $input['data']['error_message'], 'ty', 'check_call_back');
                    $order->status = 6;
                    $order->pay_error_message = $input['data']['error_message'];
                    $order->save();
                    WarrantyRecognizee::where('order_id', $order->id)->update(['status'=>6]);
                }
                break;
            case 'pay_call_back':   //支付回调通知
                $order = Order::where('order_code', $input['data']['union_order_code'])->first();
                if($input['data']['status']){
                    LogHelper::logSuccess($input, 'ty', 'pay_call_back');
                    $order->status = config('attribute_status.order.payed');
                    $order->by_stages_way = $input['data']['by_stages_way'];
                    $order->pay_time = date('Y-m-d H:i:s');
                    $order->save();
                    WarrantyRecognizee::where('order_id', $order->id)->update(['status'=>1]);
                    //录入公司佣金
                    $brokerage = new CompanyBrokerage();
                    $brokerage->order_id = $order->id;
                    $brokerage->ty_product_id = $order->ty_product_id;
                    $brokerage->brokerage = $input['data']['brokerage_for_agency'];
                    $brokerage->status = config('attribute_status.company_brokerage.clear_wait');
                    $brokerage->save();
                    //录入代理人佣金
                    if($order->warranty_rule->agent_id){
                        $m = MarketDitchRelation::where([
                            'ty_product_id'=> $order->ty_product_id,
                            'agent_id'=>$order->warranty_rule->agent_id,
                            'by_stages_way'=> $input['data']['by_stages_way'],
                            'status'=>'on'
                        ])->first();
                        $order_brokerage = new OrderBrokerage();
                        $order_brokerage->order_id = $order->id;
                        $order_brokerage->order_pay = $order->premium;
                        $order_brokerage->ty_product_id = $m->ty_product_id;
                        $order_brokerage->rate_relation_id = $m->id;
                        $order_brokerage->by_stages_way = $m->by_stages_way;
                        $order_brokerage->rate = $m->rate;
                        $order_brokerage->user_earnings = $order->premium * $m->rate / 100;
                        $order_brokerage->agent_id = $m->agent_id;
                        $order_brokerage->ditch_id = $m->ditch_id;
                        $order_brokerage->save();
                    }
                    return 1;
                }else{
                    LogHelper::logError($input, $input['data']['error_message'], 'ty', 'pay_call_back');
                    $order->status = 3;
                    $order->pay_error_message = $input['data']['error_message'];
                    $order->save();
                    WarrantyRecognizee::where('order_id', $order->id)->update(['status'=>3]);
                }
                break;
            case 'reject_call_back':
                break;
        }

    }
    /**
     * pc端添加团险单
     */
    public function addGroupOrder($order_code,$return_data,$nb_file,$start_time,$ty_product_id)
    {
        try{
            DB::beginTransaction();
            //订单插入
            $order = new Order();
            $order->order_code = $order_code['order_no'];
            $order->user_id = Auth::user()->id;
            $order->is_settlement = 1;
            $order->ty_product_id = $ty_product_id;
            $order->pay_time = date('Y-m-d H:i:s',time());
            $order->deal_type = 0;
            $order->start_time = $start_time;
            $order->premium = $order_code['total_premium'];
            $order->status = $order_code['policy_status'];
            $order->save();
            //            投保人
            $warrantyPolicy = new WarrantyPolicy();
            $warrantyPolicy->name = $return_data['ty_toubaoren_name'];
            $warrantyPolicy->card_type = $return_data['ty_toubaoren_id_type'];
            $warrantyPolicy->occupation = 0;    //投保人职业？？
            $warrantyPolicy->code =$return_data['ty_toubaoren_id_number'] ;
            $warrantyPolicy->phone = $return_data['ty_toubaoren_phone'] ;
            $warrantyPolicy->email = $return_data['ty_toubaoren_email'];
            $warrantyPolicy->status = 0;
            $warrantyPolicy->save();
            //            被保人
            //            dd($nb_file);
            foreach($nb_file as $k=>$v){
                if($k >= 2){
                    $BwarrantyPolicy = new WarrantyRecognizee();
                    $BwarrantyPolicy->name = $v['name'];
                    $BwarrantyPolicy->order_id = $order->id;
                    $BwarrantyPolicy->card_type = $v['id_type'];
                    $BwarrantyPolicy->occupation = $v['occupation'];    //投保人职业？？
                    $BwarrantyPolicy->code = $v['id_code'];
                    $BwarrantyPolicy->phone = $v['phone'];
                    $BwarrantyPolicy->status = 0;
                    $BwarrantyPolicy->save();
                }
            }
            DB::commit();

        }catch (\Exception $e) {
            DB::rollBack();
            $msg = ['data' => $e->getMessage(), 'code' => 444];
            return $msg;
        }
    }
    //移动端添加团险信息
    public function addGroupForm($order_code,$return_data,$nb_file,$start_time,$ty_product_id)
    {
        try{
            DB::beginTransaction();
            //订单插入
            $order = new Order();
            $order->order_code = $order_code['order_no'];
            $order->user_id = Auth::user()->id;
            $order->is_settlement = 1;
            $order->ty_product_id = $ty_product_id;
            $order->pay_time = date('Y-m-d H:i:s',time());
            $order->deal_type = 0;
            $order->start_time = $start_time;
            $order->premium = $order_code['total_premium'];
            $order->status = $order_code['policy_status'];
            $order->save();
//            投保人
            $warrantyPolicy = new WarrantyPolicy();
            $warrantyPolicy->name = $return_data['ty_toubaoren_name'];
            $warrantyPolicy->card_type = $return_data['ty_toubaoren_id_type'];
            $warrantyPolicy->occupation = 0;    //投保人职业？？
            $warrantyPolicy->code =$return_data['ty_toubaoren_id_number'] ;
            $warrantyPolicy->phone = $return_data['ty_toubaoren_phone'] ;
            $warrantyPolicy->email = $return_data['ty_toubaoren_email'];
            $warrantyPolicy->status = 0;
            $warrantyPolicy->save();
//            被保人
            foreach($nb_file as $k=>$v){
                $BwarrantyPolicy = new WarrantyRecognizee();
                $BwarrantyPolicy->name = $v['ty_beibaoren_name'];
                $BwarrantyPolicy->order_id = $order->id;
                $BwarrantyPolicy->card_type = $v['ty_beibaoren_id_type'];
                $BwarrantyPolicy->occupation = $v['ty_beibaoren_occupation'];    //投保人职业？？
                $BwarrantyPolicy->code = $v['ty_beibaoren_id_number'];
                $BwarrantyPolicy->phone = $v['ty_beibaoren_phone'];
                $BwarrantyPolicy->status = 0;
                $BwarrantyPolicy->save();
            }
            DB::commit();
//            dd(1);
            return 1;
        }catch (\Exception $e) {
            DB::rollBack();
            $msg = ['data' => $e->getMessage(), 'code' => 444];
            return $msg;
        }
    }
    /**
     * 同步产品来源接口信息
     * @param $data
     * @return ApiInfo
     */
    protected function insApiInfo($data)
    {
//                dd($data);
        $model = new ApiInfo();
        $api_info = $model->where([
            'ty_product_id'=> $data['ty_product_id'],
            'bind_id'=> $data['bind_id']
        ])->first();

        //补充团险模版
        $data['option']['template_url'] = $data['template_url'] ?? '/download/group_excel/insureds.xlsx';
//        dd($data);
        $json = json_encode($data['option']);
        $sign = md5($data['private_p_code'] . $json);
        //record
        if($api_info){
            if($api_info->sign == $sign)
                return $api_info;
            $model = $api_info;
        }
        //save and return record
        $model->private_p_code = $data['private_p_code'];
        $model->ty_product_id = $data['ty_product_id'];
        $model->bind_id = $data['bind_id'];
        $model->json = $json;
        $model->sign = $sign;
        $model->save();
        return $model;
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
                //给被保人开户
                $exit_data = User::where('code',$recognizee_value['card_id'])->first();
                if(isset($recognizee_value['phone']) && !isset($exit_data)){
                    $user = new User();
                    $user->name = isset($recognizee_value['name'])?$recognizee_value['name']:' ';
                    $user->email = isset($recognizee_value['email'])?$recognizee_value['email']:' ';
                    $user->phone = isset($recognizee_value['phone'])?$recognizee_value['phone']:' ';
                    $user->code = isset($recognizee_value['card_id'])?$recognizee_value['card_id']:' ';
                    $user->occupation = isset($recognizee_value['occupation'])?$recognizee_value['occupation']:' ';
                    $user->type = 'user';
                    $user->password = bcrypt('123456');
                    $user->save();
                }
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

    public function checkCompetition($private_p_code)
    {
        $time = date('Y-m-d',time());
        $competition = Competition::where([
            ['private_p_code',$private_p_code],
            ['start_time','<=',$time],
            ['end_time','>=',$time],
        ])->orwhere([
            ['product_id',0],
            ['start_time','<=',$time],
            ['end_time','>=',$time],
        ])->first();
        return $competition;
    }

    protected function optionHtml($restrict_genes, $selected_options, $price)
    {
//        $is_mobile = $this->is_mobile();
        if($this->is_phone){
            return view('frontend.show_ins.mobile_options', compact('restrict_genes', 'selected_options', 'price'))->render();
        }
        return view('frontend.show_ins.options', compact('restrict_genes', 'selected_options', 'price'))->render();
    }

    protected function itemHtml($protect_items)
    {
        if($this->is_phone){
            return view('frontend.show_ins.mobile_items',compact('protect_items'))->render();
        }
        return view('frontend.show_ins.items', compact('protect_items'))->render();
    }

    //判断是否是团险产品
    protected function is_groupIns($id) //传入ty_product_id
    {
        $res = Product::where('ty_product_id',$id)->value('insure_type');
        return $res;
    }

    public function doPaySettlement()
    {
        $input = $this->_request->all();
        $check = empty($input['bank_uuid']) || empty($input['bank_code']) || empty($input['bank_number']);
        if ($check) {
            return $this->error_notice->error( '银行卡信息有误','1');
//            return '<script>alert("银行卡信息有误");history.go(-1);</script>';
        }
        $order = Order::where('order_code', $input['union_order_code'])
            ->where('private_P_code', $input['private_p_code'])
            ->whereNotIn('status', [1,6,7])
            ->first();
        if(empty($order))
            return $this->error_notice->error( '订单不存在或为非可支付状态','1');
//            return '<script>alert("订单不存在或为非可支付状态");history.go(-1);</script>';
        $data['bank_uuid'] = $input['bank_uuid'];
        $data['bank_code'] = $input['bank_code'];
        $data['bank_number'] = $input['bank_number'];
        $premium = $order->premium;
        $data['private_p_code'] = $input['private_p_code'];
        $data['unionOrderCode'] = $input['union_order_code'];
        $data['premium'] = $input['premium'];
        //        dd(get_defined_vars());
        $data = $this->_signHelp->tySign($data);
        $response = Curl::to(env('TY_API_SERVICE_URL') . '/ins_curl/pay_ins')
            ->returnResponseObject()
            ->withData($data)
            ->withTimeout(600)
            ->post();
        //print_r($response);exit;
        $status = $response->status;
        if($status== '200'){
            //TODO  添加了支付账户保存  2017-12-12 王石磊
            $pay_account = [];
            $pay_account['bank_uuid'] = $input['bank_uuid'];
            $pay_account['bank_code'] = $input['bank_code'];
            $pay_account['bank_number'] = $input['bank_number'];
            $pay_account['premium'] = $input['premium'];
            Order::where('order_code', $input['union_order_code'])->update([
                'pay_account'=>json_encode($pay_account),
            ]);
            $content = json_decode($response->content,true);

            return "<script>location.href='/product/order_pay_success'</script>";
        } elseif ($status == '444') {
            return $this->error_notice->error( '订单支付失败，请确认信息无误','1');
//            return "<script>alert('订单支付失败，请确认信息无误');history.back(-1);</script>";
        }
        else{
            return $this->error_notice->error( $response->content,'1');
//            return "<script>alert('{$response->content}');history.back(-1);</script>";
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

    public  function insureClause($identification){
        $data = $this->productRight($identification);
        return view('frontend.guests.product.insure_clauses')->with('data',$data);
    }

    //未支付订单去支付
    public function payAgain($code)
    {
        $data = Order::where('order_code',$code)->first();
        switch($data['status']){
            case 1:
                return $this->error_notice->error( '该订单已经完成支付','1');
//                return "<script>alert('该订单已经完成支付');history.back();</script>";
            case 2:
                if(strtotime($data['created_at'])+3600 < time()){
                    return $this->error_notice->error( '该订单已经超时一小时，不可支付','1');
//                    return "<script>alert('该订单已经超时一小时，不可支付');history.back();</script>";
                }
                return $this->paySettlement($code,json_decode($data['pay_way'],true));
            case 3:
                return $this->error_notice->error( '该订单支付失败，请重新下单','1');
//                return "<script>alert('该订单支付失败，请重新下单');history.back();</script>";
            case 4:
                if(strtotime($data['created_at'])+3600 < time()){
                    return $this->error_notice->error( '该订单已经超时一小时，不可支付','1');
//                    return "<script>alert('该订单已经超时一小时，不可支付');history.back();</script>";
                }
                return $this->paySettlement($code,json_decode($data['pay_way'],true));
            case 6:
                return $this->error_notice->error( '该订单核保失败，不可支付','1');
//                return "<script>alert('该订单核保失败，无法支付');history.back();</script>";
            case 7:
                return $this->error_notice->error( '该订单已取消支付','1');
//                return "<script>alert('该订单已取消支付');history.back();</script>";
        }
    }

    //计算佣金比
//    public function getMyAgentBrokerage($product_id, $ditch_id, $agent_id)
//    {
//        $condition = array(
//            'type'=>'agent',
//            'product_id'=>$product_id,
//            'ditch_id'=>$ditch_id,
//            'agent_id'=>$agent_id,
//        );
//        $brokerage = MarketDitchRelation::where($condition)
//            ->first();
//        if(!$brokerage){
//            //进行渠道统一查询
//            $condition = array(
//                'product_id'=>$product_id,
//                'ditch_id'=>$ditch_id,
//                'agent_id'=>0,
//            );
//            $brokerage = MarketDitchRelation::where($condition)
//                ->first();
//            if(!$brokerage){//产品统一查询
//                $condition = array(
//                    'type'=>'product',
//                    'product_id'=>$product_id,
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
//        $scaling = Scaling::where($condition)
//            ->first();
//        if(!$scaling){
//            //进行渠道统一查询
//            $condition = array(
//                'product_id'=>$product_id,
//                'ditch_id'=>$ditch_id,
//                'agent_id'=>0,
//            );
//            $scaling = Scaling::where($condition)
//                ->first();
//            if(!$scaling){//产品统一查询
//                $condition = array(
//                    'type'=>'product',
//                    'product_id'=>$product_id,
//                );
//                $scaling = Scaling::where($condition)
//                    ->first();
//            }
//        }
//        if($scaling){
//            $scaling = $scaling->rate;
//        }else{
//            $scaling = 0;
//        }
//        return array(
//            'earning'=>$earning,  //佣金比
//            'scaling'=>$scaling   //折标系数
//        );
//    }

    //封装一个方法，用来获取自己的所有渠道
//    public function getMyDitch($agent_id)
//    {
//        //获取代理人的所有的渠道
//        $ditch = Agent::where('id',$agent_id)
//            ->with('ditches')
//            ->first();
//        return $ditch;
//    }
}
