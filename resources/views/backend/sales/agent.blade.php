@extends('backend.layout.base')
@section('content')
    <style>
        th{
            text-align: center;
        }
        td{
            text-align: center;
        }
    </style>
    <div id="content-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <ol class="breadcrumb">
                            <li><a href="{{ url('/backend') }}">主页</a></li>
                            <li class="active"><span>销售统计</span></li>
                        </ol>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="main-box clearfix" style="min-height: 1100px;">
                            <div class="tabs-wrapper tabs-no-header">
                                <ul class="nav nav-tabs">
                                    <li><a href="{{ url('/backend/sales/show') }}">产品销售额</a></li>
                                    <li class="active"><a href="{{ url('/backend/sales/agent') }}">代理人销售额</a></li>
                                    <li><a href="{{ url('/backend/sales/ditch') }}">渠道销售额</a></li>
                                </ul>
                                <div class="col-lg-12">
                                    @include('backend.layout.alert_info')
                                    <div class="main-box clearfix">
                                        <header class="main-box-header clearfix">
                                            <h2 class="pull-left">销售统计</h2>
                                        </header>
                                        <div class="main-box-body clearfix">
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <thead>
                                                    <tr>
                                                        <th><span>代理人工号</span></th>
                                                        <th><span>产品名称</span></th>
                                                        <th><span>订单编号</span></th>
                                                        <th><span>订单价格</span></th>
                                                        <th><span>开始时间</span></th>
                                                        <th><span>结束时间</span></th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach ( $agent as $value )
                                                        <tr>
                                                            <td>
                                                                {{ $value->job_number }}
                                                            </td>
                                                            <td>
                                                                {{ $value->product_name }}
                                                            </td>
                                                            <td>
                                                                {{ $value->order_code}}
                                                            </td>
                                                            <td>
                                                                {{ $value->premium}}
                                                            </td>
                                                            <td>
                                                                {{ $value->start_time}}
                                                            </td>
                                                            <td>
                                                                {{ $value->end_time}}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div style="text-align: center;">
                                                {{ $agent->links() }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>




                            <footer id="footer-bar" class="row">
                                <p id="footer-copyright" class="col-xs-12">
                                    &copy; 2014 <a href="http://www.adbee.sk/" target="_blank">Adbee digital</a>. Powered by Centaurus Theme.
                                </p>
                            </footer>
                        </div>
                        <script type="text/javascript" src="{{ URL::asset('js/jquery-3.1.1.min.js') }}"></script>
                        {{--点击查询周期的js--}}
                        <script>
                            $(document).ready(function(){
                                $('#period').change(function(){
                                    var period=$('#period').val();
//                                    alert(period);
                                    location.href=period;
                                })
                            })

                        </script>
@stop

