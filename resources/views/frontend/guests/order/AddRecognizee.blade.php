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
                                    <li><a href="{{ url('/user/warranty/index') }}">保单列表</a></li>
                                    <li class="active"><a href="#">添加被保人</a></li>
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
                                                        <input type="text" name="order_id" value="{{ $order_detail->id }}" hidden>
                                                        <tbody>
                                                        <tr>
                                                            <td>被保人姓名</td>
                                                            <td><input type="text" name="name" placeholder="请输入姓名" class="form-control"></td>
                                                        </tr>
                                                        <tr>
                                                            <td>与投保人关系</td>
                                                            <td>
                                                                <select name="relation" id="" class="form-control">
                                                                    <option value="">请选择关系</option>
                                                                    @foreach($relation_list as $value)
                                                                        <option value="{{ $value->abbreviation }}">{{ $value->relation_name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>证件类型</td>
                                                            <td>
                                                                <select name="card_type" id="" class="form-control">
                                                                    <option value="">请选择证件</option>
                                                                    <option value="sfz">身份证</option>
                                                                    <option value="hz">护照</option>
                                                                    <option value="jgz">军官证</option>
                                                                    <option value="qt">其他</option>
                                                                </select>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>证件号</td>
                                                            <td><input type="text" name="code" placeholder="请输入证件号" class="form-control"></td>
                                                        </tr>
                                                        <tr>
                                                            <td>手机号</td>
                                                            <td><input type="text" value="" name="phone" placeholder="请输入手机号" class="form-control"></td>
                                                        </tr>
                                                        <tr>
                                                            <td>邮箱地址</td>
                                                            <td><input type="text" value="" placeholder="强输入邮箱地址" name="email" class="form-control"></td>
                                                        </tr>
                                                        <tr>
                                                            <td>保障开始时间</td>
                                                            <td><input type="date" class="form-control" name="start_time"></td>
                                                        </tr>
                                                        <tr>
                                                            <td>保障结束时间</td>
                                                            <td><input type="date" name="end_time" class="form-control"></td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </form>
                                            </div>
                                            <button id="btn" class="btn btn-success">添加</button>
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

