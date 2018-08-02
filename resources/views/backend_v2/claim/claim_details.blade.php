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
				    <li><a href="#">理赔管理</a><i class="iconfont icon-gengduo"></i></li>
				    <li><a href="#">个人理赔</a><i class="iconfont icon-gengduo"></i></li>
				    <li class="active">理赔详情</li>
				</ol>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<div class="title">理赔信息</div>
					<div class="ui-table-tr mess-wrapper">
						<div class="col-md-3 col-sm-6">保单号：124587745212</div>
						<div class="col-md-3 col-sm-6">被保人：手冢治虫</div>
						<div class="col-md-6 col-sm-6">收款方式：支付宝</div>
						<div class="col-md-3 col-sm-6">产品名称：人身意外险</div>
						<div class="col-md-9 col-sm-6">联系方式：15478965417</div>
						<div class="col-md-3 col-sm-6">保险责任：住院医疗50万元</div>
						<div class="col-md-9 col-sm-6">证件号码：152414199841524786</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-5">
					<div class="title">理赔轨迹</div>
					<div class="ui-table-tr path-wrapper">
						<ul>
							<li>2017-07-04  21:05:56<span class="fr">发起理赔</span></li>
							<li>2017-07-04  21:05:56<span class="fr">上传单据</span></li>
							<li>2017-07-04  21:05:56<span class="fr">生成报销单号</span></li>
							<li>2017-07-04  21:05:56<span class="fr">上传单据</span></li>
							<li>2017-07-04  21:05:56<span class="fr">发起理赔</span></li>
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
