$(function() {
	mui('.mui-scroll-wrapper').scroll({
		deceleration: 0.0005,
	});
	var bankPicker = new mui.PopPicker();

	var banksJson = $('.pickerone').attr('data-options');
	bankPicker.setData(changeJsonData(banksJson,'bank'));
	$('.pickerone').on('tap', function() {
		var _this = $(this)
		bankPicker.show(function(items) {
			console.log(items)
			_this.find('input').val(items[0].text);
			_this.find('.inputhidden').val(items[0].id);
		});
	});
});