<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>记录沟通</title>
		<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
		<link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/lib/mui.min.css">
		<link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/lib/iconfont.css" />
		<link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/common_agent.css" />
		<link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/client.css" />
		<link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/workorder.css" />
		<style>
			.mui-popover{top: initial;left: 0;}
			.block {
			    width: 100%;
			    padding-top: 5px; 
			   
			}
		</style>
	</head>

	<body>
		<header id="header" class="mui-bar mui-bar-nav">
			<a class="iconfont icon-fanhui mui-pull-left mui-action-back"></a>
			<h1 class="mui-title">我的需求</h1>
		</header>
		<div id="record">
			<div class="outer-nav">
				<div id="" class="tab-wrapper">
					<a class="" href="/agent_sale/demand">发起需求工单</a>
					<a class="active">我的工单</a>
				</div>
			</div>
			<div class="outer">
				<div class="mui-control-content mui-active">
					<div  class="mui-scroll-wrapper">
						<div class="mui-scroll">
							@foreach($data as $v)
							<div class="division"></div>
							<div class="form-wrapper add-wrapper">
								<div class="borderline">
									<span class="corl">{{strtok($v['created_at'],' ')}}</span><span class="corl">工单编号：{{$v['id']}}</span>
								</div>
								<h5 class="detail" id="{{$v['id']}}">{{$v['title']}}</h5>
								<span class="cor">
									 @if($v['status'] == 1)
										已发送
									@elseif($v['status'] == 2)
										交流中
									@elseif($v['status'] == 3)
										已结束
									@else
										--
									@endif
								</span>
								<i class="iconfont icon-delete delete" id="{{$v['id']}}"></i>
							</div>
							@endforeach
						</div>
					</div>
				</div>
			</div>
		</div>
		<script src="{{config('view_url.agent_mob')}}js/lib/jquery-1.11.3.min.js"></script>
		<script src="{{config('view_url.agent_mob')}}js/lib/mui.min.js"></script>
		<script src="{{config('view_url.agent_mob')}}js/lib/startScore.js"></script>
		<script src="{{config('view_url.agent_mob')}}js/common_agent.js"></script>
		<script type="text/javascript">
			var a=1;
			$(function(){
				$(".delete").click(function(){
					id = $(".delete").attr("id");
					location.href='/agent_sale/delete_work_list/'+id;
				})

				$(".detail").click(function(){
					obj = $(this);
					id = obj.attr("id");
					location.href='/agent_sale/work_detail/'+id;
				})
			})
		</script>
	</body>
</html>