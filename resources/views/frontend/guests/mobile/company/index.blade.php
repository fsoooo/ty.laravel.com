<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>天眼互联-科技让保险无限可能</title>
	<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
	<link rel="stylesheet" href="{{config('view_url.view_url')}}mobile/company/css/lib/mui.min.css">
	<link rel="stylesheet" href="{{config('view_url.view_url')}}mobile/company/css/lib/iconfont.css" />
	<link rel="stylesheet" href="{{config('view_url.view_url')}}mobile/company/css/lib/swiper-3.4.2.min.css" />
	<link rel="stylesheet" href="{{config('view_url.view_url')}}mobile/company/css/common.css" />
	<link rel="stylesheet" href="{{config('view_url.view_url')}}mobile/company/css/index.css" />
</head>
<body>
<div id="offCanvasWrapper" class="mui-off-canvas-wrap mui-slide-in mui-draggable">
	<!--侧滑菜单部分-->
	<div class="mui-off-canvas-backdrop"></div>
	<aside id="offCanvasSide" class="mui-off-canvas-left">
		<div class="sidebar">
			<div class="sidebar-header">
				<div class="sidebar-header-img">
					<img src="{{config('view_url.view_url')}}mobile/company/image/header.png" />
				</div>

				<div class="sidebar-header-info">
					<div class="sidebar-header-name">
						@if(isset($_COOKIE['user_name']))
							{{$_COOKIE['user_name']}}
						@else
							<a href="/login">请登录</a>
						@endif
					</div>
					<div class="sidebar-header-certification">
						<span>@if(!$cStatus)未认证@elseif($cStatus == 1)待审核@elseif($cStatus == 2)通过@else未通过@endif</span>
					</div>
				</div>
			</div>
			<div class="sidebar-content">
				<a href="/order/index/all"><i class="iconfont icon-huabanfuben"></i>订单管理</a>
				<a href="/order/index/all"><i class="iconfont icon-baodan"></i>保单管理</a>
				<a href="/mpersonal/manage"><i class="iconfont icon-shezhi"></i>账户管理</a>
				<a href="/cpersonal/staff"><i class="iconfont icon-shimingrenzheng"></i>人员管理</a>
				<a href="/cpersonal/datas"><i class="iconfont icon-shujugailan"></i>数据统计</a>
			</div>

		</div>
	</aside>
	<div class="mui-inner-wrap">
		<header class="mui-bar mui-bar-nav">

			@if(isset($_COOKIE['login_type']))
				<i id="offCanvasShow" class="mui-icon mui-icon-bars mui-pull-left"><div hidden id="login_type">{{$_COOKIE['login_type']}}</div></i>
				{{--<i class="mui-icon mui-icon mui-icon-search mui-pull-right"></i>--}}
			@else
				<i id="offCanvasShow" class="mui-icon mui-icon-bars mui-pull-left" ></i>
				{{--<i class="mui-icon mui-icon mui-icon-search mui-pull-right"></i>--}}
			@endif
		</header>
		{{--<div class="search-wrapper">--}}
			{{--<div class="search-keywords">--}}
				{{--<i class="iconfont icon-fanhui2"></i>--}}
				{{--<input type="text" placeholder="请输入你想购买保险的关键字" />--}}
				{{--<i class="iconfont icon-sousuo"></i>--}}
			{{--</div>--}}
			{{--<ul class="search-list">--}}
				{{--<li><i class="iconfont icon-zuijinfangwen"></i>团体意外险</li>--}}
				{{--<li><i class="iconfont icon-zuijinfangwen"></i>团体意外险</li>--}}
			{{--</ul>--}}
			{{--<div class="search-tips">清空所有历史纪录</div>--}}
		{{--</div>--}}
		<div class="mui-content">
			<div class="find_nav">
				<div class="find_nav_left">
					<div class="find_nav_list">
						<ul id="pagenavi1">
							<li><a href="#" class="active">推荐</a></li>
							@foreach($labels as $k => $label)
									<li><a href="#">{{$label->name}}</a></li>
							@endforeach
							<li class="sideline"></li>
						</ul>
					</div>
				</div>
			</div>
			<div id="slider1" class="swipe">
				<ul class="box01_list">

							<li class="li_list">
								<div class="mui-scroll-wrapper active">
									<div id="scroll1" class="mui-scroll">
										<div class="swiper-container banner">
											<div class="swiper-wrapper">
												<div class="swiper-slide"><img src="{{config('view_url.view_url')}}mobile/image/banner.png" /></div>
												<div class="swiper-slide"><img src="{{config('view_url.view_url')}}mobile/image/banner.png" /></div>
												<div class="swiper-slide"><img src="{{config('view_url.view_url')}}mobile/image/banner.png" /></div>
											</div>
											<div class="swiper-pagination"></div>
										</div>
										<div class="division"></div>
										<div class="product-wrapper">
											<div class="product-item clearfix">
												<div class="product-img fl">
													<img src="{{config('view_url.view_url')}}mobile/image/index1.png" />
												</div>
												<div class="product-content fr">
													<h1 class="product-name">老年人绝症三高意外险</h1>
													<div class="product-label">
														<span>意外健康全覆盖</span>
														<span>意外健康全覆盖</span>
														<span>意外健康全覆盖</span>
													</div>
													<div class="product-price">
														{{--<span><i>1299</i>元起</span>--}}
														<a href="/ins/ins_info/1">立即投保</a>
													</div>
												</div>
											</div>
											<div class="product-item clearfix">
												<div class="product-img fl">
													<img src="{{config('view_url.view_url')}}mobile/image/index2.png" />
												</div>
												<div class="product-content fr">
													<h1 class="product-name">老年人绝症三高意外险</h1>
													<div class="product-label">
														<span>意外健康全覆盖</span>
														<span>意外健康全覆盖</span>
														<span>意外健康全覆盖</span>
													</div>
													<div class="product-price">
														{{--<span><i>1299</i>元起</span>--}}
														<a href="productinfo/1">立即投保</a>
													</div>
												</div>
											</div>
											<div class="product-item clearfix">
												<div class="product-img fl">
													<img src="{{config('view_url.view_url')}}mobile/image/index3.png" />
												</div>
												<div class="product-content fr">
													<h1 class="product-name">老年人绝症三高意外险</h1>
													<div class="product-label">
														<span>意外健康全覆盖</span>
														<span>意外健康全覆盖</span>
														<span>意外健康全覆盖</span>
													</div>
													<div class="product-price">
														{{--<span><i>1299</i>元起</span>--}}
														<a href="/ins/ins_info/1">立即投保</a>
													</div>
												</div>
											</div>
											<div class="division"></div>
											<div class="cooperation-wrapper">
												<div class="swiper-container cooperation">
													<div class="cooperation-title">合作保险公司</div>
													<div class="swiper-wrapper">
														<div class="swiper-slide"><img src="{{config('view_url.view_url')}}mobile/image/op1.png" alt="" /></div>
														<div class="swiper-slide"><img src="{{config('view_url.view_url')}}mobile/image/op2.png" alt="" /></div>
														<div class="swiper-slide"><img src="{{config('view_url.view_url')}}mobile/image/op1.png" alt="" /></div>
														<div class="swiper-slide"><img src="{{config('view_url.view_url')}}mobile/image/op2.png" alt="" /></div>
														<div class="swiper-slide"><img src="{{config('view_url.view_url')}}mobile/image/op1.png" alt="" /></div>
													</div>
												</div>
											</div>
											<div class="service-wrapper">
												<p>客服热线：<span>489-789-4878</span>（每天9：00-18：00）</p>
												<p>微信公众号：<span>inschos</span></p>
											</div>
										</div>
									</div>
								</div>
							</li>
					@foreach($labels as $k => $label)
							<li class="li_list">
								<div class="mui-scroll-wrapper">
									<div id="scroll1" class="mui-scroll">
										<div class="product-wrapper">
											@foreach($label->products as $key => $value)
												@if($key=='0'||$key=='1'||$key=='2')
													@php
														$first_p = json_decode($value->json, true);
                                                        $clauses = json_decode($value->clauses, true);
													@endphp
													<div class="product-item clearfix">
														<div class="product-img fl">
															<img src="{{asset($value->cover)}}" />
														</div>
														<div class="product-content fr">
															<h1 class="product-name">{{ $first_p['name'] }}</h1>
															<div class="product-label">
																<span>{{$label->name}}</span>
																{{--<span>意外健康全覆盖</span>--}}
															</div>
															<div class="product-price">
{{--																<span><i>{{($clauses[0]['tariff'][0]['tariff'])}}</i>元起</span>--}}
																<a href="/ins/ins_info/{{$first_p['id']}}">立即投保</a>
															</div>
														</div>
													</div>
												@endif
											@endforeach
											<div class="division"></div>
											<div class="cooperation-wrapper">
												<div class="swiper-container cooperation">
													<div class="cooperation-title">合作保险公司</div>
													<div class="swiper-wrapper">
														<div class="swiper-slide"><img src="{{config('view_url.view_url')}}mobile/image/op1.png" alt="" /></div>
														<div class="swiper-slide"><img src="{{config('view_url.view_url')}}mobile/image/op2.png" alt="" /></div>
														<div class="swiper-slide"><img src="{{config('view_url.view_url')}}mobile/image/op1.png" alt="" /></div>
														<div class="swiper-slide"><img src="{{config('view_url.view_url')}}mobile/image/op2.png" alt="" /></div>
														<div class="swiper-slide"><img src="{{config('view_url.view_url')}}mobile/image/op1.png" alt="" /></div>
													</div>
												</div>
											</div>
											<div class="service-wrapper">
												<p>客服热线：<span>489-789-4878</span>（每天9：00-18：00）</p>
												<p>微信公众号：<span>inschos</span></p>
											</div>
										</div>
									</div>
								</div>
							</li>
					@endforeach
				</ul>
			</div>
		</div>
		<div class="btn-returntop"><i class="iconfont icon-iconup"></i></div>
		<div class="bottom-nav">
			{{--<div class="bottom-nav-item active">--}}
				{{--<div class="bottom-nav-icon icon-shouye"></div>--}}
				{{--<span class="bottom-nav-text">首页</span>--}}
			{{--</div>--}}
			{{--<div class="bottom-nav-item">--}}
				{{--<div class="bottom-nav-icon icon-baodan"></div>--}}
				{{--<span class="bottom-nav-text">我的保单</span>--}}
			{{--</div>--}}
			{{--<div class="bottom-nav-item">--}}
				{{--<div class="bottom-nav-icon icon-lipei"></div>--}}
				{{--<span class="bottom-nav-text">发起理赔</span>--}}
			{{--</div>--}}
			{{--<div class="bottom-nav-item">--}}
				{{--<span class="mui-badge mui-badge-primary">12</span>--}}
				{{--<div class="bottom-nav-icon icon-gouwuche"></div>--}}
				{{--<span class="bottom-nav-text">购物车</span>--}}
			{{--</div>--}}
		</div>
	</div>
</div>
<script src="{{config('view_url.view_url')}}mobile/company/js/lib/jquery-1.11.3.min.js"></script>
<script src="{{config('view_url.view_url')}}mobile/company/js/lib/mui.min.js"></script>
<script src="{{config('view_url.view_url')}}mobile/company/js/lib/swiper-3.4.2.min.js"></script>
<script src="{{config('view_url.view_url')}}mobile/company/js/common.js"></script>
<script src="{{config('view_url.view_url')}}mobile/company/js/lib/touchslider.js"></script>
<script src="{{config('view_url.view_url')}}mobile/company/js/index.js"></script>
</body>
</html>