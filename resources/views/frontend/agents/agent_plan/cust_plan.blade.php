<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>天眼互联-科技让保险无限可能</title>
    <link rel="stylesheet" href="{{config('view_url.agent_url')}}css/lib/iconfont.css" />
    <link rel="stylesheet" href="{{config('view_url.agent_url')}}css/common_agent.css" />
    <link rel="stylesheet" href="{{config('view_url.agent_url')}}css/lib/swiper-3.4.2.min.css" />
    <link rel="stylesheet" href="{{config('view_url.agent_url')}}css/produced_details.css" />
    <link rel="stylesheet" href="{{config('view_url.agent_url')}}css/produced_client.css" />
</head>
<body>
<div class="header-wrapper">
    <div class="header">
        <div class="header-left">
            <div class="logo">
                <img src="{{config('view_url.agent_url')}}img/logo.png"/>
            </div>
        </div>
    </div>
</div>
<div class="main-wrapper clearfix">
    <div class="content-wrapper fr">
        <div class="content">
            <div class="merchant"><img src="{{config('view_url.agent_url')}}img/merchant.png"/></div>
            <h1 class="name">计划书名称</h1>
                <div class="table-wrapper">
                    <div class="table-header"><i class="iconfont icon-shouye1"></i>基本信息</div>
                    <table>
                        <tr><td>产品名称：{{$detail->product_name}}</td><td></td></tr>
                        <tr><td>被投保人：{{$detail->name}}</td><td>保险金额：{{$detail->premium/100}}元/份</td></tr>
                        <tr><td>被保人性别：@if(isset($detail->code)) @if(substr($detail->code,16,1)%2 == 1)男@else 女@endif @else -- @endif</td><td>缴费期间：3年</td></tr>
                        <tr><td>被保人年龄：@if(isset($detail->code)){{date('Y',time()) - substr($detail->code,6,4)}}岁@else -- @endif</td><td>缴费方式：年交</td></tr>
                        <tr><td>保障期限：保至100周岁</td><td>首年支付保险费：5000元</td></tr>
                    </table>
                </div>
                <div class="table-wrapper">
                    <div class="table-header"><i class="iconfont icon-shouye"></i>保障权益</div>
                    @foreach($detail->protect_items as $k=>$v)
                        <table class="rights">
                            <tr>
                                <td>{{$v['name']}}</td>
                                <td>{{$v['defaultValue']}}</td>
                                <td>{{$v['description']}}</td>
                            </tr>
                        </table>
                    @endforeach
                </div>
                <div class="table-wrapper">
                    <div class="table-header"><i class="iconfont icon-shouye2"></i>险种</div>
                    <table class="variety" cellspacing='4'>
                        @foreach($detail->protect_items as $k=>$v)
                            @if($k == 0)
                                <tr><td><i class="zicon-main"></i>{{$v['name']}}</td></tr>
                                    @else
                                        <tr><td><i class="zicon-minor"></i>{{$v['name']}}</td></tr>
                            @endif
                        @endforeach
                    </table>

                </div>
                <ul class="selling">
                    @if(!is_null($detail->selling))
                        @foreach(json_decode($detail->selling,true) as $k=>$v)
                            <li class="table-wrapper"><span>卖点{{$k+1}}：</span>{{$v}}</li>
                        @endforeach
                    @endif
                </ul>
        </div>
    </div>
</div>
<div class="information-wrapper">
    <div class="information">
        <div class="user-img"><img src="{{config('view_url.agent_url')}}img/girl.png" alt="" /></div>
        <p><span class="user-name">{{$agent_detail->name}}</span>vip服务专员<span class="user-grade">评分<i class="red">5.0</i></span></p>
        <p class="tel">联系电话：<i class="color-positive">{{$agent_detail->phone}}</i></p>
        <div class="evaluate"><span>专业</span><span>耐心</span><span>按需定制</span></div>
        <div class="user-operate">
            <a href="{{$detail->url}}" class="z-btn z-btn-positive">立即投保</a>
            {{--<button class="z-btn-hollow">个人信息修改</button>--}}
            <button id="feedback" class="z-btn-hollow" style="margin-right: 0;">意见反馈</button>
        </div>
    </div>
</div>

<div class="popups-wrapper popups-feedback">
    <div class="popups">
        <div class="popups-title">信息反馈<i class="iconfont icon-close"></i></div>
        <div class="popups-content">
            <form action="" method="post">
            <ul class="feedback">
                <li>
                    <span class="name">客服满意度</span>
                    <div id="score1" class="evaluate-content clearfix">
                        <div class="star_score"></div>
                        <p class="score"><span class="fenshu">0</span>分</p>
                        <input hidden type="text" value="5" name="agent_grade"/>
                    </div>
                </li>
                <li>
                    <span class="name">客服印象</span>
                    <div class="impress">
                        @foreach($lables as $v)
                        <label>
                            <span>{{$v['name']}}</span>
                            <input hidden type="checkbox" name="agent_lables[]" />
                        </label>
                            @endforeach
                    </div>
                </li>
                <li>
                    <span class="name">客服意见反馈</span>
                    <textarea name="agent_content" placeholder="请填写详细的反馈说明"></textarea>
                </li>
                <li>
                    <span class="name">产品满意度</span>
                    <div id="score2" class="evaluate-content clearfix">
                        <div class="star_score"></div>
                        <p class="score"><span class="fenshu">0</span>分</p>
                        <input hidden type="text" value="5" name="product_grade"/>
                    </div>
                </li>
                <li>
                    <span class="name">产品印象</span>
                    <div class="impress">
                        <label>
                            <span>态度好</span>
                            <input hidden type="checkbox" name="product_lables[]" />
                        </label>
                    </div>
                </li>
                <li>
                    <span class="name">产品意见反馈</span>
                    <textarea name="product_content" placeholder="请填写详细的反馈说明"></textarea>
                </li>
            </ul>
            </form>
            <button id="sendFeedback" class="z-btn z-btn-positive" disabled>提交</button>
        </div>
    </div>
</div>


<div class="popups-wrapper popups-success">
    <div class="popups">
        <div class="popups-title">信息反馈<i class="iconfont icon-close"></i></div>
        <div class="popups-content">
            <i class="iconfont icon-chenggong"></i>
            <p>提交成功</p>
            <div>
                <button class="z-btn z-btn-positive">查看相似产品</button>
            </div>
        </div>
    </div>
</div>






<script src="{{config('view_url.agent_url')}}js/lib/jquery-1.11.3.min.js"></script>
<script src="{{config('view_url.agent_url')}}js/common_agent.js"></script>
<script>
    // 初始化
    scoreFun($("#score1"));
    scoreFun($("#score2"));
    $('.impress span').click(function(){
        $(this).toggleClass('selected');
    });
    var Ele = {
        popups_feedback: $(".popups-feedback"),
        sendFeedback: $('#sendFeedback'),
    }

    // 信息反馈
    $('#feedback').click(function(){
        Popups.open('.popups-feedback');
    });

    // 是否可提交反馈信息

    Ele.popups_feedback.find('textarea').bind('input porpertychange',function(){
        Ele.popups_feedback.find('textarea').each(function(index){
            if(!$(this).val()){
                Ele.sendFeedback[0].disabled = true;
                return false;
            }
            if(index == Ele.popups_feedback.find('textarea').length-1){
                Ele.sendFeedback[0].disabled = false;
            }
        });
    });

    // 提交反馈信息
    Ele.sendFeedback.click(function(){
        // 表单提交

        // 成功提交数据显示
        Popups.close('.popups-feedback');
        Popups.open('.popups-success');
    });

</script>
</body>
</html>
