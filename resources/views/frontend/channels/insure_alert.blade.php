@if (session('status'))
    <div class="mask">
        <div class="mask-bg"></div>
        <div class="mask-container">{{session('status')}}</div>
    </div>
@endif

@if (isset($errors)&&count($errors) > 0)
    <div class="mask">
        <div class="mask-bg"></div>
        @foreach ($errors->all() as $error)
            <div class="mask-container">{{ $error }}</div>
        @endforeach
    </div>
@endif