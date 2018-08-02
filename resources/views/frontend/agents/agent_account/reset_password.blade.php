@extends('frontend.agents.agent_home.base')
@section('content')
    <link rel="stylesheet" href="{{config('view_url.agent_url')}}css/account.css" />
<div class="content content-change">
    <ul class="crumbs">
        <li><a href="/agent/account">账户设置</a><i class="iconfont icon-gengduo"></i></li>
        <li>修改密码</li>
    </ul>
    <ul class="password">
        <form id="reset_form" action="/agent/reset_password_submit" method="post">
            <input type="hidden" name="_token" value="{{csrf_token()}}">
            <li>
            <span class="name">新密码</span>
            <input id="psw" type="password" placeholder="6-18位字符，必须由数字和字母组合" maxlength="18" name="npsw"/>
            <span class="error"></span>
        </li>
        <li>
            <span class="name">确认密码</span>
            <input id="cpsw" type="password" placeholder="6-18位字符，必须由数字和字母组合" maxlength="18" name="renpsw"/>
        </li>
            <li>
                <span class="name">验证码</span>
                <input id="cpsw_code" type="text" placeholder="请输入验证码" maxlength="18" name="code"/>
            </li>
            <input type="hidden" name="phone" value="{{$data->user['phone']}}">
        </form>
    </ul>
    <div class="btn-wrapper">

        <button class="z-btn z-btn-hollowB">取消</button>
        <button class="z-btn z-btn-default" disabled>确认</button>
    </div>
</div>
    <script>
        var Ele = {
            psw: $('#psw'),
            cpsw: $('#cpsw'),
            next: $('.z-btn-default'),
        }

        // 按钮是否禁用
        $('input').bind('input propertychange', function() {
            if(!Ele.psw.val() || !Ele.cpsw.val()){
                Ele.next.prop('disabled',true);
            }else{
                Ele.next.prop('disabled',false);
            }
        });

        Ele.next.click(function(){
            $('.error').html('');
            if(!checkCorrect(Ele.psw,passwordReg)){
                $('.error').html('新密码有误，请重新填写');
                init();
            }else if(Ele.psw.val() !== Ele.cpsw.val()){
                $('.error').html('新密码有误，请重新填写');
                init();
            }else{
                $("#reset_form").submit();
            }

        });
        // 表单初始化
        function init(){
            $('input').val('');
            Ele.next.prop('disabled',true).addClass('disabled');
        }
    </script>
    @stop