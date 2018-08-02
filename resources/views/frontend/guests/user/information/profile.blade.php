@extends('frontend.guests.layout.bases')
@section('content')
    <style>
        tr,td{
            text-align: center;
        }
    </style>
    <meta name="_token" content="{{ csrf_token() }}"/>
    <div id="content-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <ol class="breadcrumb">
                            <li><a href="/">主页</a></li>
                            <li class="active"><span>账户管理</span></li>
                        </ol>
                        <h1>完善信息</h1>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="main-box clearfix" style="min-height: 1100px;">
                            <div class="tabs-wrapper tabs-no-header">
                                <ul class="nav nav-tabs">
                                    <li class="active"><a href="{{ url('/backend/claim/get_detail/') }}">完善信息</a></li>
                                </ul>
                                <div class="tab-content">
                                    @include('backend.layout.alert_info')
                                    <div class="tab-pane fade in active" id="tab-accounts">
                                        <h3><p>账户信息</p></h3>
                                        <div class="panel-group accordion" id="account">
                                            <div class="panel panel-default">
                                                <form action="{{ url('/information/profile_submit') }}"  method="post" id="form">
                                                    {{ csrf_field() }}
                                                <table id="user" class="table table-hover" style="clear: both">
                                                    <tbody>
                                                        <tr>
                                                            <td width="25%">昵称</td>
                                                            <td>
                                                                <input type="text" name="name" class="form-control" value = '{{ $self_information->name }}'>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>真实姓名</td>
                                                            <td>
                                                                <input type="text" name="real_name" class="form-control" value="{{ $self_information->real_name }}">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>身份证号</td>
                                                            <td>
                                                                <input type="text" name="code" class="form-control" value="{{ $self_information->code }}">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>手机号码</td>
                                                            <td>
                                                                <input type="text" name="phone" class="form-control" value="{{ $self_information->phone }}">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>邮箱地址</td>
                                                            <td>
                                                                <input type="text" name="email" class="form-control" value="{{ $self_information->email }}">
                                                            </td>
                                                        </tr>

                                                    </tbody>
                                                    <tr>
                                                        <td colspan="2">
                                                            <input type="button" value="保存" id="btn" class="btn btn-success" >
                                                        </td>
                                                    </tr>
                                                </table>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            </div>
        </div>
    </div>
    <script src="/js/jquery-3.1.1.min.js"></script>
    <script>
        $(function(){
            var btn = $('#btn');
            var form = $('#form');
            var name = $('input[name=name]');
            var real_name = $('input[name=real_name]');
            var email = $('input[name=email]');
            var phone = $('input[name=phone]');
            var address = $('input[name=address]');
            var code = $('input[name=code]');

            //获取各种验证正则
            var code_pattern = {{ config('pattern.code') }};
            var phone_pattern = {{ config('pattern.phone') }};
            var email_pattern = {{ config('pattern.email') }};


            btn.click(function(){
                var name_val = name.val();
                var real_name_val = real_name.val();
                var email_val = email.val();
                var phone_val = phone.val();
                var code_val = code.val();

                if(name_val == ''){   //名称验证
                    name.parent().addClass("has-error");
                    alert('昵称不能为空');
                    return false;
                }else{
                    name.parent().removeClass("has-error");
                }
                if(real_name_val == ''){   //名称验证
                    real_name.parent().addClass("has-error");
                    alert('真实姓名不能为空');
                    return false;
                }else{
                    real_name.parent().removeClass("has-error");
                }
                var check_code = check(code,code_val,code_pattern,'身份证号');
                var check_email = check(email,email_val,email_pattern,'邮箱');
                var check_phone = check(phone,phone_val,phone_pattern,'手机号');
                if(!check_email||!check_phone||!check_code){
                    alert('格式错误');
                    return false;
                }
                form.submit();
            });
            //写一个方法，用来验证
            function check(dom,dom_val,pattern,name)
            {
                if(dom == ''){//手机验证
                    dom.parent().addClass("has-error");
                    return false;
                }else if(!pattern.test(dom_val)) {
                    dom.parent().addClass("has-error");
                    return false;
                }else {
                    dom.parent().removeClass("has-error");
                    return true;
                }
            }
        })
    </script>
@stop

