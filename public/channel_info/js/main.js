//开发接口
var bindUrl = location.origin+"/service/weixinbind/identityBinding.html";    //绑定会员地址
var serverUrl = location.origin+"/claimService/";
var imageurl = "http://m.tk.cn/service/generalInsuClaim/";    //图片地址
var openid = localStorage.getItem("open_id");
var upflag = "0";
/*打开loading图*/
function openLoading() {
    str = '<div class="openLoading"><div class="loading"><img src="'+imageurl+'images/loading.gif" /></div></div>'
    $("body").append(str);
    $(".openLoading").css({
        "height" : "100%",
        "width" : "100%",
        "background" : "rgba(50,50,50,0.5)",
        "position" : "fixed",
        "top" : "0",
        "left" : "0",
        "z-index" : "9999"
    });
    $(".openLoading .loading").css({
        "width" : "5em",
        "height" : "5em",
        "position" : "fixed",
        "top" : "50%",
        "left" : "50%",
        "margin-top" : "-2.5em",
        "margin-left" : " -2.5em"
    });
    $(".loading img").css({
        "height" : "5em",
        "width" : "5em"
    });
}

/*关闭loading图*/
function closeLoading() {
    $(".openLoading").remove();
}

function showGuide(){
    $(".guideIndexShow").hide();
    $(".guideIndex").show(200);
    $(".addIconWrap").css("z-index","999");
}
function closeGuide(){
    $(".guideIndex").hide();
    $(".guideIndexShow").show(200);
    setTimeout(function(){
       $(".addIconWrap").css("z-index","0"); 
    },200)
}

/* 提交失败、成功的弹窗 */
function alertWin(title,alertMess){
    $('#alertwin').remove();
    var str = '';
    str = '<div class="coverBg2" id="alertwin">'+
                '<div class="bomb-box" id="alert_section">'+
                    '<div class="bomb-txt">'+
                        '<h4>'+title+'</h4>'+
                            '<p class=" ulev1 t-73 tx-l">'+alertMess+'</p>'+
                    '</div>'+
                    '<div class="btnW">'+
                        '<div class="btnC" id="insureWin">确定</div>'+
                    '</div>'+
                '</div>'+
            '</div>';
    $('body').append(str);
    //关闭弹窗
    $('#insureWin').click(function() {
        $('#alertwin').remove();
    });
}

/* 确定 取消的弹窗 */
function alertConfirm(title,alertMess){
    $('#alertConfirm').remove();
    var str = '';
    str = '<div class="coverBg2" id="alertConfirm">'+
            '<div class="bomb-box">'+
                '<div class="bomb-txt">'+
                    '<h4>'+title+'</h4>'+
                    '<p class=" ulev1 t-73 tx-l">'+alertMess+'</p>'+
                '</div>'+
                '<div class="btnW">'+
                    '<div class="btnL" id="cancle">取消</div>'+
                    '<div class="btnR" id="insured">确定</div>'+
                '</div> '+   
            '</div>'+
        '</div>'
    $('body').append(str);
    //确定 关闭弹窗
    $('#insure').click(function() {
        $('#alertConfirm').remove();
    });
    //取消 关闭弹窗
    $('#cancle').click(function() {
        $('#alertConfirm').remove();
    });
}

/* 黑色弹窗 */
function alertbox(alertMessage) {
    $('#alert_mask').remove();
    var str = '';
    str = '<div class="k_mask" id="alert_mask">' + '<section class="alert_section" id="alert_section">' + '<div class="alert_content">' + '<p>' + alertMessage + '</p>' + '</div></section></div>';
    $('body').append(str);

    middleBox(document.getElementById('alert_section'));
    setTimeout(function() {
        $('#alert_mask').remove();
    }, 1500)
}
/*弹窗=刷新*/
function refreshBox () {
    var refreshStr = '<div class="coverBg2 j-errorBg" style="display:block" id="refresh"><div class="errorTipWrap j-errorWrap paddingTB3" style="margin-top: -8rem;"><img src="../images/close2.png" class="iconClose j-iconClose" style="width:1rem;top:0.8rem;" >             <div class="j-errorTipTitleWrap"><div class="tx-c margin-t"> <img src="../images/WiFi.png" style="width:3rem;"></div><p class="ulev2 t-73 margin-tb">刷新一下，马上就好</p><p class="ulev2 t-blue tx-c borderAll refresh" onclick="location.reload();">刷新</p></div></div></div>'
    $("body").append(refreshStr);
    $(".j-iconClose").click(function(){
        $("#refresh").remove();  
    })
}

