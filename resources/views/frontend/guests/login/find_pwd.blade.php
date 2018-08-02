@extends('frontend.guests.guests_layout.login_layout.base')
@section('content')
        <div class="main">
            <div class="bg">
            </div>
            @if($step=='1')
            <div class="login-block-wrap">
                <div class="login-block">
                    <div class='register-type'>
                        <ul>
                            <li class="register-name">找回密码-填写账号</li>
                            <div class="ClearFix"></div>
                        </ul>

                    </div>
                    <div class="row">
                    </div>
                    <div class="register-block">
                        <form role="form" action="/dofindpwd" method="post" onsubmit="return check_one()">
                            {{ csrf_field() }}
                            <div class="user-name">
                                <input type="text" name="account" class="input" placeholder="会员名/手机/邮箱">
                            </div>
                            <div class="pattern" type="0" style="position: relative;">
                                <div class="slide-to-unlock-bg" style="width: 300px; height: 38px; background-color: rgb(238, 238, 238);">
                                    <span style="line-height: 38px; font-size: 12px; color: rgb(51, 51, 51);">请按住滑块，拖动至最右边</span>
                                </div>
                                <div class="slide-to-unlock-progress" style="background-color: rgb(35, 202, 86); height: 38px;">
                                </div>
                                <div class="slide-to-unlock-handle" style=" background-color: rgb(238, 238, 238); height: 38px; line-height: 40px; width: 46px;">
                                    <img class="icon-arrow" src="{{config('view_url.view_url').'login/image/arrow.png'}}" alt="">
                                    <img class="icon-success" src="{{config('view_url.view_url').'login/image/success.png'}}" alt="" hidden>
                                </div>
                            </div>
                            <div class="login-button">
                                <input type="submit" class="login-button-input" value="下一步">
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
                </div>
            </div>
                @elseif($step=='2')
                <div class="login-block-wrap">
                    <div class="login-block">
                        <div class='register-type'>
                            <ul>
                                <li class="register-name">找回密码-验证身份</li>
                                <div class="ClearFix"></div>
                            </ul>

                        </div>
                        <div class="row">
                        </div>
                        <div class="register-block">
                            <form role="form" action="/do_mobile_pwd" method="post">
                                {{ csrf_field() }}
                                <div class="user-name">
                                    <select name="check_type" class="input" id="check_type"  onclick="checkType()">
                                        <option value="phone">通过验证手机验证身份</option>
                                        <option value="email" selected>通过验证邮箱验证身份</option>
                                        <option value="other">联系客服重置密码</option>
                                    </select>
                                </div>
                                <div id="phone" hidden>
                                    <div class="user-name" >
                                        @if(isset($user_account_phone))
                                            <input type="text" name="phone" class="input"  value="{{$user_account_phone}}" disabled="disabled">
                                            <input type="hidden"  name="account" value="{{$user_account_phone}}" >
                                        @endif
                                    </div>
                                    <div class="phone-pattern">
                                        <input type="text" name="phone_code" class="pattern-input" placeholder="请输入验证码">
                                        <input class="pattern-button" type="button"  id="send_sms" value="获取验证码">
                                    </div>
                                </div>
                                <div id="email" >
                                    <div class="phone-pattern">
                                        @if(isset($user_account_email))
                                            <input type="email"  name="email" id="findpwd_email" class="input" name="email" placeholder="请输入邮箱" value="{{$user_account_email}}" disabled="disabled">
                                        @endif
                                        {{--<input class="pattern-button" type="button"  id="send_email" value="发送邮件" onclick="dologinemail()">--}}
                                    </div>
                                </div>
                                <div id="other" hidden>
                                    <div class="phone-pattern">
                                            <input type="text" id="other" class="input"   value="客服热线4008813521654" disabled="disabled">
                                    </div>
                                </div>
                                <div class="login-button">
                                    <input type="submit" id="submit2" class="login-button-input" value="下一步" hidden>
                                    <input type="button" id="submit2-1" class="login-button-input" value="发送邮件" onclick="do_login_email()">
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
                    </div>
                </div>
                @elseif($step=='3')
                <div class="login-block-wrap">
                    <div class="login-block">
                        <div class='register-type'>
                            <ul>
                                <li class="register-name">找回密码-重置密码</li>
                                <div class="ClearFix"></div>
                            </ul>
                        </div>
                        <div class="row">
                        </div>
                        <div class="register-block">
                            <form role="form" action="/dofindpwd" method="post">
                                {{ csrf_field() }}
                                @if(isset($email))
                                    <input type="hidden" name="email" value="{{$email}}">
                                @endif
                                <div class="password">
                                <input type="password" name="password" class="input" id="password" placeholder="请输入6至20位密码" onKeyUp="pwStrength(this.value)"  onBlur="pwStrength(this.value)">
                                </div>
                                <div class="password-level">
                                <div class="low level" id="strength_L">弱</div>
                                <div class="middle level" id="strength_M">中</div>
                                <div class="high level" id="strength_H">强</div>
                                </div>
                                <div class="confirm-password">
                                <input type="password" name="confirm_password" class="input" id="confirm" placeholder="确认密码">
                                </div>
                                <div class="login-button">
                                    <input type="submit" class="login-button-input" value="下一步">
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
                    </div>
                </div>
                @elseif($step == '4')
                <div class="login-block-wrap">
                    <div class="login-block">
                        <div class='register-type'>
                            <ul>
                                <li class="register-name">找回密码成功!<span id="btn"></span></li>
                                <div class="ClearFix"></div>
                                <form role="form" action="{{url('/do_login')}}" method="post" class="form">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="phone" class="input" value="{{$phone}}">
                                        <input type="hidden" name="password" value="{{$password}}">
                                        <input type="submit" id="login_submit" value="点击登录" hidden>
                                </form>
                            </ul>
                        </div>
                    </div>
                </div>
                <script>
                    var countdown=30;
                    window.onload = function settime() {
                        var val = document.getElementById("btn");
                        if (countdown == 0) {
                            return $("#login_submit").click();
                        }else{
                            val.innerText="(" + countdown + ")后自动登录";
                            countdown--;
                        }
                        setTimeout(function() {
                            settime(val)
                        },1000)
                    }
                </script>
                @elseif($step=='5')
                <div class="login-block-wrap">
                    <div class="login-block">
                        <div class='register-type'>
                            <ul>
                                <li class="register-name" style="color: red">您的链接已过期，请重新操作！</li>
                                <li class="register-name" ><a href="/findpwd">找回密码</a></li>
                                <div class="ClearFix"></div>
                            </ul>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        <script src="{{config('view_url.view_url').'login/js/jquery-3.1.1.min.js'}}"></script>
        <script src="{{config('view_url.view_url').'login/js/frontend/login/login.js'}}"></script>
        <script src="{{config('view_url.view_url').'login/org/un_lock/assets/js/unlock.js'}}"></script>
        @include('frontend.guests.guests_layout.notice_alert')
        <script>
            function checkType() {
                var options = $("#check_type option:selected").val();
                if(options=='email'){
                    document.getElementById("email").style.display='block';
                    document.getElementById("other").style.display='none';
                    document.getElementById("phone").style.display='none';
                    document.getElementById("submit2").style.display='none';
                    document.getElementById("submit2-1").style.display='block';
                    document.getElementById("submit2-1").value = '下一步';
                }else if(options=='phone'){
                    document.getElementById("email").style.display='none';
                    document.getElementById("other").style.display='none';
                    document.getElementById("phone").style.display='block';
                    document.getElementById("submit2").style.display='block';
                    document.getElementById("submit2-1").style.display='none';
                }else{
                    document.getElementById("other").style.display='block';
                    document.getElementById("email").style.display='none';
                    document.getElementById("phone").style.display='none';
                    document.getElementById("submit2-1").style.display='none';
                }
            }
            function  do_login_email() {
                var options = $("#check_type option:selected").val();
                var email = $("input[name=email]").val();
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "/dofindpwd",
                    type: "post",
                    data: {'email':email,'check_type':options},
                    dataType: "json",
                    success: function (data) {
                        if(data.status == 0){
                            document.getElementById("submit2-1").value = '邮件发送成功！请登录邮箱查看';
                            document.getElementById("submit2-1").disabled="disabled";
                        } else {
                            Mask.alert("邮件发送失败，请刷新页面重新尝试！");
                        }
                    }
                });
            }
    function check_one() {
            var phone = $("input[name=account]").val();
            if(!phone||phone.length == ''||phone == null){
                Mask.alert("请正确输入");
                return false;
            }else{
                return true;
            }
    }
    $(function(){
        $("#send_sms").click(function(){
            var phone = $("input[name=phone]").val();
            var model = '62523';
            if(!phone||phone.length !== 11){
                Mask.alert("请输入正确的手机号");
                return false;
            }
                        sendSms(phone, model);
            function sendSms(phone, model){
                var phone = $("input[name=phone]").val();
                var model = '62523';
                if(!phone||phone.length !== 11){
                    Mask.alert("请输入正确的手机号");
                    return false;
                }
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
                                        $("#send_sms").removeAttr("disabled").val('发送验证码').css("cursor","pointer").css('background-color','#a4d790');
                                    }
                                }, 1000);
                            }
                        }
                );
            }

        });
        function change_time(i){
            var str = i + '秒后重新发送';
            $("#send_sms").val(str).css('background-color','#999');
        }
    })


    //判断输入密码的类型
    function CharMode(iN){
        if (iN>=48 && iN <=57) //数字
            return 1;
        if (iN>=65 && iN <=90) //大写
            return 2;
        if (iN>=97 && iN <=122) //小写
            return 4;
        else
            return 8;
    }
    //bitTotal函数
    //计算密码模式
    function bitTotal(num){
        modes=0;
        for (i=0;i<4;i++){
            if (num & 1) modes++;
            num>>>=1;
        }
        return modes;
    }
    //返回强度级别
    function checkStrong(sPW){
        if (sPW.length<6)
            return 0; //密码太短，不检测级别
        Modes=0;
        for (i=0;i<sPW.length;i++){
            //密码模式
            Modes|=CharMode(sPW.charCodeAt(i));
        }
        return bitTotal(Modes);
    }
    //显示颜色
    function pwStrength(pwd){
        Dfault_color="#eeeeee";     //默认颜色
        Font_default_color="#999";     //字体默认颜色
        Font_color="#FFFFFF";     //字体颜色
        L_color="#FF6868";      //低强度的颜色，且只显示在最左边的单元格中
        M_color="#FFDA68";      //中等强度的颜色，且只显示在左边两个单元格中
        H_color="#68FF81";      //高强度的颜色，三个单元格都显示
        if (pwd==null||pwd==''){
            Lcolor=Mcolor=Hcolor=Dfault_color;
        }
        else{
            S_level=checkStrong(pwd);
            switch(S_level) {
                case 0:
                    Lcolor=Mcolor=Hcolor=Dfault_color;
                    break;
                case 1:
                    Lcolor=L_color;
                    Mcolor=Hcolor=Dfault_color;
                    break;
                case 2:
                    Lcolor=Mcolor=M_color;
                    Hcolor=Dfault_color;
                    break;
                default:
                    Lcolor=Mcolor=Hcolor=H_color;
            }
        }
        document.getElementById("strength_L").style.background=Lcolor;
        document.getElementById("strength_M").style.background=Mcolor;
        document.getElementById("strength_H").style.background=Hcolor;
        document.getElementById("strength_L").style.color=Font_color;
        document.getElementById("strength_M").style.color=Font_color;
        document.getElementById("strength_H").style.color=Font_color;
        return;
    }
</script>
@stop