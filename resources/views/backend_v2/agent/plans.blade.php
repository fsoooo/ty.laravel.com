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
            <div class="ui-table col-lg-12">
                <div class="ui-table-header radius">
                    <span class="col-md-1">制作时间</span>
                    <span class="col-md-1">计划书名称</span>
                    <span class="col-md-2">产品名称</span>
                    <span class="col-md-2">公司</span>
                    <span class="col-md-1">保费（元）</span>
                    <span class="col-md-1">佣金（元）</span>
                    <span class="col-md-1">代理人佣金（元）</span>
                    <span class="col-md-2 col-one">操作</span>
                </div>
                <div class="ui-table-body">
                    <ul>
                        @foreach($lists as $k => $v)
                            <li class="ui-table-tr">
                                <div class="col-md-1">{{ $v->planList->created_at }}</div>
                                <div class="col-md-1">{{ $v->planList->name }}</div>
                                <div class="col-md-2">{{ $v->product->product_name }}</div>
                                <div class="col-md-2">{{ $v->product->company_name }}</div>
                                <div class="col-md-1">{{ $v->premium / 100 }}</div>
                                <div class="col-md-1">{{ $v->companyBrokerage->brokerage / 100 }}</div>
                                <div class="col-md-1">{{ $v->order_brokerage->user_earnings / 100 }}</div>
                                <div class="col-md-2 text-right">
                                    <a href="{{url('/backend/agent/plan/' . $agent->id . '?plan_id=' . $v->planList->id)}}" class="btn btn-primary">查看详情</a>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <div class="row text-center">
            {{ $lists->links() }}
        </div>
    </div>
@stop
@section('footer-more')
    <script>

    </script>
@stop