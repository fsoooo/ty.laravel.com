<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>记录沟通</title>
    <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
    <link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/lib/mui.min.css">
    <link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/lib/iconfont.css" />
    <link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/common_agent.css" />
    <link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/client.css" />
    <link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/demand-succeed.css" />
    <style>
        .mui-popover{top: initial;left: 0;}
        .block {
            width: 100%;
            padding-top: 5px;

        }
        .icons{
            display: block;
            width: 2rem;
            height: 2rem;
            margin: 0 auto;
            text-align: center;
            margin-top: 1.8rem;
            line-height: 2rem;
        }
        .icons i{
            color: #FFAE00;
            font-size: 2rem;
        }
        .icons1{
            text-align: center;
            font-size: .32rem;
            color: #bdbdbd;
            padding-top: .25rem;
        }
        .icons2{
            text-align: center;
            font-size: .25rem;
            color: #bdbdbd;
            padding-top: 1rem;
        }
        .icons2 button{
            background: #00A2FF;
            color: #fff;
            display: block;
            margin: 0 auto;
            padding: .3rem;
            font-size: .25rem;

        }
        .icons2 span{
            color: #00A2FF;
            display: block;
            margin-top: .2rem;
        }
    </style>
</head>

<body>
<header id="header" class="mui-bar mui-bar-nav">
    <a class="iconfont icon-fanhui mui-pull-left mui-action-back"></a>
    <h1 class="mui-title">我的需求</h1>
</header>
<div id="record">

    <div class="outer">
        <div class="mui-control-content mui-active">
            <div  class="mui-scroll-wrapper">
                <div class="mui-scroll">
                    <div class="icons">
                        <i class="iconfont icon-shenqingchenggong"></i>
                    </div>
                    <div class="icons1">
                        <span>发送成功</span>
                    </div>
                    <div class="icons2">
                        <button class="continue">继续发起工单</button>
                        <span class="lookorder">查看工单</span>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{config('view_url.agent_mob')}}js/lib/jquery-1.11.3.min.js"></script>
<script src="{{config('view_url.agent_mob')}}js/lib/mui.min.js"></script>
<script src="{{config('view_url.agent_mob')}}js/lib/startScore.js"></script>
<script src="{{config('view_url.agent_mob')}}js/common_agent.js"></script>
<script type="text/javascript">
    //继续发起工单的链接跳转
    $('.continue').click(function(){
        location.href='/agent_sale/demand';
    });
    //查看工单的链接跳转
    $('.lookorder').click(function(){
        location.href='/agent_sale/workorder';
    });
</script>
</body>
</html>