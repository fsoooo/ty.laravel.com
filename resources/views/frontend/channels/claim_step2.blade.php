<!DOCTYPE HTML>
<html>
<head>
	<title>我要理赔</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=5.0" charset="UTF-8">
	<link href="{{config('view_url.channel_url')}}css/service.css" rel="stylesheet"/>
	<link href="{{config('view_url.channel_url')}}css/claim.css" rel="stylesheet"/>
	<script src="{{config('view_url.channel_url')}}js/baidu.statistics.js"></script>
</head>
<body style=" background-color:#fff;">
<div style="width:100%;height:100%;" id="defuTimes">
	<!--表单填写-->
	<div class="header">
		第二步：填写收款人账户信息
		<img src="{{config('view_url.channel_url')}}imges/arrow-left.png" class="arrow-left2" onclick="back();">
		<img src="{{config('view_url.channel_url')}}imges/home.png" class="home"  onclick="close_windows();">
	</div>
	<div class="main">
		<div class="formW formW1">
			<img src="{{config('view_url.channel_url')}}imges/bank.png" alt="" />
			<p class="text">通过储蓄卡转账领取理赔款</p>
		</div>
		<form action="{{ url('/channelsapi/claim_step3')}}"  method="post" id="do_claim_step2" enctype="multipart/form-data">
			{{ csrf_field() }}
			<input type="hidden" name="warranty_code" value="{{$warranty_code}}">
		<div class="formW formW2">
			<img id="btn-upload" src="{{config('view_url.channel_url')}}imges/add.png" alt="" />
			<p class="tip">上传储蓄卡</p>
			<input id="uploadImg" hidden="hidden" onchange="upLoadImg(this);" accept="image/*" type="file" name="bank_info_file" capture="camera" accept=".gif,.jpg,.jpeg,.png">
			<input hidden type="text" name="bank_info">
		</div>
		</form>
		<div class="formW formW3">
			<div class="tip">
				<img src="{{config('view_url.channel_url')}}imges/tip.png" alt="" />温馨提示:
			</div>
			<p class="text"><b>建议填写：持卡人姓名、银行开户地址、银行名称的同时再上传银行卡照片。</b>请务必确认账户为出险人本人账户，如果显示为非出险人账户，请您修改。出险人无法提供账户的，请填写受益人账户（未成年为其法定监护人）</p>
		</div>
	</div>
	{{--<button id="next" class="service-btn" disabled>下一步:上传身份证件</button>--}}
	<button  class="service-btn" onclick="do_claim_step2()">下一步:上传身份证件</button>
</div>
@include('frontend.channels.insure_alert')
<script type="text/javascript" src="{{config('view_url.channel_url')}}js/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="{{config('view_url.channel_url')}}js/main.js"></script>
<script type="text/javascript" src="{{config('view_url.channel_url')}}js/information.js"></script>
<script type="text/javascript" src="{{config('view_url.channel_url')}}js/dialog.js"></script>
<script type="text/javascript">
	function do_claim_step2() {
		$('#do_claim_step2').submit();
    }
    $('#btn-upload').click(function(){
        $('#uploadImg').click();
    });
    // 上传照片
    var upLoadImg = function(e){
        var _this = $(e).parent();
        var $c = _this.find('input[type=file]')[0];
        var file = $c.files[0],reader = new FileReader();
        reader.readAsDataURL(file);
        reader.onload = function(e) {
            var img = new Image,
                width = 1500, //image resize
                quality = 0.8, //image quality
                canvas = document.createElement("canvas"),
                drawer = canvas.getContext("2d");
            img.src = this.result;
            img.onload = function() {
                canvas.width = width;
                canvas.height = width * (img.height / img.width);
                drawer.drawImage(img, 0, 0, canvas.width, canvas.height);
                img.src = canvas.toDataURL("image/jpeg", quality);
                console.log(img.src);
                _this.find('img').attr('src',img.src).css({'width':'11rem','height':'7rem'});
                var $targetEle = _this.find('input:hidden').eq(1);
                $targetEle.val(img.src);
                console.log($targetEle.val());
                if($('#frontVal').val() && $('#contraryVal').val()){
                    $('#next').prop('disabled',false);
                }
            }
        }
    };
    $('#next').click(function(){
        location.href = '/channelsapi/claim_step3/'+"{{$warranty_code}}";
    })
</script>
</body>
</div>
</html>
