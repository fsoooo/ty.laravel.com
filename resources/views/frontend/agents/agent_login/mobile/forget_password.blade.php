<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>忘记密码</title>
    <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
    <link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/lib/mui.min.css">
    <link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/lib/iconfont.css" />
    <link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/common_agent.css" />
</head>
<body>
<div class="mui-popover login-popover mui-active">
    <i class="iconfont icon-guanbi"></i>
    <div class="content forget-content">
        <form action="/check_code" method="post">
        <ul>
            <input type="hidden" name="_token" value="{{csrf_token()}}">
            <li>
                <input id="tel" type="text" placeholder="手机号码" maxlength="11" name="phone">
            </li>
            <li>
                <input id="code" type="text" placeholder="输入验证码" name="code">
                <span id="btn-send" class="zbtn zbtn-positive" disabled>获取验证码</span>
                {{--<p class="error-tips">验证码超时请重新获取</p>--}}
            </li>
        </ul>
        <div class="bottom-wrapper">
            <button id="next" class="btn-login disabled" disabled>下一步</button>
        </div>
        </form>
    </div>
</div>
<script src="{{config('view_url.agent_mob')}}js/lib/jquery-1.11.3.min.js"></script>
<script src="{{config('view_url.agent_mob')}}js/lib/mui.min.js"></script>
<script src="{{config('view_url.agent_mob')}}js/common_agent.js"></script>
<script>
    var Ele = {
        tel: $('#tel'),
        next: $('#next'),
        code: $('#code'),
        login: $('#login'),
        btn_send: $('#btn-send'),
    }


    // 按钮是否禁用
    $('#tel,#code').bind('input propertychange', function() {

        Ele.btn_send[0].disabled = !telReg.test(Ele.tel.val());

        if(!Ele.tel.val() || !Ele.code.val()){
            Ele.next.prop('disabled',true).addClass('disabled');
        }else{
            Ele.next.prop('disabled',false).removeClass('disabled');
        }
    });

    // 发送验证码
    Ele.btn_send.click(function(){
        var phone = $("input[name='phone']").val();
        var _token = $("input[name='_token']").val();
        var model = 109489;
        if (!phone || phone.length != 11){
            alert('请输入正确的手机号');
            return false;
        }
        $.ajax({
            url:'/backend/sendsms',
            data:{'_token':_token,'phone':phone,'model':model},
            type:'post',
            success:function(res){
                if (res['status'] == 0){
                    console.log(1);
                    timer(60,$(this));
                }else{
                    console.log(res);
                    alert(res['message']);
                }
            }
        });
    });

    // 点击下一步
    Ele.next.click(function(){
        // 验证码匹配成功后跳转
//        location.href = 'change_password.html';
    });
</script>
</body>
</html>
