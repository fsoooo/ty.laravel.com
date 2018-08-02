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
                                <li class="active"><a href="{{ url('/backend/sales/show') }}">产品销售额</a></li>
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
                                    <th><span>销售件数（销售量）</span></th>
                                    <th><span>总保费额（总销售额）</span></th>
                                    <th><span>操作</span></th>
                                </tr>
                                </thead>
                                <tbody>
                                {{--@if( $count == 0 )--}}
                                    {{--<tr>--}}
                                        {{--<td colspan="8" style="text-align: center;">暂无产品</td>--}}
                                    {{--</tr>--}}
                                {{--@else--}}
                                    @foreach ( $product_list as $value )
                                        <tr>
                                            <td>
                                                {{ $value->product_name }}
                                            </td>
                                            <td>
                                                {{ $value->p_num}}
                                            </td>
                                            <td>
                                                {{ $value->premium/100}}
                                            </td>
                                            <td>
                                                <a href="{{url('/backend/sales/detail/'.$value->ty_product_id)}}">查看详情</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                {{--@endif--}}
                                </tbody>
                            </table>
                        </div>
                        {{--@if( $count != 0 )--}}
{{--                            {{ $claim->links() }}--}}
                        {{--@endif--}}
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

