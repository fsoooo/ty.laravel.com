@extends('frontend.guests.guests_layout.base')
{{--<link rel="stylesheet" href="{{config('view_url.view_url').'css/lib/idangerous.swiper.css'}}" />--}}
<link rel="stylesheet" href="{{config('view_url.view_url').'css/lib/swiper-3.4.2.min.css'}}" />
<link rel="stylesheet/less" href="{{config('view_url.view_url').'css/index.less'}}" />
<script src="{{config('view_url.view_url').'js/lib/less.min.js'}}"></script>
@section('content')
    <!--首页banner-->
    <div class="banner">
        <div class="swiper-container">
            <div class="swiper-wrapper">
                {{--<div class="swiper-slide" style="background-image: url('{{config('view_url.view_url')}}image/index-banner1.png')">--}}
                    {{--<img src="" />--}}
                {{--</div>--}}
                {{--<div class="swiper-slide" style="background-image: url('{{config('view_url.view_url')}}image/index-banner2.png')">--}}
                    {{--<img src="{" />--}}
                {{--</div>--}}
                {{--<div class="swiper-slide" style="background-image: url('{{config('view_url.view_url')}}image/816664762856828669.png')">--}}
                    {{--<img src="" />--}}
                {{--</div>--}}
            </div>
        </div>
        <div class="swiper-option">
            <div class="swiper-button-prev"><i class="iconfont icon-fanhui"></i></div>
            <div class="swiper-option-text"><span class="currentpage">1</span>/<span class="totalpages">2</span></div>
            <div class="swiper-button-next"><i class="iconfont icon-gengduo"></i></div>
        </div>
        <div class="banner-wrapper">
            <div class="main-classify">
                <div class="main-classify-left">
                    <ul>
                        @foreach($labels as $k =>$label)
                            @if(!empty($label))
                                    @if($k == 0)
                                        <li class="active" data-id="{{$label['id']}}">{{$label['name']}}</li>
                                    @else
                                        <li data-id="{{$label['id']}}">{{$label['name']}}</li>
                                    @endif
                            @endif
                        @endforeach
                    </ul>
                </div>
                <div class="main-classify-right">
                    @foreach($labels as $k => $label)
                        @if(!empty($label))
                    <div @if($k=='0') class="main-classify-content active" @else  class="main-classify-content" @endif>
                        <div class="main-classify-to  main-right-title"></div>
                        <div class="main-classify-type">
                            <ul class="clearfix">
                                <li><a href="/product_list">{{$label['name']}}</a></li>
                            </ul>
                        </div>
                        <div class="main-classify-recommend">
                            <div class="main-recommend-title main-right-title">
                                <span>特别推荐：</span>
                            </div>
                                    @php
                                    $first_p = json_decode($label['product']['json'], true);
                                    $clauses = json_decode($label['product']['clauses'], true);
                                    @endphp
                            <a class="more" href="/ins/ins_info/{{$label['product']['ty_product_id']}}" target="_blank">
                                <div class="main-recommend-content clearfix">
                                    <div class="main-recommend-content-img" style="background-image: url('{{asset($label['product']['cover'])}}');background-size: cover;background-position: center">
                                        {{--<img src="" alt="">--}}
                                    </div>
                                    <div class="recommend-content">
                                        <h3 class="title">{{$first_p['name']}}</h3>
                                        <p class="text">{{ $first_p['display_name'] }}</p>
                                        <span class="price">￥{{$first_p['base_price']/100}} 起</span>
                                        去看看&raquo;
                                    </div>
                                </div>
                            </a>

                        </div>
                    </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="main">
        <!--业绩榜-->
        <div class="performance">
            <h2 class="section-title">业绩榜</h2>
            <ul>
                <li>
                    <div class="performance-img">
                        <i class="iconfont icon-hangyefangan"></i>
                    </div>
                    <p class="performance-num">745,602</p>
                    <p class="performance-info">定制保险方案</p>
                </li>
                <li>
                    <div class="performance-img">
                        <i class="iconfont icon-baodanyangben"></i>
                    </div>
                    <p class="performance-num">38,835,527</p>
                    <p class="performance-info">累计发出保单</p>
                </li>
                <li>
                    <div class="performance-img">
                        <i class="iconfont icon-haoping"></i>
                    </div>
                    <p class="performance-num">98%</p>
                    <p class="performance-info">用户好评</p>
                </li>
            </ul>
        </div>
        <!--保险分类-->
        <!--保险分类-->
        @if(count($product_res)>0)
        <div class="classify">
            <h2 class="section-title">保险分类</h2>
            @foreach($product_res as $key=>$value)
            <ul class="classify1 clearfix">
                <li class="classify-first">
                    <h4>{{$key}}</h4>
                    <span><a href=""><i class="line"></i>{{$key}}</a></span>
                </li>
                @foreach($value as $k=>$v)
                    @if($k>=3)
                        @php break; @endphp
                    @endif
                <li>
                    <a href="/ins/ins_info/{{$v['ty_product_id']}}" target="_blank">
                        <div class="classify-img" style="background-image: url('{{$v['cover']}}');background-size: cover;background-position: center">
                            {{--<img src="{{$v['cover']}}" alt="" />--}}
                        </div>
                        <div class="classify-content">
                            <p class="classify-title">{{$v['product_name']}}</p>
                            <p class="classify-info">{{$v['company_name']}}</p>
                            <div class="clearfix">
                                <span class="classify-price fl">{{$v['base_price']/100}}元</span>
                            </div>
                        </div>
                    </a>
                </li>
                @endforeach
            </ul>
            @endforeach
        </div>
        @endif
        <!--保险分类-->
        <!--代理人团队-->
        {{--@if($agent_count!=='0')--}}
        {{--<div class="team">--}}
            {{--<h2 class="section-title">代理人团队</h2>--}}
            {{--<ul class="team-wrapper clearfix">--}}
                {{--@foreach($agent_res as $value)--}}
                {{--<li>--}}
                    {{--<div class="team-img">--}}
                        {{--<img src="{{config('view_url.view_url')}}image/546880771452609376.png" alt="" />--}}
                    {{--</div>--}}
                    {{--<h4 class="name">{{$value->user->name}}</h4>--}}
                    {{--<span class="time">从业五年</span>--}}
                    {{--<p class="manifesto">从业宣言:科技让保险无限可能</p>--}}
                    {{--<p class="f18164 tel">电话:{{$value->user->phone}}</p>--}}
                    {{--<p class="f18164">微信:1111111111</p>--}}
                {{--</li>--}}
                {{--@endforeach--}}
            {{--</ul>--}}
        {{--</div>--}}
        {{--@endif--}}
        <!--代理人团队-->
        {{--<!--合作墙-->--}}
        <div class="cooperation">
            <h2 class="section-title">合作墙</h2>
            <ul class="clearfix">
                <li>
                    <a><img src="{{config('view_url.view_url')}}image/ins (8).png" /></a>
                </li>
                <li>
                    <a><img src="{{config('view_url.view_url')}}image/ins (1).png" /></a>
                </li>
                <li>
                    <a><img src="{{config('view_url.view_url')}}image/ins (2).png" /></a>
                </li>
                <li>
                    <a><img src="{{config('view_url.view_url')}}image/ins (3).png" /></a>
                </li>
                <li>
                    <a><img src="{{config('view_url.view_url')}}image/ins (4).png" /></a>
                </li>
                <li>
                    <a><img src="{{config('view_url.view_url')}}image/ins (5).png" /></a>
                </li>
                <li>
                    <a><img src="{{config('view_url.view_url')}}image/ins (6).png" /></a>
                </li>
                <li>
                    <a><img src="{{config('view_url.view_url')}}image/ins (7).png" /></a>
                </li>
                <li>
                    <a><img src="{{config('view_url.view_url')}}image/ins (9).png" /></a>
                </li>
                <li>
                    <a><img src="{{config('view_url.view_url')}}image/ins (2).png" /></a>
                </li>
            </ul>
        </div>
        {{--<!--合作墙-->--}}
    </div>
    <script src="{{config('view_url.view_url').'js/lib/swiper-3.4.2.min.js'}}"></script>
    <script src="{{config('view_url.view_url').'js/index.js'}}"></script>
    <script>
        $(function () {
            $.ajax({
                url: '/setting?name=insurance_banner',
            }).done(function(data) {
                var html = '';
                $.each(data,function(index){
                    if(data[index]){
                        html += '<div class="swiper-slide" style="background-image:url('+ data[index] +')"></div>';
                    }
                });
                $('.swiper-wrapper').append(html);
                // banner轮播图
                var length = $('.swiper-slide').length;
                var mySwiper = new Swiper('.swiper-container', {
                    autoplay: 5000,
                    loop: true,
                    effect: 'fade',
                    onInit: function(swiper){
                        $('.totalpages').text(length);
                    },
                    onSlideChangeStart: function(swiper){
                        var cur;
                        swiper.activeIndex > length ? cur = 1 : cur = swiper.activeIndex;
                        if(swiper.activeIndex<=0){cur = length;}
                        $('.currentpage').text(cur);
                    }
                });
                $('.swiper-button-prev').click(function(e) {
                    e.preventDefault()
                    mySwiper.slidePrev();
                });
                $('.swiper-button-next').on('click', function(e) {
                    e.preventDefault()
                    mySwiper.slideNext();
                });
            });
//            Mask.alert('操作失败',3);
        });
        var classifyArr = {};
        $('.main-classify-left li').each(function(){
            var id = $(this).data('id');
            if(classifyArr[id]){
                var index = $(this).index();
                $(this).remove();
                $('.main-classify-content').eq(index).remove();
            }else{
                classifyArr[id] = id;
            }
        });

    </script>
@stop

