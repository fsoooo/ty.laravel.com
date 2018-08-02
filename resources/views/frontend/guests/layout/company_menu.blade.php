<?php
	$information = preg_match("/\/information\//",Request::getPathinfo()) ? "active open" : "";
?>
<li class="{{$information}}">
    <a href="#" class="dropdown-toggle">
        <i class="fa fa-desktop"></i>
        <span>企业信息管理</span>
        <i class="fa fa-chevron-circle-right drop-icon"></i>
    </a>
    <ul class="submenu">
        <li>
            <a href="{{url('/information/index')}}">
                公司信息
            </a>
        </li>
        <li>
            <a href="{{url('/information/change_password')}}">
                修改密码
            </a>
        </li>
        {{--<li>--}}
            {{--<a href="{{url('/information/invoice')}}">--}}
                {{--发票管理--}}
            {{--</a>--}}
        {{--</li>--}}
		<li>
			<a href="{{url('/information/authentication')}}">
				认证信息
			</a>
		</li>
    </ul>
</li>
<?php
$active = preg_match("/\/message\//",Request::getPathinfo()) ? "active open" : "";
?>
<li class="{{$active}}">
    <a href="#" class="dropdown-toggle">
        <i class="fa fa-desktop"></i>
        <span>消息管理</span>
        <i class="fa fa-chevron-circle-right drop-icon"></i>
    </a>
    <ul class="submenu">
        <li>
            <a href="{{url('message/get_unread')}}">
                站内信管理
            </a>
        </li>
    </ul>
</li>

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
        <li>
            <a href="{{url('/order/index/renewal')}}">
				待续保
            </a>
        </li>
        {{--<li>--}}
            {{--<a href="{{url('/warranty/index/user')}}">--}}
                {{----}}
            {{--</a>--}}
        {{--</li>--}}
    </ul>
</li>

<?php
$warranty_active = preg_match("/\/order\//",Request::getPathinfo()) ? "active open" : "";
?>
{{--<li class="">--}}
	{{--<a href="#" class="dropdown-toggle">--}}
		{{--<i class="fa fa-desktop"></i>--}}
		{{--<span>保单管理</span>--}}
		{{--<i class="fa fa-chevron-circle-right drop-icon"></i>--}}
	{{--</a>--}}
	{{--<ul class="submenu">--}}
		{{--<li>--}}
			{{--<a href="">--}}
				{{--全部--}}
			{{--</a>--}}
		{{--</li>--}}
		{{--<li>--}}
			{{--<a href="">--}}
				{{--待续费--}}
			{{--</a>--}}
		{{--</li>--}}
	{{--</ul>--}}
{{--</li>--}}

<?php
$slip_active = preg_match("/\/slip\//",Request::getPathinfo()) ? "active open" : "";
?>
<li class="{{$slip_active}}">
	<a href="#" class="dropdown-toggle">
		<i class="fa fa-desktop"></i>
		<span>保单管理</span>
		<i class="fa fa-chevron-circle-right drop-icon"></i>
	</a>
	<ul class="submenu">
		<li>
			<a href="/slip/index">
				保单中心
			</a>
		</li>
		<li>
			<a href="">
				删除员工
			</a>
		</li>
		<li>
			<a href="">
				申请处理
			</a>
		</li>
		<li>
			<a href="">
				人员处理记录
			</a>
		</li>
	</ul>
</li>

<?php
$warranty_active = preg_match("/\/order\//",Request::getPathinfo()) ? "active open" : "";
?>
{{--<li class="">--}}
	{{--<a href="#" class="dropdown-toggle">--}}
		{{--<i class="fa fa-desktop"></i>--}}
		{{--<span>财务管理</span>--}}
		{{--<i class="fa fa-chevron-circle-right drop-icon"></i>--}}
	{{--</a>--}}
	{{--<ul class="submenu">--}}
		{{--<li>--}}
			{{--<a href="">--}}
				{{--缴费历史--}}
			{{--</a>--}}
		{{--</li>--}}
		{{--<li>--}}
			{{--<a href="">--}}
				{{--待缴费列表--}}
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


