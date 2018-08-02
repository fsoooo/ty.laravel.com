@extends('backend_v2.layout.base')
@section('title')@parent 渠道管理 @stop
@section('head-more')
	<link rel="stylesheet" href="{{asset('r_backend/v2/css/channel.css')}}" />
@stop

@section('top_menu')
	<div class="search-wrapper fr">
		<form action='{{url('/backend/sell/ditch_agent/channel')}}' method="get">
			<select class="form-control">
				<option value="0">渠道名称</option>
				{{--@foreach($ditch as $k => $v)--}}
				{{--<option value="{{$v->id}}" @if(isset($id) && $id == $v->id) selected @endif>{{$v->name}}</option>--}}
				{{--@endforeach--}}
			</select>
			<input name="name"/>
			<button class="btn btn-primary"><i class="iconfont icon-sousuo"></i></button>
		</form>
	</div>
@stop
@section('main')
<div class="main-wrapper">
	<div class="row">
		<div class="col-lg-12">
			<div class="select-wrapper radius">
				<div class="form-inline radius">
					<div class="form-group">
						<div class="select-item">
							<label for="name">选择渠道:</label>
							<select class="form-control" id="search_name">
								<option value="0" selected >全部渠道</option>
								@foreach($ditch as $k => $v)
									<option value="{{$v->id}}" @if(isset($id) && $id == $v->id) selected @endif>{{$v->name}}</option>
								@endforeach
							</select>
						</div>
					</div>
					<button class="btn btn-warning fr" data-toggle="modal" data-target="#addStepOne">添加渠道</button>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="ui-table col-lg-12">
			<div class="ui-table-header radius">
				<span class="col-md-2">渠道名称</span>
				<span class="col-md-1">创建时间</span>
				<span class="col-md-1">渠道人数</span>
				<span class="col-md-1">渠道任务</span>
				<span class="col-md-2">任务进度</span>
				<span class="col-md-2">渠道产生佣金</span>
				<span class="col-md-1">代理人产生佣金</span>
				<span class="col-md-2 col-two">操作</span>
			</div>
			<div class="ui-table-body">
				<ul>
					@foreach($channel as $k => $v)
						@php$alen = strlen($v['path']);@endphp

						@if($v->pid == 0)
							<li class="ui-table-tr" data-sort = "{{$v->sort}}" data-pid="{{$v->pid}}" data-id = "{{$v->id}}">
						@else
							<li class="ui-table-tr" data-sort = "{{$v->sort}}" data-pid="{{$v->pid}}" data-id = "{{$v->id}}" style="display: none">
						@endif
							{{--<div class="col-md-1">{{$v->name}}</div>--}}
							<div class="col-md-2">
								<?php echo str_repeat('|——' , $v['sort']) . $v['name'] ?><span class="anima"><i class="iconfont icon-arrow-left-copy"></i></span>
							</div>

							<div class="col-md-1">{{$v->created_at}} </div>
							<div class="col-md-1"> @php echo count($v->agents); @endphp</div>
							<div class="col-md-1">
								@php
								$sum = 0;
								foreach($v->task_detail as $val){
								$sum+=$val->money;

								}
								$result = ceil($sum/100);
								@endphp
								{{$result}}
							</div>
							<div class="col-md-2">
								@php
								$money = 0;
								foreach($v->order_brokerage as $val){
								$money+=$val->order_pay;
								}
								if($result != 0){
								$cash = ceil($money/$result*100);
								}
								@endphp
								@if($result != 0)
									<div class="progress">
										<div class="progress-bar" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="width: {{$cash}}%;"></div>
									</div>
									<span class="color-default">
                                                {{$cash}}%
                                        </span>
								@else
									<div class="progress">
										<div class="progress-bar" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>
									</div>
									<span class="color-default">
                                            0%
                                    </span>
								@endif
							</div>
							<div class="col-md-2">
								@php
								$channel_brokerage = 0;
								foreach($v->order_brokerage as $val){
								$channel_brokerage+=$val->user_earnings;
								}
								@endphp
								{{ceil($channel_brokerage/100)}}

							</div>
							<div class="col-md-1">{{ceil($channel_brokerage/100)}}</div>
							<div class="col-md-2 text-right">
								{{--<button class="btn btn-warning" data-toggle="modal" data-target="#change">佣金设置</button>--}}
								<button class="btn btn-warning son_id" data-toggle="modal" data-target="#addStepOne" son_id="{{$v->id}}">添加子渠道</button>
								<a class="btn btn-primary" href="{{url('/backend/sell/ditch_agent/channel_details?id='.$v->id)}}">查看详情</a>
							</div>
						</li>
					@endforeach
				</ul>
			</div>
			<div class="row text-center">
				{{$channel->appends(['id'=>$id])->links()}}
			</div>
		</div>
	</div>
