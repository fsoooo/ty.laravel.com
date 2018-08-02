<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>天眼互联-科技让保险无限可能</title>
    <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
    <link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/lib/mui.min.css">
    <link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/lib/iconfont.css" />
    <link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/lib/swiper-3.4.2.min.css" />
    <link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/common_agent.css" />
    <link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/index.css" />
</head>
<body>
<div class="header">
    <div class="toolbar">
        {{--<div class="search">--}}
            {{--<i class="iconfont icon-sousuo"></i>--}}
            {{--<input type="text" placeholder="搜索计划书"/>--}}
        {{--</div>--}}
        <div class="msg">
            <a href="/agent_sale/agent_message"><i class="iconfont icon-xiaoxi"></i></a>
        </div>
    </div>
    <div class="banner">
        <div class="swiper-container swiper-banner">
            <div class="swiper-wrapper">
                <div class="swiper-slide"><img src="{{config('view_url.agent_mob')}}img/banner.png" alt="" /></div>
                <div class="swiper-slide"><img src="{{config('view_url.agent_mob')}}img/banner.png" alt="" /></div>
                <div class="swiper-slide"><img src="{{config('view_url.agent_mob')}}img/banner.png" alt="" /></div>
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>
    <div class="price">
        <a href="/agent_sale/add_plan" class="fr zbtn zbtn-positive">马上去赚钱</a>
        <p><i class="iconfont icon-xiaofeitongji"></i>本月已累计佣金金额：{{$data/100}} 元</p>
    </div>
</div>
<div class="division"></div>
<div class="mui-scroll-wrapper">
    <div class="mui-scroll">
        <div class="section">
            <h2 class="title">热销推荐</h2>
            <div class="hot-wrapper">
                <div class="swiper-container swiper-hot">
                    <div class="swiper-wrapper">
                        @if($product_count == 0)
                            暂时没有可以代理的产品
                        @else
                        @foreach($product_list as $v)
                        <div class="swiper-slide">
                            <div class="hot-img">
                                <img src="{{config('view_url.agent_mob')}}img/banner.png" alt="" />
                                <p style="width:8em;display:block;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{$v['product_name']}}</p>
                                <div class="percent">{{$v['rate']['earning']}}%佣金</div>
                            </div>
                            {{--<p>{{$v['main_name']}}</p>--}}
                        </div>
                        @endforeach
                            @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="division"></div>

        <div class="section">
            <h2 class="title">产品列表<a class="more" href="/agent_sale/agent_product">更多<i class="iconfont icon-gengduo"></i></a></h2>
            <div class="product-wrapper">
                <ul>
                    @if($product_count == 0)
                        暂时没有可以代理的产品
                    @else
                        @foreach($product_list as $v)
                    <li>
                        <div class="product-img">
                            <img src="{{config('view_url.agent_mob')}}img/product.png"/>
                        </div>
                        <div class="product-right">
                            <a href="/agent_sale/add_plan" class="zbtn zbtn-default">制作计划书</a>
                            <p>￥{{$v['premium']/100}}</p>
                        </div>
                        <h3 class="name" style="width:12em;display:block;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{$v['product_name']}}</h3>
                        <p class="info" style="width:12em;display:block;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{$v['company_name']}}出品</p>
                        <p class="num"><span>评论:1200</span><span>销量:1200</span><span class="color-positive">推广费:{{$v['rate']['earning']}}%</span></p>
                    </li>
                        @endforeach
                        @endif
                </ul>
            </div>
        </div>
    </div>
</div>
<ul class="bottom-nav">
    <li class="nav-item1 active">
        <div class="myicon shouye3"></div>
        <div class="icon-wrapper">
            <div class="iconfont icon-shouye3"></div>
        </div>

        <div class="text">首页</div>
    </li>
    <li>
        <a href="/agent_sale/cust_lists">
        <div class="icon-wrapper">
            <div class="iconfont icon-shouye1"></div>
        </div>
        <div class="text">我的客户</div>
        </a>
    </li>

    <li>
        <a onclick="mui('.select-popover').popover('toggle');">
            <div class="icon-wrapper">
            <div class="iconfont icon-icon"></div>
            </div>
            <div class="text">制作计划书</div>
        </a>
    </li>
    {{--<li>--}}
        {{--<a href="">--}}
            {{--<div class="icon-wrapper">--}}
                {{--<div class="iconfont icon-icon"></div>--}}
            {{--</div>--}}
            {{--<div class="text">制作计划书</div>--}}
        {{--</a>--}}
    {{--</li>--}}
    <li class="nav-item4">
        <a href="/agent_sale/user">
            <div class="myicon shouye"></div>
            <div class="icon-wrapper">
                <div class="iconfont icon-shouye"></div>
            </div>
            <div class="text">我的</div>
        </a>
    </li>
</ul>
<div class="mui-popover select-popover">
    <a class="item" href="/agent_sale/add_plan">个人</a>
    <a class="item" href="/agent_sale/add_plan_company">企业</a>
</div>
<script src="{{config('view_url.agent_mob')}}js/lib/jquery-1.11.3.min.js"></script>
<script src="{{config('view_url.agent_mob')}}js/lib/mui.min.js"></script>
<script src="{{config('view_url.agent_mob')}}js/lib/swiper-3.4.2.min.js"></script>
<script src="{{config('view_url.agent_mob')}}js/common_agent.js"></script>
<script>
    var mySwiper = new Swiper('.swiper-banner', {
        loop : true,
//				autoplay: 1000,
        pagination : '.swiper-pagination',
    });
    var mySwiper = new Swiper('.swiper-hot', {
        slidesPerView: 4,
//				spaceBetween: 20,
        slidesOffsetBefore: 10,
        slidesOffsetAfter: 90

    });
</script>
</body>
</html>
