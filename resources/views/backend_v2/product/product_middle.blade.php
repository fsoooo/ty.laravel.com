{{--业管后台产品详情顶部Tab模块--}}
<?php
$detail_active =   preg_match("/product_details_on/",Request::getRequestUri()) ? "active" : '';
$sale_active =  preg_match("/product_sale_statistics/",Request::getRequestUri()) ? "active" : '';
$comment_active = preg_match("/product_comment/",Request::getRequestUri()) ? "active" : '';
?>
    <div class="row">
        <div class="section">
            <div class="col-lg-6 col-xs-6">
                <a href="/backend/product/product_details_on/{{$product_res['id']}}" class="section-item {{$detail_active}}">产品详情</a>
            </div>
            <div class="col-lg-6 col-xs-6">
                <a href="/backend/product/product_sale_statistics/{{$product_res['ty_product_id']}}" class="section-item {{$sale_active}}">销售统计</a>
            </div>
            {{--<div class="col-lg-4 col-xs-6">--}}
                {{--<a href="/backend/product/product_comment/{{$product_res['id']}}" class="section-item {{$comment_active}}">评论</a>--}}
            {{--</div>--}}
        </div>
    </div>