@extends('frontend.agents.agent_home.base')
@section('content')
    <link rel="stylesheet" href="{{config('view_url.agent_url')}}css/lib/swiper-3.4.2.min.css" />
    <link rel="stylesheet" href="{{config('view_url.agent_url')}}css/index.css" />
<div class="banner">
    <div class="swiper-container">
        <div class="swiper-wrapper">
            {{--<div class="swiper-slide"><img src="{{config('view_url.agent_url')}}img/banner.png" alt="" /></div>--}}
            {{--<div class="swiper-slide"><img src="{{config('view_url.agent_url')}}img/banner.png" alt="" /></div>--}}
            {{--<div class="swiper-slide"><img src="{{config('view_url.agent_url')}}img/banner.png" alt="" /></div>--}}
        </div>
        <div class="swiper-pagination"></div>
    </div>
    <div class="banner-bottom">
        <a href="#" class="join">参加活动</a>
        <div class="info">
            <p>活动名称（短期任务）</p>
            <p>任务简述</p>
        </div>
    </div>
</div>

<div class="clearfix">
    <div class="section section-apply fl">
        <p class="info">暂无待响应客户</p>
        <a href="/agent_sale/agent_cust/payed" class="z-btn z-btn-default">申请客户</a>
    </div>

    <div class="section section-brokerage fr">
        <div class="section-title">
            <span>佣金统计</span>
            <a href="/agent_sale/agent_commission" class="more">查看更多</a>
        </div>
        <table>
            <thead>
            <tr><th>月份</th><th>件数总额（件）</th><th>保费总额（元）</th><th>佣金总额（元）</th></tr>
            </thead>
            <tbody>
            @foreach($brokerage as $k=>$v)
            <tr><td>{{$v['month']}}</td><td>{{$v['math']}}</td><td>{{$v['pay']/100}} </td><td>{{$v['sum_earnings']/100}}</td></tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="section section-products">
    <div class="section-title">
        <span>产品列表</span>
        <a href="/agent_sale/agent_product" class="more">查看更多</a>
    </div>
    <ul class="products-wrapper">
        @foreach($product_list as $v)
        <li>
            <div>
                <div class="product-img">
                    <img src="{{config('view_url.agent_url')}}img/produce.png"/>
                </div>
                <h2 class="name"><a href="/agent_sale/agent_product_detail/{{$v['id']}}">{{$v['product_name']}}</a></h2>
                <div class="tags-wrapper"><span class="">50万疾病住院</span><span>50万疾病住院</span></div>
                <p class="info"><span>销量：1200</span><span>评论：120</span><span class="color-positive">推广费{{$v['rate']['earning']}}%</span></p>
            </div>
            <div class="product-plan">
                <p class="price">{{$v['premium']/100}}元</p>
                <a href="/agent_sale/add_plan" class="z-btn z-btn-positive">制作计划书</a>
            </div>
        </li>
            @endforeach
    </ul>
</div>



    <script src="{{config('view_url.agent_url')}}js/lib/swiper-3.4.2.min.js"></script>
    <script>
        var mySwiper = new Swiper('.swiper-container', {
            direction : 'vertical',
            loop : true,
            autoplay: 1000,
            pagination : '.swiper-pagination',
        })
        $(function () {
            $.ajax({
                url: "/setting?name=agency_banner0",
                success: function(data) {
                    var html = '';
                    $.each(data,function(index){
                        if(data[index]){
                            html += '<div class="swiper-slide" style="background-image:url('+ data[index] +')"></div>';
                        }
                    });
                    $('.swiper-wrapper').append(html);
                    // banner轮播图
                    var mySwiper = new Swiper('.swiper-container', {
                        direction : 'vertical',
                        loop : false,
                        autoplay: 1000,
                        pagination : '.swiper-pagination',
                    });
                },
                error: function() {
                    modalDialog("网络请求错误!");
                }
            });
        });


    </script>
    @stop