<!DOCTYPE HTML>
<html>
	<head>
		<title>理赔服务指南</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=5.0" charset="UTF-8">
		<link href="{{config('view_url.channel_url')}}css/service.css" rel="stylesheet"/>
		<link href="{{config('view_url.channel_url')}}css/claim.css" rel="stylesheet"/>
		<script src="{{config('view_url.channel_url')}}js/baidu.statistics.js"></script>
	</head>
<body style="background-color:#f5f5f5;">
	<div class="header">
		理赔服务指南
	    <img src="{{config('view_url.channel_url')}}imges/arrow-left.png" class="arrow-left2" onclick="history.back();">
	    <img src="{{config('view_url.channel_url')}}imges/home.png" class="home" onclick="close_windows();">
	</div>
	<div style="margin-top: 4.6rem;">
		<a id="claim_apply_range" href="/channelsapi/claim_apply_range">
			<div class="search2 marginAuto">
				<div class="line2"></div>
				<div class="fl w90">
			    	<p class="ulev1 t-3 line-height4 padding-l margin-t">理赔申请适用范围</p>
			    </div>
			    <img src="{{config('view_url.channel_url')}}imges/arrow-right.png" class="arrow-right">
			</div>
		</a>
		<a id="claim_apply_info" href="/channelsapi/claim_apply_info">
			<div class="search2 margin-t" >
				<div class="line2"></div>
				<div class="fl w90">
			    	<p class="ulev1 t-3 line-height4 padding-l margin-t">理赔申请应备材料</p>
			    </div>
			    <img src="{{config('view_url.channel_url')}}imges/arrow-right.png" class="arrow-right">
			</div>
		</a>
		<a id="claim_apply_guide" href="/channelsapi/claim_apply_guide_index">
			<div class="search2 margin-t">
				<div class="line2"></div>
				<div class="fl w90">
			    	<p class="ulev1 t-3 line-height4 padding-l margin-t">理赔申请操作指引</p>
			    </div>
			    <img src="{{config('view_url.channel_url')}}imges/arrow-right.png" class="arrow-right">
			</div>
		</a>
	</div>
</body>
<script src="{{config('view_url.channel_url')}}js/jquery-1.10.2.min.js" type="text/javascript"></script>
<script src="{{config('view_url.channel_url')}}js/main.js" type="text/javascript"></script>
<script>
    $('#claim_apply_range').on('tap',function () {
        location.href="/channelsapi/claim_apply_range";
    });
    $('#claim_apply_info').on('tap',function(){
        location.href="/channelsapi/claim_apply_info";
    });
    $('#claim_apply_guide').on('tap',function(){
        location.href="/channelsapi/claim_apply_guide";
    });
</script>
</html>
