@extends('backend.layout.base')
@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('r_backend/css/libs/nifty-component.css')}}"/>
@endsection
@section('content')
<div id="content-wrapper">
    <div class="col-lg-12">
        <div class="row">
            <div class="col-lg-12">
                <ol class="breadcrumb">
                    <li><a href="{{ url('/backend') }}">主页</a></li>
                    <li ><span>销售管理</span></li>
                    <li ><span>代理人渠道管理</span></li>
                    {{--<li><span><a href="/backend/sell/ditch_agent/agents">代理人管理</a></span></li>--}}
                    <li class="active"><span>代理人列表</span></li>
                </ol>
            </div>
        </div>
        <div class="main-box clearfix">
            <header class="main-box-header clearfix">
                <h2 class="pull-left">代理人列表</h2>
                <div class="filter-block pull-right" style="margin-right: 20px;">
                    <a class="btn btn-default" href="{{ url('/backend/sell/ditch_agent/agents/create') }}">新建代理人</a>
                </div>
            </header>
            <ul class="nav nav-tabs">
                <li><a href="{{ url('/backend/sell/ditch_agent/ditch/details/'.$id) }}">渠道详情</a></li>
                <li><a href="{{ url('backend/sell/ditch_agent/agents/'.$id) }}">代理人</a></li>
                <li><a href="{{ url('backend/sell/ditch_agent/active_products/'.$id) }}">活跃产品</a></li>
                <li><a>渠道任务</a></li>
            </ul>
            @include('backend.layout.alert_info')
            <div class="main-box-body clearfix">

                <form action='{{url('backend/sell/ditch_agent/agents/'.$id)}}' method="get">
                    代理人名称 : <input name="name"> &nbsp;
                    <input type="submit" id="search" value="搜索">
                </form>

                <div class="table-responsive">
                    <table class="table user-list table-hover">
                        <thead>
                        <tr>
                            <th><span>代理人工号</span></th>
                            <th><span>代理人名称</span></th>
                            {{--<th class="text-center"><span>代理人全称</span></th>--}}
                            {{--<th class="text-center"><span>联系电话</span></th>--}}
                            <th class="text-center"><span>操作</span></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($agents as $k => $v)
                        <tr>
                            <td>
                                {{$v->job_number}}
                            </td>
                            <td>
                                {{$v->name}}
                            </td>

                            {{--<td class="text-center">--}}
                                {{--{{$v->phone}}--}}
                            {{--</td>--}}

                            <td class="text-center">
                                <a href="{{ url('/backend/agent/agent_info/'.$v->agent_id) }}">代理人详情</a>
                            </td>
                        </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>
                {{--分页--}}
                <div style="text-align: center;">
                    {{ $agents->appends(['name' => $name])->links() }}
                </div>
            </div>
        </div>
    </div>

    {{--<div class="md-modal md-effect-8 md-hide" id="modal-8">--}}
        {{--<div class="md-content">--}}
            {{--<div class="modal-header">--}}
                {{--<button class="md-close close">×</button>--}}
                {{--<h4 class="modal-title">代理人添加</h4>--}}
            {{--</div>--}}
            {{--<div class="modal-body">--}}
                {{--<form role="form" id="add_agent" action='{{url('backend/sell/ditch_agent/post_add_agent')}}' method="post" enctype="multipart/form-data">--}}
                    {{--{{ csrf_field() }}--}}
                    {{--<div class="form-group">--}}
                        {{--<label for="exampleInputEmail1">代理人简称 <span class="red">*</span></label>--}}
                        {{--<input class="form-control" name="name" placeholder="代理人别称（2-4汉字）" type="text">--}}
                    {{--</div>--}}
                    {{--<div class="form-group">--}}
                        {{--<label for="exampleInputPassword1">代理人真实全称<span class="red">*</span></label>--}}
                        {{--<input class="form-control" name="real_name" placeholder="代理人全称（2-4汉字）" type="text">--}}
                    {{--</div>--}}
                    {{--<div class="form-group">--}}
                        {{--<label for="exampleTextarea">身份证号<span class="red">*</span></label>--}}
                        {{--<input class="form-control" name="card_id" placeholder="代理人有效身份证号" type="text">--}}
                    {{--</div>--}}
                    {{--<div class="form-group">--}}
                        {{--<label for="exampleTextarea">工号<span class="red">*</span></label>--}}
                        {{--<input class="form-control" name="job_number" placeholder="代理人工号" type="text">--}}
                    {{--</div>--}}
                    {{--<div class="form-group">--}}
                        {{--<label for="exampleTextarea">区域<span class="red">*</span></label>--}}
                        {{--<input class="form-control" name="area" placeholder="代理人所在区域" type="text">--}}
                    {{--</div>--}}
                    {{--<div class="form-group">--}}
                        {{--<label for="exampleTextarea">渠道</label>--}}
                        {{--<select name="ditch">--}}
                            {{--@foreach($ditches as $ditch)--}}
                                {{--<option value="{{ $ditch->id }}">{{ $ditch->name }}</option>--}}
                            {{--@endforeach--}}
                        {{--</select>--}}
                    {{--</div>--}}
                    {{--<div class="form-group">--}}
                        {{--<label for="exampleTextarea">代理人职级<span class="red">*</span></label>--}}
                        {{--<input class="form-control" name="position" placeholder="代理人职级" type="text">--}}
                    {{--</div>--}}
                    {{--<div class="form-group">--}}
                        {{--<label for="exampleTextarea">联系地址</label>--}}
                        {{--<input class="form-control" name="address" placeholder="代理人联系地址" type="text">--}}
                    {{--</div>--}}
                    {{--<div class="form-group">--}}
                        {{--<label for="exampleTextarea">电子邮箱</label>--}}
                        {{--<input class="form-control" name="email" placeholder="代理人邮箱地址" type="email">--}}
                    {{--</div>--}}
                    {{--<div class="form-group">--}}
                        {{--<label for="exampleTextarea">手机号码<span class="red">*</span></label>--}}
                        {{--<input class="form-control" name="phone" placeholder="代理人联系电话" type="text">--}}
                    {{--</div>--}}
                    {{--<div class="form-group">--}}
                        {{--<label for="exampleTextarea">登录密码<span class="red">*</span></label>--}}
                        {{--<input class="form-control" name="password" placeholder="代理人登录密码" type="password">--}}
                    {{--</div>--}}
                    {{--<input id="lefile" type="file" style="display:none">--}}
                    {{--<div class="input-append">--}}
                        {{--<span>身份证正面：</span>--}}
                        {{--<input type="file" class="filestyle" name="card_img_front">--}}
                    {{--</div>--}}
                    {{--<div class="input-append">--}}
                        {{--<span>身份证反面：</span>--}}
                        {{--<input type="file" class="filestyle" name="card_img_backend">--}}
                    {{--</div>--}}
                {{--</form>--}}
            {{--</div>--}}
            {{--<div class="modal-footer">--}}
                {{--<button type="button" id="form-submit" class="btn btn-primary">确认提交</button>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}
    {{--<div class="md-overlay"></div>--}}
</div>
@stop
@section('foot-js')
<script charset="utf-8" src="/r_backend/js/modernizr.custom.js"></script>
<script charset="utf-8" src="/r_backend/js/classie.js"></script>
<script charset="utf-8" src="/r_backend/js/modalEffects.js"></script>
<script>
    $(function(){

//        $submit = $("#form-submit");
//        $submit.click(function(){
//            //简称
//            var $name = $("input[name=name]").val();
//            var $name_role = /^[\u4e00-\u9fa5]{2,4}$/;
//            var $name_check = $name_role.test($name);
//            changeClass($("input[name=name]"), $name_check);
//
//            //全称
//            var $real_name = $("input[name=real_name]").val();
//            var $real_name_role = /^[\u4e00-\u9fa5]{2,4}$/;
//            var $real_name_check = $real_name_role.test($real_name);
//            changeClass($("input[name=real_name]"), $real_name_check);
//
//            //身份证
//            var $card_id = $("input[name=card_id]").val();
//            var $card_id_role = /^[1-9]\d{5}[1-9]\d{3}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])\d{3}([0-9]|Xx)$/;
//            var $card_id_check = $card_id_role.test($card_id);
//            changeClass($("input[name=card_id]"), $card_id_check);
//
//            //电话
//            var $phone = $("input[name=phone]").val();
//            var $phone_role = /^1[34578]\d{9}$/;
//            var $phone_check = $phone_role.test($phone);
//            changeClass($("input[name=phone]"), $phone_check);
//
//
//
//            function changeClass(obj, result){
//                if(!result){
//                    obj.val('');
//                    obj.parent().addClass("has-error");
//                }else{
//                    obj.parent().removeClass("has-error");
//                }
//
//            }
//
//            if($name_check && $real_name && $card_id_check){
//                $("#add_agent").submit();
//            }else{
//                alert("请根据输入框提示填写相关内容");
//            }
//        })

    })
</script>
@stop

