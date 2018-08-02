/* 人身、财产险复选框选中的状态 */
$("#people_kexuanCheck").change(function (){
    flag_kexuan = flagkexuan();
});
$("#property_kexuanCheck").change(function (){
    flag_kexuan = flagkexuan();
});
/* 返回复选框的状态标示 */
function flagkexuan(){
    people_kexuan = document.getElementById("people_kexuanCheck").checked;        //人身险报案
    property_kexuan = document.getElementById("property_kexuanCheck").checked;   //财产险报案
    if(people_kexuan && property_kexuan){
        $("#people_report").css("display","block");
        $("#property_report").css("display","block");
        flag_kexuan = "TKAC";
        return flag_kexuan;
    }else if(people_kexuan){
        $("#people_report").css("display","block");
        $("#property_report").css("display","none");
        flag_kexuan = "TKC";
        return flag_kexuan;
    }else if(property_kexuan){
        $("#people_report").css("display","none");
        $("#property_report").css("display","block");
        flag_kexuan = "TKA";
        return flag_kexuan;
    }else{
        $("#people_report").css("display","none");
        $("#property_report").css("display","none");
        flag_kexuan = "0";
        return flag_kexuan;
    }
}

// 获取验证码
$("#getCode").click(function (){
    if(checkPolicyNo()){                //保单号不能为空的情况下，调取接口获取到手机号加密串
        get_code();
    }
});
function get_code(){
    alertbox("验证码已发送");
    codeCount();
}

function codeCount(){
    $("#getCode").addClass("disabled");
    $("#getCode").unbind("click");
    time($("#getCode"));
}
/*发送验证码倒计时*/
var wait = 60;
function time(This) {
    if (wait == 0) {
        This.removeClass("disabled");
        This.text("获取验证码");
        $("#getCode").click(function (){
            if(checkPolicyNo()){
				$("#property_code").val("");  //清空验证码
                get_code();                  //获取验证码接口
            }
        });
        wait = 60;
        codeFlag = 1;
    } else {
        This.text("重新发送(" + wait + ")");
        wait--;
        setTimeout(function() {
            time(This)
        }, 1000);
        codeFlag = 0;
    }
}




/*----------------------------出险人信息校验----------------------------*/
//出险人姓名校验
function checkName() {
    var initrate_name = localStorage.getItem("user_name");
    rateName = trim($("#ratename").val());
    rateName = rateName == initrate_name ? initrate_name : rateName;
    if(!(rateName == initrate_name)){                       //修改了姓名字段
        return isKong(rateName,0);
    }else{
        return true;
    }
}
//校验证件号
function checkCidNum(){
    cidNum = trim($("#cidnum").val());
    if(isDefine(cidNum)){
        alertbox("出险人证件号码不能为空");
        return false;
    }else if(checkidcard(cidNum)){
        alertbox("出险人证件号码无效，请重新输入");
        return false;
    }else{
        return true;
    }
}
//校验联系方式
function checkPhone(){
    var initrate_phone = localStorage.getItem("user_mobile");
    ratePhone = trim($("#phone").val());
    if(isDefine(ratePhone)){
        alertbox("出险人手机号码不能为空");
        return false;
    }else if(!(ratePhone == initrate_phone)){
        if(isDefine(ratePhone)){
            alertbox("出险人手机号码不能为空");
            return false;
        }else if(!tel_checked.test(ratePhone)){
            alertbox("出险人手机号码格式不正确");
            return false;
        }else{
            return true;
        }
    }else{
        return true;
    }
}



