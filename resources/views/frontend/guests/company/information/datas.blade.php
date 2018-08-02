@extends('frontend.guests.company_home.base')
@section('content')
    <link rel="stylesheet" href="{{config('view_url.company_url')}}css/datas.css" />
<div class="main-content clearfix">
    <div class="datas-wrapper">
        <div class="datas" style="margin: 50px auto 100px;">
            <a class="btn-more" href="/information/dataManage">查看详情<i class="iconfont icon-gengduo"></i></a>
            <h3 class="title">数据管理<span>(2017年1月至本月)</span></h3>
            <div id="main1" style="width: 100%;height:90%;"></div>
        </div>
        <div class="datas" style="margin: 100px auto 50px;">
            <a class="btn-more" href="/information/staffManage">查看详情<i class="iconfont icon-gengduo"></i></a>
            <h3 class="title">保障与人员管理<span>(2017年1月至本月)</span></h3>
            <div id="main2" style="width: 100%;height:90%;"></div>
        </div>
    </div>

</div>
@stop
<script src="{{config('view_url.company_url')}}js/lib/jquery-1.11.3.min.js"></script>
<script src="{{config('view_url.company_url')}}js/lib/echarts.js"></script>

<script src="{{config('view_url.company_url')}}js/common.js"></script>
<script>
    $(function() {
        // 数据管理
        var dataOption = {
            color: ['#42e1f1','#00a2ff'],
            legend: {
                data: ['总人数', '报销人数'],
                bottom: '0px',
                left: '20px',
            },
            tooltip : {
                trigger: 'axis'
            },
            grid: {
                top: '16%',
                left: '0%',
                right: '0%',
                bottom: '20%',
                containLabel: true
            },
            xAxis : [{
                type : 'category',
                data : ['一月','二月','三月','四月','五月','六月','七月','八月','九月','十月','十一月','本月'],
                axisLabel: {
                    textStyle: {
                        color: '#d8d7d9'
                    }
                },
            }],
            yAxis : [{
                name: '人数',
                nameTextStyle: {
                    color: '#d8d7d9'
                },
                axisLabel: {
                    textStyle: {
                        color: '#d8d7d9'
                    }
                },
            }],
            series : [
                {
                    name:'总人数',
                    type:'bar',
                    barWidth: 12,
                    barGap: '-100%',
                    data:[100,90,60,120,140,170,100,90,120,150,120,90]
                },
                {
                    name:'报销人数',
                    type:'bar',
                    barWidth: 12,
                    barGap: '-100%',
                    data:[70,80,50,90,100,70,80,50,90,100,60,50]
                },
            ]
        };
        var myChart1 = echarts.init(document.getElementById('main1'));
        myChart1.setOption(dataOption);

        // 人员管理
        var xAxisData = ['一月','二月','三月','四月','五月','六月','七月','八月','九月','十月','十一月','本月'];
        var data1 = [17,22,38,10,26,31,42,43,31,51,49,10];
        var data2 = [-23,-36,-25,-11,-25,-13,-46,-35,-51,-45,-57,-10];

        var itemStyle = {
            normal: {},
            emphasis: {
                barBorderWidth: 1,
                shadowBlur: 10,
                shadowOffsetX: 0,
                shadowOffsetY: 0,
                shadowColor: 'rgba(0,0,0,0.5)'
            }
        };

        var staffOption = {
            color: ['#42e1f1','#00a2ff'],
            legend: {
                data: ['增员', '减员'],
                bottom: '0px',
                left: '20px',
            },
            tooltip: {},
            grid: {
                top: '16%',
                left: '0%',
                right: '0%',
                bottom: '20%',
                containLabel: true
            },
            xAxis: {
                data: xAxisData,
                silent: false,
                axisLine: {onZero: true},
                splitLine: {show: false},
                splitArea: {show: false},
                axisLabel: {
                    textStyle: {
                        color: '#d8d7d9'
                    }
                },
            },
            yAxis: {
                name: '人数',
                nameTextStyle: {
                    color: '#d8d7d9'
                },
                axisLabel: {
                    textStyle: {
                        color: '#d8d7d9'
                    }
                },
            },
            series: [
                {
                    name: '增员',
                    type: 'bar',
                    barWidth: 12,
                    stack: 'one',
                    itemStyle: itemStyle,
                    data: data1
                },
                {
                    name: '减员',
                    type: 'bar',
                    barWidth: 12,
                    stack: 'one',
                    itemStyle: itemStyle,
                    data: data2
                }
            ]
        };
        var myChart2 = echarts.init(document.getElementById('main2'));
        myChart2.setOption(staffOption);
    });
</script>