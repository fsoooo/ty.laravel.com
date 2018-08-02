@extends('backend_v2.layout.base')
@section('title')@parent 渠道管理 @stop
@section('head-more')
	<link rel="stylesheet" href="{{asset('r_backend/v2/css/channel.css')}}" />
@stop
@section('main')
		<div class="main-wrapper">
			<div class="row">
				<ol class="breadcrumb col-lg-12">
				    <li><a href="#">渠道管理</a><i class="iconfont icon-gengduo"></i></li>
				    <li><a href="#">渠道列表</a><i class="iconfont icon-gengduo"></i></li>
				    <li class="active">销售记录</li>
				</ol>
			</div>
			<div class="row">
				<div class="section section-5">
					<div class="col-lg-3 col-xs-6">
						<a href="{{url('/backend/sell/ditch_agent/channel_details?id='.$id)}}" class="section-item">渠道详情 </a>
					</div>
					<div class="col-lg-3 col-xs-6">
						<a href="{{url('/backend/sell/ditch_agent/channel_record?id='.$id)}}" class="section-item active">销售记录 </a>
					</div>
					<div class="col-lg-3 col-xs-6">
						<a href="{{url('/backend/sell/ditch_agent/channel_agent?id='.$id)}}" class="section-item">渠道代理人 </a>
					</div>
					<div class="col-lg-3 col-xs-6">
						<a href="{{url('/backend/sell/ditch_agent/channel_active?id='.$id)}}" class="section-item">活跃产品 </a>
					</div>
					<div class="col-lg-3 col-xs-6">
						<a href="{{url('/backend/task?ditch='.$id)}}" class="section-item">渠道任务</a>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12 select-wrapper radius">
					<form role="form" class="form-inline radius">
					{{--<form action="{{url('/backend/sell/ditch_agent/add_channel/')}}" method="get" role="form" class="form-inline radius">--}}
						<div class="form-group">
							<div class="select-item">
									<label for="name">选择时间:</label>
									<div class="input-group date form_date">
										<input id="up_date" class="form-control up_date" type="text" value="" placeholder="请选择" readonly="">
										<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
									</div>
									<span style="vertical-align: middle;margin-left: 10px;">至</span>
									<div class="input-group date form_date">
										<input id="end_date" class="form-control end_date" type="text" value="" placeholder="请选择" readonly="">
										<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
									</div>
							</div>
							<div class="select-item">
								<label for="name">产品类型:</label>
								<select class="form-control" id="search_type">
									<option value="0" @if(isset($search_type) && $search_type == 0) selected @endif >全部类型</option>
									<option value="1" @if(isset($search_type) && $search_type == 1) selected @endif>个险产品</option>
									<option value="2" @if(isset($search_type) && $search_type == 2) selected @endif>团险产品</option>
								</select>
							</div>
							<div class="select-item">
								<label for="name">产品:</label>
								<select class="form-control" id="search_name">
									<option value="0" selected>全部产品</option>
									@foreach($product as $value)
										<option value="{{$value['id']}}" @if(isset($search_name) && $search_name == $value->id) selected @endif>{{$value['product_name']}}</option>
									@endforeach
								</select>
							</div>
						</div>
					</form>
				</div>
			</div>
			<div class="row">
				<div class="ui-table col-lg-12">
					<div class="ui-table-header radius">
						<span class="col-md-2">投保单号</span>
						<span class="col-md-2">产品名称</span>
						<span class="col-md-1">产品类型</span>
						<span class="col-md-1">保障时间</span>
						<span class="col-md-1">投保人</span>
						<span class="col-md-1">保费</span>
						<span class="col-md-1">渠道佣金</span>
						<span class="col-md-1">代理人</span>
						<span class="col-md-1" style="width: 15%;">代理人佣金</span>
						{{--<span class="col-md-2 col-one" style="width: 10%;">操作</span>--}}
					</div>
					<div class="ui-table-body table-multi-line">
						<ul>
							@foreach($record as $value)
							<li class="ui-table-tr">
								<div class="col-md-2">{{isset($value->warranty->warranty_code)?$value->warranty->warranty_code:""}}</div>
								<div class="col-md-2 ellipsis" title="">{{$value['product']['product_name']}}</div>
								@if(!empty($value['product']['insure_type']))
								<div class="col-md-1">@if($value['product']['insure_type'] == 1)个险产品@else团险产品@endif</div>
								@endif
								<div class="col-md-1" style="margin: 0;">{{isset($value->warranty->start_time)?$value->warranty->start_time:""}}<br>至<br>{{isset($value->warranty->end_time)?$value->warranty->end_time:""}}</div>
								<div class="col-md-1">{{isset($value->policy->name)?$value->policy->name:""}}</div>
								<div class="col-md-1">{{isset($value->warranty->premium) ? ceil($value->warranty->premium/100)."元" : ""}}</div>
								<div class="col-md-1">{{isset($value->brokerage->user_earnings) ? ceil($value->brokerage->user_earnings/100)."元" : ""}}</div>
								<div class="col-md-1">{{isset($value->real_name) ? $value->real_name : ""}}</div>
								<div class="col-md-1">{{isset($value->brokerage->user_earnings) ? ceil($value->brokerage->user_earnings/100)."元" : ""}}</div>
								{{--<div class="col-md-2 text-right" style="margin-top: 10px;"><a href="#" class="btn btn-primary">查看详情</a></div>--}}
							</li>
							@endforeach
						</ul>
					</div>
				</div>
			</div>
			<div class="row text-center">
				{{$record->links()}}
			</div>
			<input hidden value="{{$search_name}}" id="p_name">
			<input hidden value="{{$search_type}}" id="p_type">
			<input hidden value="{{isset($up_date)?$up_date:""}}" id="w_up">
			<input hidden value="{{isset($end_date)?$end_date:""}}" id="w_end">
		</div>
		<input type="text" hidden value="{{$id}}" id="id">
		<script src="{{asset('r_backend/v2/js/lib/jquery-1.11.3.min.js')}}"></script>
		<script src="{{asset('r_backend/v2/js/lib/echarts.js')}}"></script>
		<script src="{{asset('r_backend/v2/js/lib/bootstrap.min.js')}}"></script>
		<script src="{{asset('r_backend/v2/js/common_backend.js')}}"></script>
		<script src="{{asset('r_backend/v2/js/lib/bootstrap-datetimepicker.min.js')}}"></script>
		<script src="{{asset('r_backend/v2/js/lib/bootstrap-datetimepicker.zh-CN.js')}}"></script>

		<script>
			$('.form_date').datetimepicker({
		        language:  'zh-CN',
		        format: 'yyyy-m-d',
		        todayBtn:  1,
				autoclose: 1,
				todayHighlight: true,
				minView: 2,
				endDate: new Date()
		    }).on('changeDate',function(){
		    	console.log($('#date').val());
		    });

			$("#search_type").change(function(){
				var id = $("#id").val();
				var search_type = $("#search_type").val();
				var p_name = $("#p_name").val();
				var w_up = $("#w_up").val();
				var w_end = $("#w_end").val();

				window.location.href="/backend/sell/ditch_agent/channel_record?id="+id+"&search_type="+search_type+"&search_name="+p_name+"&w_up="+w_up+"&w_end="+w_end;
			})

			$("#search_name").change(function(){
				var id = $("#id").val();
				var search_name = $("#search_name").val();
				var p_type = $("#p_type").val();
				var w_up = $("#w_up").val();
				var w_end = $("#w_end").val();
				window.location.href="/backend/sell/ditch_agent/channel_record?id="+id+"&search_name="+search_name+"&search_type="+p_type+"&w_up="+w_up+"&w_end="+w_end;
			})

//			$(".form-control").change(function(){
//				var id = $("#id").val();
////				var p_name = $("#p_name").val();
////				var p_type = $("#p_type").val();
//				var up_date = $("#up_date").val();
//				var end_date = $("#end_date").val();
//				window.location.href="/backend/sell/ditch_agent/channel_record?id="+id+"&up_date="+up_date+"&end_date="+end_date;
//			})

			$(".up_date").change(function(){
				var id = $("#id").val();
				var up_date = $("#up_date").val();

				var w_end = $("#w_end").val();
				var p_name = $("#p_name").val();
				var p_type = $("#p_type").val();

				window.location.href="/backend/sell/ditch_agent/channel_record?id="+id+"&up_date="+up_date+"&end_date="+w_end+"&p_name="+p_name+"&p_type="+p_type;

			})

			$(".end_date").change(function(){
				var id = $("#id").val();
				var end_date = $("#end_date").val();

				var w_up = $("#w_up").val();
				var p_name = $("#p_name").val();
				var p_type = $("#p_type").val();

				window.location.href="/backend/sell/ditch_agent/channel_record?id="+id+"&up_date="+w_up+"&end_date="+end_date+"&p_name="+p_name+"&p_type="+p_type;
			})



		</script>
@stop