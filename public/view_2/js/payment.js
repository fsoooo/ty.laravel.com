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
			_this.find('#bank_name').val(items[0].text);
			_this.find('#bank_code').val(items[0].id);
			_this.find('#bank_num').val(items[0].code);
		});
	});
});