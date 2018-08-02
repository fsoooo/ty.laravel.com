<?php

namespace App\Http\Controllers\FrontendControllers\AgentControllers;
use App\Http\Controllers\FrontendControllers\BaseController;
use App\Models\WarrantyPolicy;
use App\Models\WarrantyRecognizee;
use League\Flysystem\Exception;
use Request,Image;
use App\Http\Controllers\Controller;
use DB;
use App\Models\Product;
use App\Models\Order;
use App\Models\WarrantyRule;
use App\Models\Images;
class AgentOrderController extends BaseController
{
    //




    public function addOrder()
    {//添加线下订单,获取所有的产品
        $product_list = Product::where('ty_product_id','>=',0)->get();
        $product_count = count($product_list);
        return view('frontend.agents.agent_order.AddOrder',compact('product_list','product_count'));
    }

    //线下订单表单提交表单
    public function addOrderSubmit()
    {
        $agent_id = $this->checkAgent();
        $input = Request::all();
        //添加订单，1，添加到订单表中，2.添加投保人被保人信息,3.添加到关联表中
        $Order = new Order();
        $WarrantyPolicy = new WarrantyPolicy();
        $WarrantyRecognizee = new WarrantyRecognizee();
        $pic_array = array();
        foreach($input as $key=>$value)
        {
            if(is_integer(strripos($key,'pic'))){
                array_push($pic_array,$input[$key]);
            }
        }


        //生成订单号，
        DB::beginTransaction();
        try{
            $random = rand(0,99999999);
            $date = date('Ymd',time());
            $random_number = substr('0000000'.$random,-8);
            $deal_type = 1;
            $order_code = ($date.$random_number.$deal_type);
            $order_array = array(

            'order_code'=>$order_code,

            'is_settlement'=>1,
            'product_id'=>$input['product_id'],
            'competition_id'=>0,
            'user_id'=>1,
            'agent_id'=>$agent_id,
            'claim_type'=>0,
            'deal_type'=>1,
        );
            $order_id = $this->add($Order,$order_array);
            $warranty_policy_array = array(
                'name'=>$input['policy_name'],
                'card_type'=>$input['policy_card_type'],
                'occupation'=>$input['policy_occupation'],
                'code'=>$input['policy_code'],
                'phone'=>$input['policy_phone'],
                'email'=>$input['policy_email'],
                'status'=>0,
            );
            $policy_id = $this->add($WarrantyPolicy,$warranty_policy_array);
            $warranty_recognizee_array = array(
                'name'=>$input['recognizee_name'],
                'order_id'=>$order_id,
                'order_code'=>$order_code,
                'relation'=>$input['recognizee_relation'],
                'occupation'=>$input['recognizee_occupation'],
                'card_type'=>$input['recognizee_card_type'],
                'code'=>$input['recognizee_code'],
                'phone'=>$input['recognizee_phone'],
                'email'=>$input['recognizee_email']
            );
            $recognizee_result = $this->add($WarrantyRecognizee,$warranty_recognizee_array);
            //添加到关联表中
            $WarrantyRule = new WarrantyRule();

            $warranty_rule_array = array(
                'order_id'=>$order_id,
                'policy_id'=>$policy_id,
                'agent_id'=>$agent_id,
                'union_order_code'=>$input['union_order_code'],
                'product_id'=>$input['product_id'],
            );
            $result = $this->add($WarrantyRule,$warranty_rule_array);

            //添加到图片关联中

            if($pic_array){//进行图片处理
                $image = $this->uploadImg($pic_array,$order_code);
                if(!$image){
                    return back()->withErrors('文件格式错误')->withInput($input);
                }
                $image_array = array();
                foreach($image as $value)
                {
                    $image_array[] = array('order_id'=>$order_id,'image'=>$value,'status'=>0);
                }
                $insert_result = Images::insert($image_array);
            }else{
                $insert_result = true;
            }

            if($order_id&&$policy_id&&$result&&$recognizee_result&&$insert_result){
                DB::commit();
                return back()->with('status','添加成功');
            }
            else{
                DB::rollBack();
                return back()->withErrors('添加失败');
            }

        }catch (Exception $e){
            DB::rollBack();
            return back()->withErrors('添加失败');
        }
    }
    //查看线下录入的订单
    public function offlineOrderList()
    {
        $agent_id = $this->checkAgent();
        //查找线下订单
        $order_list = Order::where('deal_type',1)
            ->where('agent_id',$agent_id)
            ->with('product')->orderBy('created_at','desc')->paginate(20);
        $count = count($order_list);
        return view('frontend.agents.agent_order.OrderList',compact('order_list','count'));
    }
//    //查看线下录入订单详情
    public function offlineOrderDetail($order_id)
    {
        //获取保单信息，投保人信息，被保人信息
        $order_detail = $this->getOrderDetailFunc($order_id);
        if($order_detail){
            $policy_id = $order_detail->policy_id;
            $uuid = json_decode(Product::where('id',$order_detail->product_id)->first()->json)->api_from_uuid;
            //获取投保人的信息
            $policy_detail = $this->getPolicyMessage($uuid,$policy_id);
            //获取被保人的信息
            $recognizee_detail = $this->getRecognizeeMessage($uuid,$order_id);
            return view('frontend.agents.agent_order.OrderDetail',compact('order_detail','policy_detail','recognizee_detail'));
        }else{
            return back()->withErrors('错误');
        }
    }

