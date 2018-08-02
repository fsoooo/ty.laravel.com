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
                <li>
                    <a href="/agent">首页</a><i class="iconfont icon-gengduo"></i></li>
                <li>
                    <a href="/agent_sale/agent_cust/unpayed">我的客户</a><i class="iconfont icon-gengduo"></i></li>
                <li>个人客户</li>
            </ul>
            <div class="select-box">
                <a href="/agent_sale/agent_cust/unpayed" class="active"><i class="i-user"></i>个人客户</a>
                <a href="/agent_sale/agent_company/unpayed"><i class="i-company"></i>企业客户</a>
            </div>
            <div style="padding: 20px;border: 1px solid #ddd;border-top: 0;background: #fff;">
                <div class="search-outer">
                    <form id="search_form" action="{{url('/agent_sale/agent_cust/'.$type)}}" method="post">
                        <div class="search-wrapper">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="type" value="{{$type}}">
                            <select name="search_type">
                                <option value="1">姓名</option>
                                <option value="2">身份证</option>
                                <option value="3">联系方式</option>
                                <option value="4">邮箱</option>
                            </select>
                            <input placeholder="搜索客户" name="content" value="">
                            <button class="z-btn z-btn-default"><i class="iconfont icon-sousuo"></i></button>
                        </div>
                    </form>
                </div>
                <div class="tab-wrapper">
                    <ul class="tab fl">
                        <li @if($type == 'unpayed')class="active"@endif>
                            <a href="/agent_sale/agent_cust/unpayed">未投保客户</a>
                        </li>
                        <li @if($type == 'payed')class="active"@endif>
                            <a href="/agent_sale/agent_cust/payed">已投保客户</a>
                        </li>
                        <li @if($type == 'history') class="active" @endif>
                            <a href="/agent_sale/agent_cust/history">历史客户</a>
                        </li>
                        <li @if($type == 'apply') class="active" @endif>
                            <a href="/agent_sale/agent_cust/apply">申请中</a>
                        </li>
                    </ul>
                    <span id="addClient" class="z-btn z-btn-default"><i class="iconfont icon-add">添加新客户</i></span>
                </div>
                <!--个人已投保客户-->
                <table class="table-hover">
                    <tr>
                        <th>客户</th>
                        <th>性别</th>
                        <th>年龄</th>
                        <th>职业</th>
                        <th>联系方式</th>
                        <th>操作</th>
                    </tr>
                    @foreach($res as $v)
                        <tr>
                            <td>@if(isset($v->name))
                                    {{$v->name}}
                                @else
                                    --
                                @endif
                                <div data-id="{{$v->id}}" class="operation">
                                    <div class="operation-item"><i class="iconfont icon-edit"></i><p>修改</p></div>
                                    <div class="operation-item"><i class="iconfont icon-delete"></i><p>删除</p></div>
                                </div>
                            </td>
                            <td>@if( isset($v->code) && substr($v->code,16,1)%2 == 1)男@elseif( isset($v->code) && substr($v->code,16,1)%2 == 0) 女 @else -- @endif</td>
                            @if(isset($v->code))
                                <td>{{date('Y',time()) - substr($v->code,6,4)}}岁</td>
                            @else
                                <td> -- </td>
                            @endif
                            @if(isset($v->occupation))
                                <td>{{$v->occupation}}</td>
                            @else
                                <td>--</td>
                            @endif
                            <td>{{$v->phone}}</td>
                            <td class="color-default"><a href="/agent_sale/cust_details/{{$v->id}}">查看详情</a></td>
                        </tr>
                    @endforeach
                </table>
                <ul class="pagination">
                    {{$res->links()}}
                </ul>
                @if(isset($error))
                    <div class="mark">
                        <p>{{$error}}</p>
                    </div>
                    @endif
            </div>
        </div>
    <div class="popups-wrapper popups-add">
        <div class="popups">
            <div class="popups-title">填写客户信息<i class="iconfont icon-close"></i></div>
            <div class="popups-content">
                <form action="/agent_sale/agent_cust_submit" id="custForm" method="post">
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <div class="clearfix">
                        <div class="form-wrapper" style="margin: 0 auto;float: none">
                            <h4 class="title">投保人信息</h4>
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

        // 操作随鼠标位置移动
        $(".table-hover tr").hover(function(e) {
            var offset = $(this).offset();
            var relativeX = (e.pageX - offset.left);
            $('.operation').css({'left':relativeX+'px'});
        });

        $('.icon-edit').click(function(){
            var id = $('.icon-edit').parent().parent().data('id');
            var _token = $("input[name='_token']").val();
            $.ajax({
                url:'/agent_sale/get_cust_info/'+id,
                type:'post',
                data:{'_token':_token},
                success:function(res){
                    console.log(res);
                    if (res['status'] == 200){
                        $("#name2").val(res['msg']['real_name']);
                        $("#idCard2").val(res['msg']['code']);
                        $("#tel2").val(res['msg']['phone']);
                        $("#email2").val(res['msg']['email']);
                        $("#name2").append('<input name="edit" type="hidden" value="1"/>');
                        $("#name2").append('<input name="id" type="hidden" value="'+id+'"/>');
                        Popups.open('.popups-add');
                    }else{
                        alert(res['msg']);
                    }
                }
            })
        })

        selectData('.radioBox', 'single');

        $('#addClient').click(function() {
            Popups.open('.popups-add');
        });
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

        // 性别
        $('.z-btn-selected').click(function() {
            $(this).parents('li').find('.z-btn-selected').removeClass('selected');
            $(this).addClass('selected').prev().prop('checked', true);
        });

        var isSelf = false;
        $('#relation').change(function() {
            var val = $(this).val();
            if(val == 1) {
                $('.showOrhide').hide();
                isSelf = true;
            } else {
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

        //删除
        $(".icon-delete").click(function(){
            var id = $('.icon-edit').parent().parent().data('id');
            var _token = $("input[name='_token']").val();
            $.ajax({
                url:'/agent_sale/delete_personal_cust/'+id,
                type:'post',
                data:{_token:_token},
                success:function(res){
                    if (res['status'] == 200){
                        alert(res['msg']);
                        location.href='/agent_sale/agent_cust/unpayed';
                    }
                }
            })
        })


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
    </script>





@stop