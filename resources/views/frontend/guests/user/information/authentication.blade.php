@extends('frontend.guests.person_home.account.base')

@section('content')
    <style>
        .main-wrapper {width: 1039px;padding: 60px 30px;}
        .user-wrapper {float: right;width: 424px;}
        .user-info>div:nth-child(2){margin: 30px;}
        .btn-save{margin: 88px 0 0 450px;}
        .form-wrapper input,.form-wrapper textarea{width: 316px;}
        .form-wrapper .form-name{width: 90px;}
        .photo-wrapper{padding-left: 90px;}
        .example-wrapper,.upload-wrapper{float: left;width: 290px;height: 180px;}
        .photo-item{margin-bottom: 30px;line-height: 180px;}
        .upload-wrapper{margin: 0 20px 0 100px;line-height: 180px;background: #f4f4f4;text-align: center;}
        .btn-upload{width: 104px;height: 30px;}
        .photo-wrapper p{margin: 20px 0;}
        .photo-wrapper .yellow{margin-left: 300px;}
        select{width:317px; background-position-x:296px;}
        #deadline{display: inline-block;width: 316px;}
        .laydate-icon{background-position-x: 316px!important;}
    </style>
    <form id="real_name_form" action="{{url('/information/real_name')}}" method="post" enctype="multipart/form-data" >
        {{ csrf_field() }}
        <ul class="form-wrapper">
    <li>
        <span class="form-name">真实姓名</span>
        @if(!empty($data['name']))
            <input id="name" class="mustFill" type="text" value="{{$data['name']}}" name="real_name"/>
        @else
            <input id="name" class="mustFill" type="text" value="" name="real_name"/>
        @endif
        <i class="error"></i>
    </li>
    <li>
        <span class="form-name">证件类型</span>
        <select id="certificatet" name="id_type">
            <option value="0">请选择</option>
            <option value="1" @if(!empty($data['id_type']) && $data['id_type']==1) selected @endif >身份证</option>
        </select>
        <i class="error"></i>
    </li>
    <li>
        <span class="form-name">证件号码</span>
        @if(!empty($data['code']))
            <input type="text" class="mustFill" id="idCard" value="{{$data['code']}}" name="id_code" />
        @else
            <input type="text" class="mustFill" id="idCard" value="" name="id_code" />
        @endif


        <i class="error"></i>
    </li>
    <li class="upload-idCard" style="display: none;">
        <span class="form-name">证件拍摄</span>请保证图片清晰四角完整
        <div class="photo-wrapper">
            <p><span>身份证图片实例</span><span class="yellow">（图片支持jpg, jpeg, png或bmp格式，单个文件大小≤2MB）</span></p>
            <div class="photo-item clearfix">
                <div class="example-wrapper"><img src="{{config('view_url.view_url')}}mobile/personal/image/zhengmian.png"/></div>
                @if(!empty($data->true_user_info['card_img_front']))
                <div class="upload-wrapper"><img src="/{{$data->true_user_info->card_img_front}}" alt=""></div>
                @else
                <div class="upload-wrapper">身份证正面照片</div>
                @endif
                <a href="javascript:;" class="btn-00a2ff btn-upload" style="line-height: 30px;margin-top: 80px">上传照片</a>
                <input hidden="hidden" type="file" onchange="upload(this);" accept="image/*" name="front" />
                <input id="front" hidden type="text" class="inputhidden"></input>
                <i class="error"></i>
            </div>
            <div class="photo-item clearfix">
                <div class="example-wrapper"><img src="{{config('view_url.view_url')}}mobile/personal/image/fanmian.png"/></div>
                @if(!empty($data->true_user_info['card_img_front']))
                    <div class="upload-wrapper"><img src="/{{$data->true_user_info->card_img_backend}}" alt=""></div>
                @else
                    <div class="upload-wrapper">身份证反面照片</div>
                @endif

                <a class="btn-00a2ff btn-upload" style="line-height: 30px;margin-top: 80px">上传照片</a>
                <input hidden="hidden" type="file" onchange="upload(this);" accept="image/*" name="back" />
                <input id="contrary" hidden type="text" class="inputhidden"></input>
                <i class="error"></i>
            </div>
            <div class="photo-item clearfix">
                <div class="example-wrapper"><img src="{{config('view_url.view_url')}}mobile/personal/image/shouchi.png"/></div>
                @if(!empty($data->true_user_info['card_img_front']))
                    <div class="upload-wrapper"><img src="/{{$data->true_user_info->card_img_person}}" alt=""></div>
                @else
                    <div class="upload-wrapper">手持身份证照片</div>
                @endif

                <a class="btn-00a2ff btn-upload" style="line-height: 30px;margin-top: 80px">上传照片</a>
                <input hidden="hidden" type="file" onchange="upload(this);" accept="image/*" name="body" />
                <input id="inhand" hidden type="text" class="inputhidden"></input>
                <i class="error"></i>
            </div>
        </div>
    </li>
    {{--<li>--}}
        {{--<span class="form-name">证件到期时间</span>--}}
        {{--<div class="laydate-icon" id="deadline">请选择</div>--}}
        {{--<input hidden type="text" class="inputhidden" ></input>--}}
        {{--<i class="error"></i>--}}
    {{--</li>--}}
</ul>
        <button id="submit" class="btn-00a2ff btn-save">保存</button>
    </form>



@stop
<script src="{{config('view_url.person_url').'js/lib/jquery-1.11.3.min.js'}}"></script>
<script src="{{config('view_url.person_url').'js/lib/laydate.js'}}"></script>
<script src="{{config('view_url.person_url').'js/common.js'}}"></script>
<script>



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
    laydate({
        elem: '#deadline',
        choose: function(datas) {
            $('#deadline').parent().find('.inputhidden').val(datas);
            console.log($('#deadline').parent().find('.inputhidden').val())
        }
    });

    $(function() {
        $('.btn-upload').click(function(){
            $(this).parent().find('input').click();
        });

        var val = $('#certificatet').val();
        if (val == 1){
            var target = $('.upload-idCard');
            target.show()
        }

        $('#certificatet').change(function(){
            var val = $(this).val();
            var target = $('.upload-idCard');
            val == 1 ? target.show() : target.hide();
        });

        $('.btn-save').click(function(){
            $('.form-wrapper .error').html('');

            var check1 = checkCorrect('#name',nameReg);
            var check2 = checkCorrect('#idCard',IdCardReg);
            var mustArry = $('.form-wrapper .mustFill');
            mustArry.each(function(){
                check3 = checkEmpty(this);
            });

            var check4 = checkUpload($('#front'));
            var check5 = checkUpload($('#contrary'));
            var check6 = checkUpload($('#inhand'));

            if(check1&&check2&&check3&&check4&&check5&&check6){
                console.log('提交数据')
                $("#real_name_form").submit();

            }
        });

    });

</script>





