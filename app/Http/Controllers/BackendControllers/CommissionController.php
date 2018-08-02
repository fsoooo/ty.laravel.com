<?php

namespace App\Http\Controllers\BackendControllers;

use App\Models\CompanyBrokerage;
use App\Models\OrderBrokerage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class CommissionController extends Controller
{
    //查看佣金
    public function index($id)
    {
        if($id==1){
            $data = OrderBrokerage::with('order_brokerage_order','order_brokerage_ditch','order_brokerage_agents.user')->paginate(15);
            $count=count($data);
            return view('backend.commission.index',['data'=>$data,'id'=>$id,'count'=>$count]);
        }else{
//            $data=CompanyBrokerage::with('company_brokerage_order','company_brokerage_warranty')->paginate(15);
//            $count=count($data);

            $data = DB::table('company_brokerage')
                ->join('warranty', 'company_brokerage.warranty_id', '=', 'warranty.id')
                ->select('brokerage', 'warranty_code', 'premium','start_time')
                ->paginate(15);
            $count=count($data);

            return view('backend.commission.index',['data'=>$data,'id'=>$id,'count'=>$count]);
        }
    }
}
