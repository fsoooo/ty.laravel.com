<!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8">
		<title>天眼互联-科技让保险无限可能</title>
		<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
		<link rel="stylesheet" href="{{config('view_url.view_url')}}mobile/css/lib/mui.min.css">
		<link rel="stylesheet" href="{{config('view_url.view_url')}}mobile/css/lib/iconfont.css" />
		<link rel="stylesheet" href="{{config('view_url.view_url')}}mobile/css/common.css" />
		<style>
			.mui-scroll-wrapper {top: .8rem;bottom: .8rem;}
			.mui-bar-nav {background: #025a8d;}
			.mui-icon-back,.mui-title {color: rgba(255, 255, 255, .8);}
			.mui-scroll-wrapper {top: .9rem;bottom: .98rem;}
			.success-header {height: 2rem;line-height: 2rem;font-size: .36rem;text-align: center;background: #fff;}
			.success-header .iconfont {margin-right: .2rem; font-size: .7rem;color: #A4D790;}
			.success-order {padding: 0 .5rem;background: #fff;}
			.success-order li {height: .7rem;line-height: .7rem;color: #313131;}
			.name {margin-right: .3rem;color: #999;}
			.share-wrapper {position: fixed;padding: .4rem 0;width: 100%;height: 2rem;bottom: .98rem;background: #fff;}
			.jiathis_button_cqq,.jiathis_button_weixin,.jiathis_button_tsina {display: none!important;}
			.jiathis_style {text-align: center;}
			.jiathis_style .iconfont {display: inline;margin: 0 .6rem;font-size: .9rem;}
			.icon-QQ {color: #30a5dd;}
			.icon-weixin {color: #45c45d;}
			.icon-weibo {color: #f44a73;}
			.buttonbox .btn-cancel {background: #fff;color: #FFAE00;border: 1px solid #FFAE00;}
			.jiathis_style li{float: left;width: 33%;}
			.jiathis_style li span{display: block;}
		</style>
	</head>

	<body>
		<div class="main">
			<header class="mui-bar mui-bar-nav">
				<a class="mui-icon mui-icon-back mui-pull-left mui-action-back"></a>
			</header>
			<div class="mui-content">
				<div class="mui-scroll-wrapper">
					<div class="mui-scroll">
						<div class="division"></div>
						<div class="success-header">
							<i class="iconfont icon-zhifuchenggong"></i>您已支付成功
						</div>
						<div class="division"></div>
						<div class="success-order">
							<ul>
								<li><span class="name">订单编号</span>{{isset($order_data['order_code'])?$order_data['order_code']:'--'}}</li>
								<li><span class="name">订单时间</span>{{isset($order_data['created_at'])?$order_data['created_at']:'--'}}</li>
								<li><span class="name">订单价格</span>{{isset($order_data['premium'])?$order_data['premium']/100:'--'}}元</li>
							</ul>
						</div>
					</div>
				</div>
				<div class="buttonbox">
					<a href="#popover" class="btn btn-next">分享</a>
				</div>
			</div>
			<div id="popover" class="mui-popover">
				<div class="share-wrapper">
					<!-- JiaThis Button BEGIN -->
					<div class="jiathis_style">
						<li>
							<i class="iconfont icon-QQ"></i>
							<a class="jiathis_button_cqq">分享到QQ</a>
							<span>QQ好友</span>

						<li>
							<i class="iconfont icon-weibo"></i>
							<a class="jiathis_button_tsina">分享到微博</a>
							<span>新浪微博</span>

						<li>
							<i class="iconfont icon-weixin"></i>
							<a class="jiathis_button_weixin">分享到微信</a>
							<span>微信</span>

					</div>

					<script type="text/javascript" src="http://v3.jiathis.com/code/jia.js?uid=2141334" charset="utf-8"></script>
					<!-- JiaThis Button END -->
				</div>
				<div class="buttonbox">
					<button class="btn btn-cancel">取消分享</button>
				</div>
			</div>
		</div>
		<script src="{{config('view_url.view_url')}}mobile/js/lib/jquery-1.11.3.min.js"></script>
		<script src="{{config('view_url.view_url')}}mobile/js/lib/mui.min.js"></script>
		<script src="{{config('view_url.view_url')}}mobile/js/common.js"></script>
		<script type="text/javascript">
            $('.icon-QQ').on('tap', function() {
                $('.jiathis_button_cqq').click();
            });
            $('.icon-weixin').on('tap', function() {
                $('.jiathis_button_weixin').click();
            });
            $('.icon-weibo').on('tap', function() {
                $('.jiathis_button_tsina').click();
            });
            $('.btn-cancel').on('tap', function() {
                mui('#popover').popover('hide');
            });

		</script>
	</body>

</html>