{{--投保须知，健康告知，填写投保信息的侧边信息块--}}
<div class="notification-right fr">
    <div class="notification-right-info">
        <div class="notification-right-header">
            @if($parameter['health_verify'] != 1)
            <div class="notification-right-img">
                <img src="{{env('TY_API_PRODUCT_SERVICE_URL')}}/{{substr(json_decode($product_res['json'],true)['company']['logo'],0,1)=="/"?substr(json_decode($product_res['json'],true)['company']['logo'],1):json_decode($product_res['json'],true)['company']['logo']}}">
            </div>
            @endif
            <div class="notification-right-content">
                <ul>
                    <li class="clearfix">
                        <div class="col1 bold">保障权益</div>
                    </li>
                    @if(isset($parameter['protect_item']))
                        @php $items = json_decode($parameter['protect_item'], true); @endphp
                        @foreach($items as $it => $item)
                            <li class="clearfix">
                                <div class="col1">{{$item['name']}}</div>
                                @if(isset($item['defaultValue'])) <div class="col2">{{$item['defaultValue']}}</div> @endif
                            </li>
                        @endforeach
                    @else
                    @foreach(json_decode($product_res->clauses,true) as $clause)
                        @foreach($clause['duties'] as $duty)
                            <li class="clearfix">
                                <div class="col1">{{$duty['name']}}</div>
                                {{--<div class="col2">5万元</div>--}}
                            </li>
                        @endforeach
                    @endforeach
                    @endif
                </ul>

                <ul>
                    <li class="clearfix">
                        <div class="col1 bold">价格</div>
                        <div class="col2">￥{{$parameter['price']/100}}</div>
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
                    <div class="col2">￥<span class="price">{{$parameter['price']/100}} </span></div>
                </li>
            </div>
        </div>
    </div>
</div>