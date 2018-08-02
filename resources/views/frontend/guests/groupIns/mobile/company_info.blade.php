<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>天眼互联-科技让保险无限可能</title>
    <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
    <link rel="stylesheet" href="{{config('view_url.mobile_group_ins')}}css/lib/mui.min.css">
    <link rel="stylesheet" href="{{config('view_url.mobile_group_ins')}}css/lib/mui.picker.all.css">
    <link rel="stylesheet" href="{{config('view_url.mobile_group_ins')}}css/lib/iconfont.css" />
    <link rel="stylesheet" href="{{config('view_url.mobile_group_ins')}}css/common.css" />
    <link rel="stylesheet" href="{{config('view_url.mobile_group_ins')}}css/information.css" />
    <style>
        .form-wrapper{padding: 0 .2rem;}
        .switchone{margin-top: .2rem;}
        .form-wrapper select{width: 80%;height:100%;padding: 0;vertical-align: baseline;}
        .mui-popover1 .icon-guanbi{
            margin-top: 2.2rem;
        }
        .mui-popover2 .icon-guanbi{
            margin-top: 2.2rem;
        }
        .recognizee-operation{
            height: .8rem;
        }
    </style>
</head>
<body>
<div class="main">
    <header class="mui-bar mui-bar-nav">
        <a class="mui-icon mui-icon-back mui-pull-left mui-action-back"></a>
        <h1 class="mui-title">投保信息</h1>
    </header>
    <div class="mui-content">
        <div class="mui-scroll-wrapper">
            <div class="mui-scroll">
                <div class="information-wrapper">
                    <form action="/ins/mobile_group_ins/mobile_group_confirm_form" method="post" id="form_submit">
                    <ul class="form-wrapper">
                        @foreach($ins['insurance_attributes'] as $k => $v)
                            @php $beibaoren_key = -1; @endphp
                            @if($v['module_key'] == 'ty_base')
                                @foreach($v['productAttributes'] as $vk => $vv)
                                    <li class="zbtn-dropdown pickerfour" >
                                        <span class="name">{{$vv['name']}}</span>
                                        @if($vv['type'] == 1)
                                            <input type="text" id="{{$vv['ty_key']}}" name="insurance_attributes[{{ $v['module_key'] }}][{{$vv['ty_key']}}]" value="" placeholder="请选择">
                                            <input class="mustFill" hidden="" type="text">
                                            <i class="iconfont icon-gengduo"></i>
                                        @endif
                                    </li>
                                @endforeach
                            @endif
                        @endforeach
                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                            <input type="hidden" name="identification" value="{{$identification}}">
                            <input type="hidden" name="ins" value="{{json_encode($ins)}}">
                            <input type="hidden" name="json" value="{{json_encode($json)}}">
                            <input type="hidden" name="product" value="{{json_encode($product)}}">
                            <input type="hidden" name="insurance_attributes[ty_toubaoren]" value="{{json_encode($toubaoren_data['insurance_attributes']['ty_toubaoren'])}}">
                            <input type="hidden" name="insurance_attributes[ty_beibaoren]" value="{{$beibaoren_data?json_encode($beibaoren_data['insurance_attributes']['ty_beibaoren']):''}}">
                    </ul>
                    </form>
                    <div class="division"></div>
                    <ul class="form-wrapper">
                        <li style="border: none;color: #00a2ff;">投保人承诺被保人职业符合1-3类
                            <div class="switchone mui-switch mui-switch-mini fr">
                                <div class="mui-switch-handle"></div>
                            </div>
                        </li>
                        <li><a href="{{ $ins['template_url'] }}" class="color-primary">查看{{$product['product_name']}}职业类别表</a></li>
                    </ul>
                    <div class="division"></div>
                    <div class="section3">
                        <span class="name">被保人</span>
                        <span class="tips">*被保人数在{{$json['min_math']}}到{{$json['max_math']}}之间*</span>
                        <button class="btn btn-add fr">添加</button>
                    </div>
                    <div class="division"></div>
                    <div class="recognizee-wrapper">
                        <div class="title">被保人员</div>
                        <ul>
                            @if($beibaoren_data)
                                @foreach($beibaoren_data['insurance_attributes']['ty_beibaoren'] as $k=>$v)
                                    <li class="k" id="{{$k}}">
                                        <span class="recognizee-name">{{$v['ty_beibaoren_name']}}<span>
                                            @if(substr($v['ty_beibaoren_id_number'],16,1)%2==1)
                                                男
                                            @else
                                                女
                                            @endif
                                        </span><span><i class="iconfont icon-shenfenzheng"></i>{{$v['ty_beibaoren_id_number']}}</span><span><i class="iconfont icon-shouji"></i>{{$v['ty_beibaoren_phone']}}</span>
                                        </span>
                                        <div class="recognizee-operation">
                                            <div class="btn-wrapper fr">
                                                <button class="btn btn-edite">修改</button>
                                                <button class="btn btn-delete">删除</button>
                                            </div>
                                            {{--<div class="recognizee-title">测试方案</div>--}}
                                            {{--<div class="recognizee-date"></div>--}}
                                        </div>
                                    </li>
                                @endforeach
                            @else
                                <li>
                                    暂时没有添加被保人员
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="buttonbox">
            <button id="next" class="btn btn-submit" disabled="disabled">下一步</button>
        </div>
    </div>
