<?php
namespace App\Helper;

use App\Models\WarrantyRecognizee;
use DB;
use Ixudra\Curl\Facades\Curl;
use App\Models\Warranty;
use League\Flysystem\Exception;
use App\Models\WarrantyRule;
use App\Models\ChannelOperate;

class Issue{  //出单接口

protected  $signHelp;
    public function __construct()
    {
        $this->signHelp = new RsaSignHelp();
    }

    public function issue($warranty_rule)
    {
        //获取被保人保单号
        $recognizee = WarrantyRecognizee::where('order_id',$warranty_rule->order_id)->first();
        $biz_content = array(
            'order_code'=>$recognizee->order_code,  //被保人单号
            'union_order_code'=>$warranty_rule->union_order_code,   //联合单号
            'private_p_code'=>$warranty_rule->private_p_code,   //天眼产品码
        );

        //天眼接口参数封装
        $data = $this->signHelp->tySign($biz_content);
        $response = Curl::to(env('TY_API_SERVICE_URL') . '/ins_curl/issue')
            ->returnResponseObject()
            ->withData($data)
            ->withTimeout(60)
            ->post();
//        dd(json_decode($response->content, true));exit;
        $status = $response->status;
        $content = $response->content;
        if($status == 200){
            $result = $this->addWarranty($warranty_rule,$content);
            if($result){
                return $result;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }
    //写一个方法，用来添加保单信息
    public function addWarranty($warranty_rule,$content)
    {
        $content = json_decode($content,true);
        if(empty($content['policy_order_code'])){
            return false;
        }
        DB::beginTransaction();
//        try{//添加到保单表中，添加到关联表中
            $id = $warranty_rule->id;
            $union_order_code = $warranty_rule->union_order_code;
            $WarrantyRule = WarrantyRule::find($id);
            $warranty_res = Warranty::where('warranty_code',$content['policy_order_code'])->first();
            if(empty($warranty_res)){
                //添加保单
                $Warranty = new Warranty();
                $Warranty->warranty_code = $content['policy_order_code'];
                $Warranty->deal_type = 0;  //成交方式，线上成交
                $Warranty->premium= $WarrantyRule->premium;
//                $Warranty->start_time = $content->start_time??'';
//                $Warranty->end_time = $content->end_time??'';
                $Warranty->start_time = $content['start_time']??'';
                $Warranty->end_time = $content['end_time']??'';
                $Warranty->save();
                //中间表关联表单
                $WarrantyRule->warranty_id = $Warranty->id;
                $result = $WarrantyRule->save();
                if($Warranty->id&&$result){
                    DB::commit();
                    return $Warranty->id;
                }else{
                    DB::rollBack();
                    return false;
                }
            }else{
                //更新保单
                $Warranty = new Warranty();
                $Warranty->warranty_code = $content['policy_order_code'];
                $Warranty->deal_type = 0;  //成交方式，线上成交
                $Warranty->premium= $WarrantyRule->premium;
              //$Warranty->start_time = $content->start_time??'';
              //$Warranty->end_time = $content->end_time??'';
                $Warranty->start_time = $content['start_time']??'';
                $Warranty->end_time = $content['end_time']??'';
                $Warranty->update();
                //中间表关联表单
                $WarrantyRule->warranty_id = $warranty_res->id;
                $WarrantyRule_res = $WarrantyRule->update();
                //更新渠道操作表
                $ChannelOperate = new ChannelOperate();
                $ChannelOperate->issue_status = '200';
                $channel_res = $ChannelOperate->update();
                if($WarrantyRule_res||$channel_res){
                    DB::commit();
                    return $warranty_res->id;
                }else{
                    DB::rollBack();
                    return false;
                }
            }
//        }catch (Exception $e){
//            DB::rollBack();
//            return false;
//        }
    }
}



