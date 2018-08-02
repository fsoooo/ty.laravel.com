<!DOCTYPE HTML>
<html>
    <head>
        <title>发送电子邮件</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=5.0" charset="UTF-8">
        <link href="{{config('view_url.channel_url')}}css/service.css" rel="stylesheet"/>
        <script src="{{config('view_url.channel_url')}}js/baidu.statistics.js"></script>
    </head>
    <body style="background-color:#f5f5f5;">
        <!----------发送邮件 弹框------------------>
        <div class="coverBg2 j-errorBg" style="display:block" id="mainTos">
            <div class="errorTipWrap j-errorWrap" style="padding-bottom:1rem; margin-top: -8rem;">
                <a href="javascript:window.history.back();"><img src="{{config('view_url.channel_url')}}imges/icon-close.png" class="iconClose j-iconClose"></a>
                <div class="j-errorTipTitleWrap">
                    <div class="notice tx-c">理赔申请书接收方式</div>
                    {{--<p class="ulev1 t-6 paddingAll tx-l">--}}
                        {{--<span class="circle"></span>邮件--}}
                    {{--</p>--}}
                    {{--<div class="form" style="margin:0.4rem auto;">--}}
                        {{--<form action="/channelsapi/email_send" method="post" id="email_form">--}}
                            {{--{{ csrf_field() }}--}}
                        {{--<div class="inputW w99">--}}
                            {{--<input type="text" name="email"  placeholder="请输入您的电子邮箱地址" class="w95" id="email">--}}
                            {{--<img src="{{config('view_url.channel_url')}}imges/down-email.png" class="rili" onclick="sendEmail();">--}}
                        {{--</div>--}}
                        {{--</form>--}}
                    {{--</div>--}}
                    <p class="ulev1 t-6 paddingAll tx-l">
                        <span class="circle"></span>下载打印<span class="ulev-1">(该网址用于电脑浏览、下载)</span>
                    </p>
					<div class="eil">
						<a class="ulev-1 t-3 paddingTB tx-l" style="word-wrap:break-word;">http://www.tk.cn/service/download</a>
					</div>
                </div>
            </div>
        </div>
        <!----------发送失败 弹框------------------>
        <div class="coverBg2 j-errorBg" style="display:none" id="errorTos">
            <div class="errorTipWrap j-errorWrap" style="padding-bottom:1rem;">
                <a href="javascript:window.history.back();"><img src="{{config('view_url.channel_url')}}imges/icon-close2.png" class="iconClose j-iconClose"></a>
                <div class="j-errorTipTitleWrap">
                    <p class="ulev1 t-red margin-L margin-t paddingTB">发送失败</p>
                    <p class="ulev1 t-6 margin-L paddingTB tx-l">请尝试重新发送或通过电脑登录下列网址下载：</p>
                    <div class="eil">
                        <a href="{{config('view_url.channel_url')}}" class="ulev1 t-6 paddingTB tx-l" style="word-wrap:break-word;">http://www.tk.cn/service/download</a>
                    </div>  
                </div>
            </div>
        </div>
        @include('frontend.channels.insure_alert')
        <script type="text/javascript" src="{{config('view_url.channel_url')}}js/jquery-1.10.2.min.js"></script>
        <script type="text/javascript" src="{{config('view_url.channel_url')}}js/main.js"></script>
    </body>
    <script>
        var userEmail;
        var email;
        //发送邮件
        function sendEmail(){
            email = $("#email").val().trim();
            if (email == "") {
                alertbox('邮箱地址不能为空');
                return false;
            }else if(!email_checked(email)) {
                alertbox('邮箱格式错误，请检查');
                return false;
            }else{
                $.ajax( {
                    type : "post",
                    url : "/channelsapi/email_send",
                    dataType : 'json',
                    data : {email:email},
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    success:function(msg){
                        if(msg.status == '200'){
                            alertbox('邮件发送成功，请前往邮箱查看！');
                        }else{
                            sendError();
                        }
                    }
                });
            }
        }
        //发送错误页面
        function sendError() {
            $("#errorTos").css("display", "block");
            $("#mainTos").css("display", "none");
        }
    </script>
</html>
