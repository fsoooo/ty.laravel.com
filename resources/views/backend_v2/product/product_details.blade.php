@extends('backend_v2.layout.base')
@section('title')@parent产品管理 @stop
@section('head-more')
	<link rel="stylesheet" href="{{asset('r_backend/v2/css/product.css')}}" />
@stop
@section('top_menu')
	@include('backend_v2.product.product_top')
@stop
@section('main')
<div class="main-wrapper">
	<div class="row">
		<ol class="breadcrumb col-lg-12">
			<li><a href="/backend/product/product_list">产品管理</a><i class="iconfont icon-gengduo"></i></li>
			<li><a href="/backend/product/product_stay_on">待售产品</a><i class="iconfont icon-gengduo"></i></li>
			<li class="active">{{$product_res['res'][0]['name']}}</li>
		</ol>
	</div>
	<div class="row">
		{{--<div class="section">--}}
			{{--<div class="col-sm-4 col-xs-6">--}}
				{{--<a href="agent2_info.html" class="section-item active">产品详情 </a>--}}
			{{--</div>--}}
			{{--<div class="col-sm-4 col-xs-6">--}}
				{{--<a href="client2_record.html" class="section-item">销售统计</a>--}}
			{{--</div>--}}
			{{--<div class="col-sm-4 col-xs-6">--}}
				{{--<a href="product_comment.html.html" class="section-item">评论</a>--}}
			{{--</div>--}}
		{{--</div>--}}
	</div>

	<div class="row">
		<div class="col-md-7 policy">
			<div class="policy-content">
				<div class="policy-wrapper scroll-pane">

					<div class="product-avatar">
						<div class="product-img">
							<img src="{{asset('/r_backend/v2/img/avatar.png')}}"/>
							<input hidden onchange="upLoadImg(this);" accept="image/*" type="file">
							<input hidden type="text">
						</div>
						{{--<button id="up-cover" class="btn btn-default fr">上传封面</button>--}}
					</div>
					<div class="policy-info">
						<h3 class="title">{{$product_res['res'][0]['name']}}
							{{--<span class="color-primary">(未上架)</span>--}}
						</h3>
						{{--<button class="btn btn-warning" data-toggle="modal" data-target="#addTags">添加标签</button>--}}
					</div>
					<div class="policy-list">
						<p><span class="name">创建时间</span><i>:</i>{{$product_res['res'][0]['created_at']}}</p>
						<p><span class="name">上架时间</span><i>:</i>-</p>
						<p><span class="name">公司名称</span><i>:</i>{{$product_res['res'][0]['company']['display_name']}}</p>
						<p><span class="name">保险险种</span><i>:</i>{{$product_res['res'][0]['category']['name']}}</p>
						<div><span class="name vtop">条款</span><i class="vtop">:</i>
							<ul class="duty-list">
								@foreach($product_res['clause'] as $value)
								<li><a href="{{env('TY_API_PRODUCT_SERVICE_URL').'/'.$value['file_url']}}" target="_blank">{{$value['name']}}</a></li>
								@endforeach
							</ul>
						</div>
						@php $json =$product_res['res'][0]; @endphp
						<div><span class="name vtop">责任保额</span><i class="vtop">:</i>
							@php
							$i = 1;
							@endphp
							<ul class="duty-list">
								@foreach($json['clauses'] as $ck => $cv)
									@foreach($cv['duties'] as $dk => $dv)
								<li><span class="duty-name">{{ $dv['name'] }} </span>{{ preg_match('/^\d{5,}$/', $dv['pivot']['coverage_jc']) ?  $dv['pivot']['coverage_jc'] / 10000 . '万元' : $dv['pivot']['coverage_jc'] }}</li>
								@php
								$i++;
								@endphp
							@endforeach
							@endforeach
							</ul>
						</div>
						{{--<p><span class="name">特别约定</span><i>:</i>保障期内在发生任何风险都不进行赔偿。</p>--}}
						{{--<p><span class="name">费率表</span><i>:</i><a href="#">查看详情</a></p>--}}
						{{--<p><span class="name">缴费方式</span><i>:</i>年缴</p>--}}
						{{--<p><span class="name">缴费期限</span><i>:</i><span class="mr">20年</span><span class="mr">15年</span><span class="mr">10年</span><span class="mr">5年</span><span class="mr">趸交</span></p>--}}
						{{--<p><span class="name">年龄限制</span><i>:</i>18-60周岁</p>--}}
						{{--<p><span class="name">职业类别</span><i>:</i>1-4类   <a href="#"> 职业类别表</a></p>--}}
						{{--<div><span class="name vtop">产品简介</span><i class="vtop">:</i>--}}
							{{--<ul class="duty-list">--}}
								{{--<li>中国人寿保险中国人寿保险中国人寿保险中国人寿保险中国人寿保险中国人寿保险 中国人寿保险中国人寿保险中国人寿保险中国人寿保险中国</li>--}}
							{{--</ul>--}}
						{{--</div>--}}
						<div><span class="name vtop">产品介绍</span><i class="vtop">:</i>
							<div class="duty-list duty-info">
								{{$product_res['res'][0]['content']}}
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="col-md-5 info">
			<div class="premium">
				<span>保费</span>
				<span class="fr color-primary">￥{{$product_res['res'][0]['base_price']/100}}元</span>
			</div>
			<div class="rate">
				<div class="rate-total">
					<span>共计产品返佣</span>
					<span class="fr">5000<i class="percent">(60%)</i></span>
				</div>
				<ul>
					<li>
						<span>公司佣金比</span>
						<span class="fr">3000<i class="percent">(60%)</i></span>
					</li>
					<li>
						<span>公司佣金比</span>
						<span class="fr">3000<i class="percent">(60%)</i></span>
					</li>
					<li>
						<span>代理人佣金比</span>
						<span class="fr">3000<i class="percent">(60%)</i></span>
					</li>
				</ul>
			</div>

			<div class="grade">
				<span class="name color-negative">综合评分:</span>
				<span class="iconfont icon-manyi"></span>
				<span class="iconfont icon-manyi"></span>
				<span class="iconfont icon-manyidu"></span>
				<span class="iconfont icon-manyidu"></span>
				<span class="iconfont icon-manyidu"></span>
			</div>
			<div class="operation">
				{{--@if($product_sync=='1')--}}
				{{--@if($product_status=='1')--}}
				{{--<a href="{{url('/backend/product/product_details_edit/'.$product_res['res']['id'])}}">--}}
				{{--<button class="btn btn-primary">个性化编辑</button>--}}
				{{--</a>--}}
				{{--@else--}}
				<button class="btn btn-primary" data-toggle="modal" data-target="#addTask">上架该产品</button>
				{{--@endif--}}
				{{--@else--}}
				{{--<button class="btn btn-primary" data-toggle="modal" data-target="#addTaskSync">同步该产品</button>--}}
				{{--@endif--}}
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="addTask" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog modal-alert" role="document">
		<div class="modal-content">
			<div class="modal-header notitle">
				<button type="button" class="refresh_close" data-dismiss="modal" aria-label="Close"><i class="iconfont icon-cancel"></i></button>
			</div>
			<div class="modal-body">
				<i class="iconfont icon-warning"></i>
				<p>上架前是否要进行个性化编辑</p>
			</div>
			<div class="modal-footer">
				<a href="{{url('/backend/product/product_details_edit/'.$product_res['res'][0]['id'])}}"><button class="btn btn-primary">是</button></a>
				<button id="product_up" class="btn btn-warning">否</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="success-up" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog modal-alert" role="document">
		<div class="modal-content">
			<div class="modal-header notitle">
				<button type="button" class="refresh_close" data-dismiss="modal" aria-label="Close"><i class="iconfont icon-cancel"></i></button>
			</div>
			<div class="modal-body">
				<i class="iconfont icon-duihao"></i>
				<p>上架成功</p>
			</div>
			<div class="modal-footer">
				<a href="/backend/product/product_list" class="color-primary">回到产品列表</a>
				<a href="/backend/product/product_rank_list" class="color-default">回到产品管理</a>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="up-warning-up" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog modal-alert" role="document">
		<div class="modal-content">
			<div class="modal-header notitle">
				<button type="button" class="refresh_close" data-dismiss="modal" aria-label="Close"><i class="iconfont icon-cancel"></i></button>
			</div>
			<div class="modal-body">
				<i class="iconfont icon-warning"></i>
				<p>上架失败</p>
			</div>
			<div class="modal-footer">
				<a href="/backend/product/product_list" class="color-primary">回到产品列表</a>
				<a href="/backend/product/product_rank_list" class="color-default">回到产品管理</a>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="sync-success-up" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog modal-alert" role="document">
		<div class="modal-content">
			<div class="modal-header notitle">
				<button type="button" class="refresh_close" data-dismiss="modal" aria-label="Close"><i class="iconfont icon-cancel"></i></button>
			</div>
			<div class="modal-body">
				<i class="iconfont icon-duihao"></i>
				<p>同步成功</p>
			</div>
			<div class="modal-footer">
				<a href="/backend/product/product_list" class="color-primary">回到产品列表</a>
				<a href="/backend/product/product_rank_list" class="color-default">回到产品管理</a>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="sync-warning-up" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog modal-alert" role="document">
		<div class="modal-content">
			<div class="modal-header notitle">
				<button type="button" class="refresh_close" data-dismiss="modal" aria-label="Close"><i class="iconfont icon-cancel"></i></button>
			</div>
			<div class="modal-body">
				<i class="iconfont icon-warning"></i>
				<p>同步失败</p>
			</div>
			<div class="modal-footer">
				<a href="/backend/product/product_stay_on" class="color-primary">回到产品列表</a>
				<a href="/backend/product/product_rank_list" class="color-default">回到产品管理</a>
			</div>
		</div>
	</div>
