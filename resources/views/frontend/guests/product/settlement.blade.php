@extends('frontend.guests.frontend_layout.policy_base')
<link rel="stylesheet" href="{{ url(config('resource.position.css').'/frontend/product/pay-settlement.css') }}">
@section('content')
    <form method="post"  id="form" action="{{ url('/product/order_pay_settlement') }}" onsubmit="return bank()">
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
                <span> ￥{{$order['premium']}}</span>
            </div>
            <div class="ClearFix"></div>
        </div><br/>
        <div class="settlement-way">
            <span class="settlement-way-name">请选择支付方式：</span>
            <input type="radio" name="bank_pay" checked>
            <label for="" class="bank_pay">使用银行卡支付</label>
            {{--<input type="radio" name="ali-pay" >--}}
            {{--<label for="">使用支付宝支付</label>--}}
        </div>

        <div class="settlement-card">
            <select name="bank_code"  class="choose-card-type">
                <option value="none">选择银行卡</option>
                @foreach($banks as $bank)
                    <option value="{{$bank->code. '-' .$bank->number}}">{{$bank->name}}</option>
                @endforeach
            </select>
            <input type="text" name="card_number" placeholder="请输入银行卡号" >
        </div>
        <div class="settlement-confirm">
                <div>
                     <input type="submit" id="submit" class="settlement-confirm-button" value="去支付">
                </div>
            <div class="settlement-sum">
                <span class="settlement-sum-name">
                    合计：
                </span>
                <span class="settlement-sum-count">
                   {{$order['premium']}}<span class="unit">元</span>
                </span>
            </div>
        </div>
        {{ csrf_field() }}
        <input type="text" name="order_code" value="{{ $union_order_code }}" hidden>
    </form>
    </div>
    <script>
        function bank() {
            var o = {};
            var a = $(form).serializeArray();
            $.each(a, function () {
                if (o[this.name] !== undefined) {
                    if (!o[this.name].push) {
                        o[this.name] = [o[this.name]];
                    }
                    o[this.name].push(this.value || '');
                } else {
                    o[this.name] = this.value || '';
                }
            });

           if(o['bank_code']=='none'){
               alert('请选择银行');
               return false;
           }else if(o['card_number']==''){
               alert('请填写银行卡号');
               return false;
           }else if(o['card_number'].length < 16){
               alert('银行卡号不符合规范');
               return false;
           }else{
               return true;
           }


        }
    </script>
@stop