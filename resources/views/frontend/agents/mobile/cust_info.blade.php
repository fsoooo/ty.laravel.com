<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>信息填写</title>
    <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
    <link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/lib/mui.min.css">
    <link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/lib/mui.picker.all.css">
    <link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/lib/iconfont.css" />
    <link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/common_agent.css" />
    <link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/client.css" />
</head>
<body id="invite">
<div class="main">
    <header id="header" class="mui-bar mui-bar-nav">
        <a class="iconfont icon-fanhui mui-pull-left mui-action-back"></a>
        <h1 class="mui-title">信息填写</h1>
    </header>
    <div class="mui-content">
        <div class="mui-scroll-wrapper">
            <div class="mui-scroll">
                <div class="header">
                    <div class="header-content">
                        <div class="header-img">
                            <img src="{{config('view_url.agent_mob')}}img/boy.png">
                        </div>
                        <p class="lin1">
                            <span class="header-name">{{$res->name}}</span>
                            <span>VIP客服专员</span>
                            <span>评分<i class="color-positive">5.0</i></span>
                        </p>
                        <p class="lin2 color-positive"><i class="iconfont icon-dianhua"></i>{{$res->phone}}</p>
                        <p class="lin3"><span class="tag-item">热情</span><span class="tag-item">专业</span><span class="tag-item">耐心</span></p>
                    </div>
                </div>
                <div class="info-wrapper">
                    <h4 class="title">信息填写</h4>

                    <form id="cust_info_form" action="/agent_sale/cust_info_submit?agent_id={{$_GET['agent_id']}}" method="post">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-wrapper">
                        <ul>
                            <li>
                                <span class="name">姓名</span>
                                <input id="Name" name="name" class="mustFill" type="text" placeholder="请填写真实姓名">
                            </li>
                            <li class="zbtn-dropdown" data-options='[{"value": "0","text": "身份证"}, {"value": "1","text": "台胞证"}]'>
                                <span class="name">证件类型</span>
                                <input type="text" placeholder="请选择" />
                                <input class="mustFill" hidden name="id_type" type="text"/>
                                <i class="iconfont icon-gengduo"></i>
                            </li>
                            <li>
                                <span class="name">证件号码</span>
                                <input id="IdCard" class="mustFill" name="id_code" type="text" placeholder="必填">
                            </li>
                            <li >
                                <span class="name">职业</span>
                                <input type="text" placeholder="请选择" name="occupation" />
                                {{--<input class="mustFill" hidden type="text" />--}}
                                {{--<i class="iconfont icon-gengduo"></i>--}}
                            </li>
                            <li>
                                <span class="name">联系电话</span>
                                <input id="Tel" class="mustFill" type="text" name="phone" maxlength="11" placeholder="必填">
                            </li>
                            <li>
                                <span class="name">电子邮箱</span>
                                <input id="Email" class="mustFill" type="text" name="email" placeholder="必填">
                            </li>
                            <input type="hidden" name="agent_id" value="{{$_GET['agent_id']}}">
                        </ul>
                    </div>
                    <span id="submit" class="zbtn zbtn-positive center" disabled>提交</span>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="button-box">
        <button id="send" class="zbtn zbtn-default">邀请好友</button>
    </div>
</div>
<div class="mui-popover popover-send">
    <ul>
        <a href="javascript:;"  id="qq_id" target="_blank"><li class="qq"></li></a><input type="text" hidden value=""/><>
        <li class="weixin" data-clipboard-action="copy" data-clipboard-target="#foo"><input type="text" value="{{$url}}" id="foo"/><>
    </ul>
</div>
<script src="{{config('view_url.agent_mob')}}js/lib/jquery-1.11.3.min.js"></script>
<script src="{{config('view_url.agent_mob')}}js/lib/mui.min.js"></script>
<script src="{{config('view_url.agent_mob')}}js/lib/mui.picker.all.js"></script>
<script src="{{config('view_url.agent_mob')}}js/common_agent.js"></script>
<script src="{{config('view_url.agent_mob')}}js/clipboard.min.js"></script>
<script>
    $('#send').on('tap',function(){
        mui('.popover-send').popover('toggle');
    });

    //复制到粘贴版
    var clipboard = new Clipboard('.weixin');
    clipboard.on('success', function(e) {
        console.log(e);
        alert('计划书地址已经复制，请到微信中进行分享');
        location.href = '/';
    });

    dataPicker('.zbtn-dropdown',function(){
        check();
    });

    // 实时监听必填项
    $('input').bind('input propertychange', function() {
        check();

    });
    function check(){
        if(!checkMustFill('.mustFill')){
            $('#submit').prop('disabled',true);
        }else{
            $('#submit').prop('disabled',false);
        }
    }

    // 点击提交数据
    $('#submit').on('tap',function(){
        checkReg();

    });

    function checkReg(){
        if(!checkCorrect($('#Name'),nameReg) ||!checkCorrect($('#IdCard'),IdCardReg) || !checkCorrect($('#Tel'),telReg) || !checkCorrect($('#Email'),emailReg)){
            console.log('校验不通过,不提交数据');
        }else{
            console.log('校验通过,提交数据');
            $('#cust_info_form').submit();
        }
    }
</script>
{{--分享--}}
<script>window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"","bdMini":"2","bdMiniList":false,"bdPic":"","bdStyle":"0","bdSize":"32"},"share":{},"image":{"viewList":["weixin","tsina","qzone","tqq"],"viewText":"分享到：","viewSize":"16"},"selectShare":{"bdContainerClass":null,"bdSelectMiniList":["weixin","tsina","qzone","tqq"]}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];</script>
<script>
    var url = "{{$url}}";
    var desc_ = "{{$res->name}}邀请您进入保险致富之路";
    function tencentWeiBo(){
        var _url = "{{$url}}";
        var _showcount = 0;
        var _summary = "";
        var _title = desc_;
        var _site = "{{$url}}";
        var _width = "600px";
        var _height = "800px";
//            var _pic = "http://www.junlenet.com/uploads/allimg/150510/1-150510104044.jpg";
        var _shareUrl = '{{$url}}';
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
            url : '{{$url}}', /*获取URL，可加上来自分享到QQ标识，方便统计*/
            desc:'',
            //title : '新玩法，再不来你就out了！', /*分享标题(可选)*/
            title:desc_,
            summary : '', /*分享摘要(可选)*/
//                pics : 'http://www.junlenet.com/uploads/allimg/150510/1-150510104044.jpg', /*分享图片(可选)*/
            flash : '', /*视频地址(可选)*/
            site : '{{$url}}', /*分享来源(可选) 如：QQ分享*/
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
