@extends('frontend.agents.agent_home.base')
@section('content')
    <link rel="stylesheet" href="{{config('view_url.agent_url')}}css/lib/swiper-3.4.2.min.css" />
    <link rel="stylesheet" href="{{config('view_url.agent_url')}}css/index.css" />
    <div class="content">
        <ul class="crumbs">
            <li><a href="#">首页</a><i class="iconfont icon-gengduo"></i></li>
            <li>我的产品</li>
        </ul>
        <form action="" method="get">
        <div class="filtrate-wrapper">
            <div class="title">产品筛选</div>
            <div class="filtrate-content">
                <div class="filtrate-section filtrate-letter">
                    <div class="filtrate-name" style="height: 130px;line-height: 130px;">保险公司</div>
                    <div class="filtrate-list">

                        <ul id="first_letter" class="filtrate-item">
                            <li></li>
                            {{--<li class="all">全部</li>--}}
                            {{--<li>A</li>--}}
                            {{--<li class="active">B</li>--}}
                            {{--<li>C</li>--}}
                            {{--<li>D</li>--}}
                            {{--<li>E</li>--}}
                            {{--<li>F</li>--}}
                            {{--<li>G</li>--}}
                            {{--<li>H</li>--}}
                            {{--<li>I</li>--}}
                            {{--<li>G</li>--}}
                            {{--<li>K</li>--}}
                            {{--<li>L</li>--}}
                            {{--<li>M</li>--}}
                            {{--<li>N</li>--}}
                            {{--<li>O</li>--}}
                            {{--<li>P</li>--}}
                            {{--<li>Q</li>--}}
                            {{--<li>R</li>--}}
                            {{--<li>S</li>--}}
                            {{--<li>T</li>--}}
                            {{--<li>U</li>--}}
                            {{--<li>V</li>--}}
                            {{--<li>W</li>--}}
                            {{--<li>X</li>--}}
                            {{--<li>Y</li>--}}
                            {{--<li>Z</li>--}}
                        </ul>
                        <div class="more">
                            <span class="fold">更多<i class="iconfont icon-gengduo"></i></span>
                            <span class="unfold">收起<i class="iconfont icon-zhankai"></i></span>
                        </div>

                        <ul class="filtrate-img company_name">
                            @foreach($company as $v)
                            <li>
                                <div class="text">{{$v['name']}}</div>
                                <input type="hidden" name="company_name" value="{{$v['name']}}">
                                <img src="{{env('TY_API_PRODUCT_SERVICE_URL').'/'.$v['logo']}}" alt="" />
                            </li>
                                @endforeach
                        </ul>
                    </div>
                </div>

                <div class="filtrate-section">
                    <div class="filtrate-name">产品分类</div>
                    <div class="filtrate-list">
                        <ul class="filtrate-item" id="category">
                            <li class="all @if(!isset($_GET['category']) || $_GET['category'] == 0) active @endif" value="0">全部</li>
                            @if($category)
                                @foreach($category as $v)
                                    <li class="@if(isset($_GET['category']) && $_GET['category'] == $v['id']) active @endif" value="{{$v['id']}}">{{$v['name']}}</li>
                                @endforeach
                            @else
                                <li>暂时没有设置佣金的产品</li>
                            @endif
                        </ul>
                    </div>
                </div>

                <div class="filtrate-section">
                    <div class="filtrate-name">佣金比率</div>
                    <div class="filtrate-list">
                        <ul class="filtrate-item" id="rate">
                            <li class="all @if( !isset($_GET['rate']) || $_GET['rate'] == 0) active @endif " value="0">全部</li>
                            <li class="@if( isset($_GET['rate']) && $_GET['rate'] == 1) active @endif " value="1">1%-10%</li>
                            <li class="@if( isset($_GET['rate']) && $_GET['rate'] == 2) active @endif " value="2">10%-20%</li>
                            <li class="@if( isset($_GET['rate']) && $_GET['rate'] == 3) active @endif " value="3">20%-30%</li>
                            <li class="@if( isset($_GET['rate']) && $_GET['rate'] == 4) active @endif " value="4">30%以上</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        </form>

        <div class="section section-products">
            <div class="search-content">
                <div class="search-wrapper">
                    <input placeholder="输入产品名称" name="product_name">
                    <button class="z-btn z-btn-default" id="product_search"><i class="iconfont icon-sousuo"></i></button>
                </div>
                <div class="page-wrapper">
                    <span>共{{$count}}件</span>
                    {{--<button class="next">下一页</button>--}}
                    {{--<button class="prev">上一页</button>--}}
                </div>
            </div>
            <ul class="products-wrapper">
                @foreach($res[0] as $v)
                <li>
                    <div class="products-label">
                        <img src="{{env('TY_API_PRODUCT_SERVICE_URL').'/'.$v['json']['company']['logo']}}" alt="" />
                    </div>
                    <div>
                        <div class="product-img">
                            <a href="/agent_sale/agent_product_detail/{{$v['id']}}">
                                <img src="{{config('view_url.agent_url')}}img/produce.png"/>
                            </a>
                        </div>
                        <h2 class="name"><a href="/agent_sale/agent_product_detail/{{$v['id']}}">{{$v['product_name']}}</a></h2>
                        <div class="tags-wrapper"><span class="">50万疾病住院</span><span>50万疾病住院</span></div>
                        <p class="info"><span>销量：1200</span><span>评论：120</span><span class="generalize">推广费{{$v['rate']['earning']}}%</span></p>
                    </div>
                    <div class="product-plan">
                        <p class="price">{{$v['price']/100}}元</p>
                        <a href="/agent_sale/add_plan" class="z-btn z-btn-positive">制作计划书</a>
                    </div>
                </li>
                    @endforeach
            </ul>
        </div>
    </div>
    <script src="{{config('view_url.agent_url')}}js/common_agent.js"></script>
    <script src="{{config('view_url.agent_url')}}js/lib/swiper-3.4.2.min.js"></script>
    <script src="{{config('view_url.agent_url')}}js/product.js"></script>
    <script>
//        产品名搜索
        $('#product_search').click(function(){
            var search = $("input[name='product_name']").val();
            location.href='/agent_sale/agent_product?'+'product_name='+search;
        })
//        点击公司logo搜索
        $('.company_name li').each(function(){
            $(this).on('click',function(){
                var search = $(this).find("input").val();
                location.href = '/agent_sale/agent_product?'+'company_name='+search;
            })
        })
        //点击分类的时候索索
        $('#category li').each(function(){
            $(this).on('click',function(){
                var search = $(this).val();
                location.href='/agent_sale/agent_product?'+'category='+search;
            })
        })
        //点击佣金比的时候检错
        $('#rate li').each(function(){
            $(this).on('click',function(){
                var  search = $(this).val();
                location.href = '/agent_sale/agent_product?'+'rate='+search;
            })
        })

    </script>
    @stop