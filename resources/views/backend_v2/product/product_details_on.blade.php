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
				<li><a href="/backend/product/product_list">在售产品</a><i class="iconfont icon-gengduo"></i></li>
				<li class="active">{{$product_res['product_name']}}</li>
			</ol>
		</div>
		@include('backend_v2.product.product_middle')

		<div class="row">
			<div class="col-md-7 policy">
				<div class="policy-content">
					<div class="policy-wrapper scroll-pane">
						<div class="product-avatar">
							<div class="product-img">
								@if(empty($product_res['cover']))
									<img src="{{asset('/r_backend/v2/img/avatar.png')}}"/>
								@else
									<img src="{{$product_res['cover']}}"/>
								@endif
								<input hidden onchange="upLoadImg(this);" accept="image/*" type="file">
								<input hidden type="text">
							</div>
							<button id="up-cover" class="btn btn-default fr">上传封面</button>
						</div>
						<div class="policy-info">
							<h3 class="title">{{$product_res['product_name']}}
								@if($product_status=='1')
									<span class="color-default">(在售)</span>
								@elseif($product_status=='0')
									<span class="color-default">(已下架)</span>
								@endif
							</h3>
							<div>
								@if(count($product_labels_res)=='0')
									<span class="tag">暂无标签</span>
								@else
									@foreach($product_labels_res as $value)
										<span class="tag">{{$value['name']}}</span>
									@endforeach
								@endif
							</div>
							{{--<button class="btn btn-warning" data-toggle="modal" data-target="#addTags">添加标签</button>--}}
						</div>
						<div class="policy-list">
							<p><span class="name">上架时间</span><i>:</i>{{date('Y-m-d',strtotime($product_res['created_at']))}}</p>
							<p><span class="name">下架时间</span><i>:</i>-</p>
							<p><span class="name">公司名称</span><i>:</i>{{$product_res['company_name']}}</p>
							<p><span class="name">保险险种</span><i>:</i>{{json_decode($product_res['json'],true)['category']['name']}}</p>
							<div><span class="name vtop">条款</span><i class="vtop">:</i>
								<ul class="duty-list">
									@foreach(json_decode($product_res['clauses'],true) as $value)
										<li><a href="{{env('TY_API_PRODUCT_SERVICE_URL').'/'.$value['file_url']}}" target="_blank">{{$value['name']}}</a></li>
									@endforeach
								</ul>
							</div>

							@php $json = json_decode($product_res['json'],true);@endphp
							<div><span class="name vtop">责任保额</span><i class="vtop">:</i>
								@php
								$i = 1;
								@endphp
								<ul class="duty-list">
									@foreach($json['clauses'] as $ck => $cv)
										@foreach($cv['duties'] as $dk => $dv)
											<li>
												<span class="duty-name" >{{ $dv['name'] }}</span>
												{{ preg_match('/^\d{5,}$/', $dv['pivot']['coverage_jc']) ?  $dv['pivot']['coverage_jc'] / 10000 . '万元' : $dv['pivot']['coverage_jc'] }}
											</li>
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
							<div>
								<span class="name vtop">产品介绍</span><i class="vtop">:</i>
								<div class="duty-list duty-info">
									{{json_decode($product_res['json'],true)['content']}}
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>


			<div class="col-md-5 info">
				<div class="premium">
					<span>保费</span>
					<span class="fr color-primary">￥{{json_decode($product_res['json'],true)['base_price']/100}}元</span>
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
				@if($product_status=='0')
					@if(!empty($product_res['product_down_reason']))
						<div class="cause">
							<span class="fl">下架原因：</span>
							<div class="cause-content">
								<ul>
									@if(count($product_res['product_down_reason'])=='0')
										<li>
											产品不好卖
										</li>
									@else
										@foreach($product_res['product_down_reason'] as $value)
											<li>
												@if(empty($value['product_down_content']))
													@if(!empty($value['product_down_labels']))
														@foreach(json_decode($value['product_down_labels'],true) as $v)
															{{$v}}
														@endforeach
													@endif
												@else
													{{$value['product_down_content']}}
													@if(!empty($value['product_down_labels']))
														@foreach(json_decode($value['product_down_labels'],true) as $v)
															{{$v}}
														@endforeach
													@endif
												@endif
											</li>
										@endforeach
									@endif
								</ul>
							</div>
						</div>
					@endif
				@endif

				<div class="operation">
					@if(!empty($product_res['personal']))
						<button class="btn btn-warning" data-toggle="modal" data-target="#preview">个性化查看</button>
					@endif
					@if($product_status=='1')
						<button class="btn btn-warning" data-toggle="modal" data-target="#soldOut">下架产品</button>
					@endif
				</div>
			</div>

			<div class="modal fade" id="soldOut" role="dialog" aria-labelledby="myModalLabel">
				<div class="modal-dialog modal-alert" role="document">
					<div class="modal-content">
						<div class="modal-header notitle">
							<button type="button" class="refresh_close" data-dismiss="modal" aria-label="Close"><i class="iconfont icon-cancel"></i></button>
						</div>
						<div class="modal-body">
							<i class="iconfont icon-warning"></i>
							<p>是否要残忍下架</p>
						</div>
						<div class="modal-footer">
							<button id="btn-yes" class="btn btn-primary">是</button>
							<button class="btn btn-warning" data-dismiss="modal">否</button>
						</div>
					</div>
				</div>
			</div>

			<div class="modal fade" id="confrim" role="dialog" aria-labelledby="myModalLabel">
				<div class="modal-dialog modal-alert" role="document">
					<div class="modal-content">
						<div class="modal-header notitle">
							<button type="button" class="" data-dismiss="modal" aria-label="Close"><i class="iconfont icon-cancel"></i></button>
						</div>
						<div class="modal-body">
							<i class="iconfont icon-warning"></i>
							<p>请选择下架原因</p>
							<form action="/backend/product/product_down_reason" method="post" id="form_down_reason">
								{{ csrf_field() }}
								<input type="hidden" name="ty_product_id" value="{{$product_res['ty_product_id']}}">
								<div class="cause-wapper">
									<div class="cause-select">
										<ul>
											<li>
												<label>
													<i class="iconfont icon-weixuan"></i>
													<input hidden type="checkbox" name="product_down_labels[]" value="产品不好卖">
												</label>
												产品不好卖不好卖
											</li>
											<li>
												<label>
													<i class="iconfont icon-weixuan"></i>
													<input hidden type="checkbox" name="product_down_labels[]" value="产品不好卖">
												</label>
												产品不好卖不好卖
											</li>
											<li>
												<label>
													<i class="iconfont icon-weixuan"></i>
													<input hidden type="checkbox" name="product_down_labels[]" value="产品不好卖">
												</label>
												产品不好卖
											</li>
											<li>
												<label>
													<i class="iconfont icon-weixuan"></i>
													<input hidden type="checkbox" name="product_down_labels[]" value="产品不好卖">
												</label>
												产品不好卖
											</li>
											<li>
												<label>
													<i class="iconfont icon-weixuan"></i>
													<input hidden type="checkbox" name="product_down_labels[]" value="产品不好卖">
												</label>
												产品不好卖不好卖
											</li>
											<li>
												<label>
													<i class="iconfont icon-weixuan"></i>
													<input hidden type="checkbox" name="product_down_labels[]" value="产品不好卖">
												</label>
												产品不好卖不好卖
											</li>
											<li>
												<label>
													<i class="iconfont icon-weixuan"></i>
													<input hidden type="checkbox" name="product_down_labels[]" value="产品不好卖">
												</label>
												产品不好卖不好卖
											</li>
											<li>
												<label>
													<i class="iconfont icon-weixuan"></i>
													<input hidden type="checkbox" name="product_down_labels[]" value="产品不好卖">
												</label>
												产品不好卖
											</li>
											<li>
												<label>
													<i class="iconfont icon-weixuan"></i>
													<input hidden type="checkbox" name="product_down_labels[]" value="产品不好卖">
												</label>
												产品不好卖不好卖
											</li>
											<li>
												<label>
													<i class="iconfont icon-weixuan"></i>
													<input hidden type="checkbox" name="product_down_labels[]" value="产品不好卖">
												</label>
												产品不好卖不好卖
											</li>
										</ul>
									</div>
									<p class="title">备注:</p>
									<textarea class="cause-text" name="product_down_content" id="product_down_reason"></textarea>
									<button id="btn-cause" class="btn btn-primary" disabled>提交</button>
								</div>
							</form>
						</div>
						<div class="modal-footer">
							<a href="/backend/product/product_list" class="color-primary">回到产品列表</a>
							<a href="/backend/product/product_rank_list" class="color-default">回到产品管理</a>
						</div>
					</div>
				</div>
			</div>



			<div class="modal fade" id="warning_down" role="dialog" aria-labelledby="myModalLabel">
				<div class="modal-dialog modal-alert" role="document">
					<div class="modal-content">
						<div class="modal-header notitle">
							<button type="button" class="refresh_close" data-dismiss="modal" aria-label="Close"><i class="iconfont icon-cancel"></i></button>
						</div>
						<div class="modal-body">
							<i class="iconfont icon-warning"></i>
							<p>下架失败</p>
						</div>
						<div class="modal-footer">
							<a href="/backend/product/product_list" class="color-primary">回到产品列表</a>
							<a href="/backend/product/product_rank_list" class="color-default">回到产品管理</a>
						</div>
					</div>
				</div>
			</div>
			@if(!empty($product_res['personal']))
				<div class="modal fade" id="preview" role="dialog" aria-labelledby="myModalLabel">
					<div class="modal-dialog modal-alert" role="document">
						<div class="modal-content">
							<div class="modal-header notitle">
								<button type="button" class="" data-dismiss="modal" aria-label="Close"><i class="iconfont icon-cancel"></i></button>
							</div>
							<div class="modal-body">
								<ul class="preview-list">
									@foreach(json_decode($product_res['personal'],true) as $value)
										<li>
											<img src="/{{$value}}" alt="" />
										</li>
									@endforeach
								</ul>
							</div>
						</div>
					</div>
				</div>
			@endif


		</div>
	</div>
	<script src="http://ty.laravel.com/r_backend/v2/js/lib/jquery-1.11.3.min.js"></script>
	<script src="{{asset('r_backend/v2/js/lib/bootstrap.min.js')}}"></script>
    <script src="http://ty.laravel.com/r_backend/v2/js/lib/jquery-1.11.3.min.js"></script>
	<script>
		$(function(){


		$('.refresh_close').on('click',function () {
			location.href = location;
		})

		$('#btn-yes').on('click',function() {
			var product_id = "{{$product_res['ty_product_id']}}";
			$.ajax( {
				type : "get",
				url : "/backend/product/add_product_down",
				dataType : 'json',
				data : {id:product_id},
				success:function(msg){
					if(msg.status == 1){
						$('#soldOut').modal('hide');
						$('#confrim').modal('show');
					}else{
						$('#soldOut').modal('hide');
						$('#confrim').modal('show');
					}
				}
			});
		});
		// 初始化
		$(".cause-select").panel({iWheelStep:32});
		new CheckTable('.cause-select');
		var Ele = {
			cause_text: $('.cause-text'),
			btn_cause: $('#btn-cause'),
		}
		Ele.cause_text.bind('input propertychange', function() {
			checkValue();
		});
		$('.cause-select .iconfont').click(function(){
			checkValue();
		});
		// 是否可以提交下架原因
		function checkValue(){
			$(".cause-select .icon-xuanze").length === 0 ? Ele.btn_cause[0].disabled = true : $('#btn-cause')[0].disabled = false;

			if(Ele.cause_text.val()){
				Ele.btn_cause[0].disabled = false;
			}
		}
		});
	</script>


	<script>
		$(function(){

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

				if($('#frontVal').val() && $('#contraryVal').val()){
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
		});
	</script>


@stop
