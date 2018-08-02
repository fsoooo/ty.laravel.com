<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>天眼互联-科技让保险无限可能</title>
	<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
	<link rel="stylesheet" href="{{config('view_url.view_url')}}mobile/css/lib/mui.min.css">
	<link rel="stylesheet" href="{{config('view_url.view_url')}}mobile/css/lib/iconfont.css" />
	<link rel="stylesheet" href="{{config('view_url.view_url')}}mobile/css/lib/swiper-3.4.2.min.css" />
	<link rel="stylesheet" href="{{config('view_url.view_url')}}mobile/css/common.css" />
	<link rel="stylesheet" href="{{config('view_url.view_url')}}mobile/css/index.css" />
</head>
<body>
<div id="offCanvasWrapper" class="mui-off-canvas-wrap mui-slide-in mui-draggable">
	<!--侧滑菜单部分-->
	<div class="mui-off-canvas-backdrop"></div>
	<aside id="offCanvasSide" class="mui-off-canvas-left">

		@if($is_person == 1)
		<div class="sidebar">
			<div class="sidebar-header">
				<div class="sidebar-header-img">
					<img src="{{config('view_url.view_url')}}mobile/personal/image/index1.png" />
				</div>
				<div class="sidebar-header-info">
					<div class="sidebar-header-name">@if(isset($_COOKIE['user_name'])){{$_COOKIE['user_name']}}@else <a
								href="/login">请登录</a>@endif</div>
					<div class="sidebar-header-certification">
						<span>@if(!$status)未认证@elseif($status == 1)待审核@elseif($status == 2)通过@else未通过@endif</span>
					</div>
				</div>
			</div>


			<div class="sidebar-content">
				<a href="/information/approvePerson"><i class="iconfont icon-shimingrenzheng"></i>实名认证</a>
				<a href="/order/index/all"><i class="iconfont icon-dingdan"></i>我的订单</a>
				<a href="/guarantee/index/all"><i class="iconfont icon-huabanfuben"></i>我的保单</a>
				<a href="/mpersonal/manage"><i class="iconfont icon-shezhi"></i>账户设置</a>
				<a href="/message/index"><i class="iconfont icon-youjian"></i>消息中心</a>
				<span id="exit"><a href="/logout">退出</a></span>
			</div>
		</div>
		@else
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
						<span>@if(!$status)未认证@elseif($status == 1)待审核@elseif($status == 2)通过@else未通过@endif</span>
					</div>
				</div>
			</div>
			<div class="sidebar-content">
				<a href="/order/index/all"><i class="iconfont icon-huabanfuben"></i>订单管理</a>
				<a href="/guarantee/index/all"><i class="iconfont icon-baodan"></i>保单管理</a>
				<a href="/mpersonal/manage"><i class="iconfont icon-shezhi"></i>账户管理</a>
				<a href="/cpersonal/staff/all"><i class="iconfont icon-shimingrenzheng"></i>人员管理</a>
				<a href="/cpersonal/datas"><i class="iconfont icon-shujugailan"></i>数据统计</a>
				<a href="/message/index"><i class="iconfont icon-youjian"></i>消息中心</a>
				<span id="exit"><a href="/logout">退出</a></span>
			</div>
		</div>
		@endif
	</aside>
	<div class="mui-inner-wrap">
		<header class="mui-bar mui-bar-nav" style="background: white">
				<div class="logo-wrapper">
					<img src="{{config('view_url.view_url')}}mobile/image/logo.png" alt="" />
				</div>
		</header>
		<div class="mui-content">
			<div class="find_nav">
				<div class="find_nav_left">
					<div class="find_nav_list">
						<ul id="pagenavi1">
							<li>
								<a href="#" class="active">全部</a>
							</li>
								@foreach($product_res as $k =>$v)
									@if(!empty($v))
										<li data-id="{{$k}}"><a href="javascript:void(0);" >{{$k}}</a></li>
									@endif
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
										{{--<div class="swiper-slide"><img src="{{config('view_url.view_url')}}mobile/image/banner.png" /></div>--}}
										{{--<div class="swiper-slide"><img src="{{config('view_url.view_url')}}mobile/image/banner.png" /></div>--}}
										{{--<div class="swiper-slide"><img src="{{config('view_url.view_url')}}mobile/image/banner.png" /></div>--}}
									</div>
									<div class="swiper-pagination"></div>
								</div>
								<div class="division"></div>
								<div class="product-wrapper">
									@foreach($product as $k=>$v)
									<div class="product-item clearfix">

										<div class="product-img fl" style="background-image: url('{{asset($v['cover'])}}');background-position: center;background-size: cover">
											{{--<img src="" />--}}
										</div>
											@php
											$first_p = json_decode($v['json'], true);
											$clauses = json_decode($v['clauses'], true);
											@endphp
										<div class="product-content fr">
											<h1 class="product-name">{{$v['product_name']}}</h1>
											<div class="product-label">
												<span>{{$v['product_name']}}</span>
											</div>
											<div class="product-price">
												<span><i>{{$v['base_price']/100}}</i>元起</span>
												<a href="/ins/ins_info/{{$v['ty_product_id']}}">立即投保</a>
											</div>
										</div>

									</div>
									@endforeach
									<div class="division"></div>
									{{--<div class="cooperation-wrapper">--}}
										{{--<div class="swiper-container cooperation">--}}
											{{--<div class="cooperation-title">合作保险公司</div>--}}
											{{--<div class="swiper-wrapper">--}}
												{{--<div class="swiper-slide"><img src="{{config('view_url.view_url')}}mobile/image/op1.png" alt="" /></div>--}}
												{{--<div class="swiper-slide"><img src="{{config('view_url.view_url')}}mobile/image/op2.png" alt="" /></div>--}}
												{{--<div class="swiper-slide"><img src="{{config('view_url.view_url')}}mobile/image/op1.png" alt="" /></div>--}}
												{{--<div class="swiper-slide"><img src="{{config('view_url.view_url')}}mobile/image/op2.png" alt="" /></div>--}}
												{{--<div class="swiper-slide"><img src="{{config('view_url.view_url')}}mobile/image/op1.png" alt="" /></div>--}}
											{{--</div>--}}
										{{--</div>--}}
									{{--</div>--}}
									{{--<div class="service-wrapper">--}}
										{{--<p>客服热线：<span>489-789-4878</span>（每天9：00-18：00）</p>--}}
										{{--<p>微信公众号：<span>inschos</span></p>--}}
									{{--</div>--}}
								</div>
							</div>
						</div>

					</li>
					@foreach($product_res as $k => $label)
							<li class="li_list">
								<div class="mui-scroll-wrapper">
									<div id="scroll1" class="mui-scroll">
										<div class="product-wrapper">
													{{--@php--}}
														{{--$first_p = json_decode($label['product']['json'], true);--}}
														{{--$clauses = json_decode($label['product']['clauses'], true);--}}
													{{--@endphp--}}
											@if(!empty($label))
												@foreach($label as $kk=>$vv)
													<div class="product-item clearfix">
														<div class="product-img fl" style="background-image: url('{{asset($vv['cover'])}}');background-position: center;background-size: cover">
															{{--<img src="" />--}}
														</div>
														<div class="product-content fr">
															<h1 class="product-name">{{ $vv['product_name'] }}</h1>
															<div class="product-label">
																<span>{{$vv['product_name']}}</span>
															</div>
															<div class="product-price">
																<span class="price">￥<i>{{$vv['base_price']/100}}</i> 起</span>
																<a href="/ins/ins_info/{{$vv['ty_product_id']}}">立即投保</a>
															</div>
														</div>
													</div>
												@endforeach
												@endif
										</div>
										<div class="division"></div>
										{{--<div class="cooperation-wrapper">--}}
											{{--<div class="swiper-container cooperation">--}}
												{{--<div class="cooperation-title">合作保险公司</div>--}}
												{{--<div class="swiper-wrapper">--}}
													{{--<div class="swiper-slide"><img src="{{config('view_url.view_url')}}mobile/image/op1.png" alt="" /></div>--}}
													{{--<div class="swiper-slide"><img src="{{config('view_url.view_url')}}mobile/image/op2.png" alt="" /></div>--}}
													{{--<div class="swiper-slide"><img src="{{config('view_url.view_url')}}mobile/image/op1.png" alt="" /></div>--}}
													{{--<div class="swiper-slide"><img src="{{config('view_url.view_url')}}mobile/image/op2.png" alt="" /></div>--}}
													{{--<div class="swiper-slide"><img src="{{config('view_url.view_url')}}mobile/image/op1.png" alt="" /></div>--}}
												{{--</div>--}}
											{{--</div>--}}
										{{--</div>--}}
										{{--<div class="service-wrapper">--}}
											{{--<p>客服热线：<span>489-789-4878</span>（每天9：00-18：00）</p>--}}
											{{--<p>微信公众号：<span>inschos</span></p>--}}
										{{--</div>--}}
									</div>
								</div>
							</li>
					@endforeach
				</ul>
			</div>
		</div>
		<div class="btn-returntop"><i class="iconfont icon-iconup"></i></div>
		<div class="bottom-nav">
			<div class="bottom-nav-item active">
				<a href="/">
					<div class="bottom-nav-icon icon-shouye"></div>
					<span class="bottom-nav-text">首页</span>
				</a>
			</div>
			<div class="bottom-nav-item">
				<a @if(isset($_COOKIE['user_id'])) href="/order/index/all" @else href="/login" @endif>
					<div class="bottom-nav-icon icon-baodan1" id="login_person" ></div>
					<span class="bottom-nav-text">我的保单</span>
				</a>
			</div>
			<div class="bottom-nav-item">
				<a href="/mpersonal/not_found">
					<div class="bottom-nav-icon icon-lipei"></div>
					<span class="bottom-nav-text"  id="lipei">发起理赔</span>
				</a>
			</div>
			@if(isset($_COOKIE['login_type']))
				<div class="bottom-nav-item " id="login_type">
						<i id="offCanvasShow">
						<div class="bottom-nav-icon icon-person"></div>
						<span class="bottom-nav-text">个人中心</span>
						</i>
				</div>
			@else
				<div class="bottom-nav-item" id="login_person" >
					<a href="/login">
						<i id="offCanvasShow" class="mui-icon mui-icon-bars hide"></i>
						<div class="bottom-nav-icon icon-person"></div>
						<span class="bottom-nav-text">个人中心</span>
					</a>
				</div>
			@endif
		</div>
	</div>
