@extends('backend_v2.layout.base')
@section('title')@parent 保单管理 @stop
@section('head-more')
<link rel="stylesheet" href="{{asset('r_backend/v2/css/client_details.css')}}" />
@stop
@section('top_menu')
<div class="nav-top-wrapper fl">
	<ul>
		<li>
			<a href="{{url('/backend/policy/')}}" >个人保单</a>
		</li>
		<li>
			<a href="{{url('/backend/policy/policy_company/')}}">企业保单</a>
		</li>
		<li class="active">
			<a href="{{url('/backend/policy/policy_offline/')}}">线下保单</a>
		</li>
	</ul>
</div>
@stop
@section('main')
		<div class="main-wrapper">
			<div class="row">
				<div class="select-wrapper radius">
					<div class="form-inline radius">
						<div class="progress-wrapper">
						@if(!is_null($fileName))
							<label>{{$fileName}}</label>
						@endif
						&nbsp;&nbsp;
						@if(!is_null($percent))
							<div class="progress-content">
								<div class="progress-bar"></div>
							</div>
							<span class="progress-percent">0%</span>
							<input hidden id="percent" value="{{$percent}}"/>
						@endif
						</div>
						<div class="fr">
							<a href="/download/offline_example.xlsx"><button class="btn btn-primary">下载表格</button></a>
							<form id="add" action="/backend/policy/import_offline" method='post' enctype="multipart/form-data" style="display: inline;">
								<input type="hidden" name="_token" value="{{csrf_token()}}" />
								<label for="file" class="btn btn-warning" style="color: #232a4f;line-height: inherit;">上传表格</label>
								<input id="fileSelect" hidden type="file" name="file" accept=".csv, application/vnd.ms-excel, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" />
							</form>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="ui-table table-single-line">
					<div class="ui-table-header radius">
						<span class="col-md-2">上传时间</span>
						<span class="col-md-2">保单生效时间</span>
						<span class="col-md-2">保单号</span>
						<span class="col-md-2">产品名称</span>
						<span class="col-md-1">代理人</span>
						<span class="col-md-1">保单状态</span>
						<span class="col-md-2 col-one">操作</span>
					</div>
					<div class="ui-table-body">
						<ul>
							@foreach($warrantyList as $warranty)
								<li class="ui-table-tr">
									<div class="col-md-2">{{$warranty->created_at}}</div>
									<div class="col-md-2">{{$warranty->start_time}}</div>
									<div class="col-md-2">{{$warranty->warranty_code}}</div>
									<div class="col-md-2">{{$warranty->product_name}}</div>
									<div class="col-md-1">{{$warranty->name}}</div>
									<div class="col-md-1 color-default">
										@if($warranty->status == 0)
											待生效
										@elseif($warranty->status == 1)
											保障中
										@elseif($warranty->status == 2)
											已失效
										@elseif($warranty->status == 3)
											退保
										@else
											---
										@endif
									</div>
									<div class="col-md-2 text-right">
										<a href="/backend/policy/policy_offline_details?warranty_rule_id={{$warranty->id}}" class="btn btn-primary">查看详情</a>
									</div>
								</li>
							@endforeach
						</ul>
					</div>
				</div>
			</div>
			@if(!is_null($list))
			<div class="row text-center">
				{{ $list->links() }}
			</div>
			@endif
		</div>
		<div class="modal fade" id="modal_warning">
			<div class="modal-dialog modal-alert" role="document">
				<div class="modal-content">
					<div class="modal-header notitle">
						<button type="button" class="" data-dismiss="modal" aria-label="Close"><i class="iconfont icon-cancel"></i></button>
					</div>
					<div class="modal-body">
						<i class="iconfont icon-warning"></i>
						<p id="update_msg" style="font-weight: bold;">提示：表格内保单号与历史记录重复</p>
						<p style="font-weight: bold;">是否覆盖？</p>
					</div>
					<div class="modal-footer">
						<a href="/backend/policy/update_offline"><button id="btn_yes" class="btn btn-primary">是</button></a>
						<button class="btn btn-warning" data-dismiss="modal">否</button>
					</div>
				</div>
			</div>
		</div>
		<div class="modal fade" id="modal_success">
			<div class="modal-dialog modal-alert" role="document">
				<div class="modal-content">
					<div class="modal-header notitle">
						<button type="button" class="" data-dismiss="modal" aria-label="Close"><i class="iconfont icon-cancel"></i></button>
					</div>
					<div class="modal-body">
						<i class="iconfont icon-duihao"></i>
						<p>上传成功</p>
					</div>
				</div>
			</div>
		</div>
		<input hidden name="fail_status" value="@if(isset($excelErrorMsg)){{$excelErrorMsg}}@endif"/>
		@if(isset($excelErrorMsg))
		<div class="modal fade" id="modal_fail">
			<div class="modal-dialog modal-alert" role="document">
				<div class="modal-content">
					<div class="modal-header notitle">
						<button type="button" class="" data-dismiss="modal" aria-label="Close"><i class="iconfont icon-cancel"></i></button>
					</div>
					<div class="modal-body">
						<i class="iconfont icon-shibai"></i>
						<p id="fail_msg">上传失败 {{$excelErrorMsg}}</p>
					</div>
					{{--<div class="modal-footer">--}}
						{{--<button id="btn_again" class="btn btn-default">重新上传</button>--}}
					{{--</div>--}}
				</div>
			</div>
		</div>
		@endif
		

		<script src="{{asset('r_backend/v2/js/lib/jquery-1.11.3.min.js')}}"></script>
		<script src="{{asset('r_backend/v2/js/lib/bootstrap.min.js')}}"></script>
		<script src="{{asset('r_backend/v2/js/common_backend.js')}}"></script>
		<script>
            $('#modal_fail').modal('toggle');
			$(function(){
                var percent = $('#percent').val() || false;
                if(percent && percent < 100){
                    var interval = setInterval(function(){
                        $.ajax({
                            type:"get",
                            url:"/backend/policy/check_import_status",
                            // data: {
                            //     "url": data
                            // },
                            success: function(data) {
								// alert(data['percent']);
                                // 调用进度条方法
                                policy_offline.progress(data['percent']);
								if (data['percent'] == 100) {
									clearInterval(interval);
									if (data['update'] > 0) {
										$('#update_msg').text('提示：有 '+ data['update']+'条重复数据');
										$('#modal_warning').modal('toggle'); // 警告模态框
									} else {
										$('#modal_success').modal('toggle'); // 上传成功模态框
									}
								}
                            },
                            error: function() {
                                Mask.alert("网络请求错误!");
                            }
                        });

                    },1000);
                } else if(percent && percent == 100){
                    $.ajax({
                        type:"get",
                        url:"/backend/policy/check_import_status",
                        success: function(data) {
                            // alert(data['percent']);
                            // 调用进度条方法
                            policy_offline.progress(data['percent']);
							if (data['update'] > 0) {
								$('#update_msg').text('提示：有 '+ data['update']+'条重复数据');
								$('#modal_warning').modal('toggle'); // 警告模态框
							} else {
								$('#modal_success').modal('toggle'); // 上传成功模态框
							}
                        },
                        error: function() {
                            Mask.alert("网络请求错误!");
                        }
                    });
				}
				var policy_offline = {
					init: function(){
						var _this = this;
						$('.form-inline .btn-warning').click(function(){
							$('#fileSelect').click();
						});
						$('#fileSelect').on('change',function(){
							$('#add').submit();
							
							
							//$('#modal_warning').modal('toggle'); // 警告模态框
							//$('#modal_success').modal('toggle'); // 上传成功模态框
							//$('#modal_fail').modal('toggle'); // 上传失败模态框
						});
						
						$('#btn_again').click(function(){
							$('#modal_fail').modal('toggle');
							$('#fileSelect').click();
						});
					},
                    progress: function(percent){
                        // 进度条  调用progress(60)
                        if(typeof percent !== 'number'){
                            Mask.alert('进度条调用的值须为数字类型');
                            return;
                        }
                        if(percent>100){return;}
                        $('.progress-bar').width(percent/100*$('.progress-content').width()+'px');
                        $('.progress-percent').text(percent+'%');
                    }
				}
				policy_offline.init();
			})
			
		</script>
@stop