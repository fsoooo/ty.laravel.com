$('.filtrate-img li').click(function(){
	$(this).siblings().find('.text').hide().end().find('img').show();
	$(this).find('.text').show().end().find('img').hide();
});

$('.filtrate-item li').click(function(){
	$(this).addClass('active').siblings().removeClass('active')
});


$('.filtrate-img>li:gt(7)').hide();
var initHeight = $('.filtrate-letter').height();
$('.more').click(function(){
	if($('.fold').is(':hidden')){
		$('.unfold').hide();
		$('.fold').show();
		$('.filtrate-img>li:gt(7)').hide();
		$('.filtrate-letter .filtrate-name').css({'height': initHeight+'px','lineHeight': initHeight+'px'})
	}else{
		// 展开
		$('.unfold').show();
		$('.fold').hide();
		$('.filtrate-img>li:gt(7)').show();
		var height = $('.filtrate-letter').height();
		$('.filtrate-letter .filtrate-name').css({'height': height+'px','lineHeight': height+'px'})
	}
});