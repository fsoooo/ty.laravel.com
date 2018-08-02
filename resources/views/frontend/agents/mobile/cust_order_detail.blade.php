<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>天眼互联-科技让保险无限可能</title>
    <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
    <link rel="stylesheet" href="{{config('view_url.view_url')}}mobile/personal/css/lib/mui.min.css">
    <link rel="stylesheet" href="{{config('view_url.view_url')}}mobile/personal/css/lib/iconfont.css" />
    <link rel="stylesheet" href="{{config('view_url.view_url')}}mobile/personal/css/common.css" />
    <link rel="stylesheet" href="{{config('view_url.view_url')}}mobile/personal/css/information.css" />
    <style>
        .list-wrapper{color: #313131;}
        .information-header .list-wrapper{color: #adadad;}
        .name{display: inline-block;width: 1.72rem;color: #adadad;}
        .buttonbox{font-size: 0;}
        .buttonbox .btn{width: 33.333%;height: .98rem;line-height: .98rem;font-size: .36rem;}
        .buttonbox .btn-primary{background: #00a2ff;}
        .buttonbox .btn-positive{background: #ffae00;}
    </style>
</head>

<body>
<div class="main">
    <header class="mui-bar mui-bar-nav">
        <a class="mui-icon mui-icon-back mui-pull-left mui-action-back"></a>
        <h1 class="mui-title">保单详情</h1>
    </header>
    <div class="mui-content">
        <div class="mui-scroll-wrapper">
            <div class="mui-scroll">
                <div class="information-wrapper">
                    <div class="information-header">
                        <div class="information-name">{{$data->product['product_name']}}</div>
                        <ul class="list-wrapper">
                            <li>保单号：{{$data->warranty_rule->warranty?$data->warranty_rule->warranty['warranty_code']:'--'}}</li>
                        </ul>
                    </div>
                    <div class="division"></div>
                    <div>
                        <div class="title">保单信息</div>
                        @if(isset($data->warranty_rule->warranty))
                        <ul class="list-wrapper">
                            <li><span class="name">保障时间:</span>{{strtok($data->warranty_rule->warranty['start_time'],' ')}}至{{strtok($data->warranty_rule->warranty['end_time'],' ')}}</li>
                            <li><span class="name">保费:</span>{{$data->warranty_rule->warranty['premium']/100}}元</li>
                            <li><span class="name">缴费频次：</span>
                                @if(preg_replace('/\D/s','',$data['by_stages_way']) == 0)
                                    趸交
                                    @else
                                {{$data['by_stages_way']}}
                                    @endif
                            </li>
                            <li><span class="name">保单形式：</span>电子保单</li>
                        </ul>
                        @else
                        <ul class="list-wrapper">
                            <li><span class="name">
                                    @if(isset($data->warranty_rule->warranty))
                                        已出单
                                        @else
                                        未出单
                                    @endif
                                </span></li>
                        </ul>
                            @endif
                    </div>
                    <div class="division"></div>
                    <div>
                        <div class="title">投保人信息</div>
                        @if(isset($data->warranty_rule->policy))
                        <ul class="list-wrapper">
                            <li><span class="name">姓名: </span>{{$data->warranty_rule->policy['name']}}</li>
                            <li><span class="name">证件类型:</span>身份证</li>
                            <li><span class="name">证件号： </span>{{$data->warranty_rule->policy['code']}}</li>
                            <li><span class="name">出生日期：</span>{{substr($data->warranty_rule->policy['code'],6,4)}}年{{substr($data->warranty_rule->policy['code'],10,2)}}月{{substr($data->warranty_rule->policy['code'],12,2)}}日</li>
                            <li><span class="name">性别：</span>
                                @if(substr($data->warranty_rule->policy['code'],16,1)%2 == 1)
                                    男
                                    @else
                                女
                                    @endif
                            </li>
                            <li><span class="name">手机号码：</span>{{$data->warranty_rule->policy['phone']}}</li>
                            <li><span class="name">电子邮件：</span>{{$data->warranty_rule->policy['email']}}</li>
                        </ul>
                            @else
                            <ul class="list-wrapper">
                                <li><span class="name">未有投保人信息</span></li>
                            </ul>
                            @endif
                    </div>
                    <div class="division"></div>
                    <div>
                        <div class="title">被保人信息</div>
                        @if(isset($data->warranty_recognizee))
                        <ul class="list-wrapper">
                            <li><span class="name">姓名: </span>{{$data->warranty_recognizee[0]['name']}}</li>
                            <li><span class="name">证件类型:</span>身份证</li>
                            <li><span class="name">证件号：</span>{{$data->warranty_recognizee[0]['code']}}</li>
                            <li><span class="name">出生日期：</span>{{substr($data->warranty_recognizee[0]['code'],6,4)}}年{{substr($data->warranty_recognizee[0]['code'],10,2)}}月{{substr($data->warranty_recognizee[0]['code'],12,2)}}日</li>
                            <li><span class="name">性别：</span>
                                @if(substr($data->warranty_recognizee[0]['code'],16,1)%2 == 1)
                                    男
                                @else
                                    女
                                @endif
                            </li>
                            <li><span class="name">职业：</span>一般职业-机关团体单位-机关内勤</li>
                            <li><span class="name">手机号码：</span>{{$data->warranty_recognizee[0]['phone']}}</li>
                            <li><span class="name">受益人类型：</span>法定受益人</li>
                        </ul>
                            @else
                            <ul class="list-wrapper">
                                <li><span class="name">未有被保人信息</span></li>
                            </ul>
                            @endif
                    </div>
                    <div class="division"></div>
                    <div>
                        <div class="title">保障权益</div>
                        <ul class="list-wrapper">
                            @if(isset($data->clauses))
                                @foreach($data->clauses['option']['protect_items'] as $v)
                            <li><span class="name" >{{$v['name']}}：</span>{{$v['defaultValue']}}   </li>
                                @endforeach
                                @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        {{--<div class="buttonbox">--}}
            {{--<button class="btn btn-positive">申请退保</button>--}}
            {{--<button class="btn btn-primary">发起理赔</button>--}}
            {{--<button class="btn btn-positive">变更信息</button>--}}
        {{--</div>--}}
    </div>
</div>

<script src="{{config('view_url.view_url')}}mobile/personal/js/lib/jquery-1.11.3.min.js"></script>
<script src="{{config('view_url.view_url')}}mobile/personal/js/lib/mui.min.js"></script>
<script src="{{config('view_url.view_url')}}mobile/personal/js/common.js"></script>
</body>

</html>