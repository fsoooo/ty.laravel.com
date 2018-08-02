@extends('backend_v2.layout.base')
@section('title')@parent 客户管理 @stop
@section('head-more')
    <link rel="stylesheet" href="{{asset('r_backend/v2/css/client.css')}}" />
@stop

@section('top_menu')
    @include('backend_v2.customer.top', ['type' => 'company'])
@stop
@section('main')
    <div class="main-wrapper">
        <!--企业客户页面显示-->
        <div class="row">
            <div class="ui-table col-lg-12">
                <div class="ui-table-header radius">
                    <span class="col-md-2">企业名称</span>
                    {{--<span class="col-md-2">企业类型</span>--}}
                    <span class="col-md-1">联系人姓名</span>
                    <span class="col-md-2">联系方式</span>
                    <span class="col-md-1">投保次数</span>
                    <span class="col-md-1">产生保额(元)</span>
                    <span class="col-md-1">产生佣金(元)</span>
                    <span class="col-md-2 col-one">操作</span>
                </div>
                <div class="ui-table-body">
                    <ul>
                        @foreach($users as $user)
                            <li class="ui-table-tr">
                                <div class="col-md-2 ellipsis" title="{{ $user->name }}">{{ $user->name }}</div>
                                {{--<div class="col-md-2">互联网-软件</div>--}}
                                <div class="col-md-1">{{ $user->name }}</div>
                                <div class="col-md-2">{{ $user->email }}</div>
                                <div class="col-md-1">{{ $user->insure_count }}</div>
                                <div class="col-md-1">{{ $user->premium }}</div>
                                <div class="col-md-1">{{ $user->brokerage }}</div>
                                <div class="col-md-2 text-right"><a href="{{ route('backend.customer.company.detail', [$user->id]) }}" class="btn btn-primary">查看详情</a></div>
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