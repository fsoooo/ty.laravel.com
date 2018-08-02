@extends('frontend.agents.agent_home.base')
@section('content')
    <link rel="stylesheet" href="{{config('view_url.agent_url')}}css/account.css" />
    <style>
        .content{
            height: 654px;
            background: url({{config('view_url.agent_url')}}img/bg.png) no-repeat;
            background-size: 100% 100%;
        }
        .success .tips-wrapper{
            color: #fff;
        }
        .success .text{
            font-size: 36px;
            font-weight: bold;
        }
        .success .z-btn-hollow{
            color: #fff;
            border-color: #fff;
        }
    </style>
    <div class="content" style="height: 560px;">
        <div class="success">
            <div class="tips-wrapper" style="margin: 100px 100px;">
                <i class="iconfont icon-chenggong1"></i>
                <p class="text">恭喜您已实名验证成功</p>
            </div>
            <div style="text-align: center;">
                <a href="/agent/account_reset_password" class="z-btn z-btn-positive">修改密码</a>
                <a href="/agent/account" class="z-btn z-btn-hollow">查看个人信息</a>
            </div>
        </div>
    </div>
    @stop