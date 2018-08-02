

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
            @if($id==1)
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <ol class="breadcrumb">
                            <li><a href="{{ url('/backend') }}">主页</a></li>
                            <li class=""><span>佣金管理</span></li>
                            <li class="active"><span>个人佣金统计</span></li>
                        </ol>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="main-box clearfix" style="min-height: 1100px;">
                            <div class="tabs-wrapper tabs-no-header">
                                <ul class="nav nav-tabs">
                                    {{--<li class="active"><a href="{{ url('/backend/commision/index/1') }}">产品佣金统计</a></li>--}}
                                    <li><a href="{{ url('/backend/commision/index/2') }}">公司佣金统计</a></li>
                                </ul>
            <div class="col-lg-12">
                @include('backend.layout.alert_info')
                <div class="main-box clearfix">

                    <header class="main-box-header clearfix">
                        <h2 class="pull-left">个人佣金统计</h2>
                    </header>
                    <div class="main-box-body clearfix">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th><span>渠道名称</span></th>
                                    <th><span>代理人姓名</span></th>
                                    <th><span>订单金额</span></th>
                                    <th><span>代理人收入</span></th>
                                    <th><span>支付时间</span></th>
                                </tr>
                                </thead>
                                <tbody>
                                @if( $count == 0 )
                                    <tr>
                                        <td colspan="8" style="text-align: center;">暂无佣金列表</td>
                                    </tr>
                                @else
                                    @foreach ( $data as $value )
                                        <tr>
                                            <td>
                                                @if($value->order_brokerage_ditch == null)
                                                    未绑定渠道
                                                @else
                                                    {{ $value->order_brokerage_ditch->name }}
                                                @endif
                                            </td>
                                            <td>
                                                {{ $value->order_brokerage_agents->user->real_name }}
                                            </td>
                                            <td>
                                                ￥{{ $value->order_pay/100 }}
                                            </td>

                                            <td>
                                                {{ $value->user_earnings/100 }}
                                            </td>
                                            <td>
                                                {{ $value->order_brokerage_order->pay_time }}
                                            </td>
                                            <td>
                                                {{ $value->product_name }}
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                        </div>
                        {{--@if( $count != 0 )--}}
                        {{--<div style="text-align: center;">--}}
                            {{--{{ $data->links() }}--}}
                        {{--</div>--}}
                        {{--@endif--}}
                    </div>
                    @elseif($id==2)
                                <div class="tabs-wrapper tabs-no-header">
                            <ul class="nav nav-tabs">
                                {{--<li><a href="{{ url('/backend/commision/index/1') }}">产品佣金统计</a></li>--}}
                                <li class="active"><a href="{{ url('/backend/commision/index/2') }}">公司佣金统计</a></li>
                            </ul>

                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-lg-12">
                                    <ol class="breadcrumb">
                                        <li><a href="{{ url('/backend') }}">主页</a></li>
                                        <li class=""><span>佣金管理</span></li>
                                        <li class="active"><span>公司佣金统计</span></li>
                                    </ol>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="main-box clearfix" style="min-height: 1100px;">
                                        <div class="tabs-wrapper tabs-no-header">
                                            <div class="col-lg-12">
                                                @include('backend.layout.alert_info')
                                                <div class="main-box clearfix">
                    <header class="main-box-header clearfix">
                        <h2 class="pull-left">公司佣金统计</h2>
                    </header>
                        <div class="main-box-body clearfix">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th><span>保单号</span></th>
                                        <th><span>所获佣金</span></th>
                                        <th><span>保单价格</span></th>
                                        <th><span>创建时间</span></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if( $count == 0 )
                                        <tr>
                                            <td colspan="8" style="text-align: center;">暂无佣金列表</td>
                                        </tr>
                                    @else
                                        @foreach ( $data as $value )
                                            <tr>
                                                <td>
                                                    {{ $value->warranty_code }}
                                                </td>
                                                <td>
                                                    ￥{{ ($value->brokerage)/100 }}
                                                </td>
                                                <td>
                                                    ￥{{ ($value->premium)/100 }}
                                                </td>
                                                <td>
                                                    {{ $value->start_time }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                            {{--分页--}}
                            <div style="text-align: center;">
                                @if( $count != 0 )
                                <div style="text-align: center;">
                                    {{ $data->links() }}
                                </div>
                                @endif
                            </div>
                        </div>
                    @endif
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
                                    location.href=period;
                                })
                            })

                        </script>
@stop

