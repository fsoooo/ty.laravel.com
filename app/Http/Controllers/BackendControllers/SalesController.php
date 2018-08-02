<?php
/**
 * Created by PhpStorm.
 * User: cyt
 * Date: 2017/8/26
 * Time: 19:17
 */
namespace App\Http\Controllers\BackendControllers;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\BackendControllers;
use App\Models\Product;
use App\Models\Agent;
use App\Models\WarrantyRule;
use App\Models\Order;
use App\Models\Ditch;
use App\Models\WarrantyRecognizee;

class SalesController extends BaseController
{
    /**
     * 销售详情首页
     * 设计表order warranty_rule
     * 按支付时间降序排列
     * @return int
     */
    public function index()
    {
        $product_list = Order::where('order.status', 1)
            ->join('product', 'product.ty_product_id', '=', 'order.ty_product_id')
            ->groupBy('product_name')
            ->select('product.ty_product_id', 'product_name', DB::raw('count(product_name) as p_num,SUM(premium) as premium'))
            ->get();

        return view('backend.sales.index', compact('product_list'));

    }

    /**
     * 代理人统计
     */
    public function agent()
    {
        $agent = Agent::where('order.status',1)
            ->join('warranty_rule', 'agents.id', '=', 'warranty_rule.agent_id')
            ->join('order', 'warranty_rule.order_id', '=', 'order.id')
            ->join('product', 'product.ty_product_id', '=', 'order.ty_product_id')
            ->select('job_number', 'product_name', 'order.premium','order_code','start_time','end_time')
            ->paginate(15);
        return view('backend.sales.agent', compact('agent'));
    }



    /**
     * 渠道统计
     */
    public function ditch()
    {
        $ditch = Ditch::where('order.status',1)
            ->join('warranty_rule', 'ditches.id', '=', 'warranty_rule.ditch_id')
            ->join('order', 'warranty_rule.order_id', '=', 'order.id')
            ->join('product', 'product.ty_product_id', '=', 'order.ty_product_id')
            ->select('name', 'product_name', 'order.premium','order_code','start_time','end_time')
            ->paginate(15);
        return view('backend.sales.ditch', compact('ditch'));
    }


    /**
     * 销售详情
     */
    public function detail($id)
    {
        $users = Order::where('order.ty_product_id',$id)
            ->where('order.status',1)
            ->join('product', 'product.ty_product_id', '=', 'order.ty_product_id')
            ->join('warranty_recognizee', 'order.id', '=', 'warranty_recognizee.order_id')
            ->select('order.order_code', 'product.product_name', 'order.id','order.premium','order.is_settlement','order.start_time','order.end_time')
            ->paginate(15);
        $count = count($users);
        return view('backend.sales.details', compact('users','count'));
    }

    /**
     * 详情下详情
     */
    public function details($id){
        $users = WarrantyRecognizee::where('warranty_recognizee.order_id',$id)
            ->select('warranty_recognizee.name', 'warranty_recognizee.order_code', 'warranty_recognizee.phone','warranty_recognizee.email','warranty_recognizee.relation','warranty_recognizee.order_code','warranty_recognizee.start_time','warranty_recognizee.end_time')
            ->paginate(15);
        $count = count($users);

        $warranty = WarrantyRule::where('warranty_rule.order_id',$id)
            ->join('warranty_policy', 'warranty_rule.policy_id', '=', 'warranty_policy.id')
            ->select('name')
            ->first();
        $name = count($warranty);
        return view('backend.sales.detailed_information', compact('users','count','warranty','name'));
    }

     /*
      *保单管理
      */
    public  function policy()
    {
        $policy = WarrantyRule::whereNotNull('warranty_id')
            ->with(['warranty','order.product'])
            ->paginate(config('list_num.backend.order'));
        $count = count($policy);
        return view('backend.sales.policy', compact('policy','count'));
    }


}
