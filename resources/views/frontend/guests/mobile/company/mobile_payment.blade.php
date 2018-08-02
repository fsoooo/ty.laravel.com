<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>天眼互联-科技让保险无限可能</title>
    <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
    <link rel="stylesheet" href="{{config('view_url.view_url')}}mobile/css/lib/mui.min.css">
    <link rel="stylesheet" href="{{config('view_url.view_url')}}mobile/css/lib/mui.picker.all.css">
    <link rel="stylesheet" href="{{config('view_url.view_url')}}mobile/css/lib/iconfont.css" />
    <link rel="stylesheet" href="{{config('view_url.view_url')}}mobile/css/common.css" />
    <style>
        .mui-scroll-wrapper {top: .9rem;}
        .mui-bar-nav {background: #025a8d;}
        .mui-icon-back,.mui-title {color: rgba(255, 255, 255, .8);}
        .payment-header {padding: .5rem 0 .54rem;background: #fff;text-align: center;color: #FFAE00;font-size: .32rem;}
        .payment-header>i {margin-bottom: .3rem;font-size: 1.45rem;}
        .payment-table {font-size: .24rem;}
        .payment-table {padding: 0 .3rem;background: #fff;}
        .payment-table-header {height: .6rem;line-height: .6rem;border-bottom: 1px solid #dcdcdc;}
        .payment-table-content {height: 1rem;line-height: 1rem;}
        .col1 {width: 1.4rem;}
        .col3 {width: 1rem;}
        .payment-table-img {width: .8rem;height: .65rem;margin-top: 0.2rem;}
        .payment-bank {margin: .3rem;background: #fff;box-shadow: 0 0 20px 1px rgba(0, 162, 255, .1);}
        .payment-bank li {position: relative;margin: 0 .54rem;}
        .payment-bank li .iconfont {position: absolute;top: 0;right: 0;z-index: 1;height: .9rem;line-height: .9rem;font-size: .36rem;color: #00a2ff;}
        .payment-bank input {padding-left: 0;height: .9rem;line-height: .9rem;font-size: .28rem;border: none;border-radius: 0;border-bottom: 1px solid #dcdcdc;}
        .btn-payment {margin: .32rem .54rem;width: 1.6rem;height: .62rem;line-height: .62rem;background: #FFAE00;color: #fff;}
        .payment-other {padding: 1rem .3rem;width: 100%;bottom: .98rem;}
        .payment-other>div {display: inline-block;width: 49%;text-align: center;}
        .payment-other>div:first-child {border-right: 1px solid #dcdcdc;}
        .payment-other .iconfont {margin-right: .3rem;font-size: .5rem;}
        .payment-other span {font-size: .26rem;}
        .icon-weixinzhifu {color: #00c800;}
        .icon-icon-alipay {color: #25abee;}
    </style>
</head>

<body>
<div class="main">
    <header class="mui-bar mui-bar-nav">
        <a class="mui-icon mui-icon-back mui-pull-left mui-action-back"></a>
        <h1 class="mui-title">订单支付</h1>
    </header>
    <div class="mui-content">
        <div class="mui-scroll-wrapper">
            <form action="/ins/do_pay_settlement" method="post" >
                <div class="mui-scroll">
                    <div class="payment-header">
                        <i class="iconfont icon-chenggong2"></i>
                        <p>订单创建成功</p>
                    </div>
                    <div class="division"></div>
                    <form method="post"  id="form" action="{{ url('/product/order_pay_settlement') }}" onsubmit="return bank()">
                        {{ csrf_field() }}
                        <input type="text" name="order_code" value="{{ $union_order_code }}" hidden>
                        <div class="payment-table">
                            <ul>
                                <li>
                                    <div class="payment-table-header clearfix">
                                        <div class="col1 bold fl">订单编号</div>
                                        <div class="col2 fl">{{$union_order_code}}</div>
                                    </div>
                                    <div class="payment-table-content clearfix">
                                        <div class="col1 fl">
                                            <div class="payment-table-img">
                                                <img src="{{asset($product->cover)}}" />
                                            </div>
                                        </div>
                                        <div class="col2 fl">{{$product->product_name}}</div>
                                        <div class="col3 fr">￥{{$order->premium}}</div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="division"></div>
                        {{ csrf_field() }}
                        <input type="hidden" name="union_order_code" value="{{$union_order_code}}">
                        <input type="hidden" name="private_p_code" value="{{$private_p_code}}">
                        <input type="hidden" name="premium" value="{{$order->premium}}">

                        <div class="payment-bank" id="bank_pay" style="display: none">
                            <h2 class="notice-title">银行卡支付</h2>
                            <ul>
                                <li style="border-bottom:0.1px solid #888888;color: #888888">
                                    <select id="select_bank">
                                        <option>请选择银行</option>
                                    </select>
                                </li>
                                <li>
                                    <input type="text" name="bank_number" placeholder="输入银行卡号" onblur="get_bank_info()" style="border-bottom:0.1px solid #888888;width: 290px"/>
                                </li>
                                <li><div  id="bank_hidden"></div></li>
                            </ul>
                            <div class="text-right">
                                <button class="btn-payment">去支付</button>
                            </div>
                        </div>
                    </form>
                    <div class="payment-other">
                        @foreach($pay_way as $k => $way)
                            <div>
                                @if($k=='aliPay')
                                    <input type="radio" name="way" value="{{$k}}"  onclick='get_pay_way("{{$k}}")'/>
                                    <i class="iconfont icon-icon-alipay"></i><span>{{$way}}</span>
                                @elseif($k=='wechatPay')
                                    <input type="radio" name="way" value="{{$k}}"  onclick='get_pay_way("{{$k}}")'/>
                                    <i class="iconfont icon-weixinzhifu"></i><span>{{$way}}</span>
                                @else
                                    <div id="choose_bank">
                                        <input type="radio" name="way" value="{{$k}}"  onclick='get_pay_way("{{$k}}")'/>
                                        <img src="{{config('view_url.view_url')}}mobile/image/bank_pay.png" style="width: 25px;height:25px"><span>{{$way}}</span>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                        <div>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</div>
<script src="{{config('view_url.view_url')}}mobile/js/lib/jquery-1.11.3.min.js"></script>
<script src="{{config('view_url.view_url')}}mobile/js/lib/mui.min.js"></script>
<script src="{{config('view_url.view_url')}}mobile/js/lib/mui.picker.all.js"></script>
<script src="{{config('view_url.view_url')}}mobile/js/common.js"></script>
<script src="{{config('view_url.view_url')}}mobile/js/payment.js"></script>
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
    function get_pay_way(pay_way) {
        if(pay_way!=="cardPay"){
            Mask.loding('正在支付,请稍等!');
        }
        var token = $("input[name=_token]").val();
        var private_p_code = "{{$private_p_code}}";
        var union_order_code = "{{$union_order_code}}";
        $.post('/ins/group_ins/get_pay_way_info',
                {"_token": token, 'pay_way': pay_way, 'union_order_code': union_order_code, 'private_p_code': private_p_code},
                function (data) {
                    if (data.status == 200) {
                        var order_code = data.content.order_code;
                        var pay_way_data = data.content.pay_way_data;
                        if (typeof pay_way_data.banks !== 'undefined') {
                            var banks = pay_way_data.banks;
                            window.banks = banks;
                            $('#bank_pay').css('display', 'block');
                            $('#choose_bank').css('display', 'none');
                            for (var i in banks) {
                                $('#select_bank').append('<option value="' + banks[i].uuid + '-' + banks[i].code + '">' + banks[i].name + '</option>');
                            }
                        } else if (typeof pay_way_data.url !== 'undefined') {
                            var url = pay_way_data.url;
                            if(pay_way !=='wechatPay'){
//                            window.open(url, 'newwindow', '');
                                window.location.href = url;
                                setInterval("get_pay_res()",10000);
                            }else{
//                            Mask.img(url);
                                window.location.href = url;
                                setInterval("get_pay_res()",10000);
                            }
                        }
                    } else {
                        alert(data.content);
                    }
                }
        );
    }
    function get_bank_info() {
        var bank_info = $('#select_bank option:selected') .val();
        var bank_infos = bank_info.split("-");
        $('#bank_hidden').html('<input type="hidden" name="bank_uuid" value="'+bank_infos[0]+'" ><input type="hidden" name="bank_code" value="'+bank_infos[1]+'" >');
    }
    var union_order_code = "{{$union_order_code}}";
    var token = $("input[name=_token]").val();
    function get_pay_res(){
        $.ajax({
            type: "post",
            dataType: "json",
            async: true,
            url: "/ins/group_ins/get_pay_res",
            data: {union_order_code:union_order_code},
            headers: {
                'X-CSRF-TOKEN':token
            },
            success: function (data) {
                if(data.status=="200"){
                    window.location.href="/product/order_pay_success/{{$union_order_code}}";
                }else{
//                    alert('支付失败');
//                    window.history.go(-1)
                }
            }
        });
    }
</script>
</body>
</html>