<?php

namespace App\Http\Controllers\BackendControllers;

use App\Models\CancelWarrantyRecord;
use App\Models\MaintenanceInfo;
use App\Models\MaintenanceRecord;
use App\Models\WarrantyRule;
use App\Models\Order;
use App\Models\User;
use App\Models\Warranty;
use Ixudra\Curl\Facades\Curl;
use Request;
use App\Http\Controllers\Controller;
use App\Models\Bank;
use App\Models\Occupation;
use App\Models\Relation;
use App\Models\CardType;
use App\Models\CodeType;
use App\Models\FormInfo;
use App\Helper\RsaSignHelp;
use App\Helper\Email;
use App\Models\EmailInfo;

class MaintenanceController extends BaseController
{
    //保全管理,主页面
    public function index()
    {
        return view('backend.maintenance.index');
    }

    //跳转到资料变更界面
    public function changeData($type)
    {
        if($type == 'user'){
            $order_type = 0;
        }else if($type == 'company'){
            $order_type = 1;
        }
//        //获取所有的资料修改
//        $list = MaintenanceRecord::where('order_type',$order_type)
//            ->with('maintenance_record_order')
//            ->select('order_id')
//            ->distinct()
//            ->paginate(config('list_num.backend.claim'));
        $list = MaintenanceInfo::with('warranty_rule')->get();
        $count = count($list);
        return view('backend.maintenance.ChangeDataList',compact('type','list','count'));
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
    return view('backend.maintenance.changedetails')
        ->with('union_order_code',$union_order_code)
        ->with('save_input',json_decode($input,true))
        ->with('input',json_decode($save_input,true))
        ->with('res',json_decode($res,true))
        ->with('occupation',$occupation)
        ->with('relation',$relation)
        ->with('card_type',$card_type);
}

    //获取某个保单的所有信息变更记录
    public function getChangeData($order_id)
    {
        $order_id = $order_id;
        $list = MaintenanceRecord::where('order_id',$order_id)
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
        return view('backend.maintenance.ChangeDataDetail',compact('list','count','order_detail'));
    }


    //


    //跳转到保额变更界面
    public function changeInsurance($type)
    {
        if($type == 'user'){
            //获取个人的所有保额变更记录
            return view('backend.maintenance.ChangeUserInsurance');
        }else if($type == 'company'){
            return view('backend.maintenance.ChangeCompanyInsurance',compact(''));
        }else{
            return back()->withErrors('非法操作');
        }
    }
    //企业通过时间获取人员变动
    public function getPersonChangeByTime()
    {
        $input = Request::all();
        dd($input);
        $start_time = $input['start_time'];
        $end_time = $input['end_time'];

    }

    //团险人员变更
    public function changePerson()
    {
        $list = MaintenanceRecord::where('change_type','团险加人')
            ->orwhere('change_type','团险减人')
            ->with('maintenance_record_order')
            ->select('order_id')
            ->distinct()
            ->paginate(config('list_num.backend.maintenance'));
        $count = count($list);
        return view('backend.maintenance.ChangePersonList',compact('list','count'));
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
        return view('backend.maintenance.ChangePersonDetail',compact('list','count','order_detail'));
    }

    //同意团险人员变更
    public function agreeChangePerson($change_type,$order_id)
    {
        $order_detail = Order::where('id',$order_id)->first();//获取原订单的详细信息
        dd($order_detail);
        //同意变更，1.天假或者修改数据，2.生成新的订单
        if($change_type == '保额变更')
        {
            //预定修改数据，形成新的订单或者退款
            $Order = new Order();
            $order_array = array(
                'relation_order_id'=>$order_id,
                'user_id'=>$order_detail->user_id,
                'product_id'=>$order_detail->product_id,
                'claim_type'=>$order_detail->claim_type,
                'deal_type'=>$order_detail->deal_type,
                'start_time'=>$order_detail->start_time,
                'end_time'=>$order_detail->end_time,
            );



        }else if($change_type == ''){

        }
    }




    //退保申请
    public function cancel()
    {
        $list = CancelWarrantyRecord::with('cancel_order')->orderBy('created_at','desc')->paginate(config('list_num.backend.claim'));
        $count = count($list);
        return view('backend.maintenance.CancelWarrantyList',compact('list','count'));
    }
    //退保申请详情
    public function cancelDetail($id)
    {
        $cancel_detail = CancelWarrantyRecord::where('id',$id)
            ->with('cancel_order')
            ->first();
        return view('backend.maintenance.CancelDetail',compact('cancel_detail'));
    }

