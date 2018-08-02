<!DOCTYPE HTML>
<html>
<head>
<title>自助理赔申请</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=5.0" charset="UTF-8">
<link href="{{config('view_url.channel_url')}}css/service.css" rel="stylesheet"/>
<link href="{{config('view_url.channel_url')}}css/mobile-select-area.css" rel="stylesheet"/>
<link href="{{config('view_url.channel_url')}}css/claim.css" rel="stylesheet"/>
	<script src="{{config('view_url.channel_url')}}js/baidu.statistics.js"></script>
</head>
<body style=" background-color:#f5f5f5;">
	<div class="header">
    	自助理赔申请
        <img src="{{config('view_url.channel_url')}}imges/arrow-left.png" class="arrow-left2" onclick="back();">
        <img src="{{config('view_url.channel_url')}}imges/home.png" class="home" onclick="close_windows();"	>
    </div>
	<div id='mySwipe' class='main swipe'>
	    <div class='swipe-wrap' style="display:-webkit-box; display: -moz-box; display: -ms-box;display: -o-box;display: box;">
	        <div style="float:left;"><img src="{{config('view_url.channel_url')}}imges/serviceIndexLunbo01.png" width="100%" alt=""></div>
	        <div style="float:left;"><img src="{{config('view_url.channel_url')}}imges/serviceIndexLunbo02.png" width="100%" alt=""></div>
	    </div>
	    <ul class='iosSliderButtons'>
	        <li class='ios_button selected'></li>
	        <li class='ios_button'></li>
	    </ul>
	</div>
	<!--新增内容start-->
	<div class="tips-wrapper"><i class="iconfont icon-cuowu"></i>请在事故发生72小时内报案，逾期不可申请理赔</div>
	<!--新增内容end-->
	<div id="select-date" class="list margin-t" >
		<div class="listL">
	    	<img src="{{config('view_url.channel_url')}}imges/serviceIndex02.png" class="listImg">
	        <div class="listText">
	        	<P class="t-ora ulev2 fw">我要理赔</P>
	            <P class="t-6 ulev-1 margin-t">人身保险  财产保险  车险</P>
	        </div>
	    </div>
	    <div class="listR"><img src="{{config('view_url.channel_url')}}imges/serviceIndex08.png" class="serviceIndex08"></div>
	</div>
	<div class="list margin-t" onclick="claimType(2);">
		<div class="listL">
	    	<img src="{{config('view_url.channel_url')}}imges/serviceIndex04.png" class="listImg">
	        <div class="listText">
	        	<P class="t-ora ulev2 fw">理赔记录查询</P>
	            <P class="t-6 ulev-1 margin-t">进度查询  历史查询</P>
	        </div>
	    </div>
	    <div class="listR"><img src="{{config('view_url.channel_url')}}imges/serviceIndex08.png" class="serviceIndex08"></div>
	</div>
	<div class="list margin-t" onclick="jumpGuide();">
	        <div class="listL">
	            <img src="{{config('view_url.channel_url')}}imges/serviceIndex03.png" class="listImg">
	            <div class="listText">
	                <P class="t-ora ulev2 fw">理赔服务指南</P>
	                <P class="t-6 ulev-1 margin-t">应备材料  流程指引</P>
	            </div>
	        </div>
	    <div class="listR"><img src="{{config('view_url.channel_url')}}imges/serviceIndex08.png" class="serviceIndex08"></div>
	</div>
	
	{{--<div class="indexBox">--}}
	        {{--<div class="listBox" onclick="jumpPage(1);">--}}
	            {{--<img src="{{config('view_url.channel_url')}}imges/serviceIndex05.png" class="serviceIndex05">--}}
	            {{--<p class="ulev-1 t-ora margin-t">定点医院查询</p>--}}
	        {{--</div>--}}
	        {{--<div class="listBox margin-L2" onclick="jumpPage(2);">--}}
	            {{--<img src="{{config('view_url.channel_url')}}imges/serviceIndex06.png" class="serviceIndex05">--}}
	            {{--<p class="ulev-1 t-ora margin-t">理赔电话查询</p>--}}
	        {{--</div>--}}
	        {{--<div class="listBox margin-L2" onclick="jumpPage(3);">--}}
	            {{--<img src="{{config('view_url.channel_url')}}imges/serviceIndex07.png" class="serviceIndex05">--}}
	            {{--<p class="ulev-1 t-ora margin-t">联系我们</p>--}}
	        {{--</div>--}}
	{{--</div>--}}
	
	
	<div class="coverBg2" id="claim-alertwin" style="display: none;">
		<div class="bomb-box">
			@if(count($res)>0)
				<div class="bomb-txt">
					<h4>请选择出险日期</h4>
					<div class="form">
							<div class="inputW" style="width: 100%;">
								<select id="date" name="insure_happen_date" class="ht">
									@foreach($res as $value)
										<option value="{{$value['warranty_code']}}">{{date('Y-m-d',strtotime($value['start_time']))}}</option>
									@endforeach
								</select>
								<img src="{{config('view_url.channel_url')}}imges/arrow-down.png" class="down">
							</div>
					</div>
					<div class="tips" style="font-size: 12px">
							请在事故发生72小时内发起理赔，逾期不可申请理赔。请确保，事故发生在72小时内。
					</div>
				</div>
				<div class="btnW">
					<div class="btnC" id="insureWin">确定</div>
				</div>
			@elseif(count($res)==0)
				<div class="bomb-txt">
					<h4>温馨提示</h4>
					<div class="tips">
						请在事故发生72小时内发起理赔，逾期不可申请理赔。<span style="color: #FC6F6F;">您没有在保保单，请确保您已经投保。</span>
					</div>
				</div>
				<div class="btnW">
					<div class="btnC" id="insureBack">确定</div>
				</div>
			@endif
		</div>
	</div>
	@include('frontend.channels.insure_alert')
	<script type="text/javascript" src="{{config('view_url.channel_url')}}js/jquery-1.10.2.min.js"></script>
	<script type="text/javascript" src="{{config('view_url.channel_url')}}js/swipe.js"></script>
	<script type="text/javascript" src="{{config('view_url.channel_url')}}js/main.js"></script>
	<script type="text/javascript" src="{{config('view_url.channel_url')}}js/dialog.js"></script>
	<script  type="text/javascript">
		var person_code = "{{$person_code??'1'}}";
		console.log(person_code);
		$(function() {
			scrollindex(); //首页轮播图
		});
		$('#insureWin').click(function(){
			var warranty_code = $('#date').val();
			location.href = '/channelsapi/claim_notice/'+warranty_code;
		});
        $('#insureBack').click(function(){
            $('#claim-alertwin').hide();
        });
		$('#select-date').click(function(){
			$('#claim-alertwin').show();
		})
		function scrollindex() {
			var elem = document.getElementById('mySwipe');
			window.mySwipe = Swipe(elem, {
				auto: 4000,
				speed: 1000,
				continuous: true,
				disableScroll: false,
				stopPropagation: false,
				callback: function(index, element) {
					index = index % 2;
					$('ul li').eq(index).addClass('selected').siblings().removeClass('selected')
				}
			});
		}
		//跳转页面
		function claimType(num){
			if(num == 2) {
				location.href="/channelsapi/claim_records/"+person_code;
			} else if(num == 3) {

			}
		}
		
		function jumpPage(num) {
			if(num == 1) {

			} else if(num == 2) {
//
			} else if(num == 3) {
//
			}
		}
		
		function jumpGuide() {
			location.href = "/channelsapi/claim_apply_guide";
		}
	</script>
</body>
</html>
