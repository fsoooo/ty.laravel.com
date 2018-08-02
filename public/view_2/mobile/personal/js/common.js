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

	$('.btn-code').click(function(){
		timer(60,$(this));
	});
	
	mui('.mui-scroll-wrapper').scroll({
		deceleration: 0.0005
	});
	
	// 单选框状态
	$(':input[type=radio]').click(function() {
		$(this).parents('.radiobox').find('.icon-danxuan2').removeClass('icon-danxuan2').addClass('icon-danxuan1');
		$(this).parent().find('.icon-danxuan1').removeClass('icon-danxuan1').addClass('icon-danxuan2');
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
	
	// 滑动解锁
//	var oBtn = document.getElementById('btn');
//	var oW, oLeft;
//	var oSlider = document.getElementById('slider');
//	var oTrack = document.getElementById('track');
//	var oIcon = document.getElementById('icon');
//	var oSpinner = document.getElementById('spinner');
//	var flag = 1;
//
//	oBtn.addEventListener('touchstart', function(e) {
//		if (flag == 1) {
//			var touches = e.touches[0];
//			oW = touches.clientX - oBtn.offsetLeft;
//		}
//	}, false);
//
//	oBtn.addEventListener("touchmove", function(e) {
//		var maxLength = oSlider.clientWidth - oBtn.offsetWidth;
//		if (flag == 1) {
//			var touches = e.touches[0];
//			oLeft = touches.clientX - oW;
//			console.log(oLeft)
//			if (oLeft < 0) {
//				oLeft = 0;
//			} else if (oLeft > maxLength) {
//				oLeft = maxLength;
//			}
//			oBtn.style.left = oLeft + "px";
//			oTrack.style.width = oLeft + 'px';
//		}
//	}, false);
//
//	oBtn.addEventListener("touchend", function() {
//		var maxLength = oSlider.clientWidth - oBtn.offsetWidth;
//		if (oLeft >= maxLength) {
//			oIcon.style.display = 'none';
//			oSpinner.style.display = 'block';
//			flag = 0;
//			$('.bg-green').text('完成验证');
//		} else {
//			oBtn.style.left = 0;
//			oTrack.style.width = 0;
//		}
//	}, false);
//	
	
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
		bank.id = Obj[item].id;
		bank.text = Obj[item].name;
		if(type == "bank"){
			bank.code = Obj[item].code;
		}
		Arr.push(bank)
	}
	console.log(Arr)
	return Arr;
}


// 正则验证
var nameReg = /^[\u4e00-\u9fa5\w-]{2,20}$/;
var telReg = /^1[34578]\d{9}$/;
var IdCardReg = /^(\d{15}$|^\d{18}$|^\d{17}(\d|X|x))$/;
var emailReg = /^[A-Za-z0-9\u4e00-\u9fa5]+@[a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]+)+$/;
var passwordReg = /^[a-zA-Z0-9]{6,18}$/;
function checkCorrect(ele,reg){
	var _this = $(ele);
	if(!reg.test(_this.val())){
		
		var name = _this.parent().find('.name').text().replace(/\*/,'');		
		var tip = name + '填写错误，请重新填写';
		mui.toast(tip);
		return false;
	}else{
		return true;
	}
}

function checkEmpty(ele){
	var _this = $(ele);
	if(!_this.val()){
		_this.parent().find('.error').html('');
		var name = _this.parents('li').find('.name').text().replace(/\*/,'');	
		var tip = name + '未填写';
		mui.toast(tip);
		return false;
	}else{
		return true;
	}
}
function checkUpload(ele){
	if(!ele.val()){
		mui.toast('请上传照片');
		return false;
	}else{
		return true;
	}
}





// 校验所有必填项是否为空
function checkMustFill(ele){
	var status = false;
	$(ele).each(function(index){
		var _this = $(this);
		if(!_this.val()){
			return false;
		}
		if(index === $(ele).length-1){
			status = true;
		}
	});
	return status;
}

// 下拉单项选择器
function dataPicker(ele,callback){
	var dataPicker = new mui.PopPicker();
	$(ele).on('tap', function() {
		$('input').blur();
		var _this = $(this);
		var data = $(this).attr('data-options');
		if(data) {
			dataPicker.setData(JSON.parse(data));
			console.log(JSON.parse(data))
			dataPicker.show(function(items) {
				var value = items[0].value;
				var text = items[0].text;
				_this.find('input:visible').val(text);
				_this.find('input:hidden').val(value);
				console.log(_this.find('input:hidden').val());
				if(typeof callback === 'function'){
					callback();
				}
			});
		}
	});
}


function selectData(ele,type){
	$(ele).each(function(){
		var $ele = $(this);
		var $btn = $ele.find('.zbtn-select');
		var $value = $ele.find('.select-value input');
		$btn.on('tap',function(){
			var _this = $(this);
			if(type === 'single'){ // 单选
				_this.addClass('active').siblings().removeClass('active');
				var index = _this.index();
				$value.eq(index).prop('checked',true);
			}
		});
	});
}



