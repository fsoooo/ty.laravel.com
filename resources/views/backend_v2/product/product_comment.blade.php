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
					<li class="active">产品评论</li>
				</ol>
			</div>
			@include('backend_v2.product.product_middle')
			<div class="row">
				<div class="col-lg-12">
					<div class="comment-section">
						<span class="name color-negative">综合评分:</span>
						<span class="iconfont icon-manyi"></span>
						<span class="iconfont icon-manyi"></span>
						<span class="iconfont icon-manyidu"></span>
						<span class="iconfont icon-manyidu"></span>
						<span class="iconfont icon-manyidu"></span>
					</div>
				</div>
			</div>
			<div class="row">
				<div  class="col-lg-12">
					<div class="comment-section">
						<div class="comment-info">
							<div class="col-sm-2 color-negative">2017-10-17  17:15</div>
							<div class="col-sm-1">张大壮</div>
							<div class="col-sm-2 color-primary">代理人：田大田</div>
							<div class="col-sm-7">
								<span class="name color-negative">对产品评分：:</span>
								<span class="iconfont icon-manyi"></span>
								<span class="iconfont icon-manyi"></span>
								<span class="iconfont icon-manyidu"></span>
								<span class="iconfont icon-manyidu"></span>
								<span class="iconfont icon-manyidu"></span>
							</div>
						</div>
						<div class="comment-label">
							<span>服务热情</span>
							<span>服务热情</span>
							<span>服务热情</span>
							<span>服务热情</span>
							<span>服务热情</span>
							<span>服务热情</span>
						</div>
						<div class="comment-content">
							<span class="color-default fl">评论：</span>
							<div class="comment-text">这里显示沟通的主要内容这里显示沟通，的主要内容这里显示沟通的主要内容这里显示沟通的主这里显示沟通的主要内容这里显示沟通，的主要这里显示沟通的主要内容这里显示沟通，的主要内容这里显示沟通的主要内容这里显示沟通的主这里显示沟通的主要内容这里显示沟通，的主要这里显示沟通的主要内容这里显示沟通，的主要内容这里显示沟通的主要内容这里显示沟通的主这里显示沟通的主要内容这里显示沟通，的主要</div>
						</div>
					</div>
					<div class="comment-section">
						<div class="comment-info">
							<div class="col-sm-2 color-negative">2017-10-17  17:15</div>
							<div class="col-sm-1">张大壮</div>
							<div class="col-sm-2 color-primary">代理人：田大田</div>
							<div class="col-sm-7">
								<span class="name color-negative">对产品评分：:</span>
								<span class="iconfont icon-manyi"></span>
								<span class="iconfont icon-manyi"></span>
								<span class="iconfont icon-manyidu"></span>
								<span class="iconfont icon-manyidu"></span>
								<span class="iconfont icon-manyidu"></span>
							</div>
						</div>
						<div class="comment-label">
							<span>服务热情</span>
							<span>服务热情</span>
							<span>服务热情</span>
							<span>服务热情</span>
							<span>服务热情</span>
							<span>服务热情</span>
						</div>
						<div class="comment-content">
							<span class="color-default fl">评论：</span>
							<div class="comment-text">这里显示沟通的主要内容这里显示沟通，的主要内容这里显示沟通的主要内容这里显示沟通的主这里显示沟通的主要内容这里显示沟通，的主要这里显示沟通的主要内容这里显示沟通，的主要内容这里显示沟通的主要内容这里显示沟通的主这里显示沟通的主要内容这里显示沟通，的主要这里显示沟通的主要内容这里显示沟通，的主要内容这里显示沟通的主要内容这里显示沟通的主这里显示沟通的主要内容这里显示沟通，的主要</div>
						</div>
					</div>

					<div class="comment-section">
						<div class="comment-info">
							<div class="col-sm-2 color-negative">2017-10-17  17:15</div>
							<div class="col-sm-1">张大壮</div>
							<div class="col-sm-2 color-primary">代理人：田大田</div>
							<div class="col-sm-7">
								<span class="name color-negative">对产品评分：:</span>
								<span class="iconfont icon-manyi"></span>
								<span class="iconfont icon-manyi"></span>
								<span class="iconfont icon-manyidu"></span>
								<span class="iconfont icon-manyidu"></span>
								<span class="iconfont icon-manyidu"></span>
							</div>
						</div>
						<div class="comment-label">
							<span>服务热情</span>
							<span>服务热情</span>
							<span>服务热情</span>
							<span>服务热情</span>
							<span>服务热情</span>
							<span>服务热情</span>
						</div>
						<div class="comment-content">
							<span class="color-default fl">评论：</span>
							<div class="comment-text">这里显示沟通的主要内容这里显示沟通，的主要内容这里显示沟通的主要内容这里显示沟通的主这里显示沟通的主要内容这里显示沟通，的主要这里显示沟通的主要内容这里显示沟通，的主要内容这里显示沟通的主要内容这里显示沟通的主这里显示沟通的主要内容这里显示沟通，的主要这里显示沟通的主要内容这里显示沟通，的主要内容这里显示沟通的主要内容这里显示沟通的主这里显示沟通的主要内容这里显示沟通，的主要</div>
						</div>
					</div>

					<div class="comment-section">
						<div class="comment-info">
							<div class="col-sm-2 color-negative">2017-10-17  17:15</div>
							<div class="col-sm-1">张大壮</div>
							<div class="col-sm-2 color-primary">代理人：田大田</div>
							<div class="col-sm-7">
								<span class="name color-negative">对产品评分：:</span>
								<span class="iconfont icon-manyi"></span>
								<span class="iconfont icon-manyi"></span>
								<span class="iconfont icon-manyidu"></span>
								<span class="iconfont icon-manyidu"></span>
								<span class="iconfont icon-manyidu"></span>
							</div>
						</div>
						<div class="comment-label">
							<span>服务热情</span>
							<span>服务热情</span>
							<span>服务热情</span>
							<span>服务热情</span>
							<span>服务热情</span>
							<span>服务热情</span>
						</div>
						<div class="comment-content">
							<span class="color-default fl">评论：</span>
							<div class="comment-text">这里显示沟通的主要内容这里显示沟通，的主要内容这里显示沟通的主要内容这里显示沟通的主这里显示沟通的主要内容这里显示沟通，的主要这里显示沟通的主要内容这里显示沟通，的主要内容这里显示沟通的主要内容这里显示沟通的主这里显示沟通的主要内容这里显示沟通，的主要这里显示沟通的主要内容这里显示沟通，的主要内容这里显示沟通的主要内容这里显示沟通的主这里显示沟通的主要内容这里显示沟通，的主要</div>
						</div>
					</div>
					{{--分页--}}
					<div class="row text-center">
						<ul class="pagination">
							<li class="disabled" ><a rel="next" >«</a></li>
								<li class="active" ><a href="{{Request::getPathinfo()}}?page=1">1</a></li>
								<li ><a href="{{Request::getPathinfo()}}?page=2">2</a></li>
								<li ><a href="{{Request::getPathinfo()}}?page=3">3</a></li>
								<li ><a href="{{Request::getPathinfo()}}?page=4">4</a></li>
								<li ><a href="{{Request::getPathinfo()}}?page=5">5</a></li>
								<li class="disabled"><a >...</a></li>
								<li ><a href="{{Request::getPathinfo()}}?page=10">10</a></li>
							<li><a rel="next" href="{{Request::getPathinfo()}}?page={{isset($_GET['page'])?$_GET['page']+1:'2'}}">»</a></li>
						</ul>
					</div>
					{{--分页--}}
				</div>
			</div>
		</div>
		<script src="{{asset('r_backend/v2/js/lib/jquery-1.11.3.min.js')}}"></script>
		<script src="{{asset('r_backend/v2/js/common_backend.js')}}"></script>
@stop