/*弹窗=确定*/
function alertInsureBox(alertMessage) {
    $('#alert_mask').remove();
    var str = '';
    str = '<div class="k_mask1" id="alert_mask1">' + '<section class="alert_section1" id="alert_section1">' + '<div class="alert_content1">' + '<p>' + alertMessage + '</p>' + '<div class="sure j-sure">确定</div></div>' + '</section>' + '</div>';
    $('body').append(str);

    middleBox(document.getElementById('alert_section1'));
    //关闭弹窗
    $('.j-sure').click(function() {
        $('#alert_mask1').remove();
    });
}

/*补充资料弹窗=2秒内返回查询主页*/
function alertDataBox(alertMessage) {
    $('#alert_mask').remove();
    var str = '';
    str = '<div class="k_mask1" id="alert_mask1">' + '<section class="alert_section1" id="alert_section1" style="width: 68%;height:8rem;">' + '<div class="alert_content1" >' + '<p style="padding: 1.6rem 1rem 1.6rem 1rem; color: #000;font-style: inherit;font-size: 1rem; border-bottom: none;">' + alertMessage + '</p>' + '<div class="sure j-sure" style="color: #666;">2秒内返回主页</div></div>' + '</section>' + '</div>';
    $('body').append(str);

    middleBox(document.getElementById('alert_section1'));
    //2秒之内关闭弹窗，并跳转至查询首页
    setTimeout(function(){
       $('#alert_mask1').remove();
        location.href="lipeiProgress.html";
    },1500)
}
/*不可重复申请弹窗=2秒内返回主页*/
function alertIndexBox(alertMessage) {
    $('#alert_mask').remove();
    var str = '';
    str = '<div class="k_mask1" id="alert_mask1">' + '<section class="alert_section1" id="alert_section1" style="width: 68%;height:8rem;">' + '<div class="alert_content1" >' + '<p style="padding: 1.6rem 1rem 1.6rem 1rem; color: #000;font-style: inherit;font-size: 1rem; border-bottom: none;">' + alertMessage + '</p>' + '<div class="sure j-sure" style="color: #666;">2秒内返回主页</div></div>' + '</section>' + '</div>';
    $('body').append(str);

    middleBox(document.getElementById('alert_section1'));
    //2秒之内关闭弹窗，并跳转至查询首页
    setTimeout(function(){
        $('#alert_mask1').remove();
        location.href="index.html?openid="+openid;
    },1500)

}
function middleBox(oBox) {
    var scrollTop = document.documentElement.scrollTop || document.body.scrollTop;
    var scrollLeft = document.documentElement.scrollLeft || document.body.scrollLeft;
    oBox.style.left = (document.documentElement.clientWidth - oBox.offsetWidth ) / 2 + 'px';
    oBox.style.top = (document.documentElement.clientHeight - oBox.offsetHeight - 90 ) / 2 + 'px';
}

/*打开上传失败弹窗*/
function openFailTOUpload() {
    str = '<div class="bg-all openFailUpload"><div class="coverBg2 j-errorBg" style="display:block"><div class="errorTipWrap j-errorWrap" style="margin-top:-4rem;"><img src="'+imageurl+'images/icon-close.png" class="iconClose j-iconClose" onclick="closeFailTOUpload();"><div class="j-errorTipTitleWrap"><div class="notice tx-c">提示</div><p class="ulev1 t-6 margin-tb paddingTB">图像上传失败，请重新上传。建议在WiFi环境下操作。</p></div></div></div></div>'
    $("body").append(str);
}

/*关闭上传失败弹窗*/
function closeFailTOUpload() {
    $(".openFailUpload").remove();
}

/*初始化编辑大图片的点击功能*/
function clickBigPicture() {
    $("body").on("touchend","#bigPicture",function() {
        ondblclickStart();
    });
}

