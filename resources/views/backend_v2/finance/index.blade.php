@extends('backend_v2.layout.base')
@section('title')@parent 财务中心 @stop
@section('head-more')
	<link rel="stylesheet" href="{{asset('r_backend/v2/css/finance.css')}}" />
	<link rel="stylesheet" href="{{asset('r_backend/v2/css/lib/iconfont.css')}}" />
@section('main')
		<div class="main-wrapper">
			<div class="row income">
				<div class="col-md-6">
					<div class="default-div left">
						<div class="fl">
							<p><span class="price">{{$today_finance['amount']['commission_net_income']}}</span>元</p>
							<p>本日佣金净收益</p>
						</div>
						<div class="fr">
							<p><span class="price">{{$today_finance['amount']['insurance_net_income']}}</span>元</p>
							<p>本日保费净收益</p>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="default-div right">
						<select id="selectDate" class="form-control">
							<option data-id="1">{{$first_month_finance['month']}}</option>
							<option data-id="2">{{$second_month_finance['month']}}</option>
							<option data-id="3">{{$third_month_finance['month']}}</option>
						</select>
						<div class="fl">
							<p><span class="price">{{$first_month_finance['commission_net_income']}}</span>元</p>
							<p class="hide"><span class="price">{{$second_month_finance['commission_net_income']}}</span>元</p>
							<p class="hide"><span class="price">{{$third_month_finance['commission_net_income']}}</span>元</p>
							<div>本月佣金净收益</div>
						</div>
						<div class="fr">
							<p><span class="price">{{$first_month_finance['insurance_net_income']}}</span>元</p>
							<p class="hide"><span class="price">{{$second_month_finance['insurance_net_income']}}</span>元</p>
							<p class="hide"><span class="price">{{$third_month_finance['insurance_net_income']}}</span>元</p>
							<div>本月保费净收益</div>
						</div>
					</div>
				</div>

			</div>
			<div class="row expenses">
				<div class="col-md-6">
					<div class="default-div left">
						<div class="select-content">
							<div class="select-item">
								<div class="today">今日应收：<span class="price">{{$today_finance['amount']['insurance_revenue']}}</span>元</div>
							</div>
							<div class="select-item" style="display: none;">
								<div class="today">今日应收：<span class="price">{{$today_finance['amount']['commission_revenue']}}</span>元</div>
							</div>
						</div>
						<div class="select-header">
							<p class="select-item active">保费</p>
							<p class="select-item">佣金</p>
						</div>
					</div>

					<div class="select-content select-tab">
						<div class="select-item table-record">
							<table>
								<tr>
									<th width="33%">时间</th>
									<th width="33%">案件号</th>
									<th width="17%">业务类型</th>
									<th width="17%">金额</th>
								</tr>
							</table>
							<div class="scroll-pane" style="height: 280px;">
								<table>
									@foreach($today_finance['order_list'] as $value)
									<tr onclick="location.href='/backend/finance/details?id={{$value['id']}}&status=1'">
									{{--<tr onclick="location.href='html/finance/finance_details.html'">--}}
										<td width="33%">{{$value['time']}}</td>
										<td width="33%">{{$value['code']}}</td>
										<td width="17%">投保</td>
										<td width="17%">+{{$value['premium']}}</td>
									</tr>
									@endforeach
								</table>
							</div>

						</div>
						<div class="select-item table-record" style="visibility: hidden;">
							<table>
								<tr>
									<th width="33%">时间</th>
									<th width="33%">案件号</th>
									<th width="17%">业务类型</th>
									<th width="17%">金额</th>
								</tr>
							</table>
							<div class="scroll-pane" style="height: 280px;">
								<table>
									@foreach($today_finance['company_brokerage_list'] as $value)
									<tr onclick="location.href='/backend/finance/details?id={{$value['id']}}&status=1'">
										<td width="33%">{{$value['time']}}</td>
										<td width="33%">{{$value['code']}}</td>
										<td width="17%">投保</td>
										<td width="17%">+{{$value['premium']}}</td>
									</tr>
									@endforeach
								</table>
							</div>
						</div>
					</div>
				</div>


				<div class="col-md-6">
					<div class="default-div right">
						<div class="select-content">
							<div class="select-item">
								<div class="today">今日应付：<span class="price">{{$today_finance['amount']['insurance_disbursement']}}</span>元</div>
							</div>
							<div class="select-item" style="display: none;">
								<div class="today">今日应付：<span class="price">{{$today_finance['amount']['commission_disbursement']}}</span>元</div>
							</div>
						</div>
						<div class="select-header">
							<p class="select-item active">保费</p>
							<p class="select-item">佣金</p>
						</div>
					</div>

					<div class="select-content select-tab">
						<div class="select-item table-record">
							<table>
								<tr>
									<th width="33%">时间</th>
									<th width="33%">案件号</th>
									<th width="17%">业务类型</th>
									<th width="17%">金额</th>
								</tr>
							</table>
							<div class="scroll-pane" style="height: 280px;">
								<table>
									@foreach($today_finance['warranty_list'] as $value)
									<tr onclick="location.href='/backend/finance/details?id={{$value['id']}}&status=2'">
										<td width="33%">{{$value['time']}}</td>
										<td width="33%">{{$value['code']}}</td>
										<td width="17%">退保</td>
										<td width="17%">-{{$value['premium']}}</td>
									</tr>
									@endforeach
								</table>
							</div>
						</div>
						<div class="select-item table-record">
							<table>
								<tr>
									<th width="33%">时间</th>
									<th width="33%">案件号</th>
									<th width="17%">业务类型</th>
									<th width="17%">金额</th>
								</tr>
							</table>
							<div class="scroll-pane" style="height: 280px;">
								<table>
									@foreach($today_finance['order_brokerage_list'] as $value)
									<tr onclick="location.href='/backend/finance/details?id={{$value['id']}}&status=2'">
										<td width="33%">{{$value['time']}}</td>
										<td width="33%">{{$value['code']}}</td>
										<td width="17%">代理人佣金</td>
										<td width="17%">-{{$value['premium']}}</td>
									</tr>
									@endforeach
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<script src="{{asset('r_backend/v2/js/lib/jquery-1.11.3.min.js')}}"></script>
		<script src="{{asset('r_backend/v2/js/lib/bootstrap.min.js')}}"></script>
		<script src="{{asset('r_backend/v2/js/lib/jquery.jscrollpane.min.js')}}"></script>
		<script src="{{asset('r_backend/v2/js/common_backend.js')}}"></script>

		<script>
			$(function(){
				$('.table-record').each(function(){
					var a = $(this).find('.jspContainer').width();
					var b = $(this).find('.jspPane').width();
					if(a !== b)$(this).addClass('scroll');
				});

                new TabControl('.expenses .left',function(obj){
                    callback(obj)
                })
                new TabControl('.expenses .right',function(obj){
                    callback(obj)
                });
                function callback(obj){
                    var ele = obj.ele;
                    var index = obj.index;
                    ele.next().find('.select-item').eq(index).css('visibility','visible').siblings().css('visibility','hidden');
                }

                $('#selectDate').change(function(){
                    var index = $(this).find('option:checked').data('id');
                    var items = $(this).nextAll();
                    items.each(function(){
                        var price = $(this).find('p');
                        price.eq(index-1).removeClass('hide').siblings('p').addClass('hide');
                    })
                })

            });
		</script>
@stop