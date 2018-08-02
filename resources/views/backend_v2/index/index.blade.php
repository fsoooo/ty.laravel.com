@extends('backend_v2.layout.base')
@section('title')@parent 代理商系统 @stop
@section('head-more')
<link rel="stylesheet" href="{{asset('r_backend/v2/css/index.css')}}" />
@stop

@section('top_menu')
    @include('backend_v2.index.top_menu')
@stop
@section('main')
<div class="main-wrapper">
    <div class="row">
        <!--保费统计-->
        <div class="col-lg-2 col-md-4">
            <div class="info-wrapper">
                <h2 class="title">保费统计</h2>
                <div class="info-item">
                    <div class="name">今日</div>
                    <div>保费：<span class="price">{{ceil($today->premium/100)}}</span></div>
                    <div>件数：<span class="price color-primary">{{$today->count}}</span></div>
                </div>
                <div class="info-item">
                    <div class="name color-primary">昨日</div>
                    <div>保费：<span class="price">{{$yesterday->premium/100}}</span></div>
                    <div>件数：<span class="price  color-primary">{{ceil($yesterday->count)}}</span></div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-8">
            <div class="chart-wrapper">
                <div class="select-wrapper">
                    {{--<div class="select-date">--}}
                        {{--<span class="btn-select active">年</span>--}}
                        {{--<span class="btn-select">季</span>--}}
                        {{--<span class="btn-select">月</span>--}}
                    {{--</div>--}}
                    <div class="select-chart">
                        <div class="item active">
                            <i class="iconfont icon-tubiaoquxian"></i>曲线图
                        </div>
                        <div class="item">
                            <i class="iconfont icon-bingzhuangtu"></i>饼状图
                        </div>
                    </div>
                    <select class="form-control" style="display: inline-block;" id="premium_date">
                        @foreach($time as $key=>$value)
                            <option value="{{$value->year}}">{{$value->year}}年</option>
                        @endforeach
                    </select>
                </div>
                <div class="chart" style="z-index:1;">
                    <div id="main1" style="width: 100%;height:200px;"></div>
                </div>
                <div class="chart" style="z-index:0;">
                    <div id="main11" style="width: 100%;height:200px;"></div>
                    <div class="percent-left"></div><div class="percent-right"></div>
                </div>
            </div>
        </div>
        <!--佣金统计-->
        <div class="col-lg-4 col-md-8">
            <div class="chart-wrapper">
                <div class="select-wrapper">
                    {{--<div class="select-date">--}}
                        {{--<span class="btn-select active">年</span>--}}
                        {{--<span class="btn-select">季</span>--}}
                        {{--<span class="btn-select">月</span>--}}
                    {{--</div>--}}
                    <div class="select-chart">
                        <div class="item active">
                            <i class="iconfont icon-tubiaoquxian"></i>曲线图
                        </div>
                        <div class="item">
                            <i class="iconfont icon-bingzhuangtu"></i>饼状图
                        </div>
                    </div>
                    <select class="form-control" style="display: inline-block;" id="twoTime">
                        @foreach($twoTime as $key => $value)
                            <option value="{{$value->year}}">{{$value->year}}年</option>
                        @endforeach
                    </select>
                </div>
                <div class="chart" style="z-index:1;">
                    <div id="main2" style="width: 100%;height:200px;"></div>
                </div>
                <div class="chart"  style="z-index:0;">
                    <div id="main22" style="width: 100%;height:200px;"></div>
                    <div class="percent-left"></div><div class="percent-right"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4">
            <div class="info-wrapper">
                <h2 class="title">佣金统计</h2>
                <div class="info-item">
                    <div class="name">今日</div>
                    <div>佣金：<span class="price">{{ceil($t_brokerage->brokerage/100)}}</span></div>
                </div>
                <div class="info-item">
                    <div class="name color-primary">昨日</div>
                    <div>佣金：<span class="price">{{ceil($y_brokerage->brokerage/100)}}</span></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!--客户统计-->
        <div class="col-lg-2 col-md-4">
            <div class="info-wrapper">
                <h2 class="title">客户统计</h2>
                <div class="info-item">
                    <div class="name">今日</div>
                    <div>客户数：<span class="price">{{$t_customer}}</span></div>
                </div>
                <div class="info-item">
                    <div class="name color-primary">昨日</div>
                    <div>客户数：<span class="price">{{$y_customer}}</span></div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-8">
            <div class="chart-wrapper">
                <div class="select-wrapper">
                    {{--<div class="select-date">--}}
                        {{--<span class="btn-select active">年</span>--}}
                        {{--<span class="btn-select">季</span>--}}
                        {{--<span class="btn-select">月</span>--}}
                    {{--</div>--}}
                    <div class="select-chart">
                        <div class="item active">
                            <i class="iconfont icon-tubiaoquxian"></i>曲线图
                        </div>
                        <div class="item">
                            <i class="iconfont icon-chinamap-chart"></i>热力图
                        </div>
                    </div>
                    <select class="form-control" style="display: inline-block;" id="userTime">
                        @foreach($time as $key=>$value)
                            <option value="{{$value->year}}">{{$value->year}}年</option>
                        @endforeach
                    </select>
                </div>
                <div class="chart" style="z-index:1;">
                    <div id="main3" style="width: 100%;height:200px;"></div>
                </div>
                <div class="chart"  style="z-index:0;">
                    <div id="main33" style="width: 100%;height:200px;"></div>
                </div>
            </div>
        </div>
        <!--保全理赔统计-->
        <div class="col-lg-4 col-md-8">
            <div class="chart-wrapper">
                <div class="select-wrapper">
                    {{--<div class="select-date">--}}
                        {{--<span class="btn-select active">年</span>--}}
                        {{--<span class="btn-select">季</span>--}}
                        {{--<span class="btn-select">月</span>--}}
                    {{--</div>--}}
                    <div class="select-chart">
                        <div class="item active">
                            <i class="iconfont icon-tubiaoquxian"></i>曲线图
                        </div>
                        <div class="item">
                            <i class="iconfont icon-tubiaoquxian"></i>曲线图
                        </div>
                    </div>
                    <select class="form-control" style="display: inline-block;">
                        <option>2017年</option>
                        <option>2016年</option>
                        <option>2015年</option>
                        <option>2014年</option>
                        <option>2013年</option>
                    </select>
                </div>
                <div id="main4" style="width: 100%;height:200px;"></div>
                <select class="form-control form-bottom fr">
                    <option>所有保全类型</option>
                    <option>保全类型1</option>
                    <option>保全类型2</option>
                    <option>保全类型3</option>
                </select>
            </div>
        </div>

        <div class="col-lg-2 col-md-4">
            <div class="info-wrapper">
                <h2 class="title">保全、理赔统计</h2>
                <div class="info-item">
                    <div class="name"></div>
                    <div>今日新增案件数</div>
                    <div class="price">12</div>
                </div>
                <div class="info-item">
                    <div class="name color-primary"></div>
                    <div>未结案工单数</div>
                    <div class="price">4</div>
                </div>
            </div>
        </div>

    </div>

    <div class="row">
        <!--代理人统计-->
        <div class="col-lg-2 col-md-4">
            <div class="info-wrapper">
                <h2 class="title">代理人统计</h2>
                <div class="info-item">
                    <div class="name">今日</div>
                    <div>代理人：<span class="price">{{$t_agent}}</span></div>
                </div>
                <div class="info-item">
                    <div class="name color-primary">昨日</div>
                    <div>代理人：<span class="price">{{$y_agent}}</span></div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-8">
            <div class="chart-wrapper">
                <div class="select-wrapper">
                    {{--<div class="select-date">--}}
                        {{--<span class="btn-select active">年</span>--}}
                        {{--<span class="btn-select">季</span>--}}
                        {{--<span class="btn-select">月</span>--}}
                    {{--</div>--}}
                    <div class="select-chart">
                        <div class="item active">
                            <i class="iconfont icon-tubiaoquxian"></i>曲线图
                        </div>
                        <div class="item">
                            <i class="iconfont icon-paixingbang"></i>排行榜
                        </div>
                    </div>
                    <select class="form-control" style="display: inline-block;" id="agentTime">
                        @foreach($timeAgent as $key=>$value)
                            <option value="{{$value->year}}">{{$value->year}}年</option>
                        @endforeach
                    </select>
                </div>
                <div class="chart" style="z-index: 1;">
                    <div id="main5" style="width: 100%;height:200px;"></div>
                </div>
                <div class="chart" style="z-index: 0;">
                    <div id="main55" style="width: 100%;height:200px;"></div>
                </div>
            </div>
        </div>
        <!--任务统计-->
        <div class="col-lg-4 col-md-8">
            <div class="chart-wrapper">
                <div class="select-wrapper">
                    {{--<div class="select-date">--}}
                        {{--<span class="btn-select active">年</span>--}}
                        {{--<span class="btn-select">季</span>--}}
                        {{--<span class="btn-select">月</span>--}}
                    {{--</div>--}}

                    <select class="form-control" style="display: inline-block;">
                        <option>2017年</option>

                    </select>
                </div>
                <div id="main6" style="width: 100%;height:200px;"></div>
            </div>
        </div>


        <div class="col-lg-2 col-md-4">
            <div class="info-wrapper">
                <h2 class="title">任务额度、任务完成统计</h2>
                <div class="info-item">
                    <div class="name"></div>
                    <div>总任务额度</div>
                    <div class="price">{{ceil($task->money/100)}}</div>
                </div>
                <div class="info-item">
                    <div class="name color-primary"></div>
                    <div>任务完成额度</div>
                    <div class="price">{{ceil($finish->money/100)}}</div>
                </div>
            </div>
        </div>

    </div>
