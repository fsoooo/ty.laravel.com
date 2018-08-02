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
                <li><a href="#">客户管理</a><i class="iconfont icon-gengduo"></i></li>
                <li><a href="#">个人客户</a><i class="iconfont icon-gengduo"></i></li>
                <li class="active">{{ $user->name }}</li>
            </ol>
        </div>

    @include('backend_v2.customer.individual.nav')

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
                            <li class="ui-table-tr">
                                <div class="col-md-1">2017-09-26</div>
                                <div class="col-md-2">2145784145236584</div>
                                <div class="col-md-1">测试产品一</div>
                                <div class="col-md-1">意外险</div>
                                <div class="col-md-1">中国人寿</div>
                                <div class="col-md-1">王大力</div>
                                <div class="col-md-1">8000</div>
                                <div class="col-md-1">2000</div>
                                <div class="col-md-1">迪丽热巴</div>
                                <div class="col-md-2 text-right"><a href="agent2_plan_details.html" class="btn btn-primary">查看详情</a></div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

    </div>

    <script src="{{asset('r_backend/v2/js/lib/jquery-1.11.3.min.js')}}"></script>
    <script src="{{asset('r_backend/v2/js/lib/echarts.js')}}"></script>
    <script src="{{asset('r_backend/v2/js/lib/bootstrap.min.js')}}"></script>
    <script src="{{asset('r_backend/v2/js/common_backend.js')}}"></script>
@stop