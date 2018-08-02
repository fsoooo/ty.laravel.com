<?php
$index_active = preg_match("/\/\//",Request::getPathinfo()) ? "active open" : "";
?>
<li class="{{$index_active}}">
    <a href="/backend">
        <i class="iconfont icon-viewgallery"></i>
        <span>首页</span>
    </a>
</li>

<?php
$product_active = preg_match("/\/product\//",Request::getPathinfo()) ? "active open" : "";
?>

<li class="{{$product_active}}">
    <a href="#" class="dropdown-toggle">
        <i class="iconfont icon-copy"></i>
        <span>产品管理</span>
    </a>
    <ul class="submenu">
        <li>
            <a href="/backend/product/productlists">
                产品池
            </a>
        </li>
        <li>
            <a href="/backend/product/productlist">
                产品列表
            </a>
        </li>
        <li>
            <a href="/backend/product/productlabels">
                产品标签
            </a>
        </li>
    </ul>
</li>

<?php
$a = preg_match("/\/claim\//",Request::getPathinfo());
$b = preg_match("/\/warranty\//",Request::getPathinfo());
$c = preg_match("/\/maintenance\//",Request::getPathinfo());
$order_active = preg_match("/\/order\//",Request::getPathinfo());
$cancel_active = preg_match("/\/cancel\//",Request::getPathinfo());
if($a||$b||$c||$order_active||$cancel_active){
    $after_active = 'active open';
}else{
    $after_active = '';
}
if($c){
    $maintenance_active = 'active opoen';
}else{
    $maintenance_active = '';
}
$order_child_active = $order_active?'active open':'';
$cancel_child_active = $cancel_active?'active open':'';

?>


{{--<li class="{{ $after_active }}">--}}
    {{--<a href="#" class="dropdown-toggle">--}}
        {{--<i class="iconfont icon-productfeatures"></i>--}}
        {{--<span>渠道管理</span>--}}
    {{--</a>--}}
    {{--<ul class="submenu" >--}}
        {{--<li>--}}
            {{--<a href="{{ url('/backend/claim/get_claim/all') }}">--}}
                {{--理赔管理--}}
            {{--</a>--}}
        {{--</li>--}}
        {{--<li class = {{ $maintenance_active }}>--}}
            {{--<a href="{{url('/backend/maintenance/change_data/user')}}">--}}
            {{--保全管理--}}
            {{--</a>--}}
            {{--<ul class="submenu">--}}
                {{--<li style="list-style-type: none">--}}
                    {{--<a href="{{url('/backend/maintenance/change_data/user')}}">--}}
                        {{--个险变更--}}
                    {{--</a>--}}
                {{--</li>--}}
                {{--<li style="list-style-type: none">--}}
                {{--<a href="{{url('/backend/maintenance/change_data/user')}}">--}}
                {{--投保人信息变更--}}
                {{--</a>--}}
                {{--</li>--}}
                {{--<li style="list-style-type: none">--}}
                {{--<a href="{{url('/backend/maintenance/change_premium')}}">--}}
                {{--保额变更--}}
                {{--</a>--}}
                {{--</li>--}}
                {{--<li style="list-style-type: none">--}}
                    {{--<a href="{{url('/backend/maintenance/change_person')}}">--}}
                        {{--团险变更--}}
                    {{--</a>--}}
                {{--</li>--}}
            {{--</ul>--}}
        {{--</li>--}}
        {{--<li class = {{ $cancel_child_active }}>--}}
            {{--<a href="{{ url('/backend/cancel/hesitation') }}">--}}
                {{--退保管理--}}
            {{--</a>--}}
        {{--</li>--}}
        {{--<li class="{{ $order_child_active }}">--}}
            {{--<a href="{{url('/backend/order/get_order/all')}}">--}}
                {{--查看订单--}}
            {{--</a>--}}
        {{--</li>--}}
        {{--<li>--}}
            {{--<a href="{{url('/backend/warranty/get_warranty/all')}}">--}}
                {{--查看保单--}}
            {{--</a>--}}
        {{--</li>--}}
        {{--<li>--}}
        {{--<a href="#" class="dropdown-toggle">--}}
        {{--保单管理--}}
        {{--<i class="fa fa-chevron-circle-right drop-icon"></i>--}}
        {{--</a>--}}
        {{--<ul class="submenu">--}}
        {{--<li style="list-style-type: none">--}}

        {{--</li>--}}
        {{--<li>--}}
        {{--<a href="{{ url('/backend/warranty/add_warranty/personal') }}">--}}
        {{--线下保单录入--}}
        {{--</a>--}}
        {{--</li>--}}
        {{--</ul>--}}
        {{--</li>--}}
    {{--</ul>--}}
{{--</li>--}}






