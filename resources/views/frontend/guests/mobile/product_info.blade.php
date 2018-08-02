<!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8">
		<title>天眼互联-科技让保险无限可能</title>
		<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
		<link rel="stylesheet" href="{{config('view_url.view_url')}}mobile/css/lib/mui.min.css">
		<link rel="stylesheet" href="{{config('view_url.view_url')}}mobile/css/lib/mui.picker.all.css">
		<link rel="stylesheet" href="{{config('view_url.view_url')}}mobile/css/lib/iconfont.css" />
		<link rel="stylesheet" href="{{config('view_url.view_url')}}mobile/css/common.css" />
		<link rel="stylesheet" href="{{config('view_url.view_url')}}mobile/css/details.css" />
	</head>
	<style>
	</style>
	<body>
		<div class="main">
			<header class="mui-bar mui-bar-nav">
				<a class="mui-icon mui-icon-back mui-pull-left" href="/"></a>
				<h1 class="mui-title">{{$product_info->product_name}}</h1>
			</header>
			<form class="introduce-parameter" action="{{ url('/ins/prepare_order') }}" id="form" method="post">
				{{ csrf_field() }}
				<div class="mui-scroll-wrapper main-scroll-wrapper">
					<div class="mui-scroll">
						<div class="banner">
							<img src="{{asset($product_info->cover)}}" alt="">
						</div>
						<div class="tag-wrapper">
							@foreach($product_info->product_label as $value)
								<span class="tag-item"><i class="iconfont icon-chenggong1"></i>{{$value['name']}}</span>
							@endforeach
						</div>
						<div class="division"></div>
						<div class="content-wrapper">
							<input type="hidden" name="private_p_code" id="private_p_code" value="{{$ins->private_p_code}}">
							<input type="hidden" name="ty_product_id" value="{{$product_info->ty_product_id}}">
							<input type="hidden" name="ditch_id" value="{{ isset($_GET['ditch_id']) ? $_GET['ditch_id'] : 0}}" >
							<input type="hidden" name="agent_id" value="{{ isset($_GET['agent_id']) ? $_GET['agent_id'] : 0}}" >
							<input type="hidden" name="plan_id" value="{{ isset($_GET['plan_id']) ? $_GET['plan_id'] : 0}}" >
							<input type="hidden" name="ty_product_id" value="{{$ty_product_id}}">
							<input type="hidden" name="health_verify" value="{{ $health_verify }}" >
							<div id="hidden"></div>
								<div id="option">
									@php
										echo $option_html;
									@endphp
								</div>


							@if(!empty($duty))
								<ul class="content-list">
									@if(!empty($clauses))
										@foreach($clauses as $value)
											@if($value['type']=='main')
												<li class="clause">
													<a href="{{env('TY_API_PRODUCT_SERVICE_URL')}}/{{substr($value['file_url'],0,1)=="/"?substr($value['file_url'],1):$value['file_url']}}" target="_blank"><i class="icon icon-zhu"></i>{{$value['name']}}</a></li>
											@else
												<li class="clause"><a href="{{env('TY_API_PRODUCT_SERVICE_URL')}}/{{substr($value['file_url'],0,1)=="/"?substr($value['file_url'],1):$value['file_url']}}" target="_blank"><i class="icon icon-fu"></i>个人人身意外伤害医疗保险条款</a></li>
											@endif
										@endforeach
									@endif
								</ul>
								<div id="item">
									<ul class="content-list">
									@php echo $item_html;@endphp

									</ul>
								</div>

							@endif

								<button class="btn-open" type="button">展开<i class="iconfont icon-xiala"></i></button>

						</div>
						<div class="division"></div>

					</div>
				</div>
				<input type="hidden" id="protect_item" name="protect_item" value="{{json_encode($protect_items, JSON_UNESCAPED_UNICODE)}}">
			</form>
				<div class="buttonsbox">
					<button class="btn btn-pirce" id="show_price"  type="button">￥{{$price  / 100 }} </button>
					<button type="button" class="btn btn-insured" id="do_form">立即投保</button>
				</div>
			</div>
		</div>
		<script src="{{config('view_url.view_url')}}mobile/js/lib/jquery-1.11.3.min.js"></script>
		<script src="{{config('view_url.view_url')}}mobile/js/lib/mui.min.js"></script>
		<script src="{{config('view_url.view_url')}}mobile/js/lib/mui.picker.all.js"></script>
		<script src="{{config('view_url.view_url')}}mobile/js/common.js"></script>
		<script src="{{config('view_url.view_url')}}mobile/js/details.js"></script>
		<script>
			function doAddForm() {
                form.submit();
            }
            $('#do_form').on('click',function () {
                var re = /^[0-9]+.?[0-9]*$/; //判断字符串是否为数字 //判断正整数 /^[1-9]+[0-9]*]*$/
                var price  = $('#price').val();
                console.log(price);
                if(!re.test(price)){
                    Mask.alert('投保年龄不符，请注意出生日期');
                }else{
                    $('#form').submit();
                }
            });
		</script>
	</body>

</html>