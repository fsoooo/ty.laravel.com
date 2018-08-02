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
	.formW2{
		position: relative;
	}
	.formW2 label img{
		width: 80%;
	}
	.formW2.active{
		border: 1px solid #F0AD4E;
	}
	.btn-colse{
		display: none;
		position: absolute;
		top: 0;
		right: 0;
		width: 2rem;
		height: 2rem;
		background: url(/channel_info/imges/home.png) no-repeat;
		background-size: 100% 100%;
	}
</style>
</head>
<body style=" background-color:#fff;">  
<div style="width:100%;height:100%;" id="defuTimes">
	<!--表单填写-->
    <div class="header">
    	核对理赔资料
		<img src="{{config('view_url.channel_url')}}imges/arrow-left.png" class="arrow-left2" onclick="back();">
		<img src="{{config('view_url.channel_url')}}imges/home.png" class="home" onclick="close_windows();">
    </div>
    <div class="main">

	    <div class="formW formW1">
	    	<p class="text">身份证正面</p>
	    </div>
	    <div class="formW formW2">
	    	<label>
	    		<img id="btn-front"  src="/{{str_replace('"','',str_replace('\/','/',json_decode($cid_res,true)['cid1']))}}" alt="" />
				<input type="radio" name="img" value="" />	    	
	    	</label>
	    	{{--<i class="btn-colse"></i>--}}
	    </div>
		<div class="formW formW1">
			<p class="text">身份证反面</p>
		</div>
	    <div class="formW formW2">
	    	<label>
		    	<img id="btn-front"  src="/{{str_replace('"','',str_replace('\/','/',json_decode($cid_res,true)['cid2']))}}" alt="" />
				<input type="radio" name="img" value="" />	    	
	    	</label>
	    	{{--<i class="btn-colse"></i>--}}
	    </div>
		<div class="formW formW1">
			<p class="text">收款人账户</p>
		</div>
		<div class="formW formW2">
			<label>
				<img id="btn-front" src="/{{str_replace('"','',str_replace('\/','/',$bank_res))}}" alt="" />
				<input type="radio" name="img" value="" />
			</label>
			{{--<i class="btn-colse"></i>--}}
		</div>
		@foreach($claim_materials_path as $key=>$value)
			<div class="formW formW1">
				@if($key=="claim_apply")
				<p class="text">理赔申请书</p>
				@elseif($key=="start_time")
					<p class="text">分拣开始时间</p>
				@elseif($key=="end_time")
					<p class="text">分拣结束时间</p>
				@elseif($key=="compensation_agreement")
					<p class="text">赔偿协议</p>
				@elseif($key=="sick_record")
					<p class="text">病例说明</p>
				@elseif($key=="invoice")
					<p class="text">发票信息</p>
				@elseif($key=="traffic_police")
					<p class="text">交警事故认定书</p>
				@elseif($key=="accident_scene")
					<p class="text">事故现场照片</p>
				@elseif($key=="delegation")
					<p class="text">保险理赔授权委托书</p>
				@elseif($key=="app_screenshot")
					<p class="text">APP截图</p>
				@elseif($key=="other")
					<p class="text">其他</p>
				@endif
			</div>
			@if(is_array($value))
				@foreach($value as $k=>$v)
					<div class="formW formW2">
						<label>
							<img id="btn-front" src="/{{str_replace('"','',str_replace('\/','/',$v))}}" alt="" />
							<input type="radio" name="img" value="" />
						</label>
						<i class="btn-colse" onclick='claimDel("{{$key.'-'.$k}}")'></i>
					</div>
				@endforeach
			@else
				<div class="formW formW2">
					<label>
						<img id="btn-front" src="/{{str_replace('"','',str_replace('\/','/',$value))}}" alt="" />
						<input type="radio" name="img" value="" />
					</label>
					<i class="btn-colse" onclick='claimDel("{{$key.'-'.$k}}")'></i>
				</div>
			@endif
		@endforeach
   	</div>
	<form action="{{ url('/channelsapi/do_claim_submit')}}"  method="post" id="do_claim_submit">
		{{ csrf_field() }}
		<input type="hidden" name="warranty_code" value="{{$warranty_code}}">
    	<button  class="service-btn" style="margin-top: 2rem;margin-bottom: 2rem;">确认提交</button>
	</form>
</div>
@include('frontend.channels.insure_alert')
<script type="text/javascript" src="{{config('view_url.channel_url')}}js/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="{{config('view_url.channel_url')}}js/main.js"></script>
<script type="text/javascript" src="{{config('view_url.channel_url')}}js/information.js"></script>
<script type="text/javascript" src="{{config('view_url.channel_url')}}js/dialog.js"></script>
<script type="text/javascript">
    $('.formW2 img').click(function(){
    	var parent = $(this).parents('.formW2');
   		parent.addClass('active').find('.btn-colse').show();
   		parent.siblings().removeClass('active').find('.btn-colse').hide();
   });
    var code = "{{$warranty_code}}";
    function claimDel(key) {
        $.ajax( {
            type : "get",
            url : "/channelsapi/do_claim_del",
            dataType : 'json',
            data : {code:code,key:key},
            success:function(msg){
                if(msg.status == 200){
                  window.location.href=location;
                }
            }
        });
    }
</script>
</body>
</div>
</html>
