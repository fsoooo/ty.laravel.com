{{--头部--}}
<link rel="stylesheet" href="{{ url(config('resource.position.css').'/frontend/head.css') }}">
<div class="nav">
    <ul>
        <li>
            @if(!Auth::check()&&!isset($_COOKIE['login_type']))
                <span class="hello">你好，请</span>
                <a href="{{url('/login')}}" class="login-btn">登录</a>
                <a href="{{url('/register')}}" class="register">注册</a>
            @else
                <a href="{{url('/information/index')}}" class="login-btn">个人中心</a>
            @endif
        {{--<li>手机xx</li>--}}
        {{--<li>我的xx</li>--}}
        {{--<li>xx商城</li>--}}
        {{--<li>帮助中心</li>--}}
        {{--<li>保单查询</li>--}}
        {{--<li>网址导航</li>--}}
        <li>
            <span class="service">人工客服</span>
            <span class="nav-phone">010-57145598</span>
        </li>

        <div class="ClearFix"></div>
    </ul>
</div>

<div class="head-bottom">


    <div class="head-bottom-left">
        <div class="logo">
            <a href="{{ url('/') }}"><img src="{{ config('resource.image.logo') }}" alt=""></a>
        </div>
        <div class="head-classify">
            <ul>
                <li>首页</li>
                <li><a href="/group_ins">团险</a></li>
                {{--<li>专题</li>--}}
                {{--<li>定制</li>--}}
                {{--<li>理赔</li>--}}
                <div class="ClearFix"></div>
            </ul>
        </div>
    </div>
    <div class="head-bottom-right">
        <div class="search">
            <input type="text" name="" class="head-search-block" placeholder="请输入关键字">
            <input type="button" class="head-search-btn" style="background: url({{ config('resource.image.main_search') }})">
        </div>

        <div class="shopping">
            <img src="{{ config('resource.image.main_cart') }}" alt="">
            <span>我的购物车</span>
        </div>
        <div class="center">
            <a href="{{ url('/information/index') }}"><img src="{{ config('resource.image.main_center') }}" alt="" cl>
            <span>个人中心</span></a>
        </div>
    </div>
    <div class="ClearFix"></div>



</div>