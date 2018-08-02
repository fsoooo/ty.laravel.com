<?php
/**
 * Created by PhpStorm.
 * User: cyt
 * Date: 2017/7/3
 * Time: 14:45
 */
namespace App\Http\Controllers\FrontendControllers\GuestControllers;
use App\Http\Controllers\FrontendControllers\BaseController;
use App\Models\DemandOffer;
use Illuminate\Support\Facades\DB;
use App\Models\LiabilityDemand;
use App\Models\Product;

class DemandController extends BaseController{
    public function index($code){
        //获取当前用户在用户表中的主键方法
        $id=$this->getId(); //当前用户的idd
        //判断是否是自己的需求
        $is_demand = LiabilityDemand::where('demand_code',$code)
            ->where('create_user_id',$id)
            ->first();
        if($is_demand){//说明有访问权限
            //进行查询
            $demand_id = $is_demand->id;
            $demand_offer_list = DemandOffer::where('demand_id',$demand_id)
                ->get();
            foreach($demand_offer_list as $value)
            {
                $product_list = json_decode($value->product_list);
                $product_detail = Product::wherein('id',$product_list)
                    ->get();
                $value->product_list = $product_detail;
            }
//            dd($demand_offer_list);
            //遍历报价，进行产品组合查询
        }else{//无访问权限
            return back()->withErrors('非法操作');
        }
        return view('frontend.guests.need_recommend_list.index',['data'=>$demand_offer_list]);
    }
    public function demandDetail($code,$id){
//        dd($code);
        $data=DB::select('select `com_demand_offer`.`product_list`from `com_demand_offer` where `com_demand_offer`.`id` =  '.$id);
//        $isNot=DB::select('select `com_liability_demand`.`demand_options`from `com_liability_demand` where `com_liability_demand`.`demand_code`='.$code);
//        dd($isNot);
        $data=$data[0];
        $result=[];
        $data = json_decode($data->product_list, true);
//        var_dump($data);die;
        $data = implode(',', $data);
//        var_dump($data);die;
        $result[]=DB::select("select * from `com_product` where `com_product`.`id`in ({$data})");
        $result=$result[0];
//        dd($result);
        return view('frontend.guests.need_recommend_list.product_list',['data'=>$result]);
    }
}
















