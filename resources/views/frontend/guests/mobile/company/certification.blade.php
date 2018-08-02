<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>天眼互联-科技让保险无限可能</title>
    <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
    <link rel="stylesheet" href="{{config('view_url.view_url')}}mobile/company/css/lib/mui.min.css">
    <link rel="stylesheet" href="{{config('view_url.view_url')}}mobile/company/css/lib/mui.picker.all.css" />
    <link rel="stylesheet" href="{{config('view_url.view_url')}}mobile/company/css/lib/iconfont.css" />
    <link rel="stylesheet" href="{{config('view_url.view_url')}}mobile/company/css/common.css" />
    <style>
        body {background: #fff;}.mui-scroll-wrapper {top: .9rem;bottom: .9rem;}.mui-bar-nav {background: #025a8d;}
        .mui-icon-back,.mui-title {color: rgba(255, 255, 255, .8);}.applicant-wrapper ul {padding: 0 .3rem;}
        .applicant-wrapper li {height: 1rem;line-height: 1rem;position: relative;border-bottom: 1px solid #dcdcdc;}
        .applicant-wrapper li .iconfont {position: absolute;top: 0;right: 0;z-index: 1;font-size: .36rem;color: #00a2ff;}
        .applicant-wrapper li input {padding-left: 1.85rem;font-size: .28rem;border: none;overflow: hidden;text-overflow:ellipsis;white-space: nowrap;}
        .name {position: absolute;top: 0;left: 0;width: 1.7rem;z-index: 100; font-size: .28rem;color: #313131;}
        .example-wrapper{float: left;width: 2.2rem;height: 1.4rem;}
        .upload-wrapper{position: relative;width: 3rem;height: 2.16rem;}
        .photo-item{margin-bottom: .4rem;}.upload-tips{color: #adadad;text-align: center;}.form-name{margin-bottom: .2rem;}
        .form-name{color: #00a2ff;border-bottom: 1px solid #dcdcdc;}
        .select-sex {padding-left: 1.85rem;}.btn-select {position: relative;padding: 0 .14rem;margin-right: .18rem;height: .56rem;line-height: .56rem;border: 1px solid #dcdcdc;font-size: .28rem;}
        .btn-select.active {border: 1px solid #00a2ff;}
        .btn-select.active:after {content: '';position: absolute;right: -1px;bottom: -3px;width: 0;height: 0;border-top: 4px solid transparent;border-bottom: 4px solid transparent;border-left: 4px solid #00a2ff;transform: rotate(45deg);}
        .btn-upload{width: 2rem;height: .6rem;line-height: .6rem;background: #00A2FF;color: #fff;margin-left: 1.85rem;}
        li.preview-wrapper{display: none;padding-left: 2rem;border-bottom: none;}
        .preview-wrapper .title{line-height: .6rem;color: #00a2ff;}
    </style>
</head>

<body>
<div class="main">
    <header class="mui-bar mui-bar-nav">
        <a class="mui-icon mui-icon-back mui-pull-left mui-action-back"></a>
        <h1 class="mui-title">企业认证</h1>
    </header>
    <div class="mui-content">
        <form action="/cpersonal/approve_submit" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
        <div class="mui-scroll-wrapper">
            <div class="mui-scroll">
                <div class="applicant-wrapper">
                    <ul class="applicant-partone">
                        <li>
                            <span class="name">企业名称</span><input id="name" name="name" value="{{$data['name']?? '--'}}" type="text" placeholder="请填写"/>
                        </li>
                        <!--<li class="pickerone" data-options = '[{"id":6,"api_from_uuid":"Wk","name":"\u4e2d\u56fd\u94f6\u884c\u4e2d\u56fd\u94f6\u884c\u4e2d\u56fd\u94f6\u884c\u4e2d\u56fd\u94f6\u884c\u4e2d\u56fd\u94f6\u884c","number":"104","code":"BOC","status":0},{"id":7,"api_from_uuid":"Wk","name":"\u4e2d\u56fd\u4ea4\u901a\u94f6\u884c","number":"301","code":"BCOM","status":0},{"id":8,"api_from_uuid":"Wk","name":"\u6d4b\u8bd5\u4e09","number":"12345643154552","code":"500113198512176918","status":0}]'>
                            <span class="name">企业类型</span>
                            <input type="text" placeholder="请选择"/>
                            <input id="certificateType" class="inputhidden" hidden="hidden" type="text"  value=""/>
                            <i class="iconfont icon-gengduo"></i>
                        </li>-->
                        <li>
                            <div class="select-sex">
                                <a href="javascript:;" class="btn-select active">三证合一企业</a>
                                <a href="javascript:;" class="btn-select">非三证合一企业</a>
                            </div>
                            <input hidden type="radio" value="0" name="id_type">
                            <input hidden type="radio" value="1" name="id_type">
                        </li>
                        <li class="hide">
                            <span class="name">组织机构代码</span><input id="organizationCode" type="text" value="{{$data->authentication['code']??'--'}}" name="code" placeholder="请填写"/>
                        </li>
                        <li class="hide">
                            <span class="name">营业执照编号</span><input id="licenseNumber" type="text" value="{{$data->authentication['license_code']??'--'}}" name="license_code" placeholder="请填写"/>
                        </li>
                        <li class="hide">
                            <span class="name">纳税人识别号</span><input id="identifyNumber" type="text" value="{{$data->authentication['tax_code']??'--'}}" name="tax_code" placeholder="请填写"/>
                        </li>
                        <li>
                            <span class="name">统一信用代码</span><input id="creditCode" type="text" value="{{$data->authentication['credit_code']??'--'}}" name="credit_code" placeholder="请填写"/>
                        </li>
                        <li class="pickerfour">
                            <span class="name">企业所在地址</span>
                            <input type="text" placeholder="请选择"/>
                            <input id="province" hidden type="text" value="" name="province"/>
                            <input id="city" hidden type="text" value="" name="city"/>
                            <input id="county" hidden type="text" value="" name="county"/>
                            <i class="iconfont icon-gengduo"></i>
                        </li>
                        <li>
                            <span class="name">企业详细地址</span>
                            <input id="address" type="text" value="{{$data['address']??'--'}}" name="inAddress" placeholder="请填写"/>
                        </li>
                        <li>
                            <span class="name">企业营业执照</span>
                            <a href="javascript:;" class="btn btn-upload">上传</a>
                        </li>
                        <li class="preview-wrapper">
                            <div class="title">预览图</div>
                            <input id="uploadImg" hidden="hidden" type="file" name="upFile" onchange="upload(this);" accept="image/*" />
                            <input id="licenseImg" hidden type="text" class="inputhidden" name="file"></input>
                            <div class="upload-wrapper"></div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="buttonbox">
            <button class="btn btn-next" type="submit">确定</button>
        </div>
        </form>
    </div>
</div>

<script src="{{config('view_url.view_url')}}mobile/company/js/lib/jquery-1.11.3.min.js"></script>
<script src="{{config('view_url.view_url')}}mobile/company/js/lib/mui.min.js"></script>
<script src="{{config('view_url.view_url')}}mobile/company/js/lib/area.js"></script>
<script src="{{config('view_url.view_url')}}mobile/company/js/lib/mui.picker.all.js"></script>
<script src="{{config('view_url.view_url')}}mobile/company/js/common.js"></script>
<script>

    function changeCityData(areaData){
        var cityData = [];
        for(var i in areaData.province){
            var level1 = {};
            level1.value = i;
            level1.text = areaData.province[i];
            level1.children = [];
            for(var i in areaData.city){
                if(i === level1.value){
                    var arr = areaData.city[i];
                    for(var i=0;i<arr.length;i++){
                        var level2 = {};
                        level2.value = arr[i][1];
                        level2.text = arr[i][0];
                        level1.children.push(level2);
                        level2.children = [];
                        for(var i in areaData.county){
                            if(i === level2.value){
                                var level2arr = areaData.county[i];
                                for(var i=0;i<level2arr.length;i++){
                                    var level3 = {};
                                    level3.value = level2arr[i][1];
                                    level3.text = level2arr[i][0];
                                    level2.children.push(level3);
                                }
                            }
                        }
                    }
                }
            }
            cityData.push(level1)
        }
        return cityData;
    }

    var cityPicker = new mui.PopPicker({layer: 3});
    $('.pickerfour').on('tap',function(){
        var _this = $(this);
        cityPicker.setData(changeCityData(areaData));
        cityPicker.show(function(items) {
            _this.find('input:text').val(items[0].text+"-"+items[1].text+"-"+items[2].text);
            _this.find('.inputhidden').val(items[0].id);
            $('#province').val(items[0].value);
            $('#city').val(items[1].value);
            $('#county').val(items[2].value);
        });
    });

    $('.btn-select').click(function() {
        $(this).addClass('active').siblings().removeClass('active');
        var index = $(this).index();
        index == 1 ? $('.hide').show() : $('.hide').hide();
        $(this).parents('li').find('input').prop('checked',false);
        $(this).parents('li').find('input').eq(index).prop('checked',true);
        console.log($(this).parents('li').find('input:checked').val());
    });

    $('.btn-next').on('tap',function(){
        if($('.hide').is(':visible')){ // 企业类型为非三证合一时
            if(!checkEmpty($('#name')) || !checkEmpty($('#organizationCode')) || !checkEmpty($('#licenseNumber')) ||
                    !checkEmpty($('#identifyNumber')) || !checkEmpty($('#creditCode')) || !checkEmpty($('#province')) ||
                    !checkEmpty($('#address'))|| !checkUpload($('#uploadImg'))){
                console.log('校验不通过');
            }else{
                console.log('提交数据');
            }
        }else{
            if(!checkEmpty($('#name')) || !checkEmpty($('#creditCode')) || !checkEmpty($('#province')) ||!checkEmpty($('#address'))|| !checkUpload($('#uploadImg'))){
                console.log('校验不通过');
            }else{
                console.log('提交数据');
            }
        }
    });

    var upload = function(e){
        var _this = $(e);
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
            $('.upload-wrapper').html(html);
            $('#inhand').val(e.target.result);
            console.log($('#inhand').val())
            $('.preview-wrapper').show();
        };
    };
    $('.btn-upload').click(function(){
        $('#uploadImg').click();
    });

    $(".mui-action-back").click(function(){
        history.back();
    })
</script>
</body>

</html>