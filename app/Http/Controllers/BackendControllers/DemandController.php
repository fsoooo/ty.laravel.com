<?php

namespace App\Http\Controllers\BackendControllers;

use App\Models\DemandOffer;
use App\Models\Product;
use League\Flysystem\Exception;
use Request;
use DB;
use App\Models\LiabilityDemand;
class DemandController extends BaseController
{
    //跳转主界面，默认显示所有的需求
    public function index($type)
    {
        $list = $this->getDemandByType($type);
        if($list){
            $count = count($list);
        }else{
            return back()->withErrors('非法操作');
        }
        return view('/backend/demand/index',compact('list','count','type'));
    }

    //获取需求的详细信息
    public function getDemandDetail($demand_id)
    {

        $demand_detail = LiabilityDemand::where('id',$demand_id)
            ->with('demand_user')->first();
//        dd($demand_detail->demand_options);
        $demand_options = json_decode($demand_detail->demand_options);//获取需求详情
//        $options_explain = ;//需求参数解释



        if($demand_detail){
            return view('backend.demand.detail',compact('demand_options','demand_detail','type'));
        }else{
            return back()->withErrors('非法操作');
        }
    }
//    //进行报价提交
//    public function offer()
//    {
//        $input = Request::all();
//        $Demand = LiabilityDemand::find($input['demand_id']);
//        if($Demand){
//            $array = array(
//                'is_deal'=>1,
//                'offer'=>$input['offer'],
//            );
//            $type = $Demand->create_type;
//            if($type){
//                $type = 'agent';
//            }else{
//                $type = 'user';
//            }
//            $result = $this->edit($Demand,$array);
//            if($result){
//                return redirect('/backend/demand/deal/'.$type)->with('status','操作成功');
//            }else{
//                return back()->withErrors('操作失败');
//            }
//        }else{
//            return back()->withErrors('非法操作');
//        }
//    }


//查询当前报价
    public function checkOffer($demand_id)
    {
        $is_demand = LiabilityDemand::where('id',$demand_id)
            ->first();
        if($is_demand){//说明是理赔，进行产品组合报价
            $offer_list = DemandOffer::where('demand_id',$demand_id)
                ->get();
            foreach($offer_list as $value)
            {
                $product_list = json_decode($value->product_list);
                $product_list_result = Product::wherein('id',$product_list)
                    ->get();
                $value->product_detail = $product_list_result;
            }
            return view('backend.demand.CheckOffer',compact('offer_list'));
        }else{
            return redirect('backend/demand/index/user')->withErrors('非法操作');
        }
    }

    //进行报价提交
    public function offer($demand_id)
    {
        $is_demand = LiabilityDemand::where('id',$demand_id)
            ->first();
        if($is_demand){//说明是理赔，进行产品组合报价
//            $product_list = Product::get();
            $product_list = Product::where('ty_product_id','>=',0)->get();//过滤线下产品
            return view('backend.demand.offer',compact('demand_id','product_list'));
        }else{
            return redirect('backend/demand/index/user')->withErrors('非法操作');
        }
    }

    //报价提交
    public function offerSubmit()
    {
        $input = Request::all();
        $offer = $input['offer'];
        if(empty($offer)){
            return back()->withErrors('报价不能为空！！')->withInput($input);
        }
        $demand_id = $input['demand_id'];
        unset($input['_token']);
        unset($input['offer']);
        unset($input['demand_id']);
        $array = array();
        foreach($input as $value)
        {
            array_push($array,$value);
        }
        $product_list = json_encode($array);
        DB::beginTransaction();
        try{
            $DemandOffer = new DemandOffer();
            $demand_offer_array = array(
                'demand_id'=>$demand_id,
                'product_list'=>$product_list,
                'offer'=>$offer,
            );
            $result = $this->add($DemandOffer,$demand_offer_array);
            //更新需求表中的数据
            $LiabilityDemand = LiabilityDemand::find($demand_id);
            $change = array(
                'is_deal'=>1,
                'offer'=>$offer
            );
            $result1 = $this->edit($LiabilityDemand,$change);
            if($result&&$result1)
            {
                DB::commit();
                return redirect('backend/demand/check_offer/'.$demand_id)->with('添加成功');
            }else{
                DB::RollBack();
                return back()->withErrors('添加失败')->withInput($input);
            }
        }catch(Exception $e){
            DB::RollBack();
            return back()->withErrors('添加失败')->withInput($input);
        }
    }


    //跳转到已经处理的请求页面
    public function deal($type)
    {
        $list = $this->getDemandByType($type,1);
        $count = count($list);
        return view('backend.demand.deal',compact('type','list','count'));

    }


    //封装方法，变换type为数字
    public function changeTypeToNumber($type){
        if($type == 'user'){
            $result = 0;
        }else if($type == 'agent'){
            $result = 1;
        }else{
            $result = false;
        }
        return $result;
    }
    //封装方法，通过类型获取不同的需求
    public function getDemandByType($type,$is_deal=0)
    {
        //改变状态为数字
        $type = $this->changeTypeToNumber($type);
        if($type != 0 && $type !=1){
            return false;
        }
        //查询条件
        $condition_array = [['status',0],['create_type',$type],['is_deal',$is_deal]];
        $demand_list = LiabilityDemand::where($condition_array)->with('demand_user')->paginate(config('list_num.backend.demand'));
        return $demand_list;
    }
}
