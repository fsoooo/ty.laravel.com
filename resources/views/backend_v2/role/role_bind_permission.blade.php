@extends('backend_v2.layout.base')
@section('title')角色权限关联 @stop
@section('head-more')
    <link rel="stylesheet" href="{{asset('r_backend/v2/css/label.css')}}" />
@stop
@section('top_menu')
    <div class="nav-top-wrapper fl">
        <ul>
            <li class="active">
                <a>角色权限关联</a>
            </li>
        </ul>
    </div>
@stop
@section('main')
    <div class="main-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <form role="form" id='select_role' action="{{asset('backend/role/role_find_permissions')}}" method="post">
                    {{ csrf_field() }}
                <div class="label-section label-top" style="height: 80px;line-height: 40px;">
                        <select  id="role_select" class="form-control search_agents" name="role_id">
                            <option value="0" selected disabled>--请选择角色--</option>
                            @foreach($roles as $rk => $rv)
                                <option value="{{$rv->id}}" @if(!empty($role) && $role->id == $rv->id)selected @endif>{{$rv->name.'---------------------'.$rv->display_name}}</option>
                            @endforeach
                        </select>
                </div>
                </form>
            </div>
        </div>
        <form role="form" id="bind" action="{{asset('backend/role/attach_permissions')}}" method="post">
            {{ csrf_field() }}
        <div class="row">
            <div class="col-lg-12">
                <div class="label-section label-middle" style="height: 240px;">
                    <div class="label-wrapper">
                        @if(!empty($role))
                            <div class="form-group">
                                <input type="hidden" name="check_role_id" value="{{$role->id}}">
                                @foreach($permissions as $pk => $pv)
                                    <div class="checkbox-nice" style="float:left;margin-left: 20px;">
                                        <input id="checkbox-{{$pk}}" name="permission_ids[]" @if(!empty($role_permission_ids) && in_array($pv->id, $role_permission_ids)) checked @endif
                                        type="checkbox" value="{{$pv->id}}">
                                        <label for="checkbox-{{$pk}}">
                                            {{$pv->name}}----{{$pv->display_name}}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="label-section label-bottom">
                        <button id="addLabel" class="btn btn-primary">提交绑定关系</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <script src="{{asset('r_backend/v2/js/lib/jquery-1.11.3.min.js')}}"></script>
    <script src="{{asset('r_backend/v2/js/lib/bootstrap.min.js')}}"></script>
    <script src="{{asset('r_backend/v2/js/label.js')}}"></script>
    <script src="{{asset('r_backend/v2/js/common_backend.js')}}"></script>
    <script>
        $('#role_select').change(function(){
            var role_id = $(this).val();
            if(role_id != 0){
                $('#select_role').submit();
            }
        });
        $("#attach_submit").click(function(){
            $('#bind').submit();
        })
    </script>
@stop