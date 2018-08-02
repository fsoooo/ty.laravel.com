<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>订单详情</title>
    <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
    <link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/lib/mui.min.css">
    <link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/lib/iconfont.css" />
    <link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/common_agent.css" />
    <style>
        body{background: #f4f4f4;}
        .mui-content{padding-top: .88rem;}
        .section{width: 96%;margin: .2rem auto;padding: .2rem;background: #fff;border-radius: 4px;}
        .title{font-size: .28rem;color: #00a2ff;}
        #call{text-decoration: underline;}
    </style>
</head>
<body>
<div class="main">
    <header id="header" class="mui-bar mui-bar-nav">
        <a class="iconfont icon-fanhui mui-pull-left mui-action-back"></a>
        <h1 class="mui-title">订单详情</h1>
    </header>
    <div class="mui-scroll-wrapper">
        <div class="mui-scroll">
            <div class="mui-content">


                <!--从计划书进入显示start-->
                <div class="section">
                    <h3 class="title">计划书信息:</h3>
                    <ul>
                        <li><span>计划书编号:</span>{{$data['id']}}</li>
                        <li><span>计划书名称：</span>{{$data['name']}}</li>
                        <li><span>计划书状态：</span>
                            @if($data['status'] == 0)
                                未发送
                            @else
                                已发送
                            @endif
                        </li>
                        <li><span>发出时间：</span>
                            @if($data['send_time'])
                                {{date('Y-m-d H:i:s',$data['send_time'])}}
                                @else
                                未发送
                                @endif
                        </li>
                        <li><span>客户阅读时间：</span>
                            @if($data['read_time'])
                                {{$data['read_time']}}
                                @else
                            未阅读
                                @endif
                        </li>
                        <li><span>客户支付时间：</span>
                            @if($data->order['status'] == 1)
                                {{$data->order['pay_time']}}
                                @else
                            未支付
                                @endif
                        </li>
                        <li><span>出单时间：</span>
                            @if($data->order && $data->order->warranty_rule && $data->order->warranty_rule->warranty)
                                {{$data->order->warranty_rule->warranty['created_at']}}
                                @else
                            未出单
                                @endif
                        </li>
                    </ul>
                </div>
                <!--从计划书进入显示end-->


                <div class="section">
                    <h3 class="title">产品信息:</h3>
                    <ul>
                        <li><span>产品名称：</span>{{$data->product['product_name']}}</li>
                        <li><span>保障时间：</span>
                            @if($data->order['status'] == 1)
                                {{$data->order['start_time']}}起
                                @else
                                自购买时填选之日起
                            @endif
                        </li>
                        <li><span>总保费：</span>
                            @if($data->order['status'] == 1)
                                {{$data->order['premium']/100}}元
                            @else
                                {{$data->product['base_price']/100}}元
                            @endif
                        </li>
                        <li><span>支付方式：</span>
                            @if($data->order['status'] == 1 && preg_replace('/\D/s','',$data->order['by_stages_way']) == 0)
                                趸交
                            @else
                                该订单未支付
                            @endif
                        </li>
                        <li><span>保障金额：</span>200万元</li>
                        <li><span>保单状态：</span>
                            @if($data->order && $data->order->warranty_rule && $data->order->warranty_rule->warranty && $data->order->warranty_rule->warranty['status'] == 0)
                                待生效
                                @elseif($data->order && $data->order->warranty_rule && $data->order->warranty_rule->warranty && $data->order->warranty_rule->warranty['status'] == 1)
                            保障中
                                @elseif($data->order && $data->order->warranty_rule && $data->order->warranty_rule->warranty && $data->order->warranty_rule->warranty['status'] == 2)
                            失效
                                @elseif($data->order && $data->order->warranty_rule && $data->order->warranty_rule->warranty && $data->order->warranty_rule->warranty['status'] == 3)
                            退保
                                @else
                                --
                                @endif

                        </li>
                        <li><span>佣金比率：</span><span class="color-positive">{{$data['rate']['earning']}}%</span></li>
                        <li><span>佣金金额：</span><span class="color-positive">{{$data->product->base_price/100*$data['rate']['earning']/100}}元</span></li>
                        <li><span>支付金额：</span><span class="color-positive">
                                @if($data->order['status'] == 1)
                                    {{$data->order['premium']}}
                                    @else
                                未支付
                                    @endif
                            </span></li>
                    </ul>
                </div>
                @if($data->product['insure_type'] == 1)
                <div class="section">
                    <h3 class="title">客户信息:</h3>
                    <ul>
                        @if(isset($data->order))
                        <li><span>投保人姓名：</span>{{$data->order->warranty_rule->policy['name']}}</li>
                        @else
                            <li><span>投保人姓名：</span>--</li>
                            @endif
                        <li><span>被保人姓名：</span>{{$data->user['real_name']}}</li>
                        <li><span>被保人是投保人的：</span>
                            @if(isset($data->order->warranty_recognizee))
                            @if($data->user['type'] == 'user')
                                @if($data->order->warranty_recognizee[0]['relation'] == 1)
                                本人
                                @elseif($data->order->warranty_recognizee[0]['relation'] == 2)
                                    妻子
                                @elseif($data->order->warranty_recognizee[0]['relation'] == 3)
                                    丈夫
                                @elseif($data->order->warranty_recognizee[0]['relation'] == 4)
                                    儿子
                                @elseif($data->order->warranty_recognizee[0]['relation'] == 5)
                                    女儿
                                @elseif($data->order->warranty_recognizee[0]['relation'] == 6)
                                    父亲
                                @elseif($data->order->warranty_recognizee[0]['relation'] == 7)
                                    母亲
                                @elseif($data->order->warranty_recognizee[0]['relation'] == 8)
                                    兄弟
                                @elseif($data->order->warranty_recognizee[0]['relation'] == 9)
                                    姐妹
                                @elseif($data->order->warranty_recognizee[0]['relation'] == 10)
                                    祖父/祖母/外祖父/外祖母
                                @elseif($data->order->warranty_recognizee[0]['relation'] == 11)
                                    孙子/孙女/外孙/外孙女
                                @elseif($data->order->warranty_recognizee[0]['relation'] == 12)
                                    叔父/伯父/舅舅
                                @elseif($data->order->warranty_recognizee[0]['relation'] == 13)
                                    婶/姨/姑
                                @elseif($data->order->warranty_recognizee[0]['relation'] == 14)
                                    侄子/侄女/外甥/外甥女
                                @else
                                --
                                @endif
                                @else
                                员工
                                @endif
                                @endif
                        </li>
                        <li><span>被保人性别：</span>
                            @if($data->user['code'] && substr($data->user['code'],16,1)%2 == 1)
                                男
                                @elseif($data->user['code'] && substr($data->user['code'],16,1)%2 == 0)
                            女
                                @else
                            --
                                @endif
                        </li>
                        <li><span>被保人年龄：</span>
                            @if($data->user['code'])
                                {{date('Y',time())-substr($data->user['code'],6,4)}}岁
                            @else
                                --
                            @endif
                        </li>
                        <li><span>投保人联系方式：</span><span id="call" class="color-primary">
                                @if(isset($data->order->warranty_rule->policy))
                                    {{$data->order->warranty_rule->policy['phone']}}
                                    @else
                                --
                                    @endif
                            </span></li>
                        <li><span>投保人邮箱：</span>
                            @if(isset($data->order->warranty_rule->policy))
                                {{$data->order->warranty_rule->policy['email']}}
                            @else
                                --
                            @endif
                        </li>
                        <li><span>客户信息反馈：</span>产品不满意</li>
                        <li><span>客户评论：</span>服务态度很好，产品价位调整后很合理</li>
                    </ul>
                </div>
                    @else
                    <div class="section">
                        <h3 class="title">客户信息:</h3>
                        <ul>
                            <li><span>企业名称：</span>{{$data->user['real_name']}}</li>
                            {{--<li><span>企业性质：</span>IT行业</li>--}}
                            <li><span>企业联系人：</span>{{isset($data->user->trueFirmInfo)?$data->user->trueFirmInfo['ins_principal']:'--'}}</li>
                            <li><span>联系人手机号码：</span><span id="call" class="color-primary">{{isset($data->user->trueFirmInfo)?$data->user->trueFirmInfo['ins_phone']:'--'}}</span></li>
                            <li><span>联系人邮箱：</span>{{$data->user['email']}}</li>
                            <li><span>投保人数：</span>{{count($data->order->warranty_recognizee)}}</li>
                            <li><span>客户信息反馈：</span>产品不满意</li>
                            <li><span>客户评论：</span>服务态度很好，产品价位调整后很合理</li>
                        </ul>
                    </div>
                    @endif
            </div>
        </div>
    </div>
</div>

<div class="mui-popover popover-call">
    <div class="popover-wrapper">
        <div class="popover-content">
            @if(isset($data->order->warranty_rule->policy))
                <p>{{$data->order->warranty_rule->policy['name']}}</p>
            @else
                <p>--</p>
            @endif
            @if(isset($data->order->warranty_rule->policy))
                <p class="tel">{{$data->order->warranty_rule->policy['phone']}}</p>
            @else
                --
            @endif

        </div>
        <div class="popover-footer">
            @if(isset($data->order->warranty_rule->policy))
                <a href="sms:{{$data->order->warranty_rule->policy['phone']}}" class="zbtn zbtn-hollow">短信</a>
                <a href="tel:{{$data->order->warranty_rule->policy['phone']}}" class="zbtn zbtn-default">呼叫</a>
            @else
                <a href="javascript:;" class="zbtn zbtn-hollow">短信</a>
                <a href="javascript:;" class="zbtn zbtn-default">呼叫</a>
            @endif

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
