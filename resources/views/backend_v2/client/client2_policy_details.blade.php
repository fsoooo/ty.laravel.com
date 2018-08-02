@extends('backend_v2.layout.base')
@section('title')@parent 代理商详情 @stop
@section('head-more')
	<link rel="stylesheet" href="{{asset('r_backend/v2/css/agent.css')}}" />
@stop

@section('top_menu')
	@include('backend_v2.agent.top_menu')
@stop
@section('main')
		<div class="main-wrapper policy">
			<div class="row">
				<ol class="breadcrumb col-lg-12">
				    <li><a href="#">客户管理</a><i class="iconfont icon-gengduo"></i></li>
				    <li><a href="#">个人客户</a><i class="iconfont icon-gengduo"></i></li>
				    <li class="active">田小田</li>
				</ol>
			</div>
			<div class="row">
				<div class="col-md-5">
					<div class="policy-wrapper">
						<div class="policy-info">
							<h3 class="title">中国人寿成人重疾险（个险）</h3>
							<p>订单号：524852174656458594</p>
							<p>保单号：524852174656458594</p>
						</div>
						<div class="policy-list">
							<p><span class="name">公司名称</span><i>:</i>中国人寿</p>
							<p><span class="name">保险险种</span><i>:</i>重疾险</p>
							<p><span class="name">条款</span><i>:</i><a href="#">《中国人寿成人重疾条款》</a></p>
							<div><span class="name vtop">责任保额</span><i class="vtop">:</i>
								<ul class="duty-list">
									<li><span class="duty-name">重症疾病</span>5万</li>
									<li><span class="duty-name">轻症疾病</span>5万</li>
									<li><span class="duty-name">身故保障金</span>已交保险费</li>
									<li><span class="duty-name">全残保障金 </span>全部保险金/两万保险金额</li>
								</ul>
							</div>
							<p><span class="name">特别约定</span><i>:</i>保障期内在发生任何风险都不进行赔偿。</p>
							<p><span class="name">受益人</span><i>:</i>法定受益人</p>
							<p><span class="name">保 费</span><i>:</i>1150元</p>
							<p><span class="name">缴费方式</span><i>:</i>年缴</p>
							<p><span class="name">缴费期限</span><i>:</i>20年</p>
							<p><span class="name">佣金</span><i>:</i>600元</p>
							<p><span class="name">渠道</span><i>:</i>自主渠道</p>
							<p><span class="name">渠道佣金</span><i>:</i>200元</p>
							<p><span class="name">代理人</span><i>:</i>李木易杨<a href="#" style="margin-left: 20px;">更换代理人</a></p>
							<p><span class="name">代理人佣金</span><i>:</i>400元</p>
						</div>
					</div>
				</div>
				<div class="col-md-7">
					<div class="info-wrapper active">
						<i class="iconfont icon-zhankai"></i>
						<button class="btn btn-primary">投保人</button>
						<div class="info-img col-lg-2">
							<img src="../../img/girl.png" alt="" />
						</div>
						<div class="col-lg-10">
							<p class="info-name">田小田<span class="color-primary"><i class="iconfont icon-shiming"></i>已实名</span></p>
						</div>
						<div class="info-datails">
							<div class="col-xs-6 col-md-4">
								<p><span class="name">性 别</span><i>:</i>男</p>
								<p><span class="name">证件类型</span><i>:</i>身份证</p>
								<p><span class="name">渠道</span><i>:</i>东城区组</p>
								<p><span class="name">购买保障</span><i>:</i>20种</p>
								<p><span class="name">职业类别</span><i>:</i>公司企业一般行政人员</p>
							</div>
							<div class="col-xs-6 col-md-6">
								<p><span class="name">手机号码</span><i>:</i>13911195495</p>
								<p><span class="name">证件号码</span><i>:</i>130737198105131523</p>
								<p><span class="name">邮箱</span><i>:</i>13911195495@163.com</p>
								<p><span class="name">保费总计</span><i>:</i>30000元</p>
							</div>
						</div>
					</div>
					
					<div class="info-wrapper">
						<i class="iconfont icon-zhankai"></i>
						<button class="btn btn-warning">被保人</button>
						<div class="info-img col-lg-2">
							<img src="../../img/girl.png" alt="" />
						</div>
						<div class="col-lg-10">
							<p class="info-name">田小田<span class="color-primary"><i class="iconfont icon-shiming"></i>已实名</span></p>
						</div>
						<div class="info-datails">
							<div class="col-xs-6 col-md-4">
								<p><span class="name">性 别</span><i>:</i>男</p>
								<p><span class="name">证件类型</span><i>:</i>身份证</p>
								<p><span class="name">渠道</span><i>:</i>东城区组</p>
								<p><span class="name">购买保障</span><i>:</i>20种</p>
								<p><span class="name">职业类别</span><i>:</i>公司企业一般行政人员</p>
							</div>
							<div class="col-xs-6 col-md-6">
								<p><span class="name">手机号码</span><i>:</i>13911195495</p>
								<p><span class="name">证件号码</span><i>:</i>130737198105131523</p>
								<p><span class="name">邮箱</span><i>:</i>13911195495@163.com</p>
								<p><span class="name">保费总计</span><i>:</i>30000元</p>
							</div>
						</div>
					</div>
					
					<div class="info-wrapper">
						<i class="iconfont icon-zhankai"></i>
						<button class="btn btn-info">受益人</button>
						<div class="info-img col-lg-2">
							<img src="../../img/girl.png" alt="" />
						</div>
						<div class="col-lg-10">
							<p class="info-name">田小田<span class="color-primary"><i class="iconfont icon-shiming"></i>已实名</span></p>
						</div>
						<div class="info-datails">
							<div class="col-xs-6 col-md-4">
								<p><span class="name">性 别</span><i>:</i>男</p>
								<p><span class="name">证件类型</span><i>:</i>身份证</p>
								<p><span class="name">渠道</span><i>:</i>东城区组</p>
								<p><span class="name">购买保障</span><i>:</i>20种</p>
								<p><span class="name">职业类别</span><i>:</i>公司企业一般行政人员</p>
							</div>
							<div class="col-xs-6 col-md-6">
								<p><span class="name">手机号码</span><i>:</i>13911195495</p>
								<p><span class="name">证件号码</span><i>:</i>130737198105131523</p>
								<p><span class="name">邮箱</span><i>:</i>13911195495@163.com</p>
								<p><span class="name">保费总计</span><i>:</i>30000元</p>
							</div>
						</div>
					</div>
					
					<div class="record">操作记录</div>
					<div class="record-list">
						<ul>
							<li>2017-03-02 11:52:50<span>申请保金</span>申请成功</li>
							<li>2017-03-02 11:52:50<span>保单支付</span>支付成功，生成保单</li>
							<li>2017-03-02 11:52:50<span>发起投保</span>投保成功</li>
							<li>2017-03-02 11:52:50<span>发起投保</span>投保失败</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		
		
		<script src="../../js/lib/jquery-1.11.3.min.js"></script>
		<script src="../../js/lib/echarts.js"></script>
		<script src="../../js/lib/bootstrap.min.js"></script>
		<script src="../../js/common_backend.js"></script>
		<script>
			$('.icon-zhankai').click(function(){
				var _this = $(this);
				_this.parent().addClass('active').find('.info-datails').show();
				_this.parent().siblings().removeClass('active').find('.info-datails').hide();
			});
		</script>
@stop