@extends('frontend.agents.agent_home.base')
@section('content')
    <link rel="stylesheet" href="{{config('view_url.agent_url')}}css/account.css" />
<div class="content">
    <ul class="crumbs">
        <li><a href="/agent/account">账户设置</a><i class="iconfont icon-gengduo"></i></li>
        <li>修改密码</li>
    </ul>
    <div class="success">
        <div class="tips-wrapper" style="margin: 100px 100px;">
            <i class="iconfont icon-shenqingchenggong"></i>
            <p class="text">密码修改成功</p>
        </div>
        <div style="text-align: center;">
            <a href="/agent" class="z-btn z-btn-positive">进入首页</a>
            <a href="/agent/account" class="z-btn z-btn-hollow">查看个人信息</a>
        </div>
    </div>
</div>
    @stop