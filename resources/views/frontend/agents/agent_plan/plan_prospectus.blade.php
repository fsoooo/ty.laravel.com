@extends('frontend.agents.agent_home.base')
@section('content')
    <link rel="stylesheet" href="{{config('view_url.agent_url')}}css/lib/swiper-3.4.2.min.css" />
    <style>
        table {border: 1px solid #ddd;}
        table th {height: 60px;line-height: 60px;color: #fff;background: #00a2ff;}
        table td {height: 50px;line-height: 50px;border: 1px solid #ddd;border-bottom: 2px solid #ddd;}
        table td:first-child{width: 200px;background: #f4f4f4;}
        table td:last-child{padding-right: 200px;}
    </style>
    <div>
        {{--<ul class="tab">--}}
            {{--<li><a href="/agent_sale/add_plan">制作计划书</a></li>--}}
            {{--<li><a href="/agent_sale/plan_lists">已制作计划书</a></li>--}}
            {{--<li class="active"><a href="/agent_sale/plan_change">已转化计划书</a></li>--}}
        {{--</ul>--}}
    </div>
    <div class="content">
        <ul class="crumbs">
            <li><a href="/agent_sale/add_plan">我的计划书</a><i class="iconfont icon-gengduo"></i></li>
            <li><a href="/agent_sale/plan_lists">已转化计划书</a><i class="iconfont icon-gengduo"></i></li>
            <li>查看详情</li>
        </ul>
        <table>
            <tr><th colspan='2'>计划书信息</th></tr>
            <tr><td>计划书编号</td><td>{{$detail->lists_id}}</td></tr>
            <tr><td>计划书名称</td><td>{{$detail->product_name}}</td></tr>
            <tr><td>计划书状态</td><td>
                    @if($detail->plan_status == 0)
                        未发送
                        @else
                    已发送
                        @endif
                </td></tr>
            <tr><td>发出时间</td>
                @if(isset($detail->send_time))
                    <td>{{date('Y-m-d',$detail->send_time)}}</td>
                @else
                    <td> -- </td>
                @endif
            </tr>
            <tr><td>客户阅读时间</td><td>2017.09.12/11：18</td></tr>
            <tr><td>客户支付时间</td>
                @if($count_order != 0)
                <td>{{$order_data->order_time}}</td>
                    @else
                <td> -- </td>
                    @endif
            </tr>
            <tr><td>出单时间</td><td>2017.09.12/11：18</td></tr>
        </table>
        <table>
            <tr><th colspan='2'>产品信息</th></tr>
            <tr><td>产品名称</td><td>{{$detail->product_name}}</td></tr>
            <tr><td>保障时间</td><td>{{explode(" ",$detail->plan_time)[0]}}起</td></tr>
            <tr><td>总保费</td><td>{{$detail->premium/100}}元</td></tr>
            <tr><td>支付方式</td><td>1次性</td></tr>
            <tr><td>保障金额</td>
                <td>
                    @if(isset($detail->protect_items))
                    @foreach($detail->protect_items as $v)
                        {{$v['name']}}:{{$v['defaultValue']}},
                    @endforeach</td>
                    @endif
            </tr>
            <tr><td>保单状态</td>
                @if($count_order != 0)
                    <td>已支付</td>
                @else
                    <td> 未支付 </td>
                @endif
            </tr>
            <tr><td>佣金比率</td><td class="color-positive">{{$detail->rate['earning']}}%</td></tr>
            <tr><td>佣金金额</td><td class="color-positive">{{$return_data['option']['price']/100 * $detail->rate['earning']/100}}元</td></tr>
            <tr><td>支付金额</td><td class="color-positive">{{$return_data['option']['price']/100}}元</td></tr>
        </table>
        <table>
            <tr><th colspan='2'>客户信息 </th></tr>
            <tr><td>投保人姓名</td>
                @if($count_order != 0)
                <td>{{$order_data->name}}</td>
                    @else
                <td> -- </td>
                    @endif
            </tr>
            <tr><td>被保人姓名</td><td>{{$detail->name}}</td></tr>
            <tr><td>被保人是投保人的</td><td>
                    @if($count_order != 0)
                    @if($order_data->relation == 1)
                        本人
                        @elseif($order_data->relation == 2)
                            妻子
                    @elseif($order_data->relation == 3)
                        丈夫
                    @elseif($order_data->relation == 4)
                        儿子
                    @elseif($order_data->relation == 5)
                        女儿
                    @elseif($order_data->relation == 6)
                        父亲
                    @elseif($order_data->relation == 7)
                        母亲
                    @elseif($order_data->relation == 8)
                        兄弟
                    @elseif($order_data->relation == 9)
                        姐妹
                    @elseif($order_data->relation == 10)
                        祖父/祖母/外祖父/外祖母
                    @elseif($order_data->relation == 11)
                        孙子/孙女/外孙/外孙女
                    @elseif($order_data->relation == 12)
                        叔父/伯父/舅舅
                    @elseif($order_data->relation == 13)
                        婶/姨/姑
                        @else
                        侄子/侄女/外甥/外甥女
                    @endif
                        @else
                    --
                        @endif
                </td></tr>
            <tr><td>被保人性别</td><td>
                    @if(substr($detail->code,16,1)%2 == 1)男@else 女@endif
                </td></tr>
            <tr><td>被保人年龄</td><td>{{date('Y',time()) - substr($detail->code,6,4)}}</td></tr>
            <tr><td>投保人联系方式</td><td>{{$detail->user_phone}}</td></tr>
            <tr><td>投保人邮箱</td><td>{{$detail->user_email}}</td></tr>
            <tr><td>客户信息反馈</td><td>产品不满意</td></tr>
            <tr><td>客户评论</td><td>服务态度很好，产品价位调整后很合理</td></tr>
        </table>
    </div>
    @stop