@extends('frontend.Guestsclaim.base')
@section('content')
    <meta name="_token" content="{{ csrf_token() }}"/>
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('r_backend/css/bootstrap/bootstrap.min.css') }}"/>
    <div id="content-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <ol class="breadcrumb">
                            <li><a href="#">前台</a></li>
                            <li class="active"><span>站内信</span></li>
                        </ol>
                        <h1>站内信列表</h1>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="main-box clearfix">
                            <header class="main-box-header clearfix">
                                <h2></h2>
                            </header>
                            <div class="main-box-body clearfix">
                                <div class="table-responsive">
                                    <table id="user" class="table table-hover" style="clear: both">
                                        <thead>
                                        <tr>
                                            <th>站内信标题</th>
                                            <th>站内信内容</th>
                                            <th>发送人</th>
                                            <th>发送时间</th>
                                            <th>查看详情</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ( $detail as $value )
                                            <tr>
                                                <td>{{ $value->title }}</td>
                                                <td>{{ $value->content }}</td>
                                                {{--<td>--}}
                                                    {{--@if( $value->send_id == 0 )--}}
                                                        {{--<span style="color: green">管理员</span>--}}
                                                    {{--@else--}}
                                                        {{--{{ $value->send_id }}--}}
                                                    {{--@endif--}}
                                                {{--</td>--}}
                                                {{--<td>{{ $value->read_time }}</td>--}}
                                                <td>
                                                    <a href="{{ url('/message/get_detail/'.$value->id) }}">查看详情</a>
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