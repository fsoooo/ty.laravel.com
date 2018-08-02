@extends('backend.layout.base')
@section('content')
    <div id="content-wrapper">
                @include('backend.layout.alert_info')
                    <div class="chart-wrapper clearfix">
                        <div class="col1 clearfix">
                            <div class="agent-wrapper section">
                                <div class="agent-mask"></div>
                                <div id="agent" style="width: 100%;height:80%;"></div>
                                <div class="buttons-wrapper">
                                    <button class="btn-wihte">展开</button>
                                    <button class="btn-purple">录入数据</button>
                                </div>
                            </div>
                            <div class="premiumAmount-wrapper section">
                                <div class="agent-mask"></div>
                                <div id="premiumAmount" style="width: 100%;height:80%;"></div>
                                <div class="buttons-wrapper">
                                    <button class="btn-wihte">展开</button>
                                    <button class="btn-purple">录入数据</button>
                                </div>
                            </div>
                        </div>
                        <div class="col2 clearfix">
                            <div class="user-wrapper section">
                                <h4 class="section-title">用户管理</h4>
                                <div class="user-content">
                                    <div class="add-wrapper">
                                        <span class="total">{{$user_count}}</span>
                                        <div class="add"></div>
                                    </div>
                                    <div class="box">新增{{$user_new}}人</div>
                                </div>
                            </div>
                            <?php $brokerage = [];
                            $brokerage["brokerage_wait"] = $brokerage_wait;
                            $brokerage["brokerage_ing"] = $brokerage_ing;
                            $brokerage["brokerage_end"] = $brokerage_end;
                            ?>
                            <div class="commission-wrapper section" >
                                <div id="commission" style="width: 443px;height:296px;" data-options="{{json_encode($brokerage)}}"></div>
                            </div>
                            <div class="order-wrapper section">
                                <h4 class="section-title">订单管理</h4>
                                <div class="section-text">本月新增订单<span>{{count($order_res)}}</span>份</div>
                                <div class="table-wrapper">
                                    <table>
                                        <tr>
                                            <th width="250px">订单编号</th>
                                            <th width="200px">产品名称</th>
                                            <th width="200px">所属公司</th>
                                            <th width="80px">查看详情</th>
                                        </tr>
                                        @if(count($order_res) != 0)
                                            @foreach($order_res as $value)
                                                <tr>
                                                    <td>{{$value['order_code']}}</td>
                                                    <td>{{$value->product->product_name}}</td>
                                                    <td>{{$value->product->company_name}}</td>
                                                    <td><a href="/backend/sales/details/{{$value->id}}">详情</a></td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                暂无订单信息
                                            </tr>
                                        @endif
                                    </table>
                                </div>
                                <a class="btn-wihte" href="/backend/sales/show">查看订单详情</a>
                            </div>
                        </div>
                    </div>
    </div>
@stop

