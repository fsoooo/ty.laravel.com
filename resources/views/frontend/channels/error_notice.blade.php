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
	body{overflow: hidden;}
	.bg{position: relative;margin-top: 10rem;width: 100%;height: 12rem;background: url(imges/505.png) no-repeat;background-size: contain;}
	.bg>.status{position: absolute;top: 1.3rem;left: 5.7rem;font-size: 2rem;}
	.bg>.msg{position: absolute; top: 11rem;left: 3rem;font-size: 1rem;}
</style>
</head>
<body>  
    <div class="header">访问出错
        <img src="{{config('view_url.channel_url')}}imges/arrow-left.png" class="arrow-left2" onclick="back();">
        <img src="{{config('view_url.channel_url')}}imges/home.png" class="home" onclick="close_windows();">
    </div>
    <div class="main">
	    <div class="bg">
	    	<span class="status">{{$status}}</span>
	    	<p class="msg">{{$content}}</p>
	    </div>
   	</div>
</body>
</div>
</html>
