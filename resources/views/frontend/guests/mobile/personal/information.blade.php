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
        .mui-scroll-wrapper {top: .9rem;bottom: .9rem;}
        .mui-bar-nav {background: #025a8d;}
        .mui-icon-back,.mui-title {color: rgba(255, 255, 255, .8);}
        .applicant-wrapper {background: #fff;padding-bottom: 2rem;}
        .applicant-partone{padding: 0 .3rem;}
        .applicant-partone li {height: 1rem;line-height: 1rem;position: relative;border-bottom: 1px solid #dcdcdc;}
        .applicant-partone li .iconfont {position: absolute;top: 0;right: 0;z-index: 1;font-size: .36rem;color: #00a2ff;}
        .applicant-partone li input {padding-left: 1.85rem;font-size: .28rem;border: none;overflow: hidden;text-overflow:ellipsis;white-space: nowrap;}
        .name {position: absolute;top: 0;left: 0;width: 1.6rem;z-index: 100; font-size: .28rem;color: #313131;}
        .user-wrapper{padding: 0 .3rem;height: 1.6rem;line-height: 1.6rem;}
        .user-header-img{margin-top: .3rem;width: 1rem;height: 1rem;border-radius: 50%;}
        .user-wrapper li{position: relative;}
        .btn-select {position: relative;padding: 0 .14rem;margin-right: .18rem;height: .56rem;line-height: .56rem;border: 1px solid #dcdcdc;font-size: .28rem;}
        .btn-select.active {border: 1px solid #00a2ff;}
        .btn-select.active:after {content: '';position: absolute;right: -1px;bottom: -3px;width: 0;height: 0;border-top: 4px solid transparent;border-bottom: 4px solid transparent;border-left: 4px solid #00a2ff;transform: rotate(45deg);}
        .select-sex{padding-left: 1.85rem;}
    </style>
</head>

<body>
<div class="main">
    <header class="mui-bar mui-bar-nav">
        <a class="mui-icon mui-icon-back mui-pull-left mui-action-back"></a>
        <h1 class="mui-title">个人信息</h1>
    </header>
    <div class="mui-content">
        <form id="form_data" action="/mpersonal/info_submit" method="post" >
            {{ csrf_field() }}
        <div class="mui-scroll-wrapper">
            <div class="mui-scroll">
                <div class="applicant-wrapper">
                    <ul class="user-wrapper">
                        <li>
                            <span class="name">头像</span>
                            <div class="user-header-img fr">
                                <!--性别：男-->
                                <!--<img src="image/boy.png"/>-->
                                <!--性别：女-->
                                <img src="{{config('view_url.view_url')}}mobile/personal/image/girl.png"/>
                            </div>
                        </li>
                    </ul>
                    <div class="division"></div>

                    <ul class="applicant-partone">
                        <li>
                            <span class="name">姓名<i class="red">*</i></span><input id="name" name="name" type="text" @if(isset($data['name'])) value="{{$data['name']}}"@endif placeholder="请添加"/>
                        </li>
                        <li class="pickerone" data-options = '[{"id":1,"name":"身份证"}]'>
                            <span class="name">证件类别<i class="red">*</i></span>
                            <input type="text" placeholder="请选择"/>
                            <input id="certificateType" class="inputhidden" hidden="hidden" name="id_type" type="text"  value=""/>
                            <i class="iconfont icon-gengduo"></i>
                        </li>
                        <li class="hide pickerfour">
                            <span class="name">出生日期<i class="red">*</i></span><input id="date" name="birthday" type="text" placeholder="必填" />
                            <i class="iconfont icon-gengduo"></i>
                        </li>
                        <li class="hide">
                            <span class="name">性别<i class="red">*</i></span>
                            <div class="select-sex">
                                <button class="btn-select active">男</button>
                                <button class="btn-select">女</button>
                            </div>
                            <input hidden type="radio" value="0" name="sex">
                            <input hidden type="radio" value="1" name="sex">
                        </li>
                        <li>
                            <span class="name">证件号码<i class="red">*</i></span><input id="idCard" name="id_code" @if(isset($data['code'])) value="{{$data['code']}}"@endif placeholder="请添加"/>
                        </li>
                        <li>
                            <span class="name">常用地址<i class="red">*</i></span><input id="address" name="address" type="text"  placeholder="请添加"/>
                        </li>
                        <li>
                            <span class="name">详细地址<i class="red">*</i></span><input id="addressDetails" name="inAddress" type="text"  placeholder="请添加"/>
                        </li>
                        <li>
                            <span class="name">邮编</span><input type="text" name="postCode"  placeholder="请添加"/>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        </form>
        <div class="buttonbox">
            <button class="btn btn-next">确定</button>
        </div>

    </div>
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

            // certificateType设为身份证id
            var certificateType = 6;
            if(items[0].id !== certificateType){
                $('.hide').show();
            }else{
                $('.hide').hide();
            }
        });
    });

    $('.btn-select').click(function() {
        $(this).addClass('active').siblings().removeClass('active');
        var index = $(this).index();
        $(this).parents('li').find('input').prop('checked',false);
        var a =$(this).parents('li').find('input').eq(index).prop('checked',true);
        console.log($(this).parents('li').find('input:checked').val())
    })

    $('.btn-next').on('tap',function(){
        if($('.hide').is(':visible')){ // 证件类型不为身份证时
            if(!checkEmpty($('#name')) || !checkEmpty($('#certificateType')) || !checkEmpty($('#date')) || !checkEmpty($('#idCard')) ||
                    !checkEmpty($('#address')) || !checkEmpty($('#addressDetails')) || !checkCorrect($('#name'),nameReg) || !checkCorrect($('#idCard'),IdCardReg)){
                console.log('校验不通过');
            }else{
                console.log('提交数据');
                $('#form_data').submit();
            }
        }else{
            if(!checkEmpty($('#name')) || !checkEmpty($('#certificateType')) || !checkEmpty($('#idCard')) ||
                    !checkEmpty($('#address')) || !checkEmpty($('#addressDetails')) || !checkCorrect($('#name'),nameReg) || !checkCorrect($('#idCard'),IdCardReg)){
                console.log('校验不通过');
            }else{
                console.log('提交数据');
                $('#form_data').submit();

            }
        }
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
        });
    });
</script>
</body>

</html>