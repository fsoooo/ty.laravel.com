@extends('backend_v2.layout.base')
@section('title')@parent 代理商详情 @stop
@section('head-more')
	<link rel="stylesheet" href="{{asset('r_backend/v2/css/client.css')}}" />
@stop

@section('top_menu')
	@include('backend_v2.client.top_client')
	<div class="search-wrapper fl">
		<select class="form-control">
			<option>姓名</option>
			<option>2016年</option>
			<option>2015年</option>
			<option>2014年</option>
			<option>2013年</option>
		</select>
		<input />
		<button class="btn btn-primary"><i class="iconfont icon-sousuo"></i></button>
	</div>
@stop

@section('main')
		<div id="agent" class="main-wrapper">
			<div class="row">
				<ol class="breadcrumb col-lg-12">
				    <li><a href="#">客户管理</a><i class="iconfont icon-gengduo"></i></li>
				    <li><a href="#">个人客户</a><i class="iconfont icon-gengduo"></i></li>
				    <li><a href="#">田小田</a><i class="iconfont icon-gengduo"></i></li>
				    <li class="active">分配代理人</li>
				</ol>
			</div>
			
			<div class="row">
				<div class="ui-table">
					<div class="ui-table-header radius">
						<span class="col-md-1">工号</span>
						<span class="col-md-1">姓名</span>
						<span class="col-md-2">
							<select class="form-control">
								<option>所有渠道</option>
								<option>2016年</option>
								<option>2015年</option>
								<option>2014年</option>
								<option>2013年</option>
							</select>
						</span>
						<span class="col-md-2">实名状态</span>
						<span class="col-md-3">客户人数</span>
						<span class="col-md-3 col-one">操作</span>
					</div>
					<div class="ui-table-body">
						<ul>
							<li class="ui-table-tr">
								<div class="col-md-1">1804</div>
								<div class="col-md-1 color-default">欧阳铁蛋</div>
								<div class="col-md-2">东城渠道</div>
								<div class="col-md-2 color-primary"><i class="iconfont icon-shiming"></i>已实名</div>
								<div class="col-md-3 color-default">42</div>
								<div class="col-md-3 text-right">
									<button class="btn btn-primary">选择</button>
								</div>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
@stop