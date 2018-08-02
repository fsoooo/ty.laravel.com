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
	.text{
		font-size: 1rem;
	}
	.tip{
		padding: 1rem .4rem;
	}
	.tip span{
		color: #29B2F4;
	}
	.btn-add{
		position: absolute;
		top: 50%;
		transform: translateY(-50%);
	}
	.formW2{
		position: relative;
		height: 5rem;
	}
	.formW3 .title{
		display: inline-block;
		margin-top: .4rem;
		font-size: 1rem;
		font-weight: bold;
	}
	.formW3-top{
		margin-bottom: .8rem;
	}
	.formW3-bottom{
		padding-left: 2rem;
	}
	#defuTimes .formW2{
		text-align: left;
	}
	.img-content{
		margin-top: .4rem;
		float: left;
		overflow: hidden;
	}
	.img-item{
		float: left;
		margin-right: .2rem;
	}
	.img-item img{
		width: 4rem;
		height: 3rem;
	}
</style>
</head>
<body style=" background-color:#fff;">  
<div style="width:100%;height:100%;" id="defuTimes">
	<!--表单填写-->
	<!--表单填写-->
	<form action="{{ url('/channelsapi/do_claim_step4')}}"  method="post" id="do_claim_step4" enctype="multipart/form-data">
		{{ csrf_field() }}
		<input type="hidden" name="warranty_code" value="{{$data['ins_policy_code']}}">
		<input type="hidden" name="bank_info" value="{{$bank_info}}">
		<input type="hidden" name="cid_file" value="{{json_encode($cid_info)}}">
    <div class="header">
    	第四步：上传理赔资料
        <img src="{{config('view_url.channel_url')}}imges/arrow-left.png" class="arrow-left2" onclick="back();">
        <img src="{{config('view_url.channel_url')}}imges/home.png" class="home">
    </div>
    <div class="main">
    	<div class="tip"><span>温馨提示:</span>为保证照片清晰，请在wifi环境上传一下理赔资料</div>
    	<ul class="img-wrapper">
			@if(in_array('事故现场照片',$doc_res))
			<li>
				<div class="formW formW1">
					<p class="text">事故现场照片<span style="font-size: 12px;font-family: 微软雅黑">（电动车，第三者车或人，至少2张）</span></p>
				</div>
				<div class="formW formW2">
					<ul class="img-content"></ul>
					<img class="btn-add" src="{{config('view_url.channel_url')}}imges/add-small.png" alt="" />
					<input  hidden onchange="upLoadImg(this);" accept="image/*" type="file" name="accident_scene[]" capture="camera" accept=".gif,.jpg,.jpeg,.png">
				</div>
			</li>
			@endif
			@if(in_array('理赔申请书',$doc_res)||in_array('理赔申请书(10000元以上需要)',$doc_res))
			<li>
				<div class="formW formW1">
					<p class="text">理赔申请书<span style="font-size: 12px;font-family: 微软雅黑">（一万元以上需要）</span></p>
				</div>
				<div class="formW formW2">
					<ul class="img-content"></ul>
					<img class="btn-add" src="{{config('view_url.channel_url')}}imges/add-small.png" alt="" />
					<input  hidden onchange="upLoadImg(this);" accept="image/*" type="file" name="claim_apply[]" capture="camera" accept=".gif,.jpg,.jpeg,.png">
				</div>
			</li>
				@endif
				@if(in_array('交警事故认定书',$doc_res))
			<li>
				<div class="formW formW1">
					<p class="text">交警事故认定书</p>
				</div>
				<div class="formW formW2">
					<ul class="img-content"></ul>
					<img class="btn-add" src="{{config('view_url.channel_url')}}imges/add-small.png" alt="" />
					<input  hidden onchange="upLoadImg(this);" accept="image/*" type="file" name="traffic_police[]" capture="camera" accept=".gif,.jpg,.jpeg,.png">
				</div>
			</li>
				@endif
				@if(in_array('发票、费用清单或门诊处方',$doc_res))
    		<li>
			    <div class="formW formW1">
			    	<p class="text">发票、费用清单或门诊处方</p>
			    </div>
			    <div class="formW formW2">
			    	<ul class="img-content"></ul>
			    	<img class="btn-add" src="{{config('view_url.channel_url')}}imges/add-small.png" alt="" />
			    	<input  hidden onchange="upLoadImg(this);" accept="image/*" type="file" name="invoice[]" capture="camera" accept=".gif,.jpg,.jpeg,.png">
				</div>
    		</li>
				@endif
				@if(in_array('病诊病历/诊断证明/出院小结',$doc_res))
    		<li>
			    <div class="formW formW1">
			    	<p class="text">病例/诊断证明/出院小结</p>
			    </div>
			    <div class="formW formW2">
			    	<ul class="img-content"></ul>
			    	<img class="btn-add" src="{{config('view_url.channel_url')}}imges/add-small.png" alt="" />
			    	<input  hidden onchange="upLoadImg(this);" accept="image/*" type="file" name="sick_record[]" capture="camera" accept=".gif,.jpg,.jpeg,.png">
			    </div>
    		</li>
				@endif
				@if(in_array('保险理赔授权委托书',$doc_res))
			<li>
				<div class="formW formW1">
					<p class="text">保险理赔授权委托书<span style="font-size: 12px;font-family: 微软雅黑">(下载手填写并上传，适用于，快递员没钱垫付该费用，让第三者找保险公司)</span></p>
				</div>
				<div class="formW formW2">
					<ul class="img-content"></ul>
					<img class="btn-add" src="{{config('view_url.channel_url')}}imges/add-small.png" alt="" />
					<input  hidden onchange="upLoadImg(this);" accept="image/*" type="file" name="delegation[]" capture="camera" accept=".gif,.jpg,.jpeg,.png">
				</div>
			</li>
				@endif
				@if(in_array('分拣开始时间截图',$doc_res))
			<li>
				<div class="formW formW1">
					<p class="text">分拣开始时间截图</p>
				</div>
				<div class="formW formW2">
					<ul class="img-content"></ul>
					<img class="btn-add" src="{{config('view_url.channel_url')}}imges/add-small.png" alt="" />
					<input  hidden onchange="upLoadImg(this);" accept="image/*" type="file" name="start_time[]" capture="camera" accept=".gif,.jpg,.jpeg,.png">
				</div>
			</li>
				@endif
				@if(in_array('韵镖侠APP截图',$doc_res))
			<li>
				<div class="formW formW1">
					<p class="text">韵镖侠APP截图<span style="font-size: 12px;font-family: 微软雅黑">(派件明细或客户签收截图等)</span></p>
				</div>
				<div class="formW formW2">
					<ul class="img-content"></ul>
					<img class="btn-add" src="{{config('view_url.channel_url')}}imges/add-small.png" alt="" />
					<input  hidden onchange="upLoadImg(this);" accept="image/*" type="file" name="app_screenshot[]" capture="camera" accept=".gif,.jpg,.jpeg,.png">
				</div>
			</li>
				@endif
				@if(in_array('其他',$doc_res))
    		<li>
			    <div class="formW formW3">
			    	<div class="formW3-top">
				    	<div class="checkbox_box2">
			                <span></span>
			            </div>
			           	<span class="title">可选资料</span>
			    	</div>
		            <p class="formW3-bottom">因意外导致的保险事故，并经由公安机关等有权机构处理的需要提供意外事故证明。</p>
			    </div>
				<div class="formW formW1">
					<p class="text">赔偿协议书（若有第三方人伤和财产损失）</p>
				</div>
				<div class="formW formW2">
					<ul class="img-content"></ul>
					<img class="btn-add" src="{{config('view_url.channel_url')}}imges/add-small.png" alt="" />
					<input  hidden onchange="upLoadImg(this);" accept="image/*" type="file" name="compensation_agreement[]" capture="camera" accept=".gif,.jpg,.jpeg,.png">
				</div>
				<div class="formW formW1">
					<p class="text">分拣结束时间截图</p>
				</div>
				<div class="formW formW2">
					<ul class="img-content"></ul>
					<img class="btn-add" src="{{config('view_url.channel_url')}}imges/add-small.png" alt="" />
					<input  hidden onchange="upLoadImg(this);" accept="image/*" type="file" name="end_time[]" capture="camera" accept=".gif,.jpg,.jpeg,.png">
				</div>
    		</li>
				@endif
    	</ul>
   	</div>
	</form>
    <button id="next" class="service-btn" style="margin: 2rem auto;" onclick="do_claim_step4()">确认提交</button>
