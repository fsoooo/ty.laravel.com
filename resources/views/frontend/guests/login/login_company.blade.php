@extends('frontend.guests.guests_layout.login_layout.base')
@section('content')

    <div class="main">
        <div class="bg">
        </div>
        <div class="login-block-wrap">
            <div class="login-block">
                <div class="login-type">
                    <ul>
                        <li class="login-type-choose">手机号登录</li>
                        <li class="login-type-no-choose">账号登录</li>
                        <div class="ClearFix"></div>
                    </ul>
                </div>

                <div class="phone-block login-type-block">
                    <form action="/phone_login" class="form" id="login_form_phone" method="post">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="password" value="******">
                        <div class="user-name">
                            <input type="text" class="input" id="phone_input" name="phone" placeholder="手机号" >
                        </div>
                        <div class="phone-pattern">
                            <input type="text" name="phone_code" class="pattern-input" placeholder="验证码">
                            <input type="button" class="pattern-button" value="获取验证码" id="phone_submit" style="width: 117px">
                        </div>
                        <div class="remember-me">
                            <label><div class="remember-check-box">
                                    <input type="checkbox">
                                </div>
                                <div class="remember-me-content">
                                    记住账号
                                </div>
                            </label>
                        </div>
                        <div class="login-button">
                            <input type="submit" class="login-button-input" value="点击登录">
                        </div>
                        <div class="account-forget-register">
                            {{--<div class="account-forget">--}}
                            {{--<a href="/agent_login">代理人登录</a>--}}
                            {{--</div>--}}
                            <div class="account-forget">
                                <a href="/findpwd">忘记密码</a>
                            </div>
                            <div class="account-register">
                                <a href="{{ url('/register_front') }}">注册新账号</a>
                            </div>
                        </div>
                        <div class="ClearFix"></div>
                        @php $path = str_replace('http://','',env('APP_URL'));@endphp
                        @if(!empty(config('third_api_url')[$path]))
                            <div class="relevance">
                                <div class="relevance-describe">
                                    使用第三方登录
                                    <span id="hzy_fast_login"></span>
                                </div>
                                <script type="text/javascript" src="{{config('third_api_url')[$path]['api_urls']}}"></script>
                                {{--<a href="https://open.weixin.qq.com/connect/qrconnect?appid=wxe1d4164a739689d2&redirect_uri=http%3A%2F%2Fdev312.inschos.com%2Fwe_chat&response_type=code&scope=snsapi_login&state=46F94C8DE14FB36680850768FF1B7F2A" style="margin-left: -20px">--}}
                                    {{--<img src="{{config('view_url.view_url').'image/weixin.jpg'}}" style="display: block;border-radius: 8px;margin-bottom: -10px;">--}}
                                {{--</a>--}}
                            </div>
                        @else
                            <div class="relevance">
                                <div class="relevance-describe">
                                    <span id="hzy_fast_login"></span>
                                </div>
                            </div>
                        @endif
                    </form>
                </div>
                <div class="account-block login-type-block" hidden>
                    <form role="form" action="{{url('/do_login_company')}}" method="post" class="form" onsubmit="return check_user_name()">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="user-name">
                            <input type="text" id="user_name"   class="input" name="email" placeholder="邮箱/证件号">
                        </div>
                        <div class="password">
                            <input type="password" id="password" name="password" class="input" placeholder="密码">
                        </div>
                        <div class="remember-me">
                            <label><div class="remember-check-box">
                                    <input type="checkbox">
                                </div>
                                <div class="remember-me-content">
                                    记住账号
                                </div></label>
                        </div>
                        <div class="pattern" type="0" style="position: relative;">
                            <div class="slide-to-unlock-bg" style="width: 300px; height: 38px; background-color: #00a2ff;">
                                <span style="line-height: 38px; font-size: 12px; color: rgb(51, 51, 51);">请按住滑块，拖动至最右边</span>
                            </div>
                            <div class="slide-to-unlock-progress" style="background-color: #00a2ff; height: 38px;">
                            </div>
                            <div class="slide-to-unlock-handle" style=" background-color: #00a2ff; height: 38px; line-height: 40px; width: 46px;">
                                <img class="icon-arrow" src="{{config('view_url.view_url').'login/image/arrow.png'}}" alt="" >
                                <img class="icon-success" src="{{config('view_url.view_url').'login/image/success.png'}}" alt="" hidden>
                            </div>
                        </div>
                        <div class="login-button">
                            <button type="button" class="login-button-input">点击登录</button>
                        </div>
                        <div class="account-forget-register">
                            {{--<div class="account-forget">--}}
                            {{--<a href="/agent_login">代理人登录</a>--}}
                            {{--</div>--}}
                            <div class="account-forget">
                                {{--<a href="/findpwd">忘记密码</a>--}}
                            </div>
                            <div class="account-register">
                                <a href="{{ url('/register_front') }}">注册新账号</a>
                            </div>
                        </div>
                        <div class="ClearFix"></div>
                        <div class="relevance2">
                            <div class="relevance-describe">
                                {{--使用第三方登录--}}
                                {{--<span id="hzy_fast_login"></span>--}}
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="http://res.wx.qq.com/connect/zh_CN/htmledition/js/wxLogin.js"></script>
    <script src="{{config('view_url.view_url').'login/js/jquery-3.1.1.min.js'}}"></script>
    <script src="{{config('view_url.view_url').'js/common.js'}}"></script>
    <script src="{{config('view_url.view_url').'login/js/frontend/login/login.js'}}"></script>
    <script src="{{config('view_url.view_url').'login/org/un_lock/assets/js/unlock.js'}}"></script>
    @include('frontend.guests.guests_layout.notice_alert')
    <script>
        {{--微信第三方登陆--}}
        var obj = new WxLogin({
            id:"login_container",
            appid: "wxe1d4164a739689d2",
            scope: "snsapi_login",
            redirect_uri: "dev312.inschos.com/we_chat",
            state: "46F94C8DE14FB36680850768FF1B7F2A",
//            style: "",
//            href: ""
        });

        function check_user_name() {
            var user_name = $("#user_name").val();
            var password = $("#password").val();
            var myreg = /^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;
            var user_type = myreg.test(user_name);
            if(user_type){
                if(password.length < 6){
                    Mask.alert("密码不少于6位",3);
                    return false;
                }else{
                    return true;
                }
            }else{
                if(!user_name|| !user_type){
                    Mask.alert("请输入正确的邮箱地址",3);
                    location.reload();
                    return false;
                }else if(password.length<6){
                    Mask.alert("密码不少于6位",3);
                    return false;
                }else{
                    return true;
                }
            }
        }


        $(function(){
            $("#phone_submit").click(function(){
                var reg = /^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/;
                var email = $("#user_name").val();
                if(!email||reg.test(email)){
                    Mask.alert("请输入正确邮箱",3);
                    return false;
                }
                var model = '107973';
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "/check_exist_phone",
                    type: "post",
                    data: {'phone':phone},
                    dataType: "json",
                    success: function (data) {
                        if(data.status == 0){
                            Mask.alert("手机号不存在，请注册",3);
                        }else{
                            sendSms(phone, model);
                        }
                    }
                });
                function sendSms(phone, model){
                    $.get('backend/sendsms',
                            {'phone':phone,'model':model},
                            function (data) {
                                if(data.status == 0){
                                    $("#send_sms").attr("disabled", true);
                                    i = 60;
                                    var set_time = setInterval(function() {
                                        if(i>0){
                                            change_time(i);
                                            i--;
                                        } else {
                                            clearInterval(set_time);
                                            $("#phone_submit").removeAttr("disabled").val('发送验证码').css("cursor","pointer").css('background-color','#a4d790');
                                        }
                                    }, 1000);
                                }
                            }
                    );
                }
            });
            function change_time(i){
                var str = i + '秒后重新发送';
                $("#phone_submit").val(str).css('background-color','#999');
            }
        })
    </script>
@stop