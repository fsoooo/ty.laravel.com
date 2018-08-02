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
			<div class="row">
				<div class="section">
					 <div class="col-md-4 col-xs-6">
					 	<!--个人客户页面显示-->
					 	<a href="{{url('backend/user_management/customer_details')}}" class="section-item">个人信息</a>
					 	
					 	<!--企业客户页面显示-->
					 	<!--<a href="client2_info.html" class="section-item">企业信息</a>-->
					 	
					 	<!--组织团体页面显示-->
					 	<!--<a href="client2_info.html" class="section-item">团体信息</a>-->
				    </div>
				    <div class="col-md-4 col-xs-6">
				    	<a href="{{url('backend/user_management/insurance_record')}}" class="section-item active">保险记录</a>
				    </div>
				    <div class="col-md-4 col-xs-6">
				    	<a href="#" class="section-item">操作记录</a>
				    </div>
				</div>
			</div>
			
			<div class="row">
				
				<!--个人客户显示-->
				<div class="ui-table col-lg-12">
					<div class="ui-table-header radius">
						<span class="col-md-1">购买时间</span>
						<span class="col-md-2">保单号</span>
						<span class="col-md-1">产品名称</span>
						<span class="col-md-1">险种</span>
						<span class="col-md-1">公司</span>
						<span class="col-md-1">投保人</span>
						<span class="col-md-1">保费(元)</span>
						<span class="col-md-1">佣金(元)</span>
						<span class="col-md-1">代理人</span>
						<span class="col-md-2 col-one">操作</span>
					</div>
					<div class="ui-table-body">
						<ul>
							<li class="ui-table-tr">
								<div class="col-md-1">2017-09-26</div>
								<div class="col-md-2">2145784145236584</div>
								<div class="col-md-1">测试产品一</div>
								<div class="col-md-1">意外险</div>
								<div class="col-md-1">中国人寿</div>
								<div class="col-md-1">王大力</div>
								<div class="col-md-1">8000</div>
								<div class="col-md-1">2000</div>
								<div class="col-md-1">迪丽热巴</div>
								<div class="col-md-2 text-right"><a href="agent2_plan_details.html" class="btn btn-primary">查看详情</a></div>
							</li>
						</ul>
					</div>
				</div>
				
				<!--企业客户/组织团体显示-->
				<div class="ui-table col-lg-12">
					<div class="ui-table-header radius">
						<span class="col-md-2">保单号</span>
						<span class="col-md-1">产品名称</span>
						<span class="col-md-1">公司</span>
						<span class="col-md-1">缴费方式</span>
						<span class="col-md-1">被保人</span>
						<span class="col-md-1">保费(元)</span>
						<span class="col-md-1">佣金总额(元)</span>
						<span class="col-md-1" style="width: 10%;">代理人佣金(元)</span>
						<span class="col-md-1">代理人</span>
						<span class="col-md-2 col-one" style="width: 15%;">操作</span>
					</div>
					<div class="ui-table-body">
						<ul>
							<li class="ui-table-tr">
								<div class="col-md-2">2145784145236584</div>
								<div class="col-md-1">测试产品一</div>
								<div class="col-md-1">中国人寿</div>
								<div class="col-md-1">年缴</div>
								<div class="col-md-1">见详情</div>
								<div class="col-md-1">8000</div>
								<div class="col-md-1">2000</div>
								<div class="col-md-1" style="width: 10%;">2000</div>
								<div class="col-md-1">迪丽热巴</div>
								<div class="col-md-2 text-right" style="width: 15%;"><a href="agent2_plan_details.html" class="btn btn-primary">查看详情</a></div>
							</li>
						</ul>
					</div>
				</div>
				
				
				
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

