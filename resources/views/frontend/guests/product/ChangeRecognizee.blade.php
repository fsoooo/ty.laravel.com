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
                        <h1>修改被保人信息</h1>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="main-box clearfix" style="min-height: 1100px;">
                            <div class="tabs-wrapper tabs-no-header">
                                <ul class="nav nav-tabs">
                                    <li><a href="{{ url('/user/order/index') }}">保单列表</a></li>
                                    <li class="active"><a href="#">修改被保人信息</a></li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane fade in active" id="tab-accounts">
                                        <h3><p>被保人信息</p></h3>
                                        @include('frontend.guests.layout.alert_info')
                                        <div class="panel-group accordion" id="operation">
                                            <div class="panel panel-default">
                                                <form action="{{ url('/order/change_recognizee_submit') }}" method="post" id="form">
                                                    {{ csrf_field() }}
                                                    <table id="user" class="table table-hover" style="clear: both">
                                                        <tbody>
                                                        <tr>
                                                            <td width="35%">为谁投保</td>
                                                            <td>
                                                                <select name="" id="">
                                                                    <option value="">选择关系</option>
                                                                    @foreach($relation_list  as $value)
                                                                        @if($value->id == $recognizee_detail->relation_id)
                                                                            <option value="{{ $value->id }}" selected>{{ $value->relation_name }}</option>
                                                                        @else
                                                                            <option value="{{ $value->id }}">{{ $value->relation_name }}</option>
                                                                        @endif
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>开始时间</td>
                                                            <td><input type="date" class="form-control" value="{{ $recognizee_detail->start_time }}" ></td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                            </div>
                                        </div>
                                        <div class="panel-group accordion" id="operation">
                                            <div class="panel panel-default">
                                                    {{ csrf_field() }}
                                                    <table id="user" class="table table-hover" style="clear: both">
                                                        <input type="text" name="recognizee_id" value="{{ $recognizee_detail->id }}" hidden>
                                                        <tbody>
                                                        <tr>
                                                            <td>被保人姓名</td>
                                                            <td><input type="text" name="name" value="{{ $recognizee_detail->name }}" class="form-control" ></td>
                                                        </tr>
                                                        <tr>
                                                            <td>证件类型</td>
                                                            <td>
                                                                <select name="" id="" class="form-control">
                                                                    <option value="">选择证件类型</option>
                                                                        @foreach($code_type as $value)
                                                                            @if($value->id == $recognizee_detail->relation_id)
                                                                                <option value="{{ $value->id }}" selected>{{ $value->name }}</option>
                                                                            @else
                                                                                <option value="{{ $value->id }}">{{ $value->name }}</option>
                                                                            @endif
                                                                        @endforeach
                                                                </select>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>证件号</td>
                                                            <td><input type="text" value="{{ $recognizee_detail->code }}"  name="code" class="form-control"></td>
                                                        </tr>
                                                        <tr>
                                                            <td>职业</td>
                                                            <td>

                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>手机号</td>
                                                            <td><input type="text" value="{{ $recognizee_detail->phone }}" name="phone" class="form-control"></td>
                                                        </tr>
                                                        <tr>
                                                            <td>邮箱地址</td>
                                                            <td><input type="text" value="{{ $recognizee_detail->email }}" name="email" class="form-control"></td>
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

