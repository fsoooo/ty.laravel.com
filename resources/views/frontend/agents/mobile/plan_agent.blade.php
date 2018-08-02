<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>天眼互联-科技让保险无限可能</title>
    <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
    <link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/lib/mui.min.css">
    <link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/lib/mui.picker.all.css">
    <link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/lib/iconfont.css" />
    <link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/common_agent.css" />
    <link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/plan.css" />
</head>
<body>
<div class="main">
    <header id="header" class="mui-bar mui-bar-nav">
        <a class="iconfont icon-fanhui mui-pull-left mui-action-back"></a>
        <h1 class="mui-title">{{$detail->product_name}}计划书</h1>
    </header>
    <div class="mui-scroll-wrapper">
        <div class="mui-scroll">
            <div class="plan-header">
                <div class="plan-img">
                    <img src="{{config('view_url.agent_mob')}}img/banner.png"/>
                </div>
                <div class="company">
                    <img src="{{config('view_url.agent_mob')}}img/merchant.png" alt="" />
                </div>
                <div class="plan-user">
                    <p class="info">{{$detail->name}}&nbsp;@if(isset($detail->code)) @if(substr($detail->code,16,1)%2 == 1)男@else 女@endif @else -- @endif&nbsp;@if(isset($detail->code)){{date('Y',time()) - substr($detail->code,6,4)}}岁@else -- @endif</p>
                    <ul class="details">
                        <li>
                            <span>保险金额</span>
                            <p><i>{{$detail->premium/100}}元</i>/份</p>
                        </li>
                        <li>
                            <span>产品期限</span>
                            <p><i>一年</i></p>
                        </li>
                        <li>
                            <span>缴费期限</span>
                            <p>
                                <i>
                                @if($product->base_stages_way == '0年')
                                    趸
                                @else
                                    {{$product->base_stages_way}}
                                @endif
                                </i>
                                交
                            </p>
                        </li>
                        <li>
                            <span>首年保费</span>
                            <p>
                                <i>
                                    @if(preg_replace('/\D/s','',$product->base_stages_way) == 0)
                                        {{$product->base_price/100}}元
                                        @else
                                        {{$product->base_price/100/preg_replace('/\D/s','', $product->base_stages_way)}}元
                                    @endif
                                </i>
                            </p>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="plan-container">
                <div class="section section-rights">
                    <h4 class="title"><i class="iconfont icon-shouye5"></i>保障权益</h4>
                    <ul class="list">
                        <li>
                            @if(isset($detail->protect_items))
                            @foreach($detail->protect_items as $v)
                            <p><span>{{$v['name']}}</span>{{$v['defaultValue']}}</p>
                                @endforeach
                                @endif
                        </li>
                        <li>查看条款详情<i class="iconfont icon-gengduo"></i></li>
                    </ul>
                </div>
                <div class="section section-variety">
                    <h4 class="title"><i class="iconfont icon-shouye21"></i>险种</h4>
                    <ul class="list">
                        @if(isset($detail->protect_items))
                        @foreach($detail->protect_items as $k=>$v)
                            @if($k == 0)
                                <li>
                                    <i class="zicon-main"></i>{{$v['name']}}
                                </li>
                                    @else
                                <li>
                                    <i class="zicon-minor"></i>{{$v['name']}}
                                </li>
                            @endif
                        @endforeach
                            @endif
                    </ul>
                </div>
                <div class="section section-points">
                    <h4 class="title"><i class="iconfont icon-shouye4"></i>卖点</h4>
                    <ul class="list">
                        @foreach($res as $v)
                        <li>{{$v}}</li>
                            @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="plan-bottom">
        <div class="fr">
            <button id="send" class="zbtn zbtn-positive">发给客户</button>
            <a id="back_edit" href="javascript:;" class="zbtn zbtn-default">修改信息</a>
        </div>
        <div class="user-header">
            <img src="{{config('view_url.agent_mob')}}img/girl.png" alt="" />
        </div>
        <p>{{$agent_detail->name}}<a href="tel:{{$agent_detail->phone}}" class="tel">{{$agent_detail->phone}}</a></p>
    </div>
</div>
{{--<div class="mui-popover popover-send">--}}
    {{--<ul>--}}
        {{--<a href="javascript:;"  id="qq_id" target="_blank"><li class="qq"></li></a>--}}
        {{--<li class="qq"></li>--}}
        {{--<input type="text" hidden id="foo" value="{{$detail->url}}">--}}
        {{--<li class="weixin" data-clipboard-action="copy" data-clipboard-target="#foo"></li>--}}
    {{--</ul>--}}
{{--</div>--}}
<div class="mui-popover popover-send">
    <ul>
        <a href="javascript:;"  id="qq_id" target="_blank"><li class="qq"></li></a><input type="text" hidden value=""/><>
        <li class="weixin" data-clipboard-action="copy" data-clipboard-target="#foo"><input type="text" value="{{url('/cust_plan/'.$plan_lists_id)}}" id="foo"/><>
    </ul>
