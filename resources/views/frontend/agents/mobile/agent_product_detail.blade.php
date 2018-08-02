<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{$data['product_name']}}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
    <link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/lib/mui.min.css">
    <link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/lib/iconfont.css" />
    <link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/common_agent.css" />
    <link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/product.css" />
</head>

<body>
<header id="header" class="mui-bar mui-bar-nav">
    <a class="iconfont icon-fanhui mui-pull-left mui-action-back"></a>
    <h1 class="mui-title">{{$data['product_name']}}</h1>
</header>
<div class="header-wrapper">
    <div class="company">
        <img src="{{env('TY_API_PRODUCT_SERVICE_URL').'/'.$data['json']['company']['logo']}}" alt="">
    </div>
    <div class="datas-wrapper">
        <div class="bg1"></div>
        <div class="bg2"></div>
        <div class="datas">
            <div id="main" style="width: 100%;height:100%;"></div>
        </div>
    </div>
</div>
<div>
    <div class="outer-nav">
        <div id="segmentedControl" class="mui-segmented-control">
            <a class="mui-control-item mui-active" href="#item1">产品详情</a>
            <a class="mui-control-item" href="#item2">产品评价</a>
        </div>
    </div>
    <div class="outer">
        <div id="item1" class="mui-control-content mui-control-details  mui-active">
            <div class="mui-scroll-wrapper">
                <div class="mui-scroll">
                    <div class="info-wrapper">
                        <a href="javascript:;" class="look-rank">查看榜单<i class="iconfont icon-gengduo"></i></a>
                        <div>总销量<span class="red">{{$count_sales}}</span>份</div>
                        <div class="info-rank">在同类产品中排名第<span class="gold">5</span></div>
                    </div>
                    <div class="form-wrapper">
                        <ul>
                            <li>
                                <span class="name">保额</span>
                                <span>{{$data['defaultPrice']['defaultValue']}}</span>
                            </li>
                            <li>
                                <span class="name">佣金比率</span>
                                <span  class="color-positive">{{$data['rate']['earning']}}%</span>
                            </li>
                            <li>
                                <span class="name">佣金金额</span>
                                <span>{{$data['price'] * $data['rate']['earning']/10000}}元</span>
                            </li>
                            <li>
                                <span class="name">支付方式</span>
                                <span>
                                    @if(preg_replace('/\D/s','',$data['base_stages_way']) == 0)
                                        趸交
                                        @else
                                        {{$data['base_stages_way']}}交
                                        @endif
                                </span>
                            </li>
                            <li>
                                <span class="name">首次支付</span>
                                <span>
                                    @if(preg_replace('/\D/s','',$data['base_stages_way']) == 0)
                                        {{$data['base_price']/100}}元
                                    @else
                                        {{$data['base_price']/100/preg_replace('/\D/s','',$data['base_stages_way'])}}元
                                    @endif
                                </span>
                            </li>
                            <li>
                                <span class="name">购买男女比例</span>
                                <span>男200人&nbsp;&nbsp;女1800人</span>
                            </li>
                            <li>
                                <span class="name">销售统计</span>
                                <span>共计销量2000份，排名16</span>
                            </li>

                        </ul>

                        <div class="division"></div>
                        <div class="title">保障权益</div>
                        <ul>
                            @foreach($return_data['option']['protect_items'] as $v)
                            <li class="zbtn-popover">
                                <span>{{$v['name']}}</span>
                                <input type="text" value="{{$v['defaultValue']}}">
                                <input hidden="" type="text">
                                <i class="iconfont icon-gengduo"></i>
                            </li>
                            @endforeach
                        </ul>

                    </div>
                </div>
            </div>
        </div>
        <div id="item2" class="mui-control-content mui-control-evaluate">
            <div class="mui-scroll-wrapper">
                <div class="mui-scroll">
                    <div class="info-wrapper">
                        <a href="javascript:;" class="look-rank">查看榜单<i class="iconfont icon-gengduo"></i></a>
                        <div>满意度<span class="score">4.0</span>分</div>
                        <div class="info-rank">产品评价<span class="total">80条</span>排名第<span class="gold">3</span></div>
                    </div>
                    <div class="label-wrapper">
                        <span class="zbtn-select high">经济实惠</span>
                        <span class="zbtn-select">值得信赖</span>
                        <span class="zbtn-select high">性价比高</span>
                        <span class="zbtn-select">放心</span>
                    </div>
                    <ul class="evaluate-list">
                        <li>
                            <div class="evaluate-user">
                                <div class="avator">
                                    <img src="{{config('view_url.agent_mob')}}img/girl.png" alt="">
                                </div>
                                <div>张女士</div>
                            </div>
                            <div class="evaluate-info">
                                <span class="date">2017-10-12</span>
                                <div class="rank">
                                    <span>满意度</span>
                                    <i class="iconfont icon-manyi"></i>
                                    <i class="iconfont icon-manyi"></i>
                                    <i class="iconfont icon-manyi"></i>
                                    <i class="iconfont icon-manyi"></i>
                                    <i class="iconfont icon-icon-manyidu"></i>
                                    <span class="score">2.0分</span>
                                </div>
                                <div class="text">价钱适中，买个安心</div>
                            </div>
                        </li>
                        <li>
                            <div class="evaluate-user">
                                <div class="avator">
                                    <img src="{{config('view_url.agent_mob')}}img/girl.png" alt="">
                                </div>
                                <div>张女士</div>
                            </div>
                            <div class="evaluate-info">
                                <span class="date">2017-10-12</span>
                                <div class="rank">
                                    <span>满意度</span>
                                    <i class="iconfont icon-manyi"></i>
                                    <i class="iconfont icon-manyi"></i>
                                    <i class="iconfont icon-manyi"></i>
                                    <i class="iconfont icon-manyi"></i>
                                    <i class="iconfont icon-icon-manyidu"></i>
                                    <span class="score">2.0分</span>
                                </div>
                                <div class="text">价钱适中，买个安心</div>
                            </div>
                        </li>
                        <li>
                            <div class="evaluate-user">
                                <div class="avator">
                                    <img src="{{config('view_url.agent_mob')}}img/girl.png" alt="">
                                </div>
                                <div>张女士</div>
                            </div>
                            <div class="evaluate-info">
                                <span class="date">2017-10-12</span>
                                <div class="rank">
                                    <span>满意度</span>
                                    <i class="iconfont icon-manyi"></i>
                                    <i class="iconfont icon-manyi"></i>
                                    <i class="iconfont icon-manyi"></i>
                                    <i class="iconfont icon-manyi"></i>
                                    <i class="iconfont icon-icon-manyidu"></i>
                                    <span class="score">2.0分</span>
                                </div>
                                <div class="text">价钱适中，买个安心</div>
                            </div>
                        </li>
                        <li>
                            <div class="evaluate-user">
                                <div class="avator">
                                    <img src="{{config('view_url.agent_mob')}}img/girl.png" alt="">
                                </div>
                                <div>张女士</div>
                            </div>
                            <div class="evaluate-info">
                                <span class="date">2017-10-12</span>
                                <div class="rank">
                                    <span>满意度</span>
                                    <i class="iconfont icon-manyi"></i>
                                    <i class="iconfont icon-manyi"></i>
                                    <i class="iconfont icon-manyi"></i>
                                    <i class="iconfont icon-manyi"></i>
                                    <i class="iconfont icon-icon-manyidu"></i>
                                    <span class="score">2.0分</span>
                                </div>
                                <div class="text">价钱适中，买个安心</div>
                            </div>
                        </li>
                    </ul>

                </div>
            </div>
        </div>
        <div class="buttons-box">
            <button class="zbtn zbtn-price">￥{{$data['price']/100}}</button>
            <button id="send" class="zbtn zbtn-positive">发送产品给客户</button>
            <a href="make.html" class="zbtn zbtn-default">制作计划书</a>
        </div>
    </div>
