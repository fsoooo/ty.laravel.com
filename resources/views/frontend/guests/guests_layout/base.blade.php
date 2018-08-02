<!DOCTYPE html>
<html>
	<head>
		<!--页头信息-->
			@include('frontend.guests.guests_layout.head')
			@yield('head-more')
		<!--页头信息-->	
	</head>
	<body>
		<div class="content">
			<div class="content-inside">
				<!--头部信息-->
				<div class="header">
					 @include('frontend.guests.guests_layout.top')
				</div>
				<!--头部信息-->
				<!--内容信息-->
					  @yield('content')
				<!--内容信息-->				
			</div>
		</div>
		<!--页脚-->
		<div class="footer">
			@include('frontend.guests.guests_layout.foot')
		</div>
		<!--页脚-->
		<!--侧边栏-->
			@include('frontend.guests.guests_layout.side')
		<!--侧边栏-->
		</body>
	@yield('footer-more')
</html>
