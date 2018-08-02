<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>产品列表</title>
    <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
    <link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/lib/mui.min.css">
    <link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/lib/iconfont.css" />
    <link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/common_agent.css" />
    <link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/list.css" />
    <link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/product.css" />
</head>

<body id="product">
<div class="mui-popover popover-search">
    <div class="popover-search-top">
        <div class="search">
            <i class="iconfont icon-sousuo"></i>
            <input type="search" placeholder="请输入产品名称"/>
        </div>
        <span id="cancel" class="zbtn">取消</span>
    </div>
    <div class="division"></div>
    <div class="popover-search-wrapper">
        {{--<div>--}}
            {{--<div class="title">搜索记录</div>--}}
            {{--<span class="zbtn">天小眼</span>--}}
            {{--<span class="zbtn">天大眼</span>--}}
            {{--<span class="zbtn">天大眼的互联网公司</span>--}}
        {{--</div>--}}
    </div>

</div>
<!--侧滑菜单容器-->
<div id="offCanvasWrapper" class="mui-off-canvas-wrap mui-draggable mui-slide-in">
    <!--菜单部分-->
    <aside id="offCanvasSide" class="mui-off-canvas-right">
        <ul class="filtrate-wrapper">
            <li class="radioBox">
                <div class="name">保险公司<span class="more">全部<i class="iconfont icon-gengduo"></i></span></div>
                <div class="select-box">
                    <span class="zbtn-select">平安保险</span>
                    <span class="zbtn-select">泰康人寿</span>
                    <span class="zbtn-select">太平洋保险</span>
                    <span class="zbtn-select">平安保险</span>
                    <span class="zbtn-select">泰康人寿</span>
                    <span class="zbtn-select">太平洋保险</span>
                    <span class="zbtn-select">平安保险</span>
                    <span class="zbtn-select">泰康人寿</span>
                    <span class="zbtn-select">太平洋保险</span>
                </div>
                <div hidden class="select-value">
                    <input type="radio" value="0" name="type"/>
                    <input type="radio" value="1" name="type"/>
                    <input type="radio" value="2" name="type"/>
                    <input type="radio" value="3" name="type"/>
                    <input type="radio" value="4" name="type"/>
                    <input type="radio" value="5" name="type"/>
                    <input type="radio" value="6" name="type"/>
                    <input type="radio" value="7" name="type"/>
                    <input type="radio" value="8" name="type"/>
                </div>
            </li>
            <li class="radioBox">
                <div class="name">产品分类<span class="more">全部<i class="iconfont icon-gengduo"></i></span></div>
                <div class="select-box">
                    <span class="zbtn-select">人寿险</span>
                    <span class="zbtn-select">财产险</span>
                    <span class="zbtn-select">医疗险</span>
                    <span class="zbtn-select">汽车险</span>
                    <span class="zbtn-select">意外险</span>
                    <span class="zbtn-select">其他险</span>
                    <span class="zbtn-select">人寿险</span>
                    <span class="zbtn-select">财产险</span>
                    <span class="zbtn-select">医疗险</span>
                </div>
                <div hidden class="select-value">
                    <input type="radio" value="0" name="type"/>
                    <input type="radio" value="1" name="type"/>
                    <input type="radio" value="2" name="type"/>
                    <input type="radio" value="3" name="type"/>
                    <input type="radio" value="4" name="type"/>
                    <input type="radio" value="5" name="type"/>
                    <input type="radio" value="6" name="type"/>
                    <input type="radio" value="7" name="type"/>
                    <input type="radio" value="8" name="type"/>
                </div>
            </li>
            <li class="radioBox">
                <div class="name">佣金比率</div>
                <div class="select-box">
                    <span class="zbtn-select">1%-10%</span>
                    <span class="zbtn-select">10%-20%</span>
                    <span class="zbtn-select">20%-30%</span>
                    <span class="zbtn-select">30%以上</span>
                </div>
                <div hidden class="select-value">
                    <input type="radio" value="0" name="plan"/>
                    <input type="radio" value="1" name="plan"/>
                    <input type="radio" value="2" name="plan"/>
                    <input type="radio" value="3" name="plan"/>
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
            <h1 class="mui-title">产品列表</h1>
        </header>
        <div id="offCanvasContentScroll" class="mui-content mui-scroll-wrapper">
            <div id='list' class="mui-indexed-list">
                <div class="list-search-wrapper">
                    {{--<a href="#offCanvasSide" class="filtrate">筛选<i class="iconfont icon-shaixuan"></i></a>--}}
                    <div class="mui-indexed-list-search mui-input-row mui-search"><i class="iconfont icon-sousuo"></i>搜索产品</div>
                </div>
                <div class="mui-indexed-list-alert"></div>
                <div class="mui-scroll-wrapper" style="bottom:0">
                    <div class="mui-scroll">
                        <div class="product-wrapper">
                            <ul>
                                @foreach($data as $v)
                                <li>
                                    <div class="products-label">
                                        <img src="{{config('view_url.agent_mob')}}img/merchant.png" alt="">
                                    </div>
                                    <div class="product-img">
                                        <a href="/agent_sale/agent_product_detail/{{$v['id']}}">
                                            <img src="{{config('view_url.agent_mob')}}img/product.png">
                                        </a>
                                    </div>
                                    <div class="product-right">
                                        <p>{{$v['price']/100}}元</p>
                                        <a href="/agent_sale/add_plan" class="zbtn zbtn-default">制作计划书</a>
                                    </div>
                                    <h3 class="name" style="text-overflow: ellipsis;"><a style="width:11em;display:block;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;" href="/agent_sale/agent_product_detail/{{$v['ty_product_id']}}">{{$v['product_name']}}</a><span class="score">5.0分</span></h3>
                                    <p class="num" style="margin: .4rem 0 0;"><span>销量:1200</span><span class="color-positive">推广费:{{$v['rate']['earning']}}%</span></p>
                                    <p class="info" style="margin: 0;"><span>50万意外医疗</span><span>60万住院医疗</span></p>
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
</script>
</body>

</html>