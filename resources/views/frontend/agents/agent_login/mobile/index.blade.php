<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>登录</title>
    <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
    <link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/lib/mui.min.css">
    <link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/lib/iconfont.css" />
    <link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/common_agent.css" />
</head>
<body>
<div class="mui-popover login-popover mui-active">
    <i class="iconfont icon-guanbi" id="back"></i>
    <div class="content content-login">
        <form id="login_form" action="/agent_do_login" method="post">
            <input type="hidden" name="_token" value="{{csrf_token()}}">
            <input type="hidden" name="redirect" value="{{$redirect}}"/>
        <ul>
            <li>
                <input class="tel" type="text" placeholder="手机号码" name="phone">
                <p style="display: none;" class="error-tips">没有该账户请更换其他账户或重新输入</p>
            </li>
            <li>
                <input class="psw" type="password" placeholder="密码" name="password">
                <p style="display: none;" class="error-tips">密码错误请重新输入</p>
            </li>
            {{--<li>--}}
                {{--<div class="stage">--}}
                    {{--<div class="slider" id="slider">--}}
                        {{--<div class="label">请按住滑块，拖动至最右边</div>--}}
                        {{--<div class="track" id="track">--}}
                            {{--<div class="bg-green"></div>--}}
                        {{--</div>--}}
                        {{--<div class="button" id="btn">--}}
                            {{--<i id="icon" class="iconfont icon-jiantouzuoshuang-"></i>--}}
                            {{--<div class="spinner" id="spinner"><i class="iconfont icon-chenggong"></i></div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</li>--}}
        </ul>
        </form>
        {{--<a href="/forget_password" class="btn-forget">忘记密码？</a>--}}

        <div class="bottom-wrapper">
            <button id="submit" class="btn-login" disabled>登录</button>
        </div>
    </div>
</div>
<script src="{{config('view_url.agent_mob')}}js/lib/jquery-1.11.3.min.js"></script>
<script src="{{config('view_url.agent_mob')}}js/lib/mui.min.js"></script>
<script src="{{config('view_url.agent_mob')}}js/common_agent.js"></script>
<script>
    var oBtn = document.getElementById('btn');
    var oW, oLeft;
    var oSlider = document.getElementById('slider');
    var oTrack = document.getElementById('track');
    var oIcon = document.getElementById('icon');
    var oSpinner = document.getElementById('spinner');
    var flag = 1;

    $('.icon-guanbi').on('tap', function() {
        window.location.href = "/";
//                location.reload();
    });
    $('#submit').click(function(){
        $('#login_form').submit();
    })
    if(oBtn){
        oBtn.addEventListener('touchstart', function(e) {
            if (flag == 1) {
                var touches = e.touches[0];
                oW = touches.clientX - oBtn.offsetLeft;
            }
        }, false);

        oBtn.addEventListener("touchmove", function(e) {
            var maxLength = oSlider.clientWidth - oBtn.offsetWidth;
            if (flag == 1) {
                var touches = e.touches[0];
                oLeft = touches.clientX - oW;
                if (oLeft < 0) {
                    oLeft = 0;
                } else if (oLeft > maxLength) {
                    oLeft = maxLength;
                }
                oBtn.style.left = oLeft + "px";
                oTrack.style.width = oLeft + 'px';
            }
        }, false);

        oBtn.addEventListener("touchend", function() {
            var maxLength = oSlider.clientWidth - oBtn.offsetWidth;
            if (oLeft >= maxLength) {
                oIcon.style.display = 'none';
                oSpinner.style.display = 'block';
                flag = 0;
                $('.bg-green').text('完成验证');
                $('#submit').attr('disabled',false);

            } else {
                oBtn.style.left = 0;
                oTrack.style.width = 0;
            }
        }, false);
    }





</script>
</body>
</html>
