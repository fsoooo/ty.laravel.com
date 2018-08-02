var guaranteeTime, selfStatus = true;
var Util = {
	getAge: function(UserCard){
		var myDate = new Date();
		var month = myDate.getMonth() + 1;
		var day = myDate.getDate();
		var age = myDate.getFullYear() - UserCard.substring(6, 10) - 1;
		if (UserCard.substring(10, 12) < month || UserCard.substring(10, 12) == month && UserCard.substring(12, 14) <= day) {age++;}
		return age;
	},
	getBirth: function(UserCard){
		var birth = UserCard.substring(6,14);
		birth = birth.substring(0, 4) + "-" + birth.substring(4, 6) + "-" + birth.substring(6)
		return birth;
	},
	getSex: function(UserCard){
		var sex;
		parseInt(UserCard.substr(16, 1)) % 2 == 1 ? sex = 1 : sex = 0; // 男：1 女：0
		return sex;
	}
}
mui('.mui-scroll-wrapper').scroll({
	deceleration: 0.0005,
	indicators: true
});
$('.switchone').parent().nextAll().hide();
$('.name').each(function(){
    var length = $(this).text().length;
    if(length>6){
        $(this).css({'word-break': 'break-all','line-height': '1.8'});
    }
});
// 判断是否认证 true:已认证
var certificationStatus = false;
if(certificationStatus) {
	$('.approve').hide();
	$('.mui-title').text('被保人');
}


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
        var text = items[0].text;
        if(text=="本人"){
            $('#ty_beibaoren_name').val($('#ty_toubaoren_name').val());
            $('#ty_beibaoren_phone').val($('#ty_toubaoren_phone').val());
            $('#ty_beibaoren_id_number').val($('#ty_toubaoren_id_number').val());
		}
        if(_this.find('#certificatetype1').length) {
            $("#certificateimg1").click();
        }
        if(_this.find('#certificatetype2').length) {
            $("#certificateimg2").click();
        }
    });
});

var ty_beibaoren_name = $('#ty_beibaoren_name'),
	ty_toubaoren_name = $('#ty_toubaoren_name'),
	
	ty_toubaoren_id_type = $('input[name="insurance_attributes[ty_toubaoren][ty_toubaoren_id_type]"]'),
	ty_beibaoren_id_type = $('input[name="insurance_attributes[ty_beibaoren][0][ty_beibaoren_id_type]"]'),
	
	ty_toubaoren_id_number = $('#ty_toubaoren_id_number'),
	ty_beibaoren_id_number = $('#ty_beibaoren_id_number'),
	
	ty_toubaoren_sex = $('input[name="insurance_attributes[ty_toubaoren][ty_toubaoren_sex]"]'),
	ty_beibaoren_sex = $('input[name="insurance_attributes[ty_beibaoren][0][ty_beibaoren_sex]"]'),
	
	ty_toubaoren_birthday = $('input[name="insurance_attributes[ty_toubaoren][ty_toubaoren_birthday]"]'),
	ty_beibaoren_birthday = $('input[name="insurance_attributes[ty_beibaoren][0][ty_beibaoren_birthday]"]'),
	
	ty_toubaoren_phone = $('#ty_toubaoren_phone'),
	ty_beibaoren_phone = $('#ty_beibaoren_phone'),
	
	ty_toubaoren_email = $('#ty_toubaoren_email'),
	ty_beibaoren_email = $('#ty_beibaoren_email'),
	
	ty_toubaoren_area = $('input[name="insurance_attributes[ty_toubaoren][ty_toubaoren_area]"]'),
	ty_beibaoren_area =  $('input[name="insurance_attributes[ty_beibaoren][0][ty_beibaoren_area]"]'),
	
	ty_toubaoren_job = $('input[name="insurance_attributes[ty_toubaoren][ty_toubaoren_job]"]'),
	ty_beibaoren_job = $('input[name="insurance_attributes[ty_beibaoren][0][ty_beibaoren_job]"]'),
	
	ty_toubaoren_address = $('#ty_toubaoren_address'),
	ty_beibaoren_address = $('#ty_beibaoren_address'),
	ty_relation = $('input[name="insurance_attributes[ty_beibaoren][0][ty_relation]"]');