/* --------姓名校验--------- */
function isKong(controlObj,flag){
    //判断是否为空
    if (controlObj.length == 0 || controlObj == null || controlObj == undefined) {
        alertbox('姓名不能为空');
        return false;
    }
    //匹配全部是空格
    var t=/^\s+$/;
    if (t.test(controlObj)) {
        alertbox('姓名不能为空');
        return false;
    };
    //匹配输入特殊字符
    var pattern = new RegExp("[`+~!@#$^&*()=|{}':;\\['\\]<>/?~！@#￥……&*（）;—|\\\{}【】‘；：”“'？]");
    if(controlObj.match(pattern)!==null){
        alertbox('姓名格式不正确,且不得出现数字或特殊符号');
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
        alertbox('姓名格式不正确,不得出现连续特殊符号');
        return false;
    }
    //匹配数字
    var number = /^.*[0-9].*$/;
    if(number.test(controlObj) ){
        alertbox('姓名格式不正确,且不得出现数字或特殊符号');
        return false;
    }
    //匹配包含中文的
    var chinese = /^.*[\u4e00-\u9fa5].*$/;
    //chinese.test(controlObj);
    //匹配包含英文的
    var english = /^.*[a-zA-Z].*$/;
    //english.test(controlObj);
    if(chinese.test(controlObj) && english.test(controlObj)){
        alertbox('姓名格式不正确,且不得出现数字或特殊符号');
        return false;
    }
    //中文去除空格并替换为点
    if(chinese.test(controlObj)){
        //去除中文空格
        var controlObj=controlObj.replace(/\s/g, '');
        //匹配中文长度
        if(controlObj.length>25 || controlObj.length<2){
            alertbox('姓名长度不匹配');
            return false;
        }
        //匹配特殊字符开头结尾
        var reg = /^(_|-|●|·|。|\.|,|，|、|．).*|.*(_|-|●|·|。|\.|,|，|、|．)$/;
        if(reg.test(controlObj)){
            alertbox('姓名格式不正确,首尾不得出现特殊符号');
            return false;
        }
        //特殊字符进行转换
        var pattern = new RegExp("[。.,，、．]");
        if(controlObj.match(pattern)!==null){
            $('#confirm').attr('confirm',controlObj);
            if (window.confirm("您输入的姓名中含有非法字符,已将其转换为'·',请确定")){
                var controlObj=$('#confirm').attr('confirm');
                var a1=new Array("·","。",".","．",",","，","、");
                if(navigator.appName == "Microsoft Internet Explorer" && navigator.appVersion .split(";")[1].replace(/[ ]/g,"")=="MSIE7.0")
                {
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
                var controlObj=controlObj.replace(/(·)\1+/g,'$1');
                if(flag == 0){
                    $('#ratename').val(controlObj);
                }else if(flag == 1){
                    $('#otherName').val(controlObj);
                }
                //console.log("111===="+controlObj);
                return true;
            }else{
                alertbox('姓名格式不正确,且不得出现数字或特殊符号');
                return false;
            }
        }else{
            var controlObj=controlObj.replace(/(·)\1+/g,'$1');
            if(flag == 0){
                $('#ratename').val(controlObj);
            }else if(flag == 1){
                $('#otherName').val(controlObj);
            }
            //console.log("222===="+controlObj);
            return true;

        }
    }

    //英文去除空格并替换为点
    if(english.test(controlObj)){
        // 去除首尾空格
        var controlObj=controlObj.replace(/^\s+|\s+$/g,'');
        //英文空格仅保留一个
        var controlObj=controlObj.replace(/   */g,' ');
        //匹配英文长度
        if(controlObj.length>50 || controlObj.length<3){
            alertbox('姓名长度不匹配');
            return false;
        }
        //匹配特殊字符开头结尾
        var reg = /^(_|-|●|·|。|\.|,|，|、).*|.*(_|-|●|·|。|\.|,|，|、)$/;
        if(reg.test(controlObj)){
            alertbox('姓名格式不正确,首尾不得出现特殊符号');
            return false;
        }
        //特殊字符进行转换
        var pattern = new RegExp("[。.,，、．]");
        if(controlObj.match(pattern)!==null){
            $('#confirm').attr('confirm',controlObj);
            if (window.confirm("您输入的姓名中含有非法字符,已将其转换为'·',请确定")){
                var controlObj=$('#confirm').attr('confirm');
                var a1=new Array("·","。",".","．",",","，","、");
                if(navigator.appName == "Microsoft Internet Explorer" && navigator.appVersion .split(";")[1].replace(/[ ]/g,"")=="MSIE7.0")
                {
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
                var controlObj=controlObj.replace(/(·)\1+/g,'$1');
                if(flag == 0){
                    $('#ratename').val(controlObj);
                }else if(flag == 1){
                    $('#otherName').val(controlObj);
                }
                //console.log("333===="+controlObj);
                return true;
            }else{
                alertbox('姓名格式不正确,且不得出现数字或特殊符号');
                return false;
            }
        }else{
            var controlObj=controlObj.replace(/(·)\1+/g,'$1');
            if(flag == 0){
                $('#ratename').val(controlObj);
            }else if(flag == 1){
                $('#otherName').val(controlObj);
            }
            //console.log("444===="+controlObj);
            return true;
        }
    }

}


//保单号校验
function checkPolicyNo(){
    property_policyNo = trim($("#property_policyNo").val());   //保单号
    if(isDefine(property_policyNo)){
        alertbox("保单号不能为空");
        return false;
    }else if(property_policyNo.length > 50){
        alertbox("保单号最大长度为50位");
        return false;
    }else if(!num_checked.test(property_policyNo)){
        alertbox("保单号只支持数字格式");
        return false;
    }else{
        return true;
    }
}