</div>
<!--保障权益浮层-->
@foreach($return_data['option']['protect_items'] as $vv)
<div class="mui-popover noticePopover">
    <i class="iconfont icon-guanbi"></i>
    <div class="notice-wrapper">
        <h2 class="notice-title">年度总限额200万元</h2>
        <div class="notice-content">
            <div class="mui-scroll-wrapper">
                <div class="mui-scroll">
                    <div class="notice-list">{{$vv['description']}}</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach
<!--发送产品给客户-->
<div class="mui-popover popover-send">
    <ul>
        <a href="javascript:;"  id="qq_id" target="_blank"><li class="qq"></li></a><input type="text" hidden value=""/><>
        <li class="weixin" data-clipboard-action="copy" data-clipboard-target="#foo"><input type="text" value="{{$url}}" id="foo"/><>
    </ul>
</div>

<script src="{{config('view_url.agent_mob')}}js/lib/jquery-1.11.3.min.js"></script>
<script src="{{config('view_url.agent_mob')}}js/lib/echarts.js"></script>
<script src="{{config('view_url.agent_mob')}}js/lib/mui.min.js"></script>
<script src="{{config('view_url.agent_mob')}}js/common_agent.js"></script>
<script src="{{config('view_url.agent_mob')}}js/clipboard.min.js"></script>

