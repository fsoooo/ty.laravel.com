<?php

namespace App\Http\Controllers\FrontendControllers\AgentControllers;

use App\Http\Controllers\FrontendControllers\BaseController;
use App\Models\Order;
use App\Models\Product;
use App\Models\WarrantyPolicy;
use App\Models\WarrantyRecognizee;
use League\Flysystem\Exception;
use Request,DB,Image;
use App\Http\Controllers\Controller;
use App\Models\WarrantyRule;
use App\Models\Images;
use App\Models\Warranty;
class AgentWarrantyController extends BaseController
{
    //

    //添加保单
    public function addWarranty()
    {//获取自己的所有的未绑定保单的订单
        $agent_id = $this->checkAgent();
        $order_list = Order::where('agent_id',$agent_id)
            ->where('deal_type',1)
            ->whereHas('warranty_rule',function($q){
                $q->where('warranty_id',null);
            })->get();
        $count = count($order_list);
        return view('frontend.agents.agent_warranty.AddWarranty',compact('order_list','count'));
    }
    //查找订单的详情
    public function getOrderDetail()
    {
        $input = Request::all();
        $order_id = $input['order_id'];
        $order_detail = Order::where('id',$order_id)
            ->with('product')
            ->first();
        if($order_detail){
            echo returnJson('200',$order_detail);
        }else{
            echo returnJson('403','查询信息失败，请重试');
        }
    }

    //线下保单提交
    public function addWarrantySubmit()
    {
        $input = Request::all();

        DB::beginTransaction();
        try{
            //更新到保单和订单关系中
            $Warranty = new Warranty();
            $warranty_code = $input['warranty_code'];
            $warranty_array = array(
                'warranty_code'=>$warranty_code,
                'warranty_url'=>$input['warranty_url'],
                'deal_type'=>1, //线下提交
            );
            $warranty_id = $this->add($Warranty,$warranty_array);
            $Warranty = WarrantyRule::where('order_id',$input['order_id'])
                ->first();
            $change_array = array(
                'warranty_id'=>$warranty_id,
            );
            $change_result = $this->edit($Warranty,$change_array);


            $pic_array = array();
            foreach($input as $key=>$value)
            {
                if(is_integer(strripos($key,'pic'))){
                    array_push($pic_array,$input[$key]);
                }
            }
            if($pic_array){//说明有图片
                $image = $this->uploadImg($pic_array,$warranty_code);
                if(!$image){
                    return back()->withErrors('文件格式错误')->withInput($input);
                }
                $image_array = array();
                foreach($image as $value)
                {
                    $image_array[] = array('warranty_id'=>$warranty_id,'image'=>$value,'status'=>0);
                }
                $insert_result = Images::insert($image_array);
            }else{
                $insert_result = true;
            }
            if($warranty_id&&$change_result&&$insert_result){
                DB::commit();
                return back()->with('status','添加成功');
            }else{
                DB::rollBack();
                return back()->withErrors('添加失败');
            }
        }catch (Exception $e){
            DB::rollBack();
            return back()->withErrors('添加失败');
        }
    }
    //查看线下录入保单列表
    public function offlineWarrantyList()
    {
        $warranty_list = WarrantyRule::with('warranty','warranty_product')->where('type',0)->orderBy('created_at','desc')->paginate(config('list_num.frontend.warranty'));
        $count = count($warranty_list);
        return view('frontend.agents.agent_warranty.WarrantyList',compact('warranty_list','count'));
    }

    //封装一个方法，用来获得具体保单的信息
    public function offlineWarrantyDetail($warranty_id)
    {
        //获取保单信息，投保人信息，被保人信息
        $warranty_detail = $this->getWarrantyDetailFunc($warranty_id);
        if($warranty_detail){
            $policy_id = $warranty_detail->policy_id;
            $uuid = Product::where('id',$warranty_detail->product_id)->first()->api_from_uuid;
            //获取投保人的信息
            $policy_detail = $this->getPolicyMessage($uuid,$policy_id);
            //获取被保人的信息
            $order_id = $warranty_detail->order_id;
            $recognizee_detail = $this->getRecognizeeMessage($uuid,$order_id);
            return view('frontend.agents.agent_warranty.WarrantyDetail',compact('warranty_detail','policy_detail','recognizee_detail'));
        }else{
            return back()->withErrors('错误');
        }
    }
    //封装一个方法，用来获取保单的所有信息
    public function getWarrantyDetailFunc($warranty_id)
    {
        $warranty_detail = Warranty::where('id',$warranty_id)
            ->with('warranty_rule')
            ->first();

        $warranty_detail = WarrantyRule::where('warranty_id',$warranty_id)
            ->with('warranty_product','warranty')
            ->first();
        if($warranty_detail && $warranty_detail->warranty){
            return $warranty_detail;
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



    protected function uploadImg($files,$warranty_code){
        $types = array('jpg', 'jpeg', 'png');
        $image_path = array();
        foreach($files as $k => $v){
            $extension = $v->getClientOriginalExtension();
            if(!in_array($extension, $types)){
                return false;
            }
            $path = 'upload/frontend/offline_warranty/image/' . date("Ymd") .'/'.$warranty_code.'/';
            $name = date("YmdHi").rand(1000, 9999). '.' .$extension;
            $v->move($path, $name);
            $image_path[] = $path . $name;
        }
        return $image_path;
    }



}
