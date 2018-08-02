<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>理赔进度—详情</title>
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
		.slip-center img{
			width: 65%;
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
<?php
$res = json_decode($res,true)[0];
?>
<?php
//dump($res);
?>
@if(isset($res['lost_money']))
{{--财产理赔详情--}}
<div id="offCanvasWrapper" class="mui-off-canvas-wrap mui-slide-in mui-draggable">
	<div class="mui-inner-wrap"style="height: 100%;">
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
				<span>理赔详情</span>
			</div>
		</header>
		<div class="mui-content" style="background-color: #efeff4;">
			<div id="slider1" class="swipe">
				<div class="shixiao">
					<div class="shixiao-head">
						<span >保单号:</span><span>
							@if(!empty($res['policy_no']))
								{{$res['policy_no']}}
							@else
								{{$warranty_code}}
							@endif
						</span>
					</div>
					<div class="shixiao-head1">
						<span >出险时间:</span><span>{{$res['tka_accidentDate']}}</span>
					</div>
				</div>
				<div class="color">
				</div>
				<div class="bottom">
					<div class="slip-manager-shixiao">
						<div class="slip-left">
							<div class="slip-manager">
								<div class="slip-manager-top">{{$res['lrt_name']}}</div>
								<div class="slip-manager-nei">
									<span class="slip-manager-bot size" >被保人:<span class="slip-manager-bot-left">{{$res['tka_name']}}</span></span>
									<div style="margin-top: .16rem;">
										<span class="slip-manager-bot size" >保险期限:<span class="slip-manager-bot-left">{{date('Y-m-d',strtotime($res['tka_accidentDate'])).'  07:00:00'}}至{{date('Y-m-d',strtotime($res['tka_accidentDate'])).'  23:59:59'}}</span></span>
									</div>
									<div style="margin-top: .16rem;">
										<span class="slip-manager-bot size" >证件号码:<span class="slip-manager-bot-left">{{$res['lost_money']}}</span></span>
									</div>
									<div style="margin-top: .16rem;">
										<span class="slip-manager-bot size" >报案号:<span class="slip-manager-bot-left">{{$res['claim_id']}}</span></span>
									</div>
									<div style="margin-top: .16rem;">
										<span class="slip-manager-bot size" >损失金额:<span class="slip-manager-bot-left">{{$res['lost_money']}}</span></span>
									</div>
									<div style="margin-top: .16rem;">
										<span class="slip-manager-bot size" >理赔金额:<span class="slip-manager-bot-left">{{$res['claim_money']}}</span></span>
									</div>
									<div style="margin-top: .16rem;">
										<span class="slip-manager-bot size" >出险地区:<span class="slip-manager-bot-left">{{$res['tka_address']}}</span></span>
									</div><div style="margin-top: .16rem;">
										<span class="slip-manager-bot size" >理赔类型:<span class="slip-manager-bot-left">{{$res['claim_type_desc']}}</span></span>
									</div>
									<div style="margin-top: .16rem;">
										<b><span class="slip-manager-bot size" >理赔状态:<span class="slip-manager-bot-left" style="font-size: 16px">{{$res['claim_status']}}</span></span></b>
									</div>
								</div>
							</div>
						</div>
						<div class="slip-center">
							@if($res['claim_status']=='理赔完成')
								<img src="/channel_info/imges/inclaims-end.png">
							@else
								<img src="/channel_info/imges/replenish.png">
							@endif
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
				</div>
			</div>
		</div>
	</div>
</div>
@elseif(isset($res['weClaim_applystatus']))
	<div id="offCanvasWrapper" class="mui-off-canvas-wrap mui-slide-in mui-draggable">
		<div class="mui-inner-wrap"style="height: 100%;">
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
					<span>理赔详情</span>
				</div>
			</header>
			<div class="mui-content" style="background-color: #efeff4;">
				<div id="slider1" class="swipe">
					<div class="shixiao">
						<div class="shixiao-head">
							<span >保单号:</span><span>{{$warranty_code}}</span>
						</div>
						<div class="shixiao-head1">
							<span >出险日期:</span><span>{{date('Y-m-d',strtotime($res['claim_date']))}}</span>
						</div>
					</div>
					<div class="color">
					</div>
					<div class="bottom">
						<div class="slip-manager-shixiao">
							<div class="slip-left">
								<div class="slip-manager">
									<div class="slip-manager-top">韵达快递保
										<span class="slip-manager-bot size" >
											<span class="slip-manager-bot-left">泰康在线</span>
										</span>
									</div>
									<div class="slip-manager-nei">
										<span class="slip-manager-bot size" >被保人:<span class="slip-manager-bot-left">{{$apply_res['warrantyRule']['warranty_rule_order']['warranty_recognizee'][0]['name']}}</span></span>
										<div style="margin-top: .16rem;">
											<span class="slip-manager-bot size" >保险期限:<span class="slip-manager-bot-left">{{date('Y-m-d',strtotime($warranty_res['created_at'])).'  07:00:00'}}至{{date('Y-m-d',strtotime($warranty_res['created_at'])).'  23:59:59'}}</span></span>
										</div>
										<div style="margin-top: .16rem;">
											<span class="slip-manager-bot size" >报案号:<span class="slip-manager-bot-left">{{$res['claim_id']}}</span></span>
										</div>
										<div style="margin-top: .16rem;">
											<span class="slip-manager-bot size" >投保单号:<span class="slip-manager-bot-left">{{$warranty_code}}</span></span>
										</div>
										<div style="margin-top: .16rem;">
											<span class="slip-manager-bot size" >理赔类型:<span class="slip-manager-bot-left">{{$res['claim_type']}}</span></span>
										</div>
										@if(isset($res['account_detail'][2])&&!empty($res['account_detail'][2]))
										<div style="margin-top: .16rem;">
											<span class="slip-manager-bot size" >理赔金额:<span class="slip-manager-bot-left">{{$res['account_detail'][2]['totalMoney']}}</span></span>
										</div>
										@endif
										<div style="margin-top: .16rem;">
											<span class="slip-manager-bot size" >理赔状态:<span class="slip-manager-bot-left">{{$res['weClaim_applystatus']}}</span></span>
										</div>
										<div style="margin-top: .16rem;">
											<span class="slip-manager-bot size" >理赔状态备注:<span class="slip-manager-bot-left">{{$res['eluClaim_applystatus']}}</span></span>
										</div>
									</div>
								</div>
							</div>
							<div class="slip-center">
								@if(isset($res['quesNo'])&&!empty($res['quesNo']))
									<img src="/channel_info/imges/replenish.png">
								@elseif($res['weClaim_applystatus']=='已结案')
									<img src="/channel_info/imges/inclaims-end.png">
								@else
									<img src="/channel_info/imges/inclaims.png">
								@endif
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
						@if(isset($res['quesNo'])&&!empty($res['quesNo']))
							<div style="text-align: center;margin-top: .4rem;">
								<a href="{{config('view_url.channel_target_url')}}claim_add_material/{{$warranty_code}}" id="claim_target">
									<button style="width: 6.9rem;height: .8rem;background-color: #f6d85f;color: #744c22;font-size: .24rem;text-align: center;">补充资料</button>
								</a>
							</div>
						@endif
					</div>
				</div>
			</div>
		</div>
	</div>
@endif
<script src="{{config('view_url.channel_url')}}js/lib/jquery-1.11.3.min.js"></script>
<script src="{{config('view_url.channel_url')}}js/lib/mui.min.js"></script>
<script src="{{config('view_url.channel_url')}}js/common.js"></script>
@include('frontend.channels.insure_alert')
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