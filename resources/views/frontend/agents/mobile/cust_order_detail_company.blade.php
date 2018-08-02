<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>天眼互联-科技让保险无限可能</title>
    <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
    <link rel="stylesheet" href="{{config('view_url.view_url')}}mobile/company/css/lib/mui.min.css">
    <link rel="stylesheet" href="{{config('view_url.view_url')}}mobile/company/css/lib/iconfont.css" />
    <link rel="stylesheet" href="{{config('view_url.view_url')}}mobile/company/css/common.css" />
    <link rel="stylesheet" href="{{config('view_url.view_url')}}mobile/company/css/information.css" />
    <style>
        .mui-scroll-wrapper{bottom: 0;background: #f7f7f7;}.mui-scroll{background: #fff;}
        .mui-popover{top: 0;}.bold{margin-top:.2rem;padding: 0 .2rem;}
        .applicant-wrapper li {height: 1rem;line-height: 1rem;position: relative;border-bottom: 1px solid #dcdcdc;}
        .list-wrapper{color: #adadad;}.content-wrapper{line-height: .8rem;}
        .content-wrapper li{border-bottom: 1px solid #dbdbdb;}.content-wrapper li:last-child{border-bottom: none;}
        .price-wrapper{line-height: .4rem;color: #ffae00;}.order-wrapper{line-height: .4rem;color: #adadad;}
        .payment-wrapper{position: absolute;bottom: 0;width: 100%;background: #fff;}
        .payment-title{margin: 0 .2rem;height: .9rem;font-size: .32rem;line-height: .9rem;color: #00a2ff;border-bottom: 1px solid #dbdbdb;}
        .payment-wrapper li{padding: 0 .6rem 0 .2rem;line-height: .9rem;}
        .btn-primary{height: 1rem;line-height: 1rem;font-size: .36rem;text-align: center;}.status{float: right;color: #00A2FF;}.name{display: inline-block;width: 3rem;}
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

                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="main">
    <header class="mui-bar mui-bar-nav">
        <a class="mui-icon mui-icon-back mui-pull-left mui-action-back"></a>
        <h1 class="mui-title">保单详情</h1>
    </header>
    <div class="mui-content">
        <div class="mui-scroll-wrapper">
            <div class="mui-scroll">
                <div class="information-wrapper">
                    <div>
                        <div class="status">
                            @if(isset($data->warranty_rule->warranty))
                                @if($data->warranty_rule->warranty['status'] == 0)
                                待生效
                                @elseif($data->warranty_rule->warranty['status'] == 1)
                                保障中
                                @elseif($data->warranty_rule->warranty['status'] == 2)
                                失效
                                @else
                                退保
                                @endif
                                @endif
                        </div>
                        <div class="information-name">{{$data->product['product_name']}}</div>
                        <ul class="list-wrapper">
                            <li>保单号：{{$data->warranty_rule->warranty?$data->warranty_rule->warranty['warranty_code']:'--'}}</li>
                        </ul>
                    </div>
                    <div class="division"></div>
                    <div>
                        <div class="title">保单信息</div>
                        @if(isset($data->warranty_rule->warranty))
                        <ul class="list-wrapper">
                            <li><span class="name">保障时间:</span>{{strtok($data->warranty_rule->warranty['start_time'],' ')}}至{{strtok($data->warranty_rule->warranty['end_time'],' ')}}</li>
                            <li><span class="name">保费:</span>{{$data->warranty_rule->warranty['premium']/100}}元</li>
                            <li><span class="name">缴费频次：</span>
                                @if(preg_replace('/\D/s','',$data['by_stages_way']) == 0)
                                    趸交
                                @else
                                    {{$data['by_stages_way']}}
                                @endif
                            </li>
                            <li><span class="name">保单形式：</span>电子保单</li>
                        </ul>
                            @else
                            <ul class="list-wrapper">
                                <li><span class="name">
                                         @if(isset($data->warranty_rule->warranty))
                                            已出单
                                        @else
                                            未出单
                                        @endif
                                    </span></li>
                            </ul>
                            @endif
                    </div>
                    <div class="division"></div>
                    <div>
                        <div class="title">保障权益</div>
                        <ul class="content-wrapper">
                            @if(isset($data->clauses))
                                @foreach($data->clauses['option']['protect_items'] as $k=>$v)
                                    <li data-id="{{$k+1}}">
                                        <span class="name">{{$v['name']}}</span>{{$v['defaultValue']}}
                                        <i class="iconfont icon-gengduo fr"></i>
                                        <input type="hidden" name="content" value="{{$v['description']}}">
                                    </li>
                                @endforeach
                            @endif
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
                    {{--<div class="division"></div>--}}
                    {{--<div>--}}
                        {{--<ul class="content-wrapper">--}}
                            {{--<li>--}}
                                {{--<span class="name">参保人员</span>--}}
                                {{--<i class="iconfont icon-gengduo fr"></i>--}}
                            {{--</li>--}}
                        {{--</ul>--}}
                    {{--</div>--}}
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{config('view_url.view_url')}}mobile/company/js/lib/jquery-1.11.3.min.js"></script>
<script src="{{config('view_url.view_url')}}mobile/company/js/lib/mui.min.js"></script>
<script src="{{config('view_url.view_url')}}mobile/company/js/common.js"></script>
<script>
    $('.content-wrapper li').on('tap',function(){
        mui('.noticePopover').popover('show');
    });

    $('.content-wrapper li').on('tap',function(){
        var id = $(this).data('id');
        // 根据获取的索引查找对应的详情信息赋值给html
        var html = $(this).children("input[name='content']").val();
        $('.notice-content .notice-list').html(html).css({'line-height':'.5rem'});
        mui('.noticePopover').popover('show');
    });
</script>
</body>

</html>