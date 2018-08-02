<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>天眼互联-科技让保险无限可能</title>
    <link rel="shortcut icon" href="favicon.ico" />
    <link rel="stylesheet"  type="text/css" href="{{config('view_url.view_url').'login/css/frontend/common.css'}}"/>
    <link rel="stylesheet" href="{{config('view_url.view_url').'css/common.less'}}" />
    <link rel="stylesheet" type="text/css"  href="{{config('view_url.view_url').'login/css/frontend/login/login.css'}}"/>
    <link rel="stylesheet" type="text/css"  href="{{config('view_url.view_url').'login/org/un_lock/css/normalize.css'}}"/>
    <link rel="stylesheet" type="text/css"  href="{{config('view_url.view_url').'login/org/un_lock/assets/less/unlock.css'}}"/>
    <link rel="stylesheet" href="{{config('view_url.view_url').'css/lib/iconfont.css'}}" />
    <script src="{{config('view_url.view_url').'js/lib/less.min.js'}}"></script>

</head>
<body>
    <div class="wrap">
        <div class="top">
            <div class="logo">
                <a href="{{ url('/') }}"><img src="{{ config('resource.image.logo') }}" alt=""></a>
            </div>
            <div class="login">
                @if(isset($type))
                        @if($type == 'person')
                        <span>个人用户注册</span>
                        @elseif($type == 'company')
                        <span>企业团体注册</span>
                        @elseif($type == 'third')
                        <span>第三方登录/注册</span>
                        @else
                            <span>团体组织注册</span>
                @endif
                @elseif($_SERVER['REQUEST_URI']=='/findpwd'||$_SERVER['REQUEST_URI']=='/dofindpwd'||$_SERVER['REQUEST_URI']=='/doemailfindpwd')
                    <span>找回密码</span>
                @else
                    <span>会员登录</span>
                @endif

            </div>
        </div>
            <!--内容信息-->
            @yield('content')
            <!--内容信息-->
        <div class="footer">
            <div class="footer-bottom">
                <div>
                    <span>保险营业许可：26595456135684</span>
                    <span>备案号：京ICP备45894532号</span>
                    <span>公安网络备案：45689715469871号</span>
                </div>
                <div>Copyright2017-2018</div>
            </div>
        </div>
    </div>
</body>
<script src="{{config('view_url.view_url').'login/js/jquery-3.1.1.min.js'}}"></script>
<script src="{{config('view_url.view_url').'login/js/frontend/login/login.js'}}"></script>
<script src="{{config('view_url.view_url').'login/org/un_lock/assets/js/unlock.js'}}"></script>
<script src="{{config('view_url.view_url').'js/common.js'}}"></script>
</html>
