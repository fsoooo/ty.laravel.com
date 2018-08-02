@extends('backend_v2.layout.base')
@section('title')@parent产品管理 @stop
@section('head-more')
	<link rel="stylesheet" href="{{asset('r_backend/v2/css/product.css')}}" />
@stop
@section('top_menu')
	@include('backend_v2.product.product_top')
@stop
@section('main')
		<div class="main-wrapper">
			<div class="row">
				<ol class="breadcrumb col-lg-12">
					<li><a href="/backend/product/product_list">产品管理</a><i class="iconfont icon-gengduo"></i></li>
					<li><a href="/backend/product/product_list">在售产品</a><i class="iconfont icon-gengduo"></i></li>
					<li class="active">{{$product_res['product_name']}}<i class="iconfont icon-gengduo"></i></li>
					<li class="active">销售统计</li>
				</ol>
			</div>
			@include('backend_v2.product.product_middle')
			<div class="row">
				<div class="col-lg-12 select-wrapper ">
					<form role="form" class="form-inline radius">
						<div class="form-group">
							<div class="select-item">
								<label for="name">选择时间:</label>
				                <div class="input-group date form_date">
									@if(isset($_GET['keyword']))
										<input id="date_start" class="form-control" type="text" value="{{explode('--',$_GET['keyword'])[0]}}" placeholder="请选择" readonly="">
									@else
										<input id="date_start" class="form-control" type="text" placeholder="请选择" readonly="" value="{{date('Y-m-d',time())}}">
									@endif
									<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
				                </div>
				                <span style="vertical-align: middle;margin-left: 10px;">至</span>
				                <div class="input-group date form_date">
									@if(isset($_GET['keyword']))
				                    <input id="date_end" class="form-control" type="text" value="{{explode('--',$_GET['keyword'])[1]}}" placeholder="请选择" readonly="">
									@else
				                    <input id="date_end" class="form-control" type="text" value="" placeholder="请选择" readonly="">
									@endif
									<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
				                </div>
							</div>
						</div>
					</form>
				</div>
			</div>
			<div class="row">
				<div class="ui-table col-lg-12">
					<div class="ui-table-header radius">
						<span class="col-md-2">投保单号</span>
						<span class="col-md-2">保障时间</span>
						<span class="col-md-1">投保人</span>
						<span class="col-md-1">保费</span>
						<span class="col-md-1">渠道佣金</span>
						<span class="col-md-1">代理人</span>
						<span class="col-md-2">代理人佣金</span>
						<span class="col-md-2 col-one">操作</span>
					</div>
					<div class="ui-table-body table-multi-line">
						<ul>
							@if(count($product_sale_res) == 0 )
								<li class="ui-table-tr">
									<div class="col-md-2"></div>
									<div class="col-md-2" style="margin: 0;">暂无产品销售记录</div>
								</li>
							@else
								@foreach($product_sale_res as $value)
									<li class="ui-table-tr">
										<div class="col-md-2">{{isset($value['warranty']['warranty_code'])?$value['warranty']['warranty_code'] : '出单中'}}</div>
										<div class="col-md-2" style="margin: 0;">{{isset($value['warranty']['start_time']) ? $value['warranty']['start_time'] : ''}}<br>至<br>{{isset($value['warranty']['end_time']) ? $value['warranty']['end_time'] : ''}}</div>
										<div class="col-md-1">{{isset($value['policy']['name'])? $value['policy']['name'] : ''}}</div>
										<div class="col-md-1">{{isset($value['warranty']['premium']) ? $value['warranty']['premium'] : '0'}}</div>
										<div class="col-md-1">{{isset($value['brokerage']['user_earnings'])? $value['brokerage']['user_earnings'] : '0'}}</div>
										<div class="col-md-1">{{isset($value['real_name'])? $value['real_name'] : ''}}</div>
										<div class="col-md-2">{{isset($value['brokerage']['user_earnings']) ? $value['brokerage']['user_earnings'] : '0'}}</div>
										<div class="col-md-2 text-right" style="margin-top: 10px;"><a href="/backend/product/product_details_on/{{$product_res['id']}}" class="btn btn-primary">查看详情</a></div>
									</li>
								@endforeach
							@endif
						</ul>
					</div>
				</div>
			</div>
		</div>
		<script src="{{asset('r_backend/v2/js/lib/jquery-1.11.3.min.js')}}"></script>
		<script src="{{asset('r_backend/v2/js/common_backend.js')}}"></script>
		<script src="{{asset('r_backend/v2/js/lib/bootstrap-datetimepicker.min.js')}}"></script>
		<script src="{{asset('r_backend/v2/js/lib/bootstrap-datetimepicker.zh-CN.js')}}"></script>
		<script>
			var id = "{{$product_res['ty_product_id']}}";
			$('.form_date').datetimepicker({
		        language:  'zh-CN',
		        format: 'yyyy-mm-dd',
		        todayBtn:  1,
				autoclose: 1,
				todayHighlight: true,
				minView: 2,
				endDate: new Date()
		    }).on('changeDate',function(){
		    	console.log('00');
		    	console.log($('#date_start').val());
		    	console.log($('#date_end').val());
		    	if($('#date_start').val()&&$('#date_end').val()){
                    window.location.href = "/backend/product/product_sale_statistics/"+id+"?search_type=ins_dates_form&keyword="+$('#date_start').val()+'--'+$('#date_end').val();
				}
		    });
		</script>
@stop