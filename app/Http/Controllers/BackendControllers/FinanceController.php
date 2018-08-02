<?php

namespace App\Http\Controllers\BackendControllers;

use App\Models\Order;
use App\Repositories\FinanceRepository;
use Illuminate\Http\Request;

/**
 * 财务中心
 *
 * @category   Controller
 * @package    Api
 * @author     房玉婷 <fangyt@inschos.com>
 * @copyright  2017 (C) 北京天眼互联科技有限公司
 * @version    1.0.0
 * @since      v1.0
 */
class FinanceController extends BaseController
{

    private $financeRepository;

    public function __construct(Request $request,
                                FinanceRepository $financeRepository)
    {
        parent::__construct($request);
        $this->financeRepository = $financeRepository;
    }

    /**
     * 财务中心列表页
     */
    public function index()
    {
        /**今日相关财务数据*/
        $start_time = date('Y-m-d', time()) . ' 00:00:00';
        $end_time = date('Y-m-d', time()) . ' 23:59:59';
        $today_finance = $this->financeRepository->getFinance($start_time, $end_time);


        /**本月保费净收益*/
        $start_time = date('Y-m', time()) . '-01 00:00:00';
        $end_time = date('Y-m-d', time()) . ' 23:59:59';
        $first_month_finance = $this->financeRepository->getFinance($start_time, $end_time);
        $first_month_finance = $first_month_finance['amount'];
        $first_month_finance['month'] = date('Y年m月', time());

        /**上一个月净收益*/
        $start_time = date('Y-m-d H:i:s',strtotime(date('Y',time()).'-'.(date('m',time())-1)));
        $end_time = date('Y-m-d H:i:s', time());
        $second_month_finance = $this->financeRepository->getFinance($start_time, $end_time);
        $second_month_finance = $second_month_finance['amount'];
        $second_month_finance['month']=date('Y年m月',strtotime($start_time));

        /**前面第二个月净收益*/
        $start_time = date('Y-m-d H:i:s',strtotime(date('Y',strtotime($start_time)).'-'.(date('m',strtotime($start_time))-1)));
        //end_time同上
        $third_month_finance = $this->financeRepository->getFinance($start_time, $end_time);
        $third_month_finance = $third_month_finance['amount'];
        $third_month_finance['month']=date('Y年m月',strtotime($start_time));

        return view('backend_v2.finance.index', compact(
            'today_finance', 'first_month_finance', 'second_month_finance', 'third_month_finance'
        ));
    }

    /**
     * 财务中心详情页
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function details(Request $request)
    {
        $id = $request->get('id');
        //收入or支出的判断状态（用于面包屑的展示）
        $status = $request->get('status');

        $order_list = Order::with(['product', 'parameter', 'order_brokerage', 'order_warranty',
            'companyBrokerage', 'order_ditch', 'order_agent' => function ($query) {
                $query->with('user');
            }])->where('id', $id)->first();

        return view('backend_v2.finance.details', compact('order_list', 'status'));
    }

}