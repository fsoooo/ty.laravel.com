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
                            <li><a href="#">前台</a></li>
                            <li class="active"><span>个人客户保单管理</span></li>
                        </ol>
                        <h1>个人保单列表</h1>
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="{{ url('/backend/task/index') }}">保单列表</a></li>
                        </ul>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="main-box clearfix">
                            <header class="main-box-header clearfix">
                                <h2></h2>
                                @include('frontend.guests.layout.alert_info')
                            </header>
                            <div class="main-box-body clearfix">
                                <div class="table-responsive">
                                    <table id="user" class="table table-hover" style="clear: both">
                                        <thead>
                                        <tr>
                                            <th><span>保单编号</span></th>
                                            <th><span>开始时间</span></th>
                                            <th><span>结束时间</span></th>
                                            <th><span>创建时间</span></th>
                                            <th><span>查看详情</span></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if($count == 0)
                                            <tr>
                                                <td colspan="5">暂无保单记录</td>
                                            </tr>
                                        @else
                                            @foreach($warranty_list as $value)
                                                <tr>
                                                    <td>{{ $value->warranty_code }}</td>
                                                    <td>{{ $value->start_time }}</td>
                                                    <td>{{ $value->end_time }}</td>
                                                    <td>{{ $value->created_at }}</td>
                                                    <td><a href="{{ url('/user/warranty/detail/'.$value->id) }}">查看详情</a></td>
                                                </tr>
                                            @endforeach
                                        @endif
                                        </tbody>
                                    </table>
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