<link rel="stylesheet" href="{{config('view_url.agent_url')}}css/lib/iconfont.css" />
<link rel="stylesheet" href="{{config('view_url.agent_url')}}css/common_agent.css" />
<ul class="menu-wrapper fl">
    <li @if($option == 'plan') class="active"@endif><a href="/agent_sale/add_plan">我的计划书</a></li>
    <li @if($option == 'cust') class="active"@endif><a href="/agent_sale/agent_cust/unpayed">我的客户</a></li>
    <li @if($option == 'product') class="active"@endif><a href="/agent_sale/agent_product">我的产品</a></li>
    <li @if($option == 'commission') class="active"@endif><a href="/agent_sale/agent_commission">我的业绩</a></li>
    <li @if($option == 'need') class="active"@endif><a href="/agent_sale/agent_need">我的需求</a></li>
</ul>