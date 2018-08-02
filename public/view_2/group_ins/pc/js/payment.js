$(function(){
	// 添加其他银行卡
	var popup;
	$('.btn-addcard').click(function(){
		popup = new Popup('.popup-addcard');
	});
	
	$(':input[type=checkbox]').click(function() {
		var status = $(this).is(':checked');
		if (status) {
			$(this).parent().next().show();
		} else {
			$(this).parent().next().hide();
		}
	});
});
