@extends('frontend.agents.agent_home.base')
@section('content')
    <link rel="stylesheet" href="{{config('view_url.agent_url')}}css/account.css" />
    <div class="content content-account">
        <div class="avatar">
            <img src="{{config('view_url.agent_url')}}img/girl.png" alt="" />
        </div>
        <ul class="information">
            <li>
                <span class="name">真实姓名</span>
                <span>{{$res->name}}</span>
            </li>
            <li>
                <span class="name">工号</span>
                <span>{{$res->num}}</span>
            </li>
            <li>
                <span class="name">手机号码</span>
                <span>{{$res->phone}}</span>
            </li>
            <li>
                <span class="name">渠道</span>
                <span>{{$ditch->ditches[0]->name}}</span>
            </li>
            <li>
                <span class="name">邮箱</span>
                <span>{{$res->email}}</span>
            </li>
            <li>
                <span class="name">证件拍摄</span>
                <div class="certificate">
                    <div><img src="{{isset($agent_data->card_img_front)?url($agent_data->card_img_front):''}}" alt="" /></div>
                    <div><img src="{{isset($agent_data->card_img_backend)?url($agent_data->card_img_backend):''}}" alt="" /></div>
                    <div><img src="{{isset($agent_data->card_img_person)?url($agent_data->card_img_person):''}}" alt="" /></div>
                </div>
            </li>
            <form id="account_form" action="/agent/account_reset_password" method="post">
                <input type="hidden" name="_token" value="{{csrf_token()}}">
                <input type="hidden" name="phone" value="{{$res->phone}}">
            </form>
        </ul>
        <div class="btn-wrapper">
            <a href="/agent/account_edit" class="z-btn z-btn-default">修改个人信息</a>
            <a id="reset" href="javascript:;" class="z-btn z-btn-hollowB">修改密码</a>
        </div>
    </div>
    <script>
        $("#reset").click(function(){
            $("#account_form").submit();
        })
    </script>

    @stop