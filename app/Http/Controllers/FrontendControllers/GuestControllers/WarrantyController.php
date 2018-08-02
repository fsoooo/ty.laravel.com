<?php

namespace App\Http\Controllers\FrontendControllers\GuestControllers;

use App\Models\CodeType;
use App\Models\MaintenanceRecord;
//use App\Models\RecognizeeGroup;
use App\Models\User;
use App\Models\Warranty;
use App\Models\WarrantyPolicy;
use App\Models\WarrantyRecognizee;
use Illuminate\Support\Facades\DB;
use League\Flysystem\Exception;
use Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\FrontendControllers\BaseController;
class WarrantyController extends BaseController
{


    //获取所有的保单
    public function index()
    {
        $type = Auth::user()->type;
        $id = $this->getId();
        $warranty_list = $this->getAllWarranty($id);
        $count = count($warranty_list);
        return view('frontend.guests.warranty.index',compact('warranty_list','count','type'));
    }
    //获取保单的详细信息
    public function getWarrantyDetail($warranty_id)
    {
        $type = Auth::user()->type;
        $warranty_rule = $this->getWarrantyRuleByWid($warranty_id);
        if($warranty_rule){
            //获取保单的详细信息
            $warranty_detail = Warranty::where('id',$warranty_id)->with('warranty_rule','warranty_rule.warranty_product')->first();
            //获取投保人的信息
            $policy = $this->getPolicyByWarrantyRule($warranty_rule);
            //获取被保人的信息
            $recognizee_type = $warranty_rule->type;
            if($recognizee_type){
                $recognizee = $this->getRecognizeeDetailFunc($warranty_id,$recognizee_type);
            }else{
                $recognizee_id = $warranty_rule->recognizee_id;
                $recognizee = $this->getRecognizeeDetailFunc($recognizee_id,$recognizee_type);
            }
            if(!$policy||!$recognizee){
                return redirect('\user\warranty\index')->withErrors('非法操作');
            }
            return view('frontend.guests.warranty.detail',compact('warranty_detail','policy','recognizee'));
        }else{
            return redirect('\user\warranty\index')->withErrors('非法操作');
        }
    }
    //添加被保人
    public function addRecognizee($warranty_id)
    {
        //获取该保单的详细信息
        $warranty_detail = $this->getWarrantyDetailFunc($warranty_id);
        if($warranty_detail){
            //获取所有的证件
            $code_type = CodeType::get();
            return view('frontend.guests.warranty.AddRecognizee',compact('warranty_id','warranty_detail','code_type'));
        }else{
            return back()->withErrors('非法操作');
        }
    }
    //添加被保人表单提交
    public function addRecognizeeSubmit()
    {
        $input = Request::all();
        dd($input);
        DB::beginTransaction();
        try{
            //添加被保人信息，  1，被保人表，2，被保人集合表,3,添加未支付到保单和账户中
            $Recognizee = new WarrantyRecognizee();
            $recognizee_array = array(
                'name'=>$input['name'],
                'code'=>$input['code'],
                'phone'=>$input['phone'],
                'email'=>$input['email'],
            );
            $recognizee_id = $this->add($Recognizee,$recognizee_array);
            //添加到被保人集合表中
//            $RecognizeeGroup = new RecognizeeGroup();
//            $recognizee_group_array = array(
//                'warranty_id'=>$input['warranty_id'],
//                'recognizee_id'=>$recognizee_id,
//                'status'=>0,
//            );
//            $this->add($RecognizeeGroup,$recognizee_group_array);
            //添加到操作记录表中

            $MaintenanceRecord = new MaintenanceRecord();
            unset($input['_token']);
            unset($input['warranty_id']);
            $maintenance_array = $input;
            $this->add($MaintenanceRecord,$maintenance_array);
            //计算保单应支付价格
//            $un_price =

            DB::commit();
            return back()->with('status','添加成功');
        }catch(Exception $e){
            DB::rollBack();
            return back()->withErrors('添加失败');
        }
    }
    //添加保额界面
    public function addPremium($warranty_code)
    {
        //查找保单
        $warranty_detail = Warranty::where('id',$warranty_id)
            ->first();
        //查找关联
    }




    //封装一个方法，用来获取保单的信息
    public function getWarrantyDetailFunc($warranty_id)
    {
        $warranty_detail = Warranty::where('id',$warranty_id)
            ->first();
        return $warranty_detail;
    }

    //封装一个方法，用来获取一个保单的相关信息
    public function getWarrantyRuleByWid($warranty_id)
    {
        $warranty_rule = Warranty::with('warranty_rule')
            ->first();
        return $warranty_rule->warranty_rule;
    }

    //封装一个方法，用来获取一个保单的投保人信息
    public function getPolicyByWarrantyRule($warranty_rule)
    {
        $id = $this->getId();
        $policy_id = $warranty_rule->policy_id;
        $result = WarrantyPolicy::where('id',$policy_id)->first();
        return $result;
    }
    //封装一个方法，用来获取被保人的信息
    public function getRecognizeeDetailFunc($recognizee_id,$recognizee_type){
        //两种情况，个人险被保人还是团险被保人
        if($recognizee_type){
//            //团险，按组查找
//            $recognizee_group = RecognizeeGroup::where('warranty_id',$recognizee_id)
//                ->select('recognizee_id')->get()->toArray();
//            $recognizee_array = array();
//            foreach($recognizee_group as $value){
//                array_push($recognizee_array,$value['recognizee_id']);
//            }
//            $recognizee_detail = WarrantyRecognizee::wherein('id',$recognizee_array)
//                ->get();
        }else{
            //个险
            $recognizee_detail = WarrantyRecognizee::where('id',$recognizee_id)
                ->get();
        }
        return $recognizee_detail;
    }
    //封装一个方法，通过产品名称


}
