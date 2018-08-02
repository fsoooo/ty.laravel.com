<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>客户列表</title>
    <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
    <link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/lib/mui.min.css">
    <link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/lib/mui.indexedlist.css" />
    <link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/lib/iconfont.css" />
    <link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/common_agent.css" />
    <link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/list.css" />
    <link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/client.css" />
</head>

<body>
<div class="mui-popover popover-search">
    <div class="popover-search-top">
        <div class="search">
            <i class="iconfont icon-sousuo"></i>
            <form id="myform1" action="" onsubmit="return false;">
                <input name="cust_search_name" type="search" placeholder="请输入客户名称"/>
            </form>
        </div>
        <span id="cancel" class="zbtn">取消</span>

    </div>
    <div class="division"></div>
    <div class="popover-search-wrapper">
        <div class="title">搜索记录</div>
        {{--<span class="zbtn">天小眼</span>--}}
        {{--<span class="zbtn">天大眼</span>--}}
        {{--<span class="zbtn">天大眼的互联网公司</span>--}}
        <div class="mui-scroll-wrapper" style="display: none;">
            <div class="mui-scroll">
                <ul class="mui-indexed-list-inner">
                    <li data-value="ENH" data-tags="EnShiXuJiaPing" class="mui-table-view-cell mui-indexed-list-item">
                        <div class="list-img">
                            <img src="{{config('view_url.agent_mob')}}img/boy.png" alt="" />
                        </div>
                        <span>天小眼</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>

</div>
<!--侧滑菜单容器-->
<div id="offCanvasWrapper" class="mui-off-canvas-wrap mui-draggable mui-slide-in">
    <!--菜单部分-->
    <aside id="offCanvasSide" class="mui-off-canvas-right">
        <form id="search_form" action="/agent_sale/cust_lists" method="post">
            <input type="hidden" name="_token" value="{{csrf_token()}}">
        <ul class="filtrate-wrapper">
            <li class="radioBox">
                <div class="name">类型</div>
                <div class="select-box">
                    <span class="zbtn-select">个人客户</span>
                    <span class="zbtn-select">企业客户</span>
                    {{--<span class="zbtn-select">组织/团体</span>--}}
                </div>
                <div hidden class="select-value">
                    <input type="radio" value="0" name="type"/>
                    <input type="radio" value="1" name="type"/>
                    {{--<input type="radio" value="2" name="type"/>--}}
                </div>
            </li>
            <li class="radioBox">
                <div class="name">投保状态</div>
                <div class="select-box">
                    <span class="zbtn-select">已投保</span>
                    <span class="zbtn-select">未投保</span>
                </div>
                <div hidden class="select-value">
                    <input type="radio" value="1" name="status"/>
                    <input type="radio" value="0" name="status"/>
                </div>
            </li>
            {{--<li class="radioBox">--}}
                {{--<div class="name">是否发送计划书</div>--}}
                {{--<div class="select-box">--}}
                    {{--<span class="zbtn-select">已发送</span>--}}
                    {{--<span class="zbtn-select">未发送</span>--}}
                {{--</div>--}}
                {{--<div hidden class="select-value">--}}
                    {{--<input type="radio" value="1" name="plan"/>--}}
                    {{--<input type="radio" value="2" name="plan"/>--}}
                {{--</div>--}}
            {{--</li>--}}
            <li class="radioBox">
                <div class="name">沟通状态</div>
                <div class="select-box">
                    <span class="zbtn-select">超过10天未沟通的客户</span>
                    <span class="zbtn-select">10天内沟通过的客户</span>
                </div>
                <div hidden class="select-value">
                    <input type="radio" value="0" name="com"/>
                    <input type="radio" value="1" name="com"/>
                </div>
            </li>
        </ul>
        </form>
        <div class="two-button-box">
            <button id="reset" class="zbtn zbtn-hollow">重置</button>
            <a id="go" class="zbtn zbtn-positive">确定</a>
        </div>
    </aside>
    <div class="mui-inner-wrap">
        <header id="header" class="mui-bar mui-bar-nav">
            <a class="iconfont icon-fanhui mui-pull-left mui-action-back"></a>
            <h1 class="mui-title">客户列表</h1>
        </header>
        <div id="offCanvasContentScroll" class="mui-content mui-scroll-wrapper">
            <div id='list' class="mui-indexed-list">
                <div class="list-search-wrapper">
                    {{--<a href="#offCanvasSide" class="filtrate">筛选<i class="iconfont icon-shaixuan"></i></a>--}}
                    <div class="mui-indexed-list-search mui-input-row mui-search"><i class="iconfont icon-sousuo"></i>搜索客户</div>
                </div>
                <div class="mui-indexed-list-alert"></div>
                <div class="mui-scroll-wrapper content">
                    <div class="mui-scroll">
                        <div class="mui-indexed-list-inner">
                            <ul class="mui-table-view">
                                @if(isset($data))
                                @foreach($data as $v)
                                    <a href="/agent_sale/mobile_cust_detail/{{$v->id}}">
                                <li style="display: block" data-value="AKU" data-tags="AKeSu" class="mui-table-view-cell mui-indexed-list-item">
                                    <div class="list-img">
                                        <img src="{{config('view_url.agent_mob')}}img/boy.png" alt="" />
                                    </div>
                                    <span>
                                        @if($v['real_name'])
                                            {{$v->name}}
                                            @else
                                            --
                                            @endif
                                    </span>
                                    <div class="icon-wrapper">
                                        @if($v['type'] == 'user' && $v['code'] && substr($res[0]['code'],10,4) == date('md',time()))
                                            <i class="iconfont icon-brithday"></i>
                                        @endif
                                        @if($v['type'] == 'company' && $v['authentication'] && $v['authentication']['status'] == 2 || $v['type'] == 'user' && $v['user_authentication_person'] && $v['user_authentication_person']['status'] == 2)
                                                <i class="iconfont icon-businesscard_fill"></i>
                                        @endif
                                            @if($v['type'] == 'company')
                                                <i class="iconfont icon-group_fill"></i>
                                        @endif
                                            {{--@if($v['type'] == 'user' && $v['code'] && substr($res[0]['code'],10,4) == date('md',time()))--}}
                                                {{--<i class="zicon zicon-xinxi-blue">1</i>--}}
                                        {{--@endif--}}
                                            {{--@if($v['type'] == 'user' && $v['code'] && substr($res[0]['code'],10,4) == date('md',time()))--}}
                                                {{--<i class="zicon zicon-xinxi-red"></i>--}}
                                        {{--@endif--}}
                                            @if($v['type'] == 'user')
                                                <i class="zicon zicon-user"></i>
                                            @endif





                                    </div>
                                </li>
                                    </a>
                                    @endforeach
                                    @endif
                            </ul>
                        </div>
                    </div>
                    <div class="two-button-box">
                        <button id="add" class="zbtn zbtn-positive">手动添加</button>
                        <a href="/agent_sale/agent_invite" class="zbtn zbtn-default content">邀请客户</a>
                    </div>
                </div>



            </div>
        </div>
        <div class="mui-off-canvas-backdrop"></div>

    </div>
