@extends('frontend.agents.layout.agent_bases')
<link rel="stylesheet" type="text/css" href="{{asset('r_backend/css/libs/nifty-component.css')}}"/>
@section('content')
    <meta name="_token" content="{{ csrf_token() }}"/>
    <style>
        th,td{
            text-align: center;
        }
    </style>
    <div id="content-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <ol class="breadcrumb">
                            <li><a href="/agent/">主页</a></li>
                            <li><a href="#">订单及任务管理</a></li>
                            <li class="active"><span>任务进度查询</span></li>
                        </ol>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="main-box clearfix" style="min-height: 1100px;">
                            <div class="tabs-wrapper tabs-no-header">
                                <ul class="nav nav-tabs">
                                    {{--<li><a href="{{ url('/agent_task/index/all') }}">查询任务</a></li>--}}
                                    <li class="active"><a href="#">任务进度查询</a></li>
                                </ul>
                                <div class="tab-content">
                                    @include('frontend.agents.layout.alert_info')
                                    @if($count == 0)
                                        <h3>
                                            <p>暂无该类型任务</p>
                                            <span style="position: absolute;right: 50px;top: 60px;">
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-link dropdown-toggle" data-toggle="dropdown" >任务类别
                                                        <span class="caret"></span>
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li>
                                                            <a href="{{ url('agent_task/progress/all') }}"></a>
                                                        </li>
                                                        <li>
                                                            <a href="{{ url('agent_task/progress/month') }}">月任务</a>
                                                        </li>
                                                        <li>
                                                            <a href="{{ url('agent_task/progress/quarter') }}">季度任务</a>
                                                        </li>
                                                        <li>
                                                            <a href="{{ url('agent_task/progress/year') }}">年任务</a>
                                                        </li>
                                                        <li>
                                                            <a  id="other-time">其他时间</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </span>
                                        </h3>
                                    @else
                                        <div class="tab-pane fade in active" id="tab-accounts">
                                        <h3>
                                            <p>{{ $task_detail->name }} 进度查询</p>
                                            <span style="position: absolute;right: 50px;top: 60px;">
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-link dropdown-toggle" data-toggle="dropdown" >任务类别
                                                        <span class="caret"></span>
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li>
                                                            <a href="{{ url('agent_task/progress/all') }}"></a>
                                                        </li>
                                                        <li>
                                                            <a href="{{ url('agent_task/progress/month') }}">月任务</a>
                                                        </li>
                                                        <li>
                                                            <a href="{{ url('agent_task/progress/quarter') }}">季度任务</a>
                                                        </li>
                                                        <li>
                                                            <a href="{{ url('agent_task/progress/year') }}">年任务</a>
                                                        </li>
                                                        <li>
                                                            <a  id="other-time">其他时间</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </span>
                                        </h3>
                                            @foreach($task_condition as $values)
                                            <div class="panel-group accordion" id="account">
                                            <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    <h4 class="panel-title">
                                                        <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion2" href="#account-message">
                                                            @if($values->task_condition_type == 1)
                                                                计算折标率
                                                            @else
                                                                不计算折标率
                                                            @endif
                                                        </a>
                                                    </h4>
                                                </div>
                                                <div id="account-message" class="panel-collapse ">
                                                    <form onsubmit="return false;" id="inquire-form">
                                                        {{ csrf_field() }}
                                                        <table id="user" class="table table-hover" style="clear: both">
                                                            <tbody>

                                                                <tr>
                                                                    <td width="30%">产品要求</td>
                                                                    @if($values->product_id != 0)
                                                                        <td>{{ $values->task_product->product_name }}</td>
                                                                    @else
                                                                        <td>无要求</td>
                                                                    @endif
                                                                </tr>

                                                                <tr>
                                                                    <td>地区要求</td>
                                                                    @if($values->area_id != 0)
																		@if($values->area_id == 1)
                                                                    		<td>北京</td>
																		@elseif($values->area_id == 2)
																			<td>上海</td>
																		@else
																			<td>杭州</td>
																		@endif
                                                                    @else
                                                                    <td>无要求</td>
                                                                    @endif
                                                                </tr>
                                                                <tr>
                                                                    <td>金额要求</td>
                                                                    <td>{{ $values->sum/100 }} 元</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>已完成</td>
                                                                    <td>{{ $values->progress/100 }} 元</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                            @endforeach
                                    </div>
                                @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="/js/jquery-3.1.1.min.js"></script>
    <script charset="utf-8" src="/r_backend/js/modernizr.custom.js"></script>
    <script charset="utf-8" src="/r_backend/js/classie.js"></script>
    <script charset="utf-8" src="/r_backend/js/modalEffects.js"></script>
    <script>
        $(function(){
            //通过选择产品进行渠道查询
            var choose_product = $('#choose-product');
            var choose_ditch = $('#choose-ditch');
            choose_product.change(function () {
                var str = '<option value="">选择渠道</option>';
                var choose_product_val = $('#choose-product option:selected').val();
                console.log(choose_product_val);
                if(choose_product_val == 0){
                    choose_ditch.html(str);
                }else{
                    $.ajax({
                        type: "post",
                        dataType: "json",
                        async: true,
                        //修改的地址，
                        url: "/agent_brokerage/get_ditch_ajax",
                        data: 'product_id='+choose_product_val,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                        },
                        success: function(data){
                            var status = data['status'];
                            if(status == 200){
                                var _data = data['data'];
                                var len = _data.length;
                                for(var i = 0;i<len;i++){
                                    str += '<option value="'+_data[i].id+'">'+_data[i].name+'</option>'
                                }
                                choose_ditch.html(str);
                            }
                        },error: function () {
                            alert('错误');
                        }
                    });
                }
            })

            var inquire_btn = $('#inquire-btn');
            var rate_result = $('#rate-result');
            var rate_result_block = $('#rate-result-block');
            var rate_content = $('#rate-content');
            rate_result.click(function () {
                rate_result.removeClass('md-show');
            })
            rate_result_block.click(function()
            {
                rate_result.removeClass('md-show');
            })
            inquire_btn.click(function () {
                var choose_product_val = $('#choose-product option:selected').val();
                var choose_ditch_val = $('#choose-ditch option:selected').val();
                var choose_product_html = $('#choose-product option:selected').html();
                var choose_ditch_html = $('#choose-ditch option:selected').html();
                if(choose_product_val == 0||choose_ditch_val == 0){
                    alert('请选择参数');
                    return false;
                }
                $.ajax({
                    type: "post",
                    dataType: "json",
                    async: true,
                    //修改的地址，
                    url: "/agent_brokerage/inquire_rate",
                    data: 'product_id='+choose_product_val+'&ditch_id='+choose_ditch_val,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    success: function(data){
                        var status = data['status'];
                        if(status == 200){
//                        rate_result.modal().show();
                            rate_result.addClass('md-show');
                            var str = '产品 '+choose_product_html+' 在渠道 '+choose_ditch_html+' 中的佣金比率是 '+data['data']+'%';
                            rate_content.html(str);
                        }else{
                            alert(data['data']);
                        }
                    },error: function () {
                        alert('错误');
                    }
                });
            })
        })







    </script>
@stop