/*显示编辑大图片弹窗*/
function openBigPicture(localSrc, serverId,type) {
    picStr = '<div class="bg-all1 ub ub-pc ub-ac" id="openEditPicture"><img src="' + localSrc + '" name="' + serverId + '" id="bigPicture" style="padding-top: 3rem;"><div class="fix-top"><img src="'+imageurl+'images/delete.png" class="delete"><img src="'+imageurl+'images/arrow-left.png" class="back-pic" onclick="closeBigPicture();"></div></div>';
    $(".uploadingBlock").css("display","none");
    //$("header").css("display","none");
    $("body").append(picStr);
    $("body").css("padding-top","0rem");
    $("#bigPicture").css("width", $("body").width());
    $(".bg-all1").height($(window).height());
    $("#tit_viewport").attr("content","width=device-width, initial-scale=1.0, user-scalable=yes, minimum-scale=1.0, maximum-scale=5.0");
    $(".delete").on("click", function() {
        delPicture(localSrc, serverId, type);
    });
}

/*显示编辑大图片弹窗- 案例，没有删除图标 */
function openBigPictureAnli(localSrc) {
    picStr = '<div class="bg-all1 ub ub-pc ub-ac" id="openEditPicture"><img src="' + localSrc + '" id="bigPicture" style="padding-top: 3rem;"><div class="fix-top"><img src="'+imageurl+'images/arrow-left.png" class="back-pic" onclick="closeBigPicture();"></div></div>';
    $(".uploadingBlock").css("display","none");
    $("header").css("display","none");
    $("body").append(picStr);
    $("#bigPicture").css("width", $("body").width());
    $(".bg-all1").height($(window).height());
    $("#tit_viewport").attr("content","width=device-width, initial-scale=1.0, user-scalable=yes, minimum-scale=1.0, maximum-scale=5.0");
}
/*关闭显示编辑大图片弹窗*/
function closeBigPicture() {
    $("#openEditPicture").remove();
    $("header").css("display","block");
    $(".uploadingBlock").css("display","block");
    $("body").css("padding-top","3rem");
    $("#tit_viewport").attr("content","width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=5.0")
    //window.location.reload();
}
/*删除上传图片*/
function delPicture(localSrc, serverSrc, type) {
    $("[src='" + localSrc + "']").remove();
    delWXPicture(serverSrc,type);    //每个页面对应的删除函数
    closeBigPicture();
}

/*图片查询，用于回显已经上传的图片
 * type是想要查询图片的类型,调接口时传入,
 * cbFun图片下载成功后希望执行的函数，调接口时候传入
 * pagetype是区分回显页面的图片，pageBank储蓄卡 pageCid身份证  pageData理赔资料  tkaother
 */
function initPicture(type, cbFun, pagetype ,claimFlag) {
    openLoading();
    var coop_id = localStorage.getItem("open_id");
    if(claimFlag == "TKC"){
        var claim_id = localStorage.getItem("claim_id_tkc");
        var claimSign = localStorage.getItem("claimSign_tkc");
    }else if(claimFlag == "TKA"){
        var claim_id = localStorage.getItem("claim_id_tka");
        var claimSign = localStorage.getItem("claimSign_tka");
    }else if(claimFlag == "TKAC"){
        var claim_id = localStorage.getItem("claim_id_tkac");
        var claimSign = localStorage.getItem("claimSign_tkac");
    }
    $.ajax({
        type : "POST",
        url : serverUrl + "claimTKAInfoImageServlet",
        data : {
            coop_id : coop_id,
            claim_id : claim_id,
            claim_flag : claimFlag,
            sign : claimSign,
			pageType : pagetype,
            function_code : "query",
            channel : "WE"
        },
        dataType : "json",
        success : function(data) {
            closeLoading();
           //alert("回显地址===="+serverUrl+"claimTKAInfoImageServlet?function_code=query&coop_id="+coop_id+"&claim_id="+claim_id+"&sign="+claimSign+"pageType="+pagetype+"claim_flag="+claimFlag+"channel=WE");
           //alert("图片查询接口返回的数据==="+JSON.stringify(data));
            if (data.success == "Y") {
                downWXPicture(data.info, type, cbFun);
            } else {         //失败
                //alertInsureBox(data.desc);
            }
        },
        error : function() {
            closeLoading();
            refreshBox();
        }
    })
}

