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
                            <li class="active"><span>个人客户保单管理</span></li>
                        </ol>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="main-box clearfix" style="min-height: 1100px;">
                            <div class="tabs-wrapper tabs-no-header">
                                <ul class="nav nav-tabs">
                                    <li><a href="{{ url('/user/order/index/all') }}">保单列表</a></li>
                                    <li class="active"><a href="#">修改投保人信息</a></li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane fade in active" id="tab-accounts">
                                        <h3><p>投保人信息</p></h3>
                                        @include('frontend.guests.layout.alert_info')
                                        <div class="panel-group accordion" id="operation">
                                            <div class="panel panel-default">
                                                <form action="{{ url('/order/change_policy_submit') }}" method="post" id="form">
                                                    {{ csrf_field() }}
                                                    <table id="user" class="table table-hover" style="clear: both">
                                                        <input type="text" name="policy_id" value="{{ $policy_message->id }}" hidden>
                                                        <tbody>
                                                        <tr>
                                                            <td width="20%">投保人姓名</td>
                                                            <td><input type="text" name="policy_name" value="{{ $policy_message->name }}" class="form-control" disabled></td>
                                                        </tr>
                                                        <tr>
                                                            <td>证件类型</td>
                                                            <td>
                                                                <input type="text" class="form-control" value="{{ $policy_message->policy_card_type->name }}" disabled>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>职业类别</td>
                                                            <td>
                                                                <input type="text" value="{{ $policy_message->policy_occupation->name }}" name="" disabled class="form-control">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>证件号</td>
                                                            <td><input type="text" name="code" value="{{ $policy_message->code }}" class="form-control" disabled></td>
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
                                            <div class="button" style="text-align: center;">
                                                <button id="btn" class="btn btn-success">提交修改</button>
                                                <button id="back-btn" class="btn btn-success">上一步</button>
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
    </div>




    <script src="/js/jquery-3.1.1.min.js"></script>
    <script charset="utf-8" src="/r_backend/js/modernizr.custom.js"></script>
    <script charset="utf-8" src="/r_backend/js/classie.js"></script>
    <script charset="utf-8" src="/r_backend/js/modalEffects.js"></script>
    <script charset="utf-8" src="/js/check.js"></script>


    <script>
       $(function(){
            var btn = $('#btn');
            var form = $('#form');
            var phone = $('input[name=phone]');
           var email = $('input[name=email]');
           var phone_pattern = {{ config('pattern.phone') }};
           var email_pattern = {{ config('pattern.email') }};
           btn.click(function(){
               //进行各项数据验证
               var phone_val = phone.val();
               var email_val = email.val();

               var check_phone = check(phone,phone_val,phone_pattern,'手机号');
               var check_email = check(email,email_val,email_pattern,'邮箱');
               if(!check_phone||!check_email)
               {
                   alert('格式错误');
                   return false;
               }
               form.submit();
           })


           //返回
           var back_btn = $('#back-btn');
           back_btn.click(function(){
               location.href(history.go(-1));
           });


       })
    </script>
@stop