    //保额变更
    public function changePremium()
    {
        //获取所有的保额变更记录
        $premium_list = MaintenanceRecord::with('maintenance_record_order','maintenance_record_order.product','maintenance_record_order.warranty_rule.warranty')
            ->where('change_type','保额变更')
            ->where('status',0)
            ->paginate(config('list_num.backend.maintenance'));
        $count = count($premium_list);
        return view('backend.maintenance.ChangePremiumList',compact('premium_list','count'));
    }
    //修改保额详情
    public function changePremiumDetail($order_id)
    {
        $premium_detail = MaintenanceRecord::where('order_id',$order_id)
            ->where('change_type','保额变更')
            ->get();
        $order_detail = Order::where('id',$order_id)->with('warranty_rule','warranty_rule.warranty_product')->first();
        return view('backend.maintenance.ChangePremiumDetail',compact('order_detail','premium_detail'));
    }

    public function changeDataSubmit($union_order_code){
        $res = MaintenanceInfo::where('union_order_id',$union_order_code)->first();
        $input_res = $res->input;//修改前
        $save_input_res = $res->save_input;//修改后
        $change_input_res = $res->change_input;//变更内容
        $company_res = WarrantyRule::with('warranty_product')->where('union_order_code',$union_order_code)->first();
        $company_email = $company_res->warranty_product->company_email;//保险公司邮箱
        $company_name = $company_res->warranty_product->company_name;//保险公司名称
        $title = '发起保全';
        $content = "<p>尊敬的". $company_name."</p>
                    <p>您好</p>
                    <p>联合订单号为".$union_order_code."的客户需要".$title."</p>               
                    <p>变更内容:".$change_input_res."</p>                
                    <p>发起时间:".date('Y-m-d H:i:s',time())."</p>";
//        $result = $this->sendEmails($company_email,$title,$content);
        $result = true;
        if($result){
            //改变状态
            MaintenanceInfo::where('union_order_id',$union_order_code)->update(['status'=>'201']);
            $biz_content = array('union_order_id'=>$union_order_code,'status'=>'201');
            $sign_help = new RsaSignHelp();
            $data = $sign_help->tySign($biz_content);
            $response = Curl::to(env('TY_API_SERVICE_URL') . '/doupdatemaintenance')
                ->returnResponseObject()
                ->withData($data)
                ->withTimeout(60)
                ->post();
            $status = $response->status;
            if($status=='200'){
                return back()->with('发起成功，等待审核');
            }else{
                return back()->withErrors('提交成功，等待审核！');
            }
        }else{
            return back()->withErrors('提交失败，请重新尝试！');
        }

    }

    //发送邮件
    public function sendEmails($email,$title,$content,$file=null)
    {
        $emails = explode("；", $email);
        if(empty($email)||empty($title)||empty($content)){
            return (['status'=>'1','message'=>'请输入邮件内容！！']);
        }
        $send = env('TY_API_ID');
        if(!empty($file||!is_null($file))){
            $file = $file[0];
        }else{
            $file = '';
        }
        $mail = new Email();
        $mail->setServer("smtp.exmail.qq.com", "galaxy@mengtiancai.com", "Shiqu521"); //设置smtp服务器
        $mail->setFrom("galaxy@mengtiancai.com"); //设置发件人
        $mail->setReceiver($emails);
        if(empty($file)){
            $mail->setMailInfo($title,$content);// 设置邮件主题、内容
        }else{
            $mail->setMailInfo($title,$content,$file);// 设置邮件主题、内容、附件
        }
        $success =  $mail->sendMail(); //发送
        $success = true;
        if($success){
            EmailInfo::insert([
                'send'=>$send,
                'receive'=>$email,
                'title'=>$title,
                'content'=>$content,
                'file'=>$file,
                'created_at'=>date('YmdHis',time()),
                'updated_at'=>date('YmdHis',time())
            ]);
            $url = $_SERVER['HTTP_HOST'];
            $biz_content = array('email'=>$email,'title'=>$title,
                'send'=>$send,'content'=>$content,'file'=>$url.'/'.$file);
            $sign_help = new RsaSignHelp();
            $data = $sign_help->tySign($biz_content);
            $response = Curl::to(env('TY_API_SERVICE_URL') . '/saveemails')
                ->returnResponseObject()
                ->withData($data)
                ->withTimeout(60)
                ->post();
            if($response->status == '200'){
               return true;
            }
        }else{
            return false;
        }
    }

    public function updatePreservationSubmit(){
        $status = $_GET[0]['status'];
        $union_order_code = $_GET[0]['union_order_code'];
        MaintenanceInfo::where('union_order_code',$union_order_code)->update(['statua'=>$status]);
        return (['status' =>'200']);
    }
}
