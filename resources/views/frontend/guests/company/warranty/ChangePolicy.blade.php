@extends('frontend.guests.layout.bases')
@section('content')
<link rel="stylesheet" type="text/css" href="{{asset('r_backend/css/libs/nifty-component.css')}}"/>
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
                            <li class="active"><span>个人客户保单管理</span></li>
                        </ol>
                        <h1>修改投保人信息</h1>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="main-box clearfix" style="min-height: 1100px;">
                            <div class="tabs-wrapper tabs-no-header">
                                <ul class="nav nav-tabs">
                                    <li><a href="{{ url('/user/warranty/index') }}">保单列表</a></li>
                                    <li class="active"><a href="#">修改投保人信息</a></li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane fade in active" id="tab-accounts">
                                        <h3><p>投保人信息</p></h3>
                                        {{--@include('frontend.layout.alert_info')--}}
                                        @include('frontend.guests.layout.alert_info')
                                        <div class="panel-group accordion" id="operation">
                                            <div class="panel panel-default">
                                                <form action="{{ url('/user/warranty/change_policy_submit') }}" method="post" id="form">
                                                    {{ csrf_field() }}
                                                    <table id="user" class="table table-hover" style="clear: both">
                                                        <input type="text" name="policy_id" value="{{ $policy_message->id }}" hidden>
                                                        <tbody>
                                                        <tr>
                                                            <td>投保人姓名</td>
                                                            <td><input type="text" name="name" value="{{ $policy_message->name }}" class="form-control" disabled></td>
                                                        </tr>
                                                        <tr>
                                                            <td>证件类型</td>
                                                            <td><input type="text" class="form-control" value="{{ $policy_message->policy_code_type->name }}" disabled></td>
                                                        </tr>
                                                        <tr>
                                                            <td>证件号</td>
                                                            <td><input type="text" value="{{ $policy_message->code }}" disabled class="form-control"></td>
                                                        </tr>
                                                        <tr>
                                                            <td>手机号</td>
                                                            <td><input type="text" value="{{ $policy_message->phone }}" name="phone" class="form-control"></td>
                                                        </tr>
                                                        <tr>
                                                            <td>邮箱地址</td>
                                                            <td><input type="text" value="{{ $policy_message->email }}" name="email" class="form-control"></td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </form>

                                            </div>
                                            <button id="btn" class="btn btn-success">修改</button>
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

