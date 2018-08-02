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
			<div class="notice-wrapper">
				<h2 class="notice-title">健康告知</h2>
				<div class="notice-content">
					<div class="mui-scroll-wrapper notice-scroll-wrapper">
						<div class="mui-scroll">
							<ul class="notice-list">
								<li>
									<div class="name">1.投保年龄</div>
									<p>被保险人投保年龄为2周岁（含）至70周岁（含）。</p>
								</li>
								<li>
									<div class="name">2.销售地区</div>
									<p>本计划仅限在如下地区销售： 广东省深圳市内。</p>
								</li>
								<li>
									<div class="name">1.投保年龄</div>
									<p>被保险人投保年龄为2周岁（含）至70周岁（含）。 2.销售地区 本计划仅限在如下地区销售： 广东省深圳市内。 3</p>
								</li>
								<li>
									<div class="name">1.投保年龄</div>
									<p>被保险人投保年龄为2周岁（含）至70周岁（含）。 2.销售地区 本计划仅限在如下地区销售： 广东省深圳市内。 3</p>
								</li>
								<li>
									<div class="name">1.投保年龄</div>
									<p>被保险人投保年龄为2周岁（含）至70周岁（含）。 2.销售地区 本计划仅限在如下地区销售： 广东省深圳市内。 3</p>
								</li>
								<li>
									<div class="name">1.投保年龄</div>
									<p>被保险人投保年龄为2周岁（含）至70周岁（含）。 2.销售地区 本计划仅限在如下地区销售： 广东省深圳市内。 3</p>
								</li>
								<li>
									<div class="name">1.投保年龄</div>
									<p>被保险人投保年龄为2周岁（含）至70周岁（含）。 2.销售地区 本计划仅限在如下地区销售： 广东省深圳市内。 3</p>
								</li>
								<li>
									<div class="name">1.投保年龄</div>
									<p>被保险人投保年龄为2周岁（含）至70周岁（含）。 2.销售地区 本计划仅限在如下地区销售： 广东省深圳市内。 3</p>
								</li>
								<li>
									<div class="name">1.投保年龄</div>
									<p>被保险人投保年龄为2周岁（含）至70周岁（含）。 2.销售地区 本计划仅限在如下地区销售： 广东省深圳市内。 3</p>
								</li>
								<li>
									<div class="name">1.投保年龄</div>
									<p>被保险人投保年龄为2周岁（含）至70周岁（含）。 2.销售地区 本计划仅限在如下地区销售： 广东省深圳市内。 3</p>
								</li>
								<li>
									<div class="name">1.投保年龄</div>
									<p>被保险人投保年龄为2周岁（含）至70周岁（含）。 2.销售地区 本计划仅限在如下地区销售： 广东省深圳市内。 3</p>
								</li>
								<li>
									<div class="name">1.投保年龄</div>
									<p>被保险人投保年龄为2周岁（含）至70周岁（含）。 2.销售地区 本计划仅限在如下地区销售： 广东省深圳市内。 3</p>
								</li>
								<li>
									<div class="name">1.投保年龄</div>
									<p>被保险人投保年龄为2周岁（含）至70周岁（含）。 2.销售地区 本计划仅限在如下地区销售： 广东省深圳市内。 3</p>
								</li>

							</ul>
						</div>
					</div>
				</div>
				<div class="notice-button-wrapper">
					<button class="btn btn-have">有过/现在有</button>					
					<button class="btn btn-health" onclick="doAddForm()">健康</button>
				</div>
			</div>
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
		</script>
	</body>
</html>