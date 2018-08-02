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
                            <li><a href="/agent/index/all"><span>代理的客户</span></a></li>
                            <li class="active"><a href="">添加联系记录</a></li>

                        </ol>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="main-box clearfix" style="min-height: 1100px;">
                            <div class="tabs-wrapper tabs-no-header">
                                <ul class="nav nav-tabs">
                                    <li><a href="{{ url('/agent/my_cust/all') }}">客户池</a></li>
                                    <li><a href="{{ url('/agent/index/all') }}">代理的客户</a></li>
                                    <li class="active"><a href="">添加联系记录</a></li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane fade in active" id="tab-accounts">
                                        @if($controller == 'add')
                                            <h3><p>联系记录</p></h3>
                                        @else
                                            <h3><p>修改联系记录</p></h3>
                                        @endif
                                        @include('frontend.agents.layout.alert_info')
                                        <div class="panel-group accordion" id="operation">
                                            <div class="panel panel-default">
                                                <form action="{{ url('/agent/add_evolve_submit') }}" method="post" id="form">
                                                    {{ csrf_field() }}
                                                    <table id="user" class="table table-hover" style="clear: both">
                                                        <tbody>
                                                        <tr>
                                                            <input type="text" name="cust_id" value="{{ $cust_id }}" hidden>
                                                            <input type="text" name="code" value="{{ $code }}" hidden>
                                                            <td>联系人</td>
                                                            <td>
                                                                <input type="text" class="form-control" placeholder="请输入联系人姓名" name="evolve_person">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td width="15%">联系方式</td>
                                                            <td width="60%">
                                                                <input type="text" class="form-control" placeholder="请输入联系方式" name="evolve_way">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>联系状态</td>
                                                            <td>
                                                                <select id="" class="form-control" id="evolve-status" name="evolve_status">
                                                                    <option value="1">选择联系状态</option>
                                                                    @foreach($status_list as $value)
                                                                        <option value="{{ $value->id }}">{{ $value->status_name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>备注说明</td>
                                                            <td>
                                                                <textarea class="form-control" id="content-text" name="remarks" id="" cols="30" rows="10"></textarea>
                                                            </td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </form>
                                            </div>
                                            <button id="send-message-btn" class="btn btn-success">发送</button>
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
            //选择联系状态



            //进行验证发送
            var evolve_person = $('input[name=evolve_person]');
            var evolve_way = $('input[name=evolve_way]');
            var evolve_status = $('input[name=evolve_status]');
            var remarks = $('input[name=remarks]');



            var content = $('#content-text');
            var btn = $('#send-message-btn');
            var form = $('#form');
            btn.click(function(){
                var evolve_person_val = evolve_person.val();
                var evolve_way_val = evolve_way.val();
                var evolve_status_val = evolve_status.val();
                var remarks_val = remarks.val();
                if(evolve_person_val == ''){
                    evolve_person.parent().addClass("has-error");
                    alert('请输入联系人姓名');
                    return false;
                }else{
                    evolve_person.parent().removeClass("has-error");
                    if(evolve_way_val == ''){
                        evolve_way.parent().addClass("has-error");
                        alert('请输入联系方式');
                        return false;
                    }else {
                        content.parent().removeClass("has-error");
                        if(evolve_status_val == 0){
                            evolve_status.parent().addClass("has-error");
                            alert('请选择联系状态');
                            return false;
                        }else {
                            evolve_status.parent().removeClass('has-error');
                        }
                    }
                }
                var data = form.serialize();
                form.submit();
//                $.ajax({
//                    type: "post",
//                    dataType: "json",
//                    async: true,
//                    //修改的地址，
//                    url: "/agent/add_evolve_submit",
//                    data: data,
//                    headers: {
//                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
//                    },
//                    success: function(data){
//                        var status = data['status'];
//                        alert(data['data']);
//                        if(status == 200){
////                            alert('发送成功');
//                        }else {
////                            alert('发送失败');
//                        }
//                    },error: function () {
//                        alert('发送失败');
//                    }
//                });
            })


        })

    </script>
@stop