</div>
<script src="{{config('view_url.view_url')}}mobile/js/lib/jquery-1.11.3.min.js"></script>
<script src="{{config('view_url.view_url')}}mobile/js/lib/mui.min.js"></script>
<script src="{{config('view_url.view_url')}}mobile/js/lib/swiper-3.4.2.min.js"></script>
<script src="{{config('view_url.view_url')}}mobile/js/common.js"></script>
<script src="{{config('view_url.view_url')}}mobile/js/lib/touchslider.js"></script>
<script src="{{config('view_url.view_url')}}mobile/js/index.js"></script>
<script>
    $(document).ready(function(){
        $('#lipei').click(function(){
            alert('敬请期待，或致电：010-57145618')
        })
    });
    var classifyArr = {};
    $('.main-classify-left li').each(function(){
        var id = $(this).data('id');
        if(classifyArr[id]){
            var index = $(this).index();
            $(this).remove();
            $('.main-classify-content').eq(index).remove();
        }else{
            classifyArr[id] = id;
        }
    });
    $(function () {
        $.ajax({
            url: '/setting?name=logo',
        }).done(function (data) {
            if (data != '') {
                $('.logo-wrapper img').attr('src', 'upload/' + data);
            }
        });
        $.ajax({
            url: '/setting?name=insurance_banner',
        }).done(function(data) {
            var html = '';
            $.each(data,function(index){
                if(data[index]){
                    html += '<div class="swiper-slide" style="background-image:url('+ data[index] +')"></div>';
                }
            });
            $('.banner .swiper-wrapper').append(html);
            // banner轮播图
			var mySwiper = new Swiper('.banner', {
				autoplay: 5000,
				pagination: '.swiper-pagination',
			});
        });
    });

</script>
</body>
</html>