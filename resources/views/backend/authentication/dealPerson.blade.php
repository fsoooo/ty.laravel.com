@extends('backend.layout.base')
@section('content')
	<meta name="_token" content="{{ csrf_token() }}"/>
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
							<li><a href="{{ url('/backend') }}">主页</a></li>
							<li ><span>公司认证</span></li>
							<li class="active"><span><a href="#">认证处理</a></span></li>
						</ol>

					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<div class="main-box clearfix" style="min-height: 1100px;">
							<div class="tabs-wrapper tabs-no-header">
								<ul class="nav nav-tabs">
									<li class="active"><a href="#">公司认证信息</a></li>
								</ul>
								<div class="tab-content">
									<div class="tab-pane fade in active" id="tab-accounts">
										@include('backend.layout.alert_info')
										<div class="panel-group accordion" id="operation">
											<div class="panel panel-default">
												<form action="{{ url('/backend/authentication/dealPersonSubmit/'.$id) }}" method="post" id="send-message-form">
													{{ csrf_field() }}
													<table id="user" class="table table-hover" style="clear: both">
														<tbody>
														<tr>
															<td width="15%">姓名</td>
															<td width="60%">
																<input type="text" class="form-control" value="{{$res->name}}" name="name" disabled>
															</td>
														</tr>
														<tr>
															<td width="15%">身份证号</td>
															<td width="60%">
																<input type="text" class="form-control" value="{{$res->code}}"  name="code" disabled>
															</td>
														</tr>
														<tr>
															<td width="15%">认证状态</td>
															<td width="60%">
																@if($res->status == 1)
																<input type="text" class="form-control" value="未处理"  name="boss"disabled>
																	@elseif($res->status == 2)
																	<input type="text" class="form-control" value="认证通过"  name="boss"disabled>
																	@else
																	<input type="text" class="form-control" value="认证未通过"  name="boss"disabled>
																	@endif
															</td>
														</tr>
														<tr>
															<td width="15%">认证结果</td>
															<td width="60%">
																<select name="status" id="inputID" class="form-control">
																	<option value="2"> 通过 </option>
																	<option value="3"> 未通过 </option>
																</select>
															</td>
														</tr>
														</tbody>
													</table>
													<button type="submit" id="send-message-btn" class="btn btn-success" onclick="doLabel()">确认提交</button>
												</form>
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
	</div>
	<script>
        {{--function doLabel(){--}}
            {{--var name = $('#name').val();--}}
            {{--var description = $('#description').val();--}}
            {{--var company_id = "{{env('TY_API_ID', '201706221136503001')}}";--}}
            {{--var url =  "{{url('')}}";--}}
            {{--var params = {company_id:company_id,name:name,description:description,url:url};--}}
            {{--console.log(params);--}}
            {{--$.ajax( {--}}
                {{--type : "get",--}}
                {{--url : 'doaddspecial',--}}
                {{--dataType : 'json',--}}
                {{--data :  params,--}}
                {{--success:function(msg){--}}
                    {{--if(msg.status == 1){--}}
                        {{--alert(msg.message);--}}
                        {{--$('#check').html('<font color="red">'+msg.message+'</font>');--}}
                    {{--}else{--}}
                        {{--alert(msg.message);--}}
                        {{--window.location = location;--}}
                        {{--// $('#check').html('<font color="green">'+msg.message+'</font>');--}}
                    {{--}--}}

                {{--}--}}
            {{--});--}}
        {{--}--}}
	</script>
@stop

