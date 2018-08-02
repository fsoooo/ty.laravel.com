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
</head>
<body>
<div class="main">
    <header id="header" class="mui-bar mui-bar-nav">
        <a class="iconfont icon-fanhui mui-pull-left mui-action-back"></a>
        <h1 class="mui-title">安全设置</h1>
    </header>
    <div class="mui-content content-password">
        <div class="operation">
            <a href="/agent_sale/user_detail" class="btn-pass">取消</a>
        </div>
        <form id="form" action="" method="post">
        <div class="form-wrapper">
            <ul>
                <li>
                    <span class="name">手机号码</span>
                    <input type="text" value="{{$data['phone']}}" name="phone" readonly/>
                </li>
                <li>
                    <span class="name">验证码</span>
                    <input type="text" placeholder="输入验证码" name="code" />
                </li>
                <li class="error-tips"></li>
            </ul>
            <span id="send" class="zbtn zbtn-positive">发送验证码</span>
        </div>
            <input type="hidden" name="_token" value="{{csrf_token()}}">
        </form>
    </div>
    <div class="button-box">
        <button id="next" class="zbtn zbtn-default" disabled>下一步</button>
    </div>
</div>

<script src="{{config('view_url.agent_mob')}}js/lib/jquery-1.11.3.min.js"></script>
<script src="{{config('view_url.agent_mob')}}js/lib/mui.min.js"></script>
<script src="{{config('view_url.agent_mob')}}js/common_agent.js"></script>
<script>
    $('#send').on('tap',function(){
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

    // 按钮是否禁用
    $('input').bind('input propertychange', function() {
        $('#next')[0].disabled = !$(this).val()
    });

    // 验证码匹配
    $('#next').on('tap',function(){
        var phone = $("input[name='phone']").val();
        var _token = $("input[name='_token']").val();
        var code = $("input[name='code']").val();
        $.ajax({
            url:'/agent/check_code',
            type:'post',
            data:{'_token':_token,'phone':phone,'code':code},
            success:function(res){
                if (res['status'] == 'success'){
                    location.href = '/agent/reset_psw_step_second';
                }else{
                    var errorStr = res['message'];
                    $('.error-tips').text(errorStr);
                }
            }
        });
        // 验证码错误
//
    });
</script>
</body>
</html>
