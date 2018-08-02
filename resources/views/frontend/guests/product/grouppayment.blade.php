@extends('frontend.guests.guests_layout.base')
<link rel="stylesheet/less" href="{{config('view_url.view_url').'css/process.less'}}"/>
<script src="{{config('view_url.view_url').'js/lib/less.min.js'}}"></script>
@section('content')
					<div class="wrapper step4">
						<div class="main payment">
							<div class="table-head">
								<span class="col1"></span>
								<span class="col2">产品名称</span>
								<span class="col3">投保形式</span>
								<span class="col4">起保日期</span>
								<span class="col5">保费</span>
							</div>
							<table cellspacing="0" cellpadding="0">
								<tr>
									<td class="col1">
										<div class="payment-img">
											<img src="image/ins (8).png" alt="" />
										</div>
									</td>
									<td class="col2">
										<div>{{$companyOld->product_name}}</div>
										<div class="rights">
											<span>保障权益<i class="iconfont icon-jiantou2"></i></span>
											<ul class="tip">
												<li><span>意外伤害身故及伤残</span>5万元</li>
												<li><span>急性病身故</span>5万元</li>
												<li><span>意外及急性病医疗</span>2万元</li>
											</ul>
										</div>
									</td>
									<td class="col3">
										<div>电子保单</div>
									</td>
									<td class="col4">
										<div>{{$orderData->start_time}}</div>
									</td>
									<td class="col5">
										<div class="f18164">￥{{sprintf("%.2f",$orderData->premium/100)}}</div>
									</td>
								</tr>
							</table>
							<div class="payment-way clearfix">
								<div class="payment-way-selection clearfix">
									<div class="fl radiobox">
										{{--<span>请选择支付方式：</span>--}}
										{{--<label><input type="radio" name="way" checked hidden/><i class="iconfont icon-danxuan2"></i><span>使用银行卡支付</span></label>--}}
										{{--<label><input type="radio" name="way" hidden/><i class="iconfont icon-danxuan1"></i><span>使用支付宝支付</span></label>--}}
									</div>
									<div class="cheap-wrapper fr radiobox">
										{{--<label><input type="checkbox" hidden/><i class="icon icon-checkbox"></i><span>使用优惠券</span></label>--}}
										{{--<label><input type="checkbox" hidden/><i class="icon icon-checkbox"></i><span>使用账户余额</span></label>--}}
									</div>
								</div>
								<!--情况1：已绑定银行卡-->
								<div class="payment-way-bankcard  situation1 radiobox clearfix" style="display: block">
									<div>保险公司的账号为：（请您线下转账到该账户，支付完成后点击“支付完成”）</div>
									<ul class="bankcard-list clearfix">
										<li>
											<label>
												<span class="bankcard-id">{{$company_bank['bank_num']}}</span>
											</label>
										</li>
									</ul>
									{{--<div class="payment-way-other fr clearfix">--}}
										{{--<div class="btn-addcard">添加其他银行卡</div>--}}
										{{--<div>--}}
											{{--<label>--}}
												{{--<input type="checkbox" hidden/>--}}
												{{--<i class="icon icon-checkbox"></i>--}}
												{{--<span>使用优惠券</span>--}}
											{{--</label>--}}
											{{--<span class="tips">当前无可用优惠券</span>--}}
										{{--</div>--}}
										{{--<div>--}}
											{{--<label>--}}
												{{--<input type="checkbox" hidden/>--}}
												{{--<i class="icon icon-checkbox"></i>--}}
												{{--<span>使用账户余额</span>--}}
											{{--</label>--}}
											{{--<span class="tips">当前账户可用余额为<i class="f18164">0</i>元</span>--}}
										{{--</div>--}}
									{{--</div>--}}
								</div>
								<!--情况2：暂无绑定银行卡-->
								{{--<div class="payment-way-bankcard  situation2 clearfix">--}}
									{{--<div class="payment-way-without">--}}
										{{--<div class="without-img">--}}
											{{--<img src="image/nodata.png" alt="" />--}}
										{{--</div>--}}
										{{--<p class="without-text">您暂时还没有银行卡</p>--}}
										{{--<div class="btn-addcard">添加银行卡</div>--}}
									{{--</div>--}}
									{{--<div class="payment-way-other fr clearfix">--}}
										{{--<div>--}}
											{{--<label>--}}
												{{--<input type="checkbox" hidden/>--}}
												{{--<i class="icon icon-checkbox"></i>--}}
												{{--<span>使用优惠券</span>--}}
											{{--</label>--}}
											{{--<span class="tips">当前无可用优惠券</span>--}}
										{{--</div>--}}
										{{--<div>--}}
											{{--<label>--}}
												{{--<input type="checkbox" hidden/>--}}
												{{--<i class="icon icon-checkbox"></i>--}}
												{{--<span>使用账户余额</span>--}}
											{{--</label>--}}
											{{--<span class="tips">当前账户可用余额为<i class="f18164">0</i>元</span>--}}
										{{--</div>--}}
									{{--</div>--}}
								{{--</div>--}}
								<!--情况3：未登录绑定银行卡-->
								{{--<div class="payment-way-bankcard situation3">--}}
									{{--<div class="payment-way-binding">--}}
										{{--<div class="select select-bankcard">--}}
											{{--<span>选择银行卡</span>--}}
											{{--<ul class="select-dropdown">--}}
												{{--<li>中国建设银行</li>--}}
												{{--<li>中国工商银行</li>--}}
											{{--</ul>--}}
										{{--</div>--}}
										{{--<input type="text" placeholder="银行卡持卡人须为投保人" />--}}
									{{--</div>--}}
								{{--</div>--}}
							</div>
							<div class="payment-compute">
								<div class="fr clearfix">
									<div class="fl"><span class="payment-compute-name">合计：</span><span class="payment-compute-price">￥{{sprintf("%.2f",$orderData->premium/100)}}</span><span class="payment-compute-unit">元</span></div>
									<div class="fl btn" id="payDone">支付完成</div>
								</div>
							</div>
						</div>
					</div>

					<!--添加银行卡-->
					{{--<div class="popup popup-addcard">--}}
						{{--<div class="popup-bg"></div>--}}
						{{--<div class="popup-wrapper">--}}
							{{--<div class="popup-title"><span>添加银行卡</span></div>--}}
							{{--<div class="popup-content">--}}
								{{--<li>--}}
									{{--<span class="name">持卡人</span>--}}
									{{--<span>张三<i class="cl333">(持卡人必须为投保人本人)</i></span>--}}
								{{--</li>--}}
								{{--<li>--}}
									{{--<span class="name">银行</span>--}}
									{{--<div class="select">--}}
										{{--<span>选择银行卡</span>--}}
										{{--<ul class="select-dropdown">--}}
											{{--<li>中国建设银行</li>--}}
											{{--<li>中国工商银行</li>--}}
										{{--</ul>--}}
									{{--</div>--}}
								{{--</li>--}}
								{{--<li>--}}
									{{--<span class="name">卡号</span>--}}
									{{--<input type="text" placeholder="请输入银行卡号" />--}}
								{{--</li>--}}
								{{--<li class="popup-content-code">--}}
									{{--<span class="name">预留手机号</span>--}}
									{{--<input type="text" placeholder="请输入手机号" maxlength="11" />--}}
									{{--<button class="btn btn-f18164">发送验证码</button>--}}
								{{--</li>--}}
								{{--<li>--}}
									{{--<span class="name">验证码</span>--}}
									{{--<input type="text" placeholder="请输入验证码" />--}}
								{{--</li>--}}
							{{--</div>--}}
							{{--<div class="popup-footer">--}}
								{{--<button class="btn-small btn-confirm">确定</button>--}}
								{{--<button class="btn-small btn-cancel">取消</button>--}}
							{{--</div>--}}
						{{--</div>--}}
					{{--</div>--}}
				</div>
			</div>
		</div>
		{{--<script src="{{config('view_url.view_url')}}js/payment.js"></script>--}}
		<script>
			$(document).ready(function(){
				$('#payDone').click(function(){
					Mask.alert('正在核保中...')
					location.href = '{{url('/')}}'
				})
			})
		</script>
		@stop
