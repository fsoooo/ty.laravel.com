<!DOCTYPE HTML>
<html>
<head>
	<title>补充资料</title>
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
		补充资料
		<img src="{{config('view_url.channel_url')}}imges/arrow-left.png" class="arrow-left2" onclick="back();">
		<img src="{{config('view_url.channel_url')}}imges/home.png" class="home" onclick="close_windows();">
	</div>
	<form action="{{ url('/channelsapi/do_claim_add_material')}}"  method="post" id="do_claim_add_material" enctype="multipart/form-data">
		{{ csrf_field() }}
		<input type="hidden" name="warranty_code" value="{{$warranty_code}}">
	<div class="main">
		<div class="main-content">
		<div class="formW formW1">
			<p class="text">上传有效的资料（1）</p>
		</div>
		<div class="formW formW2">
			<img id="btn-front" src="{{config('view_url.channel_url')}}imges/add.png" alt="" />
			<input id="front" hidden onchange="upLoadImg(this);" name="add_material_info[]"  accept="image/*" type="file" capture="camera" accept=".gif,.jpg,.jpeg,.png">
			<input id="frontVal" hidden type="text" name="add_material_file[]"></input>
		</div>
		<div class="formW formW1">
			<p class="text">上传有效的资料（2）</p>
		</div>
		<div class="formW formW2">
			<img id="btn-contrary" src="{{config('view_url.channel_url')}}imges/add.png" alt="" />
			<input id="front2" hidden onchange="upLoadImg(this);" accept="image/*" name="add_material_info[]" type="file" capture="camera" accept=".gif,.jpg,.jpeg,.png">
			<input id="contraryVal" hidden type="text" name="add_material_file[]"></input>
		</div>
		</div>
		<div id="add" class="service-btn" style="width: 60%;margin: 0 auto .2rem;">添加</div>
		<div class="formW formW3">
			<div class="tip">
				<img src="{{config('view_url.channel_url')}}imges/tip.png" alt="" />温馨提示:
			</div>
			<p class="text">除身份证外，其他类型证件需要上传客户信息页面和证件有效期页面。</p>
		</div>
	</div>
	<button id="next" class="service-btn" disabled>确认上传</button>
	</form>
</div>

{{--<input type="file" value="image" id="img_input" />--}}
{{--<textarea id="result" style="width:400px;height:150px;"></textarea>--}}
{{--<p id="img_area"></p>--}}

@include('frontend.channels.insure_alert')
<script type="text/javascript" src="{{config('view_url.channel_url')}}js/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="{{config('view_url.channel_url')}}js/main.js"></script>
<script type="text/javascript" src="{{config('view_url.channel_url')}}js/information.js"></script>
<script type="text/javascript" src="{{config('view_url.channel_url')}}js/dialog.js"></script>
<script type="text/javascript">
//    $('.formW img').click(function(){
//        $('.formW input').eq(0).click();
//    });

//
//window.onload = function() {
//    var input = document.getElementById("img_input");
//    var result = document.getElementById("result");
//    var img_area = document.getElementById("img_area");
//    if (typeof(FileReader) === 'undefined') {
//        result.innerHTML = "FileReader is not supported...";
//        input.setAttribute('disabled', 'disabled');
//    } else {
//        input.addEventListener('change', readFile, false);
//    }
//};
//function readFile() {
//    var file = this.files[0];
//    if (!/image\/\w+/.test(file.type)) {
//        alert("image only please.");
//        return false;
//    }
//    var reader = new FileReader();
//    reader.readAsDataURL(file);
//    reader.onload = function(e) {
//        var img = new Image,
//            width = 640, //image resize
//            quality = 0.5, //image quality
//            canvas = document.createElement("canvas"),
//            drawer = canvas.getContext("2d");
//        img.src = this.result;
//        img.onload = function() {
//            canvas.width = width;
//            canvas.height = width * (img.height / img.width);
//            drawer.drawImage(img, 0, 0, canvas.width, canvas.height);
//            img.src = canvas.toDataURL("image/jpeg", quality);
//            console.log(img.src);
//            result.innerHTML = '<img src="' + img.src + '" alt=""/>';
//            img_area.innerHTML = '<div class="sitetip">preview：</div><img src="' + img.src + '" alt=""/>';
//        }
//    }
//}

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
    $('body').on('click','.formW2 img',function(){
        $(this).parent().find('input').eq(0).click();
    });
    var index  = 2;
    $('#add').click(function(){
        var html = '<div class="formW formW1">\
				    	<p class="text">上传有效的资料('+ (++index) +')</p>\
				    </div>\
				    <div class="formW formW2">\
				    	<img src="/channel_info/imges/add.png" alt="" />\
				    	<input  hidden onchange="upLoadImg(this);" accept="image/*" name="add_material_info[]" type="file" capture="camera" accept=".gif,.jpg,.jpeg,.png">\
						<input hidden type="text" name="add_material_file[]"></input>\
				    </div>';
        $('.main-content').append(html)
    });

</script>
</body>
</div>
</html>
