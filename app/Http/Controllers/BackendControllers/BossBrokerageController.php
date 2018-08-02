<?php

namespace App\Http\Controllers\BackendControllers;

use App\Models\CompanyBrokerage;
use App\Models\OrderBrokerage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class BossBrokerageController extends Controller
{
    //老板查看佣金
    public function index($id)
    {
        if($id==1){
            $data = OrderBrokerage::with('order_brokerage_order','order_brokerage_ditch','order_brokerage_agents.user')->get();
            $count=count($data);
            return view('backend.boss.brokerage.index',['data'=>$data,'id'=>$id,'count'=>$count]);
        }else{
            $data=CompanyBrokerage::with('company_brokerage_order')->get();
            $count=count($data);
//            dd($data);
            return view('backend.boss.brokerage.index',['data'=>$data,'id'=>$id,'count'=>$count]);
        }
    }
    public function record()
    {

    }
}
