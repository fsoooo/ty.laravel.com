var guaranteeTime, selfStatus = true;

mui('.mui-scroll-wrapper').scroll({
	deceleration: 0.0005,
	indicators: true
});
$('.switchone').parent().nextAll().hide();

$('.name').each(function(){
	var length = $(this).text().length;
	if(length>7){
		$(this).css({'word-break': 'break-all','line-height': '1.8'});
	}
});

// 判断是否认证 true:已认证
var certificationStatus = false;
if(certificationStatus) {
	$('.approve').hide();
	$('.mui-title').text('被保人');
}

$('.switchone').on('toggle', function() {
	var $content = $(this).parent().nextAll();
	var value = event.detail.isActive;
	if(value) { //被保人非本人
		selfStatus = false;
		$content.show();
		$(this).parent().css({
			'border-bottom': '1px solid #dcdcdc'
		});
	} else {
		selfStatus = true;
		$content.hide();
		$(this).parent().css({
			'border-bottom': 'none'
		});
	}
});
$('.switchtwo').on('toggle', function() {
	var value = event.detail.isActive;
	if(value) {
		console.log('保存为常用联系人')
	}
});

var userPicker = new mui.PopPicker();
// 表单value
var certificateimg1,certificateimg2;
$('.pickerone,.pickertwo,.pickerthree').on('tap', function(e) {
	var _this = $(this);
	var jsonData = _this.attr('data-options');
	var which = this.className;
	userPicker.setData(changeJsonData(jsonData));
	userPicker.show(function(items) {
		_this.find('input:text').val(items[0].text);
		_this.find('.inputhidden').val(items[0].id);
		
		if(_this.find('#certificatetype1').length) {
			$("#certificateimg1").click();
		}
		if(_this.find('#certificatetype2').length) {
			$("#certificateimg2").click();
		}
	});
});
// 上传证件照
function upload(c) {
	var $c = document.querySelector(c),
		file = $c.files[0],
		reader = new FileReader();
	reader.readAsDataURL(file);
	reader.onload = function(e) {
		// e.target.result 为图片base64
		console.log(e.target.result);
		if(c === '#certificateimg1'){
			certificateimg1 = e.target.result;
			$('#certificateimg1').val(certificateimg1);
		}
		if(c === '#certificateimg2'){
			certificateimg2 = e.target.result;
			$('#certificateimg2').val(certificateimg2);
		}
		mui.toast('上传成功');
	};
};
// 保障时间
var protectionPeriod = 7; // 详情页选择的保障期限
function getNextDay(d,n){
    d = new Date(d);
    d = +d + 1000*60*60*24*n;
    d = new Date(d);
    return d.getFullYear()+"."+(d.getMonth()+1)+"."+d.getDate();
}
$('.pickerfour').on('tap', function() {
	var _this = $(this);
	var picker = new mui.DtPicker({
		"type": "date",
		"beginYear": 1999
	});
	picker.show(function(rs) {
		_this.find('input').val(rs.text+'-'+getNextDay(rs.text,protectionPeriod));
		guaranteeTime = rs.text;
		console.log(guaranteeTime)
		selfStatus === true ? changeColor1() : changeColor2();
		picker.dispose();
	});
});


// 表单value
var certificateing1, certificateing2;
var name1, certificatenum1, tel1, email1, name2, certificatenum2, tel2, email2;
// 按钮是否可点击
console.log(selfStatus)
$("input").on("input propertychange", function() {
	name1 = $("#name1").val();
	certificatenum1 = $("#certificatenum1").val();
	tel1 = $("#tel1").val();
	email1 = $("#email1").val();
	name2 = $("#name2").val();
	certificatenum2 = $("#certificatenum2").val();
	tel2 = $("#tel2").val();
	email2 = $("#email2").val();
	selfStatus === true ? changeColor1() : changeColor2();
});

function changeColor1() {
	if(name1 && certificatenum1 && tel1 && email1 && guaranteeTime) {
		$('.btn-next').removeAttr('disabled');
	} else {
		$('.btn-next').attr({
			'disabled': 'disabled'
		});
	}
}

