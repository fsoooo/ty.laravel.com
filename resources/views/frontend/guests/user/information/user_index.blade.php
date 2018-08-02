@extends('frontend.guests.person_home.account.base')
@section('content')
    <style>
        .main-wrapper {width: 1039px;padding: 60px 30px;background: #fff;}
        .user-wrapper {float: right;width: 424px;}
        .user-info>div:nth-child(2){margin: 30px;}
        .btn-save{margin: 88px 0 0 450px;}
        .form-wrapper input,.form-wrapper textarea{width: 346px;}
        select{width: 122px;background-position-x: 98px;}
        .error{display: block;padding-left: 70px;height: 20px;line-height: 20px;}
        #tel{width: 120px;}
    </style>
    <div class="user-wrapper">
        <div class="user-header">
            <img src="{{config('view_url.person_url').'image/头像 女孩.png'}}" />
        </div>
        <!--未实名显示-->
        @if(!$authentication)
        <div class="user-info">
            <div class="icon-unauthentication">未实名</div>
            <div><a href="/information/approvePerson">去认证</a></div>
            <div>用户类型：<span class="c025a8d">个人用户</span></div>
        </div>
        @else
        <!--实名显示-->
        <div class="user-info">
            <div class="icon-authentication">已实名</div>
            <div class="c025a8d">{{$information['name']}}</div>
            <div>用户类型：<span class="c025a8d">个人用户</span></div>
        </div>
            @endif
    </div>
    <form action="{{ url('/information/modification') }}" method="post" id="operation-form">
        {{ csrf_field() }}
    <ul class="form-wrapper">
        <li>
            <span class="form-name">手机号码</span>
            @if(!empty($information['phone']))
                <input id="tel" type="text" name="phone" maxlength="11" value="{{$information['phone']}}" disabled="disabled"/>
            @else
                <input id="tel" type="text" name="phone" maxlength="11" placeholder="请输入常用手机号码"  disabled="disabled"/>
            @endif
            <a class="blue" href="/information/home_page"><span><i class="iconfont icon-wancheng"></i>修改</span></a>
            <i class="error"></i>
        </li>
        <li>
            <span class="form-name">邮箱</span>
            @if(!empty($information['email']))
                <input id="email" type="email" name="email" value="{{$information['email']}}" />
            @else
                <input id="email" type="email" name="email" placeholder="请填写有效邮箱地址" />
            @endif
            <i class="error"></i>
        </li>
        {{--<li>--}}
            {{--<span class="form-name">常用地址</span>--}}
            {{--<select id="province" name="province"></select>--}}
            {{--<select id="city" name="city"></select>--}}
            {{--<select id="county" name="county"></select>--}}
            {{--<i class="error"></i>--}}
        {{--</li>--}}
        <li>
            <span class="form-name">常用地址</span>
            @if(!empty($information['inAddress']))
                {{--<span class="form-name"></span>--}}
                <textarea name="address" >{{$information['inAddress']}}</textarea>
            @else
                {{--<span class="form-name"></span>--}}
                <textarea name="in_address" placeholder="建议如实填写地址，方便您收取保单，例如 街道名称，门牌号，楼层和房间号等信息"></textarea>
            @endif
        </li>
        {{--<li>--}}
            {{--<span class="form-name">邮政编码</span>--}}
            {{--@if(!empty($information['postcode']))--}}
                {{--<input type="text" placeholder="您如果不清楚邮递区号，请填写000000" name="postcode" value="{{$information['postcode']}}" />--}}
            {{--@else--}}
                {{--<input type="text" placeholder="您如果不清楚邮递区号，请填写000000" name="postcode" />--}}
            {{--@endif--}}
        {{--</li>--}}
    </ul>
        <button class="btn-00a2ff btn-save">保存</button>
    </form>
@stop
<script src="/js/jquery-3.1.1.min.js"></script>
<script src="{{config('view_url.person_url').'js/lib/area.js'}}"></script>
<script src="{{config('view_url.person_url').'js/common.js'}}"></script>
<script>
    $(function () {
        $(".btn-save").click(function(){
            $("#operation-form").submit();
        });
    });


</script>
<script>
    $(function() {
        $('.btn-select').click(function() {
            $(this).addClass('active').siblings().removeClass('active');
        });
        new Cascade($("#province"), $("#city"), $("#county"));

        $('.btn-save').click(function(){
            $('.form-wrapper .error').html('');

            checkCorrect($('#tel'),telReg);
            checkCorrect($('#email'),emailReg);

            var mustArry = $('.form-wrapper input');
            mustArry.each(function(){
                checkEmpty(this);
            });
            var selectArry = $('.form-wrapper select');
            selectArry.each(function(){
                checkEmpty(this);
            });
            checkEmpty($('textarea'));
        });

        var code = "{{ $information['address'] }}";
        var segments = code.split(',');
        $("#province").find('option[value='+segments[0]+']').attr('selected', true);
        $("#city").find('option[value='+segments[0]+']').attr('selected', true);
        $("#county").find('option[value='+segments[0]+']').attr('selected', true);

    });
</script>
