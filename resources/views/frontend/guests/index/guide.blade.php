	@extends('frontend.guests.guests_layout.base')
	<link rel="stylesheet/less" href="{{config('view_url.view_url')}}css/index.less"/>
	<link rel="stylesheet" href="{{config('view_url.view_url')}}css/lib/idangerous.swiper.css" />
	<script src="{{config('view_url.view_url').'js/lib/less.min.js'}}"></script>
	<style>
		.section{padding: 67px 30px;margin-bottom: 20px;}
		.title{padding-bottom: 20px;margin-bottom: 20px;border-bottom: 1px solid #f4f4f4;font-size: 16px;font-weight: bold;}
		.section-img{margin-left: 50px;width: 840px;height:145px;}
	</style>
	@section('content')
				<!--首页banner-->
				<div class="footer-main clearfix">
					<div class="menu-wrapper">
						<ul>
							<li><a href="/about"><span>关于我们</span></a></li>
							<li><span>帮助中心</span></li>
							<li class="active"><a href="/guide"><span>流程指引</span></a></li>
						</ul>
					</div>
					<div class="main-wrapper">
						<div class="section">
							<h3 class="title">退保流程</h3>
							<div class="section-img">
								<img src="{{config('view_url.view_url')}}image/guide1.png" alt="" />
							</div>
						</div>
						<div class="section">
							<h3 class="title">理赔流程</h3>
							<div class="section-img">
								<img src="{{config('view_url.view_url')}}image/guide2.png" alt="" />
							</div>
						</div>
					</div>
				</div>
		<script src="{{config('view_url.view_url')}}js/index.js"></script>
	@stop
