<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>账户设置</title>
    <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
    <link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/lib/mui.min.css">
    <link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/lib/iconfont.css" />
    <link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/common_agent.css" />
    <link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/account.css" />
</head>
<body id="invite">
<div class="main">
    <header id="header" class="mui-bar mui-bar-nav"  style="background: none;">
        <a class="iconfont icon-fanhui mui-pull-left mui-action-back"></a>
        <h1 class="mui-title">账户设置</h1>
    </header>
    <div class="header-bg"></div>
    <div class="info-wrapper">

        <div class="info-header">
            <a class="btn-change" href="/agent/reset_psw">密码修改</a>
            <div class="avator">
                <img src="{{config('view_url.agent_mob')}}img/boy.png" alt="" />
            </div>
            <p>{{isset($data->user['name'])? $data->user['name'] : '--' }}<span class="label-approve">@if( isset($authentication) && $authentication == 2) 已认证 @else 未认证 @endif </span></p>
        </div>
        <div class="form-wrapper">
            <ul>
                <li>
                    <span class="name">工号</span>
                    <input type="text" value="{{isset($data['job_number'])? $data['job_number']: '--'}}" readonly />
                </li>
                <li>
                    <span class="name">渠道</span>
                    <input type="text" value="{{$ditch['name']}}" readonly />
                </li>
                <li>
                    <span class="name">手机</span>
                    <input type="text" value="{{isset($data->user['phone'])?$data->user['phone']:'--'}}" readonly />
                </li>
                <li>
                    <span class="name">邮箱</span>
                    <input type="text" value="{{isset($data->user['email'])?$data->user['email']:'--'}}" readonly/>
                </li>
                <li>
                    <span class="name">身份证</span>
                    <input type="text" value="{{isset($data->user['code'])?$data->user['code']:'--'}}" readonly/>
                </li>
            </ul>
        </div>
        <a href="/agent/account_edit" class="zbtn zbtn-positive center">信息修改</a>
    </div>
</div>
<script src="{{config('view_url.agent_mob')}}js/lib/jquery-1.11.3.min.js"></script>
<script src="{{config('view_url.agent_mob')}}js/lib/mui.min.js"></script>
<script src="{{config('view_url.agent_mob')}}js/common_agent.js"></script>
</body>
</html>
