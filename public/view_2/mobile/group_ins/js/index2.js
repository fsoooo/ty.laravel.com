$(function() {
	
	// 导航切换
	var $window = $(window);
	var initialWindowHeight = null;
	$window.resize(function() {
		sliderHeight();
	});
	sliderHeight();
	function sliderHeight() {
		var wHeight = $(window).height();
		var sliderHeight = wHeight - 70
		$(".swipe li").height(sliderHeight);
	}

	$(".find_nav_list").css("left", 0);
	$(".find_nav_list li").each(function() {
		$(".sideline").css({
			left: 0
		});
		$(".find_nav_list li").eq(0).addClass("find_nav_cur").siblings().removeClass("find_nav_cur");
	});
	var nav_w = $(".find_nav_list li").first().width();
	$(".sideline").width(nav_w);
	$(".find_nav_list li").on('click', function() {

		nav_w = $(this).width();
		$(".sideline").stop(true);
		$(".sideline").animate({
			left: $(this).position().left
		}, 300);
		$(".sideline").animate({
			width: nav_w
		});
		$(this).addClass("find_nav_cur").siblings().removeClass("find_nav_cur");
		var fn_w = ($(".find_nav").width() - nav_w) / 2;
		var fnl_l;
		var fnl_x = parseInt($(this).position().left);
		if(fnl_x <= fn_w) {
			fnl_l = 0;
		} else if(fn_w - fnl_x <= flb_w - fl_w) {
			fnl_l = flb_w - fl_w;
		} else {
			fnl_l = fn_w - fnl_x;
		}
		$(".find_nav_list").animate({
			"left": fnl_l
		}, 300);

	});
	var fl_w = $(".find_nav_list").width();
	var flb_w = $(".find_nav_left").width();

	for(n = 1; n < 9; n++) {
		var page = 'pagenavi' + n;
		var mslide = 'slider' + n;
		var mtitle = 'emtitle' + n;
		arrdiv = 'arrdiv' + n;
		var as = $("#" + page + "").find("a");
		var tt = new TouchSlider({
			id: mslide,
			'auto': '-1',
			fx: 'ease-out',
			direction: 'left',
			speed: 600,
			timeout: 5000,
			'before': function(index) {
				var as = document.getElementById(this.page).getElementsByTagName('a');
				as[this.p].className = '';
				this.p = index;

				fnl_x = parseInt($(".find_nav_list li").eq(this.p).position().left);

				nav_w = $(".find_nav_list li").eq(this.p).width();
				$(".sideline").stop(true);
				$(".sideline").animate({
					left: $(".find_nav_list li").eq(this.p).position().left
				}, 300);
				$(".sideline").animate({
					width: nav_w
				}, 100);
				$(".find_nav_list li").eq(this.p).addClass("find_nav_cur").siblings().removeClass("find_nav_cur");
				var fn_w = ($(".find_nav").width() - nav_w) / 2;
				var fnl_l;
				if(fnl_x <= fn_w) {
					fnl_l = 0;
				} else if(fn_w - fnl_x <= flb_w - fl_w) {
					fnl_l = flb_w - fl_w;
				} else {
					fnl_l = fn_w - fnl_x;
				}
				$(".find_nav_list").animate({
					"left": fnl_l
				}, 300);
			},
			'after': function(index) {
				console.log(index)
				$('.mui-scroll-wrapper').removeClass('active');
				$('.mui-scroll-wrapper').eq(index).addClass('active');
				var scrollY = mui('.mui-scroll-wrapper.active').scroll().y;
				showOrHide(scrollY);
			}
		});
		tt.page = page;
		tt.p = 0;
		for(var i = 0; i < as.length; i++) {
			(function() {
				var j = i;
				as[j].tt = tt;
				$(as[j]).on('tap', function() {
					this.tt.slide(j);
					return false;
				});
			})();
		}
	}
	
	var Ele = {
		searchwrapper: $('.search-wrapper'),
		btnreturntop: $('.btn-returntop')
	}
	mui('.mui-scroll-wrapper').scroll({
		deceleration: 0.0005
	});
	var offCanvasWrapper = mui('#offCanvasWrapper');
	document.getElementById('offCanvasShow').addEventListener('tap', function() {
		offCanvasWrapper.offCanvas('show');
	});
	$('.btn-exit').on('tap', function() {
		var btnArray = ['否', '是'];
		mui.confirm('您确定要退出吗？', '', btnArray, function(e) {
			if(e.index == 1) {
				console.log('exit')
				offCanvasWrapper.offCanvas('close');
			}
		});
	});
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
	
	$('.swiper-nav .swiper-slide').on('tap',function(){
		$(this).addClass('active').siblings().removeClass('active');
	});
	mui('.mui-scroll-wrapper').scroll({
		deceleration: 0.0005,
		indicators: true
	});
	$('.btn-returntop').on('tap', function() {
		mui('.active.mui-scroll-wrapper').scroll().scrollTo(0, 0, 100);
	});

	var offCanvasInner = $('.mui-inner-wrap').get(0);
	offCanvasInner.addEventListener('drag', function(event) {
		event.stopPropagation();
	});
	
	
	$('.mui-scroll').each(function() {
		this.addEventListener('scrollend', function(e) {
			var scrollY = mui('.mui-scroll-wrapper.active').scroll().y;
			showOrHide(scrollY);
		});
	});
	function showOrHide(num) {
		if(num < 0) {
			Ele.btnreturntop.show(500);
		} else {
			Ele.btnreturntop.hide(500);
		}
	}
});