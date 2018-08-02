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
                            <li><a href="#">订单及任务管理</a></li>
                            <li><a href="{{ url('/agent_task/index/month') }}">已完成订单列表</a></li>
                            <li class="active"><a href="{{ url('/agent_task/index/all') }}">已完成订单</a></li>
                        </ol>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="main-box clearfix" style="min-height: 1100px;">
                            <div class="tabs-wrapper tabs-no-header">
                                <ul class="nav nav-tabs">
                                    <li class="active"><a href="{{ url('/agent_task/index/all') }}">已完成订单</a></li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane fade in active" id="tab-accounts">
                                        <h3>
                                            <p>客户信息</p>
                                             <span style="float: right;">
                                                已完成 {{ $count }} 单
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-link dropdown-toggle" data-toggle="dropdown" >
                                                        {{ $condition }}<span class="caret"></span>
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li>
                                                            <a href="{{ url('agent_task/index/all') }}">全部订单</a>
                                                        </li>
                                                        <li>
                                                            <a href="{{ url('agent_task/index/month') }}">本月订单</a>
                                                        </li>
                                                        <li>
                                                            <a href="{{ url('agent_task/index/quarter') }}">季度订单</a>
                                                        </li>
                                                        <li>
                                                            <a href="{{ url('agent_task/index/year') }}">年度订单</a>
                                                        </li>
                                                        <li>
                                                            <a  id="other-time">其他时间</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </span>
                                            {{--<div class="clearFix"></div>--}}
                                        </h3>
                                        @include('frontend.agents.layout.alert_info')
                                        <div class="panel-group accordion" id="account">
                                            <div class="panel panel-default">
                                                <form hidden action="{{ url('agent_task/get_task') }}" method="post" id="form">
                                                    {{ csrf_field() }}
                                                    <label for="">
                                                        开始时间
                                                    </label>
                                                    <input type="date" name="start_time" >
                                                    <label for="">
                                                        结束时间
                                                    </label>
                                                    <input type="date" name="end_time" >
                                                    <button id="form-btn">查询</button>
                                                </form>
                                                <table id="user" class="table table-hover" style="clear: both">
                                                    <thead>
                                                    <tr>
                                                        <th><span>订单编号</span></th>
                                                        <th><span>付款时间</span></th>
                                                        <th><span>订单金额</span></th>
                                                        <th><span>佣金所得</span></th>
                                                        <th><span>佣金支付状态</span></th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @if($count == 0)
                                                        <tr>
                                                            <td colspan="4">暂无符合条件的订单</td>
                                                        </tr>
                                                    @else
                                                        @foreach($list as $value)
                                                            <tr>
                                                                <td>{{ $value->order_code }}</td>
                                                                <td>{{ $value->pay_time }}</td>
                                                                <td>{{ $value->order_order_brokerage->order_pay }}</td>
                                                                <td>{{ $value->order_order_brokerage->user_earnings }}</td>
                                                                <td>{{ $value->order_order_brokerage->status }}</td>
                                                            </tr>
                                                        @endforeach
                                                    @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                            @if($count != 0)
                                                {{ $list->links() }}
                                            @endif
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
        var start_time = $('input[name=start_time]');
        var end_time = $('input[name=end_time]');
        var start_time_val = start_time.html();
        var end_time_val = end_time.html();
        var form = $('#form');
        var other_time_btn = $('#other-time');
        var form_btn = $('#form-btn');
        other_time_btn.click(function () {
//            form.submit();
            form.removeAttr('hidden');
            form_btn.click(function () {
//                if(start_time_val == ''||end_time_val == ''){
//                    alert('选择参数');
//                    return false;
//                }else  if(start_time_val>end_time_val){
//                    alert('时间格式错误');
//                    return false
//                }else {
                    form.submit();
//                }

            })
        })
    </script>
@stop

