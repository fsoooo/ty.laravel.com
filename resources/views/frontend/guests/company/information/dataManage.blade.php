@extends('frontend.guests.company_home.base')
@section('content')
	<link rel="stylesheet" href="{{config('view_url.company_url')}}css/datas.css" />
		<div class="content">
			<div class="content-inside">
					<div class="main-wrapper">
						<div class="main-content">

							<div class="datas-wrapper">
								<div class="crumbs-wrapper">
									<a href="index.html">首页</a><i class="iconfont icon-gengduo"></i>
									<a href="datas.html">数据统计</a><i class="iconfont icon-gengduo"></i>
									<span>查看详情</span>
								</div>
								
								<div class="datas">
									<h3 class="title">数据管理<span>(2017年1月至本月)</span></h3>
									<div id="main" style="width: 100%;height:90%;"></div>
								</div>
							</div>
							<div class="person-wrapper">
								<div class="header">
									<h3 class="fl title">已报销人员列表</h3>
									<div class="fr">
										<select class="default" name="">
											<option value="">本月</option>
											<option value="">近三个月</option>
											<option value="">近半年</option>
											<option value="">近一年</option>
										</select>
										<select class="default" name="">
											<option value="">所有产品</option>
											<option value="">测试产品一</option>
											<option value="">测试产品二</option>
											<option value="">测试产品三</option>
										</select>
									</div>
								</div>
								<table class="tabel-default">
									<tr><th>产品</th><th>被保人</th><th>性别</th><th>证件号</th><th>手机号</th><th>报销费用(元)</th></tr>
									<tr>
										<td>产品测试方案一</td>
										<td>天小眼</td>
										<td>女</td>
										<td>1156954295645456456563132</td>
										<td>13524895146</td>
										<td style="font-weight: bold;">1000</td>
									</tr>
									<tr>
										<td>产品测试方案一</td>
										<td>天小眼</td>
										<td>女</td>
										<td>1156954295645456456563132</td>
										<td>13524895146</td>
										<td style="font-weight: bold;">1000</td>
									</tr>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	@stop

	<script src="{{config('view_url.company_url')}}js/lib/jquery-1.11.3.min.js"></script>
	<script src="{{config('view_url.company_url')}}js/lib/echarts.js"></script>

	<script src="{{config('view_url.company_url')}}js/common.js"></script>
	<script>
		$(function() {
			// 数据管理
			var dataOption = {
				color: ['#42e1f1','#00a2ff'],
				legend: {
					data: ['总人数', '报销人数'],
					bottom: '0px',
					left: '20px',
				},
			    tooltip : {
			        trigger: 'axis'
			    },
			    grid: {
					top: '16%',
					left: '0%',
					right: '0%',
					bottom: '20%',
					containLabel: true
				},
			    xAxis : [{
		            type : 'category',
		            data : ['一月','二月','三月','四月','五月','六月','七月','八月','九月','十月','十一月','本月'],
		            axisLabel: {　
						textStyle: {　　
							color: '#d8d7d9'　　
						}
					},
			    }],
			    yAxis : [{
			    	name: '人数',
			        nameTextStyle: {
						color: '#d8d7d9'
					},
			    	axisLabel: {　
						textStyle: {　　
							color: '#d8d7d9'　　
						}
					},
			    }],
			    series : [
			        {
			            name:'总人数',
			            type:'bar',
			            barWidth: 12,
			            barGap: '-100%',
			            data:[100,90,60,120,140,170,100,90,120,150,120,90]
			        },
			        {
			            name:'报销人数',
			            type:'bar',
			            barWidth: 12,
			            barGap: '-100%',
			            data:[70,80,50,90,100,70,80,50,90,100,60,50]
			        },
			    ]
			};
			var myChart1 = echarts.init(document.getElementById('main'));
			myChart1.setOption(dataOption);
		});
	</script>

</html>