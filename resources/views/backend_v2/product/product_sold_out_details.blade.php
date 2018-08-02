@extends('backend_v2.layout.base')
@section('title')@parent产品管理 @stop
@section('head-more')
	<link rel="stylesheet" href="{{asset('r_backend/v2/css/product.css')}}" />
@stop
@section('top_menu')
	@include('backend_v2.product.product_top')
@stop
@section('main')
		<div id="product" class="main-wrapper">
			<div class="row">
				<ol class="breadcrumb col-lg-12">
				    <li><a href="/backend/product/product_list">产品管理</a><i class="iconfont icon-gengduo"></i></li>
				    <li><a href="/backend/product/product_sold_out">下架产品</a><i class="iconfont icon-gengduo"></i></li>
				    <li class="active">{{$product_res['product_name']}}</li>
				</ol>
			</div>
			<div class="row">
				<div class="col-md-7 policy">
					<div class="policy-wrapper">
						
						<div class="product-avatar">
							<div class="product-img">
								@if(empty($product_res['cover']))
									<img src="{{asset('/r_backend/v2/img/avatar.png')}}"/>
								@else
									<img src="/{{$product_res['cover']}}"/>
								@endif
							</div>
						</div>
						<div class="policy-info">
							<h3 class="title">{{$product_res['product_name']}}
								{{--<span class="color-primary">(未上架)</span>--}}
							</h3>
							{{--<button class="btn btn-warning" data-toggle="modal" data-target="#addTags">添加标签</button>--}}
						</div>
						<div class="policy-list">
							<p><span class="name">创建时间</span><i>:</i>{{$product_res['created_at']}}</p>
							<p><span class="name">上架时间</span><i>:</i>-</p>
							<p><span class="name">公司名称</span><i>:</i>{{$product_res['company_name']}}</p>
							<p><span class="name">保险险种</span><i>:</i>{{json_decode($product_res['json'],true)['category']['name']}}</p>
							@foreach(json_decode($product_res['clauses'],true) as $value)
							<p><span class="name">条款</span><i>:</i><a href="{{env('TY_API_PRODUCT_SERVICE_URL').'/'.$value['file_url']}}" target="_blank">{{$value['name']}}</a></p>
							@endforeach
							{{--<div><span class="name vtop">责任保额</span><i class="vtop">:</i>--}}
								{{--<ul class="duty-list">--}}
									{{--<li><span class="duty-name">重症疾病</span>5万</li>--}}
									{{--<li><span class="duty-name">轻症疾病</span>5万</li>--}}
									{{--<li><span class="duty-name">身故保障金</span>已交保险费</li>--}}
									{{--<li><span class="duty-name">全残保障金 </span>全部保险金/两万保险金额</li>--}}
								{{--</ul>--}}
							{{--</div>--}}
							<p><span class="name">特别约定</span><i>:</i>保障期内在发生任何风险都不进行赔偿。</p>
							{{--<p><span class="name">费率表</span><i>:</i><a href="#">查看详情</a></p>--}}
							<p><span class="name">缴费方式</span><i>:</i>年缴</p>
							<p><span class="name">缴费期限</span><i>:</i><span class="mr">20年</span><span class="mr">15年</span><span class="mr">10年</span><span class="mr">5年</span><span class="mr">趸交</span></p>
							<p><span class="name">年龄限制</span><i>:</i>18-60周岁</p>
							<p><span class="name">职业类别</span><i>:</i>1-4类
								{{--<a href="#"> 职业类别表</a>--}}
							</p>
							{{--<div><span class="name vtop">产品简介</span><i class="vtop">:</i>--}}
								{{--<ul class="duty-list">--}}
									{{--<li>中国人寿保险中国人寿保险中国人寿保险中国人寿保险中国人寿保险中国人寿保险 中国人寿保险中国人寿保险中国人寿保险中国人寿保险中国</li>--}}
								{{--</ul>--}}
							{{--</div>--}}
							{{--<div><span class="name vtop">产品介绍</span><i class="vtop">:</i>--}}
								{{--<ul class="duty-list">--}}
									{{--<li>中国人寿保险中国人寿保险中国人寿保险中国人寿保险中国人寿保险中国人寿保险 中国人寿保险中国人寿保险中国人寿保险中国人寿保险中国</li>--}}
								{{--</ul>--}}
							{{--</div>--}}
							<div>
								<span class="name vtop">产品介绍</span><i class="vtop">:</i>
								<div class="duty-list duty-details">
									<ul>
										<li>{{json_decode($product_res['json'],true)['content']}}</li>
									</ul>
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
					<div class="operation">
							<button class="btn btn-primary" data-toggle="modal" data-target="#addTaskUp">上架该产品</button>
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

		<div class="modal fade" id="addTaskUp" role="dialog" aria-labelledby="myModalLabel">
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
						<a href="{{url('/backend/product/product_details_edit/'.$product_res['ty_product_id'])}}">
						<button class="btn btn-primary">是</button>
						</a>
						<button id="product_up" class="btn btn-warning">否</button>
					</div>
				</div>
			</div>
		</div>
		<script src="{{asset('r_backend/v2/js/lib/jquery-1.11.3.min.js')}}"></script>
		<script src="{{asset('r_backend/v2/js/common_backend.js')}}"></script>
		<script src="{{asset('r_backend/v2/js/lib/bootstrap-datetimepicker.min.js')}}"></script>
		<script src="{{asset('r_backend/v2/js/lib/bootstrap-datetimepicker.zh-CN.js')}}"></script>)
		<script>
            $(".duty-details").panel({iWheelStep:32});
            $(".cause-content").panel({iWheelStep:32});
            $('.refresh_close').on('click',function () {
                location.href = location;
            })
            $('#product_up').on('click',function() {
                var product_id = "{{$product_res['ty_product_id']}}";
                $.ajax( {
                    type : "get",
                    url : "/backend/product/add_product_up",
                    dataType : 'json',
                    data : {id:product_id},
                    success:function(msg){
                        if(msg.status == 0){
                            $('#addTaskUp').modal('hide');
                            $('#success-up').modal('show');
                        }else{
                            $('#addTaskUp').modal('hide');
                            $('#up-warning-up').modal('show');
                        }
                    }
                });
            });
			$('#btn-no').click(function(){
				$('#addTaskUp').modal('hide');
			});
		</script>
@stop