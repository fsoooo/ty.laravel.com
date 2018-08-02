<?php

namespace App\Http\Controllers\ApiControllers;

use Cache, DB;
use Illuminate\Http\Request;
use App\Helper\RsaSignHelp;
use App\Helper\LogHelper;
use Ixudra\Curl\Facades\Curl;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderParameter;
use App\Models\Competition;
use App\Models\WarrantyRule;
use App\Models\WarrantyPolicy;
use App\Models\WarrantyRecognizee;
use App\Models\OrderPrepareParameter;
use App\Http\Controllers\ApiControllers\BaseController as Base;

class InsController extends Base
{
    protected $request;
    protected $signHelp;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->signHelp = new RsaSignHelp();
    }

    public function insInfo()
    {
        //todo
        $ins = $this->cacheIns();
//        dd($ins['restrictGenes']);  //试算因子
        dd($ins['attr']);   //投保属性
    }

    //获取产品信息缓存
    protected function cacheIns()
    {
        $private_p_code = $this->request->private_p_code;
        $p_arr = explode('-', $private_p_code);
        $api_from_uuid = $p_arr[0];
        $cache_name = env('TY_API_ID') . 'ins_info_' . $private_p_code;

        if(!\Cache::has($cache_name)) {
            $biz_content = [
                'private_p_code' => $private_p_code,    //投保产品ID
            ];
            //天眼接口参数封装
            $data = $this->signHelp->tySign($biz_content, ['api_from_uuid'=> $api_from_uuid, 'private_p_code'=> $private_p_code]);
            //发送请求
            $response = Curl::to(env('TY_API_SERVICE_URL') . '/insurance/ins_info')
                ->returnResponseObject()
                ->withData($data)
                ->withTimeout(60)
                ->post();
//            print_r($response);exit;
            if($response->status !== 200)
                throw new \Exception('get info error');

//            dd($response);
            $data = json_decode($response->content, true);
            $data['api_from_uuid'] = $api_from_uuid;
            \Cache::put($cache_name, serialize($data), 43200);
        }
        $res = unserialize(\Cache::get($cache_name));
        return $res;

    }

    /**
     * 展示产品 及其选项
     * @return mixed
     * @throws \Exception
     */
    public function showIns()
    {
        $ins = $this->cacheIns();
        $private_p_code = $this->request->get('private_p_code');
        $option_html = $this->optionHtml($ins['restrictGenes'], $ins['default_quote']['priceArgs'], $ins['price']);
        return view('frontend.ins.ins_info', compact('ins', 'option_html', 'private_p_code'));
    }

    /**
     * 算费
     * @return mixed
     */
    public function quote()
    {
        $biz_content = $this->request->all();
        $api_from_uuid = $biz_content['api_from_uuid'];
        unset($biz_content['api_from_uuid']);

        //天眼接口参数封装
        $data = $this->signHelp->tySign($biz_content, ['api_from_uuid'=> $api_from_uuid]);

        //发送请求
        $response = Curl::to(env('TY_API_SERVICE_URL') . '/insurance/quote')
            ->returnResponseObject()
            ->withData($data)
            ->asJson(true)
            ->withTimeout(60)
            ->post();

        if($response->status !== 200)
            return response($response->content, $response->status);

        $data = $response->content['data'];

        //如果返回值中存在 其他受影响参数的选项 就覆盖原来选项
        $old_option = json_decode($this->request->get('old_option'), true);
        if(!empty($data['restrictGenes'])){
            foreach($data['restrictGenes'] as $return_k => $return_v){
                foreach($old_option as $k => $v){
                    if($return_v['name'] == $v['name']){
                        $old_option[$k] = $return_v;
                    }
                }
            }
        }
        //生成HTML
        $option_html = $this->optionHtml($old_option, $data['priceArgs'], $data['price']);
        return response($option_html, 200);
    }

    /**
     * data to html
     * @param $option
     * @param $priceArgs
     * @param $price
     * @return mixed
     */
    protected function optionHtml($option, $priceArgs, $price)
    {
        return view('frontend.ins.options', compact('option','priceArgs', 'price'))->render();
    }

    /**
     * 预购订单
     */
    public function prepareOrder()
    {
        //todo
        $input = $this->request->all();

        $agent_id = $input['agent_id'];
        $ditch_id = $input['ditch_id'];

        $date = date('Ymd',time());

        $product = Product::where('private_p_code', $input['private_p_code'])->where('ty_product_id','>=',0)->first();
//        dd($product);
        $random = rand(0,9999999);
        $random_number = substr('0000000'.$random,-7);
        $identification = ($date.$random_number);
        unset($input['_token']);
        $parameter = json_encode($input);
        $order_prepare_parameter = new OrderPrepareParameter();
        $order_prepare_parameter->agent_id = $agent_id;
        $order_prepare_parameter->ditch_id = $ditch_id;
        $order_prepare_parameter->identification = $identification;
        $order_prepare_parameter->parameter = $parameter;
        $order_prepare_parameter->product_id = $product->id;    //todo  remove
        $order_prepare_parameter->private_p_code = $input['private_p_code'];

        if($order_prepare_parameter->save()){
            //预存成功,跳转到完善信息页面
            setcookie('identification',$identification,time()+3600,'/');

            return view('frontend.guests.product.covernotes')
                ->with('identification',$identification);
        }else{
            return back()->withErrors('出错了，请重新尝试');
        }
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
        $prepare = OrderPrepareParameter::where('identification', $identification)
            ->first();

        if(!$prepare)
            return "<script>alert('订单不存在或已被删除'); window.history.go(-1);</script>";

        $this->request->private_p_code = $prepare->private_p_code;

        $ins = $this->cacheIns();
        $product = Product::where('private_p_code', $prepare->private_p_code)->where('ty_product_id','>=',0)->first()->toArray();
        $json = json_decode($product['json'], true);
        return view('frontend.ins.to_order', compact('ins', 'json', 'product', 'identification'));
    }

    /**
     * 提交投保
     * @return string
     */
    public function insurePost()
    {
        $biz_content = $this->request->all();
//        dd($biz_content);
        $prepare = OrderPrepareParameter::where('identification', $biz_content['identification'])->first();
        if(!$prepare)
            return "<script>alert('订单不存在或已被删除'); window.history.go(-1);</script>";

        $parameter = json_decode($prepare->parameter, true);
//        dd($parameter);
//        $biz_content['price'] = $parameter['price'];
//        $biz_content['private_p_code'] = $prepare['private_p_code'];
//        $api_from_uuid = $biz_content['api_from_uuid'];
//        unset($biz_content['api_from_uuid']);
//        unset($biz_content['_token']);
//        unset($biz_content['identification']);
//        dd($biz_content);
        $data['private_p_code'] = $prepare['private_p_code'];
        $data['insurance_attributes'] = $biz_content['insurance_attributes'];
        //天眼接口参数封装
        $data = $this->signHelp->tySign($data);

        //发送请求
        $response = Curl::to(env('TY_API_SERVICE_URL') . '/insurance/buy_ins')
            ->returnResponseObject()
            ->withData($data)
            ->withTimeout(60)
            ->post();

        if($response->status !== 200)
            return "<script>alert('". $response->content ."'); window.history.go(-1);</script>";

        //订单信息录入
        $return_data = json_decode($response->content, true);
        $add_res = $this->addOrder($return_data, $prepare);
        if($add_res)
            return redirect('/insurance/pay_settlement/'.$return_data['order']['order_no']);

        return "<script>alert('下单失败，重新尝试');window.history.go(-1);</script>";
    }

    //跳转到支付页面
    public function paySettlement($order_code){
        $order = Order::where('order_code', $order_code)->first();
        if($order->status != 2)
            return "<script>alert('该状态下订单无法支付，即将前往订单列表查看！');window.location.href='/order/index/all';</script>";
        $product = $order->pro;
        $json =  json_decode($product->json, true);
        $company = $json['company'];
        return view('frontend.ins.settlement',compact('product', 'order', 'company', 'warranty'));
    }

    //提交支付
    public function orderPaySettlement()
    {
//        dd($this->request->all());
        $order_code = $this->request->order_code;
        $order = Order::where('order_code', $order_code)->first();
        if(empty($order))
            return response(['data'=>'没有此支付订单', 'status'=> 'error'], 200);

        $p_code_arr = explode('-', $order->private_p_code);
        $data['pay_type'] = $this->request->pay_type;
        $data['order_no'] = $order->order_code;
        //天眼接口参数封装
        $data = $this->signHelp->tySign($data, ['api_from_uuid'=> $p_code_arr[0]]);

        //发送请求
        $response = Curl::to(env('TY_API_SERVICE_URL') . '/insurance/pay_ins')
            ->returnResponseObject()
            ->withData($data)
            ->withTimeout(60)
            ->post();
//        dd($response);
        if($response->status !== 200)
            return response(['data'=>$response->content, 'status'=> 'error'], 200);

        //todo finish
        return response(['data'=>$response->content, 'status'=> 'true'], 200);
    }


    public function orderStatus()
    {
        $order_code = $this->request->order_code;
//        dd($order_code);
        $order = Order::where('order_code', $order_code)->first();
        if(empty($order))
            return response(['data'=>'没有此订单', 'status'=> 'error'], 200);

        switch($order->status){
            case 1: //已支付
                return response(['status'=>'pay_end','message'=> '支付成功'], 200);
                break;
            case 2: //未支付
                $return = $this->tyOrderStatus($order);
                switch($return['status']){
                    case 'pay_ing':
                        return response(['status'=>'pay_ing','message'=> '支付中'], 200);
                        break;
                    case 'pay_end':
                        $order->status = 1;
                        $order->save();
                        return response(['status'=>'pay_end','message'=> '支付成功'], 200);
                        break;
                    default:
                        return response(['status'=>'pay_error','message'=> $return['message']], 200);
                }

                break;
            case 3: //支付失败
                return response(['status'=>'pay_error','message'=> '支付失败'], 200);
                break;
        }
    }

    protected function tyOrderStatus($order)
    {
        $p_code_arr = explode('-', $order->private_p_code);
        $data['order_no'] = $order->order_code;
        //天眼接口参数封装
        $data = $this->signHelp->tySign($data, ['api_from_uuid'=> $p_code_arr[0]]);

        //发送请求
        $response = Curl::to(env('TY_API_SERVICE_URL') . '/insurance/order_status')
            ->returnResponseObject()
            ->withData($data)
            ->withTimeout(60)
            ->post();
        if($response->status !== 200)
            return['data'=>$response->content, 'status'=> 'error'];

        $data = json_decode($response->content, true);
        return $data;

    }




    protected function addOrder($return_data, $prepare)
    {
        try{
            //查询是否在竞赛方案中
            $private_p_code = $prepare->private_p_code;
            $competition = $this->checkCompetition($private_p_code);
            if($competition){
                $competition_id = $competition->id;
                $is_settlement = 0;
            }else{
                $is_settlement = 1;
                $competition_id = 0;
            }
            $ditch_id = $prepare->ditch_id;
            $agent_id = $prepare->agent_id;

            //订单信息录入
            $order = new Order();
            $order->order_code = $return_data['order']['order_no']; //订单编号
            $order->user_id = \Auth::user()->id;//用户id
            $order->agent_id = $agent_id;
            $order->competition_id = $competition_id;//竞赛方案id，没有则为0
            $order->private_p_code = $private_p_code;
            $order->start_time = $return_data['insures'][0]['ins_start_time'];
            $order->claim_type = 'online';
            $order->deal_type = 0;
            $order->is_settlement = $is_settlement;
            $order->premium = $return_data['order']['total_premium'];
            $order->status = config('attribute_status.order.unpayed');
            $order->save();

            //投保人信息录入
            $warrantyPolicy = new WarrantyPolicy();
            $warrantyPolicy->name = $return_data['policy']['name'];
            $warrantyPolicy->card_type = $return_data['policy']['card_type'];
            $warrantyPolicy->occupation = 0;    //投保人职业？？
            $warrantyPolicy->code = $return_data['policy']['card_id'];
            $warrantyPolicy->phone = $return_data['policy']['phone'];
            $warrantyPolicy->email = $return_data['policy']['email'];
            $warrantyPolicy->status = 0;
            $warrantyPolicy->save();

            //被保人信息录入
            $warrantyRecognizee = new WarrantyRecognizee();
            $add_recognizee_array = array();
            foreach($return_data['insures'] as $k => $value)
            {
                $add_recognizee_array[$k]['order_id'] = $order->id;
                $add_recognizee_array[$k]['occupation'] = 1;
                $add_recognizee_array[$k]['name'] = $value['name'];
                $add_recognizee_array[$k]['relation'] = $value['relation'];
                $add_recognizee_array[$k]['card_type'] = $value['card_type'];
                $add_recognizee_array[$k]['code'] = $value['card_id'];
                $add_recognizee_array[$k]['phone'] = isset($value['phone']) ? $value['phone'] : '';
                $add_recognizee_array[$k]['order_code'] = $value['out_order_no'];
                $add_recognizee_array[$k]['created_at'] = $add_recognizee_array[$k]['updated_at'] = date('Y-m-d H:i:s');
            }
            $warrantyRecognizee::insert($add_recognizee_array);

            //添加投保参数到参数表
            $orderParameter = new OrderParameter();
            $orderParameter->parameter = $prepare->parameter;
            $orderParameter->order_id = $order->id;
            $orderParameter->private_p_code = $private_p_code;
            $orderParameter->save();

            //添加到关联表记录
            $WarrantyRule = new WarrantyRule();
            $WarrantyRule->agent_id = $agent_id;
            $WarrantyRule->ditch_id = $ditch_id;
            $WarrantyRule->order_id = $order->id;
            $WarrantyRule->union_order_code = $return_data['order']['union_order_code'];//总订单号
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

    //封装一个方法，用来判断是否是竞赛方案中
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

}