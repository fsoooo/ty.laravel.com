<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>天眼互联-科技让保险无限可能</title>
    <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
    <link rel="stylesheet" href="{{config('view_url.view_url')}}mobile/company/css/lib/mui.min.css">
    <link rel="stylesheet" href="{{config('view_url.view_url')}}mobile/company/css/lib/iconfont.css" />
    <link rel="stylesheet" href="{{config('view_url.view_url')}}mobile/company/css/common.css" />
    <style>
        .mui-scroll-wrapper {top: 1.7rem;bottom: 0;}
        .mui-bar-nav {background: #025a8d;}
        .mui-icon-back,.mui-title {color: rgba(255, 255, 255, .8);}
        .btn-positive{margin-left: .2rem;}
        .menu-wrapper{height: .88rem;line-height: .88rem;font-size: 0;}
        .menu-wrapper>span{font-size: .26rem;display: inline-block;width: 25%;text-align: center;}
        .menu-wrapper>span.active{position: relative;color: #00A2FF;}
        .menu-wrapper>span.active:after{position: absolute;bottom: .1rem;left: .7rem;content: '';width: .5rem;height: .06rem;border-radius: 15px;background: #00A2FF;}
        .guarantee-wrapper>li{padding: 0 .3rem;margin-bottom: .2rem;background: #fff;}
        .guarantee-code{height: .54rem;line-height: .54rem;border-bottom: 1px solid #dcdcdc;}
        .status{color: #FFAD00;}
        .guarantee-name,h1{font-size: .32rem;font-weight: normal;}
        .guarantee-info{color: #ADADAD;border-bottom: 1px solid #dcdcdc;}
        .guarantee-info div{line-height: .8rem;}
        .guarantee-info p{line-height: .4rem;}
        .btn-wrapper{padding: .6em 0;text-align: right;}
        .inGuarantee .status,.inGuarantee h1{color: #00a2ff;}
        .inGuarantee p{color: #313131;}
    </style>
</head>

<body>
<div class="main">
    <header class="mui-bar mui-bar-nav">
        <a class="mui-icon mui-icon-back mui-pull-left" href="/"></a>
        <h1 class="mui-title">订单管理</h1>
    </header>
    <div class="mui-content">
        <div class="menu-wrapper">
            <span class="active">全部</span>
        </div>
        <div class="mui-scroll-wrapper">
            <div class="mui-scroll">
                <ul class="guarantee-wrapper">
                    @foreach($order_list as $k=>$v)
                    <li>
                        <div class="guarantee-code"><a href="/mpersonal/order_detail/{{$v['order_code']}}">订单号：{{$v['order_code']}}</a><span class="status fr">@if($v['status'] == 2)待支付@else已支付@endif</span></div>
                        <div class="guarantee-info">
                            <div class="guarantee-name">
                                <div class="fr">保费：￥{{$v['premium']/100}}</div>
                                <h1>{{$v->attributes['product_name']}}</h1>
                            </div>
                            <p>被保人：
                                @foreach($v['warranty_recognizee'] as $vv)
                                    {{ $vv->name }}
                                @endforeach
                            </p>
                            <p>保障时间：{{explode(' ',$v['start_time'])[0]}}</p>
                            <p>发起时间：{{$v['created_at']}}</p>
                        </div>
                        <div class="btn-wrapper">
                            {{--<button class="btn-positive">修改信息</button>--}}
                            @if($v['status'] == 2)
                                <button class="btn-primary"><a href="/ins/pay_again/{{$v['order_code']}}">立即支付</a></button>
                            @else

                            @endif

                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>

<script src="{{config('view_url.view_url')}}mobile/company/js/lib/jquery-1.11.3.min.js"></script>
<script src="{{config('view_url.view_url')}}mobile/company/js/lib/mui.min.js"></script>
<script src="{{config('view_url.view_url')}}mobile/company/js/common.js"></script>
<script>
    mui('.mui-scroll-wrapper').scroll({
        deceleration: 0.0005,
    });
    $('.menu-wrapper>span').on('tap',function(){
        $(this).addClass('active').siblings().removeClass('active');
    });
    $('.mui-icon mui-icon-back mui-pull-left mui-action-back').click(function(){
        window.history.back();
    })
</script>
</body>

</html>