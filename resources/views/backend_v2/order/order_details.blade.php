@extends('backend_v2.layout.base')
@section('title')@parent 订单管理 @stop
@section('head-more')
	<link rel="stylesheet" href="{{asset('r_backend/v2/css/client_details.css')}}" />
@stop

@section('top_menu')
	<div class="nav-top-wrapper fl">
		<ul>
			<li class="active">
				<a href="{{url('/backend/order/')}}" >个人订单</a>
			</li>
			<li>
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
				    <li><a href="#">个人订单</a></li>
				    {{--<li class="active">田小田</li>--}}
				</ol>
			</div>
			<div class="row">
				<div class="col-md-5">
					<div class="policy-content">
						<div class="policy-wrapper scroll-pane">
							<div class="policy-info">
									<h3 class="title">{{$item['name']}}</h3>
									<p>订单号：{{$product->order_code}}</p>
							</div>
							<div class="policy-list">
								<div><span class="name">公司名称</span><i>:</i>{{$item['company']['name']}}</div>
								<div><span class="name">保险险种</span><i>:</i>{{$item['category']['name']}}</div>
								<div><span class="name vtop">条款</span><i class="vtop">:</i>
										@foreach($item['clauses'] as $v)
											<li><a href="{{env('TY_API_PRODUCT_SERVICE_URL').'/'.$v['file_url']}}" target="_blank">{{$v['name']}}</a></li>
										@endforeach
								</div>

								<div><span class="name vtop">责任保额</span><i class="vtop">:</i>
									@php
									$i = 1;
									@endphp
									{{--<ul class="duty-list">--}}
										@foreach($item['clauses'] as $ck => $cv)
											@foreach($cv['duties'] as $dk => $dv)
												<li><span class="duty-name">{{ $dv['name'] }}</span>
													{{ preg_match('/^\d{5,}$/', $dv['pivot']['coverage_jc']) ?  $dv['pivot']['coverage_jc'] / 10000 . '万元' : $dv['pivot']['coverage_jc'] }}
												</li>
												@php
												$i++;
												@endphp
										@endforeach
									@endforeach
									{{--</ul>--}}
								</div>
								{{--<div><span class="name">特别约定</span><i>:</i>保障期内在发生任何风险都不进行赔偿。</div>--}}
								<div><span class="name">受益人</span><i>:</i>{{isset($warranty_beneficiary->beneficiary->name) ? "$warranty_beneficiary->beneficiary->name" : "法定受益人" }}</div>
								<div><span class="name">保 费</span><i>:</i>{{$product->premium/100}}元</div>
								<div><span class="name">缴费方式</span><i>:</i>
									{{ $product->by_stages_way=='0年' ? '趸交' : '年缴' }}
								</div>
								<div><span class="name">缴费期限</span><i>:</i>{{isset($product->by_stages_way)? "$product->by_stages_way" : "--"}}</div>
								<div><span class="name">佣金</span><i>:</i>{{isset($brokerage->brokerage) ? ceil($brokerage->brokerage/100)."元" : "--" }}</div>
								<div><span class="name">渠道</span><i>:</i>{{isset($ditches->name) ? "$ditches->name" : "--" }}</div>
								<div><span class="name">渠道佣金</span><i>:</i>{{isset($order_brokerage->user_earnings) ? ceil($order_brokerage->user_earnings/100)."元" : "--" }}</div>
								<div><span class="name">代理人</span><i>:</i>{{isset($order->real_name) ? "$order->real_name" : "--" }}
									{{--<a href="#" style="margin-left: 20px;">更换代理人</a>--}}
								</div>
								{{--<div><span class="name">代理人佣金</span><i>:</i>400元</div>--}}
								<div><span class="name">保单状态</span><i>:</i><span class="color-default">
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
									</span></div>
							</div>
						</div>
					</div>
				</div>


				<div class="col-md-7">
					<div class="info-wrapper active">
						<i class="iconfont icon-zhankai"></i>
						<button class="btn btn-primary">投保人</button>
						<div class="info-img col-lg-2">
							<img src="{{ asset('/r_backend/v2/img/girl.png')}}" alt="" />
						</div>
						<div class="col-lg-10">
							<p class="info-name">{{$warranty_policy->policy->name}}<span class="color-primary">
									<i class="iconfont icon-shiming"></i>已实名</span></p>
						</div>
						<div class="info-datails">
							<div class="col-xs-6 col-md-4">
								{{--<p><span class="name">性 别</span><i>:</i>男</p>--}}
								<p><span class="name">证件类型</span><i>:</i>身份证</p>
								<p><span class="name">渠道</span><i>:</i>{{isset($ditches->name) ? "$ditches->name" : "" }}</p>
								{{--<p><span class="name">购买保障</span><i>:</i>20种</p>--}}
								{{--<p><span class="name">职业类别</span><i>:</i>公司企业一般行政人员</p>--}}
							</div>
							<div class="col-xs-6 col-md-6">
								<p><span class="name">手机号码</span><i>:</i>{{$warranty_policy->policy->phone}}</p>
								<p><span class="name">证件号码</span><i>:</i>{{$warranty_policy->policy->code}}</p>
								<p><span class="name">邮箱</span><i>:</i>{{$warranty_policy->policy->email}}</p>
								{{--<p><span class="name">住址</span><i>:</i>{{$warranty_policy->policy->area}}</p>--}}
								{{--<p><span class="name">保费总计</span><i>:</i>30000元</p>--}}
							</div>
						</div>
					</div>
					
					<div class="info-wrapper">
						<i class="iconfont icon-zhankai"></i>
						<button class="btn btn-warning">被保人</button>
						<div class="info-img col-lg-2">
							<img src="{{ asset('/r_backend/v2/img/girl.png')}}" alt="" />
						</div>
						<div class="col-lg-10">
							<p class="info-name">{{isset($warranty_recognizee->name) ? $warranty_recognizee->name : $warranty_policy->policy->name }}<span class="color-primary"><i class="iconfont icon-shiming"></i>已实名</span></p>
						</div>
						<div class="info-datails">
							<div class="col-xs-6 col-md-4">
								{{--<p><span class="name">性 别</span><i>:</i>男</p>--}}
								<p><span class="name">证件类型</span><i>:</i>身份证</p>
								<p><span class="name">渠道</span><i>:</i>{{isset($ditches->name) ? "$ditches->name" : "" }}</p>
								{{--<p><span class="name">购买保障</span><i>:</i>20种</p>--}}
								{{--<p><span class="name">职业类别</span><i>:</i>公司企业一般行政人员</p>--}}
							</div>
							<div class="col-xs-6 col-md-6">
								<p><span class="name">手机号码</span><i>:</i> {{isset($warranty_recognizee->phone) ? $warranty_recognizee->phone : $warranty_policy->policy->phone }}</p>
								<p><span class="name">证件号码</span><i>:</i> {{isset($warranty_recognizee->code) ? $warranty_recognizee->code : $warranty_policy->policy->code }}</p>
								<p><span class="name">邮箱</span><i>:</i>{{isset($warranty_recognizee->email) ? $warranty_recognizee->email : $warranty_policy->policy->email }}</p>
								{{--<p><span class="name">保费总计</span><i>:</i>30000元</p>--}}
							</div>
						</div>
					</div>
					
					<div class="info-wrapper">
						<i class="iconfont icon-zhankai"></i>
						<button class="btn btn-info">受益人</button>
						<div class="info-img col-lg-2">
							<img src="{{ asset('/r_backend/v2/img/girl.png')}}" alt="" />
						</div>
						<div class="col-lg-10">
							<p class="info-name">{{isset($warranty_beneficiary->beneficiary->name) ? "$warranty_beneficiary->beneficiary->name" : "" }}<span class="color-primary"><i class="iconfont icon-shiming"></i>已实名</span></p>
						</div>
						<div class="info-datails">
							<div class="col-xs-6 col-md-4">
								{{--<p><span class="name">性 别</span><i>:</i>男</p>--}}
								<p><span class="name">证件类型</span><i>:</i>{{isset($warranty_beneficiary->beneficiary->name) ? "身份证" : "" }}</p>
								<p><span class="name">渠道</span><i>:</i>{{isset($warranty_beneficiary->beneficiary->name) ? isset($ditches->name) ? "$ditches->name" : "" : "无" }}</p>
								{{--<p><span class="name">购买保障</span><i>:</i>20种</p>--}}
								{{--<p><span class="name">职业类别</span><i>:</i>公司企业一般行政人员</p>--}}
							</div>
							<div class="col-xs-6 col-md-6">
								<p><span class="name">手机号码</span><i>:</i>{{isset($warranty_beneficiary->beneficiary->phone) ? $warranty_beneficiary->beneficiary->phone : "无" }}</p>
								<p><span class="name">证件号码</span><i>:</i>{{isset($warranty_beneficiary->beneficiary->code) ? $warranty_beneficiary->beneficiary->code : "无" }}</p>
								<p><span class="name">邮箱</span><i>:</i>{{isset($warranty_beneficiary->beneficiary->email) ? $warranty_beneficiary->beneficiary->email : "无" }}</p>
								{{--<p><span class="name">保费总计</span><i>:</i>{{$warranty_beneficiary->beneficiary->name}}元</p>--}}
							</div>
						</div>
					</div>
					
					{{--<div class="record">操作记录</div>--}}
					{{--<div class="record-list">--}}
						{{--<ul>--}}
							{{--<li>2017-03-02 11:52:50<span>创建订单</span>创建订单成功</li>--}}
							{{--<li>2017-03-02 11:52:50<span>创建订单</span>创建订单成功</li>--}}
							{{--<li>2017-03-02 11:52:50<span>创建订单</span>创建订单成功</li>--}}
							{{--<li>2017-03-02 11:52:50<span>创建订单</span>创建订单成功</li>--}}
						{{--</ul>--}}
					{{--</div>--}}
				{{--</div>--}}
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
