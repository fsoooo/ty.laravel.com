@extends('frontend.guests.guests_layout.base')
<link rel="stylesheet/less" href="{{config('view_url.view_url')}}css/product.less"/>
<script src="{{config('view_url.view_url').'js/lib/less.min.js'}}"></script>
@section('content')
    <div class="wrapper-top">
        <div class="main">
            <!--路径导航-->
            <ol class="breadcrumb clearfix">
                {{--<li><a href="#">某某保险网</a><i class="iconfont icon-gengduo"></i></li>--}}
                {{--<li>某某保险</li>--}}
            </ol>
            <div class="introduction">
                <ul class="clearfix">
                    <li>
                        <a href="#">
                            <div class="recommend">
                                <img src="{{config('view_url.view_url')}}image/242075202125531305.png" alt="" />
                            </div>
                            <div class="introduction-img">
                                <img src="{{config('view_url.view_url')}}image/414562257716294936.png" />
                            </div>
                            <div class="introduction-content">
                                <h3 class="introduction-title">老年人意外保障计划</h3>
                                <p class="introduction-info">产品简介产品简介产品简介产</p>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <div class="recommend">
                                <img src="{{config('view_url.view_url')}}image/242075202125531305.png" alt="" />
                            </div>
                            <div class="introduction-img">
                                <img src="{{config('view_url.view_url')}}image/39227436563819736.jpg" />
                            </div>
                            <div class="introduction-content">
                                <h3 class="introduction-title">中年人骨质酥松保障</h3>
                                <p class="introduction-info">产品简介产品简介产品简介产品</p>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <div class="recommend">
                                <img src="{{config('view_url.view_url')}}image/242075202125531305.png" alt="" />
                            </div>
                            <div class="introduction-img">
                                <img src="{{config('view_url.view_url')}}image/396658748210103920.jpg" />
                            </div>
                            <div class="introduction-content">
                                <h3 class="introduction-title">幸福无忧10+1</h3>
                                <p class="introduction-info">产品简介产品简介产品简介产品</p>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <div class="recommend">
                                <img src="{{config('view_url.view_url')}}image/242075202125531305.png" alt="" />
                            </div>
                            <div class="introduction-img">
                                <img src="{{config('view_url.view_url')}}image/872561939842456927.jpg" />
                            </div>
                            <div class="introduction-content">
                                <h3 class="introduction-title">老年人意外保障计划</h3>
                                <p class="introduction-info">产品简介产品简介产品简介产品</p>
                            </div>
                        </a>
                    </li>
                </ul>
            </div>

        </div>
    </div>
    <div class="wrapper-bottom">
        <div class="main clearfix">
            <div class="subfield-left">
                <div class="filtrate">
                    <div class="filtrate-row">
                        <span class="filtrate-title cl333">产品筛选</span>
                        <span class="filtrate-title">共{{$count}}款产品</span>
                        <ul class="filtrate-content filtrate-selected">
                            <!--<li>意外保障<i class="iconfont icon-close"></i></li>
                            <li>失足落水<i class="iconfont icon-close"></i></li>-->
                        </ul>
                    </div>
                    {{--<div class="filtrate-row">--}}
                        {{--<span class="filtrate-title">保险分类：</span>--}}
                        {{--<ul class="filtrate-content clearfix">--}}
                            {{--<li class="active" data-type="fenlei">意外保障1</li>--}}
                            {{--<li data-type="fenlei">意外保障2</li>--}}
                            {{--<li data-type="fenlei">意外保障3</li>--}}
                            {{--<li data-type="fenlei">意外保障4</li>--}}
                        {{--</ul>--}}
                    {{--</div>--}}
                    {{--<div class="filtrate-row">--}}
                        {{--<span class="filtrate-title">保险期限：</span>--}}
                        {{--<ul class="filtrate-content clearfix">--}}
                            {{--<li data-type="qixian">1年</li>--}}
                            {{--<li data-type="qixian">1年以上</li>--}}
                            {{--<li data-type="qixian">1年以下</li>--}}
                            {{--<li class="filtrate-content-custom">--}}
                                {{--<span>自定义天数</span>--}}
                                {{--<div class="inline filtrate-content-days">--}}
                                    {{--<input id="start" class="laydate-icon" value="开始日"/>--}}
                                    {{--<input id="end" class="laydate-icon" value="结束日"/>--}}
                                {{--</div>--}}
                            {{--</li>--}}

                        {{--</ul>--}}
                    {{--</div>--}}
                    {{--<div class="filtrate-row">--}}
                        {{--<span class="filtrate-title">其他筛选：</span>--}}
                        {{--<div class="select">--}}
                            {{--<span>保险公司1</span>--}}
                            {{--<ul class="select-dropdown filtrate-content">--}}
                                {{--<li data-type = "baoxian1">英大保险1</li>--}}
                                {{--<li data-type = "baoxian1">天龙保险1</li>--}}
                            {{--</ul>--}}
                        {{--</div>--}}
                        {{--<div class="select">--}}
                            {{--<span>保险公司2</span>--}}
                            {{--<ul class="select-dropdown filtrate-content">--}}
                                {{--<li data-type = "baoxian2">英大保险2</li>--}}
                                {{--<li data-type = "baoxian2">天龙保险2</li>--}}
                            {{--</ul>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}

                {{--<div class="sort">--}}
                    {{--<span class="filtrate-title">综合排序：</span>--}}
                    {{--<ul class="filtrate-content clearfix">--}}
                        {{--<li class="active">默认</li>--}}
                        {{--<li>销量<i class="iconfont icon-arrowDown"></i></li>--}}
                        {{--<li>价格<i class="iconfont icon-jiantou"></i></li>--}}
                        {{--<li>评分<i class="iconfont icon-arrowDown"></i></li>--}}
                        {{--<li>上架时间<i class="iconfont icon-arrowDown"></i></li>--}}
                    {{--</ul>--}}
                    {{--<div class="sort-skipbox clearborder">--}}
                        {{--<button class="sort-skipbox-page"><span class="currentpage">1</span>/<span class="totalpages">12</span></button>--}}
                        {{--<button class="sort-skipbox-btn unusable sort-skipbox-btn-left"><i class="iconfont icon-fanhui"></i></button>--}}
                        {{--<span class="sort-skipbox-btn sort-skipbox-btn-right"><i class="iconfont icon-gengduo"></i></span>--}}
                    {{--</div>--}}

                </div>
                @if($count=='0')
                @else
                <div class="details">
                    <ul>
                        @foreach($res as $v)
                        <li class="clearfix">
                            <div class="details-left fl">
                                <div class="details-left-img"><img src="{{config('view_url.view_url')}}image/ins (2).png" /></div>
                                <h2 class="details-left-title"><a href="/ins/ins_info/{{$v->ty_product_id}}">{{$v->product_name}}</a></h2>
                                <div class="details-left-feature">
                                    <span class="tag">赔付率高</span>
                                    <span class="tag">保费性价比高</span>
                                    <span class="tag">保费性价比高</span>
                                </div>
                                <div class="details-left-list">
                                    <?php $i=1?>
                                    @foreach($v['duties']['option']['protect_items'] as $vv)
                                        @if($i<= 3)
                                    <div><span class="details-left-name">{{$vv['name']}}</span><span class="f18164">{{$vv['defaultValue']}}</span></div>
                                            @else
                                            ...

                                            @endif
                                        <?php $i++; ?>
                                        @endforeach
                                </div>
                                <div class="details-left-other">
                                    <span><i class="icon icon-wujiaoxing"></i>电子保单</span>
                                    <span><i class="icon icon-wujiaoxing"></i>电子保单</span>
                                    <span><i class="icon icon-wujiaoxing"></i>电子保单</span>
                                </div>
                            </div>
                            <div class="details-right fl">
                                <div class="details-right-price">
                                    <span class="price-unit">￥</span>
                                    <span class="price-count">{{$v['base_price']/100}}</span>
                                </div>
                                <div class="details-right-warranty"><a href="/ins/group_ins/insInfo/{{$v->ty_product_id}}">查看详情</a></div>
                                <div class="details-right-sale">销量：1300</div>
                                <div class="details-right-comment">评论：49</div>
                                <div class="details-right-contrast">
                            <label><input class="btn-compare" type="checkbox" hidden/><i class="iconfont icon-Check"></i><span>加入对比</span></label>
                        </div>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
                {{--<div id="pageTool">--}}
                    {{--{{$res->links()}}--}}
                {{--</div>--}}
                @endif
            </div>
            <div class="subfield-right">
                <h2 class="subfield-right-title">如何选购中老年人的意外险?</h2>
                <p class="subfield-right-text">给老年人选择意外险时,因大多数已经退休不存在职业限制问题,只要年龄在保障范围内即可投保。在挑选产品时主要看意外医疗的保障额度和报销比例的高低。其次，要注意的是看是否涵盖意外住院津贴。当然也需要留意一下产品免赔额的高低。</p>
                <ul class="subfield-right-list">
                    <li>
                        <p><a href="#">轻松一点 立刻找到老年人投保方法</a></p>
                    </li>
                    <li>
                        <p><a href="#">老爸老妈退休如何买保险</a></p>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <script src="{{config('view_url.view_url')}}js/lib/paging.js"></script>
    <script src="{{config('view_url.view_url')}}js/product.js"></script>
@stop