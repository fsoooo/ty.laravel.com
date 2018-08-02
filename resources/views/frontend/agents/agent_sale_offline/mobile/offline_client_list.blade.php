<!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8">
		<title>客户列表</title>
		<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
		<link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/lib/mui.min.css">
		<link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/lib/iconfont.css" />
		<link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/common_agent.css" />
		<link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/list.css" />
		<link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/client.css" />
		<link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/offline_client_list.css" />
	</head>

	<body>
		<div class="mui-popover popover-search">
			<div class="popover-search-top">
				<div class="search">
					<i class="iconfont icon-sousuo"></i>
					<input type="search" placeholder="请输入客户名称"/>
				</div>
				<span id="cancel" class="zbtn">取消</span>
			</div>
			<div class="division"></div>
			<div class="popover-search-wrapper">
				<div class="title">搜索记录</div>
				<span class="zbtn">天小眼</span>
				<span class="zbtn">天大眼</span>
				<span class="zbtn">天大眼的互联网公司</span>
			</div>
			
		</div>
		<!--侧滑菜单容器-->
		<div id="offCanvasWrapper" class="mui-off-canvas-wrap mui-draggable mui-slide-in">
			<!--菜单部分-->
			<div class="mui-inner-wrap">
				<header id="header" class="mui-bar mui-bar-nav">
					<a class="iconfont icon-fanhui mui-pull-left mui-action-back"></a>
					<h1 class="mui-title">客户列表</h1>
				</header>
				<div id="offCanvasContentScroll" class="mui-content mui-scroll-wrapper">
					<div id='list' class="mui-indexed-list">
						<div class="list-search-wrapper">
							<div id="edit" class="filtrate color-primary">编辑</div>
							<div class="mui-indexed-list-search mui-input-row mui-search"><i class="iconfont icon-sousuo"></i>搜索客户</div>
						</div>
						<div class="mui-indexed-list-alert"></div>
						<div class="mui-scroll-wrapper content">
							<div class="mui-scroll">
								<div class="mui-indexed-list-inner">
									<ul class="mui-table-view">
										@foreach($custList as $cust)
										<li class="mui-table-view-cell">
											<div class="list-img">
												<img src="{{config('view_url.agent_mob')}}img/boy.png" alt="" />
											</div>
											<span>{{$cust['name']}}</span>
											<div class="icon-wrapper">
												<i class="iconfont icon-brithday"></i>
												<i class="iconfont icon-businesscard_fill"></i>
												<i class="iconfont icon-group_fill"></i>
												<i class="zicon zicon-xinxi-blue">1</i>
												<i class="zicon zicon-xinxi-red"></i>
												<i class="zicon zicon-user"></i>
											</div>
											<div class="mask">
												<label>
													<input hidden type="checkbox" name="client" value="1">
													<i class="iconfont icon-weixuanze"></i>
												</label>
											</div>
										</li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="mui-off-canvas-backdrop"></div>
			</div>
		</div>
		<div class="button-box btn-wapper">
			<button id="confirm" class="zbtn zbtn-default" disabled>确定</button>
		</div>
		
		<script src="{{config('view_url.agent_mob')}}js/lib/jquery-1.11.3.min.js"></script>
		<script src="{{config('view_url.agent_mob')}}js/lib/mui.min.js"></script>
		<script src="{{config('view_url.agent_mob')}}js/lib/mui.indexedlist.js"></script>
		<script src="{{config('view_url.agent_mob')}}js/lib/swiper-3.4.2.min.js"></script>
		<script src="{{config('view_url.agent_mob')}}js/common_agent.js"></script>
		<script>
			var list = {
				init: function(){
					var _this = this;
					_this.choose();
					$('.mui-indexed-list-search,#cancel').on('tap',function(){
						mui('.popover-search').popover('toggle');
					});
					mui.ready(function() {
						var header = document.querySelector('header.mui-bar');
						var list = document.getElementById('list');
						list.style.height = (document.body.offsetHeight - header.offsetHeight) + 'px';
					});
					$('#edit').on('tap',function(){
						$('.mask,.btn-wapper').show();
						$('.mui-content .mui-scroll-wrapper').css('bottom','1rem');
					});
					$('#confirm').click(function(){
						_this.success();
					});
				},
				choose: function(){
					var notCheckedClass = 'icon-weixuanze',checkedClass = 'icon-queding';
					$('.mask label').click(function(){
						if($(this).find('input:disabled').length){
							$(this).find('.iconfont').addClass(notCheckedClass).removeClass(checkedClass);
							return;
						}
						var type = $(this).find('input[type=radio]').length>0 ? 0:1;
						var status = $(this).find('input').prop('checked');
						if(type){
							if(status){
								$(this).find('.iconfont').addClass(checkedClass).removeClass(notCheckedClass);
							}else{
								$(this).find('.iconfont').addClass(notCheckedClass).removeClass(checkedClass);
							}
						}else{
							$(this).parents('.mui-table-view').find('.'+checkedClass).addClass(notCheckedClass).removeClass(checkedClass);
							$(this).find('.iconfont').removeClass(notCheckedClass).addClass(checkedClass);
						}
						$('#confirm')[0].disabled = $('.mask .icon-queding').length == 0;
					});
				},
				success: function(){
					// 数据提交
					location.href = 'offline.html';
				}
			};
			list.init();
		</script>
	</body>
</html>