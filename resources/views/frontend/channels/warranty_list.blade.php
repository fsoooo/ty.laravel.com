<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<title>我的保单</title>
	<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
	<link rel="stylesheet" href="{{config('view_url.channel_url')}}css/lib/mui.min.css">
	<link rel="stylesheet" href="{{config('view_url.channel_url')}}css/lib/iconfont.css" />
	<link rel="stylesheet" href="{{config('view_url.channel_url')}}css/common.css" />
	<link rel="stylesheet" href="{{config('view_url.channel_url')}}css/index.css" />
	<script src="{{config('view_url.channel_url')}}js/baidu.statistics.js"></script>
	<style>
		.mui-bar~.mui-content .mui-fullscreen {top: 1.32rem;height: auto;}
		.mui-pull-bottom-tips {text-align: center;font-size: 15px;line-height: 40px;color: #777;}
		.mui-slider-indicator.mui-segmented-control {background: #efeff4;}
		.mui-slider-group{top: 1.2rem!important;}.mui-content{background: #efeff4;}
		.mui-scroll-wrapper{bottom: 0!important;background: #efeff4;}
		.mui-segmented-control.mui-segmented-control-inverted .mui-control-item.mui-active{color: #ff8a00;}
		.nav-wrapper{position: relative;width: 100%;height: 1rem;line-height: 1rem;background: #fff;}
		.vertical1{position: absolute;top: 0;left: 50%;}
		.bottom-slip{margin-bottom: .15rem;}
		.slip-center-left{margin-right: .4rem}
		.security-wrapper .bottom-slip,.failure-wrapper .bottom-slip{
			height: auto;
			padding-bottom: .2rem;
		}
		.security-wrapper .bottom-slip{
			background: #fff url(/channel_info/imges/Security-label.png) no-repeat 80%;
			background-size: 1rem;

		}
		.failure-wrapper .bottom-slip{
			background: #fff url(/channel_info/imges/Failure-label.png) no-repeat 80%;
			background-size: 1rem;

		}
		.mui-control-item{
			width: 49%!important;
		}
	</style>
</head>
<body>
{{--loading--}}
@include('frontend.channels.insure_mask')
{{--loading--}}
<header class="mui-bar mui-bar-nav">
	<div class="head-left">
	<div class="head-img">
		<img src="{{config('view_url.channel_url')}}imges/back.png" />
	</div>
	</div>
	<div class="head-right">
		<i class="iconfont icon-close"></i>
	</div>
	<div class="head-title">
		<span>我的保单</span>
	</div>
</header>
<div class="mui-content">
	<div id="slider" class="mui-slider mui-fullscreen">
		<div id="sliderSegmentedControl" class="mui-scroll-wrapper mui-slider-indicator mui-segmented-control mui-segmented-control-inverted">
			<div class="nav-wrapper">
				<a class="mui-control-item mui-active" href="#item1mobile">在保保单(
					@if(count($res)==0)
						0
					@else
						1
					@endif
					)</a>
				<div class="vertical1"></div>
				<a class="mui-control-item" href="#item2mobile">失效保单(
					@if(count($res)==0)
						0
					@else
						{{count($res)-1}}
					@endif
					)</a>
			</div>
		</div>
		<div class="color"></div>
		<div class="mui-slider-group">
			<div id="item1mobile" class="mui-slider-item mui-control-content mui-active">
				<div id="scroll1" class="mui-scroll-wrapper">
					<div class="mui-scroll">
						@if(count($res)!=0)
							@foreach($res as $value)
								@if(date('Y-m-d',strtotime($value['start_time']))==date('Y-m-d',time()))
									<div class="security-wrapper">
										<a href="{{config('view_url.channel_target_url')}}warranty_info" id="warranty_info_y" class="bottom-slip">
											<div class="slip-left">
												<div class="slip-manager">
													<div >
														<span class="slip-manager-top">韵达快递保·人身意外综合保险</span>
													</div>
													<div class="slip-manager-nei">
														<span class="slip-manager-bot size" >保单号:<span class="slip-manager-bot-left">{{$warranty_res['warranty_code']}}</span></span>
														<div style="margin-top: .1rem;">
															<span class="slip-manager-bot size" >生效时间:<span class="slip-manager-bot-left">今天07:00-23:59:59</span></span>
														</div>
													</div>
												</div>
											</div>
											<div class="slip-center">
												<div class="slip-center-right">
													<img src="{{config('view_url.channel_url')}}imges/turn-into.png" />
												</div>
											</div>
										</a>
									</div>
								@endif
							@endforeach
						@endif
					</div>
				</div>
			</div>
			<div id="item2mobile" class="mui-slider-item mui-control-content">
				<div class="mui-scroll-wrapper">
					<div class="mui-scroll">
						@if(count($res)!=0)
							@foreach($res as $value)
								@if(date('Y-m-d',strtotime($value['start_time']))!=date('Y-m-d',time()))
									<div class="security-wrapper">
										<a href="{{config('view_url.channel_target_url')}}warranty_info" id="warranty_info_y" class="bottom-slip">
											<div class="slip-left">
												<div class="slip-manager">
													<div >
														<span class="slip-manager-top">韵达快递保·人身意外综合保险</span>
													</div>
													<div class="slip-manager-nei">
														<span class="slip-manager-bot size" >保单号:<span class="slip-manager-bot-left">{{$warranty_res['warranty_code']}}</span></span>
														<div style="margin-top: .1rem;">
															<span class="slip-manager-bot size" >生效时间:<span class="slip-manager-bot-left">{{date('Y-m-d',strtotime($value['start_time']))}}07:00-23:59:59</span></span>
														</div>
													</div>
												</div>
											</div>
											<div class="slip-center">
												<div class="slip-center-right">
													<img src="{{config('view_url.channel_url')}}imges/turn-into.png" />
												</div>
											</div>
										</a>
									</div>
								@endif
							@endforeach
						@endif
				</div>
			</div>
		</div>
	</div>
</div>
</div>
<script src="{{config('view_url.channel_url')}}js/lib/jquery-1.11.3.min.js"></script>
<script src="{{config('view_url.channel_url')}}js/lib/mui.min.js"></script>
<script src="{{config('view_url.channel_url')}}js/common.js"></script>
<script src="{{config('view_url.channel_url')}}js/lib/mui.pullToRefresh.js"></script>
<script src="{{config('view_url.channel_url')}}js/lib/mui.pullToRefresh.material.js"></script>
<script>
    $('.head-right').on('tap',function () {
        Mask.loding();
        location.href="bmapp:homepage";
    });
    $('.head-left').on('tap',function(){
        Mask.loding();
        window.history.go(-1);
    });
    $('#warranty_info_y').on('tap',function(){
        Mask.loding();
    });
    $('#warranty_info_n').on('tap',function(){
        Mask.loding();
    });
    $('#warranty_info_y2').on('tap',function(){
        Mask.loding();
    });
    $('#warranty_info_n2').on('tap',function(){
        Mask.loding();
    });
    //				mui.init();
    mui('.mui-scroll-wrapper').scroll({
        bounce: false,
        indicators: true, //是否显示滚动条
    });
    var currentIndex = 0;
    document.getElementById('slider').addEventListener('slide', function(e) {
        if (e.detail.slideNumber === 0) {
            currentIndex = 0;
        }
        if (e.detail.slideNumber === 1) {
            currentIndex = 1;
        }
    });

    var pageNum = {
        security_cur: 1, // 在保保单当前页码
        security_tol: 1, // 在保保单总页码
        failure_cur: 1, // 失保保单当前页码
        failure_tol: 3, // 失保保单总页码
    };
    mui.ready(function() {
        mui.each(document.querySelectorAll('.mui-slider-group .mui-scroll'), function(index, pullRefreshEl) {
            mui(pullRefreshEl).pullToRefresh({
                up: {
                    contentnomore:'暂无更多',
                    callback: function() {
                        var self = this;

                        // 当前页数
                        currentIndex === 0 ? pageNum.security_cur++ : pageNum.failure_cur++;

                        // 判断是否还有数据
                        total = currentIndex === 0 ? pageNum.security_tol : pageNum.failure_tol;
                        cur = currentIndex === 0 ? pageNum.security_cur : pageNum.failure_cur;

                        if(cur <= total){
                            var imgStr = currentIndex === 0 ? '<img src="/channel_info/imges/Security-label.png"/>' : '<img src="/channel_info/imges/Failure-label.png"/>';
                            setTimeout(function() {
//                                var html = '<a class="bottom-slip" href="/channelsapi/warranty_info"  id="warranty_info_n">\
//															<div class="slip-left">\
//																<div class="slip-manager">\
//																	<div >\
//																		<span class="slip-manager-top">韵达快递保·人身意外综合保险</span>\
//																	</div>\
//																	<div class="slip-manager-nei">\
//																		<span class="slip-manager-bot size" >保单号:<span class="slip-manager-bot-left">001021122201719812353344514</span></span>\
//																		<div style="margin-top: .1rem;">\
//																			<span class="slip-manager-bot size" >生效时间:<span class="slip-manager-bot-left">今天08:50-23:59:59</span></span>\
//																		</div>\
//																	</div>\
//																</div>\
//															</div>\
//															<div class="slip-center">\
//																<div class="slip-center-right">\
//																	<img src="/channel_info/imges/turn-into.png" />\
//																</div>\
//															</div>\
//														</a>';
                                currentIndex === 0 ? $('.security-wrapper').append(html) : $('.failure-wrapper').append(html);
                                self.endPullUpToRefresh(false);

                                if(cur == total){
                                    self.endPullUpToRefresh(true);
                                }
                            }, 1000);
                        }else{
                            self.endPullUpToRefresh(true);
                        }
                    }
                }
            });
        });
    });
</script>
</body>

</html>