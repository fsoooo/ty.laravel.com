<?php
/**
 * Created by PhpStorm.
 * User: cyt
 * Date: 2017/6/28
 * Time: 15:38
 */
namespace App\Http\Controllers\BackendControllers;
use Faker\Provider\Base;
use Illuminate\Support\Facades\DB;

class BossCustController extends BaseController{
    public function index($type){
        if($type == 'all'||$type == 'person'||$type == 'company'){
            //获取所有客户
            if($type == 'all'){
                $find_arr = [['from_type',1],['cust.status','=',0]];
            }else{
                //按个人和企业客户获取
                if($type == 'person'){
                    $type_id = 0;
                }else{
                    $type_id = 1;
                }
                $find_arr = [['from_type',1],['type',$type_id],['cust.status','=',0]];
            }
            $result = DB::table('cust_rule')
                ->join('cust','cust_rule.cust_id','=','cust.id')
                ->where($find_arr)
                ->select('cust.*','cust_rule.type')
                ->orderBy('created_at','desc')
                ->get();
        }
        $count=count($result);
//        dd($result);
        return view('backend.boss.cust.index',['count'=>$count,'data'=>$result]);
    }

    //注册用户统计a
    public function register(){
        $data=DB::table('users')
            ->select('*')
            ->get();
//        dd($data);
        $count=count($data);
        return view('backend.boss.cust.register',['count'=>$count,'data'=>$data]);
    }
}