<!DOCTYPE html>
<html>
<head>
    @include('frontend.agents.agent_home.head')
</head>
<body>
<div class="header-wrapper">
    <div class="header">
        @include('frontend.agents.agent_home.top')
    </div>
</div>
<div class="main-wrapper clearfix">
    @if($option != 'message')
    @if($option == 'account')
        @include('frontend.agents.agent_home.account_menu')
    @else
        @include('frontend.agents.agent_home.menu')
    @endif
    @endif
    <div class="content-wrapper  fr">
        <!--主体内容-->
        @yield('content')
        @include('frontend.agents.agent_home.communication')
        @include('frontend.agents.agent_home.right_menu')
    </div>
</div>
<!--右侧边栏-->

@include('frontend.agents.agent_home.foot')

</body>
</html>