</div>
@include('frontend.channels.insure_alert')
<script type="text/javascript" src="{{config('view_url.channel_url')}}js/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="{{config('view_url.channel_url')}}js/main.js"></script>
<script type="text/javascript" src="{{config('view_url.channel_url')}}js/information.js"></script>
<script type="text/javascript" src="{{config('view_url.channel_url')}}js/dialog.js"></script>
<script type="text/javascript">
    function do_claim_step4() {
        $('#do_claim_step4').submit();
    }
   		$('.formW2 .btn-add').off().click(function(){
   			$(this).next().click();
   		});
    // 上传照片
	var upLoadImg = function(e){
		var _this = $(e).parent();
		var $c = _this.find('input[type=file]')[0];
		var file = $c.files[0],reader = new FileReader();
	    reader.readAsDataURL(file);
	    reader.onload = function(e){
            var name = _this.find('input:last-child').attr('name');
           	name = name.substring(0,name.length-2);
            var index = _this.find('.img-item').length;
            name = name +'_info['+ index +']';
            console.log(name);
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
            }
//            console.log( img.src);
	    	var html = '<li class="img-item">\
					    	<img src="'+ img.src +'" alt="">\
							<input hidden type="text" name="'+name+'" value="'+ img.src +'">\
					    </li>';
	    	console.log(html);
	    	_this.find('.img-content').append(html);
	    	if(_this.find('.img-item').length>=4){
	    		_this.find('.btn-add').hide();
	    	}
		};
	};
</script>
</body>
</div>
</html>
