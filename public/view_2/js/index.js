$(function() {
	// banner保险分类切换
//	$('.main-classify-left li').hover(function() {
//		var index = $(this).index();
//		console.log(index);
//		$(this).addClass('active').siblings().removeClass('active');
//		$('.main-classify-content').eq(index).addClass('active').siblings().removeClass('active');
//	});
	
	var classifyArr = {};
	$('.main-classify-left li').each(function(){
		var id = $(this).data('id');
		if(classifyArr[id]){
			var index = $(this).index();
			$(this).remove();
			$('.main-classify-content').eq(index).remove();
		}else{
			classifyArr[id] = id;
		}
	});
	
	// banner保险分类切换
	$('.main-classify-left li').hover(function() {
		var index = $(this).index();
		$(this).addClass('active').siblings().removeClass('active');
		$('.main-classify-content').eq(index).addClass('active').siblings().removeClass('active');
	});
	
	// var length = $('.swiper-slide').length;
	// // banner轮播图
	// var mySwiper = new Swiper('.swiper-container', {
	// 	autoplay: 5000,
	// 	loop: true,
	// 	effect: 'fade',
	// 	onInit: function(swiper){
	// 	    $('.totalpages').text(length);
	// 	},
	// 	onSlideChangeStart: function(swiper){
	// 		var cur;
	// 		swiper.activeIndex > length ? cur = 1 : cur = swiper.activeIndex;
	// 		if(swiper.activeIndex<=0){cur = length;}
	// 		$('.currentpage').text(cur);
	// 	}
	// });
	//
	// $('.swiper-button-prev').click(function(e) {
	// 	e.preventDefault()
	// 	mySwiper.slidePrev();
	// });
	// $('.swiper-button-next').on('click', function(e) {
	// 	e.preventDefault()
	// 	mySwiper.slideNext();
	// });
})