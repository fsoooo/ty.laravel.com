<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>快递保</title>
		<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
		<link rel="stylesheet" href="{{config('view_url.channel_url')}}css/lib/mui.min.css">
		<link rel="stylesheet" href="{{config('view_url.channel_url')}}css/lib/iconfont.css" />
		<link rel="stylesheet" href="{{config('view_url.channel_url')}}css/common.css" />
		<link rel="stylesheet" href="{{config('view_url.channel_url')}}css/index.css" />
		<script src="{{config('view_url.channel_url')}}js/baidu.statistics.js"></script>
		<style type="text/css">
			.weitoubao{
				height: 1.84rem;
				background-color: #fff;
				overflow: hidden;
			}
			.weitoubao-left{
				float: left;
				width: .5rem;
				height: .5rem;
				margin-top: .67rem;
				margin-left: .4rem;
			}
			.weitoubao-right{
				float: left;
				margin-left: .5rem;
				width: 5.1rem;
				font-size: .28rem;
				color: #333;
				line-height: 0.43rem;
				margin-top: .3rem;
			}
			.href{
				color: #267cfc;
				border-bottom: 1px solid #267cfc;
			}
			.weitoubao-center-title{
				width: 6.8rem;
				padding-top: .3rem;
				color: #333;
				margin: auto;
				font-size: .28rem;

			}
			.slip-manager-shixiao-weitou{
				/*height: 4.78rem;*/
				background-color: #fff;
				padding-bottom: 4.3rem;
			}
			.weitoubao-center-title-color{
				color: #ea1111;
			}
			.weitoubao-center-time{
				margin: auto;
				margin-top: .6rem;
				width: 2.48rem;
				height: .82rem;
				border: 1px solid #ddd;
				border-radius: .06rem;
				text-align: center;
				line-height: .82rem;
			}
			.center-time{
				font-size: .5rem;
				color: #ff8e00;
			}
			.weitoubao-center-jh{
				margin: auto;
				margin-top: .6rem;
				width: 1.64rem;
				height: .6rem;
				border: 1px solid #ddd;
				border-radius: .06rem;
				text-align: center;
				line-height: .6rem;
			}
			.center-jh{
				font-size: .24rem;
				color: #744c22;
			}
			.bottom-buttom{
				width: 6.9rem;
				height: .8rem;
				background-color: #f6d85f;
				color: #744c22;
				font-size: .24rem;
				text-align: center;
			}
			.weitoubao{
				height: 1.84rem;
				background-color: #fff;
				overflow: hidden;
			}
			.weitoubao-left{
				float: left;
				width: .5rem;
				height: .5rem;
				margin-top: .67rem;
				margin-left: .4rem;
			}
			.weitoubao-right{
				float: left;
				margin-left: .5rem;
				width: 5.5rem;
				font-size: .28rem;
				color: #333;
				line-height: 0.43rem;
				margin-top: .3rem;
			}
			.href{
				color: #267cfc;
				border-bottom: 1px solid #267cfc;
			}
			.weitoubao-center-title{
				width: 6.8rem;
				padding-top: .5rem;
				color: #333;
				margin: auto;
				font-size: .28rem;

			}
			.weitoubao-center-title-color{
				color: #ea1111;
			}
			.weitoubao-center-time{
				margin: auto;
				margin-top: .6rem;
				width: 2.48rem;
				height: .82rem;
				border: 1px solid #ddd;
				border-radius: .06rem;
				text-align: center;
				line-height: .82rem;
			}
			.center-time{
				font-size: .5rem;
				color: #ff8e00;
			}
			.weitoubao-center-jh{
				margin: auto;
				margin-top: .6rem;
				width: 1.64rem;
				height: .6rem;
				border: 1px solid #ddd;
				border-radius: .06rem;
				text-align: center;
				line-height: .6rem;
			}
			.center-jh{
				font-size: .24rem;
				color: #744c22;
			}
			.bottom-buttom{
				margin-top: 1rem;
				width: 6.9rem;
				height: .8rem;
				background-color: #f6d85f;
				color: #744c22;
				font-size: .24rem;
				text-align: center;
			}

		</style>
	</head>
	<body>
	{{--loading--}}
	@include('frontend.channels.insure_mask')
	{{--loading--}}
		<div id="offCanvasWrapper" class="mui-off-canvas-wrap mui-slide-in mui-draggable">
			<div class="mui-inner-wrap" style="height: 77%;">
				<header class="mui-bar mui-bar-nav">
					<div class="head-left">
					<div class="head-img">
						<a href="bmapp:homepage"><img src="{{config('view_url.channel_url')}}imges/back.png"/></a>
					</div>
					</div>
					<div class="head-right">
						<a href="bmapp:homepage"><i class="iconfont icon-close"></i></a>
					</div>
					<div class="head-title">
						<span>快递保</span>
					</div>
				</header>
				<div class="mui-content" style="background-color: #efeff4;">
					<div id="slider1" class="swipe">
						<div class="weitoubao">
							<div class="weitoubao-left">
								<img src="{{config('view_url.channel_url')}}imges/选中状态.png" />
							</div>
							<div class="weitoubao-right">
								<span>同意投保“<a href="{{config('view_url.channel_target_url')}}insure_info" id="insure_info_target">快递保</a>”保险，并授权保险公司从本人银行卡中扣除，已知晓
									<a href="{{config('view_url.channel_target_url')}}clause_info" id="clause_target"><span style="color: mediumblue">保险条款</span></a>、
									<a href="{{config('view_url.channel_target_url')}}insure_notice" id="notice_target"><span style="color: mediumblue">投保须知</span></a>和
									<a href="{{config('view_url.channel_target_url')}}insure_auto_pay" id="auto_pay"><span style="color: mediumblue">自动转账授权声明</span></a>。
								</span>
							</div>
						</div>
						<div class="color"></div>
						<div class="bottom">
							<div class="slip-manager-shixiao-weitou">
								<div class="weitoubao-center-title">
									<p class="weitoubao-center-title-color" style="text-align: center;margin-bottom: .14rem;">保险说明</p>
									<span >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;每天早上从扫描枪给您分拣第一个包裹开始，即自动为您投保，保期到当天23:59:59，保费为2元/天。<span class="weitoubao-center-title-color">当天未配送则不扣费，倒计时完成前，取消勾选，则当天不投保。</span></span>
								</div>
								<div class="weitoubao-center-time">
									<span class="center-time" id="timeCounter">00:01:59</span>
								</div>
								<div class="weitoubao-center-jh">
									<a href="{{config('view_url.channel_target_url')}}insure_info" id="insure_info"><span class="center-jh">保障计划</span></a>
								</div>
								<div style="text-align: center;">
								@if(!empty($url))
								<form action="{{$url}}" method="post">
                                <input type="submit"  class="bottom-buttom"  value="确认投保">
								</form>
								@else
								<a href="{{config('view_url.channel_target_url')}}get_insure" id="insure_target"><button class="bottom-buttom">确认投保</button></a>
								@endif
									
									<!--0!-->
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		@include('frontend.channels.insure_alert')
		<script src="{{config('view_url.channel_url')}}js/lib/jquery-1.11.3.min.js"></script>
		<script src="{{config('view_url.channel_url')}}js/lib/mui.min.js"></script>
		<script src="{{config('view_url.channel_url')}}js/common.js"></script>
		<script typet="text/javascript" src="https://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
		<script>
            var TIME = 300; // 自定义倒计时总秒数
            var timer = null;
            $('.weitoubao-left').on('tap',function(){
                $(this).toggleClass('unactive');
                if($(this).hasClass('unactive')){
                    $(this).find('img').attr('src','/channel_info/imges/非选环中状态.png');
                    clearInterval(timer);
                    timer = null;
                }else{
                    $(this).find('img').attr('src','/channel_info/imges/选中状态.png');
                    total = TIME;
                    timeCounter();
                }
            });
            var total = TIME;
            var timeCounter = (function() {
                return function() {
                    obj = document.getElementById('timeCounter');
                    var s = (total%60) < 10 ? ('0' + total%60) : total%60;
                    var h = total/3600 < 10 ? ('0' + parseInt(total/3600)) : parseInt(total/3600);
                    var m = (total-h*3600)/60 < 10 ? ('0' + parseInt((total-h*3600)/60)) : parseInt((total-h*3600)/60);
                    obj.innerHTML = h + ':' + m + ':' + s;
                    total--;
                    timer = setTimeout("timeCounter()", 1000);
                    if(total < 0){
                        clearTimeout(timer);
                        $('#insure_target').trigger('tap');
                    }
                }
            })();
            timeCounter();
            $('#insure_target').on('tap',function(){
                Mask.loding();
                console.log('确认投保');
            });
            $('.head-right').on('tap',function () {
                Mask.loding();
                location.href="bmapp:homepage";
            });
            $('.head-left').on('tap',function(){
                Mask.loding();
                location.href="bmapp:homepage";
            });
            $('#clause_target').on('tap',function(){
                Mask.loding();
            });
            $('#notice_target').on('tap',function(){
                Mask.loding();
            });
            $('#insure_info_target').on('tap',function(){
                Mask.loding();
            });
            $('#insure_info').on('tap',function(){
                Mask.loding();
            });
			$('.mask-bg').click(function(){
				$('.mask').hide();
			});
			setTimeout(function(){
				$('.mask').hide();
			},3000)

		</script>
	</body>
</html>