</div>


<!--手动添加弹出层-->
<div class="mui-popover popover-client">
    <div class="popover-wrapper">
        <div class="title">添加的客户类型<i class="iconfont icon-close"></i></div>
        <div class="popover-content">
            <ul>
                <li>
                    <a href="/agent_sale/client_add_person">
                        <div class="iconfont-wrapper"><i class="zicon zicon-user"></i></div>
                        <div class="text-wrapper">个人客户</div>
                    </a>
                </li>
                <li>
                    <a  href="/agent_sale/client_add_company">
                        <div class="iconfont-wrapper"><i class="iconfont icon-businesscard_fill"></i></div>
                        <div id="qiye" class="text-wrapper">企业客户</div>
                    </a>
                </li>
                {{--<li>--}}
                    {{--<a href="javascript:;">--}}
                        {{--<div class="iconfont-wrapper"><i class="iconfont icon-group_fill"></i></div>--}}
                        {{--<div class="text-wrapper">组织/团体</div>--}}
                    {{--</a>--}}
                {{--</li>--}}
            </ul>
        </div>
    </div>
</div>



<script src="{{config('view_url.agent_mob')}}js/lib/jquery-1.11.3.min.js"></script>
<script src="{{config('view_url.agent_mob')}}js/lib/mui.min.js"></script>
<script src="{{config('view_url.agent_mob')}}js/lib/mui.indexedlist.js"></script>
<script src="{{config('view_url.agent_mob')}}js/lib/swiper-3.4.2.min.js"></script>
<script src="{{config('view_url.agent_mob')}}js/common_agent.js"></script>
<script>
    $('#myform1').bind('search', function() {
        var search_data = $("input[name='cust_search_name']").val();
        $("input").blur();
        location.href='/agent_sale/cust_lists'+'?cust_search_name='+search_data;
    });

    $('#yaoqing').click(function(){
//        alert('敬请期待');
    })
    $('#qiye').click(function(){
//        alert('敬请期待');
    })
    mui('.mui-indexed-list-inner').on('tap','a',function(){document.location.href=this.href;});
    mui('.content').on('tap','a',function(){document.location.href=this.href;});

    $('.mui-indexed-list-search,#cancel').on('tap',function(){
        mui('.popover-search').popover('toggle');
    });


    // 初始化
    $('#add').on('tap', function() {
        mui('.popover-client').popover('toggle');
    });
    selectData('.radioBox','single');

    // 侧滑筛选重置
    $('#reset').on('tap',function(){
        $('.zbtn-select').removeClass('active');
        $('.filtrate-wrapper input').prop('checked',false);
    })

    mui.ready(function() {
        var header = document.querySelector('header.mui-bar');
        var list = document.getElementById('list');
        list.style.height = (document.body.offsetHeight - header.offsetHeight) + 'px';
    });

    $('#go').click(function(){
        $("#search_form").submit();
    })





</script>
</body>

</html>