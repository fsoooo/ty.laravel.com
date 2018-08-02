<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link rel="stylesheet" href="/css/backend/home.css">

</head>
<body>

    <div class="wrap">
        <div class="head">
            <div class="logo">
                <img src="/image/logo.png" alt="">
            </div>//
            <div class="nav">
                <ul>
                    <li>主页</li>{{--/
                    --}}<li>代理人</li>{{--/
                    --}}<li>财务</li>{{--/
                    --}}<li>客户</li>{{--/
                    --}}<li>渠道</li>{{--/
                    --}}<li>保单</li>{{--/
                    --}}<li>统计和预测</li>{{--/
                    --}}<li><img src="/image/....png" alt="" style="width: 18px"></li>
                </ul>
            </div>
            <div class="icon">
                <img src="/image/1.png" alt="" class="icon">
                <img src="/image/1.png" alt="" class="icon">
                <img src="/image/1.png" alt="" class="icon">
                <img src="/image/1.png" alt="" class="icon">
                <img src="/image/1.png" alt="" class="icon">
            </div>
        </div>
        <div class="main">

            <div class="tip-block">
                <div class="tips"></div>{{--/
                 --}}<div class="tips"></div>{{--
                --}}<div class="tips"></div>{{--/
                --}}<div class="tips"></div>{{--/
                --}}<div class="tips"></div>{{--/
                --}}<div class="tips"></div>{{--/
                --}}
            </div>
            <div class="ClearFix"></div>
        </div>


        <div class="footer">

        </div>


        <!-- 为ECharts准备一个具备大小（宽高）的Dom -->
        <div id="main" style="width: 600px;height:400px;border: 1px solid #000;"></div>



    </div>

</body>
<script src="{{ url('/js/echarts.js') }}"></script>
<script type="text/javascript">
    // 基于准备好的dom，初始化echarts实例
    var myChart = echarts.init(document.getElementById('main'));

    // 指定图表的配置项和数据
    var option = {
        title: {
            text: 'ECharts 入门示例'
        },
        tooltip: {},
        legend: {
            data:['销量']
        },
        xAxis: {
            data: ["衬衫","羊毛衫","雪纺衫","裤子","高跟鞋","袜子"]
        },
        yAxis: {},
        series: [{
            name: '销量',
            type: 'bar',
            data: [5, 20, 36, 10, 10, 20]
        }]
    };

    // 使用刚指定的配置项和数据显示图表。
    myChart.setOption(option);
</script>
</html>