/*微信下载图片，用于回显
 * images是后台接口返回的data.info,即各种图片集合,
 * type是想要查询图片的类型,调接口时传入,
 * cbFun图片下载成功后希望执行的函数，调接口时候传入
 */
function downWXPicture(images, type, cbFun) {
    if(typeof type == 'object'){
        var typeLen = type.length;
        var j=0;
        var typeCopy = type;
       //console.log("===="+typeCopy);
        function downloadInQueue(type,cbFun){
            var this_type = type[j];
            //console.log("***=="+[j]+"=="+this_type);
            //console.log(parseInt(this_type));
            var typeStr;
            if(this_type.length==4){
                typeStr=this_type;
            }else{
                switch(parseInt(this_type)) {
                case 0: typeStr = "claimapply";break;
                case 2: typeStr = "diagnosis"; break;
                case 4: typeStr = "other"; break;
                case 5: typeStr = "pathology"; break;
                case 6: typeStr = "death"; break;
                case 7: typeStr = "invoice"; break;
                case 8: typeStr = "sickrecord"; break;
                case 9: typeStr = "benecid"; break;
                case 1:typeStr = "tkaother"; break;
                default: break;
                }
            }
            //console.log("查询类型===" + typeStr);
            //console.log("查询类型===" + typeStr +"长度"+typeLen);
            serverId = images[typeStr];
            if(serverId=="undefined"||serverId==undefined){
                if(j < typeLen-1){
                    j++;
                    downloadInQueue(type,cbFun);  
                }else{
                    return;
                }
            }else{
                var len = serverId.length;
                var i = len - 1;
                //console.log(serverId);
                function down() {
                    wx.downloadImage({
                        serverId : serverId[i],
                        isShowProgressTips : 1,
                        success : function(res) {
                            cbFun(res.localId, typeStr, serverId[i]);
                            //下载成功后回显方法（由调用初始化接口时传入）
                            i--;
                            if (i >= 0) {
                                down();
                            }else if(j < typeLen-1){
                                j++;
                                downloadInQueue(type,cbFun);  
                            }
                        }
                    })
                }
                down();
            }
        }
        downloadInQueue(typeCopy,cbFun);
    }else{
        serverId = images[type];
        downDifferent(images, type, cbFun, serverId);
    }
}

function downDifferent(images, type, cbFun, serverId) {
    if (serverId.length <= 0) {
        //alertbox("服务器端暂无照片");
        return false;
    }
    var len = serverId.length;
    var i = len - 1;
    function down() {
        wx.downloadImage({
            serverId : serverId[i],
            isShowProgressTips : 1,
            success : function(res) {
                cbFun(res.localId, type, serverId[i]);
                //下载成功后回显方法（由调用初始化接口时传入）
                i--;
                if (i >= 0) {
                    down();
                }
            }
        })
    }
    down();
}

/*上传到服务器缓存中的图片id
 * localId:图片本地id
 * up_type：类型，做前端判断
 * claim_id,sign,img_id,img_type为后台所需参数，分别是理赔号，sign，serverId，图片类型
*/
function uploadingPicture(localId, up_type, claim_id, sign, img_id, img_type, claimFlag) {
    openLoading();
    var coop_id = localStorage.getItem("open_id");
    $.ajax({
            type : "POST",
            url : serverUrl + "claimTKAInfoImageServlet",
            data : {
                coop_id : coop_id,
                claim_id : claim_id,
                claim_flag: claimFlag,
                sign : sign,
                img_id : img_id,
                img_type : img_type,
                function_code : "add",
                channel :"WE"
        },
        dataType : "json",
        success : function(data) {
            closeLoading();
            if (data.success == "Y") {
                uploadPicturesSuccess(localId, up_type, img_id);
                alertbox("上传成功");
                upflag = "1";
                return upflag;
            } else {
                alertbox(data.desc);
                upflag = "0";
                return upflag;
            }
        },
        error : function() {
            closeLoading();
            refreshBox();
        }
    })
}
//如果过40秒 还没有上传成功，则提示客户在wifi环境下操作
function settime(){
    setTimeout(function () {
        if(upflag == "0")     //代表上传图片失败
            alertInsureBox("您当前网速慢，建议使用wifi上传");
    },40000)
}

