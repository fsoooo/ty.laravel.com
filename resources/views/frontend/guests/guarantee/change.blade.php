@extends('frontend.guests.person_home.base')
@section('content')
<div class="md-modal md-effect-8 md-hide" id="modal-8">
    {{--<div class="md-content" style="border: 1px solid rgb(52,152,219)">--}}
    <div class="modal-header" >
        <button class="md-close close">×</button>
        <h4 class="modal-title" >申请变更</h4>
    </div>
    <div class="modal-body">
        <form role="form" id="add_category" action='{{url('/order/check_phone')}}' method="post">
            {{ csrf_field() }}
            <div class="form-group">
                <label for="exampleInputEmail1">申请人必须是投保人本人，请验证投保人手机信息</label>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">投保人手机号码：123456</label>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">图片验证码：</label>
                <input  name="img_code" id="img_code"  type="text" style="width: 150px;height: 45px" onblur="check_img()">
                <img src="{{URL('/captcha/1')}}"  id="img_captaha" alt="验证码" title="刷新图片" width="100" height="40" border="0" style="width: 200px; height: 40px;">
                <span> <a onclick="change_img()"> 换一张</a></span>
                <span id="check_image"></span>
            </div>

            <div class="form-group">
                <label for="exampleInputEmail1">短信验证码：</label>
                <input  name="phone_code"  type="text" style="width: 150px;height: 45px">
                <input type="button" id="send_sms" value="发送验证码" style="width: 140px;height: 40px;background: gray;color: white;border: none" disabled>
            </div>

            <div class="modal-footer">
                <input type="submit" class="btn btn-primary" value="确认提交">
            </div>
        {{--<input type="hidden" name="phone" value="{{ $policy->phone }}">--}}
        {{--<input type="hidden" name="order_code" value="{{ $order_detail->order_code }}">--}}
        {{--<input type="hidden" name="warranty_code" value="{{$warranty->warranty_code}}">--}}
        {{--<input type="hidden" name="union_order_code" value="{{$union_order_code}}">--}}
        {{--<input type="hidden" name="recognizee" value="{{$recognizee}}">--}}
        {{--<input type="hidden" name="policy" value="{{$policy}}">--}}
        {{--</form>--}}
    </div>
</div>
@stop
<script>
    $(function(){
        $("#send_sms").click(function(){
            var phone = $("input[name=phone]").val();
//                var phone = "15701681524";
            var model = '52339';
            sendSms(phone, model);
            function sendSms(phone, model){
                $.get('/backend/sendsms',
                        {'phone':phone,'model':model},
                        function (data) {
                            if(data.status == 0){
                                $("#send_sms").attr("disabled", true);
                                i = 60;
                                var set_time = setInterval(function() {
                                    if(i>0){
                                        change_time(i);
                                        i--;
                                    } else {
                                        clearInterval(set_time);
                                        $("#send_sms").removeAttr("disabled").val('发送验证码').css("cursor","pointer").css('background-color','#00a2ff');
                                    }
                                }, 1000);
                            }
                        }
                );
            }

        });
        function change_time(i){
            var str = i + '秒后重新发送';
            $("#send_sms").val(str).css('background-color','#999');
        }
    })

    function change_img(){
        var url = "{{ URL('/captcha') }}";
        url = url + "/" + Math.random();
        document.getElementById('img_captaha').src=url;
    }
    function check_img() {
        var img_code =  document.getElementById('img_code').value;
        console.log(img_code['img_code']);
        if(img_code!==''||img_code!==null||typeof(img_code)!==undefined){
            var params = {img_code:img_code};
            $.ajax({
                type : "get",
                url : '/checkimagegcode',
                dataType : 'json',
                data :params,
                success:function(msg){
                    if(msg.status == 0){
                        $("#check_image").html('<font color="green">'+'验证码输入正确'+'</font>');
                        $("#send_sms").removeAttr("disabled").val('发送验证码').css("cursor","pointer").css('background-color','#00a2ff');
                    }else{
                        $("#check_image").html('<font color="red">'+'验证码输入错误'+'</font>');
                    }
                }
            });
        }

    }
</script>
<script src="/js/jquery-3.1.1.min.js"></script>
<script charset="utf-8" src="/r_backend/js/modernizr.custom.js"></script>
<script charset="utf-8" src="/r_backend/js/classie.js"></script>
<script charset="utf-8" src="/r_backend/js/modalEffects.js"></script>
<script>
    $(function(){
        var change_policy_btn = $('#change-policy-btn');
        var change_policy_form = $('#change-policy-form');
        change_policy_btn.click(function(){
            change_policy_form.submit();
        })
    })
    };
</script>