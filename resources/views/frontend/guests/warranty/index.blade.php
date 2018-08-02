@extends('frontend.guests.layout.bases')
@section('content')
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
                            <li><a href="#">前台</a></li>
                            @if(Auth::user()->type == 'company')
                                <li class="active"><span>团体险保单管理</span></li>
                            @elseif(Auth::user()->type == 'user')
                                <li class="active"><span>个人客户保单管理</span></li>
                            @endif
                        </ol>
                        @if(Auth::user()->type == 'company')
                            <h1>团险保单列表</h1>
                        @elseif(Auth::user()->type == 'user')
                            <h1>个人保单列表</h1>
                        @endif
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="{{ url('/backend/task/index') }}">全部订单</a></li>
                            <li><a href="{{ url('/backend/task/index') }}">待支付</a></li>
                            <li><a href="{{ url('/backend/task/index') }}">已支付</a></li>
                            <li><a href="{{ url('/backend/task/index') }}">保障中</a></li>
                            <li><a href="{{ url('/backend/task/index') }}">待评价</a></li>
                        </ul>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="main-box clearfix">
                            <header class="main-box-header clearfix">
                                <h2></h2>
                                @include('frontend.guests.layout.alert_info')
                            </header>
                            <div class="main-box-body clearfix">
                                <div class="table-responsive">
                                    <table id="user" class="table table-hover" style="clear: both">
                                        <thead>
                                        <tr>
                                            <th><span>保单编号</span></th>
                                            <th><span>开始时间</span></th>
                                            <th><span>结束时间</span></th>
                                            <th><span>创建时间</span></th>
                                            <th><span>查看详情</span></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if($count == 0)
                                            <tr>
                                                <td colspan="5">暂无保单记录</td>
                                            </tr>
                                        @else
                                            @foreach($order_list as $value)
                                                <tr>
                                                    <td>{{ $value->order_code }}</td>
                                                    <td>{{ $value->start_time }}</td>
                                                    <td>{{ $value->end_time }}</td>
                                                    <td>{{ $value->created_at }}</td>
                                                    <td><a href="{{ url('/warranty/detail/'.$value->id) }}">查看详情</a></td>
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
        <footer id="footer-bar" class="row">
            <p id="footer-copyright" class="col-xs-12">
                &copy; 2014 <a href="http://www.adbee.sk/" target="_blank">Adbee digital</a>. Powered by Centaurus Theme.
            </p>
        </footer>
    </div>
@stop