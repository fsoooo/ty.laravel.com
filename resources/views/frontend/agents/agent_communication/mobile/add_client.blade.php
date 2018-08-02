<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>新建个人客户</title>
    <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
    <link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/lib/mui.min.css">
    <link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/lib/mui.picker.all.css">
    <link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/lib/iconfont.css" />
    <link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/common_agent.css" />
    <link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/client.css" />
</head>
<body>
<div class="main">
    <header id="header" class="mui-bar mui-bar-nav">
        <a class="iconfont icon-fanhui mui-pull-left mui-action-back"></a>
        <h1 class="mui-title">新建个人客户</h1>
    </header>
    <div class="mui-content add">
        <div class="mui-scroll-wrapper">
            <div class="mui-scroll">
                <div class="form-wrapper">
                    <form action="">
                    <div class="header-img">
                        <img src="{{config('view_url.agent_mob')}}img/upload.png"/>
                        <input id="uploadImg" hidden="hidden" type="file" onchange="upLoadImg(this,upLoaded);" name="file_img" accept="image/*" />
                        <input id="avatar" hidden type="text"></input>
                    </div>
                    <ul>
                        <li>
                            <span class="name">姓名</span>
                            <input class="mustFill" name="name" id="Name" type="text" placeholder="请填写真实姓名" />
                        </li>
                        <li class="radioBox">
                            <span class="name">性别</span>
                            <div class="select-box">
                                <span class="zbtn-select active">女</span>
                                <span class="zbtn-select">男</span>
                            </div>
                            <div class="select-value">
                                <input checked type="radio" value="0" name="sex"/>
                                <input type="radio" value="1" name="sex"/>
                            </div>
                        </li>
                        <li class="pickerDate">
                            <span class="name">出生日期</span>
                            <input class="mustFill" type="text" placeholder="请选择" />
                            <i class="iconfont icon-gengduo"></i>
                            <input hidden class="inputhidden" name="birthday" type="text" />
                        </li>
                        <li>
                            <span class="name">证件号码</span>
                            <input class="mustFill" id="IdCard" name="id_code" type="text" placeholder="必填" />
                        </li>
                        <li>
                            <span class="name">职业</span>
                            <input class="mustFill" type="text" name="occupation" placeholder="必填" />
                        </li>
                        <li>
                            <span class="name">手机号码</span>
                            <input class="mustFill" id="Tel" type="tel" name="phone" maxlength="11" placeholder="必填" />
                        </li>
                        <li>
                            <span class="name">邮箱地址</span>
                            <input class="mustFill" id="Email" name="email" type="text" placeholder="必填" />
                        </li>
                        <li>
                            <span class="name">其他信息</span>
                            <input type="text" name="other" placeholder="选填" />
                        </li>
                        {{--<li>--}}
                            {{--<span class="name">客户印象</span>--}}
                            {{--<div class="labels-add">--}}
                                {{--<span>豪气</span>--}}
                                {{--<input class="btn-add" value="自定义标签" />--}}
                            {{--</div>--}}
                        {{--</li>--}}
                    </ul>
                    </form>
                </div>
                <input type="hidden" name="_token" value="{{csrf_token()}}">
            </div>
        </div>
        <div class="button-box">
            <button id="create" class="zbtn zbtn-default" disabled>添加</button>
        </div>
    </div>
</div>

<script src="{{config('view_url.agent_mob')}}js/lib/jquery-1.11.3.min.js"></script>
<script src="{{config('view_url.agent_mob')}}js/lib/mui.min.js"></script>
<script src="{{config('view_url.agent_mob')}}js/lib/mui.picker.all.js"></script>
<script src="{{config('view_url.agent_mob')}}js/common_agent.js"></script>
<script>
    $('.header-img').on('tap',function(){
        console.log('up');
        $('#uploadImg').click();
    });
    selectData('.radioBox','single');
    // 上传照片回调
    function upLoaded(){
        check();
    }
    pickerDate('.pickerDate',function(){
        check();
    });

    // 实时监听必填项
    $('input').bind('input propertychange', function() {
        check();
    });
    function check(){
        if(!checkMustFill('.mustFill')){
            $('#create').prop('disabled',true);
        }else{
            $('#create').prop('disabled',false);
        }
    }

    // 点击提交数据
    $('#create').on('tap',function(){
        checkReg();
    });

    function checkReg(){
        if(!checkCorrect($('#Name'),nameReg) || !checkCorrect($('#Tel'),telReg) || !checkCorrect($('#Email'),emailReg)){
            console.log('校验不通过,不提交数据');
        }else{
            console.log('校验通过,提交数据');
            var data = $("form").serializeArray();
            var _token = $("input[name='_token']").val();
            $.ajax({
                url:'/agent_sale/communication_add_client_submit',
                type:'post',
                data:{_token:_token,data:data},
                success:function(res){
                    if (res['status'] == 400){
                        alert(res['msg']);
                    }else
                    {
                        var frommUrl = sessionStorage.getItem('frommUrl');
                        if(frommUrl){
                            var val = res['user_id']; // 该添加的用户id标识
                            sessionStorage.setItem('clientId',val);
                            location.href = frommUrl;
                        }
                    }
                }
            });
        }
    }
</script>
</body>
</html>