function changeColor2() {
	console.log(name1)
	if(name1 && certificatenum1 && tel1 && email1 && name2 && certificatenum2 && tel2 && email2 && guaranteeTime) {
		$('.btn-next').removeAttr('disabled');
	} else {
		$('.btn-next').attr({
			'disabled': 'disabled'
		});
	}
}

// 下一步
var isTel = /^1[34578]\d{9}$/;
var isIdCard = /^(\d{15}$|^\d{18}$|^\d{17}(\d|X|x))$/;
var isEmail = /^[A-Za-z0-9\u4e00-\u9fa5]+@[a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]+)+$/;

$('.btn-next').on('tap', function() {
	// 验证
	if(!isIdCard.test(certificatenum1) || !isIdCard.test(certificatenum2)) {
		mui.toast('证件号码格式不正确');
		return;
	} else if(!isTel.test(tel1) || !isTel.test(tel1)) {
		mui.toast('手机号码格式不正确');
		return;
	} else if(!isEmail.test(email1) || !isEmail.test(email2)) {
		mui.toast('电子邮箱格式不正确');
		return;
	}else{
		console.log(name1,certificatenum1,tel1,email1,name2,certificatenum2,tel2,email2)
	}
	window.location.href = 'preview.html';
})



var arr = [{
	"id": 198009,
	"name": "\u4e00\u822c\u804c\u4e1a",
	"parentId": 0,
	"isInsure": null,
	"_child": [{
		"id": 198010,
		"name": "\u4e00\u822c\u804c\u4e1a",
		"parentId": 198009,
		"isInsure": null,
		"_child": [{
			"id": 198011,
			"name": "\u673a\u5173\u56e2\u4f53\u5185\u52e4\u4eba\u5458",
			"parentId": 198010,
			"isInsure": "\u662f"
		}, {
			"id": 198012,
			"name": "\u673a\u5173\u56e2\u4f53\u5916\u52e4\u4eba\u5458\uff08\u4ece\u4e8b\u8054\u7cfb\u5de5\u4f5c\uff09",
			"parentId": 198010,
			"isInsure": "\u662f"
		}, {
			"id": 198014,
			"name": "\u5de5\u5382\u8d1f\u8d23\u4eba\u3001\u79c1\u8425\u4f01\u4e1a\u4e3b\uff08\u4e0d\u4eb2\u81ea\u4f5c\u4e1a\uff09",
			"parentId": 198010,
			"isInsure": "\u662f"
		}, {
			"id": 198015,
			"name": "\u5de5\u5382\u3001\u4f01\u4e1a\u90e8\u95e8\u7ecf\u7406\\\u4e3b\u7ba1\uff08\u4e0d\u4eb2\u81ea\u4f5c\u4e1a\uff09",
			"parentId": 198010,
			"isInsure": "\u662f"
		}, {
			"id": 198016,
			"name": "\u5de5\u5382\u3001\u4f01\u4e1a\u4e00\u822c\u5185\u52e4",
			"parentId": 198010,
			"isInsure": "\u662f"
		}, {
			"id": 198017,
			"name": "\u6751\u59d4\u4f1a\u3001\u5c45\u59d4\u4f1a\u4eba\u5458",
			"parentId": 198010,
			"isInsure": "\u662f"
		}]
	}]
}];



var jsonData = JSON.stringify(arr);
//var jsonData = $('.pickerarea').attr('data-options');
var newData = jsonData.replace(/"_child"/g,'"children"').replace(/"name"/g,'"text"');

var cityData = JSON.parse(newData);
var _getParam = function(obj, param) {
	return obj[param] || '';
};
var areaPicker = new mui.PopPicker({
	layer: 3
});
areaPicker.setData(cityData);
$('.pickerarea').on('tap',function(){
	var _this = $(this);
	areaPicker.show(function(items) {
		_this.find('#areaText').val(_getParam(items[0], 'text') + "-" + _getParam(items[1], 'text') + "-" + _getParam(items[2], 'text'))
		_this.find('#areaValue').val(_getParam(items[0], 'id') + "-" + _getParam(items[1], 'id') + "-" + _getParam(items[2], 'id'))
		console.log(_this.find('#areaValue').val())
	});
});