</div>
<!--添加渠道-->
<div class="modal fade" id="addStepOne" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog modal-step-one" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="" data-dismiss="modal" aria-label="Close"><i class="iconfont icon-guanbi"></i></button>
				<h4 class="modal-title">新增渠道</h4>
			</div>
			<div class="modal-body">
				{{--<form class="form-horizontal">--}}
					<input type="text" class="form-control" id="channel_name" name="channel_name" placeholder="渠道名称">
				{{--</form>--}}
			</div>
			<div class="modal-footer">
				<button id="add" class="btn btn-primary" disabled>下一步</button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="addStepTow" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog modal-step-two" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="" data-dismiss="modal" aria-label="Close"><i class="iconfont icon-guanbi"></i></button>
				<h4 class="modal-title">新建渠道</h4>
			</div>
			<div class="modal-body">
				<div>已添加代理人<span class="tips">0/15</span></div>
				<div class="channel-info">
					<ul></ul>
				</div>
				<div class="form-horizontal">
					<input id="name" type="text" class="form-control" name="agent_name[]" placeholder="姓名">
					<input id="tel" type="text" class="form-control" maxlength="11" name="agent_phone[]" placeholder="手机号">
					<input id="code" type="text" class="form-control" name="agent_code[]" placeholder="工号">
					<button type="button" id="addInfo" class="btn btn-primary" disabled>添加</button>
				</div>
			</div>
			<div class="modal-footer">
				<span id="last" class="btn btn-warning">上一步</span>
				<button id="addchannel" class="btn btn-primary" disabled>完成</button>
			</div>
		</div>
	</div>
</div>

<!--佣金设置-->
<div class="modal fade" id="change" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog  modal-borkerage" role="document">
		<div class="modal-content">
			<div class="modal-header notitle">
				<button type="button" class="" data-dismiss="modal" aria-label="Close"><i class="iconfont icon-cancel"></i></button>
			</div>
			<div class="modal-body">
				<table>
					<tr>
						<th width="96px">缴别</th>
						<th width="176px">初始代理人佣金比</th>
						<th width="76px">设置佣金比</th>
					</tr>
					<tr>
						<td>20年</td>
						<td>30%</td>
						<td><input type="text" />%</td>
					</tr>
					<tr>
						<td>15年</td>
						<td>25%</td>
						<td><input type="text" />%</td>
					</tr>
					<tr>
						<td>10年</td>
						<td>20%</td>
						<td><input type="text" />%</td>
					</tr>
					<tr>
						<td>5年</td>
						<td>20%</td>
						<td><input type="text" />%</td>
					</tr>
					<tr>
						<td>2年</td>
						<td>10%</td>
						<td><input type="text" />%</td>
					</tr>
					<tr>
						<td>趸交</td>
						<td>5%</td>
						<td><input type="text" />%</td>
					</tr>
				</table>
			</div>
			<div class="modal-footer">
				<button id="btn-yes" class="btn btn-primary">确定修改</button>
			</div>
		</div>
	</div>
</div>
<script src="{{asset('r_backend/v2/js/lib/jquery-1.11.3.min.js')}}"></script>
<script src="{{asset('r_backend/v2/js/common_backend.js')}}"></script>
<script src="{{asset('r_backend/v2/js/channel.js')}}"></script>
	<script>
		var channelInfo = [];
		// 进入添加渠道代理人
		$('#add').click(function(){
			var channel_name = $('#channel_name').val();
			channelInfo.push(channel_name);

			$('#addStepOne').modal('hide');
			$('#addStepTow').modal('show');
			$('#add')[0].disabled = true;
		});

		//添加子渠道
		var son_id ="";
		$(".son_id").click(function(){
			obj = $(this);
			son_id = obj.attr("son_id");
		})

		$('#addchannel').click(function(){
			var nameArr = [];
			var codeArr = [];
			var telArr = [];
			$('.channel-info li').each(function(){
				var code = $(this).data('code');
				var tel = $(this).data('tel');
				var name =$(this).data('name');
				nameArr.push(name);
				codeArr.push(code);
				telArr.push(tel);

			});
			var channel = channelInfo[0];

			$.ajax({
				type: "GET",
				url: "/backend/sell/ditch_agent/add_channel",
				data: "nameArr="+nameArr+"&codeArr="+codeArr+"&telArr="+telArr+"&channel="+channel+"&son_id="+son_id,
				success: function(msg) {
					if (msg == 1){
						alert("添加成功");
						$('#addStepTow').modal('hide');
					}else{
						alert("添加失败，请检查手机唯一性");
					}
				}
			});

		})


		$("#search_name").change(function(){
			var id = $("#search_name").val();
			window.location.href="/backend/sell/ditch_agent/channel?id="+id;
		})

	</script>

@stop