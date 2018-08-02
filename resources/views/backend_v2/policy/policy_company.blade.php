@extends('backend_v2.layout.base')
@section('title')@parent 保单管理 @stop
@section('head-more')
	<link rel="stylesheet" href="{{asset('r_backend/v2/css/agent.css')}}" />
@stop

@section('top_menu')
	<div class="nav-top-wrapper fl">
		<ul>
			<li>
				<a href="{{url('/backend/policy/')}}" >个人保单</a>
			</li>
			<li class="active">
				<a href="{{url('/backend/policy/policy_company/')}}">企业保单</a>
			</li>
			<li>
				<a href="{{url('/backend/policy/policy_offline/')}}">线下保单</a>
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
								<label for="name">保单状态:</label>

								<select class="form-control" id="search_status">
									<option selected value="-1">全部保单</option>
									<option value="1" @if(isset($status_id) && $status_id == 1) selected @endif>保障中</option>
									<option value="2" @if(isset($status_id) && $status_id == 2) selected @endif>失效</option>
									<option value="0" @if(isset($status_id) && $status_id == 0 && $status_id != "") selected @endif>待生效</option>
									<option value="3" @if(isset($status_id) && $status_id == 3) selected @endif>退保</option>
								</select>
							</div>
						</div>
					</form>
				</div>
			</div>
			<div class="row">
				<div class="ui-table table-single-line">
					<div class="ui-table-header radius">
						<span class="col-md-2">保单号</span>
						<span class="col-md-1">保单生成时间</span>
						<span class="col-md-2">保单产品</span>
						<span class="col-md-1">保单状态</span>
						<span class="col-md-1">企业名称</span>
						<span class="col-md-1">联系方式</span>
						<span class="col-md-1">保费</span>
						<span class="col-md-1">佣金</span>
						<span class="col-md-1">代理人</span>

						<span class="col-md-1 col-one">操作</span>
					</div>
					<div class="ui-table-body">
						<ul>
							@foreach($list as $value)
							<li class="ui-table-tr">
								<div class="col-md-2">{{$value->warranty_code}}</div>
								<div class="col-md-1">{{$value->created_at}}</div>
								<div class="col-md-2">{{$value->product_name}}</div>
								<div class="col-md-1 color-default">
									@if($value->status == 1)
										保障中
									@elseif($value->status == 2)
										失效
									@elseif($value->status == 3)
										退保
									@elseif($value->status == 0)
										待生效
									@endif
								</div>
								<div class="col-md-1">{{$value->name}}</div>
								<div class="col-md-1">{{$value->phone}}</div>
								<div class="col-md-1">{{ceil($value->premium/100)}}</div>
								<div class="col-md-1">{{ceil($value->brokerage/100)}}</div>
								<div class="col-md-1">{{$value->agent_name}}</div>

								<div class="col-md-1 text-right">
									<a class="btn btn-primary" href="{{url('backend/policy/policy_company_details?id='.$value->id)}}">查看详情</a>
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
//			var deal_type = $("#deal_type").val();
			window.location.href="/backend/policy/policy_company?id="+id;
		})
	})
</script>
@stop