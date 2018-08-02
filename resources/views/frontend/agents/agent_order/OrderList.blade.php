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
                            <li><span><a href="/agent_task/add_order">线下订单录入</a></span></li>
                            <li class="active"><a href="/agent_task/order_list">已录入订单</a></li>
                        </ol>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="main-box clearfix" style="min-height: 1100px;">
                            <div class="tabs-wrapper tabs-no-header">
                                <ul class="nav nav-tabs">
                                    <li><a href="{{ url('agent_task/add_order') }}">订单录入</a></li>
                                    <li class="active"><a href="#">已录入订单</a></li>
                                </ul>

            <div class="col-lg-12">
                @include('backend.layout.alert_info')
                <div class="main-box clearfix">
                    <header class="main-box-header clearfix">
                        <h2 class="pull-left">订单列表</h2>
                    </header>
                    <div class="main-box-body clearfix">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th><span>订单编号</span></th>
                                    <th><span>产品名称</span></th>
                                    <th><span>所属公司</span></th>
                                    <th><span>查看详情</span></th>
                                </tr>
                                </thead>
                                <tbody>
                                @if( $count == 0 )
                                    <tr>
                                        <td colspan="8" style="text-align: center;">暂无订单</td>
                                    </tr>
                                @else
                                    @foreach($order_list as $value)
                                        <tr>
                                            <td>{{ $value->order_code }}</td>
                                            <td>{{ $value->product->product_name }}</td>
                                            <td>{{ $value->product->company_name }}</td>
                                            <td>
                                                <a href="{{ url('/agent_task/order_detail/'.$value->id) }}">查看详情</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                        </div>
                        @if( $count != 0 )
                            {{ $order_list->links() }}
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

