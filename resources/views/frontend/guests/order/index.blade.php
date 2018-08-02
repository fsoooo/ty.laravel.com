@extends('frontend.guests.person_home.base')
@section('content')
    <div class="main-wrapper">
        <div class="table-nav">
            <span <?php if($order_type =='all'){?> class="active" <?php } ?> ><a href="{{url('/order/index/all')}}">所有订单</a></span>
        </div>
        @include('frontend.guests.layout.alert_info')
        <div class="table-wrapper">
            <div class="table-head clearfix">
                <span class="col1">产品名称</span>
                <span class="col2">保障权益</span>
                <span class="col3">保费</span>
                <span class="col4">被保人</span>
                <span class="col5">创建时间</span>
                <span class="col6">订单状态</span>
                <span class="col7">操作</span>
            </div>

            <ul class="table-body">
                @foreach($order_list as $key=>$value)
                <li class="table-tr">
                    <span class="tips">自助投保&nbsp;&nbsp;&nbsp;暂未分配</span>
                    <div class="table-tr-bottom">
                        <span>起保时间{{ $value->start_time }}</span>
                        <span>订单号  {{ $value->order_code }}</span>
                    </div>
                    <div class="table-tr-top clearfix">
                        <div class="col1" style="width:220px;">
                            <h4 class="" style="width:150px;text-align: left;margin-left: 60px;margin-right: 10px; line-height:20px">
                                {{ isset($value->product->product_name)? $value->product->product_name : "" }}
                            </h4>
                        </div>
                        <div class="col2">
                            <?php
                                $a = isset($value['order_parameter']) ? $value['order_parameter'][0]['parameter'] : "";
                                $order_parameter = json_decode($a, true);
                                $items = isset($order_parameter['protect_item'])?json_decode($order_parameter['protect_item'], true):[];
                            ?>
                            <ul>
                                @foreach($items as $key => $val)
                                    @if($key <= 2)
                                        <li class="clearfix"><span class="fl">{{$val['name']}}</span><span class="fr">{{$val['defaultValue']}}</span></li>
                                    @endif
                                @endforeach
                            </ul>
                            <i class="iconfont icon-jiantou2">
                                <div class="order-rights" style="width:300px;">
                                    <ul>
                                        @foreach($items as $key => $val)
                                            <li class="clearfix"><span style="float:left">{{$val['name']}}</span><span class="fr">{{$val['defaultValue']}}</span></li>
                                        @endforeach
                                    </ul>
                                </div>
                            </i>
                        </div>
                        <div class="col3">
                            ￥{{ $value->premium/100 }}
                        </div>
                        <div class="col4">
                            @foreach($value['warranty_recognizee'] as $v)
                                {{ $v->name }}
                            @endforeach
                        </div>
                        <div class="col5" style="padding-top: 71px;">
                            @php $date = substr($value->created_at,'0','10');@endphp
                            <div>{{$date}}</div>
                        </div>
                        @php
                            $new_time = strtotime(date('Y-m-d H:i:s'));
                            $old_time = strtotime($value->created_at);
                            $data = ($new_time-$old_time);
                        @endphp
                        @if($value->status == 2)
                            @if($data>259200)
                                <div class="col6">
                                    已关闭
                                </div>
                            @else
                                <div class="col6">
                                    待支付
                                </div>
                            @endif

                        @else
                            <div class="col6">
                                已支付
                            </div>
                        @endif
                        <div class="col7">
                            <div class="btn-wrapper">
                                @if($value->status == 2)
                                    @if($data>259200)
                                        已关闭
                                    @else
                                        @if(isset($value->warranty_rule->union_order_code))
                                            <a class="btn btn-ffae00" href="{{ url('/ins/pay_again/'.$value->warranty_rule->union_order_code) }}">立即支付</a>
                                        @else
                                            <a href="/">操作失败</a>
                                        @endif
                                    @endif
                                @else
                                    <a href="/">继续购买</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </li>
                @endforeach

             </ul>
        </div>
        {{--分页--}}
        <div style="text-align: center;">
            {{ $order_list->links() }}
        </div>
    </div>


    </div>




@stop