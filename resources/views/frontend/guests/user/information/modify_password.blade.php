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

            .popup-phone .popup-wrapper{
                width: 900px;
                height: 300px;
            }
            .popup-phone .popup-content{
                padding: 20px 0 30px 266px;
            }
            .popup-phone .popup-wrapper .btn-code{
                position: absolute;
                right: 0;
                width: 104px;
                height: 30px;
                color: #fff;
                background: #ffae00;
                border-radius: 0;
            }
            .code-wrapper{
                display: inline-block;
                position: relative;
            }
            button:disabled{
                background: #ccc!important;
            }
        </style>
    </head>

    <body>
    <div class="content">
        <div class="content-inside">
            <div class="main-wrapper">
                <div class="main-content">
                    <div>
                        <span>账户安全：</span>
                        <span class="safety-wrapper"></span>
                    </div>
                    <ul class="safety-content">
                        <li class="clearfix">
                            <div class="safety-content-left"><i class="iconfont icon-information"></i>密码验证</div>
                            <div class="safety-content-right">
                                您可以提高密码的复杂程度来提高账户的安全性
                                <a class="fr" href="/information/change_password">修改</a>
                            </div>
                        </li>
                        <li class="clearfix">
                            <div class="safety-content-left"><i class="iconfont icon-success"></i>手机验证</div>
                            <div class="safety-content-right">
                                您验证的手机：170*****000&nbsp;&nbsp;如若有变请及时更换，以避免账户损失
                                {{--<a class="fr" href="/information/phone_verification">修改</a>--}}
                                <a id="changeTel" class="fr" href="javascript:void(0)">修改</a>
                            </div>
                        </li>

                        <li class="clearfix">
                            <div class="safety-content-left"><i class="iconfont icon-wrong"></i>实名验证</div>
                            <div class="safety-content-right">
                                您认证的实名信息：*小眼&nbsp;&nbsp;65************7640
                                <a class="fr" href="/information/approvePerson">立即认证</a>
                            </div>
                        </li>
                        {{--<li class="clearfix">--}}
                            {{--<div class="safety-content-left"><i class="iconfont icon-success"></i>手机验证</div>--}}
                            {{--<div class="safety-content-right">--}}
                                {{--您验证的手机：170*****000&nbsp;&nbsp;如若有变请及时更换，以避免账户损失--}}
                                {{--<a class="fr" href="/information/index">修改</a>--}}
                            {{--</div>--}}
                        {{--</li>--}}
                        {{--<li class="clearfix">--}}
                        {{--<div class="safety-content-left"><i class="iconfont icon-wrong"></i>邮箱验证</div>--}}
                        {{--<div class="safety-content-right">--}}
                        {{--验证后,将能及时收到电子保单等重要信息--}}
                        {{--<a class="fr" href="">立即验证</a>--}}
                        {{--</div>--}}
                        {{--</li>--}}
                        {{--<li class="clearfix">--}}
                            {{--<div class="safety-content-left"><i class="iconfont icon-wrong"></i>实名验证</div>--}}
                            {{--<div class="safety-content-right">--}}
                                {{--您认证的实名信息：*小眼&nbsp;&nbsp;65************7640--}}
                                {{--<a class="fr" href="/information/approvePerson">立即认证</a>--}}
                            {{--</div>--}}
                        {{--</li>--}}
                    </ul>
                </div>
            </div>
        </div>
    </div>
    </div>

    <div class="popup popup-phone">
        <div class="popup-bg"></div>
        <div class="popup-wrapper">
            <div class="popup-title">修改手机号码<i class="iconfont icon-close fr"></i></div>
            <div class="popup-content">
                <ul class="form-wrapper">
                    <li>
                        <span class="form-name"><i class="red">*</i>手机号码</span>
                        <input type="tel" placeholder="请输入新手机号码" maxlength="11" id="phone">
                        <i class="error"></i>
                    </li>
                    <li>
                        <span class="form-name"><i class="red">*</i>验证码</span>
                        <div class="code-wrapper">
                            <input class="code" type="text" placeholder="请输入" maxlength="6"><button disabled class="btn btn-code">发送验证码</button>
                        </div>
                        <i class="error"></i>
                    </li>
                </ul>

            </div>
            <div class="popup-footer"><button class="btn-00a2ff btn-save" disabled>保存</button></div>
        </div>
    </div>

    </body>

    <script src="{{config('view_url.person_url')}}js/lib/jquery-1.11.3.min.js"></script>
    <script src="{{config('view_url.person_url')}}js/common.js"></script>
<script>
    $(function() {
        $('.btn-select').click(function() {
            $(this).addClass('active').siblings().removeClass('active');
        })
        var sagety = {
            init: function(){
                var _this = this;
                $('#changeTel').click(function(){
                    Popups.open('.popup-phone');
//                    new Popup('.popup-phone');
                    _this.changeTel();
                });
            },
            changeTel: function(){
                var inputs = $(".popup-phone input");
                var btn_save = $(".popup-phone .btn-save");
                inputs.bind('input porpertychange',function(){
                    inputs.each(function(index){
                        if(index==0&&$(this).val()){
                            $('.btn-code').prop('disabled',true);
                        }else{
                            $('.btn-code').prop('disabled',false);
                        }
                        if(!$(this).val()){
                            btn_save.prop('disabled',true);
                            return false;
                        }
                        if(index == inputs.length-1){
                            btn_save.prop('disabled',false);
                        }
                    });
                });

                //$('.code-wrapper').next().html('验证码错误')
                $('.btn-code').click(function(){
                    if(checkCorrect($(".popup-phone input[type='tel']"),telReg)){
                        // 手机号正确
                        $(".popup-phone input[type='tel']").next().html('');
                    }
                });
            }
        }
        sagety.init();
    });


    //手机号验证
    $(".btn-code").click(function(){
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

//    修改手机号
    $(".btn-save").click(function(){
        var code = $(".code").val();
        var phone = $("#phone").val();
        $.ajax({
            type: "GET",
            url: "/information/phone_check",
            data: {phone:phone,code:code},
            success: function(msg){
               if(msg == 1){
                   alert("修改成功");
                }else{
                    alert("修改失败");
               }

            }
        });
    })


</script>

@stop