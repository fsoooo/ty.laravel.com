 @extends('frontend.guests.guests_layout.base')
<link rel="stylesheet/less" href="{{config('view_url.view_url')}}css/product.less"/>
<style>
    .pagination {
        margin-top: 50px;
        text-align: center;
    }
    .pagination > li {
        display: inline-block;
        margin: 0 8px;
        width: 36px;
        height: 36px;
        line-height: 36px;
        border: 1px solid #ddd;
    }
    .pagination > li.active {
        color: #00a2ff;
        border-color: #00a2ff;
    }
    .pagination a,
    .pagination span {
        margin: 0 10px;
        cursor: pointer;
    }
</style>
<script src="{{config('view_url.view_url').'js/lib/less.min.js'}}"></script>
@section('content')
    <div class="wrapper-top">
        <div class="main">
            <!--路径导航-->
            <ol class="breadcrumb clearfix">
                {{--<li><a href="/">保险超市</a><i class="iconfont icon-gengduo"></i></li>--}}
                {{--<li>产品列表</li>--}}
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
                            {{--<div class="introduction-content">--}}
                                {{--<h3 class="introduction-title">老年人意外保障计划</h3>--}}
                                {{--<p class="introduction-info">产品简介产品简介产品简介产</p>--}}
                            {{--</div>--}}
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
                            {{--<div class="introduction-content">--}}
                                {{--<h3 class="introduction-title">中年人骨质酥松保障</h3>--}}
                                {{--<p class="introduction-info">产品简介产品简介产品简介产品</p>--}}
                            {{--</div>--}}
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
                            {{--<div class="introduction-content">--}}
                                {{--<h3 class="introduction-title">幸福无忧10+1</h3>--}}
                                {{--<p class="introduction-info">产品简介产品简介产品简介产品</p>--}}
                            {{--</div>--}}
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
                            {{--<div class="introduction-content">--}}
                                {{--<h3 class="introduction-title">老年人意外保障计划</h3>--}}
                                {{--<p class="introduction-info">产品简介产品简介产品简介产品</p>--}}
                            {{--</div>--}}
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
                    </div>
                    {{--<div class="filtrate-row">--}}
                        {{--<span class="filtrate-title">保险分类：</span>--}}
                        {{--<ul class="filtrate-content clearfix">--}}
                            {{--@foreach($label as $value)--}}
                            {{--<li data-type="fenlei">{{$value['name']}}</li>--}}
                            {{--@endforeach--}}
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
                            {{--<span>平安保险</span>--}}
                            {{--<ul class="select-dropdown filtrate-content">--}}
                                {{--<li data-type = "baoxian1">英大保险</li>--}}
                                {{--<li data-type = "baoxian1">平安保险</li>--}}
                                {{--<li data-type = "baoxian2">中国人寿</li>--}}
                                {{--<li data-type = "baoxian2">天龙保险</li>--}}

                            {{--</ul>--}}
                        {{--</div>--}}
                        {{--<div class="select">--}}
                            {{--<span>中国人寿</span>--}}
                            {{--<ul class="select-dropdown filtrate-content">--}}
                                {{--<li data-type = "baoxian2">中国人寿</li>--}}
                                {{--<li data-type = "baoxian2">天龙保险</li>--}}
                            {{--</ul>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                </div>

                <div class="sort">
                    <span class="filtrate-title">综合排序：</span>
                    <ul class="filtrate-content clearfix">

                        <li @if(!isset($input['order_by']))class="active" @endif><a href="{{url('/product_list')}}">默认</a></li>

                        @if(isset($input['order_by']) && ($input['order_by'] == 'order_num-desc'))
                            <li class="active"><a href="{{url('/product_list?order_by=order_num-asc')}}">销量<i class="iconfont icon-arrowDown"></i></a></li>
                        @elseif(isset($input['order_by']) && ($input['order_by'] == 'order_num-asc'))
                            <li class="active"><a href="{{url('/product_list?order_by=order_num-desc')}}">销量<i class="iconfont icon-jiantou"></i></a></li>
                        @else
                            <li><a href="{{url('/product_list?order_by=order_num-asc')}}">销量<i class="iconfont icon-jiantou"></i></a></li>
                        @endif

                        @if(isset($input['order_by']) && ($input['order_by'] == 'base_price-desc'))
                            <li class="active"><a href="{{url('/product_list?order_by=base_price-asc')}}">价格<i class="iconfont icon-arrowDown"></i></a></li>
                        @elseif(isset($input['order_by']) && ($input['order_by'] == 'base_price-asc'))
                            <li class="active"><a href="{{url('/product_list?order_by=base_price-desc')}}">价格<i class="iconfont icon-jiantou"></i></a></li>
                        @else
                            <li><a href="{{url('/product_list?order_by=base_price-asc')}}">价格<i class="iconfont icon-jiantou"></i></a></li>
                        @endif

                        @if(isset($input['order_by']) && ($input['order_by'] == 'created_at-desc'))
                            <li class="active"><a href="{{url('/product_list?order_by=created_at-asc')}}">上架时间<i class="iconfont icon-arrowDown"></i></a></li>
                        @elseif(isset($input['order_by']) && ($input['order_by'] == 'created_at-asc'))
                            <li class="active"><a href="{{url('/product_list?order_by=created_at-desc')}}">上架时间<i class="iconfont icon-jiantou"></i></a></li>
                        @else
                            <li><a href="{{url('/product_list?order_by=created_at-desc')}}">上架时间<i class="iconfont icon-arrowDown"></i></a></li>
                        @endif
                    </ul>
                    {{--<div class="sort-skipbox clearborder">--}}
                        {{--<button class="sort-skipbox-page"><span class="currentpage">1</span>/<span class="totalpages">1</span></button>--}}
                        {{--<button class="sort-skipbox-btn unusable sort-skipbox-btn-left"><i class="iconfont icon-fanhui"></i></button>--}}
                        {{--<span class="sort-skipbox-btn sort-skipbox-btn-right"><i class="iconfont icon-gengduo"></i></span>--}}
                    {{--</div>--}}

                </div>
                @if($count=='0')
                @else
                <div class="details">
                    <ul>
                        @foreach($data as $v)
                            <?php $json = json_decode($v->json ,true);?>
                        <li class="clearfix">
                            <div class="details-left fl">
                                <div class="details-left-img"><img src="{{env('TY_API_PRODUCT_SERVICE_URL') . '/' .$json['company']['logo']}}" /></div>
                                <h2 class="details-left-title">  <a class="more" href="/ins/ins_info/{{$v->ty_product_id}}" target="_blank">{{$v->product_name}}</a></h2>
                                <div class="details-left-feature">
                                    <span class="tag">赔付率高</span>
                                    <span class="tag">保费性价比高</span>
                                    <span class="tag">保费性价比高</span>
                                </div>
                                <div class="details-left-list">
                                    {{--<div><span class="details-left-name">意外身故/伤残</span><span class="f18164">50万元</span></div>--}}
                                    {{--<div><span class="details-left-name">意外身故</span><span class="f18164">5万元</span></div>--}}
                                    {{--<div><span class="details-left-name">意外住院津贴</span><span class="f18164">50万元</span></div>--}}
                                    <?php $i = 1; ?>
                                    @foreach($json['clauses'] as $ck => $cv)
                                        @foreach($cv['duties'] as $dk => $dv)
                                            @if($i <= 3)
                                            <div>
                                                <span class="details-left-name">{{ $dv['name'] }}</span><span class="f18164">
                                                    {{ preg_match('/^\d{5,}$/', $dv['pivot']['coverage_jc']) ?  $dv['pivot']['coverage_jc'] / 10000 . '万元' : $dv['pivot']['coverage_jc'] }}
                                                </span>
                                            </div>
                                            @else
                                                ...
                                                <?php break 2; ?>
                                            @endif
                                            <?php $i++ ?>
                                        @endforeach
                                    @endforeach
                                </div>
                                {{--<div class="details-left-other">--}}
                                    {{--<span><i class="icon icon-wujiaoxing"></i>电子保单</span>--}}
                                    {{--<span><i class="icon icon-wujiaoxing"></i>极速赔付</span>--}}
                                    {{--<span><i class="icon icon-wujiaoxing"></i>保单变更</span>--}}
                                {{--</div>--}}
                            </div>
                            <div class="details-right fl">
                                <div class="details-right-price">
                                    <span class="price-unit">￥</span>
                                    <span class="price-count">{{ $v->base_price / 100 }}</span>
                                </div>
                                <div class="details-right-warranty"><a href="/ins/ins_info/{{$v->ty_product_id}}" target="_blank">查看详情</a></div>
                                <div class="details-right-sale">{{ $v->order_num }}</div>
                                {{--<div class="details-right-comment">评论：49</div>--}}
                                <div class="details-right-contrast">
                            {{--<label><input class="btn-compare" type="checkbox" hidden/><i class="iconfont icon-Check"></i><span>加入对比</span></label>--}}
                        </div>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
                {{--<div id="pageTool"></div>--}}
                <div style="margin:20px;">
                    {{--{{ $res->links() }}--}}
                    {{--分页--}}
                    <?php

                        $a = preg_match("/&page_num=\d+/",Request::getRequestUri());
                        $b = preg_match("/\?page_num=\d/",Request::getRequestUri());
                        if($a){
                            $str = preg_replace("/&page_num=\d/",'',Request::getRequestUri()) . "&";
                        }else
                        if($b){
                            if(preg_match("/\?page_num=\d+&/",Request::getRequestUri())){
                                $str = preg_replace("/\?page_num=\d+&/",'?',Request::getRequestUri()) . "&";
                            } else {
                                $str = preg_replace("/\?page_num=\d+/",'',Request::getRequestUri()) . "?";
                            }
                        }
                        if(!$a && !$b){
                            if(preg_match("/\?/",Request::getRequestUri())){
                                $str = Request::getRequestUri() . "&";
                            }else {
                                $str = Request::getRequestUri() . "?";
                            }

                        }
//                        dd($str);
                    ?>
                    @if($count>5)
                        @if($sum_page<5)
                            <div class="row text-center">
                                <ul class="pagination">
                                    <li @if($sum_page=='1')  class="disabled" @endif><a rel="next" href=" ">«</a></li>
                                    @for($i=1;$i<=$sum_page;$i++)
                                        @if($i=='1')
                                            <li @if($page_num == $i)class="active"@endif><a href="{{$str}}page_num={{$i}}">{{$i}}</a></li>
                                        @else
                                            <li @if($page_num == $i)class="active"@endif><a href="{{$str}}page_num={{$i}}">{{$i}}</a></li>
                                        @endif
                                    @endfor
                                    <li @if($sum_page==$page_num)  class="disabled" @endif><a rel="next" href="{{$str}}page_num={{$page_num+1}}">»</a></li>
                                </ul>
                            </div>
                        @else
                            <div class="row text-center">
                                <ul class="pagination">
                                    <li @if($page_num=='1')  class="disabled" @endif><a rel="next" href="{{$str}}page_num={{$page_num-1}}">«</a></li>
                                    @for($i=1;$i<=5;$i++)
                                        @if($i=='1')
                                            <li class="active" ><a href="{{$str}}page_num={{$i}}">{{$i}}</a></li>
                                        @else
                                            <li id="page_{{$i}}"><a href="{{$str}}page_num={{$i}}">{{$i}}</a></li>
                                        @endif
                                    @endfor
                                    <li class="disabled"><a>...</a></li>
                                    <li id="{{$sum_page}}"><a href="{{$str}}page_num={{$sum_page}}">{{$sum_page}}</a></li>
                                    <li @if($sum_page==$page_num)  class="disabled" @endif><a rel="next" href="{{$str}}page_num={{$page_num+1}}">»</a></li>
                                </ul>
                            </div>
                        @endif
                    @endif
                    {{--分页--}}
                </div>

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
