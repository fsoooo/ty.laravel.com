@extends('frontend.guests.layout.bases')
<link rel="stylesheet" type="text/css" href="{{asset('r_backend/css/libs/nifty-component.css')}}"/>
@section('content')
    <meta name="_token" content="{{ csrf_token() }}"/>
    <style>

    </style>
    <div id="content-wrapper">
        <div class="big-img" style="display: none;">
            <img src="" alt="" id="big-img" style="width: 75%;height: 90%;">
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <ol class="breadcrumb">
                            <li><a href="#">前台</a></li>
                            <li class="active"><span>1212</span></li>
                        </ol>
                        <h1>订单管理</h1>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="main-box clearfix" style="min-height: 1100px;">
                            <div class="tabs-wrapper tabs-no-header">
                                <ul class="nav nav-tabs">
                                    <li><a href="{{ url('/order/index/all') }}">订单列表</a></li>
                                    <li class="active"><a href="#">修改保额</a></li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane fade in active" id="tab-accounts">
                                        <h3><p>修改保额</p></h3>
                                        @include('frontend.guests.layout.alert_info')
                                        <div class="panel-group accordion" id="operation">
                                            <div class="panel panel-default">
                                                <form action="{{ url('/order/change_premium_submit') }}" method="post" id="form">
                                                    {{ csrf_field() }}
                                                    <table id="user" class="table table-hover" style="clear: both">
                                                        <input type="text" name="order_id" value="{{ $order_id }}" hidden>
                                                        <tbody>
                                                        <input type="text" name="order_id" value="{{ $order_detail->id }}" hidden>
                                                        <input type="text" name="order_type" value="{{ $order_detail->warranty_rule->type }}" hidden>
                                                        <input type="text" name="order_code" value="{{ $order_detail->order_code }}" hidden>
                                                        <tr>
                                                            <td>产品名称</td>
                                                            <td>{{ $order_detail->warranty_rule->warranty_product->product_name }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>保障开始时间</td>
                                                            <td>{{ $order_detail->warranty_rule->warranty->start_time }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>保障结束时间</td>
                                                            <td>{{ $order_detail->warranty_rule->warranty->end_time }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>选择保额</td>
                                                            <td>
                                                                <select name="premium" id="" class="form-control">
                                                                    <option value="">选择保额</option>
                                                                    @foreach($product_premium as $key=>$value)
                                                                        <option value="{{ $value }}">{{ $value }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </form>
                                            </div>
                                            <button id="btn" class="btn btn-success">申请修改</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>




    <script src="/js/jquery-3.1.1.min.js"></script>
    <script charset="utf-8" src="/r_backend/js/modernizr.custom.js"></script>
    <script charset="utf-8" src="/r_backend/js/classie.js"></script>
    <script charset="utf-8" src="/r_backend/js/modalEffects.js"></script>


    <script>
       $(function(){
            var btn = $('#btn');
            var form = $('#form');
           btn.click(function(){
               form.submit();
           })
       })
    </script>
@stop

