{{--头部--}}
<link rel="stylesheet" href="{{ url(config('resource.position.css').'/frontend/head.css') }}">

<div class="nav">
    <ul>
        @if(!isset($_COOKIE['user_name']))
        <li><span class="hello">你好，请 </span> <a href="" class="login-btn">登录</a> <a href="" class="register">注册</a></li>
        @endif
        <li>手机xx</li>
        <li>我的xx</li>
        <li>xx商城</li>
        <li>帮助中心</li>
        <li>保单查询</li>
        <li>网址导航</li>
        <li>
            <span class="service">人工客服</span>
            <span class="nav-phone">4006 366 366</span>
        </li>

        <div class="ClearFix"></div>
    </ul>
</div>

<div class="head-bottom">


    <div class="head-bottom-left">
        <div class="logo">

        </div>
        <div class="head-classify">
            <ul>
                <li>首页</li>
                <li>推荐</li>
                <li>专题</li>
                <li>定制</li>
                <li>理赔</li>
                <div class="ClearFix"></div>
            </ul>
        </div>
    </div>
    <div class="head-bottom-right">
        <div class="head-policy-step">

        </div>
    </div>
    <div class="ClearFix"></div>



</div>