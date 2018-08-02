$(function() {

	$('.btn-add').click(function() {
		$(this).parents('.contact').toggleClass('active');
	});
	// 提交按钮状态
	$(':input[type=checkbox]').click(function() {
		var status = $(this).is(':checked');
		if (status) {
			$('#submit').removeClass('btn-unusable').removeAttr('disabled').addClass('btn-f18164');
		} else {
			$('#submit').addClass('btn-unusable').attr('disabled','disabled').removeClass('btn-f18164');
		}
	});
	$('#submit').click(function(){
		console.log('提交投保单');
	});
	
	
	// 证件类型
	$('.certificate-type .select-dropdown li').click(function() {
		var val = $(this).text();
		if (val !== '身份证') {
			$('.person-show-hide').show();
		} else {
			$('.person-show-hide').hide();
		}
	});
	// 为谁投保
	$('.insure .select-dropdown li').click(function() {
		var val = $(this).text();
		if (val !== '本人') {
			$('.person-other-content').show();
			$('.person-other>ul>li').css({
				'margin-bottom': '25px'
			});
		} else {
			$('.person-other-content').hide();
			$('.person-other>ul>li').css({
				'margin-bottom': '0'
			});
		}
	});
	// 获取当前时间
	function getNowFormatDate() {
		var date = new Date();
		var seperator1 = "-";
		var month = date.getMonth() + 1;
		var strDate = date.getDate();
		if (month >= 1 && month <= 9) {
			month = "0" + month;
		}
		if (strDate >= 0 && strDate <= 9) {
			strDate = "0" + strDate;
		}
		var currentdate = date.getFullYear() + seperator1 + month + seperator1 + strDate;
		return currentdate;
	}
	// 初始化当前时间
	$('#starttime').text(getNowFormatDate());
	$('.time-start').text(getNowFormatDate() + '零时起');
	$('.time-end').text(getNextFormatDate() + '二十四时');

});
// 计算截止时间
function getNextFormatDate() {
	var startTime = $('.time-start').text().slice(4, 10);
	var startYear = parseInt($('.time-start').text().slice(0, 4));
	var endTime = startYear + 1 + startTime;
	return endTime;
}
laydate({
	elem: '#starttime',
	min: laydate.now(0),
	max: laydate.now(+365),
	choose: function(datas) {
		$('.time-start').text(datas + '零时起');
		$('.time-end').text(getNextFormatDate() + '二十四时');
	}
});

laydate({
	elem: '#birthday',
	max: laydate.now(0),
	choose: function(datas) {
		console.log(datas)
	}
});