<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{--<title>天眼互联   [ins].</title>--}}
    <title>天眼互联-科技让保险无限可能</title>
    <link rel="stylesheet" href="r_frontend/css/font-awesome.min.css">
    <link rel="stylesheet" href="r_frontend/css/bootstrap.min.css">
    <link rel="stylesheet" href="r_frontend/css/style.css">
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



    <link rel="stylesheet" href="{{url('r_frontend/product/redio/css/jquery-labelauty.css')}}">
    <script src="{{url('r_frontend/product/redio/js/jquery-1.8.3.min.js')}}"></script>
    <script src="{{url('r_frontend/product/redio/js/jquery-labelauty.js')}}"></script>

    <style>
        ul { list-style-type: none;}
        li { display: inline-block;}
        li { margin: 10px 0;}
        input.labelauty + label { font: 12px "Microsoft Yahei";}
    </style>
</head>
<body>


<header class="top-header">
    <div class="container">
        <div class="row">
            <div class="col-xs-5 header-logo">
                <br>
                <a href="/">
                    <img src="r_frontend/img/logo.png" title="天眼互联" class="img-responsive logo">
                </a>
            </div>

            <div class="col-md-7">
                <nav class="navbar navbar-default" style="border:none;background:none">
                    <div class="container-fluid nav-bar" style="border:none;background:none">
                        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1" >
                            <ul class="nav navbar-nav navbar-right" >
                                <li><a class="menu"  id="indexs" href="/">主页</a></li>
                                <li><a class="menu" href="http://www.inschos.com/" target="_blank">关于我们</a></li>
                                <li><a class="menu"  id="productlist" href="/productlists" >产品列表</a></li>
                                @if(!isset($_COOKIE['login_type']))
                                    <li><a class="menu" href="{{ url('/register') }}">注册</a></li>
                                    <li><a class="menu" href="/login">登录</a></li>
                                @else
                                    <li><a class="menu" href="/information/index">个人中心</a></li>
                                    {{--@if(Auth::user()->agent)--}}
                                        {{--<li><a class="menu" href="/agent/my_cust/all">代理人工具</a></li>--}}
                                    {{--@endif--}}
                                    <li><a class="menu" href="/logout">登出</a></li>
                                @endif
                            </ul>
                        </div>
                </nav>
            </div>
        </div>
        @if(isset($res['name']))
            <h4><a href="/productlists">产品列表</a>><a href="javascript:void(0)" onclick="location.reload()">产品详情</a>> <span style="color: rgb(58,158,203)">{{$res['name']}}</span></b></h4>
        @endif
    </div>

</header>




