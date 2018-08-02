$(function() {
	mui('.mui-scroll-wrapper').scroll({
		deceleration: 0.0005,
	});

	// 判断被保人是否为本人 true:是本人
	var isSelf = false;
	if(isSelf) {
		$('.hide').eq(0).prev().css({
			'border': 'none'
		});
	} else {
		$('.hide').eq(0).prev().hide()
		$('.hide').show();
	}
	$('.btn-next').on('tap', function() {
		window.location.href = 'payment.html';
	});
});