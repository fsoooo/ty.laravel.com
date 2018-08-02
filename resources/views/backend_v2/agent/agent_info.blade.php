@extends('backend_v2.layout.base')
@section('title')@parent 代理人详情 @stop
@section('head-more')
    <link rel="stylesheet" href="{{asset('r_backend/v2/css/agent.css')}}" />
@stop

@section('top_menu')
    @include('backend_v2.agent.top_menu')
@stop
@section('main')
    <div id="info" class="main-wrapper">
        @include('backend_v2.agent.agent_top')
        <div class="row">
            <div class="col-md-5">
                <div class="chart-wrapper">
                    <div>
                        <span class="btn-select active">年</span>
                        <span class="btn-select">月</span>
                        <span class="btn-select">周</span>
                        <select class="form-control fr">
                            <option>2017年</option>
                            <option>2016年</option>
                            <option>2015年</option>
                            <option>2014年</option>
                            <option>2013年</option>
                        </select>
                    </div>
                    <div id="main1" style="width: 100%;height:180px;"></div>
                </div>
            </div>
            <div class="col-md-7">
                <div class="info-wrapper">
                    <div class="info-img col-lg-2">
                        <img src="{{ asset('/r_backend/v2/img/boy.png')}}" alt="" />
                    </div>
                    <div class="col-lg-10 ">
                        <p>{{$agent->user->name}}
                                @if($agent->certification_status)
                                <span class="color-primary"><i class="iconfont icon-shiming"></i>已实名</span>
                                @else
                                <span class="color-negative"><i class="iconfont icon-weishiming"></i>未实名</span>
                                @endif
                        </p>
                        @if($agent->work_status)
                            <p class="color-default">在职</p>
                        @else
                            <p class="color-default notReal">离职</p>
                        @endif
                    </div>
                    <div class="info-datails">
                        <div class="col-xs-6 col-md-4">
                            <p><span class="name">工号</span><i>:</i>{{$agent->job_number}}</p>
                            {{--<p><span class="name">客户人数</span><i>:</i>42</p>--}}
                            <p><span class="name">渠道</span><i>:</i>{{count($agent->ditches) ? $agent->ditches[0]->name : ''}}</p>
                        </div>
                        <div class="col-xs-6 col-md-6">
                            <p><span class="name">手机号码</span><i>:</i>{{$agent->phone}}</p>
                            <p><span class="name">证件号码</span><i>:</i>{{$agent->user->trueUserInfo ? $agent->user->trueUserInfo->card_id : ''}}</p>
                            <p><span class="name">邮 箱</span><i>:</i>{{$agent->email}}</p>
                        </div>
                        @if($agent->work_status != 0)
                        <div class="col-xs-12 text-right" style="margin-top: 24px;">
                            <button class="btn btn-warning" data-toggle="modal" data-target="#changeWarning">更改职位状态</button>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="changeWarning" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog modal-alert" role="document">
                <div class="modal-content">
                    <div class="modal-header notitle">
                        <button type="button" class="" data-dismiss="modal" aria-label="Close"><i class="iconfont icon-cancel"></i></button>
                    </div>
                    <div class="modal-body">
                        <i class="iconfont icon-warning"></i>
                        <p>是否更改代理人的职位状态。</p>
                        <p>更改后不可改回之前状态！</p>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" id="work-status-off">是</button>
                        <button class="btn btn-warning" data-dismiss="modal">否</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
    {{ csrf_field() }}
    <input type="hidden" name="agent_id" value="{{ $agent->id }}" id="agent-id">
    <input type="hidden" id="pay" value="{{ json_encode($pay) }}">
    <input type="hidden" id="sum_earnings" value="{{ json_encode($sum_earnings) }}">
@stop
@section('footer-more')
    <script>
        $("#work-status-off").click(function(){
            var token = $("input[name=_token]").val();
            var agent_id = $("#agent-id").val();
            $.post('/backend/agent/change_work_status', {'_token':token,'agent_id':agent_id}, function(data){
                if(data == 1){
                    location.href = location;
                }else{
                    alert('修改失败');
                }
            });
        });

        var pay = $("#pay").val();
        pay = JSON.parse(pay);
        var pay_array =  new Array();
        for(var i in pay){
            pay_array[i] = pay[i];
        }
        var sum_earnings = $("#sum_earnings").val();
        sum_earnings = JSON.parse(sum_earnings);
        var sum_earnings_array = new Array();
        for(var j in sum_earnings){
            sum_earnings_array[j] = sum_earnings[j];
        }
        changeTab('.btn-select');
        var data1 = {
            selected: {
//                '获益佣金': false
            },
            xDatas: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'],
            data : ['成交保费','代理人佣金'],
            yDatas : [
                pay_array,
                sum_earnings_array
            ]
        }
        console.log(data1.yDatas);
        echartOptions(data1,'main1')
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
                dataobj.stack = '总量'+i;
                dataobj.type = 'line';
                dataobj.smooth = true;
                dataobj.data = yDatas[i];
                newYData.push(dataobj);
            }
            var option = {
                color: color,
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
                    selected: obj.selected,
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
                    boundaryGap: false,
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