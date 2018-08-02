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
		第三步：上传身份证件
		<img src="{{config('view_url.channel_url')}}imges/arrow-left.png" class="arrow-left2" onclick="back();">
		<img src="{{config('view_url.channel_url')}}imges/home.png" class="home" onclick="close_windows();">
	</div>
	<form action="{{ url('/channelsapi/claim_step4')}}"  method="post" id="do_claim_step3" enctype="multipart/form-data">
		{{ csrf_field() }}
		<input type="hidden" name="warranty_code" value="{{$data['ins_policy_code']}}">
		<input type="hidden" name="bank_info" value="{{$bank_info}}">
	<div class="main">
		<div class="formW formW1">
			<p class="text">上传有效身份证正面照片</p>
		</div>
		<div class="formW formW2">
			<img id="btn-front" src="{{config('view_url.channel_url')}}imges/add.png" alt="" />
			<input id="front" hidden onchange="upLoadImg(this);" accept="image/*" type="file" name="cid_file[cid1]" capture="camera" accept=".gif,.jpg,.jpeg,.png">
			<input id="frontVal" hidden type="text" name="cid1">
		</div>
		<div class="formW formW1">
			<p class="text">上传有效身份证反面照片</p>
		</div>
		<div class="formW formW2">
			<img id="btn-contrary" src="{{config('view_url.channel_url')}}imges/add.png" alt="" />
			<input id="contrary" hidden onchange="upLoadImg(this);" accept="image/*" type="file" name="cid_file[cid2]" capture="camera" accept=".gif,.jpg,.jpeg,.png">
			<input id="contraryVal" hidden type="text" name="cid2">
		</div>
		<div class="formW formW3">
			<div class="tip">
				<img src="{{config('view_url.channel_url')}}imges/tip.png" alt="" />温馨提示:
			</div>
			<p class="text">除身份证外，其他类型证件需要上传客户信息页面和证件有效期页面。</p>
		</div>
	</div>
	</form>
	{{--<button id="next" class="service-btn" disabled>确认上传</button>--}}
	<button class="service-btn" onclick="do_claim_step3()">确认上传</button>
</div>
@include('frontend.channels.insure_alert')
<script type="text/javascript" src="{{config('view_url.channel_url')}}js/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="{{config('view_url.channel_url')}}js/main.js"></script>
<script type="text/javascript" src="{{config('view_url.channel_url')}}js/information.js"></script>
<script type="text/javascript" src="{{config('view_url.channel_url')}}js/dialog.js"></script>
<script type="text/javascript">
    function do_claim_step3() {
        $('#do_claim_step3').submit();
    }
    $('#btn-front').click(function(){
        $('#front').click();
    })
    $('#btn-contrary').click(function(){
        $('#contrary').click();
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
</script>
</body>
</div>
</html>
