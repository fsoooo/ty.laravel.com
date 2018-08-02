<div class="notification-right fr">
    <div class="notification-right-info">
        <div class="notification-right-header">
            <div class="notification-right-img">
                <a href="/productlists/{{json_decode($product_res['json'],true)['category_id']}}"><img src="{{env('TY_API_PRODUCT_SERVICE_URL')."/".json_decode($product_res['json'],true)['company']['logo']}}"></a>
            </div>
            <h2 class="notification-right-title">{{$product_res['product_name']}}</h2>
        </div>
        <div class="notification-right-content">
            <ul>
                <li class="clearfix">
                    <div class="col1 bold">保障权益</div>
                </li>
                <li class="clearfix">
                    <div class="col1">意外身故</div>
                    <div class="col2">5万元</div>
                </li>
                <li class="clearfix">
                    <div class="col1">意外身故</div>
                    <div class="col2">5万元</div>
                </li>
                @foreach($parameter as $k=>$v)
                    @if(key_exists($k,$tariff_params))
                        @if($v!=="0")
                        <li class="clearfix">
                            <div class="col1 bold">{{$tariff_params[$k]}}</div>
                            <div class="col2">{{$v}}</div>
                        </li>
                        @endif
                    @endif
                @endforeach
            </ul>
            <ul>
                <li class="clearfix">
                    <div class="col1 bold">价格</div>
                    <div class="col2">￥{{$parameter['tariff']}}.00</div>
                </li>
                <li class="clearfix">
                    <div class="col1 bold">份数</div>
                    <div class="col2">1</div>
                </li>
            </ul>
        </div>
        <div class="notification-right-price">
            <li class="clearfix">
                <div class="col1 bold">合计</div>
                <div class="col2">￥<span class="price">{{$parameter['tariff']}}.00 </span></div>
            </li>
        </div>
    </div>
</div>