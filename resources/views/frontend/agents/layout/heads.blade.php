
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>天眼互联   [ins].</title>
    <link rel="stylesheet" href="r_frontend/css/font-awesome.min.css">
    <link rel="stylesheet" href="r_frontend/css/bootstrap.min.css">
    <link rel="stylesheet" href="r_frontend/css/style.css">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:600italic,400,800,700,300' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=BenchNine:300,400,700' rel='stylesheet' type='text/css'>
    <script src="r_frontend/js/modernizr.js"></script>

    <link rel="stylesheet" href="r_frontend/product/css/bootstrap.min.css">
    <link rel="stylesheet" href="r_frontend/product/css/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="r_frontend/product/css/style.css" id="theme-styles">


    <script src="r_frontend/product/js/bootstrap.min.js"></script>
    <script src="r_frontend/product/js/modernizr.js"></script>


    <link rel="stylesheet" href="{{ url('r_frontend/product/cyt/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{ url('r_frontend/product/cyt/css/fixed_order.css')}}">
    <script src="{{url('r_frontend/product/cyt/js/jquery-3.2.1.min.js')}}"></script>
    <script src="{{url('r_frontend/product/cyt/js/bootstrap.min.js')}}"></script>



</head>
<body>


<header class="top-header">
    <div class="container">
        <div class="row">
            <div class="col-xs-5 header-logo">
                <br>
                <a href="#">
                    <img src="r_frontend/img/logo.png" title="天眼互联" class="img-responsive logo">

                </a>
            </div>

            <div class="col-md-7">
                <nav class="navbar navbar-default">
                    <div class="container-fluid nav-bar">
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                        </div>


                        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                            <ul class="nav navbar-nav navbar-right">
                                <li><a class="menu active" href="/">主页</a></li>
                                <li><a class="menu" href="http://www.inschos.com/">关于我们</a></li>
                                <li><a class="menu" href="/productlists">产品列表</a></li>
                                @if(!isset($_COOKIE['login_type']))
                                    <li><a class="menu" href="{{ url('/register') }}">注册</a></li>
                                    <li><a class="menu" href="/login">登录</a></li>
                                @else
                                    <li><a class="menu" href="/information/index">个人中心</a></li>
                                    <li><a class="menu" href="/agent_logout">登出</a></li>
                                @endif

                            </ul>
                        </div>
                </nav>
            </div>
        </div>
    </div>
</header>




