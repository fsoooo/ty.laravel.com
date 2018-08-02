<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>天眼互联-科技让保险无限可能</title>
    <!--公共CSS-->
    <link rel="stylesheet" href="{{config('view_url.agent_url')}}css/lib/iconfont.css" />
    <link rel="stylesheet" href="{{config('view_url.agent_url')}}css/common_agent.css" />
    <link rel="stylesheet" href="{{config('view_url.agent_url')}}css/lib/swiper-3.4.2.min.css" />
    <link rel="stylesheet" href="{{config('view_url.agent_url')}}css/produced_details.css" />
    <script src="{{config('view_url.agent_url')}}js/lib/jquery-1.11.3.min.js"></script>
    <script src="{{config('view_url.agent_url')}}js/common_agent.js"></script>
</head>
<body>
<div class="header-wrapper">
    <div class="header">
        <div class="header-left">
            <div class="logo">
                <img src="{{config('view_url.agent_url')}}img/logo.png"/>
            </div>
            <p class="welcome"><i class="iconfont icon-chenggong"></i>您好，@if(isset($_COOKIE['agent_name'])){{$_COOKIE['agent_name']}}@else -- @endif</p>
            @if($authentication == 0)
                    <!--未认证start-->
            <div class="exit-wrapper">
                <div class="exit-top">
                    <div class="avatar">
                        <img src="{{config('view_url.agent_url')}}img/boy.png" alt="" />
                    </div>
                    <div class="info">
                        <p class="status">未认证</p>
                        <a href="/agent/account">实名认证后才可以进行相关操作及查看相关信息，马上去实名<i class="iconfont icon-gengduo"></i></a>
                    </div>
                </div>
                <div class="exit-bottom">
                    <a href="/agent/account">我的账户</a>&nbsp;|&nbsp;<span id="btn-exit"><a href="/agent/quit">退出</a></span>
                </div>
            </div>
            <!--未认证end-->
            @else
                    <!--已认证start-->
            <div class="exit-wrapper">
                <div class="exit-top">
                    <div class="avatar">
                        <img src="{{config('view_url.agent_url')}}img/boy.png" alt="" />
                    </div>
                    <div class="info">
                        <p class="status has">已认证</p>
                        <a href="performance.html">本月任务<i class="red">10万</i>元，已完成<i class="black">8万</i>元，本月剩余14天，查看业绩<i class="iconfont icon-gengduo"></i></a>
                    </div>
                </div>
                <div class="exit-bottom">
                    <a href="/agent/account">我的账户</a>&nbsp;|&nbsp;<span id="btn-exit"><a href="/agent/quit">退出</a></span>
                </div>
            </div>
            <!--已认证end-->
            @endif
        </div>
        <div class="header-right">
            <ul class="nav-wrapper">
                <li class="active"><a href="/agent">首页</a></li>
                {{--<li>活动列表</li>--}}
                <li><a href="/agent/account">账户设置</a></li>
            </ul>
        </div>
    </div>
</div>
<div class="main-wrapper clearfix">
    <ul class="menu-wrapper fl">
        <li @if($option == 'plan') class="active"@endif><a href="/agent_sale/add_plan">我的计划书</a></li>
        <li><a href="/agent_sale/agent_cust/unpayed">我的客户</a></li>
        <li><a href="/agent_sale/agent_product">我的产品</a></li>
        <li><a href="/agent_sale/agent_commission">我的业绩</a></li>
    </ul>
    <div class="content-wrapper fr">
        <!--主体内容-->
        <div>

            <ul class="crumbs" style="margin: 40px;">
                <li><a href="/agent_sale/add_plan">我的计划书</a><i class="iconfont icon-gengduo"></i></li>
                <li><a href="/agent_sale/plan_lists">已制作计划书</a><i class="iconfont icon-gengduo"></i></li>
                <li>计划书名称</li>
            </ul>
        </div>
        <div class="content">
            <div class="merchant"><img src="{{config('view_url.agent_url')}}img/merchant.png"/></div>
            <h1 class="name">计划书名称</h1>

            <div class="table-wrapper">
                <div class="table-header"><i class="iconfont icon-shouye1"></i>基本信息</div>
                <table>
                    <tr><td>产品名称：{{$detail->product_name}}</td><td></td></tr>
                    <tr><td>被投保人：{{$detail->name}}</td><td>保险金额：{{$detail->premium/100}}元/份</td></tr>
                    <tr><td>被保人性别：@if(isset($detail->code)) @if(substr($detail->code,16,1)%2 == 1)男@else 女@endif @else -- @endif</td><td>缴费期间：1年</td></tr>
                    <tr>
                        <td>被保人年龄：@if(isset($detail->code)){{date('Y',time()) - substr($detail->code,6,4)}}岁@else -- @endif
                        </td>
                        <td>缴费方式：年交</td></tr>
                    <tr><td>保障期限：一年</td><td>首年支付保险费：5000元</td></tr>
                </table>
            </div>
            <div class="table-wrapper">
                <div class="table-header"><i class="iconfont icon-shouye"></i>保障权益</div>
                @if(isset($detail->protect_items))
                @foreach($detail->protect_items as $k=>$v)
                    <table class="rights">
                        <tr>
                            <td>{{$v['name']}}</td>
                            <td>{{$v['defaultValue']}}</td>
                            <td>{{$v['description']}}</td>
                        </tr>
                    </table>
                @endforeach
                    @endif
            </div>
            <div class="table-wrapper">
                <div class="table-header"><i class="iconfont icon-shouye2"></i>险种</div>
                <table class="variety" cellspacing='4'>
                    @foreach($product->json['clauses'] as $k=>$v)
                        <tr>
                            @if($k == 0)
                                <td><i class="zicon-main"></i>{{$v['name']}}</td>
                            @else
                                <td><i class="zicon-minor"></i>{{$v['name']}}</td>
                            @endif
                        </tr>
                    @endforeach
                </table>

            </div>
            <ul class="selling">
                @if(!is_null($detail->selling))
                    @foreach(json_decode($detail->selling,true) as $k=>$v)
                        <li class="table-wrapper"><span>卖点{{$k+1}}：</span>{{$v}}</li>
                    @endforeach
                @endif
            </ul>
        </div>
    </div>
