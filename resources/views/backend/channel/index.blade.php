@extends('backend.layout.base')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{asset('r_backend/css/libs/nifty-component.css')}}"/>
@endsection
@section('content')
    <div id="content-wrapper">
        <div class="col-lg-12">
            <div class="main-box clearfix">
                <header class="main-box-header clearfix">
                    <h2 class="pull-left">合作渠道管理</h2>
                    <div class="filter-block pull-right" style="margin-right: 20px;">
                        <button class="md-trigger btn btn-primary mrg-b-lg" data-modal="modal-8" id="modal-button">新增合作渠道</button>
                    </div>
                </header>
                @include('backend.layout.alert_info')
                <div class="main-box-body clearfix">
                    <div class="table-responsive">
                        <table class="table user-list table-hover">
                            <thead>
                            <tr>
                                <th class="text-center"><span>公司名称</span></th>
                                {{--<th class="text-center"><span>公司url</span></th>--}}
                                {{--<th class="text-center"><span>代号</span></th>--}}
                                {{--<th class="text-center"><span>描述</span></th>--}}
                                <th class="text-center"><span>邮箱</span></th>
                                <th class="text-center"><span>唯一ID</span></th>
                                <th class="text-center"><span>密钥</span></th>
                                <th class="text-center"><span>创建时间</span></th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($result as $k => $v)
                                <tr>
                                    <td class="text-center">
                                        {{$v->name}}
                                    </td>

                                    <td class="text-center">
                                        {{$v->email}}
                                    </td>
                                    <td class="text-center">
                                        {{$v->only_id}}
                                    </td>
                                    <td class="text-center">
                                        {{$v->sign_key}}
                                    </td>
                                    <td class="text-center">
                                        {{$v->created_at}}
                                    </td>

                                    <td style="width: 15%;">
                                        <a href="#" class="table-link edit-button" value="{{ url('backend/channel/renew', ['id' => $v->id]) }}">
                                        <span class="fa-stack">
                                            <i class="fa fa-square fa-stack-2x"></i>
                                            <i class="fa fa-pencil fa-stack-1x fa-inverse"></i>
                                        </span>
                                        </a>
                                        <a href="javascript:;"
                                           onclick="event.preventDefault();if(confirm('确认要删除吗？')) document.getElementById('delete-form-{{ $v->id }}').submit();"
                                           class="table-link danger">
                                        <span class="fa-stack">
                                            <i class="fa fa-square fa-stack-2x"></i>
                                            <i class="fa fa-trash-o fa-stack-1x fa-inverse"></i>
                                        </span>
                                        </a>

                                        <form action="{{ url('backend/channel/channel_omit', ['id' => $v->id]) }}" id="delete-form-{{ $v->id }}" method="post" style="display: none;">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
                                        </form>
                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>
                    {{--分页--}}
                    <div style="text-align: center;">
                        {{ $result->links() }}
                    </div>

                </div>
            </div>
        </div>

        {{-- 新增用的modal框 --}}
        <div class="md-modal md-effect-8 md-hide" id="modal-8">
            <div class="md-content">
                <div class="modal-header">
                    <button class="md-close close" id="modal-close">×</button>
                    <h4 class="modal-title">新增合作渠道</h4>
                </div>
                <div class="modal-body">
                    <form role="form" id="store-user" action='{{url('backend/channel/channel_check')}}' method="post">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="exampleInputEmail1">公司名称</label>
                            <input class="form-control" name="name" placeholder="公司名称(应少于255个字符长度）" type="text">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">邮箱</label>
                            <input class="form-control" name="email" placeholder="邮箱(应少于100个字符长度)" type="text">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">公司url</label>
                            <input class="form-control" name="url" placeholder="请输入公司的url地址" type="text">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">代号</label>
                            <input class="form-control" name="code" placeholder="请输入公司代号" type="text">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">唯一ID</label>
                            <input class="form-control" name="only_id" placeholder="ID后台生成" type="text" disabled>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">密钥</label>
                            <input class="form-control" name="sign_key" placeholder="密钥后台生成" type="text" disabled>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">描述</label>
                            <textarea class="form-control"  cols="30" rows="10" name="describe" id="content"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary form-submit">确认提交</button>
                </div>
            </div>
        </div>

        <button class="md-trigger btn btn-primary mrg-b-lg" data-modal="edit-modal" id="edit-modal-button" style="display: none;"></button>
        {{-- 编辑账户信息的模态框 --}}
        <div class="md-modal md-effect-8 md-hide" id="edit-modal">
            <div class="md-content">
                <div class="modal-header">
                    <button class="md-close close" id="edit-modal-close">×</button>
                    <h4 class="modal-title">编辑代理商API账户</h4>
                </div>
                <div class="modal-body">
                    <form role="form" id="store-user" method="post">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        <div class="form-group">
                            <label for="exampleInputEmail1">公司名称</label>
                            <input class="form-control" name="name" placeholder="代理商名称(应少于255个字符长度）" type="text">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">邮箱</label>
                            <input class="form-control" name="email" placeholder="邮箱(应少于100个字符长度)" type="text">
                        </div>


                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary form-submit">确认提交</button>
                </div>
            </div>
        </div>
        <div class="md-overlay"></div>
    </div>
@stop
@section('foot-js')
    <script charset="utf-8" src="/r_backend/js/modernizr.custom.js"></script>
    <script charset="utf-8" src="/r_backend/js/classie.js"></script>
    <script charset="utf-8" src="/r_backend/js/modalEffects.js"></script>
    <script>
        $(function(){
            var $edit = false;
            var $submit = $(".form-submit");
            $submit.click(function(){
                var $form = $(this).parents(".modal-footer").siblings(".modal-body").children("form");
                var $name = $form.find("input[name=name]").val();
                var $name_role = /^[（）\u4e00-\u9fa5a-zA-Z\s\-_()]{3,50}$/;
                var $name_check = $name_role.test($name);

                var $email = $form.find("input[name=email]").val();
                var $email_role = /(?:[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*|"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:(2(5[0-5]|[0-4][0-9])|1[0-9][0-9]|[1-9]?[0-9]))\.){3}(?:(2(5[0-5]|[0-4][0-9])|1[0-9][0-9]|[1-9]?[0-9])|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])/;
                var $email_check = $email_role.test($email);

                if($name_check && $email_check ){
                    $form.submit();
                }else{
                    alert("请根据输入框提示填写相关内容");
                }

            })

            // 编辑
            $(".edit-button").on("click", function () {
                $edit = true;
                $(".modal-title").text("编辑合作渠道");
                $("#edit-modal-button").trigger("click");
                $("#edit-modal form").attr("action", $(this).attr("value"))
                var $data = $(this).parents("tr").children("td");
                $("input[name=name]").val(trim($data.eq(0).text()));
                $("input[name=email]").val(trim($data.eq(1).text()));
            });

            $("#edit-modal-close").on("click", function () {
                $(".modal-title").text("添加合作渠道");
                $edit = false;
            });
        })

        function trim(str) {
            return str.replace(/(^\s*)|(\s*$)/g, "");
        }
    </script>
@stop

