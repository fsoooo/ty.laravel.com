@extends('frontend.guests.company_home.base')
<style>
    .user-wrapper{padding: 16px 0;background: #fff;}
    .user-wrapper-left{float: left;margin-top: 26px;width: 600px;padding: 0 36px;}
    .user-name{margin: 36px 0 10px;font-size: 18px;}
    .user-wrapper-right{float: right;width: 240px;padding: 0 16px;border-left: 1px solid #f4f4f4;}
    .guarantee-content>li {height: 86px;line-height: 86px;border-bottom: 1px solid #f7f7f7;text-align: center;}
    .guarantee-content>li:last-child{border-bottom: none;}
    .col3,.col4,.col5{width: 200px;}
    .col7{width: 230px;}
    .table-body .col7{width: 164px;}
</style>
@section('content')
    <div class="section user-wrapper clearfix">
        <div class="user-wrapper-left">
            <div class="user-header">
                <img src="{{config('view_url.company_url').'image/头像 女孩.png'}}" />
            </div>
            <div class="user-account">
                <div class="user-name">@if(isset($_COOKIE['user_name'])){{$_COOKIE['user_name']}}@endif</div>
                <!--已实名显示-->
                @if($auth)
                <i class="icon-authentication">已认证</i>
                @else
                <!--未实名显示-->
                <i class="icon-unauthentication">未认证</i>
                @endif
            </div>
        </div>
        <div class="user-wrapper-right">
            <ul class="guarantee-content">
                <li>
                    <a href="#">在保人数</a>
                </li>
                <li>
                    <a href="#">已选方案</a>
                </li>
            </ul>
        </div>
    </div>
    <div class="table-nav">
        <span class="active">订单进度</span>
        <span>保单进度</span>
    </div>
    <div class="table-wrapper">
        <div class="table-head clearfix">
            <span class="col1">产品名称</span>
            <span class="col4">产品类型</span>
            <span class="col4">保费</span>
            <span class="col4">状态</span>
            <span class="col7">操作</span>
        </div>
        {{--<ul class="table-body">--}}
            {{--<li class="table-tr">--}}
                {{--<div class="table-tr-bottom">--}}
                    {{--<span>发起时间  2017-08-25</span>--}}
                    {{--<span>订单号  1643184562323123</span>--}}
                    {{--<span>VIP服务专员 张某某</span>--}}
                {{--</div>--}}
                {{--<div class="table-tr-top clearfix">--}}
                    {{--<div class="col1">--}}
                        {{--<div class="order-img">--}}
                            {{--<img src="{{config('view_url.company_url').'image/73805232439912337.png'}}" alt="" />--}}
                        {{--</div>--}}
                        {{--<h4 class="order-name">“奔跑吧兄弟” 猝死专项保障计 划 A款</h4>--}}
                    {{--</div>--}}
                    {{--<div class="col4">--}}
                        {{--意外险--}}
                    {{--</div>--}}
                    {{--<div class="col4">--}}
                        {{--80元/人/年--}}
                    {{--</div>--}}
                    {{--<div class="col4">--}}
                        {{--待支付--}}
                    {{--</div>--}}
                    {{--<div class="col7">--}}
                        {{--<div class="btn-wrapper">--}}
                            {{--<button class="btn">支付</button>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</li>--}}
            {{--<li class="table-tr">--}}
                {{--<div class="table-tr-bottom">--}}
                    {{--<span>发起时间  2017-08-25</span>--}}
                    {{--<span>订单号  1643184562323123</span>--}}
                    {{--<span>VIP服务专员 张某某</span>--}}
                {{--</div>--}}
                {{--<div class="table-tr-top clearfix">--}}
                    {{--<div class="col1">--}}
                        {{--<div class="order-img">--}}
                            {{--<img src="{{config('view_url.company_url').'image/73805232439912337.png'}}" alt="" />--}}
                        {{--</div>--}}
                        {{--<h4 class="order-name">“奔跑吧兄弟” 猝死专项保障计 划 A款</h4>--}}
                    {{--</div>--}}
                    {{--<div class="col4">--}}
                        {{--意外险--}}
                    {{--</div>--}}
                    {{--<div class="col4">--}}
                        {{--80元/人/年--}}
                    {{--</div>--}}
                    {{--<div class="col4">--}}
                        {{--已支付--}}
                    {{--</div>--}}
                    {{--<div class="col7">--}}
                        {{--<div class="btn-wrapper">--}}
                            {{--<button class="btn">查看详情</button>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</li>--}}
            {{--<li class="table-tr">--}}
                {{--<div class="table-tr-bottom">--}}
                    {{--<span>发起时间  2017-08-25</span>--}}
                    {{--<span>订单号  1643184562323123</span>--}}
                    {{--<span>VIP服务专员 张某某</span>--}}
                {{--</div>--}}
                {{--<div class="table-tr-top clearfix">--}}
                    {{--<div class="col1">--}}
                        {{--<div class="order-img">--}}
                            {{--<img src="{{config('view_url.company_url').'image/73805232439912337.png'}}" alt="" />--}}
                        {{--</div>--}}
                        {{--<h4 class="order-name">“奔跑吧兄弟” 猝死专项保障计 划 A款</h4>--}}
                    {{--</div>--}}
                    {{--<div class="col4">--}}
                        {{--意外险--}}
                    {{--</div>--}}
                    {{--<div class="col4">--}}
                        {{--80元/人/年--}}
                    {{--</div>--}}
                    {{--<div class="col4">--}}
                        {{--已失效--}}
                    {{--</div>--}}
                    {{--<div class="col7">--}}
                        {{--<div class="btn-wrapper">--}}
                            {{--<button class="btn">查看详情</button>--}}
                            {{--<button class="btn">删除</button>--}}
                            {{--<button class="btn">再次购买</button>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</li>--}}

        {{--</ul>--}}
    </div>
@stop

