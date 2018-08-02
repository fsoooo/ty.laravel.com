@extends('frontend.guests.person_home.base')
@section('content')

    <div class="section user-wrapper clearfix">
        <div class="user-wrapper-left">
            <div class="user-header">
                @if(isset($user_type['UserThird'])&&!empty($user_type['UserThird']['img']))
                    <img src="{{$user_type['UserThird']['img']}}" />
                @else
                    <img src="{{config('view_url.person_url').'image/头像 女孩.png'}}" />
                @endif
            </div>
            <div class="user-account">
                <div>
                    <span class="user-name">@if(isset($_COOKIE['user_name'])){{$_COOKIE['user_name']}}@endif</span>
                    <!--已实名显示-->
                    @if(!isset($auth_person))
                            <i class="icon-unauthentication">未实名</i>
                    @elseif($auth_person->status == 0)
                    <i class="icon-authentication">未审核</i>
                    @elseif($auth_person->status == 2)
                        <i class="icon-authentication">已认证</i>
                    @else
                        <i class="icon-authentication">认证失败</i>
                    @endif
                    <!--未实名显示-->
                </div>
                <div>
                    <span>账户安全：</span>
										<span class="safety-wrapper">
											<!--<i style="background: #ff642e"></i>
											<i style="background: #ffb32e"></i>
											<i style="background: #fff82e"></i>
											<i style="background: #b3ff2e"></i>
											<i style="background: #d8d7d9"></i>
											<span class="safety-text">较高</span>-->
										</span>
                </div>
            </div>

        </div>
        <div class="user-wrapper-middle">
            {{--<div class="user-wrapper-title">至<span>12月31日</span>，您有<span>16份</span>保险将失效</div>--}}
            <div class="user-case">
                <div>
                    <i class="iconfont icon-assessedbadge"></i>
                    <span>在保中</span>
                    {{--<i class="icon-tips">1</i>--}}
                </div>
                <div>
                    <i class="iconfont icon-iconfontstop"></i>
                    <span>待支付</span>
                    {{--<i class="icon-tips">2</i>--}}
                </div>
                <div>
                    <i class="iconfont icon-trade"></i>
                    <span>待续缴</span>
                </div>
                <div>
                    <i class="iconfont icon-favorite"></i>
                    <span>待评价</span>
                </div>
            </div>
        </div>
        <div class="user-wrapper-right">
            <div class="user-wrapper-title">您的身价</div>
            <div class="user-social"></div>
            <div class="user-operation">
                <a href="">投保评估</a>
                <a class="fr" href="">定制需求</a>
            </div>
        </div>
    </div>
    <div class="section progress-wrapper">
        <div class="section-title">
            <span class="bold">进度提醒</span>
            <a class="btn-more" href="#">全部进度<i class="iconfont icon-gengduo"></i></a>
        </div>
        <table>
            <tr>
                <th width="180px">产品名称</th>
                <th width="235px">业务类型</th>
                <th width="60px">处理状态</th>
                <th width="235px">发起时间</th>
                <th width="60px">查看详情</th>
            </tr>
            {{--<tr>--}}
                {{--<td class="showcode">--}}
                    {{--<div class="order-name">“奔跑吧兄弟”猝死专项“奔跑吧兄弟”猝死专项</div>--}}
                    {{--<div class="order-code">订单号：1546564549861564456566662</div>--}}
                {{--</td>--}}
                {{--<td>权益批改</td>--}}
                {{--<td>暂未处理</td>--}}
                {{--<td>2017-08-25</td>--}}
                {{--<td>--}}
                    {{--<a class="btn-more" href="#">详情</a>--}}
                {{--</td>--}}
            {{--</tr>--}}
            {{--<tr>--}}
                {{--<td class="showcode">--}}
                    {{--<div class="order-name">“奔跑吧兄弟”猝死专项“奔跑吧兄弟”猝死专项</div>--}}
                    {{--<div class="order-code">订单号：1546564549861564456566662</div>--}}
                {{--</td>--}}
                {{--<td>权益批改</td>--}}
                {{--<td>已生效</td>--}}
                {{--<td>2017-08-25</td>--}}
                {{--<td>--}}
                    {{--<a class="btn-more" href="#">详情</a>--}}
                {{--</td>--}}
            {{--</tr>--}}
            {{--<tr>--}}
                {{--<td class="showcode">--}}
                    {{--<div class="order-name">“奔跑吧兄弟”猝死专项“奔跑吧兄弟”猝死专项</div>--}}
                    {{--<div class="order-code">订单号：1546564549861564456566662</div>--}}
                {{--</td>--}}
                {{--<td>权益批改</td>--}}
                {{--<td>处理中</td>--}}
                {{--<td>2017-08-25</td>--}}
                {{--<td>--}}
                    {{--<a class="btn-more" href="#">详情</a>--}}
                {{--</td>--}}
            {{--</tr>--}}
        </table>
    </div>
    <div class="section guarantee-wrapper" style="float:right;">
        <ul class="guarantee-content">
            <li>
                <div class="guarantee-img">
                    <img src="{{config('view_url.person_url').'image/保单验真.png'}}" />
                </div>
                <a href="#">保单验真</a>
            </li>
            <li>
                <div class="guarantee-img">
                    <img src="{{config('view_url.person_url').'image/我要理赔.png'}}" />
                </div>
                <a href="#">我要理赔</a>
            </li>
            <li>
                <div class="guarantee-img">
                    <img src="{{config('view_url.person_url').'image/我要退保.png'}}" />
                </div>
                <a href="#">我要退保</a>
            </li>
        </ul>
    </div>
    {{--<div class="section purchase-wrapper">--}}
        {{--<div class="section-title">--}}
            {{--<a class="btn-more" href="#">全部进度<i class="iconfont icon-gengduo"></i></a>--}}
        {{--</div>--}}
        {{--<div class="ui-tabControl">--}}
            {{--<div class="ui-tabControl-label">--}}
                {{--<span>我购买的</span>--}}
                {{--<span>给我买的</span>--}}
            {{--</div>--}}
            {{--<div class="ui-tabControl-content">--}}
                {{--<div>--}}
                    {{--<table>--}}
                        {{--<tr>--}}
                            {{--<th width="180px">产品名称</th>--}}
                            {{--<th width="235px">保障权益</th>--}}
                            {{--<th width="60px">保费</th>--}}
                            {{--<th width="235px">保障时间</th>--}}
                            {{--<th width="60px">查看详情</th>--}}
                        {{--</tr>--}}
                        {{--<tr>--}}
                            {{--<td class="showcode">--}}
                                {{--<div class="order-name">“奔跑吧兄弟”猝死专项“奔跑吧兄弟”猝死专项</div>--}}
                                {{--<div class="order-code">订单号：1546564549861564456566662</div>--}}
                            {{--</td>--}}
                            {{--<td><div class="ellipsis">身故、伤残 、猝死</div></td>--}}
                            {{--<td>175.00</td>--}}
                            {{--<td>2017-08-25至2018-08-25</td>--}}
                            {{--<td>--}}
                                {{--<a class="btn-more" href="#">详情</a>--}}
                            {{--</td>--}}
                        {{--</tr>--}}
                        {{--<tr>--}}
                            {{--<td class="showcode">--}}
                                {{--<div class="order-name">“奔跑吧兄弟”猝死专项“奔跑吧兄弟”猝死专项</div>--}}
                                {{--<div class="order-code">订单号：1546564549861564456566662</div>--}}
                            {{--</td>--}}
                            {{--<td><div class="ellipsis">身故、伤残 、猝死</div></td>--}}
                            {{--<td>175.00</td>--}}
                            {{--<td>2017-08-25至2018-08-25</td>--}}
                            {{--<td>--}}
                                {{--<a class="btn-more" href="#">详情</a>--}}
                            {{--</td>--}}
                        {{--</tr>--}}
                        {{--<tr>--}}
                            {{--<td class="showcode">--}}
                                {{--<div class="order-name">“奔跑吧兄弟”猝死专项“奔跑吧兄弟”猝死专项</div>--}}
                                {{--<div class="order-code">订单号：1546564549861564456566662</div>--}}
                            {{--</td>--}}
                            {{--<td><div class="ellipsis">身故、全残、重大疾病重大疾病</div></td>--}}
                            {{--<td>175.00</td>--}}
                            {{--<td>2017-08-25至2018-08-25</td>--}}
                            {{--<td>--}}
                                {{--<a class="btn-more" href="#">详情</a>--}}
                            {{--</td>--}}
                        {{--</tr>--}}
                    {{--</table>--}}
                {{--</div>--}}
                {{--<div>--}}
                    {{--33--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}
    {{--<div class="section browse-wrapper">--}}
        {{--<div class="section-title">--}}
            {{--<span class="bold">最近浏览</span>--}}
            {{--<a class="btn-more" href="#">更多<i class="iconfont icon-gengduo"></i></a>--}}
        {{--</div>--}}
        {{--<ul class="browse-content">--}}
            {{--<div class="browse-item">--}}
                {{--<h4>天眼旅游一日游险</h4>--}}
                {{--<ul>--}}
                    {{--<li>·80种重疾+38种轻症，保障更</li>--}}
                    {{--<li>·高现金价值，可做养老金使用</li>--}}
                {{--</ul>--}}
            {{--</div>--}}
            {{--<div class="browse-item">--}}
                {{--<h4>天眼旅游一日游险</h4>--}}
                {{--<ul>--}}
                    {{--<li>·80种重疾+38种轻症，保障更</li>--}}
                    {{--<li>·高现金价值，可做养老金使用</li>--}}
                {{--</ul>--}}
            {{--</div>--}}
        {{--</ul>--}}
    {{--</div>--}}
@stop

