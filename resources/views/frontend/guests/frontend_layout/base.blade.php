<!DOCTYPE html>
<html>
@include('frontend.guests.frontend_layout.head')
<body>
<div class="wrap">
    <div class="head">
        @include('frontend.guests.frontend_layout.menu_head')
    </div>

    <div class="main">
        @yield('content')
    </div>
    <div class="aside">
        @include('frontend.guests.frontend_layout.aside')
    </div>
    <div class="footer">

    </div>
</div>

{{--@include('frontend.guests.frontend_layout.menu_set')--}}
{{--@include('frontend.guests.frontend_layout.foot')--}}
</body>
</html>