<?php

namespace App\Repositories;

use App\Models\Order;
use App\Models\CompanyBrokerage;
use App\Models\Warranty;

/**
 * 财务中心
 *
 * @category   Repository
 * @package    Api
 * @author     房玉婷 <fangyt@inschos.com>
 * @copyright  2017 (C) 北京天眼互联科技有限公司
 * @version    1.0.0
 * @since      v1.0
 */
class FinanceRepository
{

    public function __construct(Order $order, CompanyBrokerage $companyBrokerage,
                                Warranty $warranty)
    {
        $this->order = $order;
        $this->companyBrokerage = $companyBrokerage;
        $this->warranty = $warranty;
    }

    /**
     * 获取指定时间的财务信息
     *
     * @param $start_time
     * @param $end_time
     * @return array
     */
    public function getFinance($start_time, $end_time)
    {
        //今日订单列表
//        $start_time = date('Y-m-d',time()) . ' 00:00:00';
//        $end_time = date('Y-m-d',time()) . ' 23:59:59';
        $order_list = $this->order->with('order_brokerage')->where('created_at', '>=', $start_time)
            ->where('created_at', '<=', $end_time)
            ->where('status', 1)
            ->get();

        $amount['insurance_revenue'] = 0.00;//今日保费收入总和
        $amount['commission_disbursement'] = 0.00;//今日支出佣金
        $order_brokerage_arr = [];
        $order_arr = [];
        foreach ($order_list as $key => $order) {
            //返回给前端的字段整理
            $order_arr[$key]['id'] = $order['id'];
            $order_arr[$key]['time'] = date('Y-m-d H:i', strtotime($order['created_at']));
            $order_arr[$key]['code'] = $order['order_code'];
            $order_arr[$key]['premium'] = number_format($order['premium'] / 100, 2);

            $amount['insurance_revenue'] += $order['premium'] / 100;
            //如果订单有佣金支出
            if (!is_null($order['order_brokerage'])) {
                //返回给前端的字段整理
                $order_brokerage_arr[$key]['id'] = $order['id'];
                $order_brokerage_arr[$key]['time'] = date('Y-m-d H:i', strtotime($order['order_brokerage']['created_at']));
                $order_brokerage_arr[$key]['code'] = $order['order_code'];
                $order_brokerage_arr[$key]['premium'] = number_format($order['order_brokerage']['user_earnings'] / 100, 2);


                $amount['commission_disbursement'] += $order['order_brokerage']['user_earnings'] / 100;
            }
        }
        /**今日收入保费*/
        $amount['insurance_revenue'] = number_format($amount['insurance_revenue'], 2);
        /**今日支出佣金*/
        $amount['commission_disbursement'] = number_format($amount['commission_disbursement'], 2);

        /**今日收入佣金*/
        //今日公司佣金列表
        $company_brokerage_list = $this->companyBrokerage->where('company_brokerage.created_at', '>', $start_time)
            ->where('company_brokerage.created_at', '<', $end_time)
            ->where('order.status', 1)
            ->leftJoin('order', 'company_brokerage.order_id', '=', 'order.id')
            ->select('company_brokerage.id', 'company_brokerage.created_at', 'brokerage', 'company_brokerage.order_id', 'order.order_code')
            ->get();

        $amount['commission_revenue'] = 0.00;//今日佣金收入总和
        $company_brokerage_arr = [];
        foreach ($company_brokerage_list as $key => $company_brokerage) {
            //返回给前端的字段整理
            $company_brokerage_arr[$key]['id'] = $company_brokerage['order_id'];
            $company_brokerage_arr[$key]['time'] = date('Y-m-d H:i', strtotime($company_brokerage['created_at']));
            $company_brokerage_arr[$key]['code'] = $company_brokerage['order_code'];
            $company_brokerage_arr[$key]['premium'] = number_format($company_brokerage['brokerage'] / 100, 2);

            $amount['commission_revenue'] += $company_brokerage['brokerage'] / 100;
        }
        $amount['commission_revenue'] = number_format($amount['commission_revenue'], 2);

        //今日支出保费（退保）
        $amount['insurance_disbursement'] = 0.00;
        //退保的状态值
        $status = config('attribute_status.policy.surrender');
        //有保单就一定有已付款的订单，所以不需要判断order表的status=1
        $warranty_list = $this->warranty->with('warranty_order')
            ->where('created_at', '>', $start_time)
            ->where('created_at', '<', $end_time)
            ->where('status', $status)
            ->get();
        $warranty_arr = [];
        foreach ($warranty_list as $key => $warranty) {
            //返回给前端的字段整理
            $warranty_arr[$key]['id'] = $warranty['warranty_order'][0]['id'];
            $warranty_arr[$key]['time'] = date('Y-m-d H:i', strtotime($warranty['created_at']));
            $warranty_arr[$key]['code'] = $warranty['warranty_order'][0]['order_code'];
            $warranty_arr[$key]['premium'] = number_format($warranty['premium'] / 100, 2);

            $amount['insurance_disbursement'] += $warranty['premium'] / 100;
        }
        $amount['insurance_disbursement'] = number_format($amount['insurance_disbursement'], 2);

        /**本日保费净收益*/
        $amount['insurance_net_income'] = number_format($amount['insurance_revenue'] - $amount['insurance_disbursement'], 2);

        /**本日佣金净收益*/
        $amount['commission_net_income'] = number_format($amount['commission_revenue'] - $amount['commission_disbursement'], 2);

        return [
            'order_list' => $order_arr,
            'order_brokerage_list' => $order_brokerage_arr,
            'company_brokerage_list' => $company_brokerage_arr,
            'warranty_list' => $warranty_arr,
            'amount' => $amount,
        ];

    }
}

