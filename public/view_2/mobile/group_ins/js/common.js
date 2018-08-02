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
	
	mui('.mui-scroll-wrapper').scroll({deceleration: 0.0005});
	
	
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
	
	$('a:not(.mui-control-item,.mui-action-back)').on('tap',function(){
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
var IdCardReg = /^[1-9]\d{5}(18|19|([23]\d))\d{2}((0[1-9])|(10|11|12))(([0-2][1-9])|10|20|30|31)\d{3}[0-9Xx]$/;
var emailReg = /^[A-Za-z0-9\u4e00-\u9fa5]+@[a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]+)+$/;
var passwordReg = /^[a-zA-Z0-9]{6,18}$/;
// 校验格式是否正确
function checkCorrect(ele,reg){
	var status = true;
	var _this = $(ele);
	if(!reg.test(_this.val())){
		var name = _this.parent().find('.name').text();	
		var tip = name + '格式错误';
		mui.toast(tip,{duration:13500});
		status = false;
	}
	return status;
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
				var value = items[0].id;
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
// 地区选择器
function areaPicker(ele,callback){
	var cityPicker = new mui.PopPicker({layer: 3});
	$(ele).on('tap', function() {
		$('input').blur();
		var _this = $(this);
		cityPicker.setData(changeCityData(areaData));
		cityPicker.show(function(items) {
			_this.find('input:text').val(items[0].text+"-"+items[1].text+"-"+items[2].text);
			$('#province').val(items[0].value);
			$('#city').val(items[1].value);
			$('#county').val(items[2].value);
			console.log($('#province').val())
			console.log($('#city').val());
			console.log($('#county').val());
			if(typeof callback === 'function'){
				callback();
			}
		});
	});
}
function changeCityData(areaData){
	var cityData = [];
	for(var i in areaData.province){
		var level1 = {};
		level1.value = i;
		level1.text = areaData.province[i];
		level1.children = [];
		for(var i in areaData.city){
			if(i === level1.value){
				var arr = areaData.city[i];
				for(var i=0;i<arr.length;i++){
					var level2 = {};
					level2.value = arr[i][1];
					level2.text = arr[i][0];
					level1.children.push(level2);
					level2.children = [];
					for(var i in areaData.county){
						if(i === level2.value){
							var level2arr = areaData.county[i];
							for(var i=0;i<level2arr.length;i++){
								var level3 = {};
								level3.value = level2arr[i][1];
								level3.text = level2arr[i][0];
								level2.children.push(level3);
							}
						}
					}
				}
			}
		}
		cityData.push(level1)
	}
	return cityData;
}