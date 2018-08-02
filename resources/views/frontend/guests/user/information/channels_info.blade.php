@extends('frontend.guests.layout.bases')
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
                            <li><a href="/">主页</a></li>
                            <li class="active"><span>渠道用户信息管理</span></li>
                        </ol>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="main-box clearfix" style="min-height: 1100px;">
                            <div class="tabs-wrapper tabs-no-header">
                                <ul class="nav nav-tabs">
                                    <li class="active"><a href="#">渠道用户信息管理</a></li>
                                </ul>
                    <div class="col-lg-12">
                        @include('frontend.guests.layout.alert_info')
                        <div class="main-box clearfix">
                            <header class="main-box-header clearfix">
                            </header>
                            <div class="main-box-body clearfix">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th><span>用户姓名</span></th>
                                            <th><span>身份证号</span></th>
                                            <th><span>联系方式</span></th>
                                            <th><span>个人邮箱</span></th>
                                            <th><span>家庭住址</span></th>
                                            <th><span>注册时间</span></th>

                                            <th><span>渠道名称</span></th>
                                            <th><span>渠道邮箱</span></th>
                                            <th><span>渠道url</span></th>
                                            <th><span>渠道描述</span></th>

                                            {{--<th><span>查看更多</span></th>--}}
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @if($count == 0)
                                                <td colspan="8">暂无修改记录</td>
                                            @else

                                                @foreach($res as $value)
                                                    @if(!is_null($value->channel))
                                                    <tr>
                                                        <td>{{ $value->name }}</td>
                                                        <td>{{ $value->person_code }}</td>
                                                        <td>{{ $value->phone }}</td>
                                                        <td>{{ $value->email }}</td>
                                                        <td>{{ $value->address}}</td>
                                                        <td>{{ $value->created_at}}</td>
                                                        <td>{{ $value->channel->name}}</td>
                                                        <td>{{ $value->channel->email}}</td>
                                                        <td>{{ $value->channel->url}}</td>
                                                        <td>{{ $value->channel->describe}}</td>
{{--                                                        <td><a href="{{ url('/maintenance/change_data_list/'.$value->id) }}">更多</a></td>--}}
                                                    </tr>
                                                    @else
                                                    @endif
                                                @endforeach
                                            @endif

                                        </tbody>
                                    </table>
                                </div>
                                {{--@if( $count != 0 )--}}
                                    {{--{{ $claim->links() }}--}}
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
@stop

