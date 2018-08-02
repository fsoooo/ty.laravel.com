		<!--头部信息-->
					<div class="header-wrapper" id="top" name="top">
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
								{{--<ul class="nav-top">--}}
									{{--<li>--}}
										{{--<a>手机保险</a>--}}
										{{--<i class="iconfont icon-jiantou2"></i>--}}
										{{--<div class="dropdown dropdown-code">--}}
											{{--<span class="dropdown-title">--}}
										{{--<a>手机保险</a>--}}
										{{--<i class="iconfont icon-jiantou2"></i>--}}
									{{--</span>--}}
											{{--<div class="code-img">--}}
												{{--<img src="{{config('view_url.view_url')}}image/微信图片_20170803113628.png" alt="" />--}}
											{{--</div>--}}
											{{--<div class="code-text">扫码下载手机端APP</div>--}}
											{{--<div class="code-text">实时跟踪保单信息</div>--}}
										{{--</div>--}}
									{{--</li>--}}
									{{--<li>--}}
										{{--<a href="/information">我的保险</a>--}}
										{{--<i class="iconfont icon-jiantou2"></i>--}}
										{{--<div class="dropdown dropdown-list">--}}
											{{--<span class="dropdown-title">--}}
									{{--<a href="/information">我的保险</a>--}}
									{{--<i class="iconfont icon-jiantou2"></i>--}}
								{{--</span>--}}
											{{--<ul>--}}
												{{--<li><a href="/information">所有保单</a></li>--}}
												{{--<li><a href="/information">待支付订单</a></li>--}}
												{{--<li><a href="/information">进度总览</a></li>--}}
												{{--<li><a href="/information">发起理赔</a></li>--}}
											{{--</ul>--}}
										{{--</div>--}}
									{{--</li>--}}
									{{--<li><a>保险商城</a></li>--}}
									{{--<li><a>帮助中心</a></li>--}}
									{{--<li><a>保单查询</a></li>--}}
									{{--<li>--}}
										{{--<a>网址导航</a>--}}
										{{--<i class="iconfont icon-jiantou2"></i>--}}
										{{--<div class="dropdown dropdown-list website-guide clearfix">--}}
											{{--<span class="dropdown-title">--}}
										{{--<a>网址导航</a>--}}
										{{--<i class="iconfont icon-jiantou2"></i>--}}
									{{--</span>--}}
											{{--<div>--}}
												{{--<span class="website-guide-title">保险选购</span>--}}
												{{--<div class="website-guide-content splitline clearfix">--}}
													{{--<ul>--}}
														{{--<li><a>儿童保险</a></li>--}}
														{{--<li><a>成人保险</a></li>--}}
														{{--<li><a>财产保险</a></li>--}}
														{{--<li><a>关爱女性</a></li>--}}
													{{--</ul>--}}
													{{--<ul>--}}
														{{--<li><a>旅游意外</a></li>--}}
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
														{{--<li><a>如何购宝</a></li>--}}
														{{--<li><a>联系客服</a></li>--}}
														{{--<li><a>联系客服</a></li>--}}
														{{--<li><a>联系客服</a></li>--}}
													{{--</ul>--}}
													{{--<ul>--}}
														{{--<li><a>为何要购保</a></li>--}}
														{{--<li><a>保险管家</a></li>--}}
														{{--<li><a>保险管家</a></li>--}}
														{{--<li><a>保险管家</a></li>--}}
													{{--</ul>--}}
												{{--</div>--}}
											{{--</div>--}}
											{{--<div>--}}
												{{--<span class="website-guide-title">更多</span>--}}
												{{--<div class="website-guide-content clearfix">--}}
													{{--<ul>--}}
														{{--<li><a>关于我们</a></li>--}}
														{{--<li><a>加入我们</a></li>--}}
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
								<img src="{{config('view_url.view_url')}}image/main_LOGO.png" />
							</div>
							<ul class="nav-bottom">
								<li><a href="/">首页</a></li>
								<li><a href="/product_list">产品列表</a></li>
								<li><a href="/group_ins/index">团险</a></li>
								{{--<li><a>专题</a></li>--}}
								{{--<li><a>定制</a></li>--}}
								{{--<li><a>理赔</a></li>--}}
							</ul>
							{{----}}
							{{--<div class="header-bottom-right">--}}
								{{--<div class="search">--}}
									{{--<input type="text" name="" class="head-search-block" placeholder="请输入关键字">--}}
									{{--<input type="button" class="head-search-btn">--}}
									{{--<i class="icon icon-rank"></i>--}}
								{{--</div>--}}
								{{--<div class="shopping">--}}
									{{--<a>--}}
										{{--<i class="iconfont icon-gouwuche"></i>--}}
										{{--<span>我的购物车</span>--}}
									{{--</a>--}}
								{{--</div>--}}
								{{--<div class="private">--}}
									{{--<a href="/information">--}}
										{{--<i class="iconfont icon-yonghu"></i>--}}
										{{--<span>个人中心</span>--}}
									{{--</a>--}}
								{{--</div>--}}
							{{--</div>--}}
							{{----}}
							{{--投保导航--}}
							<div class="header-bottom-right" id="process_main" style="display: none">
								<ul class="progress">
									<li class="progress-item active" id="process1">
										<div class="progress-outer">
											<div class="progress-inner">1</div>
										</div>
										<div>须知</div>
									</li>
									<li class="progress-item" id="process2">
										<div class="progress-outer" >
											<div class="progress-inner">2</div>
										</div>
										<div>填写投保信息</div>
									</li>
									<li class="progress-item" id="process3">
										<div class="progress-outer">
											<div class="progress-inner">3</div>
										</div>
										<div>确认投保信息</div>
									</li>
									<li class="progress-item" id="process4">
										<div class="progress-outer">
											<div class="progress-inner">4</div>
										</div>
										<div>确认并支付</div>
									</li>
								</ul>
							</div>
						{{--投保导航--}}
						</div>
					</div>
			<!--头部信息-->
		<script>
            $(function () {
				var process_1 = $('.step1').length;
				var process_2 = $('.step2').length;
				var process_3 = $('.step3').length;
				var process_4 = $('.step4').length;
				var process_5 = $('.step5').length;
				console.log(process_1);
				console.log(process_2);
				console.log(process_3);
				console.log(process_4);
				console.log(process_5);
				if(process_1){       
                    $('#process_main').css('display','block');
                    $("#process1").addClass('active');
                    $('#process2').removeClass('active');
                    $('#process3').removeClass('active');
                    $('#process4').removeClass('active');
				}else if(process_2){
                    $('#process_main').css('display','block');
                    $("#process1").addClass('active');
                    $('#process2').removeClass('active');
                    $('#process3').removeClass('active');
                    $('#process4').removeClass('active');
				}else if(process_3){
                    $('#process_main').css('display','block');
                    $('#process1').addClass('active');
                    $('#process3').removeClass('active');
                    $('#process4').removeClass('active');
                    $("#process2").addClass('active');
                }else if(process_5){
                    $('#process1').addClass('active');
                    $('#process2').addClass('active');
                    $('#process4').removeClass('active');
                    $("#process3").addClass('active');
                }else if(process_4){
                    $('#process_main').css('display','block');
                    $('#process1').addClass('active');
                    $('#process2').addClass('active');
                    $('#process3').addClass('active');
                    $("#process4").addClass('active');
                }else{
                    $('#process_main').css('display','none');
				}

//                $.ajax({
//                    url: '/setting?name=logo',
//                }).done(function(data) {
//                    if(data != ''){
//                        $('.header-bottom-logo img').attr('src','upload/'+data);
//                    }
//                });
            });
		</script>
		{{--<script src="http://pv.sohu.com/cityjson?ie=utf-8"></script>--}}
		{{--<script type="text/javascript">--}}

			{{--//取得cookie--}}
			{{--function getCookie(name) {--}}
				{{--var nameEQ = name + "=";--}}
				{{--var ca = document.cookie.split(';'); //把cookie分割成组--}}
				{{--for(var i=0;i < ca.length;i++) {--}}
					{{--var c = ca[i]; //取得字符串--}}
					{{--while (c.charAt(0)==' ') { //判断一下字符串有没有前导空格--}}
						{{--c = c.substring(1,c.length); //有的话，从第二位开始取--}}
					{{--}--}}
					{{--if (c.indexOf(nameEQ) == 0) { //如果含有我们要的name--}}
						{{--return unescape(c.substring(nameEQ.length,c.length)); //解码并截取我们要值--}}
					{{--}--}}
				{{--}--}}
				{{--return false;--}}
			{{--}--}}
			{{--//清除cookie--}}
			{{--function clearCookie(name) {--}}
				{{--setCookie(name, "", -1);--}}
			{{--}--}}
			{{--//设置cookie--}}
			{{--function setCookie(name, value, seconds) {--}}
				{{--seconds = seconds || 0; //seconds有值就直接赋值，没有为0，这个根php不一样。--}}
				{{--var expires = "";--}}
				{{--if (seconds != 0 ) { //设置cookie生存时间--}}
					{{--var date = new Date();--}}
					{{--date.setTime(date.getTime()+(seconds*1000));--}}
					{{--expires = "; expires="+date.toGMTString();--}}
				{{--}--}}
				{{--document.cookie = name+"="+escape(value)+expires+"; path=/"; //转码并赋值--}}
			{{--}--}}

			{{--setCookie("test","tank",1800); //设置cookie的值，生存时间半个小时--}}
			{{--//    alert(getCookie('test')); //取得cookie的值，显示tank--}}
			{{--//    clearCookie("test"); //删除cookie的值--}}
			{{--//    alert(getCookie('test')); //test对应的cookie值为空，显示为false.就是getCookie最后返的false值。--}}

			{{--(function () {--}}
				{{--var domain = document.domain || '';//域名--}}
				{{--var ip =  returnCitySN["cip"] || '';//ip--}}
				{{--var region = returnCitySN["cname"] || '';//ip的地区--}}
				{{--var referrer = document.referrer || '';//引荐人、获取从那个页面跳转过来的url--}}
				{{--var url = document.URL || ''; //获取当前页面url--}}
				{{--var title = document.title || ''; //标题--}}
				{{--$.ajax({--}}
					{{--type: "get",--}}
					{{--url: "/backend/user_management/buried_point/",--}}
					{{--data:{domain:domain,ip:ip,region:region,url:url,title:title,referrer:referrer},--}}
					{{--success: function(msg){--}}
						{{--alert( msg );--}}
					{{--}--}}
				{{--});--}}
			{{--})();--}}

		{{--</script>--}}

