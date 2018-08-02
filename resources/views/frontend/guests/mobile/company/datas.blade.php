<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>天眼互联-科技让保险无限可能</title>
    <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
    <link rel="stylesheet" href="{{config('view_url.view_url')}}mobile/company/css/lib/mui.min.css">
    <link rel="stylesheet" href="{{config('view_url.view_url')}}mobile/company/css/lib/iconfont.css" />
    <link rel="stylesheet" href="{{config('view_url.view_url')}}mobile/company/css/common.css" />
    <link rel="stylesheet" href="{{config('view_url.view_url')}}mobile/company/css/information.css" />
    <link rel="stylesheet" href="{{config('view_url.view_url')}}mobile/company/css/lib/swiper-3.4.2.min.css" />
    <style>
        .data-wrapper {padding: 0 .2rem;}.data-wrapper .title {height: 1rem;line-height: 1rem;font-size: .32rem;}
        .data-wrapper .title>span {color: #00a2ff;}.swiper-container {width: 80%;height: 5rem;background: #ADADAD;}
        .chart-wrapper{position: relative;}.histogram-outer {position: absolute;bottom: 0;display: inline-block;margin-left: 1rem;width: .5rem;height: 2rem;background: #0062CC;}
        .swiper-slide {width: 100%;height: 100%;}.main-container {width: 100%;height: 100%;}
        .swiper-container{width: 80%;height: 4rem}.inner{width:80%;height: 100%;background: #333;}.outer{width: 100%;height: 100%;}
        .swiper-button-prev,.swiper-button-next{top: 60%;width: 27px;height: 17px;}
    </style>
</head>

<body>
<div class="main">
    <header class="mui-bar mui-bar-nav">
        <a class="mui-icon mui-icon-back mui-pull-left mui-action-back"></a>
        <h1 class="mui-title">数据统计</h1>
    </header>
    <div class="mui-content">
        <div class="mui-scroll-wrapper">
            <div class="mui-scroll">
                <div class="data-wrapper">
                    <div class="title">数据管理<a href="datas-user.html" class="fr">详情</a></div>
                    <div class="chart-wrapper">
                        <div class="swiper-container swiper1">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide swiper-no-swiping">
                                    <div id="main1"  style="width:100%;height:100%;"></div>
                                </div>
                                <div class="swiper-slide swiper-no-swiping">
                                    <div id="main2"  style="width:100%;height:100%;"></div>
                                </div>
                                <div class="swiper-slide swiper-no-swiping">
                                    <div id="main3"  style="width:100%;height:100%;"></div>
                                </div>
                                <div class="swiper-slide swiper-no-swiping">
                                    <div id="main4"  style="width:100%;height:100%;"></div>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-button-prev prev1"></div>
                        <div class="swiper-button-next next1"></div>
                    </div>
                </div>
                <div class="division"></div>
                <div class="data-wrapper">
                    <div class="title">保障与人员管理<a href="datas-safeguard.html" class="fr">详情</a></div>
                    <div class="chart-wrapper">
                        <div class="swiper-container swiper2">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide swiper-no-swiping">
                                    <div id="main5" style="width:100%;height:100%;"></div>
                                </div>
                                <div class="swiper-slide swiper-no-swiping">
                                    <div id="main6" style="width:100%;height:100%;"></div>
                                </div>
                                <div class="swiper-slide swiper-no-swiping">
                                    <div id="main7" style="width:100%;height:100%;"></div>
                                </div>
                                <div class="swiper-slide swiper-no-swiping">
                                    <div id="main8" style="width:100%;height:100%;"></div>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-button-prev prev2"></div>
                        <div class="swiper-button-next next2"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{config('view_url.view_url')}}mobile/company/js/lib/jquery-1.11.3.min.js"></script>
<script src="{{config('view_url.view_url')}}mobile/company/js/lib/mui.min.js"></script>
<script src="{{config('view_url.view_url')}}mobile/company/js/lib/echarts.js"></script>
<script src="{{config('view_url.view_url')}}mobile/company/js/lib/swiper-3.4.2.min.js"></script>
<script src="{{config('view_url.view_url')}}mobile/company/js/common.js"></script>
<script>
    var mySwiper1 = new Swiper('.swiper1', {
        prevButton: '.prev1',
        nextButton: '.next1'
    });
    var mySwiper2 = new Swiper('.swiper2', {
        prevButton: '.prev2',
        nextButton: '.next2'
    });

    function Charts(ele, datas) {
        paymentoption = {
            backgroundColor: '#eee',
            legend: {
                data: ['报销人数','总人数']
            },
            xAxis: [{
                type: 'category',
                data: datas.XData
            },
                //辅助x轴
                {
                    type: 'category',
                    axisLine: {
                        show: false
                    },
                    axisTick: {
                        show: false
                    },
                    axisLabel: {
                        show: false
                    },
                    splitArea: {
                        show: false
                    },
                    splitLine: {
                        show: false
                    },
                    data: datas.XData
                }
            ],
            yAxis: [{
                type: 'value',
                axisLabel: {
                    formatter: '{value}'
                }
            }],
            series: [{
                name: '报销人数',
                type: 'bar',
                label: {
                    normal: {
                        show: true,
                        position: 'inside'
                    }
                },
                barWidth: '30%',
                itemStyle: {
                    normal: {
                        color: function(params) {
                            return '#F08080'
                        }
                    }
                },
                data: datas.YData
            },
                {
                    name: '总人数',
                    type: 'bar',
                    label: {
                        normal: {
                            show: true,
                            position: 'top'
                        }
                    },
                    barWidth: '30%',
                    xAxisIndex: 1,
                    //颜色需要有透明度
                    itemStyle: {
                        normal: {
                            color: 'rgba(102, 102, 102,0.5)'
                        }
                    },
                    //data填你需要的背景的值
                    data: datas.YTotalData
                },
            ]
        };
        var myChart = echarts.init(ele);
        myChart.setOption(paymentoption);
        window.addEventListener("resize", function () {
            myChart.resize();
        });
        window.addEventListener("load", function () {
            myChart.resize();
        });
    }

    // 数据管理数据
    var data1 = {
        XData: ['1', '2', '3'],
        YData: [70, 80, 50],
        YTotalData: [100, 90, 60]
    }
    var data2 = {
        XData: ['4', '5', '6'],
        YData: [70, 20, 50],
        YTotalData: [80, 90, 60]
    }
    var data3 = {
        XData: ['7', '8', '9'],
        YData: [50, 30, 50],
        YTotalData: [60, 90, 50]
    }
    var data4 = {
        XData: ['10', '11', '12'],
        YData: [50, 30, 50],
        YTotalData: [60, 90, 50]
    }

    Charts(document.getElementById('main1'), data1);
    Charts(document.getElementById('main2'), data2);
    Charts(document.getElementById('main3'), data3);
    Charts(document.getElementById('main4'), data4);

    function Charts2(ele, datas) {
        var itemStyle = {
            emphasis: {
                barBorderWidth: 1,
                shadowBlur: 10,
                shadowOffsetX: 0,
                shadowOffsetY: 0,
                shadowColor: 'rgba(0,0,0,0.5)'
            }
        };

        option = {
            backgroundColor: '#eee',
            legend: {
                data: ['增员', '减员'],
            },
            xAxis: {
                data: datas.XData,
                silent: false,
                axisLine: {
                    onZero: true
                },
                splitLine: {
                    show: false
                },
                splitArea: {
                    show: false
                }
            },
            yAxis: {
                inverse: false,
                splitArea: {
                    show: false
                }
            },
            series: [{
                name: '增员',
                type: 'bar',
                label: {
                    normal: {
                        show: true,
                        position: 'inside'
                    }
                },
                barWidth: '30%',
                stack: 'one',
                itemStyle: itemStyle,
                data: datas.data1
            },
                {
                    name: '减员',
                    type: 'bar',
                    label: {
                        normal: {
                            show: true,
                            position: 'inside'
                        }
                    },
                    barWidth: '30%',
                    stack: 'one',
                    itemStyle: itemStyle,
                    data: datas.data2
                }
            ]
        };

        var myChart = echarts.init(ele);
        myChart.setOption(option);
        window.addEventListener("resize", function () {
            myChart.resize();
        });
        window.addEventListener("load", function () {
            myChart.resize();
        });
    }

    // 保障与人员管理数据
    var data5 = {
        XData: ['1', '2', '3'],
        data1: [1, 2, 3,],
        data2: [-3, -6, -5]
    }
    var data6 = {
        XData: ['4', '5', '6'],
        data1: [3, 2, 6],
        data2: [-3, -6, -5]
    }
    var data7 = {
        XData: ['7', '8', '9'],
        data1: [4, 2, 6],
        data2: [-6, -6, -3]
    }
    var data8 = {
        XData: ['10', '11', '12'],
        data1: [4, 2, 6],
        data2: [-6, -6, -3]
    }

    Charts2(document.getElementById('main5'), data5);
    Charts2(document.getElementById('main6'), data6);
    Charts2(document.getElementById('main7'), data7);
    Charts2(document.getElementById('main8'), data8);

</script>
</body>

</html>