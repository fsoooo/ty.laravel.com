@extends('frontend.guests.layout.bases')
@section('content')
    <div id="content-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <ol class="breadcrumb">
                            <li><a href="#">前台</a></li>
                            <li class="active"><span>发起理赔</span></li>
                        </ol>
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
                                            <th><span>理赔状态</span></th>
                                            <th><span>保单状态</span></th>
                                            <th><span>创建时间</span></th>
                                            <th><span>查看详情</span></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ( $list as $value )
                                            <tr>
                                                <td>
                                                    <a href="#">{{ $value->warranty_code }}</a>
                                                </td>
                                                <td>
                                                    @if($value->claim_type == 0)
                                                        <a href="/claim/claim/{{ $value->id }}">线上理赔</a>
                                                    @else
                                                        <a href="/claim/claim/{{ $value->id }}">线下理赔</a>
                                                    @endif
                                                </td>
                                                <td>
                                                    {{--{{ $value->warranty_status->status_name }}--}}
                                                </td>
                                                <td>
                                                    <a href="#">{{ $value->created_at }}</a>
                                                </td>
                                                <td>
                                                    查看详情
                                                </td>
                                            </tr>
                                        @endforeach
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