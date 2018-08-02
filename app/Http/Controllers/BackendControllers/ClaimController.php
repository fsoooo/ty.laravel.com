<?php
/**
 * Created by PhpStorm.
 * User: dell01
 * Date: 2017/4/26
 * Time: 10:27
 */

namespace App\Http\Controllers\BackendControllers;
use App\Models\Order;
use App\Models\SmsInfo;
use App\Helper\MakeSign;
use App\Helper\Ucpaas;
use App\Models\SmsModel;
use App\Helper\Email;
use App\Http\Controllers\backendControllers\BaseController;
use App\Models\Claim;
use App\Models\ClaimRule;
use App\Models\ClaimUrl;
use App\Models\Status;
use Chumper\Zipper\Zipper;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Mockery\CountValidator\Exception;
use Request;
use App\Models\ClaimRecord;
use App\Helper\RsaSignHelp;
use Ixudra\Curl\Facades\Curl;
class ClaimController extends BaseController{
    protected $signHelp;
    protected $status;
    public function __construct()
    {
        $this->signHelp = new RsaSignHelp();

    }
   //显示理赔页面
    public function index()
    {
        return view("backend.claim.index");
    }
    //查看所有的理赔申请
    public function getClaim($type)
    {
        $type = $type;
        if($type != 'all'&&$type != 'deal'&&$type !='no_deal'){
            return back()->withErrors('非法操作');
        }else{
            $claim = $this->getClaimListByType($type);
            $count = count($claim);
            if($type == 'all'){
                return view("backend.claim.index",compact('claim','count','type'));
            }else{
                return view("backend.claim.deal",compact('claim','count','type'));
            }
        }
    }
    //获得理赔的详情
    public function getClaimDetail($claim_id)
    {
        $isMyClaim = $this->checkClaim($claim_id);
        if($isMyClaim){
            //获得查询的id值
            //获得理赔的详细信息,保单的信息，
            $detail = Claim::where('id',$claim_id)
                ->with('claim_claim_rule','claim_claim_rule.user','claim_claim_rule.order','claim_status')
                ->first();
            return view('backend.claim.detail',compact('detail'));
        }else{
            return back()->withErrors('非法操作');
        }
    }
    //获得操作记录
    public function getRecord($cid)
    {
        $cid = $cid;
        //查找操作记录
        $record = DB::table('claim_record')
            ->where('claim_id',$cid)
            ->orderBy('created_at','desc')
            ->paginate(config('list_num.backend.claim'));
        $count = count($record);
        return view('backend.claim.record',['record'=>$record,'cid'=>$cid,'count'=>$count]);
    }
    //添加操作记录
    public function addRecord()
    {
        $input = Request::all();
        $send_email = $input['send_email'];
        $claim_id = $input['claim_id'];
        $operation_name =  Auth::guard('admin')->user()->name;//获取操作人的名字
        if($send_email){//发送邮件,1，压缩图片，2，进行邮件发送
            //获取理赔的所有图片ddd
            $claim_image = ClaimUrl::where('claim_id',$claim_id)
                ->get();
            $biz_content['title'] = '理赔申请';
            $biz_content['content'] = $input['content'];
            $biz_content['email'] = $input['email_url'];
            if(count($claim_image)){
                $image_array = array();
                foreach($claim_image as $value)
                {
                    array_push($image_array,$value->claim_url);
                }
                $zipper = new Zipper();
                //生成一个新的文件夹
                $path = 'upload/backend/claim/img_zip/' . date("Ymd") .'/';
                if (!file_exists(public_path($path))) {
                    mkdir(public_path($path), 666, true);
                }
                $zip_name = $input['union_order_code'].'.zip';
                $result = $zipper->make($path.$zip_name)->add($image_array);
                $image_url = $result->getFilePath();
            }else{
                $image_url = '';
            }
            $biz_content['file'] = $image_url;
            //z调用发送邮件接口
            $email = $input['email_url'];
            $emails = explode("；", $email);
            $title = '理赔申请';
            $content = $input['content'];
            $file = $image_url;
            $mail = new Email();
            $mail->setServer("smtp.exmail.qq.com", "galaxy@mengtiancai.com", "Shiqu521"); //设置smtp服务器
            $mail->setFrom("galaxy@mengtiancai.com"); //设置发件人
            //设置收件人，多个收件人，调用多次
            $mail->setReceiver($emails);
            if(empty($file)){
                $mail->setMailInfo($title,$content);// 设置邮件主题、内容
            }else{
                $mail->setMailInfo($title,$content,$file);// 设置邮件主题、内容、附件
            }
            $success =  $mail->sendMail(); //发送
            if(!$success){
                return back()->withErrors('操作失败，请重试');
            }
        }
        //将记录添加到理赔表中
        DB::beginTransaction();
        try{
            $status_name = Status::find($input['status'])->status_name;//获取理赔名称
            //添加到理赔记录表中
            $ClaimRecord = new ClaimRecord();
            $ClaimRecordArray = array(
                'operation_name'=>$operation_name,   //操作名称
                'claim_remarks'=>$input['remarks'],
                'status_name'=>$status_name,    //理赔备注信息
                'claim_id'=>$claim_id,
            );
            $result = $this->add($ClaimRecord,$ClaimRecordArray);
            //将claim表中的状态修改为新的状态
            $Claim = Claim::find($claim_id);
            $Claim->status = $input['status'];
            $result1 = $Claim->save();
            if($result&&$result1){
                DB::commit();
                $biz_content = array(
                    'operation_name'=>$operation_name,   //操作名称
                    'claim_remarks'=>$input['remarks'],
                    'status_name'=>$status_name,    //理赔备注信息
                    'claim_id'=>$claim_id,
                );
                $sign_help = new RsaSignHelp();
                $data = $sign_help->tySign($biz_content);
                $response = Curl::to(env('TY_API_SERVICE_URL') . '/doupdateclaimstatus')
                    ->returnResponseObject()
                    ->withData($data)
                    ->withTimeout(60)
                    ->post();
                $status = $response->status;
                if($status== '200'){
                    return redirect('/backend/claim/get_record/'.$claim_id)->with('status','添加成功');
                }else{
                    return back()->withErrors('操作失败')->withInput($input);
                }

            }else{
                DB::rollBack();
                return back()->withErrors('操作失败')->withInput($input);
            }
        } catch (Exception $e){
            DB::rollBack();
            return back()->withErrors('操作失败')->withInput($input);
        }
    }
    //跳转到操作页面，并且读取数据
    public function operation($claim_id)
    {
        $isMyClaim = $this->checkClaim($claim_id);
        if($isMyClaim){
            //查找表对应的id值
            $field_id = $this->getFieldId('claim','status');
            if($field_id){
                $status = $this->getStatusByFieldId($field_id);
                if($status){
                    $detail = Claim::where('id',$claim_id)
                        ->with('claim_claim_rule','claim_claim_rule.user','claim_url')
                        ->first();
                    $order_id = $detail->claim_claim_rule->order_id;  //获取订单id,tongguo 订单id查找产品信息
                    $order_detail = Order::where('id',$order_id)
                        ->with('product','warranty_rule')->first();
                    $image_count = count($detail->claim_url);
                    return view('backend.claim.operation',compact('order_detail','status','detail','image_count'));
                }else{
                    return back()->withErrors('错误');
                }
            }else{
                return back()->withErrors('错误');
            }
        }else{
            return back()->withErrors('非法操作');
        }

    }

