<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>我的业绩</title>
    <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
    <link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/lib/mui.min.css">
    <link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/lib/iconfont.css" />
    <link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/common_agent.css" />
    <link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/performance.css" />
</head>
<body>
<div class="main">
    <header id="header" class="mui-bar mui-bar-nav">
        <a class="iconfont icon-fanhui mui-pull-left mui-action-back"></a>
        <h1 class="mui-title">我的业绩</h1>
    </header>
    <div class="mui-scroll-wrapper">
        <div class="mui-scroll">
            <div class="datas-wrapper">
                <div class="datas">

                    <div id="main" style="width: 100%;height:100%;"></div>
                </div>
            </div>
            <ul class="datas-list">
                <li>
                    <div class="info title">
                        <span>时间</span>
                        <span>客户</span>
                        <span>佣金比率</span>
                        <span>佣金金额（元）</span>
                        <span></span>
                    </div>
                </li>
                @foreach($data as $v)
                <li>
                    <div class="info">
                        <span>{{strtok($v['created_at'],' ')}}</span>
                        <span>{{$v->order_user['name']}}</span>
                        <span>{{$v->order_brokerage['rate']}}%</span>
                        <span>{{$v->order_brokerage['user_earnings']/100}}</span>
                        <span class="more"><i class="iconfont icon-gengduo"></i></span>
                    </div>
                    <div class="details">
                        <div class="details-img">
                            <img src="{{env('TY_API_PRODUCT_SERVICE_URL').'/'.$v->product['jsons']['company']['logo']}}" alt="" />
                        </div>
                        <div class="details-content">
                            <p><span>产品名称:</span>{{$v->product['product_name']}}</p>
                            <p><span>保障期限:</span>一年</p>
                            <p><span>险种:</span>{{$v->product['jsons']['category']['name']}}</p>
                            <p><span>保额:</span>50万元</p>
                            <p><span>保费:</span>{{$v->order_brokerage['order_pay']/100}}元</p>
                            <p class="status">@if($v['status'] == 1)已支付@else未支付@endif</p>
                        </div>
                    </div>
                </li>
                @endforeach
            </ul>
        </div>
    </div>

</div>

<script src="{{config('view_url.agent_mob')}}js/lib/jquery-1.11.3.min.js"></script>
<script src="{{config('view_url.agent_mob')}}js/lib/mui.min.js"></script>
<script src="{{config('view_url.agent_mob')}}js/lib/echarts.js"></script>
<script src="{{config('view_url.agent_mob')}}js/common_agent.js"></script>
<script>
    var task = [];
    var user_earning = [];
    var pay = [];
    var month = [];
    @if($final_data)
    @foreach($final_data['month'] as $key=>$val)
    month['{{$key}}'] = '{{$key+1}}';
    @endforeach
    @foreach($final_data['sum_earnings'] as $key=>$val)
    user_earning['{{$key}}'] = '{{$val/100}}';
    @endforeach
    @foreach($final_data['pay'] as $key=>$val)
    pay['{{$key}}'] = '{{$val/100}}';
    @endforeach
    @foreach($final_data['task'] as $key=>$val)
    task['{{$key}}'] = '{{$val}}';
    @endforeach
    @endif
    console.log(month);


$('.icon-gengduo').on('tap',function(){
        var _this = $(this);
        var $details = _this.parents('li').find('.details');
        _this.toggleClass('active');
        _this.hasClass('active') == true ? $details.show(100) : $details.hide(100);
    });



    option = {
        tooltip: {
            trigger: 'axis',
            axisPointer: {
                type: 'cross',
                label: {
                    backgroundColor: '#6a7985'
                }
            }
        },
        legend: {
            data: [{
                name: '佣金',
                icon: 'pin',
                textStyle: {
                    color: '#adadad'
                }
            },
                {
                    name: '任务',
                    icon: 'pin',
                    textStyle: {
                        color: '#adadad'
                    }
                },
                {
                    name: '保费',
                    icon: 'pin',
                    textStyle: {
                        color: '#adadad'
                    }
                }],
            top: '0px',
            right: '0%'
        },
        grid: {
            left: '3%',
            top: '30%',
            right: '4%',
            bottom: '10%',
            containLabel: true
        },
        xAxis: [{
            type: 'category',
            axisLabel: {
                textStyle: {
                    color: '#d8d7d9'
                }
            },
            boundaryGap: false,
            data: month
        }],
        yAxis: [{
            type: 'value',
            name: '佣金金额(元)',
            nameTextStyle: {
                color: '#d8d7d9'
            },
            axisLabel: {
                textStyle: {
                    color: '#d8d7d9'
                }
            }
        }],
        series: [{
            name: '佣金',
            type: 'line',
            stack: '总量1',
            smooth: true,
            itemStyle: {
                normal: {
                    lineStyle: {
                        color: new echarts.graphic.LinearGradient(0, 0.5, 0.7, 1, [{
                            offset: 0,
                            color: '#41e0f1'
                        }, {
                            offset: 1,
                            color: '#00a2ff'
                        }]),
                    }
                }
            },
            data: user_earning
        },
            {
                name: '任务',
                type: 'line',
                stack: '总量2',
                smooth: true,
                itemStyle: {
                    normal: {
                        lineStyle: {
                            color: new echarts.graphic.LinearGradient(0, 0.5, 0.7, 1, [{
                                offset: 0,
                                color: '#ffae00'
                            }, {
                                offset: 1,
                                color: '#ffae00'
                            }]),
                        }
                    }
                },
                data: task
            },
            {
                name: '保费',
                type: 'line',
                stack: '总量3',
                smooth: true,
                itemStyle: {
                    normal: {
                        lineStyle: {
                            color: new echarts.graphic.LinearGradient(0, 0.5, 0.7, 1, [{
                                offset: 0,
                                color: '#025a8d'
                            }, {
                                offset: 1,
                                color: '#025a8d'
                            }]),
                        }
                    }
                },
                data: pay
            }

        ]
    };

    var myChart = echarts.init(document.getElementById('main'));
    myChart.setOption(option);
    window.addEventListener("resize", function () {
        myChart.resize();
    });
    window.addEventListener("load", function () {
        myChart.resize();
    });
</script>
</body>
</html>
