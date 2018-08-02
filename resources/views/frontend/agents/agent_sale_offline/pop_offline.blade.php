<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>天眼互联-科技让保险无限可能</title>
		<link rel="stylesheet" href="{{config('view_url.agent_url')}}css/lib/iconfont.css" />
		<link rel="stylesheet" href="{{config('view_url.agent_url')}}css/common_agent.css" />
		<link rel="stylesheet" href="{{config('view_url.agent_url')}}css/index.css" />
		<style type="text/css">
			.center{
				display: block;
				margin: 0 auto;
			}
		</style>
	</head>
	<body>
		<!--线下保单录入弹出层-->
		<div class="popups-wrapper popups-handle popups-offline" style="display: block;">
			<div class="popups">
				<div class="popups-title">线下报单填写<i class="iconfont icon-close"></i></div>
				<div class="popups-content">
					<div class="content select-content">
						
						<div class="select-item" style="display: block;">
							<form  id="info">
								<div class="content">
									<div class="section">
										<div class="section-title">第一步,选择投保人/企业</div>
										<div class="section-container insure-container">
											<div class="search-outer">
												<select class="selectOne" name="policy_type">
													<option value="1">个人</option>
													@if(isset($input) && $input['policy_type'] == 2)
														<option selected value="2">企业</option>
													@else
														<option value="2">企业</option>
													@endif
												</select>
												<select class="selectTwo" name="policy_search_type">
													@if(isset($input) && $input['policy_type'] == 2)
														<option value="1">公司名称</option>
														@if($input['policy_search_type'] == 2)
															<option selected value="2">统一信用代码</option>
														@else
															<option value="2">统一信用代码</option>
														@endif
														@if($input['policy_search_type'] == 3)
															<option selected value="3">组织机构代码</option>
														@else
															<option value="3">组织机构代码</option>
														@endif
														@if($input['policy_search_type'] == 4)
															<option selected value="4">营业执照编码</option>
														@else
															<option value="4">营业执照编码</option>
														@endif
														@if($input['policy_search_type'] == 5)
															<option selected value="5">纳税人识别号</option>
														@else
															<option value="5">纳税人识别号</option>
														@endif
													@else
														<option value="1">姓名</option>
														@if(isset($input['policy_search_type']) && $input['policy_search_type'] == 2)
															<option selected value="2">身份证号</option>
														@else
															<option value="2">身份证号</option>
														@endif
														@if(isset($input['policy_search_type']) && $input['policy_search_type'] == 3)
															<option selected value="3">手机号</option>
														@else
															<option value="3">手机号</option>
														@endif
														@if(isset($input['policy_search_type']) && $input['policy_search_type'] == 4)
															<option selected value="4">邮箱</option>
														@else
															<option value="4">邮箱</option>
														@endif
													@endif
												</select>
												<div class="search">
													@if(isset($input['policy_content']))
													<input name="policy_content" type="text" placeholder="搜索客户" value="{{$input['policy_content']}}">
													@else
														<input name="policy_content" type="text" placeholder="搜索客户">
													@endif
													<i class="iconfont icon-sousuo"></i>
												</div>
												@if(isset($input) && $input['policy_type'] == 2)
													<button type="button" class="z-btn z-btn-default" data-pop="popups-add-company"><i class="iconfont icon-add"></i>添加投保人</button>
												@else
													<button type="button" class="z-btn z-btn-default" data-pop="popups-add-person"><i class="iconfont icon-add"></i>添加投保人</button>
												@endif
											</div>
											<!--<div class="z-btn-hollow reelect">重<br>选</div>-->
											<div class="table-wrapper client-wrapper">
												<ul class="table-header">
													<!--个人信息-->
													@if(isset($input) && $input['policy_type'] == 2)
														<!--企业信息-->
															<li>
                                                                <span style="width: 35px;height: 10px;"></span>
                                                                <span style="width: 120px;">公司名称</span>
                                                                <span style="width: 253px;">公司地址</span>
                                                                <span style="width: 120px;">联系人</span>
                                                                <span style="width: 120px;">联系方式</span>
                                                                <span style="width: 160px;">邮箱</span>
                                                            </li>
														@else
														<li>
															<span style="width: 30px;height: 1px;"></span>
															<span style="width: 100px;">姓名</span>
															<span style="width: 70px;">性别</span>
															<span style="width: 110px;">出生日期</span>
															<span style="width: 180px;">身份证号</span>
															<span style="width: 120px;">手机号</span>
															<span style="width: 198px;">邮箱</span>
													</li>
														@endif
												</ul>
												<div class="table-body">
													<ul>
														<!--个人信息-->
														@if($policyCount == 0)
															<li>未添加客户</li>
														@else
															@if(isset($input) && $input['policy_type'] == 2)
																@foreach($policy as $v)
															<!--企业信息-->
																<li>
                                                                    <span style="width: 35px;">
                                                                        <label>
                                                                            <input hidden type="radio" name="policy_id" value="{{$v->id}}">
                                                                            <i class="iconfont icon-duoxuan-weixuan"></i>
                                                                        </label>
                                                                    </span>
																	@if($v->company_name)
																		<span style="width: 120px;">{{$v->company_name}}</span>
																	@else
																		<span style="width: 120px;"> -- </span>
																	@endif
																	@if($v->street_address)
																		<span style="width: 253px;" class="ellipsis" title="{{$v->street_address}}">{{$v->street_address}}</span>
																	@else
																		<span style="width: 253px;" class="ellipsis" title=" -- "> -- </span>
																	@endif
																	@if($v->name)
																		<span style="width: 120px;">{{$v->name}}</span>
																	@else
																		<span style="width: 120px;"> -- </span>
																	@endif
																	@if($v->phone)
																		<span style="width: 120px;">{{$v->phone}}</span>
																	@else
																		<span style="width: 120px;"> -- </span>
																	@endif
																	@if($v->email)
																		<span style="width: 160px;">{{$v->email}}</span>
																	@else
																		<span style="width: 160px;"> -- </span>
																	@endif
                                                                </li>
															@endforeach
															@else
															@foreach($policy as $v)
														<li>
															<span style="width: 30px;">
																<label>
																	<input hidden type="radio" name="policy_id" value="{{$v->id}}">
																	<i class="iconfont icon-duoxuan-weixuan"></i>
																</label>
															</span>
															@if($v->name)
																<span style="width: 100px;">{{$v->name}}</span>
															@else
																<span style="width: 100px;"> -- </span>
															@endif
															@if($v['code'])
																@if(substr($v['code'],16,1)%2 == 1)
																	<span style="width: 70px;">男</span>
																@else
																	<span style="width: 70px;">女</span>
																@endif
															@else
																<span style="width: 70px;">--</span>
															@endif
															@if($v['code'])
																<span style="width: 110px;">{{substr($v['code'],6,4)}}.{{substr($v['code'],10,2)}}.{{substr($v['code'],12,2)}}</span>
															@else
																<span style="width: 110px;">--</span>
															@endif
															@if($v->code)
																<span style="width: 180px;">{{$v->code}}</span>
															@else
																<span style="width: 180px;"> -- </span>
															@endif
															@if($v->phone)
																<span style="width: 120px;">{{$v->phone}}</span>
															@else
																<span style="width: 120px;"> -- </span>
															@endif
															@if($v['email'])
																<span style="width: 198px;">{{$v['email']}}</span>
															@else
																<span style="width: 198px;"> -- </span>
															@endif
														</li>
														@endforeach
														@endif
													@endif


													</ul>
												</div>
											</div>
										</div>
									</div>
									<div class="section">
										<div class="section-title">第二步,选择被保人</div>
										<div class="section-container insured-container">
											<div class="search-outer">
												<select class="selectOne" name="recognize_type">
													<option value="1">个人</option>
													@if(isset($input) && $input['recognize_type'] == 2)
														<option selected value="2">企业</option>
													@else
														<option value="2">企业</option>
													@endif
												</select>
												<select class="selectTwo" name="recognize_search_type">
													@if(isset($input) && $input['recognize_type'] == 2)
														<option value="1">公司名称</option>
														@if($input['recognize_search_type'] == 2)
															<option selected value="2">统一信用代码</option>
														@else
															<option value="2">统一信用代码</option>
														@endif
														@if($input['recognize_search_type'] == 3)
															<option selected value="3">组织机构代码</option>
														@else
															<option value="3">组织机构代码</option>
														@endif
														@if($input['recognize_search_type'] == 4)
															<option selected value="4">营业执照编码</option>
														@else
															<option value="4">营业执照编码</option>
														@endif
														@if($input['recognize_search_type'] == 5)
															<option selected value="5">纳税人识别号</option>
														@else
															<option value="5">纳税人识别号</option>
														@endif
													@else
														<option value="1">姓名</option>
														@if(isset($input['recognize_search_type']) && $input['recognize_search_type'] == 2)
															<option selected value="2">身份证号</option>
														@else
															<option value="2">身份证号</option>
														@endif
														@if(isset($input['recognize_search_type']) && $input['recognize_search_type'] == 3)
															<option selected value="3">手机号</option>
														@else
															<option value="3">手机号</option>
														@endif
														@if(isset($input['recognize_search_type']) && $input['recognize_search_type'] == 4)
															<option selected value="4">邮箱</option>
														@else
															<option value="4">邮箱</option>
														@endif
													@endif
												</select>
												<div class="search">
													@if(isset($input['recognize_content']))
														<input name="recognize_content" type="text" placeholder="搜索客户" value="{{$input['recognize_content']}}">
													@else
														<input name="recognize_content" type="text" placeholder="搜索客户">
													@endif
													<i class="iconfont icon-sousuo"></i>
												</div>
												@if(isset($input) && $input['recognize_type'] == 2)
													<button type="button" class="z-btn z-btn-default" data-pop="popups-add-company"><i class="iconfont icon-add"></i>添加被保人</button>
												@else
													<button type="button" class="z-btn z-btn-default" data-pop="popups-add-person"><i class="iconfont icon-add"></i>添加被保人</button>
												@endif

											</div>
											<!--<div class="z-btn-hollow reelect">重<br>选</div>-->
											<div class="table-wrapper client-wrapper">
												<ul class="table-header">
												@if(isset($input) && $input['recognize_type'] == 2)
													<!--企业信息-->
														<li>
                                                            <span style="width: 35px;height: 10px;"></span>
                                                            <span style="width: 120px;">公司名称</span>
                                                            <span style="width: 90px;">公司类型</span>
                                                            <span style="width: 162px;">公司地址</span>
                                                            <span style="width: 120px;">联系人</span>
                                                            <span style="width: 120px;">联系方式</span>
                                                            <span style="width: 160px;">邮箱</span>
                                                        </li>
												@else
													<!--个人信息-->
													<li>
														<span style="width: 30px;height: 1px;"></span>
														<span style="width: 100px;">姓名</span>
														<span style="width: 70px;">性别</span>
														<span style="width: 110px;">出生日期</span>
														<span style="width: 180px;">身份证号</span>
														<span style="width: 120px;">手机号</span>
														<span style="width: 198px;">邮箱</span>
													</li>
												@endif
												</ul>
												<div class="table-body">
													<ul>
														<!--个人信息-->
														@if($recognizeCount == 0)
															<li>未添加客户</li>
														@else
															@if(isset($input) && $input['recognize_type'] == 2)
															<!--企业信息-->
																@foreach($recognize as $v)
																<li>
                                                                    <span style="width: 35px;">
                                                                        <label>
                                                                            <input hidden type="radio" name="recognize_id" value="{{$v->id}}">
                                                                            <i class="iconfont icon-duoxuan-weixuan"></i>
                                                                        </label>
                                                                    </span>
																	@if($v->company_name)
																		<span style="width: 120px;">{{$v->company_name}}</span>
																	@else
																		<span style="width: 120px;"> -- </span>
																	@endif
																	@if(isset($v->is_three_company) && $v->is_three_company == 0)
																		<span style="width: 90px;">三证合一企业</span>
																	@elseif(isset($v->is_three_company) && $v->is_three_company == 1)
																		<span style="width: 90px;">非三证合一企业</span>
																	@else
																		<span style="width: 90px;"> -- </span>
																	@endif
																	@if($v->street_address)
																		<span style="width: 162px;">{{$v->street_address}}</span>
																	@else
																		<span style="width: 162px;"> -- </span>
																	@endif
																	@if($v->name)
																		<span style="width: 120px;">{{$v->name}}</span>
																	@else
																		<span style="width: 120px;"> -- </span>
																	@endif
																	@if($v->phone)
																		<span style="width: 120px;">{{$v->phone}}</span>
																	@else
																		<span style="width: 120px;"> -- </span>
																	@endif
																	@if($v->email)
																		<span style="width: 160px;">{{$v->email}}</span>
																	@else
																		<span style="width: 160px;"> -- </span>
																	@endif
                                                                </li>
																@endforeach
															@else
															@foreach($recognize as $v)
														<li>
															<span style="width: 30px;">
																<label>
																	<input hidden type="radio" name="recognize_id" value="{{$v->id}}">
																	<i class="iconfont icon-duoxuan-weixuan"></i>
																</label>
															</span>
															@if($v->name)
																<span style="width: 100px;">{{$v->name}}</span>
															@else
																<span style="width: 100px;"> -- </span>
															@endif
															@if($v['code'])
																@if(substr($v['code'],16,1)%2 == 1)
																	<span style="width: 70px;">男</span>
																@else
																	<span style="width: 70px;">女</span>
																@endif
															@else
																<span style="width: 70px;">--</span>
															@endif
															@if($v['code'])
																<span style="width: 110px;">{{substr($v['code'],6,4)}}.{{substr($v['code'],10,2)}}.{{substr($v['code'],12,2)}}</span>
															@else
																<span style="width: 110px;">--</span>
															@endif
															@if($v->code)
																<span style="width: 180px;">{{$v->code}}</span>
															@else
																<span style="width: 180px;"> -- </span>
															@endif
															@if($v->phone)
																<span style="width: 120px;">{{$v->phone}}</span>
															@else
																<span style="width: 120px;"> -- </span>
															@endif
															@if($v['email'])
																<span style="width: 198px;">{{$v['email']}}</span>
															@else
																<span style="width: 198px;"> -- </span>
															@endif
														</li>
														@endforeach
														@endif
													@endif
														

														
													</ul>
												</div>
											</div>
										</div>
									</div>
									<div class="section">
										<div class="section-title">第三步,选择产品</div>
										<div class="section-container">
											<div class="search-outer">
												<select name="product_type">
													<option value="1">产品名称</option>
													@if(isset($input['product_type']) && $input['product_type'] == 2)
														<option selected value="2">公司名称</option>
													@else
														<option value="2">公司名称</option>
													@endif
													@if(isset($input['product_type']) && $input['product_type'] == 3)
														<option selected value="3">产品分类</option>
													@else
														<option value="3">产品分类</option>
													@endif
													@if(isset($input['product_type']) && $input['product_type'] == 4)
														<option selected value="4">佣金比率</option>
													@else
														<option value="4">佣金比率</option>
													@endif
													@if(isset($input['product_type']) && $input['product_type'] == 5)
														<option selected value="5">主险条款</option>
													@else
														<option value="5">主险条款</option>
													@endif
												</select>
												<div class="search">
													@if(isset($input['product_content']))
														<input name="product_content" type="text" placeholder="搜索产品" value="{{$input['product_content']}}">
													@else
														<input name="product_content" type="text" placeholder="搜索产品">
													@endif
													<i class="iconfont icon-sousuo"></i>
												</div>
												<button type="button" id="addProduct" class="z-btn z-btn-default" data-pop="popups-product"><i class="iconfont icon-add"></i>添加新产品</button>
											</div>
											<!--<div class="z-btn-hollow reelect">重<br>选</div>-->
											<div id="product" class="table-wrapper product-wrapper">
												<ul class="table-header">
													<li>
														<span class="col1"></span>
														<span class="col2">产品ID</span>
														<span class="col3">公司名称</span>
														<span class="col4">产品类型</span>
														<span class="col5">产品名称</span>
														<span class="col6">主险</span>
														<span class="col7">佣金比率</span>
														<span class="col8">保费</span>
													</li>
												</ul>
												<div class="table-body">
													<ul>
														@if(!$jurisdiction)
															<li>还没有进行认证，请 <a href="/agent/account">先认证</a></li>
														@elseif($product_count == 0)
															<li>没有设置佣金的产品</li>
														@else
															@foreach($product_list as $v)
														<li>
															<span class="col1">
																<label>
																	<input hidden type="radio" name="product_id" value="{{$v->ty_product_id}}">
																	<i class="iconfont icon-duoxuan-weixuan"></i>
																</label>
															</span>
															@if($v->ty_product_id)
																<span class="col2">{{$v->ty_product_id}}</span>
															@else
																<span class="col2">--</span>
															@endif
															@if($v->company_name)
																<span class="col3">{{$v->company_name}}</span>
															@else
																<span class="col3">--</span>
															@endif
															@if(json_decode($v->json,true)['category']['name'])
																<span class="col4">{{json_decode($v->json,true)['category']['name']}}</span>
															@else
																<span class="col4">--</span>
															@endif
															@if($v->product_name)
																<span class="col5">{{$v->product_name}}</span>
															@else
																<span class="col5">--</span>
															@endif
															@if(json_decode($v->personal,true)['main_insure'])
																<span class="col6">{{json_decode($v->personal,true)['main_insure']}}</span>
															@else
																<span class="col6">--</span>
															@endif
															@if(isset($v->rate['earning']) && $v->rate['earning'] >= 0)
																<span class="col7">{{$v->rate['earning']}}%</span>
															@else
																<span class="col7">--</span>
															@endif
															@if($v->base_price)
																<span class="col8">{{$v->base_price/100}}元</span>
															@else
																<span class="col8">--</span>
															@endif
														</li>
															@endforeach
														@endif
													</ul>
												</div>
											</div>
										</div>
									</div>
									<div class="section">
										<div class="section-title">第四步,保单拍照上传<span class="color-positive" style="font-size: 14px;font-weight: normal;">(一次最多上传10张图片，支持JPG.PNG.格式照片，大小不超过5M)</span></div>
										<div class="section-container">
											<ul class="photos-wrapper">
												<li class="photos-add">
													<div class="btn-add">添加保单</div>
													<input hidden="hidden" type="file" onchange="upLoadImg(this);" accept="image/*">
												</li>
											</ul>
										</div>
									</div>
									<button type="button" id="addRecord" class="z-btn z-btn-positive">添加</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!--成功录入线下保单弹出层-->
		<div class="popups-wrapper popups-success">
			<div class="popups">
				<div class="popups-title">线下保单录入<i class="iconfont icon-close"></i></div>
				<div class="popups-content">
					<i class="iconfont icon-shenqingchenggong"></i>
					<p>录入成功</p>
					<div>
						<button class="z-btn z-btn-positive">继续添加线下保单</button>
						<button class="z-btn-hollow">查看已添加线下保单</button>
					</div>
				</div>
			</div>
		</div>
		<!--添加产品-->
		<div class="popups-wrapper popups-product">
			<div class="popups-bg"></div>
			<div class="popups">
				<form id="productForm">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<div class="popups-content">
						<ul>
							<li><input type="text" name="product_name" placeholder="请输入新产品名称"  maxlength="50"/></li>
							<li><input type="text" name="base_price" placeholder="请输入保险金额"  maxlength="15"/></li>
							<li>
								<select name="insure_type">
									<option value="" disabled selected>--选择类型--</option>
									<option value="1">个险</option>
									<option value="2">团险</option>
								</select>
							</li>
							<li><input type="text" name="main_insure" placeholder="主险" maxlength="10"/></li>
							<li><input type="text" name="company_name" placeholder="公司名称" maxlength="30"/></li>
							<li><input type="text" name="base_stages_way" placeholder="缴别" maxlength="10"/></li>
							<li>
								<select name="classification">
									<option value="" disabled selected>--选择分类--</option>
									<option value="财产险">|----财产险</option>
									<option value="责任险">|----|----责任险</option>
									<option value="雇主责任险">|----|----|----雇主责任险</option>
									<option value="公众责任险">|----|----|----公众责任险</option>
									<option value="物流责任险">|----|----|----物流责任险</option>
									<option value="家财险">|----|----家财险</option>
									<option value="人身险">|----人身险</option>
									<option value="个人险">|----|----个人险</option>
									<option value="意外险">|----|----|----意外险</option>
									<option value="健康险">|----|----|----健康险</option>
									<option value="人寿险">|----|----|----人寿险</option>
									<option value="年金险">|----|----|----年金险</option>
									<option value="团体险">|----|----团体险</option>
									<option value="意外险">|----|----|----意外险</option>
									<option value="健康险">|----|----|----健康险</option>
								</select>
							</li>
						</ul>
						<button type="submit" class="z-btn z-btn-positive">确定</button>
					</div>
				</form>
			</div>
		</div>
		<!--线下单预览-->
		<div class="popups-wrapper popups-preview">
			<div class="popups">
				<div class="popups-title">线下保单预览<i class="iconfont icon-close"></i></div>
				<div class="popups-content">
					<div class="section">
						<h3 class="title">被保人信息</h3>
						<ul>
							<li><span class="name"><i class="red">*</i>被保人是投保人的</span>本人</li>
							<li><span class="name"><i class="red">*</i>身份证号码</span>456423345342312312313</li>
							<li><span class="name"><i class="red">*</i>姓名</span>天小眼</li>
							<li><span class="name"><i class="red">*</i>性别</span>女</li>
							<li><span class="name"><i class="red">*</i>出生日期</span>2017-12-15</li>
							<li><span class="name"><i class="red">*</i>职业</span>快递员</li>
							<li><span class="name"><i class="red">*</i>联系方式</span>15695478569</li>
							<li><span class="name"><i class="red">*</i>邮箱地址</span>1546896@qq.com</li>
							<li><span class="name">其他信息</span>无</li>
						</ul>
					</div>
					<div class="section">
						<h3 class="title">投保人信息</h3>
						<ul>
							<li><span class="name"><i class="red">*</i>身份证号码</span>456423345342312312313</li>
							<li><span class="name"><i class="red">*</i>姓名</span>天大眼</li>
						</ul>
					</div>
					<div class="section">
						<h3 class="title">产品信息</h3>
						<ul>
							<li><span class="name"><i class="red">*</i>产品ID</span>123</li>
							<li><span class="name"><i class="red">*</i>公司名称</span>平安保险</li>
							<li><span class="name"><i class="red">*</i>产品类型</span>人寿险</li>
							<li><span class="name"><i class="red">*</i>产品名称</span>安心七日游</li>
							<li><span class="name"><i class="red">*</i>主险</span>鸿福至尊（分红型）</li>
							<li><span class="name"><i class="red">*</i>佣金比率</span>10%</li>
							<li><span class="name"><i class="red">*</i>保费</span>5</li>
						</ul>
					</div>
					<div class="section">
						<h3 class="title">照片信息</h3>
						<ul class="img-wrapper">
							<li><img src="{{config('view_url.agent_url')}}img/idcard3.png" alt="" /></li>
							<li><img src="{{config('view_url.agent_url')}}img/idcard3.png" alt="" /></li>
							<li><img src="{{config('view_url.agent_url')}}img/idcard3.png" alt="" /></li>
						</ul>
					</div>
					<div style="text-align: center;">
						<button id="change" class="z-btn z-btn-positive" style="width: 160px;margin-right: 20px;">修改</button>
						<button id="confirm" class="z-btn z-btn-default" style="width: 160px;">确认</button>
					</div>
				</div>
			</div>
		</div>
		
		
		<div class="popups-wrapper popups-add popups-add-person">
			<div class="popups">
				<div class="popups-title">填写客户信息<i class="iconfont icon-close"></i></div>
				<div class="popups-content">
					<form id="custForm">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<div class="clearfix">

							<div class="form-wrapper">
								<h4 class="title">客户信息</h4>
								<ul>
									<li>
										<span class="name"><i>*</i>姓名</span>
										<input id="name2" type="text" placeholder="请填写真实姓名" name="name" maxlength="15">
										<span class="error"></span>
									</li>
									<li>
										<span class="name"><i>*</i>身份证号</span>
										<input id="idCard2" type="text" placeholder="请输入" name="code">
										<span class="error"></span>
									</li>
									<li>
										<span class="name"><i>*</i>联系方式</span>
										<input id="tel2" type="text" placeholder="请输入" maxlength="11" name="phone">
										<span class="error"></span>
									</li>
									<li>
										<span class="name"><i>*</i>邮箱地址</span>
										<input id="email2" type="text" placeholder="请输入" name="email">
										<span class="error"></span>
									</li>
									<li>
										<span class="name vtop">其他信息</span>
										<textarea placeholder="投保人其他信息说明" name="other"  maxlength="500"></textarea>
									</li>
								</ul>
							</div>

						</div>
						<p class="tips">标有<i class="red">*</i>符号的为必填项</p>
						<input type="hidden" name="company" value="2">
						<button type="submit" id="add" class="z-btn z-btn-positive">添加</button>
					</form>
				</div>
			</div>
		</div>
		
		
		<div id="company" class="popups-wrapper popups-add popups-add-company">
			<div class="popups">
				<div class="popups-title">填写客户信息<i class="iconfont icon-close"></i></div>
				<div class="popups-content">
					<div class="clearfix">
					<form id="form">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<div class="form-wrapper">

		                        <ul>
		                            <li>
		                                <span class="name"><i>*</i>企业名称</span>
		                                <input type="text" placeholder="请输入" name="company_name">
		                            </li>
		                            <li>
		                                <span class="name"></span>
		                                <label>
		                                    <input hidden="" type="radio" name="is_three_company" value="0" checked>
		                                    <span class="selected z-btn-hollow z-btn-selected">三证合一企业</span>
		                                </label>
		                                <label>
		                                    <input hidden="" type="radio" name="is_three_company" value="1">
		                                    <span class="z-btn-hollow z-btn-selected">非三证合一企业</span>
		                                </label>
		                            </li>
		                            <li class="hide">
		                                <span class="name"><i>*</i>组织机构代码</span>
		                                <input type="text" placeholder="请输入" name="organization_code">
		                            </li>
		                            <li class="hide">
		                                <span class="name"><i>*</i>营业执照编号</span>
		                                <input type="text" placeholder="请输入" name="license_code">
		                            </li>
		                            <li class="hide">
		                                <span class="name"><i>*</i>纳税人识别号</span>
		                                <input type="text" placeholder="请输入" name="tax_code">
		                            </li>
		                            <li class="show">
		                                <span class="name"><i>*</i>统一信用代码</span>
		                                <input type="text" placeholder="请输入" name="all_code">
		                            </li>
		                            {{--<li>--}}
		                                {{--<span class="name"><i>*</i>企业所在地址</span>--}}
		                                {{--<select id="province" name="province"></select>--}}
		                                {{--<select id="city" name="city"></select>--}}
		                                {{--<select id="county" name="county"></select>--}}
		                            {{--</li>--}}
		                            <li>
		                                <span class="name" style="vertical-align: top"><i>*</i>企业所在地址</span>
		                                <textarea placeholder="请输入详细地址" name="street_address"  maxlength="60"></textarea>
		                            </li>
		                            <li>
		                                <span class="name"><i>*</i>联系人姓名</span>
		                                <input id="name" type="text" placeholder="请输入" name="name"  maxlength="15">
		                                </li>
		                            <li>
		                                <span class="name"><i>*</i>手机号码</span>
		                                <input id="tel" type="text" placeholder="请输入" maxlength="11" name="phone">
		                                </li>
		                            <li>
		                                <span class="name"><i>*</i>身份证号</span>
		                                <input id="idCard" type="text" placeholder="请输入" name="code">
		                                </li>
		                            <li>
		                                <span class="name"><i>*</i>电子邮箱</span>
		                                <input id="email" type="text" placeholder="请输入" name="email">
		                                </li>
		                            <li>
		                                <span class="name">营业执照</span>
		                                <span class="z-btn-hollow btn-upload">上传照片</span>
		                                <div class="company-img-wrapper">
		                                    <div class="company-img-item">
		                                        <div class="company-img">
		                                            <img src="{{config('view_url.agent_url')}}img/yingye.png" alt="">
		                                        </div>
		                                        <div class="company-img-tips">营业执照样本展示</div>
		                                    </div>
		                                    <div class="company-img-item">
		                                        <div class="company-img upload-wrapper"></div>
		                                        <div class="company-img-tips color-positive"></div>
		                                    </div>
		                                </div>
		                                <input hidden="hidden" type="file" onchange="upload(this);" accept="image/*">
		                                <input id="business" hidden="" type="text" class="inputhidden" name="license_image">
		                                <i class="error"></i>
		                            </li>
		                        </ul>
	                            {{--<input type="hidden" name="_token" value="">--}}
	                            <input type="hidden" name="company" value="1">
							</div>
						<p class="tips">标有<i class="red">*</i>符号的为必填项</p>
						<button type="submit" class="z-btn z-btn-positive">添加</button>
					</form>
					</div>
				</div>
			</div>
		</div>
		<script src="{{config('view_url.agent_url')}}js/lib/area.js"></script>
		<script src="{{config('view_url.agent_url')}}js/lib/jquery-1.11.3.min.js"></script>
		<script src="{{config('view_url.agent_url')}}js/lib/swiper-3.4.2.min.js"></script>
		<script src="{{config('view_url.agent_url')}}js/common_agent.js"></script>
		<script src="{{config('view_url.agent_url')}}js/lib/jquery.validate.min.js"></script>
		<script src="{{config('view_url.agent_url')}}js/check.js"></script>
		<script>
			//************保单拍照上传************//
			var Ele = {
				photos_add : $('.popups-offline .photos-wrapper .photos-add'),
				photos_btn_add : $('.popups-offline .photos-wrapper .btn-add'),
				photos_wrapper : $('.popups-offline .photos-wrapper'),
			}
			const photos_total = 10;
