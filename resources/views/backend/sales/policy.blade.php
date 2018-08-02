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
                                    <li class="active"><a href="{{ url('/backend/sales/policy') }}">保单查看</a></li>
                                    {{--<li><a href="{{ url('/backend/sales/agent') }}">代理人销售额</a></li>--}}
                                    {{--<li><a href="{{ url('/backend/sales/ditch') }}">渠道销售额</a></li>--}}
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
                                                        <th><span>产品名称</span></th>
                                                        {{--<th><span>被保人</span></th>--}}
                                                        <th><span>保单价格</span></th>
                                                        <th><span>保单编号</span></th>
                                                        <th><span>订单编号</span></th>
                                                        <th><span>状态</span></th>
                                                        {{--<th><span>操作</span></th>--}}
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @if( $count == 0 )
                                                        <tr>
                                                        <td colspan="8" style="text-align: center;">暂无产品</td>
                                                        </tr>
                                                    @else
                                                    @foreach ( $policy as $value )
                                                        <tr>
                                                            <td>
                                                                {{ $value->order->product->product_name }}
                                                            </td>
                                                            {{--<td>--}}
                                                                {{--@foreach($value->warranty_recognizee as $item)--}}
                                                                    {{--{{$item->name}}--}}
                                                                {{--@endforeach--}}
                                                            {{--</td>--}}
                                                            <td>
                                                                {{ $value->warranty->premium}}
                                                            </td>
                                                            <td>
                                                                {{$value->warranty->warranty_code}}
                                                            </td>
                                                            <td>
                                                                {{ $value->order->order_code}}
                                                            </td>
                                                            <td>
                                                                @if( $value->warranty->status == 0)
                                                                    待生效
                                                                @elseif($value->warranty->status == 1)
                                                                    保障中
                                                                @elseif($value->warranty->status == 2)
                                                                    失效
                                                                @elseif($value->warranty->status ==3)
                                                                    已退保
                                                                @endif
                                                            </td>
                                                            {{--<td>--}}
                                                                {{--<a href="{{url('/backend/sales/detail/'.$value->ty_product_id)}}">查看详情</a>--}}
                                                            {{--</td>--}}
                                                        </tr>
                                                    @endforeach
                                                    @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div style="text-align: center;">
                                            @if( $count != 0 )
                                                {{ $policy->links() }}
                                            @endif
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

