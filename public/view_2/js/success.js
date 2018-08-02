$(function(){
	var popup = new Popup('.popup-success');
	$('.btn-confirm').click(function(){
		popup.close();
	});
	
	$('.success-share>.btn').click(function(){
		new Popup('.popup-share')
		$('.jiathis_style span').removeClass('jtico');
	});
	
	var jiathis_config = {
		data_track_clickback: 'true'
	};
						
});
