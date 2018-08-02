		@extends('frontend.guests.guests_layout.base')
		<link rel="stylesheet" href="{{config('view_url.view_url')}}css/lib/idangerous.swiper.css" />
		<link rel="stylesheet/less" href="{{config('view_url.view_url')}}css/index.less"/>
		<script src="{{config('view_url.view_url').'js/lib/less.min.js'}}"></script>
		@section('content')
				<!--首页banner-->
				<div class="footer-main clearfix">
					<div class="menu-wrapper">
						<ul>
							<li class="active"><a href="/about"><span>关于我们</span></a></li>
							<li><span>帮助中心</span></li>
							<li><a href="/guide"><span>流程指引</span></a></li>
						</ul>
					</div>
					<div class="main-wrapper">
						<div class="info-img" id="aboutUs">
							{{--<img src="{{config('view_url.view_url')}}image/info.png" alt="" />--}}
							顺应互联网+大潮，北京天眼互联科技有限公司成立于2016年8月，团队成员来自新浪、网易、英大人寿、安邦保险集团等大型互联网及保险机构，我们励志通过互联网及相关技术，创造简单、轻松、共赢的保险新时代。
						</div>
					</div>
				</div>
				<script src="{{config('view_url.view_url')}}js/index.js"></script>
				<script src="{{config('view_url.view_url')}}js/lib/idangerous.swiper.min.js"></script>
				<script>
                    $(function () {
                        $.ajax({
                            url: '/setting?name=aboutUs',
                        }).done(function(data) {
                            if(data != ''){
                                document.getElementById("aboutUs").innerHTML=data;
                            }
                        });
                    });
				</script>
		@stop