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
			<li class="active">活跃产品</li>
		</ol>
	</div>
	<div class="row">
		<div class="section section-5">
			<input type="hidden" id="id" value="{{$id}}">
			<div class="col-lg-3 col-xs-6">
				<a href="{{url('/backend/sell/ditch_agent/channel_details?id='.$id)}}" class="section-item">渠道详情 </a>
			</div>
			<div class="col-lg-3 col-xs-6">
				<a href="{{url('/backend/sell/ditch_agent/channel_record?id='.$id)}}" class="section-item">销售记录 </a>
			</div>
			<div class="col-lg-3 col-xs-6">
				<a href="{{url('/backend/sell/ditch_agent/channel_agent?id='.$id)}}" class="section-item">渠道代理人 </a>
			</div>
			<div class="col-lg-3 col-xs-6">
				<a href="{{url('/backend/sell/ditch_agent/channel_active?id='.$id)}}" class="section-item active">活跃产品 </a>
			</div>
			<div class="col-lg-3 col-xs-6">
				<a href="{{url('/backend/task?ditch='.$id)}}" class="section-item">渠道任务</a>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12">
			<div class="select-wrapper radius">
				<div class="form-inline radius">
					<div class="form-group">
						<div class="select-item">
							<label for="name">选择本渠道活跃产品:</label>
							<select class="form-control" id="search">
								<option selected disabled>产品名称</option>
								@foreach($active as $value)
									<option value="{{$value->id}} @if(isset($id) && $id == $value->id) selected @endif">{{$value->product_name}}</option>
								@endforeach
							</select>
						</div>
					</div>
					<button class="btn btn-warning fr" data-toggle="modal" data-target="#change">佣金设置</button>
				</div>
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
	<div class="row">
		<div class="ui-table col-lg-12">
			<div class="ui-table-header radius">
				<span class="col-md-4">产品名称</span>
				<span class="col-md-3">销售总额</span>
				<span class="col-md-3">佣金总额</span>
				{{--<span class="col-md-2 col-one">操作</span>--}}
			</div>
			<div class="ui-table-body">
				<ul>

					@foreach($active as $item)
						<li class="ui-table-tr">
							<div class="col-md-4">{{$item->product_name}}</div>
							<div class="col-md-3">{{$item->order_pay}}元</div>
							<div class="col-md-3">{{$item->brokerage}}元</div>
							<div class="col-md-2 text-right">
								{{--{{$item->id}}--}}
								{{--<a class="btn btn-primary" href="#">查看详情</a>--}}
							</div>
						</li>
					@endforeach
				</ul>
			</div>
			<div class="row text-center">
				{{$active->links()}}
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
					<li>
						<span class="name">产品名称：</span>
						<select class="form-control" id="search_name">
							<option value="0">-选择产品-</option>
								@foreach($result as $val)
									<option value="{{$val->id}}">{{$val->product_name}}</option>
								@endforeach
						</select>
					</li>
					<li>
						<span class="name">代理人：</span>
						<select class="form-control" id="man_id">
								@foreach($agent_name as $value)
									<option value="{{$value->id}}">{{$value->real_name}}</option>
								@endforeach
						</select>
					</li>
				</ul>
				<form action="{{url('/backend/sell/ditch_agent/agent_brokerage_addition/')}}" method="get">
					<table>
						<tr>
							<th width="96px">缴别</th>
							<th width="176px">初始代理人佣金比</th>
							<th width="76px">设佣金比</th>
						</tr>
						<tbody id="span">
						<tr>
							<td></td>
							<td></td>
							<td><td>
								<input class="ditch-id" name="ditch_id[]" type="hidden" value="{{ $id }}">
								<input class="by-stages-way" name="by_stages_way[]" type="hidden" value="{{isset($val['by_stages_way']) ? $val['by_stages_way']. $val['pay_type_unit'] : "" }}">
								<input type="hidden" name="ty_product_id[]" id="ty_product_id" value="">
								<input type="hidden" name="man[]" id="man_agent" value="">
								<input type="hidden" name="ratio_for_agency[]" id="man_agent" value="{{isset($val['ratio_for_agency']) ? $val['ratio_for_agency'] : "" }}">
							</td></td>
						</tr>
							{{--@foreach($p_brokerage as $val)--}}
								{{--<tr>--}}
									{{--<td>{{$val['by_stages_way']. $val['pay_type_unit']}}</td>--}}
									{{--<td>{{$val['ratio_for_agency']}}%</td>--}}
									{{--<td>--}}
										{{--<input type="text" name="brokerage[]">%--}}
										{{--<input class="ditch-id" name="ditch_id[]" type="hidden" value="{{ $id }}">--}}
										{{--<input class="by-stages-way" name="by_stages_way[]" type="hidden" value="{{$val['by_stages_way']. $val['pay_type_unit']}}">--}}
										{{--<input type="hidden" name="ty_product_id[]" id="ty_product_id" value="">--}}
										{{--<input type="text" name="man[]" id="man_agent" value="">--}}
										{{--<input type="hidden" name="ratio_for_agency[]" id="man_agent" value="{{$val['ratio_for_agency']}}">--}}
									{{--</td>--}}
								{{--</tr>--}}
							{{--@endforeach--}}
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

<input type="hidden" id="sale_arr" value="{{ json_encode($sale_arr) }}">
<input type="hidden" id="brokerage_arr" value="{{ json_encode($brokerage_arr) }}">


<script src="{{asset('r_backend/v2/js/lib/jquery-1.11.3.min.js')}}"></script>
<script src="{{asset('r_backend/v2/js/lib/echarts.js')}}"></script>
<script src="{{asset('r_backend/v2/js/lib/bootstrap.min.js')}}"></script>
<script src="{{asset('r_backend/v2/js/common_backend.js')}}"></script>
<script>

	var sale = $("#sale_arr").val();
	sale = JSON.parse(sale);
	var sale_array =  new Array();
	for(var i in sale){
		sale_array[i] = sale[i];
	}
	var brokerage = $("#brokerage_arr").val();
	brokerage = JSON.parse(brokerage);
	var brokerage_arr =  new Array();
	for(var i in sale){
		brokerage_arr[i] = brokerage[i];
	}



	var data1 = {
		xDatas: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'],
		data : ['任务额度','已完成额度'],
		yDatas : [
			[0, 2, 101, 134, 90, 230, 210, 132, 232, 134, 90, 200],
			[220, 182, 191, 234, 290, 330, 310, 132, 191, 134, 90, 150]
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
			series: [
				{
					name:'佣金额度',
					type:'line',
					stack: '总量',
					areaStyle: {normal: {}},
					data: brokerage_arr
				},
				{
					name:'销售额度',
					type:'bar',
					barWidth: 20,
					itemStyle: {
						normal: {
							barBorderRadius:[4, 4, 0, 0]
						}
					},
					data: sale_array
				}
			]
		};
		var myChart1 = echarts.init(document.getElementById(ele));
		myChart1.setOption(option);
		$(window).resize(function(){
			myChart1.resize();
		});
	}

	$("#search").change(function(){
		var active_id = $("#search").val();
		var id = $("#id").val();
		window.location.href="/backend/sell/ditch_agent/channel_active?id="+id+"&active_id="+active_id;
	})


	$("#search_name").change(function(){
		var p_id = $("#search_name").val();
		var id = $("#id").val();
		$.ajax({
			type: "GET",
			url: "/backend/sell/ditch_agent/active_brokerage",
			data: "p_id="+p_id+"&id="+id,
			success: function(msg){
				if(p_id != 0){
					$('#span').html(msg);
				}else{
					$('#span').html("");
				}
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
