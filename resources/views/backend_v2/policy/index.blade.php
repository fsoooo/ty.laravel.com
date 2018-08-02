@extends('backend_v2.layout.base')
@section('title')@parent 保单管理 @stop
@section('head-more')
	<link rel="stylesheet" href="{{asset('r_backend/v2/css/agent.css')}}" />
	<link rel="stylesheet" href="{{asset('r_backend/v2/css/download.css')}}" />
@stop
@section('top_menu')
	@if(Auth::guard('admin')->user()->email==config('manager_account.manager'))
	<div class="nav-top-wrapper fl">
		<ul>
			<li class="active">
				<a href="{{url('/backend/policy/')}}" >个人保单</a>
			</li>
			<li>
				<a href="{{url('/backend/policy/policy_company/')}}">企业保单</a>
			</li>
			<li>
				<a href="{{url('/backend/policy/policy_offline/')}}">线下保单</a>
			</li>
		</ul>
	</div>
	@endif
@stop
@section('main')

		<div id="product" class="main-wrapper">
			<div class="row">
				<div class="select-wrapper radius">
					<form role="form" class="form-inline radius">
						<div class="form-group">
							<div class="select-item">
								<label for="name">保单状态:</label>
								<select class="form-control" id="search_status">
									<option selected value="-1">全部保单</option>
									<option value="1" @if(isset($status_id) && $status_id == 1) selected @endif>保障中</option>
									<option value="2" @if(isset($status_id) && $status_id == 2) selected @endif>失效</option>
									<option value="0" @if(isset($status_id) && $status_id == 0 && $status_id != "") selected @endif>待生效</option>
									<option value="3" @if(isset($status_id) && $status_id == 3) selected @endif>退保</option>
								</select>
							</div>
							<div class="select-item">
								<label for="name">保单来源:</label>
								<select class="form-control" id="search_type">
									<option selected value="-2">全部来源</option>
									<option value="1" @if(isset($deal_type) && $deal_type == 1) selected @endif>线下成交</option>
									<option value="0" @if(isset($deal_type) && $deal_type == 0 && $deal_type != "") selected @endif>线上成交</option>
								</select>
							</div>
							{{--<div class="select-item">--}}
								{{--<label for="name">代理人:</label>--}}
								{{--<select class="form-control" id="agent">--}}
									{{--<option selected value="-2">全部</option>--}}
									{{--@if(isset($data_agent))--}}
										{{--@foreach($data_agent as $v)--}}
											{{--<option @if($v['id'] == $agent) selected @endif value="{{$v['id']}}">{{$v->user['name']}}</option>--}}
										{{--@endforeach--}}
										{{--@endif--}}
								{{--</select>--}}
							{{--</div>--}}
						</div>
						<!--下载保单-->
						<button type="button" class="btn download" data-toggle="modal" data-target="#downloadbd">下载保单</button>
					</form>
				</div>
			</div>

			<div class="row">
				<div class="ui-table table-single-line">
					<div class="ui-table-header radius">
						<span class="col-md-2">保单号</span>
						<span class="col-md-1">保单产生时间</span>
						<span class="col-md-1">保单产品</span>
						<span class="col-md-1">保单状态</span>
						<span class="col-md-1">客户姓名</span>
						<span class="col-md-1">联系方式</span>
						<span class="col-md-1">保费</span>
						<span class="col-md-1">佣金</span>
						<span class="col-md-1">代理人</span>
						<span class="col-md-1">保单来源</span>
						<span class="col-md-1 col-one">操作</span>
					</div>
					<div class="ui-table-body">
						<ul>
							@foreach($list as $value)
								@if(isset($value['warranty'])&&!empty($value['warranty'])
								&&isset($value['warranty_rule_product'])&&!empty($value['warranty_rule_product'])
								&&isset($value['warranty_rule_order'])&&!empty($value['warranty_rule_order']))
								<li class="ui-table-tr">
								<div class="col-md-2">{{$value['warranty']['warranty_code']}}</div>
								<div class="col-md-1">{{$value['warranty']['created_at']}}</div>
								<div class="col-md-1">{{$value['warranty_rule_product']['product_name']}}</div>
								<div class="col-md-1 color-default">
									@if($value->status == 1)
										保障中
									@elseif($value->status == 2)
										失效
									@elseif($value->status == 3)
										退保
									@elseif($value->status == 0)
										待生效
									@endif
								</div>
								<div class="col-md-1">
									{{$value['policy']['name']}}
								</div>
								<div class="col-md-1">
									{{$value['policy']['phone']}}
								</div>
								<div class="col-md-1">
									{{ceil($value['warranty_rule_order']['premium']/100)}}
								</div>
								<div class="col-md-1">
									{{ceil($value['warranty_rule_order']['premium']/100*$value['warranty_product']['base_ratio']/100)}}
								</div>
								<div class="col-md-1">
									@if(isset($value->agent_name)&&!empty($value->agent_name))
										{{$value->agent_name}}
									@elseif($value->deal_type == 0)
											--
									@endif
								</div>
								<div class="col-md-1">
									@if($value->deal_type == 1)
										线下成交
									@elseif($value->deal_type == 0)
										线上成交
									@endif
								</div>
								<div class="col-md-1 text-right">
									<a class="btn btn-primary" href="{{url('backend/policy/policy_details?id='.$value['warranty']['id'])}}">查看详情</a>
								</div>
								</li>
								@endif
							@endforeach

						</ul>
					</div>
				</div>
			</div>

			<div class="row text-center">
				{{ $list->appends(['id' => $status_id,'type'=>$deal_type])->links() }}
			</div>
		</div>
		<!--弹层-->
		<div class="modal modal-label" id="downloadbd">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header notitle">
						<button type="button" class="" data-dismiss="modal" aria-label="Close"><i class="iconfont icon-cancel"></i></button>
					</div>
					{{--<form action="/backend/policy/export_policy_person" method="post" id="download" >--}}
					<div class="modal-body">
						<span class="choose">已选：10份保单</span>
						<span class="title">保单内容</span>
						<form action="/backend/policy/export_policy_person" id="download" method="post">
						<ul class="group-wrapper">
							<li>
								<span class="name">保单号：</span><input name="warranty_code" checked type="checkbox" value="1">
							</li>
							<li>
								<span class="name">代理人：</span><input name="agent" checked type="checkbox" value="1">
							</li>
							<li>
								<span class="name">起保时间：</span><input name="start_time" checked type="checkbox" value="1">
							</li>
							<li>
								<span class="name">代理人佣金：</span><input name="brokerage" checked type="checkbox" value="1">
							</li>
							<li>
								<span class="name">截止时间：</span><input name="end_time" checked type="checkbox" value="1">
							</li>
							<li>
								<span class="name">保单来源：</span><input name="policy_type" checked type="checkbox" value="1">
							</li>
							<li>
								<span class="name">产品名称：</span><input name="product_name" checked type="checkbox" value="1">
							</li>
							<li>
								<span class="name">投保人联系电话：</span><input name="phone" checked type="checkbox" value="1">
							</li>
							<li>
								<span class="name">保费：</span><input name="premium" checked type="checkbox" value="1">
							</li>
							<li>
								<span class="name">订单时间：</span><input name="created_at" checked type="checkbox" value="1">
							</li>
							<li>
								<span class="name">保单状态时间：</span><input name="policy_status" checked type="checkbox" value="1">
							</li>
						</ul>
							<input type="hidden" name="_token" value="{{csrf_token()}}">
							<input type="hidden" name="get" value="{{json_encode($_GET)}}">
						</form>
					</div>
					<div class="modal-footer fr">
						<button class="btn btn-primary">确定下载</button>
					</div>
					{{--</form>--}}
				</div>
			</div>
		</div>
	<input type="hidden" id="status_id" value="{{$status_id}}">
	<input type="hidden" id="deal_type" value="{{$deal_type}}">
