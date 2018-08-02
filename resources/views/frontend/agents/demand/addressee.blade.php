<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>记录沟通</title>
		<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
		<link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/lib/mui.min.css">
		<link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/lib/iconfont.css" />
		<link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/common_agent.css" />
		<link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/client.css" />
		<link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/addressee.css" />
		<style>
			.mui-popover{top: initial;left: 0;}
			.block {
			    width: 100%;
			    padding-top: 5px;
			}
		</style>
	</head>

	<body>
		<header id="header" class="mui-bar mui-bar-nav">
			<a class="iconfont icon-fanhui mui-pull-left mui-action-back"></a>
			<h1 class="mui-title">收件人</h1>
		</header>
		<div id="record">
			<div class="outer">
				<div class="mui-control-content mui-active">
					<div  class="mui-scroll-wrapper">
						<div class="mui-scroll">
							<div class="division"></div>
							<div class="form-wrapper add-wrapper">
								<ul>
									<li id="addClient" class="init-client address-item" data-id="0" data-name="业管后台">
										<a href="#">
											<span>业管后台</span>
										</a>
									</li>
									<li class="init-product address-item" data-id="-1" data-name="天眼后台">
										<a href="#">
											<span>天眼后台</span>
										</a>
									</li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<script src="{{config('view_url.agent_mob')}}js/lib/jquery-1.11.3.min.js"></script>
		<script src="{{config('view_url.agent_mob')}}js/lib/mui.min.js"></script>
		<script src="{{config('view_url.agent_mob')}}js/lib/startScore.js"></script>
		<script src="{{config('view_url.agent_mob')}}js/common_agent.js"></script>
	</body>
</html>
<script>
	$('.address-item').click(function(){
		var id = $(this).data('id');
		var name = $(this).data('name');
		sessionStorage.setItem('receiverId',id);
		sessionStorage.setItem('r_name',name);
		location.href='/agent_sale/demand';
	});
</script>