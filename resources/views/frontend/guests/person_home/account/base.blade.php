<!DOCTYPE html>
<html>

<head>
	@include('frontend.guests.person_home.account.head')
</head>

<body>
<div class="content">
	<div class="content-inside">
		<!--头部信息-->
		<div class="header">
			@include('frontend.guests.person_home.account.top')
		</div>

		<div class="main clearfix">
			<div class="menu-wrapper">
				{{--导航部分--}}
				@include('frontend.guests.person_home.account.left')
			</div>
			<div class="main-wrapper">
				{{--正文部分--}}
				@yield('content')

			</div>
		</div>
	</div>
</div>
<!--页脚-->
<div class="footer">
	@include('frontend.guests.person_home.account.foot')
</div>
</body>

{{--<script src="js/lib/jquery-1.11.3.min.js"></script>--}}
{{--<script src="js/common.js"></script>--}}
<script>

</script>

</html>