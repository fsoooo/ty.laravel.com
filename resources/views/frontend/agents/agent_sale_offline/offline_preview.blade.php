<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>天眼互联-科技让保险无限可能</title>
	<link rel="stylesheet" href="{{config('view_url.agent_url')}}css/lib/iconfont.css" />
	<link rel="stylesheet" href="{{config('view_url.agent_url')}}css/common_agent.css" />
	<link rel="stylesheet" href="{{config('view_url.agent_url')}}css/index.css" />
	<link rel="stylesheet" href="{{config('view_url.agent_url')}}css/lib/bootstrap-datetimepicker.min.css" />
	<style type="text/css">
		.center{
			display: block;
			margin: 0 auto;
		}
		.form_date{display: inline-table;width: 200px;}
		.section-info input{height: 30px;}
		.text-middle{vertical-align:top;display:inline-block;margin-top: 5px;}
        .img-wrapper li{position: relative;width: 290px;height: 180px;}
        .img-wrapper img{position: absolute;top: 50%;transform: translateY(-50%);}
	</style>
</head>
<body>
<div class="popups-wrapper popups-preview" style="display: block;">
	<div class="popups">
		<div class="popups-title">线下保单预览<a href="/agent_sale/offline"><i class="iconfont icon-close"></i></a></div>
		<div class="popups-content">
			{{--<form id="abc">--}}
			<div class="section section-info">
				<ul>
					<li>
						<span><i class="red">*</i>保单编号：</span>
						<input class="mustFill" type="number" name="warranty_code" maxlength="32" onKeyUp="this.value=this.value.replace(/([^\da-zA-Z]*)/g,'')"/>
					</li>
					<li class="date-picker">
						<div class="text-middle"><i class="red">*</i>保障时间：</div>
						<div class="input-group date form_date form_date_start">
							<input class="form-control mustFill" type="text" name="start_time" value="" placeholder="请选择" readonly><span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
						</div>
						<i class="vtop text-middle">至</i>
						<div class="input-group date form_date form_date_end">
							<input class="form-control" type="text" name="end_time" value="" placeholder="请选择"><span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
						</div>
					</li>
					<li class="date-picker">
						<div class="text-middle">签订时间：</div>
						<div class="input-group date form_date form_date_start">
							<input class="form-control" type="text" name="pay_time" value="" placeholder="请选择"><span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
						</div>
					</li>
				</ul>
			</div>
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<div class="section">
				<h3 class="title">投保人信息</h3>
				<ul>
					<input hidden name="policy_id" value="{{$policy['id']}}"/>
					@if($policy['type'] == 1)
						<li><span class="name"><i class="red">*</i>身份证号码</span>{{$policy['code']}}</li>
						<li><span class="name"><i class="red">*</i>姓名</span>{{$policy['name']}}</li>
					@else
						<li><span class="name"><i class="red">*</i>企业名称</span>{{$policy['company_name']}}</li>
						<li><span class="name"><i class="red">*</i>联系方式</span>{{$policy['phone']}}</li>
					@endif
				</ul>
			</div>
			<div class="section">
				<h3 class="title">被保人信息</h3>
					@foreach($recognize as $k=>$value)
						<input hidden name="recognize_id" value="{{$value['id']}}"/>
					@if($value['type'] == 1)
					<ul>
						<li><span class="name"><i class="red">*</i>被保人是投保人的</span>{{$value['relation']}}</li>
						<li><span class="name"><i class="red">*</i>身份证号码</span>{{$value['code']}}</li>
						<li><span class="name"><i class="red">*</i>姓名</span>{{$value['name']}}</li>
						@if(substr($value['code'],16,1)%2 == 1)
							<li><span class="name"><i class="red">*</i>性别</span>男</li>
						@else
							<li><span class="name"><i class="red">*</i>性别</span>女</li>
						@endif
						<li><span class="name"><i class="red">*</i>出生日期</span>{{substr($value['code'],6,4)}}-{{substr($value['code'],10,2)}}-{{substr($value['code'],12,2)}}</li>
						<li><span class="name"><i class="red">*</i>手机号</span>{{$value['phone']}}</li>
						<li><span class="name"><i class="red">*</i>邮箱地址</span>{{$value['email']}}</li>
						<li><span class="name">其他信息</span>{{$value['other']}}</li>
					</ul>
					@else
						<ul>
							<li><span class="name"><i class="red">*</i>被保人是投保人的</span>{{$value['relation']}}</li>
							<li><span class="name"><i class="red">*</i>企业名称</span>{{$value['company_name']}}</li>
							<li><span class="name"><i class="red">*</i>企业地址</span>{{$value['street_address']}}</li>
							<li><span class="name"><i class="red">*</i>联系人姓名</span>{{$value['name']}}</li>
							<li><span class="name"><i class="red">*</i>联系方式</span>{{$value['phone']}}</li>
							<li><span class="name"><i class="red">*</i>身份证号码</span>{{$value['code']}}</li>
							<li><span class="name"><i class="red">*</i>邮箱地址</span>{{$value['email']}}</li>
							<li><span class="name">营业执照</span><img src="{{$value['license_image']}}" alt="" /></li>
						</ul>
					@endif
				@endforeach
			</div>
			<div class="section">
				<h3 class="title">产品信息</h3>
				<ul>
					<input hidden name="product_id" value="{{$product['id']}}"/>
					<li><span class="name"><i class="red">*</i>产品ID</span>{{$product['ty_product_id']}}</li>
					<li><span class="name"><i class="red">*</i>公司名称</span>{{$product['company_name']}}</li>
					<li><span class="name"><i class="red">*</i>产品类型</span>{{json_decode($product['json'],true)['category']['name']}}</li>
					<li><span class="name"><i class="red">*</i>产品名称</span>{{$product['product_name']}}</li>
					<li><span class="name"><i class="red">*</i>主险</span>{{json_decode($product['personal'],true)['main_insure']}}</li>
					@if($product['rate']['earning'] <= 0)
						<li><span class="name"><i class="red">*</i>佣金比率</span>0%</li>
					@else
						<li><span class="name"><i class="red">*</i>佣金比率</span>{{$product['rate']['earning']}}%</li>
					@endif
					<li><span class="name"><i class="red">*</i>保费</span>{{$product['base_price']/100}}元</li>
				</ul>
			</div>
			<div class="section">
				<h3 class="title">照片信息</h3>
				<ul class="img-wrapper">
					@foreach($image as $value)
					<li style="background-image: url({{asset($value)}});"><input hidden type='text' value="{{$value}}"/></li>
					@endforeach
				</ul>
			</div>
			<div style="text-align: center;">
				<button class="z-btn z-btn-positive" style="width: 160px;margin-right: 20px;"><a href="/agent_sale/offline">修改</a></button>
				<button id="addWarranty" class="z-btn z-btn-default" style="width: 160px;">确认</button>
			</div>
			<input hidden name="warranty" value="{{$warranty}}">
			{{--</form>--}}
		</div>
	</div>
