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
                            <li class=""><a href="{{url('/backend/sales/index/5')}}"><span>销售统计</span></a></li>
                            <li class="active"><span>销售详情</span></li>
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
                                            <h2 class="pull-left">销售详情</h2>

                                        </header>
                                        <div class="main-box-body clearfix">
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <thead>
                                                    <tr>
                                                        <th><span>投保人</span></th>
                                                        <th><span>被保人姓名</span></th>
                                                        <th><span>与创建者关系</span></th>
                                                        <th><span>被保人的保单编号</span></th>
                                                        <th><span>被保人手机号</span></th>
                                                        <th><span>被保人电子邮箱</span></th>
                                                        <th><span>开始时间</span></th>
                                                        <th><span>结束时间</span></th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @if( $count == 0 )
                                                        <tr>
                                                            <td colspan="8" style="text-align: center;">暂无产品</td>
                                                        </tr>
                                                        @else
                                                            @foreach ($users as $value )
                                                                    <tr>
                                                                <td>
                                                                    @if( $name == 0 )
                                                                        {{ $value->name }}
                                                                    @else
                                                                        {{ $warranty->name }}
                                                                     @endif
                                                                </td>
                                                                <td>
                                                                    {{ $value->name }}
                                                                </td>
                                                                <td>
                                                                    {{ $value->relation}}
                                                                </td>

                                                                <td>
                                                                    {{$value->order_code}}

                                                                </td>
                                                                <td>
                                                                    {{$value->phone}}
                                                                </td>
                                                                <td>
                                                                    {{$value->email}}
                                                                </td>
                                                                <td>
                                                                    {{$value->start_time}}
                                                                </td>
                                                                <td>
                                                                    {{$value->end_time}}
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                            @if( $count != 0 )
                                                <div style="text-align: center;">
                                                    {{ $users->links() }}
                                                </div>
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
                                    location.href=period;
                                })
                            })

                        </script>
@stop

