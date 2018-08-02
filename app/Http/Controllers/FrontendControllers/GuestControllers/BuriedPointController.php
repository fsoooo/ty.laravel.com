<?php
namespace App\Http\Controllers\FrontendControllers\GuestControllers;
use App\Http\Controllers\FrontendControllers\BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Validator;
use App\Models\Message;
use App\Models\MessageRule;
use App\Models\User;
class  BuriedPointController extends BaseController
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






}