<?php
if(!Cache::has('user_roles_array' . \Auth::guard('admin')->user()->email)){
    $roles = array();
    $r = Auth::guard('admin')->user()->roles;
    foreach($r as $k => $v){
        $roles[] = $v->name;
    }
    $expiresAt = Carbon\Carbon::now()->addMinutes(config('session.lifetime'));
    \Cache::put('user_roles_array' .  Auth::guard('admin')->user()->email, $roles, $expiresAt);
}
$roles = Cache::get('user_roles_array' . Auth::guard('admin')->user()->email);
?>
{{--管理员菜单--}}
@if(in_array('admin',$roles))
    @include('backend_v2.layout.menu_admin')
@endif
{{--平台所属者菜单--}}
@if(in_array('owner', $roles))
    @include('backend_v2.layout.menu_owner')
@endif
{{--业管专员菜单--}}
@if(in_array('worker', $roles))
    @if(Auth::guard('admin')->user()->email=='yunda@inschos.com')
        @include('backend_v2.layout.menu_yunda')
    @elseif(Auth::guard('admin')->user()->email=='douwan@inschos.com')
        @include('backend_v2.layout.menu_douwan')
    @else
        @include('backend_v2.layout.menu_woker')
    @endif
@endif
