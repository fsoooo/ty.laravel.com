<?php
namespace App\Http\Controllers\FrontendControllers\GuestControllers;

use App\Helper\Issue;
use App\Http\Controllers\FrontendControllers\BaseController;
use App\Models\Warranty;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use App\Models\Order;
use App\Models\WarrantyRule;
use App\Models\WarrantyRecognizee;
use App\Models\WarrantyPolicy;
use App\Models\Product;
use Request as Requests;
class SlipController extends BaseController
{

//    保单展示
    public function index($type)
    {
        //        保单入库
        $data = Order::join('warranty_rule', 'order.id', 'warranty_rule.order_id')
            ->where('order.user_id', $this->getId())
            ->where('order.status', 1)
            ->where('warranty_rule.warranty_id', null)
            ->select('warranty_rule.*')
            ->get();
        if(isset($data)){
            foreach ($data as $v) {
                $insure = new Issue();
                $res = $insure->issue($v);
            }
        }
//        类型查询，判断
        $id = $this->getId();
        if($type == "unenforced"){
            $status = config('attribute_status.policy.unenforced');
        }elseif($type == "insuring"){
            $status = config('attribute_status.policy.insuring');
        }elseif($type == "lose"){
            $status = config('attribute_status.policy.lose');
        }elseif($type == "policy"){
            $status = config('attribute_status.policy.surrender');
        }elseif($type == "all"){
            $status = "";
        }
        $users = $this->data($type,$status);
        $option_type = 'guarantee';
        $count = count($users);
        if($this->is_mobile() && $this->is_person(Auth::user()->id) == 1){
            //移动个人
            return view('frontend.guests.mobile.personal.guarantee',compact('option_type','type','users','order_parameter','count'));

        }elseif($this->is_person($this->getId()) == 1 && !$this->is_mobile()){
            //个人pc
            return view('frontend.guests.guarantee.index',compact('option_type','type','users','order_parameter'));
        }elseif($this->is_mobile() && $this->is_person(Auth::user()->id) == 2){
            //移动端团险
            return view('frontend.guests.mobile.company.guarantee',compact('option_type','type','users','order_parameter','count'));
        }else{
            //pc端团险
            return view('frontend.guests.company.guarantee.index',compact('option_type','type','users'));
        }
    }

    //报单详情
    public function detail($id)
    {
        $data = Order::where('id',$id)
            ->with('warranty_recognizee','product')
            ->first();
//        dd($data);
        return view('frontend.guests.company.guarantee.detail',compact('data'));
    }

    //    封装
    public function data($type, $status)
    {
        $id = $this->getId();
        if ($type == "all") {
            $users = Order::where('order.user_id', $id)
                ->join('warranty_recognizee', 'order.id', '=', 'warranty_recognizee.order_id')
                ->join('product', 'product.ty_product_id', '=', 'order.ty_product_id')
                ->join('warranty_rule', 'order.id', '=', 'warranty_rule.order_id')
                ->join('warranty', 'warranty_rule.warranty_id', '=', 'warranty.id')
                ->join('order_parameter', 'order.id', '=', 'order_parameter.order_id')
                ->select('order_parameter.parameter','warranty.warranty_code','order.id', 'warranty.status', 'order.order_code', 'product.clauses', 'product.product_name', 'warranty_recognizee.name', 'order.premium', 'order.is_settlement', 'order.start_time', 'order.end_time', 'order.created_at')
                ->groupBy('warranty.warranty_code')
                ->paginate(config('list_num.frontend.order'));
        } else {
            $users = Order::where('order.user_id', $id)
                ->where('warranty.status', $status)
                ->join('warranty_recognizee', 'order.id', '=', 'warranty_recognizee.order_id')
                ->join('product', 'product.ty_product_id', '=', 'order.ty_product_id')
                ->join('warranty_rule', 'order.id', '=', 'warranty_rule.order_id')
                ->join('warranty', 'warranty_rule.warranty_id', '=', 'warranty.id')
                ->join('order_parameter', 'order.id', '=', 'order_parameter.order_id')
                ->select('order_parameter.parameter','warranty.warranty_code','order.id', 'warranty.status', 'order.order_code', 'product.clauses', 'product.product_name', 'warranty_recognizee.name', 'order.premium', 'order.is_settlement', 'order.start_time', 'order.end_time', 'order.created_at')
                ->groupBy('warranty.warranty_code')
                ->paginate(config('list_num.frontend.order'));
        }
        return $users;
    }

    //移动个人保单详情
    public function guaranteeDetail($id)
    {
        $data = Warranty::with('warranty_rule')
            ->with('warranty_rule.policy')
            ->with('warranty_rule.order')
            ->with('warranty_rule.order.product')
            ->with('warranty_rule.order.warranty_recognizee')
            ->where('warranty_code',$id)
            ->first();
        $type = Warranty::with('warranty_rule')
            ->with('warranty_rule.policy')
            ->with('warranty_rule.order')
            ->with('warranty_rule.order.product')
            ->where('warranty_code',$id)
            ->first();
        $duties = Warranty::with('warranty_rule')
            ->with('warranty_rule.order.order_parameter')
            ->first();
        $duty = json_decode($duties->warranty_rule->order->order_parameter[0]['parameter'],true);
        $duty = json_decode($duty['protect_item'],true);

        return view('frontend.guests.mobile.personal.guarantee_detail',compact('data','id','duty'));
    }


}