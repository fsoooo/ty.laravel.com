@extends('backend_v2.layout.base')
@section('title')@parent 代理商详情 @stop
@section('head-more')
	<link rel="stylesheet" href="{{asset('r_backend/v2/css/client.css')}}" />
	<link rel="stylesheet" href="{{asset('r_backend/v2/css/client_details.css')}}" />
@stop

@section('top_menu')
	@include('backend_v2.customer.top', ['type' => 'user'])
@stop
@section('main')
		<div class="main-wrapper policy">
			<div class="row">
				<ol class="breadcrumb col-lg-12">
					<li><a href="{{ route('backend.customer.individual.index') }}">客户管理</a><i class="iconfont icon-gengduo"></i></li>
					<li><a href="{{ route('backend.customer.individual.index') }}">个人客户</a><i class="iconfont icon-gengduo"></i></li>
					<li class="active">{{ $user->name }}</li>
				</ol>
			</div>
			<div class="row">
				<div class="col-md-5">
					<div class="policy-wrapper">
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
							<p><span class="name">受益人</span><i>:</i>法定受益人</p>
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
				</div>
				<div class="col-md-7">
					<div class="info-wrapper active">
						<i class="iconfont icon-zhankai"></i>
						<button class="btn btn-primary">投保人</button>
						<div class="info-img col-lg-2">
							<img src="{{ asset('/r_backend/v2/img/boy.png')}}" alt="" />
						</div>
						<div class="col-lg-10">
							<p class="info-name">{{ $user->name }}
								@if($user->verified == 1)
									<span class="color-primary">
										<i class="iconfont icon-shiming"></i>已实名
									</span>
								@else
									<span class="color-grey">
										<i class="iconfont icon-shiming"></i>未实名
									</span>
								@endif
							</p>
						</div>
						<div class="info-datails">
							<div class="col-xs-6 col-md-4">
								<p><span class="name">性 别</span><i>:</i>{{ $user->sex }}</p>
								<p><span class="name">证件类型</span><i>:</i>身份证</p>
								<p><span class="name">渠道</span><i>:</i>{{ $user->ditch_name }}</p>
								<p><span class="name">购买保障</span><i>:</i>{{ $user->product_count }}种</p>
								{{--<p><span class="name">职业类别</span><i>:</i>公司企业一般行政人员</p>--}}
							</div>
							<div class="col-xs-6 col-md-6">
								<p><span class="name">手机号码</span><i>:</i>{{ $user->phone }}</p>
								<p><span class="name">证件号码</span><i>:</i>{{ $user->code }}</p>
								<p><span class="name">邮箱</span><i>:</i>{{ $user->email }}</p>
								<p><span class="name">保费总计</span><i>:</i>{{ $user->premium }}元</p>
							</div>
						</div>
					</div>
					
					<div class="info-wrapper">
						<i class="iconfont icon-zhankai"></i>
						<button class="btn btn-warning">被保人</button>
						<div class="info-img col-lg-2">
							<img src="{{ asset('/r_backend/v2/img/boy.png')}}" alt="" />
						</div>
						<div class="col-lg-10">
							<p class="info-name">{{ $warranty_recognize->name }}
								{{--<span class="color-primary"><i class="iconfont icon-shiming"></i>已实名</span>--}}
							</p>
						</div>
						<div class="info-datails">
							<div class="col-xs-6 col-md-4">
								<p><span class="name">性 别</span><i>:</i>{{ $warranty_recognize->sex }}</p>
								<p><span class="name">证件类型</span><i>:</i>身份证</p>
								{{--<p><span class="name">渠道</span><i>:</i>东城区组</p>--}}
								{{--<p><span class="name">购买保障</span><i>:</i>20种</p>--}}
								{{--<p><span class="name">职业类别</span><i>:</i>公司企业一般行政人员</p>--}}
							</div>
							<div class="col-xs-6 col-md-6">
								<p><span class="name">手机号码</span><i>:</i>{{ $warranty_recognize->phone }}</p>
								<p><span class="name">证件号码</span><i>:</i>{{ $warranty_recognize->code }}</p>
								<p><span class="name">邮箱</span><i>:</i>{{ $warranty_recognize->email }}</p>
								{{--<p><span class="name">保费总计</span><i>:</i>30000元</p>--}}
							</div>
						</div>
					</div>
					
					<div class="info-wrapper">
						<i class="iconfont icon-zhankai"></i>
						<button class="btn btn-info">受益人</button>
						<div class="info-img col-lg-2">
							<img src="{{ asset('/r_backend/v2/img/boy.png')}}" alt="" />
						</div>
						<div class="col-lg-10">
							<p class="info-name">{{ $warranty_recognize->name }}
								{{--<span class="color-primary"><i class="iconfont icon-shiming"></i>已实名</span>--}}
							</p>
						</div>
						<div class="info-datails">
							<div class="col-xs-6 col-md-4">
								<p><span class="name">性 别</span><i>:</i>{{ $warranty_recognize->sex }}</p>
								<p><span class="name">证件类型</span><i>:</i>身份证</p>
								{{--<p><span class="name">渠道</span><i>:</i>东城区组</p>--}}
								{{--<p><span class="name">购买保障</span><i>:</i>20种</p>--}}
								{{--<p><span class="name">职业类别</span><i>:</i>公司企业一般行政人员</p>--}}
							</div>
							<div class="col-xs-6 col-md-6">
								<p><span class="name">手机号码</span><i>:</i>{{ $warranty_recognize->phone }}</p>
								<p><span class="name">证件号码</span><i>:</i>{{ $warranty_recognize->code }}</p>
								<p><span class="name">邮箱</span><i>:</i>{{ $warranty_recognize->email }}</p>
								{{--<p><span class="name">保费总计</span><i>:</i>30000元</p>--}}
							</div>
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
        $(".duty-list").panel({iWheelStep:32});
	</script>
@stop
