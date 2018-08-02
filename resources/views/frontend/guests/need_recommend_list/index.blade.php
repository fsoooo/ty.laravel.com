<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>天眼互联   [ins].</title>
    <link rel="stylesheet" href="{{url('r_frontend/css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{url('r_frontend/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{url('r_frontend/css/style.css')}}">
    <script src="{{url('r_frontend/js/modernizr.js')}}"></script>
    <link rel="stylesheet" href="{{url('r_frontend/product/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{url('r_frontend/product/css/font-awesome/css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{url('r_frontend/product/css/style.css')}}" id="theme-styles">

    <script src="{{url('r_frontend/product/cyt/js/jquery-3.2.1.min.js')}}"></script>

    <script src="{{url('r_frontend/product/js/bootstrap.min.js')}}"></script>
    <script src="{{url('r_frontend/product/js/modernizr.js')}}"></script>


    <link rel="stylesheet" href="{{ url('r_frontend/product/cyt/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{ url('r_frontend/product/cyt/css/fixed_order.css')}}">
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
    <style>
        .list_box{
            margin-top: 200px;
        }
        .list_box h3{
            margin-bottom: 50px;
        }
        .hidMe{
            cursor: pointer;
        }
        .table_box{
            margin: 0 auto;
            /*border: 1px solid red;*/
        }
        .title{
            /*float: left;*/
            /*border: 1px solid black;*/
        }
        .name{
            display: inline-block;
            text-align: center;
            width: 45%;
        }
        .tabld_body{
            /*border: 1px solid yellow;*/
            position: relative;
            padding-bottom: 50px;
        }
        /*.value{*/
            /*text-align: center;*/
            /*width: 45%;*/
            /*display: inline-block;*/
            /*margin-right: 2px;*/
        /*}*/
        /*.left{*/
            /*border: 1px solid green;*/
            /*width: 45%;*/
            /*display: inline-block;*/
        /*}*/
        .left_name{
            width: 45%;
            display: inline-block;
            text-align: center;
            /*border:1px solid red;*/
            /*margin: 10px 10px 20px ;*/
        }
        .right_name{
            /*border: 1px solid red;*/
            text-align: center;
            width: 45%;
            display: inline-block;
            /*margin-right: 2px;*/
            position: relative;
        }
        .right_name_value{
            width: 90%;
            /*border:1px solid black;*/
            text-align: center;
            margin: 20px 10px 10px;
            position: relative;
            float: left;
        }
        .fenge{
            border: 1px solid #CCCCCC;
        }
        .btnn{
            display: inline-block;
            float: right;
            margin-left: 200px;
        }
        .zongbtn{
            margin-top: 30px;
            position: absolute;
            right: 90px;
            bottom: 2px;
        }
    </style>
</head>
<body>


<header class="top-header">
    <div class="container">
        <div class="row">
            <div class="col-xs-5 header-logo">
                <br>
                <a href="#">
                    <img src="{{url('r_frontend/img/logo.png')}}" title="天眼互联" class="img-responsive logo">

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
    </div>

</header>
<div class="col-md-6 col-md-offset-3 list_box">
    <h3>根据您的需求系统推荐的方案</h3>
    <div class="table_box">
        <div class="title">
            <div class="left name">方案名称</div>
            <div class="right name">产品名称</div>
        </div>
        <div class="fenge"></div>

    @foreach($data as $v)
        <div class="tabld_body">
            <div class="left_name value">{{$v->demand_name}}</div>
            <div class="right_name value">
                @foreach($v->product_list as $vv)
                <div class="right_name_value">{{$vv->product_name}}<a class="btn btn-primary btnn" href="{{url('productinfo?product_id='.$vv->product_id)}}" role="button">单个购买</a></div>

                @endforeach
            </div>

            <a class="btn btn-warning zongbtn" href="#" role="button">购买该方案</a>

        </div>
            <div class="fenge"></div>

        @endforeach
    </div>

</div>
