@extends('frontend.agents.agent_home.base')
@section('content')
    <link rel="stylesheet" href="{{config('view_url.agent_url')}}css/account.css" />
    <div class="content content-edit">
        <ul class="crumbs">
            <li><a href="#">账户设置</a><i class="iconfont icon-gengduo"></i></li>
            <li>认证资料填写</li>
        </ul>
        <div class="form">
            <form id="account_submit" action="/agent/account_approve_submit" method="post" enctype="multipart/form-data">
            <div class="avatar">
                <div class="upload-wrapper btn-upload">
                    <div class="default-wrapper">
                        <div class="default">添加头像</div>
                    </div>
                </div>
                <input hidden="hidden" type="file" onchange="upload(this,isDisabled);" accept="image/*" name="touxiang">
                <input id="avatar" hidden type="text">
            </div>
                <input type="hidden" name="_token" value="{{csrf_token()}}">
            <ul class="information">
                <li>
                    <span class="name">真实姓名</span>
                    <span>@if(isset($data->user['name'])){{$data->user['name']}}@else -- @endif</span>
                </li>
                <li>
                    <span class="name">工号</span>
                    <span>{{$data['job_number']}}</span>
                </li>
                <li>
                    <span class="name">手机号码</span>
                    <span>{{$data->user['phone']}}</span>
                </li>
                <li>
                    <span class="name">渠道</span>
                    <span>{{$ditch->ditches[0]['name']}}</span>
                </li>
                <li>
                    <span class="name">邮箱</span>
                    <input id="email" type="email" name="email" value="{{$data->user['email']}}" placeholder="必填"/>
                </li>
                <li>
                    <span class="name">证件拍摄</span>请保证图片清晰四角完整

                    <div class="photo-wrapper">
                        <p><span>身份证图片实例</span><span class="color-positive">（图片支持jpg, jpeg, png或bmp格式，单个文件大小≤2MB）</span></p>
                        <div class="photo-item clearfix">
                            <div class="example-wrapper"><img src="{{config('view_url.agent_url')}}img/idcard.png"></div>
                            <div class="upload-wrapper">
                                <img src="{{config('view_url.agent_url')}}img/add.png" alt="" />
                                <span class="text">身份证个人资料面照片</span>
                            </div>
                            <span class="z-btn z-btn-default btn-upload">上传照片</span>
                            <input hidden="hidden" type="file" onchange="upload(this,isDisabled);" accept="image/*" name="up">
                            <input id="front" hidden type="text"/>
                            <i class="error"></i>
                        </div>
                        <div class="photo-item clearfix">
                            <div class="example-wrapper"><img src="{{config('view_url.agent_url')}}img/idcard2.png"></div>
                            <div class="upload-wrapper">
                                <img src="{{config('view_url.agent_url')}}img/add.png" alt="" />
                                <span class="text">身份证国徽面照片</span>
                            </div>
                            <span class="z-btn z-btn-default btn-upload">上传照片</span>
                            <input hidden="hidden" type="file" onchange="upload(this,isDisabled);" accept="image/*" name="down">
                            <input id="contrary" hidden type="text"/>
                            <i class="error"></i>
                        </div>
                        <div class="photo-item clearfix">
                            <div class="example-wrapper"><img src="{{config('view_url.agent_url')}}img/idcard3.png"></div>
                            <div class="upload-wrapper">
                                <img src="{{config('view_url.agent_url')}}img/add.png" alt="" />
                                <span class="text">本人手持身份证个人资料面照片</span>
                            </div>
                            <span class="z-btn z-btn-default btn-upload">上传照片</span>
                            <input hidden="hidden" type="file" onchange="upload(this,isDisabled);" accept="image/*" name="person">
                            <input id="inhand" hidden type="text"/>
                            <i class="error"></i>
                        </div>
                    </div>
                </li>
            </ul>
            <div class="btn-wrapper">
                <span id="next" class="z-btn z-btn-default" disabled>下一步</span>
            </div>
            </form>
        </div>
    </div>
    <script src="{{config('view_url.agent_url')}}js/lib/swiper-3.4.2.min.js"></script>
    <script>

        var Ele = {
            email : $('#email'),
            avatar : $('#avatar'),
            front : $('#front'),
            contrary : $('#contrary'),
            inhand : $('#inhand'),
            next : $('#next'),
            btn_upload : $('.btn-upload'),
        }

        Ele.btn_upload.click(function(){
            $(this).parent().find('input').click();
        });

        // 按钮是否禁用
        Ele.email.bind('input porpertychange',function(){
            isDisabled();
        });

        function isDisabled(){
            if(!Ele.email.val() || !Ele.avatar.val() || !Ele.front.val() || !Ele.contrary.val() || !Ele.inhand.val()){
                Ele.next.prop('disabled',true);
            }else{
                Ele.next.prop('disabled',false);
            }
        }

        Ele.next.click(function(){
            $('#account_submit').submit();
        })
    </script>
    @stop