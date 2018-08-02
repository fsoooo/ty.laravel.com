<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>天眼互联-科技让保险无限可能</title>
    <link rel="stylesheet" href="{{config('view_url.agent_url')}}css/lib/iconfont.css" />
    <link rel="stylesheet" href="{{config('view_url.agent_url')}}css/common_agent.css" />
    <link rel="stylesheet" href="{{config('view_url.agent_url')}}css/login.css" />
</head>
<body>

<div class="login-wrapper">
    <div class="login-left">
        <div class="logo">
            <img src="{{config('view_url.agent_url')}}img/logo.png"/>
        </div>
        <p class="info">此处填写代理人工具产品简介或标语，此处填写代理人工具产品简介或标语，此处填写代理人工具产品简介或标语，此处填写代理人工具产品简介或标语</p>
    </div>

    <div class="login-right">
        <div class="title"><a href="/agent_login"><i class="iconfont icon-xiugaitouxiang"></i>代理人登录</a></div>
        <div class="forget-password">
            <form action="/check_code" method="post">
            <ul class="form-wrapper">
                <li>
                    <span class="name">手机号</span>
                    <input style="padding-left: 60px;" id="tel" type="tel" maxlength="11" name="phone"/></li>
                <input type="hidden" name="_token" value="{{csrf_token()}}">
                <li>
                    <input id="code" type="text" placeholder="输入验证码" name="code"/>
                    <span id="btn-send" class="z-btn z-btn-positive" disabled>发送验证码</span></li>
                <p class="error-tips">验证码错误请重新填写</p>
                <!--<p class="error-tips">验证码超时请重新填写</p>-->
            </ul>
            <button id="next" class="z-btn z-btn-default disabled" disabled>下一步</button>
            </form>
        </div>
    </div>
</div>


<script src="{{config('view_url.agent_url')}}js/lib/jquery-1.11.3.min.js"></script>
<script src="{{config('view_url.agent_url')}}js/common_agent.js"></script>
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
        Ele.btn_send[0].disabled = !checkCorrect(Ele.tel,telReg);

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
//        // 验证码匹配成功后跳转
//        var phone = $("input[name='phone']").val();
//        var code = $("input[name='code']").val();
//        var _token = $("input[name='_token']").val();
//        $.ajax({
//            url:'/check_code',
//            data:{'phone':phone,'code':code,'_token':_token},
//            type:'post',
//            success:function(res){
//
//            }
//        })
//        location.href = 'change_password.html';
    });
</script>
</body>
</html>
