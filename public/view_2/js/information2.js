$(function() {
	
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
	
	// 添加被保险人信息
	$('.btn-operation-add').click(function() {
		var html = '<tr><td><div class="select"><span>其他</span><ul class="select-dropdown"><li>本人</li><li>丈夫</li><li>妻子</li><li>女儿</li><li>儿子</li><li>哥哥</li><li>弟弟</li><li>姐姐</li><li>妹妹</li><li>其他</li></ul>\
				</div></td><td><input type="text" /></td><td><div class="select"><span>身份证</span><ul class="select-dropdown"><li>身份证</li><li>护照</li><li>军官证</li><li>其他</li><li>台胞证</li></ul>\
				</div></td><td><input type="text" /></td><td><div class="select type"><span>男</span><ul class="select-dropdown"><li>男</li><li>女</li></ul></div></td><td><input type="text" /></td><td><input type="text" /><i class="iconfont icon-close"></i></td></tr>';
		$('.personlist table').append(html);
		$('.icon-close').show();
		dropDown();
		$('.icon-close').click(function() {
			$(this).parents('tr').remove();
		});
	});

	$('.btn-add').click(function() {
		$(this).parents('.contact').toggleClass('active');
	});
	
	
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