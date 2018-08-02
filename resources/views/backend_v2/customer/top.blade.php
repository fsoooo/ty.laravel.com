@if(Auth::guard('admin')->user()->email==config('manager_account.manager'))
<div class="nav-top-wrapper">
    <ul>
        <li {{ $type == 'user' ? 'class=active' : '' }}><a href="{{ route('backend.customer.individual.index') }}">个人客户</a></li>
        <li {{ $type == 'company' ? 'class=active' : '' }}><a href="{{ route('backend.customer.company.index') }}">企业客户</a></li>
        {{--<li><a href="#">组织团体</a></li>--}}
        <li {{ $type == 'unverified' ? 'class=active' : '' }}><a href="{{ route('backend.customer.unverified') }}">待审核</a></li>
    </ul>
</div>
@endif