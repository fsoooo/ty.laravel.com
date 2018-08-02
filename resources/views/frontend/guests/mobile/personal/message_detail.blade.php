<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>天眼互联-科技让保险无限可能</title>
    <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
    <link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/lib/mui.min.css">
    <link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/lib/mui.picker.all.css">
    <link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/lib/iconfont.css" />
    <link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/common_agent.css" />
    <link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/make.css" />
    <style type="text/css">
        .mui-content .mui-scroll-wrapper {
            top: .9rem;
            bottom: 0rem;
        }
        /*时间div的样式*/
        .main .mui-content .lineinfo{
            position: relative;
            height: 0.48rem;
            background: #f4f4f4;
            text-align: center;
            line-height: 0.48rem;
            font-size: 0.24rem;
        }
        .main .mui-content .lineinfo i{
            color: #e4e4e4;
        }
        /*内容div的样式*/
        .main .mui-content .contentinfo{
            height: 1.76rem;
            background: #fff;
            padding:.28rem ;
            position: relative;
        }
        .main .mui-content .contentinfo>span:nth-child(1){
            font-size: .28rem;
            color: #313131;
        }
        .main .mui-content .contentinfo .content-s{
            margin-top: .28rem;
            font-size: .24rem;
            color: #959595;
        }
        .main .mui-content .contentinfo .content-s i{
            display: inline-block;
            font-size: .3rem;
            margin-top: -.2rem;
        }

    </style>
</head>

<body>
<div class="main">
    <header id="header" class="mui-bar mui-bar-nav">
        <a class="iconfont icon-fanhui mui-pull-left mui-action-back"></a>
        <h1 class="mui-title">消息详情</h1>
    </header>
    <div class="mui-content scene">
        <div class="mui-scroll-wrapper">
            <div class="mui-scroll">
                <!--时间的div-->
                <div class="lineinfo">
                    <i class="iconfont icon-weidu"></i>
                    <span>{{$data['created_at']}}</span>
                    <div class="mask"></div>
                </div>
                <!--内容的div-->
                <div class="contentinfo">
                    <span>
                        @if($data['send_id'] == 0)
                            业管
                            @else
                        其他
                            @endif
                    </span>
                    <div class="content-s">
                        <span>
                            {{$data->comments[0]['content']}}
                        </span>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>

<script src="{{config('view_url.agent_mob')}}js/lib/jquery-1.11.3.min.js"></script>
<script src="{{config('view_url.agent_mob')}}js/lib/mui.min.js"></script>
<script src="{{config('view_url.agent_mob')}}js/lib/mui.picker.all.js"></script>
<script src="{{config('view_url.agent_mob')}}js/common_agent.js"></script>

</body>

</html>