<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>新建企业客户</title>
    <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
    <link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/lib/mui.min.css">
    <link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/lib/mui.picker.all.css">
    <link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/lib/iconfont.css" />
    <link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/common_agent.css" />
    <link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/client.css" />
</head>
<body id="add_company">
<div class="main">
    <header id="header" class="mui-bar mui-bar-nav">
        <a class="iconfont icon-fanhui mui-pull-left mui-action-back"></a>
        <h1 class="mui-title">新建企业客户</h1>
    </header>
    <div class="mui-content add">
        <form id="form" action="/agent_sale/client_add_company_submit" method="post" enctype="multipart/form-data">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="mui-scroll-wrapper">
                <div class="mui-scroll">
                    <div class="form-wrapper">
                        <div class="header-img">
                            <img src="{{config('view_url.agent_mob')}}img/upload_logo.png"/>
                            <input id="uploadImg" hidden="hidden" type="file" onchange="upLoadImg(this,upLoaded);" accept="image/*" name="uploadImg" />
                            <input id="avatar" hidden type="text"></input>
                        </div>
                        <ul>
                            <li>
                                <span class="name">企业名称</span>
                                <input class="mustFill" type="text" placeholder="必填" name="name" />
                            </li>
                            <!--<li>
                                <a href="client_type.html">
                                    <span class="name">企业类型</span>
                                    <input type="text" placeholder="请选择" />
                                    <input class="mustFill" hidden type="text"/>
                                    <i class="iconfont icon-gengduo"></i>
                                </a>
                            </li>-->
                            <li>
                                <span class="name">工商注册号</span>
                                <input class="mustFill" type="text" placeholder="必填" name="register_code" />
                            </li>
                            <li class="radioBox">
                                <span class="name">企业为</span>
                                <div class="select-box">
                                    <span class="zbtn-select active">三证合一企业</span>
                                    <span class="zbtn-select">非三证合一企业</span>
                                </div>
                                <div class="select-value">
                                    <input checked type="radio" value="0" name="comType"/>
                                    <input type="radio" value="1" name="comType"/>
                                </div>
                            </li>

                            <li class="comTypeOne">
                                <span class="name">统一信用代码</span>
                                <input type="text" placeholder="必填" name="credit_code" />
                            </li>
                            <li class="comTypeTwo">
                                <span class="name">组织机构代码</span>
                                <input type="text" placeholder="必填" name="organization_code" />
                            </li>
                            <li class="comTypeTwo">
                                <span class="name">纳税人识别码</span>
                                <input type="text" placeholder="必填" name="taxpayer_code" />
                            </li>
                            <li>
                                <span class="name">联系人姓名</span>
                                <input class="mustFill" id="Name" type="text" placeholder="必填" name="linkman_name" />
                            </li>
                            <li>
                                <span class="name">联系人电话</span>
                                <input class="mustFill" id="Tel" type="tel" maxlength="11" placeholder="必填" name="linkman_phone" />
                            </li>
                            <li>
                                <span class="name">联系人邮箱</span>
                                <input class="mustFill" id="Email" type="text" placeholder="必填" name="linkman_email" />
                            </li>

                            <li class="areaPicker">
                                <span class="name">企业所在地址</span>
                                <input type="text" placeholder="请选择"/>
                                <input class="mustFill" id="province" name="province" hidden type="text" value=""/>
                                <input id="city" hidden type="text" name="city" value=""/>
                                <input id="county" hidden type="text" name="county" value=""/>
                                <i class="iconfont icon-gengduo"></i>
                            </li>
                            <li>
                                <span class="name">企业详细地址</span>
                                <input class="mustFill" id="" type="text" placeholder="必填" name="address" />
                            </li>
                            <li>
                                <span class="name">其他信息</span>
                                <input type="text" placeholder="选填" name="other" />
                            </li>

                        </ul>
                    </div>
                </div>
            </div>
        </form>
        <div class="button-box">
            <button id="create" class="zbtn zbtn-default" disabled>添加</button>
        </div>
    </div>
</div>

<script src="{{config('view_url.agent_mob')}}js/lib/jquery-1.11.3.min.js"></script>
<script src="{{config('view_url.agent_mob')}}js/lib/mui.min.js"></script>
<script src="{{config('view_url.agent_mob')}}js/lib/area.js"></script>
<script src="{{config('view_url.agent_mob')}}js/lib/mui.picker.all.js"></script>
<script src="{{config('view_url.agent_mob')}}js/common_agent.js"></script>
<script>
    var company_type = 0; // 企业是否为三证合一企业

    $('.header-img').on('tap',function(){
        $('#uploadImg').click();
    });
    dataPicker('.zbtn-dropdown',function(){
        company_type === 0 ? check1() : check2();
    })
    areaPicker('.areaPicker',function(){
        company_type === 0 ? check1() : check2();
    });


    selectData('.radioBox','single');

    $('.zbtn-select').click(function() {
        company_type = $(this).index();
        if(company_type == 0){
            $('.comTypeOne').show();
            $('.comTypeTwo').hide();
        }else{
            $('.comTypeOne').hide();
            $('.comTypeTwo').show();
        }
        company_type === 0 ? check1() : check2();
    });



    function upLoaded(){
        company_type === 0 ? check1() : check2();
    }




    // 实时监听必填项
    $('input').bind('input propertychange', function() {
        company_type === 0 ? check1() : check2();

    });
    function check1(){
        if(!checkMustFill('.mustFill') || !checkMustFill('.comTypeOne input')){
            $('#create').prop('disabled',true);
        }else{
            $('#create').prop('disabled',false);
        }
    }
    function check2(){
        if(!checkMustFill('.mustFill') || !checkMustFill('.comTypeTwo input')){
            $('#create').prop('disabled',true);
        }else{
            $('#create').prop('disabled',false);
        }
    }

    // 点击提交数据
    $('#create').on('tap',function(){
        checkReg();

    });

    function checkReg(){
        if(!checkCorrect($('#Name'),nameReg) || !checkCorrect($('#Tel'),telReg) || !checkCorrect($('#Email'),emailReg)){
            console.log('校验不通过,不提交数据');
        }else{
            console.log('校验通过,提交数据');
            $('#form').submit();
        }
    }

</script>
</body>
</html>
