@extends('backend_v2.layout.base')
@section('title')@parent 订单管理 @stop
@section('head-more')
	<link rel="stylesheet" href="{{asset('r_backend/v2/css/agent.css')}}" />
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
	<script src="{{asset('r_backend/v2/js/lib/jquery-1.11.3.min.js')}}"></script>
		<div id="product" class="main-wrapper">
			<div class="row">
				<div class="select-wrapper radius">
					<form role="form" class="form-inline radius">
						<div class="form-group">
							<div class="select-item">
								<label for="name">订单状态:</label>
								<select class="form-control" id="search_status">
									<option value="0">全部订单</option>
									<option value="1" @if(isset($status_id) && $status_id == 1) selected @endif>已支付</option>
									<option value="2" @if(isset($status_id) && $status_id == 2) selected @endif>未支付</option>
									<option value="3" @if(isset($status_id) && $status_id == 3) selected @endif>支付失败</option>
									<option value="4" @if(isset($status_id) && $status_id == 4) selected @endif>支付中</option>
									<option value="6" @if(isset($status_id) && $status_id == 6) selected @endif>核保错误</option>
									<option value="7" @if(isset($status_id) && $status_id == 7) selected @endif>取消支付</option>
								</select>
							</div>
						</div>
					</form>
				</div>
			</div>
			<div class="row">
				<div class="ui-table table-single-line">
					<div class="ui-table-header radius">
						<span class="col-md-1">订单号</span>
						<span class="col-md-2">订单产品</span>
						<span class="col-md-2">订单生成时间</span>
						<span class="col-md-1">公司名称</span>
						<span class="col-md-1">联系方式</span>
						<span class="col-md-1">保费</span>
						<span class="col-md-1">代理人</span>
						<span class="col-md-1">订单状态</span>
						<span class="col-md-2 col-one">操作</span>
					</div>
					<div class="ui-table-body">
						<ul>
							@foreach($list as $value)
							<li class="ui-table-tr">
								<div class="col-md-1">{{$value->order_code}}</div>
								<div class="col-md-2">{{$value->product_name}}</div>
								<div class="col-md-2">{{$value->created_at}}</div>
								<div class="col-md-1">{{$value->real_name}}</div>
								<div class="col-md-1">{{$value->phone}}</div>
								<div class="col-md-1">{{ceil($value->premium/100)}}</div>
								<div class="col-md-1">{{$value->name}}</div>
								<div class="col-md-1 color-default">
									@if($value->status == 1)
										已支付
									@elseif($value->status == 2)
										未支付
									@elseif($value->status == 3)
										支付失败
									@elseif($value->status == 4)
										支付中
									@elseif($value->status == 6)
										核保错误
									@elseif($value->status == 7)
										取消支付
									@endif

								</div>
								<div class="col-md-2 text-right">
									<a class="btn btn-primary" href="{{url('/backend/order/order_company_details?id='.$value->id)}}">查看详情</a>
								</div>
							</li>

							@endforeach

						</ul>
					</div>
				</div>
			</div>

			<div class="row text-center">
				{{ $list->appends(['id' => $status_id])->links() }}
			</div>
		</div>
<script>
	$(function(){
		$("#search_status").change(function(){
			var id = $("#search_status").val();
			window.location.href="/backend/order/enterprise?id="+id;
		})
	})
</script>
@stop