@stop
<script src="{{asset('r_backend/v2/js/lib/jquery-1.11.3.min.js')}}"></script>
<script>
	$(function(){
		$("#search_status").change(function(){
			var id = $("#search_status").val();
			var deal_type = $("#deal_type").val();
			var agent = $("#agent").val();
			window.location.href="/backend/policy?id="+id+"&type="+deal_type+"&agent="+agent;
		})
	})

	$(function(){
		$("#search_type").change(function(){
			var status_id = $("#status_id").val();
			var type = $("#search_type").val();
			var agent = $("#agent").val();
			window.location.href="/backend/policy?type="+type+"&id="+status_id+"&agent="+agent;
		})
		$("#agent").change(function(){
			var status_id = $("#status_id").val();
			var type = $("#search_type").val();
			var agent = $("#agent").val();
			window.location.href="/backend/policy?type="+type+"&id="+status_id+"&agent="+agent;
		})
		//确定下载
		$('.group-wrapper input').click(function(){
			var status = $(this).prop('checked');
			var val = status === true ? 1 : 0;
			$(this).val(val);
		})
		$('.btn-primary').click(function(){
			$('.group-wrapper input').each(function(){
				if(!this.checked){
					this.checked = true;
				}
			});
//			var _token = $("input[name='_token']").val();
//			var inputs=$('.group-wrapper').find('input');
//			var _arr=[];
//			for (var i = 0; i < inputs.length; i++) {
//				if(inputs[i].checked){
//					_arr.push(1);
//				}else{
//					_arr.push(0);
//				}
//			}
//			$.ajax({
//				url:'/backend/policy/export_policy_person',
//				type:'post',
//				data:{_token:_token,data:_arr},
//				success:function(res){
//					console.log(res);
//				}
//			})
			$("#download").submit();
		});
	})
</script>
