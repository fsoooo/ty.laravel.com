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
                        </ol>
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
                                            <th><span>产品名称</span></th>
                                            <th><span>查看详情</span></th>
                                        </thead>
                                        <tbody>
                                        @if($count == 0)
                                            <tr>
                                                <td colspan="5">暂无订单记录</td>
                                            </tr>
                                        @else
                                            @foreach($product_list as $value)
                                                <tr>
                                                    <td>{{ $value->product_name }}</td>
                                                    <td><a href="{{ url('/product_info/'.$value->id) }}">查看详情</a></td>
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
@stop