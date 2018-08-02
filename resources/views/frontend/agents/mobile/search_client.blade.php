<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>天眼互联-科技让保险无限可能</title>
    <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
    <link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/lib/mui.min.css">
    <link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/lib/mui.indexedlist.css" />
    <link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/lib/iconfont.css" />
    <link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/common_agent.css" />
    <link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/list.css" />
</head>
<body>
<header id="header" class="mui-bar mui-bar-nav">
    <a class="iconfont icon-fanhui mui-pull-left mui-action-back"></a>
</header>
<div class="mui-content">
    <div id='list' class="mui-indexed-list">
        <div class="mui-indexed-list-search mui-input-row mui-search">
            <input type="search" class="mui-input-clear mui-indexed-list-search-input" placeholder="搜索客户">
        </div>
        {{--<div class="mui-indexed-list-bar">--}}
            {{--<a>A</a>--}}
            {{--<a>B</a>--}}
            {{--<a>C</a>--}}
            {{--<a>D</a>--}}
            {{--<a>E</a>--}}
        {{--</div>--}}
        <div class="mui-indexed-list-alert"></div>
        <div class="mui-indexed-list-inner">
            @if($count == 0)
            <div class="mui-indexed-list-empty-alert">没有数据</div>
            @else
            <ul class="mui-table-view">
                @foreach($cust as $v)
                <li data-value="{{$v->id}}" data-tags="AKeSu" class="mui-table-view-cell mui-indexed-list-item">
                    <span>{{$v->name}}</span>
                </li>
                    @endforeach
            </ul>
                @endif
        </div>
    </div>
</div>
<script src="{{config('view_url.agent_mob')}}js/lib/jquery-1.11.3.min.js"></script>
<script src="{{config('view_url.agent_mob')}}js/lib/mui.min.js"></script>
<script src="{{config('view_url.agent_mob')}}js/lib/mui.indexedlist.js"></script>
<script src="{{config('view_url.agent_mob')}}js/lib/swiper-3.4.2.min.js"></script>
<script src="{{config('view_url.agent_mob')}}js/common_agent.js"></script>
<script>
    mui.init();
    mui.ready(function() {
        var header = document.querySelector('header.mui-bar');
        var list = document.getElementById('list');
        list.style.height = (document.body.offsetHeight - header.offsetHeight) + 'px';
        window.indexedList = new mui.IndexedList(list);
    });

    $('.mui-indexed-list-item').on('tap',function(){
        var val = $(this).attr('data-value');
        sessionStorage.setItem('clientId',val);
        var frommUrl = sessionStorage.getItem('frommUrl');
        location.href = frommUrl;
    });
</script>
</body>

</html>