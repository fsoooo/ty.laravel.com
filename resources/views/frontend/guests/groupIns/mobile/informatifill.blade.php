<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>天眼互联-科技让保险无限可能</title>
    <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
    <link rel="stylesheet" href="{{config('view_url.mobile_group_ins')}}css/lib/mui.min.css">
    <link rel="stylesheet" href="{{config('view_url.mobile_group_ins')}}css/lib/mui.picker.all.css" />
    <link rel="stylesheet" href="{{config('view_url.mobile_group_ins')}}css/lib/iconfont.css" />
    <link rel="stylesheet" href="{{config('view_url.mobile_group_ins')}}css/common.css" />
    <style>
        body {background: #fff;}
        .mui-scroll-wrapper {top: .8rem;bottom: .8rem;}
        .mui-bar-nav {background: #025a8d;}
        .mui-icon-back,.mui-title {color: rgba(255, 255, 255, .8);}
        .applicant-wrapper {background: #fff;margin-bottom: .8rem;padding-bottom: .3rem;}
        .applicant-wrapper ul {padding: 0 .3rem;}
        .applicant-wrapper li {height: 1rem;line-height: 1rem;position: relative;border-bottom: 1px solid #dcdcdc;}
        .applicant-wrapper li .iconfont {position: absolute;top: 0;right: 0;z-index: 1;font-size: .36rem;color: #00a2ff;}
        .applicant-partone li:last-child {border-bottom: none;}
        .applicant-wrapper li input {padding-left: 1.85rem;font-size: .28rem;border: none;}
        .name {position: absolute;top: 0;left: 0;font-size: .28rem;color: #313131;}
        .applicant-wrapper li.mui-table-view-cell {border-bottom: none;}
        .mui-table-view-cell:after {background: none;}
        .mui-scroll-wrapper {top: .9rem;bottom: .98rem;}
        .applicant-parttwo li:last-child {border-bottom: none;}
        .applicant-info p{padding: 0 .3rem;margin: .16rem 0;font-size: .24rem;color: #ADADAD;}
        /*信息提交成功*/
        .payment-header {
            padding: 3.5rem 0 .54rem;
            background: #fff;
            text-align: center;
            color: #FFAE00;
            font-size: .32rem;
        }
        .payment-header>i {
            margin-bottom: .3rem;
            font-size: 1.45rem;
        }
        .payment-header>p {
            margin-top: .2rem;
        }
        .submit-btn{
            color: #fff;
        }
        .labelstyle{
            padding-left: 2rem;
        }
        .z-btn-hollow{
            margin-right: .3rem;
        }
        .z-btn-selected{
            border: 1px solid #ccc;
            padding: .15rem .3rem;
            border-radius: 19%;
        }
        .selected{
            color: #00A2FF;
            border-color: #00A2FF;
        }
    </style>
</head>

<body>
<div class="main">
    <header class="mui-bar mui-bar-nav">
        <a class="mui-icon mui-icon-back mui-pull-left mui-action-back"></a>
        <h1 class="mui-title">被保人信息填写</h1>
    </header>
    <div class="mui-content">
        <form id="form" action="/ins/add_beibaoren_info_submit" method="post">
        <div class="mui-scroll-wrapper">
            <div class="mui-scroll">
                <div class="applicant-wrapper">
                    <ul class="applicant-partone">
                        <li>
                            <span class="name">姓名</span><input type="text" placeholder="必填" name="insurance_attributes[ty_beibaoren][ty_beibaoren_name]" class="mustFill" />
                        </li>
                        {{--<li class="pickerone" data-options = '[{"id":1,"api_from_uuid":"Wk","name":"身份证","number":"104","code":"BOC","status":0},{"id":7,"api_from_uuid":"Wk","name":"出生证","number":"301","code":"BCOM","status":0}]'>--}}
                            {{--<span class="name">证件类别</span><input id="certificatetype1" type="text" placeholder="出生证" class="mustFill"/>--}}
                            {{--<input id="name" class="inputhidden" hidden="hidden" type="text"  value=""/>--}}
                            {{--<i class="iconfont icon-gengduo"></i>--}}
                        {{--</li>--}}
                        <li>
                            <span class="name">身份证号</span><input type="text" placeholder="必填" name="insurance_attributes[ty_beibaoren][ty_beibaoren_id_number]" class="mustFill"/>
                        </li>
                        <li>
                            <span class="name">职业</span><input type="text" placeholder="必填" name="insurance_attributes[ty_beibaoren][ty_beibaoren_job]" class="mustFill"/>
                        </li>
                        <!--<li>
                            <span class="name">性别</span>
                            <label class="labelstyle">
                                <input hidden="" type="radio" name="sex">
                                <span class="z-btn-hollow z-btn-selected selected">女</span>
                            </label>
                            <label>
                                <input hidden="" type="radio" name="sex">
                                <span class="z-btn-hollow z-btn-selected">男</span>
                            </label>
                        </li>-->
                        <li>
                            <span class="name">手机号码</span><input type="text" name="insurance_attributes[ty_beibaoren][ty_beibaoren_phone]" placeholder="必填" class="mustFill"/>
                        </li>
                        {{--<li>--}}
                            {{--<span class="name">电子邮箱</span><input type="text" placeholder="必填" class="mustFill"/>--}}
                        {{--</li>--}}
                    </ul>
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <input type="hidden" name="identification" value="{{$identification}}">
                    <input type="hidden" name="manager" value="0">
                </div>
                <div class="payment-header" style="display: none;">
                    <i class="iconfont icon-chenggong2"></i>
                    <p>信息提交成功</p>
                </div>
            </div>
        </div>
            <input type="hidden" name="identification" value="{{$identification}}">
        <div class="buttonbox">
            <button class="btn submit-btn" disabled="disabled">提交信息</button>
        </div>
        </form>
    </div>
</div>

<script src="{{config('view_url.mobile_group_ins')}}js/lib/jquery-1.11.3.min.js"></script>
<script src="{{config('view_url.mobile_group_ins')}}js/lib/mui.min.js"></script>
<script src="{{config('view_url.mobile_group_ins')}}js/common.js"></script>
<script src="{{config('view_url.mobile_group_ins')}}js/preview.js"></script>
<script src="{{config('view_url.mobile_group_ins')}}js/lib/mui.picker.all.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">
    //下一步的链接跳转（信息提交成功）
    $('.submit-btn').click(function(){
        $("#form").submit();
//        $('.applicant-wrapper').hide();
//        $('.payment-header').show();
//        $('.buttonbox').hide();
    });
    //证件类别、（身份证和出生证）
    var userPicker = new mui.PopPicker();
    $('.pickerone').on('tap', function(e) {
        var _this = $(this);
        $('input').blur();
        var jsonData = _this.attr('data-options');
        userPicker.setData(changeJsonData(jsonData));
        userPicker.show(function(items) {
            _this.find('input:text').val(items[0].text);
            _this.find('.inputhidden').val(items[0].id);

        });
    });
    // 实时监听必填项（input必须全部输入才有下一步）
    $('input').bind('input propertychange', function() {
        check1();
    });
    function check1(){
        if(!checkMustFill('.mustFill')){
            $('.submit-btn').prop('disabled',true);
        }else{
            $('.submit-btn').prop('disabled',false);
        }
    }
    //性别（暂时去掉了性别选项）
    $('.z-btn-hollow').on('tap',function(){
        $(this).parents('li').find('.z-btn-selected').removeClass('selected');
        $(this).addClass('selected').prev().prop('checked', true);
    });

    // 信息校验
    function checkVal(ele,reg){
        $(ele).blur(function(){
            if(!$(this).val().trim()){$(this).val('');return;}
            if(!checkCorrect(this,reg)){
                $(this).val('');
                $('.submit-btn').prop('disabled',true);
            }
        });
    }
    checkVal($('input[name="insurance_attributes[ty_beibaoren][ty_beibaoren_name]"]'),nameReg);
    checkVal($('input[name="insurance_attributes[ty_beibaoren][ty_beibaoren_id_number]"]'),IdCardReg);
    checkVal($('input[name="insurance_attributes[ty_beibaoren][ty_beibaoren_phone]"]'),telReg);


</script>
</body>

</html>