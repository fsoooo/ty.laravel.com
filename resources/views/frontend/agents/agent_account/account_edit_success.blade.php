@extends('frontend.agents.agent_home.base')
@section('content')
    <link rel="stylesheet" href="{{config('view_url.agent_url')}}css/account.css" />
<div class="content">
    <ul class="crumbs">
        <li><a href="#">账户设置</a><i class="iconfont icon-gengduo"></i></li>
        <li><a href="#">认证资料填写</a><i class="iconfont icon-gengduo"></i></li>
        <li>修改信息</li>
    </ul>
    <div class="success">
        <div class="tips-wrapper" style="margin: 100px 100px;">
            <i class="iconfont icon-shenqingchenggong"></i>
            <p class="text">信息修改成功</p>
        </div>
        <div style="text-align: center;">
            <a href="/agent/account_reset_password" class="z-btn z-btn-positive">修改密码</a>
            <a href="/agent/account" class="z-btn z-btn-hollow">查看个人信息</a>
        </div>
    </div>
</div>
    @stop