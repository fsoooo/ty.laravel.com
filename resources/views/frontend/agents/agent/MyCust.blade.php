@extends('frontend.agents.layout.agent_bases')
@section('content')
    <meta name="_token" content="{{ csrf_token() }}"/>
    <style>
        th,td{
            text-align: center;
        }
    </style>
    <div id="content-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <ol class="breadcrumb">
                            <li><a href="/agent/">主页</a></li>
                            <li>客户管理</li>
                            <li><a href="/agent/my_cust/all"><span>我的客户</span></a></li>
                            @if($type == 'all')
                                <li class="active"><a href="{{ url('/agent/my_cust/all') }}">客户池</a></li>
                            @elseif($type == 'person')
                                <li class="active"><a href="{{ url('/agent/my_cust/person') }}">个人客户</a></li>
                            @elseif($type == 'company')
                                <li class="active"><a href="{{ url('/agent/my_cust/company') }}">企业客户</a></li>
                            @endif
                        </ol>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="main-box clearfix" style="min-height: 1100px;">
                            <div class="tabs-wrapper tabs-no-header">
                                <ul class="nav nav-tabs">
                                    @if($type == 'all')
                                        <li class="active"><a href="{{ url('/agent/my_cust/all') }}">客户池</a></li>
                                        <li><a href="{{ url('/agent/my_cust/person') }}">个人客户</a></li>
                                        <li><a href="{{ url('/agent/my_cust/company') }}">企业客户</a></li>
                                    @elseif($type == 'person')
                                        <li><a href="{{ url('/agent/my_cust/all') }}">客户池</a></li>
                                        <li class="active"><a href="{{ url('/agent/my_cust/person') }}">个人客户</a></li>
                                        <li><a href="{{ url('/agent/my_cust/company') }}">企业客户</a></li>
                                    @elseif($type == 'company')
                                        <li><a href="{{ url('/agent/my_cust/all') }}">客户池</a></li>
                                        <li><a href="{{ url('/agent/my_cust/person') }}">个人客户</a></li>
                                        <li class="active"><a href="{{ url('/agent/my_cust/company') }}">企业客户</a></li>
                                    @endif
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane fade in active" id="tab-accounts">
                                        <h3>
                                            <p>客户信息</p>
                                        </h3>
                                        {{--<div class="add" style="float: right;">--}}
                                            {{--<button><a href="{{ url('/agent/my_cust/person') }}">个人客户</a></button>--}}
                                            {{--<button><a href="{{ url('/agent/my_cust/company') }}">企业客户</a></button>--}}
                                        {{--</div>--}}
                                        @include('frontend.agents.layout.alert_info')
                                        <div class="panel-group accordion" id="account">
                                            <div class="panel panel-default">
                                                <table id="user" class="table table-hover" style="clear: both">
                                                    <thead>
                                                    <tr>
                                                        <th><span>客户名称</span></th>
                                                        <th><span>联系方式</span></th>
                                                        <th><span>邮箱地址</span></th>
                                                        <th><span>身份标识</span></th>
                                                        <th><span>类型</span></th>
                                                        <th><span>操作</span></th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @if($count == 0)
                                                        <tr>
                                                            <td colspan="7" style="text-align: center;">
                                                                暂无客户
                                                            </td>
                                                        </tr>
                                                    @else
                                                        @foreach ( $list as $value )
                                                            <tr>
                                                                <td>{{ $value->name }}</td>
                                                                <td>{{ $value->phone }}</td>
                                                                <td>{{ $value->email }}</td>
                                                                <td>{{ $value->code }}</td>
                                                                <td>
                                                                    @if($value->type == 0)
                                                                        <a href="{{ url('/agent/my_cust/person') }}">个人客户</a>
                                                                    @else
                                                                        <a href="{{ url('/agent/my_cust/company') }}">企业客户</a>
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    <div class="btn-group">
                                                                        <button type="button" class="btn btn-link dropdown-toggle" data-toggle="dropdown" >
                                                                            操作 <span class="caret"></span>
                                                                        </button>
                                                                        <ul class="dropdown-menu">
                                                                            <li>
                                                                                @if($value->type == 0)
                                                                                    <a href="{{ url('/agent/edit/person/'.$value->id) }}">修改</a>
                                                                                @else
                                                                                    <a href="{{ url('/agent/edit/company/'.$value->id) }}">修改</a>
                                                                                @endif
                                                                            </li>
                                                                            <li>
                                                                                <a href="{{ url('/agent/apply_id/'.$value->id) }}">申请代理权</a>
                                                                            </li>
                                                                            <li>
                                                                                <a  href="javascript:" id="{{ $value->id }}" class="del-cust" name="{{ $value->name }}">删除</a>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
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
    <script src="/js/jquery-3.1.1.min.js"></script>
    <script>
        //删除客户
        var del_cust = $('.del-cust');
        del_cust.each(function (i,item) {
            $(item).click(function(){
                var del_name = $(item).attr('name');
                var del_cust_id = $(item).attr('id');
                if(confirm('确定要删除客户 '+del_name+' 吗?')){
                    $.ajax({
                        type: "post",
                        dataType: "json",
                        async: true,
                        //修改的地址，
                        url: "/agent/del_cust",
                        data: 'cust_id='+del_cust_id,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                        },
                        success: function(data){
                            var status = data['status'];
                            if(status == 200){
                                alert('删除成功');
                                location.reload();
                            }else {
                                alert('删除失败');
                            }
                        },error: function () {
                            alert("删除失败");
                        }
                    });
                }
            })
        })
    </script>
@stop