/*删除服务器缓存中的图片id*/
function deletingPicture(claim_id, sign, img_id, img_type,claimFlag) {
    //alert("claim_id="+claim_id+"=====sign="+sign+"====img_id="+img_id+"=====img_type="+img_type+"====claimFlag="+claimFlag);
    openLoading();
    var coop_id = localStorage.getItem("open_id");
    $.ajax({
        type : "POST",
        url : serverUrl + "claimTKAInfoImageServlet",
        data : {
            coop_id : coop_id,
            claim_id : claim_id,
            sign : sign,
            claim_flag : claimFlag,          //先写死 之后写成活的
            img_id : img_id,
            img_type : img_type,
            function_code : "del",
            channel : "WE"
        },
        dataType : "json",
        success : function(data) {
            closeLoading();
            //console.log("删除图片接口===" + JSON.stringify(data));
            if (data.success == "Y") {
                alertbox("删除成功");
            } else {
                alertbox(data.desc);
            }
        },
        error : function() {
            closeLoading();
            refreshBox();
        }
    })
}

/*微信接口配置文件*/
function InitWeiXin(Vtimestamp, VnonceStr, Vsignature) {
    wx.config({
        debug : false, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
        //appId : "wx90b252e89d5742e3", // 必填，公众号的唯一标识 测试环境
		appId : "wxcd7143c00e5bb6f7", // 必填，公众号的唯一标识  生产环境
        timestamp : Vtimestamp, // 必填，生成签名的时间戳
        nonceStr : VnonceStr, // 必填，生成签名的随机串
        signature : Vsignature, // 必填，签名，见附录1
        jsApiList : ['chooseImage', 'previewImage', 'uploadImage', 'downloadImage'] // 必填，需要使用的JS接口列表，所有JS接口列表见附录2
    });
}

/*打开wx.config*/
function initWXOpen() {
    $.ajax({
        type : "POST",
        url : serverUrl + 'weixinshare/WechatCircleOfFriends',
        data : "url=" + location.href.split('#')[0],
        dataType : "json",
        success : function(data) {
            if (data != null) {
                var Vtimestamp = data.timestamp;
                var VnonceStr = data.noncestr;
                var Vsignature = data.signature;
                InitWeiXin(Vtimestamp, VnonceStr, Vsignature);
            } else {
                alertbox('网络不给力');
            }
        },
        error : function() {
            alertbox('网络不给力');
        },
        complete : function() {
        }
    });
}

/* 微信上传图片，一次一张的上传 */
//var serverIdArry = new Array();
function uploadPictures(localId, up_type, claimFlag) {
    var i = 0;
    var len = localId.length;
    function upload() {
        wx.uploadImage({
            localId : localId[i],   // 需要上传的图片的本地ID，由chooseImage接口获得
            isShowProgressTips : 1, // 默认为1，显示进度提示
            success : function(res) {
                wxUploadPicturesSuccess(localId[i], up_type, res.serverId, claimFlag);  //每个页面对应的上传成功函数
                i++;
                if (i < len) {
                    upload();
                }
            },
            fail : function(res) {
                openFailTOUpload();
            }
        });
    }
    upload();
}

/*获取ticket值*/
function getTicket() {
    $.ajax({
        type : "POST",
        url : serverUrl +  'weixinshare/WechatticketofFriends',
        //http://whz.taikang.com/wechat_ecs/rest/circleOfFriends/getSignature
        data : "url=" + encodeURIComponent(location.href.split('#')[0]),
        dataType : "json",
        success : function(data) {
        },
        error : function() {
            alertbox('网络不给力');
        }
    });

}



/**
 * 删除DOM节点
 * @param String id
 */
