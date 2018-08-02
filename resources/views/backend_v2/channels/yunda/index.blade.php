@extends('backend_v2.layout.base')
@section('title')@parent产品管理 @stop
@section('head-more')
	<link rel="stylesheet" href="{{asset('r_backend/v2/css/client_details.css')}}" />
@stop
@section('top_menu')
@stop
@section('main')
		<div class="main-wrapper">
			<!--个人客户页面显示-->
			<div class="row">
				<div class="ui-table col-lg-12">
					<div class="ui-table-header radius">
						<span class="col-md-1">客户姓名</span>
						<span class="col-md-1">证件类型</span>
						<span class="col-md-2">证件号</span>
						<span class="col-md-1">联系方式</span>
						<span class="col-md-1">投保次数</span>
						<span class="col-md-1">被保次数</span>
						<span class="col-md-1">产生保额</span>
						<span class="col-md-1">产生佣金</span>
						<span class="col-md-1">代理人</span>
						<span class="col-md-2 col-one">操作</span>
					</div>
					<div class="ui-table-body">
						<ul>
							<li class="ui-table-tr">
								<div class="col-md-1">欧阳铁蛋</div>
								<div class="col-md-1">身份证</div>
								<div class="col-md-2">120545199514254561</div>
								<div class="col-md-1">13911195490</div>
								<div class="col-md-1">3</div>
								<div class="col-md-1">3</div>
								<div class="col-md-1">458</div>
								<div class="col-md-1">2500</div>
								<div class="col-md-1">李木易杨</div>
								<div class="col-md-2 text-right"><a href="html/client/client2_info.html" class="btn btn-primary">查看详情</a></div>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<!--企业客户页面显示-->
			<div class="row">
				<div class="ui-table col-lg-12">
					<div class="ui-table-header radius">
						<span class="col-md-2">企业名称</span>
						<span class="col-md-2">企业类型</span>
						<span class="col-md-1">联系人姓名</span>
						<span class="col-md-2">联系方式</span>
						<span class="col-md-1">投保次数</span>
						<span class="col-md-1">产生保额</span>
						<span class="col-md-1">产生佣金</span>
						<span class="col-md-2 col-one">操作</span>
					</div>
					<div class="ui-table-body">
						<ul>
							<li class="ui-table-tr">
								<div class="col-md-2 ellipsis" title="北京天眼互联科技有限公司">北京天眼互联科技有限公司…</div>
								<div class="col-md-2">互联网-软件</div>
								<div class="col-md-1">上官上官</div>
								<div class="col-md-2">13911195490</div>
								<div class="col-md-1">3</div>
								<div class="col-md-1">458</div>
								<div class="col-md-1">2500</div>
								<div class="col-md-2 text-right"><a href="html/client/client2_info.html" class="btn btn-primary">查看详情</a></div>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<!--组织团体页面显示-->
			<div class="row">
				<div class="ui-table col-lg-12">
					<div class="ui-table-header radius">
						<span class="col-md-2">用户名称</span>
						<span class="col-md-2">类型</span>
						<span class="col-md-1">联系姓名</span>
						<span class="col-md-2">联系电话</span>
						<span class="col-md-1">投保次数</span>
						<span class="col-md-1">产生保额</span>
						<span class="col-md-1">产生佣金</span>
						<span class="col-md-2 col-one">操作</span>
					</div>
					<div class="ui-table-body">
						<ul>
							<li class="ui-table-tr">
								<div class="col-md-2">富瑞苑足球队…</div>
								<div class="col-md-2">社会团体</div>
								<div class="col-md-1">上官铁柱</div>
								<div class="col-md-2">13911195490</div>
								<div class="col-md-1">3</div>
								<div class="col-md-1">458</div>
								<div class="col-md-1">2500</div>
								<div class="col-md-2 text-right"><a href="html/client/client2_info.html" class="btn btn-primary">查看详情</a></div>
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
		<script src="{{asset('r_backend/v2/js/lib/jquery-1.11.3.min.js')}}"></script>
		<script src="{{asset('r_backend/v2/js/lib/bootstrap.min.js')}}"></script>
		<script src="{{asset('r_backend/v2/js/common_backend.js')}}"></script>
	@include('backend_v2.layout.alert')
	@stop