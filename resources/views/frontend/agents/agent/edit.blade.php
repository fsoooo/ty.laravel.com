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
                            <li><a href="/agent/my_cust/all">我的客户</a></li>
                            <li class="active"><a href="#">修改客户信息</a></li>

                        </ol>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="main-box clearfix" style="min-height: 1100px;">
                            <div class="tabs-wrapper tabs-no-header">
                                <ul class="nav nav-tabs">
                                    <li class="active"><a href="#">修改客户信息</a></li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane fade in active" id="tab-accounts">
                                        @include('frontend.agents.layout.alert_info')
                                        <div class="panel-group accordion" id="operation">
                                            <div class="panel panel-default">
                                                    <form action="{{ url('/agent/edit_cust') }}" method="post" id="form">
                                                            {{ csrf_field() }}
                                                            <table id="user" class="table table-hover" style="clear: both">
                                                                <tbody>

                                                                @if($type == 'company')
                                                                    <input type="text" name="type" value="company" hidden>
                                                                        <input type="text" name="cust_id" value="{{ $detail->id }}" hidden>
                                                                        <tr>
                                                                            <td width="15%">企业名称</td>
                                                                            <td width="60%">
                                                                                <input type="text" class="form-control" placeholder="请输入企业名称" name="name" value="{{ $detail->name }}">
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>三码合一</td>
                                                                            <td>
                                                                                <input class="form-control" type="text" name="code" placeholder="请输入三码合一" value="{{ $detail->code }}" disabled>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td width="15%">联系电话</td>
                                                                            <td width="60%">
                                                                                <input type="text" class="form-control" placeholder="请输入联系电话" name="phone" value="{{ $detail->phone }}">
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>企业邮箱</td>
                                                                            <td>
                                                                                <input type="text" class="form-control" placeholder="请输入企业邮箱" name="email" value="{{ $detail->email }}">
                                                                            </td>
                                                                        </tr>
                                                                @else
                                                                    <input type="text" name="type" value="person" hidden>
                                                                        <input type="text" name="cust_id" value="{{ $detail->id }}" hidden>
                                                                        <tr>
                                                                            <td width="15%">客户名称</td>
                                                                            <td width="60%">
                                                                                <input type="text" class="form-control" placeholder="请输入客户名称" name="name" value="{{ $detail->name }}">
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>身份证号</td>
                                                                            <td>
                                                                                <input class="form-control" type="text" name="code" placeholder="请输入身份证号" value="{{ $detail->code }}" disabled>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td width="15%">联系电话</td>
                                                                            <td width="60%">
                                                                                <input type="text" class="form-control" placeholder="请输入联系电话" name="phone" value="{{ $detail->phone }}">
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>企业邮箱</td>
                                                                            <td>
                                                                                <input type="text" class="form-control" placeholder="请输入企业邮箱" name="email" value="{{ $detail->email }}">
                                                                            </td>
                                                                        </tr>
                                                                @endif

                                                                </tbody>
                                                            </table>
                                                    </form>
                                            </div>
                                                <button id="btn" index="edit" class="btn btn-success">确认修改</button>
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
            var btn = $('#btn');
            var form = $('#form');
            var cust_id_input = $('input[name=cust_id]');




            var code_pattern = /^$/ig;
//            var phone_pattern =
            var btn_type = btn.attr('index');
            btn.click(function(){
                var name_val = name.val();
                var code_val = code.val();
                if(name_val == ''){
                    name.parent().addClass("has-error");
                    alert('名称不能为空');
                    return false;
                }else{
                    name.parent().removeClass("has-error");
                    console.log(name_val);
                    if(code_val == ''){
                        code.parent().addClass("has-error");
                        alert('证件号不为空');
                        return false;
                    }else {
                        code.parent().removeClass("has-error");
                    }
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


        })

    </script>
@stop

