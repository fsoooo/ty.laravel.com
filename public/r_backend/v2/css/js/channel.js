// 初始化
$(".channel-info").panel({iWheelStep: 32});
var Ele = {
	channel_info : $('.channel-info ul'),
	name : $('#name'),
	tel : $('#tel'),
	code : $('#code'),
	addInfo : $('#addInfo'),
	addchannel : $('#addchannel'),
	step_one_form : $('#addStepOne input'),
	step_tow_form : $('#addStepTow input'),
}

// 添加渠道名称
Ele.step_one_form.bind('input propertychange', function() {
	$('#add')[0].disabled = !$(this).val();
});
// 添加渠道代理人
Ele.step_tow_form.bind('input propertychange', function() {  
    Ele.step_tow_form.each(function(index){
    	if(!$(this).val()|| !telReg.test(Ele.tel.val()) ){
    		$('#addInfo').prop('disabled',true);
    		return false;
    	}
    	if(index === 2){
    		$('#addInfo').prop('disabled',false);
    	}
    })
});

// 进入添加渠道代理人
$('#add').click(function(){
	$('#addStepOne').modal('hide');
	$('#addStepTow').modal('show');
	Ele.step_one_form.val('');
	$('#add')[0].disabled = true;
});

// 返回添加渠道名称
$('#last').click(function(){
	$('#addStepTow').modal('hide');
	$('#addStepOne').modal('show');
	Ele.step_tow_form.val('');
	$('.channel-info li').remove();
	calculatePerson();
});


// 添加代理人
Ele.addInfo.click(function(){
	var code = Ele.code.val();
	var name = Ele.name.val();
	var html = '<li><span class="fl">'+ code +'</span>'+ name +'<i class="fr iconfont icon-guanbi"></i></li>';
	Ele.channel_info.append(html);
	$(this).prop('disabled',true);
	Ele.step_tow_form.val('');
	calculatePerson();
})
			
// 删除代理人
Ele.channel_info.on('click','.iconfont',function(){
	var tag = $(this).parents('li').remove();
	calculatePerson();
});
// 计算剩余人数
function calculatePerson(){
	var total = 15;
	var num = $('.channel-info li').length;
	$('.modal-step-two .tips').text(num +'/15');
	
	if(num == total){
		Ele.step_tow_form.attr("readOnly","true");
	}else{
		Ele.step_tow_form.removeAttr("readOnly");
	}
}