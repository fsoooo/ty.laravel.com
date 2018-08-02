<!DOCTYPE html>
<html>
@include('frontend.guests.layout.head')
<body>
<div id="theme-wrapper">
    <header class="navbar" id="header-navbar">
        @include('frontend.guests.layout.menu_head')
    </header>
    <div id="page-wrapper" class="container">
        <div class="row">
            @include('frontend.guests.layout.menu_left')
            @yield('content')
        </div>
    </div>
</div>
@include('frontend.guests.layout.menu_set')
@include('frontend.guests.layout.foot')
</body>
</html>