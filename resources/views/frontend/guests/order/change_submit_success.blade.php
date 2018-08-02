@extends('frontend.guests.frontend_layout.policy_base')
<link rel="stylesheet" href="{{ url(config('resource.position.css').'/frontend/product/pay-success.css') }}">
@section('content')
        <div class="settlement-block">
            <div class="settlement-detail" >
                <div class="settlement-product-logo">
                    <img class="images" src="/view_1/image/yes.jpg">
                </div>
                <div class="settlement-product-name">
                    <div class="settlement-product-name-money">
                        您的保单信息变更成功!您新生成的投保单号是<span>{{$new_code}}</span>
                    </div>
                    <p style="color: gray;font-size: 12px">变更信息是将原单退保，再重新生成一张新的支付订单！</p>
                    <div class="settlement-product-name-time">您的保单将在30分钟内发到您的邮箱，请注意查收！！</div>
                    <div class="settlement-product-name-info"><a href="/order/detail/{{$new_code}}">查看详情</a></div>
                </div>
                <div class="settlement-product-money" style="color: #ffa700">
                    <div class="two-bar-codes">
                        <img  class="erweima" src="/view_1/image/erweima.png">
                    </div>
                    <span class="two-bar-codes-notice">扫描二维码，实时掌握投保进度</span>
                </div>
                <div class="ClearFix"></div>
            </div><br/>
            <div class="settlement-way">
                <span class="settlement-way-name">觉得我们xxx保险网还不错,想让更多人知道？</span>
            </div>

            <div class="settlement-card">
                <div class="choose-card-type">
                    <div class="share">分享到：</div>
                    <script>window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"","bdMini":"5","bdPic":"","bdStyle":"0","bdSize":"20"},"share":{},"image":{"viewList":["qzone","tsina","weixin"],"viewText":"分享到：","viewSize":"20"},"selectShare":{"bdContainerClass":null,"bdSelectMiniList":["qzone","tsina","weixin"]}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];</script>
                    <!-- JiaThis Button BEGIN -->
                    <div class="jiathis_style_24x24">
                        <a class="jiathis_button_qzone"></a>
                        <a class="jiathis_button_tsina"></a>
                        <a class="jiathis_button_weixin"></a>
                    </div>
                    <script type="text/javascript" src="http://v3.jiathis.com/code/jia.js" charset="utf-8"></script>
                    <!-- JiaThis Button END -->
                    {{--<!-- JiaThis Button BEGIN -->--}}
                    {{--<div class="jiathis_style_24x24">--}}
                        {{--<a class="jiathis_button_qzone"></a>--}}
                        {{--<a class="jiathis_button_tsina"></a>--}}
                        {{--<a class="jiathis_button_weixin"></a>--}}
                        {{--<a class="jiathis_button_cqq"></a>--}}
                        {{--<a href="http://www.jiathis.com/share" class="jiathis jiathis_txt jtico jtico_jiathis" target="_blank"></a>--}}
                        {{--<a class="jiathis_counter_style"></a>--}}
                    {{--</div>--}}
                    {{--<script type="text/javascript" src="http://v3.jiathis.com/code/jia.js" charset="utf-8"></script>--}}
                    <!-- JiaThis Button END -->
                        {{--<div class="microblog">--}}
                            {{--<img class="shareimg" src="/view_1/image/wewechat.png">--}}
                            {{--微博--}}
                            {{--<hr style="width:60px;height:2px;border:none;border-top:2px solid #00A2FF;" />--}}
                        {{--</div>--}}
                        {{--<div class="wechat">--}}
                            {{--<img class="shareimg" src="/view_1/image/wwechat.png">--}}
                            {{--微信--}}
                            {{--<hr style="width: 80px;height:2px;border:none;border-top:2px solid #185598;" />--}}
                        {{--</div>--}}

                </div>
                <div class="choose-card-type2">
                    <span>“没有读过万卷书，行万里路终究也只不过是一个邮差。”

                    最近发一些文章的时候，经常可以收到这样的评论。

                    我不太明白的是：你见过那个可以一直在外面“流浪”的人是不识字的吗？我也用这样的句子回复了好几个人。

                    有时候，我甚至怀疑那些说着这样话的人，是不是在羡慕别人的生活，或者自己做不到却又看不惯别人去做的人呢？

                    生活在这样一个信息社会，即使不去“行万里路”，依然可以视野开阔，甚至超越“行路者”。因此，“环游世界”不应再简单等同于“见多识广”。

                    但我觉得“足不出户”也不应再成为“不行万里路”的借口吧？

                    读万卷书和行万里路并不冲突，就像西红柿炒蛋，放下筷子，用勺子来吃才是正义。

                    </span>
                </div>
                <div class="choose-card-type-buttons">
                    <button class="choose-card-type-button">分享</button>
                </div>
            </div>

    </div>
        <link rel="stylesheet" type="text/css" href="/view_1/alert/css/xcConfirm.css"/>
        <script src="/view_1/alert/js/jquery-1.9.1.js" type="text/javascript" charset="utf-8"></script>
        <script src="/view_1/alert/js/xcConfirm.js" type="text/javascript" charset="utf-8"></script>
        <script>
//            function myfun() {
//                var txt="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;                                                       " +
//                    "恭喜您"+"<br/><br/>"+"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;正式成为某某保险大家庭的一员";
//                var option = {
////                    title: "系统提示",
//                    btn: parseInt("0001",4),
//
//                    onOk: function(){
//                        console.log("确认啦");
//                    }
//                }
//                window.wxc.xcConfirm(txt, "custom", option);
//            }
//            window.onload=myfun;
        </script>
@stop