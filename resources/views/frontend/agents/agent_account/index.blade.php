@extends('frontend.agents.agent_home.base')
@section('content')
    <link rel="stylesheet" href="{{config('view_url.agent_url')}}css/account.css" />
    <div class="content content-approve">
        <div class="info-wrapper">
            <div class="info">
                <div class="avatar">
                    <img src="{{config('view_url.agent_url')}}img/girl.png" alt="" />
                </div>
                <div class="info-list">
                    <p>
                        <span class="name">{{$data->user->name}}</span>
                        <span class="icon-unapprove">未实名</span>
                    </p>
                    <p>工号：{{$data->job_number}}</p>
                    <p>手机：{{$data->user->phone}}</p>
                    <p>渠道：{{$ditch->ditches[0]['name']}}</p>
                </div>
            </div>
            <a href="/agent/account_approve" class="z-btn z-btn-positive">去认证</a>
        </div>
        <div class="explain-wrapper">
            <i class="iconfont icon-information"></i>
            <div class="explain">
                <p>按照我国<a href="#">互联网管理规定</a>、<a href="#">《保险法》</a>及<a href="#">保险公司</a>要求，代理人需完成身份认证。</p>
                <p> 完成认证后，您可进行销售、管理客户、管理产品等业务操作。</p>
            </div>
        </div>
    </div>

    @stop