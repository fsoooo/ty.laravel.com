@extends('backend_v2.layout.base')
@section('title')@parent 保单管理 @stop
@section('head-more')
	<link rel="stylesheet" href="{{asset('r_backend/v2/css/policy.css')}}" />
@stop

@section('top_menu')
	<div class="nav-top-wrapper fl">
		<ul>
			<li>
				<a href="{{url('/backend/policy/')}}" >个人保单</a>
			</li>
			<li>
				<a href="{{url('/backend/policy/policy_company/')}}">企业保单</a>
			</li>
			<li class="active">
				<a href="{{url('/backend/policy/policy_offline/')}}">线下保单</a>
			</li>
		</ul>
	</div>
@stop
@section('main')
		<div class="main-wrapper">
			<div class="row">
				<ol class="breadcrumb col-lg-12">
				    <li><a href="{{url('/backend/policy/')}}">保单管理</a><i class="iconfont icon-gengduo"></i></li>
				    <li><a href="{{url('/backend/policy/policy_offline/')}}">线下保单</a><i class="iconfont icon-gengduo"></i></li>
				    <li class="active">保单详情</li>
				</ol>
			</div>

			<form id="update_form" action="/backend/policy/update_policy_offline" method="post">
			<input type="hidden" name="_token" value="{{csrf_token()}}" />
			<input type="hidden" name="warranty_image" value="" />
			<div class="row section">
				<div class="col-lg-12">
					<h3 class="title">保险合同照片</h3>
					<div class="default-div">
						<ul class="contracts">
						@if(!is_null($warrantyDetail['warranty_image']))
							@foreach(json_decode($warrantyDetail['warranty_image'],true) as $warranty_image)
							<li class="col-xs-3 img" style="background-image: url({{asset($warranty_image)}});">									
								<div class="btn-delete">删除</div>									
								<input hidden type="text" value="{{asset($warranty_image)}}">
							</li>
							@endforeach
						@endif
							<li class="col-xs-3 img-upload">
								<div class="btn-upload"  style="background-image: url({{asset('/r_backend/v2/img/btn_add.png')}});"></div>
								<input hidden accept="image/*" type="file">
							</li>
						</ul>
					</div>
				</div>
			</div>
			<div class="row section section-policy">
				<div class="col-lg-12">
					<h3 class="title">保单信息</h3>
					<div class="default-div">
						<ul>
							<li class="col-lg-3 col-md-6">
								<span class="name">公司名称</span><input class="mustFill" type="text" maxlength="20" value="{{$warrantyDetail['company_name']}}" readonly/>
							</li>
							<li class="col-lg-3 col-md-6">
								{{--<input hidden id="insure_type" value="{{$warrantyDetail['insure_type']}}"/>--}}
								<span class="name">产品类型</span>
								<input class="mustFill" type="text" maxlength="20" value="@if($warrantyDetail['insure_type']==1)个险@else团险@endif" readonly/>
								{{--<select id="select_insure_type" class="form-control">--}}
									{{--<option value="" disabled selected>--选择类型--</option>--}}
									{{--<option value="1">个险</option>--}}
									{{--<option value="2">团险</option>--}}
								{{--</select>--}}
							</li>
							<li class="col-lg-3 col-md-6">
{{--								<input hidden id="product_category" value="{{$warrantyDetail['product_category']}}"/>--}}
								<span class="name">产品分类</span>
								<input class="mustFill" type="text" maxlength="20" value="{{$warrantyDetail['product_category']}}" readonly/>
								{{--<select id="select_category" class="form-control">--}}
			                        {{--<option value="" disabled selected>--选择分类--</option>--}}
			                        {{--<option value="财产险">|----财产险</option>--}}
			                        {{--<option value="责任险">|----|----责任险</option>--}}
			                        {{--<option value="雇主责任险">|----|----|----雇主责任险</option>--}}
			                        {{--<option value="公众责任险">|----|----|----公众责任险</option>--}}
			                        {{--<option value="物流责任险">|----|----|----物流责任险</option>--}}
			                        {{--<option value="家财险">|----|----家财险</option>--}}
			                        {{--<option value="人身险">|----人身险</option>--}}
			                        {{--<option value="个人险">|----|----个人险</option>--}}
			                        {{--<option value="意外险">|----|----|----意外险</option>--}}
			                        {{--<option value="健康险">|----|----|----健康险</option>--}}
			                        {{--<option value="人寿险">|----|----|----人寿险</option>--}}
			                        {{--<option value="年金险">|----|----|----年金险</option>--}}
			                        {{--<option value="团体险">|----|----团体险</option>--}}
			                        {{--<option value="意外险">|----|----|----意外险</option>--}}
			                        {{--<option value="健康险">|----|----|----健康险</option>--}}
			                    {{--</select>--}}
							</li>
							<li class="col-lg-3 col-md-6">
								<span class="name">产品名称</span><input class="mustFill" type="text" maxlength="20" value="{{$warrantyDetail['product_name']}}" readonly/>
							</li>
							<li class="col-lg-3 col-md-6">
								<span class="name">缴费方式</span><input class="mustFill" type="text" maxlength="20" name="by_stages_way" value="{{$warrantyDetail['by_stages_way']}}"/>
							</li>
							<li class="col-lg-3 col-md-6">
								<span class="name">佣金比</span><div class="extra-wrapper">
									<input class="mustFill range" data-range="0,100" type="number" name="rate" value="{{$warrantyDetail['rate']}}"/>
									<i class="extra-right">%</i>
								</div>
							</li>
							<li class="col-lg-3 col-md-6">
								<span class="name">保单号</span><input class="mustFill" type="text" maxlength="32" onKeyUp="this.value=this.value.replace(/([^\da-zA-Z]*)/g,'')" name="warranty_code" value="{{$warrantyDetail['warranty_code']}}"/>
							</li>
							<li class="col-lg-3 col-md-6">
								<span class="name">保费</span><div class="extra-wrapper">
									<input class="mustFill num" type="number" name="premium" value="{{ceil($warrantyDetail['premium']/100)}}"/>
									<i class="extra-right">元</i>
								</div>
							</li>
							<li class="col-lg-3 col-md-6 date-picker">
								<span class="name">保障时间</span><div class="input-group date form_date form_date_start">
				                    <input class="form-control mustFill" type="text" name="start_time" value="{{ date('Y-m-d', strtotime($warrantyDetail['start_time'])) }}" placeholder="请选择" readonly>
									<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
				                </div><i class="vtop">至</i><div class="input-group date form_date form_date_end">
				                    <input class="form-control" type="text" name="end_time" value="@if(!is_null($warrantyDetail['end_time'])){{ date('Y-m-d', strtotime($warrantyDetail['end_time'])) }}@endif" placeholder="请选择">
									<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
				                </div>
							</li>
							<li class="col-lg-3 col-md-6 date-picker">
								<span class="name">签订时间</span>
								<div class="input-group date form_date form_date_start">
									<input class="form-control" type="text" name="pay_time" value="{{ date('Y-m-d', strtotime($warrantyDetail['pay_time'])) }}" placeholder="请选择">
									<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
								</div>
							</li>
							<li class="col-lg-3 col-md-6">
								<span class="name" style="width: 72px;">下次缴费时间</span><input style="width: 70%;" type="text" value="@if(isset($warrantyDetail['next_pay_time'])){{date('Y-m-d',strtotime($warrantyDetail['next_pay_time']))}}@endif" readonly/>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<div class="row section">
				<div class="col-lg-12">
					<h3 class="title">代理人信息</h3>
					<div class="default-div">
						<ul>
							<li class="col-md-3">
								<span class="name">渠道</span>
								<select class="form-control" id="select-ditch" name="ditch_id">
									@foreach($ditchList as $ditch)
										@if($ditch->id == $ditchId)
											<option value="{{$ditch->id}}" selected>{{$ditch->name}}</option>
										@else
											<option value="{{$ditch->id}}">{{$ditch->name}}</option>
										@endif
									@endforeach
								</select>
							</li>
							<li class="col-md-3"><span class="name">代理人</span>
								<select class="form-control" name="agent_id">
									@foreach($agentList as $agent)
										@if($agent->agent->id == $agentId)
											<option value="{{$agent->agent->id}}" selected>{{$agent->agent->user->name}}</option>
										@else
											<option value="{{$agent->agent->id}}">{{$agent->agent->user->name}}</option>
										@endif
									@endforeach
								</select>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<input hidden id="warranty_rule_id" name="warranty_rule_id" value="{{$warranty_rule_id}}">
			<div class="row text-left">
				<button id="save" type="button" class="btn btn-primary">保存</button>
			</div>
			</form>
		</div>

		@if(!is_null($errorMsg))
		<div class="modal fade" id="modal_fail">
			<div class="modal-dialog modal-alert" role="document">
				<div class="modal-content">
					<div class="modal-header notitle">
						<button type="button" class="" data-dismiss="modal" aria-label="Close"><i class="iconfont icon-cancel"></i></button>
					</div>
					<div class="modal-body">
						<i class="iconfont icon-shibai"></i>
						<p id="fail_msg">{{$errorMsg}}</p>
					</div>
				</div>
			</div>
		</div>
		@endif
		

		<script src="{{asset('r_backend/v2/js/lib/jquery-1.11.3.min.js')}}"></script>
		<script src="{{asset('r_backend/v2/js/common_backend.js')}}"></script>

		<script src="{{asset('r_backend/v2/js/lib/bootstrap.min.js')}}"></script>
		<script>
            $('#modal_fail').modal('toggle');
			//select框默认选中
            // var insure_type = $('#insure_type').val();
            // $('#select_insure_type').val(insure_type);
            // var product_category = $('#product_category').val();
            // if(product_category == '意外险' && insure_type == 2){
             //    $('#select_category')[0].selectedIndex = 14;
            // }else if(product_category == '健康险' && insure_type == 2){
             //    $('#select_category')[0].selectedIndex = 15;
			// }else {
             //    $('#select_category').val(product_category);
            // }

			$(function(){
                $('#select-ditch').on('change', function () {
                    var ditch_id = $(this).val();
                    var warranty_rule_id = $('#warranty_rule_id').val();
                    location.href = '?warranty_rule_id='+warranty_rule_id+'&ditch_id=' + ditch_id;
                });
				var details = {
					init: function(){
						var _this = this;
						// 数据验证
						$('.range').on('blur', function(){
							verify.rangeNum($(this));
						});
						$('.num').on('blur', function(){
							verify.isNum($(this));
						});
					    // 时间选择器
					    Util.DatePickerRange({
					    	ele: ".date-picker",
					    	callback: function(){
					    		_this.isDisabled();
					    	}
					    });
					    //图片上传
					    new upload({ele: '.contracts',path:'backend/offline/'});
					    $('select').on('change',function(){
					    	_this.isDisabled();
					    });
					    $('.section-policy input').bind('input propertychange', function() { 
							_this.isDisabled();
						});
						$('#save').click(function(){
							_this.save();
						});
					},
					isEmpty: function(ele){
						var status = false;
						$(ele).each(function(index){
							if(!$(this).val()){
								status = true;
								return false;
							}
						});
						return status;
					},
					isDisabled: function(){
						var _this = this;
						var status = _this.isEmpty('.section-policy .mustFill') || _this.isEmpty('.section-policy select');
						document.getElementById('save').disabled = status;
					},
					save: function(){
						var _this = $(this);
						var warranty_image = []; // 保险合同照片
						$('.contracts li.img input').each(function(){
							var val = $(this).val();
							warranty_image.push(val);
						});
						$('input[name="warranty_image"]').val(warranty_image);
						$('#update_form').submit();
					}
				}
				details.init();
			});
		</script>
@stop