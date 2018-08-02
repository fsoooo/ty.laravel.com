<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>天眼互联-科技让保险无限可能</title>
		<link rel="stylesheet" href="{{config('view_url.agent_url')}}css/lib/iconfont.css" />
		<link rel="stylesheet" href="{{config('view_url.agent_url')}}css/common_agent.css" />
		<link rel="stylesheet" href="{{config('view_url.agent_url')}}css/index.css" />
		<style type="text/css">
			.center{
				display: block;
				margin: 0 auto;
			}
		</style>
	</head>
	<body>
		<!--成功录入线下保单弹出层-->
		<div class="popups-wrapper popups-success" style="display: block;">
			<div class="popups">
				<div class="popups-title">线下保单录入<a href="/agent_sale/offline"><i class="iconfont icon-close"></i></a></div>
				<div class="popups-content">
					<i class="iconfont icon-shenqingchenggong"></i>
					<p>录入成功</p>
					<div>
						<a href="/agent_sale/offline"><button class="z-btn z-btn-positive">继续添加线下保单</button></a>
						<button id="backIndex" class="z-btn-hollow">返回首页</button>
						<!-- TODO:做完列表后打开 -->
						{{--<a href="/agent"><button class="z-btn-hollow">查看已添加线下保单</button></a>--}}
					</div>
				</div>
			</div>
		</div>
		<script src="{{config('view_url.agent_url')}}js/lib/area.js"></script>
		<script src="{{config('view_url.agent_url')}}js/lib/jquery-1.11.3.min.js"></script>
		<script src="{{config('view_url.agent_url')}}js/lib/swiper-3.4.2.min.js"></script>
		<script src="{{config('view_url.agent_url')}}js/common_agent.js"></script>
		<script src="{{config('view_url.agent_url')}}js/lib/jquery.validate.min.js"></script>
		<script src="{{config('view_url.agent_url')}}js/check.js"></script>
		<script>
            $("#backIndex").click(function() {
                window.parent.location.href = '/agent'
            });
		</script>
	</body>
</html>
