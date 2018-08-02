@extends('frontend.guests.guests_layout.base')
@section('head-more')
	<link rel="stylesheet/less" href="{{config('view_url.view_url')}}css/process.less"/>
	<script src="{{config('view_url.view_url').'js/lib/less.min.js'}}"></script>
	<style>
		select{width: 200px;height: 35px;font-size: 16px;color:#888888 ; border: 0.1px solid #D0D0D0;margin-right: 5px}
		.two{display:none;}
		.three{display:none;}
		#down :hover{
			color: darkgreen;
			text-decoration:underline;
		}
		.insured_table tr td{width:120px;height:20px;padding:5px;text-align: center;}
		.insured_table tr .id_number{width:230px;}
		.insured_table tr td input{height:25px;padding:3px;text-align: center;}
		.button_min{width:20px;}

	</style>
@stop

@section('content')
	{{--0：下拉框 1：日历 2：日历+下拉框 3：文本输入框 4：地区 5：职业 6：文本 9:单选--}}
	{{--<form class="form-horizontal" method="post"  id="form" action="{{ url('ins/group_confirm_form')}}" enctype="multipart/form-data">--}}
		<div class="wrapper step3">
			<div class="main notification clearfix">
				<div class="notification-left fl">
					{{--<div class="notification-left-tip">--}}
					{{--<i class="iconfont icon-yduidunpaishixin"></i><span>为了保障您的权益，请填写真实有效的信息。您填写的内容仅供投保使用，对于您的信息我们会严格保密。</span>--}}
					{{--</div>--}}
					<div class="notification-left-content">
						{{ csrf_field() }}
						<input type="hidden" name="identification" value="{{ $identification }}" >
						<input type="hidden" name="product" value="{{json_encode($product)}}" >
						<input type="hidden" name="ins" value="{{json_encode($ins)}}" >
						<input type="hidden" name="json" value="{{json_encode($json)}}">
						@foreach($ins['insurance_attributes'] as $k => $v)
							@php $beibaoren_key = -1; @endphp
							{{--@if($v['module_key'] == 'ty_base')--}}
							{{--基础信息--}}
							{{--<h3 class="title">{{ $v['name'] }}</h3>--}}
							{{--@foreach($v['productAttributes'] as $vk => $vv)--}}
							{{--<div class="date">--}}
							{{--<span class="name"><i class="f18164">*</i>{{$vv['name']}}</span>--}}
							{{--@if($vv['type'] == 1)--}}

							{{--<input type="date" style="font-size: 16px;color:#888888;" id="{{$vv['ty_key']}}" name="insurance_attributes[{{ $v['module_key'] }}][{{$vv['ty_key']}}]" class="common-input" value="{{date('Y-m-d',time())}}">--}}
							{{--<input type="text" name="startTime" class="inline laydate-icon" id="starttime" value="{{date('Y-m-d',time())}}">--}}
							{{--<span>起保日期<i class="cl333 time-start">2017-07-14零时起</i>至<i class="cl333 time-end">2017-07-17二十四时</i>止</span>--}}
							{{--@endif--}}
							{{--@if($vv['type'] == 3)--}}
							{{--<input type="text" class="common-input" placeholder="{{$vv['name']}}" name="insurance_attributes[{{ $v['module_key'] }}][{{ $vv['ty_key'] }}]" id="{{$vv['ty_key']}}" >--}}
							{{--<span class="error"></span>--}}
							{{--@endif--}}
							{{--@if($vv['type'] == 4)--}}
							{{--todo 城市联动--}}
							{{--@endif--}}
							{{--@if($vv['type'] == 5)--}}
							{{--todo 职业联动--}}
							{{--@endif--}}
							{{--@if($vv['type'] == 6)--}}
							{{--@foreach($vv['attributeValues'] as $ak => $av)--}}
							{{--<input class="common-input btn btn-default" name="insurance_attributes[{{ $v['module_key'] }}][{{ $vv['ty_key'] }}]" value="{{$av['ty_value']}}" />{{$av['value']}}--}}
							{{--@endforeach--}}
							{{--@endif--}}
							{{--@if(in_array($vv['type'], [0, 9]))--}}
							{{--<select class="common-input code-select" name="insurance_attributes[{{ $v['module_key'] }}][{{ $vv['ty_key'] }}]">--}}
							{{--@foreach($vv['attributeValues'] as $ak => $av)--}}
							{{--<option value="{{$av['ty_value']}}">{{$av['value']}}</option>--}}
							{{--@endforeach--}}
							{{--</select>--}}
							{{--@endif--}}
							{{--</div>--}}
							{{--@endforeach--}}
							{{--基础信息--}}
							{{--@elseif ($v['module_key'] == 'ty_toubaoren')--}}
							{{--投保人信息--}}
							<div class="person" id="{{ $v['module_key'] }}">
								{{--<h3 class="title">{{ $v['name'] }}</h3>--}}
								<ul>
									@foreach($v['productAttributes'] as $vk => $vv)
										<li>
											<span class="name"><i class="f18164">*</i>{{$vv['name']}}</span>
											@if($vv['type'] == 1)
												<input type="date" style="font-size: 16px;color:#888888;" id="{{$vv['ty_key']}}"  name="insurance_attributes[{{ $v['module_key'] }}][{{ $vv['ty_key'] }}]" class="common-input" value="{{date('Y-m-d',time())}}">
											@endif
											@if($vv['type'] == 3)
												<input type="text"  class="w320"  class="common-input" placeholder="{{$vv['name']}}" id="{{ $vv['ty_key'] }}" name="insurance_attributes[{{ $v['module_key'] }}][{{ $vv['ty_key'] }}]">
												<span class="error"></span>
											@endif
											@if($vv['type'] == 4)
												{{--todo 城市联动--}}
											@endif
											@if($vv['type'] == 5)
												<?php
												if(isset($ins['jobs'])){
													$one = "<select class='one' id='one_". $beibaoren_key ."' sort_id='".$beibaoren_key."' >";
													$two = '';
													$three = '';
													foreach($ins['jobs'] as $one_k => $one_v){
														$one .= "<option value='". $one_v['id'] ."'>" . $one_v['name'] . "</option>";
														if(isset($one_v['_child'])){
															$two .= "<select class='two two_". $beibaoren_key ."' sort_id='".$beibaoren_key."' id='two_".$beibaoren_key. '_'. $one_v['id'] ."' >";
															foreach($one_v['_child'] as $tow_k =>$two_v){
																$two .= "<option value='". $two_v['id'] ."'>" . $two_v['name'] . "</option>";
																if(isset($two_v['_child'])){
																	$three .= "<select class='three three_". $beibaoren_key ."' id='three_".$beibaoren_key. '_'. $two_v['id'] ."' two_id='". $two_v['id'] ."' sort_id='".$beibaoren_key."' >";
																	foreach($two_v['_child'] as $three_k => $three_v){
																		$three .= "<option value='". $three_v['id'] ."'>" . $three_v['name'] . "</option>";
																	}
																	$three .= "</select>";
																}
															}
															$two .= "</select>";
														}
													}
													$one .= "</select>";
													echo $one;
													echo $two;
													echo $three;
												}
												?>
												<input type="hidden" id="job_val_{{$beibaoren_key}}" name="insurance_attributes[{{ $v['module_key'] }}][{{ $beibaoren_key }}][{{ $vv['ty_key'] }}]">
											@endif
											@if($vv['type'] == 6)
												@foreach($vv['attributeValues'] as $ak => $av)
													<input  class="btn btn-default" name="insurance_attributes[{{ $v['module_key'] }}][{{ $vv['ty_key'] }}]" value="{{$av['ty_value']}}" />{{$av['value']}}
												@endforeach
											@endif
											@if(in_array($vv['type'], [0, 9]))
												<select style="width: 170px;height: 35px;font-size: 16px;color:#888888 ; border: 0.1px solid #D0D0D0;" class="common-input code-select" name="insurance_attributes[{{ $v['module_key'] }}][{{ $vv['ty_key'] }}]" id="{{ $vv['ty_key'] }}">
													@foreach($vv['attributeValues'] as $ak => $av)
														<option value="{{$av['ty_value']}}" style="text-align:center ">{{$av['value']}}</option>
													@endforeach
												</select>
											@endif
										</li>
									@endforeach
								</ul>
							</div>
							{{--投保人信息--}}
							{{--@elseif ($v['module_key'] == 'ty_beibaoren')--}}
							{{--@php $beibaoren_key++; @endphp--}}
							{{--<div id="{{ $v['module_key'] }}">--}}
							{{--<h3 class="title">{{ $v['name'] }}</h3>--}}
							{{--<ul>--}}
							{{--<li>--}}
							{{--<a href="{{ env('TY_API_PRODUCT_SERVICE_URL').'/'.$ins['template_url'] }}"  style="color:dodgerblue; margin-bottom:5px;">下载被保人模板</a>--}}
							{{--</li>--}}
							{{--<li>--}}
							{{--<i class="f18164"></i>上传被保人excel文件--}}
							{{--<input type="file" name="b_file" id="excel-file" style="height:30px;line-height: 30px;margin:7px;">--}}
							{{--</li>--}}
							{{--<li>--}}
							{{--<table class="insured_table">--}}
							{{--<tr class="insured_lists" list-num="0">--}}
							{{--<td>姓名</td>--}}
							{{--<td class="id_number">身份证号</td>--}}
							{{--<td>职业</td>--}}
							{{--<td>手机号</td>--}}
							{{--<td><button type="button" class="button_min" id="add_insured">+</button></td>--}}
							{{--</tr>--}}
							{{----}}
							{{--</table>--}}
							{{--</li>--}}
							{{--</ul>--}}
							{{--</div>--}}

							{{--@endif--}}
						@endforeach
						<div class="contact">
							<div class="contact-agreement">
								<label>
									<i class="icon icon-checkbox"></i>
									<input type="checkbox" id="agree" hidden/>
									我已查看并同意
									@if(!empty($product_res['clauses']))
										@foreach(json_decode($product_res['clauses'],true) as $value)
											@if($value['type']=='main')
												<a href="{{env('TY_API_PRODUCT_SERVICE_URL')}}/{{$value['file_url']}}" class="a4d790" target="_blank">保险条款</a>和
											@endif
										@endforeach
									@endif
									<a href="/upload/frontend/policy_holder/policyHolder_notice.pdf" class="a4d790" target="_blank">投保人申明</a>
								</label>
							</div>
							<div>
								{{--<button type="button" class="btn btn-f18164" onclick="form_check()">提交投保单</button>--}}
								<button type="button" class="btn btn-f18164" id="next" onclick="form_check()">保存</button>
								<span id="checksave"></span>
							</div>
						</div>
					</div>
				</div>
				@include('frontend.guests.product.product_notice')
			</div>
		</div>
	{{--</form>--}}

