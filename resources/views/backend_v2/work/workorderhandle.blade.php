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
		<link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/workorderhandle.css" />
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
			<h1 class="mui-title">工单信息处理</h1>
		</header>
		<div id="record">
			<div class="outer">
				<div class="mui-control-content mui-active">
					<div  class="mui-scroll-wrapper">
						<div class="mui-scroll">
							<div class="info">
								<ul class=" ullist clearfix">
									@foreach($content as $value)
										@if($value->send_id == 0)
											<li class="info-left">
												{{$value->content}}  {{$value->send_id}}
											</li>
										@else
											<li class="info-right">
												{{$value->content}}
											</li>
										@endif
									@endforeach
								</ul>
							</div>

							<input hidden value="{{$input['recipient_id']}}" id="recipient_id">
							<input hidden value="{{$input['id']}}" id="id">
							<input type="hidden" name="_token" value="{{csrf_token()}}">
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="button-box clearfix">
			<input type="text" placeholder="请输入要回复的内容" id="inpt" value=""/>
			<button id="add" class="zbtn zbtn-default">发送</button>
		</div>
		<script src="{{config('view_url.agent_mob')}}js/lib/jquery-1.11.3.min.js"></script>
		<script src="{{config('view_url.agent_mob')}}js/lib/mui.min.js"></script>
		<script src="{{config('view_url.agent_mob')}}js/lib/startScore.js"></script>
		<script src="{{config('view_url.agent_mob')}}js/common_agent.js"></script>
		<script type="text/javascript">
			$('#add').click(function(){
				var a=$('#inpt').val();
				if(a==""){
					mui.toast("回复内容不能为空");
				}else{
					var str = '<li class="info-right show">'+a+'</li>';
					$('#inpt').val("");
			    	$(".ullist").append(str);

					recipient_id = $("#recipient_id").val();
					id = $("#id").val();
					_token = $("input[name='_token']").val();

					$.ajax({
						url:'/agent_sale/add_reply',
						type:'POST',
						data:{_token:_token,id:id,recipient_id:recipient_id,a:a},
						success:function(res){
							if(res['status'] == 200){
//								var html = '<i class="iconfont icon-chenggong1" style="font-size: 24px;vertical-align: middle;margin-right: 10px;"></i>关闭成功';
//								Mask.alert(html,2);

							}else{
								alert(res['msg']);
							}
						}
					})



				}
				
			});
		</script>
	</body>
</html>