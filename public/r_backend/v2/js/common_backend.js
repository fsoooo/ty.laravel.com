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

$('.modal').on('show.bs.modal', function (e) {
	if(document.body.clientWidth < window.innerWidth){
		$('.main-wrapper').css({"padding-right":'37px'});
	}
})
$('.modal').on('hidden.bs.modal', function (e) {
	if(document.body.clientWidth < window.innerWidth){
		$('.main-wrapper').css({"padding-right":'20px'});
	}
});

$(function(){
	function initMenuHeight(){
		var mainHeight = $('.main-wrapper')[0].offsetHeight;
		var menuHeight = $('.menu-wrapper')[0].offsetHeight;
		if(mainHeight>menuHeight){
			$('.menu-wrapper').height(mainHeight-60)
		}
	}
	initMenuHeight();
	
	var bars = '.jspHorizontalBar, .jspVerticalBar';
	if($('.scroll-pane').length){
		function myscroll(){
			$('.scroll-pane').bind('jsp-initialised', function (event, isScrollable) {
				$(this).find(bars).hide();
			}).jScrollPane().hover(
				function () {
					$(this).find(bars).stop().fadeTo('fast', 1);
				}
			);
		}
		myscroll();
		$(window).resize(function () {
		   myscroll();
		});
	}
});



function changeTab(ele){
	$(ele).click(function(){
		$(this).parent().parent().find(ele).removeClass('active');
		$(this).addClass('active');
	});
}

function GetQueryString(name){
    var reg = new RegExp("(^|&)"+ name +"=([^&]*)(&|$)");
    var r = window.location.search.substr(1).match(reg);
    if(r!=null)return  unescape(r[2]); return null;
}
function setPage(){
	var page = parseInt(GetQueryString("page"));
	
	$('.pagination li').eq(page).addClass('active').siblings().removeClass('active');
}

var telReg = /^1[34578]\d{9}$/;
var emailReg = /^[A-Za-z0-9\u4e00-\u9fa5]+@[a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]+)+$/;

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


// 弹出提示框
if($('.tip-wrapper').is(':visible')){
	$('.modal-tip,.modal-tips').modal('show');
}

// 提醒实名倒计时
function changeTime(total){
	var s = (total%60) < 10 ? ('0' + total%60) : total%60;
	var h = total/3600 < 10 ? ('0' + parseInt(total/3600)) : parseInt(total/3600);
	var m = (total-h*3600)/60 < 10 ? ('0' + parseInt((total-h*3600)/60)) : parseInt((total-h*3600)/60);
	return h + ':' + m + ':' + s;
}	

function timeCounter(ele,total,endtext){
	var timer = null;
 	total--;
 	ele.html(changeTime(total));
 	ele.prop('disabled', true);
 	timer = setInterval(function(){
 		if(total > 0){
 			total--;
 			ele.html(changeTime(total));
	    }
 		if(total <= 0){
 			ele.html(endtext).prop('disabled',false);
	    	clearInterval(timer);
	    }
 	},1000);
}




// 多选表格
function CheckTable(ele){
	this.parentEle = $(ele),
	this.btn_select = this.parentEle.find('.iconfont'),
	this.btn_select_all = this.parentEle.find('#selectAll'),
	this.init();
}
CheckTable.prototype = {
	init: function(){
		var _this = this;
		this.btn_select.click(function(){
			var $this = $(this);
			$this.hasClass('icon-weixuan') ? $this.addClass('icon-xuanze').removeClass('icon-weixuan') : $this.addClass('icon-weixuan').removeClass('icon-xuanze')
		
			if($this.hasClass('icon-weixuan')){
				_this.btn_select_all.addClass('icon-weixuan').removeClass('icon-xuanze')
			}
		});
		this.btn_select_all.click(function(){
			if($(this).hasClass('icon-weixuan')){
				$('.ui-table-tr .icon-xuanze').trigger('click');
			}else{
				$('.ui-table-tr .icon-weixuan').trigger('click');
			}
		});
	}
}

function checkTable(){
	$('.ui-table .iconfont').click(function(){
		var _this = $(this);
		_this.hasClass('icon-weixuan') ? _this.addClass('icon-xuanze').removeClass('icon-weixuan') : _this.addClass('icon-weixuan').removeClass('icon-xuanze')
	
		if(_this.hasClass('icon-weixuan')){
			$('#selectAll').addClass('icon-weixuan').removeClass('icon-xuanze')
		}
	});
	
	$('#selectAll').click(function(){
		var _this = $(this);
		if($(this).hasClass('icon-weixuan')){
			$('.ui-table-tr .icon-xuanze').trigger('click');
		}else{
			$('.ui-table-tr .icon-weixuan').trigger('click');
			
		}
	});
}


var Util = {
	changeSkin: function(){
		var skin = localStorage.getItem('skin');
		if(skin !== 'skin0'){
			$('html').removeClass().addClass('skin-default '+skin);
		}else{
			$('html').removeClass().addClass('skin-main '+skin);
		}
	}
}
Util.changeSkin();


// 上传照片
var upLoadImg = function(e){
	console.log(e)
	var _this = $(e).parent();
	var $c = _this.find('input[type=file]')[0];
	var file = $c.files[0],reader = new FileReader();
    reader.readAsDataURL(file);
    reader.onload = function(e){
    	_this.find('img').attr('src',e.target.result);
    	var $targetEle = _this.find('input:hidden').eq(1);
    	$targetEle.val(e.target.result);
    	console.log($targetEle.val())
	};
};


// 个性化编辑上传照片
function img(ele,size,callback){
	var _this = $(ele).parent();
	var $c = _this.find('input[type=file]')[0];
	var file = $c.files[0],reader = new FileReader();
	var max_size = 1;
	if(!/\/(png|jpeg|PNG|JPEG|jpg|JPG)$/.test(file.type)){
		Mask.alert('图片支持jpg,png格式',2);
		return false;
	}
	if(file.size>size){
		var msg = size > 1024*1024 ? size/(1024*1024) : size/1024;
		if(size > 1024*1024){
			Mask.alert('单个文件大小必须小于等于'+ msg +'MB',2);
		}else{
			Mask.alert('单个文件大小必须小于等于'+ msg +'kb',2);
		}
		return false;
	}
    reader.readAsDataURL(file);
    reader.onload = function(e){
    	var data = e.target.result;
    	Mock.mock('http://g.cn', '../../img/temp_logo.png');
		$.ajax({
			url: "http://g.cn",
//			data: {
//				"url": data
//			},
			success: function(data) {
				_this.find('.img').css({'background-image':'url('+ data +')','background-size':'contain'});
		    	var $targetEle = _this.find('input:hidden').eq(1);
		    	$targetEle.val(data);
		    	console.log($targetEle.val());
				if(callback){
					callback(data,_this);
				}
			},
			error: function() {
				Mask.alert("网络请求错误!");
			}
		});
	};
}


			
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


