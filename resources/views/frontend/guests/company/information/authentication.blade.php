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
                            <li class="active"><span>认证管理</span></li>
                        </ol>
                        <ul class="nav nav-tabs">
							<li class="active"><a href="#">公司认证</a></li>
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
                                            <th><span>公司名称</span></th>
                                            <th><span>三合一码</span></th>
                                            <th><span>法人姓名</span></th>
                                            <th><span>认证状态</span></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if($math == 0)
                                            <tr>
                                                <td colspan="8">暂无认证记录</td>
                                            </tr>
                                        @else
											<tr>
												<td>{{ $result[0]->name }}</td>
												<td>{{ $result[0]->code}}</td>
												<td>{{$result[0]->boss}}</td>
												@if($result[0]->status == 1)
													<td>未审核</td>
												@elseif($result[0]->status == 2)
													<td>审核通过</td>
												@else
													<td>审核未通过</td>
												@endif
											</tr>
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