<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <title>天眼业管后台</title>
    
    <link rel="stylesheet" type="text/css" href="{{asset('r_backend/css/bootstrap/bootstrap.min.css')}}"/>

    <script src="{{asset('r_backend/js/demo-rtl.js')}}"></script>


    <link rel="stylesheet" type="text/css" href="{{asset('r_backend/css/libs/font-awesome.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('r_backend/css/libs/nanoscroller.css')}}"/>

    <link rel="stylesheet" type="text/css" href="{{asset('r_backend/css/compiled/theme_styles.css')}}"/>
    <link rel="stylesheet"  type="text/css" href="{{config('view_url.view_url').'login/css/frontend/common.css'}}"/>
    <link rel="stylesheet" type="text/css"  href="{{config('view_url.view_url').'login/org/un_lock/css/normalize.css'}}"/>
    <link rel="stylesheet" type="text/css"  href="{{config('view_url.view_url').'login/org/un_lock/assets/less/unlock.css'}}"/>
    <style>
        #login-page{
              background: url("http://eins.inschos.com/public/admin/login/login_bg.gif") ;
        }
    </style>
    <!--[if lt IE 9]>
    <script src="{{asset('r_backend/js/html5shiv.js')}}"></script>
    <script src="{{asset('r_backend/js/respond.min.js')}}"></script>
    <![endif]-->
    <script type="text/javascript">
        /* <![CDATA[ */
        var _gaq = _gaq || [];
        _gaq.push(['_setAccount', 'UA-49262924-2']);
        _gaq.push(['_trackPageview']);

        (function(b){(function(a){"__CF"in b&&"DJS"in b.__CF?b.__CF.DJS.push(a):"addEventListener"in b?b.addEventListener("load",a,!1):b.attachEvent("onload",a)})(function(){"FB"in b&&"Event"in FB&&"subscribe"in FB.Event&&(FB.Event.subscribe("edge.create",function(a){_gaq.push(["_trackSocial","facebook","like",a])}),FB.Event.subscribe("edge.remove",function(a){_gaq.push(["_trackSocial","facebook","unlike",a])}),FB.Event.subscribe("message.send",function(a){_gaq.push(["_trackSocial","facebook","send",a])}));"twttr"in b&&"events"in twttr&&"bind"in twttr.events&&twttr.events.bind("tweet",function(a){if(a){var b;if(a.target&&a.target.nodeName=="IFRAME")a:{if(a=a.target.src){a=a.split("#")[0].match(/[^?=&]+=([^&]*)?/g);b=0;for(var c;c=a[b];++b)if(c.indexOf("url")===0){b=unescape(c.split("=")[1]);break a}}b=void 0}_gaq.push(["_trackSocial","twitter","tweet",b])}})})})(window);
        /* ]]> */
    </script>

</head>
<body id="login-page">
<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <div id="login-box">
                <div id="login-box-holder">
                    <div class="row">
                        <div class="col-xs-12">
                            <header id="login-header">
                                <div id="login-logo">
                                    <img src="{{asset('r_backend/img/logo.png')}}" alt=""/>
                                </div>
                            </header>
                            <div id="login-box-inner">
                                <form role="form" action="{{url('backend/do_login')}}" method="post">
                                    {{ csrf_field() }}
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                        <input class="form-control" type="text" placeholder="Email address" name="email">
                                    </div>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-key"></i></span>
                                        <input type="password" class="form-control" placeholder="Password" name="password">
                                    </div>
                                    <div class="row">
                                        @if (count($errors) > 0)
                                            <div class="alert alert-danger">
                                                <ul>
                                                    @foreach ($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="pattern" type="0" style="position: relative;">
                                        <div class="slide-to-unlock-bg" style="width: 300px; height: 38px; background-color: #00a2ff;">
                                            <span style="line-height: 38px; font-size: 12px; color: rgb(51, 51, 51);">请按住滑块，拖动至最右边</span>
                                        </div>
                                        <div class="slide-to-unlock-progress" style="background-color: #00a2ff; height: 38px;">
                                        </div>
                                        <div class="slide-to-unlock-handle" style=" background-color: #00a2ff; height: 38px; line-height: 40px; width: 46px;">
                                            <img class="icon-arrow" src="{{config('view_url.view_url').'login/image/arrow.png'}}" alt="" >
                                            <img class="icon-success" src="{{config('view_url.view_url').'login/image/success.png'}}" alt="" hidden>
                                        </div>
                                    </div>
                                    <br>
                                    <br>
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <button type="submit" class="btn btn-success col-xs-12" style="background: rgb(0, 162, 255)">Login</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                {{--<div id="login-box-footer">--}}
                    {{--<div class="row">--}}
                        {{--<div class="col-xs-12">--}}
                            {{--Do not have an account?--}}
                            {{--<a href="registration.html">--}}
                                {{--Register now--}}
                            {{--</a>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
            </div>
        </div>
    </div>
</div>

<script src="{{asset('r_backend/js/demo-skin-changer.js')}}"></script>
<script src="{{asset('r_backend/js/jquery.js')}}"></script>
<script src="{{asset('r_backend/js/bootstrap.js')}}"></script>
<script src="{{asset('r_backend/js/jquery.nanoscroller.min.js')}}"></script>
<script src="{{asset('r_backend/js/demo.js')}}"></script>


<script src="{{asset('r_backend/js/scripts.js')}}"></script>

<script src="{{config('view_url.view_url').'login/js/frontend/login/login.js'}}"></script>
<script src="{{config('view_url.view_url').'login/org/un_lock/assets/js/unlock.js'}}"></script>
<script src="{{config('view_url.view_url').'js/common.js'}}"></script>
</body>
</html>