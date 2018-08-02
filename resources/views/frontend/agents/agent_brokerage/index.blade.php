@extends('frontend.agents.layout.agent_bases')
@section('content')
    <meta name="_token" content="{{ csrf_token() }}"/>
    <style>
        th,td{
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
                            <li>佣金管理</li>
                            <li class="active"><span>账户详情</span></li>
                        </ol>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="main-box clearfix" style="min-height: 1100px;">
                            <div class="tabs-wrapper tabs-no-header">
                                <ul class="nav nav-tabs">
                                    <li><a href="{{ url('/agent_brokerage/rate') }}">佣金查询</a></li>
                                    {{--<li class="active"><a href="{{ url('/agent_brokerage/index') }}">订单明细</a></li>--}}
                                    <li><a href="{{ url('/agent_brokerage/no_settlement_order') }}">未结算任务</a></li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane fade in active" id="tab-accounts">
                                        <h3>
                                            <p>佣金记录</p>
                                        </h3>
                                        @include('frontend.agents.layout.alert_info')
                                        <div class="panel-group accordion" id="account">
                                            <div class="panel panel-default">
                                                <table id="user" class="table table-hover" style="clear: both">
                                                    <thead>
                                                    <tr>
                                                        <th><span>订单编号</span></th>
                                                        <th><span>创建时间</span></th>
                                                        <th><span>订单金额</span></th>
                                                        <th><span>佣金所得</span></th>
                                                        <th><span>佣金支付状态</span></th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @if($brokerage_list_count == 0)
                                                        <tr>
                                                            <td colspan="">暂无已成交订单</td>
                                                        </tr>
                                                    @else
                                                        @foreach($brokerage_list as $value)
                                                            <tr>
                                                                <td>
                                                                    {{ $value->order_id }}
                                                                </td>
                                                                <td>
                                                                    {{ $value->created_at }}
                                                                </td>
                                                                <td>
                                                                    {{ $value->order_pay }}
                                                                </td>
                                                                <td>
                                                                    {{ $value->user_earnings }}
                                                                </td>
                                                                <td>

                                                                </td>
                                                            </tr>

                                                        @endforeach
                                                    @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
    </div>
    <script src="/js/jquery-3.1.1.min.js"></script>
    <script>
    </script>
@stop