@section('footer-more')
	<script src="{{asset('r_frontend/js/xlsx.core.min.js')}}"></script>
	<script>
//		$("#next").click(function(){
//			window.location.href = '/ins/group_ins/next_insure';
//		});

		$(function(){
			$(".one").change(function(){
				var val = $(this).val();
				var sort_id = $(this).attr('sort_id');
				var class_obj_name = '.two_' + sort_id;
				$(class_obj_name).hide();
				var two_id = "#two_" + sort_id + '_' +val;
				$(two_id).show();
				var three_class_obj_name = '.three_' + sort_id;
//                console.log(three_class_obj_name);
				$(three_class_obj_name).hide();
				var val_2 = $(two_id).prop('selectedIndex', 0).val();
				var input_val = val + '-' +val_2;
				console.log(input_val);
				$("#job_val_" + sort_id).val(input_val);
			});
			$(".two").change(function(){
				var val = $(this).val();
				var sort_id = $(this).attr('sort_id');
				var class_obj_name = '.three' + '_' +sort_id;
				$(class_obj_name).hide();
				var val_1 = $('#one_' + sort_id).val();
				var input_val = val_1 + '-' +val;

				var three_id = "#three_" + sort_id + '_' +val;
				if($(three_id).length > 0){
					$(three_id).show();
					var val_2 = $(three_id).prop('selectedIndex', 0).val();
					input_val = input_val + '-' + val_2;
				}

				console.log(input_val);
				$("#job_val_" + sort_id).val(input_val);
			});

			$(".three").change(function(){
				var val = $(this).val();
				var sort_id = $(this).attr('sort_id');
				var two_id = $(this).attr('two_id');
				var val_1 = $('#one_' + sort_id).val();
				var val_2 = $('#two_' + sort_id + '_' +val_1).val();
				var input_val = val_1 + '-' + val_2 + '-' + val;
				console.log(input_val);
				$("#job_val_" + sort_id).val(input_val);
			});

			var agree_status = $('#agree').val();


		})
		function form_check() {
			$('.w320').each(function (index) {
				var insure_value  = $(this).val();
				if(!insure_value||insure_value.length<1){
					Mask.alert("请正确输入投保信息");
					return false;
				}
				if(index == $('.w320').length-1){
					$(form).submit();
				}
			})
			return false;
		}
		function selct_self() {
			var ty_toubaoren_name = $('#ty_toubaoren_name').val();
			var ty_toubaoren_id_number = $('#ty_toubaoren_id_number').val();
			var ty_toubaoren_phone = $('#ty_toubaoren_phone').val();
			console.log(ty_toubaoren_name);
			$('.code-select option:selected').each(function (index) {
				var select_value  = $(this).text();
				if(select_value=='本人'){
					$('#ty_beibaoren_name').val(ty_toubaoren_name);
					$('#ty_beibaoren_phone').val(ty_toubaoren_phone);
					$('#ty_beibaoren_id_number').val(ty_toubaoren_id_number);
				}
			})
		}

		//增行
		$("#add_insured").click(function(){
			$num = parseInt($('.insured_lists').last().attr('list-num')) + 1;
			$str = '<tr class="insured_lists" list-num="'+ $num +'">'+
					'<td><input type="text" name="insurance_attributes[ty_beibaoren]['+$num+'][name]"></td>'+
					'<td><input type="text" name="insurance_attributes[ty_beibaoren]['+$num+'][ty_beibaoren_id_number]"></td>'+
					'<td><input type="text" name="insurance_attributes[ty_beibaoren]['+$num+'][ty_beibaoren_job]"></td>'+
					'<td><input type="text" name="insurance_attributes[ty_beibaoren]['+$num+'][ty_beibaoren_phone]"></td>'+
					'<td><button type="button" class="button_min btn-del">-</button></td>'+
					'</tr>';
			$('.insured_lists').last().after($str);
		});
		//减行
		$("body").on('click', '.btn-del', function(){
			$(this).parent().parent().remove();
		})

		//excel导入
		$('#excel-file').change(function(e) {
			var files = e.target.files;

			var fileReader = new FileReader();
			fileReader.onload = function(ev) {
				try {
					var data = ev.target.result,
							workbook = XLSX.read(data, {
								type: 'binary'
							}), // 以二进制流方式读取得到整份excel表格对象
							persons = []; // 存储获取到的数据
				} catch (e) {
					console.log('文件类型不正确');
					return;
				}

				// 表格的表格范围，可用于判断表头是否数量是否正确
				var fromTo = '';
				// 遍历每张表读取
				for (var sheet in workbook.Sheets) {
					if (workbook.Sheets.hasOwnProperty(sheet)) {
						fromTo = workbook.Sheets[sheet];
						persons = persons.concat(XLSX.utils.sheet_to_json(workbook.Sheets[sheet]));
						// break; // 如果只取第一张表，就取消注释这行
					}
				}

				console.log(persons);
				// 页面渲染

				var html = '';
				for(var i=0,l=persons.length;i<l;i++){
					$num = parseInt($('.insured_lists').last().attr('list-num')) + i;
					if(i==0){
						continue;
					}
					html += '<tr class="insured_lists" list-num="'+ $num +'">';
					for(n in persons[i]){
						html += '<td>' +
								'<input type="text" name="insurance_attributes[ty_beibaoren]['+$num+']['+n+']" ' +
								'value="'+persons[i][n]+'">' +
								'</td>';

					}
					html += '<td><button type="button" class="button_min btn-del">-</button></td></tr>';
				}

				$('.insured_lists').last().after(html);
			};
			// 以二进制方式打开文件
			fileReader.readAsBinaryString(files[0]);
		});
	</script>
@stop

@stop