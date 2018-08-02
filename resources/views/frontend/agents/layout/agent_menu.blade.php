<li>
    <a href="/agent/">
        <i class="fa fa-desktop"></i>
        <span>主页</span>
    </a>
</li>
<?php
$cust_active = preg_match("/\/agent\//",Request::getPathinfo()) ? "active open" : "";
?>
<li class="{{$cust_active}}">
    <a href="#" class="dropdown-toggle">
        <i class="fa fa-desktop"></i>
        <span>客户管理</span>
        <i class="fa fa-chevron-circle-right drop-icon"></i>
    </a>
    <ul class="submenu">
        <li>
            <a href="{{url('/agent/my_cust/all')}}">
                我的客户
            </a>
        </li>
        <li>
            <a href="{{url('/agent/add/person')}}">
                添加客户
            </a>
        </li>
        <li>
            <a href="{{url('/agent/apply/person')}}">
                申请客户
            </a>
        </li>
        <li>
            <a href="{{url('/agent/apply/record/all')}}">
                申请记录
            </a>
        </li>
        <li>
            <a href="{{url('/agent/index/all')}}">
                代理的客户
            </a>
        </li>
    </ul>
</li>
<?php
$sale_active = preg_match("/\/agent_sale\//",Request::getPathinfo()) ? "active open" : "";
?>
<li class="{{ $sale_active }}">
    <a href="#" class="dropdown-toggle">
        <i class="fa fa-desktop"></i>
        <span>销售管理</span>
        <i class="fa fa-chevron-circle-right drop-icon"></i>
    </a>
    <ul class="submenu">
        <li>
            <a href="{{url('agent_sale/product_list')}}">
                产品列表
            </a>
        </li>
        <li>
            <a href="{{url('agent_sale/plan')}}">
                计划书管理
            </a>
        </li>
    </ul>
</li>
<?php
$agent_brokerage = preg_match("/\/agent_brokerage\//",Request::getPathinfo()) ? "active open" : "";
?>
<li class="{{$agent_brokerage}}">
    <a href="#" class="dropdown-toggle">
        <i class="fa fa-desktop"></i>
        <span>佣金管理</span>
        <i class="fa fa-chevron-circle-right drop-icon"></i>
    </a>
    <ul class="submenu">
        <li>
            <a href="{{url('/agent_brokerage/brokerage_statistics')}}">
                账户详情
            </a>
        </li>
        <li>
            <a href="{{url('agent_brokerage/rate')}}">
                佣金比率查询
            </a>
        </li>
    </ul>
</li>


<?php
$task = preg_match("/\/agent_task\//",Request::getPathinfo()) ? "active open" : "";
?>
<li class="{{ $task }}">
    <a href="#" class="dropdown-toggle">
        <i class="fa fa-desktop"></i>
        <span>订单及任务管理</span>
        <i class="fa fa-chevron-circle-right drop-icon"></i>
    </a>
    <ul class="submenu">
        <li>
            <a href="{{url('agent_task/index/month')}}">
                已完成订单列表
            </a>
        </li>
        <li>
            <a href="{{url('agent_task/add_order')}}">
                线下订单录入
            </a>
        </li>
        <li>
            <a href="{{url('agent_task/add_warranty')}}">
                线下保单录入
            </a>
        </li>
        <li>
            <a href="{{url('/agent_task/progress/month')}}">
                任务进度查询
            </a>
        </li>
    </ul>
</li>