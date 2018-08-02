{{--业管后台产品管理顶部Tab模块--}}
<?php
$product_on_active =   preg_match("/product_list/",Request::getRequestUri()) || preg_match("/product_details_on/",Request::getRequestUri())? "class=active" : '';
$product_ing_active =  preg_match("/product_stay_on/",Request::getRequestUri()) || preg_match("/product_details_ing/",Request::getRequestUri())|| preg_match("/product_details_edit/",Request::getRequestUri())? "class=active" : '';
$product_down_active = preg_match("/product_sold_out/",Request::getRequestUri())|| preg_match("/product_sold_out_details/",Request::getRequestUri()) ? "class=active" : '';
$product_rank_active = preg_match("/product_rank_list/",Request::getRequestUri())|| preg_match("/product_rank_list_details/",Request::getRequestUri()) ? "class=active" : '';
$sale_active =  preg_match("/product_sale_statistics/",Request::getRequestUri()) ? "class=active" : '';
$comment_active = preg_match("/product_comment/",Request::getRequestUri()) ? "class=active" : '';
?>
<div class="nav-top-wrapper fl">
    <ul>
        <li {{$product_rank_active}}>
            <a href="{{url('/backend/product/product_rank_list')}}">产品排行</a></li>
        </li>
        <li {{$product_on_active}}{{$sale_active}}{{$comment_active}}>
            <a href="{{url('/backend/product/product_list')}}">在售产品</a>
        </li>
        <li {{$product_ing_active}}>
            <a href="{{url('/backend/product/product_stay_on')}}">待上架产品</a></li>
        </li>
        <li {{$product_down_active}}>
            <a href="{{url('/backend/product/product_sold_out')}}">停售产品</a></li>
        </li>
    </ul>
</div>


