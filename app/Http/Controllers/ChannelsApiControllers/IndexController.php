<?php

namespace App\Http\Controllers\ChannelsApiControllers;

use App\Models\ChannelPrepareInfo;
use App\Models\Warranty;
use Illuminate\Http\Request;
use App\Helper\DoChannelsSignHelp;
use App\Helper\RsaSignHelp;
use App\Helper\AesEncrypt;
use Ixudra\Curl\Facades\Curl;
use Validator, DB, Image, Schema;
use App\Models\Channel;
use App\Models\ChannelOperate;
use App\Models\UserChannel;
use App\Models\UserChannels;
use App\Models\User;
use App\Models\UserContact;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Session,Cache;
use App\Models\Order;
use App\Models\OrderParameter;
use App\Models\WarrantyPolicy;
use App\Models\WarrantyRecognizee;
use App\Models\WarrantyRule;
use App\Models\OrderBrokerage;
use App\Helper\LogHelper;
use App\Models\Product;
use App\Models\ApiInfo;
use App\Models\Bank;
use App\Models\UserBank;
use App\Models\Competition;
use App\Models\CompanyBrokerage;
use App\Models\OrderPrepareParameter;
use App\Models\ChannelClaimApply;
use App\Models\ChannelInsureInfo;
use App\Helper\Issue;
use App\Helper\UploadFileHelper;
use App\Helper\IdentityCardHelp;
use App\Models\ChannelContract;

class IndexController extends BaseController{