</div>
<!--点击按钮出现手动填写保单的弹层-->
<form id="form" action="/ins/add_beibaoren_info_submit" method="post">
    <div class="mui-popover mui-popover0">
        <i class="iconfont icon-guanbi"></i>
        <div class="fill-wrapper">
            <div class="fill-title">被保人信息</div>
            <ul>
                <li>
                    <span class="name">姓名</span><input type="text" placeholder="必填" name="insurance_attributes[ty_beibaoren][ty_beibaoren_name]" />
                </li>
                {{--<li class="pickerone" data-options = '[{"id":1,"api_from_uuid":"Wk","name":"身份证","number":"104","code":"BOC","status":0},{"id":7,"api_from_uuid":"Wk","name":"护照","number":"301","code":"BCOM","status":0}]'>--}}
                {{--<span class="name">证件类别</span><input id="certificatetype1" type="text" />--}}
                {{--<input id="name" class="inputhidden" hidden="hidden" type="text"  value=""/>--}}
                {{--<i class="iconfont icon-gengduo"></i>--}}
                {{--</li>--}}
                <li>
                    <span class="name">证件号码</span><input type="text" placeholder="必填" name="insurance_attributes[ty_beibaoren][ty_beibaoren_id_number]"/>
                </li>
                <li>
                    <span class="name">职业</span><input type="text" placeholder="必填" name="insurance_attributes[ty_beibaoren][ty_beibaoren_job]"/>
                </li>
                <li>
                    <span class="name">手机号码</span><input type="text" name="insurance_attributes[ty_beibaoren][ty_beibaoren_phone]" placeholder="必填"/>
                </li>
                {{--<li class="pickerone hide" data-options = '[{"id":1,"name":"男"},{"id":0,"name":"女"}]'>--}}
                {{--<span class="name">性别</span><input type="text" placeholder="" />--}}
                {{--<input id="name1" class="inputhidden" hidden="hidden" type="text"  value=""/>--}}
                {{--<i class="iconfont icon-gengduo"></i>--}}
                {{--</li>--}}
                {{--<li class="pickerfour hide">--}}
                {{--<span class="name">出生日期</span><input id="date" type="text" />--}}
                {{--<i class="iconfont icon-gengduo"></i>--}}
                {{--</li>--}}
            </ul>
            <input type="hidden" name="_token" value="{{csrf_token()}}">
            <input type="hidden" name="manager" value="1">
            <input type="hidden" name="identification" value="{{$identification}}">
            <button class="btn btn-confirm btn-sure">确定</button>
        </div>
    </div>
</form>
<!--点击添加的按钮弹出可选择的层-->
<div class="mui-popover mui-popover1">
    <i class="iconfont icon-guanbi"></i>
    <div class="choose-wrapper">
        <ul class="chooselist">
            <li class="passive">被保人填写</li>
            <li class="Manual">手动添加</li>
        </ul>
    </div>
</div>
<!--二维码要出来的弹层-->
<div class="mui-popover  mui-popover2">
    <i class="iconfont icon-guanbi"></i>
    <div class="qrcode-wrapper">
        <div class="qrcode">
            <img src="{{$qrcode_url}}" alt="" />
            <span class="download">点击下载</span>
        </div>
    </div>
</div>

<!--修改要出来的弹层-->
<div class="mui-popover  mui-popover3">
    <i class="iconfont icon-guanbi"></i>
    <div class="fill-wrapper">
        <div class="fill-title">被保人信息</div>
        <ul>
            <li>
                <span class="name">姓名</span><input type="text" placeholder="必填" name="insurance_attributes[ty_beibaoren][name]" />
            </li>
            <li>
                <span class="name">证件号码</span><input type="text" placeholder="必填" name="insurance_attributes[ty_beibaoren][ty_beibaoren_id_number]"/>
            </li>
            <li>
                <span class="name">职业</span><input type="text" placeholder="必填" name="insurance_attributes[ty_beibaoren][ty_beibaoren_job]"/>
            </li>
            <li>
                <span class="name">手机号码</span><input type="text" name="insurance_attributes[ty_beibaoren][ty_beibaoren_phone]" placeholder="必填"/>
            </li>
        </ul>
        <button class="btn btn-confirm btn-edit">确定</button>
    </div>
