<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>计划书</title>
    <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
    <link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/lib/mui.min.css">
    <link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/lib/mui.picker.all.css">
    <link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/lib/iconfont.css" />
    <link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/common_agent.css" />
    <link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/plan.css" />
</head>
<body>
<div class="main">
    <header id="header" class="mui-bar mui-bar-nav">
        <a class="iconfont icon-fanhui mui-pull-left mui-action-back"></a>
        <h1 class="mui-title">{{$detail->plan_name}}</h1>
    </header>
    <div class="mui-scroll-wrapper">
        <div class="mui-scroll">
            <div class="plan-header">
                <div class="plan-img">
                    <img src="{{config('view_url.agent_mob')}}img/banner.png"/>
                </div>
                <div class="company">
                    <img src="{{env('TY_API_PRODUCT_SERVICE_URL')."/".$product->json['company']['logo']}}" alt="" />
                </div>
                <div class="plan-user">
                    <p class="info">{{$detail->name}}&nbsp;@if(isset($detail->code)) @if(substr($detail->code,16,1)%2 == 1)男@else 女@endif @else -- @endif&nbsp;@if(isset($detail->code)){{date('Y',time()) - substr($detail->code,6,4)}}岁@else -- @endif</p>
                    <ul class="details">
                        <li>
                            <span>保险金额</span>
                            <p><i>{{$detail->premium/100}}元</i>/份</p>
                        </li>
                        <li>
                            <span>产品期限</span>
                            <p><i>1年</i></p>
                        </li>
                        <li>
                            <span>缴费期限</span>
                            <p><i>年</i>交</p>
                        </li>
                        <li>
                            <span>首年保费</span>
                            <p><i>5000元</i></p>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="plan-container">
                <div class="section section-rights">
                    <h4 class="title"><i class="iconfont icon-shouye5"></i>保障权益</h4>
                    <ul class="list">
                        @foreach($detail->protect_items as $k=>$v)
                            <li>
                                <p><span>{{$v['name']}}</span>
                                {{$v['defaultValue']}}</p>
                            </li>
                        @endforeach
                        <li>查看条款详情<i class="iconfont icon-gengduo"></i></li>
                    </ul>
                </div>
                <div class="section section-variety">
                    <h4 class="title"><i class="iconfont icon-shouye21"></i>险种</h4>
                    <ul class="list">
                        @foreach($detail->protect_items as $k=>$v)
                            @if($k == 0)
                                <li><i class="zicon-main"></i>{{$v['name']}}
                                    @else
                                <li><i class="zicon-minor"></i>{{$v['name']}}

                            @endif
                        @endforeach
                    </ul>
                </div>
                <div class="section section-points">
                    <h4 class="title"><i class="iconfont icon-shouye4"></i>卖点</h4>
                    <ul class="list">
                        @if(!is_null($detail->selling))
                            @foreach(json_decode($detail->selling,true) as $k=>$v)
                                <li>卖点{{$k+1}}：{{$v}}</li>
                            @endforeach
                        @endif
                    </ul>
                </div>
                <button id="changeInfo" class="zbtn zbtn-default">修改个人信息</button>
            </div>
        </div>
    </div>
    <div class="plan-bottom">
        <div class="fr">
            <a href="{{$detail->url}}" class="zbtn zbtn-positive">立即投保</a>
            <a href="feedback.html" class="zbtn zbtn-default">反馈意见</a>
        </div>
        <div class="user-header">
            <img src="{{config('view_url.agent_mob')}}img/girl.png" alt="" />
        </div>
        <p>{{$agent_detail->name}}<a href="tel:{{$agent_detail->phone}}" class="tel">{{$agent_detail->phone}}</a></p>
    </div>
</div>

<div class="mui-popover popover-info">
    <div class="popover-wrapper">
        <div class="title">被保人信息<i class="iconfont icon-close"></i></div>
        <div class="popover-content">
            <div class="form-wrapper">
                <ul>
                    <li>
                        <span class="name">姓名</span><input type="text" value="天小眼" />
                    </li>
                    <li class="radioBox">
                        <span class="name">性别</span>
                        <div class="select-box">
                            <button class="zbtn-select active">男</button>
                            <button class="zbtn-select">女</button>
                        </div>
                        <div class="select-value">
                            <input checked type="radio" value="0" name="sex"/>
                            <input type="radio" value="1" name="sex"/>
                        </div>
                    </li>
                    <li class="pickerDate">
                        <span class="name">出生日期</span>
                        <input type="text" value="2017-09-21" />
                        <i class="iconfont icon-gengduo"></i>
                        <input hidden type="text" />
                    </li>
                </ul>
            </div>
            <button class="zbtn zbtn-default">确定</button>
        </div>
    </div>
</div>


<script src="{{config('view_url.agent_mob')}}js/lib/jquery-1.11.3.min.js"></script>
<script src="{{config('view_url.agent_mob')}}js/lib/mui.min.js"></script>
<script src="{{config('view_url.agent_mob')}}js/lib/mui.picker.all.js"></script>
<script src="{{config('view_url.agent_mob')}}js/common_agent.js"></script>
<script>

    $('#changeInfo').on('tap',function(){
        mui('.popover-info').popover('toggle');
    });
    pickerDate('.pickerDate');
    selectData('.radioBox','single');

    $('.mui-popover .icon-close').on('tap',function(){
        mui('.mui-popover').popover('toggle');
    })
</script>
</body>
</html>
