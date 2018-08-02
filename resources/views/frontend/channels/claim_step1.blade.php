<!DOCTYPE HTML>
<html>
<head>
<title>我要理赔</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=5.0" charset="UTF-8">
<link href="{{config('view_url.channel_url')}}css/service.css" rel="stylesheet"/>
<link href="{{config('view_url.channel_url')}}css/mobile-select-area.css" rel="stylesheet"/>
<link href="{{config('view_url.channel_url')}}css/claim.css" rel="stylesheet"/>
	<script src="{{config('view_url.channel_url')}}js/baidu.statistics.js"></script>
</head>
<body style=" background-color:#fff;">  
	<div style="width:100%;height:100%;" id="defuTimes">
		<!--温馨提示-->
		<div class="coverBg2" id="alertwin">
			<div class="bomb-box">
				<div class="bomb-txt">
					<h4>温馨提示</h4>
					<p class=" ulev1 t-73 tx-l">人身险报案：被保险人本人出险报案入口（医疗险、意外险、重疾险）。<br>财产险报案：非人身险损失报案入口。<br>若同时出险，勾选两者可直接报案。</p>
				</div>
				<div class="btnW">
					<div class="btnC" id="insureWin">确定</div>
				</div>
			</div>
		</div>
		<!--表单填写-->
		<form action="{{ url('/channelsapi/do_claim_step1')}}"  method="post" id="do_claim_step1">
			{{--enctype="multipart/form-data"--}}
			{{ csrf_field() }}
			<input type="hidden" name="warranty_code" value="{{$warranty_code}}">
			<input type="hidden" name="cidnumber_decrypt" value="{{$user_info['cidnumber_decrypt']}}">
			<input type="hidden" name="mobile_decrypt" value="{{$member['tka_mobile']}}">
			<input type="hidden" name="member_id" value="{{$user_info['member_id']}}">
			<input type="hidden" name="coop_id" value="{{$user_info['member_id']}}">
			<input type="hidden" name="cidtype" value="{{$user_info['cidtype']}}">
			<input type="hidden" name="sign" value="{{$user_info['member_sign']}}">
			<input type="hidden" name="relationship" value="0">
			<input type="hidden" name="claim_operatetype" value="YDAPP">
			<input type="hidden" name="mobile_sign" value="{{$member['mobile_sign']}}">
			<input type="hidden" name="tka_mobile" value="{{$member['tka_mobile']}}">
			<input type="hidden" name="tka_cidnumber" value="{{$member['tka_cidnumber']}}">
			<input type="hidden" name="private_p_code" value="VGstMTEyMkEwMUcwMQ">
			<input type="hidden" name="cidtype" value="01">
			<input type="hidden" name="tka_accidentResult" value="{{$member['tka_accidentInfos'][0]['tka_accidentType']}}">
			<input type="hidden" name="tka_accidentResult_desc" value="{{$member['tka_accidentInfos'][0]['tka_accidentResult']}}">
	    <div class="header">
	    	第一步：填写出险人信息
	        <img src="{{config('view_url.channel_url')}}imges/arrow-left.png" class="arrow-left2" onclick="back();">
	        <img src="{{config('view_url.channel_url')}}imges/home.png" class="home" onclick="close_windows();">
	    </div>
			<div class="nav-card box clearfix" style="margin-top: 2rem;">
				<div class="checkbox">
					<div class="checkbox_box2">
						<input type="checkbox" name="claim_flag" id="people_kexuanCheck" checked="true" value="TKC">
						<span></span>
					</div>
					<p class="padding-tb">人身险报案</p>
				</div>
				<div class="checkbox">
					<div class="checkbox_box2">
						<input type="checkbox" name="claim_flag" id="property_kexuanCheck" value="TKA">
						<span></span>
					</div>
					<p class="padding-tb">财产险报案</p>
				</div>
				<div id="tkac"></div>
			</div>
	    <div style="margin-top: 7rem;">
		    <!--出险人信息 -->
		    <div class="formW">
		    	<div class="form">
		        	<p>出险人</p>
		            <div class="inputW">
		                <input type="text"  placeholder="请输入出险人姓名" name="ins_name" id="ratename"  value="{{$user_info['name']}}"/>
		            </div>
		        </div>
		        <div class="form">
		        	<p>证件类型</p>
		        	<div class="inputW">
		            	<select id="cidtypes" class="ht" name="ins_cidtype">
		            		<option value="01">身份证</option>
		                	<option value="03">护照</option>
		                    <option value="04">军官证</option>
		                    <option value="05">港台同胞证</option>
		                    <option value="07">户口本</option>
		                    <option value="13">回乡证</option>
		                    <option value="17">台胞证</option>
		                    <option value="11">驾驶证</option>
		                    <option value="06">出生日期</option>
		                    <option value="10">其它</option>
		           		</select>
		                <img src="{{config('view_url.channel_url')}}imges/arrow-down.png" class="down">
		             </div>
		        </div>
		        <div class="form">
		        	<p>证件号码</p>
		        	<div class="inputW">
		            	<input type="text"  placeholder="请输入出险人证件号码"  id="cidnum" />
		            	<input type="hidden"  placeholder="请输入出险人证件号码" name="ins_cidnumber" value="{{$user_info['cidnumber_decrypt']}}" />
		            </div>
		        </div>
		        <div class="form no-border">
		        	<p>手机号码</p>
		        	<div class="inputW">
		                <input type="tel"  placeholder="请输入出险人手机号码" name="ins_mobile" maxlength="11" id="phone" />
		            </div>
		        </div>
		    </div>
		    <!-- 人身出险信息 -->
		    <div id="people_report" style="display: block;">
		        <div class="people">
		            <div class="line"></div>
		            <span class="padding-l">人身出险信息</span>
		        </div>
		        <div class="formW">
		            <div class="form">
		                <p>出险地区</p>
		                <div class="inputW">
		                    <select id="people_provinceName" name="company_no" class="ht">
		                        <option>－请选择－</option>
								@foreach($area['province'] as $value)
									<option value="{{$value['provincecode']}}">{{$value['provincename']}}</option>
								@endforeach
		                    </select>
		                    <img src="{{config('view_url.channel_url')}}imges/arrow-down.png" class="down">
		                </div>
		            </div>
		            <div class="form">
		                <p>&nbsp;</p>
		                <div class="inputW">
		                    <select id="people_city" name="branch_no" class="ht">
		                        <option>－请选择－</option>
								@foreach($area['city'] as $value)
									<option value="{{$value['citycode']}}">{{$value['cityname']}}</option>
								@endforeach
		                    </select>
		                    <img src="{{config('view_url.channel_url')}}imges/arrow-down.png" class="down">
		                </div>
		            </div>
		            <div class="form">
		                <p>出险日期</p>
		                <div class="inputW">
		                    <input type="text" class="rili-bg" name="accidentDate" placeholder="请选择出险日期" readonly="readonly" id="people_rateTime" value=""/>
		                </div>
		            </div>
		            <div class="form no-border">
		                <p>出险类型</p>
		                <div class="checkboxW" style="padding: 0.6rem 0 0.3rem;">
		                    <div class="checkbox_box">
		                        <input type="checkbox" name="accidentResult[]" id="people_doorEmer" value="03">
		                        <p>门急诊／住院费用</p>
		                    </div>
		                </div>
		                <div class="checkboxW" style="width:22%!important; margin-left:4%; padding: 0.6rem 0 0.3rem;">
		                    <div class="checkbox_box" style="width:98%!important;">
		                        <input type="checkbox" name="accidentResult[]"  id="people_hospitalSub" style="width:100%!important;" value="00">
		                        <p style="width:98%!important;">住院津贴</p>
		                    </div>
		                </div>
		            </div>
		            <div class="form no-border">
		                <p style="padding:0;">&nbsp;</p>
		                <div class="checkboxW" style="width:24%!important; padding: 0.3rem 0 0.6rem;">
		                    <div class="checkbox_box" style="width:98%!important;">
		                        <input type="checkbox" name="accidentResult[]"  id="people_disease" style="width:100%!important;" value="01">
		                        <p style="width:98%!important;">重大疾病</p>
		                    </div>
		                </div>
		                <div class="checkboxW" style="width:24%!important; margin-left:1rem; padding: 0.3rem 0 0.6rem;">
		                    <div class="checkbox_box" style="width:98%!important;">
		                        <input type="checkbox" name="accidentResult[]"  id="people_invalid" style="width:100%!important;" value="04">
		                        <p style="width:98%!important;">残疾</p>
		                    </div>
		                </div>
		            </div>
		            <div class="form no-border" id="shengu" style="display: none;">
		                <p style="padding:0;">&nbsp;</p>
		                <div class="checkboxW" style="width:24%!important;padding: 0.3rem 0 0.6rem;" >
		                    <div class="checkbox_box" style="width:98%!important;">
		                        <input type="checkbox" id="people_die" name="accidentResult[]"  style="width:100%!important;" value="02">
		                        <p style="width:98%!important;">身故</p>
		                    </div>
		                </div>
		            </div>
		        </div>
		    </div>
		    <!-- 财产险出险信息 -->
		    <div id="property_report" style="display: none;">
		        <div class="people">
		            <div class="line"></div>
		            <span class="padding-l">财产险出险信息</span>
		        </div>
		        <div class="formW">
		            <div class="form">
		                <p>保单号</p>
		                <div class="inputW">
		                    <input type="tel" name="policy_no"  placeholder="请输入您的保单号" id="property_policyNo" value="{{$warranty_code}}"/>
		                </div>
		            </div>
		            <div class="form">
		                <p>被保险人</p>
		                <div class="inputW">
		                    <input type="text" name="tka_name"  placeholder="被保险人姓名" id="property_insuName" value="{{$user_info['name']}}"/>
		                </div>
		            </div>
		            <div class="form">
		                <p>证件类型</p>
		                <div class="inputW">
		                    <select id="property_cidtypes" name="tka_cidtype" class="ht">
		                        <option value="01">身份证</option>
		                        <option value="03">护照</option>
		                        <option value="04">军官证</option>
		                        <option value="05">港台同胞证</option>
		                        <option value="07">户口本</option>
		                        <option value="13">回乡证</option>
		                        <option value="17">台胞证</option>
		                        <option value="11">驾驶证</option>
		                        <option value="06">出生日期</option>
		                        <option value="10">其它</option>
		                    </select>
		                    <img src="{{config('view_url.channel_url')}}imges/arrow-down.png" class="down">
		                </div>
		            </div>
		            <div class="form">
		                <p>证件号码</p>
		                <div class="inputW">
							<input type="text" name="tka_cidnumber"  placeholder="出险人证件号码" id="property_cidnum" />
		                </div>
		            </div>
		            <div class="form">
		                <p>出险日期</p>
		                <div class="inputW">
		                    <input type="text" name="tka_accidentDate" class="rili-bg" readonly="readonly" placeholder="请选择出险日期"  id="property_rateTime" value="{{date("Y-m-d H:i",time())}}"/>
		                </div>
		            </div>
		            <div class="form">
		                <p>出险地区</p>
		                <div class="inputW">
		                    <select id="property_provinceName" name="tka_company_no" class="ht">
		                        <option>－请选择－</option>
								@foreach($area['province'] as $value)
									<option value="{{$value['provincecode']}}">{{$value['provincename']}}</option>
								@endforeach
		                    </select>
		                    <img src="{{config('view_url.channel_url')}}imges/arrow-down.png" class="down">
		                </div>
		            </div>
		            <div class="form">
		                <p>&nbsp;</p>
		                <div class="inputW">
		                    <select id="property_city" name="tka_branch_no" class="ht">
		                        <option>－请选择－</option>
								@foreach($area['city'] as $value)
		                        	<option value="{{$value['citycode']}}">{{$value['cityname']}}</option>
								@endforeach
		                    </select>
		                    <img src="{{config('view_url.channel_url')}}imges/arrow-down.png" class="down">
		                </div>
		            </div>
		            <div class="form">
		                <p>&nbsp;</p>
		                <div class="inputW">
		                    <input type="text" name="address" placeholder="请输入详细地址" id="property_detailAddress" />
		                </div>
		            </div>
		            <div class="form">
		                <p>损失金额</p>
		                <div class="inputW">
		                    <input type="tel" name="lost_money"  placeholder="请输入损失金额" id="property_lossAmount" />
		                    <span class="yuan">元</span>
		                </div>
		            </div>
		            <div class="form">
		                <p>出险原因</p>
		                <div class="inputW">
		                    <select id="property_becauseDanger" class="ht">
		                        <option value="-1">－请选择－</option>
		                        <option value="00">住院日额津贴</option>
		                        <option value="01">重大疾病</option>
		                        <option value="02">身故</option>
		                        <option value="03">门急诊/住院费用</option>
		                        <option value="04">残疾</option>
		                    </select>
		                    <img src="{{config('view_url.channel_url')}}imges/arrow-down.png" class="down">
		                </div>
		            </div>
		            <div class="form no-border">
		                <p style="width:100%">事故经过和损失描述</p>
		            </div>
		            <div class="form">
		                <textarea class="writ-box" name="claim_desc" rows="4" placeholder="请在此输入事故经过和损失描述..." id="property_describle"></textarea>
		            </div>
		            <div class="form">
		                <p>被保险人手机号</p>
		                <div class="inputW">
							<input type="text"  placeholder="被保险人手机号" id="property_insuredPhone" value="{{$member['tka_mobile_show']}}" />
							<input type="hidden" name="tka_mobile"   value="{{$member['tka_mobile']}}" />
		                </div>
		            </div>
		            <div class="form no-border">
		                <p>验证码</p>
		                <div class="inputW">
		                    <input class="numb-input" type="tel"  name="yzmCode" placeholder="请输入验证码" maxlength="6" id="property_code" />
		                    <div class="numb-btn" id="getCode">获取验证码</div>
		                </div>
		            </div>
		        </div>
		    </div>
		    <!--他人申请-->
		    <div id="otherApply" style="display: block;">
		        <div class="people">
		            <div class="line"></div>
		            <span class="padding-l">申请人信息</span>
		        </div>
		        <div class="formW">
		            <div class="form">
		                <p>申请人姓名</p>
		                <div class="inputW">
		                    <input type="text" name="applyname"  placeholder="请输入申请人姓名" id="otherName"/>
		                </div>
		            </div>
		            <div class="form no-border hei">
		                <p>申请人手机号码</p>
		                <div class="inputW">
		                    <input type="tel" name="applymobile"  placeholder="请输入申请人手机号码" id="otherPhone"/>
		                </div>
		            </div>
		        </div>
		    </div>
		    <div id="nextAccount">
		        <div class="service-btn">下一步：填写收款账户信息</div>
		    </div>
	    </div>
		</form>
	    <!--核对信息弹框-->
	    <div class="coverBg2" id="checkInfos" style="display: none;">
			<div class="bomb-box">
				<div class="bomb-txt">
					<h4>提示</h4>
					<p class=" ulev1 t-73 tx-l">人身险报案：被保险人本人出险报案入口（医疗险、意外险、重疾险）。<br>财产险报案：非人身险损失报案入口。<br>若同时出险，勾选两者可直接报案。</p>
				</div>
				<div class="btnW">
	            	<div class="btnL" id="modify">修改</div>
	                <div class="btnR" id="insure">确定</div>
	            </div>
			</div>
		</div>
		<script type="text/javascript" src="{{config('view_url.channel_url')}}js/jquery-1.10.2.min.js"></script>
		<script type="text/javascript" src="{{config('view_url.channel_url')}}js/main.js"></script>
		<script type="text/javascript" src="{{config('view_url.channel_url')}}js/dialog.js"></script>
		<script type="text/javascript" src="{{config('view_url.channel_url')}}js/information.js"></script>
		<script type="text/javascript" src="{{config('view_url.channel_url')}}js/mobile-select-date.js"></script>
		<script type="text/javascript" src="{{config('view_url.channel_url')}}js/mobile-select-dateTime.js"></script>
		<script type="text/javascript">
            // 获取验证码
            $("#getCode").click(function (){
                if(checkPolicyNo()){                //保单号不能为空的情况下，调取接口获取到手机号加密串
                    var tka_mobile = "{{$member['tka_mobile']}}";
                    var mobile_sign = "{{$member['mobile_sign']}}";
                    get_code(tka_mobile,mobile_sign);
                }
            });
            function get_code(tka_mobile,mobile_sign){
                $.ajax( {
                    type : "post",
                    url : "/channelsapi/sms_send",
                    dataType : 'json',
                    data : {tka_mobile:tka_mobile,mobile_sign:mobile_sign},
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    success:function(msg){
                        if(msg.status == '200'){
                            alertbox("验证码已发送");
                            codeCount();
                        }else{
                            alertbox("验证码发送失败，请重新尝试！");
                        }
                    }
                });
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
		    $(function (){
		    	// 关闭温馨提示
			    $('#insureWin').click(function() {
			        $('#alertwin').remove();
			    });
			    $('#insure').click(function(){
                    var tk_value = $("input:checkbox[name='claim_flag']:checked").map(function(index,elem) {
                        return $(elem).val();
                    }).get().join(',');
                    if(tk_value=='TKC,TKA'){
						$('#tkac').html('<input type="hidden" name="claim_flag" value="'+"TKAC"+'" >');
					}
			        $('#do_claim_step1').submit();
			    })
				// 校验
				$("#nextAccount").on("click",function (){
					if(checkName()&&checkCidNum()&&checkPhone()){
		                $("#checkInfos").fadeIn();
		          	}
				});
				/* 修改 */
				$(".btnL").click(function(){
				    $("#checkInfos").fadeOut();
				});
		        //日期-年 月 日
		        var selectDate_person = new MobileSelectDate();
		        selectDate_person.init({
		            trigger: $("#people_rateTime"),
	//	            value: "2016-06-16"             //初始默认时间
		        });
		         //时间-年 月 日 时 分
		        var selectDate_property = new MobileSelectDate();
		        selectDate_property.init({
		            trigger: $("#property_rateTime"),
		        });
                var selectDateTime = new MobileSelectDateTime();
                selectDateTime.init({
                    trigger: $("#property_rateTime"),
                });

            });
		</script>
	</div>
</body>
</html>
