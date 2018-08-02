<div class="header-wrapper">
    <div class="header-top clearfix">
        <div class="header-content">
            <!--<span>您好，xx</span>-->
            {{--{{dd($_COOKIE)}}--}}
            @if(!isset($_COOKIE['user_id']))
                <span>您好，请<a href="#" class="btn-login">登录</a><a class="btn-register" href="#">免费注册</a></span>
            @else
                <span><a href="#" class="btn-login">@if(isset($_COOKIE['user_name'])){{$_COOKIE['user_name']}}@endif</a></span><a class="btn-register" href="/logout">退出</a>
            @endif
            {{--<ul class="nav-top">--}}
                {{--<li>--}}
                    {{--<a href="#">我的保险</a>--}}
                    {{--<i class="iconfont icon-jiantou2"></i>--}}
                    {{--<div class="dropdown dropdown-list">--}}
											{{--<span class="dropdown-title">--}}
												{{--<a href="#">我的保险</a>--}}
												{{--<i class="iconfont icon-jiantou2"></i>--}}
											{{--</span>--}}
                        {{--<ul>--}}
                            {{--<li>--}}
                                {{--<a href="#">所有保单</a>--}}
                            {{--</li>--}}
                            {{--<li>--}}
                                {{--<a href="#">待支付订单</a>--}}
                            {{--</li>--}}
                            {{--<li>--}}
                                {{--<a href="#">进度总览</a>--}}
                            {{--</li>--}}
                            {{--<li>--}}
                                {{--<a href="#">发起理赔</a>--}}
                            {{--</li>--}}
                        {{--</ul>--}}
                    {{--</div>--}}
                {{--</li>--}}
            {{--</ul>--}}
        </div>
    </div>

    <div class="header-bottom clearfix">
        <div class="header-bottom-logo">
            <img src="{{config('view_url.company_url').'image/logo.png'}}" />
        </div>
        <div class="header-bottom-index">
            <h1>我的天眼</h1>
            <a class="btn-index" href="{{url('/')}}">返回超市首页</a>
        </div>
        <div class="nav-bottom">
            <a @if($option_type == 'index') class="active" @endif href="{{url('/information')}}">首页</a>
            <a @if($option_type == 'information') class="active" @endif href="{{url('/information/guest_info')}}">账户设置</a>
            <a @if($option_type == 'message') class="active" @endif href="{{url('/message/index')}}">消息</a>
        </div>
    </div>
</div>