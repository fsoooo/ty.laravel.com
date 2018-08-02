<?php

namespace App\Http\Controllers\FrontendControllers\GuestControllers;

use App\Http\Controllers\FrontendControllers\BaseController;

use App\Models\NodeCondition;
use App\Models\Order;
use App\Models\User;
use Request,Image;
use Illuminate\Support\Facades\DB;
use App\Models\Claim;
use App\Models\ClaimRule;
use App\Models\ClaimRecord;
use App\Models\ClaimUrl;
use App\Models\Warranty;
use App\Models\WarrantyRule;
use App\Helper\Status;
use App\Helper\RsaSignHelp;
use Ixudra\Curl\Facades\Curl;
class ClaimController extends BaseController
{
    protected $id;
    protected $path_info;
    protected $bool = true;
    protected $message = '';
    protected $user_id;
    protected $isAuthentication;

    public function __construct()
    {
        $id = $this->getId();
        $this->isAuthentication = $this->isAuthentication($id);
        $this->isMyWarranty();
        $this->path_info = Request::getPathinfo();
        $path_array = explode('/',$this->path_info);
        $path1 = $path_array[1];
        $path2 = $path_array[2];
        //通过路由查找路由表对应的id
        $route_id = $this->getRouteByPath($path1,$path2);
        if($route_id){
            //通过路由查找节点
            $node_id = $this->getNodeByRoute($route_id);
            if($node_id){
                //通过节点查找条件，先查找所有禁止的条件
                $impossible = NodeCondition::where('node_id',$node_id)
                    ->where('is_possible','0')->where('status','0')->get();
//                dd($impossible);
            }
        }
//        //通过路由查找行为规范表中是否有
//        $result = DB::table('behaviour')
//            ->join('route','behaviour.route_id','=','route.id')
//            ->where([
//                ['route.path1',$path1],
//                ['route.path2',$path2],
//            ])->get();
//        $count = count($result);
//        if($count){
//            //说明有行为规范要求,对当前状态和行为状态进行对比
//            //获取所需的对象的状态码
//            $obj_status_array = DB::table('test')
//                ->where('id',$warranty_id)
//                ->first();
//            $count = count($obj_status_array);
//            if($count){
//                $obj_status = $obj_status_array->status;
//                //查找该状态下，该方法的可执行情况
//                $behaviour = DB::table('behaviour')
//                    ->join('route','route.id','=','behaviour.route_id')
//                    ->where([
//                        ['route.path1',$path1],
//                        ['route.path2',$path2],
//                        ['judge_status',$obj_status]
//                    ])->first();
//                $behaviour_count = count($behaviour);
//                if($behaviour_count){
//                    $isPossible = $behaviour->is_possible;
//                    if($isPossible){
//
//                    }else{
//                        $this->bool = false;
//                        $this->message = $behaviour->return_message;
//                    }
//                }else{
//                    $this->bool = false;
//                    $this->message = '未知操作';
//                }
//            }else{
//                $this->bool = false;
//                $this->message = '未知操作';
//            }
//        }
    }

