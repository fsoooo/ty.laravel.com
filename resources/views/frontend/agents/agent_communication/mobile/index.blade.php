<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>沟通列表</title>
    <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
    <link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/lib/mui.min.css">
    <link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/lib/iconfont.css" />
    <link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/common_agent.css" />
    <link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/list.css" />
    <link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/record.css" />
</head>

<body>
<div class="mui-popover popover-search">
    <div class="popover-search-top">
        <form action="" id="search">
        <div class="search">
            <i class="iconfont icon-sousuo"></i>
            <input type="search" name="search" placeholder="请输入客户名称"/>
        </div>
        </form>
        <span id="cancel" class="zbtn">取消</span>
    </div>
    <div class="division"></div>
    {{--<div class="popover-search-wrapper">--}}
        {{--<div class="title">搜索记录</div>--}}
        {{--<span class="zbtn">天小眼</span>--}}
        {{--<span class="zbtn">天大眼</span>--}}
        {{--<span class="zbtn">天大眼的互联网公司</span>--}}
    {{--</div>--}}
</div>
<header id="header" class="mui-bar mui-bar-nav">
    <a class="iconfont icon-fanhui mui-pull-left mui-action-back"></a>
    <h1 class="mui-title">沟通列表</h1>
</header>
<div class="mui-content mui-scroll-wrapper content-record">
    <div class="mui-indexed-list">
        <div class="list-search-wrapper">
            <div id='edit' class="filtrate color-primary">编辑</div>
            <div class="mui-indexed-list-search mui-input-row mui-search"><i class="iconfont icon-sousuo"></i>搜索客户</div>
        </div>
        <div class="mui-scroll-wrapper">
            <div class="mui-scroll">
                <ul class="mui-table-view">
                    @foreach($data as $v)
                    <li class="mui-table-view-cell">
                        <div class="details">
                            <div class="list-img">
                                <img src="{{config('view_url.agent_mob')}}img/boy.png" alt="" />
                            </div>
                            <span class="name" style="width:11em;display:block;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{$v->user['real_name']}}</span>
                            <span>{{$v->product['product_name']}}</span>
                            <span class="color-positive">{{$v['grade']}}分</span>
                            <span class="date">{{strtok($v['created_at'],' ')}}</span>
                        </div>
                        <div class="info">{{$v['content']}}</div>
                        <div class="mask">
                            <label>
                                <input hidden type="radio" value="{{$v['id']}}" name="record"/>
                                <i class="iconfont icon-weixuanze"></i>
                            </label>
                        </div>
                    </li>
                        @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="button-box">
    <a href="/agent_sale/communication_add" class="zbtn zbtn-default">新增沟通记录</a>
</div>

<div class="two-button-box" style="display: none;">
    <button id="delete" disabled type="button" class="zbtn zbtn-default">删除</button>
    <button id="edit_btn" disabled type="button" class="zbtn zbtn-positive disabled">修改</button>
</div>

<script src="{{config('view_url.agent_mob')}}js/lib/jquery-1.11.3.min.js"></script>
<script src="{{config('view_url.agent_mob')}}js/lib/mui.min.js"></script>
<script src="{{config('view_url.agent_mob')}}js/common_agent.js"></script>
<script>
    // 初始化
    $('#add').on('tap', function() {
        mui('.popover-client').popover('toggle');
    });
    selectData('.radioBox','single');

    $('.mui-indexed-list-search,#cancel').on('tap',function(){
        mui('.popover-search').popover('toggle');
    });

    // 侧滑筛选重置
    $('#reset').on('tap',function(){
        $('.zbtn-select').removeClass('active');
        $('.filtrate-wrapper input').prop('checked',false);
    });

    // 编辑
    $('#edit').on('tap',function(){
        $('.mask,.two-button-box').show();
    });

    // 删除修改按钮是否禁用
    $('.mask').click(function(){
        var This = $(this);
        if($('.icon-queding').length){
            $('.two-button-box .zbtn').prop('disabled',false).removeClass('disabled');
        }
        //修改
        $("#edit_btn").click(function(){
            var id = This.parent().find('input').val();
            location.href='/agent_sale/communication_add'+'?communication_id='+id;
        })
        //删除
        $("#delete").click(function(){
            var id = This.parent().find('input').val();
            location.href='/agent_sale/communication_delete'+'?id='+id;
        })
    });



    //搜索
    $('#search').bind('search', function() {
        var search = $("input[name='search']").val();
        location.href='/agent_sale/communication'+'?search='+search;
    });

    // 修改按钮点击操作
    $('.zbtn-positive').on('tap',function(){
        location.href = 'record_add.html';
    });

    // 编辑按钮选择沟通记录
    $('.mui-table-view-cell .iconfont').on('tap',function(){
        var _this = $(this);
        $('.mui-table-view-cell .iconfont').addClass('icon-weixuanze').removeClass('icon-queding');
        if(_this.hasClass('icon-weixuanze')){
            _this.addClass('icon-queding').removeClass('icon-weixuanze');
        }else{
            _this.addClass('icon-weixuanze').removeClass('icon-queding');
        }
    });
</script>
</body>
</html>