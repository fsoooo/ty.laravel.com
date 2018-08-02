@extends('frontend.guests.guests_layout.base')
<link rel="stylesheet/less" href="{{config('view_url.view_url')}}css/details.less" />
<script src="{{config('view_url.view_url')}}js/lib/less.min.js"></script>
@section('content')
    <div class="wrapper-top">
        <div class="main">
            <!--路径导航-->
            <ol class="breadcrumb clearfix">
                <li><a href="#">某某保险网</a><i class="iconfont icon-gengduo"></i></li>
                <li><a href="#">儿童保险</a><i class="iconfont icon-gengduo"></i></li>
                <li><a href="#">重大疾病险</a><i class="iconfont icon-gengduo"></i></li>
                <li><a href="#">泰康人寿</a><i class="iconfont icon-gengduo"></i></li>
                <li>百万安行-个人综合意外保障计划 </li>
            </ol>
        </div>
    </div>
    <div class="anchorlink-wrapper">
        <div class="main">
            <div class="anchorlink-box">
                <div class="anchorlink-item active">保障详情</div>
                <div class="anchorlink-item">拥有权益</div>
                <div class="anchorlink-item">用户问题（<span class="f18164">55</span>）</div>
            </div>
        </div>
    </div>

    <div class="wrapper-bottom">
        <div class="main">
            <div class="product">
                <div class="product-introduce">
                    <h1 class="introduce-name">百万安行-个人综合意外保障计划</h1>
                    <ul class="introduce-classify clearfix">
                        <li><i class="iconfont icon-fuxuankuang"></i>意外健康全覆盖</li>
                        <li><i class="iconfont icon-fuxuankuang"></i>意外健康全覆盖</li>
                        <li><i class="iconfont icon-fuxuankuang"></i>意外健康全覆盖</li>
                    </ul>
                    <div class="introduce-parameter">
						<div class="introduce-parameter-row clearfix">
							<span class="introduce-parameter-title">保费</span>
							<div class="introduce-parameter-content">
								<span class="f18164">￥</span><span class="pirce">568.00</span>
							</div>
						</div>
						<div class="introduce-button">
							<a href="javascript:;"><input type="submit" class="btn btn-f18164" value="立即投保" id="groupInsSubmit"></a>
							<a href="javascript:void(0)"><button class="btn btn-a4d790">加入购物车</button></a>
							<!--<span class="product-btn-order">预约顾问</span>-->
						</div>
						<script>
							$(document).ready(function(){
								$('#groupInsSubmit').click(function(){
									@if(!$result)
									//判断是否登陆
										location.href = '{{url('/login')}}';
									@elseif($result && $result->type == 'user')
									    alert('当前登陆账户不是企业/团体账户，不能购买团体险');
                                    @else
										location.href='{{url('/groupInsNotice')}}';
									@endif
								})
							})
						</script>
                    </div>
                </div>
                <div>
                    <h3 class="section-title">保险条款</h3>
                    <div class="content-tableview">
                        <table class="content-table-detail">
                            <tbody>
                            <tr>
                                <th rowspan="1">主条款</th>
                                <td>
                                    <a href="#">人身意外伤害保险条款（2016版）</a>
                                    <i class="iconfont icon-pdf"></i>
                                    <div class="fr">
                                        <a href="#" class="content-table-tdlabel-1">下载</a>
                                        <span class="content-table-tdlabel-2">|</span>
                                        <a href="#" class="content-table-tdlabel-2">查看</a>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th class="addition-clause">附加条款</th>
                                <td>
                                    <a href="#">人身意外伤害保险条款（2016版）</a>
                                    <i class="iconfont icon-pdf"></i>
                                    <div class="fr">
                                        <a href="#" class="content-table-tdlabel-1">下载</a>
                                        <span class="content-table-tdlabel-2">|</span>
                                        <a href="#" class="content-table-tdlabel-2">查看</a>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <a href="#">人身意外伤害保险条款（2016版）</a>
                                    <i class="iconfont icon-pdf"></i>
                                    <div class="fr">
                                        <a href="#" class="content-table-tdlabel-1">下载</a>
                                        <span class="content-table-tdlabel-2">|</span>
                                        <a href="#" class="content-table-tdlabel-2">查看</a>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="product-equity">
                    <h3 class="section-title">保障权益</h3>
                    <div class="product-equity-item">
                        <div class="table-head">意外伤害及医疗保障</div>
                        <table>
                            <tr>
                                <td class="product-equity-img">
                                    <img src="{{config('view_url.view_url')}}image/610318870343627142.png" alt="" />
                                </td>
                                <td class="product-equity-name">意外身故</td>
                                <td class="product-equity-price">5万元</td>
                                <td class="product-equity-info">若被保险人在本附加合同生效(或最后复效)之日起180天后初次发生且经专科医生明确诊断患本附加合同所定义的重大疾病[注],保险公司将按本附加合同的保险金额给付重大疾病保险金，本附加合同终止。</td>
                            </tr>
                            <tr>
                                <td class="product-equity-img">
                                    <img src="{{config('view_url.view_url')}}image/610318870343627142.png" alt="" />
                                </td>
                                <td class="product-equity-name">意外身故</td>
                                <td class="product-equity-price">5万元</td>
                                <td class="product-equity-info">若被保险人在本附加合同生效(或最后复效)之日起180天后初次发生且经专科医生明确诊断患本附加合同所定义的重大疾病[注],保险公司将按本附加合同的保险金额给付重大疾病保险金，本附加合同终止。</td>
                            </tr>
                        </table>
                    </div>
                    <div class="product-equity-item">
                        <div class="table-head">生命健康及医疗保险</div>
                        <table>
                            <tr>
                                <td class="product-equity-img">
                                    <img src="{{config('view_url.view_url')}}image/610318870343627142.png" alt="" />
                                </td>
                                <td class="product-equity-name">意外身故</td>
                                <td class="product-equity-price">5万元</td>
                                <td class="product-equity-info">若被保险人在本附加合同生效(或最后复效)之日起180天后初次发生且经专科医生明确诊断患本附加合同所定义的重大疾病[注],保险公司将按本附加合同的保险金额给付重大疾病保险金，本附加合同终止。</td>
                            </tr>
                            <tr>
                                <td class="product-equity-img">
                                    <img src="{{config('view_url.view_url')}}image/610318870343627142.png" alt="" />
                                </td>
                                <td class="product-equity-name">意外身故</td>
                                <td class="product-equity-price">5万元</td>
                                <td class="product-equity-info">若被保险人在本附加合同生效(或最后复效)之日起180天后初次发生且经专科医生明确诊断患本附加合同所定义的重大疾病[注],保险公司将按本附加合同的保险金额给付重大疾病保险金，本附加合同终止。</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="product-possess">
                    <h3 class="section-title">您拥有的权益</h3>
                    <div class="product-possess-wrapper">
                        <ul class="clearfix">
                            <li class="clearfix">
                                <div class="product-possess-img fl">
                                    <img src="{{config('view_url.view_url')}}image/154994202374191399.png" alt="" />
                                </div>
                                <div class="product-possess-content fl">
                                    <div class="possess-name">索赔</div>
                                    <p class="possess-text">指当被保险标的遭受承保责任范围内的风险损失或伤害时,被保险人有权向保险人提出索赔。</p>
                                </div>
                            </li>
                            <li class="clearfix">
                                <div class="product-possess-img fl">
                                    <img src="{{config('view_url.view_url')}}image/154994202374191399.png" alt="" />
                                </div>
                                <div class="product-possess-content fl">
                                    <div class="possess-name">索赔</div>
                                    <p class="possess-text">指当被保险标的遭受承保责任范围内的风险损失或伤害时,被保险人有权向保险人提出索赔。</p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="product-evaluate">
                    <h3 class="section-title">用户评价</h3>
                    <div class="description clearfix">
                        <div class="description-left fl">
                            <div class="description-rate">100%</div>
                            <div class="description-text">好评率</div>
                        </div>
                        <div class="description-right fl">
                            <span class="tag">好(22)</span>
                            <span class="tag">性价比高(8)</span>
                            <span class="tag">好(22)</span>
                            <span class="tag">很好用(8)</span>
                            <span class="tag">省心放心(8)</span>
                        </div>
                    </div>
                    <!-- UY BEGIN -->
                    <div id="uyan_frame"></div>
                    <script type="text/javascript" src="{{config('view_url.view_url')}}http://v2.uyan.cc/code/uyan.js?uid=2141334"></script>
                    <!-- UY END -->
                <!--<div class="tabControl">
									<div class="tabControl-nav">
										<span>用户评价55</span>
										<span>理赔反馈55</span>
									</div>
									<div class="tabControl-wrapper">
										<ul class="active">
											<li class="clearfix">
												<div class="tabControl-img fl">
													<img src="{{config('view_url.view_url')}}image/546880771452609376.png" alt="" />
												</div>
												<div class="tabControl-content fl">
													<div>
														断**线
														<i class="iconfont icon-shoucangwujiaoxing"></i>
														<i class="iconfont icon-shoucangwujiaoxing"></i>
														<i class="iconfont icon-shoucangwujiaoxing"></i>
														<i class="iconfont icon-shoucangwujiaoxing"></i>
														<i class="iconfont icon-shoucangwujiaoxing"></i>
													</div>
													<div class="tabControl-text">
														客服周云女士非常耐心，而且提供的信息很专业，能根据客户的实际情况提供恰当的险种。半年前无意中接触了保险网，对不太了解，半年后自己陆续买了一些保险后再来看惠泽，发现提供的险种非常实用有针对性。如果需要理赔，希望能像投保时一样顺利，但是不希望有理赔的情况出现，希望是把这点小钱捐助给了有需要的人吧。
													</div>
												</div>
											</li>
											<li class="clearfix">
												<div class="tabControl-img fl">
													<img src="{{config('view_url.view_url')}}image/546880771452609376.png" alt="" />
												</div>
												<div class="tabControl-content fl">
													<div>
														断**线
														<i class="iconfont icon-shoucangwujiaoxing"></i>
														<i class="iconfont icon-shoucangwujiaoxing"></i>
														<i class="iconfont icon-shoucangwujiaoxing"></i>
														<i class="iconfont icon-shoucangwujiaoxing"></i>
														<i class="iconfont icon-shoucangwujiaoxing"></i>
													</div>
													<div class="tabControl-text">
														客服周云女士非常耐心，而且提供的信息很专业，能根据客户的实际情况提供恰当的险种。半年前无意中接触了保险网，对不太了解，半年后自己陆续买了一些保险后再来看惠泽，发现提供的险种非常实用有针对性。如果需要理赔，希望能像投保时一样顺利，但是不希望有理赔的情况出现，希望是把这点小钱捐助给了有需要的人吧。
													</div>
												</div>
											</li>
										</ul>
										<ul>
											<li>暂无信息</li>
										</ul>
									</div>
								</div>-->
                </div>
            </div>
            <div class="product-right">
                <div class="product-right-top">
                    <div class="product-right-info clearfix">
                        <div class="product-right-num fl">
                            <div class="cl999">销量</div>
                            <div class="a4d790">1489</div>
                        </div>
                        <div class="product-right-rate fl">
                            <div class="cl999">满意度</div>
                            <div class="f18164">100%</div>
                        </div>
                    </div>
                    <div class="product-right-impression">
                        <div class="name">买家印象</div>
                        <div>
                            <span class="tag">好(22)</span>
                            <span class="tag">性价比高(8)</span>
                            <span class="tag">省心放心(8)</span>
                        </div>
                    </div>
                    <div class="product-right-service">
                        <div class="name">服务与承诺</div>
                        <ul>
                            <li><i class="icon icon-wujiaoxing"></i>电子表单</li>
                            <li><i class="icon icon-wujiaoxing"></i>电子表单</li>
                        </ul>
                    </div>
                </div>
                <div class="product-right-bottom">
                    <div class="name">保费</div>
                    <div class="f18164">￥<span class="price">568.00</span></div>
                    <button class="btn btn-f18164"><a class="f18164" href="#">立即投保</a></button>
                    <button class="btn btn-a4d790"><a href="javascript:void(0)">加入购物车</a></button>
                </div>

            </div>
        </div>
    </div>

    <script src="{{config('view_url.view_url')}}js/lib/laydate.js"></script>
    <script src="{{config('view_url.view_url')}}js/details.js"></script>
@stop

