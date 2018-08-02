<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>天眼互联-科技让保险无限可能</title>
    <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
    <link rel="stylesheet" href="{{config('view_url.view_url')}}mobile/personal/css/lib/mui.min.css">
    <link rel="stylesheet" href="{{config('view_url.view_url')}}mobile/personal/css/lib/iconfont.css" />
    <link rel="stylesheet" href="{{config('view_url.view_url')}}mobile/personal/css/common.css" />
    <style>
        .division{height: .5rem;line-height: .5rem;padding-left: .4rem;}
        .mui-scroll-wrapper {top: .9rem;bottom: 0;background: #f4f4f4;}
        .mui-bar-nav {background: #025a8d;}
        .applicant-wrapper {background: #fff;}
        .applicant-partone{padding: 0 .3rem;}
        .applicant-partone li {height: 1rem;line-height: 1rem;position: relative;border-bottom: 1px solid #dcdcdc;}
        .applicant-partone li:last-child{border-bottom: none;}
        .user-wrapper{padding: 0 .3rem;height: 1.6rem;line-height: 1.6rem;}
        .user-header-img{margin-top: .18rem;width: .62rem;height: .62rem;border-radius: 50%;display: inline-block;margin-right: .2rem;}
        .user-wrapper li{position: relative;}
        .user-name{display: inline-block;vertical-align: top;}
        .mui-icon.mui-icon-plusempty{font-size: .6rem;color: #fff;}
    </style>
</head>

<body>
<div class="main">
    <header class="mui-bar mui-bar-nav">
        <a class="mui-icon mui-icon-back mui-pull-left mui-action-back"></a>
        <h1 class="mui-title">联系人</h1>
        <a href="/mpersonal/addperson" class="mui-icon mui-icon-plusempty mui-pull-right"></a>
    </header>
    <div class="mui-content">
        <div class="mui-scroll-wrapper">
            <div class="mui-scroll">
                <div>
                    <div class="applicant-wrapper">
                        <ul class="applicant-partone">
                            @if($count == 0)
                                <li>
                                    没有添加过联系人
                                </li>
                            @else
                                @foreach($data as $k=>$v)
                                <li>
                                    <div class="user-header-img">
                                        <img src="{{config('view_url.view_url')}}mobile/personal/image/girl.png"/>
                                    </div>
                                    <div class="user-name">{{$v['name']}}</div>
                                </li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{config('view_url.view_url')}}mobile/personal/js/lib/jquery-1.11.3.min.js"></script>
<script src="{{config('view_url.view_url')}}mobile/personal/js/lib/mui.min.js"></script>
<script src="{{config('view_url.view_url')}}mobile/personal/js/common.js"></script>
</body>

</html>