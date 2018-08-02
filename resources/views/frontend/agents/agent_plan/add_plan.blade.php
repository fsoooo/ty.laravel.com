@extends('frontend.agents.agent_home.base')
@section('content')
    <link rel="stylesheet" href="{{config('view_url.agent_url')}}css/lib/swiper-3.4.2.min.css" />
    <link rel="stylesheet" href="{{config('view_url.agent_url')}}css/make.css" />
    <div>
        <button id="addClient" class="z-btn z-btn-default"><i class="iconfont icon-add"></i>添加新客户</button>

        <ul class="tab">
            <li class="active"><a href="/agent_sale/add_plan">制作计划书</a></li>
            <li><a href="/agent_sale/plan_lists">已制作计划书</a></li>
            <li><a href="/agent_sale/plan_change">已转化计划书</a></li>
        </ul>
    </div>

    <form action="/agent_sale/add_plan_submit" method="post" id="plan_form">
        {{ csrf_field() }}
    <div class="content">
        <div class="section">
            <div class="section-title">第一步,选择客户（被保险人）</div>
            <div class="section-container">
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                <select id="cust_type" name="cust_type">
                    <option @if($cust_type == 1) selected @endif value="1">个人</option>
                    <option @if($cust_type == 2) selected @endif value="2">企业</option>
                </select>
                @if($cust_type == 1)
                <select id="cust_search_type" name="cust_search_type">
                    <option value="1">姓名</option>
                    <option value="2">证件号码</option>
                    <option value="3">电话号</option>
                    <option value="4">邮箱</option>
                </select>
                @else
                    <select id="cust_search_type" name="cust_search_type">
                        <option value="1">公司名称</option>
                        <option value="2">统一信用代码</option>
                        <option value="3">组织机构代码</option>
                        <option value="4">营业执照编码</option>
                        <option value="5">社会统一代码</option>
                    </select>
                @endif
                <div class="search">
                    <input type="text" placeholder="搜索客户" name="cust_content"/>
                    <i id="cust_submit" class="iconfont icon-sousuo"></i>
                </div>
                {{--<div class="z-btn-hollow reelect">重<br />选</div>--}}
                <div id="client" class="table-wrapper">
                    @if(!isset($_GET['cust_type']) || $_GET['cust_type'] == 1)
                    <ul class="table-header">
                        <li>
                            <span class="col1"></span>
                            <span class="col2">姓名</span>
                            <span class="col3">性别</span>
                            <span class="col4">出生日期</span>
                            <span class="col5">职业</span>
                            <span class="col6">证件号码</span>
                            <span class="col7">电话号</span>
                            <span class="col8">邮箱</span>
                        </li>
                    </ul>
                    @else
                        <ul class="table-header">
                            <li>
                                <span style="width: 35px;height: 10px;"></span>
                                <span style="width: 120px;">公司名称</span>
                                {{--<span style="width: 90px;">公司类型</span>--}}
                                <span style="width: 162px;">公司地址</span>
                                <span style="width: 120px;">联系人</span>
                                <span style="width: 120px;">联系方式</span>
                                <span style="width: 160px;">邮箱</span>
                            </li>
                        </ul>
                    @endif
                    <div class="table-body">
                        @if(!isset($_GET['cust_type']) || $_GET['cust_type'] == 1 )
                        <ul>
                            @if($count == 0)
                                <li>未添加客户</li>
                            @else
                                @foreach($cust as $v)
                                <li>
                                    <span class="col1">
                                        <label>
                                            <input hidden type="radio" name="user" value="{{$v->id}}"/>
                                            <i class="iconfont icon-duoxuan-weixuan"></i>
                                        </label>
                                    </span>
                                    @if($v->real_name)
                                        <span class="col2">{{$v->real_name}}</span>
                                    @else
                                        <span class="col2"> -- </span>
                                    @endif
                                    @if($v->type == 'user' && $v['code'])
                                        @if(substr($v['code'],16,1)%2 == 1)
                                            <span class="col3">男</span>
                                        @else
                                            <span class="col3">女</span>
                                        @endif
                                    @else
                                        <span class="col3">--</span>
                                    @endif
                                    @if($v->type == 'user' && $v['code'])
                                        <span class="col4">{{substr($v['code'],6,4)}}年{{substr($v['code'],10,2)}}月</span>
                                    @else
                                        <span class="col4">--</span>
                                    @endif

                                    @if($v->type == 'user' && $v->occupation)
                                        <span class="col5"> {{$v->occupation}}</span>
                                    @else
                                       <span class="col5"> --</span>
                                    @endif
                                    @if($v->code)
                                    <span class="col6">{{$v->code}}</span>
                                    @else
                                        <span class="col6"> -- </span>
                                    @endif
                                    @if($v->phone)
                                        <span class="col7">{{$v->phone}}</span>
                                    @else
                                        <span class="col7"> -- </span>
                                    @endif
                                    @if($v['email'])
                                        <span class="col8">{{$v['email']}}</span>
                                    @else
                                        <span class="col8"> -- </span>
                                    @endif
                                </li>
                                @endforeach
                                @endif
                        </ul>
                        @else
                            <ul>
                                @if($count == 0)
                                    <li>未添加客户</li>
                                @else
                                    @foreach($cust as $v)
                                        <li>
                                            <span style="width: 35px;">
                                                <label>
                                                    <input hidden type="radio" name="user" value="{{$v->id}}"/>
                                                    <i class="iconfont icon-duoxuan-weixuan"></i>
                                                </label>
                                            </span>
                                            <span style="width: 120px;">{{$v['name']??'--'}}</span>
                                            {{--<span style="width: 90px;">IT行业</span>--}}
                                            <span style="width: 162px;">{{$v['address']??'--'}}</span>
                                            <span style="width: 120px;">{{$v->trueFirmInfo['ins_principal']??'--'}}</span>
                                            <span style="width: 120px;">{{$v->trueFirmInfo['ins_phone']??'--'}}</span>
                                            <span style="width: 160px;">{{$v->trueFirmInfo['ins_email']??'--'}}</span>
                                        </li>
                                    @endforeach
                                @endif
                            </ul>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="section">
            <div class="section-title">第二步,选择产品</div>
            <div class="section-container">
                <select id="product_type" name="product_type">
                    <option value="1">产品名称</option>
                    <option value="2">公司名称</option>
                    <option value="3">产品类型</option>
                    <option value="4">佣金比率</option>
                    <option value="5">主险条款</option>
                </select>
                <div class="search">
                    <input type="text" name="product_content" placeholder="搜索产品"/>
                    <i id="product_search" class="iconfont icon-sousuo"></i>
                </div>
                {{--<div class="z-btn-hollow reelect">重<br />选</div>--}}
                <div id="product" class="table-wrapper">
                    <ul class="table-header">
                        <li>
                            <span class="col1"></span>
                            <span class="col2">产品ID</span>
                            <span class="col3">公司名称</span>
                            <span class="col4">产品类型</span>
                            <span class="col5">产品名称</span>
                            <span class="col6">主险</span>
                            <span class="col7">佣金比率</span>
                            <span class="col8">保费</span>
                        </li>
                    </ul>
                    <div class="table-body">
                        <ul>
                            @if(!$jurisdiction)
                                <li>还没有进行认证，请 <a href="/agent/account">先认证</a></li>
                            @elseif($product_count == 0)
                                <li>没有设置佣金的产品</li>
                                @else
                                @foreach($product_list as $v)
                            <li>
                                <span class="col1">
                                    <label>
                                        <input hidden type="radio" name="product" value="{{$v->ty_product_id}}"/>
                                        <i class="iconfont icon-duoxuan-weixuan"></i>
                                    </label>
                                </span>
                                <span class="col2">{{$v->ty_product_id}}</span>
                                <span class="col3 ellipsis" title="{{$v->company_name}}">{{$v->company_name}}</span>
                                <span class="col4 ellipsis" title="{{json_decode($v->json,true)['category']['name']}}">{{json_decode($v->json,true)['category']['name']}}</span>
                                <span class="col5 ellipsis" title="{{$v->product_name}}">{{$v->product_name}}</span>
                                <span class="col6 ellipsis" title="{{$v->main_name}}">{{$v->main_name}}</span>
                                <span class="col7">{{$v->rate['earning']}}%</span>
                                <span class="col8">{{$v->premium/100}}元</span>
                            </li>
                                @endforeach
                                @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="section">
            <div class="section-title">第三步,输入卖点</div>
            <div class="section-container">
                <div id="addPoints" class="z-btn-hollow" style="line-height: 18px;top: 98px;">添<br />加<br />卖<br />点</div>
                <div class="table-wrapper">
                    <div id="points" class="table-body">
                        <ul class="points-wrapper">
                            <li>
                                <span class="col1">
                                    <label>
                                        <input hidden type="checkbox"/>
                                        <i class="iconfont icon-duoxuan-weixuan"></i>
                                    </label>
                                </span>
                                <input class="points" type="text" placeholder="请输入信息，为产品添加卖点" name="selling[]"/>
                            </li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>
        <a href="javascript:;" id="create" class="z-btn z-btn-positive">生成计划书</a>
    </div>
        <div class="popups-wrapper popups-confirm">
            <div class="popups">
                <div class="popups-title">填写计划书名称<i class="iconfont icon-close"></i></div>
                <div class="popups-content">
                    <input id="planName" type="text" placeholder="请输入计划书名称" name="planName"/>
                    <button id="confirm" class="z-btn z-btn-positive" disabled>确定</button>
                </div>
            </div>
        </div>
    </form>


    <div class="popups-wrapper popups-add">
        <div class="popups">
            <div class="popups-title">填写客户信息<i class="iconfont icon-close"></i></div>
            <div class="popups-content">
                <form action="/agent_sale/add_cust_submit" id="custForm" method="post">
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                <div class="clearfix">
                    <div class="form-wrapper" style="margin: 0 auto;float: none">
                        <h4 class="title">被保人信息</h4>
                        <ul>
                            <li>
                                <span class="name"><i>*</i>姓名</span>
                                <input id="name2" type="text" placeholder="请填写真实姓名" name="toubaoren_name">
                                <span class="error"></span>
                            </li>
                            <li>
                                <span class="name"><i>*</i>身份证号</span>
                                <input id="idCard2" type="text" placeholder="请输入" name="toubaoren_id_code">
                                <span class="error"></span>
                            </li>
                            <li>
                                <span class="name"><i>*</i>联系方式</span>
                                <input id="tel2" type="text" placeholder="请输入" maxlength="11" name="toubaoren_phone">
                                <span class="error"></span>
                            </li>
                            <li>
                                <span class="name"><i>*</i>邮箱地址</span>
                                <input id="email2" type="text" placeholder="请输入" name="toubaoren_email">
                                <span class="error"></span>
                            </li>
                            <li>
                                <span class="name vtop">其他信息</span>
                                <textarea placeholder="投保人其他信息说明" name="toubaoren_other"></textarea>
                            </li>
                        </ul>
                    </div>

                </div>
                    <p class="tips">标有<i class="red">*</i>符号的为必填项</p>
                    <input type="hidden" name="company" value="2">
                    <button type="submit" id="add" class="z-btn z-btn-positive">添加</button>
                    </form>

            </div>
        </div>
    </div>


    <script src="{{config('view_url.agent_url')}}js/lib/laydate.js"></script>
    <script src="{{config('view_url.agent_url')}}js/lib/jquery.validate.min.js"></script>
    <script src="{{config('view_url.agent_url')}}js/check.js"></script>
    <script>
        // 初始
        $(".table-body").panel({iWheelStep: 32});
        check();
        laydate({
            elem: '#birthday',
            choose: function(datas) {
                console.log(datas)
                $('#startDatetwo').parent().find('.inputhidden').val(datas)
            }
        });
        $('#addClient').click(function(){
            Popups.open('.popups-add');
        });

        //筛选
        $('#cust_submit').click(function(){
            var cust_type = $('#cust_type').val();
            var cust_search_type = $("#cust_search_type").val();
            var  cust_content = $("input[name='cust_content']").val();
            location.href = '/agent_sale/add_plan'+'?cust_type='+cust_type+'&cust_search_type='+cust_search_type+'&cust_content='+cust_content;
        })
        $('#product_search').click(function(){
            var product_type = $('#product_type').val();
            var product_content = $("input[name='product_content']").val()
            location.href = '/agent_sale/add_plan'+'?product_type='+product_type+'&product_content='+product_content;
        })


        // 添加卖点
        $('#addPoints').click(function(){
            var html = '<li><span class="col1"><label><input hidden type="checkbox"/><i class="iconfont icon-duoxuan-weixuan"></i></label></span><input class="points" type="text" placeholder="请输入信息，为产品添加卖点" name="selling[]"/></li>';
            $('.points-wrapper').append(html);
            check();
        });


        // 性别
        $('.z-btn-selected').click(function(){
            $(this).parents('li').find('.z-btn-selected').removeClass('selected');
            $(this).addClass('selected').prev().prop('checked',true);
        });

        var isSelf = false;
        $('#relation').change(function(){
            var val = $(this).val();
            console.log()
            if(val == 1){
                $('.showOrhide').hide();
                isSelf = true;
            }else{
                $('.showOrhide').show();
            }
        });



        // 校验
        $(document).ready(function() {
            $("#custForm").validate();
        });

        // 提交数据
        $.validator.setDefaults({
            submitHandler: function() {
                if(!isRealName($('#name2'))){
                    return false;
                }else{
                    $('#custForm').submit();
                }
            }
        });

        // 校验规则
        $('#custForm').validate({
            rules: {
//                baibaoren_name: {
//                    required: true,
//                    byteRangeLength: [3, 50]
//                },
                toubaoren_name: {
                    required: true,
                    byteRangeLength: [3, 50]
                },
//                beibaoren_email: {
//                    required: true,
//                    email: true
//                },
                toubaoren_email: {
                    required: true,
                    email: true
                },
//                beibaoren_phone: {
//                    required: true,
//                    isMobile: true
//                },
                toubaoren_phone: {
                    required: true,
                    isMobile: true
                },
//                beibaoren_id_code: {
//                    required: true,
//                    isIdCardNo: true
//                },
//                beibaoren_occupation: {
//                    required: true,
//                    sqlCheck: true,
//                },
                toubaoren_id_code: {
                    required: true,
                    isIdCardNo: true
                },
//                beibaoren_other: {
//                    sqlCheck: true,
//                },
                toubaoren_other: {
                    sqlCheck: true,
                }
            },
            messages: {
//                baibaoren_name: {
//                    byteRangeLength: errorMessages.namelength
//                },
                toubaoren_name: {
                    byteRangeLength: errorMessages.namelength
                }
            },
            focusInvalid: true,
            onkeyup: function(element) {$(element).valid();},
            errorPlacement: function(error, element) {
                error.appendTo(element.parent());
            }
        });





        $('input').bind('input propertychange', function() {
            if($('#planName').val()){
                $('#confirm').prop('disabled',false);
            }else{
                $('#confirm').prop('disabled',true);
            }
        });

        // 客户产品卖点至少各选一项方可生成计划书
        function isChecked(ele){
            var status = false;
            $(ele).find('input').each(function(){
                if($(this).prop('checked')){
                    status = true;
                    return false;
                }
            });
            return status;
        }
        $('#create').click(function(){
            if(!isChecked('#client')){
                Mask.alert('客户未选择，请选择',2);
            }else if(!isChecked('#product')){
                Mask.alert('产品未选择，请选择',2);
            }else{
                Popups.open('.popups-confirm');
                $('#confirm').click(function(){
                    $('#plan_form').submit();
                });

            }
        });

        // 选择客户下拉列表的联动
        var personObj = {"1" :'姓名',"2" :'身份证',"3" :'手机号',"4" :'邮箱'};
        var companyObj = {"1" :'公司名称',"2" :'统一信用代码',"3" :'组织机构代码',"4" :'营业执照编码',"5" :'社会统一代码'};
        $('#cust_type').change(function(){
            var obj;
            var cust_type = $('#cust_type').val();
            var cust_search_type = $("#cust_search_type").val();
            var  cust_content = $("input[name='cust_content']").val();
            location.href = '/agent_sale/add_plan'+'?cust_type='+cust_type+'&cust_search_type='+cust_search_type+'&cust_content='+cust_content;

            $(this).val() == 0 ? obj = personObj : obj = companyObj;

            var html = '';
            $.each(obj, function(i, val) {
                html += '<option value="'+ i +'">'+ val +'</option>'
            });

            $('#cust_search_type').empty().append(html);
        });
    </script>
    @stop