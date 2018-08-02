<link rel="stylesheet" href="{{config('view_url.agent_url')}}css/lib/iconfont.css" />
<link rel="stylesheet" href="{{config('view_url.agent_url')}}css/common_agent.css" />
<ul class="menu-wrapper fl">
    <li @if($option == 'plan') class="active"@endif><a href="/agent/account">实名信息</a></li>
    <li @if($option == 'cust') class="active"@endif><a href="/agent/account_reset_password">密码修改</a></li>
</ul>