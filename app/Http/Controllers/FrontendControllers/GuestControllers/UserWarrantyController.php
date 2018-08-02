<?php

namespace App\Http\Controllers\FrontendControllers\GuestControllers;
use App\Http\Controllers\FrontendControllers\BaseController;
use App\Models\MaintenanceRecord;
use App\Models\Warranty;
use App\Models\WarrantyPolicy;
use Illuminate\Support\Facades\DB;
use League\Flysystem\Exception;
use Request;
use App\Http\Controllers\Controller;

class UserWarrantyController extends WarrantyController
{

    public function index()
    {
        $id = $this->getId();
        $warranty_list = $this->getAllWarranty($id);
        $count = count($warranty_list);
        return view('frontend.user.warranty.index',compact('warranty_list','count'));
    }



    //获取保单的详细信息
    public function getWarrantyDetail($warranty_id)
    {
        $warranty_rule = $this->getWarrantyRuleByWid($warranty_id);
        if($warranty_rule){
            //获取保单的详细信息
            $warranty_detail = Warranty::where('id',$warranty_id)->with('warranty_rule','warranty_rule.warranty_product')->first();
            //获取投保人的信息
            $policy = $this->getPolicyByWarrantyRule($warranty_rule);
            //获取被保人的信息
            $recognizee = $this->getRecognizeeByWarrantyRule($warranty_rule);
            if(!$policy||!$recognizee){
                return redirect('\user\warranty\index')->withErrors('非法操作');
            }
            return view('frontend.guests.user.warranty.detail',compact('warranty_detail','policy','recognizee'));
        }else{
            return redirect('\user\warranty\index')->withErrors('非法操作');
        }
    }

    //跳转到修改投保人信息页面
    public function changePolicy()
    {
        $input = Request::all();
        $policy_id = $input['policy_id'];
        //获取投保人的所有信息
        $policy_message = WarrantyPolicy::where('id',$policy_id)->with('policy_code_type')->first();
        return view('frontend.guests.user.warranty.ChangePolicy',compact('policy_message'));
    }


    //跳转到信息修改页面
    public function changePolicySubmit()
    {
        //获取信息
        $input = Request::all();
        unset($input['_token']);
        $user_id = $this->getId();
        DB::beginTransaction();
        try{
            $policy_id = $input['policy_id'];
            unset($input['policy_id']);
            //修改投保人信息
            $Policy = WarrantyPolicy::find($policy_id);
            $PolicyArray = array(
                'phone'=>$input['phone'],
                'email'=>$input['email'],
            );
            $this->edit($Policy,$PolicyArray);
            //添加到记录表中
            $warranty_id = $Policy->warranty_id;
            $Maintenance = new MaintenanceRecord();
            $change_content = json_encode($PolicyArray);
            $maintenance_array = array(
                'warranty_id'=>$warranty_id,
                'change_content'=>$change_content,
                'warranty_type'=>0,
                'change_type'=>'修改投保人信息',
                'status'=>0,
            );
            $this->add($Maintenance,$maintenance_array);
            DB::commit();
            return redirect('/user/warranty/warranty/5')->with('status','修改成功');
        }catch (Exception $e){
            DB::rollBack();
            return redirect('/user/warranty/warranty/'.$warranty_id)->withErrors('修改失败');
        }



    }










}
