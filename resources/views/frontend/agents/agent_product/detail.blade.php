@extends('frontend.agents.agent_home.base')
@section('content')
    <link rel="stylesheet" href="{{config('view_url.agent_url')}}css/agent.css" />
    <link rel="stylesheet" href="{{config('view_url.agent_url')}}css/product.css" />
    <div class="content" style="padding: 40px 0;">
        <div style="padding: 0 20px;">
            <ul class="crumbs">
                <li><a href="#">首页</a><i class="iconfont icon-gengduo"></i></li>
                <li><a href="#">我的产品</a><i class="iconfont icon-gengduo"></i></li>
                <li>产品详情</li>
            </ul>

            <div class="user-wrapper">
                <img class="fl" src="{{env('TY_API_PRODUCT_SERVICE_URL').'/'.$data['json']['company']['logo']}}" alt="" />
                <button id="sendToCustomer" class="z-btn z-btn-positive" style="margin: -6px 0 0 10px;">发送给客户</button>
                <a href="/agent_sale/add_plan" class="z-btn z-btn-default" style="margin-top: -6px;">制作计划书</a>
                <p class="user-info"><span>{{$data['product_name']}}</span></p>
            </div>

            <table class="table-gary">
                <tbody>
                <tr>
                    <td>保费</td>
                    <td>{{$data['price']/100}}元</td>
                    <td>佣金比率</td>
                    <td class="color-positive">{{$data['rate']['earning']}}%</td>
                </tr>
                <tr>
                    <td>保额</td>
                    <td>{{$data['defaultPrice']['defaultValue']}}</td>
                    <td>佣金金额</td>
                    <td>{{$data['price'] * $data['rate']['earning']/10000}}元</td>
                </tr>
                <tr>
                    <td>销售统计</td>
                    <td>共销售2000份，排名<span class="red">16</span></td>
                    <td>支付方式</td>
                    <td>{{$data['json']['brokerage'][0]['pay_type_unit']}}交</td>
                </tr>
                <tr>
                    <td>购买男女比例</td>
                    <td>男20份 女180份</td>
                    <td>首次支付</td>
                    <td>2000元</td>
                </tr>
                </tbody>
            </table>
        </div>

        <div class="datas-wrapper">
            <div class="datas-content">
                <div class="datas-header">
                    <div class="title">按月销量统计</div>
                    <div class="ranking-wrapper">
                        <span>总销量<i class="red">2000</i>份</span>
                        <span>在同类产品中排第 <i class="ranking">5</i>名</span>
                        <a href="product_rank.html">
                            <span class="more">查看排行<i class="iconfont icon-gengduo"></i></span>
                        </a>
                    </div>
                </div>
                <div class="datas">
                    <div id="main" style="width: 100%;height:220px;"></div>
                </div>
            </div>
        </div>

        <div style="padding: 0 20px;">
            <div class="section-wrapper">
                <div class="section-header"><i class="iconfont icon-shouye"></i>保障权益</div>
                <div class="section-content">
                    <ul class="equity-list">
                        @foreach($return_data['option']['protect_items'] as $v)
                        <li>
                            <div class="info">{{$v['name']}}<span class="more">查看详情<i class="iconfont icon-gengduo"></i></span></div>
                            <div class="details">{{$v['description']}}</div>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="section-wrapper section2">
                <div class="section-header"><i class="iconfont icon-shouye1"></i>用户评价</div>
                <div class="section-content">
                    <div class="evaluate-left">
                        <div class="score"><span>4.0</span>分</div>
                        <div class="satis">
                            <span>满意度</span>
                            <i class="iconfont icon-manyi"></i>
                            <i class="iconfont icon-manyi"></i>
                            <i class="iconfont icon-manyi"></i>
                            <i class="iconfont icon-manyi"></i>
                            <i class="iconfont icon-icon-manyidu"></i>
                        </div>
                        <div class="rank">
                            <span>排名：3</span>
                            <span class="more fr">查看排行<i class="iconfont icon-gengduo"></i></span>
                        </div>
                    </div>

                    <div class="evaluate-right">
                        <i id="moreLabel" class="iconfont icon-gengduo"></i>
                        <span class="z-btn z-btn-hollow">放心</span>
                        <span class="z-btn z-btn-hollow high">性价比高</span>
                        <span class="z-btn z-btn-hollow">值得信赖</span>
                        <span class="z-btn z-btn-hollow high">经济实惠</span>
                        <span class="z-btn z-btn-hollow">保费低</span>
                        <span class="z-btn z-btn-hollow">保额高</span>
                        <span class="z-btn z-btn-hollow">很热情</span>
                        <span class="z-btn z-btn-hollow">买份安心</span>
                        <span class="z-btn z-btn-hollow high">经济实惠</span>
                        <span class="z-btn z-btn-hollow">保费低</span>
                        <span class="z-btn z-btn-hollow">保额高</span>
                        <span class="z-btn z-btn-hollow">很热情</span>
                        <span class="z-btn z-btn-hollow">买份安心</span>
                    </div>
                </div>
            </div>
            <div class="evaluate-wrapper">
                <div class="title">全部评价（120条）<span class="fold">收起<i class="iconfont icon-shangla"></i></span></div>
                <div class="evaluate-all">
                    <span class="more"><span class="under">查看全部评价</span><i class="iconfont icon-gengduo"></i></span>
                </div>
                <ul class="evaluate-list">
                    <li>
                        <div class="evaluate-user">
                            <div class="avator">
                                <img src="{{config('view_url.agent_url')}}img/girl.png" alt="" />
                            </div>
                            <div>张女士</div>
                        </div>
                        <div class="evaluate-info">
                            <span class="date">2017-10-12</span>
                            <div class="rank">
                                <i class="iconfont icon-manyi"></i>
                                <i class="iconfont icon-manyi"></i>
                                <i class="iconfont icon-manyi"></i>
                                <i class="iconfont icon-manyi"></i>
                                <i class="iconfont icon-icon-manyidu"></i>
                            </div>
                            <div class="text">优势是6000免保额，价钱适中，买个安心</div>
                        </div>
                    </li>
                    <li>
                        <div class="evaluate-user">
                            <div class="avator">
                                <img src="{{config('view_url.agent_url')}}img/girl.png" alt="" />
                            </div>
                            <div>张女士</div>
                        </div>
                        <div class="evaluate-info">
                            <span class="date">2017-10-12</span>
                            <div class="rank">
                                <i class="iconfont icon-manyi"></i>
                                <i class="iconfont icon-manyi"></i>
                                <i class="iconfont icon-manyi"></i>
                                <i class="iconfont icon-manyi"></i>
                                <i class="iconfont icon-icon-manyidu"></i>
                            </div>
                            <div class="text">优势是6000免保额，价钱适中，买个安心</div>
                        </div>
                    </li>
                </ul>
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
                        <input type="hidden" name="url" value="点击此链接，开启您的保险之旅   {{$url}}">
                        <a href="javascript:;" id="sendEmail" class="z-btn z-btn-positive" disabled>发送</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="popups-wrapper popups-success">
        <div class="popups">
            <div class="popups-title">发送产品<i class="iconfont icon-close"></i></div>
            <div class="popups-content">
                <i class="iconfont icon-shenqingchenggong"></i>
                <p>发送成功</p>
                <div>
                    <a href="/agent_sale/agent_product" class="z-btn z-btn-positive" style="display: block;margin: 60px auto 0;">返回产品列表</a>
                    <a href="" class="z-btn-hollow" style="display: block;margin: 0 auto;border: none;">发送给其他客户</a>
                </div>
            </div>
        </div>
    </div>

    <script src="{{config('view_url.agent_url')}}js/lib/echarts.js"></script>
    <script src="{{config('view_url.agent_url')}}js/product_details.js"></script>
    <script>

        option = {
            color: ['#3398DB'],
            tooltip : {
                trigger: 'axis',
                axisPointer : {
                    type : 'shadow'
                }
            },
            grid: {
                top: '12%',
                left: '3%',
                right: '4%',
                bottom: '3%',
                containLabel: true
            },
            xAxis : [
                {
                    type : 'category',
                    axisLabel: {
                        textStyle: {
                            color: '#d8d7d9'
                        }
                    },
                    data : ['一月', '二月', '三月', '四月', '五月', '六月', '七月', '八月', '九月', '十月', '十一月', '本月'],
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
                    data:[100, 82, 200, 334, 390, 330, 220, 44, 20, 100, 222, 330]
                }
            ]
        };
        var myChart = echarts.init(document.getElementById('main'));
        myChart.setOption(option);
    </script>

    {{--分享--}}
    <script>window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"","bdMini":"2","bdMiniList":false,"bdPic":"","bdStyle":"0","bdSize":"32"},"share":{},"image":{"viewList":["weixin","tsina","qzone","tqq"],"viewText":"分享到：","viewSize":"16"},"selectShare":{"bdContainerClass":null,"bdSelectMiniList":["weixin","tsina","qzone","tqq"]}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];</script>
    <script type="text/javascript" src="http://code.jquery.com/jquery-1.8.0.min.js"></script>
    <script>
        $('#sendToCustomer').click(function(){
            Popups.open('.popups-way',function(){
                $('#email').val('').parent().hide();
            });
            $('#sendEmail').click(function(){
                var data = $("input[name=email]").val();
                var _token = $("input[name=_token]").val();
                var url = $("input[name=url]").val();
                $.ajax({
                    url:'/agent_sale/send_url',
                    data:{'data':data,'_token':_token,'url':url},
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


        var url = "{{$url}}";
        var desc_ = "您的专属保险计划书";
        function tencentWeiBo(){
            var _url = "{{$url}}";
            var _showcount = 0;
            var _summary = "";
            var _title = "通过以下地址开启您的保险之旅";
            var _site = "";
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
                summary : '{{$url}}', /*分享摘要(可选)*/
//                pics : 'http://www.junlenet.com/uploads/allimg/150510/1-150510104044.jpg', /*分享图片(可选)*/
                flash : '', /*视频地址(可选)*/
                site : '', /*分享来源(可选) 如：QQ分享*/
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
    @stop
