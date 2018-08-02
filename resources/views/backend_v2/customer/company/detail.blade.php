@extends('backend_v2.layout.base')
@section('title')@parent 代理商详情 @stop
@section('head-more')
	<link rel="stylesheet" href="{{asset('r_backend/v2/css/client_details.css')}}" />
@stop

@section('top_menu')
	@include('backend_v2.customer.top', ['type' => 'company'])
@stop
@section('main')
	<div class="main-wrapper info">
		<div class="row">
			<ol class="breadcrumb col-lg-12">
				<li><a href="{{ route('backend.customer.individual.index') }}">客户管理</a><i class="iconfont icon-gengduo"></i></li>
				<li><a href="{{ route('backend.customer.company.index') }}">企业客户</a><i class="iconfont icon-gengduo"></i></li>
				<li class="active">{{ $user->name }}</li>
			</ol>
		</div>

	@include('backend_v2.customer.company.nav', ['type' => 'detail'])


	<!--企业客户页面显示-->
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
					<div id="main2" style="width: 100%;height:180px;"></div>
				</div>
			</div>
			<div class="col-lg-7">
				<div class="info-wrapper">
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
							<p><span class="name">保费总计</span><i>:</i>{{ $user->premium }}元</p>
							<p><span class="name">在保人数</span><i>:</i>{{ $user->insured_count }}</p>
							<p><span class="name">电话号码</span><i>:</i>{{ $user->ins_phone }}</p>
							<p><span class="name">联系人</span><i>:</i>{{ $user->name }}</p>
							<p><span class="name">邮箱</span><i>:</i>{{ $user->email }}</p>
							<p><span class="name">代理人</span><i>:</i>{{ $user->agent_name }}</p>
						</div>
						<div class="col-xs-6 col-md-5">
							<p><span class="name">工商注册号</span><i>:</i>{{ $user->license_code }}</p>
							<p><span class="name">组织机构代码</span><i>:</i>{{ $user->code }}</p>
							<p><span class="name">统一信用代码</span><i>:</i>{{ $user->credit_code }}</p>
							<p><span class="name">纳税人识别号</span><i>:</i>{{ $user->tax_code }}</p>
							{{--<p><span class="name">行业类型</span><i>:</i>-</p>--}}
							<p><span class="name">公司地址</span><i>:</i>{{ $user->address }}</p>
						</div>
					</div>
					<div class="col-lg-12 info-operation">
						<a href="{{ route('backend.customer.allocate_agent', [$user->id]) }}" class="btn btn-primary">分配代理人</a>
						{{--<button class="btn btn-warning" data-toggle="modal" data-target="#modalChange">重置密码</button>--}}
					</div>
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
					<span class="col-md-1">保单号</span>
					<span class="col-md-1">产品名称</span>
					<span class="col-md-1">产品类型</span>
					<span class="col-md-2">公司名称</span>
					<span class="col-md-1">购买人数</span>
					<span class="col-md-1">保费总额(元)</span>
					<span class="col-md-1">佣金总额(元)</span>
					<span class="col-md-2">代理人佣金(元)</span>
					<span class="col-md-2 col-one">操作</span>
				</div>
				<div class="ui-table-body">
					<ul>
						@foreach($lists as $list)
							@if(!empty($list->warranty_code))
								<li class="ui-table-tr">
									<div class="col-md-1">{{ $list->warranty_code }}</div>
									<div class="col-md-1 ellipsis"  title="{{ $list->product_name }}">{{ $list->product_name }}</div>
									<div class="col-md-1">{{ $list->category }}</div>
									<div class="col-md-2">{{ $list->company }}</div>
									<div class="col-md-1">{{ $list->insured_count }}</div>
									<div class="col-md-1">{{ $list->premium }}</div>
									<div class="col-md-1">{{ $list->brokerage }}</div>
									<div class="col-md-1">{{ (int)$list->user_earnings == 0 ? '0(自主购买)' : $list->user_earnings }}</div>
									<div class="col-md-2 text-right"><a href="{{ route('backend.customer.company.warranty', [$list->id]) }}" class="btn btn-primary">查看详情</a></div>
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


        // 佣金
        var premium = [];
		@foreach($lists2 as $key => $item)
            premium['{{ $key }}'] = '{{ $item['premium'] }}';
		@endforeach
        // 保费
        var brokerage = [];
		@foreach($lists3 as $key => $item)
            brokerage['{{ $key }}'] = '{{ $item['brokerage'] }}';
		@endforeach
        var data2 = {
                xDatas: ['1月', '2月', '3月', '4月', '5月', '6月', '7月', '8月', '9月', '10月', '11月', '12月'],
                data: ['保费', '佣金'],
                yDatas: [
                    brokerage,
                    premium
                ]
            };

        echartOptions(data2,'main2');
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