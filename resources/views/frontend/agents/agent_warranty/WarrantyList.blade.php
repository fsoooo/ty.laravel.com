@extends('frontend.agents.layout.agent_bases')
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
                            <li><a href="/agent/">主页</a></li>
                            <li><a href="#">订单及任务管理</a></li>
                            <li><a href="{{ url('/agent_task/add_warranty') }}">线下保单录入</a></li>
                            <li class="active"><a href="#">查看已录入保单</a></li>
                        </ol>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="main-box clearfix" style="min-height: 1100px;">
                            <div class="tabs-wrapper tabs-no-header">
                                <ul class="nav nav-tabs">
                                    <li><a href="{{ url('/agent_task/add_warranty') }}">线下保单录入</a></li>
                                    <li class="active"><a href="#">查看已录入保单</a></li>
                                </ul>
            <div class="col-lg-12">
                @include('frontend.agents.layout.alert_info')
                <div class="main-box clearfix">
                    <header class="main-box-header clearfix">
                    </header>
                    <div class="main-box-body clearfix">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th><span>订单编号</span></th>
                                    <th><span>保险产品</span></th>
                                    {{--<th><span>开始时间</span></th>--}}
                                    {{--<th><span>到期日期</span></th>--}}
                                    <th><span>保单类型</span></th>
                                    <th><span>查看详情</span></th>
                                </tr>
                                </thead>
                                <tbody>
                                @if( $count == 0 )
                                    <tr>
                                        <td colspan="8" style="text-align: center;">暂无保单</td>
                                    </tr>
                                @else
                                    @foreach($warranty_list as $value)
                                        <tr>
                                            <td>{{ $value->warranty_rule_order->order_code }}</td>
                                            {{--<td>{{ $value->start_time }}</td>--}}
                                            {{--<td>{{ $value->end_time }}</td>--}}
                                            <td>{{ $value->warranty_product->product_name }}</td>
                                            <td>
                                                @if($value->type == 0)
                                                    个险保单
                                                @elseif($value->type == 1)
                                                    团险保单
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ url('/agent_task/warranty_detail/'.$value->warranty_id) }}">查看详情</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                        </div>
                        @if( $count != 0 )
                            {{ $warranty_list->links() }}
                        @endif
                    </div>
                </div>
            </div>
        </div>




        <footer id="footer-bar" class="row">
            <p id="footer-copyright" class="col-xs-12">
                &copy; 2014 <a href="http://www.adbee.sk/" target="_blank">Adbee digital</a>. Powered by Centaurus Theme.
            </p>
        </footer>
    </div>
@stop