</div>


<script src="{{config('view_url.agent_mob')}}js/lib/jquery-1.11.3.min.js"></script>
<script src="{{config('view_url.agent_mob')}}js/lib/mui.min.js"></script>
<script src="{{config('view_url.agent_mob')}}js/lib/mui.picker.all.js"></script>
<script src="{{config('view_url.agent_mob')}}js/lib/swiper-3.4.2.min.js"></script>
<script src="{{config('view_url.agent_mob')}}js/common_agent.js"></script>
<script src="{{config('view_url.agent_mob')}}js/clipboard.min.js"></script>
<script>
    $("#back_edit").click(function(){
        window.history.back();
    })
    $('#send').on('tap',function(){
        mui('.popover-send').popover('toggle');
    });

    //复制到粘贴版
    var clipboard = new Clipboard('.weixin');
    clipboard.on('success', function(e) {
        console.log(e);
        alert('计划书地址已经复制，请到微信中进行分享');
        location.href = '/agent';
    });

    clipboard.on('error', function(e) {
        console.log(e);
    });

</script>

{{--分享--}}
<script>window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"","bdMini":"2","bdMiniList":false,"bdPic":"","bdStyle":"0","bdSize":"32"},"share":{},"image":{"viewList":["weixin","tsina","qzone","tqq"],"viewText":"分享到：","viewSize":"16"},"selectShare":{"bdContainerClass":null,"bdSelectMiniList":["weixin","tsina","qzone","tqq"]}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];</script>
<script type="text/javascript" src="http://code.jquery.com/jquery-1.8.0.min.js"></script>
<script>
    var url = "{{url('/cust_plan/'.$plan_lists_id)}}";
    var desc_ = "您的专属保险计划书";
    function tencentWeiBo(){
        var _url = "{{url('/cust_plan/'.$plan_lists_id)}}";
        var _showcount = 0;
        var _summary = "";
        var _title = desc_;
        var _site = "{{url('/cust_plan/'.$plan_lists_id)}}";
        var _width = "600px";
        var _height = "800px";
//            var _pic = "http://www.junlenet.com/uploads/allimg/150510/1-150510104044.jpg";
        var _shareUrl = '{{url('/cust_plan/'.$plan_lists_id)}}';
        _shareUrl += '&title=' + encodeURIComponent(_title||document.title);    //分享的标题
        _shareUrl += '&url=' + encodeURIComponent(_url||location.href);    //分享的链接
        _shareUrl += '&appkey=5bd32d6f1dff4725ba40338b233ff155';    //在腾迅微博平台创建应用获取微博AppKey
        //_shareUrl += '&site=' + encodeURIComponent(_site||'');   //分享来源
        _shareUrl += '&pic=' + encodeURIComponent(_pic||'');    //分享的图片，如果是多张图片，则定义var _pic='图片url1|图片url2|图片url3....'
        window.open(_shareUrl,'width='+_width+',height='+_height+',left='+(screen.width-_width)/2+',top='+(screen.height-_height)/2+',toolbar=no,menubar=no,scrollbars=no,resizable=1,location=no,status=0');
    }
    var top = window.screen.height / 2 - 250;
    var left = window.screen.width / 2 - 300;
    var height = window.screen.height;
    var width =  window.screen.width;
    /*title是标题，rLink链接，summary内容，site分享来源，pic分享图片路径,分享到新浪微博*/
    function qqFriend() {
        var p = {
            url : '{{url('/cust_plan/'.$plan_lists_id)}}', /*获取URL，可加上来自分享到QQ标识，方便统计*/
            desc:'',
            //title : '新玩法，再不来你就out了！', /*分享标题(可选)*/
            title:desc_,
            summary : '', /*分享摘要(可选)*/
//                pics : 'http://www.junlenet.com/uploads/allimg/150510/1-150510104044.jpg', /*分享图片(可选)*/
            flash : '', /*视频地址(可选)*/
            site : '{{url('/cust_plan/'.$plan_lists_id)}}', /*分享来源(可选) 如：QQ分享*/
            style : '201',
            width : 32,
            height : 32
        };
        var s = [];
        for ( var i in p) {
            s.push(i + '=' + encodeURIComponent(p[i] || ''));
        }
        var url = "http://connect.qq.com/widget/shareqq/index.html?"+s.join('&');
        return url;
        //window.location.href = url;
        //document.write(['<a class="qcShareQQDiv" href="http://connect.qq.com/widget/shareqq/index.html?',s.join('&'), '" >分享给QQ好友</a>' ].join(''));
    }
    $(function(){
        var url = qqFriend();
        $("#qq_id").attr("href",url);
    })
</script>
</body>
</html>
