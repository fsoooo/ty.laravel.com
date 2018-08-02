$(function(){
	$('table .btn-small').click(function(){
		$(this).addClass('active').siblings().removeClass('active');
		isallselected();
	});
    $('#btn-all-yes').click(function(){
        $('.step2 tr').each(function(){
            $(this).find('.btn-small').eq(0).addClass('active').siblings().removeClass('active');
        });
        isallselected();
    });
	$('#btn-all-no').click(function(){
		$('.step2 tr').each(function(){
			$(this).find('.btn-small').eq(1).addClass('active').siblings().removeClass('active');
		});
		isallselected();
	});
	
	function isallselected(){
		var tatal = $('.step2 tr').length;
		$('.step2 tr').each(function(index,ele){
			var col1 = $(this).find('.btn-small').eq(0);
			if(!col1.hasClass('active')){
                $('#btn-all').removeAttr('disabled', 'disabled').removeClass('btn-unusable');
                $('#btn-next').addClass('btn-unusable').removeClass('btn-f18164').attr('disabled','disabled');
                return false;
			}
			if(index == tatal-1){
                $('#btn-all').attr('disabled', 'disabled').addClass('btn-unusable');
				$('#btn-next').removeClass('btn-unusable').addClass('btn-f18164').removeAttr('disabled');
			}
		})
	}
});
