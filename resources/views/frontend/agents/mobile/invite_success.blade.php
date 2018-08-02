<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>信息填写</title>
    <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
    <link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/lib/mui.min.css">
    <link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/lib/iconfont.css" />
    <link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/common_agent.css" />
    <link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/success.css" />
</head>
<body>
<div class="main">
    <header id="header" class="mui-bar mui-bar-nav">
        <a class="iconfont icon-fanhui mui-pull-left mui-action-back"></a>
        <h1 class="mui-title">信息填写</h1>
    </header>
    <div class="mui-content">
        <div class="tips-wrapper">
            <i class="iconfont icon-chenggong"></i>
            <p class="tips">发送成功</p>
        </div>
        <div>
            <a class="zbtn zbtn-default" href="/agent_sale/add_plan">制作计划书</a>
            <a class="return" href="/agent_sale/cust_lists">返回客户列表</a>
        </div>
    </div>
</div>
<div class="button-box">
    <a href="/agent_sale/agent_invite" id="send" class="zbtn zbtn-default">继续邀请客户</a>
</div>
<script src="{{config('view_url.agent_mob')}}js/lib/jquery-1.11.3.min.js"></script>
<script src="{{config('view_url.agent_mob')}}js/lib/mui.min.js"></script>
<script src="{{config('view_url.agent_mob')}}js/common_agent.js"></script>
</body>
</html>