function initProduct(){
	mui('.product-wrapper').on('tap','a',function(){document.location.href=this.href;});
	mui.ready(function() {
		var header = document.querySelector('header.mui-bar');
		var list = document.getElementById('list');
		list.style.height = (document.body.offsetHeight - header.offsetHeight) + 'px';
	});
	
	selectData('.radioBox','single');
	
	
	$('.mui-indexed-list-search,#cancel').on('tap',function(){
		mui('.popover-search').popover('toggle');
	});
	
	$('.select-box').each(function(){
		$(this).find('.zbtn-select:gt(5)').hide();
	});
	
	// 侧滑筛选的全部与收起
	$('.radioBox .more').on('tap',function(){
		
		$(this).toggleClass('unfold');
		
		if($(this).hasClass('unfold')){
			var html = '收起<i class="iconfont icon-gengduo"></i>';
			$(this).html(html);
			$(this).parents('.radioBox').find('.zbtn-select:gt(5)').show();
		}else{
			var html = '全部<i class="iconfont icon-gengduo"></i>';
			$(this).html(html);
			$(this).parents('.radioBox').find('.zbtn-select:gt(5)').hide();
		}
	});
	
	// 侧滑筛选重置
	$('#reset').on('tap',function(){
		$('.zbtn-select').removeClass('active');
		$('.filtrate-wrapper input').prop('checked',false);
	});
}


// 时间选择器
function pickerDate(ele,callback){
	$(ele).on('tap', function() {
		$('input').blur();
		var _this = $(this);
		var picker = new mui.DtPicker({
			"type": "date",
			"beginYear": 1999
		});
		picker.show(function(rs) {
			_this.find('input:visible').val(rs.text);
			_this.find('input:hidden').val(rs.text);
			console.log(_this.find('input:visible').val());
			console.log(_this.find('input:hidden').val());
			if(typeof callback === 'function'){
				callback();
			}
			picker.dispose();
		});
	});
}


//上传图片
function Upload(options){
	this.defaults = {
		type: 'img',
		ele: null,
		num: 5,
		maxSize: 5,
	};
	this.options = $.extend({}, this.defaults, options);
	this.container = $(this.options.ele);
	if(this.options.type === 'img'){this.img();}
}
Upload.prototype = {
	img: function(){
		var _this = this;
		_this.photos_add = _this.container.find('.photos-add');//上传图片的li的类名
		_this.btn_upload = _this.container.find('.btn-upload');//button的类名
	
		var index = _this.container.data('id');
		_this.preview = $('.pop .popover').eq(index-1);//预览图片的div
		_this.p = _this.preview.find('.swiper-button-prev');//按钮---暂时不需要
		_this.n = _this.preview.find('.swiper-button-next');//按钮--暂时不需要
		_this.c = _this.preview.find('.swiper-container');//swiper的外层
		_this.b = _this.preview.find('.bg');//预览的背景
		_this.d = _this.preview.find('.icon-delete');//删除按钮
		
		
    	var mySwiper = new Swiper(_this.c,{
    		observer: true,
    		onSlideChangeStart: function(swiper){
		    	swiper.activeIndex === 0 ? _this.d.hide() : _this.d.show();
		    }
    	});
    	
		_this.p.click(function(){mySwiper.slidePrev();});
    	_this.n.click(function(){mySwiper.slideNext();});
    	
    	_this.b.click(function(){_this.preview.css({'visibility':'hidden'})})
    	_this.container.find('.photos-item').on('click',function(){
			var index = $(this).index();
			console.log(index)
			mySwiper.slideTo(index,0);
			_this.preview.css({'visibility':'visible'});
    	});
			    		
		_this.btn_upload.click(function(){
			$(this).parent().find('input').click();
		});
		_this.photos_add.find('input[type="file"]').off().on("change",function(e){
			var file = $(this)[0].files[0],reader = new FileReader();
			
			if(!/\/(png|jpg|jpeg|bmp|PNG|JPG|JPEG|BMP)$/.test(file.type)){
				Mask.alert('图片支持jpg, jpeg, png或bmp格式',2);
				return false;
			}
			if(file.size>_this.options.maxSize*1024*1024){
				Mask.alert('单个文件大小必须小于等于'+ _this.options.maxSize +'MB',2)
				return false;
			}
		    reader.readAsDataURL(file);
		    reader.onload = function(e){
		    	var value = e.target.result;
		    	var html = '<li class="photos-item"><img src="'+ value +'" alt="" class="imgobj"/><input hidden type="text" value="'+ value +'"/></li>';
		    	$(html).insertBefore(_this.photos_add);
		    	canAddPhoto();
		    	// 预览
		    
		    	var str = '<div class="swiper-slide" style="background-image:url('+ value +')"></div>';
		    	_this.preview.find('.swiper-wrapper').append(str);
		    	_this.container.find('.photos-item').click(function(){
					var index = $(this).index();
					mySwiper.slideTo(index,1);
					_this.preview.css({'visibility':'visible'});
		    	});
			}
		});
		// 删除照片
    	_this.d.click(function(){
			var index = mySwiper.activeIndex;
			_this.container.find('.photos-item').eq(index).remove();
			_this.preview.find('.swiper-slide').eq(index).remove();
			var num = _this.container.find('.photos-item').length;
			if(num == 1){
				$(this).hide();
			}
		});
		
		// 是否可以继续拍照上传
		function canAddPhoto(){
		    var num = _this.container.find('.photos-item').length;
			if(num >= _this.options.num){
	    		_this.photos_add.hide();
	    	}else{
	    		_this.photos_add.show();
	    	}
		}
	}
}