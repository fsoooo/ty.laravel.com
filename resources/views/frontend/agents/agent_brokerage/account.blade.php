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
                            <li><a >佣金管理</a></li>
                            <li class="active"><span>账户详情</span></li>
                        </ol>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="main-box clearfix" style="min-height: 1100px;">
                            <div class="tabs-wrapper tabs-no-header">
                                <ul class="nav nav-tabs">
                                    <li class="active"><a href="{{ url('/agent_brokerage/brokerage_statistics') }}">账户详情</a></li>
                                    <li><a href="{{ url('/agent_brokerage/no_settlement_order') }}">未结算任务</a></li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane fade in active" id="tab-accounts">
                                        @include('frontend.agents.layout.alert_info')
                                        <h3><p>我的佣金</p></h3>
                                        <div class="panel-group accordion" id="account">
                                            <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    <h4 class="panel-title">
                                                        <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion2" href="#account-message">
                                                            账户余额
                                                        </a>
                                                    </h4>
                                                </div>
                                                <div id="account-message" class="panel-collapse ">
                                                    <form onsubmit="return false;" id="inquire-form">
                                                        {{ csrf_field() }}
                                                        <table id="user" class="table table-hover" style="clear: both">
                                                            <tbody>
                                                                <tr>
                                                                    <td width="20%">账户余额</td>
                                                                    <td id="task_name" index="asd">
                                                                        {{ $brokerage->sum/100 }} 元
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <h3><p>余额收支明细</p></h3>
                                        <div class="panel-group accordion" id="bill">
                                            <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    <h4 class="panel-title">
                                                        <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion1" href="#product-list" >
                                                            收支明细
                                                        </a>
                                                    </h4>
                                                </div>
                                                <div id="product-list" class="panel-collapse ">
                                                    <div class="panel-body" style="padding-bottom: 0">
                                                        <table id="product" class="table table-hover" style="clear: both">
                                                            <thead>
                                                                <th>操作时间</th>
                                                                <th>金额</th>
                                                                <th>操作类型</th>
                                                                <th>余额</th>
                                                                <th>操作</th>
                                                            </thead>
                                                            <tbody>
                                                            @if($count == 0)
                                                                <tr>
                                                                    <td colspan="6">
                                                                        暂无操作记录
                                                                    </td>
                                                                </tr>

                                                            @else
                                                                @foreach($brokerage_detail as $value)
                                                                    <tr>
                                                                        <td>{{ $value->created_at }}</td>
                                                                        <td>{{ $value->money/100 }}</td>
                                                                        <td>{{ $value->operate }}</td>
{{--                                                                        <td>{{ $value->created_at }}</td>--}}
                                                                        <td>{{ $value->balance/100 }}</td>
                                                                        <td>{{ $value->created_at }}</td>
                                                                    </tr>
                                                                @endforeach
                                                            @endif
                                                            </tbody>
                                                        </table>
                                                        <div style="text-align: center;">
                                                        @if($count != 0)
                                                            {{ $brokerage_detail->links() }}
                                                        @endif
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="md-modal md-effect-8 md-hide" id="rate-result" >
        <div class="md-content">
            <div class="modal-header">
                <button class="md-close close">×</button>
                <h4 class="modal-title">佣金比率查询</h4>
            </div>
            <div class="modal-body" id="rate-content">
            </div>
            <div class="modal-footer" style="text-align: center;">
                <button type="button" class="btn btn-primary">确定</button>
            </div>
        </div>
    </div>
    <div class="md-overlay" id="rate-result-block"></div>
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
                            console.log(data['data']);
                            if(data['data']['scaling'] == 0){
                                var scaling = '无折标率';
                            }else {
                                var scaling = data['data']['scaling']+'%';
                            }
                            var earnings = data['data']['earnings'];
                            var str = '产品 '+choose_product_html+' 在渠道 '+choose_ditch_html+' 中的佣金比率是 '+data['data']['earnings']+'%'+' 折标率是 '+scaling;
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

