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

var contentHeight = $('.content-wrapper').height();

$('.menu-wrapper').height(contentHeight);

//  打开侧边栏弹出层
var html = '<div class="link-wrapper"><div class="bg"></div><div class="link-content"><iframe src="" width="100%" height="100%" frameborder="no" border="0" ></iframe></div></div>';
$(function(){
$('body').append(html);
$('.sidebar>li').click(function(){
	var src = $(this).data('src');
	$('.link-wrapper iframe').attr('src',src);
	$('.link-wrapper').show();
});
})


function changeTab(ele){
	$(ele).click(function(){
		$(this).addClass('active').siblings().removeClass('active');
	});
}

function check(){
	var notCheckedClass = 'icon-duoxuan-weixuan',checkedClass = 'icon-duoxuanxuanzhong01';
//	$('.icon-duoxuan-weixuan').click(function(){
//		var type = $(this).parent().find('input[type=radio]').length>0 ? 0:1;
//		var status = $(this).parent().find('input').prop('checked');
//		if(type){
//			if(status){
//				$(this).addClass(notCheckedClass).removeClass(checkedClass);
//			}else{
//				$(this).addClass(checkedClass).removeClass(notCheckedClass);
//			}
//		}else{
//			$(this).parents('.table-body').find('.icon-duoxuanxuanzhong01').addClass(notCheckedClass).removeClass(checkedClass);
//			$(this).removeClass(notCheckedClass).addClass(checkedClass);
//		}
//	});
	$('.table-body label').click(function(){
		var type = $(this).find('input[type=radio]').length>0 ? 0:1;
		var status = $(this).find('input').prop('checked');
		if(type){
			if(status){
				$(this).find('.iconfont').addClass(checkedClass).removeClass(notCheckedClass);
			}else{
				$(this).find('.iconfont').addClass(notCheckedClass).removeClass(checkedClass);
			}
		}else{
			$(this).parents('.table-body').find('.icon-duoxuanxuanzhong01').addClass(notCheckedClass).removeClass(checkedClass);
			$(this).find('.iconfont').removeClass(notCheckedClass).addClass(checkedClass);
		}
	});
	$('.reelect').click(function(){
		$(this).parents('.section-container').find('input').prop('checked',false);
		$(this).parents('.section-container').find('.icon-duoxuanxuanzhong01').addClass(notCheckedClass).removeClass(checkedClass);
	});
}



function selectData(ele,type){
	$(ele).each(function(){
		var $ele = $(this);
		var $btn = $ele.find('label');
		var $value = $ele.find('.select-value input');
		$btn.click(function(){
			var _this = $(this);
			if(type === 'single'){ // 单选
				$ele.find('.iconfont').addClass('icon-danxuan').removeClass('icon-danxuanxuanzhong');
				_this.find('.iconfont').addClass('icon-danxuanxuanzhong').removeClass('icon-danxuan');
				var index = _this.index();
				$value.eq(index).prop('checked',true);
				
			}
		});
	});
}





// 正则验证
var nameReg = /^[\u4e00-\u9fa5\w-]{2,20}$/;
var telReg = /^1[34578]\d{9}$/;
var IdCardReg = /^\d{6}(18|19|20)?\d{2}(0[1-9]|1[12])(0[1-9]|[12]\d|3[01])\d{3}(\d|X|x)$/;
var emailReg = /^[A-Za-z0-9\u4e00-\u9fa5]+@[a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]+)+$/;
var passwordReg = /^[a-zA-Z0-9]{6,18}$/;

function checkCorrect(ele,reg){
	var status = true;
	var _this = $(ele);
	if(!reg.test(_this.val())){
//		var name = _this.parent().find('.name').text().replace(/^\*/,'');	
		var name = '';
		var tip = name + '格式错误，请重新填写';
		_this.parent().find('.error').text(tip);
		status = false;
	}
	return status;
}

