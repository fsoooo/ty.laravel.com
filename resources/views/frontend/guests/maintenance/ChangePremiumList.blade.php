@extends('frontend.guests.layout.bases')
@section('content')
    <style>
        th{
            text-align: center;
        }
        td{
            text-align: center;
        }
    </style>
    <div id="content-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <ol class="breadcrumb">
                            <li><a href="/">主页</a></li>
                            <li class="active"><span>保全</span></li>
                        </ol>
                        <h1>保全信息</h1>
                    </div>
                </div>
                <div class="row">

                    <div class="col-lg-12">
                        <div class="tabs-wrapper tabs-no-header">
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#">保额变更</a></li>
                            </ul>
                        @include('frontend.guests.layout.alert_info')
                        <div class="main-box">
                            <header class="main-box-header clearfix">
                                <h2 class="pull-left">保额变更</h2>
                            </header>
                            <div class="main-box-body clearfix">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th><span>订单编号</span></th>
                                            <th><span>保单编号</span></th>
                                            <th><span>产品名称</span></th>
                                            <th><span>成交方式</span></th>
                                            <th><span>开始时间</span></th>
                                            <th><span>结束时间</span></th>
                                            <th><span>查看更多</span></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @if($count == 0)
                                                <td colspan="8">暂无修改记录</td>
                                            @else
                                                @foreach($premium_list as $value)
                                                    <tr>
                                                        <td>{{ $value->maintenance_record_order->order_code }}</td>
                                                        <td>{{ $value->maintenance_record_order->warranty_rule->warranty->warranty_code }}</td>
                                                        <td>{{ $value->maintenance_record_order->product->product_name }}</td>
                                                        <td>
                                                            @if($value->maintenance_record_order->deal_type == 0)
                                                                线上成交
                                                            @elseif($value->maintenance_record_order->deal_type == 1)
                                                                线下成交
                                                            @endif
                                                        </td>
                                                        <td>{{ $value->maintenance_record_order->warranty_rule->warranty->start_time }}</td>
                                                        <td>{{ $value->maintenance_record_order->warranty_rule->warranty->end_time }}</td>
                                                        <td><a href="{{ url('/maintenance/change_premium_detail/'.$value->order_id) }}">查看详情</a></td>
                                                    </tr>
                                                @endforeach
                                            @endif

                                        </tbody>
                                    </table>
                                </div>
                                @if( $count != 0 )
                                    {{ $premium_list->links() }}
                                @endif
                            </div>
                        </div>
                    </div>
        </div>

    </div>
@stop

