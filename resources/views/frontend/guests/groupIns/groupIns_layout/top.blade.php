		<!--头部信息-->
		<div class="header">
			<div class="header-wrapper">
				<div class="header-top clearfix">
					<div class="header-content">
						@if(isset($_COOKIE['login_type']))
							<span>
                                <a href="/information" class="btn-login">个人中心</a>
                                <a class="btn-register" href="/logout">退出</a>
                            </span>
						@else
							<span>
                                您好，请
                                <a href="/login" class="btn-login">登录</a>
                                <a class="btn-register" href="/register_front">免费注册</a>
                            </span>
						@endif
					</div>
				</div>

				<div class="header-bottom clearfix">
					<div class="header-bottom-logo">
						{{--<img src="image/main_LOGO.png" />--}}
						<img src="{{config('view_url.pc_group_ins')}}image/main_LOGO.png" />
					</div>
					<ul class="nav-bottom">
						<li><a href="/">首页</a></li>
						<li><a href="/product_list">产品列表</a></li>
						<li><a href="/group_ins/index">团险</a></li>
					</ul>

					<div class="header-bottom-right">
						<ul class="progress">
							<li class="progress-item active">
								<div class="progress-outer">
									<div class="progress-inner"></div>
								</div>
								<div>填写企业信息</div>
							</li>
							<li class="progress-item">
								<div class="progress-outer">
									<div class="progress-inner"></div>
								</div>
								<div>填写投保信息</div>
							</li>
							<li class="progress-item">
								<div class="progress-outer">
									<div class="progress-inner"></div>
								</div>
								<div>确认并支付</div>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>