//            new Cascade($('#province'),$('#city'),$('#county'));
			
			// 初始化
			$(".table-body").panel({iWheelStep: 32});
			$('#change').click(function(){
				Popups.close('.popups-preview');
				Popups.open('.popups-offline');
			});
			$('.popups-preview .icon-close').off().click(function(){
				Popups.close('.popups-preview');
				Popups.open('.popups-offline');
			});
			$('#confirm').click(function(){
				Popups.close('.popups-preview');
				Popups.open('.popups-success');
			});
			$('.popups-product .popups-bg').click(function(){
				Popups.close('.popups-product');
			});
			check(); // 单选
			// 是否为三证合一企业
			$('.z-btn-selected').click(function(){
				$(this).parents('li').find('.z-btn-selected').removeClass('selected');
				$(this).addClass('selected').prev().prop('checked',true);
				var index = $(this).parent().index();
				index === 1 ? $('.hide').hide() : $('.hide').show();
				index === 1 ? $('.show').show() : $('.show').hide();
			});
            var search = {
                init: function(){
                    var _this = this;

                    $('.icon-sousuo').click(function(){
                        _this.postSearch();
                    });
                    $('.search-outer select').change(function(){
                        _this.postSearch();
                    });
                    _this.addInfo();
                    _this.change();
                    _this.company();
                    $('.insure-container .selectOne').change(function(){
                        _this.change();
                        _this.company();
                    });
                    $('.insured-container .selectOne').change(function(){
                        _this.company();
                    });

                    $('.table-body label').click(function(){
                        _this.company();
                    });

                    $('.icon-sousuo').click(function(){
                        console.log($('.insured-container .table-body input:checked').val());
                    });
                },
                company: function(){
                    var insure_para=1,insured_para=1;
                    insure_para = $('.insure-container .selectOne').val();
                    insured_para = $('.insured-container .selectOne').val();
                    choose();
                    function choose(){
                        // 投保人被保人同为企业时，选择值相同,被保人其他选项禁用
                        var c = 'icon-duoxuanxuanzhong01',n = 'icon-duoxuan-weixuan';
                        if(insure_para == insured_para &&  insure_para == 2){
                            var index = $('.insure-container input:checked').parents('li').index();
                            if(index<0){return};
                            var target = $('.insured-container .table-body li').eq(index);
                            target.find('input').prop('checked',true);
                            target.find('.'+n).removeClass(n).addClass(c);
                            target.siblings().find('input').prop('disabled',true).prop('checked',false);
                            target.siblings().find('.'+c).removeClass(c).addClass(n);
                        }
                    }
                },
                change: function(){
                    var val = $('.insure-container .selectOne').val();
                    var ele = $('.insured-container .selectOne option').eq(1);
                    var inputs = $('.insured-container .table-body input');
                    if(val == 1){ele.remove();}
//                    val == 1 ? ele.hide().prev().prop('selected',true) : ele.show();
                    // 投保人为企业时 被保人个人可多选
                    val == 2 ? inputs.attr('type','checkbox') : inputs.attr('type','radio');
                },
                addInfo: function(){
                    // 添加个人或企业时对应弹出框的显影
                    $('.insure-container .search-outer,.insured-container .search-outer').each(function(){
                        var val = $(this).find('.selectOne').val();
                        var target = $(this).find('.z-btn-default');
                        val == 1 ? target.data('pop','popups-add-person') : target.data('pop','popups-add-company');
                    })
                },
                postSearch: function(){
                    var search = '';
                    $('.search-outer').each(function(){
                        $(this).find('select,input').each(function(){
                            var name = $(this).attr('name');
                            var val = $(this).val();
                            search += name+"="+val+"&";
                        });
                    });
                    search = "?"+search.slice(0,-1);
                    location.href = location.href.split('?')[0] + search;
                },
            }
            search.init();
            //上传保单
            var upLoadImg = function(e){
                uploading(e).onload = function(e){
                    var value = e.target.result;
                    var _token = $("input[name='_token']").val();
                    $.ajax({
                        type: 'post',
                        url: "/agent_sale/uploadImage",
                        data: {
                            "url": value,
                            '_token':_token
                        },
                        success: function(data) {
                            if(data.status != undefined && data.status == false){
                                Mask.alert(data.msg);
							}else {
								var html = "<li class='photos-item' style='background-image: url("+ data +");'><input hidden type='text' value="+ data +"/></li>";
                                $(html).insertBefore('.photos-wrapper .photos-add');
                                canAddPhoto();
                            }
                        },
                        error: function() {
                            Mask.alert("网络请求错误!");
                        }
                    });
                };
            };
            // 上传营业执照
            var old_val = '';
            var upload = function(e){
                var _this = $(e).parent();
                uploading(e).onload = function(e){
                    var data = e.target.result;
                    var _token = $("input[name='_token']").val();
                    $.ajax({
						type: 'post',
                        url: "/agent_sale/uploadImage",
                        data: {
                            "url": data,
                            '_token':_token,
							'old_val':old_val
                        },
                        success: function(data) {
                            var html = "<img src="+ data +" />";
                            _this.find('.upload-wrapper').html(html);
                            $('.company-img-tips.color-positive').html('上传成功');
                            $('.btn-upload').text('重新上传');
                            _this.find('.inputhidden').val(data);
                            old_val = $('.company-img-item .upload-wrapper img').attr('src');
                        },
                        error: function() {
                            Mask.alert("网络请求错误!");
                        }
                    });
                };
            };
			
			Ele.photos_btn_add.click(function(){
				$(this).parent().find('input').click();
			});
			
			// 上传照片配置
			function uploading(e){
				var _this = $(e).parent();
				var max_size=1024*1024*5;
		   		var $c = _this.find('input[type=file]')[0];
		   		var file = $c.files[0],reader = new FileReader();
		   		if(!/\/(png|jpg|jpeg|PNG|JPG|JPEG)$/.test(file.type)){
		   			Mask.alert('图片支持jpg,png格式',2);
		   			return false;
		   		}
		   		if(file.size>max_size){
		   			Mask.alert('单个文件大小必须小于等于5MB',2)
		   			return false;
		   		}
			    reader.readAsDataURL(file);
			    return reader;
			}
			// 是否可以继续拍照上传
			function canAddPhoto(){
			    var num = Ele.photos_wrapper.find('li').length;
				if(num >= photos_total+1){
		    		Ele.photos_add.hide();
		    	}else{
		    		Ele.photos_add.show();
		    	}
			}
			
			
			
			$('.btn-upload').click(function(){
				$(this).parent().find('input').click();
			});

            // 选择客户下拉列表的联动
