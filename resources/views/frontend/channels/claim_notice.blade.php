<!DOCTYPE HTML>
<html>
<head>
<title>我要理赔</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=5.0" charset="UTF-8">
<link href="{{config('view_url.channel_url')}}css/service.css" rel="stylesheet"/>
<link href="{{config('view_url.channel_url')}}css/claim.css" rel="stylesheet"/>
	<script src="{{config('view_url.channel_url')}}js/baidu.statistics.js"></script>

	<style>
    .navL{
        width: 32%;
    }
    .navL1{
        width: 36%;
        border-radius: 0px;
        border-color: #fff;
        background-color: #29B2F4;
    }
    .navR{
        width: 32%;
    }
    .widImg{width: 1.5rem;}
    .heihos{height: 4rem;line-height: 4rem;}
    .hospital{margin-bottom: .3rem;padding-bottom: 3.3rem;}
</style>
</head>
	<body style=" background-color:#fff;padding-top:3rem;">
		<div class="header">
	    	服务须知
	        <img src="{{config('view_url.channel_url')}}imges/arrow-left.png" class="arrow-left2" onclick="back();">
	        <img src="{{config('view_url.channel_url')}}imges/home.png" class="home" onclick="close_windows();">
	    </div>
	
		<div class="j-errorTipTitleWrap" style="width: 80%; margin: 2rem auto;">
	        <!-- <div class="tx-c t-red ulev2" style="padding-bottom: 0.8rem;">自助理赔服务须知</div> -->
	        <p class="t-6 ulev1 tx-l paddinglR line-height16 margin-t" style="padding-bottom: 0.6rem; letter-spacing: 0.1rem;">1、请确认出险属实，故意伪造证明材料属于违法行为，需承担法律责任。</p>
	        <p class="t-6 ulev1 tx-l paddinglR  line-height16 margin-t" style="padding-bottom: 0.6rem;  letter-spacing: 0.1rem;">2、我们将以收到您“<span class="t-red">齐全</span>”的索赔资料作为理赔受理时间；资料不全的我们会以短信等方式及时通知您,请您妥善保存好理赔资料原件。</p>
	        <!-- <p class="t-6 ulev1 tx-l paddinglR  line-height16 margin-t" style="padding-bottom: 0.6rem;  letter-spacing: 0.1rem;">3、申请人为出险人时，请选择本人申请，否则，请选择他人申请。</p> -->
		    <a href="/channelsapi/claim_step1/{{$warranty_code}}"><div class="service-btn">确定</div></a>
		</div>
		@include('frontend.channels.insure_alert')
		<script type="text/javascript" src="{{config('view_url.channel_url')}}js/jquery-1.10.2.min.js"></script>
		<script type="text/javascript" src="{{config('view_url.channel_url')}}js/main.js"></script>
		<script type="text/javascript" src="{{config('view_url.channel_url')}}js/information.js"></script>
		<script type="text/javascript" src="{{config('view_url.channel_url')}}js/dialog.js"></script>

	</body>

</html>
