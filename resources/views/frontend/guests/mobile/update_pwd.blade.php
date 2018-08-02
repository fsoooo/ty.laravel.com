<!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8">
		<title>天眼互联-科技让保险无限可能</title>
		<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
		<link rel="stylesheet" href="{{config('view_url.view_url')}}mobile/css/lib/mui.min.css">
		<link rel="stylesheet" href="{{config('view_url.view_url')}}mobile/css/lib/iconfont.css" />
		<link rel="stylesheet" href="{{config('view_url.view_url')}}mobile/css/common.css" />
	</head>

	<body>
		<div id="loginPopover" class="mui-popover">
			<i class="iconfont icon-guanbi"></i>
			<div class="login-wrapper">
				<form role="form" action="/dofindpwd" method="post" onsubmit="return check_pwd()">
					{{ csrf_field() }}
				<ul>
					<li>
						<input id="password" type="password" name="password" placeholder="请输入密码" />
					</li>
					<li>
						<input id="confirm" type="password" name="confirm_password" placeholder="请再次输入密码" />
					</li>
				</ul>
				<button class="btn-disabled" disabled="disabled">确定</button>
				</form>
			</div>
		</div>
		<script src="{{config('view_url.view_url')}}mobile/js/lib/jquery-1.11.3.min.js"></script>
		<script src="{{config('view_url.view_url')}}mobile/js/lib/mui.min.js"></script>
		<script src="{{config('view_url.view_url')}}mobile/js/common.js"></script>
		<script type="text/javascript">
			var Ele = {
				btnpassword : $('.btn-disabled'),
			};
			var passwordVal,confirmVal;
			mui('.mui-popover').popover('show');
			$("input").on("input propertychange", function() {
				passwordVal = $("#password").val();
				confirmVal = $("#confirm").val();
				if(passwordVal&&confirmVal){
					Ele.btnpassword.css({'background': '#00a2ff'}).removeAttr('disabled');
				}else{
					Ele.btnpassword.css({'background': '#adadad'}).attr('disabled','disabled');
				}
			});

			function check_pwd() {
                    if(passwordVal!==confirmVal){
                        mui.toast('两次输入的密码不一致');
                        return false;
                    }else{
                        return true;
                    }
            }


            $('.icon-guanbi').on('tap', function() {
                window.location.href = "/";
//                location.reload();
            });
		</script>
	</body>

</html>