    //初始化
    public function __construct(Request $request)
    {
        $this->sign_help = new DoChannelsSignHelp();
        $this->signhelp = new RsaSignHelp();
        $this->request = $request;
        set_time_limit(0);//永不超时
    }
    //欢迎页面
    public function index(){
        return '<img src="'.config('view_url.view_url').'image/logo.png" style="position:absolute;top:320px;left:710px;">
                    <h1 style="position:absolute;top:350px;left:750px;">天眼互联欢迎您的加入！</h1>';
    }
    //获取授权
    public function getAccount(){
        $all = $this->request->all();
        // LogHelper::logChannelError($all, 'YD_get_account');
        if(!is_array($all)){
            $all = json_decode($all,true);
        }
        if(!isset($all['channel_code'])){
//            return view('frontend.channels.channel_notice')
//                ->with('status','500')
//                ->with('content','请输入渠道唯一标识');
            return json_encode(['status' => '500', 'content' => '请输入渠道唯一标识'],JSON_UNESCAPED_UNICODE);
        }
        if(empty($all['channel_code'])){
//            return view('frontend.channels.channel_notice')
//                ->with('status','500')
//                ->with('content','渠道唯一标识不能为空');
            return json_encode(['status' => '500', 'content' => '渠道唯一标识不能为空'],JSON_UNESCAPED_UNICODE);
        }
        $channel_code_res = Channel::where('code',$all['channel_code'])->first();
        $channel_name_res = Channel::where('name',$all['channel_code'])->first();
        $channel_url_res = Channel::where('url',$all['channel_code'])->first();
        $channel_email_res = Channel::where('email',$all['channel_code'])->first();
        if(is_null($channel_code_res)&&is_null($channel_name_res)&&is_null($channel_url_res)&&is_null($channel_email_res)){
            $biz_content = array('params'=> $this->request->all());
            $sign_help = new RsaSignHelp();
            $data = $sign_help->tySign($biz_content);
            $response = Curl::to(env('TY_API_SERVICE_URL') . '/getchannelinfo')
                ->returnResponseObject()
                ->withData($data)
                ->withTimeout(60)
                ->post();
            $status = $response->status;
            if($status=='200'){
                $contents = json_decode($response->content);
                $status  = $contents->status;
                $content = $contents->content;
                if($status=='200'){
                    $channel_info = $contents->channel_info;
                    $channel_res = Channel::where('id',$channel_info->id)->first();
                    if(is_null($channel_res)){
                        $channel_info = $this->object2array($channel_info);
                        Channel::insert($channel_info);
//                        return view('frontend.channels.channel_notice')
//                            ->with('status','500')
//                            ->with('content',$content);
                        return json_encode(['status' => '500', 'content' => $content],JSON_UNESCAPED_UNICODE);
                    }
                }else{
//                    return view('frontend.channels.channel_notice')
//                        ->with('status','500')
//                        ->with('content','获取渠道信息有误');
                    return json_encode(['status' => '500', 'content' => '获取渠道信息有误'],JSON_UNESCAPED_UNICODE);
                }
            }else{
//                return view('frontend.channels.channel_notice')
//                    ->with('status','500')
//                    ->with('content','获取渠道信息有误');
                return json_encode(['status' => '500', 'content' => '获取渠道信息有误'],JSON_UNESCAPED_UNICODE);
            }
        }else{
            if(!is_null($channel_code_res)){
                $content =[];
                $content['account_id']=$channel_code_res->only_id;
                $content['sign_key']=$channel_code_res->sign_key;
                $content['account']=$channel_code_res->name;
                return view('frontend.channels.channel_notice')
                    ->with('status','200')
                    ->with('content',$content);
//                return json_encode(['status'=>'200','content'=>['account_id'=>$channel_email_res->only_id,'sign_key'=>$channel_email_res->sign_key,'account'=>$channel_email_res->name]],JSON_UNESCAPED_UNICODE);
            }
            if(!is_null($channel_name_res)){
                $content =[];
                $content['account_id']=$channel_code_res->only_id;
                $content['sign_key']=$channel_code_res->sign_key;
                $content['account']=$channel_code_res->name;
                return view('frontend.channels.channel_notice')
                    ->with('status','200')
                    ->with('content',$content);
                //                return json_encode(['status'=>'200','content'=>['account_id'=>$channel_email_res->only_id,'sign_key'=>$channel_email_res->sign_key,'account'=>$channel_email_res->name]],JSON_UNESCAPED_UNICODE);
            }
            if(!is_null($channel_url_res)){
                $content =[];
                $content['account_id']=$channel_code_res->only_id;
                $content['sign_key']=$channel_code_res->sign_key;
                $content['account']=$channel_code_res->name;
                return view('frontend.channels.channel_notice')
                    ->with('status','200')
                    ->with('content',$content);
                //                return json_encode(['status'=>'200','content'=>['account_id'=>$channel_email_res->only_id,'sign_key'=>$channel_email_res->sign_key,'account'=>$channel_email_res->name]],JSON_UNESCAPED_UNICODE);
            }
            if(!is_null($channel_email_res)){
                $content =[];
                $content['account_id']=$channel_code_res->only_id;
                $content['sign_key']=$channel_code_res->sign_key;
                $content['account']=$channel_code_res->name;
                return view('frontend.channels.channel_notice')
                    ->with('status','200')
                    ->with('content',$content);
                //                return json_encode(['status'=>'200','content'=>['account_id'=>$channel_email_res->only_id,'sign_key'=>$channel_email_res->sign_key,'account'=>$channel_email_res->name]],JSON_UNESCAPED_UNICODE);
            }
        }
    }
    //获取访问令牌access_token
    public function getAccess(){
        //解签得到渠道传过来的参数
        $params = $this->request->all();
        // LogHelper::logChannelError($params, 'YD_get_token');
        if(!is_array($params)){
            $params = json_decode($params,true);
        }
        if(!isset($params['account_id'])){
            return json_encode(['status' => '500', 'content' => '请输入渠道获取的账户ID'],JSON_UNESCAPED_UNICODE);
        }
        if(empty($params['account_id'])){
            return json_encode(['status' => '500', 'content' => '渠道账户ID不能为空'],JSON_UNESCAPED_UNICODE);
        }
        // $channel_info_res = Channel::where('only_id',$params['account_id'])->first();
		$channel_email_res = [];
        $biz_content = $params['biz_content'];
        $channel_account_id = $params['account_id'];
        $biz_content = base64_decode(str_replace(" ","+",$biz_content));
        $biz_content = json_decode($biz_content);
        if(empty($biz_content)){
            return json_encode(['status' => '500', 'content' => '参数不能为空'],JSON_UNESCAPED_UNICODE);
        }
        if(!is_array($biz_content)&&is_object($biz_content)){
            $biz_content =  $this->object2array($biz_content);
        }
        // //验证token，如果没有失效，返回旧token
        //        $last_token = \Cache::get($biz_content['channel_user_code'].'access_token');
        //            if(!is_null($last_token)){
        //                return  (['status'=>'200','content'=>['access_token'=>$last_token]]);
        //            }
        //验证身份，然后生成access_token（包含身份信息和时间戳以及有效期）
        // if(!empty($channel_info_res)){
            $data = [
                'channel_code'=>$biz_content['channel_code'],
                'account_id'=>$channel_account_id,
                'person_code'=>$biz_content['channel_user_code'],
                'person_phone'=>$biz_content['channel_user_phone'],
                'timestamp'=>time(),
                'expiry_date'=>3600*8,//一小时有效期
            ];
            $sign_help = new RsaSignHelp();
            $access_token = $sign_help->base64url_encode(json_encode($data));
            //            $expiresAt = \Carbon\Carbon::now()->addMinutes(60);//60分钟
            //            \Cache::put($biz_content['channel_user_code'].'access_token', $access_token, $expiresAt);
            return  (['status'=>'200','content'=>['access_token'=>$access_token]]);
        // }
    }
    //合作渠道联合登录  todo  判断预投保状态
    public function getParams()
    {
        //验证授权
        $sign_help = new RsaSignHelp();
        //解签得到渠道传过来的参数
        $params = $this->request->all();
        $params = '{"biz_content":"eyJvcGVyYXRlX2NvZGUiOiIiLCJjaGFubmVsX2JhbmtfYWRkcmVzcyI6IiIsImNoYW5uZWxfdXNlcl9uYW1lIjoi5L2V5ZCRIiwiY2hhbm5lbF9iYW5rX3Bob25lIjoiIiwiY291cmllcl9zdGF0ZSI6IiIsImNoYW5uZWxfY29kZSI6IllEIiwicF9jb2RlIjoiIiwiY2hhbm5lbF91c2VyX2VtYWlsIjoiIiwiY2hhbm5lbF91c2VyX2NvZGUiOiI1MTEwMjMxOTkwMDIwMjc4MTAiLCJpc19pbnN1cmUiOiIiLCJjaGFubmVsX3VzZXJfYWRkcmVzcyI6IiIsImNvdXJpZXJfc3RhcnRfdGltZSI6IiIsImNoYW5uZWxfdXNlcl9waG9uZSI6IjE4NTgwMTExNjgxIiwiY2hhbm5lbF9iYW5rX2NvZGUiOiIiLCJjaGFubmVsX2JhY2tfdXJsIjoiIiwiY2hhbm5lbF9iYW5rX25hbWUiOiIiLCJjaGFubmVsX3Byb3ZpbmNlcyI6IiIsImNoYW5uZWxfY2l0eSI6IiIsImNoYW5uZWxfY291bnR5IjoiIn0=","sign":"1e7debfb46b8ec9514020e5f4fc214bd","timestamp":"1516087930","account_id":"1505187019288846"}';
        $params = json_decode($params,true);
        if(!isset($params['biz_content'])){
            return json_encode(['status' => '500', 'content' => '请输入渠道联合登录所需要的参数'],JSON_UNESCAPED_UNICODE);
        }
        if(empty($params['biz_content'])){
            return json_encode(['status' => '500', 'content' => '渠道联合登录所需要的参数不能为空'],JSON_UNESCAPED_UNICODE);
        }
        $channel_account_id = $params['account_id'];
        $biz_content = $params['biz_content'];
        $biz_content = base64_decode(str_replace(" ","+",$biz_content));
        $biz_content = json_decode($biz_content,true);
        $biz_content['word_start'] = date('Y-m-d H:i:s',time());
        $biz_content['is_word'] = '1';//1上工，0没上工
        if(!is_array($biz_content)&&is_object($biz_content)){
            $biz_content =  $this->object2array($biz_content);
        }
        if($biz_content['channel_code']=="91110116MA00CAPM96"){
            return $this->saveDouwanInfo($biz_content);
        }
        if($biz_content['channel_code']=="913101070558512086"){
            return $this->saveDaLingGongInfo($biz_content);
        }
        if($biz_content['channel_code']=="YD"){
            $channel_user_code = $biz_content['channel_user_code'];//身份证号
            $channel_user_phone = $biz_content['channel_user_phone'];//手机号
            $channel_user_name = $biz_content['channel_user_name'];//姓名
            //todo 匹配预投保信息(从预投保信息中筛选此人信息)
            $day = date('Y-m-d',time()-24*3600);//todo 前一天
            $insure_operate = ChannelOperate::where('operate_time',$day)
                ->where('channel_user_code',$biz_content['channel_user_code'])
                ->where('prepare_status','200')
                ->select('channel_user_code')
                ->first();
             if(empty($insure_operate)){//没有预投保信息，就不显示联合登录接口
                 return (['status'=>'500','content'=>'']);
             }
            $is_word = '1';//是否上工
            $word_start = date('Y-m-d H:i:s',time());//上工时间
             //todo 更新投保操作表，插入是否上工和上工时间
            ChannelOperate::where('operate_time',$day)
                ->where('channel_user_code',$biz_content['channel_user_code'])
                ->where('prepare_status','200')
                ->update([
                    'is_work'=>$is_word,//上工1,0未上工
                    'word_start'=>$word_start,//上工时间
                ]);
            //TODO 匹配出没有签约的
            //TODO  匹配出签约过期的
            $channel_contract_res = ChannelContract::where('channel_user_code',$channel_user_code)
                ->where('is_valid',1)//todo 签约协议失败
                ->select('openid','contract_id','contract_expired_time')//openid,签约协议号,签约过期时间
                ->first();
            $contract_expired_time = strtotime($channel_contract_res['contract_expired_time']);
             if(empty($channel_contract_res)){
                 $warranty = false;//没有签约
             }elseif($contract_expired_time<time()) {
                 $warranty = false;//签约已过期
             }else{
                 $warranty = true;//已经签约
             }
//			$warranty=false;
            if(!$warranty){
                //未投保
                $insure_url = 'http://'.$_SERVER['HTTP_HOST'].'/channelsapi/do_insure';
                $api_url = 'http://'.$_SERVER['HTTP_HOST'].'/channelsapi/to_insure';
                return json_encode(['status'=>'200','content'=>['insure_status'=>'0','insure_url'=>$insure_url,'to_insure_url'=>$api_url]],JSON_UNESCAPED_SLASHES);
            }else{
                //已投保
                $insure_url = 'http://'.$_SERVER['HTTP_HOST'].'/channelsapi/do_insure';
                $api_url = 'http://'.$_SERVER['HTTP_HOST'].'/channelsapi/do_insure';
                return json_encode(['status'=>'200','content'=>['insure_status'=>'1','insure_url'=>$insure_url,'to_insure_url'=>$api_url]],JSON_UNESCAPED_SLASHES);
            }
        }
        return json_encode(['status' => '500', 'content' => '请检查渠道标识channel_code是否正确！'],JSON_UNESCAPED_UNICODE);
    }
    //我的保险
    public function doInsure(){
        $access_token = $this->request->header('access-token');
        $access_token_data = json_decode($this->sign_help->base64url_decode($access_token),true);
        $person_code = $access_token_data['person_code'];
        return view('frontend.channels.do_insure')
		->with('person_code',$person_code)
		->render();
    }
    //自动保险设置
    public function insureSeting(){
        $access_token = $this->request->header('access-token');
        $access_token_data = json_decode($this->sign_help->base64url_decode($access_token),true);
        $person_code = $access_token_data['person_code']??"410881199406056514";
        $insure_status = ChannelContract::where('channel_user_code',$person_code)->select('is_auto_pay')->first();
        if(empty($insure_status)){
            $insure_status = '0';
        }else{
            $insure_status = $insure_status['is_auto_pay'];
        }
        //0开通自动投保，1关闭自动投保
        return view('frontend.channels.insure_seting')
            ->with('insure_status',$insure_status)
            ->with('person_code',$person_code);
    }
    //改变自动投保
    public function doInsureSeting(){
        $input = $this->request->all();
        $insure_status = ChannelContract::where('channel_user_code',$input['person_code'])->select('is_auto_pay')->first();
        if(empty($insure_status)){
            return json_encode(['status'=>'401','msg'=>'用户还没有签约！']);
        }
        ChannelContract::where('channel_user_code',$input['person_code'])->update([
            'is_auto_pay'=>$input['insure_status'],
        ]);
        return json_encode(['status'=>'200','msg'=>'OK']);
    }
    //未投保
    public function toInsure(){
		$access_token = $this->request->header('access-token');
        $access_token_data = json_decode($this->sign_help->base64url_decode($access_token),true);
		$person_code =  $access_token_data['person_code'];
		$person_phone =  $access_token_data['person_phone'];
		if(!empty($_SERVER["HTTP_CLIENT_IP"])){
            $cip = $_SERVER["HTTP_CLIENT_IP"];
        }
        elseif(!empty($_SERVER["HTTP_X_FORWARDED_FOR"])){
            $cip = $_SERVER["HTTP_X_FORWARDED_FOR"];
        }
        elseif(!empty($_SERVER["REMOTE_ADDR"])){
            $cip = $_SERVER["REMOTE_ADDR"];
        }
        else{
            $cip = "无法获取！";
        }
        $ip = $cip;
		//查询签约情况
		$contrant_res = ChannelContract::where('channel_user_code',$person_code)->select('contract_expired_time')->first();
		if(!empty($contrant_res)){
			 return view('frontend.channels.to_insure')
                 ->with('url','')
                 ->with('status','0');//已签约
		}
		$channel_res = ChannelOperate::where('channel_user_code',$person_code)
           ->where('prepare_status','200')
           ->where('operate_time',date('Y-m-d',time()-24*3600))
           ->select('proposal_num')
           ->first();
		$channel_user_res = ChannelPrepareInfo::where('channel_user_code',$person_code)
           ->select('channel_user_name')
           ->first();
		$union_order_code = $channel_res['proposal_num']??"000021122201824012275204035";
        $data = [];
        $data['price'] = '2';
        $data['private_p_code'] = 'VGstMTEyMkEwMUcwMQ';
        $data['quote_selected'] = '';
        $data['insurance_attributes'] = '';
        $data['union_order_code'] = $union_order_code;
		$data['pay_account'] = $channel_user_res['channel_user_name'].$person_phone;
        // $data['pay_account'] = '王石磊18732399013';
        $data['clientIp'] = $ip;
        $data = $this->signhelp->tySign($data);
        //发送请求
        $response = Curl::to(env('TY_API_SERVICE_URL') . '/ins_curl/contract_ins')
            ->returnResponseObject()
            ->withData($data)
            ->withTimeout(60)
            ->post();
        //print_r($response);die;
        if($response->status != 200){
            ChannelOperate::where('channel_user_code',$person_code)
                ->where('proposal_num',$union_order_code)
                ->update(['pay_status'=>'500','pay_content'=>$response->content]);
            LogHelper::logError($response->content, 'YD_pay_order_'.$union_order_code);
            $respose =  json_encode(['status'=>'502','content'=>'支付签约失败'],JSON_UNESCAPED_UNICODE);
           return "<script>alert('快递保未生效，重新尝试');window.location.href='bmapp:homepage';</script>";
        }
        $return_data =  json_decode($response->content,true);//签约返回数据
        $url =  $return_data['result_content']['contracturl'];//禁止转义
        return view('frontend.channels.to_insure')
            ->with('url',$url)
            ->with('status','1');//未签约
    }
    //产品详情
    public function getInsInfo(){
        return view('frontend.channels.insure_detail');
    }
    //产品条款
    public function getClause(){
        return view('frontend.channels.insure_clause');
    }
    //投保须知
    public function insureNotice(){
        return view('frontend.channels.insure_notice');
    }
    //自动扣款声明须知
    public function autoPay(){
        return view('frontend.channels.auto_pay');
    }
    //理赔列表
    public function getClaim(){
        return view('frontend.channels.insure_claim');
    }
    //保单列表
    public function getWarranty(){
        $access_token = $this->request->header('access-token');
        $access_token_data = json_decode($this->sign_help->base64url_decode($access_token),true);
        $person_code = $access_token_data['person_code'];
        $issue_res = $this->insureIssue($person_code);//执行出单
        $time = date('Y-m-d',time());
        $channel_operate_res = ChannelOperate::where('channel_user_code',$person_code)
             ->where('issue_status','200')
             ->with('channel_user_info','order','warranty')
             ->get();
		$channel_operate_res = [];
        $warranty_ids = [];
        foreach($channel_operate_res as $value){
            if(!empty($value->warranty->warranty_id)){
                $warranty_ids[] = $value->warranty->warranty_id;
            }
        }
        $warranty_res = Warranty::whereIn('id',$warranty_ids)->get();
		$warranty_res = [];
        return view('frontend.channels.warranty_list')
            ->with('time',$time)
            ->with('res',$warranty_res);
    }
    //保单详情
    public function getWarrantyDetail(){
        $access_token = $this->request->header('access-token');
        $access_token_data = json_decode($this->sign_help->base64url_decode($access_token),true);
       $person_code = $access_token_data['person_code'];
        $time = date('Y-m-d',time());
        $channel_operate_res = ChannelOperate::where('channel_user_code',$person_code)
            ->with('channel_user_info','order','warranty')
            ->first();
        return view('frontend.channels.warranty_detail')
            ->with('time',$time)
            ->with('res',$channel_operate_res);
    }
    //投保操作  todo 定时器任务
    public function insurePay(){
        set_time_limit(0);//永不超时
        $access_token = $this->request->header('access-token');
        $access_token_data = json_decode($this->sign_help->base64url_decode($access_token),true);
        //        $params = $this->request->all();
        //        $biz_content = $params['biz_content'];
        //        $channel_account_id = $params['account_id'];
        //        $biz_content = json_decode(base64_decode($biz_content),true);
        //        $channel_code  = $access_token_data['channel_code'];
        //        $person_code  = $access_token_data['person_code'];
        //        $person_phone  = $access_token_data['person_phone']
        //  程静峰	二代身份证	410822199501120035
        //	储喆	二代身份证	342921199408271616
        //	高立圣	二代身份证	13082419940130051X
        //	倪炀	二代身份证	411524199401210030
        //	聂文瑾	二代身份证	41088119941230078X
        //	任旭东	二代身份证	130185199503121314
        //	史亚文	二代身份证	412723199501151643
        //	王炳村	二代身份证	372325199403042011
        //	王昆伦	二代身份证	132930199405134736
        //	王石磊	二代身份证	410881199406056514
        //	尹路路	二代身份证	130983199209110017
        //	张海宁	二代身份证	130803199412060011
        //	赵永才	二代身份证	410881199601015515
        $channel_code  = 'YD';
        $person_code  = '410822199501120035';
        $person_phone  = '13294032124';
        $channel_res = ChannelPrepareInfo::where('channel_user_code',$person_code)
            ->where('channel_code',$channel_code)
            ->where('channel_user_phone',$person_phone)
            ->first();
        //        dump($channel_res);
        $data = [];
        $insurance_attributes = [];
        $base = [];
        $base['ty_start_date'] = '2017-09-21 12:00:00';
        $toubaoren = [];
        $toubaoren['ty_toubaoren_name'] = '程静峰';
        $toubaoren['ty_toubaoren_id_type'] = '1';//身份证号
        $toubaoren['ty_toubaoren_id_number'] = '410822199501120035';//身份证号
        $toubaoren['ty_toubaoren_birthday'] = substr($toubaoren['ty_toubaoren_id_number'],6,4).'-'.substr($toubaoren['ty_toubaoren_id_number'],10,2).'-'.substr($toubaoren['ty_toubaoren_id_number'],12,2);
        if(substr($toubaoren['ty_toubaoren_id_number'],16,1)%2=='0'){
            $toubaoren['ty_toubaoren_sex'] = '女';
        }else{
            $toubaoren['ty_toubaoren_sex'] = '男';
        }
        $toubaoren['ty_toubaoren_phone'] = '13294032124';
        $toubaoren['ty_toubaoren_email'] = 'wangsl@inschos.com';
        $toubaoren['ty_toubaoren_provinces'] = '110000';
        $toubaoren['ty_toubaoren_city'] = '110000';
        $toubaoren['ty_toubaoren_county'] = '110101';
        $beibaoren = [];
        $beibaoren[0]['ty_beibaoren_name'] = '程静峰';
        $beibaoren[0]['ty_relation'] = '01';
        $beibaoren[0]['ty_beibaoren_id_type'] = '1';
        $beibaoren[0]['ty_beibaoren_id_number'] = '410822199501120035';
        $beibaoren[0]['ty_beibaoren_birthday'] = substr($toubaoren['ty_toubaoren_id_number'],6,4).'-'.substr($toubaoren['ty_toubaoren_id_number'],10,2).'-'.substr($toubaoren['ty_toubaoren_id_number'],12,2);
        if(substr($toubaoren['ty_toubaoren_id_number'],16,1)%2=='0'){
            $beibaoren[0]['ty_beibaoren_sex'] = '女';
        }else{
            $beibaoren[0]['ty_beibaoren_sex'] = '男';
        }
        $beibaoren[0]['ty_beibaoren_phone'] = '13294032124';
        $insurance_attributes['ty_base'] = $base;
        $insurance_attributes['ty_toubaoren'] = $toubaoren;
        $insurance_attributes['ty_beibaoren'] = $beibaoren;
        $data['price'] = '2';
        $data['private_p_code'] = 'VGstMTEyMkEwMUcwMQ';
        $data['quote_selected'] = '';
        $data['insurance_attributes'] = $insurance_attributes;
        $data = $this->signhelp->tySign($data);
        //发送请求
        $response = Curl::to(env('TY_API_SERVICE_URL') . '/ins_curl/buy_ins')
            ->returnResponseObject()
            ->withData($data)
            ->withTimeout(60)
            ->post();
//        print_r($response);die;
        if($response->status != 200){
            ChannelOperate::insert([
                'channel_user_code'=>$person_code,
                'prepare_status'=>'500',
                'prepare_content'=>$response->content,
                'operate_time'=>date('Y-m-d',time()),
                'created_at'=>date('Y-m-d H:i:s',time()),
                'updated_at'=>date('Y-m-d H:i:s',time())
            ]);
            $content = $response->content;
            $respose =  json_encode(['status'=>'501','content'=>'投保出错','msg'=>$content],JSON_UNESCAPED_UNICODE);
            print_r($respose);die;
        }
        $prepare = [];
        $prepare['parameter'] = '0';
        $prepare['private_p_code'] = 'VGstMTEyMkEwMUcwMQ';
        $prepare['ty_product_id'] = 'VGstMTEyMkEwMUcwMQ';
        $prepare['agent_id'] = '0';
        $prepare['ditch_id'] = '0';
        $prepare['user_id'] = '0';
        $prepare['identification'] = '0';
        $prepare['union_order_code'] = '0';
        $return_data = json_decode($response->content, true);
        //todo  本地订单录入
        $add_res = $this->addOrder($return_data, $prepare,$toubaoren);
        if($add_res){
            $respose =  json_encode(['status'=>'200','content'=>'投保完成'],JSON_UNESCAPED_UNICODE);
            print_r($respose);die;
        }else{
            $respose =  json_encode(['status'=>'502','content'=>'投保失败'],JSON_UNESCAPED_UNICODE);
            print_r($respose);die;
        }
    }
    //签约操作
    public function insureSign(){
//        $person_code
        set_time_limit(0);//永不超时
        if(!empty($_SERVER["HTTP_CLIENT_IP"])){
            $cip = $_SERVER["HTTP_CLIENT_IP"];
        }
        elseif(!empty($_SERVER["HTTP_X_FORWARDED_FOR"])){
            $cip = $_SERVER["HTTP_X_FORWARDED_FOR"];
        }
        elseif(!empty($_SERVER["REMOTE_ADDR"])){
            $cip = $_SERVER["REMOTE_ADDR"];
        }
        else{
            $cip = "无法获取！";
        }
        $ip = $cip;
		$person_code = '';
//        $access_token = $this->request->header('access-token');
//        $access_token_data = json_decode($this->sign_help->base64url_decode($access_token),true);
//        $channel_code  = $access_token_data['channel_code']??'YD';
//        $person_code  = $access_token_data['person_code']??'520181197907112113';
//        $person_phone  = $access_token_data['person_phone']??'18185179958';
//        $channel_res = ChannelOperate::where('channel_user_code',$person_code)
//            ->where('prepare_status','200')
//            ->where('operate_time',date('Y-m-d',time()-24*3600))
//            ->with('channel_user_info')
//            ->first();
//        $union_order_code = $channel_res['proposal_num'];
		// 000021122201824012274972514
		// 000021122201824012275009736
		// 000021122201824012275036011
		// 000021122201824012275059643
		// 000021122201824012275080314
		// 000021122201824012275129078
		// 000021122201824012275141030
		// 000021122201824012275153051
		// 000021122201824012275174616
		// 000021122201824012275204035
		// 000021122201824012275934515
		// 000021122201824012275960011
		// 000021122201824012276005017
		// 000021122201824012276259363
        $union_order_code = '000021122201824012275080314';
        $data = [];
        $data['price'] = '2';
        $data['private_p_code'] = 'VGstMTEyMkEwMUcwMQ';
        $data['quote_selected'] = '';
        $data['insurance_attributes'] = '';
        $data['union_order_code'] = $union_order_code;
//        $data['pay_account'] = $channel_res['channel_user_info']['channel_user_name'].$channel_res['channel_user_info']['channel_user_phone'];
        $data['pay_account'] = '王石磊18732399013';
        $data['clientIp'] = '222.131.24.108';
        $data = $this->signhelp->tySign($data);
        //发送请求
        $response = Curl::to(env('TY_API_SERVICE_URL') . '/ins_curl/contract_ins')
            ->returnResponseObject()
            ->withData($data)
            ->withTimeout(60)
            ->post();
        // print_r($response);die;
        if($response->status != 200){
            ChannelOperate::where('channel_user_code',$person_code)
                ->where('proposal_num',$union_order_code)
                ->update(['pay_status'=>'500','pay_content'=>$response->content]);
            LogHelper::logError($response->content, 'YD_pay_order_'.$union_order_code);
            $respose =  json_encode(['status'=>'502','content'=>'支付签约失败'],JSON_UNESCAPED_UNICODE);
            return false;
        }
        $return_data =  json_decode($response->content,true);//签约返回数据
        $url =  $return_data['result_content']['contracturl'];//禁止转义
        return view('frontend.channels.test_url')->with('url',$url);
    }
    //签约回调  TODO  签约回调
    public function contractCallBack(){
        $input = $this->request->all();
        LogHelper::logChannelSuccess($input, 'contractCallBack');
        $contract_code = $input['contract_code'];
        $union_order_code = substr($contract_code,0,-8);
		$channel_res = ChannelOperate::where('proposal_num',$union_order_code)->select('channel_user_code')->first();
        $channel_user_code = $channel_res['channel_user_code'];
        $channel_contract_res = ChannelContract::where('channel_user_code',$channel_user_code)
            ->where('is_valid',0)//TODO 签约是正常的
            ->select('openid','contract_id','contract_expired_time')//openid,签约协议号,签约过期时间
            ->first();
        $contract_expired_time = strtotime($channel_contract_res['contract_expired_time']);
        if(empty($channel_contract_res)){//没签约
            $channel_contract = new ChannelContract();
            $channel_contract->operate_time = $input['operate_time'];
            $channel_contract->request_serial = $input['request_serial'];
            $channel_contract->contract_expired_time = $input['contract_expired_time'];
            $channel_contract->contract_id = $input['contract_id'];
            $channel_contract->change_type = $input['change_type'];
            $channel_contract->contract_code = $input['contract_code'];
            $channel_contract->openid = $input['openid'];
            $channel_contract->channel_user_code = $channel_user_code;
            $channel_contract->save();
        }elseif($contract_expired_time<time()) {//签约已过期
            ChannelContract::where('channel_user_code',$channel_user_code)->delete();
            $channel_contract = new ChannelContract();
            $channel_contract->operate_time = $input['operate_time'];
            $channel_contract->request_serial = $input['request_serial'];
            $channel_contract->contract_expired_time = $input['contract_expired_time'];
            $channel_contract->contract_id = $input['contract_id'];
            $channel_contract->change_type = $input['change_type'];
            $channel_contract->contract_code = $input['contract_code'];
            $channel_contract->openid = $input['openid'];
            $channel_contract->channel_user_code = $channel_user_code;
            $channel_contract->save();
        }
        return json_encode(['status'=>'200','msg'=>'回调成功']);
    }
    //微信代扣支付
    public function insureWechatPay(){
        set_time_limit(0);//永不超时
        $access_token = $this->request->header('access-token');
        $access_token_data = json_decode($this->sign_help->base64url_decode($access_token),true);
        $channel_code  = $access_token_data['channel_code'];
        $person_code  = $access_token_data['person_code'];
        $person_phone  = $access_token_data['person_phone'];
        $channel_contract_info = ChannelContract::where('channel_user_code',$person_code)->select(['openid','contract_id'])->first();      
        $channel_res = ChannelOperate::where('channel_user_code',$person_code)
            ->where('prepare_status','200')
            ->where('operate_time',date('Y-m-d',time()-24*3600))
			->select('proposal_num')
            ->first();
		$union_order_code = $channel_res['proposal_num'];
        $data = [];
        $data['price'] = '2';
        $data['private_p_code'] = 'VGstMTEyMkEwMUcwMQ';
        $data['quote_selected'] = '';
        $data['insurance_attributes'] = '';
        $data['union_order_code'] = $union_order_code;
        $data['pay_account'] = $channel_contract_info['openid']??"oalT50N9lxHbWhGBDTF3FMCYhTx8";
        $data['contract_id'] = $channel_contract_info['contract_id']??"201801050468783068";
        $data = $this->signhelp->tySign($data);
        //发送请求
        $response = Curl::to(env('TY_API_SERVICE_URL') . '/ins_curl/wechat_pay_ins')
            ->returnResponseObject()
            ->withData($data)
            ->withTimeout(60)
            ->post();
		// print_r($response);die;
        if($response->status != 200){
            ChannelOperate::where('channel_user_code',$person_code)
                ->where('proposal_num',$union_order_code)
                ->update(['pay_status'=>'500','pay_content'=>$response->content]);
			 return redirect('/channelsapi/to_insure')->with('status','支付失败');
        }
        $return_data =  json_decode($response->content,true);//返回数据
        // LogHelper::logChannelSuccess($return_data, 'pay_return_data');
        //TODO  可以改变订单表的状态
        ChannelOperate::where('channel_user_code',$person_code)
            ->where('proposal_num',$union_order_code)
            ->update(['pay_status'=>'200']);
        WarrantyRule::where('union_order_code',$union_order_code)
            ->update(['status'=>'1']);
        Order::where('order_code',$union_order_code)
            ->update(['status'=>'1']);
        $respose =  json_encode(['status'=>'200','content'=>'支付成功'],JSON_UNESCAPED_UNICODE);
        return redirect('/channelsapi/do_insure')->with('status','支付成功');
    }
    //对象转化数组
    function object2array($object) {
        if (is_object($object)) {
            foreach ($object as $key => $value) {
                $array[$key] = $value;
            }
        }
        else {
            $array = $object;
        }
        return $array;
    }
    //添加投保返回信息
    protected function addOrder($return_data, $prepare, $policy_res)
    {
        try{
            //查询是否在竞赛方案中
            $private_p_code = $prepare['private_p_code'];
            $is_settlement = 0;
            $competition_id = 0;
            $ditch_id = $prepare['ditch_id'];
            $agent_id = $prepare['agent_id'];
            //订单信息录入

            foreach ($return_data['order_list'] as $order_value){
                $order = new Order();
                $order->order_code = $order_value['union_order_code']; //订单编号
                $order->user_id = isset($_COOKIE['user_id'])?$_COOKIE['user_id']:' ';//用户id
                $order->agent_id = $agent_id;
                $order->competition_id = $competition_id;//竞赛方案id，没有则为0
                $order->private_p_code = $private_p_code;
                $order->ty_product_id = $prepare['ty_product_id'];
                $order->start_time = isset($order_value['start_time'])?$order_value['start_time']: ' ';
                $order->claim_type = 'online';
                $order->deal_type = 0;
                $order->is_settlement = $is_settlement;
                $order->premium = $order_value['premium'];
                $order->status = config('attribute_status.order.unpayed');
                $order->pay_way = json_encode($return_data['pay_way']);
                $order->save();
            }
            //投保人信息录入
            $warrantyPolicy = new WarrantyPolicy();
            $warrantyPolicy->name = isset($policy_res['ty_toubaoren_name'])?$policy_res['ty_toubaoren_name']:'';
            $warrantyPolicy->card_type = isset($policy_res['ty_toubaoren_id_type'])?$policy_res['ty_toubaoren_id_type']:'';
            $warrantyPolicy->occupation = isset($policy_res['ty_toubaoren_occupation'])?$policy_res['ty_toubaoren_occupation']:'';  //投保人职业？？
            $warrantyPolicy->code = isset($policy_res['ty_toubaoren_id_number'])?$policy_res['ty_toubaoren_id_number']:'';
            $warrantyPolicy->phone =  isset($policy_res['ty_toubaoren_phone'])?$policy_res['ty_toubaoren_phone']:'';
            $warrantyPolicy->email =  isset($policy_res['ty_toubaoren_email'])?$policy_res['ty_toubaoren_email']:'';
            $warrantyPolicy->area =  isset($policy_res['ty_toubaoren_area'])?$policy_res['ty_toubaoren_area']:'';
            $warrantyPolicy->status = config('attribute_status.order.check_ing');
            $warrantyPolicy->save();
            //被保人信息录入
            foreach ($return_data['order_list'] as $recognizee_value){
                $warrantyRecognizee = new WarrantyRecognizee();
                $warrantyRecognizee->name = $recognizee_value['name'];
                $warrantyRecognizee->order_id = $order->id;
                $warrantyRecognizee->order_code = $recognizee_value['out_order_no'];
                $warrantyRecognizee->relation = $recognizee_value['relation'];
                $warrantyRecognizee->occupation =isset($recognizee_value['occupation'])?$recognizee_value['occupation']: ' ';
                $warrantyRecognizee->card_type = isset($recognizee_value['card_type'])?$recognizee_value['card_type']: ' ';
                $warrantyRecognizee->code = isset($recognizee_value['card_id'])?$recognizee_value['card_id']: ' ';
                $warrantyRecognizee->phone = isset($recognizee_value['phone'])?$recognizee_value['phone']: ' ';
                $warrantyRecognizee->email = isset($recognizee_value['email'])?$recognizee_value['email']: ' ';
                $warrantyRecognizee->start_time = isset($recognizee_value['start_time'])?$recognizee_value['start_time']: ' ';
                $warrantyRecognizee->end_time = isset($recognizee_value['end_time'])?$recognizee_value['end_time']: ' ';
                $warrantyRecognizee->status = config('attribute_status.order.unpayed');
                $warrantyRecognizee->save();
            }
            //添加投保参数到参数表
            $orderParameter = new OrderParameter();
            $orderParameter->parameter = $prepare['parameter'];
            $orderParameter->order_id = $order->id;
            $orderParameter->ty_product_id = $order->ty_product_id;
            $orderParameter->private_p_code = $private_p_code;
            $orderParameter->save();
            //添加到关联表记录
            $WarrantyRule = new WarrantyRule();
            $WarrantyRule->agent_id = $agent_id;
            $WarrantyRule->ditch_id = $ditch_id;
            $WarrantyRule->order_id = $order->id;
            $WarrantyRule->ty_product_id = $order->ty_product_id;
            $WarrantyRule->premium = $order->premium;
            $WarrantyRule->union_order_code = $return_data['union_order_code'];//总订单号
            $WarrantyRule->parameter_id = $orderParameter->id;
            $WarrantyRule->policy_id = $warrantyPolicy->id;
            $WarrantyRule->private_p_code = $private_p_code;   //预留
            $WarrantyRule->save();
            //添加到渠道用户操作表
            $ChannelOperate = new ChannelOperate();
            $ChannelOperate->channel_user_code = $policy_res['ty_toubaoren_id_number'];
            $ChannelOperate->order_id = $order->id;
            $ChannelOperate->proposal_num = $return_data['union_order_code'];
            $ChannelOperate->prepare_status = '200';
            $ChannelOperate->operate_time = date('Y-m-d',time());
            $ChannelOperate->save();
            DB::commit();
            return true;
        }catch (\Exception $e)
        {
            DB::rollBack();
            LogHelper::logChannelError([$return_data, $prepare], $e->getMessage(), 'addOrder');
            return false;
        }
    }
    //todo APP触发支付
    public function doInsurePay(){
//        $access_token = $this->request->header('access-token');
//        $access_token_data = json_decode($this->sign_help->base64url_decode($access_token),true);
//        $params = $this->request->all();
//        $biz_content = $params['biz_content'];
//        $biz_content = json_decode(base64_decode($biz_content),true);
//        $channel_code  = $access_token_data['channel_code'];
//        $person_code  = $access_token_data['person_code'];
//        $person_phone  = $access_token_data['person_phone'];
//        $channel_code = isset($channel_code) ??  'YD';
//        $person_code = isset($person_code) ?? '410881199406056514';
//        $person_phone = isset($person_phone) ??  '15701681524';
//        $channel_prepare_res = ChannelPrepareInfo::where('channel_user_code','410881199406056514')
//            ->where('operate_time',date('Y-m-d',time()))
//            ->first();
//        $channel_operete_res = ChannelOperate::where('channel_user_code','410881199406056514')
//            ->where('operate_time',date('Y-m-d',time()))
//            ->first();
//        if(empty($channel_operete_res)){
//            LogHelper::logChannelError($channel_operete_res, 'YD_pay_order_'.$person_code);
//            $return_data =  $respose =  json_encode(['status'=>'502','content'=>'没有找到订单信息！'],JSON_UNESCAPED_UNICODE);
//            return $return_data;
//        }
//        $proposal_num = $channel_operete_res->proposal_num;
        $proposal_num = '000021122201724002103727035';
        $person_code = '410822199501120035';
        $biz_content = [];
        $biz_content['proposal_num'] = $proposal_num;
        $biz_content['person_code'] = $person_code;
        \Redis::rPush("insure_data",json_encode($biz_content));//入队操作
        $count = \Redis::Llen('insure_data');
        for($i=0;$i<$count;$i++) {
            $insure_data = json_decode(\Redis::lpop('insure_data'),true);//出队
            $pay_url = $this->payInsure($insure_data);
            return $pay_url;
        }
    }
    //支付操作（封装方法）
    public function payInsure($insure_data){
        $proposal_num = $insure_data['proposal_num'];
        $person_code = $insure_data['person_code'];
        $data = [];
        $data['unionOrderCode'] = $proposal_num;
        $data['private_p_code'] = 'VGstMTEyMkEwMUcwMQ';
        $data['premium'] = '2';
        $datas = $this->signhelp->tySign($data);
        //发送请求
        $response = Curl::to(env('TY_API_SERVICE_URL') . '/ins_curl/pay_ins')
            ->returnResponseObject()
            ->withData($datas)
            ->withTimeout(60)
            ->post();
//        print_r($response);die;
        if($response->status != 200){
            ChannelOperate::where('channel_user_code',$person_code)
                ->where('proposal_num',$proposal_num)
                ->update(['pay_status'=>'500','pay_content'=>$response->content]);
            // LogHelper::logChannelError($response->content, 'YD_pay_order_'.$proposal_num);
            $respose =  json_encode(['status'=>'502','content'=>'支付失败'],JSON_UNESCAPED_UNICODE);
            return $respose;
        }
        // LogHelper::logChannelSuccess($response->content, 'YD_pay_order_'.$proposal_num);
        ChannelOperate::where('channel_user_code',$person_code)
            ->where('proposal_num',$proposal_num)
            ->update(['pay_status'=>'200']);
        WarrantyRule::where('union_order_code',$proposal_num)
            ->update(['status'=>'1']);
        Order::where('order_code',$proposal_num)
            ->update(['status'=>'1']);
        $pay_url =  json_decode($response->content,true)['payUrl'];//支付链接
        return $pay_url;
    }
    //todo 轮询出单
    public function insureIssue($person_code){
        $channel_operate_res = ChannelOperate::where('channel_user_code',$person_code)
            ->where('operate_time',date('Y-m-d',time()))
			->select('proposal_num')
            ->first();
        if(empty($channel_operate_res)){
            return false;
        }
        $union_order_code = $channel_operate_res['proposal_num'];
        \Redis::rPush("issue_data",json_encode($union_order_code));//入队操作
        $count = \Redis::Llen('issue_data');
        for($i=0;$i<$count;$i++) {+
            $insure_data = json_decode(\Redis::lpop('issue_data'),true);//出队
            $issue_status = $this->doInsureIssue($insure_data);
            if(!$issue_status){
                LogHelper::logChannelError($insure_data, 'YD_TK_Insure_issue_'.$insure_data);//记录日志
            }
        }
    }
    //出单操作
    public function doInsureIssue($union_order_code){
        $warranty_rule = WarrantyRule::where('union_order_code', $union_order_code)->first();
        $i = new Issue();
        $result = $i->issue($warranty_rule);
        if(!$result){
            $respose =  json_encode(['status'=>'503','content'=>'出单失败'],JSON_UNESCAPED_UNICODE);
            return false;
        }
        ChannelOperate::where('proposal_num',$union_order_code)
            ->update(['issue_status'=>'200']);
        $respose =  json_encode(['status'=>'200','content'=>'出单完成'],JSON_UNESCAPED_UNICODE);
            return true;
    }
    //理赔选择
    public function toClaim(){
        $access_token = $this->request->header('access-token');
		$access_token_data = json_decode($this->sign_help->base64url_decode($access_token),true);
        $person_code = $access_token_data['person_code'];
        $time = date('Y-m-d',time()-3600*48);
        //最近三天内可理赔的保单详情
        $channel_operate_res = ChannelOperate::where('channel_user_code',$person_code)
            ->where('operate_time','>=',$time)
            ->where('issue_status','200')
            ->with('warranty')
            ->get();
        $warranty_ids = [];
        foreach($channel_operate_res as $value){
            if(!empty($value->warranty->warranty_id)){
                $warranty_ids[] = $value->warranty->warranty_id;
            }
        }
		$warranty_ids = [];
        $warranty_res = Warranty::whereIn('id',$warranty_ids)->get();
        return view('frontend.channels.to_claim')
            ->with('res',$warranty_res)
            ->with('person_code',$person_code);
    }
    //自助理赔服务须知
    public function claimNotice($warranty_code){
        return view('frontend.channels.claim_notice')->with('warranty_code',$warranty_code);
    }
    //理赔操作指引
    public function claimApplyGuide(){
        return view('frontend.channels.claim_guide');
    }
    //理赔指引详情
    public function claimApplyGuideIndex(){
        return view('frontend.channels.claim_guide_index');
    }
    //理赔适用范围
    public function claimApplyRange(){
        return view('frontend.channels.claim_apply_range');
    }
    //理赔应备材料
    public function claimApplyInfo(){
        return view('frontend.channels.claim_apply_info');
    }
    //理赔申请书接受方式
    public function claimApplyWay(){
        return view('frontend.channels.claim_apply_way');
    }
    //理赔第一步：填写出险人信息 todo 报案
    public function claimStep1($warranty_code){
        $data = $this->getClaimCommon($warranty_code);
        $member = $this->getInsurantInfo($data);
        $address = $this->getAreaInfo($data);
        $user_info = $this->getMemberInfo($data);
//                dump($address);
//                dump($member);
//                dump($user_info);
//                die;
        if(json_decode($address,true)){
            $address  = json_decode($address,true);
        }else{
            return back()->with('status','获取初始化地区信息出错！');
        }
        if(json_decode($member,true)){
            $member  = json_decode($member,true);
        }else{
            return back()->with('status','获取投保人信息出错！');
        }
        if(json_decode($user_info,true)){
            $user_info  = json_decode($user_info,true);
        }else{
            return back()->with('status','获取会员信息出错！');
        }
//                dump($address);
//                dump($member);
//                dump($user_info);
//                die;
        if(empty($address)&&empty($member)&&empty($user_info)){
            // LogHelper::logChannelError($member, 'YD_TK_get_init_member');
            // LogHelper::logChannelError($address, 'YD_TK_get_init_area');
            // LogHelper::logChannelError($address, 'YD_TK_get_init_user_info');
            $result =  json_encode(['status'=>'501','content'=>'初始化出错'],JSON_UNESCAPED_UNICODE);
            return $result;
        }
        ChannelOperate::where('proposal_num',$data['union_order_code'])->update(['init_status'=>'200','init_content'=>json_encode($member)]);
        return view('frontend.channels.claim_step1')
            ->with('area',$address)
            ->with('member',$member)
            ->with('user_info',$user_info)
            ->with('warranty_code',$warranty_code);
    }
    //处理第一步：报案处理
    public function doClaimStep1(){
        $input = $this->request->all();
        $data = $this->getClaimCommon($input['warranty_code']);
        $datas = $this->signhelp->tySign($input);
        $response = Curl::to(env('TY_API_SERVICE_URL') .'/claim/save_case_info')
            ->returnResponseObject()
            ->withData($datas)
            ->withTimeout(60)
            ->post();
        LogHelper::logChannelError($response, 'YD_TK_sms');
//        print_r($response);die;
        if($response->status != 200){
            $content = $response->content;
            LogHelper::logChannelError($content, 'YD_TK_claim_step1');
            $respose =  json_encode(['status'=>'501','content'=>'出险人信息提交失败'],JSON_UNESCAPED_UNICODE);
            print_r($respose);
            return back()->with('status','出险人信息提交失败');
        }
        ChannelClaimApply::insert([
            'union_order_code'=>$data['union_order_code'],
            'channel_user_code'=>$data['channel_user_code'],
            'warranty_code'=>$input['warranty_code'],
            'user_report_info'=>json_encode($input),
            'user_report_status'=>'200',
            'user_report_content'=>$response->content,
            'claim_start_time'=>date('Y-m-d',time()),
            'claim_start_status'=>'200'
        ]);
        return redirect('/channelsapi/claim_step2/'.$input['warranty_code'])->with('status','用户信息提交成功');
    }
    //理赔第二步：填写收款人账户信息
    public function claimStep2($warranty_code){
        $data = $this->getClaimCommon($warranty_code);
        $res = $this->getCliamSaveInfo($data);
        return view('frontend.channels.claim_step2')
            ->with('res',$res)
            ->with('data',$data)
            ->with('warranty_code',$warranty_code);
    }
    //理赔第三步：上传身份证件信息
    public function claimStep3(){
        $input = $this->request->all();
        $data = $this->getClaimCommon($input['warranty_code']);
        if(isset($input['bank_info_file'])){
            if(is_string($input['bank_info_file'])){
                $image_path =$input['bank_info_file'];
            }else{
                $path = 'upload/channel/claim_post/' . date("Ymd") .'/';
                $image_path = UploadFileHelper::uploadImage($input['bank_info_file'], $path);//理赔上传图片路径（存数据库）
            }
        }
        ChannelClaimApply::where(  'warranty_code',$data['ins_policy_code'])
            -> where( 'union_order_code',$data['union_order_code'])
            ->update(['bank_files'=>json_encode($image_path)]);
        return view('frontend.channels.claim_step3')
            ->with('data',$data)
            ->with('bank_info',$input['bank_info']);
    }
    //理赔第四步：上传理赔资料
    public function claimStep4(){
        set_time_limit(0);//永不超时
        $input = $this->request->all();
        $data = $this->getClaimCommon($input['warranty_code']);
        $claim_id = $this->getCliamId($data);
        $claim_save_info = $this->getCliamSaveInfo($data);
        $data['claim_id'] = $claim_id;
        $data['sign'] = $claim_save_info['claim_sign']??$claim_save_info['sign'];
        $claim_flug = $claim_save_info['bank_flag'];
        if($claim_flug=='TKC'){//人伤
            $doc_res = $this->claimGetTKCDocType($data);
            $doc_res = is_array(json_decode($doc_res,true)) ? json_decode($doc_res,true) : $doc_res;
            $doc_desc_res = [];
            foreach($doc_res as $value){
                $doc_desc_res[] = $value['desc'];
            }
            $doc_res = $doc_desc_res;
        }elseif($claim_flug=='TKA'){//财产
            $doc_res = $this->claimGetTKAUploadDesc($data);
            $doc_res = is_array(explode('、',$doc_res)) ? explode('、',$doc_res) :$doc_res;
        }
        $image_paths = [];
        if(isset($input['cid_file'])){
            foreach ($input['cid_file'] as $key=>$value){
                if(is_string($value)){
                    $image_path = $value;
                }else{
                    $path = 'upload/channel/claim_post/' . date("Ymd") .'/';
                    $image_path = UploadFileHelper::uploadImage($value, $path);//理赔上传图片路径（存数据库）
                }
                $image_paths[$key] = $image_path;
            }
        }
        ChannelClaimApply::where('warranty_code',$data['ins_policy_code'])
            ->update([
                'cid_files'=>json_encode($image_paths),
            ]);
        $cid_info = [];
        $cid_info['cid1'] = $input['cid1'];
        $cid_info['cid2'] = $input['cid2'];
        return view('frontend.channels.claim_step4')
            ->with('data',$data)
            ->with('doc_res',$doc_res)
            ->with('cid_info',$cid_info)
            ->with('bank_info',$input['bank_info']);
    }
    //处理第四步，理赔材料保存接口
    public function doClaimStep4(){
        set_time_limit(0);//永不超时
        $input = $this->request->all();
        $data = $this->getClaimCommon($input['warranty_code']);//获取通用信息
        $claim_id = $this->getCliamId($data);//获取报案号
        $claim_save_info = $this->getCliamSaveInfo($data);//获取报案返回信息
        $member_info = $this->getMemberInfo($data);//获取会员信息
        $data['claim_id'] = $claim_id;
        $data['sign'] = $claim_save_info['claim_sign']??$claim_save_info['sign'];
        if(json_decode($member_info,true)){
            $member_info  = json_decode($member_info,true);
        }else{
            return back()->with('status','获取信息出错！');
        }
        $claim_apply_info = isset($input['claim_apply_info'])?$input['claim_apply_info']:[];
        $start_time_info = isset($input['start_time_info'])?$input['start_time_info']:[];
        $compensation_agreement_info = isset($input['compensation_agreement_info'])?$input['compensation_agreement_info']:[];
        $sick_record_info = isset($input['sick_record_info'])?$input['sick_record_info']:[];
        $invoice_info = isset($input['invoice_info'])?$input['invoice_info']:[];
        $traffic_police_info = isset($input['traffic_police_info'])?$input['traffic_police_info']:[];
        $accident_scene_info = isset($input['accident_scene_info'])?$input['accident_scene_info']:[];
        $delegation_info = isset($input['delegation_info'])?$input['delegation_info']:[];
        $app_screenshot_info = isset($input['app_screenshot_info'])?$input['app_screenshot_info']:[];
        $end_time_info = isset($input['end_time_info'])?$input['end_time_info']:[];
        $cid1_info = [json_decode($input['cid_file'],true)['cid1']];
        $cid2_info = [json_decode($input['cid_file'],true)['cid2']];
        $bank_info = [$input['bank_info']];
        //上传图片参数
        $data['function_code'] = 'addBase64';
        $data['claim_id'] = $claim_id;
        $data['coop_id'] = $member_info['member_id'];
        $data['sign'] =  $claim_save_info['sign'];
        $data['claim_flag'] = $claim_save_info['bank_flag'];
        //调用上传方法
        $cid1_res = $this->getImgUpload($cid1_info,$data,'cid1');//证件正面
        $cid2_res = $this->getImgUpload($cid2_info,$data,'cid2');//证件反面
        $bank_res = $this->getImgUpload($bank_info,$data,'bank');//银行卡信息
        $image_upload_path = [];
        $image_upload_code = [];
        $image_upload_base64 = [];
        if(!empty($claim_apply_info)){
            $image_upload_code['claim_apply'] = $this->getImgUpload($claim_apply_info,$data,'claim_apply');//理赔申请书
            $image_upload_path['claim_apply'] = $this->getImgPath($input,'claim_apply');//理赔申请书
            $image_upload_base64['claim_apply'] = $claim_apply_info;
        }
        if(!empty($start_time_info)){
            $image_upload_code['start_time'] = $this->getImgUpload($start_time_info,$data,'start_time');//分拣开始
            $image_upload_path['start_time'] = $this->getImgPath($input,'start_time');//分拣开始
            $image_upload_base64['start_time'] = $start_time_info;
        }
        if(!empty($compensation_agreement_info)){
            $image_upload_code['compensation_agreement'] = $this->getImgUpload($compensation_agreement_info,$data,'compensation_agreement');//赔偿协议
            $image_upload_path['compensation_agreement'] = $this->getImgPath($input,'compensation_agreement');//赔偿协议
            $image_upload_base64['compensation_agreement'] = $compensation_agreement_info;
        }
        if(!empty($sick_record_info)){
            $image_upload_code['sick_record'] = $this->getImgUpload($sick_record_info,$data,'sick_record');//病例信息
            $image_upload_path['sick_record'] = $this->getImgPath($input,'sick_record');//病例
            $image_upload_base64['sick_record'] = $sick_record_info;
        }
        if(!empty($invoice_info)){
            $image_upload_code['invoice'] = $this->getImgUpload($invoice_info,$data,'invoice');//发票信息
            $image_upload_path['invoice'] = $this->getImgPath($input,'invoice');//发票
            $image_upload_base64['invoice'] = $invoice_info;
        }
        if(!empty($traffic_police_info)){
            $image_upload_code['traffic_police'] = $this->getImgUpload($traffic_police_info,$data,'traffic_police');//交警事故认定书
            $image_upload_path['traffic_police'] = $this->getImgPath($input,'traffic_police');//交警
            $image_upload_base64['traffic_police'] = $traffic_police_info;
        }
        if(!empty($accident_scene_info)){
            $image_upload_code['accident_scene'] = $this->getImgUpload($accident_scene_info,$data,'accident_scene');//事故现场
            $image_upload_path['accident_scene'] = $this->getImgPath($input,'accident_scene');//事故现场
            $image_upload_base64['accident_scene'] = $accident_scene_info;
        }
        if(!empty($delegation_info)){
            $image_upload_code['delegation'] = $this->getImgUpload($delegation_info,$data,'delegation');//保险理赔授权委托书
            $image_upload_path['delegation'] = $this->getImgPath($input,'delegation');//保险理赔授权委托书
            $image_upload_base64['delegation'] = $delegation_info;
        }
        if(!empty($app_screenshot_info)){
            $image_upload_code['app_screenshot'] = $this->getImgUpload($app_screenshot_info,$data,'app_screenshot');//APP截图
            $image_upload_path['app_screenshot'] = $this->getImgPath($input,'app_screenshot'); //APP屏幕截图
            $image_upload_base64['app_screenshot'] = $app_screenshot_info;
        }
        if(!empty($end_time_info)){
            $image_upload_code['end_time'] = $this->getImgUpload($end_time_info,$data,'end_time');//分拣结束
            $image_upload_path['end_time'] = $this->getImgPath($input,'end_time');//分拣结束
            $image_upload_base64['end_time'] = $end_time_info;
        }
        $img_upload_res = [];
        $img_upload_res['path'] = $image_upload_path;
        $img_upload_res['code'] = $image_upload_code;
        $img_upload_res['base64'] = $image_upload_base64;
//                dump($this->getImgUpload($cid1_info,$data,'cid1'));
//                dump($input);
//                dump($claim_save_info);
//                dump($data);
//                dump($member_info);
//                dump($cid1_res);
//                dump($cid2_res);
//                dump($bank_res);
//                dump($image_upload_path);
//                dump($image_upload_code);
//                dump($img_upload_res);
//                die;
        $claim_files_res = ChannelClaimApply::where('warranty_code',$data['ins_policy_code'])
            ->where('union_order_code',$data['union_order_code'])
            ->first();
        if(empty($claim_files_res)){
            ChannelClaimApply::insert([
                'union_order_code'=>$data['union_order_code'],
                'warranty_code'=>$data['warranty_code'],
                'claim_materials'=>json_encode($img_upload_res),
            ]);
        }
        ChannelClaimApply::where('warranty_code',$data['ins_policy_code'])
            ->where('union_order_code',$data['union_order_code'])->update([
                'claim_materials'=>json_encode($img_upload_res),
            ]);
        ChannelOperate::where('proposal_num',$data['union_order_code'])->update([
            'claim_status'=>'100',//理赔材料提交成功
        ]);
        return redirect('/channelsapi/claim_submit/'.$data['ins_policy_code'])->with('status','理赔信息提交成功！');
    }
    //获取图片上传路径
    public function getImgPath($res,$param){
        $image_paths = [];
        if(isset($res[$param])){
            foreach ($res[$param] as $key=>$value){
                if(is_string($value)){
                    $image_path     = $value;
                }else{
                    $path = 'upload/channel/'.$param.'/' . date("Ymd") .'/';
                    $image_path = UploadFileHelper::uploadImage($value, $path);//理赔上传图片路径（存数据库）
                }
                $image_paths[$key] = $image_path;
            }
        }
        return $image_paths;
    }
    //调用图片上传接口
    public function getImgUpload($res,$data,$name){
        if(empty($res)&&count($res)==0){
            return back()->with('status','理赔资料提交失败');
        }
        $return_code = [];
        switch ($name){
            case 'cid1':
                $data['img_type'] = 'cid1';
                break;
            case 'cid2':
                $data['img_type'] = 'cid2';
                break;
            case 'bank':
                $data['img_type'] = 'bank';
                break;
            case 'claim_apply':
                $data['img_type'] = 'claimapply';
                break;
            case 'invoice':
                $data['img_type'] = 'invoice';
                break;
            case 'sick_record':
                $data['img_type'] = 'sickrecord';
                break;
            case 'diagnosis':
                $data['img_type'] = 'diagnosis';
                break;
            case 'benecid':
                $data['img_type'] = 'benecid';
                break;
            case 'beneficiary':
                $data['img_type'] = 'beneficiary';
                break;
            case 'ECM':
                $data['img_type'] = 'ECM';
                break;
            case 'supply':
                $data['img_type'] = 'supply';
                break;
            case 'death':
                $data['img_type'] = 'death';
                break;
            case 'pathology':
                $data['img_type'] = 'pathology';
                break;
            case 'benecid':
                $data['img_type'] = 'benecid';
                break;
            case 'start_time':
                $data['img_type'] = 'other';
                break;
            case 'compensation_agreement':
                $data['img_type'] = 'other';
                break;
            case 'traffic_police':
                $data['img_type'] = 'other';
                break;
            case 'delegation':
                $data['img_type'] = 'other';
                break;
            case 'app_screenshot':
                $data['img_type'] = 'other';
                break;
            case 'end_time':
                $data['img_type'] = 'other';
                break;
        }
        foreach ($res as $key=>$value){
            $data['img_id'] = $value;
            $datas = $this->signhelp->tySign($data);
            $response = Curl::to(env('TY_API_SERVICE_URL') .'/claim/handle_docs')
                ->returnResponseObject()
                ->withData($datas)
                ->withTimeout(60)
                ->post();
//            print_r($response);die;
            if($response->status != 200){
                $content = $response->content;
                LogHelper::logChannelError($content, 'YD_TK_claim_upload_metarial');
                $respose =  json_encode(['status'=>'501','content'=>'理赔资料提交失败'],JSON_UNESCAPED_UNICODE);
                print_r($respose);
                return back()->with('status','理赔资料提交失败');
            }
            $return_code[] = $response->content;
        }
        return $return_code;
    }
    //获取短信验证码
    public function getSmsCode(){
        $input = $this->request->all();
        $data = [];
        $data['tka_mobile'] = $input['tka_mobile'];
        $data['mobile_sign'] = $input['mobile_sign'];
        $data['ty_product_id'] = '15';
        $data['private_p_code'] = 'VGstMTEyMkEwMUcwMQ';
        $data = $this->signhelp->tySign($data);
        //发送请求
        $response = Curl::to(env('TY_API_SERVICE_URL') . '/claim/get_verify_code')
            ->returnResponseObject()
            ->withData($data)
            ->withTimeout(60)
            ->post();
        //        print_r($response);die;
        if($response->status != 200){
            $content = $response->content;
            LogHelper::logChannelError($content, 'YD_TK_sms_send');
            $result =  json_encode(['status'=>'501','content'=>$response->content],JSON_UNESCAPED_UNICODE);
            return $result;
        }
        //验证码存缓存
        $expiresAt = \Carbon\Carbon::now()->addMinutes(3);
        \Cache::put("reg_code_".$input['tka_mobile'], $response->content, $expiresAt);
        $result =  json_encode(['status'=>'200','content'=>'获取验证码成功'],JSON_UNESCAPED_UNICODE);
        return $result;
    }
    //验证手机验证码
    protected function checkPhoneCode($phone, $phone_code)
    {
        if(!Cache::get("reg_code_".$phone))
            return ['status'=>'error', 'message'=>'验证码不存在，请重新发送'];
        if(Cache::get("reg_code_".$phone) != $phone_code)
            return ['status'=>'error', 'message'=>'验证码错误'];
        Cache::forget("reg_code_".$phone);
        return ['status'=> 'success', 'message'=>'验证码正确'];
    }
    //邮件发送接口(理赔申请书下载)
    public function getEmailSend(){
        $input = $this->request->all();
        $claim_id = getCliamId($input);
        $data = [];
        $data['person_code'] = '410881199406056514';
        $data['emaildress'] = $input['email'];
        $data['ismodify'] = 'Y';
        $data['claim_id'] = $claim_id;
        $data['sign'] = 'sign';
        $data['function_code'] = 'claimsend';
        $data['ty_product_id'] = '15';
        $data['private_p_code'] = 'VGstMTEyMkEwMUcwMQ';
        $data = $this->signhelp->tySign($data);
        //发送请求
        $response = Curl::to(env('TY_API_SERVICE_URL') . '/claim/get_email_send')
            ->returnResponseObject()
            ->withData($data)
            ->withTimeout(60)
            ->post();
        if($response->status != 200){
            $content = $response->content;
            LogHelper::logChannelError($content, 'YD_TK_email_send');
            $respose =  json_encode(['status'=>'501','content'=>'邮件发送出错'],JSON_UNESCAPED_UNICODE);
            return $respose;
        }
        $respose =  json_encode(['status'=>'200','content'=>'邮件发送成功，请前往邮箱查看邮件'],JSON_UNESCAPED_UNICODE);
        return $respose;

        //        ismodify		字符	Y	固定值：Y
        //emaildress	发送地址	字符	Y	826884878@qq.com前端校验邮箱格式，否则不予发送
        //claim_id	报案号	字符	Y	保存接口返回的claim_id
        //sign	验签	字符	Y	保存接口返回的sign
        //function_code	功能编码	字符	Y	固定值：claimsend
    }
    //理赔进度/历史列表
    public function claimRecords($person_code){
        $access_token = $this->request->header('access-token');
        $access_token_data = json_decode($this->sign_help->base64url_decode($access_token),true);
        $person_id_code = $access_token_data['person_code'] ? $access_token_data['person_code'] : $person_code;
        $channel_operate_res = ChannelOperate::where('channel_user_code',$person_id_code)
            ->where('issue_status','200')
            ->where('claim_status','<>',' ')//理赔中200，理赔结束100
            ->with(['warranty','warranty.warranty','warranty.warranty_product','warranty.warranty_rule_order.warranty_recognizee'])
            ->get();
        $channel_operate_end_res = ChannelOperate::where('channel_user_code',$person_id_code)
            ->where('issue_status','100')
            ->where('claim_status','<>',' ')//理赔中200，理赔结束100
            ->with(['warranty','warranty.warranty','warranty.warranty_product','warranty.warranty_rule_order.warranty_recognizee'])
            ->get();
        return view('frontend.channels.claim_records')
            ->with('res',$channel_operate_res)
            ->with('res_end',$channel_operate_end_res);
    }
    //理赔详情页
    public function claimInfo($warranty_code){
        $data = $this->getClaimCommon($warranty_code);
        $claim_id = $this->getCliamId($data);
        $claim_save_info = $this->getCliamSaveInfo($data);//获取报案返回信息
        $data['claim_id'] = $claim_id;
        $data['bank_flag'] = $claim_save_info['bank_flag'];
        $user_info = $this->getMemberInfo($data);
        $progress_info = $this->getCliamProgress($data);
        if(json_decode($user_info,true)){
            $user_info  = json_decode($user_info,true);
        }else{
            return back()->with('status','获取会员信息出错！');
        };
        if(json_decode($progress_info,true)){
            $progress_info  = json_decode($progress_info,true);
        }else{
            return back()->with('status','获取理赔进度信息出错！');
        };
        foreach ($progress_info as $value){
            if($claim_save_info['bank_flag'].$claim_id==$value['claim_id']){
                $sign = $value['sign'];
                $claim_flag = $value['claimFlag'];
            }
        }
        $data['sign'] = $sign;
        $data['member_id'] = $user_info['member_id'];
        $data['claim_id'] = $claim_flag.$claim_id;
        $data = $this->signhelp->tySign($data);
        //发送请求
        $response = Curl::to(env('TY_API_SERVICE_URL') . '/claim/get_detail')
            ->returnResponseObject()
            ->withData($data)
            ->withTimeout(60)
            ->post();
        if($response->status != 200){
            $content = $response->content;
            LogHelper::logChannelError($content, 'YD_TK_Claim_Info_error');
            return back()->with('status','获取理赔详情出错');
        }
        LogHelper::logChannelError($response->content, 'YD_TK_Claim_Info');
        $apply_res = ChannelClaimApply::where('warranty_code',$warranty_code)
            ->where('claim_start_status','200')
            ->with('warrantyRule','warrantyRule.warranty_product','warrantyRule.warranty_rule_order.warranty_recognizee')
            ->first();
        $warranty_res = Warranty::where('warranty_code',$warranty_code)->first();
        return view('frontend.channels.claim_info')
            ->with('res',$response->content)
            ->with('apply_res',$apply_res)
            ->with('warranty_res',$warranty_res)
            ->with('warranty_code',$warranty_code);
    }
    //理赔资料提交
    public function claimSubmit($warranty_code){
        $data = $this->getClaimCommon($warranty_code);//获取通用信息
        $claim_save_info = $this->getCliamSaveInfo($data);//获取报案返回信息
        $member_info = $this->getMemberInfo($data);//获取会员信息
        $claim_apply_res = ChannelClaimApply::where('warranty_code',$warranty_code)
            ->where('union_order_code',$data['union_order_code'])
            ->where('channel_user_code',$data['channel_user_code'])
            ->first();
        if(empty($claim_apply_res)){
            return back()->with('status','获取理赔上传资料出错！');
        }
        $cid_res = $claim_apply_res['cid_files'];
        $bank_res = $claim_apply_res['bank_files'];
        $claim_materials_path = json_decode($claim_apply_res['claim_materials'],true)['path'];
        $claim_materials_code = json_decode($claim_apply_res['claim_materials'],true)['code'];
        //        foreach ($claim_materials_path as $key=>$value){
        //            foreach ($claim_materials_code as $k=>$v){
        //
        //            }
        //        }
        return view('frontend.channels.claim_submit')
            ->with('claim_save_info',$claim_save_info)
            ->with('member_info',$member_info)
            ->with('cid_res',$cid_res)
            ->with('bank_res',$bank_res)
            ->with('claim_materials_path',$claim_materials_path)
            ->with('claim_materials_code',$claim_materials_code)
            ->with('warranty_code',$warranty_code);
    }
    //处理理赔材料删除
    public function doClaimDel(){
        $input = $this->request->all();
        $data = $this->getClaimCommon($input['code']);//获取通用信息
        $claim_save_info = $this->getCliamSaveInfo($data);//获取报案返回信息
        $member_info = $this->getMemberInfo($data);//获取会员信息
        if(json_decode($member_info,true)){
            $member_info  = json_decode($member_info,true);
        }else{
            return back()->with('status','获取信息出错！');
        };

        $claim_apply_res = ChannelClaimApply::where('warranty_code',$input['code'])
            ->where('union_order_code',$data['union_order_code'])
            ->where('channel_user_code',$data['channel_user_code'])
            ->first();
        $key = explode('-',$input['key'])[0];
        $k = explode('-',$input['key'])[1];
        $claim_materials_path = json_decode($claim_apply_res['claim_materials'],true)['path'];
        $claim_materials_code = json_decode($claim_apply_res['claim_materials'],true)['code'];
        $claim_materials_base64 = json_decode($claim_apply_res['claim_materials'],true)['base64'];
        $img_code = $claim_materials_code[$key][$k];
        $data['function_code'] = 'del';
        $data['claim_id'] = $claim_save_info['claim_id'];
        $data['coop_id'] = $member_info['member_id'];
        $data['sign'] =  $claim_save_info['sign'];
        $data['claim_flag'] = $claim_save_info['bank_flag'];
        $data['img_id'] = $img_code;
        $datas = $this->signhelp->tySign($data);
        $response = Curl::to(env('TY_API_SERVICE_URL') .'/claim/handle_docs')
            ->returnResponseObject()
            ->withData($datas)
            ->withTimeout(60)
            ->post();
        if($response->status != 200){
            $content = $response->content;
            LogHelper::logChannelError($content, 'YD_TK_claim_del_metarial');
            $respose =  json_encode(['status'=>'501','content'=>'理赔资料删除失败'],JSON_UNESCAPED_UNICODE);
            return $respose;
        }
        unset($claim_materials_code[$key][$k]);
        unset($claim_materials_path[$key][$k]);
        unset($claim_materials_base64[$key][$k]);
        $img_upload_res = [];
        $img_upload_res['path'] = $claim_materials_path;
        $img_upload_res['code'] = $claim_materials_code;
        $img_upload_res['base64'] = $claim_materials_base64;
        ChannelClaimApply::where('warranty_code',$data['ins_policy_code'])
            ->where('union_order_code',$data['union_order_code'])->update([
                'claim_materials'=>json_encode($img_upload_res),
            ]);
        $respose =  json_encode(['status'=>'200','content'=>'理赔资料删除成功'],JSON_UNESCAPED_UNICODE);
        return $respose;
    }
    //处理理赔材料提交
    public function doClaimSubmit(){
        $input = $this->request->all();
        $data = $this->getClaimCommon($input['warranty_code']);//获取通用信息
        $claim_save_info = $this->getCliamSaveInfo($data);//获取报案返回信息
        $member_info = $this->getMemberInfo($data);//获取会员信息
        if(json_decode($member_info,true)){
            $member_info  = json_decode($member_info,true);
        }else{
            return back()->with('status','获取信息出错！');
        }
        $data['claim_id'] = $claim_save_info['claim_id'];
        $data['coop_id'] = $member_info['member_id'];
        $data['sign'] =  $claim_save_info['sign'];
        $data['claim_flag'] = $claim_save_info['bank_flag'];
        $datas = $this->signhelp->tySign($data);
        $response = Curl::to(env('TY_API_SERVICE_URL') .'/claim/submit')
            ->returnResponseObject()
            ->withData($datas)
            ->withTimeout(60)
            ->post();
//        print_r($response);die;
        if($response->status != 200){
            $content = $response->content;
            LogHelper::logChannelError($content, 'YD_TK_claim_submit_metarial');
            $respose =  json_encode(['status'=>'501','content'=>'理赔资料提交失败'],JSON_UNESCAPED_UNICODE);
            print_r($respose);
            return back()->with('status','理赔资料提交失败');
        }
        ChannelOperate::where('proposal_num',$data['union_order_code'])->update([
            'claim_status'=>'200',//理赔材料提交成功
        ]);
        return redirect('/channelsapi/claim_submit/'.$input['warranty_code'])->with('status','理赔资料提交成功');
    }
    //理赔材料补充
    public function claimAddMaterial($warranty_code){
        return view('frontend.channels.claim_add_material')->with('warranty_code',$warranty_code);
    }
    //处理理赔材料补充
    public function doClaimAddMaterial(){
        $input = $this->request->all();
        $data = $this->getClaimCommon($input['warranty_code']);//获取通用信息
        $claim_save_info = $this->getCliamSaveInfo($data);//获取报案返回信息
        $member_info = $this->getMemberInfo($data);//获取会员信息
        if(json_decode($member_info,true)){
            $member_info  = json_decode($member_info,true);
        }else{
            return back()->with('status','获取信息出错！');
        }
        $data['claim_id'] = $claim_save_info['claim_id'];
        $data['coop_id'] = $member_info['member_id'];
        $data['sign'] =  $claim_save_info['sign'];

        $data = $this->signhelp->tySign($data);
        $response = Curl::to(env('TY_API_SERVICE_URL') . '/claim/get_detail')
            ->returnResponseObject()
            ->withData($data)
            ->withTimeout(60)
            ->post();

        if($response->status != 200){
            $content = $response->content;
            LogHelper::logChannelError($content, 'YD_TK_Claim_Info_error');
            return back()->with('status','获取理赔详情出错');
        }
        $data['claim_flag'] = $claim_save_info['bank_flag'];
        $data['function_code'] = 'sendQuestionInfo2ECM';
        $data['channel'] = 'YDAPP';
        $data['seq_no'] = $response->content['quesNo'];//申请号
        $data['questionid'] = $response->content['seq_no'];//问题件号
        $data['question_desc'] = $response->content['quesDesc'];//补充资料内容
        $datas = $this->signhelp->tySign($data);
        //发送请求
        $response = Curl::to(env('TY_API_SERVICE_URL') . '/claim/submit_append')
            ->returnResponseObject()
            ->withData($datas)
            ->withTimeout(60)
            ->post();
//        print_r($response);die;
        if($response->status != 200){
            $content = $response->content;
            LogHelper::logChannelError($content, 'YD_TK_claim_append_metarial');
            $respose =  json_encode(['status'=>'501','content'=>'理赔资料提交失败'],JSON_UNESCAPED_UNICODE);
            print_r($respose);
            return back()->with('status','理赔资料提交失败');
        }
        $image_paths = [];
        if(isset($input['add_material_info'])){
            foreach ($input['add_material_info'] as $key=>$value){
                if(is_string($value)){
                    $image_path = $value;
                }else{
                    $path = 'upload/channel/claim_add_material/' . date("Ymd") .'/';
                    $image_path = UploadFileHelper::uploadImage($value, $path);//理赔上传图片路径（存数据库）
                }
                $image_paths[$key] = $image_path;
            }
        }
        $claim_files_res = ChannelClaimApply::where('warranty_code',$data['ins_policy_code'])
            ->where('union_order_code',$data['union_order_code'])
            ->first();
        ChannelClaimApply::where('warranty_code',$data['ins_policy_code'])
            ->where('union_order_code',$data['union_order_code'])->update([
                'add_push_files'=>json_encode($image_paths),
                'claim_add_status'=>'200',//已上传补充资料
            ]);
        return redirect('/channelsapi/to_claim')->with('status','补充资料上传成功！');
    }
    //获取请求接口的公共参数  todo 有改动
    public function getClaimCommon($warranty_code){
        //获取保单号，联合订单号，产品信息，被保人信息等
        $warranty_res = Warranty::where('warranty_code',$warranty_code)
            ->with([
                'warranty_rule.warranty_rule_order.warranty_recognizee',
                'warranty_rule.warranty_product',
                'warranty_rule.warranty_rule_order',
                'warranty_rule.policy',
            ])->first();
        $data = [];
        if(!empty($warranty_res->warranty_rule)
            &&!empty($warranty_res->warranty_rule->policy)
            &&!empty($warranty_res->warranty_rule->warranty_rule_order->warranty_recognizee)){
            $data['ins_policy_code'] = $warranty_code;
            $data['private_p_code'] = $warranty_res->warranty_rule->private_p_code ??  'VGstMTEyMkEwMUcwMQ';
            $data['union_order_code'] = $warranty_res->warranty_rule->union_order_code;
            $data['ty_product_id'] = $warranty_res->warranty_rule->warranty_product->ty_product_id ??  '15';
            $data['policy_user_code'] =$warranty_res->warranty_rule->policy->code;
            $data['channel_user_code'] =$warranty_res->warranty_rule->policy->code;
            $data['recognizee_user_code'] =$warranty_res->warranty_rule->warranty_rule_order->warranty_recognizee[0]->code;

        }
        return $data;
    }
    //获取会员绑定信息查询接口
    public function getMemberInfo($res){
        $data = [];
        $data['ins_policy_code'] = $res['ins_policy_code'];
        $data['union_order_code'] = $res['union_order_code'] ?? '';
        $data['ty_product_id'] = $res['ty_product_id'] ?? '15';
        $data['private_p_code'] = $res['private_p_code']?? '';
        $data = $this->signhelp->tySign($data);
        //发送请求
        $response = Curl::to(env('TY_API_SERVICE_URL') . '/claim/get_member_info')
            ->returnResponseObject()
            ->withData($data)
            ->withTimeout(60)
            ->post();
//        print_r($response);die;
        if($response->status != 200){
            $content = $response->content;
            LogHelper::logChannelError($content, 'YD_TK_Claim_Info');
            return back()->with('status','获取会员信息出错');
        }
        $return_data =  is_array($response->content)? json_encode($response->content) :$response->content;
        return $return_data;
    }
    //获取地区初始化信息
    public function getAreaInfo($res){
        $data = [];
        $data['ins_policy_code'] = $res['ins_policy_code'];
        $data['union_order_code'] = $res['union_order_code'];
        $data['private_p_code'] = $res['private_p_code'];
        $data['ty_product_id'] = $res['ty_product_id'];
        $data = $this->signhelp->tySign($data);
        //发送请求
        $response = Curl::to(env('TY_API_SERVICE_URL') . '/claim/get_area')
            ->returnResponseObject()
            ->withData($data)
            ->withTimeout(60)
            ->post();
        //        print_r($response);die;
        if($response->status != 200){
            $content = $response->content;
            LogHelper::logChannelError($content, 'YD_TK_Get_Area');
            return back()->with('status','获取地区初始化信息失败');
        }
        $return_data =  is_array($response->content)? json_encode($response->content) :$response->content;
        return $return_data;
    }
    //获取投保人信息
    public function getInsurantInfo($res){
        $data = [];
        $data['ins_policy_code'] = $res['ins_policy_code'];
        $data['union_order_code'] = $res['union_order_code'];
        $data['private_p_code'] = $res['private_p_code'];
        $data['ty_product_id'] = $res['ty_product_id'];
        $member_info = $this->getMemberInfo($res);
//        dd($member_info);
        if(json_decode($member_info,true)){
            $member_info  = json_decode($member_info,true);
        }else{
            return back()->with('status','获取会员信息出错！');
        }
        //        dump($member_info);
        $data['cidnumber_decrypt'] = $member_info['cidnumber_decrypt'];
        $data['cidtype'] = $member_info['cidtype'];
//                dump($data);
        $data = $this->signhelp->tySign($data);
        //发送请求
        $response = Curl::to(env('TY_API_SERVICE_URL') . '/claim/get_insurant_info')
            ->returnResponseObject()
            ->withData($data)
            ->withTimeout(60)
            ->post();
//        print_r($response);die;
        if($response->status != 200){
            $content = $response->content;
            LogHelper::logChannelError($content, 'YD_TK_get_insurant_info');
            return back()->with('status','获取投保人信息失败');
        }
        $return_data =  is_array($response->content)? json_encode($response->content) :$response->content;
        return $return_data;
    }
    //获取投保进度
    public function getCliamProgress($res){
        $data = [];
        $data['ins_policy_code'] = $res['ins_policy_code'];
        $data['union_order_code'] = $res['union_order_code'];
        $data['ty_product_id'] = $res['ty_product_id'];
        $data['private_p_code'] = $res['private_p_code'];
        $data['claim_id'] = $res['bank_flag'].$res['claim_id'];
        $user_info = $this->getMemberInfo($data);
        if(json_decode($user_info,true)){
            $user_info  = json_decode($user_info,true);
        }else{
            return back()->with('status','获取信息出错！');
        };
        $data['coop_id'] = $user_info['member_id'];
        $data['member_id'] = $user_info['member_id'];
        $data['sign'] = $user_info['member_sign'];
//        dump($data);
        $data = $this->signhelp->tySign($data);
        //发送请求
        $response = Curl::to(env('TY_API_SERVICE_URL') . '/claim/get_progress')
            ->returnResponseObject()
            ->withData($data)
            ->withTimeout(60)
            ->post();
//        print_r($response);die;
        if($response->status != 200){
            $content = $response->content;
            LogHelper::logChannelError($content, 'YD_TK_Claim_Progress');
            return back()->with('status',$content);
        }
        $return_data =  is_array($response->content)? json_encode($response->content) :$response->content;
        return $return_data;
    }
    //获取理赔报案号
    public function getCliamId($res){
        $claim_apply_res =  ChannelClaimApply::where('warranty_code',$res['ins_policy_code'])
            ->first();
        if(empty($claim_apply_res)){
            return back()->with('status','获取报案号出错');
        }
        $return_data =  isset(json_decode($claim_apply_res['user_report_content'],true)['claim_id'])?json_decode($claim_apply_res['user_report_content'],true)['claim_id']:[];
        return $return_data;
    }
    //获取理赔报案返回信息
    public function getCliamSaveInfo($res){
        $claim_apply_res =  ChannelClaimApply::where('warranty_code',$res['ins_policy_code'])
            ->first();
        if(empty($claim_apply_res)){
            return back()->with('status','获取理赔报案返回信息出错');
        }
        $return_data =  isset($claim_apply_res['user_report_content']) ? json_decode($claim_apply_res['user_report_content'],true):[];
        return $return_data;
    }
    //获取人伤险理赔资料上传类型
    public function claimGetTKCDocType($res){
        $data = [];
        $data['ins_policy_code'] = $res['ins_policy_code'] ?? "";;
        $data['union_order_code'] = $res['union_order_code'] ?? "";
        $data['ty_product_id'] = $res['ty_product_id'] ?? "15";;
        $data['claim_id'] = $res['claim_id'] ?? "";;
        $data['sign'] = $res['sign'] ?? "";;
        $data = $this->signhelp->tySign($data);
        //发送请求
        $response = Curl::to(env('TY_API_SERVICE_URL') . '/claim/get_tkc_doc_type')
            ->returnResponseObject()
            ->withData($data)
            ->withTimeout(60)
            ->post();
//        print_r($response);die;
        if($response->status != 200){
            $content = $response->content;
            LogHelper::logChannelError($content, 'YD_TK_Claim_tkc_doc_type');
            return back()->with('status','获取信息出错');
        }
        $return_data = $response->content;
        return $return_data;
    }
    //获取财产险上传资料描述
    public function claimGetTKAUploadDesc($res){
        $data = [];
        $data['ins_policy_code'] = $res['ins_policy_code'];
        $data['union_order_code'] = $res['union_order_code'];
        $data['ty_product_id'] = $res['ty_product_id'];
        $data['private_p_code'] = $res['private_p_code'];
        $data = $this->signhelp->tySign($data);
        //发送请求
        $response = Curl::to(env('TY_API_SERVICE_URL') . '/claim/get_tka_upload_desc')
            ->returnResponseObject()
            ->withData($data)
            ->withTimeout(60)
            ->post();
        if($response->status != 200){
            $content = $response->content;
            LogHelper::logChannelError($content, 'YD_TK_Claim_tka_doc_type');
            return back()->with('status','获取信息出错');
        }
        $return_data = $response->content;
        return $return_data;
    }
    //存储斗腕的用户信息
    public function saveDouwanInfo($biz_content){
        LogHelper::logChannelError($biz_content, 'DW_get_params');
        if(empty($biz_content)){
            return json_encode(['status' => '500', 'content' => '参数集不能为空'],JSON_UNESCAPED_UNICODE);
        }
        $res = ChannelInsureInfo::insert($biz_content);
        if($res){
            return json_encode(['status' => '200', 'content' => '操作成功'],JSON_UNESCAPED_UNICODE);
        }else{
            return json_encode(['status' => '500', 'content' => '参数有误'],JSON_UNESCAPED_UNICODE);
        }
    }
    //存储打零工的用户信息
    public function saveDaLingGongInfo($biz_content){
        LogHelper::logChannelError($biz_content, 'DLG_get_params');
        if(empty($biz_content)){
            return json_encode(['status' => '500', 'content' => '参数集不能为空'],JSON_UNESCAPED_UNICODE);
        }
        if(!isset($biz_content['channel_code'])){
            return json_encode(['status' => '500', 'content' => '请输入渠道代码'],JSON_UNESCAPED_UNICODE);
        }
        if(!isset($biz_content['channel_user_name'])){
            return json_encode(['status' => '500', 'content' => '请输入用户姓名'],JSON_UNESCAPED_UNICODE);
        }
        if(!isset($biz_content['channel_user_code'])){
            return json_encode(['status' => '500', 'content' => '请输入用户证件号'],JSON_UNESCAPED_UNICODE);
        }
        if(!isset($biz_content['channel_code_type'])){
            return json_encode(['status' => '500', 'content' => '请输入用户证件类型'],JSON_UNESCAPED_UNICODE);
        }elseif($biz_content['channel_code_type']!='01'){
            if(!isset($biz_content['channel_nationality'])){
                return json_encode(['status' => '500', 'content' => '请输入用户国籍'],JSON_UNESCAPED_UNICODE);
            }
        }
        if(!isset($biz_content['channel_user_birthday'])){
            return json_encode(['status' => '500', 'content' => '请输入用户生日'],JSON_UNESCAPED_UNICODE);
        }
        if(!isset($biz_content['channel_user_age'])){
            return json_encode(['status' => '500', 'content' => '请输入用户年龄'],JSON_UNESCAPED_UNICODE);
        }
        if(!isset($biz_content['channel_user_sex'])){
            return json_encode(['status' => '500', 'content' => '请输入用户性别'],JSON_UNESCAPED_UNICODE);
        }
        if(!isset($biz_content['channel_user_phone'])){
            return json_encode(['status' => '500', 'content' => '请输入用户联系方式'],JSON_UNESCAPED_UNICODE);
        }
        if(!isset($biz_content['insure_end_time'])){
            return json_encode(['status' => '500', 'content' => '请输入截止时间'],JSON_UNESCAPED_UNICODE);
        }
        if(!isset($biz_content['insure_start_time'])){
            return json_encode(['status' => '500', 'content' => '请输入起保时间'],JSON_UNESCAPED_UNICODE);
        }
        if(!isset($biz_content['occupation'])){
            return json_encode(['status' => '500', 'content' => '请输入用户职业'],JSON_UNESCAPED_UNICODE);
        }
        try{
            DB::beginTransaction();
            //用户表
            $user = new User();
            $user->name = $biz_content['channel_user_name'];
            $user->real_name = $biz_content['channel_user_name'];
            $user->email = '';
            $user->phone = $biz_content['channel_user_phone'];
            $user->code = $biz_content['channel_user_code'];
            $user->occupation = $biz_content['occupation'];
            $user->address = '';
            $user->type = 'user';
            $user->password = bcrypt('123qwe');
            $user->created_at = date('Y-m-d H:i:s',time());
            $user->updated_at = date('Y-m-d H:i:s',time());
            $user->save();
            //渠道信息表
            $channel_insure_info = new ChannelInsureInfo();
            $channel_insure_info->user_id = $user->id;
            $channel_insure_info->insure_end_time = $biz_content['insure_end_time'];
            $channel_insure_info->channel_user_code = $biz_content['channel_user_code'];
            $channel_insure_info->channel_user_age = $biz_content['channel_user_age'];
            $channel_insure_info->occupation = $biz_content['occupation'];
            $channel_insure_info->channel_code_type = $biz_content['channel_code_type'];
            $channel_insure_info->channel_user_birthday = $biz_content['channel_user_birthday'];
            $channel_insure_info->channel_code = $biz_content['channel_code'];
            $channel_insure_info->channel_user_sex = $biz_content['channel_user_sex'];
            $channel_insure_info->channel_user_phone = $biz_content['channel_user_phone'];
            $channel_insure_info->channel_user_name = $biz_content['channel_user_name'];
            $channel_insure_info->insure_start_time = $biz_content['insure_start_time'];
            $channel_insure_info->save();
            DB::commit();
            return json_encode(['status' => '200', 'content' => '操作成功'],JSON_UNESCAPED_UNICODE);
        }catch (\Exception $e) {
            DB::rollBack();
            return json_encode(['status' => '500', 'content' => '参数有误,或重复操作'],JSON_UNESCAPED_UNICODE);
            //            $msg = ['data' => $e->getMessage(), 'code' => 444];
            //            return $msg;
        }
    }
}

