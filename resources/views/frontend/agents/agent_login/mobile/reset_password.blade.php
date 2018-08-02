<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>修改密码</title>
    <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
    <link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/lib/mui.min.css">
    <link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/lib/iconfont.css" />
    <link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/common_agent.css" />
</head>
<body>
<div class="mui-popover login-popover mui-active">
    <i class="iconfont icon-guanbi"></i>
    <div class="content change-content">
        <p class="explain">密码6-18位字符，必须由数字和字母组合</p>
        <ul>
            <li>
                <input id="psw" type="password" placeholder="新密码" maxlength="18" name="newPassword">
                <p id="psw-error" class="error-tips"></p>
            </li>
            <input type="hidden" name="_token" value="{{csrf_token()}}">
            <li>
                <input id="cpsw" type="password" placeholder="确认密码" maxlength="18" name="repeatPassword">
                <p id="psw-cpsw" class="error-tips"></p>
            </li>
        </ul>
        <div class="success-tips">修改成功</div>
        <div class="bottom-wrapper">
            <button id="next" class="btn-login disabled" disabled>确定修改</button>
        </div>
    </div>
</div>
<script src="{{config('view_url.agent_mob')}}js/lib/jquery-1.11.3.min.js"></script>
<script src="{{config('view_url.agent_mob')}}js/lib/mui.min.js"></script>
<script src="{{config('view_url.agent_mob')}}js/common_agent.js"></script>
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
        $('.content .error-tips').html('');


        if(!passwordReg.test(Ele.psw.val())){
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
                        location.href='/forget_password';
                    }
                }
            })
        }

    });
    // 表单初始化
    function init(){
        $('.content input').val('').removeClass('password');
        Ele.next.prop('disabled',true).addClass('disabled');
    }
</script>
</body>
</html>
