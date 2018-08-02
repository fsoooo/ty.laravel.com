$(function() {
	var scrollFunc = function(e) {
		e = e || window.event;
		if(e.wheelDelta && event.ctrlKey) {
			event.returnValue = false;
		} else if(e.detail) {
			event.returnValue = false;
		}
	}
	if(document.addEventListener) {
		document.addEventListener('DOMMouseScroll', scrollFunc, false);
	}
	window.onmousewheel = document.onmousewheel = scrollFunc;
	// 顶部导航
	$('.nav-top>li').hover(function() {
		$(this).find('.dropdown').show();
		$(this).find('.icon-jiantou2').removeClass('turndown').addClass('turn');
	}, function() {
		$(this).find('.dropdown').hide();
		$(this).find('.icon-jiantou2').removeClass('turn').addClass('turndown');
	});
	$(".cooperation li:lt(5)").css({
		"borderRight": "none",
		"borderBottom": "none"
	});

	$(".cooperation li:lt(9)").css({
		"borderRight": "none"
	});
	$(".cooperation li:eq(4)").css({
		"borderRight": "1px solid #cecece"
	});
	
	// 返回顶部
	$('.btn-returntop').click(function() {
		console.log('1')
		$('body,html').animate({
			scrollTop: 0
		}, 600);
	});

	// 侧边栏的显示与隐藏
	$('.sidebar li').hover(function() {
		$(this).find('.sidebar-text').show();
	}, function() {
		$(this).find('.sidebar-text').hide();
	});

	// 初始化当前下拉框
	dropDown();

	// 复选框状态
	$(':input[type=checkbox]').click(function() {
		var status = $(this).is(':checked');
		if (status) {
			$(this).parent().find('.icon').removeClass('icon-checkbox').addClass('icon-checkbox-selected');
		} else {
			$(this).parent().find('.icon').removeClass('icon-checkbox-selected').addClass('icon-checkbox');
		}
	});
	
	// 单选框状态
	$(':input[type=radio]').click(function() {
		$(this).parents('.radiobox').find('.iconfont').removeClass('icon-danxuan2').addClass('icon-danxuan1');
		$(this).parent().find('.iconfont').removeClass('icon-danxuan1').addClass('icon-danxuan2');
	});
	
	var clientHeight = document.documentElement.clientHeight||document.body.clientHeight;
	var footerHeight = $('.footer').get(0).offsetHeight;
	$('.footer').css({'margin-top':'-'+footerHeight+'px'})
	$('.content').css({'min-height':clientHeight+'px'})
	$('.content-inside').css({'padding-bottom':footerHeight+'px'})

});


// 正则验证
var nameReg = /^[\u4e00-\u9fa5\w-]{2,20}$/;
var telReg = /^1[34578]\d{9}$/;
var IdCardReg = /^(\d{15}$|^\d{18}$|^\d{17}(\d|X|x))$/;
var emailReg = /^[A-Za-z0-9\u4e00-\u9fa5]+@[a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]+)+$/;
var passwordReg = /^[a-zA-Z0-9]{6,18}$/;
function checkCorrect(ele,reg){
	var _this = $(ele);
	if(!reg.test(_this.val())){
		_this.parent().find('.error').html('');
		
		var name = _this.parent().find('.form-name').text().replace(/^\*/,'');		
		var tip = name + '填写错误，请重新填写';
		_this.parent().find('.error').text(tip);
	}
	
}

function checkEmpty(ele){
	var _this = $(ele);
	if(!_this.val()){
		_this.parent().find('.error').html('');
		var name = _this.parents('li').find('.form-name').text().replace(/^\*/,'');	
		var tip = name + '未填写';
		_this.parents('li').find('.error').text(tip);
	}
}
function checkUpload(ele){
	if(!ele.val()){
		ele.parent().find('.error').html('请上传')
	}
}





