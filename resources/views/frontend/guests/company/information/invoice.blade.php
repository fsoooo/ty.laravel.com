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
                            <li class="#"><span>企业信息管理</span></li>
                            <li class="active"><span>发票管理</span></li>
                        </ol>
                        <ul class="nav nav-tabs">
							<li class="active"><a href="#">发票列表</a></li>
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
                                            <th><span>收件人</span></th>
                                            <th><span>联系方式</span></th>
                                            <th><span>状态</span></th>
                                            <th><span>地址</span></th>
                                            <th><span>抬头</span></th>
                                            <th><span>发票类型</span></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if($count == 0)
                                            <tr>
                                                <td colspan="8">暂无发票记录</td>
                                            </tr>
                                        @else
                                            @foreach($data as $value)
                                                <tr>
                                                    <td>{{ $value->name }}</td>
                                                    <td>{{ $value->phone}}</td>
													@if($value->status == 1)
                                                    	<td>已发</td>
													@else
														<td>未发</td>
													@endif
                                                    <td>{{$value->address}}</td>
                                                    <td>{{$value->real_name}}</td>
													@if($value->type == 1)
                                                    	<td>普通发票</td>
													@else
														<td style="color: #CCCCCC">专用发票</td>
													@endif
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