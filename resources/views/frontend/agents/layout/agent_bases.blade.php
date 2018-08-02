<!DOCTYPE html>
<html>
@include('frontend.agents.layout.head')
<body>
<div id="theme-wrapper">
    <header class="navbar" id="header-navbar">
        @include('frontend.agents.layout.agent_menu_head')
    </header>
    <div id="page-wrapper" class="container">
        <div class="row">
            @include('frontend.agents.layout.agent_menu_left')
            @yield('content')
        </div>
    </div>
</div>
@include('frontend.agents.layout.menu_set')
@include('frontend.agents.layout.foot')
</body>
</html>