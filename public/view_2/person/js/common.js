$(function() {
	// 顶部导航
	$('.nav-top>li').hover(function() {
		$(this).find('.dropdown').show();
		$(this).find('.icon-jiantou2').removeClass('turndown').addClass('turn');
	}, function() {
		$(this).find('.dropdown').hide();
		$(this).find('.icon-jiantou2').removeClass('turn').addClass('turndown');
	});
	$(".cooperation li:lt(4)").css({
		"borderRight": "none",
		"borderBottom": "none"
	});

	$(".cooperation li:lt(8)").css({
		"borderRight": "none"
	});
	$(".cooperation li:eq(4)").css({
		"borderRight": "1px solid #cecece"
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
		
	new tabControl('.ui-tabControl');
	
	
	// 安全等级
	function safety(leve){
		var colors = ['#ff642e','#ffb32e','#fff82e','#b3ff2e','#d8d7d9'];
		var html = '';
		for(var i=0;i<colors.length;i++){
			if(i<leve){
				html += '<i style="background: '+ colors[i] +'"></i>';
			}
		}
		for(var i=0;i<colors.length-leve;i++){
			html += '<i style="background: '+ colors[colors.length-1] +'"></i>';
		}
		html += '<span class="safety-text">较高</span>';
		$('.safety-wrapper').append(html);
	}
	safety(3);
	
	
	
});

function timer(wait,ele) {
	wait--;
	ele.html(wait + 's');
	ele.attr('disabled', 'disabled').css({'color':'#ffae00'});
	var clear = setInterval(function() {
		if (wait > 0) {
			wait--;
			ele.html(wait + 's');
		}
		if (wait <= 0) {
			ele.html('发送验证码').removeAttr('disabled').css({'color':'#00a2ff'});
			clearInterval(clear);
		}
	},
	1000);
}
// 正则验证
var nameReg = /^[\u4e00-\u9fa5\w-]{2,20}$/;
var telReg = /^1[34578](\d{9})$/;
var IdCardReg = /^(\d{15}$|^\d{18}$|^\d{17}(\d|X|x))$/;
var emailReg = /^[A-Za-z0-9\u4e00-\u9fa5]+@[a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]+)+$/;

function checkCorrect(ele,reg){
	var _this = $(ele);
	if(!reg.test(_this.val())){
		_this.parent().find('.error').html('');
		
		var name = _this.parent().find('.form-name').text().replace(/^\*/,'');		
		var tip = name + '填写错误，请重新填写';
		_this.parent().find('.error').text(tip);
		return false;
	}else{
		return true;
	}
}

function checkEmpty(ele){
	var _this = $(ele);
	if(!_this.val()){
		_this.parent().find('.error').html('');
		var name = _this.parent().find('.form-name').text().replace(/^\*/,'');	
		var tip = name + '未填写';
		_this.parent().find('.error').text(tip);
		return false;
	}else{
		return true;
	}
}
function checkUpload(ele){
	if(!ele.val()){
		ele.parent().find('.error').html('请上传');
		return false;
	}else{
		return true;
	}
}









// 选项卡
function tabControl(ele){
	this.ele = $(ele);
	this.label = this.ele.find('.ui-tabControl-label>span');
	this.content = this.ele.find('.ui-tabControl-content>div');
	this.init();
}
tabControl.prototype.init = function(){
	var _this = this;
	_this.label.eq(0).addClass('active')
	_this.content.eq(0).show().siblings().hide();
	this.label.click(function(){
		var index = $(this).index();
		$(this).addClass('active').siblings().removeClass('active');
		_this.content.eq(index).show().siblings().hide();
	})
}
// 下拉框
function dropDown() {
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

//function Popup(el) {
//	this.popup = $(el);
//	this.bg = this.popup.find('.popup-bg');
//	this.btncancel = this.popup.find('.btn-cancel');
//	this.initEvents();
//}
//Popup.prototype.initEvents = function() {
//	var _this = this;
//	_this.popup.show();
//	$("html,body").css("overflow", "hidden");
//	_this.popup.find('.iconfont').click(function() {
//		_this.close();
//	});
//}
//Popup.prototype.close = function() {
//	this.popup.fadeOut(600);
//	$("html,body").css("overflow", "initial");
//}



// 弹出框
var Popups = function(){
	this.open = function(ele,callback) {
		var _this = this;
		$(ele).show();
		$(ele).find('.icon-close').click(function(){
			_this.close(ele);
			if(typeof callback === 'function'){
				callback();
			}
		});
	},
	this.close = function(ele) {
		$(ele).fadeOut(600);
	}
}
var Popups = new Popups();
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
		$("html,body").css("overflow", "hidden");
		this.init();
	},
	this.close = function() {
		$(".mask").off().remove();
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
Mask.prototype.loding = function(msg, time, callback) {
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




//上传照片最多20张
		var Ele = {
				photos_add : $('.photos-wrapper .photos-add'),
				photos_btn_add : $('.photos-wrapper .btn-add'),
				photos_wrapper : $('.photos-wrapper'),
			}
			const photos_total = 20;
			//************保单拍照上传************//
			
			// 上传照片
			var upLoadImg = function(e,callback){
				var _this = $(e).parent();
				var $c = _this.find('input[type=file]')[0];
				var file = $c.files[0],reader = new FileReader();
			    reader.readAsDataURL(file);
			    reader.onload = function(e){
			    	var value = e.target.result;
			    	var html = '<li class="photos-item"><img src="'+ value +'" alt="" class="imgobj"/><input hidden type="text" value="'+ value +'"/></li>';
			    	$(html).insertBefore('.photos-wrapper .photos-add');
			    	//img放到轮播图位置
			    	var str = '<div class="swiper-slide"><img src="'+ value +'" alt="" /></div>';
			    	$(".swiper-wrapper").append(str);
			    	canAddPhoto();
//			    	canCreate();
					callback && callback();
					
				};
			};
			
			Ele.photos_btn_add.click(function(){
				$(this).parent().find('input').click();
			});
			// 是否可以继续拍照上传
			function canAddPhoto(){
			    var num = Ele.photos_wrapper.find('li').length;
				if(num >= photos_total+1){
		    		Ele.photos_add.hide();
		    	}else{
		    		Ele.photos_add.show();
		    	}
			}
			
			
			
function Check(ele,options){
	this.defaults = {
		notCheckedClass: 'icon-duoxuan-weixuan',
		checkedClass: 'icon-duoxuanxuanzhong01',
	};
	this.options = $.extend({}, this.defaults, options);
	this.container = $(ele);
	this.all = this.container.find('thead .iconfont');
	this.item = this.container.find('th:first-child .iconfont,td:first-child .iconfont');
	this.init();
}

Check.prototype = {
	init: function(){
		var _this = this;
		var notCheckedClass = _this.options.notCheckedClass;
		var checkedClass = _this.options.checkedClass;
		
		this.item.click(function(){
			var $this = $(this);
			if($this.hasClass(notCheckedClass)){
				$this.removeClass(notCheckedClass).addClass(checkedClass);
			}else{
				$this.removeClass(checkedClass).addClass(notCheckedClass);
			}
			
			if($this.hasClass(notCheckedClass)){
				_this.all.addClass(notCheckedClass).removeClass(checkedClass)
			}
		});
		
		this.all.click(function(){
			var $this = $(this);
			if($this.hasClass(notCheckedClass)){
				$('tbody .'+checkedClass).trigger('click');
			}else{
				$('tbody .'+notCheckedClass).trigger('click');
			}
		});
	}
}

//上传图片
function Upload(options){
	this.defaults = {
		type: 'img',
		ele: null,
		num: 5,
		maxSize: 2,
	};
	this.options = $.extend({}, this.defaults, options);
	this.container = $(this.options.ele);
	if(this.options.type === 'img'){this.img();}
}
Upload.prototype = {
	img: function(){
		var _this = this;
		_this.photos_add = _this.container.find('.photos-add');
		_this.btn_upload = _this.container.find('.btn-upload'),
		
		
		_this.preview = this.container.find('.previewPop');
		_this.p = _this.preview.find('.swiper-button-prev');
		_this.n = _this.preview.find('.swiper-button-next');
		_this.c = _this.preview.find('.swiper-container');
		_this.b = _this.preview.find('.popups-bg');
		_this.d = _this.preview.find('.btn-detele');
		
    	var mySwiper = new Swiper(_this.c,{
    		observer: true,
    		onSlideChangeStart: function(swiper){
		    	swiper.activeIndex === 0 ? _this.d.hide() : _this.d.show();
		    }
    	});
    	
		_this.p.click(function(){mySwiper.slidePrev();});
    	_this.n.click(function(){mySwiper.slideNext();});
    	_this.b.click(function(){_this.preview.css({'visibility':'hidden'})})
    	_this.container.find('.photos-item').click(function(){
			var index = $(this).index();
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


// 公共的方法
	//银行账户模态框打开
		$(function() {
			$('.bankAccounts').click(function() {
				Popups.open('.popup-bank');
			});
		});
		//支付宝账户模态框打开
		$(function() {
			$('.zhifubaoAccount').click(function() {
				Popups.open('.popupzfb');
			});
		});
		//微信账户模态框打开
		$(function() {
			$('.weixinAccount').click(function() {
				Popups.open('.popupwx');
			});
		});
		//微信账户的链接跳转
		$(function() {
			$('.texterqode').click(function() {
				Popups.close('.popupwx');
				Popups.open('.popupwxqrcode');
			});
		//二维码处的链接跳转
		$('.texterqode1').click(function() {
			Popups.close('.popupwxqrcode');
			Popups.open('.popupwx');
		});
			
		});
		//非空校验（银行，支付宝，微信的非空校验）
		$('.popup').find('input').bind('input porpertychange',function(){
			var inputs = $(this).parents('.popup').find('input');
			var btn = $(this).parents('.popup').find('button')[0];
			inputs.each(function(index){
				if(!$(this).val()){
					btn.disabled = true;
					return false;
				}
				if(index == inputs.length-1){
					btn.disabled = false;
				}
			})
		});
		//单选按钮的点击
		$('#checkR').click(function(){
			var label = $(this).parent();
			var icon = label.find('.iconfont');
			if(icon.hasClass('icon-danxuan')){
				icon.removeClass('icon-danxuan').addClass('icon-danxuan1');
			}else{
				icon.removeClass('icon-danxuan1').addClass('icon-danxuan');
			}
		})
		//银行卡账户确定保存的跳转
		$('#saveAccount').click(function(){
			Popups.close('.popup-bank');
			$('.yh').show();
			$('.sencethreeinfo-bottom').hide();
		})
		//微信账户确定保存的跳转
		$('#saveAccountwx').click(function(){
			Popups.close('.popupwx');
			$('.wx').show();
			$('.yh').hide();
			$('.sencethreeinfo-bottom').hide();
		})
		//支付宝账户确定保存的跳转
		$('#saveAccountzfb').click(function(){
			Popups.close('.popupzfb');
			$('.zfb').show();
			$('.yh').hide();
			$('.sencethreeinfo-bottom').hide();
		})

		//更改收款方式的跳转(银行)
		$('#paytype').click(function(){
			$('.yh').hide();
			$('.sencethreeinfo-bottom').show();
		});
		//更改收款方式的跳转(微信)
		$('#paytype1').click(function(){
			$('.wx').hide();
			$('.sencethreeinfo-bottom').show();
		});
		//更改收款方式的跳转(支付宝)
		$('#paytype2').click(function(){
			$('.zfb').hide();
			$('.sencethreeinfo-bottom').show();
		});
		