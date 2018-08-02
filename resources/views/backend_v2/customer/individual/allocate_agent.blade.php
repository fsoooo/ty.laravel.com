@extends('backend_v2.layout.base')
@section('title')@parent 代理商详情 @stop
@section('head-more')
	<meta name="csrf-token" content="{{ csrf_token() }}" />
	<link rel="stylesheet" href="{{asset('r_backend/v2/css/client.css')}}" />
@stop

@section('top_menu')
	@include('backend_v2.client.top_client')
	<div class="search-wrapper fl">
		<select class="form-control">
			<option>姓名</option>
			<option>2016年</option>
			<option>2015年</option>
			<option>2014年</option>
			<option>2013年</option>
		</select>
		<input />
		<button class="btn btn-primary"><i class="iconfont icon-sousuo"></i></button>
	</div>
@stop

@section('main')
	<div id="agent" class="main-wrapper">
		<div class="row">
			<ol class="breadcrumb col-lg-12">
				<li><a href="#">客户管理</a><i class="iconfont icon-gengduo"></i></li>
				<li><a href="#">个人客户</a><i class="iconfont icon-gengduo"></i></li>
				<li><a href="#">田小田</a><i class="iconfont icon-gengduo"></i></li>
				<li class="active">分配代理人</li>
			</ol>
		</div>

		<div class="row">
			<div class="ui-table">
				<div class="ui-table-header radius">
					<span class="col-md-1">工号</span>
					<span class="col-md-1">姓名</span>
					<span class="col-md-2">
							<select class="form-control" id="select-ditch">
								@foreach($ditches as $ditch)
									<option value="{{ $ditch->id }}"
											@if($ditch_id == $ditch->id) selected @endif
									>{{ $ditch->name }}</option>
								@endforeach
							</select>
						</span>
					<span class="col-md-2">实名状态</span>
					<span class="col-md-3">客户人数</span>
					<span class="col-md-3 col-one">操作</span>
				</div>
				<div class="ui-table-body">
					<ul>
						@foreach($agents as $agent)
							<li class="ui-table-tr">
								<div class="col-md-1">{{ $agent->job_number }}</div>
								<div class="col-md-1 color-default">{{ $agent->name }}</div>
								<div class="col-md-2">{{ $agent->name }}</div>
								<div class="col-md-2 color-primary"><i class="iconfont icon-shiming"></i>{{ $agent->certification_status }}</div>
								<div class="col-md-3 color-default">{{ $agent->cust_count }}</div>
								<div class="col-md-3 text-right">
									<button class="btn btn-primary choose-button" data-value="{{ $agent->id }}">选择</button>
								</div>
							</li>
						@endforeach
					</ul>
				</div>
			</div>
		</div>
	</div>
	<script src="{{asset('r_backend/v2/js/lib/jquery-1.11.3.min.js')}}"></script>
	<script src="{{asset('r_backend/v2/js/lib/echarts.js')}}"></script>
	<script src="{{asset('r_backend/v2/js/lib/bootstrap.min.js')}}"></script>
	<script src="{{asset('r_backend/v2/js/common_backend.js')}}"></script>
	<script>
        $(function () {
            $('#select-ditch').on('change', function () {
                location.href = '?ditch_id=' + $(this).val();
            });
            $('.choose-button').on('click', function () {
                var user_id = '{{ $user_id }}';
                var agent_id = $(this).attr('data-value');
                $.ajax({
					url: '/backend/customer/individual/allocate_agent',
                    data: {
                        user_id: user_id,
                        agent_id: agent_id
					},
					type: 'post',
					headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
					success: function (result) {
                        if (result.code == 0) {
                            Mask.alert('分配成功');
                            location.href = '{{ route('backend.customer.individual.index') }}';
                        } else {
                            alert(result.content);
                        }
                    },
					error: function (XMLHttpRequest, textStatus, errorThrown) {
					    console.log(XMLHttpRequest.responseJSON.content);
					}
				});
			});
        });
	</script>
@stop