<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>线下保单填写</title>
		<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
		<link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/lib/mui.min.css">
		<link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/lib/iconfont.css" />
		<link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/common_agent.css" />
		<link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/make.css" />
		<link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/offline.css" />
	</head>
	<body>
		<div class="main">
			<header id="header" class="mui-bar mui-bar-nav">
				<a class="iconfont icon-fanhui mui-pull-left mui-action-back"></a>
				<h1 class="mui-title">线下保单填写</h1>
			</header>
			<div class="mui-content">
				<form id="info">
					<div class="mui-scroll-wrapper">
						<div class="mui-scroll">
							<div class="form-wrapper form-insure">
								<div class="title">投保人/企业信息</div>
								<ul class="init-client init-insure">
									<li style="text-align: center;">
										<a href="/agent_sale/offlineCustList" class="goTo zbtn zbtn-default">从客户列表导入</a>
										<a here="javascript:void(0)" class="zbtn zbtn-hollow"><i class="iconfont icon-add"></i>添加投保人</a>
									</li>
								</ul>
								<ul class="import-client import-insure">
									<input hidden type="text" value="1" name="policy_id"/>
									<li>
										<span class="name">姓名</span>
										<input type="text" value="天小眼" readonly/>
									</li>
									<li>
										<span class="name">性别</span>
										<input type="text" value="男" readonly/>
									</li>
									<li>
										<span class="name">年龄</span>
										<input type="text" value="38岁" readonly/>
									</li>
								</ul>
							</div>
							<div class="form-wrapper form-insured">
								<div class="title">被保人信息<span id="insured-error" class="red"></span></div>
								<ul class="init-client init-insured">
									<li style="text-align: center;">
										<a data-tag="insuredId" href="offline_client_list.html" class="goTo zbtn zbtn-default">从客户列表导入</a>
										<a class="zbtn zbtn-hollow"><i class="iconfont icon-add"></i>添加被保人</a>
									</li>
								</ul>
								<div class="import-client import-insured-more">
									<ul>
										<li>
											<input hidden type="text" value="1" name="recognize_id1"/>
											<span class="name">被保人1</span>
											<input style="width: 60%;text-decoration: underline;" type="text" value="天小眼" readonly/>
											<i class="iconfont icon-delete"></i>
										</li>
										<li>
											<input hidden type="text" value="2" name="recognize_id2"/>
											<span class="name">被保人1</span>
											<input style="width: 60%;text-decoration: underline;" type="text" value="天小眼" readonly/>
											<i class="iconfont icon-delete"></i>
										</li>
										<li>
											<input hidden type="text" value="3" name="recognize_id3"/>
											<span class="name">被保人1</span>
											<input style="width: 60%;text-decoration: underline;" type="text" value="天小眼" readonly/>
											<i class="iconfont icon-delete"></i>
										</li>
									</ul>
								</div>
							</div>
							<div class="form-wrapper form-product">
								<div class="title">产品信息</div>
								<ul class="info init-product">
									<li style="text-align: center;">
										<a href="product_list.html" class="goTo zbtn zbtn-default">从产品列表导入</a>
										<a href="offline_product.html" class="goTo zbtn zbtn-hollow"><i class="iconfont icon-add"></i>添加新产品</a>
									</li>
								</ul>
								
								<ul class="import-product">
									<input hidden type="text" value="1" name="product_id"/>
									<li>
										<span class="name">产品名称</span>
										<input id="pname" type="text" value="平安国庆七日游计划一" readonly/>
									</li>
									<li class="show">
										<span class="name">产品期限</span>
										<input type="text" value="保至100周岁" readonly/>
									</li>
									<li class="pickerDate">
										<span class="name">保险金额</span>
										<input id="pprice" type="text" value="2000元/份" readonly/>
									</li>
									<li class="show">
										<span class="name">缴费期限</span>
										<input type="text" value="3年交" readonly/>
									</li>
									<li class="show">
										<span class="name">首年保费</span>
										<input type="text" value="5000元" readonly/>
									</li>
								</ul>
							</div>
							<div class="form-wrapper">
								<div class="title">保单拍照上传<span class="color-positive" style="font-size: .2rem;">（一次最多上传10张图片，大小不超过5M）</span></div>
								<ul class="photos-wrapper">
									<li class="btn-add">
										<img src="{{config('view_url.agent_mob')}}img/add-underline.png" alt="" />
										<input id="addPhoto" hidden="hidden" type="file" accept="image/*" capture="camera"/>
									</li>
								</ul>
							</div>
						</div>
					</div>
					<div class="button-box">
						<button type="button" id="create" class="zbtn zbtn-default" disabled>录入</button>
					</div>
				</form>
			</div>
		</div>
		
		<div class="mui-popover photo-popover">
			<i class="iconfont icon-delete"></i>
			<div class="content">
				<img id="preview" src="" alt="" />
			</div>
		</div>
		<!--选择客户类型-->
		<div class="mui-popover popover-client">
			<div class="popover-wrapper">
				<div class="title">添加的客户类型<i class="iconfont icon-close"></i></div>
				<div class="popover-content">
					<ul>
						<li>
							<a href="offline_person.html">
								<div class="iconfont-wrapper"><i class="zicon zicon-user"></i></div>
								<div class="text-wrapper">个人客户</div>
							</a>
						</li>
						<li>
							<a href="offline_company.html">
								<div class="iconfont-wrapper"><i class="iconfont icon-businesscard_fill"></i></div>
								<div class="text-wrapper">企业客户</div>
							</a>
						</li>
					</ul>
				</div>
			</div>
		</div>
		
		<script src="{{config('view_url.agent_mob')}}js/lib/jquery-1.11.3.min.js"></script>
		<script src="{{config('view_url.agent_mob')}}js/lib/mui.min.js"></script>
		<script src="{{config('view_url.agent_mob')}}js/common_agent.js"></script>
		<script type="text/javascript">
			var Ele = {
				photos_wrapper : $('.photos-wrapper'),
				photos_add : $('.btn-add'),
				create : $('#create'),
				
				import_insure : $('.import-insure'),
				init_insure : $('.init-insure'),
				import_insured : $('.import-insured'),
				init_insured : $('.init-insured'),
				import_product : $('.import-product'),
				init_product : $('.init-product'),
				
				form_insure: $('.form-insure'),
				form_insured: $('.form-insured'),
				form_product: $('.form-product'),
			}
			const photos_total = 10; // 最多上传照片个数
			
			var offline = {
				init: function(){
					var _this = this;
					$('.import-insured-more .icon-delete').on('tap',function(){
						$(this).parent().remove();
					})
					// 录入信息操作
					Ele.create.on('tap',function(){
						_this.success();
					});
					Ele.photos_add.on('tap',function(){
						$(this).find('input').click();
					});
					
					$('.form-insure .zbtn-hollow,.form-insured .zbtn-hollow').on('tap',function(){
						mui('.popover-client').popover('toggle');
					});
					
					$('#addPhoto').on('change',function(){
						_this.addPhoto(this);
					})
					_this.photoOption();
					_this.checkType();
				},
				checkType: function(){
					var insureType = parseInt(sessionStorage.getItem('insureType')),
						insuredType = parseInt(sessionStorage.getItem('insuredType'));
					if(insureType == 0 && insuredType == 1){
						$('#insured-error').text('被保人不可为企业');
						Ele.create.prop('disabled',true);
					}else{
						$('#insured-error').text('');
					}
				},
				addPhoto: function(e){
					var _this = this;
					var $c = $(e).parent().find('input[type=file]')[0];
					var file = $c.files[0],reader = new FileReader();
				    reader.readAsDataURL(file);
				    reader.onload = function(e){
				    	var value = e.target.result;
				    	$.ajax({
							url: "http://g.cn",
							data: {                            
								"url": data    
							},
							success: function(data) {
								var html = '<li class="photos-item" style="background-image:url('+ data +')"><input hidden type="text" value="'+ data +'"/></li>';
						    	$(html).insertBefore('.photos-wrapper .btn-add');
						    	_this.canAddPhoto();
						    	_this.isDisable();
							},
							error: function() {
								Mask.alert("网络请求错误!");
							}
						});
					};
				},
				photoOption: function(){
					var _this = this;
					var index; // 预览照片的索引
					// 预览照片
					Ele.photos_wrapper.on('tap','.photos-item',function(){
						index = $(this).index();
						var src = $(this).css('background-image');
						$('#preview').attr('src',src.split('(')[1].slice(1,-2));
						mui('.photo-popover').popover('toggle');
					});
					
					// 删除照片
					$('.photo-popover .icon-delete').on('tap',function(){
						mui('.photo-popover').popover('toggle');
						$('.photos-item').eq(index).remove();
						_this.canAddPhoto();
					});
				},
				canAddPhoto: function(){
					var num = Ele.photos_wrapper.find('li').length;
					if(num >= photos_total+1){
			    		Ele.photos_add.hide();
			    	}else{
			    		Ele.photos_add.show();
			    	}
				},
				isDisable: function(){
					var _this = this;
					var insure = Ele.import_insure.is(':visible');
					var insured = Ele.import_insured.is(':visible');
					var product = Ele.import_product.is(':visible');
					if(insure&&insured&&product){
						Ele.create.prop('disabled',false);
					}
					_this.checkType();
				},
				success: function(){
					var result = {};
					var images = [];
					var recognize = [];
					var data = $('#info').serializeArray();
					$('.form-insured input').each(function(index){
						var reg = /recognize/g;
						if(reg.test($(this).prop('name'))){
							recognize.push(parseInt($(this).val()));
						}
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
					console.log(result);
					// 录入信息
					$.ajax({
						url: "http://g.cn",
						data: {
							"result": result
						},
						success: function(data) {
							location.href = 'success_offline.html';
						},
						error: function() {
							Mask.alert("网络请求错误!");
						}
					});
				}
			};
			offline.init();
			
			// 投保人标识
			Ele.form_insure.find('.goTo').on('tap',function(){
				sessionStorage.setItem('isInsure',1);
			});
			
			// 被保人标识
			Ele.form_insured.find('.goTo').on('tap',function(){
				sessionStorage.setItem('isInsure',0);
			});
		</script>
	</body>
</html>
