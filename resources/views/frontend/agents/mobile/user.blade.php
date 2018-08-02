<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>天眼互联-科技让保险无限可能</title>
    <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
    <link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/lib/mui.min.css">
    <link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/lib/iconfont.css" />
    <link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/common_agent.css" />
    <link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/user.css" />
    <link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/index.css" />
    <style>
        .header-img{overflow:hidden}
    </style>
</head>
<body>
<div class="header-wrapper">
    <div class="header-top">
        <div class="msg">
            <a href="/agent_sale/agent_message"><i class="iconfont icon-xiaoxi"></i></a>
        </div>

        @if(isset($info->img))
            <div class="header-img" style="background-repeat:no-repeat; ">
                <img src="{{$info->img}}" />
            </div>
        @else
            <div class="header-img"  style="background-image:url({{config('view_url.agent_mob')}}img/boy.png)"></div>
        @endif

        @if(isset($info['name']))
            <p>Hi，{{$info['name']}}</p>
        @else
            <p>Hi，{{$res->user['name']}}</p>
        @endif
        <p class="status">@if($authentication == 2) 已认证 @else 未认证 @endif</p>
        <a href="/agent_sale/user_detail"><i class="iconfont icon-gengduo"></i></a>
    </div>
    <div class="header-bottom">
        <li>
            <span>{{count($order)}}个</span>
            <p>累计完成订单</p>
        </li>
        <li>
            <span>{{$sum/100}}元</span>
            <p>累计收入</p>
        </li>
        <li>
            <span class="color-positive">{{$sum_now/100}}元</span>
            <p>本月收入</p>
        </li>
        <li>
            <span>{{count($order_now)}}个</span>
            <p>本月完成订单</p>
        </li>
    </div>
</div>
<div class="mui-scroll-wrapper">
    <div class="mui-scroll">
        <ul class="user-list">
            <li><a href="/agent_sale/plan_lists">
                <i class="zicon zicon-jihuashu"></i>
                <span>我的计划书</span>
                <i class="iconfont icon-gengduo"></i>
                </a>
            </li>
            <li><a href="/agent_sale/agent_order">
                <i class="zicon zicon-dingdan"></i>
                <span>我的订单</span>
                <i class="iconfont icon-gengduo"></i>
                </a>
            </li>
            <li><a href="/agent_sale/cust_lists">
                <i class="zicon zicon-kehu"></i>
                <span>我的客户</span>
                <i class="iconfont icon-gengduo"></i></a>
            </li>
            <li><a href="/agent_sale/demand">
                <i class="zicon zicon-xuqiu"></i>
                <span>我的需求</span>
                <i class="iconfont icon-gengduo"></i></a>
            </li>
            <li>
                <a href="/agent_sale/agent_product">
                <i class="zicon zicon-chanpin"></i>
                <span>我的产品</span>
                <i class="iconfont icon-gengduo"></i>
                </a>
            </li>
            <li>
                <a href="/agent_sale/agent_performance">
                    <i class="zicon zicon-yeji"></i>
                    <span>我的业绩</span>
                    <i class="iconfont icon-gengduo"></i>
                </a>
            </li>
        </ul>
        <div class="division"></div>

        <ul class="user-list">
            {{--<li>--}}
                {{--<i class="zicon zicon-huodong"></i>--}}
                {{--<span>活动列表</span>--}}
                {{--<i class="iconfont icon-gengduo"></i>--}}
            {{--</li>--}}
            <li>
                <a href="/agent_sale/communication">
                    <i class="zicon zicon-jihuashu"></i>
                    <span>记录沟通</span>
                    <i class="iconfont icon-gengduo"></i>
                </a>
            </li>
        </ul>
        {{--<div class="division"></div>--}}
        {{--<ul class="user-list">--}}
            {{--<li>--}}
                {{--<a href="/agent_sale/offlineMobile">--}}
                    {{--<i class="zicon zicon-xianxiadan"></i>--}}
                    {{--<span>线下单录入</span>--}}
                    {{--<i class="iconfont icon-gengduo"></i>--}}
                {{--</a>--}}
            {{--</li>--}}
        {{--</ul>--}}
        <div class="division"></div>
        <ul class="user-list">
            <li class="exit"><a href="/agent_logout">退出</a></li>
        </ul>

    </div>
</div>
        <ul class="bottom-nav">
            <li class="nav-item1">
                <a href="/agent">
                    <div class="myicon shouye3"></div>
                    <div class="icon-wrapper">
                        <div class="iconfont icon-shouye3"></div>
                    </div>
                    <p class="text">首页</p>
                </a>
            </li>
            <li>
                <a href="/agent_sale/cust_lists">
                <div class="icon-wrapper">
                    <div class="iconfont icon-shouye1"></div>
                </div>
                <p class="text">我的客户</p>
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
                {{--<a href="/agent_sale/add_plan">--}}
                    {{--<div class="icon-wrapper">--}}
                        {{--<div class="iconfont icon-icon"></div>--}}
                    {{--</div>--}}
                    {{--<p class="text">制作计划书</p>--}}
                {{--</a>--}}
            {{--</li>--}}
            <li class="nav-item4 active">
                <a href="/agent_sale/user">
                    <div class="myicon shouye"></div>
                    <div class="icon-wrapper">
                        <div class="iconfont icon-shouye"></div>
                    </div>
                    <p class="text">我的</p>
                </a>
            </li>
        </ul>
<div class="mui-popover select-popover">
    <a class="item" href="/agent_sale/add_plan">个人</a>
    <a class="item" href="/agent_sale/add_plan_company">企业</a>
</div>


<script src="{{config('view_url.agent_mob')}}js/lib/jquery-1.11.3.min.js"></script>
<script src="{{config('view_url.agent_mob')}}js/lib/mui.min.js"></script>
<script src="{{config('view_url.agent_mob')}}js/common_agent.js"></script>
</body>
</html>
