$.extend($.validator.messages, {
    required: "不能为空",
    remote: "请修正该字段",
    email: "请输入正确格式的电子邮件",
    isPhone: "请输入一个有效的联系电话",
    url: "请输入合法的网址",
    date: "请输入合法的日期",
    dateISO: "请输入合法的日期 (ISO).",
    number: "请输入合法的数字",
    digits: "只能输入整数",
    isIdCardNo: "请输入正确的身份证号",
    creditcard: "请输入合法的信用卡号",
    passport: "请输入正确的护照编号",
    equalTo: "请再次输入相同的值",
    accept: "请输入拥有合法后缀名的字符串",
    stringCheck: "只能包括中文、英文、数字和下划线",
    maxlength: $.validator.format("请输入一个长度最多是 {0} 的字符串"),
    minlength: $.validator.format("请输入一个长度最少是 {0} 的字符串"),
    rangelength: $.validator.format("请输入一个长度介于 {0} 和 {1} 之间的字符串"),
    range: $.validator.format("请输入一个介于 {0} 和 {1} 之间的值"),
    max: $.validator.format("请输入一个最大为 {0} 的值"),
    min: $.validator.format("请输入一个最小为 {0} 的值"),
});

var errorMessages = {
	namelength: "姓名必须在3-50个字符之间"
}