</div>


<script src="{{config('view_url.mobile_group_ins')}}js/lib/jquery-1.11.3.min.js"></script>
<script src="{{config('view_url.mobile_group_ins')}}js/lib/mui.min.js"></script>
<script src="{{config('view_url.mobile_group_ins')}}js/lib/mui.picker.all.js"></script>
<script src="{{config('view_url.mobile_group_ins')}}js/common.js"></script>
<script>
    var userPicker = new mui.PopPicker();
    $('.pickerone').on('tap', function(e) {
        var _this = $(this);
        $('input').blur();
        var jsonData = _this.attr('data-options');
        userPicker.setData(changeJsonData(jsonData));
        userPicker.show(function(items) {
            _this.find('input:text').val(items[0].text);
            _this.find('.inputhidden').val(items[0].id);
            // 性别和出生日期在用户选择身份证之外的证件类型时出现
            if(items[0].id == 1){
                $('.hide').hide();
            }else{
                $('.hide').show();
            }
        });
    });
    dataPicker('.zbtn-dropdown');
    //点击添加出来的弹层
    $('.btn-add').on('tap',function(){
        mui('.mui-popover1').popover('show');
    });
    //点击确定弹层关闭
    $('.btn-sure').on('click',function(){
        mui('.mui-popover').popover('hide');

    });
    //点击被保人填写出来的弹层
    $('.passive').on('tap',function(){
        mui('.mui-popover1').popover('hide');
        mui('.mui-popover2').popover('show');
    });
    //点击手动添加出来的弹层
    $('.Manual').on('tap',function(){
        mui('.mui-popover1').popover('hide');
        mui('.mui-popover0').popover('show');
    });
    //点击下载
    $('.download').on('tap', function() {
        alert("下载图片")
    });
    //来回切换的按钮
    $('.switchone').on('toggle', function() {
        var value = event.detail.isActive;
        if (value){
            $('.btn-submit').attr('disabled',true);
        }else{
            var personTotal = {{$json['min_math']}};
            if($('.recognizee-wrapper li').length>=personTotal){
                $('.tips').hide();
                $('.btn-submit').prop('disabled',false);
            }else{
                $('.tips').show();
                $('.btn-submit').prop('disabled',true);
            }
//            $('.btn-submit').attr('disabled',false);
        }
    });


    // 团险项目最少添加几位被保人
    {{--var personTotal = {{$json['min_math']}};--}}
    {{--if($('.recognizee-wrapper li').length>=personTotal){--}}
        {{--$('.tips').hide();--}}
        {{--$('.btn-submit').prop('disabled',false);--}}
    {{--}else{--}}
        {{--$('.tips').show();--}}
        {{--$('.btn-submit').prop('disabled',true);--}}
    {{--}--}}

    {{--// 下一步--}}
    {{--$('.btn-submit').on('tap',function(){--}}
        {{--$("#form_submit").submit();--}}
    {{--});--}}
    {{--//起保日期--}}
    {{--$('.pickerfour').on('tap', function() {--}}
        {{--var _this = $(this);--}}
        {{--var picker = new mui.DtPicker({--}}
            {{--"type": "date",--}}
            {{--"beginDate": new Date(),--}}
        {{--});--}}
        {{--picker.show(function(rs) {--}}
            {{--_this.find('input').val(rs.text);--}}
        {{--});--}}
    {{--});--}}

    // 团险项目最少添加几位被保人
    function checkPerson(){
        var personTotal = {{$json['min_math']}};
        if($('.recognizee-wrapper li').length >= personTotal){
            $('.tips').hide();
            return false;
        }else{
            $('.tips').show();
            return true;
        }
    }

    // 实时监听必填项
    $('input').bind('input propertychange', function() {
        check1();
    });
    function check1(){
        var status = checkPerson()||!checkMustFill('.mustFill');
//				console.log(checkPerson())
        console.log(!checkMustFill('.mustFill'))
        $('#next').prop('disabled',status);
    }
    // 下一步
    //拿到上一步存储好的值
    $('.btn-submit').on('tap',function(){
        $("#form_submit").submit();
    });
    //起保日期
    $('.pickerfour').on('tap', function() {
        var _this = $(this);
        var picker = new mui.DtPicker({
            "type": "date",
            "beginDate": new Date(),
        });
        picker.show(function(rs) {
            _this.find('input').val(rs.text);
            check1();
        });
    });

    //修改出来的弹层
    $('.btn-edite').click(function(){
        var _token = $("input[name='_token']").val();
        mui('.mui-popover3').popover('show');
        var a=$(this).parent().parent().parent();
        var math = a.attr("id");
        $.ajax({
            url:'/ins/mobile_group_ins/edit_info/'+math,
            type:'post',
            data:{_token:_token},
            success:function(res){
                var name = res.ty_beibaoren_name;
                var id_number = res.ty_beibaoren_id_number;
                var job = res.ty_beibaoren_job;
                var phone = res.ty_beibaoren_phone;
                $('.mui-popover3 input[name="insurance_attributes[ty_beibaoren][name]"]').val(name);
                $('.mui-popover3 input[name="insurance_attributes[ty_beibaoren][ty_beibaoren_id_number]"]').val(id_number);
                $('.mui-popover3 input[name="insurance_attributes[ty_beibaoren][ty_beibaoren_job]"]').val(job);
                $('.mui-popover3 input[name="insurance_attributes[ty_beibaoren][ty_beibaoren_phone]"]').val(phone);
                console.log(res);
            }
        })
    });

    //修改数据提交
    $(".btn-edit").click(function(){
        var a=$(this).parent().parent().siblings('.main').find('.k');
        var math = a.attr("id");
        var _token = $("input[name='_token']").val();
        var ty_beibaoren_name = $('.mui-popover3 input[name="insurance_attributes[ty_beibaoren][name]"]').val();
        var ty_beibaoren_id_number = $('.mui-popover3 input[name="insurance_attributes[ty_beibaoren][ty_beibaoren_id_number]"]').val();
        var ty_beibaoren_job = $('.mui-popover3 input[name="insurance_attributes[ty_beibaoren][ty_beibaoren_job]"]').val();
        var ty_beibaoren_phone = $('.mui-popover3 input[name="insurance_attributes[ty_beibaoren][ty_beibaoren_phone]"]').val();
        $.ajax({
            url:'/ins/mobile_group_ins/edit_info_submit/'+math,
            type:'post',
            data:{_token:_token,ty_beibaoren_name:ty_beibaoren_name,ty_beibaoren_id_number:ty_beibaoren_id_number,ty_beibaoren_job:ty_beibaoren_job,ty_beibaoren_phone:ty_beibaoren_phone},
            success:function(res){
                Mask.alert(res['msg']);
                location.reload();
            }
        })
    })


    $(".btn-delete").click(function(){
        var a=$(this).parent().parent().parent();
        var math = a.attr("id");
        var _token = $("input[name='_token']").val();
        var identification = {{$identification}};
        $.ajax({
            url:'/ins/mobile_group_ins/delete_info/'+math,
            type:'post',
            data:{_token:_token,identification:identification},
            success:function(res){
                if (res.code == 200){
                    Mask.alert(res.msg);
                    setTimeout(function(){
                        a.remove();
                    },1500);
                }else{
                    Mask.alert(res.msg);
                }

            }
        })
    });

    $(function(){
        var inputs = $('.mui-popover0 input');
        var btn_confirm = $('.mui-popover0 .btn-confirm');
        var info = {
            init: function(){
                var _this = this;
                _this.isCorrectFormat();
                inputs.bind('input propertychange', function() {
                    _this.isDisabled();
                });
            },
            isCorrectFormat: function(){
                var _this = this;
                _this.checkVal($('input[name="insurance_attributes[ty_beibaoren][ty_beibaoren_name]"]'),nameReg);
                _this.checkVal($('input[name="insurance_attributes[ty_beibaoren][ty_beibaoren_id_number]"]'),IdCardReg);
                _this.checkVal($('input[name="insurance_attributes[ty_beibaoren][ty_beibaoren_phone]"]'),telReg);
            },
            checkVal: function(ele,reg){
                $(ele).blur(function(){
                    if(!$(this).val().trim()){$(this).val('');return;}
                    if(!checkCorrect(this,reg)){
                        $(this).val('');
                        btn_confirm.prop('disabled',true);
                    }
                });
            },
            isDisabled: function(){
                checkMustFill('.mui-popover0 input') == true ? btn_confirm.prop('disabled',false):btn_confirm.prop('disabled',true);
            }
        }
        info.init();
    });



</script>
</body>

</html>