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
                            <li class="active"><span>账户信息</span></li>
                        </ol>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="main-box clearfix" style="min-height: 1100px;">
                            <div class="tabs-wrapper tabs-no-header">
                                <ul class="nav nav-tabs">
                                    <li class="active"><a href="#">账户信息</a></li>
                                </ul>
                                <div class="tab-content">
                                    {{--@include('frontend.layout.alert_info')--}}
                                    @include('frontend.guests.layout.alert_info')
                                    <div class="tab-pane fade in active" id="tab-accounts">
                                        <h3><p>账户信息</p></h3>
                                        <div class="panel-group accordion" id="account">
                                            <div class="panel panel-default">
                                                <table id="user" class="table table-hover" style="clear: both">
                                                    <tbody>
                                                    <tr>
														@if($type == 'company')
                                                        <td width="25%">公司名称</td>
														@else
															<td width="25%">组织/团体名称</td>
														@endif
                                                        <td>
                                                            {{ $information->name }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>电子邮箱</td>
                                                        <td>
                                                            {{ $information->email }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>联系电话</td>
                                                        <td>
                                                            {{ $information->phone }}
                                                        </td>
                                                    </tr>
                                                    <tr>
														@if($type == 'company')
															<td width="25%">公司地址</td>
														@else
															<td width="25%">组织/团体地址</td>
														@endif
                                                        <td>
                                                            {{ $information->address }}
                                                        </td>
                                                    </tr>
                                                    <tr>
														@if($type == 'company')
															<td width="25%">公司三合一码</td>
														@else
															<td width="25%">组织/团体登记证号</td>
														@endif
                                                        <td>{{ $information->code }}</td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                                <button id="operation-btn" class="btn btn-success"><a href="{{ url('/information/change_information') }}" style="color: white">修改信息</a></button>
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

