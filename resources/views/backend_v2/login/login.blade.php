<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>@section('title') ty - @show</title>
    <link rel="stylesheet" href="{{asset('r_backend/v2/css/lib/bootstrap.min.css')}}" />
    <link rel="stylesheet" href="{{asset('r_backend/v2/css/lib/iconfont.css')}}" />
    <link rel="stylesheet" href="{{asset('r_backend/v2/css/common_backend.css')}}" />
    <link rel="stylesheet" href="{{asset('r_backend/v2/css/lib/bootstrap-datetimepicker.min.css')}}" />
    <link rel="stylesheet" href="{{asset('r_backend/v2/css/login.css')}}" />
    <link rel="stylesheet" href="{{asset('r_backend/v2/css/lib/unlock.css')}}" />
@section('head-more')@show
</head>

<body>
<div class="login-wrapper">
    <div class="logo-wrapper">
        <img src="{{asset('r_backend/v2/img/logo-login.png')}}"/>
    </div>
    {{--@if (count($errors) > 0)--}}
        {{--<div class="error alert alert-danger">--}}
            {{--<ul>--}}
                {{--@foreach ($errors->all() as $error)--}}
                    {{--<li>{{ $error }}</li>--}}
                {{--@endforeach--}}
            {{--</ul>--}}
        {{--</div>--}}
    {{--@endif--}}
    {{--<div class="error">账号或密码错误</div>--}}
    <div>
        <form role="form" action="{{url('backend/do_login')}}" method="post">
            {{ csrf_field() }}
            <div class="input-group">
                <span class="input-group-addon"><i class="iconfont icon-zhanghao"></i></span>
                <input type="text" id="username" class="form-control" name="email" placeholder="邮箱地址" >

            </div>
            <div class="input-group">
                <span class="input-group-addon"><i class="iconfont icon-mima"></i></span>
                <input type="password" id="password" class="form-control" name="password" placeholder="账户密码" >

            </div>
            <div class="pattern" type="0" style="position: relative;">
                <div class="slide-to-unlock-bg" style="width: 298px; height: 38px; background-color: rgb(238, 238, 238);">
                    <span style="line-height: 38px; font-size: 12px; color: rgb(51, 51, 51);">请按住滑块，拖动至最右边</span>
                </div>
                <div class="slide-to-unlock-progress" style="background-color: rgb(35, 202, 86); height: 38px;"></div>
                <div class="slide-to-unlock-handle" style="background-color: rgb(238, 238, 238); height: 38px; line-height: 38px; width: 46px;">
                    <i class="iconfont icon-jiantouzuoshuang-"></i>
                </div>
            </div>
            <button style="margin-top: 40px;" id="login" class="btn btn-primary" disabled>登录</button>
        </form>
    </div>
    {{--alert--}}
    <div class="row" style="margin-top: 5px;">
        @if (session('status'))
            <div class="mask show-success">
                <div class="mask-bg"></div>
                <div class="mask-container">{{ session('status') }}</div>
            </div>
        @endif
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
    {{--end alert--}}
</div>
<script src="{{asset('r_backend/v2/js/lib/jquery-1.11.3.min.js')}}"></script>
<script src="{{asset('r_backend/v2/js/lib/unlock.js')}}"></script>
<script src="{{asset('r_backend/v2/js/common_backend.js')}}"></script>
<script>
    var $pattern = $('.pattern');
    $pattern.slideToUnlock({
        height : 30,
        succText : '验证通过',
        bgColor : '#d8d7d9',
        progressColor : '#00a2ff',//已经拖动的颜色
        succColor : '##00a2ff',  //成功的颜色
        textColor : '#fff',     //字体的颜色
        font_size : '16',
        succTextColor : '#fff',  //成功后的字体颜色
        handleColor : '#fff',
        successFunc : function () {
            $pattern.attr('type','1')
            check();
        }
    });

    $('input').bind('input propertychange', function() {
        check();
    });

    function check(){
        if(!$('#username').val() || !$('#password').val() || !parseInt($('.pattern').attr('type'))){
            $('#login').prop('disabled',true);
        }else{
            $('#login').prop('disabled',false);
        }
    }

//    $("input").on('input porpertychange',function(){
//        if(!$('#username').val() || !$('#password').val()){
//            $('#login').prop('disabled',true);
//        }else{
//            $('#login').prop('disabled',false);
//        }
//    });
</script>
</body>

</html>