<div class="header-wrapper">
	<div class="header-top clearfix">
		<div class="header-content">
			<!--<span>您好，xx</span>-->
			@if(!isset($_COOKIE['user_id']))
				<span>您好，请<a href="#" class="btn-login">登录</a><a class="btn-register" href="#">免费注册</a></span>
			@else
				<span><a href="#" class="btn-login">@if(isset($_COOKIE['user_name'])){{$_COOKIE['user_name']}}@endif</a></span><a class="btn-register" href="/logout">退出</a>
			@endif
			{{--<ul class="nav-top">--}}
				{{--<li>--}}
					{{--<a href="#">我的保险</a>--}}
					{{--<i class="iconfont icon-jiantou2"></i>--}}
					{{--<div class="dropdown dropdown-list">--}}
											{{--<span class="dropdown-title">--}}
												{{--<a href="#">我的保险</a>--}}
												{{--<i class="iconfont icon-jiantou2"></i>--}}
											{{--</span>--}}
						{{--<ul>--}}
							{{--<li>--}}
								{{--<a href="#">所有保单</a>--}}
							{{--</li>--}}
							{{--<li>--}}
								{{--<a href="#">待支付订单</a>--}}
							{{--</li>--}}
							{{--<li>--}}
								{{--<a href="#">进度总览</a>--}}
							{{--</li>--}}
							{{--<li>--}}
								{{--<a href="#">发起理赔</a>--}}
							{{--</li>--}}
						{{--</ul>--}}
					{{--</div>--}}
				{{--</li>--}}
				{{--<li>--}}
					{{--<a href="#">手机保险</a>--}}
					{{--<i class="iconfont icon-jiantou2"></i>--}}
					{{--<div class="dropdown dropdown-code">--}}
											{{--<span class="dropdown-title">--}}
												{{--<a href="#">手机保险</a>--}}
												{{--<i class="iconfont icon-jiantou2"></i>--}}
											{{--</span>--}}
						{{--<div class="code-img">--}}
							{{--<img src="{{config('view_url.person_url').'image/微信图片_20170803113628.png'}}" alt="" />--}}
						{{--</div>--}}
						{{--<div class="code-text">扫码下载手机端APP</div>--}}
						{{--<div class="code-text">实时跟踪保单信息</div>--}}
					{{--</div>--}}
				{{--</li>--}}
				{{--<li>--}}
					{{--<a href="#">保险商城</a>--}}
				{{--</li>--}}
				{{--<li>--}}
					{{--<a href="#">帮助中心</a>--}}
				{{--</li>--}}
				{{--<li>--}}
					{{--<a href="#">保单查询</a>--}}
				{{--</li>--}}
				{{--<li>--}}
					{{--<a href="#">网址导航</a>--}}
					{{--<i class="iconfont icon-jiantou2"></i>--}}
					{{--<div class="dropdown dropdown-list website-guide clearfix">--}}
											{{--<span class="dropdown-title">--}}
										{{--<a href="#">网址导航</a>--}}
										{{--<i class="iconfont icon-jiantou2"></i>--}}
									{{--</span>--}}
						{{--<div>--}}
							{{--<span class="website-guide-title">保险选购</span>--}}
							{{--<div class="website-guide-content splitline clearfix">--}}
								{{--<ul>--}}
									{{--<li>--}}
										{{--<a href="#">儿童保险</a>--}}
									{{--</li>--}}
									{{--<li>--}}
										{{--<a href="#">成人保险</a>--}}
									{{--</li>--}}
									{{--<li>--}}
										{{--<a href="#">财产保险</a>--}}
									{{--</li>--}}
									{{--<li>--}}
										{{--<a href="#">关爱女性</a>--}}
									{{--</li>--}}
								{{--</ul>--}}
								{{--<ul>--}}
									{{--<li>--}}
										{{--<a href="#">旅游意外</a>--}}
									{{--</li>--}}
								{{--</ul>--}}
							{{--</div>--}}
						{{--</div>--}}
						{{--<div>--}}
							{{--<span class="website-guide-title">保险常识</span>--}}
							{{--<div class="website-guide-content splitline splitline2 clearfix">--}}
								{{--<ul>--}}
									{{--<li class="bold">购保问答</li>--}}
									{{--<li class="bold">购宝咨询</li>--}}
									{{--<li class="bold">购保新闻</li>--}}
									{{--<li class="bold">保险汇</li>--}}
								{{--</ul>--}}
								{{--<ul>--}}
									{{--<li>--}}
										{{--<a href="#">如何购宝</a>--}}
									{{--</li>--}}
									{{--<li>--}}
										{{--<a href="#">联系客服</a>--}}
									{{--</li>--}}
									{{--<li>--}}
										{{--<a href="#">联系客服</a>--}}
									{{--</li>--}}
									{{--<li>--}}
										{{--<a href="#">联系客服</a>--}}
									{{--</li>--}}
								{{--</ul>--}}
								{{--<ul>--}}
									{{--<li>--}}
										{{--<a href="#">为何要购保</a>--}}
									{{--</li>--}}
									{{--<li>--}}
										{{--<a href="#">保险管家</a>--}}
									{{--</li>--}}
									{{--<li>--}}
										{{--<a href="#">保险管家</a>--}}
									{{--</li>--}}
									{{--<li>--}}
										{{--<a href="#">保险管家</a>--}}
									{{--</li>--}}
								{{--</ul>--}}
							{{--</div>--}}
						{{--</div>--}}
						{{--<div>--}}
							{{--<span class="website-guide-title">更多</span>--}}
							{{--<div class="website-guide-content clearfix">--}}
								{{--<ul>--}}
									{{--<li>--}}
										{{--<a href="#">关于我们</a>--}}
									{{--</li>--}}
									{{--<li>--}}
										{{--<a href="#">加入我们</a>--}}
									{{--</li>--}}
								{{--</ul>--}}

							{{--</div>--}}
						{{--</div>--}}
					{{--</div>--}}
				{{--</li>--}}
				{{--<li>人工客服<span class="nav-top-tel">4896 489 789</span></li>--}}
			{{--</ul>--}}
		</div>
	</div>

	<div class="header-bottom clearfix">
		<div class="header-bottom-logo">
			<img src="{{config('view_url.person_url').'image/logo.png	'}}" />
		</div>
		<div class="header-bottom-index">
			<h1>我的天眼</h1>
			<a class="btn-index" href="{{url('/')}}">返回超市首页</a>
		</div>
		<div class="nav-bottom">
			<a @if($option_type == 'index') class="active" @endif href="{{url('/information')}}">首页</a>
			<a @if($option_type == 'information') class="active" @endif href="{{url('/information/guest_info')}}">账户设置</a>
			<a @if($option_type == 'message') class="active" @endif href="{{url('/message/index')}}">消息</a>
		</div>

		{{--<div class="header-bottom-right">--}}
			{{--<div class="shopping">--}}
				{{--<a href="#">--}}
					{{--<i class="iconfont icon-gouwuche"></i>--}}
					{{--<span>我的购物车</span>--}}
				{{--</a>--}}
				{{--<i class="icon-tips">5</i>--}}
			{{--</div>--}}
			{{--<div class="private">--}}
				{{--<a href="#">--}}
					{{--<i class="iconfont icon-kefu"></i>--}}
					{{--<span>在线客服</span>--}}
				{{--</a>--}}
			{{--</div>--}}
		{{--</div>--}}
	</div>
</div>