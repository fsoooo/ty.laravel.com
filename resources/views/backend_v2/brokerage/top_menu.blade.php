<?php
$agent_on = preg_match("/agent_brokerage/",Request::getRequestUri()) ? "active" : '';
?>
@if(Auth::guard('admin')->user()->email==config('manager_account.manager'))
<div class="nav-top-wrapper fl">
    <ul>
        <li class="{{ $agent_on ? '' :  'active'}}">
            <a href="{{asset("/backend/set_brokerage/list")}}">渠道佣金</a>
        </li>
        <li class="{{$agent_on}}">
            <a href="{{asset("/backend/set_brokerage/agent_brokerage")}}">代理人佣金</a>
        </li>
    </ul>
</div>
@endif