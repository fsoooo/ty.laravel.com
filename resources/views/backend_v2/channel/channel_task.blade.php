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
				    <li class="active">渠道的详细名称</li>
				</ol>
			</div>
			<div class="row">
				<div class="section section-5">
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
						<div class="col-md-3">全年销售任务：<span class="color-primary">5000万元</span></div>
						<div class="col-md-3">本月销售任务：<span class="color-primary">450万元</span></div>
						<button id="setTask" class="btn btn-primary fr" data-toggle="modal" data-target="#addTask">任务设置</button>
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
						<span class="col-md-5">追加时间</span>
						<span class="col-md-5">操作</span>
						<span class="col-md-2">目标金额</span>
					</div>
					<div class="ui-table-body">
						<ul>
							<li class="ui-table-tr">
								<div class="col-md-5">2017-03-15</div>
								<div class="col-md-5">追加年任务</div>
								<div class="col-md-2">2000万</div>
							</li>
							<li class="ui-table-tr">
								<div class="col-md-5">2017-03-15</div>
								<div class="col-md-5">追加年任务</div>
								<div class="col-md-2">2000万</div>
							</li>
							<li class="ui-table-tr">
								<div class="col-md-5">2017-03-15</div>
								<div class="col-md-5">追加年任务</div>
								<div class="col-md-2">2000万</div>
							</li>
						</ul>
					</div>
					<div class="row text-center">
						<ul class="pagination">
			                <li class="disabled"><span>«</span></li>
			                <li class="active"><span>1</span></li>
			                <li><a>2</a></li>
			                <li><a>3</a></li>
			        		<li><a rel="next">»</a></li>
			        	</ul>
					</div>
				</div>
				
			</div>
		</div>
		
		
		<div class="modal fade in" id="addTask" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header notitle">
						<button type="button" class="" data-dismiss="modal" aria-label="Close"><i class="iconfont icon-cancel"></i></button>
					</div>
					<div class="modal-body">
						<ul>
							<li>
								<span class="name">选择代理人：</span>
								<select class="form-control">
									<option>代理人1</option>
									<option>代理人2</option>
									<option>代理人3</option>
								</select>
							</li>
							<li>
								<span class="name">现有任务：</span>2000万
							</li>
							<li>
								<span class="name">追加任务：</span><input type="text">元
							</li>
							<li>
								<span class="name">任务总额：</span>-
							</li>
						</ul>
					</div>
					<div class="modal-footer">
						<button id="add" class="btn btn-primary" disabled>确认修改</button>
					</div>
				</div>
			</div>
		</div>
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



			$('#addTask input').bind('input propertychange', function() {  
				document.getElementById('add').disabled = !checkMustFill('#addTask input');
			});
			
			
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
		</script>
@stop
