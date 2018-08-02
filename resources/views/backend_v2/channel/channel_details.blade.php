@extends('backend_v2.layout.base')
@section('title')@parent 渠道管理 @stop
@section('head-more')
	<link rel="stylesheet" href="{{asset('r_backend/v2/css/channel.css')}}" />
@stop
@section('main')
		<div class="main-wrapper">
			<div class="row">
				<ol class="breadcrumb col-lg-12">
				    <li><a href="#">渠道管理</a><i class="iconfont icon-gengduo"></i></li>
				    <li><a href="#">渠道列表</a><i class="iconfont icon-gengduo"></i></li>
				    <li class="active">渠道详情</li>
				</ol>
			</div>
			<div class="row">
				<div class="section section-5">
					<div class="col-lg-3 col-xs-6">
					 	<a href="{{url('/backend/sell/ditch_agent/channel_details?id='.$id)}}" class="section-item active">渠道详情 </a>
				    </div>
				    <div class="col-lg-3 col-xs-6">
						<a href="{{url('/backend/sell/ditch_agent/channel_record?id='.$id)}}" class="section-item">销售记录 </a>
				    </div>
				    <div class="col-lg-3 col-xs-6">
						<a href="{{url('/backend/sell/ditch_agent/channel_agent?id='.$id)}}" class="section-item">渠道代理人 </a>
				    </div>
				    <div class="col-lg-3 col-xs-6">
						<a href="{{url('/backend/sell/ditch_agent/channel_active?id='.$id)}}" class="section-item">活跃产品 </a>
				    </div>
				    <div class="col-lg-3 col-xs-6">
						<a href="{{url('/backend/task?ditch='.$id)}}" class="section-item">渠道任务</a>
				    </div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<div class="ui-table-tr" style="line-height: 30px;">
						<div class="col-lg-12 color-default">渠道的详细名称</div>
						<div class="col-md-2">创建时间：<span>{{$channel_details->created_at}}</span></div>
						<div class="col-md-2">代理人数：<span>@php echo count($channel_details->agents); @endphp人</span></div>
						<div class="col-md-2">客户人数：<span>{{$user_count}}人</span></div>
						<div class="col-md-2">本月销售额：<span>{{ceil($month_pay->month/1000)}}元</span></div>
						<div class="col-md-2">今年累计销售额：<span>{{$year_pay->year}}元</span></div>
						<button class="btn btn-warning fr" data-toggle="modal" data-target="#change">佣金设置</button>
					</div>
				</div>
			</div>
			<div class="row select-wrapper">
				<div class="col-lg-12">
					<div class="chart-wrapper" style="height: 238px;">
						<div class="chart-header">
							<span class="btn-select active">年</span>
							<span class="btn-select">季</span>
							<select class="form-control fr">
								<option>2017年</option>
								<option>2016年</option>
								<option>2015年</option>
								<option>2014年</option>
								<option>2013年</option>
							</select>
						</div>
						<div id="main" style="width: 96%;height:180px;"></div>
					</div>

				</div>
			</div>
		</div>

		<div class="modal fade in" id="change" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog  modal-borkerage" role="document">
				<div class="modal-content">
					<div class="modal-header notitle">
						<button type="button" class="" data-dismiss="modal" aria-label="Close"><i class="iconfont icon-cancel"></i></button>
					</div>
					<div class="modal-body">
						<ul>
							{{--<li>--}}
								{{--<span class="type">产品分类：</span>--}}
									{{--<select class="form-control" id="search_">--}}
										{{--@foreach($result as $val)--}}
											{{--<option value="">11</option>--}}
										{{--@endforeach--}}
									{{--</select>--}}
							{{--</li>--}}

							<li>
								<span class="name">产品名称：</span>
								<select class="form-control" id="search_name">
									@foreach($result as $val)
										<option value="{{$val->id}}">{{$val->product_name}}</option>
									@endforeach
								</select>
							</li>
							<li>
								<span class="name">代理人：</span>
								<select class="form-control" id="man_id">
									@foreach($man as $value)
										<option value="{{$value->agent_id}}">{{$value->real_name}}</option>
									@endforeach
								</select>
							</li>
						</ul>
						<form action="{{url('/backend/sell/ditch_agent/add_brokerage/')}}" method="get">
						<table>
							<tr>
								<th width="96px">缴别</th>
								<th width="176px">系统收益佣金比</th>
								<th width="76px">设佣金比</th>
							</tr>
							<tbody id="span">
								@foreach($p_brokerage as $val)
									<tr>
										<td>{{$val['by_stages_way']. $val['pay_type_unit']}}</td>
										<td>{{$val['ratio_for_agency']}}%</td>
										<td>
											<input type="text" name="brokerage[]">%
											<input class="ditch-id" name="ditch_id[]" type="hidden" value="{{ $id }}">
											<input class="by-stages-way" name="by_stages_way[]" type="hidden" value="{{$val['by_stages_way']. $val['pay_type_unit']}}">
											<input type="hidden" name="ty_product_id[]" id="ty_product_id" value="">
											<input type="hidden" name="man[]" id="man_agent" value="">
											<input type="hidden" name="ratio_for_agency[]" id="man_agent" value="{{$val['ratio_for_agency']}}">
										</td>
									</tr>
								@endforeach
							</tbody>
							</table>

							<div class="modal-footer">
								<button id="btn-yes" class="btn btn-primary">确定修改</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>

		<input type="text" hidden value="{{$id}}" id="id">
		<input type="hidden" id="task_arr" value="{{ json_encode($task_arr) }}">
		<input type="hidden" id="finish_task_arr" value="{{ json_encode($finish_task_arr) }}">
		<script src="{{asset('r_backend/v2/js/lib/jquery-1.11.3.min.js')}}"></script>
		<script src="{{asset('r_backend/v2/js/lib/echarts.js')}}"></script>
		<script src="{{asset('r_backend/v2/js/lib/bootstrap.min.js')}}"></script>
		<script src="{{asset('r_backend/v2/js/common_backend.js')}}"></script>
		<script>
			var task = $("#task_arr").val();
			task = JSON.parse(task);
			var task_array =  new Array();
			for(var i in task){
				task_array[i] = task[i];
			}
			var finish_task = $("#finish_task_arr").val();
			finish_task = JSON.parse(finish_task);
			var finish_task_array =  new Array();
			for(var i in task){
				finish_task_array[i] = finish_task[i];
			}

			var data1 = {
				xDatas: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'],
				data : ['任务额度','已完成额度'],
				yDatas : [
					task_array,
					finish_task_array
				]
			}
			echartOptions(data1,'main')
			function echartOptions(obj,ele){
				var color = ['#da4fdc','#63dc4f','#00a2ff','#faf722','#c61e57','#1aeddc'];
				var data1 = obj.data;
				var newData = [];
				for(var i=0,l=data1.length;i<l;i++){
					var dataobj = {};
					dataobj.name = data1[i];
					dataobj.icon = 'pin';
					dataobj.textStyle= {};
					dataobj.textStyle.color = color[i];
					newData.push(dataobj);
				}
				var newYData = [];
				var yDatas = obj.yDatas;
				for(var i=0,l=yDatas.length;i<l;i++){
					var dataobj = {};
					dataobj.name = data1[i];
					dataobj.type = 'bar';
					dataobj.barWidth = 20;
					dataobj.data = yDatas[i];
					dataobj.itemStyle = {
						normal: {
                            barBorderRadius:[4, 4, 0, 0]
                        }
					};
					newYData.push(dataobj);
				}
				var option = {
					color: color,
					tooltip: {
						trigger: 'axis',
						axisPointer: {
							type: 'shadow'
						}
					},
					legend: {
						data: newData,
						bottom: '0px',
						left: '20px',
						textStyle: {
							fontSize: 10
						}
					},
					grid: {
						top: '6%',
						left: '4%',
						right: '2%',
						bottom: '20%',
						containLabel: true
					},
					xAxis: [{
						type: 'category',
						axisLabel: {
					　  		textStyle: {
					　　  			color: '#83879d'
					　　		}
						},
						splitLine:{
	                        show:true,
	                        lineStyle:{
								color: '#2f365a',
							}
	                    },
						data: obj.xDatas
					}],
					yAxis: [{
						type: 'value',
						axisLabel: {
					　  		textStyle: {
					　　  			color: '#00a2ff'
					　　		}
						},
						splitLine:{
	                        lineStyle:{
								color: '#2f365a',
							}
	                    },
					}],
					series: newYData
				};
				var myChart1 = echarts.init(document.getElementById(ele));
				myChart1.setOption(option);
				$(window).resize(function(){
	                myChart1.resize();
	            });
			}


			$("#search_name").change(function(){
				var p_id = $("#search_name").val();
				var id = $("#id").val();
				$.ajax({
					type: "GET",
					url: "/backend/sell/ditch_agent/set_brokerage",
					data: "p_id="+p_id+"&id="+id,
					success: function(msg){
						$('#span').html(msg);
					}
				});
			})

			$("#btn-yes").click(function(){
				var man = $("#man_id").val();
				var p_id = $("#search_name").val();

				$("#ty_product_id").val(p_id);
				$("#man_agent").val(man);
			})
		</script>
@stop
