@extends('backend_v2.layout.base')
@section('title')@parent 订单管理 @stop
@section('head-more')
	<link rel="stylesheet" href="{{asset('r_backend/v2/css/client_details.css')}}" />
@stop

@section('top_menu')
	<div class="nav-top-wrapper fl">
		<ul>
			<li>
				<a href="{{url('/backend/order/')}}" >个人订单</a>
			</li>
			<li class="active">
				<a href="{{url('/backend/order/enterprise/')}}">企业订单</a>
			</li>
		</ul>
	</div>
@stop
@section('main')
		<div class="main-wrapper policy">
			<div class="row">
				<ol class="breadcrumb col-lg-12">
				    <li><a href="#">订单管理</a><i class="iconfont icon-gengduo"></i></li>
				    <li><a href="#">企业订单</a><i class="iconfont icon-gengduo"></i></li>
				    {{--<li class="active">天眼互联科技有限公司</li>--}}
				</ol>
			</div>
			<div class="row">


				<div class="col-md-5">
					<div class="policy-content" style="margin-bottom: 10px;">
						<div class="policy-wrapper scroll-pane" style="height: 540px;">
							<div class="policy-info">
								<h3 class="title">{{$item['name']}}</h3>
								<p>订单号：{{$product->order_code}}</p>
							</div>
							<div class="policy-list">
								<p><span class="name">公司名称</span><i>:</i>{{$item['company']['name']}}</p>
								<p><span class="name">保险险种</span><i>:</i>{{$item['category']['name']}}</p>
								<p><span class="name">条款</span><i>:</i>
									@foreach($item['clauses'] as $v)
										<li><a href="{{env('TY_API_PRODUCT_SERVICE_URL').'/'.$v['file_url']}}" target="_blank">{{$v['name']}}</a></li>
									@endforeach
								</p>

								<div><span class="name vtop">责任保额</span><i class="vtop">:</i>
									@php
									$i = 1;
									@endphp
									{{--<ul class="duty-list">--}}
										@foreach($item['clauses'] as $ck => $cv)
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
									{{--</ul>--}}
								</div>
								{{--<p><span class="name">特别约定</span><i>:</i>保障期内在发生任何风险都不进行赔偿。</p>--}}
								<p><span class="name">保障时间</span><i>:</i>2017-10-20 至 2018-10-21</p>
								<p><span class="name">保 费</span><i>:</i>{{isset($product->premium) ? ceil($product->premium/100)."元" : "--" }}</p>
								<p><span class="name">缴费方式</span><i>:</i>{{ $product->by_stages_way=='0年' ? '趸交' : '年缴' }}</p>
								<p><span class="name">缴费期限</span><i>:</i>{{isset($product->by_stages_way) ? "$product->by_stages_way" : "--" }}</p>
								<p><span class="name">佣金</span><i>:</i>{{isset($brokerage->brokerage) ? ceil($brokerage->brokerage/100)."元" : "--" }}</p>
								<p><span class="name">渠道</span><i>:</i>{{isset($ditches->name) ? "$ditches->name" : "--" }}</p>
								<p><span class="name">渠道佣金</span><i>:</i>{{isset($order_brokerage->user_earnings) ? ceil($order_brokerage->user_earnings/100)."元" : "--" }}</p>
								<p><span class="name">代理人</span><i>:</i>{{isset($order->real_name) ? "$order->real_name" : "--" }}</p>
								<p><span class="name">代理人佣金</span><i>:</i>
									@if($product->status == 1)
										已支付
									@elseif($product->status == 2)
										未支付
									@elseif($product->status == 3)
										支付失败
									@elseif($product->status == 4)
										支付中
									@elseif($product->status == 6)
										核保错误
									@elseif($product->status == 7)
										取消支付
									@endif
								</p>
							</div>
						</div>
					</div>


					<div class="record">操作记录</div>
					<div class="record-list">
						<ul>
							<li>2017-03-02 11:52:50<span>申请保金</span>申请成功</li>
							<li>2017-03-02 11:52:50<span>保单支付</span>支付成功，生成保单</li>
							<li>2017-03-02 11:52:50<span>发起投保</span>投保成功</li>
							<li>2017-03-02 11:52:50<span>发起投保</span>投保失败</li>
						</ul>
					</div>
				</div>



				<div class="col-md-7">
					<div style="margin-bottom: 10px;">公司员工列表</div>
					<div class="ui-table">
						<div class="ui-table-header radius">
							<span class="col-md-2 col-xs-2">员工姓名</span>
							<span class="col-md-2 col-xs-2">联系方式</span>
							<span class="col-md-5 col-xs-6">证件信息</span>
							{{--<span class="col-md-3 col-xs-2 col-one">操作</span>--}}
						</div>
						<div class="ui-table-body">
							<ul>
								@foreach($warranty_recognizee as $value)
								<li class="ui-table-tr">
									<div class="col-md-2 col-xs-2">{{$value->name}}</div>
									<div class="col-md-2 col-xs-2">{{$value->phone}}</div>
									<div class="col-md-5 col-xs-6">{{$value->code}}</div>
									<div class="col-md-3 col-xs-2 text-right">
										{{--<a class="btn btn-primary" href="html/channel/channel_details.html">查看详情</a>--}}
									</div>
								</li>
								@endforeach

							</ul>
						</div>
						<div class="row text-center">
							{{$warranty_recognizee->links()}}
						</div>
					</div>
				</div>
			</div>
		</div>

		<script src="{{asset('r_backend/v2/js/lib/jquery-1.11.3.min.js')}}"></script>
		<script src="{{asset('r_backend/v2/js/common_backend.js')}}"></script>
		<script>
			$(".duty-list").panel({iWheelStep:32});

			$('.icon-zhankai').click(function(){
				var _this = $(this);
				_this.parent().addClass('active').find('.info-datails').show();
				_this.parent().siblings().removeClass('active').find('.info-datails').hide();
			});
		</script>
@stop
