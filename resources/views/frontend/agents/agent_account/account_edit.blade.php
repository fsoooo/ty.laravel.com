@extends('frontend.agents.agent_home.base')
@section('content')
    <link rel="stylesheet" href="{{config('view_url.agent_url')}}css/account.css" />
<div class="content content-edit">
    <ul class="crumbs">
        <li><a href="#">账户设置</a><i class="iconfont icon-gengduo"></i></li>
        <li>认证资料填写</li>
    </ul>
    <form id="edit_form" action="/agent/account_edit_submit" method="post" enctype="multipart/form-data">
    <div class="form">
        <div class="avatar">
            <div class="upload-wrapper btn-upload">
                <div class="default-wrapper">
                    <div class="default">上传头像</div>
                </div>
            </div>
            <input hidden="hidden" type="file" onchange="upload(this);" accept="image/*">
            <input id="avatar" hidden type="text">
        </div>
        <ul class="information">
            <li>
                <span class="name">真实姓名</span>
                <span>{{$data->user['name']}}</span>
            </li>
            <li>
                <span class="name">工号</span>
                <span>{{$res->num}}</span>
            </li>
            <li>
                <span class="name">手机号码</span>
                <input id="tel" type="tel" name="phone" value="{{$data->user['phone']}}" />
            </li>
            <li>
                <span class="name">渠道</span>
                <span>{{$ditch->ditches[0]->name}}</span>
            </li>
            <li>
                <span class="name">邮箱</span>
                <input id="email" type="email" name="email" value="{{$data->user['email']}}"/>
            </li>
            <li>
                <span class="name">证件拍摄</span>请保证图片清晰四角完整

                <div class="photo-wrapper">
                    <p><span>身份证图片实例</span><span class="color-positive">（图片支持jpg, jpeg, png或bmp格式，单个文件大小≤2MB）</span></p>
                    <div class="photo-item clearfix">
                        <div class="example-wrapper"><img src="{{config('view_url.agent_url')}}img/idcard.png"></div>
                        <div class="upload-wrapper">
                            <img src="{{isset($agent_data->card_img_front)?url($agent_data->card_img_front):''}}"/>
                        </div>
                        <span class="z-btn z-btn-default btn-upload">重新上传</span>
                        <input hidden="hidden" type="file" onchange="upload(this);" accept="image/*" name="up">
                        <input id="front" hidden type="text"/>
                        <i class="error"></i>
                    </div>
                    <div class="photo-item clearfix">
                        <div class="example-wrapper"><img src="{{config('view_url.agent_url')}}img/idcard2.png"></div>
                        <div class="upload-wrapper">
                            <img src="{{isset($agent_data->card_img_backend)?url($agent_data->card_img_backend):''}}"/>
                        </div>
                        <span class="z-btn z-btn-default btn-upload">重新上传</span>
                        <input hidden="hidden" type="file" onchange="upload(this);" accept="image/*" name="down">
                        <input id="contrary" hidden type="text"/>
                        <i class="error"></i>
                    </div>
                    <div class="photo-item clearfix">
                        <div class="example-wrapper"><img src="{{config('view_url.agent_url')}}img/idcard3.png"></div>
                        <div class="upload-wrapper">
                            <img src="{{isset($agent_data->card_img_person)?url($agent_data->card_img_person):''}}"/>
                        </div>
                        <span class="z-btn z-btn-default btn-upload">重新上传</span>
                        <input hidden="hidden" type="file" onchange="upload(this);" accept="image/*" name="person">
                        <input id="inhand" hidden type="text"/>
                        <i class="error"></i>
                    </div>
                </div>
            </li>
        </ul>
        <div class="btn-wrapper">
            <span id="next" class="z-btn z-btn-default">保存</span>
        </div>
    </div>
        <input type="hidden" name="_token" value="{{csrf_token()}}">
    </form>
</div>
    <script>

        $('.btn-upload').click(function(){
            $(this).parent().find('input').click();
        });

        $('#tel').click(function(){
            Popups.open('.popups-call');
        });

        $('#next').click(function(){
            // 提交数据成功后
            $("#edit_form").submit();
        });
    </script>
    @stop