function removeNode(id){
    var e = document.getElementById(id);
    if(e) e.parentElement.removeChild(e);
}
//截取地址中的参数
function getParameter (param) {
    var query = window.location.search;//获取URL地址中？后的所有字符
    var iLen = param.length;//获取你的参数名称长度
    var iStart = query.indexOf(param);//获取你该参数名称的其实索引
    if (iStart == -1)//-1为没有该参数
        return "";
    iStart += iLen + 1;
    var iEnd = query.indexOf("&", iStart);//获取第二个参数的其实索引
    if (iEnd == -1)//只有一个参数
        return query.substring(iStart);//获取单个参数的参数值
    return query.substring(iStart, iEnd);//获取第二个参数的值
}
/*删除左右两端的空格*/
function trim(str){
    return str.replace(/(^\s*)|(\s*$)/g, "");
}
/*邮箱判断*/
function email_checked(email) {
    var patten = /^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;
    if (!patten.test(email)) {
        return false;
    } else {
        return true;
    }
}
/*手机判断*/
function phone_checked(phone) {
    var patten = /^0*(86)*(13|14|15|17|18|19)\d{9}$/;
    if (!patten.test(phone)) {
        return false;
    } else {
        return true;
    }
}
var nameRreg = /^([A-z\u4E00-\u9FA5\uF900-\uFA2D]+[.|·]?)+([A-z\u4E00-\u9FA5\uF900-\uFA2D]+)$/;     //不能是数字或特殊字符
var tel_checked = /^((0\d{10})|1[35478]\d{9})$/;      //校验手机号
var num_checked = /^[0-9]*$/;                         //数字格式

var exp1 = /^[1-9][0-9]{5}((([0-9]{3}[1-9]|[0-9]{2}[1-9][0-9]{1}|[0-9]{1}[1-9][0-9]{2}|[1-9][0-9]{3})(((0[13578]|1[02])(0[1-9]|[12][0-9]|3[01]))|((0[469]|11)(0[1-9]|[12][0-9]|30))|(02(0[1-9]|[1][0-9]|2[0-8]))))|((([0-9]{2})(0[48]|[2468][048]|[13579][26])|((0[48]|[2468][048]|[3579][26])00))0229))[0-9]{3}([0-9]|[xX])$/;

