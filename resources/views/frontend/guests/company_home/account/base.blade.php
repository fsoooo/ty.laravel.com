<!DOCTYPE html>
<html>

<head>
    @include('frontend.guests.company_home.account.head')
</head>

<body>
<div class="content">
    <div class="content-inside">
        <!--头部信息-->
        <div class="header">
            @include('frontend.guests.company_home.account.top')
        </div>
        <div class="main clearfix">
            <div class="menu-wrapper">
                @include('frontend.guests.company_home.account.left')
            </div>
            <div class="main-wrapper">
                @yield('content')
            </div>
        </div>
    </div>
</div>
<!--页脚-->
<div class="footer">
    @include('frontend.guests.company_home.account.foot')
</div>
</body>
</html>