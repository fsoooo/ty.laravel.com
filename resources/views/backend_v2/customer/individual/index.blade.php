@extends('backend_v2.layout.base')
@section('title')@parent 客户管理 @stop
@section('head-more')
	<link rel="stylesheet" href="{{asset('r_backend/v2/css/client.css')}}" />
@stop
@section('top_menu')
	@include('backend_v2.customer.top', ['type' => 'user'])
@stop
@section('main')
		<div class="main-wrapper">
			<!--个人客户页面显示-->
			<div class="row">
				<div class="ui-table col-lg-12">
					<div class="ui-table-header radius">
						<span class="col-md-1">客户姓名</span>
						<span class="col-md-1">证件类型</span>
						<span class="col-md-2">证件号</span>
						<span class="col-md-1">
							<select class="form-control" id="choose-status">
								<option value="0" {{ $status == 0 ? 'selected' : '' }}>全部状态</option>
								<option value="2" {{ $status == 2 ? 'selected' : '' }}>已实名</option>
								<option value="1" {{ $status == 1 ? 'selected' : '' }}>未实名</option>
							</select>
						</span>
						<span class="col-md-1">联系方式</span>
						<span class="col-md-1">投保次数</span>
						<span class="col-md-1">产生保费(元)</span>
						<span class="col-md-1">产生佣金(元)</span>
						<span class="col-md-1">代理人</span>
						<span class="col-md-2 col-one">操作</span>
					</div>
					<div class="ui-table-body">
						<ul>
							@foreach($users as $user)
								<li class="ui-table-tr">
									<div class="col-md-1">{{ $user->name }}</div>
									<div class="col-md-1">身份证号</div>
									<div class="col-md-2">{{ $user->code }}</div>
									@if($user->verify == 1)
										<div class="col-md-1 color-negative"><i class="iconfont icon-shiming"></i>已实名</div>
									@else
										<div class="col-md-1 color-negative"><i class="iconfont icon-shiming"></i>未实名</div>
									@endif
									<div class="col-md-1">{{ $user->phone }}</div>
									<div class="col-md-1">{{ $user->insure_count }}</div>
									<div class="col-md-1">{{ $user->premium }}</div>
									<div class="col-md-1">{{ $user->brokerage }}</div>
									<div class="col-md-1">{{ $user->agent_name }}</div>
									<div class="col-md-2 text-right"><a href="{{ route('backend.customer.individual.detail', [$user->id]) }}" class="btn btn-primary">查看详情</a></div>
								</li>
							@endforeach
							@if(count($channel_users)!=0)
								@foreach($channel_users as $user)
									<li class="ui-table-tr">
										<div class="col-md-1">{{ $user->channel_user_name }}</div>
										<div class="col-md-1">身份证号</div>
										<div class="col-md-2">{{ $user->channel_user_code }}</div>
										<div class="col-md-1 color-negative"><i class="iconfont icon-shiming"></i>已实名</div>
										<div class="col-md-1">{{ $user->channel_user_phone }}</div>
										<div class="col-md-1">{{count($user->channelOperateRes)}}</div>
										<div class="col-md-1">{{count($user->channelOperateRes)*2}}</div>
										<div class="col-md-1">{{count($user->channelOperateRes)*2*49/100}}</div>
										<div class="col-md-1">--</div>
										{{--<div class="col-md-2 text-right"><a href="{{ route('backend.customer.individual.channel.detail', [$user->channel_user_code]) }}" class="btn btn-primary">查看详情</a></div>--}}
									</li>
								@endforeach
								@endif
								{{--@if(count($resognizee)!=0)--}}
									{{--@foreach($resognizee as $user)--}}
										{{--<li class="ui-table-tr">--}}
											{{--<div class="col-md-1">{{ $user->name }}</div>--}}
											{{--<div class="col-md-1">身份证号</div>--}}
											{{--<div class="col-md-2">{{ $user->code }}</div>--}}
											{{--<div class="col-md-1 color-negative"><i class="iconfont icon-shiming"></i>已实名</div>--}}
											{{--<div class="col-md-1">--}}
												{{--@if(!empty($user->phone)&&$user->phone!==" ")--}}
												{{--{{$user->phone }}--}}
												{{--@else--}}
													{{------}}
												{{--@endif--}}
											{{--</div>--}}
											{{--<div class="col-md-1">--}}
												{{------}}
											{{--</div>--}}
											{{--<div class="col-md-1">2</div>--}}
											{{--<div class="col-md-1">{{2*49/100}}</div>--}}
											{{--<div class="col-md-1">--</div>--}}
											{{--<div class="col-md-2 text-right"><a href="{{ route('backend.customer.individual.channel.detail', [$user->channel_user_code]) }}" class="btn btn-primary">查看详情</a></div>--}}
										{{--</li>--}}
									{{--@endforeach--}}
								{{--@endif--}}

						</ul>
					</div>
				</div>
			</div>
			<div class="row text-center">
				{{ $channel_users->appends(['status' => $status])->links() }}
			</div>
		</div>
		<script src="{{asset('r_backend/v2/js/lib/jquery-1.11.3.min.js')}}"></script>
		<script src="{{asset('r_backend/v2/js/lib/bootstrap.min.js')}}"></script>
		<script src="{{asset('r_backend/v2/js/common_backend.js')}}"></script>
		<script>
			$(function () {
			    $('#choose-status').on('change', function () {
                    var status = $(this).val();
                    location.href = '?status=' + status;
				});
			});
		</script>
@stop

