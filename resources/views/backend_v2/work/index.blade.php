@extends('backend_v2.layout.base')
@section('title')@parent 订单管理 @stop
@section('head-more')
	<link rel="stylesheet" href="{{asset('r_backend/v2/css/work.css')}}" />
@stop

@section('top_menu')
	@if(Auth::guard('admin')->user()->email==config('manager_account.manager'))
			<div class="nav-top-wrapper fl">

				@if($id == 1)
				<ul>
					<li class="active">
						<a href="/backend/work_order/1">我收到的工单</a>
					</li>
					<li>
						<a href="/backend/work_order/2">我发出的工单</a>
					</li>
				</ul>
				@else
					<ul>
						<li>
							<a href="/backend/work_order/1">我收到的工单</a>
						</li>
						<li class="active">
							<a href="/backend/work_order/2">我发出的工单</a>
						</li>
					</ul>
				@endif

			</div>
	@endif
@stop
@section('main')

		<div class="main-wrapper">
			<div class="row">
				<div class="select-wrapper radius">
					<form role="form" class="form-inline radius">
						<div class="form-group">
							<div class="select-item">
								<label for="name">工单状态:</label>

								<select class="form-control status">
									<option value="0" @if(isset($status) && $status ==0) selected @endif>全部状态</option>
									<option value="1" @if(isset($status) && $status ==1) selected @endif>未读</option>
									<option value="2" @if(isset($status) && $status ==2) selected @endif>沟通中</option>
									<option value="3" @if(isset($status) && $status ==3) selected @endif>已关闭</option>
								</select>
							</div>
						</div>
						{{--@if($data == 1)--}}
						{{--<!--我发出的工单显示start-->--}}

						<button type="button" class="btn btn-primary fr" data-toggle="modal" data-target="#add">创建工单</button>
						<!--我发出的工单显示end-->
					</form>
				</div>
			</div>

			<div class="row">
				<div class="ui-table table-single-line">
					<div class="ui-table-header radius">
						<span class="col-md-2">工单号</span>
						<span class="col-md-2">创建时间</span>
						<span class="col-md-2">标题</span>
						<span class="col-md-2">所属模块</span>
						<span class="col-md-1">发送人</span>
						{{--<span class="col-md-1">所属渠道</span>--}}
						<span class="col-md-1">工单状态</span>
						<span class="col-md-2 col-one">操作</span>
					</div>
					<div class="ui-table-body">
						<ul>
							@foreach($data as $v)
							<li class="ui-table-tr">
								<div class="col-md-2">{{$v->id}}</div>
								<div class="col-md-2">{{$v['created_at']}}</div>
								<div class="col-md-2">{{$v->title}}</div>
								<div class="col-md-2">
									@if($v['module'] == 1)
										客户
									@elseif($v['module'] == 2)
										产品
									@elseif($v['module'] == 3)
										计划书
									@elseif($v['module'] == 4)
										销售业绩
									@elseif($v['module'] == 5)
										销售任务
									@elseif($v['module'] == 6)
										活动
									@elseif($v['module'] == 7)
										消息
									@elseif($v['module'] == 8)
										评价
									@elseif($v['module'] == 9)
										账户设置
									@else
										--
									@endif
								</div>
								<div class="col-md-1">
									@if($v['recipient_id'] == 0)
										业管
									@elseif($v['recipient_id'] == -1)
										天眼后台
									@endif
								</div>
								{{--<div class="col-md-1">渠道名字</div>--}}
								<div class="col-md-1">
									@if($v['status'] == 1)
										未读
									@elseif($v['status'] == 2)
										已读
									@elseif($v['status'] == 3)
										已结束
									@else
										--
									@endif

								</div>
								<div class="col-md-2 text-right">
									<a href="/backend/work_order/details/{{$v->id}}?status={{$id}}" class="btn btn-primary">查看详情</a>

								</div>
							</li>
							@endforeach
						</ul>
					</div>
				</div>
			</div>

			<div class="row text-center">
				{{ $data->appends(['status' => $status])->links() }}
{{--				{{ $list->appends(['id' => $status_id])->links() }}--}}
			</div>
		</div>

		<!--我发出的工单显示start-->
		<!--创建工单-->
		<div class="modal fade" id="add">
			<div class="modal-dialog modal-add">
				<div class="modal-content">
					<div class="modal-header notitle">
						<button type="button" class="" data-dismiss="modal" aria-label="Close"><i class="iconfont icon-cancel"></i></button>
					</div>
					<div class="modal-body">
						<div>
							<input type="hidden" name="_token" value="{{csrf_token()}}">
							<label>标题</label><input type="text" id="title"/>
						</div>
						<div>
							<label>模块</label>
							<select class="form-control modular" style="margin-right: 27px;">
								<option value="1">客户</option>
								<option value="2">产品</option>
								<option value="3">计划书</option>
								<option value="4">销售业绩</option>
								<option value="5">销售任务</option>
								<option value="6">活动</option>
								<option value="7">消息</option>
								<option value="8">评价</option>
								<option value="9">账户设置</option>
							</select>
							<label>受理人</label>
							<select class="form-control people">
								<option value="-1">天眼后台</option>
							</select>
						</div>
						<div>
							<label class="vtop">内容</label><textarea id = "content"></textarea>
						</div>
					</div>

					<div class="modal-footer">
						<button id="btn-yes" class="btn btn-primary addWrok" disabled>提交</button>
					</div>
				</div>
			</div>
			<input hidden value="{{$id}}" id="url">

		</div>
		<!--我发出的工单显示end-->

		<script>
			$(function(){
				var Ele = {
					add_input: $('.modal-add input'),
					add_textare: $('.modal-add textarea'),
					btn_yes: $('#btn-yes'),
				}
				$('.modal-add input,.modal-add textarea').bind('input propertychange', function() {
					if(!Ele.add_input.val() || !Ele.add_textare.val()){
						Ele.btn_yes.prop('disabled',true);
					}else{
						Ele.btn_yes.prop('disabled',false);
					}

				});
			})
			//       创建工单
			$(function(){
				$(".addWrok").click(function(){
					modular = $(".modular").val();
					people = $(".people").val();
					content = $("#content").val();
					title = $("#title").val();
					_token = $("input[name='_token']").val();
					url = $("#url").val();

					$.ajax({
						type: "POST",
						url: "/backend/work_order/{id}/add_work",
						data: {_token:_token,modular:modular,people:people,title:title,content:content},
						success: function(msg){
							if(msg['status'] == 200){
								Mask.alert("添加成功");
								location.href='/backend/work_order/'+url;
							}
						}
					});
				})
			})


			// 工单状态
			$(function(){
				$(".status").change(function(){
					status = $(".status").val();
					url = $("#url").val();

					location.href='/backend/work_order/'+url+"?status="+status;

				})
			})

		</script>
@stop