</div>
<script src="{{asset('r_backend/v2/js/lib/jquery-1.11.3.min.js')}}"></script>
<script src="{{asset('r_backend/v2/js/lib/bootstrap.min.js')}}"></script>
<script src="{{asset('r_backend/v2/js/common_backend.js')}}"></script>

<script>
	// 上传封面
	$('#up-cover').click(function(){
		$('.product-img').find('input:hidden').eq(0).click();
	});

	$('#btn-no').click(function(){
		$('#addTask').modal('hide');
		$('#success-up').modal('show');

	});


	$('.duty-info').html(changeInfo($('.duty-info').text()));




	// 上传照片
	var upLoadImg = function(e){
		var _this = $(e).parent();
		var $c = _this.find('input[type=file]')[0];
		var file = $c.files[0],reader = new FileReader();
		reader.readAsDataURL(file);
		reader.onload = function(e){
			_this.find('img').attr('src',e.target.result).css({'width':'11rem','height':'7rem'});
			var $targetEle = _this.find('input:hidden').eq(1);
			$targetEle.val(e.target.result);
			console.log($targetEle.val())

			if($('#frontVal').val() && $('#contraryVal').val()	){
				$('#next').prop('disabled',false);
			}

		};
	};

	$(document).on('click','.selected-wrapper',function(e){
		var target = $(e.target);
		if(target.hasClass('selected-wrapper')){

			$(this).toggleClass('focus');

			if($(this).hasClass('focus')){
				$('#addTag').focus();
			}else{
				$('#addTag').blur();
			}
		}
	});
</script>
@stop