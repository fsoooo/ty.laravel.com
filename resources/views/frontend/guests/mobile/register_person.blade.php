<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>天眼互联-科技让保险无限可能</title>
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
	<link rel="stylesheet" href="{{config('view_url.view_url')}}mobile/css/lib/mui.min.css">
	<link rel="stylesheet" href="{{config('view_url.view_url')}}mobile/css/lib/iconfont.css" />
	<link rel="stylesheet" href="{{config('view_url.view_url')}}mobile/css/common.css" />
	<style>
		#loginPopover .login-wrapper{margin-top: 2rem;}
	</style>
</head>
<body>
<div id="loginPopover" class="mui-popover">
	<i class="iconfont icon-guanbi"></i>
	<form role="form" action="/register_post" method="post" onsubmit="return checkForm()">
		{{csrf_field()}}
		@if($type == 'person')
			<input type="hidden" name="identifying" value="person">
		@elseif($type == 'company')
			<input type="hidden" name="identifying" value="company">
		@else
			<input type="hidden" name="identifying" value="group">
		@endif
	<div class="login-wrapper">
		<ul>
			<li>
				<input id="tel" type="text" name="phone" placeholder="手机号码" />
			</li>
			<li>
				<input id="code" type="text"  name="phone_code"  placeholder="输入验证码" />
				<button type="button" class="btn-code" id="phone_submit">获取验证码</button>
			</li>
			<li>
				<input id="password" type="password" name="password" placeholder="请输入6-20位密码" />
			</li>
			<li>
				<input id="confirm" type="password" name="confirm"  placeholder="确认密码" />
			</li>
		</ul>
		<span style="color: red" id="check_login_phone">
			@if (count($errors) > 0)
				@foreach ($errors->all() as $error)
					{{ $error }}
				@endforeach
			@endif
					</span>
		<input type="submit" class="btn-disabled" disabled="disabled" value="立即注册">
		<div class="btn-password">直接登录</div>
	</div>
	</form>
	<div class="thirdparty">
		<p>使用第三方登录</p>
		<ul class="clearfix">
			<li>
				<a href="{{config('third_api_url.local_third_api_qq')}}">
					<i class="iconfont icon-QQ"></i>
				</a>
			</li>
			<li>
				<a href="{{config('third_api_url.local_third_api_baidu')}}" style="margin: 9px 3px;" class="open_login_8">
					<i class="iconfont icon-baidu"></i>
				</a>
			</li>
			<li>
				<a href="{{config('third_api_url.local_third_api_sina')}}" style="margin: 9px 3px;" class="open_login_2">
					<i class="iconfont icon-weibo1-copy"></i>
				</a>
			</li>

		</ul>
	</div>
</div>
<script src="{{config('view_url.view_url')}}mobile/js/lib/jquery-1.11.3.min.js"></script>
<script src="{{config('view_url.view_url')}}mobile/js/lib/mui.min.js"></script>
<script src="{{config('view_url.view_url')}}mobile/js/common.js"></script>
<script type="text/javascript">
    var Ele = {
        btnRegister : $('.btn-disabled')
    };
    var passwordVal,confirmVal;
    mui('.mui-popover').popover('show');
    $("input").on("input propertychange", function() {
        passwordVal = $("#password").val();
        confirmVal = $("#confirm").val();
        if($("#tel").val()&&$("#code").val()&&passwordVal&&confirmVal){
            Ele.btnRegister.css({'background': '#00a2ff'}).removeAttr('disabled');
        }else{
            Ele.btnRegister.css({'background': '#adadad'}).attr('disabled','disabled');
        }
    });
    $('.btn-password').on('tap', function() {
        window.location.href = '/login_person';
    });
    $('.icon-guanbi').on('tap', function() {
        window.location.href = "/";
//                location.reload();
    });
    var phone = $("input[name=phone]").val();
    var phone_code = $("input[name=phone_code]").val();
    $(function(){
        $("#phone_submit").click(function(){
            var phone = $("input[name='phone']").val();
            var myreg = /^(((13[0-9]{1})|(14[0-9]{1})|(17[0-9]{1})|(15[0-9]{1})|(18[0-9]{1}))+\d{8})$/;
            var model = '62524';
            if(!phone||phone.length !== 11 || !myreg.test(phone)){
                $("#check_login_phone").html("请输入正确的手机号!");
                return false;
            }
            $.ajax({
                url: "/check_exist_phone",
                type: "post",
                data: {'phone':phone},
                dataType: "json",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (data) {
                    if(data.status == 200){
                        $("#check_login_phone").html("您的输入有误，请检查后重新输入");
                    }else{
                        sendSms(phone, model);
                    }
                }
            });
            function sendSms(phone, model){
                $.get('/backend/sendsms',
                    {'phone':phone,'model':model},
                    function (data) {
                        if(data.status == '0'){
                            $("#phone_submit").attr("disabled", true);
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
            var str = i + '秒';
            $("#phone_submit").html(str).css({'background-color':'#ffae00','color':'white'});
        }
    })
    function checkForm() {
       if(passwordVal!==confirmVal){
            mui.toast('两次输入的密码不一致');
        }else{
           return true;
        }
    }
</script>
</body>

</html>
