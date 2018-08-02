@extends('frontend.agents.layout.agent_bases')
@section('content')
    <meta name="_token" content="{{ csrf_token() }}"/>
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
                            <li><a href="/agent/">主页</a></li>
                            <li>客户管理</li>
                            <li ><a href="/agent/apply/record/all"><span>申请记录</span></a></li>
                            @if($type == 'all')
                                <li class="active"><a href="{{ url('/agent/apply/record/all') }}">全部申请</a></li>
                            @elseif($type == 'no_deal')
                                <li class="active"><a href="{{ url('/agent/apply/record/no_deal') }}">未处理</a></li>
                            @elseif($type == 'agree')
                                <li class="active"><a href="{{ url('/agent/apply/record/agree') }}">已同意</a></li>
                            @elseif($type == 'refuse')
                                <li class="active"><a href="{{ url('/agent/apply/record/refuse') }}">已拒绝</a></li>
                            @endif
                        </ol>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="main-box clearfix" style="min-height: 1100px;">
                            <div class="tabs-wrapper tabs-no-header">
                                <ul class="nav nav-tabs">
                                    @if($type == 'all')
                                        <li class="active"><a href="{{ url('/agent/apply/record/all') }}">全部申请</a></li>
                                        <li><a href="{{ url('/agent/apply/record/no_deal') }}">未处理</a></li>
                                        <li><a href="{{ url('/agent/apply/record/agree') }}">已同意</a></li>
                                        <li><a href="{{ url('/agent/apply/record/refuse') }}">已拒绝</a></li>
                                    @elseif($type == 'no_deal')
                                        <li><a href="{{ url('/agent/apply/record/all') }}">全部申请</a></li>
                                        <li class="active"><a href="{{ url('/agent/apply/record/no_deal') }}">未处理</a></li>
                                        <li><a href="{{ url('/agent/apply/record/agree') }}">已同意</a></li>
                                        <li><a href="{{ url('/agent/apply/record/refuse') }}">已拒绝</a></li>
                                    @elseif($type == 'agree')
                                        <li><a href="{{ url('/agent/apply/record/all') }}">全部申请</a></li>
                                        <li><a href="{{ url('/agent/apply/record/no_deal') }}">未处理</a></li>
                                        <li class="active"><a href="{{ url('/agent/apply/record/agree') }}">已同意</a></li>
                                        <li><a href="{{ url('/agent/apply/record/refuse') }}">已拒绝</a></li>
                                    @elseif($type == 'refuse')
                                        <li><a href="{{ url('/agent/apply/record/all') }}">全部申请</a></li>
                                        <li><a href="{{ url('/agent/apply/record/no_deal') }}">未处理</a></li>
                                        <li><a href="{{ url('/agent/apply/record/agree') }}">已同意</a></li>
                                        <li class="active"><a href="{{ url('/agent/apply/record/refuse') }}">已拒绝</a></li>
                                    @endif
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane fade in active" id="tab-accounts">
                                        <h3>
                                            <p>客户信息</p>
                                        </h3>
                                        @include('frontend.agents.layout.alert_info')
                                        <div class="panel-group accordion" id="account">
                                            <div class="panel panel-default">
                                                <table id="user" class="table table-hover" style="clear: both">
                                                    <thead>
                                                    <tr>
                                                        <th><span>客户名称</span></th>
                                                        <th><span>身份标识</span></th>
                                                        <th><span>客户类型</span></th>
                                                        <th><span>申请时间</span></th>
                                                        <th><span>处理结果</span></th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @if($count == 0)
                                                        <tr>
                                                            <td colspan="7" style="text-align: center;">
                                                                暂无客户
                                                            </td>
                                                        </tr>
                                                    @else
                                                        @foreach ( $apply_list as $value )
                                                           <tr>
                                                               <td>{{ $value->cust->name }}</td>
                                                               <td>{{ $value->code }}</td>
                                                               <td>
                                                                   @if($value->type == 0)
                                                                       个人客户
                                                                   @else
                                                                       企业客户
                                                                   @endif
                                                               </td>
                                                               <td>{{ $value->created_at }}</td>
                                                               <td>
                                                               @if($value->status == 0)
                                                                   处理中
                                                               @elseif($value->status == 1)
                                                                   已同意
                                                               @elseif($value->status == 2)
                                                                   已拒绝
                                                               @endif
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
            </div>
            <footer id="footer-bar" class="row">
                <p id="footer-copyright" class="col-xs-12">
                    &copy; 2014 <a href="http://www.adbee.sk/" target="_blank">Adbee digital</a>. Powered by Centaurus Theme.
                </p>
            </footer>
        </div>
    </div>
    <script src="/js/jquery-3.1.1.min.js"></script>
@stop

