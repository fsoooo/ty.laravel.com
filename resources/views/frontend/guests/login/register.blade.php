@extends('frontend.guests.guests_layout.login_layout.base')
@section('content')
    @if(isset($user_third_register))
        <div class="main">
            <div class="bg">
            </div>
            <div class="login-block-wrap">
                <div class="login-block">
                    <div class='register-type'>
                        <ul>
                            <li class="register-name">还没有账号？账号绑定</li>
                            <div class="ClearFix"></div>
                        </ul>
                    </div>
                    <div class="row">
                    </div>
                    <div class="register-block">
                        <form role="form" action="/register_post" method="post" id="form_third">
                            {{ csrf_field() }}
                            <input type="hidden" name="identifying" value="person">
                            <div class="user-name">
                                <input type="text" name="phone" class="input" name="user_name" placeholder="手机号">
                            </div>
                            <div class="phone-pattern">
                                <input type="text" name="phone_code" class="pattern-input" placeholder="验证码">
                                {{--<input class="pattern-button" type="button"  id="send_sms_third" value="获取验证码">--}}
                                <button class="pattern-button" id="send_sms_third">获取验证码</button>
                            </div>
                            <div class="password">
                                <input id="third_password" type="password" name="password" class="input" placeholder="请输入6至20位密码" onKeyUp="pwStrength(this.value)"  onBlur="pwStrength(this.value)">
                            </div>
                            <div class="password-level">
                                <div class="low level" id="strength_L">弱</div>
                                <div class="middle level" id="strength_M">中</div>
                                <div class="high level" id="strength_H">强</div>
                            </div>
                            <div class="confirm-password">
                                <input id="third_confirm" type="password" name="confirm_password" class="input" placeholder="确认密码">
                            </div>
                            <div class="remember-me">
                                <label><div class="remember-check-box">
                                        <input id="third_check" type="checkbox">
                                    </div>
                                    <div class="remember-me-content">
                                        我已阅读 <a href="/register_notice">《用户服务协议》</a>
                                    </div></label>
                            </div>
                            <div class="login-button">
                                <input type="hidden" name="app_id" value="{{$user_third_register}}">
                                <button id="bu_third" type="button" class="login-button-input" disabled="disabled" style=" background-color: #999;">验证并绑定</button>
                            </div>
                            <div class="account-forget-register">
                                <span><a href="/login">返回登录</a></span>
                            </div>
                            <div class="ClearFix"></div>
                            <div class="relevance">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="main">
            <div class="bg">
            </div>
            <div class="login-block-wrap">
                <div class="login-block">
                    <div class='register-type'>
                        <ul>
                            @if($type == 'person')
                                <li class="register-name">新用户注册</li>
                            @elseif($type == 'company')
                                <li class="register-name">企业用户注册</li>
                            @else
                                <li class="register-name">组织/团体用户注册</li>
                            @endif
                            <div class="ClearFix"></div>
                        </ul>
                    </div>
                    <div class="row">
                    </div>
                    <div class="register-block">
                        @if($type == 'person')
                            {{--个人注册（手机号）--}}
                            <form role="form" action="/register_post" method="post" id="form_person">
                                {{ csrf_field() }}
                                <div class="user-name">
                                    <input type="text" name="phone" class="input" name="user_name" placeholder="手机号">
                                </div>
                                <div class="phone-pattern">
                                    <input type="text" name="phone_code" class="pattern-input" placeholder="验证码">
                                    <input class="pattern-button" type="button"  id="send_sms" value="获取验证码">
                                </div>
                                <div class="password">
                                    <input type="password" id="person_password" name="password" class="input" placeholder="请输入6至20位密码" onKeyUp="pwStrength(this.value)"  onBlur="pwStrength(this.value)">
                                </div>
                                <div class="password-level">
                                    <div class="low level" id="strength_L">弱</div>
                                    <div class="middle level" id="strength_M">中</div>
                                    <div class="high level" id="strength_H">强</div>
                                </div>
                                <div class="confirm-password">
                                    <input type="password" id="person_confirm" name="confirm_password" class="input" placeholder="确认密码">
                                </div>
                                @if($type == 'person')
                                    <input type="hidden" name="identifying" value="person">
                                @elseif($type == 'company')
                                    <input type="hidden" name="identifying" value="company">
                                @else
                                    <input type="hidden" name="identifying" value="group">
                                @endif
                                <div class="remember-me">
                                    <label>
                                        <div class="remember-check-box">
                                            <input id="person_check" type="checkbox" class="">
                                        </div>
                                        <div class="remember-me-content">
                                            我已阅读 <a href="/register_notice">《用户服务协议》</a>
                                        </div>
                                    </label>
                                </div>
                                <div class="login-button">
                                    <button id="bu_person" type="button" class="login-button-input" disabled="disabled">点击注册</button>
                                </div>
                                <div class="account-forget-register">
                                    <span><a href="/login_person">返回登录</a></span>
                                </div>
                                <div class="ClearFix"></div>
                                <div class="relevance">
                                </div>
                            </form>
                        @else
                            {{--企业注册（邮箱）--}}
                            <form role="form" action="/register_post" method="post" id="form_company">
                                {{ csrf_field() }}
                                <div class="user-name">
                                    <input type="text" name="email" class="input" placeholder="邮箱地址">
                                </div>
                                <div class="phone-pattern">
                                    <input type="text" name="email_code" class="pattern-input" placeholder="验证码">
                                    <input class="pattern-button" type="button"  id="send_msg" value="获取验证码">
                                </div>
                                <div class="password">
                                    <input type="password" id="company_password" name="password" class="input" placeholder="请输入6至20位密码" onKeyUp="pwStrength(this.value)"  onBlur="pwStrength(this.value)">
                                </div>
                                <div class="password-level">
                                    <div class="low level" id="strength_L">弱</div>
                                    <div class="middle level" id="strength_M">中</div>
                                    <div class="high level" id="strength_H">强</div>
                                </div>
                                <div class="confirm-password">
                                    <input type="password" id="company_confirm" name="confirm_password" class="input" placeholder="确认密码">
                                </div>
                                @if($type == 'person')
                                    <input type="hidden" name="identifying" value="person">
                                @elseif($type == 'company')
                                    <input type="hidden" name="identifying" value="company">
                                @else
                                    <input type="hidden" name="identifying" value="group">
                                @endif
                                <div class="remember-me">
                                    <label>
                                        <div class="remember-check-box">
                                            <input id="company_check" type="checkbox" class="">
                                        </div>
                                        <div class="remember-me-content">
                                            我已阅读 <a href="/register_notice">《用户服务协议》</a>
                                        </div>
                                    </label>
                                </div>
                                <div class="login-button">
                                    <button id="bu_company" type="button" class="login-button-input" disabled="disabled">点击注册</button>
                                </div>
                                <div class="account-forget-register">
                                    <span><a href="/login_person">返回登录</a></span>
                                </div>
                                <div class="ClearFix"></div>
                                <div class="relevance">
                                </div>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif
    <script src="{{config('view_url.view_url').'login/js/jquery-3.1.1.min.js'}}"></script>
    <script src="{{config('view_url.view_url').'login/js/frontend/login/login.js'}}"></script>
    <script src="{{config('view_url.view_url').'login/org/un_lock/assets/js/unlock.js'}}"></script>
    @include('frontend.guests.guests_layout.notice_alert')
    <script>
                {{--验证、绑定、已阅读--}}
        var inputs = $('.register-block input:visible'),
                bu_person = $('.login-button-input'),
                person_check = $('#person_check');
        inputs.bind('input propertychange', function() {
            bu_person.get(0).disabled = checkInputs() || checkProtocol();
        });
        person_check.click(function(){
            bu_person.get(0).disabled = checkInputs() || checkProtocol();
        });
        function checkInputs(){
            var status = false;
            inputs.each(function(index){
                if(!$(this).val()){
                    status = true;
                    return false;
                }
            });
            return status;
        }
        function checkProtocol(){
            var status = true;
            if(person_check.prop('checked')){
                status = false;
            }
            return status;
        }

        $('#third_check').on('click',function () {
            var check_third = $('#third_check').prop('checked');
            if(check_third){
                $('#bu_third').removeAttr('disabled');
                $('#bu_third').css('background-color','#00a2ff');
            }else{
                $('#bu_third').attr('disabled',true);
                $('#bu_third').css('background-color','#999');
            }
        });
        $('#person_check').on('click',function () {
            var person_check = $('#person_check').prop('checked');
            if(person_check){
                $('#bu_person').removeAttr('disabled');
                $('#bu_person').css('background-color','#00a2ff');
            }else{
                $('#bu_person').attr('disabled',true);
                $('#bu_person').css('background-color','#999');
            }
        });
        $('#company_check').on('click',function () {
            var company_check = $('#company_check').prop('checked');
            if(company_check){
                $('#bu_company').removeAttr('disabled');
                $('#bu_company').css('background-color','#00a2ff');
            }else{
                $('#bu_company').attr('disabled',true);
                $('#bu_company').css('background-color','#999');
            }
        });
        //            $(function () {
        //                $("#agree").change(function(){
        //                    test = $("input[type='checkbox']").is(':checked');
        //                    if(test == true){
        //                        $('#submit').removeAttr("disabled");
        //                        $("#submit").css("background-color","#ffae00");
        ////
        //                    }else{
        //                        $("#submit").removeAttr("style");
        //                        $("#submit").attr("disabled", "disable");
        //                    }
        //                });
        //            });
        $('#bu_third').on('click',function () {
            if($('#third_password').val()!=$('#third_confirm').val()){
                Mask.alert("两次密码不相等",3);
                return false;
            }else{
                $('#form_third').submit();
            }
        });
        $('#bu_person').on('click',function () {
            if($('#person_password').val()!=$('#person_confirm').val()){
                Mask.alert("两次密码不相等",3);
                return false;
            }else{
                $('#form_person').submit();
            }
        });
        $('#bu_company').on('click',function () {
            if($('#company_password').val()!= $('#company_confirm').val()){
                alert($("#company_confirm").val());
                Mask.alert("两次密码不相等",3);
                return false;
            }else{
                $('#form_company').submit();
            }
        });
        $(function(){
            //三方登陆注册发送验证码
            $("#send_sms_third").click(function(){
                var phone = $("input[name=phone]").val();
                if(!phone||phone.length !== 11){
                    Mask.alert("请输入正确的手机号",3);
                    return false;
                }
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
                            sendSmsThird(phone, model);
                        } else {
                            Mask.alert("手机号已注册",3);
                        }
                    }
                });
                function sendSmsThird(phone, model){
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: "/backend/sendsms",
                        type: "post",
                        data: {'phone':phone,'model':model},
                        dataType: "json",
                        success: function (data) {
                            if(data.status == '0'||data.status == 0||data.status != 1){
                                $("#send_sms_third").attr("disabled", true);
                                i = 60;
                                var set_time = setInterval(function() {
                                    if(i>0){
                                        var str = i + '秒后重新发送';
                                        $("#send_sms_third").val(str).css('background-color','#999');
                                        i--;
                                    } else {
                                        clearInterval(set_time);
                                        $("#send_sms_third").removeAttr("disabled").val('发送验证码').css("cursor","pointer").css('background-color','#a4d790');
                                    }
                                }, 1000);
                            }
                        }
                    });
                }
            });
            //个人注册发送验证码
            $("#send_sms").click(function(){
                var phone = $("input[name=phone]").val();
                var myreg = /^(((13[0-9]{1})|(14[0-9]{1})|(17[0-9]{1})|(15[0-9]{1})|(18[0-9]{1}))+\d{8})$/;
                var model = '62524';
                if(!phone||phone.length !== 11 || !myreg.test(phone)){
                    Mask.alert("请输入正确的手机号",3);
                    return false;
                }
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "/check_exist_phone",
                    type: "post",
                    data: {'phone':phone},
                    dataType: "json",
                    success: function (data) {
                        if(data.status == '0'||data.status == 0||data.status != 1){
                            sendSms(phone, model);
                            $("#send_sms").attr("disabled", true);
                                i = 60;
                                var set_time = setInterval(function() {
                                    if(i>0){
                                        var str = i + '秒后重新发送';
                                        $("#send_sms").val(str).css('background-color','#999');
                                        i--;
                                    } else {
                                        clearInterval(set_time);
                                        $("#send_sms").removeAttr("disabled").val('发送验证码').css("cursor","pointer").css('background-color','#00a2ff');
                                    }
                                }, 1000);

                        } else {
                            Mask.alert("手机号已注册",3);
                        }
                    }
                });
                function sendSms(phone, model){
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: "/backend/sendsms",
                        type: "post",
                        data: {'phone':phone,'model':model},
                        dataType: "json",
                        success: function (data) {
                            if(data.status){

                            }else {
                                $("#send_sms").attr("disabled", true);
                                i = 60;
                                var set_time = setInterval(function() {
                                    if(i>0){
                                        var str = i + '秒后重新发送';
                                        $("#send_sms").val(str).css('background-color','#999');
                                        i--;
                                    } else {
                                        clearInterval(set_time);
                                        $("#send_sms").removeAttr("disabled").val('发送验证码').css("cursor","pointer").css('background-color','#00a2ff');
                                    }
                                }, 1000);
                            }
                        }
                    });
                }
            });
            //企业注册发送验证码
            $("#send_msg").click(function(){
                var email = $("input[name=email]").val();
                var model = '62524';
                var myreg = /^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;
                if(!email|| !myreg.test(email)){
                    Mask.alert("请输入正确的邮箱地址",3);
                    return false;
                }
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "/check_exist_phone",
                    type: "post",
                    data: {'phone':email},
                    dataType: "json",
                    success: function (data) {
                        if(data.status == 0){
                            sendSms(email, model);
                        } else {
                            Mask.alert("该邮箱地址已注册",3);
                        }
                    }
                });
                function sendSms(email, model){
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: "/backend/companysendemail",
                        type: "post",
                        data: {'email':email,'model':model},
                        dataType: "json",
                        success: function (data) {
                            if(data.status == '0'||data.status == 0||data.status != 1){
                                $("#send_msg").attr("disabled", true);
                                i = 60;
                                var set_time = setInterval(function() {
                                    if(i>0){
                                        change_time(i);
                                        i--;
                                    } else {
                                        clearInterval(set_time);
                                        $("#send_msg").removeAttr("disabled").val('发送验证码').css("cursor","pointer").css('background-color','#00a2ff');
                                    }
                                }, 1000);
                            }
                        }
                    });
                }
            });
            //倒计时
            function change_time(i){
                var str = i + '秒后重新发送';
                $("#send_msg").val(str).css('background-color','#999');
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