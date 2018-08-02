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
                            <li class="active"><span>账户信息</span></li>
                        </ol>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="main-box clearfix" style="min-height: 1100px;">
                            <div class="tabs-wrapper tabs-no-header">
                                <ul class="nav nav-tabs">
                                    <li class="active"><a href="{{ url('/backend/claim/get_detail/') }}">账户信息</a></li>
                                </ul>
                                <div class="tab-content">
                                    @include('frontend.guests.layout.alert_info')
                                    <div class="tab-pane fade in active" id="tab-accounts">
                                        <h3><p>账户信息</p></h3>
                                        <div class="panel-group accordion" id="account">
                                            <div class="panel panel-default">
                                                <form action="{{ url('/information/change_information_submit') }}"  method="post" id="change-information-form" enctype="multipart/form-data">
                                                    {{ csrf_field() }}
                                                <table id="user" class="table table-hover" style="clear: both">
                                                    <tbody>
                                                    <tr>
                                                        <td width="15%">法人姓名</td>
                                                        <td width="65%">
                                                            <input type="text" name="name" value="{{ $information->name }}" class="form-control" placeholder="请填写法人姓名">
                                                        </td>
                                                    </tr>
													<tr>
														<td width="15%">法人证件号码</td>
														<td width="65%">
															<input type="text" name="id_code" value="{{ $information->name }}" class="form-control" placeholder="请填写法人证件号码">
														</td>
													</tr>
                                                    <tr>
                                                        <td>公司全称(发票抬头一致)</td>
                                                        <td>
															@if($information->real_name)
                                                            <input type="text" name="real_name" value="{{ $information->real_name }}" class="form-control" disabled>
																@else
																<input type="text" name="real_name" value="" class="form-control" placeholder="请填写公司法人的姓名">
																@endif
														</td>
                                                    </tr>
                                                    <tr>
                                                        <td>电子邮箱</td>
                                                        <td>
                                                            <input type="text" name="email" value="{{ $information->email }}" class="form-control" placeholder="请填写公司邮箱">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>联系电话</td>
                                                        <td>
                                                            <input type="text" value="{{ $information->phone }}" name="phone" class="form-control" placeholder="请填写公司电话">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>公司地址</td>
                                                        <td>
                                                            <input type="text" name="address" value="{{ $information->address }}" class="form-control" placeholder="请填写公司办公地址与公司名称">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>公司三合一码</td>
                                                        <td>
															@if($information->code)
															<input type="text" value="{{ $information->code }}" name="code" class="form-control" disabled>
																@else
																<input type="text" value="" name="code" class="form-control" placeholder="填写公司营业执照上的三合一码">
																@endif
														</td>
                                                    </tr>
													<tr>
														<td>公司营业执照照片</td>
														<td>
															<div class="form-group">
																<label for="exampleInputFile"></label>
																<input type="file" name="license" id="exampleInputFile">
																<p class="help-block">点击上传营业执照的照片</p>
															</div>
														</td>
													</tr>
													<tr>
														<td>公司团险负责人姓名</td>
														<td>
															@if(!$finalData)
																<input type="text" name="ins_principal" value="" class="form-control" placeholder="请填写公司团险负责人的姓名">
															@else
																<input type="text" name="ins_principal" value="{{$finalData->ins_principal}}" class="form-control" placeholder="请填写公司团险负责人的姓名">
															@endif
														</td>
													</tr>
													<tr>
														<td>公司团险负责人联系方式</td>
														<td>
															@if(!$finalData)
																<input type="text" name="ins_phone" value="" class="form-control" placeholder="请填写公司团险负责人的姓名">
															@else
																<input type="text" name="ins_phone" value="{{$finalData->ins_phone}}" class="form-control" placeholder="请填写公司团险负责人的姓名">
															@endif
														</td>
													</tr>
													<tr>
														<td>公司团险负责人身份证号</td>
														<td>
															@if(!$finalData)
																<input type="text" name="ins_principal_code" value="" class="form-control" placeholder="请填写公司团险负责人的姓名">
															@else
																<input type="text" name="ins_principal_code" value="{{$finalData->ins_principal_code}}" class="form-control" placeholder="请填写公司团险负责人的姓名">
															@endif
														</td>
													</tr>
                                                    </tbody>
                                                </table>
                                                </form>
                                                <button id="change-information-btn" class="btn btn-success">修改信息</button>
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
    <script>
        var change_information_btn = $('#change-information-btn');
        var change_information_form = $('#change-information-form');
        change_information_btn.click(function(){
            change_information_form.submit();
        });
    </script>
@stop