// 下拉框
function dropDown() {
	var initText = $('.select-dropdown>li').eq(0).text();
	$('.select span').text(initText);
	$('.select').click(function(e) {
		var e = window.event || e;
		$('.select').removeClass('active');
		$(this).toggleClass('active');
		if (e.stopPropagation) {
			e.stopPropagation();
		} else {
			e.cancelBubble = true;
		}
	});
	$('.select ul.select-dropdown li').click(function(e) {
		var dataVal = $(this).attr('data-value');
		var e = window.event || e;
		var val = $(this).html();
		$(this).parents('.select').find('span').html(val);
		$('.select').removeClass('active');
		if (e.stopPropagation) {
			e.stopPropagation();
		} else {
			e.cancelBubble = true;
		}
		
		$(this).parents('.select').find('.inputhidden').val(dataVal)
	})
	$(document).click(function() {
		$('.select').removeClass('active');
	});
}

function Popup(el) {
	this.popup = $(el);
	this.bg = this.popup.find('.popup-bg');
	this.btncancel = this.popup.find('.btn-cancel');
	this.iconclose = this.popup.find('.icon-close');
	this.initEvents();
}
Popup.prototype.initEvents = function() {
	var _this = this;
	_this.popup.show();
	$("html,body").css("overflow", "hidden");
	_this.popup.find('.popup-bg,.btn-cancel,.icon-close').click(function() {
		_this.close();
	});
}
Popup.prototype.close = function() {
	this.popup.hide();
	$("html,body").css("overflow", "initial");
}


// 弹出提示框
var Mask = function() {
	this.btn = ["取消", "确定"],
	this.init = function(){
		var container = $(".mask-container");
		var width = container.outerWidth();
		var height = container.outerHeight();
		container.css({"marginLeft":"-" + width/2 + "px","marginTop":"-" + height/2 + "px"});
	},
	this.open = function(html){
		$("body").append(html);
		// $("html,body").css("overflow", "hidden");
		this.init();
	},
	this.close = function() {
		$(".mask").off().remove();
		// $("html,body").css("overflow", "initial");
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
	var html = '<div class="mask mask-confirm"><div class="mask-bg"></div><div class="mask-container"><div class="title">提示</div><p>' + msg + '</p><div class="mask-btn-box"><button class="mask-btn mask-btn-cancel">' + btn[0] + '</button><button class="mask-btn mask-btn-confirm">' + btn[1] + '</button></div></div></div>';
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
var areaData = areaData || '';
if(areaData){
	var Cascade = function(province, city, county) {
		this.provinceEle = province;
		this.cityEle = city;
		this.countyEle = county;
		this.init();
		this.changeProvince();
		this.changeCity();
	}
	Cascade.prototype = {
		provinceArr: areaData.province,
		cityArr: areaData.city,
		countyArr: areaData.county,
		init: function() {
			var provinceHtml = '';
			for(var id in this.provinceArr) {
				provinceHtml += '<option value="' + id + '">' + this.provinceArr[id] + '</option>'
			}
			this.provinceEle.append(provinceHtml);
	
			var id = this.provinceEle.val();
			this.change(this.cityArr[id], this.cityEle);
			this.change(this.countyArr[this.cityArr[id][0][1]], this.countyEle);
		},
		changeProvince: function() {
			var _this = this;
			this.provinceEle.change(function() {
				var id = $(this).val();
				_this.change(_this.cityArr[id], _this.cityEle);
				_this.change(_this.countyArr[_this.cityArr[id][0][1]], _this.countyEle);
			});
		},
		changeCity: function() {
			var _this = this;
			this.cityEle.change(function() {
				var id = $(this).val();
				_this.change(_this.countyArr[id], _this.countyEle);
			});
		},
		change: function(arr, ele) {
			ele.empty();
			var html = '';
			for(var i = 0; i < arr.length; i++) {
				html += '<option value="' + arr[i][1] + '">' + arr[i][0] + '</option>'
			}
			ele.append(html);
		}
	}
}