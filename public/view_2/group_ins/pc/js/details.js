$(function() {
	// 表格
	var rowspannum = $('.content-table-detail tr').length - 1;
	$('.addition-clause').attr('rowspan', rowspannum);
	var ele = {
		anchorlinkwrapper: $('.anchorlink-wrapper'),
		anchorlinkitem: $('.anchorlink-item'),
		navitem: $('.tabControl-nav span'),
		wrapperitem: $('.tabControl-wrapper ul'),
		productTop: $('.product').offset().top,
		productPossessTop: $('.product-possess').offset().top,
		productEvaluateTop: $('.product-evaluate').offset().top,
		productChangeTop: $('.product-right-top'),
		productChangeBottom: $('.product-right-bottom'),
	}

	$('.introduce-parameter .product-type').click(function() {
		$(this).addClass('active').siblings().removeClass('active');
	});
	
	// 选项卡切换
	ele.navitem.click(function() {
		var index = $(this).index();
		$(this).addClass('active').siblings().removeClass('active');
		ele.wrapperitem.eq(index).show().siblings().hide();
	})

	// 锚链接
	var currentIndex;
	var anchorlinkwrapperTop = ele.anchorlinkwrapper.offset().top;
	$(document).scroll(function() {
		var scrollTop = $(document).scrollTop();
		if (scrollTop >= anchorlinkwrapperTop) {
			ele.anchorlinkwrapper.addClass('fixed');
			ele.productChangeTop.hide();
			ele.productChangeBottom.show();
		} else {
			ele.anchorlinkwrapper.removeClass('fixed');
			ele.productChangeTop.show();
			ele.productChangeBottom.hide();
		}
		if (scrollTop >= parseInt(ele.productTop)-80) {
			active(0);
		}
		if (scrollTop >= parseInt(ele.productPossessTop)-80) {
			active(1);
		}
		if (scrollTop >= parseInt(ele.productEvaluateTop)-80) {
			active(2);
		}
		function active(index){
			ele.anchorlinkitem.eq(currentIndex).addClass('active').siblings().removeClass('active');
		}
	});

	ele.anchorlinkitem.click(function() {
		$(this).addClass('active').siblings().removeClass('active');
		var index = $(this).index();
		currentIndex = index;
		var scrollTop;
		switch (index) {
			case 0:
				scrollTop = ele.productTop - 80;
				break;
			case 1:
				scrollTop = ele.productPossessTop - 80;
				break;
			case 2:
				scrollTop = ele.productEvaluateTop - 80;
				break;
			default:
				scrollTop = 0;
				break;
		}
		document.documentElement.scrollTop = scrollTop;
		document.body.scrollTop = scrollTop;
	});

	// 弹出框
	$('.btn-compare').click(function() {
		new Popup('.popup-compare');
	});
	

	$('.popup-list th').click(function() {
		$('td').removeClass('active');
		var selectedindex = $(this).index();
		$('.popup-list tbody tr').each(function(index) {
			$(this).find('td').removeClass('line');
			if (index === 0) {
				$(this).find('td').eq(selectedindex).addClass('line');
			}
			$(this).find('td').eq(selectedindex).addClass('active');
		})
	});
	// json格式转换
	function changeJsonData(json) {
		var Obj = JSON.parse(json);
		var Arr = [];
		for(item in Obj) {
			var bank = {};
			bank.id = Obj[item].value;
			bank.text = Obj[item].text;
			Arr.push(bank)
		}
		return Arr;
	}
	// 选择框联动效果
	$('.product-type').click(function(){
		var data = $(this).attr('data-options');
		var arr = changeJsonData(data);
		var html = '';
		for(var i=0;i<arr.length;i++){
			html += '<li data-value="'+ arr[i].id +'">'+ arr[i].text +'</li>';
		}
		$('.select>span').text(arr[0].text)
		$('.select-dropdown').html(html);
		dropDown();
	});
	
	
	// 对比条目的筛选
	$('.popup .product-type').not('.all').click(function() {
		$('.popup .all').removeClass('active');
		if ($(this).hasClass('active')) {
			$(this).removeClass('active');
		} else {
			$(this).addClass('active');
		}
		popupselecte();
	});
	$('.popup .all').click(function() {
		$('.popup .product-type').removeClass('active');
		if ($(this).hasClass('active')) {
			$(this).removeClass('active');
		} else {
			$(this).addClass('active');
		}
		popupselecte();
	});
	function popupselecte() {
		$('.popup .product-type.active').each(function(index, ele) {
			console.log($(this).index());
			var selectedindex = $(this).index();
		})
	}
	
	
	Mock.mock('http://g.cn', {
	    'name'	   : '[@name](/user/name)()',
	    'age|1-100': 100,
	    'color'	   : '[@color](/user/color)'
	});
	
	
	
});
laydate({
	elem: '#starttime',
	max: laydate.now(0),
	choose: function(datas) {
		console.log(datas)
	}
});

var html = $('#options').html();
function init(){
	$('.introduce-parameter-content li,#starttime').click(function(){
		$.ajax({
		    url: 'http://g.cn',
		}).done(function(data, status, xhr){
		    console.log('111')
			$('#options').html(html);  
			dropDown()
			init()
		})
	})
	laydate({
		elem: '#starttime',
		max: laydate.now(0),
		choose: function(datas) {
			console.log(datas)
		}
	});
}
init()