function checkEmpty(ele){
	var status = true;
	for(var i=0,l=arguments.length;i<l;i++){
		var _this = $(arguments[i]);
		if(!_this.val()){
			var name = _this.parents('li').find('.form-name').text().replace(/^\*/,'');	
			var tip = name + '未填写';
			_this.parents('li').find('.error').text(tip);
			status = false;
		}
	}
	return status;
}
function checkUpload(ele){
	if(!ele.val()){
		ele.parent().find('.error').html('请上传');
		return false;
	}else{
		return true;
	}
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


var TabControl = function(ele){
	this.hea_item = $(ele).find('.select-header .select-item');
	this.con_item = $(ele).find('.select-content .select-item');
	this.init();
}
TabControl.prototype.init = function(){
	var _this = this;
	_this.hea_item.click(function(){
		var index = $(this).addClass('active').siblings().removeClass('active').end().index();
		_this.con_item.eq(index).show().siblings().hide();
	});
}


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



// 实名认证上传图片
var upload = function(e,callback){
	var _this = $(e);
	var max_size=2097152;
	var $c = _this.parent().find('input[type=file]')[0];
	var file = $c.files[0],reader = new FileReader();
	if(!/\/(png|jpg|jpeg|bmp|PNG|JPG|JPEG|BMP)$/.test(file.type)){
		Mask.alert('图片支持jpg, jpeg, png或bmp格式',2);
		return false;
	}
	if(file.size>max_size){
		Mask.alert('单个文件大小必须小于等于2MB',2)
		return false;
	}
	
    reader.readAsDataURL(file);
    reader.onload = function(e){
    	var html = '<img src="'+ e.target.result +'" />';
    	_this.parent().find('.upload-wrapper').html(html);
    	_this.parent().find('input').eq(1).val(e.target.result);
    	
    	if(callback && typeof(callback) == "function"){
    		callback();
    	}
	};
};


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
Mask.prototype.loding = function(msg) {
	var _this = this;
	var html = '<div class="mask mask-loding"><div class="mask-bg"></div><div class="mask-container"><div class="loadEffect"><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span>\
				</div><p class="text">' + msg + '</p></div></div>';
	_this.open(html);
}

var Mask = new Mask();




// 区域滚动
$.zUI = $.zUI || {};
$.zUI.emptyFn = function(){};
$.zUI.asWidget = [];
$.zUI.addWidget = function(sName,oSefDef){
	$.zUI.asWidget.push(sName);
	var w = $.zUI[sName] = $.zUI[sName] || {};
	var sPrefix = "zUI" + sName
	w.sFlagName = sPrefix;
	w.sEventName = sPrefix + "Event";
	w.sOptsName = sPrefix + "Opts";
	w.__creator = $.zUI.emptyFn;
	w.__destroyer = $.zUI.emptyFn;
	$.extend(w,oSefDef);
	w.fn = function(ele,opts){
		var jqEle = $(ele);
		jqEle.data(w.sOptsName,$.extend({},w.defaults,opts));
		if(jqEle.data(w.sFlagName)){
			return;
		}
		jqEle.data(w.sFlagName,true);
		w.__creator(ele);
		jqEle.on(jqEle.data(w.sEventName));
	};
	w.unfn = function(ele){
		w.__destroyer(ele);
		var jqEle = $(ele);
		if(jqEle.data(w.sFlagName)){
			jqEle.off(jqEle.data(w.sEventName));
			jqEle.data(w.sFlagName,false);
		}
	}
}
$.zUI.addWidget("draggable",{
	defaults:{
		bOffsetParentBoundary:false,
		oBoundary:null,
		fnComputePosition:null
	},
	__creator:function(ele){
		var jqEle = $(ele);
		jqEle.data($.zUI.draggable.sEventName,{
		mousedown:function(ev){
		var jqThis = $(this);
		var opts = jqThis.data($.zUI.draggable.sOptsName);
		
		jqThis.trigger("draggable.start");
		var iOffsetX = ev.pageX - this.offsetLeft;
		var iOffsetY = ev.pageY - this.offsetTop;
		
		function fnMouseMove (ev) {
			var oPos = {};
			if(opts.fnComputePosition){
				oPos = opts.fnComputePosition(ev,iOffsetX,iOffsetY);
			}else{
				oPos.iLeft = ev.pageX - iOffsetX;
				oPos.iTop = ev.pageY - iOffsetY;
			}
			
			var oBoundary = opts.oBoundary;
			if(opts.bOffsetParentBoundary){//如果以offsetParent作为边界
				var eParent = jqThis.offsetParent()[0];
				oBoundary = {};
				oBoundary.iMinLeft = 0;
				oBoundary.iMinTop = 0;
				oBoundary.iMaxLeft = eParent.clientWidth - jqThis.outerWidth();
				oBoundary.iMaxTop = eParent.clientHeight - jqThis.outerHeight();
			}
		
			if(oBoundary){//如果存在oBoundary，将oBoundary作为边界
				oPos.iLeft = oPos.iLeft < oBoundary.iMinLeft ? oBoundary.iMinLeft : oPos.iLeft;
				oPos.iLeft = oPos.iLeft > oBoundary.iMaxLeft ? oBoundary.iMaxLeft : oPos.iLeft;
				oPos.iTop = oPos.iTop < oBoundary.iMinTop ? oBoundary.iMinTop : oPos.iTop;
				oPos.iTop = oPos.iTop > oBoundary.iMaxTop ? oBoundary.iMaxTop : oPos.iTop;
			}
			
			jqThis.css({left:oPos.iLeft,top:oPos.iTop});
			ev.preventDefault();
			jqThis.trigger("draggable.move");
		}
		
		var oEvent = {
			mousemove:fnMouseMove,
			mouseup:function(){
				$(document).off(oEvent);
				jqThis.trigger("draggable.stop");
			}
		};
		
		$(document).on(oEvent);
	}});
	}
});
$.zUI.addWidget("panel",{
	defaults : {
			iWheelStep:16,
			sBoxClassName:"zUIpanelScrollBox",
			sBarClassName:"zUIpanelScrollBar"
	},
	__creator:function(ele){
		var jqThis = $(ele);
		if(jqThis.css("position") === "static"){
			jqThis.css("position","relative");
		}
		jqThis.css("overflow","hidden");
		
		var jqChild = jqThis.children(":first");
		if(jqChild.length){
			jqChild.css({top:0,position:"absolute"});
		}else{
			return;
		}
		
		var opts = jqThis.data($.zUI.panel.sOptsName);
		//创建滚动框
		var jqScrollBox = $("<div style='position:absolute;line-height:0;'></div>");
		jqScrollBox.addClass(opts.sBoxClassName);
		//创建滚动条
		var jqScrollBar= $("<div style='position:absolute;line-height:0;'></div>");
		jqScrollBar.addClass(opts.sBarClassName);
		jqScrollBox.appendTo(jqThis);
		jqScrollBar.appendTo(jqThis);
		
		
		
		opts.iTop = parseInt(jqScrollBox.css("top"));
		opts.iWidth = jqScrollBar.width();
		opts.iRight = parseInt(jqScrollBox.css("right"));
		
		//添加拖拽触发自定义函数
		jqScrollBar.on("draggable.move",function(){
			var opts = jqThis.data($.zUI.panel.sOptsName);
			fnScrollContent(jqScrollBox,jqScrollBar,jqThis,jqChild,opts.iTop,0);
		});
		
	    //事件对象
		var oEvent ={
			mouseenter:function(){
				fnFreshScroll();
				jqScrollBox.css("display","block");
				jqScrollBar.css("display","block");
			},
			mouseleave:function(){
				jqScrollBox.css("display","block");
				jqScrollBar.css("display","block");
			}
		};
		
		var sMouseWheel = "mousewheel";
		if(!("onmousewheel" in document)){
			sMouseWheel = "DOMMouseScroll";
		}
		oEvent[sMouseWheel] = function(ev){
			var opts = jqThis.data($.zUI.panel.sOptsName);
			var iWheelDelta = 1;
			ev.preventDefault();
			ev = ev.originalEvent;
			if(ev.wheelDelta){
					iWheelDelta = ev.wheelDelta/120;
			}else{
					iWheelDelta = -ev.detail/3;
			}
			var iMinTop = jqThis.innerHeight() - jqChild.outerHeight();
			//外面比里面高，不需要响应滚动
			if(iMinTop>0){
				jqChild.css("top",0);
				return;
			}
			var iTop = parseInt(jqChild.css("top"));
			var iTop = iTop + opts.iWheelStep*iWheelDelta;
			iTop = iTop > 0 ? 0 : iTop;
			iTop = iTop < iMinTop ? iMinTop : iTop;
			jqChild.css("top",iTop);
			fnScrollContent(jqThis,jqChild,jqScrollBox,jqScrollBar,0,opts.iTop);
		}
		//记录添加事件
		jqThis.data($.zUI.panel.sEventName,oEvent);
		//跟随滚动函数
		function fnScrollContent(jqWrapper,jqContent,jqFollowWrapper,jqFlollowContent,iOffset1,iOffset2){
			var opts = jqThis.data($.zUI.panel.sOptsName);
			var rate = (parseInt(jqContent.css("top"))-iOffset1)/(jqContent.outerHeight()-jqWrapper.innerHeight())//卷起的比率
			var iTop = (jqFlollowContent.outerHeight()-jqFollowWrapper.innerHeight())*rate + iOffset2;
			jqFlollowContent.css("top",iTop);
		}
	
		//刷新滚动条
		function fnFreshScroll(){

			var opts = jqThis.data($.zUI.panel.sOptsName);
			var iScrollBoxHeight = jqThis.innerHeight()-2*opts.iTop;
			var iRate = jqThis.innerHeight()/jqChild.outerHeight();
			var iScrollBarHeight = iScrollBarHeight = Math.round(iRate*iScrollBoxHeight);
			//如果比率大于等于1，不需要滚动条,自然也不需要添加拖拽事件
			if(iRate >= 1){
				jqScrollBox.css("height",0);
				jqScrollBar.css("height",0);
				return;
			}
			jqScrollBox.css("height",iScrollBoxHeight);
			jqScrollBar.css("height",iScrollBarHeight);
			//计算拖拽边界，添加拖拽事件
			var oBoundary = {iMinTop:opts.iTop};
			oBoundary.iMaxTop = iScrollBoxHeight - Math.round(iRate*iScrollBoxHeight)+opts.iTop;
			oBoundary.iMinLeft = jqThis.innerWidth() - opts.iWidth - opts.iRight;
			oBoundary.iMaxLeft = oBoundary.iMinLeft;
			fnScrollContent(jqThis,jqChild,jqScrollBox,jqScrollBar,0,opts.iTop);
			jqScrollBar.draggable({oBoundary:oBoundary});
		}
	},
		__destroyer:function(ele){
			var jqEle = $(ele);
			if(jqEle.data($.zUI.panel.sFlagName)){
				var opts = jqEle.data($.zUI.panel.sOptsName);
				jqEle.children("."+opts.sBoxClassName).remove();
				jqEle.children("."+opts.sBarClassName).remove();
			}
	}
});

$.each($.zUI.asWidget,function(i,widget){
	unWidget = "un"+widget;
	var w = {};
	w[widget] = function(args){
			this.each(function(){
			$.zUI[widget].fn(this,args);
		});
		return this;
	};
	w[unWidget] = function(){
			this.each(function(){
			$.zUI[widget].unfn(this);
		});
		return this;
	}
	$.fn.extend(w);
});

function scoreFun(object, opts) {
	var defaults = {
		fen_d: 16,
		ScoreGrade: 10,
		types: ["很不满意", "差得太离谱，与卖家描述的严重不符，非常不满", "不满意", "部分有破损，与卖家描述的不符，不满意", "一般", "质量一般", "没有卖家描述的那么好", "满意", "质量不错，与卖家描述的基本一致，还是挺满意的", "非常满意", "质量非常好，与卖家描述的完全一致，非常满意"],
		nameScore: "fenshu",
		parent: "star_score",
		attitude: "attitude",
	};
	options = $.extend({}, defaults, opts);
	var countScore = object.find("." + options.nameScore);
	var inputValue = object.find("input:hidden");
	var startParent = object.find("." + options.parent);
	var atti = object.find("." + options.attitude);
	var now_cli;
	var fen_cli;
	var atu;
	var fen_d = options.fen_d;
	var len = options.ScoreGrade;
	startParent.width(fen_d * len);
	var preA = (5 / len);
	for(var i = 0; i < len; i++) {
		var newSpan = $("<a href='javascript:void(0)'></a>");
		newSpan.css({
			"left": 0,
			"width": fen_d * (i + 1),
			"z-index": len - i
		});
		newSpan.appendTo(startParent)
	}
	startParent.find("a").each(function(index, element) {
		$(this).click(function() {
			now_cli = index;
			show(index, $(this));
			
			inputValue.val(countScore.text());
			console.log(inputValue.val())
			
		});
		$(this).mouseenter(function() {
			show(index, $(this))
		});
		$(this).mouseleave(function() {
			if(now_cli >= 0) {
				var scor = preA * (parseInt(now_cli) + 1);
				startParent.find("a").removeClass("clibg");
				startParent.find("a").eq(now_cli).addClass("clibg");
				var ww = fen_d * (parseInt(now_cli) + 1);
				startParent.find("a").eq(now_cli).css({
					"width": ww,
					"left": "0"
				});
				if(countScore) {
					countScore.text(scor);
				}
			} else {
				startParent.find("a").removeClass("clibg");
				if(countScore) {
					countScore.text("0");
				}
			}
		})
	});

	function show(num, obj) {
		var n = parseInt(num) + 1;
		var lefta = num * fen_d;
		var ww = fen_d * n;
		var scor = preA * n;
		atu = options.types[parseInt(num)];
		object.find("a").removeClass("clibg");
		obj.addClass("clibg");
		obj.css({
			"width": ww,
			"left": "0"
		});
		countScore.text(scor);
	}
};
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