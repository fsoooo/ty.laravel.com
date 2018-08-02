@extends('frontend.agents.agent_home.base')
@section('content')
    <style>
        .content-wrapper{
            background: none;
        }
    </style>
    <link rel="stylesheet" href="{{config('view_url.agent_url')}}css/agent.css" />
    <div class="content" style="padding: 0;">
        <ul class="crumbs">
            <li><a href="/agent">首页</a><i class="iconfont icon-gengduo"></i></li>
            <li><a href="/agent_sale/agent_company/unpayed">我的客户</a><i class="iconfont icon-gengduo"></i></li>
            <li>企业客户</li>
        </ul>
        <div class="select-box">
            <a href="/agent_sale/agent_cust/unpayed"><i class="i-user"></i>个人客户</a>
            <a href="/agent_sale/agent_company/unpayed" class="active"><i class="i-company"></i>企业客户</a>
        </div>
        <div style="padding: 20px;border: 1px solid #ddd;border-top: 0;background: #fff;">
            <div class="search-outer">
                <form id="search_form" action="{{url('/agent_sale/agent_company/'.$type)}}" method="post">
                    <div class="search-wrapper">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="type" value="{{$type}}">
                        <select name="search_type">
                            <option value="1">企业名称</option>
                            <option value="2">统一信用代码</option>
                            <option value="3">组织机构代码</option>
                            <option value="4">营业执照编码</option>
                        </select>
                        <input placeholder="搜索客户" name="content" value="">
                        <button class="z-btn z-btn-default"><i class="iconfont icon-sousuo"></i></button>
                    </div>
                </form>
            </div>
            <div class="tab-wrapper">
                <ul class="tab fl">
                    <li @if($type == 'unpayed')class="active"@endif>
                        <a href="/agent_sale/agent_company/unpayed">未投保客户</a>
                    </li>
                    <li @if($type == 'payed')class="active"@endif>
                        <a href="/agent_sale/agent_company/payed">已投保客户</a>
                    </li>
                    <li @if($type == 'history')class="active"@endif>
                        <a href="/agent_sale/agent_company/history">历史客户</a>
                    </li>
                    <li @if($type == 'apply')class="active"@endif>
                        <a href="/agent_sale/agent_company/apply">申请中</a>
                    </li>
                </ul>
                <span id="addClient" class="z-btn z-btn-default"><i class="iconfont icon-add">添加新客户</i></span>
            </div>
            <!--企业已投保-->
            <table class="table-hover">
                <tr>
                    <th>企业名称</th>
                    {{--<th>企业类型</th>--}}
                    <th>联系人</th>
                    <th>联系方式</th>
                    <th>认证状态</th>
                    <th>操作</th>
                </tr>
                @foreach($res as $v)
                    <tr>
                        <td>@if($v->name)
                                {{$v->name}}
                            @else
                                --
                            @endif
                            <div data-id="{{$v->id}}" class="operation">
                                <div class="operation-item"><i class="iconfont icon-edit"></i><p>修改</p></div>
                                <div class="operation-item"><i class="iconfont icon-delete"></i><p>删除</p></div>
                            </div>
                        </td>
                        <td>
                            @if($v->ins_principal){{$v->ins_principal}}@else -- @endif
                        </td>
                        <td>
                            @if($v->ins_phone)
                            {{$v->ins_phone}}
                                @else
                            --
                                @endif
                        </td>
                        <td>@if( isset($v->auth_status) && $v->auth_status == 0)
                                待审核
                                @elseif(isset($v->auth_status) && $v->auth_status == 1)
                            审核失败
                                @elseif(isset($v->auth_status) && $v->auth_status == 2)
                            审核通过
                                @else
                                未提交认证
                                @endif
                        </td>
                        <td class="color-default"><a href="/agent_sale/cust_details/{{$v->id}}">查看详情</a></td>
                    </tr>
                @endforeach
            </table>
            <ul class="pagination">
                {{$res->links()}}
            </ul>
        </div>
    </div>
    <div id="company" class="popups-wrapper popups-add popups-add-company">
        <div class="popups">
            <div class="popups-title">填写客户信息<i class="iconfont icon-close"></i></div>
            <div class="popups-content">
                <form id="form" action="/agent_sale/agent_cust_submit" method="post" enctype="multipart/form-data">
                <div class="clearfix">
                    <div class="form-wrapper">
                        <ul>
                            <li>
                                <span class="name"><i>*</i>企业名称</span>
                                <input id="company_name" type="text" placeholder="请输入" name="name_company">
                                <span class="error"></span>
                            </li>
                            <li>
                                <span class="name"></span>
                                <label>
                                    <input hidden="" type="radio" name="type" checked="">
                                    <span class="selected z-btn-hollow z-btn-selected">三证合一企业</span>
                                </label>
                                <label>
                                    <input hidden="" type="radio" name="type">
                                    <span class="z-btn-hollow z-btn-selected">非三证合一企业</span>
                                </label>
                                <span class="error"></span>
                            </li>
                            <li class="hide">
                                <span class="name"><i>*</i>组织机构代码</span>
                                <input type="text" placeholder="请输入" name="organization_code">
                                <span class="error"></span>
                            </li>
                            <li class="hide">
                                <span class="name"><i>*</i>营业执照编号</span>
                                <input type="text" placeholder="请输入" name="license_code">
                                <span class="error"></span>
                            </li>
                            <li class="hide">
                                <span class="name"><i>*</i>纳税人识别号</span>
                                <input type="text" placeholder="请输入" name="taxpayer_code">
                                <span class="error"></span>
                            </li>
                            <li class="show">
                                <span class="name"><i>*</i>统一信用代码</span>
                                <input type="text" placeholder="请输入" name="credit_code">
                                <span class="error"></span>
                            </li>
                            <li>
                                <span class="name"><i>*</i>企业所在地址</span>
                                <select id="province" name="province"><option value="110000">北京</option><option value="120000">天津</option><option value="130000">河北省</option><option value="140000">山西省</option><option value="150000">内蒙古自治区</option><option value="210000">辽宁省</option><option value="220000">吉林省</option><option value="230000">黑龙江省</option><option value="310000">上海</option><option value="320000">江苏省</option><option value="330000">浙江省</option><option value="340000">安徽省</option><option value="350000">福建省</option><option value="360000">江西省</option><option value="370000">山东省</option><option value="410000">河南省</option><option value="420000">湖北省</option><option value="430000">湖南省</option><option value="440000">广东省</option><option value="450000">广西壮族自治区</option><option value="460000">海南省</option><option value="500000">重庆</option><option value="510000">四川省</option><option value="520000">贵州省</option><option value="530000">云南省</option><option value="540000">西藏自治区</option><option value="610000">陕西省</option><option value="620000">甘肃省</option><option value="630000">青海省</option><option value="640000">宁夏回族自治区</option><option value="650000">新疆维吾尔自治区</option></select>
                                <select id="city" name="city"><option value="110000">北京市</option></select>
                                <select id="county" name="county"><option value="110101">东城区</option><option value="110102">西城区</option><option value="110105">朝阳区</option><option value="110106">丰台区</option><option value="110107">石景山区</option><option value="110108">海淀区</option><option value="110109">门头沟区</option><option value="110111">房山区</option><option value="110112">通州区</option><option value="110113">顺义区</option><option value="110114">昌平区</option><option value="110115">大兴区</option><option value="110116">怀柔区</option><option value="110117">平谷区</option><option value="110228">密云县</option><option value="110229">延庆县</option></select>
                                <i class="error"></i>
                            </li>
                            <li>
                                <span class="name"></span>
                                <textarea placeholder="请输入详细地址" name="address"></textarea>
                            </li>
                            <li>
                                <span class="name"><i>*</i>联系人姓名</span>
                                <input id="name" type="text" placeholder="请输入" name="linkman_name">
                                <span class="error"></span>
                            </li>
                            <li>
                                <span class="name"><i>*</i>手机号码</span>
                                <input id="tel" type="text" placeholder="请输入" maxlength="11" name="linkman_phone">
                                <span class="error"></span>
                            </li>
                            <li>
                                <span class="name"><i>*</i>身份证号</span>
                                <input id="idCard" type="text" placeholder="请输入" name="linkman_id_code">
                                <span class="error"></span>
                            </li>
                            <li>
                                <span class="name"><i>*</i>电子邮箱</span>
                                <input id="email" type="text" placeholder="请输入" name="linkman_email">
                                <span class="error"></span>
                            </li>

                            <li>
                                <span class="name">营业执照</span>
                                <span class="z-btn-hollow btn-upload">上传照片</span>
                                <div class="company-img-wrapper">
                                    <div class="company-img-item">
                                        <div class="company-img">
                                            <img src="{{config('view_url.agent_url')}}img/yingye.png" alt="">
                                        </div>
                                        <div class="company-img-tips">营业执照样本展示</div>
                                    </div>
                                    <div class="company-img-item">
                                        <div id="img_bro" class="company-img upload-wrapper"></div>
                                        <div class="company-img-tips color-positive"></div>
                                    </div>
                                </div>
                                <input hidden="hidden" type="file" onchange="upload(this);" accept="image/*" name="uploadImg">
                                <input id="business" hidden="" type="text" class="inputhidden">
                                <i class="error"></i>
                            </li>
                        </ul>
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <input type="hidden" name="company" value="1">

                    </div>
                </div>
                <p class="tips">标有<i class="red">*</i>符号的为必填项</p>
                <button type="submit" id="add" class="z-btn z-btn-positive">添加</button>
                </form>
            </div>
        </div>
    </div>
    <script src="{{config('view_url.agent_url')}}js/areaSelect.js"></script>
    <script src="{{config('view_url.agent_url')}}js/lib/jquery.validate.min.js"></script>
    <script src="{{config('view_url.agent_url')}}js/check.js"></script>
    <script>

        // 操作随鼠标位置移动
        $(".table-hover tr").hover(function(e) {
            var offset = $(this).offset();
            var relativeX = (e.pageX - offset.left);
            $('.operation').css({'left':relativeX+'px'});
        });

        $('.icon-edit').click(function(){
            var id = $(this).parent().parent().data('id');
            var _token = $("input[name='_token']").val();
            var company = 1;
            $.ajax({
                url:'/agent_sale/get_cust_info/'+id,
                type:'post',
                data:{'_token':_token,'company':company},
                success:function(res){
                    console.log(res);
                    if (res['status'] == 200){
                        $("input[name='name_company']").val(res['msg']['real_name']);
                        $("input[name='organization_code']").val(res['msg']['authentication']['code']);
                        $("input[name='license_code']").val(res['msg']['authentication']['license_code']);
                        $("input[name='taxpayer_code']").val(res['msg']['authentication']['tax_code']);
                        $("input[name='credit_code']").val(res['msg']['authentication']['credit_code']);
                        $("input[name='linkman_name']").val(res['msg']['true_firm_info']['ins_principal']);
                        $("input[name='linkman_phone']").val(res['msg']['true_firm_info']['ins_phone']);
                        $("input[name='linkman_id_code']").val(res['msg']['true_firm_info']['ins_principal_code']);
                        $("input[name='linkman_email']").val(res['msg']['true_firm_info']['ins_email']);
                        $("#company_name").append('<input name="edit" type="hidden" value="1"/>');
                        $("#company_name").append('<input name="id" type="hidden" value="'+id+'"/>');
//                        $("#img_bro").append('<img src="'+res['msg']['true_firm_info']['license_img']+'">');
                        Popups.open('.popups-add');
                    }else{
                        alert(res['msg']);
                    }
                }
            })
        })

        //删除
        $(".icon-delete").click(function(){
            var id = $('.icon-edit').parent().parent().data('id');
            var _token = $("input[name='_token']").val();
            $.ajax({
                url:'/agent_sale/delete_company_cust/'+id,
                type:'post',
                data:{_token:_token},
                success:function(res){
                    console.log(res);
                    if (res['status'] == 200){
                        alert(res['msg']);
                        location.href='/agent_sale/agent_company/unpayed';
                    }
                }
            })
        })

        selectData('.radioBox','single');
        new Cascade($('#province'),$('#city'),$('#county'));

        $('#addClient').click(function(){
            Popups.open('.popups-add');
        });


        // 是否为三证合一企业
        $('.z-btn-selected').click(function(){
            $(this).parents('li').find('.z-btn-selected').removeClass('selected');
            $(this).addClass('selected').prev().prop('checked',true);
            var index = $(this).parent().index();
            index === 1 ? $('.hide').hide() : $('.hide').show();
            index === 1 ? $('.show').show() : $('.show').hide();

        });

        var upload = function(e){
            var _this = $(e);
            console.log(_this);
            var max_size=2097152;
            var $c = _this.parent().find('input[type=file]')[0];
            var file = $c.files[0],reader = new FileReader();
            if(!/\/(png|jpg|PNG|JPG|jpeg|JPEG)$/.test(file.type)){
                Mask.alert('图片支持jpg,png格式',2);
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
                $('.company-img-tips.color-positive').html('上传成功');
                $('.btn-upload').text('重新上传');
                _this.parent().find('.inputhidden').val(e.target.result);
            };
        };

        $('.btn-upload').click(function(){
            $(this).parent().find('input').click();
        });



        // 提交数据
        $.validator.setDefaults({
            submitHandler: function() {
                if(!isRealName($('#name')) || !checkUpload($('#business'))){
                    return false;
                }else{
                    // 提交数据
                    $('#form').submit();
                }
            }
        });
        $(document).ready(function() {
            $("#form").validate();
        });

        //开始验证
        $('#form').validate({
            rules: {
                name_company: {
                    required: true,
                    stringCheck: true,
                },
                credit_code: {
                    required: true,
                    sqlCheck: true,
                    creditCheck: true,
                    notStringCheck: true
                },
                organization_code: {
                    required: true,
                    sqlCheck: true,
                    organizationCheck: true
                },
                license_code: {
                    required: true,
                    sqlCheck: true,
                    licenseCheck: true,
                    notStringCheck: true
                },
                taxpayer_code: {
                    required: true,
                    sqlCheck: true,
                    notStringCheck: true
                },
                address: {
                    required: true,
                    sqlCheck: true,
                    stringCheck: true
                },
                linkman_name: {
                    required: true,
                    byteRangeLength: [3, 50]
                },
                linkman_email: {
                    required: true,
                    email: true
                },
                linkman_phone: {
                    required: true,
                    isMobile: true
                },
                linkman_id_code: {
                    required: true,
                    isIdCardNo: true
                }
            },
            messages: {
                linkman_name: {
                    byteRangeLength: errorMessages.namelength
                }
            },
            focusInvalid: true,
            onkeyup: function(element) {$(element).valid();},
            errorPlacement: function(error, element) {
                error.appendTo(element.parent());
            },
        });


    </script>
@stop