/*校验身份证*/
function checkidcard(idcard) {
    var area = {
        11 : "北京",
        12 : "天津",
        13 : "河北",
        14 : "山西",
        15 : "内蒙古",
        21 : "辽宁",
        22 : "吉林",
        23 : "黑龙江",
        31 : "上海",
        32 : "江苏",
        33 : "浙江",
        34 : "安徽",
        35 : "福建",
        36 : "江西",
        37 : "山东",
        41 : "河南",
        42 : "湖北",
        43 : "湖南",
        44 : "广东",
        45 : "广西",
        46 : "海南",
        50 : "重庆",
        51 : "四川",
        52 : "贵州",
        53 : "云南",
        54 : "西藏",
        61 : "陕西",
        62 : "甘肃",
        63 : "青海",
        64 : "宁夏",
        65 : "新疆",
        71 : "台湾",
        81 : "香港",
        82 : "澳门",
        91 : "国外"
    };

    var idcard,
        Y,
        JYM;
    var S,
        M;
    var idcard_array = new Array();
    idcard_array = idcard.split("");
    if (area[parseInt(idcard.substr(0, 2))] == null)
        result = true;
    switch (idcard.length) {
    case 15:
        if ((parseInt(idcard.substr(6, 2)) + 1900) % 4 == 0 || ((parseInt(idcard.substr(6, 2)) + 1900) % 100 == 0 && (parseInt(idcard.substr(6, 2)) + 1900) % 4 == 0)) {
            ereg = /^[1-9][0-9]{5}[0-9]{2}((01|03|05|07|08|10|12)(0[1-9]|[1-2][0-9]|3[0-1])|(04|06|09|11)(0[1-9]|[1-2][0-9]|30)|02(0[1-9]|[1-2][0-9]))[0-9]{3}$/;
            // 测试出生日期的合法性
        } else {
            ereg = /^[1-9][0-9]{5}[0-9]{2}((01|03|05|07|08|10|12)(0[1-9]|[1-2][0-9]|3[0-1])|(04|06|09|11)(0[1-9]|[1-2][0-9]|30)|02(0[1-9]|1[0-9]|2[0-8]))[0-9]{3}$/;
            // 测试出生日期的合法性
        }
        if (ereg.test(idcard))
            result = false;
        else
            result = true;
        break;
    case 18:
        if (parseInt(idcard.substr(6, 4)) % 4 == 0 || (parseInt(idcard.substr(6, 4)) % 100 == 0 && parseInt(idcard.substr(6, 4)) % 4 == 0)) {
            ereg = /^[1-9][0-9]{5}(19|20)[0-9]{2}((01|03|05|07|08|10|12)(0[1-9]|[1-2][0-9]|3[0-1])|(04|06|09|11)(0[1-9]|[1-2][0-9]|30)|02(0[1-9]|[1-2][0-9]))[0-9]{3}[0-9Xx]$/;
            // 闰年出生日期的合法性正则表达式
        } else {
            ereg = /^[1-9][0-9]{5}(19|20)[0-9]{2}((01|03|05|07|08|10|12)(0[1-9]|[1-2][0-9]|3[0-1])|(04|06|09|11)(0[1-9]|[1-2][0-9]|30)|02(0[1-9]|1[0-9]|2[0-8]))[0-9]{3}[0-9Xx]$/;
            // 平年出生日期的合法性正则表达式
        }
        if (ereg.test(idcard)) {
            S = (parseInt(idcard_array[0]) + parseInt(idcard_array[10])) * 7 + (parseInt(idcard_array[1]) + parseInt(idcard_array[11])) * 9 + (parseInt(idcard_array[2]) + parseInt(idcard_array[12])) * 10 + (parseInt(idcard_array[3]) + parseInt(idcard_array[13])) * 5 + (parseInt(idcard_array[4]) + parseInt(idcard_array[14])) * 8 + (parseInt(idcard_array[5]) + parseInt(idcard_array[15])) * 4 + (parseInt(idcard_array[6]) + parseInt(idcard_array[16])) * 2 + parseInt(idcard_array[7]) * 1 + parseInt(idcard_array[8]) * 6 + parseInt(idcard_array[9]) * 3;
            Y = S % 11;
            M = "F";
            JYM = "10X98765432";
            M = JYM.substr(Y, 1);
            if (M == idcard_array[17])
                result = false;
            else
                result = true;
        } else
            result = true;
        break;
    default:
        result = true;
        break;
    }
    return result;
}
/*校验-出生日期*/
function isDate(str){
    var ereg;
    var year = str.substr(0,4);
    if (parseInt(year) % 4 == 0 ) {
        ereg = /^(19|20)[0-9]{2}((01|03|05|07|08|10|12)(0[1-9]|[1-2][0-9]|3[0-1])|(04|06|09|11)(0[1-9]|[1-2][0-9]|30)|02(0[1-9]|[1-2][0-9]))$/;
        // 闰年出生日期的合法性正则表达式
    } else {
        ereg = /^(19|20)[0-9]{2}((01|03|05|07|08|10|12)(0[1-9]|[1-2][0-9]|3[0-1])|(04|06|09|11)(0[1-9]|[1-2][0-9]|30)|02(0[1-9]|1[0-9]|2[0-8]))$/;
        // 平年出生日期的合法性正则表达式
    }
    var reg = /^(\d{4})-(\d{2})-(\d{2})$/;
    if(!reg.test(str)){
        return true;
    }else{
        str1 = year + str.substr(5,2)+ str.substr(8,2);
        if (ereg.test(str1)){
           return false; //校验通过
        }
        return true;
    }
}
/*校验-回乡证*/
function checkBackId(str){
    var ereg;
    ereg = /^[mMhH]\d{10}$/;
    if (ereg.test(str)){
        return false; 
    }
    return true;
}
/*校验-台胞证*/
function checkTaiId(str){
    var ereg1;
    var ereg2;
    ereg1 = /^[a-zA-Z0-9]{8}$/;
    ereg2 = /^[a-zA-Z0-9]{10}$/;
    if (ereg1.test(str)||ereg2.test(str)){
        return false; 
    }
    return true;
}
/*为空或未定义返回true*/
function isDefine(str){
    if(str==""||str=="null"||str=="undefined"||str==null||str==undefined){
        return true;
    }
    return false;
}



function back(){
	history.go(-1);
}
