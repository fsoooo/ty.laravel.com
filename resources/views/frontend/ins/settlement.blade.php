@extends('frontend.guests.frontend_layout.policy_base')
<link rel="stylesheet" href="{{ url(config('resource.position.css').'/frontend/product/pay-settlement.css') }}">
<style type="text/css">
    .mask {
        position: absolute; top: 0px; filter: alpha(opacity=60); background-color: #777;
        z-index: 1002; left: 0px;
        opacity:0.5; -moz-opacity:0.5;
        display: none;
    }
</style>
@section('content')
    {{--<form method="post"  id="form" action="{{ url('/insurance/order_pay_settlement') }}">--}}
    <div class="settlement-block">
        {{--<div class="back">--}}
            {{--<span>返回购物车</span>--}}
        {{--</div>--}}
                <div class="settlement-title">
                    <div class="product-name">
                        <span>产品名称</span>
                    </div>
                    <div class="policy-way">
                        <span>投保形式</span>
                    </div>
                    <div class="start-time">
                        <span>起保日期</span>
                    </div>
                    <div class="policy-money">
                        <span>保费</span>
                    </div>
                </div>
        <div class="settlement-detail" >
            <div class="settlement-product-logo">
               <img src="{{env('TY_API_PRODUCT_SERVICE_URL')}}{{$company['logo']}}" style="height: 24px;margin-top: 21px">
            </div>
            <div class="settlement-product-name">
                <a href="">{{$product->product_name}}</a>
            </div>
            <div class="settlement-product-policy-way">
                <span>电子保单</span>
            </div>
            <div class="settlement-product-start-time">
                <span>{{$order['start_time']}}</span>
            </div>
            <div class="settlement-product-money" style="color: #ffa700">
                <span> ￥{{$order['premium'] / 100}}</span>
            </div>
            <div class="ClearFix"></div>
        </div>
        <br/>
        <div class="settlement-way">
            <span class="settlement-way-name">请选择支付方式：</span>
            <input type="radio" name="pay_type" value="1" checked>
            <label for="">支付宝</label>
            <input type="radio" name="pay_type" value="2">
            <label for="">微信</label>
            {{--<input type="radio" name="pay_type" value="3">--}}
            {{--<label for="" class="bank_pay">银联</label>--}}

        </div>

        {{--<div class="settlement-card">--}}
            {{--<select name="bank_code"  class="choose-card-type">--}}
                {{--<option value="none">选择银行卡</option>--}}
                {{--@foreach($banks as $bank)--}}
                    {{--<option value="{{$bank->code}}">{{$bank->name}}</option>--}}
                    {{--<input type="hidden" name="bank_number" value="{{$bank->number}}">--}}
                {{--@endforeach--}}
            {{--</select>--}}
            {{--<input type="text" name="card_number" placeholder="请输入银行卡号" >--}}
        {{--</div>--}}
        <div class="settlement-confirm">
            <div>
                 <input type="submit" id="submit" class="settlement-confirm-button" value="去支付">
            </div>
            <div class="settlement-sum">
                <span class="settlement-sum-name">
                    合计：
                </span>
                <span class="settlement-sum-count">
                   {{$order->premium / 100}}<span class="unit">元</span>
                </span>
            </div>
        </div>
        {{ csrf_field() }}
        <input type="text" name="order_code" value="{{ $order->order_code }}" hidden>
    </div>
    <div id="mask" class="mask">
        <div style="margin:0 auto;color: white;">支付中...</div>
    </div>

    {{--</form>--}}
    {{--todo--}}
    <script>
        $("#submit").click(function(){
            showMask();
            var pay_type = $("input[name=pay_type]:checked").val();
            var _token = $("input[name=_token]").val();
            order_code = $("input[name=order_code]").val();
            $.post(
                    '{{ url('/insurance/order_pay_settlement') }}',
                    {'pay_type':pay_type,'_token':_token, 'order_code':order_code},
                    function(data){
                        if(data.status == 'error'){
                            alert(data.data);
                        } else {
                            var res = JSON.parse(data.data);
                            window.open(res.pay_url);
                            setInterval(function () {
                                $.post(
                                        '{{ url('/insurance/order_status') }}',
                                        {'order_code':order_code},
                                        function(data){
                                            console.log(data);
                                            if(data.status == 'pay_error'){
                                                alert(data.message);
                                                history.go(0);
                                            }
                                            if(data.status == 'pay_end'){
                                                alert("支付成功");
                                                window.location.href = "/information/index";
                                            }
                                        }
                                );
                            }, 2000);
                        }
                    }
            );
        });



        //显示遮罩
        function showMask(){
            $("#mask").css("height",$(document).height());
            $("#mask").css("width",$(document).width());
            $("#mask").show();
        }
        //隐藏遮罩层
        function hideMask(){
            $("#mask").hide();
        }
    </script>
@stop