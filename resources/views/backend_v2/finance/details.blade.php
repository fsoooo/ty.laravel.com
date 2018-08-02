@extends('backend_v2.layout.base')
@section('title')@parent 财务中心 @stop
@section('head-more')
	<link rel="stylesheet" href="{{asset('r_backend/v2/css/finance.css')}}" />
	<link rel="stylesheet" href="{{asset('r_backend/v2/css/lib/iconfont.css')}}" />
@stop
@section('main')
		<div class="main-wrapper">
			<div class="row">
				<ol class="breadcrumb col-lg-12">
				    <li><a href="/backend/finance">财务中心</a><i class="iconfont icon-gengduo"></i></li>
                    @if($status == 1)
				    <li class="active">应收详情</li>
                    @else
					<li class="active">应付详情</li>
                    @endif
				</ol>
			</div>
			<div class="row" style="margin-bottom: 10px;">
				<div class="col-md-6">
					<div class="policy-content">
						<div class="policy-wrapper scroll-pane">
							<div class="policy-info">
								<h3 class="title">{{$order_list['product']['product_name']}}（{{$order_list['product']['insure_type'] == 1 ? '个险' : '团险'}}）</h3>
								<p>订单号：{{$order_list['order_code']}}<a href="/backend/order/personal_details?id={{$order_list['id']}}">查看</a></p>
								<p>保单号：{{$order_list['order_warranty'][0]['warranty_code']}}<a href="/backend/customer/individual/warranty/{{$order_list['order_warranty'][0]['id']}}">查看</a></p>
							</div>
							<div class="policy-list">
								<div><span class="name">公司名称</span><i>:</i>{{$order_list['product']['company_name']}}</div>
								<div><span class="name">保险险种</span><i>:</i>{{json_decode($order_list['product']['json'],true)['category']['name']}}</div>
								<div><span class="name vtop">条款</span><i class="vtop">:</i>
									<ul class="duty-list">
										@foreach(json_decode($order_list['product']['clauses'],true) as $clauses)
										<li><a href="{{getenv('TY_API_PRODUCT_SERVICE_URL').'/'.$clauses['file_url']}}">{{$clauses['name']}}</a></li>
										@endforeach
									</ul>
								</div>
								<div><span class="name vtop">责任保额</span><i class="vtop">:</i>
									<ul class="duty-list">
										@foreach(json_decode(json_decode($order_list['parameter']['parameter'],true)['protect_item'],true) as $value)
										<li><span class="duty-name">{{$value['name']}}</span>{{$value['defaultValue']}}</li>
										@endforeach
									</ul>
								</div>
								<div><span class="name">特别约定</span><i>:</i>{{$order_list['product']['personal']}}</div>
								<div><span class="name">受益人</span><i>:</i>法定受益人</div>
								<div><span class="name">保 费</span><i>:</i>{{number_format($order_list['premium']/100, 2)}}元</div>
								<div><span class="name">缴费方式</span><i>:</i>{{mb_substr($order_list['by_stages_way'],mb_strlen($order_list['by_stages_way'])-1,mb_strlen($order_list['by_stages_way']))}}缴</div>
								<div><span class="name">缴费期限</span><i>:</i>{{$order_list['by_stages_way']}}</div>
								<div><span class="name">佣金</span><i>:</i>{{number_format($order_list['companyBrokerage']['brokerage']/100, 2)}}元</div>
								<div><span class="name">渠道</span><i>:</i>{{$order_list['order_ditch']['name']}}</div>
								{{--<div><span class="name">渠道佣金</span><i>:</i>200元</div>--}}
								<div><span class="name">代理人</span><i>:</i>{{$order_list['order_agent']['user']['name']}}</div>
								<div><span class="name">代理人佣金</span><i>:</i>{{number_format($order_list['order_brokerage']['user_earnings']/100, 2)}}元</div>
								<div><span class="name">保单状态</span><i>:</i><span class="color-default">@if($order_list['order_warranty'][0]['status'] == 0)待生效@elseif($order_list['order_warranty'][0]['status'] == 1)保障中@elseif($order_list['order_warranty'][0]['status'] == 2)失效@elseif($order_list['order_warranty'][0]['status'] == 3)退保@endif</span></div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="record">操作记录</div>
					<div class="table-record">
						<table>
							<tr>
								<th width="40%">时间</th>
								<th width="34%">业务类型</th>
								<th width="25%">金额</th>
							</tr>
						</table>
						<div class="scroll-pane" style="height: 550px;">
							<table>
								<tr>
									<td width="40%">{{$order_list['created_at']}}</td>
									<td width="34%">生成订单</td>
									<td width="25%">成功</td>
								</tr>
                                <tr>
                                    <td width="40%">{{$order_list['order_warranty'][0]['created_at']}}</td>
                                    <td width="34%">生成保单</td>
                                    <td width="25%">成功</td>
                                </tr>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>

		<script>
			$(function(){
				$('.table-record').each(function(){
					var a = $(this).find('.jspContainer').width();
					var b = $(this).find('.jspPane').width();
					if(a !== b)$(this).addClass('scroll');
				});
			});
		</script>
@stop
