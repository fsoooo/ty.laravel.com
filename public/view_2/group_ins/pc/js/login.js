$(function(){
	var mySwiper = new Swiper('.swiper-container', {
		loop: true,
		autoplay: 3000,
		speed: 1000,
		// progress淡入淡出
		progress: true,
		onProgressChange: function(swiper) {
			for (var i = 0; i < swiper.slides.length; i++) {
				var slide = swiper.slides[i];
				var progress = slide.progress;
				var translate = progress * swiper.width;
				var opacity = 1 - Math.min(Math.abs(progress), 1);
				slide.style.opacity = opacity;
				swiper.setTransform(slide, 'translate3d(' + translate + 'px,0,0)');
			}
		},
		onTouchStart: function(swiper) {
			for (var i = 0; i < swiper.slides.length; i++) {
				swiper.setTransition(swiper.slides[i], 0);
			}
		},
		onSetWrapperTransition: function(swiper, speed) {
			for (var i = 0; i < swiper.slides.length; i++) {
				swiper.setTransition(swiper.slides[i], speed);
			}
		}

	});
})
