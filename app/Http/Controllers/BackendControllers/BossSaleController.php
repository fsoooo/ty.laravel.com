<?php
/**
 * Created by PhpStorm.
 * User: cyt
 * Date: 2017/6/27
 * Time: 19:17
 */
namespace App\Http\Controllers\BackendControllers;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\BackendControllers;

class BossSaleController extends BaseController{
    /**
     * 销售详情首页
     * 设计表order warranty_rule
     * 按支付时间降序排列
     * @return int
     */
    public function index($period){
//        dd($period);
        switch($period){
            case 1:
                $time=time()-604800;
                $time=date("Y-m-d H:i:s",$time);
                $data=DB::select('select `product_name`,count(`product_name`) as count,`com_product`.`id` from `com_product` inner join `com_order` on `com_product`.`id` = `com_order`.`ty_product_id` where `com_order`.`pay_time` > :id AND `com_order`.`status` = 1 AND `com_order`.`deal_type` = 0  group by `com_product`.`product_name`',['id'=>$time]);
//                dd($data);
                $count=count($data);
                return view('backend.boss.sale.index',['product_list'=>$data,'count'=>$count,'period'=>$period]);
                break;
            case 2:
                $time=time()-2592000;
                $time=date("Y-m-d H:i:s",$time);
                $data=DB::select('select `product_name`,count(`product_name`) as count,`com_product`.`id` from `com_product` inner join `com_order` on `com_product`.`id` = `com_order`.`ty_product_id` where `com_order`.`pay_time` > :id AND `com_order`.`status` = 1 AND `com_order`.`deal_type` = 0 group by `com_product`.`product_name`',['id'=>$time]);
                $count=count($data);
                return view('backend.boss.sale.index',['product_list'=>$data,'count'=>$count,'period'=>$period]);
                break;
            case 3:
                $time=time()-7776000;
                $time=date("Y-m-d H:i:s",$time);
                $data=DB::select('select `product_name`,count(`product_name`) as count,`com_product`.`id` from `com_product` inner join `com_order` on `com_product`.`id` = `com_order`.`ty_product_id` where `com_order`.`pay_time` > :id AND `com_order`.`status` = 1 AND `com_order`.`deal_type` = 0 group by `com_product`.`product_name`',['id'=>$time]);
                $count=count($data);
                return view('backend.boss.sale.index',['product_list'=>$data,'count'=>$count,'period'=>$period]);
                break;
            case 4:
                $time=time()-31536000;
                $time=date("Y-m-d H:i:s",$time);
                $data=DB::select('select `product_name`,count(`product_name`) as count,`com_product`.`id` from `com_product` inner join `com_order` on `com_product`.`id` = `com_order`.`ty_product_id` where `com_order`.`pay_time` > :id and `com_order`.`status` = 1 AND `com_order`.`deal_type` = 0  group by `com_product`.`product_name`',['id'=>$time]);
                $count=count($data);
                return view('backend.boss.sale.index',['product_list'=>$data,'count'=>$count,'period'=>$period]);
                break;
            case 5:
                $data=DB::select('select `product_name`,count(`product_name`) as count,`com_product`.`id`  from `com_product` inner join `com_order` on `com_product`.`id` = `com_order`.`ty_product_id` WHERE `com_order`.`status` = 1 AND `com_order`.`deal_type` = 0 group by `com_product`.`product_name`');
//                dd($data);
                $count=count($data);
                return view('backend.boss.sale.index',['product_list'=>$data,'count'=>$count,'period'=>$period]);
                break;
            default :
                $data=DB::select('select `product_name`,count(`product_name`) as count,`com_product`.`id` from `com_product` inner join `com_order` on `com_product`.`id` = `com_order`.`ty_product_id` WHERE `com_order`.`status` = 1 AND `com_order`.`deal_type` = 0 group by `com_product`.`product_name`');
                $count=count($data);
                return view('backend.boss.sale.index',['product_list'=>$data,'count'=>$count,'period'=>$period]);
                break;
        }

    }

    /**
     * 销售详情
     */
    public function details($id){
        $data=DB::table('order')
            ->join('product','order.ty_product_id','=','product.id')
            ->join('users','order.user_id','=','users.id')
            ->select('order.*','product.product_name','users.real_name')
            ->where([
                ['order.ty_product_id','=',$id],
                ['order.status','=',1],
                ['order.deal_type','=',0]
            ])
            ->get();
        $count=count($data);
//        dd($data);
        return view('backend.boss.sale.details',['product_list'=>$data,'count'=>$count]);



    }
}



















