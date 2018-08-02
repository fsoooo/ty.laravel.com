<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>天眼互联-科技让保险无限可能</title>
    <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
    <link rel="stylesheet" href="{{config('view_url.view_url')}}mobile/personal/css/lib/mui.min.css">
    <link rel="stylesheet" href="{{config('view_url.view_url')}}mobile/personal/css/lib/iconfont.css" />
    <link rel="stylesheet" href="{{config('view_url.view_url')}}mobile/personal/css/common.css" />
    <link rel="stylesheet" href="{{config('view_url.view_url')}}mobile/personal/css/information.css" />
    <style>
        .bold{margin-top:.2rem;padding: 0 .2rem;}.title{margin-bottom: 0;}
        .applicant-wrapper li {height: 1rem;line-height: 1rem;position: relative;border-bottom: 1px solid #dcdcdc;}
        .list-wrapper{color: #adadad;}.content-wrapper{line-height: .8rem;}
        .content-wrapper li{border-bottom: 1px solid #dbdbdb;}.content-wrapper li:last-child{border-bottom: none;}
        .price-wrapper{line-height: .4rem;color: #ffae00;}.order-wrapper{line-height: .4rem;color: #adadad;}
        .payment-wrapper{position: absolute;bottom: 0;width: 100%;background: #fff;}
        .payment-title{margin: 0 .2rem;height: .9rem;font-size: .32rem;line-height: .9rem;color: #00a2ff;border-bottom: 1px solid #dbdbdb;}
        .payment-wrapper li{padding: 0 .6rem 0 .2rem;line-height: .9rem;}
        .btn-primary{height: 1rem;line-height: 1rem;font-size: .36rem;text-align: center;}.status{float: right;margin-top: .2rem;color: #ffae00;}.name{display: inline-block;width: 3rem;}
        .paymentPopover{height: 5.1rem;}
        .mui-scroll-wrapper{bottom: 1rem;}
    </style>
</head>

<body>
<div class="mui-popover noticePopover">
    <i class="iconfont icon-guanbi"></i>
    <div class="notice-wrapper">
        <h2 class="notice-title">详情</h2>
        <div class="notice-content">
            <div class="mui-scroll-wrapper notice-scroll-wrapper">
                <div class="mui-scroll">
                    <ul class="notice-list">
                        @foreach($order_detail['clause_chose'] as $k=>$value)
                        <li>
                            <div class="name">{{$k+1}} 、{{$value['name']}}</div>
                            <p>{{$value['description']}}</p>
                        </li>
                            @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="main">
    <header class="mui-bar mui-bar-nav">
        <a class="mui-icon mui-icon-back mui-pull-left mui-action-back"></a>
        <h1 class="mui-title">订单详情</h1>
    </header>
    <div class="mui-content">
        <div class="mui-scroll-wrapper main-scroll-wrapper">
            <div class="mui-scroll">
                {{--<div class="warn">请在2017-10-11 23:59:59 前支付 否则订单将会失效</div>--}}
                <div class="information-wrapper">
                    <div class="order-wrapper">
                        <span class="status">
                            @if($order_detail['status'] == 1)
                                已支付
                                @elseif($order_detail['status'] == 2)
                                未支付
                                @elseif($order_detail['status'] == 3)
                                支付失败
                                @elseif($order_detail['status'] == 4)
                                支付中
                                @elseif($order_detail['status'] == 6)
                                核保错误
                                @else
                                取消支付
                            @endif
                        </span>
                        <div>订单号：{{$order_detail['order_code']}}</div>
                        <div>创建时间：{{$order_detail['created_at']}}</div>
                    </div>
                    <div class="division"></div>
                    <div>
                        <div class="information-name">{{$product_detail['json']['category']['name']}}</div>
                        <ul class="list-wrapper">
                            <li>代理人：田小田</li>
                            <li>保障时间：{{strtok($order_detail['start_time'],' ')}}起</li>
                            <li>发起时间：{{$order_detail['created_at']}}</li>
                        </ul>
                    </div>
                    <div class="division"></div>
                    <div>
                        <div class="title">保障权益</div>
                        <ul class="content-wrapper">
                            @foreach($order_detail['clause_chose'] as $value)
                            <li>
                                <span class="name">{{$value['name']}}</span>{{$value['defaultValue']}}
                                <i class="iconfont icon-gengduo fr"></i>
                            </li>
                                @endforeach
                        </ul>
                    </div>
                    <div class="division"></div>
                    <div>
                        <div class="title">保单权益</div>
                        <ul class="content-wrapper">
                            <li>
                                <span class="name">退保</span>
                                <i class="iconfont icon-gengduo fr"></i>
                            </li>
                            <li>
                                <span class="name">保单变更</span>
                                <i class="iconfont icon-gengduo fr"></i>
                            </li>
                            <li>
                                <span class="name">索赔</span>
                                <i class="iconfont icon-gengduo fr"></i>
                            </li>
                        </ul>
                    </div>
                    <div class="division"></div>
                    <div style="line-height: .8rem;">
                        <a href="/order/detail_recognizee/{{$order_detail['id']}}" style="width: 100%;">
                            <span class="name">参保人员</span>
                            <i class="iconfont icon-gengduo fr"></i>
                        </a>
                    </div>
                    <div class="division"></div>
                    <div class="price-wrapper">
                        <div>应付保费：<span class="fr">￥{{$order_detail['premium']/100}}*{{count($recognizee)}}=¥{{$order_detail['premium']/100 * count($recognizee)}}</span></div>
                        <div>实付金额：<span class="fr">¥{{$order_detail['premium']/100 * count($recognizee)}}</span></div>
                    </div>

                </div>
            </div>
        </div>
        <div class="buttonbox">
            @if($order_detail['status'] == 2)
            <button class="btn btn-primary">立即支付</button>
                @endif
        </div>
    </div>
</div>
<div class="mui-popover paymentPopover payment-wrapper">
    <div class="payment-title">应付金额<span class="fr">￥59.00</span></div>
    <div class="bold">支付方式</div>
    <ul class="radiobox">
        <li>
            <label>
                <i class="iconfont icon-icon-alipay"></i>支付宝
                <input hidden name="payment" type="radio" />
                <i class="iconfont icon-danxuan1 fr"></i>
            </label>
        </li>
        <li>
            <label>
                <i class="iconfont icon-wechat"></i>微信
                <input hidden name="payment" type="radio" />
                <i class="iconfont icon-danxuan1 fr"></i>
            </label>
        </li>
        <li>
            <label>
                <div class="icon-img">
                    <img src="image/bank.png" alt="" />
                </div>银联
                <input hidden name="payment" type="radio" />
                <i class="iconfont icon-danxuan1 fr"></i>
            </label>
        </li>
    </ul>
    <div class="btn-primary">立即支付</div>
</div>
<script src="{{config('view_url.view_url')}}mobile/personal/js/lib/jquery-1.11.3.min.js"></script>
<script src="{{config('view_url.view_url')}}mobile/personal/js/lib/mui.min.js"></script>
<script src="{{config('view_url.view_url')}}mobile/personal/js/common.js"></script>
<script>
    $('.content-wrapper li').on('tap',function(){
        mui('.noticePopover').popover('show');
    });
    $('.btn-primary').on('tap',function(){
        mui('.paymentPopover').popover('show');
    });
    mui('body').on('shown', '.paymentPopover', function(e) {
        mui('.main-scroll-wrapper').scroll().scrollTo(0,-255);
    });
    mui('body').on('hidden', '.paymentPopover', function(e) {
        mui('.main-scroll-wrapper').scroll().scrollTo(0,0);
    });
</script>
</body>

</html>