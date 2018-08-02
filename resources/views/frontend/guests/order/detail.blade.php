@extends('frontend.guests.layout.bases')
<link rel="stylesheet" type="text/css" href="{{asset('r_backend/css/libs/nifty-component.css')}}"/>
@section('content')
    <meta name="_token" content="{{ csrf_token() }}"/>
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
                            <li><a href="/">主页</a></li>
                            <li class="active"><span>个人订单管理</span></li>
                        </ol>
                        <h1>个人订单</h1>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="main-box clearfix" style="min-height: 1100px;">
                            <div class="tabs-wrapper tabs-no-header">
                                <ul class="nav nav-tabs">
                                    <li><a href="{{ url('order/index/all') }}">订单列表</a></li>
                                    <li class="active"><a href="#">订单详情</a></li>
                                </ul>
                                <div class="tab-content">
                                    @include('frontend.guests.layout.alert_info')
                                    <div class="tab-pane fade in active" id="tab-accounts">


                                        <div class="panel-group accordion" id="account">
                                            <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    <h4 class="panel-title">
                                                        订单详情
                                                    </h4>
                                                </div>
                                                <div id="account-message" class="panel-collapse ">
                                                    <table id="basic" class="table table-hover" style="clear: both">
                                                        <tbody>
                                                        <tr>
                                                            <td>订单编号：{{ $order_detail->order_code }}</td>
                                                            <td>订单支付时间：{{$order_detail->pay_time}}</td>
                                                            <td>投保单号：{{$warranty->warranty_code}}</td>
                                                            <td>购买产品：国华至尊保重大疾病保险 </td>
                                                            <td>交易状态：已支付</td>
                                                            <td>支付金额：888</td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel-group accordion" id="account">
                                            <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    <h4 class="panel-title">
                                                        保单基本信息
                                                    </h4>
                                                </div>
                                                <div id="account-message" class="panel-collapse ">
                                                    <table id="basic" class="table table-hover" style="clear: both">
                                                        <tbody>
                                                        <tr>
                                                            <td width="5%">保单编号</td>
                                                            <td width="45%">{{$warranty->warranty_code}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>保障开始时间</td>
                                                            <td>{{$order_detail->start_time }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>保单形式</td>
                                                            @if($warranty)
                                                                <td>电子保单</td>
                                                            @endif
                                                        </tr>
                                                        <tr>
                                                            <td>支付金额</td>
                                                            <td>132132</td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        {{--<div class="panel-group accordion" id="account">--}}
                                            {{--<div class="panel panel-default">--}}
                                                {{--<div class="panel-heading">--}}
                                                    {{--<h4 class="panel-title">--}}
                                                        {{--<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion2" href="#account-message">--}}
                                                            {{--订单基本信息--}}
                                                        {{--</a>--}}
                                                    {{--</h4>--}}
                                                {{--</div>--}}
                                                {{--<div id="account-message" class="panel-collapse ">--}}
                                                    {{--<table id="basic" class="table table-hover" style="clear: both">--}}
                                                        {{--<tbody>--}}
                                                        {{--<tr>--}}
                                                            {{--<td width="35%">订单编号</td>--}}
                                                            {{--<td>{{ $order_detail->order_code }}</td>--}}
                                                        {{--</tr>--}}
														{{--<tr>--}}
															{{--<td width="35%">订单支付时间</td>--}}
															{{--<td>{{$order_detail->pay_time}}</td>--}}
														{{--</tr>--}}
                                                        {{--@if($warranty)--}}
                                                            {{--<tr>--}}
                                                                {{--<td>保单编号</td>--}}
                                                                {{--<td>{{$warranty->warranty_code}}</td>--}}
                                                            {{--</tr>--}}
                                                        {{--@endif--}}
                                                        {{--<tr>--}}
                                                            {{--<td width="35%">保障开始时间</td>--}}
                                                            {{--<td>{{ $order_detail->start_time }}</td>--}}
                                                        {{--</tr>--}}
                                                        {{--<tr>--}}
                                                            {{--<td width="35%">保障结束时间</td>--}}
                                                            {{--<td>{{ $order_detail->end_time }}</td>--}}
                                                        {{--</tr>--}}
                                                        {{--<tr>--}}
                                                            {{--<td width="35%">保额数量</td>--}}
                                                            {{--<td>{{  }}</td>--}}
                                                        {{--</tr>--}}
                                                        {{--<tr>--}}
                                                            {{--<td>产品名称</td>--}}
                                                            {{--<td>{{ $warranty_detail->warranty_rule->warranty_product->product_name }}</td>--}}
                                                        {{--</tr>--}}
                                                        {{--<tr>--}}
                                                            {{--<td>保费</td>--}}
                                                            {{--<td>{{ $order_detail->premium/100 }} 元</td>--}}
                                                        {{--</tr>--}}
                                                        {{--<tr>--}}
                                                            {{--<td>保额</td>--}}
                                                            {{--<td>{{ $coverage }} 元</td>--}}
                                                        {{--</tr>--}}
                                                        {{--<td colspan="2" style="text-align: center;">--}}
                                                            {{--@if($order_detail->status != config('attribute_status.order.unpayed'))--}}
                                                            {{--<button id="change-recognizee-btn" index="add" style="text-align: center;" class="btn btn-success">--}}
                                                                {{--<a href="{{ url('/order/change_premium/'.$order_detail->id) }}" style="color:white;">修改保额</a></button>--}}
                                                            {{--@endif--}}
                                                            <?php $time = date('Y-m-d',time());
//                                                                if($order_detail->end_time>$time){
//                                                                    echo '<button id="change-recognizee-btn" index="add" style="text-align: center;" class="btn btn-success"><a style="color: white;" href="/order/cancel_order/'.$order_detail->id.'">申请退保</a></button>';
//
//                                                                }
                                                            ?>

                                                        {{--</td>--}}
                                                        {{--</tbody>--}}
                                                    {{--</table>--}}
                                                {{--</div>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}

                                        <div class="panel-group accordion" id="bill">
                                            <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    <h4 class="panel-title">

                                                            投保人信息

                                                    </h4>
                                                </div>
                                                <div id="bill-block" class="panel-collapse ">
                                                    <div class="panel-body" style="padding-bottom: 0">
                                                            <table id="product" class="table table-hover" style="clear: both">
                                                                <tr>
                                                                    <td width="35%">投保人姓名</td>
                                                                    <td>{{ $policy->name }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>投保人证件类型</td>
                                                                    <td>{{ $policy->policy_card_type->name }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>投保人证件号码</td>
                                                                    <td>{{ $policy->code }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>投保人电话</td>
                                                                    <td>{{ $policy->phone }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>投保人邮箱</td>
                                                                    <td>{{ $policy->email }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <form action="{{ url('/order/change_policy') }}" method="post" id="change-policy-form">
                                                                        {{ csrf_field() }}
                                                                        <input type="text" name="policy_id" value="{{$policy->id}}" id="" hidden>
                                                                        <input type="text" name="uuid" value="{{ $uuid }}" hidden>
                                                                    </form>
                                                                    {{--<td colspan="2" style="text-align: center;">--}}
                                                                        {{--@if($order_detail->status != config('attribute_status.order.unpayed'))--}}
                                                                        {{--<button id="change-policy-btn" index="add" style="text-align: center;" class="btn btn-success">修改投保人信息</button>--}}
                                                                        {{--@endif--}}
                                                                    {{--</td>--}}
                                                                </tr>
                                                            </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="panel-group accordion" id="bill">
                                            <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    <h4 class="panel-title">
                                                            被保人信息
                                                    </h4>
                                                </div>
                                                @foreach($recognizee as $value)
                                                     <div id="bill-block" class="panel-collapse ">
                                                        <div class="panel-body" style="padding-bottom: 0">
                                                            <table id="product" class="table table-hover" style="clear: both">
                                                                <tr>
                                                                    <td width="35%">被保人姓名</td>
                                                                    <td>{{ $value->name }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>被保人证件类型</td>
                                                                    <td>{{ $value->recognizee_card_type->name }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>被保人证件号码</td>
                                                                    <td>{{ $value->code }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>被保人电话</td>
                                                                    <td>{{ $value->phone }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>被保人和投保人关系</td>
                                                                    <td>{{ $value->recognizee_relation->name }}</td>
                                                                </tr>
                                                                <td colspan="2" style="text-align: center;">
{{--                                                                    <button id="change-recognizee-btn" index="add" style="text-align: center;" class="btn btn-success"><a href="{{ url('/order/change_recognizee/'.$value->id) }}" style="color: white;">修改被保人信息</a></button>--}}
                                                                    {{--@if($_COOKIE['login_type'] == 'company')--}}
                                                                        {{--<button id="change-recognizee-btn" index="add" style="text-align: center;" class="btn btn-success">--}}
                                                                            {{--<a href="{{ url('/warranty/del_recognizee/'.$value->id) }}" style="color:white;">删除</a></button>--}}
                                                                    {{--@endif--}}
                                                                </td>
                                                                <tr>
                                                                    {{--@if($order_detail->warranty_rule->type)--}}
                                                                        {{--<td>--}}
                                                                            {{--<button   style="text-align: center;" class="btn btn-success">--}}
                                                                                {{--<a href="{{ url('/order/del_recognizee/'.$order_detail->id.'/'.$value->id) }}" style="color:white;">删除被保人</a>--}}
                                                                            {{--</button>--}}
                                                                        {{--</td>--}}
                                                                    {{--@endif--}}
                                                                </tr>
                                                            </table>
                                                        </div>
                                                    </div>
                                                @endforeach
                                                {{--@if($order_detail->warranty_rule->type)--}}
                                                    {{--<button id="change-recognizee-btn" index="add" style="text-align: center;" class="btn btn-success">--}}
                                                        {{--<a href="{{ url('/order/add_recognizee/'.$order_detail->id) }}" style="color:white;">增加被保人</a></button>--}}
                                                {{--@endif--}}
                                            </div>
                                        </div>
                                        <button style="background: rgb(52,152,219);width: 150px;height:35px;color: white;font-size:15px;border:none;position: absolute;">下载保单</button>
                                        <div style="position: absolute;left:1300px;">
                                            <a>评论</a>
                                            <a>再次购买</a>
                                            <a class="accordion-toggle collapsed md-trigger "  index="0" style="cursor: pointer;"  data-modal="modal-8">
                                                变更投保信息
                                            </a>
                                            <a>申请退保</a>
                                            <a>保险条款</a>
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
    <div class="md-overlay" id="add-condition-wrap"></div>

    <div class="md-modal md-effect-8 md-hide" id="modal-8">
        <div class="md-content" style="border: 1px solid rgb(52,152,219)">
            <div class="modal-header" >
                <button class="md-close close">×</button>
                <h4 class="modal-title" >申请变更</h4>
            </div>
            <div class="modal-body">
                <form role="form" id="add_category" action='{{url('/order/check_phone')}}' method="post">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="exampleInputEmail1">申请人必须是投保人本人，请验证投保人手机信息</label>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">投保人手机号码：{{ $policy->phone }}</label>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">图片验证码：</label>
                        <input  name="img_code" id="img_code"  type="text" style="width: 150px;height: 45px" onblur="check_img()">
                        <img src="{{URL('/captcha/1')}}"  id="img_captaha" alt="验证码" title="刷新图片" width="100" height="40" border="0" >
                        <span> <a onclick="change_img()"> 换一张</a></span>
                        <span id="check_image"></span>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">短信验证码：</label>
                        <input  name="phone_code"  type="text" style="width: 150px;height: 45px">
                        <input type="button" id="send_sms" value="发送验证码" style="width: 140px;height: 40px;background: gray;color: white;border: none" disabled>
                    </div>

            </div>
            <div class="modal-footer">
                <input type="submit" class="btn btn-primary" value="确认提交">
            </div>
            <input type="hidden" name="phone" value="{{ $policy->phone }}">
            <input type="hidden" name="order_code" value="{{ $order_detail->order_code }}">
            <input type="hidden" name="warranty_code" value="{{$warranty->warranty_code}}">
            <input type="hidden" name="union_order_code" value="{{$union_order_code}}">
            <input type="hidden" name="recognizee" value="{{$recognizee}}">
            <input type="hidden" name="policy" value="{{$policy}}">
            </form>
        </div>
    </div>
    <script>
        $(function(){
            $("#send_sms").click(function(){
                var phone = $("input[name=phone]").val();
//                var phone = "15701681524";
                var model = '52339';
                sendSms(phone, model);
                function sendSms(phone, model){
                    $.get('/backend/sendsms',
                        {'phone':phone,'model':model},
                        function (data) {
                            if(data.status == 0){
                                $("#send_sms").attr("disabled", true);
                                i = 60;
                                var set_time = setInterval(function() {
                                    if(i>0){
                                        change_time(i);
                                        i--;
                                    } else {
                                        clearInterval(set_time);
                                        $("#send_sms").removeAttr("disabled").val('发送验证码').css("cursor","pointer").css('background-color','#00a2ff');
                                    }
                                }, 1000);
                            }
                        }
                    );
                }

            });
            function change_time(i){
                var str = i + '秒后重新发送';
                $("#send_sms").val(str).css('background-color','#999');
            }
        })

        function change_img(){
            var url = "{{ URL('/captcha') }}";
            url = url + "/" + Math.random();
            document.getElementById('img_captaha').src=url;
        }
        function check_img() {
            var img_code =  document.getElementById('img_code').value;
            console.log(img_code['img_code']);
            if(img_code!==''||img_code!==null||typeof(img_code)!==undefined){
                var params = {img_code:img_code};
                $.ajax({
                    type : "get",
                    url : '/checkimagegcode',
                    dataType : 'json',
                    data :params,
                    success:function(msg){
                        if(msg.status == 0){
                            $("#check_image").html('<font color="green">'+'验证码输入正确'+'</font>');
                            $("#send_sms").removeAttr("disabled").val('发送验证码').css("cursor","pointer").css('background-color','#00a2ff');
                        }else{
                            $("#check_image").html('<font color="red">'+'验证码输入错误'+'</font>');
                        }
                    }
                });
            }

        }
    </script>
    <script src="/js/jquery-3.1.1.min.js"></script>
    <script charset="utf-8" src="/r_backend/js/modernizr.custom.js"></script>
    <script charset="utf-8" src="/r_backend/js/classie.js"></script>
    <script charset="utf-8" src="/r_backend/js/modalEffects.js"></script>
    <script>
        $(function(){
            var change_policy_btn = $('#change-policy-btn');
            var change_policy_form = $('#change-policy-form');
            change_policy_btn.click(function(){
                change_policy_form.submit();
            })
        })
        {{--function changeFormInfo() {--}}
           {{--var order_code =  "{{ $order_detail->order_code }}";--}}
            {{--$.ajax({--}}
                {{--type : "get",--}}
                {{--url : '/saveforminfo',--}}
                {{--dataType : 'json',--}}
                {{--data :o,--}}
                {{--success:function(msg){--}}
                    {{--if(msg.status == 0){--}}
                        {{--alert('保存成功');--}}
                        {{--window.location = location;--}}

                    {{--}else{--}}
                        {{--alert('操作失败，请重新尝试！');--}}
                    {{--}--}}
                {{--}--}}
            {{--});--}}
        }
    </script>
@stop

