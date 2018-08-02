@extends('backend_v2.layout.base')
@section('title')@parent 消息管理 @stop
@section('head-more')
    <link rel="stylesheet" href="{{asset('r_backend/v2/css/message.css')}}" />
@stop
@section('top_menu')
    <div class="nav-top-wrapper fl">
        <ul>
            <li class="active">
                <a href="javascript:;" >通知</a>
            </li>
        </ul>
    </div>
@stop
@section('main')
    <div class="main-wrapper">
        <div class="row">
            <ol class="breadcrumb col-lg-12">
                <li><a href="/backend/sms/message">信息管理</a><i class="iconfont icon-gengduo"></i></li>
                <li class="active">通知详情</li>
            </ol>
        </div>

        <div class="details">
            <div class="row">
                <div class="col-md-4">
                    <div class="title">信息</div>
                    <div class="default-div">
                        <ul>
                            <li><span class="name">收件人：</span>
                                @if($data['accept_type'] == 0)
                                    客户
                                @else
                                    代理人
                                @endif
                            </li>

                            <li><span class="name">查看率：</span>80%</li>
                            <li><span class="name">发送时间：</span>
                                @if($data['status'] == 1)
                                    未发送
                                    @else
                                    {{$data['send_time']}}
                                @endif
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="title">内容</div>
                    <div class="default-div">
                        {{$data->comments[0]['content']}}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="title">未查看人员</div>
                </div>
            </div>
            <div class="row">
                <div class="ui-table table-single-line">
                    <div class="ui-table-header radius">
                        <span class="col-xs-2">姓名</span>
                        <span class="col-xs-8">身份</span>
                        <span class="col-xs-2 col-one">操作</span>
                    </div>
                    <div class="ui-table-body">
                        <ul>
                            <li class="ui-table-tr">
                                <div class="col-xs-2">张小张</div>
                                <div class="col-xs-8">代理人</div>
                                <div class="col-xs-2 text-right">
                                    {{--<a href="html/message/message_details.html" class="btn btn-primary">再次发送</a>--}}
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{asset('r_backend/v2/js/common_backend.js')}}"></script>
@stop