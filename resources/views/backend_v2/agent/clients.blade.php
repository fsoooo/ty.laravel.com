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
        <div class="row select-wrapper">
            <div class="col-lg-12">
                <a href="{{ url('/backend/agent/clients/' . $agent->id) }}" class="btn-select @if(!isset($input['type'])) active @endif">个人客户</a>
                <a href="{{ url('/backend/agent/clients/' . $agent->id) . '?type=firm'}}" class="btn-select @if(isset($input['type']) && $input['type']=='firm') active @endif">企业客户</a>
                {{--<a href="" class="btn-select">组织团体</a>--}}
            </div>
        </div>
            <!--个人客户start-->
            <div class="row">
                <div class="ui-table col-lg-12">
                    <div class="ui-table-header radius">
                        @if(isset($input['type']) && ($input['type'] == 'firm'))
                            <span class="col-md-1">客户姓名</span>
                        @else
                            <span class="col-md-1">公司名称</span>
                        @endif
                        {{--<span class="col-md-1">证件类型</span>--}}
                        {{--<span class="col-md-2">证件号</span>--}}
                        <span class="col-md-2">联系方式</span>
                        <span class="col-md-1">投保次数</span>
                        {{--<span class="col-md-1">被保次数</span>--}}
                        <span class="col-md-1">产生总保费</span>
                        <span class="col-md-1" style="width:10%">产生总佣金
                            （当前代理人）</span>
                        <span class="col-md-2 col-one">操作</span>
                    </div>
                    <div class="ui-table-body">
                        <ul>
                            @foreach($agent->customers as $k => $v)
                                <li class="ui-table-tr">
                                    <div class="col-md-1">{{ $v->user->name ? $v->user->name : '--'}}</div>
                                    {{--<div class="col-md-1">身份证</div>--}}
                                    {{--<div class="col-md-2">{{ $v->user->code ? $v->user->code : '--'}}</div>--}}
                                    <div class="col-md-2">{{ $v->user->phone }}</div>
                                    <div class="col-md-1">{{ count($v->user->order) }}</div>
                                    {{--<div class="col-md-1">2</div>--}}
                                    <div class="col-md-1">{{ $v->user->order->sum('premium') / 100 }} 元</div>
                                    <div class="col-md-1">{{ $v->user->order->sum('order_brokerage.user_earnings') / 100 }} 元</div>
                                    <div class="col-md-2 text-right">
                                        @if($v->user->type == 'user')
                                        <a href="{{route('backend.customer.individual.detail', [$v->user->id])}}">
                                            <button class="btn btn-primary">查看详情</button>
                                        </a>
                                            @else
                                            <a href="{{route('backend.customer.company.detail', [$v->user->id])}}">
                                                <button class="btn btn-primary">查看详情</button>
                                            </a>
                                        @endif
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <!--个人客户end-->


            {{--<!--企业客户start-->--}}
            {{--<div class="row">--}}
                {{--<div class="ui-table col-lg-12">--}}
                    {{--<div class="ui-table-header radius">--}}
                        {{--<span class="col-md-2">企业名称</span>--}}
                        {{--<span class="col-md-2">企业类型</span>--}}
                        {{--<span class="col-md-1">联系人姓名</span>--}}
                        {{--<span class="col-md-2">联系方式</span>--}}
                        {{--<span class="col-md-1">投保次数</span>--}}
                        {{--<span class="col-md-1">产生保额</span>--}}
                        {{--<span class="col-md-1">产生佣金</span>--}}
                        {{--<span class="col-md-2 col-one">操作</span>--}}
                    {{--</div>--}}
                    {{--<div class="ui-table-body">--}}
                        {{--<ul>--}}
                            {{--<li class="ui-table-tr">--}}
                                {{--<div class="col-md-2">北京天眼互联科技有限公司…</div>--}}
                                {{--<div class="col-md-2">互联网-软件</div>--}}
                                {{--<div class="col-md-1">上官上官</div>--}}
                                {{--<div class="col-md-2">13911195495</div>--}}
                                {{--<div class="col-md-1">2</div>--}}
                                {{--<div class="col-md-1">50000</div>--}}
                                {{--<div class="col-md-1">10500</div>--}}
                                {{--<div class="col-md-2 text-right"><button class="btn btn-primary">查看详情</button></div>--}}
                            {{--</li>--}}
                        {{--</ul>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
            {{--<!--企业客户end-->--}}


            {{--<!--组织团体start-->--}}
            {{--<div class="row">--}}
                {{--<div class="ui-table col-lg-12">--}}
                    {{--<div class="ui-table-header radius">--}}
                        {{--<span class="col-md-2">用户名称</span>--}}
                        {{--<span class="col-md-2">类型</span>--}}
                        {{--<span class="col-md-1">联系人姓名</span>--}}
                        {{--<span class="col-md-2">联系电话</span>--}}
                        {{--<span class="col-md-1">投保次数</span>--}}
                        {{--<span class="col-md-1">产生保额</span>--}}
                        {{--<span class="col-md-1">产生佣金</span>--}}
                        {{--<span class="col-md-2 col-one">操作</span>--}}
                    {{--</div>--}}
                    {{--<div class="ui-table-body">--}}
                        {{--<ul>--}}
                            {{--<li class="ui-table-tr">--}}
                                {{--<div class="col-md-2">富瑞苑足球…</div>--}}
                                {{--<div class="col-md-2">社会团体</div>--}}
                                {{--<div class="col-md-1">上官铁柱</div>--}}
                                {{--<div class="col-md-2">13911195495</div>--}}
                                {{--<div class="col-md-1">2</div>--}}
                                {{--<div class="col-md-1">50000</div>--}}
                                {{--<div class="col-md-1">10500</div>--}}
                                {{--<div class="col-md-2 text-right"><button class="btn btn-primary">查看详情</button></div>--}}
                            {{--</li>--}}
                        {{--</ul>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
    </div>
@stop
@section('footer-more')
    <script>

    </script>
@stop