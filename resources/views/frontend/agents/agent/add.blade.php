@extends('frontend.agents.layout.agent_bases')
@section('content')
    <meta name="_token" content="{{ csrf_token() }}"/>
    <style>
    </style>
    <div id="content-wrapper">
        <div class="big-img" style="display: none;">
            <img src="" alt="" id="big-img" style="width: 75%;height: 90%;">
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <ol class="breadcrumb">
                            <li><a href="/agent/">主页</a></li>
                            <li>客户管理</li>
                            <li><a href="/agent/add/person"><span>添加客户</span></a></li>
                            @if($type == 'person')
                                <li class="active"><a href="{{ url('/agent/add/person') }}">添加个人客户</a></li>
                            @elseif($type == 'company')
                                <li class="active"><a href="{{ url('/agent/add/company') }}">添加企业客户</a></li>
                            @endif
                        </ol>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="main-box clearfix" style="min-height: 1100px;">
                            <div class="tabs-wrapper tabs-no-header">
                                <ul class="nav nav-tabs">
                                    @if($type == 'person')
                                        <li class="active"><a href="{{ url('/agent/add/person') }}">添加个人客户</a></li>
                                        <li><a href="{{ url('/agent/add/company') }}">添加企业客户</a></li>
                                    @elseif($type == 'company')
                                        <li><a href="{{ url('/agent/add/person') }}">添加个人客户</a></li>
                                        <li class="active"><a href="{{ url('/agent/add/company') }}">添加企业客户</a></li>
                                    @endif
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane fade in active" id="tab-accounts">
                                        @include('frontend.agents.layout.alert_info')
                                        <div class="panel-group accordion" id="operation">
                                            <div class="panel panel-default">
                                                    <form action="{{ url('/agent/add_cust/') }}" method="post" id="form">
                                                            {{ csrf_field() }}
                                                            <table id="user" class="table table-hover" style="clear: both">
                                                                <tbody>

                                                                @if($type == 'company')
                                                                    <input type="text" name="type" value="company" hidden>

                                                                        <input type="text" name="type" value="1" hidden>
                                                                        <input type="text" name="cust_id" value="" hidden>
                                                                        <tr>
                                                                            <td>企业名称</td>
                                                                            <td>
                                                                                <input type="text" class="form-control" placeholder="请输入企业名称" name="name" value="">
                                                                            </td>
                                                                            <td class="error-message" >
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>三码合一</td>
                                                                            <td>
                                                                                <input class="form-control" type="text" name="code" placeholder="请输入三码合一" value="">
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td width="15%">手机号码</td>
                                                                            <td >
                                                                                <input type="text" class="form-control" placeholder="请输入联系电话" name="phone" value="">
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>企业邮箱</td>
                                                                            <td>
                                                                                <input type="text" class="form-control" placeholder="请输入企业邮箱" name="email" value="">
                                                                            </td>
                                                                        </tr>
                                                                @else
                                                                    <input type="text" name="type" value="person" hidden>
                                                                        <input type="text" name="type" value="0" hidden>
                                                                        <input type="text" name="cust_id" value="" hidden>
                                                                        <tr>
                                                                            <td width="15%">客户名称</td>
                                                                            <td width="60%">
                                                                                <input type="text" class="form-control" placeholder="请输入客户名称" name="name" value="">
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>身份证号</td>
                                                                            <td>
                                                                                <input class="form-control" type="text" name="code" placeholder="请输入身份证号" value="">
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td width="15%">手机号码</td>
                                                                            <td width="60%">
                                                                                <input type="text" class="form-control" placeholder="请输入联系电话" name="phone" value="">
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>个人邮箱</td>
                                                                            <td>
                                                                                <input type="text" class="form-control" placeholder="请输入邮箱邮箱" name="email" value="">
                                                                            </td>
                                                                        </tr>
                                                                @endif

                                                                </tbody>
                                                            </table>
                                                    </form>
                                            </div>
                                                <button id="btn" index="add" class="btn btn-success">确认添加</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <footer id="footer-bar" class="row">
                    <p id="footer-copyright" class="col-xs-12">
                        &copy; 2014 <a href="http://www.adbee.sk/" target="_blank">Adbee digital</a>. Powered by Centaurus Theme.
                    </p>
                </footer>
            </div>

        </div>
    </div>

    <script src="/js/jquery-3.1.1.min.js"></script>
    <script>


        $(function(){

            //进行验证发送
            var name = $('input[name=name]');
            var code = $('input[name=code]');
            var phone = $('input[name=phone]');
            var email = $('input[name=email]');
            var btn = $('#btn');
            var form = $('#form');
            var cust_id_input = $('input[name=cust_id]');



            //正则表达式
            var phone_pattern = {{ config('pattern.phone')}};
            var email_pattern = {{ config('pattern.email') }};
            var code_pattern = {{ config('pattern.code') }};
            var btn_type = btn.attr('index');
            btn.click(function(){
                var name_val = name.val();
                var code_val = code.val();
                var phone_val = phone.val();
                var email_val = email.val();console.log(phone_val);
                if(name_val == ''){   //名称验证
                    name.parent().addClass("has-error");
                    alert('名称不能为空');
                    return false;
                }else{
                    name.parent().removeClass("has-error");
                }
                var check_phone = check(phone,phone_val,phone_pattern,'联系方式');
                var check_email = check(email,email_val,email_pattern,'邮箱');
                var check_code = check(code,code_val,code_pattern,'证件号');
                if(!check_email||!check_phone||!check_code){
                    alert('格式错误');
                    return false;
                }

                if(btn_type == 'add'){
                    //进行判断是否已经添加过该客户
                    $.ajax({
                        type: "post",
                        dataType: "json",
                        async: true,
                        //修改的地址，
                        url: "/agent/is_my_cust_ajax",
                        data: 'code='+code_val,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                        },
                        success: function(data){
                            var status = data['status'];
                            if(status == 200){
                                var cust_id = data['data'];
                                //说明已经添加过该客户
                                if(confirm('已经添加过该客户了，要进行信息修改吗？')){
                                    var data = form.serialize();
                                    cust_id_input.val(cust_id);
                                    form.attr('action','/agent/edit_cust');
                                    form.submit();
                                }
                            }else {
                                form.submit();
                            }
                        },error: function () {
                            alert('添加失败');
                        }
                    });
                }else{
                    form.submit();
                }
            })


            //写一个方法，用来验证
            function check(dom,dom_val,pattern,name)
            {
                if(dom == ''){//手机验证
                    dom.parent().addClass("has-error");
                    return false;
                }else if(!pattern.test(dom_val)) {
                    dom.parent().addClass("has-error");
                    return false;
                }else {
                    dom.parent().removeClass("has-error");
                    return true;
                }
            }





        })

    </script>
@stop