    //封装一个方法，用来获取订单的所有信息
    public function getOrderDetailFunc($order_id)
    {
        $order_detail = WarrantyRule::where('order_id',$order_id)
            ->with('warranty_rule_order','warranty_product')
            ->first();
        if($order_detail && $order_detail->warranty_rule_order){
            return $order_detail;
        }else{
            return false;
        }
    }
    //封装一个方法，用来获取一个保单的投保人信息
    public function getPolicyMessage($uuid,$policy_id)
    {
        //获取被保人的信息，同时获取证件类型
        $result = WarrantyPolicy::where('id',$policy_id)
            ->with(['policy_card_type'=>function($q)use($uuid){
                $q->where('api_from_uuid',$uuid);
            },'policy_occupation'=>function($q)use($uuid){
                $q->where('api_from_uuid',$uuid);
            }])->first();
        return $result;
    }
    //封装一个方法，用来获取被保人的信息
    public function getRecognizeeMessage($uuid,$order_id){
        $recognizee_detail = WarrantyRecognizee::where('order_id',$order_id)
            ->with(['recognizee_card_type'=>function($q)use($uuid){
                $q->where('api_from_uuid',$uuid);
            },'recognizee_occupation'=>function($q)use($uuid){
                $q->where('api_from_uuid',$uuid);
            },'recognizee_relation'=>function($q)use($uuid){
                $q->where('api_from_uuid',$uuid);
            }])->get();
        return $recognizee_detail;
    }

    //通过产品id获取产品的所有信息
    public function getParameterAjax()
    {
        $input = Request::all();
        $product_id = $input['product_id'];
        $Parameter = Product::where('id',$product_id)
            ->with('card_type','occupation','relation')
            ->first();
        $count = count($Parameter);
        if($count){
            echo returnJson('200',$Parameter);
        }else{
            echo returnJson('404','错误，请重试');
        }
    }
    protected function uploadImg($files,$order_code){
        $types = array('jpg', 'jpeg', 'png');
        $image_path = array();
        foreach($files as $k => $v){
            $extension = $v->getClientOriginalExtension();
            if(!in_array($extension, $types)){
                return false;
            }
            $path = 'upload/frontend/offline_order/image/' . date("Ymd") .'/'.$order_code.'/';
            $name = date("YmdHi").rand(1000, 9999). '.' .$extension;
            $v->move($path, $name);
            $image_path[] = $path . $name;
        }
        return $image_path;
    }
}