    //前台跳转理赔页面
    public function claim($order_id)
    {
        $user_id = $this->getId();
        if(!$this->isAuthentication){
            return redirect(url('/information/change_information'))->withErrors('尚未进行实名认证，请完善个人信息');
        }
        //判断是否有权限发起理赔
       $is_order =  Order::where('id',$order_id)->where('user_id',$user_id)
           ->where('status',config('attribute_status.order.payed'))->first();
        if(!$is_order){
            return back()->withErrors('错误的订单');
        }
        if(!$this->bool) {
            return back()->withErrors($this->message);
        }else{
            //获取个人的id和个人的用户信息
            $id = $this->getId();
            $UserArray = $this->getUserMessage($id);
            if($UserArray){
                return view("frontend.guests.claim.submit",['real_name'=>$UserArray,'order_id'=>$order_id]);
            }else{
                return back()->withErrors('非法操作');
            }
        }
    }
    //理赔提交页面
    public function submit()
    {
        $id = $this->getId();
        $input = Request::all();
        $account = $input['account'];
        $phone = $input['phone'];
        $type = $input['type'];
        $bank_name = $input['bank_name'];
        $order_id = $input['order_id'];
        $res  = ClaimRule::where('order_id',$order_id)->first();
        if(!is_null($res)){
            return back()->withErrors('您已经发起过理赔！请勿重复操作');
        }
        unset($input['_token']);
        unset($input['order_id']);
        unset($input['real_name']);
        unset($input['phone']);
        unset($input['type']);
        unset($input['account']);
        unset($input['bank_name']);
        //将理赔申请填写到理赔信息表中
        DB::beginTransaction();
        try{
            //添加到理赔表中
            $Claim = new Claim();
            $ClaimArray = array(
                'account'=>$account,//理赔收款账号
                'phone'=>$phone,//客户理赔联系电话
                'account_type'=>$type,//收款账户类型，1，银行卡，2，支付宝账户，3，微信
                'bank_name'=>$bank_name,//收款账户的开户行
                'status'=>0,//状态
            );
            $claim_id = $this->add($Claim,$ClaimArray);
            //添加到理赔关系表中
            $ClaimRule = new ClaimRule();
            $ClaimRuleArray = array(
                'claim_id'=>$claim_id,//理赔记录的id
                'user_id'=>$id,//客户的id
                'status'=>0,//状态
                'from_id'=>1,//所属中介id
                'order_id'=>$order_id,//订单id
            );
            $result1 = $this->add($ClaimRule,$ClaimRuleArray);
            //添加图片到理赔表中
            if($input){//进行图片处理
                $image = $this->uploadImg($input);
                if(!$image){
                    return back()->withErrors('文件格式错误')->withInput($input);
                }
                $image_array = array();
                $url = $_SERVER['HTTP_HOST'];
                foreach($image as $value)
                {
                    $image_array[] = array('claim_id'=>$claim_id,'claim_url'=>$url.'/'.$value);
                }
                $insert_result = DB::table('claim_url')->insert($image_array);
            }
            if($claim_id && $result1){
                DB::commit();
                $biz_content = [];
                $biz_content['claim'] = Claim::where('id',$claim_id)->first();//理赔信息
                $biz_content['claim']['user_msg'] = json_encode(User::where('id',$id)->first());//用户信息
                $biz_content['claim']['order_code'] = Order::where('id',$order_id)->first()->order_code;//订单信息
                $biz_content['claim']['api_account'] = env('TY_API_ID');//账户信息
                $biz_content['claim']['url'] = 'http://'.$_SERVER['HTTP_HOST'];
                $biz_content['claim']['created_at'] = date('Y-m-d H:i:s',time());
                $biz_content['claim']['updated_at'] = date('Y-m-d H:i:s',time());
                $biz_content['claim']['claim_image'] = json_encode($image_array);//理赔单据
                $biz_content['claim']['claim_id'] = $claim_id;
                $biz_content['claim']['union_order_code'] = WarrantyRule::with('warranty_rule_order')
                    ->where('order_id',$order_id)
                    ->first()
                    ->union_order_code;//保单信息
                $sign_help = new RsaSignHelp();
                $data = $sign_help->tySign($biz_content);
                $response = Curl::to(env('TY_API_SERVICE_URL') . '/saveclaim')
                    ->returnResponseObject()
                    ->withData($data)
                    ->withTimeout(60)
                    ->post();
                if($response->status == '200'){
                    return redirect('/claim/get_claim')->with('status','发送成功');
                }else{
                    return back()->withErrors('提交失败');
                }
            }else{
                DB::rollBack();
                return back()->withErrors('提交失败');
            }
        } catch (Exception $e){
            DB::rollBack();
            return back()->withErrors('提交失败');
        }
    }
    protected function uploadImg($files){
        $types = array('jpg', 'jpeg', 'png');
        $image_path = array();
        foreach($files as $k => $v){
            $extension = $v->getClientOriginalExtension();
            if(!in_array($extension, $types)){
                return false;
            }
            $path = 'upload/frontend/claim/claim_image/' . date("Ymd") .'/';
            $name = date("YmdHi").rand(1000, 9999). '.' .$extension;
            $v->move($path, $name);
            $image_path[] = $path . $name;
        }
        return $image_path;
    }
    function extend($file_name){
        $extend = pathinfo($file_name);
        $extend = strtolower($extend["extension"]);
        return $extend;
    }


    //获得理赔的列表
    public function getClaimList()
    {
        $uid = $this->getId();
        //获取保单状态信息
        //aabbccd 暂无保单表，以后和保单表关联
        $list = ClaimRule::where('user_id',$uid)
            ->with('order','get_claim.claim_record')
            ->paginate(config('list_num.frontend.claim'));
        $count = count($list);
        return view('frontend.guests.claim.list',compact('list','count'));
    }
    //查看理赔的详情,具体流程
    public function getClaimDetail($claim_id)
    {
        $uid = $this->getId();
        //判断当前理赔是否有权限查看
        $isMyClaim = $this->isMyClaim($uid,$claim_id);
        if($isMyClaim){
            $record = $this->getMyClaimRecordDetail($claim_id);
            if($record){
                $count = 1;
            }else{
                $count = 0;
            }
            return view('frontend.guests.claim.record',['record'=>$record,'count'=>$count]);
        }else{
            return redirect('claim/index')->withErrors('非法操作');
        }
    }

//获取文件类型后缀
        public function _extend($file){
            $arr = explode('.',$file);
            return $arr[count($arr)-1];
        }
    //开始封装
    //封装一个添加的方法,添加数据
    public function add($table,$array){
        foreach($array as $key=>$value){
            $table->$key = $value;
        }
        $table->save();
        return $table->id;
    }
    //封装一个更新数据的方法
    public function edit($table,$array){
        foreach($array as $key=>$value){
            $table->$key = $value;
        }
        $result = $table->save();
        return $result;
    }
    //封装一个方法，用来获取保单的信息
    public function getWarrantyDetail()
    {

    }
    //封装一个方法，用来获取自己的个人信息
    public function getUserMessage($id)
    {
        $result = User::where('id',$id)
            ->get();
        $count = count($result);
        if($count){
            return $result;
        }else{
            return false;
        }
    }
    //封装一个方法，用来判断是否有操作保单的权限
    public function isMyWarranty()
    {
//        $result = WarrantyRule::where('order_id',$)



    }
    //封装一个方法，用来判断是否有理赔操作的权限
    public function isMyClaim($uid,$claim_id)
    {
        $result = DB::table('claim_rule')
            ->where([
                ['claim_id',$claim_id],
                ['user_id',$uid],
            ])->count();
        if($result){
            return true;
        }else{
            return false;
        }
    }
    //封装一个方法，用来获取属于自己的某条理赔的详情
    public function getMyClaimRecordDetail($claim_id)
    {
        $record = DB::table('claim_record')
            ->where('claim_id',$claim_id)
            ->orderBy('created_at','desc')
            ->paginate(config('list_num.frontend.message'));
        $count = count($record);
        if($count){
            return $record;
        }else{
            return false;
        }
    }
    public  function getClaimLocalDetail($cid){
        $claim_res = Claim::with('claim_url')->where('id',$cid)->first();
        return view('frontend.guests.claim.claimlocaldetail')->with('res',$claim_res);
    }

}