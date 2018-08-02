@extends('backend_v2.layout.base')
@section('title')@parent 代理商详情 @stop
@section('head-more')
    <link rel="stylesheet" href="{{asset('r_backend/v2/css/agent.css')}}" />
    <link rel="stylesheet" href="{{asset('r_backend/v2/css/client_details.css')}}" />

@stop

@section('top_menu')
    @include('backend_v2.agent.top_menu')
@stop
@section('main')
<div id="performance" class="main-wrapper">
    @include('backend_v2.agent.agent_top')
        <div class="row">
            <div class="col-lg-12">
                <!--客户管理实名认证-->
                {{--<div class="ui-table-tr" style="line-height: 30px;">--}}
                    {{--<div class="col-lg-12 color-default" style="font-size: 16px;font-weight: bold;">田大田</div>--}}
                    {{--<div class="col-md-3">注册时间：<span>2017-09-27</span></div>--}}
                    {{--<div class="col-md-3">联系方式：<span>13011145847</span></div>--}}
                    {{--<div class="col-md-2">证件类型：<span>身份证</span></div>--}}
                    {{--<div class="col-md-4">证件号码：<span>125478965412541568</span></div>--}}
                {{--</div>--}}

                <!--代理人实名认证-->
                <div class="ui-table-tr" style="line-height: 30px;">
                    <div class="col-lg-12 color-default" style="font-size: 16px;font-weight: bold;">{{ $user->name }}</div>
                    <div class="col-lg-2 col-sm-6">注册时间：<span>{{ $user->created_at }}</span></div>
                    <div class="col-lg-2 col-sm-6">联系方式：<span>{{ $user->phone }}</span></div>
                    <div class="col-lg-3 col-sm-6">邮箱：<span>{{ $user->email }}</span></div>
                    <div class="col-lg-2 col-sm-6">证件类型：<span>身份证</span></div>
                    <div class="col-lg-3 col-sm-6">证件号码：<span>{{ $user->code ? $user->code : '--' }}</span></div>
                </div>
            </div>
        </div>

        @if(!$user->trueUserInfo)
            <div>未提交实名资料</div>
        @else
        <div class="row autonym">
            <div class="col-lg-12">
                <div class="certificate">
                    <h2 class="title">证件信息</h2>
                    <div class="img-wrapper col-lg-3">

                        <img src="{{asset($user->trueUserInfo->card_img_front)}}" alt="" />
                        {{--<span class="btn btn-default" data-toggle="modal" data-target="#larger">查看大图</span>--}}
                    </div>
                    <div class="img-wrapper col-lg-3">
                        <img src="{{asset($user->trueUserInfo->card_img_backend)}}" alt="" />
                        {{--<span class="btn btn-default" data-toggle="modal" data-target="#larger">查看大图</span>--}}
                    </div>
                    <div class="img-wrapper col-lg-3">
                        <img src="{{asset($user->trueUserInfo->card_img_person)}}" alt="" />
                        {{--<span class="btn btn-default" data-toggle="modal" data-target="#larger">查看大图</span>--}}
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="standard">
                    <h2 class="title">审核标准</h2>
                    <ul>
                        <li>1.基本信息真实性</li>
                        <li>1.身份证信息真实性</li>
                        <li>1.基本信息与身份证信息一致</li>
                    </ul>
                </div>
            </div>
            @if($agent->pending_status != 1)
            <div class="operation">
                <button class="btn btn-primary" id="btn-pass">通过审核</button>
                <button class="btn btn-warning" data-toggle="modal" data-target="#notPass" id="btn-not-pass">审核不通过</button>
            </div>
            @endif
        </div>
    </div>

    <!--查看大图-->
    {{--<div class="modal fade in" id="larger" role="dialog" aria-labelledby="myModalLabel">--}}
        {{--<div class="modal-dialog modal-alert" role="document">--}}
            {{--<div class="modal-content">--}}
                {{--<div class="modal-header notitle">--}}
                    {{--<button type="button" class="" data-dismiss="modal" aria-label="Close"><i class="iconfont icon-cancel"></i></button>--}}
                {{--</div>--}}
                {{--<div class="modal-body">--}}
                    {{--<img src="../../img/zhengjianzhengmian.png" alt="" />--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}

    <!--审核通过-->
{{--todo--}}
    <form action="{{url('/backend/agent/dispose_audit')}}" method="post" id="submit-form">
        {{ csrf_field() }}
        <input type="hidden" name="type">
        <input type="hidden" name="agent_id" value="{{ $agent->id }}">
        <input type="hidden" name="reject_mag" >
    </form>
    <div class="modal fade in" id="pass" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-alert modal-nofooter" role="document">
            <div class="modal-content">
                <div class="modal-header notitle">
                    <button type="button" class="" data-dismiss="modal" aria-label="Close"><i class="iconfont icon-cancel"></i></button>
                </div>
                <div class="modal-body">
                    <i class="iconfont icon-duihao"></i>
                    <p>审核通过</p>
                </div>
            </div>
        </div>
    </div>
    <!--审核不通过-->
    <div class="modal fade in" id="notPass" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-alert modal-cause" role="document">
            <div class="modal-content">
                <div class="modal-header notitle">
                    <button type="button" class="" data-dismiss="modal" aria-label="Close"><i class="iconfont icon-cancel"></i></button>
                </div>
                <div class="modal-body">
                    <i class="iconfont icon-warning"></i>
                    <p>审核未通过</p>
                    <div class="cause-wapper">
                        <p class="title">未通过原因:</p>
                        <textarea class="cause-text" id="msg"></textarea>
                        <button id="btn-cause" type="button" class="btn btn-primary" disabled="">提交</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @endif
</div>
@stop
@section('footer-more')
    <script>
        $('.cause-text').bind('input propertychange', function() {
            $('#btn-cause')[0].disabled = !$(this).val();
        });
        $("#btn-pass").click(function(){
            $('input[name=type]').val('pass');
            $('#submit-form').submit();
        });
        $("#btn-cause").click(function(){
            var msg = $("#msg").val();
            $("input[name=type]").val('not_pass');
            $("input[name=reject_mag]").val(msg);
            $('#submit-form').submit();
        });
    </script>
@stop