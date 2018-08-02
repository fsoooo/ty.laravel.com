<?php

namespace App\Http\Controllers\BackendControllers;

use App\Models\Agent;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
class BossBusinessController extends Controller
{
    //老板业务统计页面
    //客户统计
    public function cust($type)
    {
        $list = $this->getCustByType($type);
        $count = count($list);
        $type = $type;
        return view('backend.boss.BossBusinessCust',compact('list','count','type'));
    }
    //代理人统计
    public function agent($data)
    {
        //获取所有代理人的区域集合
        $area=$this->getArea();
        //获取所有代理人的职级
        $position=$this->getPosition();
        $data=explode('.',$data);
        switch($data[0]){
            case 'area'://地区筛选
                //获取自己的所有的代理人
                $list = DB::table('agents')
                    ->join('users','agents.user_id','=','users.id')
                    ->select('agents.*','users.id as uid','users.real_name as ureal_name','users.code')
                    ->where('agents.area','=',$data[1])
                    ->get();
                $count = count($list);
                $selected=$data;
                return view('backend.boss.BossBusinessAgent',compact('list','count','area','position','selected'));
                break;
            case 'position'://职位筛选
                //获取自己的所有的代理人
                $list = DB::table('agents')
                    ->join('users','agents.user_id','=','users.id')
                    ->select('agents.*','users.id as uid','users.real_name as ureal_name','users.code')
                    ->where('agents.position','=',$data[1])
                    ->get();
                $count = count($list);
                $selected=$data;
                return view('backend.boss.BossBusinessAgent',compact('list','count','area','position','selected'));
                break;
            default :
                //获取自己的所有的代理人
                $list = DB::table('agents')
                    ->join('users','agents.user_id','=','users.id')
                    ->select('agents.*','users.id as uid','users.real_name as ureal_name','users.code')
                    ->get();
                $count = count($list);
                $selected=$data;
                return view('backend.boss.BossBusinessAgent',compact('list','count','area','position','selected'));
                break;
        }


    }
    //代理人的筛选
    public function screen()
    {
        return view('backend.boss.BossBusinessAgent',compact('list','count','area','position'));

    }
    //代理人业绩详情
    public function detail($id)
    {
        $data=DB::table('order')
            ->join('product','order.product_id','=','product.id')
            ->select('order.*','product.product_name')
            ->where('user_id','=',$id)
            ->get();
//        dd($data);
        $count=0;
        return view('backend.boss.AgentsDetail',compact('data','count'));
    }

    //业务统计
    public function order()
    {
        //查询所有的订单
        $order_list = $this->getAllOrder();
        $count=count($order_list);
        return view('backend.boss.BossBusinessBusiness',compact('order_list','count'));
    }
    //获得订单详情
    public function get_order_detail(){

    }

    //封装一个方法，通过类型查找客户
    public function getCustByType($type)
    {
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
        return $result;
    }
    //封装一个方法，用来获取所有的已成交订单
    public function getAllOrder()
    {
        $order_list = Order::with('product','warranty_rule.policy','order_user','order_agent.user')->get();
//        dd($order_list);
        return $order_list;
    }

    //封装一个获取所有代理人区域集合的方法
    protected function getArea(){
        $data=DB::table('agents')
            ->select('area')
            ->groupBy('area')
            ->get();
        return $data;
    }

    //获取所有代理人的职级
    protected function getPosition(){
        $data=DB::table('agents')
            ->select('position')
            ->groupBy('position')
            ->get();
        return $data;
    }


}
