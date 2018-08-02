@extends('frontend.guests.layout.bases')
@section('content')
    <meta name="_token" content="{{ csrf_token() }}"/>
    <style>

        a{
            color: white;
            text-decoration: none;
        }
        .line  {
            font-size: 18px;
            line-height: 100%;
            vertical-align: bottom;
        }
        .line-right,.line-left{
            height:60px;
            line-height: 60px;
            display: inline-block;
            vertical-align: middle;
        }
        .line-left{

            width:10%;
            text-align: right;
            /*text-align: justify;*/
            /*text-align-last: justify;*/
            margin-right: 5%;
        }
        .line-right{
            border-bottom: 1px dashed black;
            width: 60%;
        }
        .clearFix{content:".";display:block;height:0;clear:both;visibility:hidden}
    </style>
    <div id="content-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <ol class="breadcrumb">
                            <li><a href="/">主页</a></li>
                            <li class="active"><span>理赔管理</span></li>
                        </ol>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="main-box clearfix" style="min-height: 1100px;">
                            <div class="tabs-wrapper tabs-no-header">
                                <ul class="nav nav-tabs">
                                    <li class="active"><a href="#">理赔信息</a></li>
                                </ul>
                                <div class="tab-content">
                                    @include('frontend.guests.layout.alert_info')
                                    <div class="tab-pane fade in active" id="tab-accounts">
                                        <h3><p>理赔信息</p></h3>
                                        <div class="panel-group accordion" id="account">
                                            <div class="panel panel-default">
                                                <table id="user" class="table table-hover" style="clear: both">
                                                    <tbody>
                                                    <tr>
                                                        <td width="15%">发起理赔方</td>
                                                        <td width="65%">
                                                            {{ $_COOKIE['user_name'] }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>联系方式</td>
                                                        <td>
                                                            {{ $res->phone }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>账户类型</td>
                                                        <td>
                                                            @if($res->account_type=='1')
                                                                银行卡账户
                                                            @elseif($res->account_type=='2')
                                                                支付宝账户
                                                            @else
                                                                微信账户
                                                            @endif
                                                        </td>
                                                    </tr>

                                                    @if($res->account_type=='1')
                                                    <tr>
                                                        <td>银行名称</td>
                                                        <td>
                                                            {{ $res->bank_name }}
                                                        </td>
                                                    </tr>
                                                    @endif
                                                    <tr>
                                                        <td>收款账户</td>
                                                        <td>
                                                            {{ $res->account }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>理赔状态</td>
                                                        <td style="color: green">
                                                            @if($res->status=='0')
                                                                发起理赔成功，等待处理
                                                            @elseif($res->status=='1')
                                                                发起理赔成功，处理成功
                                                            @else
                                                                发起理赔成功，处理失败
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>发起时间</td>
                                                        <td>{{ $res->created_at }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>理赔单据</td>
                                                        <td>
                                                            @foreach($res->claim_url as $v)
                                                            <img src="http://{{$v->claim_url}}" style="width: 320px;height: 155px">
                                                            @endforeach
                                                        </td>
                                                    </tr>
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

            </div>
        </div>
    </div>
    <script src="/js/jquery-3.1.1.min.js"></script>
@stop

