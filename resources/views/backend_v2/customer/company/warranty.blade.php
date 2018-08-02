@extends('backend_v2.layout.base')
@section('title')@parent 代理商详情 @stop
@section('head-more')
	<link rel="stylesheet" href="{{asset('r_backend/v2/css/client.css')}}" />
	<link rel="stylesheet" href="{{asset('r_backend/v2/css/client_details.css')}}" />
@stop

@section('top_menu')
	@include('backend_v2.customer.top', ['type' => 'company'])
@stop
@section('main')
		<div class="main-wrapper policy">
			<div class="row">
				<ol class="breadcrumb col-lg-12">
					<li><a href="{{ route('backend.customer.individual.index') }}">客户管理</a><i class="iconfont icon-gengduo"></i></li>
					<li><a href="{{ route('backend.customer.company.index') }}">企业客户</a><i class="iconfont icon-gengduo"></i></li>
					<li class="active">{{ $user->name }}</li>
				</ol>
			</div>
			<div class="row">
				<div class="col-md-5">
					<div class="policy-wrapper" style="height: 540px;">
						<div class="policy-info">
							<h3 class="title">{{ $product->product_name }}</h3>
							<p>订单号：{{ $warranty->warranty_code }}</p>
							<p>保单号：{{ $warranty->order_code }}</p>
						</div>
						<div class="policy-list">
							<p><span class="name">公司名称</span><i>:</i>{{ $product->company }}</p>
							<p><span class="name">保险险种</span><i>:</i>{{ $product->category }}</p>
							<p><span class="name">条款</span><i>:</i>
								@foreach($product->clauses as $clause)<a href="{{ env('APP_URL'). $clause['file_url'] }}">{{ $clause['name'] }}</a>@endforeach
							</p>
							<div><span class="name vtop">责任保额</span><i class="vtop">:</i>
								<div class="duty-list" style="height: 100px;">
									<ul>
										@foreach($coverage as $value)
											<li><span class="duty-name">{{ $value->name }}</span>{{ $value->defaultValue }}</li>
										@endforeach
									</ul>
								</div>
							</div>
							{{--<p><span class="name">特别约定</span><i>:</i>保障期内在发生任何风险都不进行赔偿。</p>--}}
							<p><span class="name">保障时间</span><i>:</i>{{ date('Y-m-d', strtotime($warranty->start_time)) }} 至 {{ date('Y-m-d', strtotime($warranty->end_time)) }}</p>
							<p><span class="name">保 费</span><i>:</i>{{ $warranty->premium }}元</p>
							<p><span class="name">缴费方式</span><i>:</i>{{ $warranty->by_stages_way=='0年' ? '趸交' : '年缴' }}</p>
							<p><span class="name">缴费期限</span><i>:</i>{{ $warranty->by_stages_way }}</p>
							<p><span class="name">佣金</span><i>:</i>{{ $warranty->brokerage }}元</p>
							<p><span class="name">渠道</span><i>:</i>{{ $warranty->ditch_name }}</p>
							<p><span class="name">渠道佣金</span><i>:</i>{{ $warranty->user_earnings }}元</p>
							<p><span class="name">代理人</span><i>:</i>{{ $warranty->agent_name }}
								{{--<a href="#" style="margin-left: 20px;">更换代理人</a>--}}
							</p>
							<p><span class="name">代理人佣金</span><i>:</i>{{ $warranty->user_earnings }}元</p>
						</div>
					</div>

					{{--<div class="record">操作记录</div>--}}
					{{--<div class="record-list">--}}
						{{--<ul>--}}
							{{--<li>2017-03-02 11:52:50<span>申请保金</span>申请成功</li>--}}
							{{--<li>2017-03-02 11:52:50<span>保单支付</span>支付成功，生成保单</li>--}}
							{{--<li>2017-03-02 11:52:50<span>发起投保</span>投保成功</li>--}}
							{{--<li>2017-03-02 11:52:50<span>发起投保</span>投保失败</li>--}}
						{{--</ul>--}}
					{{--</div>--}}
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
								@foreach($warranty_recognize as $item)
									<li class="ui-table-tr">
										<div class="col-md-2 col-xs-2">{{ $item->name }}</div>
										<div class="col-md-2 col-xs-2">{{ $item->phone }}</div>
										<div class="col-md-5 col-xs-6">{{ $item->code }}</div>
										{{--<div class="col-md-3 col-xs-2 text-right">--}}
											{{--<a class="btn btn-primary" href="{{ route('') }}">查看详情</a>--}}
										{{--</div>--}}
									</li>
								@endforeach
							</ul>
						</div>
						<div class="row text-center">
							{{ $warranty_recognize->links() }}
						</div>
					</div>
				</div>
			</div>
		</div>
@stop
@section('footer-more')
		<script>
			$('.icon-zhankai').click(function(){
				var _this = $(this);
				_this.parent().addClass('active').find('.info-datails').show();
				_this.parent().siblings().removeClass('active').find('.info-datails').hide();
			});
            $(".duty-list").panel({iWheelStep:50});
		</script>
@stop
