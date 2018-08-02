@extends('backend_v2.layout.base')
@section('title')@parent 工单管理 @stop
@section('head-more')
	<link rel="stylesheet" href="{{asset('r_backend/v2/css/work.css')}}" />
@stop

@section('top_menu')
	@if(Auth::guard('admin')->user()->email==config('manager_account.manager'))
		<div class="nav-top-wrapper fl">
			@if($status == 1)
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
			@if($status == 1)
				<ol class="breadcrumb col-lg-12">
					<li><a href="/backend/work_order/1">工单管理</a><i class="iconfont icon-gengduo"></i></li>
					<li><a href="/backend/work_order/1">我收到的工单</a><i class="iconfont icon-gengduo"></i></li>
					<li class="active">{{$liability_demand->title}}</li>
				</ol>
			@else
				<ol class="breadcrumb col-lg-12">
					<li><a href="/backend/work_order/1">工单管理</a><i class="iconfont icon-gengduo"></i></li>
					<li><a href="/backend/work_order/2">我发出的工单</a><i class="iconfont icon-gengduo"></i></li>
					<li class="active">{{$liability_demand->title}}</li>
				</ol>
			@endif
		</div>
		<div class="row work-details">
			<div class="col-md-8">
				<div class="ui-table-tr title" style="font-weight: bold;">{{$liability_demand->title}}</div>
				<div class="ui-table-tr">{{$comment->content}}</div>

				<!--已关闭工单不显示start-->
				<div class="ui-table-tr">
					<textarea id="con-replay" class="content"></textarea>
					<div style="margin-top: 20px;">
						<!--我发出的工单显示start-->
						<button class="btn btn-warning" data-toggle="modal" data-target="#close">关闭工单</button>
						<!--我发出的工单显示end-->
						<button id="btn-replay" class="btn btn-primary fr reply" disabled>回复</button>
					</div>
				</div>
				<!--已关闭工单不显示end-->

				<div class="ui-table-tr">
					<h3 class="title color-negative" style="margin-bottom: 20px;">操作轨迹</h3>
					<div class="path-list scroll-pane" style="height: 360px;">
						<ul>
							<li>
								<span class="color-primary vtop">状态</span>
								<p class="text">
									@if($liability_demand->status==1)
										已发送
									@elseif($liability_demand->status==2)
										交流中
									@elseif($liability_demand->status==3)
										{{--已结束 : --}}
										@if($liability_demand->close_status==1)
											已解决
										@elseif($liability_demand->close_status==2)
											无需解决
										@elseif($liability_demand->close_status==3)
											其他原因
											{{$liability_demand->reason}}
										@endif
									@endif
								</p>
								{{--<p class="text"></p>--}}
								<span class="color-negative vtop">{{$liability_demand->updated_at}}</span>
							</li>
							@foreach($content as $value)
								<li>
									<span class="color-default vtop">回复</span>
									<p class="text">{{$value->content}}</p>
									<span class="color-negative vtop">{{$value->created_at}}</span>
								</li>
							@endforeach

						</ul>
					</div>
				</div>
			</div>

			<div class="col-md-4">
				<div class="ui-table-tr info">
					<h3 class="title color-negative">工单信息</h3>
					<ul>
						<li><span class="name">工单号：</span>{{$liability_demand->id}}</li>
						<li><span class="name">创建时间：</span>{{$liability_demand->created_at}}</li>
						<li><span class="name">工单标题：</span>{{$liability_demand->title}}</li>
						<li><span class="name">所属模块：</span>
							@if($liability_demand->module == 1)
								客户
							@elseif($liability_demand->module == 2)
								产品
							@elseif($liability_demand->module == 3)
								计划书
							@elseif($liability_demand->module == 4)
								销售业绩
							@elseif($liability_demand->module == 5)
								销售任务
							@elseif($liability_demand->module == 6)
								活动
							@elseif($liability_demand->module == 7)
								消息
							@elseif($liability_demand->module == 8)
								评价
							@elseif($liability_demand->module == 9)
								账户设置
							@else
								--
							@endif
						</li>
						<li><span class="name">发件人：</span>
							@if($liability_demand->recipient_id == 0)
								业管
							@elseif($liability_demand->recipient_id == -1)
								天眼后台
							@endif
						</li>
						{{--<li><span class="name">所属渠道：</span>渠道名字</li>--}}
					</ul>
				</div>
			</div>
		</div>
	</div>

	<!--我发出的工单显示start-->
	<div class="modal fade" id="close">
		<div class="modal-dialog modal-alert modal-cause">
			<div class="modal-content">
				<div class="modal-header notitle">
					<button type="button" class="" data-dismiss="modal" aria-label="Close"><i class="iconfont icon-cancel"></i></button>
				</div>
				<div class="modal-body">
					<p style="font-size: 16px;text-align: center;">关闭原因</p>
					<div class="cause-wapper">
						<ul class="cause-select">
							<li>
								<label>
									<i class="iconfont icon-weixuan"></i>
									<input hidden type="checkbox" name="cause" value="已解决">
									已解决
								</label>
							</li>
							<li>
								<label>
									<i class="iconfont icon-weixuan"></i>
									<input hidden type="checkbox" name="cause" value="无需解决">
									无需解决
								</label>
							</li>
							<li>
								<label>
									<i class="iconfont icon-weixuan"></i>
									<input hidden type="checkbox" name="cause" id="reason" value="">
									其他原因
								</label>
							</li>
						</ul>
						<textarea class="cause-text" style="display: none" id="content"></textarea>
					</div>
				</div>
				<input type="hidden" name="_token" value="{{csrf_token()}}">
				<div class="modal-footer">
					<button class="btn btn-warning" data-dismiss="modal">否</button>
					<button id="btn-yes" class="btn btn-primary determine" disabled>确定</button>
				</div>
			</div>
		</div>
	</div>
	<input hidden value="{{$liability_demand->recipient_id}}" id="recipient_id">
	<input hidden value="{{$liability_demand->agent_id}}" id="agent_id">
	<input hidden value="{{$liability_demand->id}}" id="liability_demand_id">
	<input hidden value="{{$status}}" id="status">

	<!--我发出的工单显示end-->
	<script src="/r_backend/v2/js/common_backend.js"></script>
	<script type="text/javascript">
		// 关闭工单
		new Check({
			ele: '.cause-select',
			callback: function(e){
				if(e.index == 2){
					$('.cause-text').show();
					$('#btn-yes').prop('disabled',true);
				}else{
					$('.cause-text').hide();
					$('#btn-yes').prop('disabled',false);
				}
			}
		});

		$('.cause-text').bind('input propertychange', function() {
			$('#btn-yes')[0].disabled = !$(this).val();
		});

		// 回复
		$('#con-replay').bind('input propertychange', function() {
			$('#btn-replay')[0].disabled = !$(this).val();

		});
		//回复
		$(function(){
			$(".reply").click(function(){
				content = $(".content").val();
				_token = $("input[name='_token']").val();
				recipient_id = $("#recipient_id").val();
//				agent_id = $("#agent_id").val();
				liability_demand_id = $("#liability_demand_id").val();

				url_status = $("#status").val();//url
				url_id = $("#liability_demand_id").val();//url

				$.ajax({
					url:'/backend/work_order/details/'+url_id+'/'+url_status+'/add_reply',
					type:'post',
					data:{_token:_token,content:content,recipient_id:recipient_id,liability_demand_id:liability_demand_id},
					success:function(res){
						if(res['status'] == 200){
							Mask.alert("成功回复");
							location.href='/backend/work_order/details/'+url_id+"?status="+url_status;
						}else{
							Mask.alert(res['msg']);
						}
					}
				})

			})
		})

		//			关闭
		$(function(){
			$('#btn-yes').on('click',function(){
				_token = $("input[name='_token']").val();
				liability_demand_id = $("#liability_demand_id").val(); //id 也是路由id
				url_status = $("#status").val();//url状态
				url_id = $("#liability_demand_id").val();//url

				var id =$('input[name="cause"]:checked').parents('li').index()+1;
				var val =$('input[name="cause"]:checked').val();
				if(id == 3){
					val = $('.cause-text').val();
				}

				$.ajax({
					url:'/backend/work_order/details/'+liability_demand_id+'/'+url_status+'/add_close',
					type:'post',
					data:{_token:_token,val:val,id:id,liability_demand_id:liability_demand_id},
					success:function(res){
						if(res['status'] == 200){
							Mask.alert("成功关闭");
							location.href='/backend/work_order/details/'+url_id+"?status="+url_status;
						}else{
							Mask.alert(res['msg']);
						}

					}
				})
			});

		})

	</script>
@stop