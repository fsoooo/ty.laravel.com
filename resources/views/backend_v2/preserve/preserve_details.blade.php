@extends('backend_v2.layout.base')
@section('title')@parent 保单管理 @stop
@section('head-more')
	<link rel="stylesheet" href="{{asset('r_backend/v2/css/claim.css')}}" />
@stop
@section('top_menu')

@stop
@section('main')
		<div class="main-wrapper">
			<div class="row">
				<ol class="breadcrumb col-lg-12">
				    <li><a href="#">保全管理</a><i class="iconfont icon-gengduo"></i></li>
				    <li><a href="#">个人保全</a><i class="iconfont icon-gengduo"></i></li>
				    <li class="active">保全详情</li>
				</ol>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<div class="title">保全信息</div>
					<div class="ui-table-tr  mess-wrapper">
						<div class="col-md-3 col-sm-6">保单号：124587745212</div>
						<div class="col-md-3 col-sm-6">投保人：手冢治虫</div>
						<div class="col-md-6 col-sm-6">收/付款方式：支付宝</div>
						<div class="col-md-3 col-sm-6">保全类型：主体及主体信息更改</div>
						<div class="col-md-9 col-sm-6">联系方式：15478965417</div>
						<div class="col-md-3 col-sm-6">产品类型：人身险</div>
						<div class="col-md-9 col-sm-6">证件号码：152414199841524786</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-5">
					<div class="title">保全轨迹</div>
					<div class="ui-table-tr path-wrapper">
						<ul>
							<li>2017-07-04  21:05:56<span class="fr">等待审核</span></li>
							<li>2017-07-04  21:05:56<span class="fr">上传单据</span></li>
							<li>2017-07-04  21:05:56<span class="fr">生成报销单号</span></li>
							<li>2017-07-04  21:05:56<span class="fr">上传单据</span></li>
						</ul>
					</div>
				</div>
				<div class="col-md-7">
					<div class="title">上传的单据</div>
					<ul class="bills-wrapper">
						<li class="col-xs-2"><img src="{{asset('r_backend/v2/img/info.png')}}" alt="" /></li>
						<li class="col-xs-2"><img src="{{asset('r_backend/v2/img/info.png')}}" alt="" /></li>
						<li class="col-xs-2"><img src="{{asset('r_backend/v2/img/info.png')}}" alt="" /></li>
						<li class="col-xs-2"><img src="{{asset('r_backend/v2/img/info.png')}}" alt="" /></li>
						<li class="col-xs-2"><img src="{{asset('r_backend/v2/img/info.png')}}" alt="" /></li>
						<li class="col-xs-2"><img src="{{asset('r_backend/v2/img/info.png')}}" alt="" /></li>
						<li class="col-xs-2"><img src="{{asset('r_backend/v2/img/info.png')}}" alt="" /></li>
					</ul>
				</div>
			</div>
		</div>

@stop