var applicant = {
	init: function(){
		var _this = this;
		ty_relation.val() == '1' ? _this.selfHide() : _this.selfShow();
		_this.certificate();
		_this.isSelf();
		if(ty_toubaoren_id_type.val() == '1'){ // 投保人身份证
			ty_toubaoren_sex.parent().hide();
			ty_toubaoren_birthday.parent().hide();
		}
		if(ty_beibaoren_id_type.val() == '1'){ // 被保人身份证
			ty_beibaoren_sex.parent().hide();
			ty_beibaoren_birthday.parent().hide();
		}
	},
	certificate: function(){
		$('input[name="insurance_attributes[ty_toubaoren][ty_toubaoren_id_type]"],input[name="insurance_attributes[ty_beibaoren][0][ty_beibaoren_id_type]"]').parent().on('tap', function(e) {
			var _this = $(this);
		    var jsonData = _this.attr('data-options');
		    userPicker.setData(changeJsonData(jsonData));
		    userPicker.show(function(items) {
		        _this.find('input:text').val(items[0].text);
		        _this.find('.inputhidden').val(items[0].id);
		        var text = items[0].text;
		        if(text=="身份证"){
					_this.next().next().hide().next().hide();
				}else{
					_this.next().next().show().next().show();
				}
		    });
		});
		ty_toubaoren_id_number.blur(function(){
			if(!$(this).val()){return;}
			var msg = $(this).attr('msg'),
				reg = eval('/'+$(this).attr('regex')+'/');
			var idCard = $(this).val();
			if(reg && !reg.test(idCard)){return;}
			if(ty_toubaoren_id_type.val() == '1'){
				var sex = Util.getSex(idCard);
					birth = Util.getBirth(idCard);
				ty_toubaoren_sex.val(sex);
				ty_toubaoren_birthday.val(birth);
			}
		});
		ty_beibaoren_id_number.blur(function(){
			if(!$(this).val()){return;}
			var msg = $(this).attr('msg'),
				reg = eval('/'+$(this).attr('regex')+'/');
			var idCard = $(this).val();
			if(reg && !reg.test(idCard)){return;}
			if(ty_beibaoren_id_type.val() == '1'){
				var sex = Util.getSex(idCard);
					birth = Util.getBirth(idCard);
				ty_beibaoren_sex.val(sex);
				ty_beibaoren_birthday.val(birth);
			}
		});
	},
	relation: function(){ // 判断关系
		var _this = this;
		var toubaoren_id =  $('#ty_toubaoren_id_number'),
			relation =  $('input[name="insurance_attributes[ty_beibaoren][0][ty_relation]"]').val(),
			beibaoren_id =  $('#ty_beibaoren_id_number'),
			sex1 = Util.getSex(toubaoren_id.val()),
			sex2 = Util.getSex(beibaoren_id.val()),
			age1 = Util.getAge(toubaoren_id.val()),
			age2 = Util.getAge(beibaoren_id.val());
		if(age1<18){
			Mask.alert('投保人须年满18周岁',2);
			return false;
		}
		if(relation == '2'||relation == '3'||relation == '19'){
			if(sex1 == sex2){
				Mask.alert('配偶性别不可相同',2);
				return false;
			}
		}
		if(relation == '4'||relation == '5'||relation == '20'){
			if(age1-age2 < 18){
				Mask.alert('父母与子女年龄差不可小于18岁',2);
				return false;
			}
		}
		if(relation == '6'||relation == '7'||relation == '18'){
			if(age2-age1 < 18){
				Mask.alert('父母与子女年龄差不可小于18岁',2);
				return false;
			}
		}
		return true;
	},
	selfVal: function(){
		if(ty_toubaoren_name.length){
			ty_beibaoren_name.val(ty_toubaoren_name.val());
		}
		if(ty_toubaoren_id_type.length){
			ty_beibaoren_id_type.val(ty_toubaoren_id_type.val());
		}
		if(ty_toubaoren_id_number.length){
			ty_beibaoren_id_number.val(ty_toubaoren_id_number.val());
		}
		if(ty_toubaoren_sex.length){
			ty_beibaoren_sex.val(ty_toubaoren_sex.val());
		}
		if(ty_toubaoren_birthday.length){
			ty_beibaoren_birthday.val(ty_toubaoren_birthday.val());
		}
		if(ty_toubaoren_phone.length){
			ty_beibaoren_phone.val(ty_toubaoren_phone.val());
		}
    	if(ty_toubaoren_email.length){
			ty_beibaoren_email.val(ty_toubaoren_email.val());
		}
		if(ty_toubaoren_area.length){
			ty_beibaoren_area.val(ty_toubaoren_area.val());
		}
		if(ty_toubaoren_job.length){
			ty_beibaoren_job.val(ty_toubaoren_job.val());
		}
		if(ty_toubaoren_address.length){
			ty_beibaoren_address.val(ty_toubaoren_address.val());
		}
	},
	isSelf: function(){
		var _this = this;
		$('input[name="insurance_attributes[ty_beibaoren][0][ty_relation]"]').parent().on('tap', function(e) {
			var _that = $(this);
		    var jsonData = _that.attr('data-options');
		    userPicker.setData(changeJsonData(jsonData));
		    userPicker.show(function(items) {
		        _that.find('input:text').val(items[0].text);
		        _that.find('.inputhidden').val(items[0].id);
		        var text = items[0].text;
		        if(text=="本人"){
		        	_this.selfHide();
				}else{
					_this.selfShow();
				}
		    });
		});
	},
	selfHide: function(){
		if(ty_toubaoren_name.length){
			ty_beibaoren_name.parent().hide();
		}
		if(ty_toubaoren_id_type.length){
			ty_beibaoren_id_type.parent().hide();
		}
		if(ty_toubaoren_id_number.length){
			ty_beibaoren_id_number.parent().hide();
		}
		if(ty_toubaoren_sex.length){
			ty_beibaoren_sex.parent().hide();
		}
    	if(ty_toubaoren_birthday.length){
			ty_beibaoren_birthday.parent().hide();
		}
		if(ty_toubaoren_phone.length){
			ty_beibaoren_phone.parent().hide();
		}
		if(ty_toubaoren_email.length){
			ty_beibaoren_email.parent().hide();
		}
		if(ty_toubaoren_area.length){
			ty_beibaoren_area.parent().hide();
		}
    	if(ty_toubaoren_job.length){
			ty_beibaoren_job.parent().hide();
		}
    	if(ty_toubaoren_address.length){
			ty_beibaoren_address.parent().hide();
		}
	},
	selfShow: function(){
		ty_beibaoren_name.parent().show();
    	ty_beibaoren_id_type.parent().show();
    	ty_beibaoren_id_number.parent().show();
    	ty_beibaoren_sex.parent().show();
    	ty_beibaoren_birthday.parent().show();
    	ty_beibaoren_phone.parent().show();
    	ty_beibaoren_email.parent().show();
    	ty_beibaoren_area.parent().show();
    	ty_beibaoren_job.parent().show();
    	ty_beibaoren_address.parent().show();
	},
	canSubmit: function(){
		var _this = this;
		return _this.relation();
	}
}
applicant.init();
function form_check() {
	if($('input[name="insurance_attributes[ty_beibaoren][0][ty_relation]"]').val() == '1'){
		applicant.selfVal();
	}
	
    $('.w320').each(function (index) {
        var insure_value  = $(this).val();
        if(!insure_value||insure_value.length<1){
            Mask.alert("请正确输入投保信息",2);
            return false;
        }
        if(index == $('.w320').length-1){
        	if(applicant.canSubmit()){
        		$(form).submit();
        	}
        }
    });
    return false;
}

$('.pickerfour').on('tap', function() {
	var _this = $(this);
	var picker = new mui.DtPicker({
		"type": "date","beginYear": 1900
	});
	picker.show(function(rs) {
		_this.find('input').val(rs.text);
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

var jsonData = $('.pickerarea').attr('data-options');
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
        _this.find('.areaValue').val(_getParam(items[0], 'id') + "-" + _getParam(items[1], 'id') + "-" + _getParam(items[2], 'id'))
        console.log(_this.find('.areaValue').val())
    });
});
