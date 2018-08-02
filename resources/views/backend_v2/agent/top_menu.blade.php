<?php
$work_on = preg_match("/work_status=1/",Request::getRequestUri()) ? "active" : '';
$work_off = preg_match("/work_status=0/",Request::getRequestUri()) ? "active" : '';
$pending_on = preg_match("/pending_status=0/",Request::getRequestUri()) ? "active" : '';
$pending_off = preg_match("/pending_status=1/",Request::getRequestUri()) ? "active" : '';

?>
<div class="nav-top-wrapper fl">
    <ul>
        <li class="{{$work_on}}">
            <a href="{{url('backend/agent/list?work_status=1')}}">在职</a>
        </li>
        <li class="{{$work_off}}">
            <a href="{{url('backend/agent/list?work_status=0')}}">离职</a>
        </li>
        <li class="{{$pending_on}}">
            <a href="{{url('backend/agent/list?pending_status=0')}}">待审核</a>
        </li>
        <li class="{{$pending_off}}">
            <a href="{{url('backend/agent/list?pending_status=1')}}">已通过</a>
        </li>
    </ul>
</div>

