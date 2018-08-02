<?php

namespace App\Http\Controllers\BackendControllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Inter;
use App\Models\Msgorder;
use Illuminate\Support\Facades\DB;
use App\Helper\Email;
use App\Helper\RsaSignHelp;
use Ixudra\Curl\Facades\Curl;
use App\Models\EmailModel;
use App\Models\EmailInfo;
use App\Models\SmsModel;
use App\Models\SmsInfo;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema;
use App\Models\OnlineService;
class MassageController extends Controller
{
    //短信
    public function sms(){
        $result =  Inter::where('company_id',env('TY_API_ID'))->first();
        $models = SmsModel::get();
        $params = "/backend/sms/sms";
//        ->with('params', $params)
        $limit = config('list_num.backend.roles');//每页显示几条
        if(isset($_GET['page'])){
            $page = $_GET['page'];
            $res = SmsInfo::paginate($limit);
            $pages = $res->lastPage();//总页数
            $totals = $res->total();//总数
            $currentPage = $res->currentPage();//当前页码
            $infos = SmsInfo::orderBy('created_at','asc')
                ->skip($page)
                ->offset(($page-1)*$limit)
                ->limit($limit)
                ->get();
        }else{
            $page = '1';
            $res = SmsInfo::paginate($limit);
            $pages = $res->lastPage();//总页数
            $totals = $res->total();//总数
            $currentPage = $res->currentPage();//当前页码
            $infos = SmsInfo::orderBy('created_at','asc')
                ->skip($page)
                ->offset(($page-1)*$limit)
                ->limit($limit)
                ->get();
        }
        if(is_null($result)){
            return view('backend.massage.sms')
                ->with([
                    'infos'=>$infos,
                    'num'=>'0',
                    'company_id'=>env('TY_API_ID'),
                    'send'=>'0',
                    'notice'=>'0',
                    'moneys'=>'0',
                    'status'=>'1',
                    'token'=>''
                ])
                ->with('params', $params)
                ->with('totals',$totals)
                ->with('models',$models)
                ->with('currentPage',$currentPage )
                ->with('pages',$pages);
        }else{
            $status =$result ->status;
            $token = $result ->token;
            return view('backend.massage.sms')
                ->with([
                    'infos'=>$infos,
                    'num'=>'0',
                    'company_id'=>env('TY_API_ID'),
                    'send'=>'0',
                    'notice'=>'0',
                    'moneys'=>'0',
                    'status'=>$status,
                    'token'=>$token
                ])
                ->with('params', $params)
                ->with('models',$models)
                ->with('totals',$totals)
                ->with('currentPage',$currentPage )
                ->with('pages',$pages);
        }
    }
    //邮件
    public function email(){
            $models = EmailModel::all();
            return view('backend.massage.email')->with(['company_id'=>env('TY_API_ID')])->with('models',$models);
    }
    //生成订单
    public function doOrder(){
        $money = $_GET['money'];
        $paytype = $_GET['paytype'];
        $company  = $_GET['company'];
        //订单号生成规则(12位)
        $time = time();
        $str = "1234567890";
        $order_num = substr(str_shuffle($company.$time.$str),0,15);
        $biz_content = array(
            'name'=>'sms',
            'order_num'=>$order_num,
            'company'=>$company,
            'create_time'=>time(),
            'pay_type'=>$paytype,
            'money'=>$money
        );
        $sign_help = new RsaSignHelp();
        $data = $sign_help->tySign($biz_content);
        $response = Curl::to(env('TY_API_SERVICE_URL') . '/paysms')
            ->returnResponseObject()
            ->withData($data)
            ->withTimeout(60)
            ->post();
        $status = $response->status;
        $content =  $response->content;
        if($status ==  '200'){
            $result = Msgorder::where('order_num',$order_num)->first();
            if(!is_null($result)){
                return (['status' => 1, 'message' => '操作失败！！']);
            }else{
                $res = Msgorder::insert(
                    [
                        'name'=>'sms',
                        'order_num'=>$order_num,
                        'company'=>$company,
                        'created_at'=>time(),
                        'pay_type'=>$paytype,
                        'money'=>$money
                    ]);
                if($res){
                    return (['status' => 0, 'message' => '操作成功！！']);
                }else{
                    return (['status' => 1, 'message' => '操作失败！！']);
                }
            }
        }else{
            return (['status' => 1, 'message' => $content]);
        }
    }
    //短信订单页面
    public function doPay(){
      $nums = Msgorder::get();
      return view('backend.msg_order.sms')->with(['nums'=>$nums]);
    }
    //支付操作
    public function payfor(){
      $order_num =  $_GET['id'];
      $data =Msgorder::where('order_num',$order_num)->first();
      dump($data);
    }