</div>
<div class="information-wrapper">
    <div class="information">
        <div class="user-img"><img src="{{config('view_url.agent_url')}}img/girl.png" alt="" /></div>
        <p><span class="user-name">{{$agent_detail->name}}</span>vip服务专员<span class="user-grade">评分<i class="red">5.0</i></span></p>
        <p class="tel">联系电话：<i class="color-positive">{{$agent_detail->phone}}</i></p>
        <div class="evaluate"><span>专业</span><span>耐心</span><span>按需定制</span></div>
        <div class="user-operate">
            <button id="sendToCustomer" class="z-btn z-btn-positive">发给客户</button>
            <a href="/agent_sale/add_plan" class="z-btn-hollow">修改计划书</a>
        </div>
    </div>
</div>
<div class="popups-wrapper popups-way">
    <div class="popups">
        <div class="popups-title">选择发送方式<i class="iconfont icon-close"></i></div>
        <div class="popups-content">
            <ul class="clearfix">
                <li>
                    <p class="way-item">1.邮箱发送</p>
                    <i class="iconfont icon-youxiang"></i>
                </li>
                <li>
                    <p class="way-item">2.qq发送</p>、
                    <a href="javascript:;"  id="qq_id" target="_blank"><i class="iconfont icon-qq"></i></a>
                </li>
                <li>
                    <p class="way-item">3.扫描二维码发送</p>
                    <img src="{{config('view_url.agent_url')}}img/code.png"/>
                </li>
            </ul>
            <form action="" id="email_form">
                {{ csrf_field() }}
                <div class="way-email">
                    <input id="email" type="email" name="email" placeholder="请填写客户邮箱地址"/>
                    <input type="hidden" name="url" value="{{url('/cust_plan/'.$plan_lists_id)}}">
                    <a href="javascript:;" id="sendEmail" class="z-btn z-btn-positive" disabled>发送</a>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="popups-wrapper popups-success">
    <div class="popups">
        <div class="popups-title">发送计划书<i class="iconfont icon-close"></i></div>
        <div class="popups-content">
            <i class="iconfont icon-chenggong"></i>
            <p>发送成功</p>
            <div>
                <a href="/agent_sale/add_plan" class="z-btn z-btn-positive">继续制作计划书</a>
                <a href="/agent_sale/plan_lists" class="z-btn-hollow">查看已制作计划书</a>
            </div>
        </div>
    </div>
</div>
<input type="hidden" name="plan_id" value="{{$plan_lists_id}}">

</body>
</html>



    <script>
        $('#sendToCustomer').click(function(){
            Popups.open('.popups-way',function(){
                $('#email').val('').parent().hide();
            });
            $('#sendEmail').click(function(){
                var data = $("input[name=email]").val();
                var _token = $("input[name=_token]").val();
                var url = $("input[name=url]").val();
                var id = $("input[name='plan_id']").val();
                $.ajax({
                    url:'/agent_sale/send_url',
                    data:{'data':data,'_token':_token,'url':url,'id':id},
                    type:'post',
                    success:function(res){
                        if (res['status']==200){
                            Popups.open('.popups-success');
                            Popups.close('.popups-way');

                        }else{
                            alert('发送失败，请稍后再试');
                        }

                    }
                })
            });
        });
        $('.icon-youxiang').click(function(){
            $('.way-email').show();
        });
        $('input').bind('input propertychange', function() {
            if(emailReg.test($('#email').val())){
                $('#sendEmail').prop('disabled',false);
            }else{
                $('#sendEmail').prop('disabled',true);
            }
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
