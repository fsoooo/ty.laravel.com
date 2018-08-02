@extends('backend_v2.layout.base')
@section('title')@parent 代理人详情 @stop
@section('head-more')
    <link rel="stylesheet" href="{{asset('r_backend/v2/css/agent.css')}}" />
@stop

@section('top_menu')
    @include('backend_v2.agent.top_menu')
@stop
@section('main')
    <div id="info" class="main-wrapper">
        @include('backend_v2.agent.agent_top')
        <div class="row">
            <div class="col-lg-4" style="padding-left: 10px;">
                <div class="plan-wrapper">
                    <h2 class="title">计划书信息</h2>
                    <div class="plan-content">
                        <h3 class="name">{{ $res->name }}</h3>
                        <ul class="plan-list">
                            <li>计划书状态：已发送</li>
                            {{--<li>发送途径：QQ </li>--}}
                            <li>创建时间：{{ $res->created_at }}</li>
                            <li>客户阅读时间：{{ $res->read_time }}</li>
                            <li>客户支付时间：{{ $res->order->pay_time ? $res->order->pay_time : '2017-10-17 14:20' }}</li>
                            @if($res->order->warranty_rule->warranty)
                            <li>出单时间：{{ $res->order->warranty_rule->warranty->created_at }}</li>
                            @else
                                <li>未出单</li>
                            @endif
                        </ul>
                    </div>
                </div>

            </div>
            <div class="col-lg-4" style="padding-left: 10px;">
                <div class="plan-wrapper">
                    <h2 class="title">产品信息</h2>
                    <div class="plan-content">
                        <h3 class="name">{{ $res->product->product_name }}</h3>
                        <ul class="plan-list">
                            @if($res->order->warranty_rule->warranty)
                                <li>保障时间：{{ $res->order->warranty_rule->warranty->start_time }} 至 {{ $res->order->warranty_rule->warranty->end_time }}</li>
                            @else
                                <li>未出单</li>
                            @endif
                            <li>保费：{{ $res->order->premium }}</li>
                            <li>缴费方式：{{ $res->order->by_stages_way }}</li>
                            <li>保障金额：
                                @foreach($protect_item as $k => $v)
                                    {{  $v['name']. ":" .$v['defaultValue'] }}
                                @endforeach
                            </li>
                            <li>佣金比率：{{ $res->order->order_brokerage->rate }}%</li>
                            <li>佣金金额： {{ $res->order->order_brokerage->user_earnings / 100 }} 元</li>
                            <li>支付金额：{{ $res->order->premium / 100 }} 元</li>
                        </ul>
                    </div>
                </div>

            </div>

            <div class="col-lg-4" style="padding-left: 10px;">
                <div class="plan-wrapper">
                    <h2 class="title">客户信息</h2>
                    <div class="plan-content">
                        <h3 class="name">客户姓名</h3>
                        <ul class="plan-list">
                            <li>被保人姓名：{{ $res->order->warranty_recognizee[0]->name }}</li>
                            {{--<li>投保人与被保人关系：本人</li>--}}
                            {{--<li>被保人性别：男</li>--}}
                            {{--<li>被保人年龄：27</li>--}}
                            <li>投保人姓名：{{ $res->order->warranty_rule->policy->name }}</li>
                            <li>投保人联系方式：{{ $res->order->warranty_rule->policy->phone }}</li>
                            <li>投保人联系邮箱：{{ $res->order->warranty_rule->policy->email }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@section('footer-more')
    <script>

    </script>
@stop