@extends('backend_v2.layout.base')
@section('title')产品管理 @stop
@section('head-more')
	<link rel="stylesheet" href="{{asset('r_backend/v2/css/product.css')}}" />
@stop
@section('top_menu')
	@include('backend_v2.product.product_top')
@stop
@section('main')
		<div id="product" class="main-wrapper">
			<div class="row">
				<ol class="breadcrumb col-lg-12">
				    <li><a href="/backend/product/product_list">产品管理</a><i class="iconfont icon-gengduo"></i></li>
				    <li><a href="/backend/product/product_stay_on">待上架产品</a><i class="iconfont icon-gengduo"></i></li>
					<li class="active">{{$product_res['res'][0]['name']}}<i class="iconfont icon-gengduo"></i></li>
				    <li class="active">个性化编辑</li>
				</ol>
			</div>
			<form action="{{ url('/backend/product/do_product_details_edit')}}"  method="post" id="do_product_details_edit" enctype="multipart/form-data">
				{{ csrf_field() }}
				<input type="hidden" name="ty_product_id" value="{{$product_res['res'][0]['id']}}">
				<div class="row">
					<div class="col-md-7 policy">
						<div class="policy-content">
							<div class="policy-wrapper scroll-pane">
								<div class="product-avatar">
									<div class="product-img">
										<img src="{{ asset('/r_backend/v2/img/avatar.png')}}" alt="" />
										<input hidden onchange="upLoadImg(this);" name="product_cover" accept="image/*" type="file">
										<input hidden type="text">
									</div>
									<button type="button" id="up-cover" class="btn btn-default fr">上传封面</button>
								</div>
								<div class="policy-info">
									<h3 class="title">{{$product_res['res'][0]['name']}}</h3>
									<button type="button"  class="btn btn-warning" data-toggle="modal" data-target="#addTags">添加标签</button>
								</div>
								<div class="policy-list">
									<p><span class="name">创建时间</span><i>:</i>{{$product_res['res'][0]['created_at']}}</p>
									<p><span class="name">上架时间</span><i>:</i>-</p>
									<p><span class="name">公司名称</span><i>:</i>{{$product_res['res'][0]['company']['display_name']}}</p>
									<p><span class="name">保险险种</span><i>:</i>{{$product_res['res'][0]['category']['name']}}</p>

									<div><span class="name vtop">条款</span><i class="vtop">:</i>
										<ul class="duty-list">
											@foreach($product_res['clause'] as $value)
											<li><a href="{{env('TY_API_PRODUCT_SERVICE_URL').'/'.$value['file_url']}}" target="_blank">{{$value['name']}}</a></li>
											@endforeach
										</ul>
									</div>
									@php $json =$product_res['res'][0]; @endphp
									<div><span class="name vtop">责任保额</span><i class="vtop">:</i>
										@php
										$i = 1;
										@endphp
										<ul class="duty-list">
											@foreach($json['clauses'] as $ck => $cv)
												@foreach($cv['duties'] as $dk => $dv)
											<li><span class="duty-name" >{{ $dv['name'] }}</span>
												{{ preg_match('/^\d{5,}$/', $dv['pivot']['coverage_jc']) ?  $dv['pivot']['coverage_jc'] / 10000 . '万元' : $dv['pivot']['coverage_jc'] }}</li>
											@php
											$i++;
											@endphp
											@endforeach
										@endforeach
										</ul>
									</div>
									{{--<p><span class="name">特别约定</span><i>:</i>保障期内在发生任何风险都不进行赔偿。</p>--}}
									{{--<p><span class="name">费率表</span><i>:</i><a href="#">查看详情</a></p>--}}
									{{--<p><span class="name">缴费方式</span><i>:</i>年缴</p>--}}
									{{--<p><span class="name">缴费期限</span><i>:</i><span class="mr">20年</span><span class="mr">15年</span><span class="mr">10年</span><span class="mr">5年</span><span class="mr">趸交</span></p>--}}
									{{--<p><span class="name">年龄限制</span><i>:</i>18-60周岁</p>--}}
									{{--<p><span class="name">职业类别</span><i>:</i>1-4类   <a href="#"> 职业类别表</a></p>--}}
									{{--<div><span class="name vtop">产品简介</span><i class="vtop">:</i>--}}
										{{--<ul class="duty-list">--}}
											{{--<li>中国人寿保险中国人寿保险中国人寿保险中国人寿保险中国人寿保险中国人寿保险 中国人寿保险中国人寿保险中国人寿保险中国人寿保险中国</li>--}}
										{{--</ul>--}}
									{{--</div>--}}
									<div><span class="name vtop">产品介绍</span><i class="vtop">:</i>
										<div class="duty-list duty-info">
											{{$product_res['res'][0]['content']}}
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				<div class="col-md-5 info">
					<div class="upload-wrapper">
						<div class="upload">
							<h3 class="title">上传产品介绍图</h3>
							<ul class="img-wrapper">
								<li>
									<img src="{{ asset('/r_backend/v2/img/add.png')}}" alt="" />
									<input hidden="hidden" onchange="upLoadLimit(this);" name="person_img[]" accept="image/*" type="file">
									<input hidden type="text">
								</li>
								<li>
									<img src="{{ asset('/r_backend/v2/img/add.png')}}" alt="" />
									<input hidden onchange="upLoadLimit(this);" name="person_img[]" accept="image/*" type="file">
									<input hidden type="text">
								</li>
								<li>
									<img src="{{ asset('/r_backend/v2/img/add.png')}}" alt="" />
									<input hidden onchange="upLoadLimit(this);" name="person_img[]" accept="image/*" type="file">
									<input hidden="" type="text">
								</li>
								<li>
									<img src="{{ asset('/r_backend/v2/img/add.png')}}" alt="" />
									<input hidden onchange="upLoadLimit(this);" name="person_img[]"  accept="image/*" type="file">
									<input hidden type="text">
								</li>
								<li>
									<img src="{{ asset('/r_backend/v2/img/add.png')}}" alt="" />
									<input hidden onchange="upLoadLimit(this);" name="person_img[]" accept="image/*" type="file">
									<input hidden type="text">
								</li>
							</ul>
						</div>
						<div class="explain">
							<h3 class="title">上传须知：</h3>
							<ul class="explain-list">
								<li>1.第一张图为产品主图</li>
								<li>2.上传尺寸不得大于850×600px,，大小不超过3M，图片格式（jpg、png）<span class="color-default">（建议尺寸为850×600px）</span></li>
								<li>3.上传限制5张图片</li>
								<li>4.不建议多次使用同一张图片</li>
							</ul>
						</div>
					</div>
					<div class="operation">
						<button type="button" id="btn-preview" disabled class="btn btn-warning" data-toggle="modal" data-target="#preview">预览</button>
						{{--<button type="button"  class="btn btn-primary" data-toggle="modal" data-target="#audit">提交审核</button>--}}
						<button class="btn btn-primary">提交审核</button>
					</div>
				</div>
			</div>
			</form>
		</div>

		<div class="modal fade" id="preview" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog modal-alert" role="document">
				<div class="modal-content">
					<div class="modal-header notitle">
						<button type="button" class="" data-dismiss="modal" aria-label="Close"><i class="iconfont icon-cancel"></i></button>
					</div>
					<div class="modal-body">
						{{--图片预览--}}
						<ul class="preview-list"></ul>
					</div>
				</div>
			</div>
		</div>
		{{--上传成功提示--}}
		<div class="modal fade" id="audit" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog modal-alert" role="document">
				<div class="modal-content">
					<div class="modal-header notitle">
						<button type="button" class="" data-dismiss="modal" aria-label="Close"><i class="iconfont icon-cancel"></i></button>
					</div>
					<div class="modal-body">
						<i class="iconfont icon-duihao"></i>
						<p>成功上传,审核通过后便可商上架销售</p>
					</div>
					<div class="modal-footer">
						<a href="/backend/product/product_list" class="color-primary">回到产品列表</a>
						<a href="/backend/product/product_rank_list" class="color-default">回到产品管理</a>
					</div>
				</div>
			</div>
		</div>
		{{--产品标签添加成功--}}
		<div class="modal fade" id="label_relevance_success" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog modal-alert" role="document">
				<div class="modal-content">
					<div class="modal-header notitle">
						<button type="button" class="refresh_close" data-dismiss="modal" aria-label="Close"><i class="iconfont icon-cancel"></i></button>
					</div>
					<div class="modal-body">
						<i class="iconfont icon-duihao"></i>
						<p>产品标签添加成功</p>
					</div>
					<div class="modal-footer">
						<a href="/backend/product/product_list" class="color-primary">回到产品列表</a>
						<a href="/backend/product/product_rank_list" class="color-default">回到产品管理</a>
					</div>
				</div>
			</div>
		</div>
		{{--标签--}}
		<div class="modal fade in" id="addTags" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header notitle">
						<button type="button" class="" data-dismiss="modal" aria-label="Close" ><i class="iconfont icon-cancel"></i></button>
					</div>
					<form action="/backend/label/do_label_relevance" method="post" id="do_label_relevance">
						{{ csrf_field() }}
						<input type="hidden" name="label_belong" value="product">
						<input type="hidden" name="label_relevance" value="{{$product_res['res'][0]['id']}}">
					<div class="modal-body">
						<div class="title">已选择标签</div>
						<div class="selected-wrapper">
							<div class="selected">
								@if(count($product_labels_res)=='0')
									<span class="tag">暂无标签</span>
								@else
									@foreach($product_labels_res as $value)
										<span data-id="{{$value['id']}}" class="tag">{{$value['name']}}<i class="iconfont icon-quxiao"></i></span>
									@endforeach
								@endif
							</div>
						</div>
						<ul class="tags-classify">
							<li>
								<label>选择标签分类</label>
								<select class="form-control" id="label_type">
									<option value="global">全局标签</option>
									<option value="special">特有标签</option>
								</select>
							</li>
							<li>
								<label>选择标签组</label>
								<div class="tags-wrapper global_labels" style="display: block;" >
									<ul>
										@if(count($global_labels)=='0')
											<li class="tag-no">暂无全局标签</li>
										@else
											@foreach($global_labels as $value)
												<li class="tag" data-value="{{$value['id']}}">
													{{$value['name']}}
												</li>
											@endforeach
										@endif
									</ul>
								</div>
								<div class="tags-wrapper special_labels" style="display: none;">
									<ul>
										@if(count($special_labels)=='0')
											<li class="tag-no">暂无全局标签</li>
										@else
											@foreach($special_labels as $value)
												<li class="tag" data-value="{{$value['id']}}">
													{{$value['name']}}
												</li>
											@endforeach
										@endif
									</ul>
								</div>
							</li>
							<li>
								<label>选择产品标签</label>
								<div class="tags-wrapper global_labels" >
									<ul>
										@if(count($labels_global_res)=='0')
											<li class="tag-no">暂无全局标签</li>
										@else
											@foreach($labels_global_res as $value)
												<li class="tag" data-value="{{$value['id']}}">
													{{$value['name']}}
												</li>
											@endforeach
										@endif
									</ul>
								</div>
								<div class="tags-wrapper special_labels" >
									<ul>
										@if(count($labels_special_res)=='0')
											<li class="tag-no">暂无全局标签</li>
										@else
											@foreach($labels_special_res as $value)
												<li class="tag" data-value="{{$value['id']}}">
													{{$value['name']}}
												</li>
											@endforeach
										@endif
									</ul>
								</div>
							</li>
						</ul>
					</div>
					</form>
					<div class="modal-footer">
						<button class="btn btn-primary" id="label_relevance_post">确定</button>
					</div>
				</div>
			</div>
		</div>
		<script src="{{asset('r_backend/v2/js/lib/jquery-1.11.3.min.js')}}"></script>
		<script src="{{asset('r_backend/v2/js/common_backend.js')}}"></script>
		<script>
			$('body').on('click','.icon-quxiao',function () {
                var id = $(this).parent().data('id');
                delGroup(id);
                $(this).parent().remove();
            });
			$('.icon-quxiao').on('click',function () {

            });
            // 删除组事件
            function delGroup(id){
                    $.ajax( {
                        type : "get",
                        url : "/backend/label/del_label_relevance",
                        dataType : 'json',
                        data : {label_id:id}
                    });
            }
            $('.refresh_close').on('click',function () {
                location.href = location;
            })
            $('#label_relevance_post').click(function(){
                var label_relevance = "{{$product_res['res'][0]['id']}}";
                var label_belong = "product";
                $.ajax( {
                    type : "get",
                    url : "/backend/label/do_label_relevance",
                    dataType : 'json',
                    data : {label_relevance:label_relevance,label_belong:label_belong,label_id:arr},
                    success:function(msg){
                        if(msg.status == 0){
                            $('#addTags').modal('hide');
                            $('#label_relevance_success').modal('show');
                        }
                    }
                });
            });
            var arr = [];
            $('.tags-wrapper .tag').click(function () {
                var value = $(this).data('value');
                arr.push(value);
            });
			// 上传封面
			$('#up-cover').click(function(){
				$('.product-img').find('input:hidden').eq(0).click();
			});
            $('.tags-wrapper .tag').click(function(){
                $(this).toggleClass('selected');
                if($(this).hasClass('selected')){
                    var text = $(this).text();
                    var html = '<span class="tag">'+ text +'<i class="iconfont icon-quxiao" style="display: inline;"></i></span>';
                    $('.selected-wrapper').append(html)
                }

            });
            // 上传产品介绍图
			$('.img-wrapper img').click(function(){
				$(this).parent().find('input:hidden').eq(0).click();
			});
			//ajax  获取标签组下面的标签
			$('#label_type').on('change',function () {
                var label_type = $('#label_type').val();
                console.log(label_type);
                if(label_type=='special'){
                    $('.global_labels').hide();
                    $('.special_labels').show();
                }else if(label_type=='global'){
                    $('.global_labels').show();
                    $('.special_labels').hide();
                }
            });
			var upLoadLimit = function(e){
				var _this = $(e).parent();
				var $c = _this.find('input[type=file]')[0];
				var file = $c.files[0],reader = new FileReader();
				
				var max_size = 3145728;
				
				if(!/\/(png|jpeg|PNG|JPEG|jpg|JPG)$/.test(file.type)){
		   			Mask.alert('图片支持jpg,png格式',2);
		   			return false;
		   		}
		   		if(file.size>max_size){
		   			Mask.alert('单个文件大小必须小于等于3MB',2)
		   			return false;
		   		}
			    reader.readAsDataURL(file);
			    reader.onload = function(e){
			    	_this.find('img').attr('src',e.target.result);
			    	var $targetEle = _this.find('input:hidden').eq(1);
			    	$targetEle.val(e.target.result);
			    	console.log($targetEle.val())
                    var html = '<li><img src="'+ e.target.result +'" alt=""></li>'
                    $('.preview-list').append(html);

                    if($('#btn-preview').prop('disabled',true)){
                        $('#btn-preview').prop('disabled',false);
                    }

                };
			};
			$(document).on('click','.selected-wrapper',function(e){
				var target = $(e.target);
				if(target.hasClass('selected-wrapper')){
					
					$(this).toggleClass('focus');
				
					if($(this).hasClass('focus')){
						$('#addTag').focus();
					}else{
						$('#addTag').blur();
					}
				}
			})
            $(".duty-details").panel({iWheelStep:32});
            var html = '<li><img src="'+ e.target.result +'" alt=""></li>'
            $('.preview-list').append(html);
            if($('#btn-preview').prop('disabled',true)){
                $('#btn-preview').prop('disabled',false);
            }
		</script>
@stop