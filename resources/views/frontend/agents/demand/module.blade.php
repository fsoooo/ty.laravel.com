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
		<link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/module.css" />
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
			<h1 class="mui-title">所属模块</h1>
		</header>
		<div id="record">
			<div class="outer">
				<div class="mui-control-content mui-active">
					<div  class="mui-scroll-wrapper">
						<div class="mui-scroll">
							<div class="division"></div>
							<div class="form-wrapper add-wrapper">
								<ul>
									<li id="addClient" class="init-client address-item" data-id="1" data-name="客户">
										<a href="#">
											<span>客户</span>
										</a>
									</li>
									<li class="init-product address-item" data-id="2" data-name="产品">
										<a href="#">
											<span>产品</span>
										</a>
									</li>
									<li class="init-product address-item" data-id="3" data-name="计划书">
										<a href="#">
											<span>计划书</span>
										</a>
									</li>
									<li class="init-product address-item" data-id="4" data-name="销售业绩">
										<a href="#">
											<span>销售业绩</span>
										</a>
									</li>
									<li class="init-product address-item" data-id="5" data-name="销售任务">
										<a href="#">
											<span>销售任务</span>
										</a>
									</li>
									<li class="init-product address-item" data-id="6" data-name="活动">
										<a href="#">
											<span>活动</span>
										</a>
									</li>
									<li class="init-product address-item" data-id="7" data-name="消息">
										<a href="#">
											<span>消息</span>
										</a>
									</li>
									<li class="init-product address-item" data-id="8" data-name="评价">
										<a href="#">
											<span>评价</span>
										</a>
									</li>
									<li class="init-product address-item" data-id="9" data-name="账户设置">
										<a href="#">
											<span>账户设置</span>
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

<script type="text/javascript">
	$('.address-item').click(function(){
		var id = $(this).data('id');
		var m_name = $(this).data('name');
		sessionStorage.setItem('moduleId',id);
		sessionStorage.setItem('m_name',m_name);
		location.href='/agent_sale/demand';
	});
</script>