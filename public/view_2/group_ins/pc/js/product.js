$(function() {
	// 分页
	$('#pageTool').Paging({
		pagesize:10,
		count:100,
		callback:function(page,size,count){
			console.log(arguments)
			alert('当前第 ' +page +'页,每页 '+size+'条,总页数：'+count+'页')
		}
	});
	// 综合排序
	$('.sort .filtrate-content li').click(function() {
		$(this).addClass('active').siblings().removeClass('active');
		if ($(this).find('.icon-arrowDown').length) {
			$(this).find('.iconfont').removeClass('icon-arrowDown').addClass('icon-jiantou');
		} else if ($(this).find('.icon-jiantou').length) {
			$(this).find('.iconfont').removeClass('icon-jiantou').addClass('icon-arrowDown');
		}
	});
	// 产品筛选
	$('.filtrate .filtrate-content li').not('.filtrate-dropdown,.filtrate-content-custom').click(function() {
		var ele = $(this).clone();
		var html = ele.append('<i class="iconfont icon-close"></i>');
		var text = $(this).text();
		var type1 = $(this).attr('data-type');
		if ($('.filtrate-selected li').length) {
			$('.filtrate-selected li').each(function(index, ele) {
				var type = $(this).attr('data-type');
				if (type1 == 'fenlei') {
					if ($(this).text() === text) {
						return false;
					}
					if (index === $('.filtrate-selected li').length - 1) {
						$('.filtrate-selected').append(html);
					}
				} else {
					if (type1 === type) {
						$(this).remove();
						$('.filtrate-selected').append(html);
					}else{
						$('.filtrate-selected').append(html);
					}
				}
			});
		} else {
			$('.filtrate-selected').append(html);
		}
		// 标签的删除
		$('.icon-close').click(function() {
			$(this).parent().remove();
		})

	});
	
	$('.filtrate-content-custom').click(function(e){
		$(this).find('.filtrate-content-days').show();
	});
	

	// 单选按钮状态
	$('.btn-compare').click(function() {
		var status = $(this).is(':checked');
		var ele = {
			iconfont: $(this).parent().find('.iconfont'),
			span: $(this).parent().find('span')
		}
		console.log(status);
		if (status) {
			ele.iconfont.removeClass('icon-Check').addClass('icon-danxuankuang');
			ele.span.addClass('active');
		} else {
			ele.iconfont.removeClass('icon-danxuankuang').addClass('icon-Check');
			ele.span.removeClass('active');
		}
	});

	// 综合排序
	var ele = {
		currentpage: $('.currentpage'),
		totalpages: $('.totalpages'),
		btnleft: $('.sort-skipbox-btn-left'),
		btnright: $('.sort-skipbox-btn-right')
	}

	ele.btnleft.click(function() {
		var currentpage = parseInt(ele.currentpage.text());
		var totalpages = parseInt(ele.totalpages.text());
		currentpage--;
		ele.btnright.removeClass('unusable');
		if (currentpage == 0) {
			return false;
		}
		if (currentpage == 1) {
			ele.btnleft.addClass('unusable');
		}
		ele.currentpage.text(currentpage);
	});

	ele.btnright.click(function() {
		var currentpage = parseInt(ele.currentpage.text());
		var totalpages = parseInt(ele.totalpages.text());
		currentpage++;
		ele.btnleft.removeClass('unusable');
		if (currentpage <= totalpages) {
			if (currentpage == totalpages) {
				ele.btnright.addClass('unusable');
			}
			ele.currentpage.text(currentpage);
		}
	});
});


laydate({
	elem: '#starttime',
	max: laydate.now(0),
	choose: function(datas) {
		console.log(datas)
	}
});

var startTime,endTime;
var parserDate = function (date) {  
    var t = Date.parse(date);  
    if (!isNaN(t)) {  
        return new Date(Date.parse(date.replace(/-/g, "/")));  
    } else {  
        return new Date();  
    }  
};
function formatDuring(mss) {
    var days = parseInt(mss / (1000 * 60 * 60 * 24));
    return days + " 天 ";
}
//日期范围限制
var start = {
    elem: '#start',
    format: 'YYYY-MM-DD',
    min: laydate.now(0), //设定最小日期为当前日期
    max: '2099-06-16', //最大日期
    choose: function(datas){
         end.min = datas; //开始日选好后，重置结束日的最小日期
         end.start = datas //将结束日的初始值设定为开始日
         startTime = parserDate(datas);
    }
};
var end = {
    elem: '#end',
    format: 'YYYY-MM-DD',
    min: laydate.now(),
    max: '2099-06-16',
    choose: function(datas){
        start.max = datas; //结束日选好后，充值开始日的最大日期
		endTime = parserDate(datas);
		var days = formatDuring(endTime - startTime);
		$('.filtrate-content-days').hide();
		$('.filtrate-content-custom').find('span').text(days);
		console.log(days)
		
    }
};
laydate(start);
laydate(end);