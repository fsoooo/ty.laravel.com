<!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8">
		<title>自动扣款声明须知</title>
		<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
		<link rel="stylesheet" href="{{config('view_url.channel_url')}}css/lib/mui.min.css">
		<link rel="stylesheet" href="{{config('view_url.channel_url')}}css/lib/iconfont.css" />
		<link rel="stylesheet" href="{{config('view_url.channel_url')}}css/common.css" />
		<link rel="stylesheet" href="{{config('view_url.channel_url')}}css/index.css" />
		<script src="{{config('view_url.channel_url')}}js/baidu.statistics.js"></script>
		<style type="text/css">
			.header{
				height: 1.25rem;
				background-color: #fff;
				padding-left: .3rem;
				padding-top: .3rem;
			}
			.header-bottom{
				margin-top: .15rem;
			}
			.detil-name{
				color: #666;
				font-size: .28rem;
			}
			.detil-name-color{
				color: #333;
				font-size: .28rem;
				margin-left: .15rem;
			}
			.mui-scroll{
				padding: .2rem;
				font-size: 14px;
				text-align: justify;
			}
			p{
				line-height: 1.6;
			}
			.mui-scroll-wrapper{
				top: 3.2rem;
				bottom: 0!important;
			}
			.title{
				height: .6rem;
				line-height: .6rem;
				font-size: .28rem;
				text-align: center;
				background: #f7f7f7;
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
						<i class="iconfont icon-close"></i>
					</div>
					<div class="head-title">
						<span>自动扣款声明须知</span>
					</div>
				</header>
				<div class="mui-content">
					<div class="header">
						<div>
							<span class="detil-name">产品名称:<span class="detil-name-color">韵达快递保·人身意外综合保险</span></span>
						</div>
						<div class="header-bottom">
							<span class="detil-name">保险公司名称:<span class="detil-name-color">泰康在线</span></span>
						</div>
					</div>
					<h1 class="title">自动扣款声明须知</h1>
					<div class="mui-scroll-wrapper">
						<div class="mui-scroll"><p style="text-align:center"><strong></strong></p><p><span style=";font-family:Calibri;font-size:14px">&nbsp;</span></p><p><span style=";font-family:宋体;color:rgb(255,0,0);font-size:14px">*</span><span style=";font-family:宋体;font-size:14pxfont-family:宋体">投保人同意授权泰康在线通过该投保人提供的微信支付账户中转账支付与泰康在线约定的保险费。</span></p><p><span style=";font-family:宋体;font-size:14px">&nbsp;</span></p><p><span style=";font-family:宋体;color:rgb(255,0,0);font-size:14px">*</span><span style=";font-family:宋体;font-size:14pxfont-family:宋体">投保人保证其提供的微信账户中有足够的金额支付应交保险费，若因账户存款余额不足造</span></p><p><span style=";font-family:宋体;font-size:14pxfont-family:宋体">成转账不成功，致合同不能成立或不能持续有效，因此引起的责任概由投保人承担。</span></p><p><span style=";font-family:宋体;font-size:14px">&nbsp;</span></p><p><span style=";font-family:宋体;color:rgb(255,0,0);font-size:14px">*</span><span style=";font-family:宋体;font-size:14pxfont-family:宋体">如因系统原因保费划转不成功，造成合同未成立，保险公司不承担责任。</span></p><p><span style=";font-family:宋体;color:rgb(255,0,0);font-size:14px">&nbsp;</span></p><p><span style=";font-family:宋体;color:rgb(255,0,0);font-size:14px">*</span><span style=";font-family:宋体;font-size:14pxfont-family:宋体">投保人同意将其提供的微信账户默认设置为常用账户，该常用账户的扣费规则同上。</span></p><p><span style=";font-family:Calibri;font-size:14px">&nbsp;</span></p><p><br/></p></div>
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