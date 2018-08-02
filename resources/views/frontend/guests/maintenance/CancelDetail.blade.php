@extends('frontend.guests.layout.bases')
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
                        <h1>修改投保人信息</h1>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="main-box clearfix" style="min-height: 1100px;">
                            <div class="tabs-wrapper tabs-no-header">
                                <ul class="nav nav-tabs">
                                    <li><a href="{{ url('/backend/maintenance/cancel') }}">退保申请</a></li>
                                    <li class="active"><a href="#">退保申请详情</a></li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane fade in active" id="tab-accounts">
                                        <h3><p>被保人信息</p></h3>
                                        @include('frontend.guests.layout.alert_info')
                                        <div class="panel-group accordion" id="operation">
                                            <div class="panel panel-default">
                                                <form action="{{ url('/order/add_recognizee_submit') }}" method="post" id="form">
                                                    {{ csrf_field() }}
                                                    <table id="user" class="table table-hover" style="clear: both">
                                                        <tbody>
                                                        <tr>
                                                            <td>保单编号</td>
                                                            <td>{{ $cancel_detail->cancel_order->order_code }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>退保理由</td>
                                                            <td>
                                                                {{ $cancel_detail->result }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>退保描述</td>
                                                            <td>
                                                                {{--{{ $cancel_detail->d }}--}}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>申请时间</td>
                                                            <td>{{ $cancel_detail->created_at }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>保单生效时间</td>
                                                            <td>{{ $cancel_detail->cancel_order->start_time }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>保单结束时间</td>
                                                            <td>{{ $cancel_detail->cancel_order->end_time }}</td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </form>
                                            </div>
                                            {{--<button id="btn" class="btn btn-success">添加</button>--}}
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

