// 初始化
$(function(){
	var emailReg = /^[A-Za-z0-9\u4e00-\u9fa5]+@[a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]+)+$/;
	$(".agent-info").panel({iWheelStep: 32});
	var Ele = {
		agent_info : $('.agent-info ul'),
		addAgent : $('#addAgent'), // 模态框一
		step_one_form : $('#addAgent input'), // 模态框一表单
		tel : $('#tel'), //  代理人手机号
		email : $('#email'), //  代理人邮箱
		add : $('#add'), // 下一步
		addStepTwo : $('#addStepTwo'), // 模态框二
		step_two_form : $('#addStepTwo input'), // 模态框二表单
		addChannelName : $('#addChannelName'), // 渠道名称
		finish : $('#finish'), // 完成
	}
	
	// 第一步 按钮是否禁用
	Ele.step_one_form.bind('input propertychange', function() {  
	    Ele.step_one_form.each(function(index){
	    	if(!$(this).val()){
	    		Ele.add.prop('disabled',true);
	    		return false;
	    	}
	    	if(index == Ele.step_one_form.length - 1){
	    		if(!telReg.test(Ele.tel.val()) ||  !emailReg.test(Ele.email.val()) ){
	    			Ele.add.prop('disabled',true);
	    		}else{
	    			Ele.add.prop('disabled',false);
	    		}
	    	}
	    });
	});
	
	// 第二步 按钮是否禁用
	Ele.step_two_form.bind('input propertychange', function() {
		Ele.addChannelName[0].disabled = !$(this).val();
	});
	
	// 进入第二步
	Ele.add.click(function(){
		Ele.addAgent.modal('hide');
		Ele.addStepTwo.modal('show');
		// Ele.step_one_form.val('');
		Ele.add[0].disabled = true;
	});
	
	// 返回第一步
	$('#last').click(function(){
		Ele.addStepTwo.modal('hide');
		Ele.addAgent.modal('show');
		// Ele.step_two_form.val('');
	});
	
	// 添加渠道名称
	Ele.addChannelName.click(function(){
		var name = $("#ditch_name").val();
		var token = $("input[name=_token]").val();
		$.post('/backend/agent/add_ditch',{'ditch_name':name,'_token':token},function(data){
			if(data > 0){
				var total = 15; // 限制总人数
				var name = Ele.step_two_form.val();
				var html = '<li ditch_id="'+ data +'">'+ name +'<span class="fr">0/'+ total +'</span></li>';
				Ele.agent_info.append(html);
				$(this).prop('disabled',true);
				Ele.step_two_form.val('');
			}else if(data < 0) {
				$('#add-ditch-error').show();
				setTimeout(function () {
					$("#add-ditch-error").fadeOut("slow");
				}, 1000);
			}
		});
	
	});
	// 选择渠道
	Ele.agent_info.on('click','li',function(){
		$(this).addClass('selected').siblings().removeClass('selected');
		var ditch_id = $(this).attr('ditch_id');
		$("#add_agent_ditch_id").val(ditch_id);
		Ele.finish[0].disabled = false;
	});
});