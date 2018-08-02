@extends('frontend.guests.company_home.account.base')
@section('content')
    <style>
        .main-wrapper {width: 1039px;padding: 60px 30px;background: #fff;}
        .upload-wrapper{display: inline-block;width: 288px;height: 150px;background: #F3F3F3;}
        .form-wrapper{width: 400px;margin: 40px auto;}
        .form-wrapper li:last-child span{vertical-align: top;}
        .form-wrapper .form-name{width: 100px;}
        .btn-wrapper{margin: 10px 0 10px 104px;}
        .btn-select {position: relative;padding: 0 14px;margin-right: 18px;height: 30px;line-height: 30px;border: 1px solid #dcdcdc;}
        .btn-select.active {border: 1px solid #00a2ff;}
        .btn-select.active:after {content: '';position: absolute;right: -1px;bottom: -3px;width: 0;height: 0;border-top: 4px solid transparent;border-bottom: 4px solid transparent;border-left: 4px solid #00a2ff;transform: rotate(45deg);}
        .btn-save{margin-left: 500px;}
        .btn-upload {margin-left: 200px;width: 104px;height: 30px;}
        select{width: 89px;}
        .error{margin-left: 104px;}
        #code{width: 185px;}
        .btn-code{width: 70px;}
    </style>
    <form action="{{url('/information/changePass')}}" method="post">
        {{ csrf_field() }}
        <ul class="form-wrapper">
            <li>
                <span class="form-name">当前密码</span>
                <input id="oldPassword" type="password" maxlength="18" name="oldPass" placeholder="6-18位字符，必须由数字和字母组合" />
                <i class="error"></i>
            </li>
            <li>
                <span class="form-name">新密码</span>
                <input id="newPassword" type="password" maxlength="18" name="newPass" placeholder="6-18位字符，必须由数字和字母组合" />
                <i class="error"></i>
            </li>
            <li>
                <span class="form-name">确认新密码</span>
                <input id="confirmPassword" type="password" maxlength="18" name="sureNewPass" placeholder="6-18位字符，必须由数字和字母组合" />
                <i class="error"></i>
            </li>
        </ul>
        <button type="submit" class="btn-00a2ff btn-save" id="done">保存</button>
    </form>
@stop




