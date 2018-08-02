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
	
	
	// 全选
	$('#allSelect').click(function(){
		var _this = $(this);
		if(_this.prop('checked')){
			$('td input').prop('checked',true);
		}else{
			$('td input').prop('checked',false);
		}
	});
	
	
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
		return 0;
	}else{
		return 1;
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

function Popup(el) {
	this.popup = $(el);
	this.bg = this.popup.find('.popup-bg');
	this.btncancel = this.popup.find('.btn-cancel');
	this.initEvents();
}
Popup.prototype.initEvents = function() {
	var _this = this;
	_this.popup.show();
	$("html,body").css("overflow", "hidden");
	_this.popup.find('.iconfont').click(function() {
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
	//		provinceHtml += '<option disabled selected>请选择</option>';
			for(var id in this.provinceArr) {
				provinceHtml += '<option value="' + id + '">' + this.provinceArr[id] + '</option>'
			}
			this.provinceEle.append(provinceHtml);
	
			var id = this.provinceEle.val();
			this.change(this.cityArr[id], this.cityEle);
			this.change(this.countyArr[this.cityArr[id][0][1]], this.countyEle);
	//		if(this.cityArr[id]){
	//			this.change(this.countyArr[this.cityArr[id][0][1]], this.countyEle);
	//		}else{
	//			$('#city,#county').append('<option disabled selected>请选择</option>')
	//		}
			
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
			if(arr){
				for(var i = 0; i < arr.length; i++) {
					html += '<option value="' + arr[i][1] + '">' + arr[i][0] + '</option>'
				}
				ele.append(html);
			}
		}
	}
}

// 职业联动
var Profession = function(level1, level2) {
	this.level1 = level1;
	this.level2 = level2;
	this.init();
	this.changeLevel1();
}
Profession.prototype = {
	init: function() {
		var provinceHtml = '';
		var level1 = '';
		level1 += '<option disabled selected>请选择</option>';
		for(i in professionData){
			level1 += '<option value="' + professionData[i].id + '">' + professionData[i].name + '</option>';
		}
		this.level1.append(level1);
		this.change(professionData[0]._child, this.level2);
	},
	changeLevel1: function() {
		var _this = this;
		this.level1.change(function() {
			var id = $(this).val();
			for(var i in professionData){
				if(professionData[i].id == id){
					_this.change(professionData[i]._child, _this.level2);
				}
			}
		});
	},
	change: function(arr, ele) {
		ele.empty();
		var html = '';
		html += '<option disabled selected>请选择</option>';
		for(var i = 0; i < arr.length; i++) {
			html += '<option value="' + arr[i].id + '">' + arr[i].name + '</option>';
		}
		ele.append(html);
	}
}

