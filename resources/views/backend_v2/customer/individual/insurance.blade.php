@extends('backend_v2.layout.base')
@section('title')@parent 代理商详情 @stop
@section('head-more')
    <link rel="stylesheet" href="{{asset('r_backend/v2/css/client_details.css')}}" />
@stop

@section('top_menu')
    @include('backend_v2.customer.top', ['type' => 'user'])
@stop
@section('main')
    <div class="main-wrapper info">
        <div class="row">
            <ol class="breadcrumb col-lg-12">
                <li><a href="{{ route('backend.customer.individual.index') }}">客户管理</a><i class="iconfont icon-gengduo"></i></li>
                <li><a href="{{ route('backend.customer.individual.index') }}">个人客户</a><i class="iconfont icon-gengduo"></i></li>
                <li class="active">{{ $user->name }}</li>
            </ol>
        </div>

    @include('backend_v2.customer.individual.nav', ['type' => 'insurance'])

        <div class="row">
            <div class="ui-table col-lg-12">
                <div class="ui-table-header radius">
                    <span class="col-md-1">购买时间</span>
                    <span class="col-md-2">保单号</span>
                    <span class="col-md-1">产品名称</span>
                    <span class="col-md-1">险种</span>
                    <span class="col-md-1">公司</span>
                    <span class="col-md-1">投保人</span>
                    <span class="col-md-1">保费(元)</span>
                    <span class="col-md-1">佣金(元)</span>
                    <span class="col-md-1">代理人</span>
                    <span class="col-md-2 col-one">操作</span>
                </div>
                <div class="ui-table-body">
                    <ul>
                        @foreach($lists as $list)
                            @if(!empty($list->warranty_code))
                                <li class="ui-table-tr">
                                    <div class="col-md-1">{{ date('Y-m-d', strtotime($list->pay_time)) }}</div>
                                    <div class="col-md-2">{{ $list->warranty_code }}</div>
                                    <div class="col-md-1">{{ $list->product_name }}</div>
                                    <div class="col-md-1">{{ $list->category }}</div>
                                    <div class="col-md-1">{{ $list->company }}</div>
                                    <div class="col-md-1">{{ $list->recognizee_name }}</div>
                                    <div class="col-md-1">{{ $list->premium }}</div>
                                    <div class="col-md-1">{{ $list->brokerage }}</div>
                                    <div class="col-md-1">{{ $list->agent_name }}</div>
                                    <div class="col-md-2 text-right"><a href="{{ route('backend.customer.individual.warranty', [$list->id]) }}" class="btn btn-primary">查看详情</a></div>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <div class="row text-center">
            {{ $lists->links() }}
        </div>
    </div>

    <script src="{{asset('r_backend/v2/js/lib/jquery-1.11.3.min.js')}}"></script>
    <script src="{{asset('r_backend/v2/js/lib/echarts.js')}}"></script>
    <script src="{{asset('r_backend/v2/js/lib/bootstrap.min.js')}}"></script>
    <script src="{{asset('r_backend/v2/js/common_backend.js')}}"></script>
@stop