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
                            <li ><span>售后管理</span></li>
                            <li class="active"><span>理赔</span></li>
                        </ol>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="main-box clearfix">
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#">理赔申请记录</a></li>
                            </ul>
                            <header class="main-box-header clearfix">
                                <h2></h2>
                                @include('frontend.guests.layout.alert_info')
                            </header>
                            <div class="main-box-body clearfix">
                                <div class="table-responsive">
                                    <table id="user" class="table table-hover" style="clear: both">
                                        <thead>
                                        <tr>
                                            <th>订单编号</th>
                                            <th>理赔状态</th>
                                            <th>发起时间</th>
                                            <th>操作</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if( $count == 0 )
                                            <tr>
                                                <td colspan="7" style="text-align: center;">
                                                    暂无理赔记录
                                                </td>
                                            </tr>
                                        @else
                                            @foreach ( $list as $value )
                                                <tr>
                                                    <td>
                                                        {{ $value->order->order_code }}
                                                    </td>
                                                    <td>
                                                        @if(isset($value->get_claim->claim_record->status_name))
                                                        {{$value->get_claim->claim_record->status_name}}
                                                        @else
                                                            理赔提交成功，待审核
                                                        @endif
                                                    </td>
                                                    <td>
                                                        {{ $value->created_at }}
                                                    </td>
                                                    <td>
                                                        @if(isset($value->get_claim->claim_record->status_name))
                                                            @if($value->get_claim->claim_record->status_name)
                                                            <a href="/claim/detail/{{ $value->id }}">查看详情</a>
                                                            @endif
                                                            @else
                                                            <a href="/claim/detail_local/{{ $value->id }}">查看详情</a>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            {{ $list->links() }}
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