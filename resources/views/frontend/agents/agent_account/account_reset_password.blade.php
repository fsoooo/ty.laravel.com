@extends('frontend.agents.agent_home.base')
@section('content')
    <link rel="stylesheet" href="{{config('view_url.agent_url')}}css/account.css" />
<div class="content content-change">
    <ul class="crumbs">
        <li><a href="/agent/account">账户设置</a><i class="iconfont icon-gengduo"></i></li>
        <li>修改密码</li>
    </ul>
    <ul class="password">
        <form id="reset_form" action="/agent/reset_password" method="post">
            <input type="hidden" name="_token" value="{{csrf_token()}}">
            <li>
            <span class="name">当前密码</span>
            <input type="password" placeholder="6-18位字符，必须由数字和字母组合" maxlength="18" name="psw"/>
        </li>
        <li>
            <span class="name">注册邮箱</span>
            <span>{{$data->user['email']}}</span>
        </li>
            <input type="hidden" name="phone" value="{{$data->user['phone']}}">
        </form>
    </ul>
    <div class="btn-wrapper">
        <a href="/agent/account"><span class="z-btn z-btn-hollowB">取消</span></a>
        <span class="z-btn z-btn-default" disabled>前往邮箱验证</span>
    </div>
</div>
    <script>

        $("input").bind('input porpertychange',function(){
            if(passwordReg.test($(this).val())){
                $('.z-btn-default')[0].disabled = false;

            }else{
                $('.z-btn-default')[0].disabled = true;
            }
        });

        $('.z-btn-default').click(function(){
            var email = "{{$data->user['email']}}";
            var model = '62524';
            var _token = $("input[name='_token']").val();
            // 通过验证
            var psw = $("input[name='psw']").val();
            if(!psw){
                alert('请输入当前账户的旧密码');
                return false;
            }
            $.ajax({
                url:'/backend/companysendemail',
                type:'post',
                data:{'email':email,'model':model,'_token':_token},
                success:function(res){
                    console.log(res);
                    $('#reset_form').submit();
                }
            });
        })
    </script>
    @stop