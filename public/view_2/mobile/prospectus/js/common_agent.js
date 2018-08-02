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
})(document, window);


if($('.mui-scroll-wrapper').size()){
	mui('.mui-scroll-wrapper').scroll({deceleration: 0.0005});
}

$('.mui-popover .icon-close,.mui-popover .icon-guanbi').on('tap',function(){
	mui('.mui-popover').popover('toggle');
});

function timer(wait,ele) {
	wait--;
	ele.html(wait + 's');
	ele.attr('disabled', 'disabled').addClass('disabled');
	var clear = setInterval(function() {
		if (wait > 0) {
			wait--;
			ele.html(wait + 's');
		}
		if (wait <= 0) {
			ele.html('发送验证码').removeAttr('disabled').removeClass('disabled')
			clearInterval(clear);
		}
	},
	1000);
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
function check(){
	var notCheckedClass = 'icon-duoxuan-weixuan',checkedClass = 'icon-duoxuanxuanzhong01';
	$('.icon-duoxuan-weixuan').click(function(){
		var type = $(this).parent().find('input[type=radio]').length>0 ? 0:1;
		var status = $(this).parent().find('input').prop('checked');
		if(type){
			if(status){
				$(this).addClass(notCheckedClass).removeClass(checkedClass);
			}else{
				$(this).addClass(checkedClass).removeClass(notCheckedClass);
			}
		}else{
			$(this).parents('.table-body').find('.icon-duoxuanxuanzhong01').addClass(notCheckedClass).removeClass(checkedClass);
			$(this).removeClass(notCheckedClass).addClass(checkedClass);
		}
	});
	$('.reelect').click(function(){
		$(this).parents('.section-container').find('input').prop('checked',false);
		$(this).parents('.section-container').find('.icon-duoxuanxuanzhong01').addClass(notCheckedClass).removeClass(checkedClass);
	});
}

//判断是否微信登陆
function isWeiXin() {
	var ua = window.navigator.userAgent.toLowerCase();
	if (ua.match(/MicroMessenger/i) == 'micromessenger') {
		return true;
	} else {
		return false;
	}
}
if(isWeiXin()){
	console.log(" 是来自微信内置浏览器");
	$('body').addClass('weixin');
	$('#header').hide();
	$('.wechatHide').hide();
	$('.mui-content').css({paddingTop:'0'});
	$('.mui-content .mui-scroll-wrapper').not('#list .mui-scroll-wrapper').css({top:'0'});
}else{
	console.log("不是来自微信内置浏览器");
}

// 正则验证
var nameReg = /^[\u4e00-\u9fa5\w-]{2,20}$/;
var telReg = /^1[34578]\d{9}$/;
var IdCardReg = /^[1-9]\d{5}[1-9]\d{3}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])\d{4}$/;
var emailReg = /^[A-Za-z0-9\u4e00-\u9fa5]+@[a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]+)+$/;
var passwordReg = /^[a-zA-Z0-9]{6,18}$/;
// 校验格式是否正确
function checkCorrect(ele,reg){
	var status = true;
	var _this = $(ele);
	if(!reg.test(_this.val())){
		var name = _this.parent().find('.name').text().replace(/^\*/,'');	
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

// 弹出框
var Popups = function(){
	this.open = function(ele,callback) {
		var _this = this;
		$(ele).show();
		$("html,body").css("overflow", "hidden");
		$(ele).find('.icon-close').click(function(){
			_this.close(ele);
			if(typeof callback === 'function'){
				callback();
			}
		});
	},
	this.close = function(ele) {
		$(ele).hide();
		$("html,body").css("overflow", "auto");
	}
}
var Popups = new Popups();

// 弹出提示框
var Mask = function() {
	this.btn = ["取消", "确定"],
	this.init = function() {
		var container = $(".mask-container");
		var width = container.outerWidth();
		var height = container.outerHeight();
		container.css({
			"marginLeft": "-" + width / 2 + "px",
			"marginTop": "-" + height / 2 + "px"
		});
	},
	this.open = function(html) {
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
Mask.prototype.loding = function(msg) {
	var _this = this;
	var html = '<div class="mask mask-loding"><div class="mask-bg"></div><div class="mask-container"><div class="loadEffect"><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span>\
				</div><p class="text">' + msg + '</p></div></div>';
	_this.open(html);
}

var Mask = new Mask();

// 时间选择器
function pickerDate(ele,callback){
	$(ele).on('tap', function() {
		$('input').blur();
		var _this = $(this);
		var picker = new mui.DtPicker({
			"type": "date",
			"beginYear": 1917
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

// 数量选择器
function selectNum(ele){
	var Ele = {
		iconjiahao: $(ele).find('.icon-add'),
		iconjianhao: $(ele).find('.icon-jianhao'),
		btnselectnum: $(ele).find('.zbtn-select-num')
	}
	Ele.iconjiahao.on('tap', function() {
		var num = parseInt(Ele.btnselectnum.text());
		num++;
		Ele.iconjianhao.css({'color':'#00a2ff'})
		Ele.btnselectnum.text(num);
		$(this).parent().find('input:hidden').val(num);
		console.log($(this).parent().find('input:hidden').val())
	});
	Ele.iconjianhao.on('tap', function() {
		var num = parseInt(Ele.btnselectnum.text());
		if(num == 1)return;
		if(num == 2){
			Ele.iconjianhao.css({'color':'#333'});
		};
		num--;
		Ele.btnselectnum.text(num);
		$(this).parent().find('input:hidden').val(num);
		console.log($(this).parent().find('input:hidden').val())
		
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

var pointIndex = 1;
function addPoints(ele,callback){
	$(ele).on('tap',function(){
		if(!$('.points li:last-child input').val()){
			return;
		}
		pointIndex++;
		$('.points .name').hide();
		$('.points input').addClass('added');
		$('.points .iconfont').show();
		console.log(pointIndex)
		var html = '<li>\
						<i class="iconfont icon-shanchu"></i>\
						<span class="name">卖点</span>\
						<input type="text" placeholder="请输入详细的产品卖点" name="selling[' + pointIndex + ']"/>\
						<i class="iconfont icon-xiugai"></i>\
					</li>';
		$('.points').append(html);
		$('.icon-shanchu').on('tap',function(){
			$(this).parent().remove();
			if(typeof callback === 'function'){
				callback();
			}
		});
		
		if(typeof callback === 'function'){
			callback();
		}
	});
}

// 上传照片
var upLoadImg = function(e,callback){
	var _this = $(e).parent();
	console.log(_this)
//	var max_size=2097152;
	var $c = _this.find('input[type=file]')[0];
	var file = $c.files[0],reader = new FileReader();
//	if(!/\/(png|jpg|jpeg|bmp|PNG|JPG|JPEG|BMP)$/.test(file.type)){
//		Mask.alert('图片支持jpg, jpeg, png或bmp格式',2);
//		return false;
//	}
//	if(file.size>max_size){
//		Mask.alert('单个文件大小必须小于等于2MB',2)
//		return false;
//	}
    reader.readAsDataURL(file);
    reader.onload = function(e){
    	_this.find('img').attr('src',e.target.result);
    	
    	
    	
    	var $targetEle = _this.find('input:hidden').eq(1);
    	
    	$targetEle.val(e.target.result);
    	console.log($targetEle.val())
		if(typeof callback === 'function'){
			callback();
		}
	};
};

// 我的产品——[产品列表/榜单列表] : 初始化
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

var oBtn = document.getElementById('btn');
var oW, oLeft;
var oSlider = document.getElementById('slider');
var oTrack = document.getElementById('track');
var oIcon = document.getElementById('icon');
var oSpinner = document.getElementById('spinner');
var flag = 1;

if(oBtn){
	var verify = false;
	oBtn.addEventListener('touchstart', function(e) {
		if (flag == 1) {
			var touches = e.touches[0];
			oW = touches.clientX - oBtn.offsetLeft;
		}
	}, false);

	oBtn.addEventListener("touchmove", function(e) {
		var maxLength = oSlider.clientWidth - oBtn.offsetWidth;
		if (flag == 1) {
			var touches = e.touches[0];
			oLeft = touches.clientX - oW;
			if (oLeft < 0) {
				oLeft = 0;
			} else if (oLeft > maxLength) {
				oLeft = maxLength;
			}
			oBtn.style.left = oLeft + "px";
			oTrack.style.width = oLeft + 'px';
		}
	}, false);

	oBtn.addEventListener("touchend", function() {
		var maxLength = oSlider.clientWidth - oBtn.offsetWidth;
		if (oLeft >= maxLength) {
			oIcon.style.display = 'none';
			oSpinner.style.display = 'block';
			flag = 0;
			$('.bg-green').text('完成验证');
			verify = true;
			check();
		} else {
			oBtn.style.left = 0;
			oTrack.style.width = 0;
		}
	}, false);
}


// 登录注册
if($('.login-popover').size()){
	
	$('.content-login input').bind('input propertychange', function() {
	    check();
	});
	
	var Ele = {
		telInput: $('.content-login .tel'),
		passwordInput: $('.content-login .psw'),
		btnLogin: $('.content-login .btn-login')
	}
	
	function check(){
		if(!Ele.telInput.val() || !Ele.passwordInput.val()){
	    	Ele.btnLogin.prop('disabled',true);
	    }else{
	    	Ele.btnLogin.prop('disabled',false);
	    }
	}
}