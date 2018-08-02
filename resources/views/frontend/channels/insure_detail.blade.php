<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>保障计划</title>
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
			.header-slip{
				height: .86rem;
				text-align: center;
				line-height: .86rem;
				background-color: #fff;
				border: 1px solid #ddd;
			}
			.head-with{
				width: 1.72rem;
				border-right: 1px solid #ddd;
			}
			.head-color{
				font-size: .28rem;
				color: #ff8a00;
			}
			.tab tr{
				text-align: center;
				border-bottom: 1px solid #ddd;

			}
			.tab tr td{

				border-right: 1px solid #ddd;
			}

			/*.tab-tr-td{
				height: .86rem;
				line-height:.86rem ;
			}*/
			.tab{
				background-color: #fff;
			}
			.tab-tr-td1{
				height: 2.72rem;
				line-height: 2.72rem;


			}
			.tab-tr-td-ul li{
				height: .87rem;
				line-height: .9rem;
				border-bottom: 1px solid #ddd;

			}
			.tab-tr-span{
				font-size: .24rem;
				color: #333;
				line-height: .83rem;
			}
			.tab-tr1{
				height: 1.36rem;
				line-height: 1.36rem;
			}
			.tab-tr2{
				height: .86rem;
				line-height: .86rem;
			}
			.detil-bottom{
				margin-top: .3rem;
				margin-left: .3rem;
			}
			.detil-bottom-size{
				font-size: .28rem;
				color: #333;
			}
			.detil-bottom-tell{
				overflow: hidden;
				line-height: .3rem;
				margin-left: .1rem;
				margin-top: .5rem;
				margin-bottom: .1rem;
			}
			.detil-bottom-tell-left{
				float: left;
				width: .65rem;
				height: .65rem;
			}
			.detil-bottom-tell-right{
				float: left;
				margin-left: .2rem;
				font-size: .24rem;
				color: #003333;
			}
			thead{
				color: #ff8a00;
			}
			tr{
				height: 1rem;
				line-height: 1rem;
			}
			.mui-scroll-wrapper{top: 1.32rem;bottom: 0!important;}
			.list{
				padding: .5rem;
			}
			.list .title{
				margin-bottom: .2rem;
				font-size: .3rem;
			}
			.list ul{
			}
			.list li{
				line-height: 2;
				font-size: .28rem;
				text-align: justify;
			}
		</style>
	</head>
	<body>
	{{--loading--}}
	@include('frontend.channels.insure_mask')
	{{--loading--}}
	<div id="offCanvasWrapper" class="mui-off-canvas-wrap mui-slide-in mui-draggable">
		<div class="mui-inner-wrap">
			<div class="status"></div>
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
					<span>保障计划</span>
				</div>
			</header>
			<div class="mui-content" style="">
				<div class="mui-scroll-wrapper">
					<div class="mui-scroll">
				<div id="slider1" class="swipe">
					<div class="header">
						<div >
							<span class="detil-name">产品名称:<span class="detil-name-color">韵达快递保·人身意外综合保险</span></span>
						</div>
						<div class="header-bottom">
							<span class="detil-name">保险公司名称:<span class="detil-name-color">泰康在线</span></span>
						</div>
					</div>
					<div class="color">
					</div>
					<div class="bottom">
						<div id="insure_clause">
							<table class="tab">
								<thead>
								<td>保障权益</td>
								<td>保额</td>
								</thead>
								<tr>
									<td>人身意外伤害身故/伤残</td>
									<td>200,000元</td>
								</tr>
								<tr>
									<td>意外伤害医疗</td>
									<td>10,000元</td>
								</tr>
								<tr>
									<td>非机动车第三者责任保险(死亡、伤残、医疗)</td>
									<td>50,000元</td>
								</tr>
								<tr>
									<td>非机动车第三者责任保险(财产损失)</td>
									<td>10,000元</td>
								</tr>
							</table>
						</div>
						<div class="color">
						</div>
						<div class="">
							<div class="detil-bottom">
								<span class="detil-bottom-size">理赔流程</span>
								<div class="detil-bottom-tell">
									<div class="detil-bottom-tell-left">
										<img src="{{config('view_url.channel_url')}}imges/carmea.png" />

									</div>
									<div class="detil-bottom-tell-right">
										<span>图片（相机拍照）</span><br />
										<span style="margin-top: .05rem;">拍摄现场出险照片，车辆照片</span>
									</div>
								</div>
								<div class="detil-bottom-tell">
									<div class="detil-bottom-tell-left">
										<img src="{{config('view_url.channel_url')}}imges/-lp_1.png" />

									</div>
									<div class="detil-bottom-tell-right">
										<span>图片（电话）拨打交警电话122</span><br />
										<span style="margin-top: .05rem;">要求交警来现场并索要《交警事故鉴定书》</span>
									</div>
								</div>
								<div class="detil-bottom-tell">
									<div class="detil-bottom-tell-left">
										<img src="{{config('view_url.channel_url')}}imges/-lp_2.png" />

									</div>
									<div class="detil-bottom-tell-right">
										<span style="line-height: .6rem;">在“韵镖侠”APP中报案并描述出险的基本情况</span><br />
									</div>
								</div>


								<div class="detil-bottom-tell">
									<div class="detil-bottom-tell-left">
										<img src="{{config('view_url.channel_url')}}imges/-lp_4.png" />

									</div>
									<div class="detil-bottom-tell-right">
										<span>处理事故，该看病看病，该赔偿赔偿,</span><br />
										<span style="margin-top: .05rem;">并保留好所有发票单据和与第三者的和解书</span>
									</div>
								</div>

								<div class="detil-bottom-tell">
									<div class="detil-bottom-tell-left">
										<img src="{{config('view_url.channel_url')}}imges/-lp_3.png" />

									</div>
									<div class="detil-bottom-tell-right">
										<span>将单据上传至“韵镖侠”APP中</span><br />
										<span style="margin-top: .05rem;">等待保险公司核赔并赔款</span>
									</div>

								</div>
							</div>
						</div>
					</div>
				</div>
						<div class="list">
							<h2 class="title">特别声明</h2>
							<ul>
								<li>1.本产品起保时间为当天7:00，止保时间为当天23:59:59；</li>
								<li>2.本产品仅承保被保险人驾驶韵达指定非机动车从快递分拣开始至送件或取件结束期间发生的意外损失，具体保障责任时间以上述两个时间段为准；</li>
								<li>3.本产品被保险人投保年龄：18-60周岁（含）;</li>
								<li>4.本产品出险后需提供交警开具的《交通事故责任认定书》或公安部门出具的报/立案证明；</li>
								<li>5.本产品意外伤害医疗保险责任免赔额100元；</li>
								<li>6.本产品附加非机动车第三方财产损失免赔为500元或者第三方财产损失的5%，两者以高者为准；</li>
							</ul>
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
            $('#insure_clause').on('tap',function(){
                Mask.loding();
                location.href="/channelsapi/clause_info";
            });
		</script>
	</body>
</html>