<?php
/**
 * Created by PhpStorm.
 * User: cyt
 * Date: 2017/11/29
 * Time: 10:56
 */
namespace App\Http\Controllers\ApiControllers;
use App\Helper\IsPhone;
use App\Helper\LogHelper;
use App\Helper\RsaSignHelp;
use App\Models\ApiInfo;
use App\Models\PlanLists;
use App\Models\Product;
use Illuminate\Http\Request;
use Ixudra\Curl\Facades\Curl;
use App\Models\OrderPrepareParameter;

class GroupInsApiController{
    protected $_request;
    protected $_signHelp;
    protected $is_phone;

    public function __construct(Request $request)
    {
        $this->_request = $request;
        $this->_signHelp = new RsaSignHelp();
        $this->is_phone = isset($_SERVER['HTTP_USER_AGENT']) ? IsPhone::isPhone() : null;
    }

    //获取产品详情
    public function insInfo($id)
    {
        $input = $this->_request->all();
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
        if($response->status != 200){
            LogHelper::logError($biz_content, $response->content, 'ty', 'ins_api_info');
            return "<script>alert('获取产品详情失败');location.href='/';</script>";
        }
        $return_data = json_decode($response->content, true);
        $ins = $this->insApiInfo($return_data);
        $restrict_genes = $return_data['option']['restrict_genes'];     //算费因子
        $selected_options = $return_data['option']['selected_options']; //默认算费选中项
        $protect_items = isset($return_data['option']['protect_items']) ? $return_data['option']['protect_items'] : ''; //保障内容
        $price = (int)$return_data['option']['price']; //默认费率
        if(!$ins)
            return "<script>alert('获取产品详情失败！');location.href='/'</script>";
        $product_info = Product::where('ty_product_id',$id)->with('label.labels')->first();//产品详情
        $company = json_decode($product_info->json,true)['company'];
        $min_math = json_decode($product_info->json,true)['min_math'];
        $max_math = json_decode($product_info->json,true)['max_math'];

        $clauses = json_decode($product_info->clauses,true);

        $duty = [];
        foreach ($clauses as $value){
            if(isset($value['duties'])){
                $duty[] = $value['duties'];
            }
        }
        $option_html = $this->optionHtml($restrict_genes, $selected_options, $price);
        $protects = [];
        $item_html = $protect_items ? $this->itemHtml($protect_items) : '';
        $object = Product::where('ty_product_id', $id)->first();
        $product_claes = json_decode($object['json'],true)['content'];
        $json = $object->json;
        $json = json_decode($json, true);
        if(!is_null($object['cover'])){
            $json['cover']= $object['cover'];
        }
        if(isset($input['agent_id']) && isset($input['ditch_id']) && isset($input['plan_id']))
            PlanLists::where(['id'=> $input['plan_id'], 'status'=> 1])->update(['status'=> 2, 'read_time'=> date("Y-m-d H:i:s")]);
        return view('frontend.guests.groupIns.detail',compact('duty','company','json','clauses','product_info','option_html','item_html','ins_type','id','ins','product_claes','min_math','max_math'));
    }

    //团险算费
    public function quote()
    {
        $biz_content = $this->_request->all();
        //天眼接口参数封装
        $data = $this->_signHelp->tySign($biz_content);
        //发送请求
        $response = Curl::to(env('TY_API_SERVICE_URL') . '/ins_curl/quote')
            ->returnResponseObject()
            ->withData($data)
            ->withTimeout(60)
            ->post();
//        print_r($response->content);exit;
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

    protected function optionHtml($restrict_genes, $selected_options, $price)
    {
        if($this->is_phone){
            return view('frontend.show_ins.mobile_options', compact('restrict_genes', 'selected_options', 'price'))->render();
        }
        return view('frontend.show_ins.group_ins_option', compact('restrict_genes', 'selected_options', 'price'))->render();
    }

    protected function itemHtml($protect_items)
    {
        return view('frontend.show_ins.items', compact('protect_items'))->render();
    }

    public function prepareOrder()
    {
        $input = $this->_request->all();
        $ty_product_id = $input['ty_product_id'];
        if($ty_product_id == 29){
            return "<script>alert('报备产品，不可投保');history.back();</script>";
        }
        $product_type = Product::where('ty_product_id',$ty_product_id)->pluck('insure_type')[0];
        $res = $this->getProductType($ty_product_id);
        $agent_id = $input['agent_id'];
        $ditch_id = $input['ditch_id'];
        $plan_id = $input['plan_id'];
        $api_info =ApiInfo::where('private_p_code', $input['private_p_code'])->first();
        $product_res = Product::where('ty_product_id',$ty_product_id)->first();//投保须知
        $product_claes = json_decode($product_res['json'],true)['content'];
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

            $data = $this->productRight($identification);
            return view('frontend.guests.groupIns.cover_notes')
                ->with('res',$res)
                ->with('parameter',$data['parameter'])
                ->with('product_claes',$product_claes)
                ->with('product_res',$data['product_res'])
                ->with('identification',$identification);
        }else{
            return back()->withErrors('出错了，请重新尝试');
        }
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

        $user_true = empty($user_true) ? [] : $user_true;

        return view('frontend.guests.groupIns.group_ins')
            ->with('ins',$ins)
            ->with('json',$json)
            ->with('product',$product)
            ->with('parameter',$data['parameter'])
            ->with('product_res',$data['product_res'])
            ->with('user_true',$user_true)
            ->with('identification',$identification);
    }

    /*
     * 被保人页面
     * @param $identification
     * */
    public function nextInsure(){
        dd(123);

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



}