var Mask = function() {
	this.btn = ["取消", "确定"],
	this.open = function(html){
		$("body").append(html);
		$("html,body").css("overflow", "hidden");
		if(document.body.clientWidth < window.innerWidth){
			$('.main-wrapper').css({"padding-right":'37px'});
		}
	},
	this.close = function() {
		$(".mask").off().remove();
		$("html,body").css("overflow", "initial");
		if(document.body.clientWidth < window.innerWidth){
			$('.main-wrapper').css({"padding-right":'20px'});
		}
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
var Mask = new Mask();

function Check(options){
	this.defaults = {
		ele : '',
		notCheckedClass: 'icon-weixuan',
		checkedClass: 'icon-xuanze',
		type: 0,
		callback : null
	};
	this.options = $.extend({}, this.defaults, options);
	this.con = $(this.options.ele);
	this.inputs = this.con.find('input');
	
	if(this.options.type == 0){ // 单选
		this.single();
	}
	if(this.options.type == 1){ // 多选
		this.multiple();
	}
}
Check.prototype = {
	single: function(){
		var _this = this;
		var n = _this.options.notCheckedClass;
		var c = _this.options.checkedClass;
		var f = _this.options.callback;
		this.inputs.click(function(){
			var others = $(this).parents('li').siblings();
			others.find('input').prop('checked',false);
			others.find('.iconfont').removeClass(c).addClass(n);
			
			var index = $(this).parents('li').index();
			
			var status = $(this).prop('checked');
			var icon = $(this).siblings('.iconfont');
			if(status){
				icon.removeClass(n).addClass(c);
			}else{
				icon.removeClass(c).addClass(n);
			}
			var obj={
				index: index
			}
			if(f){f(obj);}
		});
	},
	multiple: function(){
		var _this = this;
		this.labels = this.con.find('label');
		var a = _this.con.find('.all'); // 全选
		
		var n = _this.options.notCheckedClass;
		var c = _this.options.checkedClass;
		var f = _this.options.callback;
		_this.inputs.click(function(){
			var $this = $(this).siblings('.iconfont');
			$this.hasClass(n) ? $this.addClass(c).removeClass(n) : $this.addClass(n).removeClass(c)
			_this.inputs.each(function(index){
				if($(this).siblings('.iconfont').hasClass(n)){
					a.find('.iconfont').addClass(n).removeClass(c);
					return false;
				}
				if(index == _this.inputs.length-1){
					a.find('.iconfont').addClass(c).removeClass(n)
				}
			})
			if(f)f();
		});
		
		a.click(function(){
			var $this = $(this).find('.iconfont');
			if($this.hasClass(n)){
				$this.addClass(c).removeClass(n);
			}else{
				$this.addClass(n).removeClass(c);
				_this.inputs.trigger('click');
				return false;
			}
			_this.inputs.each(function(index){
				if($(this).siblings('.iconfont').hasClass(n)){
					$(this).trigger('click');
				}
			});
		})
		
	}
}

// 饼图
function pieChart(ele,datas){
	var percentA,percentB;
	var option = {
		color: ['#09a8fa', '#ffae00', '#ff6f3c', '#acff7e','#5d74eb','#c47bdc','#7ef7ff','#fffa9d','#ea62ef','#59f77b'],
		tooltip: {
			trigger: 'item',
			formatter: "{b}: {c} ({d}%)"
		},
		legend: {
			x: 'left',
			bottom: '0px',
			left: '20px',
			data: [{
				name: '人身险',
				icon: 'pin',
				textStyle: {
					fontSize: 10,
					color: '#09a8fa'
				},
			}, {
				name: '财产险',
				icon: 'pin',
				textStyle: {
					fontSize: 10,
					color: '#ffae00'
				},
			}]
		},
		
		series: [{
				name: '组别1',
				type: 'pie',
				clockwise: false,
				radius: [0, '40%'],
				label: {
					normal: {
						show: false,
						formatter: function(params) {
							params.dataIndex == 0 ? percentA = params.percent : percentB = params.percent;
						}
					}
				},
				data: datas.level1
			},
			{
				name: '组别2',
				type: 'pie',
				clockwise: false,
				radius: ['60%', '80%'],
				label: {
					normal: {
						show: false
					}
				},
				data: datas.level2
			}
		]
	};
	var myChart = echarts.init(document.getElementById(ele));
	myChart.setOption(option);
	myChart.setOption(option);
	$(window).resize(function() {
		myChart.resize();
	});
	if(!percentA){percentA=0}
	if(!percentB){percentB=0}
	$('#'+ele).parent().find('.percent-left').text(percentA+'%');
	$('#'+ele).parent().find('.percent-right').text(percentB+'%');
}

// 排行榜
function transverseBarChart(ele,datas) {
	// 数值
	var seriesData = [];
	var color = ['#ffae00','#ff6f3c','#ff3c3c'];
	for(var i=0,l=datas.xAxisData.length;i<l;i++){
		var dataobj = {};
		dataobj.value = datas.xAxisData[i];
		dataobj.itemStyle= {};
		dataobj.itemStyle.normal = {};
		dataobj.itemStyle.normal.color = color[i];
		seriesData.push(dataobj);
	}
	
	var option = {
		color: ['#00a2ff'],
		legend: {
			x: 'left',
			y: 'bottom',
			data: [{
				name: '活动率top3渠道',
				icon: 'pin',
				textStyle: {
					color: '#00a2ff'
				}
			}],
			bottom: '0px',
			left: '20px',
		},
		grid: {
			top: '40px',
			left: '20px',
			bottom: '30%',
		},
		xAxis: {
			type: 'value',
			max: 300,
			axisLabel: {　
				textStyle: {　　
					color: '#21294c'　　
				}
			},
			splitLine: {
				show: false,
			},
		},
		yAxis: {
			type: 'category',
			data: datas.yAxisData,
			axisLabel: {　
				textStyle: {　　
					color: '#21294c'　　
				}
			},
		},
		series: [{
			name: '活动率top3渠道',
			type: 'bar',
			barWidth: 20,
			label: {
				normal: {
					show: true,
					position: ['130%', '0%'],
					color: '#d3d5dc',
					formatter: function(params) {
						var top;
						params.dataIndex === 0 ? top = 3 : params.dataIndex === 2 ? top = 1 : top = 2;
						return 'top' + top + '  活动率' + params.value + '%        ' + params.name
					}
				}
			},
			data: seriesData
		}]
	};
	
	var myChart = echarts.init(document.getElementById(ele));
	myChart.setOption(option);
	$(window).resize(function() {
		myChart.resize();
	});
}

// 折线柱状图
function lineColumnChart(ele,datas) {
	// 图例
	var legendData = [];
	for(var i=0,l=datas.legendName.length;i<l;i++){
		var dataobj = {};
		dataobj.name = datas.legendName[i];
		dataobj.icon = 'pin';
		dataobj.textStyle= {};
		dataobj.textStyle.color = '#ededed';
		legendData.push(dataobj);
	}
	
	var option = {
		color: ['#00a2ff', '#11d958', '#df40e1'],
		tooltip: {
			trigger: 'axis',
			axisPointer: {
				type: 'shadow'
			}
		},
		legend: {
			data: legendData,
			bottom: '0px',
			left: '20px',
			textStyle: {
				fontSize: 10
			}
		},
		grid: {
			top: '16%',
			left: '4%',
			right: '2%',
			bottom: '20%',
			containLabel: true
		},
		xAxis: [{
			type: 'category',
			axisLabel: {　
				textStyle: {　　
					color: '#83879d'　　
				}
			},
			splitLine: {
				show: true,
				lineStyle: {
					color: '#2f365a',
				}
			},
			data: datas.xAxisData
		}],
		yAxis: [{
			type: 'value',
			name: datas.yAxisName[0],
			nameTextStyle: {
				color: '#d8d7d9'
			},
			axisLabel: {　
				textStyle: {　　
					color: '#83879d'　　
				}
			},
			splitLine: {
				lineStyle: {
					color: '#2f365a',
				}
			},
		},
        {
            type: 'value',
            name: datas.yAxisName[1],
            nameTextStyle: {
				color: '#d8d7d9'
			},
            axisLabel: {
				textStyle: {　　
					color: '#83879d'　　
				},
            },
            splitLine: {
            	show: false
			},
        }],
		series: datas.series
	};
	var myChart = echarts.init(document.getElementById(ele));
	myChart.setOption(option);
	$(window).resize(function() {
		myChart.resize();
	});
}

// 地图
function mapChart(ele,datas){
	var myChart;
	var domMain = document.getElementById(ele);
	var needRefresh = false;
	var curTheme;
	
	function requireCallback(ec, defaultTheme) {
		curTheme = defaultTheme;
		echarts = ec;
		refresh();
		window.onresize = myChart.resize;
	}
	
	function refresh(isBtnRefresh) {
		if(isBtnRefresh) {
			needRefresh = true;
			return;
		}
		needRefresh = false;
		if(myChart && myChart.dispose) {
			myChart.dispose();
		}
		myChart = echarts.init(domMain, curTheme);
		window.onresize = myChart.resize;
		myChart.setOption(option, true)
	}
	var echarts;
	require.config({
		paths: {
			echarts: './js'
		}
	});
	require(
		[
			'echarts',
			'echarts/chart/map'
		],
		requireCallback
	);
	var option = {
		tooltip: {
			trigger: 'item'
		},
		legend: {
			x:'left',
			y: 'bottom',
			data: [{
				name: '地区客户量',
				textStyle: {
					fontSize: 10,
					color: '#09a8fa'
				},
			}],
			bottom: '0px',
			left: '20px',
		},
		dataRange: {
			show: false,
			x: 'left',
			y: 'bottom',
			splitList: [{
					start: 1500
				},
				{
					start: 900,
					end: 1500
				},
				{
					start: 310,
					end: 1000
				},
				{
					start: 200,
					end: 300
				},
				{
					start: 0,
					end: 200,
				}
			],
			color: ['#f08437', '#41b25d', '#8cc66d', '#b3d8a3', '#dddddc']
		},
		series: [{
			name: '地区客户量',
			type: 'map',
			mapType: 'china',
			itemStyle: {
				show: false,
				normal: {
					label: {
						show: false,
					}
				}
			},
			data: datas
		}]
	}
}


var TabControl = function(ele,callback){
	this.ele = $(ele);
	this.callback = callback || '';
	this.hea_item = $(ele).find('.select-header .select-item');
	this.con_item = $(ele).find('.select-content .select-item');
	this.init();
}
TabControl.prototype.init = function(){
	var _this = this;
	_this.hea_item.click(function(){
		var index = $(this).addClass('active').siblings().removeClass('active').end().index();
		_this.con_item.eq(index).show().siblings().hide();
		
		var obj = {
			ele: _this.ele,
			index: index
		}
		_this.callback && _this.callback(obj);
	});
}

function upload(options){
	this.defaults = {
		type: 'img',
		num: 10,
		maxSize: 5*1024*1024
	};
	this.options = $.extend({}, this.defaults, options);
	this.container = $(this.options.ele);
	if(this.options.type === 'img'){this.img();}
}
upload.prototype = {
	img: function(){
		var _this = this,
			photos_add = _this.container.find('.img-upload'),
			btn_upload = _this.container.find('.btn-upload');
		btn_upload.click(function(){
			$(this).next().eq(0).click();
		});
		btn_upload.next().on('change',function(){
	    	_this.upLoadImg(this);
	    });
	    $('body').on('click',function(e){
	    	var target = $(e.target);
	    	if(target.is('.btn-delete')){
	    		target.parent().remove();
	    		_this.canAdd();
	    	}
	    	if(target.is('.img')){
	    		var url = target.css("backgroundImage");
				url = url.split("(")[1].split(")")[0];
				Util.preview(url.slice(1,-1));
	    	}
	    });
	},
	upLoadImg: function(ele){
		var _this = this;
		var maxSize = _this.options.maxSize;
		var $c = $(ele).parent().find('input[type=file]')[0];
		var file = $c.files[0],reader = new FileReader();
		if(file.size>maxSize){
			var msg = maxSize > 1024*1024 ? maxSize/(1024*1024) : maxSize/1024;
			if(maxSize > 1024*1024){
				Mask.alert('单个文件大小必须小于等于'+ msg +'MB',2);
			}else{
				Mask.alert('单个文件大小必须小于等于'+ msg +'kb',2);
			}
			return false;
		}
	    reader.readAsDataURL(file);
	    reader.onload = function(e){
	    	var data = e.target.result;
//	    	Mock.mock('http://g.cn', '../../img/temp_logo.png');
			$.ajax({
				type: 'post',
				url: "/backend/ajax/uploadImage",
				data: {
					"url": data,
                    "path": _this.options.path,
				},
				success: function(data) {
					var html =  "<li class='col-xs-3 img' style='background-image: url("+ data +");'>\
									<div class='btn-delete'>删除</div>\
									<input hidden type='text' value="+ data +" />\
								</li>";
	    			$(html).insertBefore('.img-upload');
	    			_this.canAdd();
				},
				error: function() {
					Mask.alert("网络请求错误!");
				}
			});
		};
	},
	canAdd: function(){
		var _this = this;
			num = _this.container.find('.img').length,
			photos_add = _this.container.find('.img-upload');
		num>=_this.options.num ? photos_add.hide() : photos_add.show();
	}
}


// 验证规则
var verify = {
	isNum: function(ele){
		if(!ele.val()){return;}
		if(!/^[\d|.]*$/.test(ele.val())){
			Mask.alert('请输入数字且不得为负数',2);
			ele.val('').focus();
			return false;
		}
		return true;
	},
	rangeNum: function(ele){
		var data = ele.data('range').split(',');
		var min = parseFloat(data[0]);
		var num = parseFloat(ele.val());
		var max = parseFloat(data[1]);
		if(!verify.isNum(ele)){
			return false;
		}
		if(min>=num){
			Mask.alert('请输入大于'+ min +'的数字',2);
			ele.val('').focus();
			return false;
		}
		if(num>max){
			Mask.alert('请输入小于'+ max +'的数字',2);
			ele.val('').focus();
			return false;
		}
		return true;
	},
	isUrl: function(ele){
		if(!ele.val()){return;}
		if(!/[a-zA-Z0-9][-a-zA-Z0-9]{0,62}(\.[a-zA-Z0-9][-a-zA-Z0-9]{0,62})+\.?/.test(ele.val())){
			Mask.alert('请输入正确格式的网址',2);
			ele.val('').focus();
			return false;
		}
		return true;
	},
	isPhone: function(ele){
		if(!ele.val()){return;}
		if(!/^1[34578]\d{9}$/.test(ele.val())){
			Mask.alert('请输入正确格式的手机号',2);
			ele.val('').focus();
			return false;
		}
		return true;
	}
}

var Util = (function(){
	var funObj = {
		DatePickerRange: function(options){
			var _this = this;
			this.defaults = {};
			this.options = $.extend({}, this.defaults, options);
			var ele = this.options.ele;
			$(ele).each(function(){
		    	var beginSelector = $(this).find('.form_date_start');
		    	var endSelector = $(this).find('.form_date_end');
		        beginSelector.datetimepicker({  
		            language:  'zh-CN',
                    format: 'yyyy-mm-dd',
			        pickerPosition: 'bottom-left',
			        todayBtn:  1,
					autoclose: 1,
					todayHighlight: true,
					minView: 2,
					startDate: new Date()
		        }).on('changeDate', function(ev){               
		            if(ev.date){
		            	var date = ev.date.valueOf()+1000*60*60*24;
		                endSelector.datetimepicker('setStartDate', new Date(date));
		            }else{  
		                endSelector.datetimepicker('setStartDate',null);  
		            }  
		            if(_this.options.callback){_this.options.callback();}
		        });
		        endSelector.datetimepicker({  
		            language:  'zh-CN',
                    format: 'yyyy-mm-dd',
			        todayBtn:  1,
					autoclose: 1,
					todayHighlight: true,
					minView: 2,
					startDate: new Date()
		        }).on('changeDate', function(ev){    
		            if(ev.date){  
		            	var date = ev.date.valueOf()-1000*60*60*24;
		                beginSelector.datetimepicker('setEndDate', new Date(date))  
		            }else{  
		                beginSelector.datetimepicker('setEndDate',new Date());  
		            }
		            if(_this.options.callback){_this.options.callback();}
		        });
	    	});
		},
		preview: function(url){
			if($('#previewModal').length){
	    		$('.preview-list img').attr('src',url);
				$('#previewModal').modal('toggle');
	    		return;
	    	}
	    	var html = '<div class="modal fade" id="previewModal">\
							<div class="modal-dialog">\
								<div class="modal-content">\
									<div class="modal-header notitle">\
										<button type="button" class="" data-dismiss="modal" aria-label="Close"><i class="iconfont icon-cancel"></i></button>\
									</div>\
									<div class="modal-body">\
										<ul class="preview-list"><li><img src='+ url +'></li></ul>\
									</div>\
								</div>\
							</div>\
						</div>';
			$('body').append(html);
			$('#previewModal').modal('toggle');
		},
		isPC: function(){
			var userAgentInfo = navigator.userAgent;
		    var Agents = ["Android", "iPhone","SymbianOS", "Windows Phone","iPad", "iPod"];
		    var flag = true;
		    for (var v = 0; v < Agents.length; v++) {
		        if (userAgentInfo.indexOf(Agents[v]) > 0) {
		            flag = false;
		            break;
		        }
		    }
		    return flag;
		},
		GetQueryString: function(name){
		    var reg = new RegExp("(^|&)"+ name +"=([^&]*)(&|$)");
		    var r = window.location.search.substr(1).match(reg);
		    if(r!=null)return  unescape(r[2]); return null;
		}
	}
	return {
		DatePickerRange: funObj.DatePickerRange,
		preview: funObj.preview,
		isPC: funObj.isPC,
		GetQueryString: funObj.GetQueryString
	}
})();





// 产品详情-产品介绍格式转换
function changeInfo(cont){
	var html = '<ul>';
	cont = cont.replace(/\d\./g,"//").split('//');
	var arr = [];
	for (var i=0,l=cont.length;i<l;i++) {
		if(!cont[i].trim()){continue;}
		arr = cont[i].replace(/\d、/g,"//").split('//');
		for(var j=0,len=arr.length;j<len;j++){
			if(len == 1){
				html += '<li><span>'+ (i) + '.</span>' +arr[j] +'</li>';
			}else{
				if(!arr[j].trim()){continue;}
				if(j==1){
					html += '<li><span>'+ (i) + '.</span>' + (j) + '、' +arr[j] +'</li>';
				}else{
					html += '<li class="level2"><span>'+ (j) + '、</span>' +arr[j] +'</li>';
				}
			}
		}
	}
	html += '</ul>';
	return html;
}



(function($) {

var types = ['DOMMouseScroll', 'mousewheel'];

if ($.event.fixHooks) {
    for ( var i=types.length; i; ) {
        $.event.fixHooks[ types[--i] ] = $.event.mouseHooks;
    }
}

$.event.special.mousewheel = {
    setup: function() {
        if ( this.addEventListener ) {
            for ( var i=types.length; i; ) {
                this.addEventListener( types[--i], handler, false );
            }
        } else {
            this.onmousewheel = handler;
        }
    },
    
    teardown: function() {
        if ( this.removeEventListener ) {
            for ( var i=types.length; i; ) {
                this.removeEventListener( types[--i], handler, false );
            }
        } else {
            this.onmousewheel = null;
        }
    }
};

$.fn.extend({
    mousewheel: function(fn) {
        return fn ? this.bind("mousewheel", fn) : this.trigger("mousewheel");
    },
    
    unmousewheel: function(fn) {
        return this.unbind("mousewheel", fn);
    }
});


function handler(event) {
    var orgEvent = event || window.event, args = [].slice.call( arguments, 1 ), delta = 0, returnValue = true, deltaX = 0, deltaY = 0;
    event = $.event.fix(orgEvent);
    event.type = "mousewheel";
    
    // Old school scrollwheel delta
    if ( orgEvent.wheelDelta ) { delta = orgEvent.wheelDelta/120; }
    if ( orgEvent.detail     ) { delta = -orgEvent.detail/3; }
    
    // New school multidimensional scroll (touchpads) deltas
    deltaY = delta;
    
    // Gecko
    if ( orgEvent.axis !== undefined && orgEvent.axis === orgEvent.HORIZONTAL_AXIS ) {
        deltaY = 0;
        deltaX = -1*delta;
    }
    
    // Webkit
    if ( orgEvent.wheelDeltaY !== undefined ) { deltaY = orgEvent.wheelDeltaY/120; }
    if ( orgEvent.wheelDeltaX !== undefined ) { deltaX = -1*orgEvent.wheelDeltaX/120; }
    
    // Add event and delta to the front of the arguments
    args.unshift(event, delta, deltaX, deltaY);
    
    return ($.event.dispatch || $.event.handle).apply(this, args);
}

})(jQuery);

(function(b,a,c){b.fn.jScrollPane=function(e){function d(D,O){var ay,Q=this,Y,aj,v,al,T,Z,y,q,az,aE,au,i,I,h,j,aa,U,ap,X,t,A,aq,af,am,G,l,at,ax,x,av,aH,f,L,ai=true,P=true,aG=false,k=false,ao=D.clone(false,false).empty(),ac=b.fn.mwheelIntent?"mwheelIntent.jsp":"mousewheel.jsp";aH=D.css("paddingTop")+" "+D.css("paddingRight")+" "+D.css("paddingBottom")+" "+D.css("paddingLeft");f=(parseInt(D.css("paddingLeft"),10)||0)+(parseInt(D.css("paddingRight"),10)||0);function ar(aQ){var aL,aN,aM,aJ,aI,aP,aO=false,aK=false;ay=aQ;if(Y===c){aI=D.scrollTop();aP=D.scrollLeft();D.css({overflow:"hidden",padding:0});aj=D.innerWidth()+f;v=D.innerHeight();D.width(aj);Y=b('<div class="jspPane" />').css("padding",aH).append(D.children());al=b('<div class="jspContainer" />').css({width:aj+"px",height:v+"px"}).append(Y).appendTo(D)}else{D.css("width","");aO=ay.stickToBottom&&K();aK=ay.stickToRight&&B();aJ=D.innerWidth()+f!=aj||D.outerHeight()!=v;if(aJ){aj=D.innerWidth()+f;v=D.innerHeight();al.css({width:aj+"px",height:v+"px"})}if(!aJ&&L==T&&Y.outerHeight()==Z){D.width(aj);return}L=T;Y.css("width","");D.width(aj);al.find(">.jspVerticalBar,>.jspHorizontalBar").remove().end()}Y.css("overflow","auto");if(aQ.contentWidth){T=aQ.contentWidth}else{T=Y[0].scrollWidth}Z=Y[0].scrollHeight;Y.css("overflow","");y=T/aj;q=Z/v;az=q>1;aE=y>1;if(!(aE||az)){D.removeClass("jspScrollable");Y.css({top:0,width:al.width()-f});n();E();R();w()}else{D.addClass("jspScrollable");aL=ay.maintainPosition&&(I||aa);if(aL){aN=aC();aM=aA()}aF();z();F();if(aL){N(aK?(T-aj):aN,false);M(aO?(Z-v):aM,false)}J();ag();an();if(ay.enableKeyboardNavigation){S()}if(ay.clickOnTrack){p()}C();if(ay.hijackInternalLinks){m()}}if(ay.autoReinitialise&&!av){av=setInterval(function(){ar(ay)},ay.autoReinitialiseDelay)}else{if(!ay.autoReinitialise&&av){clearInterval(av)}}aI&&D.scrollTop(0)&&M(aI,false);aP&&D.scrollLeft(0)&&N(aP,false);D.trigger("jsp-initialised",[aE||az])}function aF(){if(az){al.append(b('<div class="jspVerticalBar" />').append(b('<div class="jspCap jspCapTop" />'),b('<div class="jspTrack" />').append(b('<div class="jspDrag" />').append(b('<div class="jspDragTop" />'),b('<div class="jspDragBottom" />'))),b('<div class="jspCap jspCapBottom" />')));U=al.find(">.jspVerticalBar");ap=U.find(">.jspTrack");au=ap.find(">.jspDrag");if(ay.showArrows){aq=b('<a class="jspArrow jspArrowUp" />').bind("mousedown.jsp",aD(0,-1)).bind("click.jsp",aB);af=b('<a class="jspArrow jspArrowDown" />').bind("mousedown.jsp",aD(0,1)).bind("click.jsp",aB);if(ay.arrowScrollOnHover){aq.bind("mouseover.jsp",aD(0,-1,aq));af.bind("mouseover.jsp",aD(0,1,af))}ak(ap,ay.verticalArrowPositions,aq,af)}t=v;al.find(">.jspVerticalBar>.jspCap:visible,>.jspVerticalBar>.jspArrow").each(function(){t-=b(this).outerHeight()});au.hover(function(){au.addClass("jspHover")},function(){au.removeClass("jspHover")}).bind("mousedown.jsp",function(aI){b("html").bind("dragstart.jsp selectstart.jsp",aB);au.addClass("jspActive");var s=aI.pageY-au.position().top;b("html").bind("mousemove.jsp",function(aJ){V(aJ.pageY-s,false)}).bind("mouseup.jsp mouseleave.jsp",aw);return false});o()}}function o(){ap.height(t+"px");I=0;X=ay.verticalGutter+ap.outerWidth();Y.width(aj-X-f);try{if(U.position().left===0){Y.css("margin-left",X+"px")}}catch(s){}}function z(){if(aE){al.append(b('<div class="jspHorizontalBar" />').append(b('<div class="jspCap jspCapLeft" />'),b('<div class="jspTrack" />').append(b('<div class="jspDrag" />').append(b('<div class="jspDragLeft" />'),b('<div class="jspDragRight" />'))),b('<div class="jspCap jspCapRight" />')));am=al.find(">.jspHorizontalBar");G=am.find(">.jspTrack");h=G.find(">.jspDrag");if(ay.showArrows){ax=b('<a class="jspArrow jspArrowLeft" />').bind("mousedown.jsp",aD(-1,0)).bind("click.jsp",aB);x=b('<a class="jspArrow jspArrowRight" />').bind("mousedown.jsp",aD(1,0)).bind("click.jsp",aB);
if(ay.arrowScrollOnHover){ax.bind("mouseover.jsp",aD(-1,0,ax));x.bind("mouseover.jsp",aD(1,0,x))}ak(G,ay.horizontalArrowPositions,ax,x)}h.hover(function(){h.addClass("jspHover")},function(){h.removeClass("jspHover")}).bind("mousedown.jsp",function(aI){b("html").bind("dragstart.jsp selectstart.jsp",aB);h.addClass("jspActive");var s=aI.pageX-h.position().left;b("html").bind("mousemove.jsp",function(aJ){W(aJ.pageX-s,false)}).bind("mouseup.jsp mouseleave.jsp",aw);return false});l=al.innerWidth();ah()}}function ah(){al.find(">.jspHorizontalBar>.jspCap:visible,>.jspHorizontalBar>.jspArrow").each(function(){l-=b(this).outerWidth()});G.width(l+"px");aa=0}function F(){if(aE&&az){var aI=G.outerHeight(),s=ap.outerWidth();t-=aI;b(am).find(">.jspCap:visible,>.jspArrow").each(function(){l+=b(this).outerWidth()});l-=s;v-=s;aj-=aI;G.parent().append(b('<div class="jspCorner" />').css("width",aI+"px"));o();ah()}if(aE){Y.width((al.outerWidth()-f)+"px")}Z=Y.outerHeight();q=Z/v;if(aE){at=Math.ceil(1/y*l);if(at>ay.horizontalDragMaxWidth){at=ay.horizontalDragMaxWidth}else{if(at<ay.horizontalDragMinWidth){at=ay.horizontalDragMinWidth}}h.width(at+"px");j=l-at;ae(aa)}if(az){A=Math.ceil(1/q*t);if(A>ay.verticalDragMaxHeight){A=ay.verticalDragMaxHeight}else{if(A<ay.verticalDragMinHeight){A=ay.verticalDragMinHeight}}au.height(A+"px");i=t-A;ad(I)}}function ak(aJ,aL,aI,s){var aN="before",aK="after",aM;if(aL=="os"){aL=/Mac/.test(navigator.platform)?"after":"split"}if(aL==aN){aK=aL}else{if(aL==aK){aN=aL;aM=aI;aI=s;s=aM}}aJ[aN](aI)[aK](s)}function aD(aI,s,aJ){return function(){H(aI,s,this,aJ);this.blur();return false}}function H(aL,aK,aO,aN){aO=b(aO).addClass("jspActive");var aM,aJ,aI=true,s=function(){if(aL!==0){Q.scrollByX(aL*ay.arrowButtonSpeed)}if(aK!==0){Q.scrollByY(aK*ay.arrowButtonSpeed)}aJ=setTimeout(s,aI?ay.initialDelay:ay.arrowRepeatFreq);aI=false};s();aM=aN?"mouseout.jsp":"mouseup.jsp";aN=aN||b("html");aN.bind(aM,function(){aO.removeClass("jspActive");aJ&&clearTimeout(aJ);aJ=null;aN.unbind(aM)})}function p(){w();if(az){ap.bind("mousedown.jsp",function(aN){if(aN.originalTarget===c||aN.originalTarget==aN.currentTarget){var aL=b(this),aO=aL.offset(),aM=aN.pageY-aO.top-I,aJ,aI=true,s=function(){var aR=aL.offset(),aS=aN.pageY-aR.top-A/2,aP=v*ay.scrollPagePercent,aQ=i*aP/(Z-v);if(aM<0){if(I-aQ>aS){Q.scrollByY(-aP)}else{V(aS)}}else{if(aM>0){if(I+aQ<aS){Q.scrollByY(aP)}else{V(aS)}}else{aK();return}}aJ=setTimeout(s,aI?ay.initialDelay:ay.trackClickRepeatFreq);aI=false},aK=function(){aJ&&clearTimeout(aJ);aJ=null;b(document).unbind("mouseup.jsp",aK)};s();b(document).bind("mouseup.jsp",aK);return false}})}if(aE){G.bind("mousedown.jsp",function(aN){if(aN.originalTarget===c||aN.originalTarget==aN.currentTarget){var aL=b(this),aO=aL.offset(),aM=aN.pageX-aO.left-aa,aJ,aI=true,s=function(){var aR=aL.offset(),aS=aN.pageX-aR.left-at/2,aP=aj*ay.scrollPagePercent,aQ=j*aP/(T-aj);if(aM<0){if(aa-aQ>aS){Q.scrollByX(-aP)}else{W(aS)}}else{if(aM>0){if(aa+aQ<aS){Q.scrollByX(aP)}else{W(aS)}}else{aK();return}}aJ=setTimeout(s,aI?ay.initialDelay:ay.trackClickRepeatFreq);aI=false},aK=function(){aJ&&clearTimeout(aJ);aJ=null;b(document).unbind("mouseup.jsp",aK)};s();b(document).bind("mouseup.jsp",aK);return false}})}}function w(){if(G){G.unbind("mousedown.jsp")}if(ap){ap.unbind("mousedown.jsp")}}function aw(){b("html").unbind("dragstart.jsp selectstart.jsp mousemove.jsp mouseup.jsp mouseleave.jsp");if(au){au.removeClass("jspActive")}if(h){h.removeClass("jspActive")}}function V(s,aI){if(!az){return}if(s<0){s=0}else{if(s>i){s=i}}if(aI===c){aI=ay.animateScroll}if(aI){Q.animate(au,"top",s,ad)}else{au.css("top",s);ad(s)}}function ad(aI){if(aI===c){aI=au.position().top}al.scrollTop(0);I=aI;var aL=I===0,aJ=I==i,aK=aI/i,s=-aK*(Z-v);if(ai!=aL||aG!=aJ){ai=aL;aG=aJ;D.trigger("jsp-arrow-change",[ai,aG,P,k])}u(aL,aJ);Y.css("top",s);D.trigger("jsp-scroll-y",[-s,aL,aJ]).trigger("scroll")}function W(aI,s){if(!aE){return}if(aI<0){aI=0}else{if(aI>j){aI=j}}if(s===c){s=ay.animateScroll}if(s){Q.animate(h,"left",aI,ae)
}else{h.css("left",aI);ae(aI)}}function ae(aI){if(aI===c){aI=h.position().left}al.scrollTop(0);aa=aI;var aL=aa===0,aK=aa==j,aJ=aI/j,s=-aJ*(T-aj);if(P!=aL||k!=aK){P=aL;k=aK;D.trigger("jsp-arrow-change",[ai,aG,P,k])}r(aL,aK);Y.css("left",s);D.trigger("jsp-scroll-x",[-s,aL,aK]).trigger("scroll")}function u(aI,s){if(ay.showArrows){aq[aI?"addClass":"removeClass"]("jspDisabled");af[s?"addClass":"removeClass"]("jspDisabled")}}function r(aI,s){if(ay.showArrows){ax[aI?"addClass":"removeClass"]("jspDisabled");x[s?"addClass":"removeClass"]("jspDisabled")}}function M(s,aI){var aJ=s/(Z-v);V(aJ*i,aI)}function N(aI,s){var aJ=aI/(T-aj);W(aJ*j,s)}function ab(aV,aQ,aJ){var aN,aK,aL,s=0,aU=0,aI,aP,aO,aS,aR,aT;try{aN=b(aV)}catch(aM){return}aK=aN.outerHeight();aL=aN.outerWidth();al.scrollTop(0);al.scrollLeft(0);while(!aN.is(".jspPane")){s+=aN.position().top;aU+=aN.position().left;aN=aN.offsetParent();if(/^body|html$/i.test(aN[0].nodeName)){return}}aI=aA();aO=aI+v;if(s<aI||aQ){aR=s-ay.verticalGutter}else{if(s+aK>aO){aR=s-v+aK+ay.verticalGutter}}if(aR){M(aR,aJ)}aP=aC();aS=aP+aj;if(aU<aP||aQ){aT=aU-ay.horizontalGutter}else{if(aU+aL>aS){aT=aU-aj+aL+ay.horizontalGutter}}if(aT){N(aT,aJ)}}function aC(){return -Y.position().left}function aA(){return -Y.position().top}function K(){var s=Z-v;return(s>20)&&(s-aA()<10)}function B(){var s=T-aj;return(s>20)&&(s-aC()<10)}function ag(){al.unbind(ac).bind(ac,function(aL,aM,aK,aI){var aJ=aa,s=I;Q.scrollBy(aK*ay.mouseWheelSpeed,-aI*ay.mouseWheelSpeed,false);return aJ==aa&&s==I})}function n(){al.unbind(ac)}function aB(){return false}function J(){Y.find(":input,a").unbind("focus.jsp").bind("focus.jsp",function(s){ab(s.target,false)})}function E(){Y.find(":input,a").unbind("focus.jsp")}function S(){var s,aI,aK=[];aE&&aK.push(am[0]);az&&aK.push(U[0]);Y.focus(function(){D.focus()});D.attr("tabindex",0).unbind("keydown.jsp keypress.jsp").bind("keydown.jsp",function(aN){if(aN.target!==this&&!(aK.length&&b(aN.target).closest(aK).length)){return}var aM=aa,aL=I;switch(aN.keyCode){case 40:case 38:case 34:case 32:case 33:case 39:case 37:s=aN.keyCode;aJ();break;case 35:M(Z-v);s=null;break;case 36:M(0);s=null;break}aI=aN.keyCode==s&&aM!=aa||aL!=I;return !aI}).bind("keypress.jsp",function(aL){if(aL.keyCode==s){aJ()}return !aI});if(ay.hideFocus){D.css("outline","none");if("hideFocus" in al[0]){D.attr("hideFocus",true)}}else{D.css("outline","");if("hideFocus" in al[0]){D.attr("hideFocus",false)}}function aJ(){var aM=aa,aL=I;switch(s){case 40:Q.scrollByY(ay.keyboardSpeed,false);break;case 38:Q.scrollByY(-ay.keyboardSpeed,false);break;case 34:case 32:Q.scrollByY(v*ay.scrollPagePercent,false);break;case 33:Q.scrollByY(-v*ay.scrollPagePercent,false);break;case 39:Q.scrollByX(ay.keyboardSpeed,false);break;case 37:Q.scrollByX(-ay.keyboardSpeed,false);break}aI=aM!=aa||aL!=I;return aI}}function R(){D.attr("tabindex","-1").removeAttr("tabindex").unbind("keydown.jsp keypress.jsp")}function C(){if(location.hash&&location.hash.length>1){var aK,aI,aJ=escape(location.hash.substr(1));try{aK=b("#"+aJ+', a[name="'+aJ+'"]')}catch(s){return}if(aK.length&&Y.find(aJ)){if(al.scrollTop()===0){aI=setInterval(function(){if(al.scrollTop()>0){ab(aK,true);b(document).scrollTop(al.position().top);clearInterval(aI)}},50)}else{ab(aK,true);b(document).scrollTop(al.position().top)}}}}function m(){if(b(document.body).data("jspHijack")){return}b(document.body).data("jspHijack",true);b(document.body).delegate("a[href*=#]","click",function(s){var aI=this.href.substr(0,this.href.indexOf("#")),aK=location.href,aO,aP,aJ,aM,aL,aN;if(location.href.indexOf("#")!==-1){aK=location.href.substr(0,location.href.indexOf("#"))}if(aI!==aK){return}aO=escape(this.href.substr(this.href.indexOf("#")+1));aP;try{aP=b("#"+aO+', a[name="'+aO+'"]')}catch(aQ){return}if(!aP.length){return}aJ=aP.closest(".jspScrollable");aM=aJ.data("jsp");aM.scrollToElement(aP,true);if(aJ[0].scrollIntoView){aL=b(a).scrollTop();aN=aP.offset().top;if(aN<aL||aN>aL+b(a).height()){aJ[0].scrollIntoView()}}s.preventDefault()
})}function an(){var aJ,aI,aL,aK,aM,s=false;al.unbind("touchstart.jsp touchmove.jsp touchend.jsp click.jsp-touchclick").bind("touchstart.jsp",function(aN){var aO=aN.originalEvent.touches[0];aJ=aC();aI=aA();aL=aO.pageX;aK=aO.pageY;aM=false;s=true}).bind("touchmove.jsp",function(aQ){if(!s){return}var aP=aQ.originalEvent.touches[0],aO=aa,aN=I;Q.scrollTo(aJ+aL-aP.pageX,aI+aK-aP.pageY);aM=aM||Math.abs(aL-aP.pageX)>5||Math.abs(aK-aP.pageY)>5;return aO==aa&&aN==I}).bind("touchend.jsp",function(aN){s=false}).bind("click.jsp-touchclick",function(aN){if(aM){aM=false;return false}})}function g(){var s=aA(),aI=aC();D.removeClass("jspScrollable").unbind(".jsp");D.replaceWith(ao.append(Y.children()));ao.scrollTop(s);ao.scrollLeft(aI);if(av){clearInterval(av)}}b.extend(Q,{reinitialise:function(aI){aI=b.extend({},ay,aI);ar(aI)},scrollToElement:function(aJ,aI,s){ab(aJ,aI,s)},scrollTo:function(aJ,s,aI){N(aJ,aI);M(s,aI)},scrollToX:function(aI,s){N(aI,s)},scrollToY:function(s,aI){M(s,aI)},scrollToPercentX:function(aI,s){N(aI*(T-aj),s)},scrollToPercentY:function(aI,s){M(aI*(Z-v),s)},scrollBy:function(aI,s,aJ){Q.scrollByX(aI,aJ);Q.scrollByY(s,aJ)},scrollByX:function(s,aJ){var aI=aC()+Math[s<0?"floor":"ceil"](s),aK=aI/(T-aj);W(aK*j,aJ)},scrollByY:function(s,aJ){var aI=aA()+Math[s<0?"floor":"ceil"](s),aK=aI/(Z-v);V(aK*i,aJ)},positionDragX:function(s,aI){W(s,aI)},positionDragY:function(aI,s){V(aI,s)},animate:function(aI,aL,s,aK){var aJ={};aJ[aL]=s;aI.animate(aJ,{duration:ay.animateDuration,easing:ay.animateEase,queue:false,step:aK})},getContentPositionX:function(){return aC()},getContentPositionY:function(){return aA()},getContentWidth:function(){return T},getContentHeight:function(){return Z},getPercentScrolledX:function(){return aC()/(T-aj)},getPercentScrolledY:function(){return aA()/(Z-v)},getIsScrollableH:function(){return aE},getIsScrollableV:function(){return az},getContentPane:function(){return Y},scrollToBottom:function(s){V(i,s)},hijackInternalLinks:b.noop,destroy:function(){g()}});ar(O)}e=b.extend({},b.fn.jScrollPane.defaults,e);b.each(["mouseWheelSpeed","arrowButtonSpeed","trackClickSpeed","keyboardSpeed"],function(){e[this]=e[this]||e.speed});return this.each(function(){var f=b(this),g=f.data("jsp");if(g){g.reinitialise(e)}else{g=new d(f,e);f.data("jsp",g)}})};b.fn.jScrollPane.defaults={showArrows:false,maintainPosition:true,stickToBottom:false,stickToRight:false,clickOnTrack:true,autoReinitialise:false,autoReinitialiseDelay:500,verticalDragMinHeight:0,verticalDragMaxHeight:99999,horizontalDragMinWidth:0,horizontalDragMaxWidth:99999,contentWidth:c,animateScroll:false,animateDuration:300,animateEase:"linear",hijackInternalLinks:false,verticalGutter:4,horizontalGutter:4,mouseWheelSpeed:0,arrowButtonSpeed:0,arrowRepeatFreq:50,arrowScrollOnHover:false,trackClickSpeed:0,trackClickRepeatFreq:70,verticalArrowPositions:"split",horizontalArrowPositions:"split",enableKeyboardNavigation:true,hideFocus:false,keyboardSpeed:0,initialDelay:300,speed:30,scrollPagePercent:0.8}})(jQuery,this);

//拖拽排序
(function() {
  "use strict";
  var $, Animation, Draggable, Gridly,
    bind = function(fn, me){ return function(){ return fn.apply(me, arguments); }; },
    slice = [].slice;

  $ = jQuery;

  Animation = (function() {
    function Animation() {}

    Animation.transitions = {
      "webkitTransition": "webkitTransitionEnd",
      "mozTransition": "mozTransitionEnd",
      "oTransition": "oTransitionEnd",
      "transition": "transitionend"
    };

    Animation.transition = function($el) {
      var el, ref, result, type;
      el = $el[0];
      ref = this.transitions;
      for (type in ref) {
        result = ref[type];
        if (el.style[type] != null) {
          return result;
        }
      }
    };

    Animation.execute = function($el, callback) {
      var transition;
      transition = this.transition($el);
      if (transition != null) {
        return $el.one(transition, callback);
      } else {
        return callback();
      }
    };

    return Animation;

  })();

  Draggable = (function() {
    function Draggable($container, selector, callbacks) {
      this.touchend = bind(this.touchend, this);
      this.click = bind(this.click, this);
      this.moved = bind(this.moved, this);
      this.ended = bind(this.ended, this);
      this.began = bind(this.began, this);
      this.coordinate = bind(this.coordinate, this);
      this.off = bind(this.off, this);
      this.on = bind(this.on, this);
      this.toggle = bind(this.toggle, this);
      this.bind = bind(this.bind, this);
      this.$container = $container;
      this.selector = selector;
      this.callbacks = callbacks;
      this.toggle();
    }

    Draggable.prototype.bind = function(method) {
      if (method == null) {
        method = 'on';
      }
      $(document)[method]('mousemove touchmove', this.moved);
      return $(document)[method]('mouseup touchcancel', this.ended);
    };

    Draggable.prototype.toggle = function(method) {
      if (method == null) {
        method = 'on';
      }
      this.$container[method]('mousedown touchstart', this.selector, this.began);
      this.$container[method]('touchend', this.selector, this.touchend);
      return this.$container[method]('click', this.selector, this.click);
    };

    Draggable.prototype.on = function() {
      return this.toggle('on');
    };

    Draggable.prototype.off = function() {
      return this.toggle('off');
    };

    Draggable.prototype.coordinate = function(event) {
      switch (event.type) {
        case 'touchstart':
        case 'touchmove':
        case 'touchend':
        case 'touchcancel':
          return event.originalEvent.touches[0];
        default:
          return event;
      }
    };

    Draggable.prototype.began = function(event) {
      var ref;
      if (this.$target) {
        return;
      }
      event.preventDefault();
      event.stopPropagation();
      this.bind('on');
      this.$target = $(event.target).closest(this.$container.find(this.selector));
      this.$target.addClass('dragging');
      this.origin = {
        x: this.coordinate(event).pageX - this.$target.position().left,
        y: this.coordinate(event).pageY - this.$target.position().top
      };
      return (ref = this.callbacks) != null ? typeof ref.began === "function" ? ref.began(event) : void 0 : void 0;
    };

    Draggable.prototype.ended = function(event) {
      var ref;
      if (this.$target == null) {
        return;
      }
      if (event.type !== 'touchend') {
        event.preventDefault();
        event.stopPropagation();
      }
      this.bind('off');
      this.$target.removeClass('dragging');

      delete this.$target;
      delete this.origin;
      return (ref = this.callbacks) != null ? typeof ref.ended === "function" ? ref.ended(event) : void 0 : void 0;
    };

    Draggable.prototype.moved = function(event) {
      var ref;
      if (this.$target == null) {
        return;
      }
      event.preventDefault();
      event.stopPropagation();
      this.$target.css({
        left: this.coordinate(event).pageX - this.origin.x,
        top: this.coordinate(event).pageY - this.origin.y
      });
      this.dragged = this.$target;
      return (ref = this.callbacks) != null ? typeof ref.moved === "function" ? ref.moved(event) : void 0 : void 0;
    };

    Draggable.prototype.click = function(event) {
      if (!this.dragged) {
        return;
      }
      event.preventDefault();
      event.stopPropagation();
      return delete this.dragged;
    };

    Draggable.prototype.touchend = function(event) {
      this.ended(event);
      return this.click(event);
    };

    return Draggable;

  })();

  Gridly = (function() {
    Gridly.settings = {
      base: 60,
      gutter: 20,
      columns: 12,
      end: null,
      draggable: {
        zIndex: 800,
        selector: '> *'
      }
    };

    Gridly.gridly = function($el, options) {
      var data;
      if (options == null) {
        options = {};
      }
      data = $el.data('_gridly');
      if (!data) {
        data = new Gridly($el, options);
        $el.data('_gridly', data);
      }
      return data;
    };

    function Gridly($el, settings) {
      if (settings == null) {
        settings = {};
      }
      this.optimize = bind(this.optimize, this);
      this.layout = bind(this.layout, this);
      this.structure = bind(this.structure, this);
      this.position = bind(this.position, this);
      this.size = bind(this.size, this);
      this.draggingMoved = bind(this.draggingMoved, this);
      this.draggingEnded = bind(this.draggingEnded, this);
      this.draggingBegan = bind(this.draggingBegan, this);
      this.$sorted = bind(this.$sorted, this);
      this.draggable = bind(this.draggable, this);
      this.compare = bind(this.compare, this);
      this.$ = bind(this.$, this);
      this.reordinalize = bind(this.reordinalize, this);
      this.ordinalize = bind(this.ordinalize, this);
      this.$el = $el;
      this.settings = $.extend({}, Gridly.settings, settings);
      this.ordinalize(this.$('> *'));
      if (this.settings.draggable !== false) {
        this.draggable();
      }
      return this;
    }

    Gridly.prototype.ordinalize = function($elements) {
      var $element, i, j, ref, results1;
      results1 = [];
      for (i = j = 0, ref = $elements.length; 0 <= ref ? j <= ref : j >= ref; i = 0 <= ref ? ++j : --j) {
        $element = $($elements[i]);
        results1.push($element.data('position', i));
      }
      return results1;
    };

    Gridly.prototype.reordinalize = function($element, position) {
      return $element.data('position', position);
    };

    Gridly.prototype.$ = function(selector) {
      return this.$el.find(selector);
    };

    Gridly.prototype.compare = function(d, s) {
      if (d.y > s.y + s.h) {
        return +1;
      }
      if (s.y > d.y + d.h) {
        return -1;
      }
      if ((d.x + (d.w / 2)) > (s.x + (s.w / 2))) {
        return +1;
      }
      if ((s.x + (s.w / 2)) > (d.x + (d.w / 2))) {
        return -1;
      }
      return 0;
    };

    Gridly.prototype.draggable = function(method) {
      if (this._draggable == null) {
        this._draggable = new Draggable(this.$el, this.settings.draggable.selector, {
          began: this.draggingBegan,
          ended: this.draggingEnded,
          moved: this.draggingMoved
        });
      }
      if (method != null) {
        return this._draggable[method]();
      }
    };

    Gridly.prototype.$sorted = function($elements) {
      return ($elements || this.$('> *')).sort(function(a, b) {
        var $a, $b, aPosition, aPositionInt, bPosition, bPositionInt;
        $a = $(a);
        $b = $(b);
        aPosition = $a.data('position');
        bPosition = $b.data('position');
        aPositionInt = parseInt(aPosition);
        bPositionInt = parseInt(bPosition);
        if ((aPosition != null) && (bPosition == null)) {
          return -1;
        }
        if ((bPosition != null) && (aPosition == null)) {
          return +1;
        }
        if (!aPosition && !bPosition && $a.index() < $b.index()) {
          return -1;
        }
        if (!bPosition && !aPosition && $b.index() < $a.index()) {
          return +1;
        }
        if (aPositionInt < bPositionInt) {
          return -1;
        }
        if (bPositionInt < aPositionInt) {
          return +1;
        }
        return 0;
      });
    };

    Gridly.prototype.draggingBegan = function(event) {
      var $elements, ref, ref1;
      $elements = this.$sorted();
      this.ordinalize($elements);
      setTimeout(this.layout, 0);
      return (ref = this.settings) != null ? (ref1 = ref.callbacks) != null ? typeof ref1.reordering === "function" ? ref1.reordering($elements) : void 0 : void 0 : void 0;
    };

    Gridly.prototype.draggingEnded = function(event) {
      var $elements, ref, ref1;
      $elements = this.$sorted();
      this.ordinalize($elements);
      setTimeout(this.layout, 0);
      return (ref = this.settings) != null ? (ref1 = ref.callbacks) != null ? typeof ref1.reordered === "function" ? ref1.reordered($elements, this._draggable.dragged) : void 0 : void 0 : void 0;
    };

    Gridly.prototype.draggingMoved = function(event) {
      var $dragging, $elements, element, i, index, j, k, len, original, positions, ref, ref1, ref2;
      $dragging = $(event.target).closest(this.$(this.settings.draggable.selector));
      $elements = this.$sorted(this.$(this.settings.draggable.selector));
      positions = this.structure($elements).positions;
      original = index = $dragging.data('position');
      ref = positions.filter(function(position) {
        return position.$element.is($dragging);
      });
      for (j = 0, len = ref.length; j < len; j++) {
        element = ref[j];
        element.x = $dragging.position().left;
        element.y = $dragging.position().top;
        element.w = $dragging.data('width') || $dragging.outerWidth();
        element.h = $dragging.data('height') || $dragging.outerHeight();
      }
      positions.sort(this.compare);
      $elements = positions.map(function(position) {
        return position.$element;
      });
      $elements = (((ref1 = this.settings.callbacks) != null ? ref1.optimize : void 0) || this.optimize)($elements);
      for (i = k = 0, ref2 = $elements.length; 0 <= ref2 ? k < ref2 : k > ref2; i = 0 <= ref2 ? ++k : --k) {
        this.reordinalize($($elements[i]), i);
      }
      return this.layout();
    };

    Gridly.prototype.size = function($element) {
      return (($element.data('width') || $element.outerWidth()) + this.settings.gutter) / (this.settings.base + this.settings.gutter);
    };

    Gridly.prototype.position = function($element, columns) {
      var column, height, i, j, k, max, ref, ref1, ref2, size;
      size = this.size($element);
      height = Infinity;
      column = 0;
      for (i = j = 0, ref = columns.length - size; 0 <= ref ? j < ref : j > ref; i = 0 <= ref ? ++j : --j) {
        max = Math.max.apply(Math, columns.slice(i, i + size));
        if (max < height) {
          height = max;
          column = i;
        }
      }
      for (i = k = ref1 = column, ref2 = column + size; ref1 <= ref2 ? k < ref2 : k > ref2; i = ref1 <= ref2 ? ++k : --k) {
        columns[i] = height + ($element.data('height') || $element.outerHeight()) + this.settings.gutter;
      }
      return {
        x: column * (this.settings.base + this.settings.gutter),
        y: height
      };
    };

    Gridly.prototype.structure = function($elements) {
      var $element, columns, i, index, j, position, positions, ref;
      if ($elements == null) {
        $elements = this.$sorted();
      }
      positions = [];
      columns = (function() {
        var j, ref, results1;
        results1 = [];
        for (i = j = 0, ref = this.settings.columns; 0 <= ref ? j <= ref : j >= ref; i = 0 <= ref ? ++j : --j) {
          results1.push(0);
        }
        return results1;
      }).call(this);
      for (index = j = 0, ref = $elements.length; 0 <= ref ? j < ref : j > ref; index = 0 <= ref ? ++j : --j) {
        $element = $($elements[index]);
        position = this.position($element, columns);
        positions.push({
          x: position.x,
          y: position.y,
          w: $element.data('width') || $element.outerWidth(),
          h: $element.data('height') || $element.outerHeight(),
          $element: $element
        });
      }
      return {
        height: Math.max.apply(Math, columns),
        positions: positions
      };
    };

    Gridly.prototype.layout = function() {
      var $element, $elements, index, j, position, ref, ref1, structure;
      $elements = (((ref = this.settings.callbacks) != null ? ref.optimize : void 0) || this.optimize)(this.$sorted());
      structure = this.structure($elements);
      for (index = j = 0, ref1 = $elements.length; 0 <= ref1 ? j < ref1 : j > ref1; index = 0 <= ref1 ? ++j : --j) {
        $element = $($elements[index]);
        position = structure.positions[index];
        if ($element.is('.dragging')) {
          continue;
        }
        $element.attr('data-id',index);
        $element.css({
          position: 'absolute',
          left: position.x,
          top: position.y
        });
      }
      return this.$el.css({
        height: structure.height
      });
    };

    Gridly.prototype.optimize = function(originals) {
      var columns, index, j, ref, results;
      results = [];
      columns = 0;
      while (originals.length > 0) {
        if (columns === this.settings.columns) {
          columns = 0;
        }
        index = 0;
        for (index = j = 0, ref = originals.length; 0 <= ref ? j < ref : j > ref; index = 0 <= ref ? ++j : --j) {
          if (!(columns + this.size($(originals[index])) > this.settings.columns)) {
            break;
          }
        }
        if (index === originals.length) {
          index = 0;
          columns = 0;
        }
        columns += this.size($(originals[index]));
        results.push(originals.splice(index, 1)[0]);
      }
      return results;
    };

    return Gridly;

  })();

  $.fn.extend({
    gridly: function() {
      var option, parameters;
      option = arguments[0], parameters = 2 <= arguments.length ? slice.call(arguments, 1) : [];
      if (option == null) {
        option = {};
      }
      return this.each(function() {
        var $this, action, options;
        $this = $(this);
        options = $.extend({}, $.fn.gridly.defaults, typeof option === "object" && option);
        action = typeof option === "string" ? option : option.action;
        if (action == null) {
          action = "layout";
        }
        return Gridly.gridly($this, options)[action](parameters);
      });
    }
  });

}).call(this);