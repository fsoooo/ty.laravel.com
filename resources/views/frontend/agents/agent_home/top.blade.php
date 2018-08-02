<div class="header-left">
    <div class="logo">
        <img src="{{config('view_url.agent_url')}}img/logo.png"/>
    </div>
    <div class="welcome">
        <i class="iconfont icon-chenggong"></i>您好，{{$_COOKIE['agent_name']}}
        @if($authentication == 0 || $authentication == 1)
        <!--未认证start-->
        <div class="exit-wrapper">
            <div class="exit-top">
                <div class="avatar">
                    <img src="{{config('view_url.agent_url')}}img/boy.png" alt="" />
                </div>
                <div class="info">
                    <p class="status">未认证</p>
                    <a href="/agent/account">实名认证后才可以进行相关操作及查看相关信息，马上去实名<i class="iconfont icon-gengduo"></i></a>
                </div>
            </div>
            <div class="exit-bottom">
                <a href="/agent/account">我的账户</a>&nbsp;|&nbsp;<span id="btn-exit"><a href="/agent_logout">退出</a></span>
            </div>
        </div>
        <!--未认证end-->
        @else
        <!--已认证start-->
        <div class="exit-wrapper">
            <div class="exit-top">
                <div class="avatar">
                    <img src="{{config('view_url.agent_url')}}img/boy.png" alt="" />
                </div>
                <div class="info">
                    <p class="status has">已认证</p>
                    {{--<a href="performance.html">本月任务<i class="red">10万</i>元，已完成<i class="black">8万</i>元，本月剩余14天，查看业绩<i class="iconfont icon-gengduo"></i></a>--}}
                </div>
            </div>
            <div class="exit-bottom">
                <a href="/agent/account">我的账户</a>&nbsp;|&nbsp;<span id="btn-exit"><a href="/agent_logout">退出</a></span>
            </div>
        </div>
        <!--已认证end-->
        @endif

    </div>
    <a href="/agent_sale/agent_info">
    @if($option == 'index')
        @if(count($message_data) == 0)
    <span class="iconfont icon-xinxi"></span>
        @else
    <span class="iconfont icon-xinxi have">
        <i class="remind">{{count($message_data)}}</i>
    </span>
            @endif
    @endif
    </a>
</div>
<div class="header-right">
    <ul class="nav-wrapper">
        <li @if($option == 'index')class="active"@endif><a href="/agent">首页</a></li>
        {{--<li>活动列表</li>--}}
        <li @if($option == 'account')class="active"@endif><a href="/agent/account">账户设置</a></li>
    </ul>
</div>
<script>
//    $(function () {
//        $.ajax({
//            url: '/setting?name=logo',
//        }).done(function(data) {
//            if(data != ''){
//                $('.logo img').attr('src','upload/'+data);
//            }
//        });
//    });
</script>



{{--<div class="header-left">--}}
    {{--<div class="logo">--}}
        {{--<img src="{{config('view_url.agent_url')}}img/logo.png"/>--}}
    {{--</div>--}}
    {{--<p class="welcome"><i class="iconfont icon-chenggong"></i>您好，{{$_COOKIE['agent_name']}}</p>--}}

    {{--未认证--}}
    {{--<div class="exit-wrapper">--}}
        {{--<div class="exit-top">--}}
            {{--<div class="avatar">--}}
                {{--<img src="img/boy.png" alt="" />--}}
            {{--</div>--}}
            {{--<div class="info">--}}
                {{--<p class="status">未认证</p>--}}
                {{--<a href="account_approve.html">实名认证后才可以进行相关操作及查看相关信息，马上去实名<i class="iconfont icon-gengduo"></i></a>--}}
            {{--</div>--}}
        {{--</div>--}}
        {{--<div class="exit-bottom">--}}
            {{--<a href="account_unapprove.html">我的账户</a>&nbsp;|&nbsp;<span id="btn-exit">退出</span>--}}
        {{--</div>--}}
    {{--</div>--}}

    {{--<!--已认证start-->--}}
    {{--<div class="exit-wrapper">--}}
        {{--<div class="exit-top">--}}
            {{--<div class="avatar">--}}
                {{--<img src="img/boy.png" alt="" />--}}
            {{--</div>--}}
            {{--<div class="info">--}}
                {{--<p class="status has">已认证</p>--}}
                {{--<a href="performance.html">本月任务<i class="red">10万</i>元，已完成<i class="black">8万</i>元，本月剩余14天，查看业绩<i class="iconfont icon-gengduo"></i></a>--}}
            {{--</div>--}}
        {{--</div>--}}
        {{--<div class="exit-bottom">--}}
            {{--<a href="account.html">我的账户</a>&nbsp;|&nbsp;<span id="btn-exit">退出</span>--}}
        {{--</div>--}}
    {{--</div>--}}
    {{--<!--已认证end-->--}}
{{--</div>--}}
{{--<div class="header-right">--}}
    {{--<ul class="nav-wrapper">--}}
        {{--<li @if($option == 'index')class="active"@endif><a href="/agent">首页</a></li>--}}
        {{--<li>活动列表</li>--}}
        {{--<li @if($option == 'account')class="active"@endif><a href="/agent/account">账户设置</a></li>--}}
    {{--</ul>--}}
{{--</div>--}}