    public function payInfo(){
      return '查看详情';
    }
    public function doReply(){
      $order_num = $_GET['order'];
      $status = $_GET['status'];
      $object = DB::table('msgorders')->where('order_num',$order_num)->first();
      if (is_object($object)) {
        foreach ($object as $key => $value) {
          $array[$key] = $value;
        }
      }
      else {
        $array = $object;
      }
      $company = $array['company'];
      $name  = $array['name'];
         if($status == '1'){
             Inter::where('compony_id',$company)->where('name',$name)->update(['status'=>1]);
             Msgorder::where('order_num',$order_num)->update(['ispay'=>1]);
      }
    }

    public  function hasSendEmail(){
        $limit = config('list_num.backend.roles');//每页显示几条
        $params = "/backend/sms/hassendemail";
        if (isset($_GET['page'])) {
            $page = $_GET['page'];
            $res = EmailInfo::paginate($limit);
            $pages = $res->lastPage();//总页数
            $totals = $res->total();//总数
            $currentPage = $res->currentPage();//当前页码
            $result = EmailInfo::orderBy('created_at', 'asc')
                ->skip($page)
                ->offset(($page - 1) * $limit)
                ->limit($limit)
                ->get();
            return view('backend.massage.hassendemail')
                ->with('res', $result)
                ->with('params', $params)
                ->with('totals', $totals)
                ->with('currentPage', $currentPage)
                ->with('pages', $pages);
        } else {
            $page = '1';
            $res = EmailInfo::paginate($limit);
            $pages = $res->lastPage();//总页数
            $totals = $res->total();//总数
            $currentPage = $res->currentPage();//当前页码
            $result = EmailInfo::orderBy('created_at', 'asc')
                ->skip($page)
                ->offset(($page - 1) * $limit)
                ->limit($limit)
                ->get();
            return view('backend.massage.hassendemail')
                ->with('res', $result)
                ->with('params', $params)
                ->with('totals', $totals)
                ->with('currentPage', $currentPage)
                ->with('pages', $pages);
        }
    }
    public  function  emailModels(){
        $limit = config('list_num.backend.roles');//每页显示几条
        $params = "/backend/sms/emailmodels";
        if (isset($_GET['page'])) {
            $page = $_GET['page'];
            $res = EmailModel::paginate($limit);
            $pages = $res->lastPage();//总页数
            $totals = $res->total();//总数
            $currentPage = $res->currentPage();//当前页码
            $result = EmailModel::orderBy('created_at', 'asc')
                ->skip($page)
                ->offset(($page - 1) * $limit)
                ->limit($limit)
                ->get();
            return view('backend.massage.emailmodels')
                ->with('res', $result)
                ->with('params', $params)
                ->with('totals', $totals)
                ->with('currentPage', $currentPage)
                ->with('pages', $pages);
        } else {
            $page = '1';
            $res = EmailModel::paginate($limit);
            $pages = $res->lastPage();//总页数
            $totals = $res->total();//总数
            $currentPage = $res->currentPage();//当前页码
            $result = EmailModel::orderBy('created_at', 'asc')
                ->skip($page)
                ->offset(($page - 1) * $limit)
                ->limit($limit)
                ->get();
            return view('backend.massage.emailmodels')
                ->with('res', $result)
                ->with('params', $params)
                ->with('totals', $totals)
                ->with('currentPage', $currentPage)
                ->with('pages', $pages);
        }
    }
    public  function addEmailModels(){

        return view('backend.massage.addmodels');
    }
    public  function doAddEmailModels(){
        if(empty($_GET['name'])||empty($_GET['descrition'])){
            return (['status' => 1, 'message' => '模板名称、内容不能为空！']);
        }
        $res = EmailModel::insert([
            'model_id'=>$_GET['model_id'],
            'model_name'=>$_GET['name'],
            'content'=>$_GET['descrition'],
            'created_at'=>date('YmdHis',time()),
            'updated_at'=>date('YmdHis',time()),
        ]);
        if($res){
            return (['status' => 0, 'message' => '模板添加成功']);
        }else{
            return (['status' => 1, 'message' => '模板添加失败']);
        }
    }
    public function getEmailModels(){
        $res = EmailModel::where('model_id',$_GET['model_id'])->get();
        $res = $res[0]['content'];
     if(is_null($res)){
         return (['status' => 1, 'message' => '模板获取失败','model'=>' ']);
     }else{
         return (['status' => 0, 'message' => '模板获取成功','model'=>$res]);
     }

    }
    public function emailModelsInfo(){
        $res  = EmailModel::where('id',$_GET['id'])->get();
        return view('backend.massage.emailmodelsinfo')->with('res',$res);
    }

