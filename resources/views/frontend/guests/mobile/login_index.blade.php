<!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8">
		<title>天眼互联-科技让保险无限可能</title>
		<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
		<link rel="stylesheet" href="{{config('view_url.view_url')}}mobile/css/common.css" />
		<link rel="stylesheet" href="{{config('view_url.view_url')}}mobile/css/lib/mui.min.css" />
		<style>
			.mui-bar-nav{background: transparent!important;box-shadow: none;}
			.mui-icon-back{color: #fff!important;}
			.main-wrapper {width: 100%;height: 100%;}
			.bg {width: 100%;height: 100%;background: url(view_2/mobile/image/loginbg.png) no-repeat;background-size: 100% 100%;}
			.logo {margin: 0 auto;width: 1.5rem;height: 1.5rem;background: #fff;border-radius: 50%;}
			.content-wrapper {position: absolute;top: 2.6rem;width: 100%;font-size: .32rem;text-align: center;}
			.choose-wrapper {margin-right: -.55rem;}
			.btn {margin-right: .55rem;width: 2.48rem;height: .78rem;line-height: .78rem;background: transparent;border:1px solid #fff;color: #fff;border-radius: 2px;}
			.slogon {margin: .7rem 0 .5rem;font-size: .48rem;color: #fff;}
		</style>
			<script src="{{config('view_url.view_url')}}mobile/js/lib/mui.min.js"></script>
	</head>
	<body>
		<div class="main-wrapper">
			<div class="bg"></div>
			<header class="mui-bar mui-bar-nav">
				<a class="mui-icon mui-icon-back mui-pull-left mui-action-back" href="/"></a>
			</header>
			<div class="content-wrapper">
				<div class="logo">
					<img src="{{config('view_url.view_url')}}mobile/image/logo.png" />
				</div>
				{{--<p class="slogon">科技让保险无限可能</p>--}}
				<div class="choose-wrapper" style="margin:0;">
					@if(isset($_COOKIE['user_id']))
               			<a class="btn" href="/" style="display: block;margin: .4rem auto;">个人用户</a>
						<a class="btn" href="/" style="display: block;margin: .4rem auto;">企业用户</a>
						<a class="btn" href="/" style="display: block;margin: .4rem auto;">代理人</a>
					@else
						<a class="btn" href="/login_person" style="display: block;margin: .4rem auto;">个人用户</a>
						<a class="btn" href="/login_company" style="display: block;margin: .4rem auto;">企业用户</a>
						<a class="btn" href="/agent_login" style="display: block;margin: .4rem auto;">代理人</a>
					@endif
				</div>
				<br/>
				<span style="color: green" id="check_login_phone">
					@if (count($errors) > 0)
						@foreach ($errors->all() as $error)
							<script>
								var msg = "{{$error}}";
								  mui.toast(msg);
							</script>
						@endforeach
					@endif
				</span>
			</div>
		</div>
		<script src="{{config('view_url.view_url')}}mobile/js/lib/jquery-1.11.3.min.js"></script>
		<script src="{{config('view_url.view_url')}}mobile/js/common.js"></script>
	</body>

</html>