<?php
$c = preg_match("/\/status\//",Request::getPathinfo());
$b = preg_match("/\/demand\//",Request::getPathinfo());
$e = preg_match("/\/flow\//",Request::getPathinfo());
$f = preg_match("/\/authentication\//",Request::getPathinfo());
if($b||$c||$e||$f){
    $business_active = 'active open';
}else{
    $business_active = '';
}
$demand_active = preg_match("/\/demand\//",Request::getPathinfo())?'active open':'';
$authentication_active = preg_match("/\/authentication\//",Request::getPathinfo())?'active open':'';
$flow_active = preg_match("/\/flow\//",Request::getPathinfo())?'active open':'';
?>
{{--<li class="{{ $business_active }}">--}}
    {{--<a href="#" class="dropdown-toggle">--}}
        {{--<i class="iconfont icon-process"></i>--}}
        {{--<span>运营管理</span>--}}
    {{--</a>--}}
    {{--<ul class="submenu">--}}
        {{--<li class="{{$flow_active}}">--}}
            {{--<a href="{{url('/backend/flow/index')}}">--}}
                {{--工作流管理--}}
            {{--</a>--}}
        {{--</li>--}}
        {{--<li>--}}
            {{--<a href="/backend/status/index">--}}
                {{--状态管理--}}
            {{--</a>--}}
        {{--</li>--}}
        {{--<li class="{{$demand_active}}">--}}
            {{--<a href="#" class="dropdown-toggle">--}}
                {{--需求管理--}}
                {{--<i class="fa fa-chevron-circle-right drop-icon"></i>--}}
            {{--</a>--}}
            {{--<ul class="submenu">--}}
                {{--<li>--}}
                    {{--<a href="{{url('backend/demand/index/user')}}">--}}
                        {{--待响应需求--}}
                    {{--</a>--}}
                {{--</li>--}}
                {{--<li>--}}
                    {{--<a href="{{asset('backend/demand/deal/user')}}">--}}
                        {{--已处理需求--}}
                    {{--</a>--}}
                {{--</li>--}}
                {{--<li>--}}
                {{--<a href="{{asset('backend/sell/ditch_agent/ditch_bind_agent')}}">--}}
                {{--已转化保单--}}
                {{--</a>--}}
                {{--</li>--}}
            {{--</ul>--}}
        {{--</li>--}}
        {{--<li class="{{$authentication_active}}">--}}
            {{--<a href="{{url('backend/authentication/index/untreated')}}">--}}
                {{--实名认证--}}
            {{--</a>--}}
            {{--<ul class="submenu">--}}
                {{--<li>--}}
                    {{--<a href="{{asset('backend/authentication/index/all')}}">--}}
                        {{--全部--}}
                    {{--</a>--}}

            {{--</ul>--}}
        {{--</li>--}}
    {{--</ul>--}}
{{--</li>--}}

<?php
$agent_active = preg_match("/\/relation\//",Request::getPathinfo()) ? "active open" : "";
?>
{{--<li class="{{ $agent_active }}">--}}
    {{--<a href="#" class="dropdown-toggle">--}}
        {{--<i class="iconfont icon-service"></i>--}}
        {{--<span>客户管理</span>--}}
    {{--</a>--}}
    {{--<ul class="submenu">--}}
        {{--<li>--}}
            {{--<a href="/backend/relation/cust/all">--}}
                {{--客户池--}}
            {{--</a>--}}
        {{--</li>--}}
        {{--<li>--}}
            {{--<a href="{{asset('/backend/relation/cust/un_distribution')}}">--}}
                {{--未分配客户--}}
            {{--</a>--}}
        {{--</li>--}}
        {{--<li>--}}
            {{--<a href="{{asset('/backend/relation/cust/distribution')}}">--}}
                {{--已分配客户--}}
            {{--</a>--}}
        {{--</li>--}}
        {{--<li>--}}
            {{--<a href="/backend/relation/get_apply">--}}
                {{--申请列表--}}
            {{--</a>--}}
        {{--</li>--}}
    {{--</ul>--}}
{{--</li>--}}


<?php
$special_active = preg_match("/\/special\//",Request::getPathinfo()) ? "active open" : "";
?>
{{--<li class="{{$special_active}}">--}}
    {{--<a href="/backend/special/addspecial">--}}
        {{--<i class="iconfont icon-imagetext"></i>--}}
        {{--<span>工单管理</span>--}}
    {{--</a>--}}
{{--</li>--}}