var idCardNoUtil = {
	provinceAndCitys: {11:"北京",12:"天津",13:"河北",14:"山西",15:"内蒙古",21:"辽宁",22:"吉林",23:"黑龙江",
	31:"上海",32:"江苏",33:"浙江",34:"安徽",35:"福建",36:"江西",37:"山东",41:"河南",42:"湖北",43:"湖南",44:"广东",
	45:"广西",46:"海南",50:"重庆",51:"四川",52:"贵州",53:"云南",54:"西藏",61:"陕西",62:"甘肃",63:"青海",64:"宁夏",
	65:"新疆",71:"台湾",81:"香港",82:"澳门",91:"国外"},

	powers: ["7","9","10","5","8","4","2","1","6","3","7","9","10","5","8","4","2"],

	parityBit: ["1","0","X","9","8","7","6","5","4","3","2"],

	genders: {male:"男",female:"女"},

	checkAddressCode: function(addressCode){
		var check = /^[1-9]\d{5}$/.test(addressCode);
		if(!check) return false;
		if(idCardNoUtil.provinceAndCitys[parseInt(addressCode.substring(0,2))]){
		return true;
		}else{
		return false;
		}
	},

	checkBirthDayCode: function(birDayCode){
		var check = /^[1-9]\d{3}((0[1-9])|(1[0-2]))((0[1-9])|([1-2][0-9])|(3[0-1]))$/.test(birDayCode);
		if(!check) return false;
		var yyyy = parseInt(birDayCode.substring(0,4),10);
		var mm = parseInt(birDayCode.substring(4,6),10);
		var dd = parseInt(birDayCode.substring(6),10);
		var xdata = new Date(yyyy,mm-1,dd);
		if(xdata > new Date()){
			return false;//生日不能大于当前日期
		}else if ( ( xdata.getFullYear() == yyyy ) && ( xdata.getMonth () == mm - 1 ) && ( xdata.getDate() == dd ) ){
			return true;
		}else{
			return false;
		}
	},

	getParityBit: function(idCardNo){
		var id17 = idCardNo.substring(0,17);
		var power = 0;
		for(var i=0;i<17;i++){
			power += parseInt(id17.charAt(i),10) * parseInt(idCardNoUtil.powers[i]);
		}
		var mod = power % 11;
		return idCardNoUtil.parityBit[mod];
	},

	checkParityBit: function(idCardNo){
		var parityBit = idCardNo.charAt(17).toUpperCase();
		if(idCardNoUtil.getParityBit(idCardNo) == parityBit){
			return true;
		}else{
			return false;
		}
	},

	checkIdCardNo: function(idCardNo){
		//15位和18位身份证号码的基本校验
		var check = /^\d{15}|(\d{17}(\d|x|X))$/.test(idCardNo);
		if(!check) return false;
		//判断长度为15位或18位
		if(idCardNo.length==15){
			return idCardNoUtil.check15IdCardNo(idCardNo);
		}else if(idCardNo.length==18){
			return idCardNoUtil.check18IdCardNo(idCardNo);
		}else{
			return false;
		}
	},
	//校验15位的身份证号码
	check15IdCardNo: function(idCardNo){
		//15位身份证号码的基本校验
		var check = /^[1-9]\d{7}((0[1-9])|(1[0-2]))((0[1-9])|([1-2][0-9])|(3[0-1]))\d{3}$/.test(idCardNo);
		if(!check) return false;
		//校验地址码
		var addressCode = idCardNo.substring(0,6);
		check = idCardNoUtil.checkAddressCode(addressCode);
		if(!check) return false;
		var birDayCode = '19' + idCardNo.substring(6,12);
		//校验日期码
		return idCardNoUtil.checkBirthDayCode(birDayCode);
	},
	//校验18位的身份证号码
	check18IdCardNo: function(idCardNo){
		//18位身份证号码的基本格式校验
		var check = /^[1-9]\d{5}[1-9]\d{3}((0[1-9])|(1[0-2]))((0[1-9])|([1-2][0-9])|(3[0-1]))\d{3}(\d|x|X)$/.test(idCardNo);
		if(!check) return false;
		//校验地址码
		var addressCode = idCardNo.substring(0,6);
		check = idCardNoUtil.checkAddressCode(addressCode);
		if(!check) return false;
		//校验日期码
		var birDayCode = idCardNo.substring(6,14);
		check = idCardNoUtil.checkBirthDayCode(birDayCode);
		if(!check) return false;
		//验证校检码
		return idCardNoUtil.checkParityBit(idCardNo);
	},
	formateDateCN: function(day){
	var yyyy =day.substring(0,4);
	var mm = day.substring(4,6);
	var dd = day.substring(6);
	return yyyy + '-' + mm +'-' + dd;
	},
	//获取信息
	getIdCardInfo: function(idCardNo){
		var idCardInfo = {
			gender:"", //性别
			birthday:"" // 出生日期(yyyy-mm-dd)
		};
		if(idCardNo.length==15){
		var aday = '19' + idCardNo.substring(6,12);
		idCardInfo.birthday=idCardNoUtil.formateDateCN(aday);
		if(parseInt(idCardNo.charAt(14))%2==0){
			idCardInfo.gender=idCardNoUtil.genders.female;
		}else{
			idCardInfo.gender=idCardNoUtil.genders.male;
		}
		}else if(idCardNo.length==18){
			var aday = idCardNo.substring(6,14);
			idCardInfo.birthday=idCardNoUtil.formateDateCN(aday);
		if(parseInt(idCardNo.charAt(16))%2==0){
			idCardInfo.gender=idCardNoUtil.genders.female;
		}else{
			idCardInfo.gender=idCardNoUtil.genders.male;
		}
	}
	return idCardInfo;
	},

	getId15:function(idCardNo){
		if(idCardNo.length==15){
			return idCardNo;
		}else if(idCardNo.length==18){
			return idCardNo.substring(0,6) + idCardNo.substring(8,17);
		}else{
			return null;
		}
	},

	getId18: function(idCardNo){
		if(idCardNo.length==15){
			var id17 = idCardNo.substring(0,6) + '19' + idCardNo.substring(6);
			var parityBit = idCardNoUtil.getParityBit(id17);
			return id17 + parityBit;
		}else if(idCardNo.length==18){
			return idCardNo;
		}else{
			return null;
		}
	}
};

//验证护照是否正确
function checknumber(number){
	var str=number;
	var Expression=/(P\d{7})|(G\d{8})/;
	var objExp=new RegExp(Expression);
	if(objExp.test(str)==true){
	   return true;
	}else{
	   return false;
	} 
};

// SQL防注入
function checksql(value){
	var Expression=/select|update|delete|exec|count|'|"|=|;|>|<|%/i;
	var objExp=new RegExp(Expression);
	if(objExp.test(value)==true){
	   return false;
	}else{
	   return true;
	} 
};



