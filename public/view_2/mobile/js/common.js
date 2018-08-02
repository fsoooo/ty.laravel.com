(function(doc, win) {
	var docEl = doc.documentElement,
		resizeEvt = 'orientationchange' in window ? 'orientationchange' : 'resize',
		recalc = function() {
			var clientWidth = docEl.clientWidth;
			if (!clientWidth) return;
			if (clientWidth > 750) {
				clientWidth = 750;
			}
			docEl.style.fontSize = 100 * (clientWidth / 750) + 'px';
		};
	if (!doc.addEventListener) return;
	win.addEventListener(resizeEvt, recalc, false);
	doc.addEventListener('DOMContentLoaded', recalc, false);
//	document.getElementsByTagName('body')[0].style.maxWidth = '750px';
//	document.getElementsByTagName('body')[0].style.margin = '0 auto';
})(document, window);

	//检测横屏竖屏
		window.addEventListener("onorientationchange" in window ? "orientationchange" : "resize", function() {  
	            if (window.orientation === 180 || window.orientation === 0) {  
	                 window.location.reload(); 
	            }   
	            if (window.orientation === 90 || window.orientation === -90 ){   
	                 window.location.reload(); 
	            }    
	        }, false);   
$(function() {
	function timer(wait,ele) {
		wait--;
		ele.html(wait + 's');
		ele.attr('disabled', 'disabled').css({'background': '#ffae00','color':'#fff'});
		var clear = setInterval(function() {
				if (wait > 0) {
					wait--;
					ele.html(wait + 's');
				}
				if (wait <= 0) {
					ele.html('获取验证码').removeAttr('disabled').css({'background':'#f4f4f4','color':'#ffae00'});
					clearInterval(clear);
				}
			},
			1000);
	}

	// $('.btn-code').click(function(){
	// 	timer(60,$(this));
	// });
	
	$('a:not(.mui-control-item,sidebar-content iconfont,.mui-action-back)').on('tap',function(){
		document.location.href=this.href;
	});
	
	
	// 登录
	$('.btn-message,.btn-password').on('tap',function(){
		$(this).parents('.login-wrapper').hide().siblings().show()
	});
	
	$('.icon-close').on('tap',function(){
		mui('.mui-popover').popover('hide');
	});
	$('.icon-guanbi').on('tap',function(){
		mui('.mui-popover').popover('hide');
	});
	



});
// 弹出层
var Mask = function() {
	this.btn = ["取消", "确定"],
	this.init = function(){
	},
	this.open = function(html){
		$("body").append(html);
		$("html,body").css("overflow", "hidden");
		this.init();
	},
	this.close = function() {
//		$(".mask").animate({
//		    opacity:'0',
//		},1000,function(){
//			$(this).off().remove();
//		});
		$(".mask").hide();
		$("html,body").css("overflow", "auto");
	}
};
Mask.prototype.alert = function(msg, time, callback) {
	var _this = this;
	var timer = null;
	var html = '<div class="mask"><div class="mask-bg"></div><div class="mask-container">' + msg + '</div></div>'
	_this.open(html);
	$(".mask").click(function(ev) {
		clearTimeout(timer);
		_this.close();
	});
	$(".mask-container").click(function(ev) {
		ev.stopPropagation()
	});
	if(time && time > 0) {
		timer = setTimeout(function() {
			_this.close();
			callback && callback();
			clearTimeout(timer);
		}, time * 1000);
	}
};
Mask.prototype.loding = function(msg){
	var _this = this;
	var html = '<div class="mask mask-loding"><div class="mask-bg"></div><div class="mask-container"><div class="loadEffect"><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span>\
				</div><p class="text">'+ msg +'</p></div></div>';
	_this.open(html);
}
Mask.prototype.img = function(url){
	var _this = this;
	var html = '<div class="mask mask-loding"><div class="mask-bg"></div><div class="mask-container">\
				<div class="img-wrapper">\
					<img src="'+ url +'"/>\
				</div>\
			</div>\
		</div>';
	_this.open(html);
}
Mask.prototype.confirm = function(msg, btn, cancelcallback, confirmcallback) {
	var _this = this;
	if(btn instanceof Function) {
		confirmcallback = cancelcallback;
		cancelcallback = btn;
		btn = this.btn;
	}
	var html = '<div class="mask"><div class="mask-bg"></div>\
					<div class="mask-container">\
						<p>' + msg + '</p>\
						<div class="mask-btn-box"><button class="mask-btn mask-btn-cancel">' + btn[0] + '</button><button class="mask-btn mask-btn-confirm">' + btn[1] + '</button></div>\
					</div>\
				</div>';
	_this.open(html);

	$(".mask-bg").click(function(ev) {
		_this.close();
	});

	$(".mask-btn-cancel").click(function() {
		_this.close();
		cancelcallback && cancelcallback();
	});
	$(".mask-btn-confirm").click(function() {
		_this.close();
		confirmcallback && confirmcallback();
	});
};
var Mask = new Mask();
// json格式转换
function changeJsonData(json, type) {
	var Obj = JSON.parse(json);
	var Arr = [];
	for(item in Obj) {
		var bank = {};
		bank.id = Obj[item].ty_value;
		bank.text = Obj[item].value;
		if(type == "bank"){
			bank.code = Obj[item].code;
		}
		Arr.push(bank)
	}
	console.log(Arr)
	return Arr;
}