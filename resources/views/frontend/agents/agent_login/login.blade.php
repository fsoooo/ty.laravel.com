<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>天眼互联-科技让保险无限可能</title>
    <link rel="stylesheet" href="{{config('view_url.agent_url')}}css/lib/iconfont.css" />
    <link rel="stylesheet" href="{{config('view_url.agent_url')}}css/lib/unlock.css" />
    <link rel="stylesheet" href="{{config('view_url.agent_url')}}css/common_agent.css" />
    <link rel="stylesheet" href="{{config('view_url.agent_url')}}css/login.css" />
</head>
<body>

<div class="login-wrapper">

    <div class="login-left">
        <div class="logo">
            <img src="{{config('view_url.agent_url')}}img/logo.png"/>
        </div>
        <p class="info">此处填写代理人工具产品简介或标语，此处填写代理人工具产品简介或标语，此处填写代理人工具产品简介或标语，此处填写代理人工具产品简介或标语</p>
    </div>

    <div class="login-right">
        <div class="title"><i class="iconfont icon-xiugaitouxiang"></i>代理人登录</div>
        <form action="/agent_do_login" method="post">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="redirect" value="{{$redirect}}"/>
            <div>
            <ul class="form-wrapper">
                <li><input id="tel" type="tel" placeholder="手机号" maxlength="11" name="phone"/></li>
                <li><input id="password" type="password" placeholder="密码" name="password"/></li>
            </ul>
            <a href="/forget_password" class="btn-forget">忘记密码？</a>
            <div class="pattern" type="0" style="position: relative;">
                <div class="slide-to-unlock-bg" style="width: 298px; height: 38px; background-color: rgb(238, 238, 238);">
                    <span style="line-height: 38px; font-size: 12px; color: rgb(51, 51, 51);">请按住滑块，拖动至最右边</span>
                </div>
                <div class="slide-to-unlock-progress" style="background-color: rgb(35, 202, 86); height: 38px;"></div>
                <div class="slide-to-unlock-handle" style="background-color: rgb(238, 238, 238); height: 38px; line-height: 38px; width: 46px;">
                    <i class="iconfont icon-jiantouzuoshuang-"></i>
                </div>
            </div>
            <button id="login" class="z-btn z-btn-default" disabled>登录</button>
        </div>
        </form>
    </div>
</div>


<script src="{{config('view_url.agent_url')}}js/lib/jquery-1.11.3.min.js"></script>
<script src="{{config('view_url.agent_url')}}js/lib/unlock.js"></script>
<script src="{{config('view_url.agent_url')}}js/common_agent.js"></script>
<script>
    var $pattern = $('.pattern');
    $pattern.slideToUnlock({
        height : 30,
        succText : '验证通过',
        bgColor : '#d8d7d9',
        progressColor : '#23ca56',//已经拖动的颜色
        succColor : '#23ca56',  //成功的颜色
        textColor : '#fff',     //字体的颜色
        font_size : '16',
        succTextColor : '#fff',  //成功后的字体颜色
        handleColor : '#fff',
        successFunc : function () {
            $pattern.attr('type','1')
            check();
        }
    });

    $('input').bind('input propertychange', function() {
        check();
    });

    function check(){
        if(!$('#tel').val() || !$('#password').val() || !parseInt($('.pattern').attr('type'))){
            $('#login').prop('disabled',true);
        }else{
            $('#login').prop('disabled',false);
        }
    }
</script>
</body>
</html>
