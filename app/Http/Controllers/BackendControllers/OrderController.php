<?php
/**
 * Created by PhpStorm.
 * User: dell01
 * Date: 2017/5/2
 * Time: 18:12
 */
namespace App\Http\Controllers\BackendControllers;
use App\Http\Controllers\BackendControllers;
use App\Models\Clause;
use App\Models\CodeType;
use App\Models\Company;
use App\Models\Order;
use App\Models\Product;
//use App\Models\RecognizeeGroup;
//use App\Models\RecognizeeRule;
use App\Models\Warranty;
use App\Models\WarrantyPolicy;
use App\Models\WarrantyRecognizee;
use App\Models\WarrantyRelation;
use App\Models\WarrantyRule;
use Illuminate\Database\Eloquent\Relations\Relation;
use League\Flysystem\Exception;
use Request;
use Illuminate\Support\Facades\DB;
class OrderController extends BaseController{



    //添加订单表单提交界面,同时发送请求
    public function addOrderSubmit()
    {
        $input = Request::all();
//        dd($input);
        DB::beginTransaction();
        try{
            //添加投保人信息
            $Policy = new WarrantyPolicy();
            $PolicyArray = array(
                'name'=>$input['policy_name'],
                'code_type'=>$input['policy_code_type'],
                'code'=>$input['recognizee_code'],
                'phone'=>$input['recognizee_phone'],
                'email'=>$input['recognizee_email'],
                'status'=>0,
            );
            $policy_id = $this->add($Policy,$PolicyArray);
            //添加被保人信息,同时进行判断，被保人和投保人是否是一个人
            $Recognizee = new WarrantyRecognizee();
            if($input['relation_type'] == '本人'){
                $RecognizeeArray = $PolicyArray;
            }else{
                $RecognizeeArray = array(
                    'name'=>$input['recognizee_name'],
                    'code_type'=>$input['recognizee_code_type'],
                    'code'=>$input['recognizee_code'],
                    'phone'=>$input['recognizee_phone'],
                    'email'=>$input['recognizee_email'],
                    'status'=>0,
                );
            }
            $recognizee_id = $this->add($Recognizee,$RecognizeeArray);
            //添加保单信息
//            $Order =
            $WarrantyArray = array(
                'warranty_code'=>$input['warranty_code'],
                'deal_type'=>1,
                'claim_type'=>$input['claim_type'],
                'start_time'=>$input['start_time'],
                'end_time'=>$input['end_time'],
                'status'=>0,
            );
            $warranty_id = $this->add($Warranty,$WarrantyArray);
            //添加保单关联信息
            $WarrantyRule = new WarrantyRule();
            $WarrantyRuleArranty = array(
                'warranty_id'=>$warranty_id,
                'policy_id'=>$policy_id,
                'recognizee_id'=>$recognizee_id,
                'type'=>0,
                'recognizee_type'=>0,
                'recognizee_id'=>$recognizee_id,
                'relation'=>$input['relation_type'],
            );
            $result = $this->add($WarrantyRule,$WarrantyRuleArranty);
            DB::commit();
            return redirect('backend/warranty/get_warranty/all')->with('添加成功');
        }catch (Exception $e){
            DB::rollBack();
            return back()->withErrors('添加失败');
        }
    }



    //跳转到查看订单页面，默认为查看线上保单
    public function getOrder($type)
    {
        $type = $type;
        $order = $this->getOrderByType($type);
        $order_list = $order->paginate(20);
        $count = count($order->get());
        return view('backend.order.OrderList',compact('order_list','count','type'));
    }
    //用来获得具体订单的信息
    public function getOrderDetail($order_id)
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
            return view('backend.order.detail',compact('order_detail','policy_detail','recognizee_detail'));
        }else{
            return back()->withErrors('错误');
        }
    }



    //跳转到分配保单页面
    public function distribution($warranty_id)
    {
        $agent_list = $this->getAgent();
        $count = count($agent_list);
        return view('backend.warranty.distribute',compact('agent_list','count'));
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



    //封装一个方法，用来获取不同类型的保单
    public function  getOrderByType($type)
    {
        if($type == 'all'){
            $order_list = Order::with('product')->orderBy('created_at');
        }else if($type == 'offline'){
            //查找线下订单
            $order_list = Order::where('deal_type',1)
                ->with('product')->orderBy('created_at');
        }else if($type == 'online'){
            //查找线上成交订单
            $order_list = Order::where('deal_type',0)
                ->with('product')->orderBy('created_at');
        }else{
            return false;
        }
        return $order_list;
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
}