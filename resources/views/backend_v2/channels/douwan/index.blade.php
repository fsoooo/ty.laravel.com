@extends('backend_v2.layout.base')
@section('title')@parent产品管理 @stop
@section('head-more')
	<link rel="stylesheet" href="{{asset('r_backend/v2/css/client_details.css')}}" />
@stop
@section('top_menu')
@stop
@section('main')
		<div class="main-wrapper">
			<!--个人客户页面显示-->
			<div class="row">
				<div class="ui-table col-lg-12">
					<div class="ui-table-header radius">
						<span class="col-md-1">客户姓名</span>
						<span class="col-md-1">证件类型</span>
						<span class="col-md-1">证件号</span>
						<span class="col-md-1">联系方式</span>
						<span class="col-md-1">年龄</span>
						<span class="col-md-1">出生日期</span>
						<span class="col-md-1">性别</span>
						<span class="col-md-1">投保开始时间</span>
						<span class="col-md-1">投保截止日期</span>
						<span class="col-md-1">用户国籍</span>
						<span class="col-md-1">投保状态</span>
						<span class="col-md-1 col-one">操作</span>
					</div>
					<div class="ui-table-body">
						<ul>
							@if(count($channel_res)=='0')
								<li class="ui-table-tr">
									<div class="col-md-1">暂无用户信息</div>
								</li>
							@else
								@foreach($channel_res as $value)
								<li class="ui-table-tr">
									<div class="col-md-1">{{$value['channel_user_name']}}</div>
									@if($value['channel_code_type']=='1')
									<div class="col-md-1">身份证</div>
									@else
									<div class="col-md-1">护照</div>
									@endif
									<div class="col-md-1">{{$value['channel_user_code']}}</div>
									<div class="col-md-1">{{$value['channel_user_phone']}}</div>
									<div class="col-md-1">{{$value['channel_user_age']}}</div>
									<div class="col-md-1">{{$value['channel_user_birthday']}}</div>
									@if($value['channel_user_sex']=='m')
										<div class="col-md-1">男</div>
									@elseif($value['channel_user_sex']=='w')
										<div class="col-md-1">女</div>
									@endif
									<div class="col-md-1">{{$value['insure_start_time']}}</div>
									<div class="col-md-1">{{$value['insure_end_time']}}</div>
									@if(!empty($value['channel_nationality']))
										<div class="col-md-1">{{$value['channel_nationality']}}</div>
									@else
										<div class="col-md-1">中国</div>
									@endif
									@if($value['insure_status']=='1')
										<div class="col-md-1">已投保</div>
									@else
										<div class="col-md-1">未投保</div>
										<div class="col-md-1 text-right"><a href="/backend/channels/douwan/do_insure/{{$value['id']}}" class="btn btn-primary">投保</a></div>
									@endif
								</li>
								@endforeach
							@endif
						</ul>
					</div>
				</div>
			</div>
			<div class="row text-center">
				{{$channel_res->links()}}
			</div>
		</div>
		<script src="{{asset('r_backend/v2/js/lib/jquery-1.11.3.min.js')}}"></script>
		<script src="{{asset('r_backend/v2/js/lib/bootstrap.min.js')}}"></script>
		<script src="{{asset('r_backend/v2/js/common_backend.js')}}"></script>
	@include('backend_v2.layout.alert')
	@stop