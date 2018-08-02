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
	</head>

	<body>
		<div id="loginPopover" class="mui-popover">
			<i class="iconfont icon-guanbi"></i>
			<div class="login-wrapper">
				<form role="form" action="/do_mobile_pwd" method="post">
					{{csrf_field()}}
					<ul>
						<li>
							<input id="tel" type="text"  name="account" placeholder="手机号/邮箱" onblur="check_account()"/>
						</li>
						<li>
							<input id="code" type="text" name="check_code" placeholder="输入验证码" />
							<button type="button" class="btn-code">获取验证码</button>
						</li>
						<li id="hidden_account_type"><input type="hidden" name="account_type" value="0"></li>
					</ul>
					<span id="check_login_phone" style="color: red"></span>
					<button class="btn-disabled" disabled="disabled">找回密码</button>
				</form>
			</div>
		</div>
		<script src="{{config('view_url.view_url')}}mobile/js/lib/jquery-1.11.3.min.js"></script>
		<script src="{{config('view_url.view_url')}}mobile/js/lib/mui.min.js"></script>
		<script src="{{config('view_url.view_url')}}mobile/js/common.js"></script>
		<script type="text/javascript">
			var Ele = {
				btnpassword : $('.btn-disabled')
			};
			mui('.mui-popover').popover('show');
			$("input").on("input propertychange", function() {
				if($("#tel").val()&&$("#code").val()){
					Ele.btnpassword.css({'background': '#00a2ff'}).removeAttr('disabled');
				}else{
					Ele.btnpassword.css({'background': '#adadad'}).attr('disabled','disabled');
				}
			});
//			Ele.btnpassword.on('tap', function() {
//				window.location.href = '/update_pwd';
//			});
            $('.icon-guanbi').on('tap', function() {
                window.location.href = "/";
//                location.reload();
            });
            //
            function check_account() {
                var account = $("#tel").val();
                var account_type = isEmail(account);
                $.ajax({
                    url: "/check_exist_phone",
                    type: "post",
                    data: {'phone':account},
                    dataType: "json",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (data) {
                        if(data.status == 0){
                            $("#check_login_phone").html("您的输入有误，请检查后重新输入");
                        }else{
                            if(account_type){
                                account_type = 'email';
                                $('#hidden_account_type').html('<input type="hidden" name="account_type" value="'+account_type+'" >');
                            }else{
                                account_type = 'phone';
                                $('#hidden_account_type').html('<input type="hidden" name="account_type" value="'+account_type+'" >');
                            }
                            if(account_type=='email'){
                                sendEmail(account);
							}else{
                                var model = '109489';
                                sendSms(account, model)
							}
                        }
                    }
                });
            }
			//判断输入是不是邮箱
            function isEmail(str){
                var reg = /^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(.[a-zA-Z0-9_-])+/;
                return reg.test(str);
            }
            function sendSms(phone, model){
                $.get('/backend/sendsms',
                    {'phone':phone,'model':model},
                    function (data) {
                        if(data.status == '200'){
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
            function  sendEmail(account) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "/dofindpwd",
                    type: "post",
                    data: {'email':account,'check_type':'email'},
                    dataType: "json",
                    success: function (data) {
                        if(data.status == 0){
                            document.getElementById("submit2-1").value = '邮件发送成功！请登录邮箱查看';
                            document.getElementById("submit2-1").disabled="disabled";
                        } else {
                            alert('邮件发送失败，请刷新页面重新尝试！');
                        }
                    }
                });
            }
		</script>
	</body>

</html>