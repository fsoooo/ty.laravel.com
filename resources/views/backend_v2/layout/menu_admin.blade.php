<?php
$roles_active =  preg_match("/roles/",Request::getPathinfo()) ? "class=active" : '';
$permission_active = preg_match("/permissions/",Request::getPathinfo()) ? "class=active" : '';
$bind_active = preg_match("/role_bind_permission/",Request::getPathinfo()) ||preg_match("/role_find/",Request::getPathinfo())? "class=active" : '';
$user_active = preg_match("/user_bind/",Request::getPathinfo())||preg_match("/user_find_roles/",Request::getPathinfo())  ? "class=active" : '';
$roles_active = $user_active=="class=active" ? '' : $roles_active;
$permission_active = $bind_active=="class=active" ? '' : $permission_active;
$nothing_active = !($roles_active || $permission_active || $bind_active || $user_active ) ? "class=active" : '';
?>
<div class="menu-wrapper">
    <ul>
        <li {{$nothing_active}}><a href="{{url('/backend')}}"><i class="iconfont icon-shouye"></i>首页</a></li>
        <li {{$roles_active}}><a href="{{url('backend/role/roles')}}"><i class="iconfont icon-dailiren"></i>角色管理</a></li>
        <li {{$permission_active}}><a href="{{url('backend/role/permissions')}}"><i class="iconfont icon-chanpin"></i>权限管理</a></li>
        <li {{$bind_active}}><a href="{{url('backend/role/role_bind_permission') }}"><i class="iconfont icon-xing"></i>角色权限</a></li>
        <li {{$user_active}}><a href="{{url('backend/role/user_bind_roles')}}"><i class="iconfont icon-qudao"></i>账户角色</a></li>
    </ul>
</div>
