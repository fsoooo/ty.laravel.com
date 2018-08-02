@extends('backend_v2.layout.base')
@section('title')@parent 权限管理 @stop
@section('head-more')
    <link rel="stylesheet" href="{{asset('r_backend/v2/css/agent.css')}}" />
@stop
@section('top_menu')
@stop
@section('main')
    <div id="agent" class="main-wrapper">
        <div class="row">
            <div class="ui-table">
                <div class="ui-table-header radius">
                    <span class="col-md-1">权限编号</span>
                    <span class="col-md-2">权限名称</span>
                    <span class="col-md-3">权限全称</span>
                    <span class="col-md-3">权限描述</span>
                    <span class="col-md-2">修改时间</span>
                    <span class="col-md-1">操作</span>
                </div>
                <div class="ui-table-body">
                    <ul>
                        @foreach($permissions as $value)
                            <li class="ui-table-tr">
                                <div class="col-md-1"> {{$value['id']}} </div>
                                <div class="col-md-2 color-default"> {{$value['name']}} </div>
                                <div class="col-md-3 color-default"> {{$value['display_name']}} </div>
                                <div class="col-md-3 color-default"> {{$value['description']}} </div>
                                <div class="col-md-2 color-default"> {{empty($value['created_at'])?$value['updated_at']:$value['created_at']}}</div>
                                <div class="col-md-1 color-default"><a href="" data-toggle="modal" data-target="#updateAgent{{$value['id']}}"><button class="btn btn-primary" type="button">修改</button></a></div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
            <button class="btn btn-warning" data-toggle="modal" data-target="#addAgent">新增权限<i class="iconfont icon-add"></i></button>
        </div>
        <div class="row" style="text-align: center">{{ $permissions->links() }}</div>
    </div>
    {{--新增角色--}}
    <div class="modal fade" id="addAgent" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="" data-dismiss="modal" aria-label="Close"><i class="iconfont icon-guanbi"></i></button>
                    <h4 class="modal-title">新增权限</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" action="{{url('backend/role/post_add_permission')}}" method="post">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <div class="col-sm-12">
                                <input type="text" class="form-control" placeholder="权限名称" name="name">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <input type="text" class="form-control" placeholder="权限全称" name="display_name">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <input type="text" class="form-control" placeholder="权限描述" name="description">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button id="add" class="btn btn-primary" disabled>确认添加</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    @foreach($permissions as $value)
        <div class="modal fade" id="updateAgent{{$value['id']}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="" data-dismiss="modal" aria-label="Close"><i class="iconfont icon-guanbi"></i></button>
                        <h4 class="modal-title">修改权限</h4>
                    </div>
                    <div class="modal-body">
                        <form class="form-horizontal" action="{{url('backend/role/modifypower')}}" method="post">
                            {{ csrf_field() }}
                            <input type="hidden" name="power_id" value="{{$value['id']}}">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" placeholder="权限名称" name="name" value="{{$value['name']}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" placeholder="权限全称" name="display_name" value="{{$value['display_name']}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" placeholder="权限描述" name="description" value="{{$value['description']}}">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button id="update" class="btn btn-primary">确认添加</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    @endforeach
@stop
@section('footer-more')
    <script>
        $('#addAgent input').bind('input propertychange', function() {
            document.getElementById('add').disabled = !checkMustFill('#addAgent input');
        });
        $(".search_agents").change(function(){
            $("#search_agent").submit();
        });
    </script>
@stop