    public function hasEmailInfo(){
        $res  = EmailInfo::where('id',$_GET['id'])->get();
        return view('backend.massage.hasemailinfo')->with('res',$res);
    }
    public function  smsInfoList(){
        $infos = SmsInfo::where('id',$_GET['sms_id'])->first();
        return view('backend.massage.smsinfo')->with('info',$infos);
    }
    public function smsListInfo(){
        $sms_id = $_GET['sms_id'];
        $info = SmsInfo::where('id',$sms_id)->get();
        return view('backend.massage.smsinfo')->with('info',$info);
    }
    //在线客服管理
    public function onlineService(){
        $limit = config('list_num.backend.roles');//每页显示几条
        $params = "/backend/sms/onlineservice";
        if (isset($_GET['page'])) {
            $page = $_GET['page'];
            $res = OnlineService::paginate($limit);
            $pages = $res->lastPage();//总页数
            $totals = $res->total();//总数
            $currentPage = $res->currentPage();//当前页码
            $result = OnlineService::skip($page)
                ->offset(($page - 1) * $limit)
                ->limit($limit)
                ->get();
            return view('backend.massage.onlineservice')
                ->with('res', $result)
                ->with('params', $params)
                ->with('totals', $totals)
                ->with('currentPage', $currentPage)
                ->with('pages', $pages);
        } else {
            $page = '1';
            $res = OnlineService::paginate($limit);
            $pages = $res->lastPage();//总页数
            $totals = $res->total();//总数
            $currentPage = $res->currentPage();//当前页码
            $result = OnlineService::skip($page)
                ->offset(($page - 1) * $limit)
                ->limit($limit)
                ->get();
            return view('backend.massage.onlineservice')
                ->with('res', $result)
                ->with('params', $params)
                ->with('totals', $totals)
                ->with('currentPage', $currentPage)
                ->with('pages', $pages);
        }
    }
    //添加客服
    public function addOnlines(){
        return view('backend.massage.addonlines');
    }
    public function doAddOnlines(Request $request){
       $res = $request->aLL();
       if(empty($res['name'])||empty($res['number'])||empty($res['datas'])||empty($res['phone'])||empty($res['real_name'])||empty($res['card_id'])){
           return (['status'=>'1','message'=>'请正确填写内容']);
       }
       $ids = OnlineService::where('number',$res['number'])->first();
       if(!is_null($ids)){
           return (['status'=>'1','message'=>'您已经添加过此号码！！']);
       }else{
           OnlineService::insert($res);
           return (['status'=>'0','message'=>'添加成功']);
       }
    }
    public function  onlinesInfo(){
        $res = OnlineService::where('id',$_GET['id'])->first();
        return view('backend.massage.onlinesinfo')->with('res',$res);
    }


    
}
