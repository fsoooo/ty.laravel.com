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
                            <li>销售管理</li>
                            <li><a href="{{ url('/agent_sale/product_list') }}">产品列表</a></li>
                            <li class="active"><a href="#">生成我的网站</a></li>
                        </ol>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="main-box clearfix" style="min-height: 1100px;">
                            <div class="tabs-wrapper tabs-no-header">
                                <ul class="nav nav-tabs">
                                    {{--<li><a href="{{ url('/agent_sale/product_list') }}">我的产品</a></li>--}}
                                    {{--<li><a href="{{ url('/agent_sale/plan') }}">计划书管理</a></li>--}}
                                    <li class="active"><a href="#">生成我的网站</a></li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane fade in active" id="tab-accounts">
                                        @include('frontend.agents.layout.alert_info')
                                        <h3><p>网址生成</p></h3>
                                        <div class="panel-group accordion" id="account">
                                            <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    <h4 class="panel-title">
                                                        <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion2" href="#account-message">
                                                            网址生成
                                                        </a>
                                                    </h4>
                                                </div>
                                                <div id="account-message" class="panel-collapse ">
                                                    <form onsubmit="return false;" id="create-url-form">
                                                        {{ csrf_field() }}
                                                        <table id="user" class="table table-hover" style="clear: both">
                                                            <tbody>
                                                                <tr>
                                                                    <td width="20%">产品名</td>
                                                                    <td id="task_name" index="asd">
                                                                        <input type="text" name="product_id" value="{{ $product->id }}" hidden>
                                                                        <input disabled type="text"  name="product_name" value="{{ $product->product_name }}" class="form-control">
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td width="20%">选择渠道</td>
                                                                    <td id="task_name" index="asd">
                                                                        <select name="ditch_id" id="choose-ditch" class="form-control" >
                                                                            <option value="">选择渠道</option>
                                                                            @foreach($ditch as $value)
                                                                                <option value="{{ $value->id }}">{{ $value->name }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </td>
                                                                </tr>

                                                                <tr hidden id="url-result-block">
                                                                    <td>生成的网址是</td>
                                                                    <td>
                                                                        <input id="url-result" type="text" class="form-control" value="">
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="2" style="text-align: center;">
                                                                        <button id="inquire-btn" class="btn btn-success">生成网址</button>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </form>
                                                    <table id="basic" class="table table-hover" style="clear: both">
                                                        <tbody>
                                                        <tr>

                                                        </tr>

                                                        </tbody>
                                                    </table>
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
                <h4 class="modal-title">生成网址</h4>
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
            var form = $('#create-url-form');
            var url_result_block = $('#url-result-block');
            var url_result = $('#url-result');
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
                if(choose_product_val == 0){
                    alert('请选择产品');
                    return false;
                }
                var data = form.serialize();
                $.ajax({
                    type: "post",
                    dataType: "json",
                    async: true,
                    //修改的地址，
                    url: "/agent_sale/create_url_submit",
                    data: data,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    success: function(data){
                        var status = data['status'];
                        if(status == 200){
                            url_result_block.removeAttr('hidden');
                            var str = data['data'];
                            url_result.val(str);
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

