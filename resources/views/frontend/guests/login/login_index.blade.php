<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta charset="UTF-8">
    <title>天眼互联-科技让保险无限可能</title>
    <link rel="stylesheet" href="{{config('view_url.view_url').'css/lib/iconfont.css'}}" />
    <link rel="stylesheet" href="{{config('view_url.view_url').'css/lib/idangerous.swiper.css'}}" />
    <link rel="stylesheet" href="{{config('view_url.view_url').'css/login.css'}}" />
</head>

<body>
<div class="banner">
    <div class="swiper-container">
        <div class="swiper-wrapper">
            <div class="swiper-slide">
                <img src="{{config('view_url.view_url').'image/TB1pfG4IFXXXXc6XXXXXXXXXXXX.jpg'}}" />
            </div>
            <div class="swiper-slide">
                <img src="{{config('view_url.view_url').'image/TB1sXGYIFXXXXc5XpXXXXXXXXXX.jpg'}}" />
            </div>
        </div>
    </div>

    <div class="main">
        <div class="header">
            <div class="nav">
                <a href="/"><div class="logo"></div></a>
                {{--<div class="entry">--}}
                    {{--我已有账户<a href="#">快速登录</a>--}}
                {{--</div>--}}
            </div>

        </div>
        <div class="wrapper">
            <div class="slogon">科技让保险无限可能</div>
            <div class="buttonbox">
                <a href="/login_person"><button><i class="iconfont icon-yonghudenglu"></i>个人登录</button></a>
                <a href="/login_company"><button><i class="iconfont icon-duoren"></i>企业登录</button></a>
                <a href="/agent_login"><button><i class="iconfont icon-yonghudenglu"></i>代理人登录</button></a>
                {{--<a href="/login_person"><button><i class="iconfont icon-duoren"></i>团体/组织登录</button></a>--}}
                {{--<br>--}}
                {{--<br>--}}
                {{--<br>--}}
                {{--<a href="/register_front"><button><i class="iconfont icon-duoren" ></i>前往注册</button></a>--}}
            </div>
        </div>
    </div>
</div>
</body>
<script src="{{config('view_url.view_url').'js/lib/jquery-1.11.3.min.js'}}"></script>
<script src="{{config('view_url.view_url').'js/lib/idangerous.swiper.min.js'}}"></script>
<script src="{{config('view_url.view_url').'js/login.js'}}"></script>

</html>