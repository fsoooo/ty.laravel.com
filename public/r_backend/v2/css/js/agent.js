// 初始化
$(".agent-info").panel({iWheelStep: 32});
var Ele = {
	agent_info : $('.agent-info ul'),
	addAgent : $('#addAgent'), // 模态框一
	step_one_form : $('#addAgent input'), // 模态框一表单
	tel : $('#tel'), //  代理人手机号
	add : $('#add'), // 下一步
	addStepTwo : $('#addStepTwo'), // 模态框二
	step_two_form : $('#addStepTwo input'), // 模态框二表单
	addChannelName : $('#addChannelName'), // 渠道名称
	finish : $('#finish'), // 完成
}

// 第一步 按钮是否禁用
Ele.step_one_form.bind('input propertychange', function() {  
    Ele.step_one_form.each(function(index){
    	if(!$(this).val() || !telReg.test(Ele.tel.val()) ){
    		Ele.add.prop('disabled',true);
    		return false;
    	}
    	if(index === 2){
    		Ele.add.prop('disabled',false);
    	}
    })
});

// 第二步 按钮是否禁用
Ele.step_two_form.bind('input propertychange', function() {
	Ele.addChannelName[0].disabled = !$(this).val();
});

// 进入第二步
Ele.add.click(function(){
	Ele.addAgent.modal('hide');
	Ele.addStepTwo.modal('show');
	Ele.step_one_form.val('');
	Ele.add[0].disabled = true;
});

// 返回第一步
$('#last').click(function(){
	Ele.addStepTwo.modal('hide');
	Ele.addAgent.modal('show');
	Ele.step_two_form.val('');
});

// 添加渠道名称
Ele.addChannelName.click(function(){
	var total = 15; // 限制总人数
	var name = Ele.step_two_form.val();
	var html = '<li>'+ name +'<span class="fr">0/'+ total +'</span></li>';
	Ele.agent_info.append(html);
	$(this).prop('disabled',true);
	Ele.step_two_form.val('');
});
// 选择渠道
Ele.agent_info.on('click','li',function(){
	$(this).addClass('selected').siblings().removeClass('selected');
	Ele.finish[0].disabled = false;
});