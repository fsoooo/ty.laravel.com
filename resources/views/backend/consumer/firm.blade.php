@extends('backend.layout.base')
@section('content')
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <div id="content-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <ol class="breadcrumb">
                            <li><a href="{{ url('/backend') }}">主页</a></li>
                            <li ><span>用户管理</span></li>
                            <li class="active"><span>个人用户</span></li>
                        </ol>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="main-box clearfix">
                            <ul class="nav nav-tabs">
                                <li><a href="{{ url('/backend/user_management/user_list') }}">个人用户</a></li>
                                <li class="active"><a href="{{ url('backend/user_management/firm') }}">企业用户</a></li>
                            </ul>
                            <header class="main-box-header clearfix">
                                @include('backend.layout.alert_info')
                            </header>
                            <div class="main-box-body clearfix">
                                <div class="table-responsive">

                                    {{--<input type="text" id="seach"> <button class="btn search btn-success">搜索</button>--}}

                                    <table id="user" class="table table-hover" style="clear: both">
                                        <thead>
                                        <tr>
                                            <th>用户名称</th>
                                            <th>手机号</th>
                                            <th>邮箱</th>
                                            <th>身份标识</th>
                                            <th>地址</th>
                                            <th>注册时间</th>
                                            <th>状态</th>
                                            <th>操作</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ( $users as $value )
                                            <tr>
                                                <td>{{ $value->real_name }}</td>
                                                <td>{{ $value->phone }}</td>
                                                <td>{{ $value->email }}</td>
                                                <td>{{ $value->code }}</td>
                                                <td>{{ $value->created_at }}</td>
                                                <td>{{ $value->address }}</td>
                                                <td>
                                                    @if(isset($count))
                                                        会员
                                                    @else
                                                        非会员
                                                    @endif
                                                </td>
                                                {{--<input type="hidden" value="{{ $value->id }}" id="id">--}}
                                                {{--<td><button sole="{{ $value->id }}" id="send_sms" class="btn btn-success"></button></td>--}}
                                                <td><button sole="{{ $value->id }}" id="send_sms" class="btn btn-success" phone="{{ $value->phone }}">密码重置</button></td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div style="text-align: center;">
                                {{ $users->links() }}
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
@stop
<script src="/js/jquery-3.1.1.min.js"></script>
<script>
//    $(function(){
//        $(".search").click(function(){
//           var search = $("#seach").val();
//            $.ajax({
//                url: "/backend/user_management/inde",
//                type: "post",
//                data: {'search':search},
//                dataType: "json",
//                success: function (data) {
//                   alert(data);
//                }
//            });
//
//        })
//    });



    $(function(){
        $(".btn-success").click(function(){
            var id = $(this).attr("sole");
            var phone = $(this).attr("phone");
            var name = $(this).attr("name");
            var model = '134321';
            var pwd="";
            for(var i=0;i<6;i++)
            {
                pwd+=Math.floor(Math.random()*10);
            }

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "/backend/user_management/short_message",
                type: "get",
                data: {'id':id,'pwd':pwd},
                dataType: "json",
                success: function (data) {
                    if(data.status == 0){
                        sendSms(phone,model,name,pwd);
                    } else {
                        alert('密码重置失败');
                    }
                }
            });

            function sendSms(phone, model,name,pwd){
                $.get('/backend/sendsms',
                        {'phone':phone,'model':model,'name':name,'sms_content':pwd},
                        function (data) {
                            if(data['content'] == undefined){
                                alert(data['message']);
                            }else{
                                alert(data['content']);
                            }
                        }
                );
            }
        })
    })

</script>




