//            psOrcpn('.insure-container .search-outer,.insured-container .search-outer',function(obj){
//                var index = obj.target.parent().find('.selectOne').get(0).selectedIndex;
//                var btn = obj.target.siblings('.z-btn');
//                index == 0 ? btn.data('pop','popups-add-person') : btn.data('pop','popups-add-company');
//            });
			
			// 添加新产品按钮是否可点击
			var offline = {
				init: function(){
					this.addProduct();
				},
				addProduct: function(){
					$(document).ready(function() {
						$("#productForm").validate();
					});
					// 提交数据
					$.validator.setDefaults({
						submitHandler: function() {
							var jsonData = $('#productForm').serializeArray();
                            var data = changeData(jsonData);
                            var _token = $("input[name='_token']").val();
							$.ajax({
								type: 'post',
								url: "addProduct",
								data: {                            
									"cust": data,
                                    '_token':_token
								},
								success: function(data) {
                                    if(data['msg'] != undefined){
                                        Mask.alert(data['msg']);
                                    }else{
                                        location.href='offline';
                                    }
								},
								error: function() {
									Mask.alert("网络请求错误!",2);
								}
							});
						}
					});
					// 校验规则 
					$('#productForm').validate({
						rules: {
							product_name: {required: true,sqlCheck: true},
							base_price: {required: true,price: true},
							insure_type: {required: true},
							main_insure: {required: true,sqlCheck: true},
							company_name: {required: true,sqlCheck: true},
							base_stages_way: {required: true,sqlCheck: true},
							classification: {required: true}
						},
						focusInvalid: true,
						onkeyup: function(element) {$(element).valid();},
						errorPlacement: function(error, element) {
							error.appendTo(element.parent());
						}
					});
				}
			}
			offline.init();
			
			$('.z-btn-default').click(function(){
				var target = $(this).data('pop');
				Popups.close('.popups-handle');
				Popups.open('.'+target,function(){
					Popups.open('.popups-handle');
				});
				if(target=='popups-product'){
					Popups.open('.popups-offline');
				}
			});
			
			$('.popups-offline .popups-title .icon-close').click(function(){
				window.parent.$(".link-wrapper").hide();
			});
			
			// 填写客户信息-个人
			// 校验
			$(document).ready(function() {
				$("#custForm").validate();
			});
			// 提交数据
			$.validator.setDefaults({
				submitHandler: function() {
					if(!isRealName($('#name2'))){
						return false;
					}else{
						// 通过校验，调用接口
						var jsonData = $('#custForm').serializeArray();
						var data = changeData(jsonData);
                        var _token = $("input[name='_token']").val();
                        $.ajax({
                            type: 'post',
                            url: "addCust",
                            data: {
                            	"cust": data,
                                '_token':_token
                            },
                        	success: function(data) {
                                if(data['msg'] != undefined){
                                    Mask.alert(data['msg']);
                                }else{
                                    location.href='offline';
                                }
                            },
                        	error: function() {
                            	Mask.alert("网络请求错误!");
                            }
                        });
					}
				}
			});
            function changeData(data){
                var result = {};
                for(i in data){
                    if(data[i].name == '_token'){
                        continue;
					}
                    result[data[i].name] = data[i].value;
                }
                return result;
            }
			// 校验规则 
            $('#custForm').validate({
                rules: {
                    name: {
                        required: true,
                        byteRangeLength: [3, 50]
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    phone: {
                        required: true,
                        isMobile: true
                    },
                    code: {
                        required: true,
                        isIdCardNo: true
                    },
                    other: {
                        sqlCheck: true,
                    },
                },
                messages: {
                    name: {
                        byteRangeLength: errorMessages.namelength
                    }
                },
                focusInvalid: true,
                onkeyup: function(element) {$(element).valid();},
                errorPlacement: function(error, element) {
                    error.appendTo(element.parent());
                }
            });
			
			
			// 填写客户信息-企业
			// 提交数据
			$.validator.setDefaults({
				submitHandler: function() {
					if(!isRealName($('#name')) || !checkUpload($('#business'))){
						return false;
					}else{
						// 通过校验，调用接口
                        var jsonData = $('#form').serializeArray();
                        var data = changeData(jsonData);
                        var _token = $("input[name='_token']").val();
                        $.ajax({
                            type: 'post',
                            url: "addCust",
                            data: {
                                "cust": data,
                                '_token':_token
                            },
                        	success: function(data) {
                                if(data['msg'] != undefined){
                                    Mask.alert(data['msg']);
                                }else{
                                    location.href='offline';
                                }
                            },
	                        error: function() {
	                            Mask.alert("网络请求错误!");
	                        }
	                    });
					}
				}
			});
			$(document).ready(function() {
				$("#form").validate();
			});

			//开始验证 
            $('#form').validate({
                rules: {
                    company_name: {
                        required: true,
                        stringCheck: true,
                    },
                    all_code: {
                        required: true,
                        sqlCheck: true,
                        creditCheck: true,
                        notStringCheck: true
                    },
                    organization_code: {
                        required: true,
                        sqlCheck: true,
                        organizationCheck: true,
                    },
                    license_code: {
                        required: true,
                        sqlCheck: true,
                        licenseCheck: true,
                        notStringCheck: true
                    },
                    tax_code: {
                        required: true,
                        sqlCheck: true,
                        notStringCheck: true
                    },
                    street_address: {
                        required: true,
                        sqlCheck: true,
                        stringCheck: true
                    },
                    name: {
                        required: true,
                        byteRangeLength: [3, 50]
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    phone: {
                        required: true,
                        isMobile: true
                    },
                    code: {
                        required: true,
                        isIdCardNo: true
                    }
                },
                messages: {
                    linkman_name: {
                        byteRangeLength: errorMessages.namelength
                    }
                },
                focusInvalid: true,
                onkeyup: function(element) {$(element).valid();},
                errorPlacement: function(error, element) {
                    error.appendTo(element.parent());
                }
            });

			// 添加线下单校验
			$('#addRecord').click(function(){
				if(!isChecked('.insure-container .client-wrapper')){
					Mask.alert('投保人未选择，请选择',2);
				}else if(!isChecked('.insured-container .client-wrapper')){
					Mask.alert('被保人未选择，请选择',2);
				}else if(!isChecked('.product-wrapper')){
					Mask.alert('产品未选择，请选择',2);
				}else if(!$('.popups-offline .photos-wrapper .photos-item').length){
					Mask.alert('保单未上传，请上传',2);
				}else{
					// 通过验证，提交数据
					var result = {},images = [],recognize = [];
                    var data = $('#info').serializeArray();
                    $('.insured-container .table-body input:checked').each(function(index){
                        recognize.push(parseInt($(this).val()));
                    });
                    for(i in data){
                        var reg = /recognize/g;
                        if(reg.test(data[i].name)){
                            result['recognize_id'] = recognize;
                            continue;
                        }
                        result[data[i].name] = data[i].value;
                    }
                    $('#info .photos-item input').each(function(){
						images.push($(this).val());
					});
					result.image = images;
                    var previewResult = JSON.stringify(result);
                    window.location.href="offlinePreview?preview="+previewResult;
//					$.ajax({
//						url: "offlinePreview",
//						data: result,
//						success: function(data) {
//							Popups.close('.popups-handle');
//							Popups.open('.popups-preview');
//						},
//						error: function() {
//							Mask.alert("网络请求错误!");
//						}
//					});
				}
			});
			
			// 投保人、被保人、产品至少各选一项
			function isChecked(ele){
				var status = false;
			    $(ele).find('input').each(function(){
					if($(this).prop('checked')){
						status = true;
						return false;
					}
				});
				return status;
			}
			
			// 继续添加记录
			$('.popups-success .z-btn-positive').click(function(){
				Popups.close('.popups-success');
				Popups.open('.popups-handle');
			});
			
		</script>
	</body>
</html>
