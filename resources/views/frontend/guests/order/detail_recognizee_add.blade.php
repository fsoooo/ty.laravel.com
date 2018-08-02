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
    <style type="text/css">
        body {background: #fff;}.mui-scroll-wrapper {top: .9rem;bottom: .9rem;}.mui-bar-nav {background: #025a8d;}
    </style>
</head>

<body>
<div class="main">
    <header class="mui-bar mui-bar-nav">
        <a class="mui-icon mui-icon-back mui-pull-left mui-action-back"></a>
        <h1 class="mui-title">添加人员</h1>
    </header>
    <div class="mui-content">
        <form id="form" action="/order/detail_recognizee_add_submit" method="post">
            <input type="hidden" name="_token" value="{{csrf_token()}}">
        <div class="mui-scroll-wrapper">
            <div class="mui-scroll">
                <div>
                    <ul class="form-wrapper">
                        <li>
                            <span class="name">姓名</span><input id="name" name="name" class="mustFill" type="text"/>
                        </li>
                        <li class="radioBox">
                            <span class="name">性别</span>
                            <div class="select-box">
                                <span class="zbtn-select active">男</span>
                                <span class="zbtn-select">女</span>
                            </div>
                            <div class="select-value">
                                <input checked type="radio" value="1" name="sex">
                                <input type="radio" value="0" name="sex">
                            </div>
                        </li>
                        <li class="pickerone" data-options='[{"value": "0","text": "身份证"}, {"value": "1","text": "台胞证"}]'>
                            <span class="name">证件类别</span>
                            <input type="text" class="mustFill" placeholder="请选择">
                            <input id="certificateType" class="inputhidden" hidden="" name="id_type" type="text" value="">
                            <i class="iconfont icon-gengduo"></i>
                        </li>
                        <li>
                            <span class="name">证件号码</span>
                            <input id="idCard" type="tel" class="mustFill" name="id_code" value=""/>
                        </li>
                        <li>
                            <span class="name">手机号</span>
                            <input id="phone" type="tel" class="mustFill" name="phone" value=""/>
                        </li>
                        <input type="hidden" name="product" value="{{$data['ty_product_id']}}">
                    </ul>
                </div>
            </div>
        </div>
        </form>
        <div class="buttonbox">
            <button id="form_submit" class="btn btn-next" disabled>下一步</button>
        </div>

    </div>
</div>

<script src="{{config('view_url.view_url')}}mobile/personal/js/lib/jquery-1.11.3.min.js"></script>
<script src="{{config('view_url.view_url')}}mobile/personal/js/lib/mui.min.js"></script>
<script src="{{config('view_url.view_url')}}mobile/personal/js/lib/mui.picker.all.js"></script>
<script src="{{config('view_url.view_url')}}mobile/personal/js/common.js"></script>
<script>
    var Ele = {
        btn_next : $('.btn-next')
    }
    selectData('.radioBox','single');
    dataPicker('.pickerone',function(){isDisabled();});
    $('input').bind('input propertychange',function(){isDisabled();});

    function isDisabled(){
        if(checkMustFill('.mustFill')){
            Ele.btn_next.prop('disabled',false);
        }else{
            Ele.btn_next.prop('disabled',true);
        }
    }
    $('.btn-next').on('tap',function(){
        if(checkCorrect('#name',nameReg)){
            if($('#certificateType').val() == 0){
//                if(checkCorrect('#idCard',IdCardReg)){
                    console.log('通过校验，提交数据');
                    $("#form").submit();
//                }
            }else{
                console.log('通过校验，提交数据');
                $("#form").submit();
            }
        }
    })
</script>
</body>

</html>