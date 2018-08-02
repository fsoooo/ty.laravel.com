@extends('frontend.guests.layout.bases')
@section('content')
    <meta name="_token" content="{{ csrf_token() }}"/>
    <style>

    </style>
    <div id="content-wrapper">
        <div class="big-img" style="display: none;">
            <img src="" alt="" id="big-img" style="width: 75%;height: 90%;">
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <ol class="breadcrumb">
                            <li><a href="/">主页</a></li>
                            <li class="active"><span>修改密码</span></li>
                        </ol>
                        <h1>修改登录密码</h1>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="main-box clearfix" style="min-height: 1100px;">
                            <div class="tabs-wrapper tabs-no-header">
                                <ul class="nav nav-tabs">
                                    <li class="active"><a href="#">修改密码</a></li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane fade in active" id="tab-accounts">
                                        <h3><p>修改密码</p></h3>
                                        @include('backend.layout.alert_info')
                                        <div class="panel-group accordion" id="operation">
                                            <div class="panel panel-default">
                                                <form action="{{ url('/information/change_password_submit') }}" method="post" id="change-password-form">
                                                    {{ csrf_field() }}
                                                    <table id="user" class="table table-hover" style="clear: both">
                                                        <tbody>
                                                        <tr>
                                                            <td width="15%">原密码</td>
                                                            <td width="60%">
                                                                <input type="password" class="form-control" placeholder="请输入原密码" name="old_password">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>新密码</td>
                                                            <td><input type="password" class="form-control" placeholder="请输入密码" value="" name="new_password"></td>
                                                        </tr>
                                                        <tr>
                                                            <td>确认新密码</td>
                                                            <td><input type="password" class="form-control" placeholder="请再次输入新密码" value="" name="check_new_password"></td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </form>
                                            </div>
                                            <button id="change-password-btn" class="btn btn-success">确认修改</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <footer id="footer-bar" class="row">
                    <p id="footer-copyright" class="col-xs-12">
                        &copy; 2014 <a href="http://www.adbee.sk/" target="_blank">Adbee digital</a>. Powered by Centaurus Theme.
                    </p>
                </footer>
            </div>

        </div>
    </div>

    <script src="/js/jquery-3.1.1.min.js"></script>
    <script>
        $(function(){
            var change_password_btn = $('#change-password-btn');
            var change_password_form = $('#change-password-form');
            var old_password = $('input[name=old_password]');
            var new_password = $('input[name=new_password]');
            var check_new_password = $('input[name=check_new_password]');
            //获取正则表达式
            var password_pattern = {{ config('pattern.password') }};

            change_password_btn.click(function () {
                var old_password_val = old_password.val();
                var new_password_val = new_password.val();
                var check_new_password_val = check_new_password.val();
                if(old_password_val == ''){
                    old_password.parent().addClass("has-error");
                    alert('原密码不能为空');
                    return false;
                }else {
                    old_password.parent().removeClass("has-error");
                }



                var check_password = check(new_password,new_password_val,password_pattern,'密码');
                if(!check_password){
                    new_password.parent().addClass("has-error");
                    alert('密码格式错误，6-20位字母数字');
                    return false;
                }else {
                    new_password.parent().removeClass("has-error");
                }







                if(new_password_val != check_new_password_val){
                    new_password.parent().addClass("has-error");
                    check_new_password.parent().addClass("has-error");
                    alert('两次密码输入不同');
                    return false;
                }else{
                    new_password.parent().removeClass("has-error");
                    check_new_password.parent().removeClass("has-error");
                }



                change_password_form.submit();
            })

        })



        //写一个方法，用来验证
        function check(dom,dom_val,pattern,name)
        {
            if(dom == ''){//手机验证
                dom.parent().addClass("has-error");
                return false;
            }else if(!pattern.test(dom_val)) {
                dom.parent().addClass("has-error");
                return false;
            }else {
                dom.parent().removeClass("has-error");
                return true;
            }
        }

    </script>
@stop

