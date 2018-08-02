<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>天眼互联-科技让保险无限可能</title>
    <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
    <link rel="stylesheet" href="{{config('view_url.view_url')}}mobile/personal/css/lib/mui.min.css">
    <link rel="stylesheet" href="{{config('view_url.view_url')}}mobile/personal/css/lib/iconfont.css" />
    <link rel="stylesheet" href="{{config('view_url.view_url')}}mobile/personal/css/common.css" />
</head>

<body>
<div id="loginPopover" class="mui-popover">
    <i class="iconfont icon-guanbi" id="shutDown"></i>
    <div class="login-wrapper">
        <form action="{{url('/information/changePass')}}" method="post">
            {{ csrf_field() }}
        <ul>
            <li>
                <input id="oldPassword" type="password" placeholder="请输入旧密码" name="oldPass" />
            </li>
            <li>
                <input id="newPassword" type="password" placeholder="请输入新密码,字母、数字都必须有" name="newPass" />
            </li>
            <li>
                <input id="confirmPassword" type="password" placeholder="确认新密码" name="sureNewPass" />
            </li>
        </ul>
        <button class="btn-disabled" disabled="disabled">确定</button>
        </form>
    </div>
</div>

<script src="{{config('view_url.view_url')}}mobile/personal/js/lib/jquery-1.11.3.min.js"></script>
<script src="{{config('view_url.view_url')}}mobile/personal/js/lib/mui.min.js"></script>
<script src="{{config('view_url.view_url')}}mobile/personal/js/common.js"></script>
<script type="text/javascript">
    var Ele = {
        btnpassword : $('.btn-disabled'),
    };
    var oldPasswordVal,newPasswordVal,confirmPasswordVal;
    mui('.mui-popover').popover('show');
    $("input").on("input propertychange", function() {
        oldPasswordVal = $("#oldPassword").val();
        newPasswordVal = $("#newPassword").val();
        confirmPasswordVal = $("#confirmPassword").val();

        if(oldPasswordVal&&newPasswordVal&&confirmPasswordVal){
            Ele.btnpassword.css({'background': '#00a2ff'}).removeAttr('disabled');
        }else{
            Ele.btnpassword.css({'background': '#adadad'}).attr('disabled','disabled');
        }
    });

    Ele.btnpassword.on('tap', function() {
        if(newPasswordVal.length<6){
            mui.toast('密码至少6位');
        }else if(newPasswordVal!==confirmPasswordVal){
            mui.toast('两次输入的密码不一致');
        }else{
            console.log('找回密码');
        }
    });
    $(document).ready(function(){
        $('#shutDown').click(function(){
            history.back();
            {{--location.href = "{{url('/mpersonal/manage')}}";--}}
        });
    });
</script>
</body>

</html>