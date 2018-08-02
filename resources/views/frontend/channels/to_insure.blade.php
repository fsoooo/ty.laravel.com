<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>快递保</title>
		<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
		<link rel="stylesheet" href="{{config('view_url.channel_url')}}css/lib/mui.min.css">
		<link rel="stylesheet" href="{{config('view_url.channel_url')}}css/lib/iconfont.css">
		<link rel="stylesheet" href="{{config('view_url.channel_url')}}css/common.css" />
		<link rel="stylesheet" href="{{config('view_url.channel_url')}}css/index.css" />
		<link rel="stylesheet" href="{{config('view_url.channel_url')}}css/step.css" />
	</head>

	<body>
		<header class="mui-bar mui-bar-nav">
			<div class="head-left">
				<div class="head-img">
					<a href="bmapp:homepage"><img src="{{config('view_url.channel_url')}}imges/back.png"></a>
				</div>
			</div>
			<div class="head-right">
				<a href="bmapp:homepage"><i class="iconfont icon-close"></i></a>
			</div>
			<div class="head-title">
				<span>快递保</span>
			</div>
		</header>
		<div class="step1">
			<div class="mui-scroll-wrapper">
				<div class="mui-scroll">
					<div class="banner">
						<img src="{{config('view_url.channel_url')}}imges/banner_2.png" alt="" />
					</div>
					<div class="section section-one">
						<h3 class="title">保障内容</h3>
						<ul>
							<li><span class="ellipsis">意外身故、伤残保险金意外身故</span><span class="fr">20万</span></li>
							<li><span class="ellipsis">附加意外伤害医疗保险金</span><span class="fr">1万</span></li>
							<li><span class="ellipsis">附加第三方人身伤害（死亡、伤残、医疗）</span><span class="fr">5万</span></li>
						</ul>
						<a href="{{config('view_url.channel_target_url')}}insure_info" id="insure_info">查看保障详情</a>
					</div>
					<div class="section">
						<div class="section-item">
							<span class="section-right color-parimary">1天</span>
							<h3 class="title">保障时间</h3>
							<ul>
								<li>起保时间为当天7:00起至当天23:59:59止</li>
							</ul>
						</div>
						<div class="section-item">
							<span class="section-right btn-unfold"><i class="iconfont icon-xiajiantou"></i></span>
							<h3 class="title">投保说明</h3>
							<ul>
								<li>投保方式：自动投保</li>
								<li class="hide">自动投保是指当天开通免密支付协议后，每天上班后自动扣 除当天的保费，如果当日未上班则不扣费。</li>
							</ul>
						</div>
					</div>
					<div class="section section-three">
						<input hidden type="text" value="0" />
						<button id="agree" type="button" class="btn-check"></button>
						<div class="agree">我已阅读并理解以上内容，授权保险公司代"快递保"产品，并同意
							<a href="{{config('view_url.channel_target_url')}}clause_info" id="clause_target">
								《保险条款》
							</a>和
							<a href="{{config('view_url.channel_target_url')}}insure_notice" id="notice_target">
								《投保须知》
							</a>的全部内容</div>
					</div>
				</div>
			</div>
			{{--未签约显示--}}
			@if($status=='1')
			<div class="buttons-wrapper">
				<div class="btn btn-left"><span class="price">2.00</span>元/天</div>
				@if(isset($url)&&!empty($url))
					<form action="{{$url}}" method="post" id="do_insure_sign">
					</form>
				@endif
				<button id="open" type="button" class="btn btn-right" disabled>立即开通自动投保</button>
			</div>
			@endif
			{{--未签约显示--}}
		</div>
		<!--投保失败弹出层-->
		<div class="popups-wrapper popups-msg">
			<div class="popups-bg"></div>
			<div class="popups popups-tips">
				<div class="popups-title"><i class="iconfont icon-guanbi"></i></div>
				<div class="popups-content color-wraning">
					<i class="iconfont icon-error"></i>
					<p class="tips">获取签约链接失败！</p>
				</div>
			</div>
		</div>
		<script src="{{config('view_url.channel_url')}}js/lib/jquery-1.11.3.min.js"></script>
		<script src="{{config('view_url.channel_url')}}js/lib/mui.min.js"></script>
		<script src="{{config('view_url.channel_url')}}js/common.js"></script>
		<script>
			$(function(){
				var hide = $('.hide');
				var btn_agree = $('#agree');
				var step = {
					init: function(){
						var _this = this;
						$('.btn-unfold').click(function(){
							hide.toggleClass('hide');
							if(hide.hasClass('hide')){
								$(this).find('.iconfont').removeClass('icon-xiangshangjiantou1').addClass('icon-xiajiantou');
							}else{
								$(this).find('.iconfont').removeClass('icon-xiajiantou').addClass('icon-xiangshangjiantou1');
							}
						});
						_this.isAgree();
					},
					isAgree: function(){
						btn_agree.click(function(){
							var _that = $(this);
							_that.toggleClass('active');
							var status = _that.hasClass('active') == true ? 1 : 0;
							_that.prev().val(status);
							$('#open').prop('disabled',!_that.hasClass('active'));
						});
					}
				}
				step.init();
			});
            $('#insure_info').on('tap',function(){
                Mask.loding();
            });
            $('#clause_target').on('tap',function(){
                Mask.loding();
            });
            $('#notice_target').on('tap',function(){
                Mask.loding();
            });
            var sign_url = "{{$url}}";
            $('#open').on('tap',function(){
                if(sign_url){
                    $('#do_insure_sign').submit();
				}else{
                    Popups.open('.popups-msg');
				}
            });
		</script>
	</body>

</html>