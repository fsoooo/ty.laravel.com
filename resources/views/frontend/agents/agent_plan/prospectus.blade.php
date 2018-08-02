@extends('frontend.agents.agent_home.base')
@section('content')
    <link rel="stylesheet" href="{{config('view_url.agent_url')}}css/lib/swiper-3.4.2.min.css" />
    <link rel="stylesheet" href="{{config('view_url.agent_url')}}css/performance.css" />
    <div class="datas-wrapper">
        <div class="datas">
            <div id="main" style="width: 100%;height:100%;"></div>
        </div>
    </div>
    <div class="content">
        <form id="select_search" action="/agent_sale/agent_commission" method="get">
            <input type="hidden" name="_token" value="{{csrf_token()}}">
        <select id="search_option" name="search">
            <option @if(isset($_GET['search']) && $_GET['search'] == 1) selected @endif value="1">近三个月</option>
            <option @if(isset($_GET['search']) && $_GET['search'] == 2)selected @endif value="2">近半年</option>
            <option @if(isset($_GET['search']) && $_GET['search'] == 3)selected @endif value="3">近一年</option>
            <option @if(!isset($_GET['search']) || $_GET['search'] == 4)selected @endif value="4">全部</option>
        </select>
            <script>
                $('#search_option').change(function(){
                    $("#select_search").submit();
                })
            </script>
        </form>
        <ul class="datas-list">
            <li>
                <div class="info title">
                    <span>时间</span>
                    <span>客户</span>
                    <span>佣金比率</span>
                    <span>佣金金额（元）</span>
                    <span>查看详情</span>
                </div>
            </li>

                @if($count == 0)
                    <li>暂无数据</li>
                @else
                @foreach($data as $v)
                    <li>
                        <div class="info">
                            <span>{{explode(' ',$v->created_at)[0]}}</span>
                            <span>{{$v->order_user->real_name}}</span>
                            <span>{{$v->order_brokerage['rate']}}%</span>
                            <span>{{$v->order_brokerage['user_earnings']/100}}</span>
                            <span class="more"><i class="iconfont icon-gengduo"></i></span>
                        </div>
                        <div class="details">
                            <span>{{$v->product['product_name']}}</span>
                            <span>{{$v->product['company_name']}}</span>
                            <span>{{$v->product['jsons']['category']['name']}}</span>
                            <span>
                                <?php
                                $order_parameter = json_decode($v['order_parameter'][0]['parameter'], true);
                                $items = json_decode($order_parameter['protect_item'], true);
                                ?>
                                @foreach($items as $key=>$val)

                                @endforeach
                            </span>
                            <span>保费{{$v['premium']/100}}元</span>
                            <span>
                                @if($v['status'] == 1)
                                    订单已支付
                                    @else
                                订单未支付
                                    @endif
                            </span>
                        </div>
                    </li>
                    @endforeach
                @endif
        </ul>
        <ul class="pagination">
            {{$data->links()}}
        </ul>
    </div>
    <script src="{{config('view_url.agent_url')}}js/lib/echarts.js"></script>
    <script>
        var task = [];
        var user_earning = [];
        var pay = [];
        var month = [];
        @if($final_data)
        @foreach($final_data['month'] as $key=>$val)
        month['{{$key}}'] = '{{$key+1}}月';
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
        console.log(task);
        // 查看详情焦点区域
        $('.more').hover(function(){
            var _this = $(this);
            _this.parents('li').siblings().find('.iconfont').removeClass('active').end().find('.details').hide(200);
            _this.find('.iconfont').addClass('active').end().parents('.info').next().show(200);
        });

        $('.datas-list').mouseleave(function(){
            var _this = $(this);
            _this.find('.iconfont').removeClass('active');
            _this.find('.details').hide(200);
        });




        option = {
            title: {
                text: '按月佣金统计'
            },
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
                right: '4%'
            },
            grid: {
                left: '3%',
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
    </script>
    @stop