</div>
<script src="{{config('view_url.agent_url')}}js/lib/area.js"></script>
<script src="{{config('view_url.agent_url')}}js/lib/jquery-1.11.3.min.js"></script>
<script src="{{config('view_url.agent_url')}}js/lib/swiper-3.4.2.min.js"></script>
<script src="{{config('view_url.agent_url')}}js/common_agent.js"></script>
<script src="{{config('view_url.agent_url')}}js/lib/jquery.validate.min.js"></script>
<script src="{{config('view_url.agent_url')}}js/check.js"></script>
<script src="{{config('view_url.agent_url')}}js/lib/bootstrap-datetimepicker.min.js"></script>
<script>
    Util.DatePickerRange({ele: ".date-picker"});
    $('#addWarranty').click(function(){
        var warranty = $("input[name='warranty']").val();
        var _token = $("input[name='_token']").val();
        var warranty_code = $("input[name='warranty_code']").val();
        var start_time = $("input[name='start_time']").val();
        var end_time = $("input[name='end_time']").val();
        var pay_time = $("input[name='pay_time']").val();
        $.ajax({
            type: 'post',
            url: "offlineSubmit",
            data: {
                "warranty": warranty,
				'warranty_code':warranty_code,
                'start_time':start_time,
                'end_time':end_time,
				'pay_time':pay_time,
                '_token':_token
            },
            success: function(data) {
                if(data.status != undefined && data.status == false){
                    Mask.alert(data.msg);
				}else {
                    location.href = 'offlineSuccess';
                }
            },
            error: function() {
                Mask.alert("网络请求错误!");
            }
        });
	});
    var preview = {
        init: function(){
            var _this = this;
            $('.section-info input:visible').bind('input propertychange', function() {
                _this.canSubmit();
            });
            Util.DatePickerRange({
                ele: ".date-picker",
                callback: function(){
                    _this.canSubmit();
                }
            });
        },
        canSubmit: function(){
            var inputs = $('.section-info .mustFill')
            inputs.each(function(index){
                if(!$(this).val()){
                    $('#confirm').prop('disabled',true);
                    return false;
                }
                if(index == inputs.length-1){
                    $('#confirm').prop('disabled',false);
                }
            })
        }
    }
    preview.init();
</script>
</body>
</html>
