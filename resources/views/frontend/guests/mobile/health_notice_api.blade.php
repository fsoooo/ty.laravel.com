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
		<link rel="stylesheet" href="{{config('view_url.view_url')}}mobile/css/details.css" />
	</head>
	<div id="noticePopover" class="mui-popover noticePopover">
			<i class="iconfont icon-guanbi"></i>
			<!--健康告知-->
		<form class="form-horizontal" method="post"  id="form" action="{{ url('ins/sub_health_notice')}}">
			<input type="hidden" name="transNo" value="{{ $transNo }}">
			<input type="hidden" name="partnerId" value="{{ $partnerId }}">
			{{ csrf_field()}}
			<input type="hidden" name="identification" value="{{ $identification }}">
			<input type="hidden" name="qaAnswer[healthyId]" value="{{ $healthId }}">
			<input type="hidden" name="moduleId" value="{{ $product_res['moduleId'] }}">
			<input type="hidden" name="keyCode" value="{{ $product_res['keyCode'] }}">
			<div class="notice-wrapper">
				<h2 class="notice-title">{{ $product_res['moduleName'] }}</h2>
				<div class="notice-content">
					<div class="mui-scroll-wrapper notice-scroll-wrapper">
						<div class="mui-scroll">
							<ul class="notice-list">
								@foreach($product_res['healthyQuestions'] as $key=>$value)
									<li data-id="{{ $value['questionId'] }}">
										<div class="name">{{ $key + 1  }} . {{$value['content']}}</div>
									</li>
									{{--层级关系--}}
									<input type="hidden" name="question[{{$value['questionId']}}][parentId]" value="{{$value['parentId']}}">
									<input type="hidden" name="question[{{$value['questionId']}}][questionSort]" value="{{$value['questionSort']}}">
									@if(isset($value['healthyAnswers']))
										@foreach($value['healthyAnswers'] as $k=>$val)


											@if(isset($val['description']))
												<li>
													<div class="name">{{ $val['description'] }}</div>
												</li>
											@endif

											{{--单选框    --}}
											@if($val['healthyAttribute']['attributeType'] == 9)
												<li>
													<li>
														@foreach($val['healthyAttribute']['attributeValues'] as $v)
															<li><input name="answer[{{ $val['questionIds'] }}][{{ $val['answerId'] }}][{{ $val['healthyAttribute']['keyCode'] }}]" type="radio" value="{{ $v['controlValue'] }}" /> {{ $v['attributeValue'] }} </li>
														@endforeach
													</li>
												</li>
											@endif

											{{--文本框--}}
											@if($val['healthyAttribute']['attributeType'] == 3)
												<li>
													<li>
														{{$val['healthyAttribute']['attributeName']}}<br>
														<input style="width: 100px;" class="" type="text" name="answer[{{ $val['questionIds'] }}][{{ $val['answerId'] }}][{{ $val['healthyAttribute']['keyCode'] }}]" regex="{{$val['healthyAttribute']['regex']}}" msg="{{$val['healthyAttribute']['errorRemind']}}">
                                                        <li class="green" style="width: 200px;">
                                                            {{ $val['healthyAttribute']['defaultRemind'] }}
                                                        </li>
													</li>
												</li>
											@endif

										@endforeach
									@endif
								@endforeach
							</ul>
						</div>
					</div>
				</div>
				<div class="notice-button-wrapper">
					{{--<button class="btn btn-have">有过/现在有</button>					--}}
					<button class="btn" >下一步</button>
				</div>
			</div>
		</form>
		</div>
		<script src="{{config('view_url.view_url')}}mobile/js/lib/jquery-1.11.3.min.js"></script>
		<script src="{{config('view_url.view_url')}}mobile/js/lib/mui.min.js"></script>
		<script src="{{config('view_url.view_url')}}mobile/js/lib/mui.picker.all.js"></script>
		<script src="{{config('view_url.view_url')}}mobile/js/common.js"></script>
		<script src="{{config('view_url.view_url')}}mobile/js/details.js"></script>
		<script>
			var identification = "{{$identification}}";
			mui('#noticePopover').popover('show');
			$('.btn-health').on('tap', function() {
				window.location.href = '/ins/insure/'+identification;
			});
			$('.icon-guanbi').on('tap', function() {
				history.go(-2);
				location.reload();
			});
            $('.btn-have').on('tap', function() {
                history.go(-2);
                location.reload();
            });

			var inputs = $('.health-content input:visible[type="text"]');
			inputs.on('blur',function(){

				var regex =  eval('/'+$(this).attr('regex')+'/');
				var value = $(this).val();
				if (regex){
					var msg = $(this).attr('msg');
					if (!regex.test(value)){
						$(this).val("");
//                        Mask.alert(msg,2);
						$(this).next().addClass('red');
						$(this).next().text(msg);
					} else {
						$(this).next().removeClass('red');
						$(this).next().text('输入完成');
					}
				}
			});


		</script>
	</body>
</html>