<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>个人记录</title>
    <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
    <link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/lib/mui.min.css">
    <link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/lib/iconfont.css" />
    <link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/common_agent.css" />
    <link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/client.css" />
</head>

<body id="record">
<div class="header-wrapper">
    <div class="return wechatHide">
        <a class="iconfont icon-fanhui mui-action-back"></a>
    </div>
    <div class="header-top">
        <div class="header-img">
            <img src="{{config('view_url.agent_mob')}}img/boy.png"/>
        </div>
        <p>{{$res['name']}}<span class="status">@if($authentication) 已认证 @else 未认证 @endif </span></p>
        <p id="call"><i class="iconfont icon-dianhua"></i>{{$res['phone']}}</p>
        <a href="/agent_sale/mobile_cust_detail_other/{{$id}}" class="more">详细资料<i class="iconfont icon-gengduo"></i></a>
    </div>
</div>
<div>
    <div class="outer-nav">
        <div id="segmentedControl" class="mui-segmented-control">
            <a class="mui-control-item mui-active" href="#item1">沟通记录
                {{--<span class="tips">已11天为沟通</span>--}}
            </a>
            <a class="mui-control-item" href="#item2">购买记录</a>
        </div>
    </div>
    <div class="outer">
        <div id="item1" class="mui-control-content mui-active">
            <div id="scroll" class="mui-scroll-wrapper">
                <div class="mui-scroll">
                    <div class="product-wrapper">
                        <p class="date"><span>2017-08-25</span><i class="iconfont icon-jilu"></i></p>
                        <ul>
                            <li>
                                <div class="product-details">
                                    <div class="product-img">
                                        <img src="{{config('view_url.agent_mob')}}img/product.png">
                                    </div>
                                    <div class="product-right">
                                        <a href="details_client.html" class="zbtn zbtn-hollow">制作计划书</a>
                                        <p>290.00</p>
                                    </div>
                                    <h3 class="name">产品名称一</h3>
                                    <p class="info">平安2017新品上线</p>
                                    <p class="num"><span>评论:1200</span><span>销量:1200</span><span class="color-positive">推广费:20%</span></p>
                                    <div class="buy">
                                        <span>购买意向</span>
                                        <i class="iconfont icon-manyi"></i>
                                        <i class="iconfont icon-icon-manyidu"></i>
                                        <i class="iconfont icon-icon-manyidu"></i>
                                    </div>
                                </div>
                                <div class="explain-details">第二次沟通，客户由于前天家中被盗，有意向购买保</div>
                            </li>

                            <li>
                                <div class="product-details">
                                    <div class="product-img">
                                        <img src="{{config('view_url.agent_mob')}}img/product.png">
                                    </div>
                                    <div class="product-right">
                                        <a href="details_client.html" class="zbtn zbtn-hollow">制作计划书</a>
                                        <p>290.00</p>
                                    </div>
                                    <h3 class="name">产品名称一</h3>
                                    <p class="info">平安2017新品上线</p>
                                    <p class="num"><span>评论:1200</span><span>销量:1200</span><span class="color-positive">推广费:20%</span></p>
                                    <div class="buy">
                                        <span>购买意向</span>
                                        <i class="iconfont icon-manyi"></i>
                                        <i class="iconfont icon-icon-manyidu"></i>
                                        <i class="iconfont icon-icon-manyidu"></i>
                                    </div>
                                </div>
                                <div class="explain-details">第二次沟通，客户由于前天家中被盗，有意向购买保</div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div id="item2" class="mui-control-content">
            <div id="scroll" class="mui-scroll-wrapper">
                <div class="mui-scroll">
                    <div class="product-wrapper">

                        <ul>
                            @foreach($data as $v)
                            <p class="date"><span>{{strtok($v['created_at'],' ')}}</span></p>
                            <li>
                                <div class="product-details">
                                    <div class="product-img">
                                        <img style="height: 60px;" src="{{env('TY_API_PRODUCT_SERVICE_URL').'/'.$v->product['jsons']['company']['logo']}}">
                                    </div>
                                    <div class="product-right">
                                        <a href="/agent_sale/cust_order_detail/{{$v['id']}}" class="zbtn zbtn-hollow">保单详情</a>
                                        <p>￥{{$v->premium/100}}</p>
                                    </div>
                                    <h3 class="name" style="width:7em;display:block;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{$v->product['product_name']}}</h3>
                                    <p class="info">{{$v->product['company_name']}}</p>
                                    <p class="num"><span>评论:1200</span><span>销量:1200</span><span class="color-positive">推广费:{{$v->rate['earning']}}%</span></p>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="mui-popover popover-call">
    <div class="popover-wrapper">
        <div class="popover-content">
            <p>天小眼</p>
            <p class="tel">156-4568-5625</p>
        </div>
        <div class="popover-footer">
            <a href="sms:156-4568-5625" class="zbtn zbtn-hollow">短信</a>
            <a href="tel:156-4568-5625" class="zbtn zbtn-default">呼叫</a>
        </div>
    </div>
</div>
<script src="{{config('view_url.agent_mob')}}js/lib/jquery-1.11.3.min.js"></script>
<script src="{{config('view_url.agent_mob')}}js/lib/mui.min.js"></script>
<script src="{{config('view_url.agent_mob')}}js/common_agent.js"></script>
<script>
    $('#call').on('tap',function(){
        mui('.popover-call').popover('toggle');
    })
</script>
</body>
</html>