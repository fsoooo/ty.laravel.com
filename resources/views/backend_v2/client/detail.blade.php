@extends('backend_v2.layout.base')
@section('title')@parent 代理商详情 @stop
@section('head-more')
	<link rel="stylesheet" href="{{asset('r_backend/v2/css/client_details.css')}}" />
@stop

@section('top_menu')
	@include('backend_v2.customer.top', ['type' => 'user'])
@stop
@section('main')
		<div class="main-wrapper info">
			<div class="row">
				<ol class="breadcrumb col-lg-12">
				    <li><a href="#">客户管理</a><i class="iconfont icon-gengduo"></i></li>
				    <li><a href="#">个人客户</a><i class="iconfont icon-gengduo"></i></li>
				    <li class="active">田小田</li>
				</ol>
			</div>
			<div class="row">
				<div class="section">
					 <div class="col-md-4 col-xs-6">
					 	<a href="agent2_info.html" class="section-item active">个人信息</a>
				    </div>
				    <div class="col-md-4 col-xs-6">
				    	<a href="{{url('backend/user_management/insurance_record')}}" class="section-item">保险记录</a>
				    </div>
				    <div class="col-md-4 col-xs-6">
				    	<a href="#" class="section-item">操作记录</a>
				    </div>
				</div>
			</div>
			
			
			<!--个人客户页面显示-->
			<div class="row">
				<div class="col-lg-5">
					<div class="chart-wrapper">
						<div>
							<span class="btn-select active">1</span>
							<span class="btn-select">2</span>
							<select class="form-control fr">
								<option>2017</option>
								<option>2016</option>
								<option>2015</option>
								<option>2014</option>
								<option>2013</option>
							</select>
						</div>
						<div id="main1" style="width: 100%;height:180px;"></div>
					</div>
				</div>
				<div class="col-lg-7">
					<div class="info-wrapper info-person">
						<div class="info-img col-md-2">
							<img src="{{ asset('/r_backend/v2/img/girl.png')}}" alt="" />
						</div>
						<div class="col-md-10">
							<p class="info-name">田小田<span class="color-primary"><i class="iconfont icon-shiming"></i>已实名</span></p>
						</div>
						<div class="info-datails">
							<div class="col-xs-6 col-md-5">
								<p><span class="name">性 别</span><i>:</i>男</p>
								<p><span class="name">证件类型</span><i>:</i>身份证</p>
								<p><span class="name">渠道</span><i>:</i>东城区组</p>
								<p><span class="name">购买保障</span><i>:</i>20种</p>
								<p><span class="name">职业类别</span><i>:</i>公司企业一般行政人员</p>
							</div>
							<div class="col-xs-6 col-md-5">
								<p><span class="name">手机号码</span><i>:</i>13911195495</p>
								<p><span class="name">证件号码</span><i>:</i>130737198105131523</p>
								<p><span class="name">邮箱</span><i>:</i>13911195495@163.com</p>
								<p><span class="name">保费总计</span><i>:</i>30000元</p>
								<p><span class="name">代理人</span><i>:</i>-</p>
							</div>
						</div>
						<div class="col-lg-12 info-operation">
							<a href="{{url('backend/user_management/client_agent')}}" class="btn btn-primary">分配代理人</a>
							<button class="btn btn-warning" data-toggle="modal" data-target="#modalChange">重置密码</button>
						</div>
					</div>
					
				</div>
			</div>
			
			
			
			
			<!--企业客户页面显示-->
			<div class="row">
				<div class="col-lg-5">
					<div class="chart-wrapper">
						<div>
							<span class="btn-select active">1</span>
							<span class="btn-select">2</span>
							<select class="form-control fr">
								<option>2017</option>
								<option>2016</option>
								<option>2015</option>
								<option>2014</option>
								<option>2013</option>
							</select>
						</div>
						<div id="main2" style="width: 100%;height:180px;"></div>
					</div>
				</div>
				<div class="col-lg-7">
					<div class="info-wrapper">
						<div class="info-img col-md-2">
							<img src="{{ asset('/r_backend/v2/img/girl.png')}}" alt="" />
						</div>
						<div class="col-md-10">
							<p class="info-name">天眼互联科技有限公司</p>
						</div>
						<div class="info-datails">
							<div class="col-xs-6 col-md-5">
								<p><span class="name">保费总计</span><i>:</i>3000元</p>
								<p><span class="name">在保人数</span><i>:</i>139</p>
								<p><span class="name">电话号码</span><i>:</i>13911195495</p>
								<p><span class="name">联系人</span><i>:</i>田大田</p>
								<p><span class="name">邮箱</span><i>:</i>13911195495@163.com</p>
								<p><span class="name">代理人</span><i>:</i>-</p>
							</div>
							<div class="col-xs-6 col-md-5">
								<p><span class="name">工商注册号</span><i>:</i>110108002734660</p>
								<p><span class="name">组织机构代码</span><i>:</i>MA007MTL1</p>
								<p><span class="name">统一信用代码</span><i>:</i>9110105MA007MTl18</p>
								<p><span class="name">纳税人识别号</span><i>:</i>9110105MA007MTl18</p>
								<p><span class="name">行业类型</span><i>:</i>互联网-软件</p>
								<p><span class="name">公司地址</span><i>:</i>北京市东城区富瑞苑大厦308</p>
							</div>
						</div>
						<div class="col-lg-12 info-operation">
							<a href="{{url('backend/user_management/client_agent')}}" class="btn btn-primary">分配代理人</a>
							<button class="btn btn-warning" data-toggle="modal" data-target="#modalChange">重置密码</button>
						</div>
					</div>

				</div>
			</div>
			
			
			
			<!--组织团体页面显示-->
			<div class="row">
				<div class="col-lg-5">
					<div class="chart-wrapper">
						<div>
							<span class="btn-select active">1</span>
							<span class="btn-select">2</span>
							<select class="form-control fr">
								<option>2017</option>
								<option>2016</option>
								<option>2015</option>
								<option>2014</option>
								<option>2013</option>
							</select>
						</div>
						<div id="main3" style="width: 100%;height:180px;"></div>
					</div>
				</div>
				<div class="col-lg-7">
					<div class="info-wrapper">
						<div class="info-img col-md-2">
							<img src="{{ asset('/r_backend/v2/img/girl.png')}}" alt="" />
						</div>
						<div class="col-md-10">
							<p class="info-name">富瑞苑足球队</p>
						</div>
						<div class="info-datails">
							<div class="col-xs-6 col-md-5">
								<p><span class="name">登记管理机关</span><i>:</i>东城区民政局</p>
								<p><span class="name">业务主管单位</span><i>:</i>龙潭湖寄到办事处</p>
								<p><span class="name">统一信用代码</span><i>:</i>9110105MA007MTl18</p>
								<p><span class="name">登记证号</span><i>:</i>214578541256332145</p>
								<p><span class="name">联系人</span><i>:</i>田大田</p>
								<p><span class="name">代理人</span><i>:</i>-</p>
							</div>
							<div class="col-xs-6 col-md-5">
								<p><span class="name">在保人数</span><i>:</i>139</p>
								<p><span class="name">保障方案</span><i>:</i>1种</p>
								<p><span class="name">保费总计</span><i>:</i>3000元</p>
								<p><span class="name">电话号码</span><i>:</i>13911195495</p>
								<p><span class="name">邮箱</span><i>:</i>13911195495@163.com</p>
							</div>
						</div>
						<div class="col-lg-12 info-operation">
							<a href="{{url('backend/user_management/client_agent')}}" class="btn btn-primary">分配代理人</a>
							<button class="btn btn-warning" data-toggle="modal" data-target="#modalChange">重置密码</button>
						</div>
					</div>
				</div>
			</div>






			<!--个人客户页面显示-->
			<div class="row">
				<div class="col-lg-12">
					<div class="section">
						 <div class="col-md-2">
						 	<a href="#" class="section-item active">投保产品</a>
					    </div>
					    <div class="col-md-2">
					    	<a href="#" class="section-item">被保产品</a>
					    </div>
					</div>
				</div>
				<div class="ui-table col-lg-12">
					<div class="ui-table-header radius">
						<span class="col-md-2">保单号</span>
						<span class="col-md-1">产品名称</span>
						<span class="col-md-1">承保时间</span>
						<span class="col-md-1">缴费方式</span>
						<span class="col-md-1">投保人</span>
						<span class="col-md-1">被保人</span>
						<span class="col-md-1">保费</span>
						<span class="col-md-1">佣金总额(元)</span>
						<span class="col-md-1" style="width: 15%;">代理人佣金(元)</span>
						<span class="col-md-2 col-one" style="width: 10%;">操作</span>
					</div>
					<div class="ui-table-body table-multi-line">
						<ul>
							<li class="ui-table-tr">
								<div class="col-md-2">425124563214585412</div>
								<div class="col-md-1 ellipsis" title="中国人寿成人重疾中国人寿成人重疾">中国人寿成人重疾中国人寿成人重疾</div>
								<div class="col-md-1" style="margin: 0;">2019-09-22<br/>至<br/>2037-09-22</div>
								<div class="col-md-1">年缴</div>
								<div class="col-md-1">王大力</div>
								<div class="col-md-1">王大力</div>
								<div class="col-md-1">1150</div>
								<div class="col-md-1">600</div>
								<div class="col-md-1">400</div>
								<div class="col-md-2 text-right" style="margin-top: 10px;"><a href="{{url('backend/user_management/client_policy_details')}}" class="btn btn-primary">查看详情</a></div>
							</li>
						</ul>
					</div>
				</div>
			</div>
			
			<!--企业客户页面显示-->
			<div class="row">
				<div class="col-lg-12">
					<div class="section">
						<div class="col-md-2">
						 	<a href="#" class="section-item active">投保产品</a>
					    </div>
					</div>
				</div>
				<div class="ui-table col-lg-12">
					<div class="ui-table-header radius">
						<span class="col-md-2">产品名称</span>
						<span class="col-md-1">产品类型</span>
						<span class="col-md-2">公司名称</span>
						<span class="col-md-1">购买人数</span>
						<span class="col-md-1">保费总额</span>
						<span class="col-md-1">佣金总额(元)</span>
						<span class="col-md-2">代理人佣金(元)</span>
						<span class="col-md-2 col-one">操作</span>
					</div>
					<div class="ui-table-body">
						<ul>
							<li class="ui-table-tr">
								<div class="col-md-2 ellipsis"  title="中国人寿成人重疾中国人寿成人重疾">中国人寿成人重疾中国人寿成人重疾</div>
								<div class="col-md-1">意外险</div>
								<div class="col-md-2">平安保险</div>
								<div class="col-md-1">15</div>
								<div class="col-md-1">3000</div>
								<div class="col-md-1">600</div>
								<div class="col-md-2">400</div>
								<div class="col-md-2 text-right"><a href="{{url('backend/user_management/client_policy_details')}}" class="btn btn-primary">查看详情</a></div>
							</li>
						</ul>
					</div>
				</div>
			</div>
			
			<!--组织客户页面显示-->
			<div class="row">
				<div class="col-lg-12">
					<div class="section">
						<div class="col-md-2">
						 	<a href="#" class="section-item active">投保产品</a>
					    </div>
					</div>
				</div>
				<div class="ui-table col-lg-12">
					<div class="ui-table-header radius">
						<span class="col-md-2">产品名称</span>
						<span class="col-md-1">产品类型</span>
						<span class="col-md-1">公司名称</span>
						<span class="col-md-1">购买人数</span>
						<span class="col-md-1">保费总额</span>
						<span class="col-md-1">佣金总额(元)</span>
						<span class="col-md-2">代理人佣金(元)</span>
						<span class="col-md-1">保障状态</span>
						<span class="col-md-2 col-one">操作</span>
					</div>
					<div class="ui-table-body">
						<ul>
							<li class="ui-table-tr">
								<div class="col-md-2 ellipsis" title="中国人寿成人重疾中国人寿成人重疾">中国人寿成人重疾中国人寿成人重疾</div>
								<div class="col-md-1">意外险</div>
								<div class="col-md-1">平安保险</div>
								<div class="col-md-1">15</div>
								<div class="col-md-1">3000</div>
								<div class="col-md-1">600</div>
								<div class="col-md-2">400</div>
								<div class="col-md-1">保障中 </div>
								<div class="col-md-2 text-right"><a href="{{url('backend/user_management/client_policy_details')}}" class="btn btn-primary">查看详情</a></div>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		
		<!--密码重置-->
		<div class="modal fade modal-change" id="modalChange" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="" data-dismiss="modal" aria-label="Close"><i class="iconfont icon-guanbi"></i></button>
						<h4 class="modal-title">账户管理</h4>
					</div>
					<div class="modal-body">
						<p>田小田</p>
						<p>登录账号：13911195495</p>
						<p>初始密码：账户后六位</p>
						<p>密码：9******</p>
					</div>
					<div class="modal-footer">
						<button class="btn btn-warning">密码重置</button>
					</div>
				</div>
			</div>
		</div>
		<script src="{{asset('r_backend/v2/js/lib/jquery-1.11.3.min.js')}}"></script>
		<script src="{{asset('r_backend/v2/js/lib/echarts.js')}}"></script>
		<script src="{{asset('r_backend/v2/js/lib/bootstrap.min.js')}}"></script>
		<script src="{{asset('r_backend/v2/js/common_backend.js')}}"></script>
		<script>
			changeTab('.btn-select');
			
			
			// 投保产品
			var data2 = {
				selected: {
					'佣金': false
				},
				xDatas: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'],
				data : ['保费','佣金'],
				yDatas : [
					[120, 132, 101, 134, 90, 230, 210, 132, 232, 134, 90, 200],
					[220, 182, 191, 234, 290, 330, 310, 132, 191, 134, 90, 150]
				]
			}
			
			// 被保产品
			var data1 = {
				selected: {
					'购保次数': false
				},
				xDatas: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'],
				data : ['理赔次数','购保次数'],
				yDatas : [
					[120, 132, 101, 134, 90, 230, 210, 132, 232, 134, 90, 200],
					[220, 182, 191, 234, 290, 330, 310, 132, 191, 134, 90, 150]
				]
			}
			
			
			echartOptions(data1,'main1');
			echartOptions(data2,'main2');
			echartOptions(data2,'main3');
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
					dataobj.stack = '总量'+i;
					dataobj.type = 'line';
					dataobj.smooth = true;
					dataobj.data = yDatas[i];
					newYData.push(dataobj);
				}
				var option = {
					color: color,
					tooltip: {
						trigger: 'axis',
						axisPointer: {
							type: 'cross',
							label: {
								backgroundColor: '#6a7985'
							}
						}
					},
					legend: {
						selected: obj.selected,
						data: newData,
						bottom: '0px',
						left: '20px',
						textStyle: {
							fontSize: 10
						}
					},
					grid: {
						top: '6%',
						left: '0%',
						right: '4%',
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
						boundaryGap: false,
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