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
	<link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/demand.css" />
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
			<a class="active">发起需求工单</a>
			<a class="" href="workorder">我的工单</a>
		</div>
	</div>
	<div class="outer">
		<div class="mui-control-content mui-active">
			<div  class="mui-scroll-wrapper">
				<div class="mui-scroll">
					<div class="division"></div>
					<div class="form-wrapper add-wrapper">
						<ul>
							<li id="addClient" class="init-client">
								<a href="/agent_sale/recipients">
									<div class="list-img">
										<img src="{{config('view_url.agent_mob')}}img/add.png" alt="">
									</div>
									<span>收件人</span>
									<i class="iconfont icon-gengduo"></i>
								</a>
							</li>
							<li class="import-client" style="display: none;">
								<a href="/agent_sale/recipients">
									<div class="list-img">
										<img src="{{config('view_url.agent_mob')}}img/add.png" alt="">
									</div>
									<span id="r_name">收件人</span>
									<i class="iconfont icon-gengduo"></i>
								</a>
							</li>
							<li class="init-product">
								<a href="/agent_sale/subordinateModule">
									<div class="list-img">
										<img src="{{config('view_url.agent_mob')}}img/add.png" alt="">
									</div>
									<span>所属模块</span>
									<i class="iconfont icon-gengduo"></i>
								</a>
							</li>


							<li class="import-product" style="display: none;">
								<a href="/agent_sale/subordinateModule">
									<div class="list-img">
										<img src="{{config('view_url.agent_mob')}}img/add.png" alt="">
									</div>
									<span id="m_name">所属模块</span>
									<i class="iconfont icon-gengduo"></i>
								</a>
							</li>
						</ul>
					</div>
					<div class="division"></div>
					<div class="form-wrapper content-wrapper">
						<ul>
							<li>
								<span class="name">工单标题</span>
								<div id="startTwo"  class="block clearfix" >
									<input type="" name="" id="title" value="" placeholder="请填写"/>
								</div>
							</li>
							<li>
								<span class="name">工单正文</span>
								<textarea placeholder="请填写需求详细说明" id="content"></textarea>
							</li>
						</ul>
					</div>
					<div class="button-box">
						<button id="add" class="zbtn zbtn-default" disabled>发送</button>
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
	//发送按钮的禁用
	$('#startTwo').find('input').bind('input porpertychange',function(){
		var inputs = $('#startTwo').find('input').val();
		var btn = $('#add');
		if(inputs!=''){
			$('#add').prop('disabled',false);
			return false;
		}
	});
	var receiverId=sessionStorage.getItem("receiverId"); // 收件人id
	var moduleId=sessionStorage.getItem("moduleId"); // 所屬模块id

	if(receiverId){
		var r_name=sessionStorage.getItem("r_name"); // 所屬模块id

		$('.import-client').show();
		$('.init-client').hide();
		$("#r_name").text(r_name);
	}

	if(moduleId){
		var m_name=sessionStorage.getItem("m_name"); // 所屬模块id
		$('.import-product').show();
		$('.init-product').hide();
		$("#m_name").text(m_name);
	}


	$("#add").click(function(){
		title = $("#title").val(); //工单标题
		content = $("#content").val(); //工单正文
		var _token = $("input[name='_token']").val();
		$.ajax({
			type: "POST",
			url: "/agent_sale/demand_add",
			data: {_token:_token,receiverId:receiverId,moduleId:moduleId,title:title,content:content},
			success: function(msg){
				if(msg['status'] == 200){
					location.href='/agent_sale/addSuccess';
				}
			}
		});
	})

</script>
</body>
</html>