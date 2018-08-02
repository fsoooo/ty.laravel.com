$(function() {
	var offCanvasWrapper = mui('#offCanvasWrapper');
	document.getElementById('offCanvasShow').addEventListener('tap', function() {
		offCanvasWrapper.offCanvas('show');
	});
	
	mui('.mui-scroll-wrapper').scroll({
	deceleration: 0.0005 //flick 减速系数，系数越大，滚动速度越慢，滚动距离越小，默认值0.0006
});

	$('.btn-exit').on('tap', function() {
		var btnArray = ['否', '是'];
		mui.confirm('您确定要退出吗？', '', btnArray, function(e) {
			if(e.index == 1) {
				console.log('exit')
				offCanvasWrapper.offCanvas('close');
			}
		})
	});

	var Ele = {
		searchwrapper: $('.search-wrapper'),
		btnreturntop: $('.btn-returntop')
	}
	$('.mui-icon-search').on('tap', function() {
		Ele.searchwrapper.addClass('unfold');
	});
	$('.icon-fanhui2').on('tap', function() {
		Ele.searchwrapper.removeClass('unfold');
	});
	var mySwiper = new Swiper('.banner', {
		autoplay: 5000,
		pagination: '.swiper-pagination',
	});
	var mySwiper = new Swiper('.cooperation', {
		slidesPerView: 4,
		spaceBetween: 10,
		slidesOffsetAfter: 50
	});
	var mySwiper = new Swiper('.swiper-nav', {
		slidesPerView: 4,
		spaceBetween: 10,
		slidesOffsetAfter: 50
	});
	
	$('.swiper-nav .swiper-slide').on('tap',function(){
		$(this).addClass('active').siblings().removeClass('active');
	});
	mui('.mui-scroll-wrapper').scroll({
		deceleration: 0.0005,
		indicators: true
	});
	$('.btn-returntop').on('tap', function() {
		mui('.mui-active .mui-scroll-wrapper').scroll().scrollTo(0, 0, 100);
	});
	$('.mui-scroll').each(function() {
		this.addEventListener('scrollend', function(e) {
			var scrollY = mui('.mui-active .mui-scroll-wrapper').scroll().y;
			showOrHide(scrollY);
		});
	})
	var scrollTop = [];
//	document.getElementById('slider').addEventListener('slide', function(e) {
//		var scrollY = mui('.mui-active .mui-scroll-wrapper').scroll().y;
//		var index = $('.mui-slider-item.mui-active').index()
//		scrollTop[index] = scrollY;
//		showOrHide(scrollTop[e.detail.slideNumber])
//	});

	function showOrHide(num) {
		if(num < 0) {
			Ele.btnreturntop.show(500);
		} else {
			Ele.btnreturntop.hide(500);
		}
	}

});