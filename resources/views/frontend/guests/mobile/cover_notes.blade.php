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
	<style>
	</style>
	<body>
		<div id="noticePopover" class="mui-popover noticePopover">
			<a href="/ins/ins_info/{{$ty_product_id}}"><i class="iconfont icon-guanbi"></i></a>
			<!--投保须知-->
			<div class="notice-wrapper" style="display: block">
				<h2 class="notice-title">投保须知</h2>
				<div class="notice-content">
					<div class="mui-scroll-wrapper notice-scroll-wrapper">
						<div class="mui-scroll">
							<div class="notice-list list1">
								{{$product_res}}
							</div>
						</div>
					</div>
				</div>
				<div class="notice-button-wrapper">
					<button class="btn btn-agree">我已查看并同意《投保须知》</button>
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
            $('.btn-agree').on('tap', function() {
				@if($res == 2)
				window.location.href = '/ins/mobile_group_ins/insure/'+identification;
				@elseif($res != 3)
				  window.location.href = '/ins/insure/'+identification;
				@else
//				  window.location.href = '/ins/insure/'+identification;
                window.location.href = 'health_notice/'+identification;//健康告知
				@endif
            });
            $('.icon-guanbi').on('tap', function() {
                history.go(-1);
                location.reload();
            });

			// 投保须知-健康告知格式转换
//			function changeInfo(cont){
//				var html = '<ul>';
//				cont = cont.replace(/\d\./g,"//").split('//');
//				var arr = [];
//				for (var i=0,l=cont.length;i<l;i++) {
//					if(!cont[i].trim()){continue;}
//					arr = cont[i].replace(/\d、/g,"//").split('//');
//					for(var j=0,len=arr.length;j<len;j++){
//						if(len == 1){
//							html += '<li><span>'+ (i) + '.</span>' +arr[j] +'</li>';
//						}else{
//							if(!arr[j].trim()){continue;}
//							if(j==1){
//								html += '<li><span>'+ (i) + '.</span>' + (j) + '、' +arr[j] +'</li>';
//							}else{
//								html += '<li class="level2"><span>'+ (j) + '、</span>' +arr[j] +'</li>';
//							}
//						}
//					}
//				}
//				html += '</ul>';
//				return html;
//			}
//
//			$(".list1").html(changeInfo($('.list1').text()));
			function changeInfo(cont){
				var html = '<ul>';
				cont = cont.replace(/\d+[\.]/g,"///").split('///');
				var arr = [];
				$.each(cont,function(index){
					if(index !== 0){
						html += '<li><span>'+ (index) + '.</span>' +cont[index] +'</li>';
					}
				});
				html += '</ul>';
				return html;
			}
			//            console.log($('.list1').text());
			$(".list1").html(changeInfo($('.list1').text()));
		</script>
	</body>
</html>
