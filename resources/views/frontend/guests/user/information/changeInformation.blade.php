@extends('frontend.guests.layout.bases')
@section('content')
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
                        <h1>账户详情</h1>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="main-box clearfix" style="min-height: 1100px;">
                            <div class="tabs-wrapper tabs-no-header">
                                <ul class="nav nav-tabs">
                                    <li><a href="{{ url('/information/index') }}">个人信息</a></li>
                                    <li class="active"><a href="#">修改信息</a></li>
                                </ul>
                                <div class="tab-content">
                                    @include('backend.layout.alert_info')
                                    <div class="tab-pane fade in active" id="tab-accounts">
                                        <h3><p>账户信息</p></h3>
                                        <div class="panel-group accordion" id="account">
                                            <div class="panel panel-default">
                                                <form action="{{ url('/information/change_information_submit') }}"  method="post" id="change-information-form">
                                                    {{ csrf_field() }}
                                                <table id="user" class="table table-hover" style="clear: both">
                                                    <tbody>
                                                    <tr>
                                                        <td width="15%">昵称</td>
                                                        <td width="65%">
                                                            <input type="text" name="name" value="{{ $information->name }}" class="form-control">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>真实姓名</td>
                                                        <td>
                                                            <input type="text" name="real_name" value="{{ $information->real_name }}" class="form-control"<?php if($information->real_name){?> disabled<?php }?>>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>电子邮箱</td>
                                                        <td>
                                                            <input type="text" name="email" value="{{ $information->email }}" class="form-control">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>联系电话</td>
                                                        <td>
                                                            <input type="text" value="{{ $information->phone }}" name="phone" class="form-control" <?php if($information->real_name){?> disabled<?php }?>>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>家庭住址</td>
                                                        <td>
                                                            <input type="text" name="address" value="{{ $information->address }}" class="form-control">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>身份证号</td>
                                                        <td>
                                                            @if($information->code)
                                                                <input type="text" value="{{ $information->code }}" name="code" class="form-control" disabled>
                                                            @else
                                                                <input type="text" value="" name="code" class="form-control">
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    {{--@if(!$information->code)--}}
                                                        {{--<td colspan="2" style="text-align: center;">--}}
                                                            {{--请输入正确的身份证号--}}
                                                        {{--</td>--}}
                                                    {{--@endif--}}
                                                    <tr>
                                                        <td colspan="2" style="text-align: center;"><input type="button" id="change-information-btn" class="btn btn-success" value="确认修改"></td>
                                                    </tr>
                                                    </tbody>
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
            var change_information_btn = $('#change-information-btn');
            var change_information_form = $('#change-information-form');
            var name = $('input[name=name]');
            var real_name = $('input[name=real_name]');
            var email = $('input[name=email]');
            var phone = $('input[name=phone]');
            var address = $('input[name=address]');
            var code = $('input[name=code]');

            //获取各种验证正则
            {{--var code_pattern = {{ config('pattern.code') }};--}}
            {{--var phone_pattern = {{ config('pattern.phone') }};--}}
            {{--var email_pattern = {{ config('pattern.email') }};--}}


            change_information_btn.click(function(){
                var name_val = name.val();
//                var real_name_val = real_name.val();
                var email_val = email.val();
//                var phone_val = phone.val();
//                var code_val = code.val();
                if(name_val == ''){   //名称验证
                    name.parent().addClass("has-error");
                    alert('昵称不能为空');
                    return false;
                }else{
                    name.parent().removeClass("has-error");
                }
//                if(real_name_val == ''){   //名称验证
//                    real_name.parent().addClass("has-error");
//                    alert('真实姓名不能为空');
//                    return false;
//                }else{
//                    real_name.parent().removeClass("has-error");
//                }

//                var check_email = check(email,email_val,email_pattern,'邮箱');
//                var check_phone = check(phone,phone_val,phone_pattern,'手机号');
//                var check_code = check(code,code_val,code_pattern,'证件号码');
//                if(!check_email){
//                    alert('格式错误');
//                    return false;
//                }
                change_information_form.submit();
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

