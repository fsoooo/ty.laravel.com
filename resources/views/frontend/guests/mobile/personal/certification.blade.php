<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>天眼互联-科技让保险无限可能</title>
    <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
    <link rel="stylesheet" href="{{config('view_url.view_url')}}mobile/personal/css/lib/mui.min.css">
    <link rel="stylesheet" href="{{config('view_url.view_url')}}mobile/personal/css/lib/mui.picker.all.css" />
    <link rel="stylesheet" href="{{config('view_url.view_url')}}mobile/personal/css/lib/iconfont.css" />
    <link rel="stylesheet" href="{{config('view_url.view_url')}}mobile/personal/css/common.css" />
    <style>
        body {background: #fff;}.mui-scroll-wrapper {top: .8rem;bottom: .8rem;}.mui-bar-nav {background: #025a8d;}
        .mui-icon-back,.mui-title {color: rgba(255, 255, 255, .8);}.applicant-wrapper ul {padding: 0 .3rem;}
        .applicant-wrapper li {height: 1rem;line-height: 1rem;position: relative;border-bottom: 1px solid #dcdcdc;}
        .applicant-wrapper li:last-child {border-bottom: none;}.applicant-wrapper li .iconfont {position: absolute;top: 0;right: 0;z-index: 1;font-size: .36rem;color: #00a2ff;}
        .applicant-wrapper li input {padding-left: 1.85rem;font-size: .28rem;border: none;overflow: hidden;text-overflow:ellipsis;white-space: nowrap;}
        .name {position: absolute;top: 0;left: 0;width: 1.6rem;z-index: 100; font-size: .28rem;color: #313131;}
        .example-wrapper{float: left;width: 2.2rem;height: 1.4rem;}.upload-wrapper{position: relative;float: right;width: 2.2rem;height: 1.4rem;background: #f4f4f4;}
        .photo-item{margin-bottom: .4rem;}.upload-tips{color: #adadad;text-align: center;}.form-name{margin-bottom: .2rem;}
        .applicant-wrapper li .iconfont.icon-add{right: .9rem;top: .2rem;}.form-name{color: #00a2ff;border-bottom: 1px solid #dcdcdc;}
        .select-sex {padding-left: 1.85rem;}.btn-select {position: relative;padding: 0 .14rem;margin-right: .18rem;height: .56rem;line-height: .56rem;border: 1px solid #dcdcdc;font-size: .28rem;}
        .btn-select.active {border: 1px solid #00a2ff;}
    </style>
</head>

<body>
<div class="main">
    <header class="mui-bar mui-bar-nav">
        <a class="mui-icon mui-icon-back mui-pull-left mui-action-back"></a>
        <h1 class="mui-title">实名认证</h1>
    </header>
    <div class="mui-content">
        <form action="{{url('/information/real_name')}}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
        <div class="mui-scroll-wrapper">
            <div class="mui-scroll">
                <div class="applicant-wrapper">
                    <ul class="applicant-partone">
                        <li>
                            <span class="name">姓名<span class="red">*</span></span>
                            @if(!empty($data['name']))
                                <input id="name" type="text" value="{{$data['name']}}" name="real_name" placeholder="请输入姓名"/>
                            @else
                                <input id="name" type="text" value="" name="real_name" placeholder="请输入姓名"/>
                                @endif

                        </li>
                        <li class="pickerone" data-options = '[{"id":1,"name":"身份证"}]'>
                            <span class="name">证件类别<span class="red">*</span></span>
                            <input type="text" placeholder="请选择"/>
                            <input id="certificateType" class="inputhidden" hidden="hidden" name="id_type" type="text"  value=""/>
                            <i class="iconfont icon-gengduo"></i>
                        </li>
                        {{--<li class="hide pickerfour">--}}
                            {{--<span class="name">出生日期<i class="red">*</i></span><input id="date" type="text" placeholder="必填" />--}}
                            {{--<i class="iconfont icon-gengduo"></i>--}}
                        {{--</li>--}}
                        {{--<li class="hide">--}}
                            {{--<span class="name">性别<i class="red">*</i></span>--}}
                            {{--<div class="select-sex">--}}
                                {{--<button class="btn-select active">男</button>--}}
                                {{--<button class="btn-select">女</button>--}}
                            {{--</div>--}}
                            {{--<input hidden type="radio" value="0">--}}
                            {{--<input hidden type="radio" value="1">--}}
                        {{--</li>--}}
                        <li>
                            <span class="name">证件号码<span class="red">*</span></span>
                            @if(!empty($data['code']))
                                <input id="idCard" placeholder="请输入" value="{{$data['code']}}" name="id_code" />
                            @else
                                <input id="idCard" placeholder="请输入" name="id_code" />
                            @endif

                        </li>
                    </ul>
                    <div class="division"></div>
                    <ul class="">
                        <li>
                            <div class="form-name">上传证件照片</div>
                            <div class="photo-item clearfix">
                                <div class="example-wrapper"><img src="{{config('view_url.view_url')}}mobile/personal/image/shouchi.png"/></div>
                                <div class="upload-wrapper btn-upload">
                                    @if(isset($data->true_user_info['card_img_person']))
                                        <img src="{{url($data->true_user_info['card_img_person'])}}" alt="">
                                    @endif
                                    <i class="iconfont icon-add"></i></div>
                                <div class="upload-tips">上传手持证件照</div>
                                <input hidden="hidden" type="file" onchange="upload(this);" accept="image/*" name="body" />
                                <input id="inhand" hidden type="text" class="inputhidden"/>
                            </div>
                            <div class="photo-wrapper">
                                <div class="photo-item clearfix">
                                    <div class="example-wrapper"><img src="{{config('view_url.view_url')}}mobile/personal/image/zhengmian.png"/></div>
                                    <div class="upload-wrapper btn-upload">
                                        @if(isset($data->true_user_info['card_img_front']))
                                            <img src="{{url($data->true_user_info['card_img_front'])}}" alt="">
                                        @endif
                                        <i class="iconfont icon-add"></i></div>
                                    <div class="upload-tips">上传身份证正面</div>
                                    <input hidden="hidden" type="file" onchange="upload(this);" accept="image/*" name="front" />
                                    <input id="contrary" hidden type="text" class="inputhidden"/>
                                </div>
                                <div class="photo-item clearfix">
                                    <div class="example-wrapper"><img src="{{config('view_url.view_url')}}mobile/personal/image/fanmian.png"/></div>
                                    <div class="upload-wrapper btn-upload">
                                        @if(isset($data->true_user_info['card_img_backend']))
                                            <img src="{{url($data->true_user_info['card_img_backend'])}}" alt="">
                                        @endif
                                        <i class="iconfont icon-add"></i></div>
                                    <div class="upload-tips">上传身份证反面</div>
                                    <input hidden="hidden" type="file" onchange="upload(this);" accept="image/*" name="back" />
                                    <input id="front" hidden type="text" class="inputhidden"/>
                                </div>
                            </div>
                        </li>
                    </ul>

                </div>
            </div>
        </div>
        <div class="buttonbox">
            <button class="btn btn-next">保存</button>
        </div>
        </form>
    </div>
</div>

<script src="{{config('view_url.view_url')}}mobile/personal/js/lib/jquery-1.11.3.min.js"></script>
<script src="{{config('view_url.view_url')}}mobile/personal/js/lib/mui.min.js"></script>
<script src="{{config('view_url.view_url')}}mobile/personal/js/common.js"></script>
<script src="{{config('view_url.view_url')}}mobile/personal/js/lib/mui.picker.all.js"></script>
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
        console.log($(this).parents('li').find('input:checked').val());
    });

    $('.btn-next').on('tap',function(){
        if($('.hide').is(':visible')){ // 证件类型不为身份证时
            if(!checkEmpty($('#name')) || !checkEmpty($('#certificateType')) || !checkEmpty($('#date')) || !checkEmpty($('#idCard')) ||
                    !checkUpload($('#inhand')) || !checkUpload($('#contrary')) || !checkUpload($('#front')) ||
                    !checkCorrect($('#name'),nameReg) || !checkCorrect($('#idCard'),IdCardReg)){
                console.log('校验不通过');
            }else{
                console.log('提交数据');
            }
        }else{
            if(!checkEmpty($('#name')) || !checkEmpty($('#certificateType')) || !checkEmpty($('#idCard')) ||
                    !checkUpload($('#inhand')) || !checkUpload($('#contrary')) || !checkUpload($('#front')) ||
                    !checkCorrect($('#name'),nameReg) || !checkCorrect($('#idCard'),IdCardReg)){
                console.log('校验不通过');
            }else{
                console.log('提交数据');
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
            picker.dispose();
        });
    });

    var upload = function(e){
        var _this = $(e);
        console.log(_this);
        var max_size=2097152;
        var $c = _this.parent().find('input[type=file]')[0];
        var file = $c.files[0],reader = new FileReader();
        if(!/\/(png|jpg|jpeg|bmp|PNG|JPG|JPEG|BMP)$/.test(file.type)){
            Mask.alert('图片支持jpg, jpeg, png或bmp格式',2);
            return false;
        }
        if(file.size>max_size){
            Mask.alert('单个文件大小必须小于等于2MB',2)
            return false;
        }
        reader.readAsDataURL(file);
        reader.onload = function(e){
            var html = '<img src="'+ e.target.result +'" />'
            _this.parent().find('.upload-wrapper').html(html);
            _this.parent().find('.inputhidden').val(e.target.result);
            //		    	console.log(_this.parent().find('.inputhidden').val())
        };
    };
    $('.btn-upload').click(function(){
        $(this).parent().find('input').click();
    });


</script>
</body>

</html>