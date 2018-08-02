<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>计划书列表</title>
    <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
    <link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/lib/mui.min.css">
    <link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/lib/iconfont.css" />
    <link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/common_agent.css" />
    <link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/list.css" />
    <link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/product.css" />
    <style>
        .product-wrapper .name{
            text-decoration: underline;
        }
        .status{
            position: absolute;
            right: 0.4rem;
            bottom: -.5rem;
            font-size: .28rem;
            color: #ffae00;
        }
        .zbtn-default{
            color: #00a2ff;
            border: 1px solid #00a2ff;
            background: none;
        }
    </style>
</head>

<body>
<div class="mui-popover popover-search">
    <form id="search" action="" onsubmit="return false;">
    <div class="popover-search-top">
        <div class="search">
            <i class="iconfont icon-sousuo"></i>
            <input name="search" type="search" placeholder="请输入计划书名称"/>
        </div>
        <span id="cancel" class="zbtn">取消</span>
    </div>
    <div class="division"></div>
    <div class="popover-search-wrapper">
        <div class="title">搜索记录</div>
        {{--<span class="zbtn">天小眼</span>--}}
        {{--<span class="zbtn">天大眼</span>--}}
        {{--<span class="zbtn">天大眼的互联网公司</span>--}}
    </div>
    </form>
</div>
<!--侧滑菜单容器-->
<div id="offCanvasWrapper" class="mui-off-canvas-wrap mui-draggable mui-slide-in">
    <!--菜单部分-->
    <aside id="offCanvasSide" class="mui-off-canvas-right">
        <ul class="filtrate-wrapper">
            <li class="radioBox">
                <div class="name">状态</div>
                <div class="select-box">
                    <span class="zbtn-select">未发送</span>
                    <span class="zbtn-select">已发送</span>
                    <span class="zbtn-select">已阅读</span>
                    <span class="zbtn-select">已支付</span>
                    <span class="zbtn-select">待支付</span>
                    <span class="zbtn-select">已停效</span>
                    <span class="zbtn-select">已生效</span>
                    <span class="zbtn-select">已失效</span>
                </div>
                <div hidden class="select-value">
                    <input type="radio" value="0" name="status"/>
                    <input type="radio" value="1" name="status"/>
                    <input type="radio" value="2" name="status"/>
                    <input type="radio" value="3" name="status"/>
                    <input type="radio" value="4" name="status"/>
                    <input type="radio" value="5" name="status"/>
                    <input type="radio" value="6" name="status"/>
                    <input type="radio" value="7" name="status"/>
                </div>
            </li>
            <li class="radioBox">
                <div class="name">产品分类</div>
                <div class="select-box">
                    <span class="zbtn-select">人寿险</span>
                    <span class="zbtn-select">财产险</span>
                    <span class="zbtn-select">医疗险</span>
                    <span class="zbtn-select">汽车险</span>
                    <span class="zbtn-select">意外险</span>
                    <span class="zbtn-select">其他险</span>
                </div>
                <div hidden class="select-value">
                    <input type="radio" value="0" name="type"/>
                    <input type="radio" value="1" name="type"/>
                    <input type="radio" value="2" name="type"/>
                    <input type="radio" value="3" name="type"/>
                    <input type="radio" value="4" name="type"/>
                    <input type="radio" value="5" name="type"/>
                </div>
            </li>
        </ul>
        <div class="two-button-box">
            <button id="reset" class="zbtn zbtn-hollow">重置</button>
            <a class="zbtn zbtn-positive">确定</a>
        </div>
    </aside>
    <div class="mui-inner-wrap">
        <header id="header" class="mui-bar mui-bar-nav">
            <a class="iconfont icon-fanhui mui-pull-left mui-action-back"></a>
            <h1 class="mui-title">计划书列表</h1>
        </header>
        <div id="offCanvasContentScroll" class="mui-content mui-scroll-wrapper">
            <div id='list' class="mui-indexed-list">
                <div class="list-search-wrapper">
                    {{--<a href="#offCanvasSide" class="filtrate">筛选<i class="iconfont icon-shaixuan"></i></a>--}}
                    <div class="mui-indexed-list-search mui-input-row mui-search"><i class="iconfont icon-sousuo"></i>搜索计划书</div>
                </div>
                <div class="mui-scroll-wrapper" style="bottom:0">
                    <div class="mui-scroll">
                        <div class="product-wrapper">
                            <ul>
                                @foreach($lists as $v)
                                <li>
                                    <div class="products-label">
                                        <img src="{{env('TY_API_PRODUCT_SERVICE_URL').'/'.$v->json['company']['logo']}}" alt="">
                                    </div>
                                    <div class="product-img">
                                        <img src="{{config('view_url.agent_mob')}}img/product.png">
                                    </div>
                                    <div class="product-right">
                                        <p>{{$v->premium/100}}元</p>
                                        <a href="/agent_sale/plan_detail_other/{{$v->lists_id}}" class="zbtn zbtn-default">查看详情</a>
                                        <span class="status">
                                            @if($v->plan_status == 0)
                                                未发送
                                            @else
                                                已发送
                                            @endif
                                        </span>
                                    </div>
                                    <h3 class="name" style="width:12em;display:block;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;"><a href="/agent_sale/plan_detail/{{$v->lists_id}}">{{$v->plan_name}}</a></h3>
                                    <p class="num" style="margin: .4rem 0 0;"><span class="color-positive">推广费:{{$v->rate['earning']}}%</span></p>
                                    <p class="info" style="margin: 0;"><span>被保人：{{$v->real_name}}</span></p>
                                </li>
                                    @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mui-off-canvas-backdrop"></div>
    </div>
</div>

<script src="{{config('view_url.agent_mob')}}js/lib/jquery-1.11.3.min.js"></script>
<script src="{{config('view_url.agent_mob')}}js/lib/mui.min.js"></script>
<script src="{{config('view_url.agent_mob')}}js/lib/swiper-3.4.2.min.js"></script>
<script src="{{config('view_url.agent_mob')}}js/common_agent.js"></script>
<script>
    initProduct();
    $('.select-box .zbtn-select').show();

    $('#search').bind('search', function() {
        var search_data = $("input[name='search']").val();
        $("input").blur();
        location.href='/agent_sale/plan_lists'+'?search='+search_data;
    });


</script>
</body>

</html>