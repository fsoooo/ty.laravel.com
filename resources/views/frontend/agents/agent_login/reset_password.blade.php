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
        <div class="title"><a href="login.html"><i class="iconfont icon-xiugaitouxiang"></i>代理人登录</a></div>
        <div class="change-password">
            <ul class="form-wrapper">
                <li>
                    <span class="name">新密码</span>
                    <input style="padding-left: 70px;" id="psw" type="password" placeholder="6-18位字符，必须由数字和字母组合" maxlength="18" name="newPassword"/>
                    <p id="psw-error" class="error-tips"></p>
                </li>
                <li>
                    <span class="name">确认密码</span>
                    <input style="padding-left: 70px;" id="cpsw" type="password" placeholder="6-18位字符，必须由数字和字母组合" maxlength="18" name="repeatPassword"/>
                    <p id="psw-cpsw" class="error-tips"></p>
                </li>
            </ul>
            <input type="hidden" name="_token" value="{{csrf_token()}}">
            <div class="success-tips" style="display: none;">修改成功</div>
            <button id="next" class="z-btn z-btn-default disabled" disabled>确定修改</button>
        </div>
    </div>
</div>


<script src="{{config('view_url.agent_url')}}js/lib/jquery-1.11.3.min.js"></script>
<script src="{{config('view_url.agent_url')}}js/common_agent.js"></script>
<script>
    var Ele = {
        psw: $('#psw'),
        cpsw: $('#cpsw'),
        next: $('#next'),
    }

    $('input').bind('input propertychange', function() {
        var _this = $(this);
        // 输入框样式
        if(_this.val()){
            _this.addClass('password');
        }else{
            _this.removeClass('password');
        }
        // 按钮是否禁用
        if(!Ele.psw.val() || !Ele.cpsw.val()){
            Ele.next.prop('disabled',true).addClass('disabled');
        }else{
            Ele.next.prop('disabled',false).removeClass('disabled');
        }
    });

    Ele.next.click(function(){
        $('.form-wrapper .error-tips').html('');
        if(!checkCorrect(Ele.psw,passwordReg)){
            $('#psw-error').html('密码格式错误请重新填写');
            init();
        }else if(Ele.psw.val() !== Ele.cpsw.val()){
            $('#psw-cpsw').html('密码不一致请重新填写');
            init();
        }else{
            var newPassword = $("input[name='newPassword']").val();
            var _token = $("input[name='_token']").val();
            var repeatPassword = $("input[name='repeatPassword']").val();
            $.ajax({
                url:'/reset_password_submit',
                data:{'newPassword':newPassword,'repeatPassword':repeatPassword,'_token':_token},
                type:'post',
                success:function(res){
                    console.log(res);
                    if (res['status']==200){
                        $('.success-tips').show();
                        setTimeout(function(){
                            location.href = '/agent';
                        },2000);
                    }else{
                        alert(res['msg']);
                    }
                }
            })
        }
    });
    // 表单初始化
    function init(){
        $('.form-wrapper input').val('').removeClass('password');
        Ele.next.prop('disabled',true).addClass('disabled');
    }

</script>
</body>
</html>
