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
                        <li><span><a href="/backend/sell/ditch_agent/agents">代理人管理</a></span></li>
                        <li class="active"><span>代理人列表</span></li>
                    </ol>
                </div>
            </div>
            <div class="main-box clearfix">
                <header class="main-box-header clearfix">
                    <h2 class="pull-left">代理人列表</h2>
                </header>
                <ul class="nav nav-tabs">
                    <li><a href="{{ url('backend/sell/ditch_agent/ditches') }}">渠道管理</a></li>
                    <li><a href="{{ url('backend/sell/ditch_agent/agents') }}">代理人管理</a></li>
                    <li><a href="{{ url('backend/sell/ditch_agent/ditch_bind_agent') }}">渠道代理人关联</a></li>
                    <li><a href="{{ url('backend/sell/ditch_agent/brokerage') }}">佣金设置</a></li>
                    <li class="active"><a href="">编辑代理人</a></li>
                </ul>
                @include('backend.layout.alert_info')
                <div class="main-box-body clearfix">
                    <form role="form" id="add_agent" action='{{url('backend/sell/ditch_agent/update_agent', $user->id)}}' method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        <div class="form-group">
                            <label for="exampleInputEmail1">代理人简称 <span class="red">*</span></label>
                            <input class="form-control" name="name" value="{{ old('name') ?: $user->name }}" type="text">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">代理人真实全称<span class="red">*</span></label>
                            <input class="form-control" name="real_name" value="{{ old('real_name') ?: $user->real_name }}" type="text">
                        </div>
                        <div class="form-group">
                            <label for="exampleTextarea">工号<span class="red">*</span></label>
                            <input class="form-control" name="job_number" value="{{ old('job_number') ?: $user->agent->job_number }}" placeholder="代理人工号" type="text">
                        </div>
                        <div class="form-group">
                            <label for="exampleTextarea">区域<span class="red">*</span></label>
                            <input class="form-control" name="area" value="{{ old('area') ?: $user->agent->area }}" type="text">
                        </div>
                        <div class="form-group">
                            <label for="exampleTextarea">电子邮箱</label>
                            <input class="form-control" name="email" value="{{ old('email') ?: $user->email }}" placeholder="代理人邮箱地址" type="email">
                        </div>
                        <div class="form-group">
                            <label for="exampleTextarea">手机号码<span class="red">*</span></label>
                            <input class="form-control" name="phone" value="{{ old('phone') ?: $user->phone }}" placeholder="代理人联系电话" type="text">
                        </div>
                        <div class="form-group">
                            <button class="btn btn-success">保存</button>
                            <button class="btn btn-success" onclick="history.go(-1)">返回</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
@section('foot-js')
    <script charset="utf-8" src="/r_backend/js/modernizr.custom.js"></script>
    <script charset="utf-8" src="/r_backend/js/classie.js"></script>
    <script charset="utf-8" src="/r_backend/js/modalEffects.js"></script>
    <script>
        $(function(){

//            $submit = $("#form-submit");
//            $submit.click(function(){
//                //简称
//                var $name = $("input[name=name]").val();
//                var $name_role = /^[\u4e00-\u9fa5]{2,4}$/;
//                var $name_check = $name_role.test($name);
//                changeClass($("input[name=name]"), $name_check);
//
//                //全称
//                var $real_name = $("input[name=real_name]").val();
//                var $real_name_role = /^[\u4e00-\u9fa5]{2,4}$/;
//                var $real_name_check = $real_name_role.test($real_name);
//                changeClass($("input[name=real_name]"), $real_name_check);
//
//                //身份证
//                var $card_id = $("input[name=card_id]").val();
//                var $card_id_role = /^[1-9]\d{5}[1-9]\d{3}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])\d{3}([0-9]|Xx)$/;
//                var $card_id_check = $card_id_role.test($card_id);
//                changeClass($("input[name=card_id]"), $card_id_check);
//
//                //电话
//                var $phone = $("input[name=phone]").val();
//                var $phone_role = /^1[34578]\d{9}$/;
//                var $phone_check = $phone_role.test($phone);
//                changeClass($("input[name=phone]"), $phone_check);
//
//
//
//                function changeClass(obj, result){
//                    if(!result){
//                        obj.val('');
//                        obj.parent().addClass("has-error");
//                    }else{
//                        obj.parent().removeClass("has-error");
//                    }
//
//                }
//
//                if($name_check && $real_name && $card_id_check){
//                    $("#add_agent").submit();
//                }else{
//                    alert("请根据输入框提示填写相关内容");
//                }
//            })

        })
    </script>
@stop

