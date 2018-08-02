<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>天眼互联-科技让保险无限可能</title>
    <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
    <link rel="stylesheet" href="{{config('view_url.view_url')}}mobile/company/css/lib/mui.min.css">
    <link rel="stylesheet" href="{{config('view_url.view_url')}}mobile/company/css/lib/mui.picker.all.css">
    <link rel="stylesheet" href="{{config('view_url.view_url')}}mobile/company/css/lib/iconfont.css" />
    <link rel="stylesheet" href="{{config('view_url.view_url')}}mobile/company/css/common.css" />
    <style>
        body {background: #fff;}
        .mui-scroll-wrapper {top: .8rem;bottom: .8rem;background: #f4f4f4;}
        .mui-bar-nav {background: #025a8d;}
        .mui-icon-back,.mui-title {color: rgba(255, 255, 255, .8);}
        .applicant-wrapper {background: #fff;margin-bottom: .8rem;}
        .applicant-wrapper ul {padding: 0 .3rem;}
        .applicant-wrapper li {height: 1rem;line-height: 1rem;position: relative;border-bottom: 1px solid #dcdcdc;}
        .applicant-wrapper li .iconfont {position: absolute;top: 0;right: 0;z-index: 1;font-size: .36rem;color: #00a2ff;}
        .applicant-partone li:last-child {border-bottom: none;}
        .applicant-wrapper li input {padding-left: 1.85rem;font-size: .28rem;border: none;overflow: hidden;text-overflow:ellipsis;white-space: nowrap;}
        .name {position: absolute;top: 0;left: 0;width: 1.6rem;z-index: 100; font-size: .28rem;color: #313131;}
        .applicant-wrapper li.mui-table-view-cell {border-bottom: none;}
        .mui-table-view-cell:after {background: none;}
        .buttonbox button[disabled]{background-color: #dddddd;}
        .applicant-wrapper li.title{font-size: 0.3rem;font-weight: bold;margin-bottom: -.3rem;border-bottom: none;}
    </style>
</head>

<body>
<div class="main">
    <header class="mui-bar mui-bar-nav">
        <a class="mui-icon mui-icon-back mui-pull-left mui-action-back"></a>
        <h1 class="mui-title">账户管理</h1>
    </header>
    <div class="mui-content">
        <div class="mui-scroll-wrapper">
            <div class="mui-scroll">
                <div class="applicant-wrapper">
                    <ul class="applicant-partone">
                        <li class="approve">
                            <a href="/cpersonal/approve_company"><span class="name">企业认证</span><i class="iconfont icon-gengduo"></i></a>
                        </li>
                        <li>
                            <a href="/mpersonal/chang_psw"><span class="name">密码修改</span><i class="iconfont icon-gengduo"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{config('view_url.view_url')}}mobile/company/js/lib/jquery-1.11.3.min.js"></script>
<script src="{{config('view_url.view_url')}}mobile/company/js/lib/mui.min.js"></script>
<script src="{{config('view_url.view_url')}}mobile/company/js/lib/mui.picker.all.js"></script>
<script src="{{config('view_url.view_url')}}mobile/company/js/common.js"></script>
<script>
    $(".mui-action-back").click(function(){
        history.back();
    })
</script>
</body>

</html>