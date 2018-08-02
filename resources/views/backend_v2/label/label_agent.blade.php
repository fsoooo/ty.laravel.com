@extends('backend_v2.layout.base')
@section('title')标签管理-代理人标签 @stop
@section('head-more')
	<link rel="stylesheet" href="{{asset('r_backend/v2/css/label.css')}}" />
@stop
@section('top_menu')
	@include('backend_v2.label.label_top')
@stop
@section('main')
		<div class="main-wrapper">
				
			<div class="row">
				<div class="col-lg-12">
					<div class="label-section label-top" style="height: 80px;line-height: 40px;">
						<button id="editGroup" class="btn btn-primary fr">编辑</button>
						@if(count($label_groups)=='0')
							<i>请添加标签组</i>
						@else
							@foreach($label_groups as $key=>$value)
								@if(isset($_GET['keyword'])&&$value['id']==$_GET['keyword'])
									<span onclick="get_label({{$value['id']}})" class="active">{{$value['name']}}</span>
								@else
									@if(!isset($_GET['keyword'])&&$key=='0')
										<span onclick="get_label({{$value['id']}})" class="active">{{$value['name']}}</span>
									@else
										<span onclick="get_label({{$value['id']}})" >{{$value['name']}}</span>
									@endif
								@endif
							@endforeach
						@endif
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-lg-12">
					<div class="label-section label-middle" style="height: 240px;">
						<div class="label-wrapper">
							@if(count($label_res)=='0')
								<span class="">暂无标签</span>
							@else
								@foreach($label_res as $value)
									<span data-id="{{$value['id']}}">{{$value['name']}}<i class="iconfont icon-quxiao" ></i></span>
								@endforeach
							@endif
						</div>
					</div>
				</div>
			</div>

			<form action="/backend/label/do_add_label" method="post" id="add_label">
				{{ csrf_field() }}
				<input type="hidden" name="label_belong" value="agent">
				@if(isset($_GET['keyword'])&&$_GET['search_type']=='label_group')
					<input type="hidden" name="parent_id" value="{{$_GET['keyword']}}">
				@else
					<input type="hidden" name="parent_id" value="@if(isset($label_groups[0])){{$label_groups[0]['id']}}@endif">
				@endif
				<div class="row">
					<div class="col-lg-12">
						<div class="label-section label-bottom">
							<input type="text" name="label_add" placeholder="请输入标签内容，字数限制在10个字" maxlength="10"/>
							<button id="addLabel" class="btn btn-primary" disabled>确定</button>
						</div>
					</div>
				</div>
			</form>
			
		</div>
		
		
		<div class="modal fade modal-label" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header notitle">
						<button type="button" class="" data-dismiss="modal" aria-label="Close"><i class="iconfont icon-cancel"></i></button>
					</div>
					<div class="modal-body">
						<form action="/backend/label/do_add_label_group" method="post" id="add_label_group">
							{{ csrf_field() }}
							<input type="hidden" name="label_belong" value="agent">
							<ul class="group-wrapper">
								@if(count($label_groups)=='0')
									<li>
										<span class="name">标签组名称：</span><input type="text" value="标签名称">
									</li>
								@else
									@foreach($label_groups as $key=>$value)
										@if($key=='0')
											<li>
												<span class="name">标签组{{$key+1}}：</span>
												<input type="text" name="label_edit[{{$value['id']}}]" value="{{$value['name']}}">
											</li>
										@else
											<li data-id="{{$value['id']}}">
												<span class="name">标签组{{$key+1}}：</span>
												<input type="text" name="label_edit[{{$value['id']}}]" value="{{$value['name']}}">
												<button type="button" class="btn btn-default">删除组</button>
											</li>
										@endif
									@endforeach
								@endif
							</ul>
						</form>
					</div>
					<div class="modal-footer">
						<button id="addGroup" class="btn btn-warning">添加组</button>
						<button id="add" class="btn btn-primary">确定</button>
					</div>
				</div>
			</div>
		</div>
		<script src="{{asset('r_backend/v2/js/lib/jquery-1.11.3.min.js')}}"></script>
		<script src="{{asset('r_backend/v2/js/lib/bootstrap.min.js')}}"></script>
		<script src="{{asset('r_backend/v2/js/label.js')}}"></script>
		<script src="{{asset('r_backend/v2/js/common_backend.js')}}"></script>
		<script>
            function get_label(id) {
                var url = "{{Request::getPathinfo()}}";
                var params = /\?/;
                var result = params.test(url);
                if(result){
                    window.location.href = url+"&"+"search_type=label_group&keyword="+id;
                }else{
                    window.location.href = url+"?search_type=label_group&keyword="+id;
                }
            }
            $('#add').on('click',function () {
                $('#add_label_group').submit();
            })
		</script>
@stop