/*******validator验证方法*********/

// SQL
jQuery.validator.addMethod("sqlCheck", function(value, element) {
	return this.optional(element) || checksql(value);
}, "不能包含非法字符");

// 社会统一信用代码
jQuery.validator.addMethod("creditCheck", function(value, element) {
	return this.optional(element) || /[A-Z0-9]{18}/g.test(value);
}, "请输入正确格式的信用代码");

// 组织机构代码
jQuery.validator.addMethod("organizationCheck", function(value, element) {
	return this.optional(element) || /[a-zA-Z0-9]{8}-[a-zA-Z0-9]/g.test(value);
}, "请输入正确格式的组织机构代码");

// 营业执照编号
jQuery.validator.addMethod("licenseCheck", function(value, element) { 
	return this.optional(element) || /^[A-Z0-9]{15}$/g.test(value) || /^[A-Z0-9]{18}$/g.test(value);
}, "请输入正确格式的营业执照编号"); 







// 字符验证
jQuery.validator.addMethod("stringCheck", function(value, element) {
	return this.optional(element) || /^[\u0391-\uFFE5\w]+$/.test(value);
});

// 非汉字验证
jQuery.validator.addMethod("notStringCheck", function(value, element) {
	return this.optional(element) || /^[\w\s]+$/.test(value);
}, "不能包含中文");


// 中文字两个字节
jQuery.validator.addMethod("byteRangeLength", function(value, element, param) {
	var length = value.length;
	for(var i = 0; i < value.length; i++){
		if(value.charCodeAt(i) > 127){
			length++;
		}
	}
	return this.optional(element) || ( length >= param[0] && length <= param[1] );
}, "请确保输入的值在3-15个字节之间(一个中文字算2个字节)");


// 身份证号码验证
jQuery.validator.addMethod("isIdCardNo", function(value, element) { 
	return this.optional(element) || idCardNoUtil.checkIdCardNo(value);     
}, "请正确输入您的身份证号码");



//护照编号验证
jQuery.validator.addMethod("passport", function(value, element) { 
	return this.optional(element) || checknumber(value);     
}, "请正确输入您的护照编号"); 


// 手机号码验证 
jQuery.validator.addMethod("isMobile", function(value, element) { 
	var length = value.length; 
	var mobile = /^1[34578]\d{9}$/; 
	return this.optional(element) || (length == 11 && mobile.test(value)); 
}, "请正确填写您的手机号码"); 

// 电话号码验证 
jQuery.validator.addMethod("isTel", function(value, element) { 
	var tel = /^\d{3,4}-?\d{7,9}$/; //电话号码格式010-12345678 
	return this.optional(element) || (tel.test(value)); 
}, "请正确填写您的电话号码"); 

// 联系电话(手机/电话皆可)验证 
jQuery.validator.addMethod("isPhone", function(value,element) { 
	var length = value.length; 
	var mobile = /^1[34578]\d{9}$/; 
	var tel = /^\d{3,4}-?\d{7,9}$/; 
	return this.optional(element) || (tel.test(value) || mobile.test(value)); 
}, "请正确填写您的联系电话"); 

// 邮政编码验证 
jQuery.validator.addMethod("isZipCode", function(value, element) { 
	var tel = /^[0-9]{6}$/; 
	return this.optional(element) || (tel.test(value)); 
}, "请正确填写您的邮政编码");







