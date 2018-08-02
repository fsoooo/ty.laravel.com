@extends('frontend.guests.company_home.base')
@section('content')
    <link rel="stylesheet" href="{{config('view_url.company_url')}}css/lib/paging.css" />
    <style>
        .main-content{padding: 20px;background: #fff;}
        .btn{width: 40px;}
        .filter{width: 160px;background-position-x: 140px;}
    </style>
    <div class="table-nav">
        <span class="active">意外伤害保险</span>
    </div>
    <div class="main-content">
        <div class="table-wrapper">
            <div>
                <select class="filter">
                    <option value="" selected disabled>请选择年份</option>
                    <option value="">2016</option>
                    <option value="">2017</option>
                </select>
                <div id="main" style="width:100%;height:300px;"></div>
            </div>
            <table class="table-address">
                <thead>
                <tr>
                    <th width="40px"><input type="checkbox"/>全选</th>
                    <th width="40px">工号</th>
                    <th width="40px">姓名</th>
                    <th width="200px">身份证号</th>
                    <th width="100px">手机号码</th>
                    <th width="100px">报销金额</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td><input type="checkbox" /></td>
                    <td>01</td>
                    <td>天小眼</td>
                    <td>1215541111211212</td>
                    <td>13599845562</td>
                    <td>2018-06-05</td>
                </tr>
                <tr>
                    <td><input type="checkbox" /></td>
                    <td>01</td>
                    <td>天小眼</td>
                    <td>1215541111211212</td>
                    <td>13599845562</td>
                    <td>测试方案一</td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="paging-wrapper">
            <div id="pageToolbar"></div>
        </div>
    </div>
@stop
<script src="{{config('view_url.company_url')}}js/lib/jquery-1.11.3.min.js"></script>
<script src="{{config('view_url.company_url')}}js/lib/echarts.js"></script>
<script src="{{config('view_url.company_url')}}js/lib/paging.js"></script>
<script src="{{config('view_url.company_url')}}js/common.js"></script>
<script type="text/javascript">
    $('#pageToolbar').Paging({
        pagesize:10,
        count:85,
        prevTpl: "<",
        nextTpl: ">",
        toolbar:true,
        callback: function(page,size,count){
            console.log('当前第 ' +page +'页,每页 '+size+'条,总页数：'+count+'页')
        }
    });

    paymentoption = {
        calculable : true,
        tooltip : {
            trigger: 'axis'
        },
        xAxis : [
            {
                type : 'category',
                data : ['1','2','3','4','5','6','7','8','9','10','11','12']
            },
            //辅助x轴
            {
                type : 'category',
                axisLine: {show:false},
                axisTick: {show:false},
                axisLabel: {show:false},
                splitArea: {show:false},
                splitLine: {show:false},
                data : ['1','2','3','4','5','6','7','8','9','10','11','12']
            }
        ],
        yAxis : [
            {
                type : 'value',
                axisLabel:{formatter:'{value}'}
            }
        ],
        series : [
            {
                name:'报销人数',
                type:'bar',
                itemStyle: {
                    normal: {
                        color: function(params) {
                            return '#F08080'
                        }
                    }
                },
                data:[70,80,50,90,100,70,70,30,60,60,40,50]
            },
            {
                name:'总人数',
                type:'bar',
                xAxisIndex:1,
                itemStyle: {normal: {color:'rgba(102, 102, 102,0.5)'}},
                //data填你需要的背景的值
                data:[100,90,60,100,100,70,80,50,90,100,90,100]
            },
        ]
    };
    var myChart = echarts.init(document.getElementById('main'));
    myChart.setOption(paymentoption);




</script>