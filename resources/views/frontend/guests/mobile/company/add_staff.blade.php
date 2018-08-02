<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>天眼互联-科技让保险无限可能</title>
    <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
    <link rel="stylesheet" href="{{config('view_url.view_url')}}mobile/personal/css/lib/mui.min.css">
    <link rel="stylesheet" href="{{config('view_url.view_url')}}mobile/personal/css/lib/mui.picker.all.css">
    <link rel="stylesheet" href="{{config('view_url.view_url')}}mobile/personal/css/lib/iconfont.css" />
    <link rel="stylesheet" href="{{config('view_url.view_url')}}mobile/personal/css/common.css" />
    <style>
        .mui-scroll-wrapper {top: .9rem;bottom: 0;background: #fff;}
        .mui-bar-nav {background: #025a8d;}
        .mui-icon-back,.mui-title {color: rgba(255, 255, 255, .8);}
        .applicant-wrapper ul {padding: 0 .3rem;}
        .applicant-wrapper li {height: 1rem;line-height: 1rem;position: relative;border-bottom: 1px solid #dcdcdc;}
        .applicant-wrapper li .iconfont {position: absolute;top: 0;right: 0;z-index: 1;font-size: .36rem;color: #00a2ff;}
        .applicant-wrapper li input {padding-left: 1.85rem;font-size: .28rem;border: none;overflow: hidden;text-overflow:ellipsis;white-space: nowrap;}
        .name {position: absolute;top: 0;left: 0;width: 1.6rem;z-index: 100; font-size: .28rem;color: #313131;}
        .mui-icon-checkmarkempty{margin-top: -.2rem;font-size: 1rem!important;color: #fff;}
        .btn-select {position: relative;padding: 0 .14rem;margin-right: .18rem;height: .56rem;line-height: .56rem;border: 1px solid #dcdcdc;font-size: .28rem;}
        .btn-select.active {border: 1px solid #00a2ff;}
        .btn-select.active:after {content: '';position: absolute;right: -1px;bottom: -3px;width: 0;height: 0;border-top: 4px solid transparent;border-bottom: 4px solid transparent;border-left: 4px solid #00a2ff;transform: rotate(45deg);}
        .select-sex{padding-left: 1.85rem;}
    </style>
</head>

<body>
<div class="main">
    <form action="/cpersonal/staffaddsubmit" method="post">
        {{ csrf_field() }}
    <header class="mui-bar mui-bar-nav">
        <a class="mui-icon mui-icon-back mui-pull-left mui-action-back"></a>
        <h1 class="mui-title">新增被保人</h1>
        <button id="form_submit" class="mui-icon mui-icon-checkmarkempty mui-pull-right" type="submit"></button>
    </header>
    <div class="mui-content">
        <div class="mui-scroll-wrapper">
            <div class="mui-scroll">
                <div class="applicant-wrapper">
                    <ul class="applicant-partone">
                        <li class="pickerone" data-options = '[@foreach($products as $k=>$v) {"id":{{$v->ty_product_id}},"name":"{{$v->product_name}}"}@if($k< count($products)-1),@else @endif @endforeach]'>
                            <span class="name">保障方案<span class="red">*</span></span>
                            <input type="text" placeholder="请选择" name="product" />
                            <input id="scheme" class="inputhidden" hidden type="text"  value="" name="product"/>
                            <i class="iconfont icon-gengduo"></i>
                        </li>
                        <li>
                            <span class="name">姓名<span class="red">*</span></span>
                            <input id="name" type="text" value="" name="name" placeholder="请添加"/>
                        </li>
                        <li class="pickerone" data-options = '[{"id":1,"name":"身份证"},{"id":2,"name":"护照"}]'>
                            <span class="name">证件类别<span class="red">*</span></span>
                            <input type="text"  placeholder="请选择" name="id_type" />
                            <input id="certificateType" class="inputhidden" hidden type="text"  value="" name="id_type"/>
                            <i class="iconfont icon-gengduo"></i>
                        </li>
                        <li class="hide pickerfour">
                            <span class="name">出生日期<i class="red">*</i></span>
                            <input id="birthday" type="text" placeholder="请选择" name="birthday" />
                            <i class="iconfont icon-gengduo"></i>
                        </li>
                        <li class="hide">
                            <span class="name">性别<i class="red">*</i></span>
                            <div class="select-sex">
                                <button class="btn-select active">男</button>
                                <button class="btn-select">女</button>
                            </div>
                            <input  type="radio" name="sex" checked value="1">
                            <input  type="radio" name="sex" value="0">
                        </li>
                        <li>
                            <span class="name">证件号码<i class="red">*</i></span><input id="idCard" placeholder="请添加" name="id_code"/>
                        </li>
                        <li>
                            <span class="name">手机号码<i class="red">*</i></span><input id="tel" type="text" maxlength="11" name="phone"  placeholder="请添加"/>
                        </li>
                        <li>
                            <span class="name">电子邮箱<i class="red">*</i></span><input id="email" type="text"  name="email" placeholder="请添加"/>
                        </li>
                        <li class="pickerfour">
                            <span class="name">保障时间<i class="red">*</i></span>
                            <input id="date" type="text" placeholder="请选择" name="date">
                            <i class="iconfont icon-gengduo"></i>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    </form>
</div>

<script src="{{config('view_url.view_url')}}mobile/personal/js/lib/jquery-1.11.3.min.js"></script>
<script src="{{config('view_url.view_url')}}mobile/personal/js/lib/mui.min.js"></script>
<script src="{{config('view_url.view_url')}}mobile/personal/js/lib/mui.picker.all.js"></script>
<script src="{{config('view_url.view_url')}}mobile/personal/js/common.js"></script>
<script>
    var userPicker = new mui.PopPicker();
    $('.pickerone').on('tap', function(e) {
        var _this = $(this);
        var jsonData = _this.attr('data-options');
        var which = this.className;
        userPicker.setData(changeJsonData(jsonData));
        userPicker.show(function(items) {
            _this.find('input:text').val(items[0].text);
            _this.find('.inputhidden').val(items[0].id);
            console.log($('#scheme').val())
            console.log($('#certificateType').val())

            // certificateType设为身份证id
            var certificateType = 1;
            if(items[0].id !== certificateType){
                $('.hide').show();
            }else{
                $('.hide').hide();
            }
        });
    });
    $('.pickerfour').on('tap', function() {
        var _this = $(this);
        var picker = new mui.DtPicker({
            "type": "date",
            "beginYear": 1999
        });
        picker.show(function(rs) {
            _this.find('input').val(rs.text);
            guaranteeTime = rs.text;
            console.log(_this.find('input').val())
            picker.dispose();
        });
    });

    $('.btn-select').click(function() {
        $(this).addClass('active').siblings().removeClass('active');
        var index = $(this).index();
        $(this).parents('li').find('input').prop('checked',false);
        var a =$(this).parents('li').find('input').eq(index).prop('checked',true);
        console.log($(this).parents('li').find('input:checked').val())
    })

    $('.mui-icon-checkmarkempty').on('tap',function(){

        if($('.hide').is(':visible')){ // 证件类型不为身份证时
            if(!checkEmpty($('#scheme')) ||!checkEmpty($('#name')) || !checkEmpty($('#certificateType')) || !checkEmpty($('#birthday')) || !checkEmpty($('#idCard'))
                    || !checkEmpty($('#tel')) || !checkEmpty($('#email')) ||!checkEmpty($('#date')) ||
                    !checkCorrect($('#name'),nameReg) || !checkCorrect($('#idCard'),IdCardReg) || !checkCorrect($('#tel'),telReg) || !checkCorrect($('#email'),emailReg)){
                console.log('校验不通过');
            }else{
                console.log('提交数据');
            }
        }else{
            if(!checkEmpty($('#scheme')) ||!checkEmpty($('#name')) || !checkEmpty($('#certificateType')) || !checkEmpty($('#idCard')) || !checkEmpty($('#tel'))
                    || !checkEmpty($('#email')) ||!checkEmpty($('#date')) ||
                    !checkCorrect($('#name'),nameReg) || !checkCorrect($('#idCard'),IdCardReg) || !checkCorrect($('#tel'),telReg)  || !checkCorrect($('#email'),emailReg)){
                console.log('校验不通过');

            }else{
                console.log('提交数据');
            }
        }
    });

    $("#")
</script>
</body>

</html>