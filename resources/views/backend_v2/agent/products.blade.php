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
                    <span class="col-md-2">代理产品</span>
                    <span class="col-md-1">产品类型</span>
                    <span class="col-md-2">公司名称</span>
                    <span class="col-md-1">购买人数</span>
                    <span class="col-md-2">保费总额(元)</span>
                    <span class="col-md-2">佣金总额(元)</span>
                    <span class="col-md-2">代理人佣金(元)</span>
                </div>
                <div class="ui-table-body">
                    <ul>
                        @foreach($agent->orders as $ok => $ov)
                            <li class="ui-table-tr">
                                <div class="col-md-2">{{$ov->product->product_name}}</div>
                                <div class="col-md-1">{{$ov->product->insure_type == 1 ? '个险' : '团险'}}</div>
                                <div class="col-md-2">{{$ov->product->company_name}}</div>
                                <div class="col-md-1">{{$ov->order_brokerage->num}}</div>
                                <div class="col-md-2">{{$ov->premium / 100}}</div>
                                <div class="col-md-2">{{$ov->companyBrokerage->c_brokerage / 100}}</div>
                                <div class="col-md-2">{{$ov->order_brokerage->user_earnings / 100}}</div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
@stop
@section('footer-more')
    <script>

    </script>
@stop