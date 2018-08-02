<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>账户设置</title>
    <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
    <link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/lib/mui.min.css">
    <link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/lib/iconfont.css" />
    <link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/common_agent.css" />
    <link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/account.css" />
</head>
<body id="add_company">
<div class="main">
    <header id="header" class="mui-bar mui-bar-nav">
        <a class="iconfont icon-fanhui mui-pull-left mui-action-back"></a>
        <h1 class="mui-title">账户设置</h1>
    </header>
    <div class="mui-content content-edit">
        <div class="mui-scroll-wrapper">
            <form id="edit_form" action="/agent/account_edit_submit" method="post" enctype="multipart/form-data">
            <div class="mui-scroll">
                <div class="form-wrapper">
                    <ul>
                        <li>
                            <span class="name">渠道</span>
                            <input class="" id="" type="text" value="{{isset($ditch->ditches[0]['name'])?$ditch->ditches[0]['name']:'--'}}" readonly />
                        </li>
                        <li>
                            <span class="name">手机号码</span>
                            <input id="tel" type="text" name="phone" value="{{isset($agent_data->user['phone'])?$agent_data->user['phone']:'--'}}" />
                        </li>
                        <li>
                            <span class="name">邮箱地址</span>
                            <input class="" id="" type="text" name="email" value="{{isset($agent_data->user['email'])?$agent_data->user['email']:'--'}}" />
                        </li>
                    </ul>
                </div>
                <div class="img-wrapper">
                    <p class="title">证件上传<span>点击图片重新上传</span></p>
                    <ul>
                        <li>
                            <span>1.身份证个人资料面照片</span>
                            <div class="info-img">
                                <img src="{{isset($agent_data->user->trueUserInfo->card_img_front)?url($agent_data->user->trueUserInfo->card_img_front):config('view_url.agent_mob').'img/idcard3.png'}}"/>
                                <div class="account-mask"></div>
                                <input hidden="hidden" type="file" onchange="upLoad(this);" accept="image/*" name="up"  capture="camera"/>
                                <input id="avatar" hidden type="text"></input>
                            </div>
                        </li>
                        <li>
                            <span>2.身份证国徽面照片</span>
                            <div class="info-img">
                                <img src="{{isset($agent_data->user->trueUserInfo->card_img_backend)?url($agent_data->user->trueUserInfo->card_img_backend):config('view_url.agent_mob').'img/idcard1.png'}}"/>
                                <div class="account-mask"></div>
                                <input hidden="hidden" type="file" onchange="upLoad(this);" accept="image/*" name="down" capture="camera" />
                                <input id="avatar" hidden type="text"></input>
                            </div>
                        </li>
                        <li>
                            <span>3.本人手持身份证个人资料面照片</span>
                            <div class="info-img">
                                <img src="{{isset($agent_data->user->trueUserInfo->card_img_person)?url($agent_data->user->trueUserInfo->card_img_person):config('view_url.agent_mob').'img/idcard2.png'}}"/>
                                <div class="account-mask"></div>
                                <input hidden="hidden" type="file" onchange="upLoad(this);" accept="image/*" name="person" capture="camera" />
                                <input id="avatar" hidden type="text"></input>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
                <input type="hidden" name="_token" value="{{csrf_token()}}">
            </form>
        </div>
        <div class="button-box">
            <button id="next" class="zbtn zbtn-default">保存</button>
        </div>
    </div>
</div>


<div class="mui-popover popover-call">
    <div class="popover-wrapper">
        <div class="popover-content">
            <p class="red">修改手机号请致电业管人员</p>
            <p class="tel"><span>联系方式</span>。。。</p>
        </div>
        <div class="popover-footer">
            <a href="sms:156-4568-5625" class="zbtn zbtn-hollow">短信</a>
            <a href="tel:156-4568-5625" class="zbtn zbtn-default">呼叫</a>
        </div>
    </div>
</div>


<script src="{{config('view_url.agent_mob')}}js/lib/jquery-1.11.3.min.js"></script>
<script src="{{config('view_url.agent_mob')}}js/lib/mui.min.js"></script>
<script src="{{config('view_url.agent_mob')}}js/common_agent.js"></script>
<script>
    var upLoad = function(e){
        var _this = $(e).parent();
        console.log(_this)
        var max_size=2097152;
        var $c = _this.find('input[type=file]')[0];
        var file = $c.files[0],reader = new FileReader();
        if(!/\/(png|jpg|jpeg|bmp|PNG|JPG|JPEG|BMP)$/.test(file.type)){
            Mask.alert('图片支持jpg, jpeg, png或bmp格式',2);
            return false;
        }
//        if(file.size>max_size){
//            Mask.alert('单个文件大小必须小于等于2MB',2)
//            return false;
//        }
        reader.readAsDataURL(file);
        reader.onload = function(e){
            _this.find('img').attr('src',e.target.result);
            var $targetEle = _this.find('input:hidden').eq(1);
            $targetEle.val(e.target.result);
            _this.find('.account-mask').remove();
        };
    };

    // 点击电话号码弹出层
    $('#tel').on('tap',function(){
        mui('.popover-call').popover('toggle');
    });

    // 上传照片
    $('.info-img').on('tap',function(){
        $(this).find('input').click();
    });

    // 按钮是否禁用
    $('input').bind('input propertychange', function() {
        $('#next')[0].disabled = !$(this).val()
    });

    $('#next').on('tap',function(){
        $("#edit_form").submit();
    });

</script>
</body>
</html>
