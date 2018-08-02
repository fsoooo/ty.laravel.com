<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>天眼互联-科技让保险无限可能</title>
    <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
    <link rel="stylesheet" href="{{config('view_url.view_url')}}mobile/personal/css/lib/mui.min.css">
    <link rel="stylesheet" href="{{config('view_url.view_url')}}mobile/personal/css/lib/mui.picker.all.css">
    <link rel="stylesheet" href="{{config('view_url.view_url')}}mobile/personal/css/lib/iconfont.css" />
    <link rel="stylesheet" href="{{config('view_url.view_url')}}mobile/personal/css/common.css" />
    <style>
        .mui-scroll-wrapper {top: 1.7rem;bottom: 0;}
        .mui-bar-nav {background: #025a8d;}
        .mui-icon-back,.mui-title {color: rgba(255, 255, 255, .8);}
        .btn-positive{margin-left: .2rem;}

        .menu-wrapper{
            height: .88rem;
            line-height: .88rem;
            font-size: 0;
        }
        .menu-wrapper>span{
            font-size: .26rem;
            display: inline-block;
            width: 20%;
            text-align: center;
        }
        .menu-wrapper>span.active{
            position: relative;
            color: #00A2FF;
        }
        .menu-wrapper>span.active:after{
            position: absolute;
            bottom: .1rem;
            left: .24rem;
            content: '';
            width: .5rem;
            height: .06rem;
            border-radius: 15px;
            background: #00A2FF;
        }
        .guarantee-wrapper>li{
            padding: 0 .3rem;
            margin-bottom: .2rem;
            background: #fff;
        }
        .guarantee-code{
            height: .54rem;
            line-height: .54rem;
            border-bottom: 1px solid #dcdcdc;
        }
        .status{
            color: #FFAD00;
        }
        .guarantee-name,h1{
            font-size: .32rem;
            font-weight: normal;
        }
        .guarantee-info{
            color: #ADADAD;
            border-bottom: 1px solid #dcdcdc;
        }
        .guarantee-info div{
            line-height: .8rem;
        }
        .guarantee-info p{
            line-height: .4rem;
        }
        .btn-wrapper{
            padding: .6em 0;
            text-align: right;
        }
        .inGuarantee .status,.inGuarantee h1{
            color: #00a2ff;
        }
        .inGuarantee p{
            color: #313131;
        }
    </style>
</head>

<body>
<div class="main">
    <header class="mui-bar mui-bar-nav">
        <a class="mui-icon mui-icon-back mui-pull-left mui-action-back"></a>
        <h1 class="mui-title">我的保单</h1>
    </header>
    <div class="mui-content">
        <div class="menu-wrapper">
            <span class="active">全部({{$count}})</span>
            <span>有效({{$count}})</span>
            <span>失效()</span>
            <span>停效()</span>
            <span>退保()</span>
        </div>
        <div class="mui-scroll-wrapper">
            <div class="mui-scroll">
                <ul class="guarantee-wrapper">
                    @foreach($users as $v)
                    <li>
                        <div class="guarantee-code">保单号：{{$v->warranty_code}}<span class="status fr">
                                @if($v->status == 0)
                                    待生效
                                 @elseif($v->status == 1)
                                    保障中
                                    @elseif($v->status == 2)
                                    失效
                                    @else
                                    退保
                                    @endif
                            </span></div>
                        <div class="guarantee-info">
                            <div class="guarantee-name">
                                <div class="fr">保费：{{$v->premium/100}}元</div>
                                <h1><a href="/guarantee/guarantee_detail/{{$v->warranty_code}}">{{$v->product_name}}</a></h1>
                            </div>
                            <p>被保人：{{$v->name}}</p>
                            <p>保障时间：{{$v->start_time}}至{{$v->end_time}}</p>
                            {{--<p>发起时间：2017-08-17  11:12:59</p>--}}
                        </div>
                        <div class="btn-wrapper">
                            <button class="btn-positive">退保记录</button>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>

<script src="{{config('view_url.view_url')}}mobile/personal/js/lib/jquery-1.11.3.min.js"></script>
<script src="{{config('view_url.view_url')}}mobile/personal/js/lib/mui.min.js"></script>
<script src="{{config('view_url.view_url')}}mobile/personal/js/lib/mui.picker.all.js"></script>
<script src="{{config('view_url.view_url')}}mobile/personal/js/common.js"></script>
<script>
    mui('.mui-scroll-wrapper').scroll({
        deceleration: 0.0005,
    });
    $('.menu-wrapper>span').on('tap',function(){
        console.log('12')
        $(this).addClass('active').siblings().removeClass('active');
    })





</script>
</body>

</html>