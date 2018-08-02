<!DOCTYPE html>
<html>
<head>
	@include('frontend.guests.person_home.head')
</head>
<body>
<div class="content">
	<div class="content-inside">
		<!--头部信息-->
		<div class="header">
			@include('frontend.guests.person_home.top')
		</div>
		<div class="main">
			@if($option_type != 'message')
			{{--导航部分--}}
			<div class="menu-wrapper">
				@include('frontend.guests.person_home.left')
			</div>
			@endif
			{{--正文部分--}}
			<div class="main-wrapper">
				@yield('content')
			</div>
		</div>
	</div>
</div>
<!--页脚-->
<div class="footer">
	@include('frontend.guests.person_home.foot')
</div>
</body>
</html>