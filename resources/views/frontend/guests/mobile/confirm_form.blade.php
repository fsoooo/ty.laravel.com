<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>天眼互联-科技让保险无限可能</title>
		<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
		<link rel="stylesheet" href="{{config('view_url.view_url')}}mobile/css/lib/mui.min.css">
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
			.applicant-wrapper li input {padding-left: 2.8rem;font-size: .28rem;border: none;overflow: hidden;text-overflow:ellipsis;white-space: nowrap;}
			.name {position: absolute;top: 0;left: 0;font-size: .28rem;color: #313131;}
			.applicant-wrapper li.mui-table-view-cell {border-bottom: none;}
			.mui-table-view-cell:after {background: none;}
			.mui-scroll-wrapper {top: .9rem;bottom: .98rem;}
			.applicant-parttwo li:last-child {border-bottom: none;}
			.warn {height: .48rem;line-height: .48rem;color: #f00;background: #ffae00;text-align: center;}
			.applicant-info p{padding: 0 .3rem;margin: .16rem 0;font-size: .24rem;color: #ADADAD;}
		</style>
	</head>
	<body>
		<div class="main">
			<header class="mui-bar mui-bar-nav">
				<a class="mui-icon mui-icon-back mui-pull-left mui-action-back"></a>
				<h1 class="mui-title">信息预览</h1>
			</header>
			<div class="mui-content">
				<div class="mui-scroll-wrapper">
					<div class="mui-scroll">
						<div class="applicant-wrapper">
							<div class="warn"><i class="iconfont icon-chenggong"></i>投保人需与支付人为同一人</div>
							<ul class="applicant-partone">
								@foreach(json_decode($input['ins'],true)['insurance_attributes'] as $k => $v)
									@if(key_exists($v['module_key'],json_decode($insurance_attributes,true)))
										@php $beibaoren_key = -1; @endphp
										@foreach(json_decode($insurance_attributes,true)[$v['module_key']] as $key => $values)
											@if(is_array($values))
												@foreach($values as $ks=>$vs)
														@foreach($v['productAttributes'] as $vk => $vv)
															@if($ks==$vv['ty_key'])
																	@if($vv['type'] == 1)
																		<li class="pickerfour">
																			<span class="name">{{$vv['name']}}</span>
																			<input id="text"  type="text" class="common-input" value="{{$vs}}">
																		</li>
																	@endif
																	@if($vv['type'] == 3)
																		<li class="pickerfour">
																			<span class="name">{{$vv['name']}}</span>
																			<input id="name1"  type="text" class="common-input"   value="{{$vs}}">
																		</li>
																	@endif
																		@if($vv['type'] == 4)
																			<li class="pickerfour">
																				<span class="name">{{$vv['name']}}</span>
																				@php
																					list($proCode, $cityCode, $countryCode) = explode(',', $vs);
                                                                                    $proName = '';
                                                                                    $cityName = '';
                                                                                    $countryName = '';
                                                                                    foreach (json_decode($input['ins'],true)['area'] as $province) {
                                                                                        if ($province['code'] == $proCode) {
                                                                                            $proName = $province['name'];
                                                                                            foreach ($province['cities'] as $city) {
                                                                                                if ($city['code'] == $cityCode) {
                                                                                                    $cityName = $city['name'];
                                                                                                    foreach ($city['countries'] as $country) {
                                                                                                        if ($country['code'] == $countryCode) {
                                                                                                            $countryName = $country['name'];
                                                                                                        }
                                                                                                    }
                                                                                                }
                                                                                            }
                                                                                        }
                                                                                    }
                                                                                    $area =  $proName . ',' . $cityName . ',' . $countryName;
																				@endphp
																				<input type="text" class="common-input"   value="{{$area}}">
																			</li>
																		@endif
																	@if($vv['type'] == 5)
																		{{--todo 职业联动--}}
																			<li class="pickerfour">
																				<span class="name">{{$vv['name']}}</span>
																				@if(!empty($vs)||!is_null($vs))
																					@php
																						$job_id = explode('-',$vs);
                                                                                        $job_name = [];
                                                                                        foreach (json_decode($input['ins'],true)['jobs'] as $one){
                                                                                                if($one['id']==$job_id[0]){
                                                                                                $job_name[0] = $one['name'];
                                                                                                if(isset($one['_child'])){
                                                                                                   foreach ($one['_child'] as $two){
                                                                                                    if($two['id']==$job_id[1]){
                                                                                                    $job_name[1] = $two['name'];
                                                                                                        if(isset($two['_child'])){
                                                                                                            foreach ($two['_child'] as $three){
                                                                                                                   if($three['id']==$job_id[2]){
                                                                                                                    $job_name[2] = $three['name'];
                                                                                                                    }
                                                                                                                }
                                                                                                            }
                                                                                                        }
                                                                                                   }
                                                                                                }
                                                                                            }
                                                                                        }
                                                                                    $job_name =  implode('-',$job_name);
																					@endphp
																					<input id="name1" class="common-input"  value="{{$job_name}}"/>
																				@endif
																			</li>
																	@endif
																	@if($vv['type'] == 6)
																		@foreach($vv['attributeValues'] as $ak => $av)
																			<li class="pickerfour">
																				<span class="name">{{$vv['name']}}</span>
																				<input id="name1" class="common-input btn btn-default"  value="{{$vs}}"/>
																			</li>
																		@endforeach
																	@endif
																	@if(in_array($vv['type'], [0, 9]))
																			<li class="pickerfour">
																			<span class="name">{{$vv['name']}}</span>
																			@foreach($vv['attributeValues'] as $ak => $av)
																					@if($vs ==$av['ty_value'])
																					<input type="text" value="{{$av['value']}}"/>
																				@endif
																			@endforeach
																			</li>
																	@endif
																@endif
															@endforeach
													@endforeach
											@else
												@foreach($v['productAttributes'] as $vk => $vv)
														@if($key== $vv['ty_key'])
															@if($vv['type'] == 1)
																<li class="pickerfour">
																	<span class="name">{{$vv['name']}}</span>
																	<input  type="text" class="common-input" value="{{$values}}">
																</li>
															@endif
															@if($vv['type'] == 3)
																<li class="pickerfour">
																	<span class="name">{{$vv['name']}}</span>
																	<input id="name1"  type="text" class="common-input"   value="{{$values}}">
																</li>
															@endif
																@if($vv['type'] == 4)
																	<li class="pickerfour">
																		<span class="name">{{$vv['name']}}</span>
																		@php
																			list($proCode, $cityCode, $countryCode) = explode(',', $values);
                                                                            $proName = '';
                                                                            $cityName = '';
                                                                            $countryName = '';
                                                                            foreach (json_decode($input['ins'],true)['area'] as $province) {
                                                                                if ($province['code'] == $proCode) {
                                                                                    $proName = $province['name'];
                                                                                    foreach ($province['cities'] as $city) {
                                                                                        if ($city['code'] == $cityCode) {
                                                                                            $cityName = $city['name'];
                                                                                            foreach ($city['countries'] as $country) {
                                                                                                if ($country['code'] == $countryCode) {
                                                                                                    $countryName = $country['name'];
                                                                                                }
                                                                                            }
                                                                                        }
                                                                                    }
                                                                                }
                                                                            }
                                                                              $area =  $proName . ',' . $cityName . ',' . $countryName;
																		@endphp
																		<input type="text" class="common-input"   value="{{$area}}">
																		</span>
																	</li>
																@endif
																@if($vv['type'] == 5)
																	{{--todo 职业联动--}}
																	<li class="pickerfour">
																		<span class="name">{{$vv['name']}}</span>
																		@if(!empty($vs)||!is_null($values))
																			@php
																				$job_id = explode('-',$values);
                                                                                $job_name = [];
                                                                                foreach (json_decode($input['ins'],true)['jobs'] as $one){
                                                                                        if($one['id']==$job_id[0]){
                                                                                        $job_name[0] = $one['name'];
                                                                                        if(isset($one['_child'])){
                                                                                           foreach ($one['_child'] as $two){
                                                                                            if($two['id']==$job_id[1]){
                                                                                            $job_name[1] = $two['name'];
                                                                                                if(isset($two['_child'])){
                                                                                                    foreach ($two['_child'] as $three){
                                                                                                           if($three['id']==$job_id[2]){
                                                                                                            $job_name[2] = $three['name'];
                                                                                                            }
                                                                                                        }
                                                                                                    }
                                                                                                }
                                                                                           }
                                                                                        }
                                                                                    }
                                                                                }
                                                                            $job_name =  implode('-',$job_name);
																			@endphp
																			<input id="name1" class="common-input"  value="{{$job_name}}"/>
																		@endif
																	</li>
																@endif
															@if($vv['type'] == 6)
																@foreach($vv['attributeValues'] as $ak => $av)
																	<li class="pickerfour">
																		<span class="name">{{$vv['name']}}</span>
																		<input id="name1" class="common-input btn btn-default"  value="{{$values}}"/>
																	</li>
																@endforeach
															@endif
															@if(in_array($vv['type'], [0, 9]))
																<li class="pickerfour">
																	<span class="name">{{$vv['name']}}</span>
																	@foreach($vv['attributeValues'] as $ak => $av)
																		@if($values ==$av['ty_value'])
																			<input type="text" value="{{$av['value']}}"/>
																		@endif
																	@endforeach
																</li>
															@endif
														@endif
												@endforeach
											@endif
										@endforeach
									@endif
								@endforeach
							</ul>
							<div class="division"></div>
						</div>
					</div>
				</div>
				<div class="buttonbox">
					<form class="form-horizontal" method="post"  id="form" action="{{ url('ins/insure_post')}}">
						{{ csrf_field() }}
						<input type="hidden" name="input" value="{{json_encode($input)}}">
						<input type="hidden" name="insurance_attributes" value="{{$insurance_attributes}}">
						<input type="hidden" name="identification" value="{{$identification}}">
					</form>
					<button type="submit" class="btn btn-next" value="">下一步</button>
				</div>
			</div>
		</div>

		<script src="{{config('view_url.view_url')}}mobile/js/lib/jquery-1.11.3.min.js"></script>
		<script src="{{config('view_url.view_url')}}mobile/js/lib/mui.min.js"></script>
		<script src="{{config('view_url.view_url')}}mobile/js/common.js"></script>
		<script src="{{config('view_url.view_url')}}mobile/js/preview.js"></script>
		<script>
			$('.btn-next').on('click',function(){
				insureSubmit();
			})
            function insureSubmit() {
                $(form).submit();
            }
		</script>
	</body>

</html>