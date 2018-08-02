@extends('backend_v2.layout.base')
@section('title')@parent 保单管理 @stop
@section('head-more')
	<link rel="stylesheet" href="{{asset('r_backend/v2/css/client_details.css')}}" />
@stop
@section('top_menu')
	<div class="nav-top-wrapper fl">
		<ul>
			<li class="active">
				<a href="{{url('/backend/policy/')}}" >个人保单</a>
			</li>
			<li>
				<a href="{{url('/backend/policy/policy_company/')}}">企业保单</a>
			</li>
			<li>
				<a href="{{url('/backend/policy/policy_offline/')}}">线下保单</a>
			</li>
		</ul>
	</div>
@stop
@section('main')
		<div class="main-wrapper policy">
			<div class="row">
				<ol class="breadcrumb col-lg-12">
				    <li><a href="#">保单管理</a><i class="iconfont icon-gengduo"></i></li>
				    <li><a href="#">个人保单</a><i class="iconfont icon-gengduo"></i></li>
				</ol>
			</div>
			<div class="row">
				<div class="col-md-5">
					<div class="policy-content">
						<div class="policy-wrapper scroll-pane">
							@if(!empty($product_res)&&!empty($warranty)&&!empty($order))
								<div class="policy-info">
									<h3 class="title">{{$product_res['product_name']}}</h3>
									<p>保单号：{{$warranty['warranty_code']}}</p>
									<p>订单号：{{$order['order_code']}}</p>
								</div>
							@endif
							<div class="policy-list">
{{--								@if(!empty($json))--}}
								<div><span class="name">公司名称</span><i>:</i>{{$json['company']['name']}}</div>
								<div><span class="name">保险险种</span><i>:</i>{{$json['category']['name']}}</div>
								<div><span class="name vtop">条款</span><i class="vtop">:</i>
									@foreach($json['clauses'] as $v)
										<li><a href="{{env('TY_API_PRODUCT_SERVICE_URL').'/'.$v['file_url']}}">{{$v['name']}}</a></li>
									@endforeach
								</div>

								<div><span class="name vtop">责任保额</span><i class="vtop">:</i>
									@php
									$i = 1;
									@endphp
									<ul>
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

								{{--<div><span class="name">特别约定</span><i>:</i>保障期内在发生任何风险都不进行赔偿。</div>--}}
								<div><span class="name">受益人</span><i>:</i>{{isset($beneficiary['name']) ? $beneficiary['name'] : "法定受益人" }}</div>
								<div><span class="name">保 费</span><i>:</i>{{ceil($order['premium']/100)}}元</div>
								<div><span class="name">缴费方式</span><i>:</i>{{  $order->by_stages_way=='0年' ? '趸交' : '年缴' }}</div>
								<div><span class="name">缴费期限</span><i>:</i>{{isset($order->by_stages_way) ? $order->by_stages_way : "0年" }}</div>
								<div><span class="name">佣金</span><i>:</i>{{isset($order_brokerage->brokerage) ? ceil($order_brokerage->brokerage/100)."元" : "--"  }}</div>
								<div><span class="name">渠道</span><i>:</i>{{isset($ditches->name) ? "$ditches->name" : "" }}</div>
								<div><span class="name">渠道佣金</span><i>:</i>{{ceil($order['premium']/100*$product_res['base_ratio']/100)}}元</div>
								<div><span class="name">代理人</span><i>:</i>{{isset($order_agent->real_name) ? "$order_agent->real_name" : "--"}}
									{{--<a href="#" style="margin-left: 20px;">更换代理人</a>--}}
								</div>
								{{--<div><span class="name">代理人佣金</span><i>:</i>400元</div>--}}
								<div><span class="name">保单状态</span><i>:</i><span class="color-default">
										@if($order->status == 1)
											已支付
										@elseif($order->status == 2)
											未支付
										@elseif($order->status == 3)
											支付失败
										@elseif($order->status == 4)
											支付中
										@elseif($order->status == 6)
											核保错误
										@elseif($order->status == 7)
											取消支付
										@endif
									</span></div>
							</div>
						</div>

					</div>
				</div>
				<div class="col-md-7">
					@if(!empty($policy))
					<div class="info-wrapper active">
						<i class="iconfont icon-zhankai"></i>
						<button class="btn btn-primary">投保人</button>
						<div class="info-img col-xs-2">
							<img src="{{ asset('/r_backend/v2/img/girl.png')}}" alt="" />
						</div>
						<div class="col-xs-10" style="width: 60%;">
							<p class="info-name">{{$policy['name']}}<span class="color-primary"><i class="iconfont icon-shiming"></i>已实名</span></p>
						</div>
						<div class="info-datails">
							<div class="col-xs-6 col-md-4">
								<p><span class="name">性 别</span><i>:</i></p>
								<p><span class="name">证件类型</span><i>:</i>身份证</p>
								<p><span class="name">渠道</span><i>:</i>{{isset($ditches->name) ? "$ditches->name" : "" }}</p>
								<p><span class="name">购买保障</span><i>:</i>20种</p>
								<p><span class="name">职业类别</span><i>:</i>公司企业一般行政人员</p>
							</div>
							<div class="col-xs-6 col-md-5">
								<p><span class="name">手机号码</span><i>:</i>{{$policy['phone']}}</p>
								<p><span class="name">证件号码</span><i>:</i>{{$policy['code']}}</p>
								<p><span class="name">邮箱</span><i>:</i>{{$policy['email']}}</p>
								<p><span class="name">保费总计</span><i>:</i>30000元</p>
							</div>
						</div>
					</div>
					@endif
					@if(!empty($warranty_recognizees))
						@foreach($warranty_recognizees as $warranty_recognizee)
					<div class="info-wrapper">
						<i class="iconfont icon-zhankai"></i>
						<button class="btn btn-warning">被保人</button>
						<div class="info-img col-xs-2">
							<img src="{{ asset('/r_backend/v2/img/girl.png')}}" alt="" />
						</div>
						<div class="col-xs-10" style="width: 60%;">
							<p class="info-name">{{isset($warranty_recognizee->name) ? $warranty_recognizee->name : "" }}<span class="color-primary"><i class="iconfont icon-shiming"></i>已实名</span></p>
						</div>
						<div class="info-datails">
							<div class="col-xs-6 col-md-4">
								<p><span class="name">性 别</span><i>:</i></p>
								<p><span class="name">证件类型</span><i>:</i>身份证</p>
								<p><span class="name">渠道</span><i>:</i>{{isset($warranty_recognizee->name) ?  isset($ditches->name) ? "$ditches->name" : "": "" }}</p>
								<p><span class="name">购买保障</span><i>:</i>20种</p>
								<p><span class="name">职业类别</span><i>:</i>公司企业一般行政人员</p>
							</div>
							<div class="col-xs-6 col-md-5">
								<p><span class="name">手机号码</span><i>:</i>{{isset($warranty_recognizee->phone) ? $warranty_recognizee->phone : "$policy->phone" }}</p>
								<p><span class="name">证件号码</span><i>:</i>{{isset($warranty_recognizee->code) ? $warranty_recognizee->phone : "$policy->code" }}</p>
								<p><span class="name">邮箱</span><i>:</i>{{isset($warranty_recognizee->email) ? $warranty_recognizee->phone : "$policy->email" }}</p>
								<p><span class="name">保费总计</span><i>:</i>30000元</p>
							</div>
						</div>
					</div>
							@endforeach
						@endif
						@if(!empty($beneficiary))
					<div class="info-wrapper">
						<i class="iconfont icon-zhankai"></i>
						<button class="btn btn-info">受益人</button>
						<div class="info-img col-xs-2">
							<img src="{{ asset('/r_backend/v2/img/girl.png')}}" alt="" />
						</div>
						<div class="col-xs-10" style="width: 60%;">
							<p class="info-name">{{isset($beneficiary['name']) ? $beneficiary['name'] : "" }}<span class="color-primary"><i class="iconfont icon-shiming"></i>已实名</span></p>
						</div>
						<div class="info-datails">
							<div class="col-xs-6 col-md-4">
								<p><span class="name">性 别</span><i>:</i></p>
								<p><span class="name">证件类型</span><i>:</i>身份证</p>
								<p><span class="name">渠道</span><i>:</i>{{isset($ditches->name) ? "$ditches->name" : "" }}</p>
								<p><span class="name">购买保障</span><i>:</i>20种</p>
								<p><span class="name">职业类别</span><i>:</i>公司企业一般行政人员</p>
							</div>
							<div class="col-xs-6 col-md-5">
								<p><span class="name">手机号码</span><i>:</i>{{isset($beneficiary->phone) ? $beneficiary->phone : "无" }}</p>
								<p><span class="name">证件号码</span><i>:</i>{{isset($beneficiary->code) ? $beneficiary->code : "无" }}</p>
								<p><span class="name">邮箱</span><i>:</i>{{isset($beneficiary->email) ? $beneficiary->email : "无" }}</p>
								<p><span class="name">保费总计</span><i>:</i>{{$beneficiary->name}}元</p>
							</div>
						</div>
					</div>
						@endif
					<div class="record">操作记录</div>
					<div class="record-list">
						<ul>
							<li>2017-03-02 11:52:50<span>创建订单</span>创建订单成功</li>
							<li>2017-03-02 11:52:50<span>创建订单</span>创建订单成功</li>
							<li>2017-03-02 11:52:50<span>创建订单</span>创建订单成功</li>
							<li>2017-03-02 11:52:50<span>创建订单</span>创建订单成功</li>
						</ul>
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
