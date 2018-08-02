@extends('frontend.guests.layout.bases')
@section('content')

    <style>

    </style>
    <div id="content-wrapper">
        <div class="big-img" style="display: none;">
            <img src="" alt="" id="big-img" style="width: 75%;height: 90%;">
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <ol class="breadcrumb">
                            <li><a href="/">主页</a></li>
                            <li class="active"><span>站内信</span></li>
                            <a href="{{ url('/message/get_unread') }}" id="myMessage"></a>
                        </ol>
                        <h1>未读站内信</h1>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="main-box clearfix" style="min-height: 1100px;">
                            <div class="tabs-wrapper tabs-no-header">
                                <ul class="nav nav-tabs">
                                    <li><a href="{{ url('/message/get_unread') }}">未读</a></li>
                                    <li class="active"><a href="{{ url('/message/get_read') }}">已读</a></li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane fade in active" id="tab-accounts">
                                        @include('frontend.guests.layout.alert_info')
                                        <div class="panel-group accordion" id="operation">
                                            <div class="panel panel-default">
                                                <div class="main-box-body clearfix">
                                                    <div class="table-responsive">
                                                        <table id="user" class="table table-hover" style="clear: both">
                                                            <thead>
                                                            <tr>
                                                                <th>站内信标题</th>
                                                                <th>发送人</th>
                                                                <th>发送时间</th>
                                                                <th>查看详情</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            @if($count == 0)
                                                                <tr>
                                                                    <td colspan="5" style="text-align: center;">
                                                                        暂无新消息
                                                                    </td>
                                                                </tr>
                                                            @else
                                                                @foreach ( $list as $value )
                                                                    <tr>
                                                                        <td>{{ $value->title }}</td>
                                                                        <td>
                                                                            @if( $value->send_id == 0 )
                                                                                <span style="color: green">管理员</span>
                                                                            @else
                                                                                {{ $value->send_id }}
                                                                            @endif
                                                                        </td>
                                                                        <td>{{ date('Y-m-d H:i:s',$value->read_time) }}</td>
                                                                        <td>
                                                                            <a href="{{ url('/message/get_detail/'.$value->id) }}">查看详情</a>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            @endif
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            @if($count != 0)
                                                {{ $list->links() }}
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
        </div>
    </div>
    <script src="/js/jquery-3.1.1.min.js"></script>
    <script>

    </script>
@stop

