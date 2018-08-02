<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>天眼互联-科技让保险无限可能</title>
    <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
    <link rel="stylesheet" href="{{config('view_url.view_url')}}mobile/personal/css/lib/mui.min.css">
    <link rel="stylesheet" href="{{config('view_url.view_url')}}mobile/personal/css/information.css">
    <link rel="stylesheet" href="{{config('view_url.view_url')}}mobile/personal/css/lib/iconfont.css" />
    <link rel="stylesheet" href="{{config('view_url.view_url')}}mobile/personal/css/common.css" />
    <style>
        .list-wrapper{color: #adadad;}
        .name{display: inline-block;width: 1.72rem;color: #313131;}
        .buttonbox .btn{height: .98rem;line-height: .98rem;background: #ffae00;}
    </style>
</head>

<body>
<div class="main">
    <header class="mui-bar mui-bar-nav">
        <a class="mui-icon mui-icon-back mui-pull-left mui-action-back"></a>
        <h1 class="mui-title">投保信息</h1>
    </header>
    <div class="mui-content">
        <div class="mui-scroll-wrapper">
            <div class="mui-scroll">
                <div class="information-wrapper">
                    <div>
                        <div class="information-name">{{$data->warranty_rule->order->product->product_name}}</div>
                        <ul class="list-wrapper">
                            <li>保单号：{{$id}}</li>
                        </ul>
                    </div>
                    <div class="division"></div>
                    <div>
                        <div class="title">保单信息</div>
                        <ul class="list-wrapper">
                            <li><span class="name">保障时间:</span>{{$data->start_time}}至{{$data->end_time}}</li>
                            <li><span class="name">保费:</span>{{$data->warranty_rule->order->premium/100}}</li>
                            <li><span class="name">缴费频次：</span>趸交</li>
                            <li><span class="name">保单形式：</span>电子保单</li>
                        </ul>
                    </div>
                    <div class="division"></div>
                    <div>
                        <div class="title">投保人信息</div>
                        <ul class="list-wrapper">
                            <li><span class="name">姓名: </span>{{$data->warranty_rule->policy->name}}</li>
                            <li><span class="name">证件类型:</span>@if($data->warranty_rule->policy->card_type == 1)身份证@else其他@endif</li>
                            <li><span class="name">证件号： </span>{{$data->warranty_rule->policy->code}}</li>
                            <li><span class="name">出生日期：</span> {{substr($data->warranty_rule->policy->code,6,4)}}-{{substr($data->warranty_rule->policy->code,10,2)}}     </li>
                            <li><span class="name">性别：</span>@if(substr($data->warranty_rule->policy->code,16,1)%2 == 1)男@else女@endif</li>
                            <li><span class="name">手机号码：</span>{{$data->warranty_rule->policy->phone}}</li>
                            <li><span class="name">电子邮件：</span>{{$data->warranty_rule->policy->email}}</li>
                        </ul>
                    </div>
                    <div class="division"></div>
                    <div>
                        <div class="title">被保人信息</div>
                        <ul class="list-wrapper">
                            <li><span class="name">姓名: </span>{{$data->warranty_rule->order->warranty_recognizee[0]->name}}</li>
                            <li><span class="name">证件类型:</span>@if($data->warranty_rule->order->warranty_recognizee[0]->card_type == 1)身份证@else其他@endif</li>
                            <li><span class="name">证件号：</span>{{$data->warranty_rule->order->warranty_recognizee[0]->code}}</li>
                            <li><span class="name">出生日期：</span>{{substr($data->warranty_rule->policy->code,6,4)}}-{{substr($data->warranty_rule->policy->code,10,2)}}</li>
                            <li><span class="name">性别：</span>@if(substr($data->warranty_rule->policy->code,16,1)%2 == 1)男@else女@endif</li>
                            <li><span class="name">职业：</span>{{$data->warranty_rule->order->warranty_recognizee[0]->occupation}}</li>
                            <li><span class="name">手机号码：</span>{{$data->warranty_rule->order->warranty_recognizee[0]->phone}}</li>
                            <li><span class="name">受益人类型：</span>法定受益人</li>
                        </ul>
                    </div>
                    <div class="division"></div>
                    <div>
                        <div class="title">保障权益</div>
                        <ul class="list-wrapper">
                            @foreach($duty as $v)
                            <li><span class="name">{{$v['name']}}：</span>{{$v['defaultValue']}}   </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="buttonbox">
            {{--<button class="btn">修改信息</button>--}}
        </div>
    </div>
</div>

<script src="{{config('view_url.view_url')}}mobile/personal/js/lib/jquery-1.11.3.min.js"></script>
<script src="{{config('view_url.view_url')}}mobile/personal/js/lib/mui.min.js"></script>
<script src="{{config('view_url.view_url')}}mobile/personal/js/common.js"></script>
</body>

</html>