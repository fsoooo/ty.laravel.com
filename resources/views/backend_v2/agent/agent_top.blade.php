<?php
$agent_active = preg_match("/\/agent\/agent_info\//",Request::getPathinfo()) ? "active" : '';
$performance_active = preg_match("/\/agent\/performance\//",Request::getPathinfo()) ? "active" : '';
$clients_active = preg_match("/\/agent\/clients\//",Request::getPathinfo()) ? "active" : '';
$plans_active = preg_match("/\/agent\/plan/",Request::getPathinfo()) ? "active" : '';
$product_active = preg_match("/\/agent\/products\//",Request::getPathinfo()) ? "active" : '';
?>
<div class="row">
    <ol class="breadcrumb col-lg-12">
        <li><a href="">代理人</a><i class="iconfont icon-gengduo"></i></li>
        <li><a href="">在职</a><i class="iconfont icon-gengduo"></i></li>
        <li class="active">{{$agent->user->name}}</li>
    </ol>
</div>
<div class="row">
    <div class="section">
        <div class="col-md-3 col-xs-6">
            <a href="{{url('/backend/agent/agent_info/' . $agent->id)}}" class="section-item {{$agent_active}}">
                <h4 class="title">个人信息</h4>
            </a>
        </div>
        <div class="col-md-3 col-xs-6">
            <a href="{{url('/backend/agent/performance/' . $agent->id)}}" class="section-item {{$performance_active}}">
                <h4 class="title">近期业绩</h4>
            </a>
        </div>
        <div class="col-md-3 col-xs-6">
            <a href="{{url('/backend/agent/products/' . $agent->id)}}" class="section-item {{$product_active}}">
                <h4 class="title">代理的产品</h4>
            </a>
        </div>
        <div class="col-md-3 col-xs-6">
            <a href="{{url('/backend/agent/clients/' . $agent->id)}}" class="section-item {{$clients_active}}">
                <h4 class="title">代理的客户</h4>
            </a>
        </div>
        <div class="col-md-3 col-xs-6">
            <a href="{{url('/backend/agent/plans/' . $agent->id)}}" class="section-item {{$plans_active}}">
                <h4 class="title">计划书</h4>
            </a>
        </div>
        <div class="col-md-3 col-xs-6">
            <a href="{{url('/backend/agent/true_info/' . $agent->id)}}" class="section-item">
                <h4 class="title">实名资料</h4>
            </a>
        </div>
        {{--<div class="col-md-3 col-xs-6">--}}
            {{--<a href="" class="section-item">--}}
                {{--<h4 class="title">沟通记录</h4>--}}
            {{--</a>--}}
        {{--</div>--}}
        {{--<div class="col-md-3 col-xs-6">--}}
            {{--<a href="" class="section-item">--}}
                {{--<h4 class="title">评价</h4>--}}
            {{--</a>--}}
        {{--</div>--}}
    </div>
</div>