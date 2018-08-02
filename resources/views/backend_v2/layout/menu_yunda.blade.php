<?php
$agent_active = preg_match("/\/backend\/agent\//",Request::getPathinfo()) ? "class=active" : '';
$policy = preg_match("/\/backend\/policy/",Request::getPathinfo()) ? "class=active" : '';
$order = preg_match("/\/backend\/order/",Request::getPathinfo()) ? "class=active" : '';
$brokerage_active = preg_match("/\/set_brokerage\//",Request::getPathinfo()) ? "class=active" : '';
$product_active = preg_match("/\/backend\/product\//",Request::getPathinfo()) ? "class=active" : '';
$task_active = preg_match("/\/backend\/task/",Request::getPathinfo()) ? "class=active" : '';
$channel = preg_match("/\/ditch_agent\//",Request::getPathinfo()) ? "class=active" : '';
$customer_active = preg_match("/\/backend\/customer\//",Request::getPathinfo()) ? "class=active" : '';
$label_active =  preg_match("/\/backend\/label\//",Request::getPathinfo()) ? "class=active" : '';
$channel_douwan =  preg_match("/\/channels\/douwan\//",Request::getPathinfo()) ? "class=active" : '';
$channel_yunda =  preg_match("/\/channels\/yunda\//",Request::getPathinfo()) ? "class=active" : '';
$nothing_active = !($agent_active || $brokerage_active ||$channel || $product_active ||$task_active || $customer_active || $order || $policy || $channel_douwan || $channel_yunda) ? "class=active" : '';
?>
<div class="menu-wrapper">
    <ul>
        <li {{$nothing_active}}><a href="{{url('/backend')}}"><i class="iconfont icon-shouye"></i>首页</a></li>
        {{--<li {{$agent_active}}><a href="{{url('backend/agent/list?work_status=1')}}"><i class="iconfont icon-dailiren"></i>代理人</a></li>--}}
        {{--<li><a href="{{url('/backend/sales/show')}}"><i class="iconfont icon-gongwenbao"></i>业务统计</a></li>--}}
        <li {{$product_active}}><a href="{{url('/backend/product/product_rank_list')}}"><i class="iconfont icon-chanpin"></i>产品管理</a></li>
        {{--<li {{$task_active}}><a href="{{ route('backend.task.index') }}"><i class="iconfont icon-xing"></i>任务管理</a></li>--}}
        {{--<li><a href="{{url('/backend/sell/ditch_agent/ditches')}}"><i class="iconfont icon-qudao"></i>渠道管理</a></li>--}}
        {{--<li {{$channel}}><a href="{{url('/backend/sell/ditch_agent/channel')}}"><i class="iconfont icon-qudao"></i>渠道管理</a></li>--}}
        {{--<li><a href=""><i class="iconfont icon-yunying"></i>运营管理</a></li>--}}
        {{--<li {{$brokerage_active}}><a href="{{url('/backend/set_brokerage/list')}}"><i class="iconfont icon-yunying"></i>佣金管理</a></li>--}}
        <li {{$customer_active}}><a href="{{ route('backend.customer.individual.index') }}"><i class="iconfont icon-kehu"></i>客户管理</a></li>
        {{--<li {{$label_active}}><a href="{{url('/backend/label/user_label')}}"><i class="iconfont icon-kehu"></i>标签管理</a></li>--}}
        <li {{$order}}><a href="{{url('/backend/order')}}"><i class="iconfont icon-yunying"></i>订单管理</a></li>
        <li {{$policy}}><a href="{{url('/backend/policy')}}"><i class="iconfont icon-qudao"></i>保单管理</a></li>
        {{--<li {{$channel_douwan}}><a href="{{url('/backend/channels/douwan')}}"><i class="iconfont icon-kehu"></i>投保管理(D)</a></li>--}}
        <li {{$channel_yunda}}><a href="{{url('/backend/channels/yunda/brokerage')}}"><i class="iconfont icon-xing"></i>佣金管理</a></li>
    </ul>
</div>
