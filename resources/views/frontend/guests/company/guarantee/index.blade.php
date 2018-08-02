@extends('frontend.guests.company_home.base')
@section('content')
    <div class="main-wrapper">
        <div class="table-nav">
            <span <?php if($type =='all'){?> class="active" <?php } ?>><a href="{{url('/guarantee/index/all')}}">所有保单</a></span>
        </div>
        <div class="table-wrapper">
            <div class="table-head clearfix">
                <span class="col1">产品名称</span>
                <span class="col2">权益</span>
                <span class="col4">保费</span>
                <span class="col5">参保人</span>
                <span class="col6">保障期限</span>
                <span class="col7">操作</span>
            </div>
            <ul class="table-body">
                @foreach($users as $value)
                    <li class="table-tr">
                        <span class="tips">自助投保&nbsp;&nbsp;&nbsp;暂未分配&nbsp;&nbsp;&nbsp;
                            {{--<a href="{{url('/preservation/insure_cacel/'.$value->warranty_code)}}">我要退保</a>--}}
                            </span>
                        <div class="table-tr-bottom">
                            <span>创建时间{{ $value->created_at }}</span>
                            <span>保单号  {{ $value->warranty_code }}</span>
                        </div>
                        <div class="table-tr-top clearfix">
                            <div class="col1" style="width:250px;">
                                <h4 class="" style="width:150px;text-align: left;margin-left: 82px;margin-right: 10px; line-height:20px">{{ $value->product_name }}</h4>
                            </div>
                            <div class="col2">
                                <?php
                                $order_parameter = json_decode($value['order_parameter'][0]['parameter'], true);
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
                            <div class="col5">
                                <div>{{isset($value['start_time'])?strtok($value['start_time'],' ') : '--'}}</div>
                                <div>至</div>
                                <div>{{isset($value['end_time'])?strtok($value['end_time'],' ') : date("Y-m-d",strtotime("+1 year",strtotime($value['start_time'])))}}</div>
                            </div>
                            <div class="col6 ">
                                <a href="/guarantee/company_guarantee_detail/{{$value['id']}}">查看详情</a>
                            </div>

                        </div>
                    </li>
                @endforeach

            </ul>

        </div>
        {{--分页--}}
        <div style="text-align: center;">
            {{ $users->links() }}
        </div>

        <div class="paging-wrapper">
            <div id="pageToolbar"></div>
        </div>
    </div>



@stop