@extends('backend_v2.layout.base')
@section('title')@parent 代理商详情 @stop
@section('head-more')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
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

    @include('backend_v2.customer.company.nav', ['type' => 'verification'])

        <div class="row">
            <div class="col-lg-12">
                <div class="ui-table-tr" style="line-height: 30px;">
                    <div class="col-lg-12 color-default" style="font-size: 16px;font-weight: bold;">{{ $user->name }}</div>
                    <div class="col-md-3">注册时间：<span>{{ $user->created_at }}</span></div>
                    <div class="col-md-3">联系方式：<span>{{ $user->phone }}</span></div>
                    <div class="col-md-2">证件类型：<span>身份证</span></div>
                    <div class="col-md-4">证件号码：<span>{{ $user->code }}</span></div>
                </div>
            </div>
        </div>

        <div class="row autonym">
            @if(empty($user->card_img_front) || empty($user->card_img_backend) || empty($user->license_img) || empty($user->code))
                <div class="col-lg-12">
                    <div class="certificate">
                        <div class="img-wrapper col-lg-3">
                            @if(empty($user->code))
                                没有证件号码
                            @endif
                            @if(empty($user->card_img_front) || empty($user->card_img_backend) || empty($user->license_img))
                                没有上传全部证件文件
                            @endif
                        </div>
                    </div>
                </div>
                @if($user->status != 2)
                    <div class="operation">
                        <button class="btn btn-primary" data-toggle="modal" data-target="#pass" disabled id="pass-button">通过审核</button>
                        <button class="btn btn-warning" data-toggle="modal" data-target="#notPass" disabled id="not-pass-button">审核不通过</button>
                    </div>
                @endif
            @else
                <div class="col-lg-12">
                    <div class="certificate">
                        <h2 class="title">证件信息</h2>
                        <div class="img-wrapper col-lg-3">
                            <img src="{{ rtrim(env('APP_URL'), '/'). '/' . $user->card_img_front }}" alt="" /><span class="btn btn-default" data-toggle="modal" data-target="#larger-1">查看大图</span>
                        </div>
                        <div class="img-wrapper col-lg-3">
                            <img src="{{ rtrim(env('APP_URL'), '/'). '/' . $user->card_img_backend }}" alt="" /><span class="btn btn-default" data-toggle="modal" data-target="#larger-2">查看大图</span>
                        </div>
                        <div class="img-wrapper col-lg-3">
                            <img src="{{ rtrim(env('APP_URL'), '/'). '/' . $user->license_img }}" alt="" /><span class="btn btn-default" data-toggle="modal" data-target="#larger-3">查看大图</span>
                        </div>
                    </div>
                </div>
                <div class="operation">
                    <button class="btn btn-primary" data-toggle="modal" data-target="#pass" id="pass-button">通过审核</button>
                    <button class="btn btn-warning" data-toggle="modal" data-target="#notPass" id="not-pass-button">审核不通过</button>
                </div>
            @endif
        </div>
    </div>

    <!--查看大图-->
    <div class="modal fade in" id="larger-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-alert" role="document">
            <div class="modal-content">
                <div class="modal-header notitle">
                    <button type="button" class="" data-dismiss="modal" aria-label="Close"><i class="iconfont icon-cancel"></i></button>
                </div>
                <div class="modal-body">
                    <img src="{{ env('APP_URL') . $user->card_img_front }}" alt="" />
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade in" id="larger-2" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-alert" role="document">
            <div class="modal-content">
                <div class="modal-header notitle">
                    <button type="button" class="" data-dismiss="modal" aria-label="Close"><i class="iconfont icon-cancel"></i></button>
                </div>
                <div class="modal-body">
                    <img src="{{ env('APP_URL') . $user->card_img_backend }}" alt="" />
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade in" id="larger-3" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-alert" role="document">
            <div class="modal-content">
                <div class="modal-header notitle">
                    <button type="button" class="" data-dismiss="modal" aria-label="Close"><i class="iconfont icon-cancel"></i></button>
                </div>
                <div class="modal-body">
                    <img src="{{ env('APP_URL') . $user->card_img_person }}" alt="" />
                </div>
            </div>
        </div>
    </div>

    <!--审核通过-->
    {{--<div class="modal fade in" id="pass" role="dialog" aria-labelledby="myModalLabel">--}}
        {{--<div class="modal-dialog modal-alert modal-nofooter" role="document">--}}
            {{--<div class="modal-content">--}}
                {{--<div class="modal-header notitle">--}}
                    {{--<button type="button" class="" data-dismiss="modal" aria-label="Close"><i class="iconfont icon-cancel"></i></button>--}}
                {{--</div>--}}
                {{--<div class="modal-body">--}}
                    {{--<i class="iconfont icon-duihao"></i>--}}
                    {{--<p>审核通过</p>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}
    {{--<!--审核不通过-->--}}
    {{--<div class="modal fade in" id="notPass" role="dialog" aria-labelledby="myModalLabel">--}}
        {{--<div class="modal-dialog modal-alert modal-cause" role="document">--}}
            {{--<div class="modal-content">--}}
                {{--<div class="modal-header notitle">--}}
                    {{--<button type="button" class="" data-dismiss="modal" aria-label="Close"><i class="iconfont icon-cancel"></i></button>--}}
                {{--</div>--}}
                {{--<div class="modal-body">--}}
                    {{--<i class="iconfont icon-warning"></i>--}}
                    {{--<p>审核未通过</p>--}}
                    {{--<div class="cause-wapper">--}}
                        {{--<p class="title">未通过原因:</p>--}}
                        {{--<textarea class="cause-text"></textarea>--}}
                        {{--<button id="btn-cause" class="btn btn-primary" disabled="">提交</button>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}
    <script src="{{asset('r_backend/v2/js/lib/jquery-1.11.3.min.js')}}"></script>
    <script src="{{asset('r_backend/v2/js/lib/echarts.js')}}"></script>
    <script src="{{asset('r_backend/v2/js/lib/bootstrap.min.js')}}"></script>
    <script src="{{asset('r_backend/v2/js/common_backend.js')}}"></script>
    <script>
        $(function () {
            $('#pass-button').on('click', function () {
                var user_id = '{{ $user->id }}';
                $.ajax({
                    url: '{{ route('backend.customer.company.verification.store') }}',
                    data: {
                        user_id: user_id,
                        type: 'pass'
                    },
                    type: 'post',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (result) {
                        if (result.code == 0) {
                            Mask.alert('审核通过');
                            location.href = '{{ route('backend.customer.company.detail', [$user->id]) }}';
                        }
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        console.log(XMLHttpRequest.responseJSON.content);
                    }
                });
            });
            $('#not-pass-button').on('click', function () {
                var user_id = '{{ $user->id }}';
                $.ajax({
                    url: '{{ route('backend.customer.company.verification.store') }}',
                    data: {
                        user_id: user_id,
                        type: 'not-pass'
                    },
                    type: 'post',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (result) {
                        if (result.code == 0) {
                            Mask.alert('审核不通过');
                            location.href = '{{ route('backend.customer.company.detail', [$user->id]) }}';
                        }
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        console.log(XMLHttpRequest.responseJSON.content);
                    }
                });
            });
        });
    </script>
@stop