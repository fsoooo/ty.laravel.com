<head>
    <meta charset="UTF-8"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" type="text/css" href="/r_backend/css/bootstrap/bootstrap.min.css"/>
    <title>天眼互联-科技让保险无限可能</title>
    <link rel="shortcut icon" href="favicon.ico" />
    <script src="/r_backend/js/demo-rtl.js"></script>

    <link rel="stylesheet" type="text/css" href="/r_backend/css/libs/font-awesome.css"/>
    <link rel="stylesheet" type="text/css" href="/r_backend/css/libs/nanoscroller.css"/>

    <link rel="stylesheet" type="text/css" href="/r_backend/css/compiled/theme_styles.css"/>

    <link rel="stylesheet" href="/r_backend/css/libs/fullcalendar.css" type="text/css"/>

    <link rel="stylesheet" href="/r_backend/css/compiled/calendar.css" type="text/css" media="screen"/>
    <link rel="stylesheet" href="/r_backend/css/libs/morris.css" type="text/css"/>
    <link rel="stylesheet" href="/r_backend/css/libs/daterangepicker.css" type="text/css"/>
    <link rel="stylesheet" href="/r_backend/css/libs/iconfont.css" type="text/css"/>
    <meta name="csrf-token" content="{{csrf_token()}}">
    <!--[if lt IE 9]>
    <script src="/r_backend/js/html5shiv.js"></script>
    <script src="/r_backend/js/respond.min.js"></script>
    <![endif]-->
    <script type="text/javascript">
        /* <![CDATA[ */
        var _gaq = _gaq || [];
        _gaq.push(['_setAccount', 'UA-49262924-2']);
        _gaq.push(['_trackPageview']);

        (function(b){(function(a){"__CF"in b&&"DJS"in b.__CF?b.__CF.DJS.push(a):"addEventListener"in b?b.addEventListener("load",a,!1):b.attachEvent("onload",a)})(function(){"FB"in b&&"Event"in FB&&"subscribe"in FB.Event&&(FB.Event.subscribe("edge.create",function(a){_gaq.push(["_trackSocial","facebook","like",a])}),FB.Event.subscribe("edge.remove",function(a){_gaq.push(["_trackSocial","facebook","unlike",a])}),FB.Event.subscribe("message.send",function(a){_gaq.push(["_trackSocial","facebook","send",a])}));"twttr"in b&&"events"in twttr&&"bind"in twttr.events&&twttr.events.bind("tweet",function(a){if(a){var b;if(a.target&&a.target.nodeName=="IFRAME")a:{if(a=a.target.src){a=a.split("#")[0].match(/[^?=&]+=([^&]*)?/g);b=0;for(var c;c=a[b];++b)if(c.indexOf("url")===0){b=unescape(c.split("=")[1]);break a}}b=void 0}_gaq.push(["_trackSocial","twitter","tweet",b])}})})})(window);
        /* ]]> */
    </script>
    @yield('css')
    <link href="/r_backend/editor/themes/default/css/umeditor.css" type="text/css" rel="stylesheet">
    <script type="text/javascript" src="/r_backend/editor/third-party/jquery.min.js"></script>
    <script type="text/javascript" src="/r_backend/editor/third-party/template.min.js"></script>
    <script type="text/javascript" charset="utf-8" src="/r_backend/editor/umeditor.config.js"></script>
    <script type="text/javascript" charset="utf-8" src="/r_backend/editor/umeditor.min.js"></script>
    <script type="text/javascript" src="/r_backend/editor/lang/zh-cn/zh-cn.js"></script>
    <script type="text/javascript" src="/r_backend/js/echarts.js"></script>
    <script type="text/javascript" src="/r_backend/js/echarts.js"></script>
    <script src="{{config('view_url.view_url').'js/common.js'}}"></script>
    <style>
        /*弹出提示框*/
        .mask{position: fixed;top: 0;left: 0;bottom: 0;right: 0;z-index: 1000;}
        .mask-bg {position: absolute;top: 0;left: 0;bottom: 0;right: 0;background: #000;filter:Alpha(opacity=50);background: rgba(0, 0, 0, .5);z-index: 999;}
        .mask-container {min-width: 300px;position: absolute;left: 50%;top: 50%;padding: 20px 50px;text-align: center;background: #fff;z-index: 1000;}
        .mask-btn-box {margin-right: -5%;}
        .mask-btn {width: 80px;height: 30px;margin-right: 5%;border: none;outline: none;}
        .mask-loding .mask-container{background: transparent;}
        .mask-loding .text{font-size: 18px;color: #fff;}
        .mask .img-wrapper{width: 350px;height: 350px;}

    </style>
</head>
