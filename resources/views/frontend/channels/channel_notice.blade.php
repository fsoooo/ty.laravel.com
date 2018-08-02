<!DOCTYPE HTML>
<html>
<head>
<title>提示</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=5.0" charset="UTF-8">
<link href="{{config('view_url.channel_url')}}css/service.css" rel="stylesheet"/>
<link href="{{config('view_url.channel_url')}}css/claim.css" rel="stylesheet"/>
	<script src="{{config('view_url.channel_url')}}js/baidu.statistics.js"></script>
<style>
	body{overflow: hidden;)}
	.mask-container{background: rgba(0, 0, 0, .4);}
	.mask-container>p{font-size: 1rem;line-height: 1.4;text-align: center;}
	.mask{background-repeat: no-repeat;background-size:100% 100%;}
</style>
</head>
<body>  
    <div class="mask">
    	<div class="mask-container">
    		<p>{{$status}}</p>
			@if(is_array($content))
				@foreach($content as $key=>$value)
				<p>{{$key}}:{{$value}}</p><br/>
				@endforeach
			@else
				<p>{{$content}}</p>
			@endif
    	</div>
    </div>
</body>
</div>
<script src="{{config('view_url.channel_url')}}js/jquery-1.10.2.min.js"></script>
<script>
	function IsPC() {
	    var userAgentInfo = navigator.userAgent;
	    var Agents = ["Android", "iPhone","SymbianOS", "Windows Phone","iPad", "iPod"];
	    var flag = true;
	    for (var v = 0; v < Agents.length; v++) {
	        if (userAgentInfo.indexOf(Agents[v]) > 0) {
	            flag = false;break;
	        }
	    }
	    return flag;
	}
	if(IsPC()){
		$('.mask-container p').css('font-size','20px');
        $('.mask').css('background-image','url(imges/guideImg02.png)');
	}else{
		$('.mask-container p').css('font-size','1rem');
        $('.mask').css('background-image','url(imges/guideImg02.png)');
	}
</script>
</html>
