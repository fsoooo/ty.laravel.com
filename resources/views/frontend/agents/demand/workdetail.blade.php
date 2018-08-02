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
	<link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/progress.css" />
	<link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/workdetail.css" />
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
	<h1 class="mui-title">工单详情页</h1>
</header>
<div id="record">
	<div class="outer">
		<div class="mui-control-content mui-active">
			<div  class="mui-scroll-wrapper">
				<div class="mui-scroll">
					<div class="progresscliaml clearfix">
						<ul class="progress1">
							<!--处理完成灰色-->
							<li class="progress-item1 unconfirm">
								<div class="progress-outer1">
									<div class="progress-inner1"></div>
									<div class="textinfo">处理完成 </div>
								</div>
							</li>
							<!--处理完成蓝色-->
							<li class="progress-item1 confirm active" style="display: none;">
								<div class="progress-outer1">
									<div class="progress-inner1"></div>
									<div class="textinfo">处理完成 </div>
								</div>
							</li>
							<!--处理中原本的样式-->
							<li class="undetail progress-item1 visited">
								<div class="progress-outer1">
									<div class="progress-inner1"></div>
									<div class="textinfo">处理中</div>
								</div>
							</li>
							<!--处理中要显示的元素-->
							<li class="detail progress-item1 active" style="display: none;">
								<div class="progress-outer1">
									<div class="progress-inner1"></div>
									<div class="textinfo" id="show">处理中  <i class="iconfont icon-gengduo"></i></div>
								</div>
							</li>
							<!--阅读中原本的元素-->
							<li class="unread progress-item1 active" >
								<div class="progress-outer1">
									<div class="progress-inner1"></div>
									<div class="textinfo">阅读工单</div>
								</div>
							</li>
							<!--阅读成功要显示的元素-->
							<li class="read progress-item1 active" style="display: none;">
								<div class="progress-outer1">
									<div class="progress-inner1"></div>
									<div class="textinfo">阅读工单&nbsp; <span class="prompt">提醒查看工单</span></div>
								</div>
							</li>
							<li class="progress-item1 active">
								<div class="progress-outer1">
									<div class="progress-inner1"></div>
									<div class="textinfo">发起工单   <span>{{$data['created_at']}}</span></div>
								</div>
							</li>
						</ul>
					</div>
					<div class="textinfo-cont" style="display: none;">
						<span>{{$content->content}} &nbsp;&nbsp;&nbsp;<span class="corlorb reply">回复</span></span>
					</div>
					<div class="text-info">
						<div class="text-info-line">
							<span>工单标题：{{$data['title']}}</span>
						</div>
						<div class="text-info-content">
							<p>工单正文: {{$content->content}}</p>
						</div>
					</div>
					<div class="text-info-s">
								<span>收件人:<span>
										 @if($data['recipient_id'] == 0)
											业管
										@elseif($data['recipient_id'] == -1)
											天眼后台
										@endif
									</span></span>&nbsp;
								<span>所属模块:<span>
										 @if($data['module'] == 1)
											客户
										@elseif($data['module'] == 2)
											产品
										@elseif($data['module'] == 3)
											计划书
										@elseif($data['module'] == 4)
											销售业绩
										@elseif($data['module'] == 5)
											销售任务
										@elseif($data['module'] == 6)
											活动
										@elseif($data['module'] == 7)
											消息
										@elseif($data['module'] == 8)
											评价
										@elseif($data['module'] == 9)
											账户设置
										@else
											--
										@endif
									</span></span>
					</div>
					<div class="button-box">
						<input hidden value="{{$data['status']}}" id="status">
						<input hidden value="{{$data['agent_id']}}" id="agent_id">
						<input hidden value="{{$data['recipient_id']}}" id="recipient_id">
						<input hidden value="{{$data['id']}}" id="id">
						<input hidden value="{{strtotime($data['created_at'])}}" id="created_at">
						<button id="add" class="zbtn zbtn-default">结束工单</button>
						<input type="hidden" name="_token" value="{{csrf_token()}}">
					</div>
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
	$(function(){
		$(".reply").click(function(){
			recipient_id = $("#recipient_id").val();
			id = $("#id").val();
			agent_id = $("#agent_id").val();
			location.href='/agent_sale/reply_list/?id='+id+"&recipient_id="+recipient_id+"&agent_id="+agent_id;

		})
	})

	//处理中
	$('#show').click(function(){
		$('.textinfo-cont').css('display','block');
		$('#show').html('处理中  <i class="iconfont icon-jiantou2"></i>')
	});
	//回复的链接跳转
//	$('.corlorb').click(function(){
//		location.href='workorderhandle.html';
//	});

	//提醒查看工单的

	$('.prompt').click(function(){
		created_at = $("#created_at").val();
		time_now = Math.round(new Date().getTime()/1000);

		if (time_now - created_at <= 86400){
			// 发起工单未满24小时调用
			Mask.alert('发起工单24小时后才能提醒',2);
		}else{
		// 提醒成功之后调用
			var html = '<i class="iconfont icon-chenggong1" style="font-size: 24px;vertical-align: middle;margin-right: 10px;"></i>提醒成功，请耐心等待';
			Mask.alert(html,2);
		}

	});

	status = $("#status").val();
	if(status==1){
		$('.unconfirm').show();
		$('.confirm').hide();
		$('.undetail').show();
		$('.detail').hide();
		$('.unread').hide();
		$('.read').show();
	}
	if(status==2){
		$('.unconfirm').show();
		$('.confirm').hide();
		$('.undetail').hide();
		$('.detail').show();
		$('.unread').show();
		$('.read').hide();
	}
	if(status==3){
		$('.unconfirm').hide();
		$('.confirm').show();
		$('.unread').show();
		$('.read').hide();
		$('.undetail').hide();
		$('.detail').show();
	}

	$(function(){
		$(".zbtn-default").click(function(){
			 id = $("#id").val();
			 _token = $("input[name='_token']").val();
			$.ajax({
				url:'/agent_sale/end_work_list',
				type:'POST',
				data:{_token:_token,id:id},
				success:function(res){
					if(res['status'] == 200){
						var html = '<i class="iconfont icon-chenggong1" style="font-size: 24px;vertical-align: middle;margin-right: 10px;"></i>关闭成功';
						Mask.alert(html,2);

					}else{
						alert(res['msg']);
					}
				}
			})

		})
	})

</script>
</body>
</html>
