@extends('frontend.guests.guests_layout.base')
<link rel="stylesheet/less" href="{{config('view_url.view_url')}}css/success.less"/>
<script src="{{config('view_url.view_url').'js/lib/less.min.js'}}"></script>
@section('content')
<div class="wrapper">
    <div class="main">
        <div class="main-top">
            <i class="iconfont icon-zhifuchenggong"></i>支付成功
        </div>
        <div class="main-bottom">
            <div>
                <button class="btn btn-return" onclick="window.location='/'" >返回保险超市</button>
                <button class="btn btn-f18164"  onclick="window.location='/information'">查看保单详情</button>
            </div>
            {{--<ul class="clearfix">--}}
                {{--<li class="success-price">--}}
                    {{--<p class="success-price-text">您已成功支付<span class="f18164">27.00</span>元</p>--}}
                    {{--<p>您的保单将在30分钟内发送至您的邮箱</p>--}}
                {{--</li>--}}
                {{--<li class="success-share">--}}
                    {{--<button class="btn btn-f18164">立即分享</button>--}}
                    {{--<p>把我们的保险网站分享给更多人</p>--}}
                {{--</li>--}}
                {{--<li class="success-code">--}}
                    {{--<div class="success-code-img">--}}
                        {{--<img src="{{config('view_url.view_url')}}image/微信图片_20170803113628.png" />--}}
                    {{--</div>--}}
                    {{--<p>扫描二维码，实时掌握投保进度</p>--}}
                {{--</li>--}}
            {{--</ul>--}}
        </div>
    </div>
</div>
<div class="popup popup-success">
    <div class="popup-bg"></div>
    <div class="popup-wrapper">
        <i class="iconfont icon-close"></i>
        <div class="bold">恭喜您,支付成功！ </div>
        <div class="popup-content">
            {{--支付成功！--}}
        </div>
        <div class="popup-footer">
            <button class="btn-small btn-confirm">确定</button>
        </div>
    </div>
</div>
<div class="popup popup-share">
    <div class="popup-bg"></div>
    <div class="popup-wrapper">
        <i class="iconfont icon-close"></i>
        <div class="popup-title"><span>分享</span></div>
        <div class="popup-content">
            <!-- JiaThis Button BEGIN -->
            <div class="jiathis_style">
                <i class="iconfont icon-QQ"></i><a class="jiathis_button_qzone">分享到QQ</a>
                <i class="iconfont icon-weixin"></i><a class="jiathis_button_weixin">分享到微信</a>
                <i class="iconfont icon-weibo"></i><a class="jiathis_button_tsina">分享到微博</a>
            </div>
            <script type="text/javascript">

            </script>
            <script type="text/javascript" src="http://v3.jiathis.com/code/jia.js?uid=2141334" charset="utf-8"></script>
            <!-- JiaThis Button END -->
        </div>
    </div>
</div>
<script src="{{config('view_url.view_url')}}js/success.js"></script>
@stop