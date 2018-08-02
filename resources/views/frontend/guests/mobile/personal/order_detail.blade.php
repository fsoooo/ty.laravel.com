<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>天眼互联-科技让保险无限可能</title>
    <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
    <link rel="stylesheet" href="{{config('view_url.view_url')}}mobile/personal/css/lib/mui.min.css">
    <link rel="stylesheet" href="{{config('view_url.view_url')}}mobile/personal/css/information.css">
    <link rel="stylesheet" href="{{config('view_url.view_url')}}mobile/personal/css/lib/iconfont.css" />
    <link rel="stylesheet" href="{{config('view_url.view_url')}}mobile/personal/css/common.css" />
    <style>
        .mui-popover{top: 0;}.bold{margin-top:.2rem;padding: 0 .2rem;}
        .applicant-wrapper li {height: 1rem;line-height: 1rem;position: relative;border-bottom: 1px solid #dcdcdc;}
        .list-wrapper{color: #adadad;}.content-wrapper{line-height: .8rem;}
        .content-wrapper li{border-bottom: 1px solid #dbdbdb;}.content-wrapper li:last-child{border-bottom: none;}
        .price-wrapper{line-height: .4rem;color: #ffae00;}.order-wrapper{line-height: .4rem;color: #adadad;}
        .payment-wrapper{position: absolute;bottom: 0;width: 100%;background: #fff;}
        .payment-title{margin: 0 .2rem;height: .9rem;font-size: .32rem;line-height: .9rem;color: #00a2ff;border-bottom: 1px solid #dbdbdb;}
        .payment-wrapper li{padding: 0 .6rem 0 .2rem;line-height: .9rem;}
        .btn-primary{height: 1rem;line-height: 1rem;}.status{float: right;margin-top: .2rem;color: #ffae00;}.name{display: inline-block;width: 3rem;}
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
                        <li>
                            <div class="name">1.投保年龄</div>
                            <p>被保险人投保年龄为2周岁（含）至70周岁（含）。</p>
                        </li>
                        <li>
                            <div class="name">2.销售地区</div>
                            <p>本计划仅限在如下地区销售： 广东省深圳市内。</p>
                        </li>
                        <li>
                            <div class="name">1.投保年龄</div>
                            <p>被保险人投保年龄为2周岁（含）至70周岁（含）。 2.销售地区 本计划仅限在如下地区销售： 广东省深圳市内。 3</p>
                        </li>
                        <li>
                            <div class="name">1.投保年龄</div>
                            <p>被保险人投保年龄为2周岁（含）至70周岁（含）。 2.销售地区 本计划仅限在如下地区销售： 广东省深圳市内。 3</p>
                        </li>
                        <li>
                            <div class="name">1.投保年龄</div>
                            <p>被保险人投保年龄为2周岁（含）至70周岁（含）。 2.销售地区 本计划仅限在如下地区销售： 广东省深圳市内。 3</p>
                        </li>
                        <li>
                            <div class="name">1.投保年龄</div>
                            <p>被保险人投保年龄为2周岁（含）至70周岁（含）。 2.销售地区 本计划仅限在如下地区销售： 广东省深圳市内。 3</p>
                        </li>
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
        <div class="mui-scroll-wrapper">
            <div class="mui-scroll">
                {{--<div class="warn">请在2017-10-11 23:59:59 前支付 否则订单将会失效</div>--}}
                <div class="information-wrapper">
                    <div class="order-wrapper">
                        <span class="status">
                            @if($data->status ==1)
                                已支付
                                @elseif($data->status==2)
                            未支付，核保成功
                                @elseif($data->status == 3)
                            支付失败
                                @elseif($data->status==4)
                            支付中
                                @elseif($data->status == 5)
                            支付结束
                                @else
                            核保错误
                                @endif
                        </span>
                        <div>订单号：{{$code}}</div>
                        <div>创建时间：{{$data->created_at}}</div>
                    </div>
                    <div class="division"></div>
                    <div>
                        <div class="information-name">{{$data->product->product_name}}</div>
                        <ul class="list-wrapper">
                            <li>被保人：{{$data->warranty_recognizee[0]->name}}</li>
                            <li>保障时间：{{$data->warranty_recognizee[0]->start_time}}至{{$data->warranty_recognizee[0]->end_time}}</li>
                            <li>发起时间：{{$data->warranty_recognizee[0]->created_at}}</li>
                        </ul>
                    </div>
                    <div class="division"></div>
                    <div>
                        <div class="title">保障权益</div>
                        <ul class="content-wrapper">
                            @foreach($duty as $v)
                                <li>
                                    <span class="name">{{$v['name']}}</span>{{$v['defaultValue']}}
                                    <i class="iconfont icon-gengduo fr"></i>
                                </li>
                                @endforeach
                        </ul>
                    </div>
                    <div class="division"></div>
                    {{--<div>--}}
                        {{--<div class="title">保单权益</div>--}}
                        {{--<ul class="content-wrapper">--}}
                            {{--<li>--}}
                                {{--<span class="name">退保</span>--}}
                                {{--<i class="iconfont icon-gengduo fr"></i>--}}
                            {{--</li>--}}
                            {{--<li>--}}
                                {{--<span class="name">保单变更</span>--}}
                                {{--<i class="iconfont icon-gengduo fr"></i>--}}
                            {{--</li>--}}
                            {{--<li>--}}
                                {{--<span class="name">索赔</span>--}}
                                {{--<i class="iconfont icon-gengduo fr"></i>--}}
                            {{--</li>--}}
                        {{--</ul>--}}
                    {{--</div>--}}
                    <div class="division"></div>
                    <div class="price-wrapper">
                        <div>应付保费：<span class="fr">￥{{$data->premium/100}}</span></div>
                        <div>实付金额：<span class="fr">￥{{$data->premium/100}}</span></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="buttonbox">
            @if($data->status == 2)
                <button class="btn btn-primary"><a href="/ins/pay_again/{{$code}}">立即支付</a></button>
                @endif
        </div>
    </div>
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
    })
</script>
</body>

</html>