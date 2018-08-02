@extends('frontend.guests.layout.bases')
@section('content')
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
                            <li><a href="#">主页</a></li>
                            <li class="active"><span>需求管理</span></li>
                        </ol>
                        <h1>需求管理</h1>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="main-box clearfix">
                            <ul class="nav nav-tabs">
                                @if($type == 'all')
                                    <li class="active"><a href="{{ url('liability_demand/my_demand/all') }}">全部需求</a></li>
                                    <li><a href="{{ url('liability_demand/my_demand/deal') }}">已处理需求</a></li>
                                    <li><a href="{{ url('liability_demand/my_demand/no_deal') }}">未处理需求</a></li>
                                @elseif($type == 'deal')
                                    <li><a href="{{ url('liability_demand/my_demand/all') }}">全部需求</a></li>
                                    <li class="active"><a href="{{ url('liability_demand/my_demand/deal') }}">已处理需求</a></li>
                                    <li><a href="{{ url('liability_demand/my_demand/no_deal') }}">未处理需求</a></li>
                                @elseif($type == 'no_deal')
                                    <li><a href="{{ url('liability_demand/my_demand/all') }}">全部需求</a></li>
                                    <li><a href="{{ url('liability_demand/my_demand/deal') }}">已处理需求</a></li>
                                    <li class="active"><a href="{{ url('liability_demand/my_demand/no_deal') }}">未处理需求</a></li>
                                @endif
                            </ul>
                            @include('frontend.guests.layout.alert_info')
                            <header class="main-box-header clearfix">

                            </header>
                            <div class="main-box-body clearfix" style="padding-bottom: 0">
                                <div class="table-responsive">
                                    <table id="user" class="table table-hover" style="clear: both">
                                        <thead>
                                        <tr>
                                            <th>需求单号</th>
                                            <th>状态</th>
                                            <th>需求报价</th>
                                            <th>创建时间</th>
                                            <th>查看详情</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @if($count == 0)
                                                <tr>
                                                    <td colspan="5" style="text-align: center;">
                                                        暂无符合条件的需求
                                                    </td>
                                                </tr>
                                            @else
                                                @foreach($demand_list as $value)
                                                    <tr>
                                                        <td>{{ $value->demand_code }}</td>
														@if($value->is_deal == 1)
                                                        	<td>已处理</td>
														@else
															<td>未处理</td>
														@endif
                                                        @if($value->offer)
                                                            <td>{{ $value->offer }}</td>
                                                        @else
                                                            <td>暂无报价</td>
                                                        @endif
                                                        <td>{{ $value->created_at }}</td>
                                                        <td><a href="{{ url('/demand/'.$value->demand_code) }}">查看详情</a></td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                    @if($count != 0)
                                        {{ $demand_list->links() }}
                                    @endif
                                </div>
                            </div>
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

@stop