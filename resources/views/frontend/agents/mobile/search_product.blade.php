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
            <input type="search" class="mui-input-clear mui-indexed-list-search-input" placeholder="搜索产品">
        </div>
        <div class="mui-indexed-list-alert"></div>
        <div class="mui-indexed-list-inner">
            <div class="mui-indexed-list-empty-alert">没有数据</div>
            <ul class="mui-table-view">
                @if($product_count ==0)
                    <li>
                       暂时没有产品可以代理
                    </li>
                @else
                    @foreach($product_list as $v)
                        <li data-value="{{$v->ty_product_id}}" data-tags="AKeSu" class="mui-table-view-cell mui-indexed-list-item">
                            <div class="list-img">
                            </div>
                            <span>{{$v->product_name}}</span>
                        </li>
                    @endforeach
                @endif
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
    mui.init();
    mui.ready(function() {
        var header = document.querySelector('header.mui-bar');
        var list = document.getElementById('list');
        list.style.height = (document.body.offsetHeight - header.offsetHeight) + 'px';
        window.indexedList = new mui.IndexedList(list);
    });

    $('.mui-indexed-list-item').on('tap',function(){
        var val = $(this).attr('data-value');
        sessionStorage.setItem('productId',val);
        var frommUrl = sessionStorage.getItem('frommUrl');
        location.href = frommUrl;
    });
</script>
</body>

</html>