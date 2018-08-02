@extends('frontend.guests.company_home.base')
@section('content')
	<link rel="stylesheet" href="{{config('view_url.company_url')}}css/datas.css" />
		<div class="content">
			<div class="content-inside">
				<!--头部信息-->
					<div class="main-wrapper">
						<div class="main-content">
							
							<div class="datas-wrapper">
								<div class="crumbs-wrapper">
									<a href="index.html">首页</a><i class="iconfont icon-gengduo"></i>
									<a href="">数据统计</a><i class="iconfont icon-gengduo"></i>
									<span>查看详情</span>
								</div>
								
								<div class="datas">
									<h3 class="title">保障与人员管理<span>(2017年1月至本月)</span></h3>
									<div id="main" style="width: 100%;height:90%;"></div>
								</div>
							</div>
							<div class="person-wrapper">
								<div class="header">
									<h3 class="fl title">人员变动列表</h3>
									<div class="fr">
										<select class="default" name="">
											<option value="">本月</option>
											<option value="">近三个月</option>
											<option value="">近半年</option>
											<option value="">近一年</option>
										</select>
										<select class="default" name="">
											<option value="">增员</option>
											<option value="">减员</option>
										</select>
									</div>
								</div>
								<table class="tabel-default">
									<tr><th>产品</th><th>被保人</th><th>性别</th><th>证件号</th><th>手机号</th><th>操作</th></tr>
									<tr>
										<td>产品测试方案一</td>
										<td>天小眼</td>
										<td>女</td>
										<td>1156954295645456456563132</td>
										<td>13524895146</td>
										<td>
											<span style="color: #adadad;">已恢复</span>
											<!--<button class="btn-00a2ff">修改</button><button class="btn-primary-hollow">删除</button>-->
										</td>
									</tr>
									<tr>
										<td>产品测试方案一</td>
										<td>天小眼</td>
										<td>女</td>
										<td>1156954295645456456563132</td>
										<td>13524895146</td>
										<td>
											<button class="btn-00a2ff">修改</button><button class="btn-primary-hollow">删除</button>
										</td>
									</tr>
									<tr>
										<td>产品测试方案一</td>
										<td>天小眼</td>
										<td>女</td>
										<td>1156954295645456456563132</td>
										<td>13524895146</td>
										<td>
											<button class="btn-00a2ff">恢复</button><button class="btn-primary-hollow">删除</button>
										</td>
									</tr>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!--页脚-->
	@stop
	<script src="{{config('view_url.company_url')}}js/lib/jquery-1.11.3.min.js"></script>
	<script src="{{config('view_url.company_url')}}js/lib/echarts.js"></script>

	<script src="{{config('view_url.company_url')}}js/common.js"></script>
	<script>
		$(function() {
			// 人员管理
			var xAxisData = ['一月','二月','三月','四月','五月','六月','七月','八月','九月','十月','十一月','本月'];
			var data1 = [17,22,38,10,26,31,42,43,31,51,49,10];
			var data2 = [-23,-36,-25,-11,-25,-13,-46,-35,-51,-45,-57,-10];
			
			var itemStyle = {
			    normal: {},
			    emphasis: {
			        barBorderWidth: 1,
			        shadowBlur: 10,
			        shadowOffsetX: 0,
			        shadowOffsetY: 0,
			        shadowColor: 'rgba(0,0,0,0.5)'
			    }
			};
			
			var staffOption = {
				color: ['#42e1f1','#00a2ff'],
			    legend: {
			        data: ['增员', '减员'],
			        bottom: '0px',
					left: '20px',
			    },
			    tooltip: {},
			    grid: {
					top: '16%',
					left: '0%',
					right: '0%',
					bottom: '20%',
					containLabel: true
				},
			    xAxis: {
			        data: xAxisData,
			        silent: false,
			        axisLine: {onZero: true},
			        splitLine: {show: false},
			        splitArea: {show: false},
			        axisLabel: {　
						textStyle: {　　
							color: '#d8d7d9'　　
						}
					},
			    },
			    yAxis: {
			    	name: '人数',
			        nameTextStyle: {
						color: '#d8d7d9'
					},
			        axisLabel: {　
						textStyle: {　　
							color: '#d8d7d9'　　
						}
					},
			    },
			    series: [
			        {
			            name: '增员',
			            type: 'bar',
			            barWidth: 12,
			            stack: 'one',
			            itemStyle: itemStyle,
			            data: data1
			        },
			        {
			            name: '减员',
			            type: 'bar',
			            barWidth: 12,
			            stack: 'one',
			            itemStyle: itemStyle,
			            data: data2
			        }
			    ]
			};
			var myChart2 = echarts.init(document.getElementById('main'));
			myChart2.setOption(staffOption);
		});
	</script>

</html>