    //封装一个方法，用来获取不同类型的理赔列表
    public function getClaimListByType($type)
    {
        if($type == 'all'){
            $condition = [];
        }else if($type == 'deal'){
            $condition = [['status', '<>', 0]];
        }else if($type == 'no_deal'){
            $condition = ['status'=> 0];
        }else{
            return false;
        }
//        $result =  DB::table("claim_rule")
//            ->join('claim','claim_rule.claim_id','=','claim.id')
//            ->join('users','claim_rule.user_id','=','users.id')
//            ->leftjoin('status','claim.status','=','status.id')
//            ->where($condition)
//            ->orderBy('claim.created_at','desc')
//            ->select('claim.*','claim_rule.order_id','users.code','users.name','users.real_name','claim_rule.user_id','status.status_name')
//            ->paginate(config('list_num.backend.claim'));
//dd($condition);
        $result = ClaimRule::whereHas('get_claim', function($w) use($condition) {
				$w->where($condition );
			})
			->with('get_claim','user','order','order.product','get_claim.claim_status')
            ->paginate(config('list_num.backend.claim'));

        return $result;
    }
    //封装一个方法，用来判断是否是自己的理赔
    public function checkClaim($claim_id)
    {
        $result = Claim::where('id',$claim_id)->count();
        $result1 = ClaimRule::where('claim_id',$claim_id)->count();
        if($result&&$result1){
            return true;
        }else{
            return false;
        }
    }
    public function updateClaimSubmit(){
        $status = $_GET[0]['status'];
        $claim_id = $_GET[0]['claim_id'];
        Claim::where('id',$claim_id)->update(['statua'=>$status]);
        return (['status' =>'200']);
    }
}