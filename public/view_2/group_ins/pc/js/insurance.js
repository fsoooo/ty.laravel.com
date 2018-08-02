$(function(){
	var ele = {
		icon: $(this).parent().find('.icon'),
		btn: $('.notification-left-operation .btn')
	}
	$(':input[type=checkbox]').click(function() {
		var status = $(this).is(':checked');
		if (status) {
			ele.icon.removeClass('icon-checkbox').addClass('icon-checkbox-selected');
			ele.btn.removeClass('btn-unusable').addClass('btn-f18164').removeAttr('disabled');
		} else {
			ele.icon.removeClass('icon-checkbox-selected').addClass('icon-checkbox');
			ele.btn.removeClass('btn-f18164').addClass('btn-unusable').attr('disabled','disabled');
		}
	});
	
	$('.btn').click(function(){
		location.href='health.html';
	})
})
