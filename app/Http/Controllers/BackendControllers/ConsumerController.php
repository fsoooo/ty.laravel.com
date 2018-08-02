<?php

namespace App\Http\Controllers\BackendControllers;

use App\Models\OrderBrokerage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ConsumerController extends Controller
{
    //    埋点
     public function buried_point(Request $request){
         $ip = $request['ip'];
         $region = $request['region'];
         $url = $request['url'];
         $referrer = $request['referrer'];


         //访问次数   记录所有访客1天内访问了多少次您的网站，相同的访客有可能多次访问您的网站。
         $time = date("Y-m-d");
         $date = date("Y-m-d H:i:s");
         $today = DB::table('track_statistics')->where('time', 'like', $time.'%')->first();
         if(!empty($today)){
             $uv =($today->uv+1);
             $sum_browse =($today->sum_browse+1);
             $visit = DB::table('track_statistics')->where('id', $today->id)->update(['uv' => $uv,'sum_browse'=>$sum_browse]);
         }else{
             $visit = DB::table('track_statistics')->insert(['uv' =>1,'sum_browse'=>1,'time'=>$date]);
         }


         //独立访客   1天内相同的访客多次访问您的网站只计算1个UV。以cookie为依据
         $only_uv = DB::table('track')->where('visit_time','like',$time.'%')
             ->groupBy('ip')
             ->get()->count();
         $count = DB::table('track_statistics')->where('id', $today->id)->update(['only_uv' => $only_uv]);


         //网站浏览量 指页面的浏览次数，用以衡量网站用户访问的网页数量。多次打开同一页面则浏览量累计；
         $pv = ($today->pv+1);
         $visit = DB::table('track_statistics')->where('id', $today->id)->update(['pv' => $pv]);



         //独立ip      指1天内使用不同IP地址的用户访问网站的数量。
         $ip_count = DB::table('track')->where('visit_time','like',$time.'%')
             ->groupBy('ip')
             ->get()->count();
         $count = DB::table('track_statistics')->where('id', $today->id)->update(['ip' => $ip_count]);



         //新独立访客：是指一段时间内第一次访问网站的人数
         $last_month = date("Y-m-d", strtotime("-1 month"));
         $new_user = DB::table('track')
             ->where('ip', $ip )
             ->whereNotBetween('visit_time', [$last_month, $time])->get()->toArray();
         if(empty($new_user)){
             $new_uv = ($today->new_uv+1);
             $new = DB::table('track_statistics')->where('id', $today->id)->update(['new_uv' => $new_uv]);
         }

//         基本信息添加入库
//         $time = date("Y-m-d H:i:s");
//         $result = DB::table('track')->insert(['ip' =>$ip, 'region' =>$region,'url'=>$url,'referrer'=>$referrer,'visit_time'=>$time]);
     }

    //个人账号管理
    public function index()
    {
        //        $search = $_POST['search'] ?? "";
        //      标识客户购买的次数
        $count = $users =DB::table('users')->where('type', 'user')
            ->join('order', 'users.id', '=', 'order.user_id')->count();
        $type = "user";
//        个人用户
        $users = DB::table('users')
            ->where('type', $type)
            ->select('real_name','email','phone','code','address','users.id','created_at')
            ->paginate(15);
        return view('backend.consumer.index',['users'=>$users,'count'=>$count]);
    }

    //公司账号
    public function firm()
    {
        //      标识客户购买的次数
        $count = $users =DB::table('users')->where('type', 'company')
            ->join('order', 'users.id', '=', 'order.user_id')
            ->count();
        $type = "company";

        //        企业用户
        $users = DB::table('users')
            ->where('type', $type)
            ->select('real_name','email','phone','code','address','users.id','created_at')
            ->paginate(15);
        return view('backend.consumer.firm',['users'=>$users,'count'=>$count]);
    }



//    重置密码
    public function short_message(Request $request){
        $password = bcrypt($request->pwd);
        $user = DB::table('users')->where('id', $request->id)->update(['password' => $password]);
        if($user){
            return response()->json(array('status'=> 0,'message'=>'密码重置成功'), 200);
        }

//        $sendTemplateSMS = new SendTemplateSMS();
//        $code = '';
//        $charset = '1234567890';
//        $_len = strlen($charset)-1;
//        for($i=0;$i<6;++$i){
//            $code .= $charset[mt_rand(0,$_len)];
//        }
//        $sendTemplateSMS->sendTemplateSMS($phone,array($code,60),1);
//
//        $deadline = date("Y-m-d H:i:s",time()+60*60);
//        if(TempPhone::where('phone',$phone)->first()){
//            TempPhone::where('phone',$phone)->update(['code'=>$code,'deadline'=>$deadline]);
//        }else{
//            $tempPhone = new TempPhone();
//            $tempPhone->phone=$phone;
//            $tempPhone->code=$code;
//            $tempPhone->deadline=$deadline;
//            $tempPhone->save();
//        }
//
//        $m3_result->status=0;
//        $m3_result->message='发送成功';
//        return $m3_result->toJson();
    }

//    客户管理
    public function custom()
    {
        return view('backend_v2.client.client');
    }

    //  客户详情页
    public function customer_details(){
        return view('backend_v2.client.client_info');
    }

//    分配代理人
    public function client_agent(){
        return view('backend_v2.client.client_agent');
    }

//    保险记录详情
    public function client_policy_details(){
        return view('backend_v2.client.client_policy_details');
    }

//    保险记录
    public function insurance_record(){
        return view('backend_v2.client.client_record');
    }

}
?>