<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>天眼互联-科技让保险无限可能</title>
		<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
		<link rel="stylesheet" href="{{config('view_url.view_url')}}mobile/css/lib/mui.min.css">
		<link rel="stylesheet" href="{{config('view_url.view_url')}}mobile/css/lib/mui.picker.all.css">
		<link rel="stylesheet" href="{{config('view_url.view_url')}}mobile/css/lib/iconfont.css" />
		<link rel="stylesheet" href="{{config('view_url.view_url')}}mobile/css/common.css" />
		<style>
			body {background: #fff;}
			.mui-scroll-wrapper {top: .8rem;bottom: .8rem;}
			.mui-bar-nav {background: #025a8d;}
			.mui-icon-back,.mui-title {color: rgba(255, 255, 255, .8);}
			.applicant-wrapper {background: #fff;margin-bottom: .8rem;padding-bottom: .3rem;}
			.applicant-wrapper ul {padding: 0 .3rem;}
			.applicant-wrapper li {height: 1rem;line-height: 1rem;position: relative;border-bottom: 1px solid #dcdcdc;}
			.applicant-wrapper li .iconfont {position: absolute;top: 0;right: 0;z-index: 1;font-size: .36rem;color: #00a2ff;}
			.applicant-partone li:last-child {border-bottom: none;}
			.applicant-wrapper li input {padding-left: 2rem;font-size: .28rem;border: none;}
			.name {position: absolute;top: 0;left: 0;font-size: .28rem;color: #313131;width: 1.9rem;z-index: 100}
			.applicant-wrapper li.mui-table-view-cell {border-bottom: none;}
			.mui-table-view-cell:after {background: none;}
			.buttonbox button[disabled]{background-color: #dddddd;}
			.applicant-wrapper li.title{font-size: 0.3rem;font-weight: bold;margin-bottom: -.3rem;border-bottom: none;}
		</style>
	</head>
	<form class="form-horizontal" method="post"  id="form" action="{{ url('ins/confirmform')}}">
		{{ csrf_field()}}
		<input type="hidden" name="identification" value="{{ $identification }}" >
		<input type="hidden" name="product" value="{{json_encode($product)}}">
		<input type="hidden" name="ins" value="{{json_encode($ins)}}" >
		<input type="hidden" name="json" value="{{json_encode($json)}}" >
			<header class="mui-bar mui-bar-nav">
				<a class="mui-icon mui-icon-back mui-pull-left mui-action-back"></a>
				<h1 class="mui-title">填写投保信息</h1>
			</header>
			<div class="mui-content">
				<div class="mui-scroll-wrapper">
					<div class="mui-scroll">
						<div class="applicant-wrapper">
							<ul class="applicant-partone">
								@foreach($ins['insurance_attributes'] as $k => $v)
									@php $beibaoren_key = -1; @endphp
									@if($v['module_key'] == 'ty_base')
										{{--基础信息--}}
										<li class="title">
											<span>{{ $v['name'] }}</span>
										</li>
										@foreach($v['productAttributes'] as $vk => $vv)
												@if($vv['type'] == 1)
												{{--<li class="pickerfour">--}}
													{{--<span class="name">保障时间</span><input id="date" type="text" placeholder="必填" />--}}
													{{--<i class="iconfont icon-gengduo"></i>--}}
												{{--</li>--}}
												<li class="startDate">
													<span class="name">{{$vv['name']}}</span>
													<input id="date" regex="{{$vv['regex']?? ''}}" msg="{{$vv['errorRemind']?? ''}}"   style="font-size: 16px;color:#888888;" name="insurance_attributes[{{ $v['module_key'] }}][{{$vv['ty_key']}}]" class="common-input" value="{{date('Y-m-d',time())}}">
													<i class="iconfont icon-gengduo"></i>
												</li>
												@endif
												@if($vv['type'] == 3)
														<li class="pickerfour">
															<span class="name">{{$vv['name']}}</span>
															<input id="{{$vv['ty_key']}}" regex="{{$vv['regex']?? ''}}" msg="{{$vv['errorRemind']?? ''}}"  type="text" class="common-input" placeholder="{{$vv['name']}}" name="insurance_attributes[{{ $v['module_key'] }}][{{ $vv['ty_key'] }}]">
														</li>
													@endif
												@if($vv['type'] == 4)
													{{--todo 城市联动--}}
														<li class="pickerfive area">
															<span class="name">投保人所在地</span>
															<input  placeholder="请选择"/>
															<input class="inputhidden" hidden name="nsurance_attributes[{{ $v['module_key'] }}][{{ $vv['ty_key'] }}]" type="text" value=""/>
															<i class="iconfont icon-gengduo"></i>
														</li>
												@endif
												@if($vv['type'] == 5)
														<li class="pickerfive profession">
															<span class="name">投保人职业</span>
															<input  placeholder="请选择"/>
															<input class="inputhidden" hidden name="nsurance_attributes[{{ $v['module_key'] }}][{{ $vv['ty_key'] }}]" type="text" value=""/>
															<i class="iconfont icon-gengduo"></i>
														</li>
												@endif
												@if($vv['type'] == 6)
														@foreach($vv['attributeValues'] as $ak => $av)
															<li class="pickerfour">
																<span class="name">{{$vv['name']}}</span>
																<input id="{{$vv['ty_key']}}" regex="{{$vv['regex']?? ''}}" msg="{{$vv['errorRemind']?? ''}}" class="common-input btn btn-default" name="insurance_attributes[{{ $v['module_key'] }}][{{ $vv['ty_key'] }}]" value="{{$av['ty_value']}}" />{{$av['value']}}
															</li>
														@endforeach
												@endif
												@if(in_array($vv['type'], [0, 9]))
													<li class="approve pickerone" data-options="{{json_encode($vv['attributeValues'])}}">
														<span class="name">{{$vv['name']}}</span>
														<input id="certificateimg1" hidden="hidden" type="file" name="insurance_attributes[{{ $v['module_key'] }}][{{ $vv['ty_key'] }}]" onchange="upload('#certificateimg1');" accept="image/*" capture="camera"/>
														<input class="inputhidden" hidden="hidden" type="text"  name="holderIdType" value=""/>
														<input id="certificatetype1"  placeholder="请选择"/>
														<i class="iconfont icon-gengduo"></i>
													</li>
												@endif
										@endforeach
										{{--基础信息--}}
									@elseif ($v['module_key'] == 'ty_toubaoren')
										{{--投保人信息--}}
										<li class="title">
											<span>{{ $v['name'] }}</span>
										</li>
												@foreach($v['productAttributes'] as $vk => $vv)
														@if($vv['type'] == 1)
														<li class="pickerfour">
															<span class="name">{{$vv['name']}}</span>
															<input id="date" regex="{{$vv['regex']?? ''}}" msg="{{$vv['errorRemind']?? ''}}"   style="font-size: 16px;color:#888888;" name="insurance_attributes[{{ $v['module_key'] }}][{{$vv['ty_key']}}]" class="common-input" value="{{date('Y-m-d',time())}}">
															<i class="iconfont icon-gengduo"></i>
														</li>
														@endif
														@if($vv['type'] == 3)
																<li class="approve">
																	<span class="name">{{$vv['name']}}</span>
																	<input id="{{$vv['ty_key']}}" regex="{{$vv['regex']?? ''}}" msg="{{$vv['errorRemind']?? ''}}" type="text" class="w320"  class="common-input" placeholder="{{$vv['name']}}" name="insurance_attributes[{{ $v['module_key'] }}][{{ $vv['ty_key'] }}]">
																</li>
															@endif
															@if($vv['type'] == 4)
																{{--todo 城市联动--}}
																<li class="pickerfive area">
																	<span class="name">投保人所在地</span>
																	<input  placeholder="请选择"/>
																	<input class="inputhidden" hidden  name="insurance_attributes[{{ $v['module_key'] }}][{{ $vv['ty_key'] }}]" type="text" value=""/>
																	<i class="iconfont icon-gengduo"></i>
																</li>
															@endif
															@if($vv['type'] == 5)
																<li class="pickerfive profession">
																	<span class="name">投保人职业</span>
																	<input  placeholder="请选择"/>
																	<input class="inputhidden" hidden name="insurance_attributes[{{ $v['module_key'] }}][{{ $vv['ty_key'] }}]" type="text" value=""/>
																	<i class="iconfont icon-gengduo"></i>
																</li>
															@endif
														@if($vv['type'] == 6)
																<li class="approve">
																	<span class="name">{{$vv['name']}}</span>
																		@foreach($vv['attributeValues'] as $ak => $av)
																			<input id="name1" regex="{{$vv['regex']?? ''}}" msg="{{$vv['errorRemind']?? ''}}"  class="btn btn-default" name="insurance_attributes[{{ $v['module_key'] }}][{{ $vv['ty_key'] }}]" value="{{$av['ty_value']}}" />{{$av['value']}}
																		@endforeach
																</li>
														@endif
														@if(in_array($vv['type'], [0, 9]))
															<li class="approve pickerone" data-options="{{json_encode($vv['attributeValues'])}}">
																<span class="name">{{$vv['name']}}</span>
																{{--<input id="certificateimg1" hidden="hidden" type="file" name="insurance_attributes[{{ $v['module_key'] }}][{{ $vv['ty_key'] }}]" onchange="upload('#certificateimg1');" accept="image/*" capture="camera"/>--}}
																<input class="inputhidden" hidden="hidden" type="text"  name="insurance_attributes[{{ $v['module_key'] }}][{{ $vv['ty_key'] }}]" value=""/>
																<input id="certificatetype1"  placeholder="请选择"/>
																<i class="iconfont icon-gengduo"></i>
															</li>
														@endif
												@endforeach
										{{--投保人信息--}}
									@elseif ($v['module_key'] == 'ty_beibaoren')
										<li class="title">
											<span>{{ $v['name'] }}</span>
										</li>
										@php $beibaoren_key++; @endphp
										{{--被保人信息表--}}
										@foreach($v['productAttributes'] as $vk => $vv)
											@if($vv['type'] == 1)
												<li class="pickerfour">
													<span class="name">{{$vv['name']}}</span>
													<input id="date" regex="{{$vv['regex']?? ''}}" msg="{{$vv['errorRemind']?? ''}}"   style="font-size: 16px;color:#888888;" name="insurance_attributes[{{ $v['module_key'] }}][{{ $beibaoren_key }}][{{ $vv['ty_key'] }}]"  class="common-input" value="{{date('Y-m-d',time())}}">
													<i class="iconfont icon-gengduo"></i>
												</li>
											@endif
											@if($vv['type'] == 3)
												<li class="approve">
													<span class="name">{{$vv['name']}}</span>
													<input id="{{$vv['ty_key']}}" regex="{{$vv['regex']?? ''}}" msg="{{$vv['errorRemind']?? ''}}" type="text" class="w320"  class="common-input" placeholder="{{$vv['name']}}" name="insurance_attributes[{{ $v['module_key'] }}][{{ $beibaoren_key }}][{{ $vv['ty_key'] }}]" >
												</li>
											@endif
												@if($vv['type'] == 4)
													{{--todo 城市联动--}}
													<li class="pickerfive area">
														<span class="name">被保人所在地</span>
														<input  placeholder="请选择"/>
														<input class="inputhidden" hidden name="insurance_attributes[{{ $v['module_key'] }}][{{ $beibaoren_key }}][{{ $vv['ty_key'] }}]" type="text" value=""/>
														<i class="iconfont icon-gengduo"></i>
													</li>
												@endif
												@if($vv['type'] == 5)
													<li class="pickerfive profession">
														<span class="name">被保人职业</span>
														<input  placeholder="请选择"/>
														<input class="inputhidden" hidden name="insurance_attributes[{{ $v['module_key'] }}][{{ $beibaoren_key }}][{{ $vv['ty_key'] }}]" type="text" value=""/>
														<i class="iconfont icon-gengduo"></i>
													</li>
												@endif
											@if($vv['type'] == 6)
												<li class="approve">
													<span class="name">{{$vv['name']}}</span>
													@foreach($vv['attributeValues'] as $ak => $av)
														<input id="{{$vv['ty_key']}}" regex="{{$vv['regex']?? ''}}" msg="{{$vv['errorRemind']?? ''}}"  class="btn btn-default" name="insurance_attributes[{{ $v['module_key'] }}][{{ $beibaoren_key }}][{{ $vv['ty_key'] }}]"  value="{{$av['ty_value']}}" />{{$av['value']}}
													@endforeach
												</li>
											@endif
											@if(in_array($vv['type'], [0, 9]))
												<li class="approve pickerone" data-options="{{json_encode($vv['attributeValues'])}}">
													<span class="name">{{$vv['name']}}</span>
													{{--<input id="certificateimg1" hidden="hidden" type="file" name="insurance_attributes[{{ $v['module_key'] }}][{{ $vv['ty_key'] }}]" onchange="upload('#certificateimg1');" accept="image/*" capture="camera"/>--}}
													<input class="inputhidden" hidden="hidden" type="text"  name="insurance_attributes[{{ $v['module_key'] }}][{{ $beibaoren_key }}][{{ $vv['ty_key'] }}]"  value=""/>
													<input id="certificatetype1"  placeholder="请选择"/>
													<i class="iconfont icon-gengduo"></i>
												</li>
											@endif
										@endforeach
										{{--被保人信息--}}
										@else
										{{--其他信息--}}
										<li class="title">
											<span>{{ $v['name'] }}</span>
										</li>
										@foreach($v['productAttributes'] as $vk => $vv)
											@if($vv['type'] == 1)
												<li class="pickerfour">
													<span class="name">{{$vv['name']}}</span>
													<input id="date" regex="{{$vv['regex']?? ''}}" msg="{{$vv['errorRemind']?? ''}}"   style="font-size: 16px;color:#888888;" name="insurance_attributes[{{ $v['module_key'] }}][{{$vv['ty_key']}}]" class="common-input" value="{{date('Y-m-d',time())}}">
													<i class="iconfont icon-gengduo"></i>
												</li>
											@endif
											@if($vv['type'] == 3)
												<li class="approve">
													<span class="name">{{$vv['name']}}</span>
													<input id="{{$vv['ty_key']}}" regex="{{$vv['regex']?? ''}}" msg="{{$vv['errorRemind']?? ''}}" type="text" class="w320"  class="common-input" placeholder="{{$vv['name']}}" name="insurance_attributes[{{ $v['module_key'] }}][{{ $vv['ty_key'] }}]">
												</li>
											@endif
												@if($vv['type'] == 4)
													{{--todo 城市联动--}}
													<li class="pickerfive area">
														<span class="name">投保人所在地</span>
														<input  placeholder="请选择"/>
														<input class="inputhidden" hidden name="insurance_attributes[{{ $v['module_key'] }}][{{ $vv['ty_key'] }}]" type="text" value=""/>
														<i class="iconfont icon-gengduo"></i>
													</li>
												@endif
												@if($vv['type'] == 5)
													<li class="pickerfive profession">
														<span class="name">被保人职业</span>
														<input  placeholder="请选择"/>
														<input class="inputhidden" hidden name="insurance_attributes[{{ $v['module_key'] }}][{{ $vv['ty_key'] }}]" type="text" value=""/>
														<i class="iconfont icon-gengduo"></i>
													</li>
												@endif
											@if($vv['type'] == 6)
												<li class="approve">
													<span class="name">{{$vv['name']}}</span>
													@foreach($vv['attributeValues'] as $ak => $av)
														<input id="name1" regex="{{$vv['regex']?? ''}}" msg="{{$vv['errorRemind']?? ''}}"  class="btn btn-default" name="insurance_attributes[{{ $v['module_key'] }}][{{ $vv['ty_key'] }}]" value="{{$av['ty_value']}}" />{{$av['value']}}
													@endforeach
												</li>
											@endif
											@if(in_array($vv['type'], [0, 9]))
												<li class="approve pickerone" data-options="{{json_encode($vv['attributeValues'])}}">
													<span class="name">{{$vv['name']}}</span>
													{{--<input id="certificateimg1" hidden="hidden" type="file" name="insurance_attributes[{{ $v['module_key'] }}][{{ $vv['ty_key'] }}]" onchange="upload('#certificateimg1');" accept="image/*" capture="camera"/>--}}
													<input class="inputhidden" hidden="hidden" type="text"  name="insurance_attributes[{{ $v['module_key'] }}][{{ $vv['ty_key'] }}]" value=""/>
													<input id="certificatetype1"  placeholder="请选择"/>
													<i class="iconfont icon-gengduo"></i>
												</li>
											@endif
										@endforeach
										{{--其他信息--}}
									@endif
								@endforeach
									{{--<li class="pickerthree" data-options='[{"ty_value":"1","value":"\u6cd5\u5b9a\u53d7\u76ca\u4eba"}]'>--}}
									{{--<span class="name">受益人类别</span>--}}
									{{--<input class="inputhidden" hidden="hidden" type="text"  name="beneficiary" value=""/>--}}
									{{--<input id="favoree" type="text"   placeholder="请选择受益人"/>--}}
									{{--<i class="iconfont icon-gengduo"></i>--}}
									{{--</li>--}}
									{{--<li class="mui-table-view-cell">--}}
										{{--<span class="name">保存为常用联系人</span>--}}
										{{--<div class="switchtwo mui-switch mui-switch-mini">--}}
											{{--<div class="mui-switch-handle"></div>--}}
										{{--</div>--}}
									{{--</li>--}}
							</ul>
						</div>
					</div>
				</div>
				<div class="buttonbox">
					<button type="button" class="btn" onclick="form_check()">下一步</button>
				</div>
			</div>
		</form>
		<script src="{{config('view_url.view_url')}}mobile/js/lib/jquery-1.11.3.min.js"></script>
		<script src="{{config('view_url.view_url')}}mobile/js/lib/mui.min.js"></script>
		<script src="{{config('view_url.view_url')}}mobile/js/lib/mui.picker.all.js"></script>
		<script src="{{config('view_url.view_url')}}mobile/js/common.js"></script>
		<script src="{{config('view_url.view_url')}}mobile/js/applicant.js"></script>
		<script>
			//投保日期的校验
			function CheckDate(options){
				this.defaults = {};
				this.options = $.extend({}, this.defaults, options);
				this.ele = $(this.options.ele).eq(0);
				this.init();
			}
			CheckDate.prototype = {
				init: function(){
					var _this = this;
					var range = _this.options.range;
					var defaultVal = this.ele.val();

					var now = new Date();
					startVal = now.setDate(now.getDate()+range[0]-1);
					var now = new Date(),
							startText = _this.fmtDate(now.setDate(now.getDate()+range[0]));

					var now = new Date(),
							endVal = now.setDate(now.getDate()+range[1]),
							endText = _this.fmtDate(endVal);

					var startArry = startText.split('-'),
							endArry = endText.split('-');

					_this.ele.find('input').val(startText);
					_this.ele.on('tap', function() {
						var _that = $(this);
						var picker = new mui.DtPicker({
							"type": "date",
							"beginDate": new Date(startArry[0], parseInt(startArry[1])-1, startArry[2]),//设置开始日期
							"endDate": new Date(endArry[0], parseInt(endArry[1])-1, endArry[2]),//设置结束日期
						});
						picker.show(function(rs) {
							_that.find('input').val(rs.text);
							if(_this.options.callback){_this.options.callback();}
							picker.dispose();
						});
					});
				},
				fmtDate: function(obj){
					var date =  new Date(obj);
					var y = 1900+date.getYear();
					var m = "0"+(date.getMonth()+1);
					var d = "0"+date.getDate();
					return y+"-"+m.substring(m.length-2,m.length)+"-"+d.substring(d.length-2,d.length);
				}
			}

			new CheckDate({
				ele: '.startDate', // input元素
				range: [2,10], // 时间天数范围 今天2天后 连续10天
				callback: function(){
					selfStatus === true ? changeColor1() : changeColor2();
				}
			});
			//所有input的校验
//			var inputs = $('.applicant-partone input:visible[type="text"]');
//			inputs.on('blur',function(){
//				var regex =  eval('/'+$(this).attr('regex')+'/');
//				var value = $(this).val();
//				if (regex){
//					var msg = $(this).attr('msg');
//					if (!regex.test(value)){
//						$(this).val("");
//						Mask.alert(msg,2);
//					}
//				}
//			});
			var inputs = $('.applicant-partone input:visible[type="text"]');
			inputs.on('blur',function(){
				if(!$(this).val()){return;}
				var regex =  eval('/'+$(this).attr('regex')+'/');
				var value = $(this).val().trim();
				if (regex){
					var msg = $(this).attr('msg');
					if (!regex.test(value)){
						$(this).val("");
						Mask.alert(msg,2);
					}
				}
			});

//            function form_check() {
//                $('.w320').each(function (index) {
//                    var insure_value  = $(this).val();
//                    if(!insure_value||insure_value.length<1){
//                        Mask.alert("请正确输入投保信息");
//                        return false;
//                    }
//                    if(index == $('.w320').length-1){
//                        $(form).submit();
//                    }
//                })
//                return false;
//            }
            var delimiter = '';
            function changeJson(data,type){
                // type=0 职业 1地区
//                var jsonData = JSON.stringify(data);
                if(type == 0){
                    var data = data.replace(/id/g,'value').replace(/name/g,'text').replace(/_child/g,'children');
                    delimiter = '-';
                }else{
                    var data = data.replace(/code/g,'value').replace(/name/g,'text').replace(/cities/g,'children').replace(/countries/g,'children');
                    delimiter = ',';
                }
                data = data.replace(/\\/g, "\\\\");
//				console.log(data);
                return JSON.parse(data);
            }
            var cityPicker = new mui.PopPicker({layer: 3});
            @if (isset($ins['area']))
				var areaData = '{!! json_encode($ins['area']) !!}';
			@endif
			@if (isset($ins['jobs']))
			var professionData = '{!! json_encode($ins['jobs']) !!}';
			@elseif(isset($ins['job']))
            var professionData = '{!! json_encode($ins['job']) !!}';
            @endif
$('.pickerfive').on('tap',function(){
                var _this = $(this);
                if($(this).hasClass('profession')){
                    cityPicker.setData(changeJson(professionData,0));
                }else if($(this).hasClass('area')){
                    cityPicker.setData(changeJson(areaData,1));
                }
                cityPicker.show(function(items) {
                    if(items[2].value){
                        _this.find('input:text').val(items[0].text+delimiter+items[1].text+delimiter+items[2].text);
                        _this.find('.inputhidden').val(items[0].value+delimiter+items[1].value+delimiter+items[2].value);
					}else{
                        _this.find('input:text').val(items[0].text+delimiter+items[1].text);
                        _this.find('.inputhidden').val(items[0].value+delimiter+items[1].value);
					}

//                    console.log(_this.find('.inputhidden').val())
                });
            });
		</script>
	</body>
</html>