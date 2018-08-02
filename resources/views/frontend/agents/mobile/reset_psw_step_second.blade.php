<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>安全设置</title>
    <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
    <link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/lib/mui.min.css">
    <link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/lib/iconfont.css" />
    <link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/common_agent.css" />
    <link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/account.css" />
    <style>
        .error-tips{
            display: none;
        }
    </style>
</head>
<body>
<div class="main">
    <header id="header" class="mui-bar mui-bar-nav">
        <a class="iconfont icon-fanhui mui-pull-left mui-action-back"></a>
        <h1 class="mui-title">安全设置</h1>
    </header>
    <div class="mui-content content-password">
        <div class="form-wrapper">
            <div class="operation">
                <a href="/agent_sale/user_detail" class="btn-pass">取消</a>
            </div>
                <input type="hidden" name="_token" value="{{csrf_token()}}">
            <ul>
                <li>
                    <span class="name">原始密码</span>
                    <input id="ipsw" type="password" placeholder="请输入" name="old" />
                </li>
                <li class="error-tips tips1">11</li>
                <li>
                    <span class="name">新密码</span>
                    <input id="psw" type="password" placeholder="6-18位字符，必须由数字和字母组合" name="new" />
                </li>
                <li class="error-tips tips2">ff</li>
                <li>
                    <span class="name">确认密码</span>
                    <input id="cpsw"  type="password" placeholder="6-18位字符，必须由数字和字母组合" name="reNew" />
                </li>
                <li class="error-tips tips3">11</li>
            </ul>
            <button id="next" class="zbtn zbtn-positive disabled" disabled>确认修改</button>
        </div>
    </div>
</div>

<script src="{{config('view_url.agent_mob')}}js/lib/jquery-1.11.3.min.js"></script>
<script src="{{config('view_url.agent_mob')}}js/lib/mui.min.js"></script>
<script src="{{config('view_url.agent_mob')}}js/common_agent.js"></script>
<script>
    var Ele = {
        ipsw: $('#ipsw'),
        psw: $('#psw'),
        cpsw: $('#cpsw'),
        next: $('#next'),
        tips1: $('.tips1'),
        tips2: $('.tips2'),
        tips3: $('.tips3'),
    }

    // 按钮是否禁用
    $('input').bind('input propertychange', function() {
        if(!Ele.ipsw.val() || !Ele.psw.val() || !Ele.cpsw.val()){
            Ele.next.prop('disabled',true);
        }else{
            Ele.next.prop('disabled',false);
        }
    });

    Ele.next.click(function(){
        $('.error-tips').html('').hide();

        // 密码输入错误时显示
        //Ele.tips2.html('密码格式错误请重新输入').show();
        //init();

        if(!passwordReg.test(Ele.psw.val())){
            Ele.tips2.html('密码格式错误请重新输入').show();
            init();
        }else if(Ele.psw.val() !== Ele.cpsw.val()){
            Ele.tips3.html('两次密码不一致请重新输入').show();
            init();
        }else{ // 认证成功
            var old = $("input[name='old']").val();
            var newPsw = $("input[name='new']").val();
            var rePsw = $("input[name='reNew']").val();
            var _token = $("input[name='_token']").val();
            $.ajax({
                url:'/agent/mobile_check_agent',
                data:{'_token':_token,'old':old,'new':newPsw,'rePsw':rePsw},
                type:'post',
                success:function(res){
                    if (res['status'] == 200){
                        location.href='/agent/reset_psw_success';
                    }else{
                        alert(res['msg']);
                    }
                }
            });
        }

    });
    // 表单初始化
    function init(){
        $('input').val('');
        Ele.next.prop('disabled',true).addClass('disabled');
    }
</script>
</body>
</html>
