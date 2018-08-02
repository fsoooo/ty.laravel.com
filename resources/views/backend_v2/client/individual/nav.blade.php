<div class="row">
    <div class="section">
        <div class="col-md-4 col-xs-6">
            <a href="{{ route('backend.customer.individual.detail', [$user->id]) }}" class="section-item {{ $nav_type == 'detail' ? 'active' : '' }}">个人信息</a>
        </div>
        <div class="col-md-4 col-xs-6">
            <a href="{{ route('backend.customer.individual.insurance', [$user->id]) }}" class="section-item {{ $nav_type == 'insurance' ? 'active' : '' }}">保险记录</a>
        </div>
        <div class="col-md-4 col-xs-6">
            <a href="{{ route('backend.customer.individual.operation', [$user->id]) }}" class="section-item {{ $nav_type == 'operation' ? 'active' : '' }}">操作记录</a>
        </div>
    </div>
</div>