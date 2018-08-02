@extends('backend_v2.layout.base')
@section('title')@parent 代理商详情 @stop
@section('head-more')
    <link rel="stylesheet" href="{{asset('r_backend/v2/css/agent.css')}}" />
@stop

@section('top_menu')
    @include('backend_v2.agent.top_menu')
@stop
@section('main')
    <div id="performance" class="main-wrapper">
        @include('backend_v2.agent.agent_top')
        <div class="row select-wrapper">
            <div class="col-lg-12">
                <div class="chart-wrapper">
                    <div class="chart-header">
                        <span class="btn-select active">年</span>
                        <span class="btn-select">季</span>
                        <select class="form-control fr">
                            <option>不限产品</option>
                            <option>8月</option>
                            <option>9月</option>
                            <option>10月</option>
                            <option>11月</option>
                        </select>
                        <select class="form-control fr">
                            <option>2017年</option>
                            <option>2016年</option>
                            <option>2015年</option>
                            <option>2014年</option>
                            <option>2013年</option>
                        </select>
                    </div>
                    <div id="main" style="width: 96%;height:180px;"></div>
                </div>

            </div>
        </div>
        <div class="row">
            <div class="ui-table col-lg-12">
                <div class="ui-table-header radius">
                    <span class="col-md-2">保单号</span>
                    <span class="col-md-2">产品名称</span>
                    {{--<span class="col-md-1">承保时间</span>--}}{{--todo--}}
                    <span class="col-md-1">保费(元)</span>
                    <span class="col-md-1">缴费方式</span>
                    <span class="col-md-1">投保人</span>
                    <span class="col-md-1">被保人</span>
                    <span class="col-md-1">佣金总额(元)</span>
                    <span class="col-md-1">代理人佣金(元)</span>
                    <span class="col-md-1">操作</span>
                </div>
                <div class="ui-table-body">
                    <ul>
                        @foreach($agent->orders as $k => $v)
                            <li class="ui-table-tr">
                                <div class="col-md-2">{{!empty($v->warranty_rule->warranty) ? $v->warranty_rule->warranty->warranty_code : '未出单'}}</div>
                                <div class="col-md-2">{{$v->product->company_name}}</div>
                                {{--<div class="col-md-1" style="margin: 0;">2017-01-05<br/>至<br/>2030-01-04</div>--}}
                                <div class="col-md-1">{{$v->premium / 100}}</div>
                                <div class="col-md-1">{{$v->by_stages_way}}</div>
                                {{--todo--}}
                                <div class="col-md-1">{{$v->warranty_rule->policy->name}}</div>
                                <div class="col-md-1">{{$v->warranty_recognizee[0]->name}}</div>
                                <div class="col-md-1">{{$v->companyBrokerage->brokerage / 100}}</div>
                                <div class="col-md-1">{{$v->order_brokerage->user_earnings / 100}}</div>
                                <div class="col-md-1" style="margin-top: 10px;">
                                    <a href="{{ url('/backend/order/personal_details?id='. $v->id) }}"><button class="btn btn-primary">查看详情</button></a>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

        </div>
    </div>
    <input type="hidden" id="task_arr" value="{{ json_encode($task_arr) }}">
    <input type="hidden" id="finish_task_arr" value="{{ json_encode($finish_task_arr) }}">
@stop
@section('footer-more')
    <script>
        var task = $("#task_arr").val();
        task = JSON.parse(task);
        var task_array =  new Array();
        for(var i in task){
            task_array[i] = task[i];
        }
        var finish_task = $("#finish_task_arr").val();
        finish_task = JSON.parse(finish_task);
        var finish_task_array =  new Array();
        for(var i in task){
            finish_task_array[i] = finish_task[i];
        }

        changeTab('.btn-select');
        var data1 = {
            xDatas: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'],
            data : ['任务额度','已完成额度'],
            yDatas : [
                task_array,
                finish_task_array
            ]
        }
        echartOptions(data1,'main')
        function echartOptions(obj,ele){
            var color = ['#da4fdc','#63dc4f','#00a2ff','#faf722','#c61e57','#1aeddc'];
            var data1 = obj.data;
            var newData = [];
            for(var i=0,l=data1.length;i<l;i++){
                var dataobj = {};
                dataobj.name = data1[i];
                dataobj.icon = 'pin';
                dataobj.textStyle= {};
                dataobj.textStyle.color = color[i];
                newData.push(dataobj);
            }
            var newYData = [];
            var yDatas = obj.yDatas;
            for(var i=0,l=yDatas.length;i<l;i++){
                var dataobj = {};
                dataobj.name = data1[i];
                dataobj.type = 'bar';
                dataobj.barWidth = 20;
                dataobj.data = yDatas[i];
                dataobj.itemStyle = {
                    normal: {
                        barBorderRadius:[4, 4, 0, 0]
                    }
                };
                newYData.push(dataobj);
            }
            var option = {
                color: color,
                tooltip: {
                    trigger: 'axis',
                    axisPointer: {
                        type: 'shadow'
                    }
                },
                legend: {
                    data: newData,
                    bottom: '0px',
                    left: '20px',
                    textStyle: {
                        fontSize: 10
                    }
                },
                grid: {
                    top: '6%',
                    left: '0%',
                    right: '4%',
                    bottom: '20%',
                    containLabel: true
                },
                xAxis: [{
                    type: 'category',
                    axisLabel: {
                        textStyle: {
                            color: '#83879d'
                        }
                    },
                    splitLine:{
                        show:true,
                        lineStyle:{
                            color: '#2f365a',
                        }
                    },
                    data: obj.xDatas
                }],
                yAxis: [{
                    type: 'value',
                    axisLabel: {
                        textStyle: {
                            color: '#00a2ff'
                        }
                    },
                    splitLine:{
                        lineStyle:{
                            color: '#2f365a',
                        }
                    },
                }],
                series: newYData
            };
            var myChart1 = echarts.init(document.getElementById(ele));
            myChart1.setOption(option);
            $(window).resize(function(){
                myChart1.resize();
            });
        }
    </script>
@stop