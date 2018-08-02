$(function(){
	$('table .btn-small').click(function(){
		$(this).addClass('active').siblings().removeClass('active');
		isallselected();
	});
	
	$('#btn-all').click(function(){
		$('.step2 tr').each(function(){
			$(this).find('.btn-small').eq(0).addClass('active').siblings().removeClass('active');
		});
		isallselected();
	});
	
	function isallselected(){
		var tatal = $('.step2 tr').length;
		$('.step2 tr').each(function(index,ele){
			var col1 = $(this).find('.btn-small').eq(0);
			if(!col1.hasClass('active')){
				$('#btn-next').addClass('btn-unusable').removeClass('btn-f18164').attr('disabled','disabled');
				return false;
			}
			if(index == tatal-1){
				$('#btn-next').removeClass('btn-unusable').addClass('btn-f18164').removeAttr('disabled');
			}
		})
	}
});