/* --------姓名校验--------- */
function isRealName(ele){
   	var controlObj = ele.val();
    
    //匹配全部是空格
    var t=/^\s+$/;
    if (t.test(controlObj)) {
        Mask.alert('姓名不能为空');
        return false;
    };
    //匹配输入特殊字符
    var pattern = new RegExp("[`+~!@#$^&*()=|{}':;\\['\\]<>/?~！@#￥……&*（）;—|\\\{}【】‘；：”“'？]");
    if(controlObj.match(pattern)!==null){
        Mask.alert('姓名格式不正确,且不得出现数字或特殊符号');
        return false;
    }
    //匹配输入的都是允许输入标点符号
    var dianstr1=/^(·+)$/;
    var dianstr2=/^(。+)$/;
    var dianstr3=/^(\.+)$/;
    var dianstr4=/^(,+)$/;
    var dianstr5=/^(，+)$/;
    var dianstr6=/^(、+)$/;
    var dianstr7=/^(-+)$/;
    var dianstr8=/^(_+)$/;
    var dianstr9=/^(●+)$/;
    var dianstr10=/^(\．+)$/;
    if(dianstr1.test(controlObj)||dianstr2.test(controlObj)||dianstr3.test(controlObj)||dianstr4.test(controlObj)||dianstr5.test(controlObj)||dianstr6.test(controlObj)||dianstr7.test(controlObj)||dianstr8.test(controlObj)||dianstr9.test(controlObj)||dianstr10.test(controlObj)){
        Mask.alert('姓名格式不正确,不得出现连续特殊符号');
        return false;
    }
    //匹配数字
    var number = /^.*[0-9].*$/;
    if(number.test(controlObj) ){
        Mask.alert('姓名格式不正确,且不得出现数字或特殊符号');
        return false;
    }
    //匹配包含中文的
    var chinese = /^.*[\u4e00-\u9fa5].*$/;
    //匹配包含英文的
    var english = /^.*[a-zA-Z].*$/;
    if(chinese.test(controlObj) && english.test(controlObj)){
        Mask.alert('姓名不可中英混输,且不得出现数字或特殊符号');
        return false;
    }
    //中文去除空格并替换为点
    if(chinese.test(controlObj)){
        //去除中文空格
        var controlObj=controlObj.replace(/\s/g, '');
       	ele.val(controlObj);
        
        //匹配中文长度
        if(controlObj.length>25 || controlObj.length<2){
            Mask.alert('姓名长度不匹配');
            return false;
        }
        return specialCharsShift(ele);
    }

    //英文去除空格并替换为点
    if(english.test(controlObj)){
        // 去除首尾空格
        var controlObj=controlObj.replace(/^\s+|\s+$/g,'');
        ele.val(controlObj);
        //英文空格仅保留一个
        var controlObj=controlObj.replace(/   */g,' ');
        ele.val(controlObj);
        //匹配英文长度
        if(controlObj.length>50 || controlObj.length<3){
            Mask.alert('姓名长度不匹配');
            return false;
        }
        return specialCharsShift(ele);
    }
}

// 特殊字符转换
function specialCharsShift(ele){
	var controlObj = ele.val();
	//匹配特殊字符开头结尾
    var reg = /^(_|-|●|·|。|\.|,|，|、|．).*|.*(_|-|●|·|。|\.|,|，|、|．)$/;
    if(reg.test(controlObj)){
        Mask.Mask.alert('姓名格式不正确,首尾不得出现特殊符号');
        return false;
    }
    //特殊字符进行转换
    var pattern = new RegExp("[。.,，、．]");
    if(controlObj.match(pattern)!==null){
    	Mask.confirm("您输入的姓名中含有非法字符,已将其转换为'·'",function(){},function(){
			
    		var a1=new Array("·","。",".","．",",","，","、");
            if(navigator.appName == "Microsoft Internet Explorer" && navigator.appVersion .split(";")[1].replace(/[ ]/g,"")=="MSIE7.0"){
                for(var i=0;i<a1.length;i++){
                    for(var j=0; j<controlObj.length; j++){
                        if(controlObj.charAt(j)==a1[i]){
                            controlObj=controlObj.replace(controlObj.charAt(j),'·');
                        }
                    }
                }
            }else{
                for(var i=0;i<a1.length;i++){
                    for(var j=0; j<controlObj.length; j++){
                        if(controlObj[j]==a1[i]){
                            controlObj=controlObj.replace(controlObj[j],'·');
                        }
                    }
                }
            }
            //去掉多余的连续的·
            controlObj=controlObj.replace(/(·)\1+/g,'$1');
            ele.val(controlObj);
            return true;
    	});
    	return false;
    }else{
        var controlObj=controlObj.replace(/(·)\1+/g,'$1');
        ele.val(controlObj);
        return true;
    }
}