<script>
    $('.zbtn-popover').on('tap',function(){
        mui('.noticePopover ').popover('toggle');
    });
    $('#send').on('tap',function(){
        mui('.popover-send').popover('toggle');
    });
    $('.icon-guanbi').on('tap',function(){
        mui('.noticePopover ').popover('toggle');
    });

    //复制到粘贴版
    var clipboard = new Clipboard('.weixin');
    clipboard.on('success', function(e) {
        console.log(e);
        alert('计划书地址已经复制，请到微信中进行分享');
        location.href = '/agent';
    });
    var month = [];
    var data = [];
    @if($sales)
    @foreach($sales as $k=>$v)
        month['{{$k}}'] = '{{$v['month']}}';
        data['{{$k}}'] = '{{$v['count']}}';
    @endforeach
    @endif
    option = {
        title:{
            text:'按月销售统计',
            textStyle : {
                fontSize: '.24rem',
                color : '#adadad',
            },
            x:'center',
            y:'top',
            textAlign:'left'
        },
        color: ['#3398DB'],
        tooltip : {
            trigger: 'axis',
            axisPointer : {
                type : 'shadow'
            }
        },
        grid: {
            top: '30%',
            left: '0%',
            right: '4%',
            bottom: '3%',
            containLabel: true
        },
        xAxis : [
            {
                type : 'category',
                axisLabel: {
                    textStyle: {
                        color: '#d8d7d9',
                    }
                },
                data : month,
                axisTick: {
                    alignWithLabel: true
                }
            }
        ],
        yAxis : [
            {
                type : 'value',
                name: '销量(份)',
                axisLabel: {
                    textStyle: {
                        color: '#d8d7d9'
                    }
                }
            }
        ],
        series : [
            {
                name:'销量份数',
                type:'bar',
                barWidth: '20%',
                data:data
            }
        ]
    };

    var myChart = echarts.init(document.getElementById('main'));
    myChart.setOption(option);
    window.addEventListener("resize", function () {
        myChart.resize();
    });
    window.addEventListener("load", function () {
        myChart.resize();
    });

</script>

{{--分享--}}
<script>window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"","bdMini":"2","bdMiniList":false,"bdPic":"","bdStyle":"0","bdSize":"32"},"share":{},"image":{"viewList":["weixin","tsina","qzone","tqq"],"viewText":"分享到：","viewSize":"16"},"selectShare":{"bdContainerClass":null,"bdSelectMiniList":["weixin","tsina","qzone","tqq"]}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];</script>
<script>
    var url = "{{$url}}";
    var desc_ = "您的专属保险计划书";
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