</div>

<script src="{{asset('r_backend/v2/js/lib/jquery-1.11.3.min.js')}}"></script>
<script src="{{asset('r_backend/v2/js/lib/echarts.js')}}"></script>
<script src="{{asset('r_backend/v2/js/echartsmap.js')}}"></script>
<script src="{{asset('r_backend/v2/js/lib/bootstrap.min.js')}}"></script>
<script src="{{asset('r_backend/v2/js/common_backend.js')}}"></script>
<script src="{{asset('r_backend/v2/js/index.js')}}"></script>
<script>
    //保费、件数
    $("#premium_date").change(function(){
        time = $("#premium_date").val();
        $.ajax({
            type: "GET",
            url: "/backend/statistics",
            data: "time="+time,
            success: function(msg){
                one(msg)
            }
        });

        //保费的饼图
        $.ajax({
            type: "GET",
            url: "/backend/safe",
            data: "time="+time,
            success: function(msg){
                two(msg)
            }
        });
    })

    //佣金
    $("#twoTime").change(function(){
        towTime = $("#twoTime").val();

        $.ajax({
            type: "GET",
            url: "/backend/brokerage",
            data: "time="+towTime,
            success: function(msg){
                Three(msg)
            }
        });

        $.ajax({
            type: "GET",
            url: "/backend/PieChart",
            data: "time="+towTime,
            success: function(msg){
                Four(msg)
            }
        });

    })

//   人均保费、客户数
    $("#userTime").change(function(){
        userTime = $("#userTime").val();

        $.ajax({
            type: "GET",
            url: "/backend/average",
            data: "time="+userTime,
            success: function(msg){
                five(msg)
            }
        });

//        $.ajax({
//            type: "GET",
//            url: "/backend/customer",
//            data: "time="+userTime,
//            success: function(msg){
//
//                six(msg)
//            }
//        });

    })

    $("#agentTime").change(function(){
        time = $("#agentTime").val();

        $.ajax({
            type: "GET",
            url: "/backend/average",
            data: "time="+time,
            success: function(msg){
                seven(msg)
            }
        });

    })




</script>
@stop