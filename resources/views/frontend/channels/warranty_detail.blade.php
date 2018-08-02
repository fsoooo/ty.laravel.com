<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>我的保单-保障中</title>
		<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
		<link rel="stylesheet" href="{{config('view_url.channel_url')}}css/lib/mui.min.css">
		<link rel="stylesheet" href="{{config('view_url.channel_url')}}css/lib/iconfont.css" />
		<link rel="stylesheet" href="{{config('view_url.channel_url')}}css/common.css" />
		<link rel="stylesheet" href="{{config('view_url.channel_url')}}css/index.css" />
		<script src="{{config('view_url.channel_url')}}js/baidu.statistics.js"></script>
		<style type="text/css">
			.shixiao-head{
				margin-left: .4rem;
				padding-top: .3rem;
				font-size: .28rem;
				color: #333;
			}
			.shixiao-head1{
				margin-left: .4rem;
				margin-top: .16rem;
				font-size: .24rem;
				color: #999;
			}
			.shixiao{
				    height: 1.4rem;
				    border-bottom: 1px solid #ddd;
				    background-color: #fff;
			}
			.shixiao-img{
				margin-right: .5rem;
				margin-top: .45rem;
			}
			.slip-manager-shixiao{
				height: 2rem;
				background-color: #fff;
			}
			.slip-manager-shixiao-bottom{
				height: 2.4rem;
				background-color: #fff;
			}
			.shixiao-bottom{
				padding-top: .3rem;
				margin-left: .4rem;
			}
			.slip-manager-top-tab-right{
				float: right;
				margin-right: .5rem;
				color: #267cfc;
			}
			.left{
				float: left;
			}
			.slip-manager-top-tab ul{
				overflow: hidden;
			}
			.slip-manager-top-tab ul li{
				
				margin-top: .16rem;
			}
			.zongji{
				height: 1rem;
				line-height: 1rem;
				background-color: #fff;
			}
			.zongji-title{
				font-size: .30rem;
				color: #ff8a00;
				margin-left: .4rem;
			}
			.slip-manager-shixiao{
				background: #fff url(/channel_info/imges/Security-label.png) no-repeat 88%;
				background-size: 1rem;
			}
			.slip-left{
				margin-top: 0;
			}
			.slip-manager-shixiao{
				height: auto;
				padding: .3rem 0;
				overflow: hidden;
			}
			.slip-manager-top{
				height: .4rem;
				line-height: .4rem;
			}
		</style>
	</head>
	<body>
	{{--loading--}}
	@include('frontend.channels.insure_mask')
	{{--loading--}}
		<div id="offCanvasWrapper" class="mui-off-canvas-wrap mui-slide-in mui-draggable">
			<div class="mui-inner-wrap"style="height: 80%;">
				<header class="mui-bar mui-bar-nav">
					<div class="head-left">
					<div class="head-img">
						<img src="{{config('view_url.channel_url')}}imges/back.png"/>
					</div>
					</div>
					<div class="head-right">
						<a href="bmapp:homepage"><i class="iconfont icon-close"></i></a>
					</div>
					<div class="head-title">
						<span>我的保单</span>
					</div>
				</header>
				<div class="mui-content" style="background-color: #efeff4;">
					<div id="slider1" class="swipe">
						<div class="shixiao">
							<div class="shixiao-head">
								<span >订单号:</span><span>{{$res['order']['order_code']}}</span>
							</div>
							<div class="shixiao-head1">
								<span >创建时间:</span><span>{{$res['order']['created_at']}}</span>
							</div>
						</div>
						<div class="color"></div>
						<div class="bottom">
							<div class="slip-manager-shixiao">
								<div class="slip-left">
									<div class="slip-manager">
										<div >
											<span class="slip-manager-top">韵达快递保·人身意外综合保险</span>
										</div>
										<div class="slip-manager-nei">
											<span class="slip-manager-bot size" >被保人:<span class="slip-manager-bot-left">{{$res['channel_user_info']['channel_user_name']}}</span></span>
											<div style="margin-top: .16rem;">
												<span class="slip-manager-bot size" >保险期限:<span class="slip-manager-bot-left">分拣时间至&nbsp;{{$time}}&nbsp;23:59:59</span></span>
											</div>
											<div style="margin-top: .16rem;">
												<span class="slip-manager-bot size" >投保单号:<span class="slip-manager-bot-left">{{$res['warranty']['union_order_code']}}</span></span>
											</div>
										</div>
									</div>
								</div>
								<div class="slip-center">
									{{--<div class="slip-center-left shixiao-img" style="">--}}
										{{--<img src="{{config('view_url.channel_url')}}imges/Security-label.png"/>--}}
									{{--</div>--}}
								</div>
							</div>
							<div class="color">
							</div>
							<div class="slip-manager-shixiao-bottom">
								<div class="shixiao-bottom">
									<span class="slip-manager-top">保障权益</span>
									<div class="slip-manager-top-tab">
										<ul>
											<li class="slip-manager-bot size left">人身意外伤害身故/伤残</li>
											<li class="slip-manager-top-tab-right">200,000元</li>
										</ul>
										<ul>
											<li class="slip-manager-bot size left">意外伤害医疗</li>
											<li class="slip-manager-top-tab-right">10,000元</li>
										</ul>
										<ul>
											<li class="slip-manager-bot size left">非机动车第三者责任保险（死亡、伤残、医疗）</li>
											<li class="slip-manager-top-tab-right">50,000元</li>
										</ul>
										<ul>
											<li class="slip-manager-bot size left">非机动车第三者责任保险（财产损失)</li>
											<li class="slip-manager-top-tab-right">10,000元</li>
										</ul>
									</div>
								</div>
							</div>
							<div class="color">
							</div>
							<div class="zongji">
								<div class="zongji-title">
									<span>保费合计:<span>2元</span></span>
								</div>
							</div>
							<div style="text-align: center;margin-top: .4rem;">
								<a href="{{config('view_url.channel_target_url')}}to_claim" id="claim_target">
								<button style="width: 6.9rem;height: .8rem;background-color: #f6d85f;color: #744c22;font-size: .24rem;text-align: center;">提交理赔申请</button>
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<script src="{{config('view_url.channel_url')}}js/lib/jquery-1.11.3.min.js"></script>
		<script src="{{config('view_url.channel_url')}}js/lib/mui.min.js"></script>
		<script src="{{config('view_url.channel_url')}}js/common.js"></script>
		<script>
            $('.head-right').on('tap',function () {
                Mask.loding();
                location.href="bmapp:homepage";
            });
            $('.head-left').on('tap',function(){
                Mask.loding();
                window.history.go(-1);
            });
            $('#claim_target').on('tap',function(){
                Mask.loding();
            });

		</script>
	</body>
</html>