<?php
$active = preg_match("/\/sales\//",Request::getPathinfo()) ? "active open" : "";
$business_active = preg_match("/\/commision\//",Request::getPathinfo());
//$task_active = preg_match("/\/task\//",Request::getPathinfo());
if($active||$business_active){
    $sale_active = 'active open';
}else{
    $sale_active = '';
}
?>
<li class="{{$sale_active}}">
    <a href="#" class="dropdown-toggle">
        <i class="iconfont icon-bussinessman"></i>
        <span>绩效管理</span>
    </a>
    <ul class="submenu">
        {{--<li class="{{ $business_active }}">--}}
            {{--<a href="/backend/business/competition">--}}
                {{--竞赛方案管理--}}
            {{--</a>--}}
        {{--</li>--}}
        <li>
            <a href="{{ route('backend.task.index') }}">
                任务管理
            </a>
        </li>
        <li>
            <a href="{{ url('/backend/sales/show') }}">
                销售统计
            </a>
        </li>
        <li>
            <a href="{{ url('/backend/sales/policy') }}">
                保单查看
            </a>
        </li>
        <li>
            <a href="{{ url('/backend/commision/index/2') }}">
                佣金统计管理
            </a>
        </li>
        <li>
            {{--<a href="{{asset('backend/sell/ditch_agent/ditches')}}">--}}
                {{--代理人渠道管理--}}
            {{--</a>--}}
            {{--<a href="#" class="dropdown-toggle">--}}
                {{--代理人渠道管理--}}
            {{--</a>--}}
            <a href="#" class="dropdown-toggle">
                <span>
                    <a href="{{asset('backend/sell/ditch_agent/ditches')}}">
                        代理人渠道管理
                    </a>
                </span>
            </a>
            {{--<ul class="submenu">--}}
                {{--<li>--}}
                    {{--<a href="{{asset('backend/sell/ditch_agent/ditches')}}">--}}
                        {{--渠道管理--}}
                    {{--</a>--}}
                {{--</li>--}}
                {{--<li>--}}
                    {{--<a href="{{asset('backend/sell/ditch_agent/agents')}}">--}}
                        {{--代理人管理--}}
                    {{--</a>--}}
                {{--</li>--}}
                {{--<li>--}}
                    {{--<a href="{{asset('backend/sell/ditch_agent/ditch_bind_agent')}}">--}}
                        {{--渠道代理人关联--}}
                    {{--</a>--}}
                {{--</li>--}}
                {{--<li>--}}
                    {{--<a href="{{ asset('backend/sell/ditch_agent/brokerage') }}">--}}
                        {{--佣金设置--}}
                    {{--</a>--}}
                {{--</li>--}}
            {{--</ul>--}}
        </li>
    </ul>
</li>
<?php
$invoice_active = preg_match("/\/invoice\//",Request::getPathinfo()) ? "active open" : "";
?>

{{--<li class="{{$invoice_active}}">--}}
    {{--<a href="#" class="dropdown-toggle">--}}
        {{--<i class="iconfont icon-survey"></i>--}}
        {{--<span>业务统计</span>--}}
    {{--</a>--}}
    {{--<ul class="submenu">--}}
        {{--<li>--}}
            {{--<a href='/backend/invoice/index'>--}}
                {{--发票列表--}}
            {{--</a>--}}
        {{--</li>--}}
    {{--</ul>--}}
{{--</li>--}}
<?php
$channel_active = preg_match("/\/channel_management\//",Request::getPathinfo()) ? "active open" : "";
?>

{{--<li class="{{$channel_active}}">--}}
{{--<a href="/backend/channel/addchannel" >--}}
{{--<i class="fa fa-desktop"></i>--}}
{{--<span>渠道管理</span>--}}
{{--</a>--}}
{{--<ul class="submenu">--}}
{{--<li>--}}
{{--<a href="/backend/channel/addchannel">--}}
{{--合作渠道管理--}}
{{--</a>--}}
{{--</li>--}}

{{--</ul>--}}
{{--</li>--}}


<?php
$sms_active = preg_match("/\/sms\//",Request::getPathinfo()) ? "active open" : "";
?>

<li class="{{$sms_active}}">
    <a href="#" class="dropdown-toggle">
        <i class="iconfont icon-comments"></i>
        <span>消息管理</span>
    </a>
    <ul class="submenu">
        {{--<li>--}}
            {{--<a href='/backend/sms/email'>--}}
                {{--邮件管理--}}
            {{--</a>--}}
        {{--</li>--}}
        {{--<li>--}}
            {{--<a href='/backend/sms/sms'>--}}
                {{--短信管理--}}
            {{--</a>--}}
        {{--</li>--}}
        {{--<li>--}}
            {{--<a href="/backend/sms/dopay">--}}
                {{--短信订单--}}
            {{--</a>--}}
        {{--</li>--}}
        {{--<li>--}}
            {{--<a href='/backend/sms/onlineservice'>--}}
                {{--在线客服--}}
            {{--</a>--}}
        {{--</li>--}}
        <li>
            <a href="/backend/sms/message">
                站内信管理
            </a>
        </li>
    </ul>
</li>
<?php
    $user_management = preg_match("/\/user_management\//",Request::getPathinfo()) ? "active open" : "";
?>
<li class="{{$user_management}}">
    <a href="/backend/user_management/user_list" >
        <i class="iconfont icon-yonghuguanli-copy"></i>
        <span>用户管理</span>
    </a>
</li>

