<!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8">
		<title>天眼互联-科技让保险无限可能</title>
		<link rel="shortcut icon" href="favicon.ico" />
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
		<link rel="stylesheet" href="{{config('view_url.view_url')}}mobile/css/lib/mui.min.css">
		<link rel="stylesheet" href="{{config('view_url.view_url')}}mobile/css/lib/mui.picker.all.css">
		<link rel="stylesheet" href="{{config('view_url.view_url')}}mobile/css/lib/iconfont.css" />
		<link rel="stylesheet" href="{{config('view_url.view_url')}}mobile/css/common.css" />
		<link rel="stylesheet" href="{{config('view_url.view_url')}}mobile/css/details.css" />
	</head>
	<style>
	</style>
	<body>
		<div id="loginPopover" class="mui-popover mui-active">
			<div class="mui-scroll-wrapper">
				<div class="mui-scroll">
			<i class="iconfont icon-guanbi" id="close_login"></i>
			<div class="login-wrapper">
				<form action="/phone_login" class="form" id="login_form_phone" method="post">
					{{ csrf_field() }}
					<ul>
						<li>
							<input type="text" name="phone" id="phone_input" placeholder="手机号" autocomplete="off" maxlength="11"/>
						</li>
						<li>
							<input type="text" name="phone_code" placeholder="输入验证码" autocomplete="off"/>
							<button type="button" class="btn-code"  id="phone_submit">获取验证码</button>
						</li>
					</ul>
					<span style="color: red" id="check_login_phone">
						@if (count($errors) > 0)
							@foreach ($errors->all() as $error)
								{{ $error }}
							@endforeach
						@endif
					</span>
					<input type="submit" class="btn-login"value="快速登录">
				</form>
				<div type="button" class="btn-password"  style="margin-top: 15px;">使用密码登录</div><br/>
			</div>
			<div class="login-wrapper hide">
				<div class="text-right">
					<button class="btn-message" type="button">短信验证码登录</button>
				</div>
				<ul>
					<form action="{{url('/do_login')}}" method="post" id="form_password" onsubmit="return doLogin()">
						{{ csrf_field() }}
					<li>
						<input type="text" id="phone_person" name="phone" placeholder="手机号/身份证号" autocomplete="off" maxlength="18"/>
					</li>
					<li>
						<input type="password" id="phone_password" name="password" placeholder="输入密码" autocomplete="off"/>
					</li>
						<input type="submit"  id="submit" style="display: none">
						<input type="hidden" id="move_check" value="1">
					</form>
					{{--<li>--}}
						{{--<div class="stage">--}}
							{{--<div class="slider" id="slider">--}}
								{{--<div class="label">请按住滑块，拖动至最右边</div>--}}
								{{--<div class="track" id="track">--}}
									{{--<div class="bg-green"></div>--}}
								{{--</div>--}}
								{{--<div class="button" id="btn">--}}
									{{--<i id="icon" class="iconfont icon-jiantouzuoshuang-"></i>--}}
									{{--<div class="spinner" id="spinner"></div>--}}
								{{--</div>--}}
							{{--</div>--}}
						{{--</div>--}}
					{{--</li>--}}
				</ul>
				<span style="color: red" id="check_phone">
						@if (count($errors) > 0)
						@foreach ($errors->all() as $error)
							{{ $error }}
						@endforeach
					@endif
					</span>
				<div class="bottom-wrapper">
					<button class="btn-login" onclick="doSubmit()">点击登录</button>
					<div class="btn-password">
						<a href="/register/person" class="fl">立即注册</a>
						<a href="/findpwd" class="fr">忘记密码</a>
					</div>
				</div>
			</div>
					@php $path = str_replace('http://','',env('APP_URL'));@endphp
					@if(!empty(config('third_api_url')[$path]))
						<div class="thirdparty">
							<p>使用第三方登录</p>
							<ul class="clearfix">
								<li>
									<a href="{{config('third_api_url')[$path]['api_url_qq']}}">
										<i class="iconfont icon-QQ"></i>
									</a>
								</li>
								<li>
									<a href="{{config('third_api_url')[$path]['api_url_baidu']}}">
										<i class="iconfont icon-baidu"></i>
									</a>
								</li>
								<li>
									<a href="{{config('third_api_url')[$path]['api_url_sina']}}">
										<i class="iconfont icon-weibo1-copy"></i>
									</a>
								</li>
							</ul>
						</div>
					@else
						<div class="thirdparty">
							<p></p>
						</div>
					@endif
				</div>
			</div>
		</div>
		<script src="{{config('view_url.view_url')}}mobile/js/lib/jquery-1.11.3.min.js"></script>
		<script src="{{config('view_url.view_url')}}mobile/js/lib/mui.min.js"></script>
		<script src="{{config('view_url.view_url')}}mobile/js/lib/mui.picker.all.js"></script>
		<script src="{{config('view_url.view_url')}}mobile/js/common.js"></script>
		<script src="{{config('view_url.view_url')}}mobile/js/details.js"></script>
		<script>
            $('.icon-guanbi').on('tap', function() {
                window.location.href = "/";
//                location.reload();
            });
            function doLogin() {
                var phone = $("#phone_person").val();
                var password = $("#phone_password").val();
                var move_check = $("#move_check").val();
                console.log(phone);
                console.log(password);
                if(!phone||phone.length !== 11){
                    $("#check_phone").html("请输入正确的手机号");
                    return false;
                }else if(!password){
                    $("#check_phone").html("请输入正确的密码");
                    return false;
                }
                return true;
            }
            function doSubmit() {
                $("#submit").click();
            }
            $(function(){
                $("#phone_submit").click(function(){
                    var phone = $("input[name=phone]").val();
					var myreg = /^(((13[0-9]{1})|(14[0-9]{1})|(17[0-9]{1})|(15[0-9]{1})|(18[0-9]{1}))+\d{8})$/;
                    if(!phone||phone.length !== 11 || !myreg.test(phone)){
                        $("#check_login_phone").html("请输入正确的手机号");
                        return false;
                    }
                    var model = '107973';
                    $.ajax({
                        url: "/check_exist_phone",
                        type: "post",
                        data: {'phone':phone},
                        dataType: "json",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (data) {
                            if(data.status == 0){
                                sendSms(phone, model);
                            }else{
                                $("#check_login_phone").html("您的输入有误，请检查后重新输入");
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
                mui('.mui-scroll-wrapper').scroll({deceleration: 0.0005});
            })
		</script>
	</body>
</html>