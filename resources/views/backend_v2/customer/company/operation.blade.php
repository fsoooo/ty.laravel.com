@extends('backend_v2.layout.base')
@section('title')@parent 代理商详情 @stop
@section('head-more')
	<link rel="stylesheet" href="{{asset('r_backend/v2/css/client_details.css')}}" />
@stop

@section('top_menu')
	@include('backend_v2.client.top_client')
@stop
@section('main')
		<div class="main-wrapper">
			<div class="row">
				<ol class="breadcrumb col-lg-12">
				    <li><a href="#">客户管理</a><i class="iconfont icon-gengduo"></i></li>
				    <li><a href="#">个人客户</a><i class="iconfont icon-gengduo"></i></li>
				    <li class="active">田小田</li>
				</ol>
			</div>
			@include('backend_v2.customer.company.nav', ['type' => 'operation'])


			<div class="row">
				<!--操作记录页面显示-->
				<div class="ui-table col-lg-12">
					<div class="ui-table-header radius">
						<span class="col-md-5">操作时间</span>
						<span class="col-md-5">操作内容</span>
						<span class="col-md-2">操作结果</span>
					</div>
					<div class="ui-table-body">
						<ul>
							<li class="ui-table-tr">
								<div class="col-md-5">2017-09-26</div>
								<div class="col-md-5">对订单号<span class="color-default">4251788665441232544125</span>保单进行续费</div>
								<div class="col-md-2">缴费成功</div>
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
                    <li><a>4</a></li>
                    <li><a>5</a></li>
                    <li class="disabled"><span>...</span></li>
                   	<li><a>18</a></li>
                    <li><a>19</a></li>
            		<li><a rel="next">»</a></li>
            	</ul>
			</div>
		</div>
		<script src="../../js/lib/jquery-1.11.3.min.js"></script>
		<script src="../../js/lib/bootstrap.min.js"></script>
		<script src="../../js/common_backend.js"></script>
@stop

