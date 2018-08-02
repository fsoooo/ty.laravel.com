<?php

namespace App\Http\Controllers\FrontendControllers\GuestControllers;

use App\Http\Controllers\FrontendControllers\BaseController;
use App\Models\CancelWarrantyRecord;
use App\Models\MaintenanceRecord;
use App\Models\Order;
use App\Models\FormInfo;
use App\Models\MaintenanceInfo;
use App\Models\WarrantyRule;
use App\Models\Bank;
use App\Models\Occupation;
use App\Models\Relation;
use App\Models\CardType;
use App\Models\CodeType;



class MaintenanceController extends BaseController
{
    //
    protected $uid;
    public function __construct()
    {
        $this->uid = $this->getId();
    }

    //跳转到资料变更界面
    public function changeData()
    {

        $type = $_COOKIE['login_type'];
        if($type == 'user')
        {
            $order_type = 0;
        }else{
            $order_type = 1;
        }

        //获取所有的资料修改
        $list = MaintenanceInfo::with('warranty_rule')->get();
        $count = count($list);
        return view('frontend.guests.maintenance.ChangeDataList',compact('list','count'));
    }
    //获取某个保单的所有信息变更记录
    public function getChangeData($order_id)
    {
        $order_id = $order_id;
        $list = MaintenanceRecord::where('order_id',$order_id)
            ->where('user_id',$this->uid)
            ->with('maintenance_record_order')
            ->where('change_type','修改投保人信息')
            ->orderBy('id','desc')
            ->paginate(config('list_num.backend.maintenance'));
        foreach($list as $key1=>$value){
            $arr = array();
            $change_content = json_decode($value->change_content);
            foreach($change_content as $key=>$value){
                $arr[$key]=$value;
            }
            $list[$key1]['change_content_array'] = $arr;
        }
        $count = count($list);
        $order_detail = Order::where('id',$order_id)
            ->first();
        return view('frontend.guests.maintenance.ChangeDataDetail',compact('list','count','order_detail'));
    }


    //保额变更
    public function changePremium()
    {
        //获取所有的保额变更记录
        $premium_list = MaintenanceRecord::with('maintenance_record_order','maintenance_record_order.product','maintenance_record_order.warranty_rule.warranty')
            ->where('user_id',$this->uid)
            ->where('change_type','保额变更')
            ->select('order_id')
            ->distinct()
            ->orderBy('id','desc')
            ->where('status',0)
            ->paginate(config('list_num.backend.maintenance'));
        $count = count($premium_list);
        return view('frontend.guests.maintenance.ChangePremiumList',compact('premium_list','count'));
    }
    //修改保额详情
    public function changePremiumDetail($order_id)
    {
        $premium_detail = MaintenanceRecord::where('order_id',$order_id)
            ->where('change_type','保额变更')
            ->with('maintenance_record_order.product','maintenance_record_order.warranty_rule.warranty')
            ->orderBy('id','desc')
            ->get();
        return view('frontend.guests.maintenance.ChangePremiumDetail',compact('premium_detail'));
    }



    //团险人员变更
    public function changePerson()
    {
        $list = MaintenanceRecord::where('change_type','团险加人')
            ->orwhere('change_type','团险减人')
            ->where('user_id',$this->uid)
            ->with('maintenance_record_order')
            ->select('order_id')
            ->distinct()
            ->paginate(config('list_num.backend.maintenance'));
        $count = count($list);
        return view('frontend.guests.maintenance.ChangePersonList',compact('list','count'));
    }
    //团险人员变动详情
    public function changePersonData($order_id)
    {
        $order_id = $order_id;
        $list = MaintenanceRecord::where('order_id',$order_id)
            ->with('maintenance_record_recognizee')
            ->with('maintenance_record_order')
            ->where('change_type','团险加人')
            ->orwhere('change_type','团险减人')
            ->orderBy('id','desc')
            ->paginate(config('list_num.backend.maintenance'));
        foreach($list as $key1=>$value){
            $arr = array();
            if($value->change_type == '团险加人'){
                $change_content = json_decode($value->change_content);
                foreach($change_content as $key=>$value){
                    $arr[$key]=$value;
                }
            }else{
                $recognizee = $value->maintenance_record_recognizee;
                $arr['name'] = $recognizee['name'];
                $arr['relation'] = $recognizee['relation'];
                $arr['card_type'] = $recognizee['card_type'];
                $arr['code'] = $recognizee['code'];
                $arr['phone'] = $recognizee['phone'];
                $arr['email'] = $recognizee['email'];
                $arr['start_time'] = $recognizee['start_time'];
                $arr['end_time'] = $recognizee['end_time'];
            }
            $list[$key1]['change_content_array'] = $arr;
        }
        $count = count($list);
        $order_detail = Order::where('id',$order_id)
            ->first();
        return view('frontend.guests.maintenance.ChangePersonDetail',compact('list','count','order_detail'));
    }

    //退保申请
    public function cancel()
    {
        $list = CancelWarrantyRecord:: where('user_id',$this->uid)->with('cancel_order')->orderBy('created_at','desc')->paginate(config('list_num.backend.claim'));
        $count = count($list);
        return view('frontend.guests.maintenance.CancelWarrantyList',compact('list','count'));
    }
    //退保申请详情
    public function cancelDetail($id)
    {
        $cancel_detail = CancelWarrantyRecord::where('id',$id)
            ->with('cancel_order')
            ->first();
        return view('frontend.guests.maintenance.CancelDetail',compact('cancel_detail'));
    }
    public function changeDataDetail($union_order_code){
        $maintenance_info = MaintenanceInfo::where('union_order_id',$union_order_code)->first();
        $input = json_decode($maintenance_info->input,true);
        $save_input = json_decode($maintenance_info->save_input,true);
        $res = json_decode($maintenance_info->change_input,true);
        $product_res = WarrantyRule::with('warranty_product')->where('union_order_code',$union_order_code)->first();
        $uuid = $product_res->warranty_product->api_form_uuid;
        $occupation = Occupation::get();//职业
        $relation = Relation::get();//亲属关系
        $card_type = CardType::get();//证件类型
        return view('frontend.guests.maintenance.changedetails')
            ->with('union_order_code',$union_order_code)
            ->with('save_input',json_decode($input,true))
            ->with('input',json_decode($save_input,true))
            ->with('res',json_decode($res,true))
            ->with('occupation',$occupation)
            ->with('relation',$relation)
            ->with('card_type',$card_type);
    }



}
