@extends('frontend.guests.layout.bases')
@section('content')
    <style>
        th,td{
            text-align: center;
        }
    </style>
    <meta name="_token" content="{{ csrf_token() }}"/>
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
                                @include('frontend.guests.layout.alert_info')
                            </header>
                            <div class="main-box-body clearfix">
                                <div class="table-responsive">
                                    <table id="user" class="table table-hover" style="clear: both">
                                    <thead>
                                        <tr>
                                            <th>操作人</th>
                                            <th>操作时间</th>
                                            <th>操作内容</th>
                                            <th>操作说明</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @if($count == 0)
                                        <tr style="text-align: center;">
                                            <td colspan="4">暂时没有操作记录</td>
                                        </tr>
                                    @else
                                        @foreach ( $record as $value )
                                            <tr>
                                                <td>
                                                    {{ $value->operation_name }}
                                                </td>
                                                <td>
                                                    {{ $value->created_at }}
                                                </td>
                                                <td>
                                                    {{ $value->status_name }}
                                                </td>
                                                <td>
                                                    {{ $value->claim_remarks }}
                                                </td>
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
    </div>
@stop