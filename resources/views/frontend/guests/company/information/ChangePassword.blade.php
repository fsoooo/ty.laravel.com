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
                                        @include('frontend.guests.layout.alert_info')
                                        <div class="panel-group accordion" id="operation">
                                            <div class="panel panel-default">
                                                <form action="{{ url('/information/change_password_submit') }}" method="post" id="change-password-form">
                                                    {{ csrf_field() }}
                                                    <table id="user" class="table table-hover" style="clear: both">
                                                        <tbody>
                                                        <tr>
                                                            <td width="15%">原密码</td>
                                                            <td width="60%">
                                                                <input type="text" class="form-control" placeholder="请输入原密码" name="old_password">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>新密码</td>
                                                            <td><input type="text" class="form-control" placeholder="请输入密码" value="" name="new_password"></td>
                                                        </tr>
                                                        <tr>
                                                            <td>确认新密码</td>
                                                            <td><input type="text" class="form-control" placeholder="请再次输入新密码" value="" name="check_new_password"></td>
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
            change_password_btn.click(function () {
                var new_password = $('input[name=new_password]').val();
                var check_new_password = $('input[name=check_new_password]').val();


                if(new_password != check_new_password){
                    alert('两次密码输入不同');
                    return false;
                }else {
                    change_password_form.submit();
                }
            })

        })

    </script>
@stop

