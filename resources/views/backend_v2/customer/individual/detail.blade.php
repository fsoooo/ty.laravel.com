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
				    <li><a href="{{ route('backend.customer.individual.index') }}">客户管理</a><i class="iconfont icon-gengduo"></i></li>
				    <li><a href="{{ route('backend.customer.individual.index') }}">个人客户</a><i class="iconfont icon-gengduo"></i></li>
				    <li class="active">{{ $user->name }}</li>
				</ol>
			</div>

			@include('backend_v2.customer.individual.nav', ['type' => 'detail'])
			
			
			<!--个人客户页面显示-->
			<div class="row">
				<div class="col-lg-5">
					<div class="chart-wrapper">
						<div style="visibility: hidden;">
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
							<p class="info-name">{{ $user->name }}
								@if($user->verified == 1)
									<span class="color-primary">
										<i class="iconfont icon-shiming"></i>已实名
									</span>
									@else
									<span class="color-grey">
										<i class="iconfont icon-shiming"></i>未实名
									</span>
								@endif
							</p>
						</div>
						<div class="info-datails">
							<div class="col-xs-6 col-md-5">
								<p><span class="name">性 别</span><i>:</i>{{ $user->sex }}</p>
								<p><span class="name">证件类型</span><i>:</i>身份证</p>
								<p><span class="name">渠道</span><i>:</i>{{ $user->ditch_name }}</p>
								<p><span class="name">购买保障</span><i>:</i>{{ $user->product_count }}种</p>
								{{--<p><span class="name">职业类别</span><i>:</i>在职员工</p>--}}

							</div>
							<div class="col-xs-6 col-md-5">
								<p><span class="name">手机号码</span><i>:</i>{{ $user->phone }}</p>
								<p><span class="name">证件号码</span><i>:</i>{{ $user->code }}</p>
								<p><span class="name">邮箱</span><i>:</i>{{ $user->email }}</p>
								<p><span class="name">保费总计</span><i>:</i>{{ $user->premium }}元</p>
								<p><span class="name">代理人</span><i>:</i>{{ $user->agent_name }}</p>
							</div>
						</div>
						<div class="col-lg-12 info-operation">
							<a href="{{ route('backend.customer.allocate_agent', [$user->id]) }}" class="btn btn-primary">分配代理人</a>
							{{--<button class="btn btn-warning" data-toggle="modal" data-target="#modalChange">重置密码</button>--}}
						</div>
					</div>
					
				</div>
			</div>

			<!--个人客户页面显示-->
			<div class="row">
				<div class="col-lg-12">
					<div class="section">
						 <div class="col-md-2">
						 	<a href="{{ route('backend.customer.individual.detail', [$user->id]) . '?list=insure' }}" class="section-item {{ $list_type == 'insure' ? 'active' : '' }}">投保产品</a>
					    </div>
					    {{--<div class="col-md-2">--}}
					    	{{--<a href="{{ route('backend.customer.individual.detail', [$user->id]) . '?list=insured' }}" class="section-item {{ $list_type == 'insured' ? 'active' : '' }}">被保产品</a>--}}
					    {{--</div>--}}
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
						<span class="col-md-1">保费(元)</span>
						<span class="col-md-1">佣金总额(元)</span>
						<span class="col-md-1" style="width: 15%;">代理人佣金(元)</span>
						<span class="col-md-2 col-one" style="width: 10%;">操作</span>
					</div>
					<div class="ui-table-body table-multi-line">
						<ul>
							@foreach($lists as $list)
								@if(!empty($list->warranty_code))
									<li class="ui-table-tr">
										<div class="col-md-2">{{ $list->warranty_code }}</div>
										<div class="col-md-1 ellipsis" title="{{ $list->product_name }}">{{ $list->product_name }}</div>
										<div class="col-md-1" style="margin: 0;">{{ $list->start_time }}<br/>至<br/>{{ $list->end_time	 }}</div>
										<div class="col-md-1">{{ $list->by_stages_way }}</div>
										<div class="col-md-1">{{ $list->policy_name }}</div>
										<div class="col-md-1">{{ $list->recognizee_name }}</div>
										<div class="col-md-1">{{ $list->premium }}</div>
										<div class="col-md-1">{{ $list->brokerage }}</div>
										<div class="col-md-1">{{ (int)$list->user_earnings == 0 ? '0(自主购买)' : $list->user_earnings }}</div>
										<div class="col-md-2 text-right" style="margin-top: 10px;"><a href="{{ route('backend.customer.individual.warranty', [$list->id]) }}" class="btn btn-primary">查看详情</a></div>
									</li>
								@endif
							@endforeach
							</ul>
					</div>
				</div>
			</div>
			<div class="row text-center">
				{{ $lists->links() }}
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
						<p>{{ $user->name }}</p>
						<p>登录账号：{{ $user->phone }}</p>
						<p>初始密码：账户后六位</p>
						<p>密码：xxxxx</p>
					</div>
					<div class="modal-footer">
						<button class="btn btn-warning" id="reset-password">密码重置</button>
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
			// 购买保险次数
            var buy = [];
			@foreach($lists2 as $key => $item)
                buy['{{ $key }}'] = '{{ $item['count'] }}';
			@endforeach
			var data1 = {
				xDatas: ['1月', '2月', '3月', '4月', '5月', '6月', '7月', '8月', '9月', '10月', '11月', '12月'],
//				data : ['理赔次数','购保次数'],
				data : ['购保次数'],
				yDatas : [
					buy
				]
			}

			echartOptions(data1,'main1');
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

				{{--$('#reset-password').on('click', function () {--}}
                    {{--$.ajax({--}}
                        {{--headers: {--}}
                            {{--'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')--}}
                        {{--},--}}
                        {{--url: "{{ route('backend.customer.reset_password') }}",--}}
                        {{--type: "get",--}}
                        {{--data: {'id':id,'pwd':pwd},--}}
                        {{--dataType: "json",--}}
                        {{--success: function (data) {--}}
                            {{--if(data.status == 0){--}}
                                {{--sendSms(phone,model,name,pwd);--}}
                            {{--} else {--}}
                                {{--alert('密码重置失败');--}}
                            {{--}--}}
                        {{--}--}}
                    {{--});--}}
				{{--});--}}

                {{--function sendSms(phone, model,name,pwd){--}}
                    {{--$.get('/backend/sendsms',--}}
                        {{--{'phone':phone,'model':model,'name':name,'sms_content':pwd},--}}
                        {{--function (data) {--}}
                            {{--if(data['content'] == undefined){--}}
                                {{--alert(data['message']);--}}
                            {{--}else{--}}
                                {{--alert(data['content']);--}}
                            {{--}--}}
                        {{--}--}}
                    {{--);--}}
                {{--}--}}

			}
		</script>
@stop