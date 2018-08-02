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
                            <li class="active"><span>订单列表</span></li>
                        </ol>
                        <h1>订单列表</h1>
                        <ul class="nav nav-tabs">
                            @if($order_type == 'all')
                                <li class="active"><a href="#">全部订单</a></li>
                            @elseif($order_type == 'unpayed')
                                <li class="active"><a href="#">待支付</a></li>
                            @elseif($order_type == 'payed')
                                <li class="active"><a href="#">已支付</a></li>
                                <script>
                                    window.onload = function(){
                                        if(location.search.indexOf("?")==-1){
                                            location.href += "?channel_login";
                                        }else{
                                            if(location.search.indexOf("channel_login")==-1) location.href += "&channel_login";
                                        }
                                    }
                                </script>
                            @elseif($order_type == 'insuring')
                                <li class="active"><a href="#">保障中</a></li>
                            @elseif($order_type == 'renewal')
                                <li class="active"><a href="#">待续保</a></li>
                            @endif
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
                                            <th><span>订单编号</span></th>
                                            <th><span>产品名称</span></th>
                                            <th><span>状态</span></th>
                                            {{--<th><span>创建时间</span></th>--}}
                                            @if($order_type == 'unpayed')
                                                <th><span>去支付</span></th>
                                            @endif
                                            <th><span>订单时间</span></th>
                                            @if($order_type == 'insuring')
                                                <th><span>申请理赔</span></th>
                                            @endif
                                            <th><span>查看详情</span></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if($count == 0)
                                            <tr>
                                                <td colspan="8">暂无订单记录</td>
                                            </tr>
                                        @else
                                            @foreach($order_list as $value)
                                                <tr>
                                                    <td>{{$value['order_code']}}</td>
                                                    <td>{{$value->product->product_name }}</td>
													@if($value->status == 1)
                                                    	<td>已支付</td>
													@elseif($value->status == 2)
														<td>未支付</td>
													@else
														<td>支付失败</td>
													@endif
                                                    <td>{{ $value->created_at }}</td>
                                                    @if($order_type == 'unpayed')
                                                        <td><a href="{{ url('/product/pay_settlement/'.$value->warranty_rule->union_order_code) }}">支付</a></td>
                                                    @endif
                                                    @if($order_type == 'insuring')
                                                        <td><a href="{{ url('/claim/claim/'.$value->id) }}">申请理赔</a></td>
                                                    @endif
													@if($value->status == 1)
                                                    	<td><a href="{{ url('/order/detail/'.$value->id) }}">查看详情</a></td>
													@else
														<td style="color: #CCCCCC">查看详情</td>
													@endif
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