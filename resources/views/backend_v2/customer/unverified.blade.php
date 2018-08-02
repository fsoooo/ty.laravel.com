@extends('backend_v2.layout.base')
@section('title')@parent 代理商详情 @stop
@section('head-more')
	<link rel="stylesheet" href="{{asset('r_backend/v2/css/client_details.css')}}" />
@stop

@section('top_menu')
	@include('backend_v2.customer.top', ['type' => 'unverified'])
@stop
@section('main')
<div class="main-wrapper">
	<div class="row">
		<div class="section">
			<div class="col-lg-6 col-xs-6">
				<a href="/backend/customer/unverified" class="section-item active">待实名审核 </a>
			</div>
			<div class="col-lg-6 col-xs-6">
				<a href="/backend/customer/undistributed" class="section-item">分配代理人</a>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="ui-table col-lg-12">
			<div class="ui-table-header radius">
				<span class="col-md-2">客户姓名</span>
				<span class="col-md-2">证件类型</span>
				<span class="col-md-2">证件号</span>
				<span class="col-md-2">联系方式</span>
				<span class="col-md-2">操作类型</span>
				<span class="col-md-1 col-one" style="padding-right: 70px;">操作</span>
			</div>
			<div class="ui-table-body table-single-line">
				<ul>
					@foreach($users as $user)
						<li class="ui-table-tr">
							<div class="col-md-2">{{ $user->name }}</div>
							<div class="col-md-2">身份证</div>
							<div class="col-md-2">{{ $user->code }}</div>
							<div class="col-md-2">{{ $user->phone }}</div>
							<div class="col-md-2">
							@if($user->sattus == 0)
								文件未进行处理
							@elseif($user->status == 1)
								认证失败
							@endif

							</div>
							@if($user->type == "company")
								<div class="col-md-1 text-right"><a href="/backend/customer/company/verification/{{$user->id}}" class="btn btn-primary" style="width: 92px;">查看详情</a></div>
								@elseif($user->type == "user")
								<div class="col-md-1 text-right"><a href="/backend/customer/individual/verification/{{$user->id}}" class="btn btn-primary" style="width: 92px;">查看详情</a></div>
							@endif

						</li>
					@endforeach

				</ul>
			</div>
		</div>
	</div>
		<div class="row text-center">
			{{ $users->links() }}
		</div>
</div>

@stop