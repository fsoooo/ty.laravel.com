@extends('frontend.guests.layout.bases')
@section('content')
    <meta name="_token" content="{{ csrf_token() }}"/>
    <div id="content-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <ol class="breadcrumb">
                            <li><a href="/">主页</a></li>
                            <li class="active"><span>账户管理</span></li>
                        </ol>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="main-box clearfix" style="min-height: 1100px;">
                            <div class="tabs-wrapper tabs-no-header">
                                <ul class="nav nav-tabs">
                                    <li class="active"><a href="#">实名认证信息</a></li>
                                </ul>
                                <div class="tab-content">
                                    @include('backend.layout.alert_info')
                                    <div class="tab-pane fade in active" id="tab-accounts">
                                        <h3><p>账户信息</p></h3>
                                        <div class="panel-group accordion" id="account">
                                            <div class="panel panel-default">
                                                <form action="{{ url('/information/change_information_submit') }}"  method="post" id="change-information-form">
                                                    {{ csrf_field() }}
                                                <table id="user" class="table table-hover" style="clear: both">
                                                    <tbody>
                                                    <tr>
                                                        <td width="15%">真实姓名</td>
                                                        <td width="65%">

                                                        </td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td>证件类型</td>
                                                        <td>

                                                        </td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td>证件号码</td>
                                                        <td>

                                                        </td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td>证件上传</td>
                                                        <td>
                                                            <a>身份证图片示例</a>
                                                        </td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td></td>
                                                        <td>

                                                        </td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td></td>
                                                        <td>

                                                        </td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td></td>
                                                        <td>

                                                        </td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2" style="text-align: center;"><input type="button" id="change-information-btn" class="btn btn-success" value="确认修改"></td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                                </form>
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

