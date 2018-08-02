<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>理赔方式</title>
		<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
		<link rel="stylesheet" href="{{config('view_url.channel_url')}}css/lib/mui.min.css">
		<link rel="stylesheet" href="{{config('view_url.channel_url')}}css/lib/iconfont.css" />
		<link rel="stylesheet" href="{{config('view_url.channel_url')}}css/common.css" />
		<link rel="stylesheet" href="{{config('view_url.channel_url')}}css/index.css" />
		<script src="{{config('view_url.channel_url')}}js/baidu.statistics.js"></script>
		<style type="text/css">
			.lipei{
				width: 1.36rem;
				height: 1.36rem;
				margin: auto;
				text-align: center;
				background-color: palevioletred;
				margin-top: 2.14rem;
			}
			.lipei1{
				width: 1.84rem;
				height: 1.34rem;
				margin: auto;
				text-align: center;
				margin-top: 1.84rem;
			}
			.lipei-tell{
				text-align: center;
				font-size: .24rem;
				color: #ff8a00;
				margin-top: .3rem;
			}
		</style>
	</head>
	<body>
	{{--loading--}}
	@include('frontend.channels.insure_mask')
	{{--loading--}}
		<div id="offCanvasWrapper" class="mui-off-canvas-wrap mui-slide-in mui-draggable">
			<div class="mui-inner-wrap">
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
						<span>理赔方式</span>
					</div>
				</header>
				<div class="mui-content" style="">
					<div id="slider1" class="swipe">
						<div class="lipei">
							<img src="{{config('view_url.channel_url')}}imges/phone.png" />
						</div>
						<div class="lipei-tell">
							<span>电话理赔:<span>45545689215</span></span>
						</div>
						<div class="lipei1">
							<img src="{{config('view_url.channel_url')}}imges/泰康二维码.png" />
						</div>
						<div class="lipei-tell">
							<span>微信理赔:关注泰康理赔公众号</span>
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
		</script>
	</body>
</html>