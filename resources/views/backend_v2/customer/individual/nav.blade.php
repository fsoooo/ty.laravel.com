<div class="row">
    <div class="section">
        <div class="col-md-4 col-xs-6">
            <a href="{{ route('backend.customer.individual.detail', [$user->id]) }}" class="section-item {{ $type == 'detail' ? 'active' : '' }}">个人信息</a>
        </div>
        <div class="col-md-4 col-xs-6">
            <a href="{{ route('backend.customer.individual.insurance', [$user->id]) }}" class="section-item {{ $type == 'insurance' ? 'active' : '' }}">保险记录</a>
        </div>
        {{--<div class="col-md-3 col-xs-6">--}}
            {{--<a href="{{ route('backend.customer.individual.operation', [$user->id]) }}" class="section-item {{ $type == 'operation' ? 'active' : '' }}">操作记录</a>--}}
        {{--</div>--}}
        <div class="col-md-4 col-xs-6">
            <a href="{{ route('backend.customer.individual.verification', [$user->id]) }}" class="section-item {{ $type == 'verification' ? 'active' : '' }}">实名资料</a>
        </div>
    </div>
</div>