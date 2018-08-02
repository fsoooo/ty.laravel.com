<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>消息中心</title>
    <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
    <link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/lib/mui.min.css">
    <link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/lib/mui.picker.all.css">
    <link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/lib/iconfont.css" />
    <link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/common_agent.css" />
    <link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/make.css" />
    <style>
        .mui-content .mui-scroll-wrapper {
            top: .9rem;
            bottom: 0rem;
            background: #f4f4f4;
        }
        .form-wrapper ul li{
            padding: .2rem;
            margin-bottom: .2rem;
            background: #fff;
            text-align: left;
            line-height: .6rem;
        }
        .form-wrapper ul li i{
            font-size: .5rem;
        }
        .form-wrapper ul li .info{
            padding-left: .6rem;
        }
        .form-wrapper ul {
            padding: 0rem;
        }
        .form-wrapper li .icon-gengduo, .form-wrapper li .icon-xiugai {
            position: absolute;
            top: 10px;
            right: 10px;
            color: #d8d7d9;
        }
        .form-wrapper ul li .info .remind {
            position: absolute;
            top: 10px;
            left: 64px;
            display: inline-block;
            padding: 0 3px;
            height: 15px;
            line-height: 15px;
            font-size: 10px;
            background: #ffae00;
            border-radius: 50%;
            -moz-border-radius: 50%;
            -webkit-border-radius: 50%;
            -o-border-radius: 50%;
            color: #fff;
        }
        .form-wrapper ul li .info .remind2 {
            position: absolute;
            top: 10px;
            left: 64px;
            display: inline-block;
            padding: 0 3px;
            height: 15px;
            line-height: 15px;
            font-size: 10px;
            background: #ffae00;
            border-radius: 50%;
            -moz-border-radius: 50%;
            -webkit-border-radius: 50%;
            -o-border-radius: 50%;
            color: #fff;
        }
    </style>
</head>
<body>
<div class="main">
    <header id="header" class="mui-bar mui-bar-nav">
        <a class="iconfont icon-fanhui mui-pull-left mui-action-back"></a>
        <h1 class="mui-title">消息中心</h1>
    </header>
    <div class="mui-content">
        <div class="mui-scroll-wrapper">
            <div class="mui-scroll">
                <div class="form-wrapper form-insure">
                    <ul>
                        {{--<li class="list">--}}
                            {{--<div>--}}
                                {{--<i class="iconfont icon-wenjian1"></i>--}}
                                {{--<span class="info"><i class="remind">2</i>系统消息</span>--}}
                                {{--<i class="iconfont icon-gengduo"></i>--}}
                            {{--</div>--}}
                        {{--</li>--}}
                        {{--<li class="list">--}}
                            {{--<div>--}}
                                {{--<i class="iconfont icon-xinxi1"></i>--}}
                                {{--<span class="info">站内信</span>--}}
                                {{--<i class="iconfont icon-gengduo"></i>--}}
                            {{--</div>--}}
                        {{--</li>--}}
                        <li class="list">
                            <div>
                                <i class="iconfont icon-xin"></i>
                                <span class="info"><i class="remind2">{{$count}}</i>通知</span>
                                <i class="iconfont icon-gengduo"></i>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{config('view_url.agent_mob')}}js/lib/jquery-1.11.3.min.js"></script>
<script src="{{config('view_url.agent_mob')}}js/lib/mui.min.js"></script>
<script src="{{config('view_url.agent_mob')}}js/lib/mui.picker.all.js"></script>
<script src="{{config('view_url.agent_mob')}}js/common_agent.js"></script>
<script type="text/javascript">
    $('.list').click(function(){
        location.href='/agent_sale/agent_info';
    });
</script>
</body>
</html>
