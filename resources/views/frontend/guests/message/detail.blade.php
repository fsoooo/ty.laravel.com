@extends('frontend.guests.layout.bases')
@section('content')
    <meta name="_token" content="{{ csrf_token() }}"/>
    <div id="content-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <ol class="breadcrumb">
                            <li><a href="#">前台</a></li>
                            <li class="active"><span>站内信</span></li>
                        </ol>
                        <h1>站内信详情</h1>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="main-box clearfix">
                            <ul class="nav nav-tabs">
                                <li><a href="{{ url('/message/get_unread') }}">未读</a></li>
                                <li><a href="{{ url('/message/get_read') }}">已读</a></li>
                                <li class="active"><a href="#}">站内信详情</a></li>
                            </ul>
                            <header class="main-box-header clearfix">
                                <h2></h2>
                            </header>
                            <div class="main-box-body clearfix">
                                <div class="table-responsive">
                                    <table id="user" class="table table-hover" style="clear: both">

                                        <tr>
                                           <td>站内信标题</td>
                                           <td>{{ $detail->title }}</td>
                                        </tr>
                                        <tr>
                                            <td>发送人</td>
                                            <td>
                                                @if($detail->message_rule[0]->send_id == 0)
                                                    系统管理员
                                                @else
                                                    {{ $detail->message_rule[0]->user->name }}
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>发送时间</td>
                                            <td>{{ date('Y-m-d H:i:s',$detail->message_rule[0]->read_time) }}</td>
                                        </tr>
                                        <tr>
                                            <td>站内信内容</td>
                                            <td>{{ $detail->content }}</td>
                                        </tr>

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