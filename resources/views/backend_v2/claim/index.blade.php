@extends('backend_v2.layout.base')
@section('title')@parent 保单管理 @stop
@section('head-more')
	<link rel="stylesheet" href="{{asset('r_backend/v2/css/claim.css')}}" />
@stop
@section('top_menu')

@stop
@section('main')
		<div id="product" class="main-wrapper">
			<div class="row">
				<div class="select-wrapper radius">
					<form role="form" class="form-inline radius">
						<div class="form-group">
							<div class="select-item">
								<label for="name">理赔状态:</label>
								<select class="form-control">
									<option>全部状态</option>
									<option>状态1</option>
									<option>状态2</option>
								</select>
							</div>
						</div>
					</form>
				</div>
			</div>
			<div class="row">
				<div class="ui-table">
					<div class="ui-table-header radius">
						<span class="col-md-2">理赔发起时间</span>
						<span class="col-md-1">案件号</span>
						<span class="col-md-2">保单号</span>
						<span class="col-md-2">被保人</span>
						<span class="col-md-2">产品名称</span>
						<span class="col-md-1">理赔状态</span>
						<span class="col-md-2 col-one">操作</span>
					</div>
					<div class="ui-table-body">
						<ul>
							<li class="ui-table-tr">
								<div class="col-md-2">2017-09-04</div>
								<div class="col-md-1">0214</div>
								<div class="col-md-2">45879654122142</div>
								<div class="col-md-2">手冢治虫</div>
								<div class="col-md-2">人身意外险</div>
								<div class="col-md-1">待处理</div>
								<div class="col-md-2 text-right">
									<a href="/backend/claim/claimDetails" class="btn btn-primary">查看详情</a>
								</div>
							</li>
							<li class="ui-table-tr">
								<div class="col-md-2">2017-09-04</div>
								<div class="col-md-1">0214</div>
								<div class="col-md-2">45879654122142</div>
								<div class="col-md-2">手冢治虫</div>
								<div class="col-md-2">人身意外险</div>
								<div class="col-md-1 color-default">处理中</div>
								<div class="col-md-2 text-right">
									<a href="/backend/claim/claimDetails" class="btn btn-primary">查看详情</a>
								</div>
							</li>
							<li class="ui-table-tr">
								<div class="col-md-2">2017-09-04</div>
								<div class="col-md-1">0214</div>
								<div class="col-md-2">45879654122142</div>
								<div class="col-md-2">手冢治虫</div>
								<div class="col-md-2">人身意外险</div>
								<div class="col-md-1 color-primary">已处理</div>
								<div class="col-md-2 text-right">
									<a href="/backend/claim/claimDetails" class="btn btn-primary">查看详情</a>
								</div>
							</li>
						</ul>
					</div>
				</div>
			</div>
			
			<div class="row text-center">
				<ul class="pagination">
	                <li class="disabled"><span>«</span></li>
	                <li class="active"><span>1</span></li>
	                <li><a>2</a></li>
	                <li><a>3</a></li>
	        		<li><a rel="next">»</a></li>
	        	</ul>
			</div>
		</div>


		{{--<script src="js/lib/jquery-1.11.3.min.js"></script>--}}
		{{--<script src="js/lib/bootstrap.min.js"></script>--}}
		{{--<script src="js/common_backend.js"></script>--}}
@stop