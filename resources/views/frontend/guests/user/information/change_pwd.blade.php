<!DOCTYPE html>
<html>
@extends('frontend.guests.person_home.account.base')
@section('content')
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta charset="UTF-8">
        <title>天眼互联-科技让保险无限可能</title>
        <link rel="stylesheet" href="{{config('view_url.person_url').'css/lib/iconfont.css'}}" />
        <link rel="stylesheet" href="{{config('view_url.person_url').'css/common.css'}}" />
        <style>
            .main-wrapper {height: 656px;}
            .main-content{padding: 78px 30px;}
            .safety-content-left>.iconfont{margin-right: 10px;}
            .icon-information{color: #f5a623;}
            .icon-success{color: #00a2ff;}
            .icon-wrong{color: #f00;}
        </style>
    </head>

    <body>
    <div class="content">
        <div class="content-inside">
            <div class="main-wrapper">
                <div class="main-content">
                    <form action="{{ url('/information/change_password_submit') }}" method="post" id="change-password-form">
                        {{ csrf_field() }}
                    <ul class="form-wrapper">
                        <li class="clearfix">
                            <div class="safety-content-right">
                                <span>原 密 码 :</span>
                                <input type="password" class="form-control" placeholder="请输入原密码" name="old_password">
                            </div>
                        </li>
                        <li class="clearfix">
                            <div class="safety-content-right">
                                <span>新 密 码 :</span>
                                <input type="password" class="form-control" placeholder="请输入密码" value="" name="new_password">
                            </div>
                        </li>
                        <li class="clearfix">
                            <div class="safety-content-right">
                                <span>确认密码:</span>
                                <input type="password" class="form-control" placeholder="请再次输入新密码" value="" name="check_new_password">
                            </div>
                        </li>
                        <li class="clearfix">
                            <div class="safety-content-right">
                                <span>验 证 码 :</span>
                                <input type="password" class="form-control" placeholder="请输入验证码" value="" id="code" name="code" style="width:100px;">
                                <span>发送默认{{$mobile}}手机号</span>
                                <span class="btn btn-success code  btn-00a2ff btn-save preservation" style="width:100px;height:50px;">获取验证码</span>
                            </div>
                        </li>
                    </ul>
                    </form>
                        <button id="change-password-btn" class="btn-00a2ff btn-save" style="margin-left:200px;">确认修改</button>
                    <input id="phone" type="hidden" value="{{$phone->phone }}" >
                </div>
            </div>
        </div>
    </div>
    </div>
    </body>
@stop
<script src="/js/jquery-3.1.1.min.js"></script>
<script>

    $(function(){
        $(".code").click(function(){
            var phone = $("#phone").val();
            var model = '62523';
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "/information/proving_code",
                type: "get",
                data: {'phone':phone},
                dataType: "json",
                success: function (data) {
                    if(data.status == 0){
                        sendSms(phone,model);
                    } else {
                        alert('密码重置失败');
                    }
                }
            });

            function sendSms(phone, model){
                $.get('/backend/sendsms',
                        {'phone':phone,'model':model},
                        function (data) {
                            alert(data['message']);
                        }
                );
            }
        })
    })




    $(function(){
        var change_password_btn = $('#change-password-btn');
        var change_password_form = $('#change-password-form');
        var old_password = $('input[name=old_password]');
        var new_password = $('input[name=new_password]');
        var check_new_password = $('input[name=check_new_password]');
        //获取正则表达式
        var password_pattern = {{ config('pattern.password') }};

        change_password_btn.click(function () {
            var old_password_val = old_password.val();
            var new_password_val = new_password.val();
            var check_new_password_val = check_new_password.val();
            var code = $("#code").val();
            if(code == ""){
                alert("验证码不能为空");
                return false;
            }
            if(old_password_val == ''){
                old_password.parent().addClass("has-error");
                alert('原密码不能为空');
                return false;
            }else {
                old_password.parent().removeClass("has-error");
            }
            var check_password = check(new_password,new_password_val,password_pattern,'密码');
            if(!check_password){
                new_password.parent().addClass("has-error");
                alert('密码格式错误，6-20位字母数字');
                return false;
            }else {
                new_password.parent().removeClass("has-error");
            }

            if(new_password_val != check_new_password_val){
                new_password.parent().addClass("has-error");
                check_new_password.parent().addClass("has-error");
                alert('两次密码输入不同');
                return false;
            }else{
                new_password.parent().removeClass("has-error");
                check_new_password.parent().removeClass("has-error");
            }
            change_password_form.submit();
        })
    })

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

</script>

