<?php

namespace App\Http\Controllers\BackendControllers;

use App\Models\AgentAccountRecord;
use App\Models\CompanyBrokerage;
use App\Models\Order;
use App\Models\OrderBrokerage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StatisticsController extends BaseController
{
    //中介统计工具

    public function getPremium()
    {
        //保费统计，按时间获取保费
    }

    public function getBrokerageStatistics()
    {
        //佣金统计
        $brokerage_list = OrderBrokerage::with('order_brokerage_order')
            ->paginate(config('list_num.backend.statistics'));
        $brokerage = OrderBrokerage::sum('user_earnings');
        $count = count($brokerage_list);
        return view('backend.statistics.BrokerageStatistics',compact('brokerage_list','count','brokerage'));
    }

    public function getAwardStatistics()
    {
        //提奖统计

        $award_list = AgentAccountRecord::where('operate',2)
            ->with('agent_account_record_user')
            ->paginate(config('list_num.backend.statistics'));
        $count = count($award_list);
        return view('backend.statistics.index',compact('award_list','count'));
    }
    //公司佣金统计
    public function getCompanyBrokerage()
    {
        ///获取所有的佣金记录
        $brokerage_list = CompanyBrokerage::paginate(10);
        dd($brokerage_list);
    }
}
