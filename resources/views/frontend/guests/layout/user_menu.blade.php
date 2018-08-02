<li>
    <a href="/information/" >
        <i class="fa fa-desktop"></i>
        <span>主页</span>
    </a>
</li>

<?php
$active = preg_match("/\/information\//",Request::getPathinfo()) ? "active open" : "";
?>
<li class="{{ $active }}}}">
    <a href="#" class="dropdown-toggle">
        <i class="fa fa-desktop"></i>
        <span>账户管理</span>
        <i class="fa fa-chevron-circle-right drop-icon"></i>
    </a>
    <ul class="submenu">
        <li>
            <a href="{{url('/information/index')}}">
                个人信息
            </a>
        </li>
        <li>
            <a href="{{url('/information/approvePerson')}}">
                实名认证
            </a>
        </li>
        <li>
            <a href="{{url('/information/change_password')}}">
                修改密码
            </a>
        </li>
        {{--<li>--}}
            {{--<a href="{{ url('/information/profile') }}">--}}
                {{--完善个人信息--}}
            {{--</a>--}}
        {{--</li>--}}
        @if(isset($_COOKIE['user_type']))
        <li>
            <a href="{{url('/information/channels_index')}}">
                多渠道用户管理
            </a>
        </li>
        @endif
    </ul>
</li>

<?php
$message_active = preg_match("/\/message\//",Request::getPathinfo()) ? "active open" : "";
?>
    {{--<li class="{{$message_active}}">--}}
        {{--<a href="#" class="dropdown-toggle">--}}
            {{--<i class="fa fa-desktop"></i>--}}
            {{--<span>消息管理</span>--}}
            {{--<i class="fa fa-chevron-circle-right drop-icon"></i>--}}
        {{--</a>--}}
        {{--<ul class="submenu">--}}
            {{--<li>--}}
                {{--<a href="{{url('message/get_unread')}}">--}}
                    {{--站内信管理--}}
                {{--</a>--}}
            {{--</li>--}}
        {{--</ul>--}}
    {{--</li>--}}

<?php
$warranty_active = preg_match("/\/order\//",Request::getPathinfo()) ? "active open" : "";
?>
<li class="{{$warranty_active}}">
    <a href="#" class="dropdown-toggle">
        <i class="fa fa-desktop"></i>
        <span>订单管理</span>
        <i class="fa fa-chevron-circle-right drop-icon"></i>
    </a>
    <ul class="submenu">
        <li>
            <a href="{{url('/order/index/all')}}">
                全部
            </a>
        </li>
        <li>
            <a href="{{url('/order/index/unpayed')}}">
                待支付
            </a>
        </li>
        <li>
            <a href="{{url('/order/index/payed')}}">
                已支付
            </a>
        </li>
        <li>
            <a href="{{url('/order/index/insuring')}}">
                保障中
            </a>
        </li>
        {{--<li>--}}
            {{--<a href="{{url('/order/index/feedback')}}">--}}
                {{--待评价--}}
            {{--</a>--}}
        {{--</li>--}}
        <li>
            <a href="{{url('/order/index/renewal')}}">
                待续保
            </a>
        </li>
    </ul>
</li>

<?php
$active1 = preg_match("/\/maintenance\//",Request::getPathinfo());
$active2 = preg_match("/\/claim\//",Request::getPathinfo());
if($active1||$active2){
    $after_active = 'active open';
}else{
    $after_active = '';
}
?>
{{--<li class="{{$after_active}}">--}}
    {{--<a href="#" class="dropdown-toggle">--}}
        {{--<i class="fa fa-desktop"></i>--}}
        {{--<span>售后管理</span>--}}
        {{--<i class="fa fa-chevron-circle-right drop-icon"></i>--}}
    {{--</a>--}}
    {{--<ul class="submenu">--}}
        {{--<li style="list-style-type: none">--}}
            {{--<a href="{{url('/maintenance/change_data')}}">--}}
                {{--保全--}}
            {{--</a>--}}
        {{--</li>--}}
        {{--<li style="list-style-type: none">--}}
            {{--<a href="{{url('/claim/get_claim')}}">--}}
                {{--理赔--}}
            {{--</a>--}}
        {{--</li>--}}
        {{--<li style="list-style-type: none">--}}
            {{--<a href="{{url('/maintenance/cancel')}}">--}}
                {{--退保--}}
            {{--</a>--}}
        {{--</li>--}}
    {{--</ul>--}}
{{--</li>--}}


<?php
$active = preg_match("/\/liability_demand\//",Request::getPathinfo()) ? "active open" : "";
?>
{{--<li class="{{$active}}">--}}
    {{--<a href="#" class="dropdown-toggle">--}}
        {{--<i class="fa fa-desktop"></i>--}}
        {{--<span>需求管理</span>--}}
        {{--<i class="fa fa-chevron-circle-right drop-icon"></i>--}}
    {{--</a>--}}
    {{--<ul class="submenu">--}}
        {{--<li>--}}
            {{--<a href="{{url('liability_demand/index')}}">--}}
                {{--发起需求--}}
            {{--</a>--}}
        {{--</li>--}}
        {{--<li>--}}
            {{--<a href="{{url('liability_demand/my_demand/all')}}">--}}
                {{--查看反馈--}}
            {{--</a>--}}
        {{--</li>--}}
    {{--</ul>--}}
{{--</li>--}}
<li class="">
    <a href="#" class="dropdown-toggle">
        <i class="fa fa-desktop"></i>
        <span>保单管理</span>
        <i class="fa fa-chevron-circle-right drop-icon"></i>
    </a>
    <ul class="submenu">
        <li>
            <a href="{{url('liability_demand/index')}}">
                保单管理
            </a>
        </li>
    </ul>
</li>
