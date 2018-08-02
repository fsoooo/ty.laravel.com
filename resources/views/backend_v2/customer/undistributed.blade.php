@extends('backend_v2.layout.base')
@section('title')@parent 代理商详情 @stop
@section('head-more')
    <link rel="stylesheet" href="{{asset('r_backend/v2/css/client_details.css')}}" />
@stop

@section('top_menu')
    @include('backend_v2.customer.top', ['type' => 'unverified'])
@stop
@section('main')
    <div class="main-wrapper">
        <div class="row">
            <div class="section">
                <div class="col-lg-6 col-xs-6">
                    <a href="/backend/customer/unverified" class="section-item">待实名审核 </a>
                </div>
                <div class="col-lg-6 col-xs-6">
                    <a href="/backend/customer/undistributed" class="section-item active">分配代理人</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="ui-table col-lg-12">
                <div class="ui-table-header radius">
                    <span class="col-md-2">客户姓名</span>
                    <span class="col-md-2">证件类型</span>
                    <span class="col-md-3">证件号</span>
                    <span class="col-md-2">联系方式</span>
                    {{--<span class="col-md-4">客户来源</span>--}}
                    <span class="col-md-2 col-one" style="padding-right: 70px;">操作</span>
                </div>
                <div class="ui-table-body table-single-line">
                    <ul>

                        @foreach($users as $user)
                            <li class="ui-table-tr">
                                <div class="col-md-2">{{ $user->name }}</div>
                                <div class="col-md-2">身份证</div>
                                <div class="col-md-3">{{ $user->code }}</div>
                                <div class="col-md-2">{{ $user->phone }}</div>
                                {{--<div class="col-md-4">自主注册</div>--}}
                                <div class="col-md-2 text-right"><a href="{{ route('backend.customer.allocate_agent', [$user->id]) }}" class="btn btn-primary" style="width: 92px;">分配代理人</a></div>
                            </li>
                        @endforeach

                    </ul>
                </div>
            </div>
        </div>

        <div class="row text-center">
            {{ $users->links() }}
        </div>
    </div>
@stop