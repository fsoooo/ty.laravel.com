@extends('frontend.guests.company_home.base')
@section('content')
    <link rel="stylesheet" href="{{config('view_url.company_url').'css/lib/paging.css'}}" />
    <style>
        .main-content {
            padding: 20px 30px;
            background: #fff;
            padding-right: 100px;
        }
        .order-code{
            height: 30px;
            line-height: 30px;
        }
        .guarantee-wrapper .table-left,
        .guarantee-wrapper .table-right {
            float: left;
        }

        .guarantee-wrapper .table-left {
            width: 350px;
        }

        .guarantee-wrapper .table-right {
            width: 570px;
            height: 214px;
        }

        .guarantee-wrapper table tr {
            height: 40px;
        }

        .guarantee-wrapper table {
            border-collapse: separate;
            border-spacing: 2px;
        }

        .guarantee-wrapper table td:first-child {
            width: 120px;
            background: #d8d7d9;
            text-align: center;
        }

        .guarantee-wrapper table td:last-child {
            padding-left: 20px;
            background: #f4f4f4;
        }

        .guarantee-wrapper .table-right tr {
            height: 200px;
        }

        .date {
            margin: 0 40px;
        }

        .order-code {
            padding: 0 10px;
            margin-bottom: 60px;
            background: #f4f4f4;
        }

        .total {
            margin-left: 100px;
            height: 36px;
            line-height: 36px;
        }

        .table-wrapper {
            padding: 20px;
            height: 872px;
            background: #fff;
        }

        .table-address {
            width: 100%;
            margin: 4px 0 30px;
            border: 1px solid #d8d7d9;
            text-align: center;
        }
        .search {
            position: relative;
        }
        .table-address th {
            color: #fff;
            background: #00a2ff;
        }

        .table-address tr {
            height: 60px;
            border-bottom: 1px solid #d8d7d9;
        }

        .table-address td {
            position: relative;
        }

        .table-address .btn-edite {
            margin-right: 6px;
        }

        .major {
            margin-left: 50px;
        }


        .search .iconfont {
            position: absolute;
            top: 4px;
            left: 6px;
            font-size: 26px;
            color: #e5e5e5;
        }
        .search input{
            width: 370px;
            padding-left: 40px;
            background: #F4F4F4;
            border-radius: 5px;
            border-color: #F4F4F4;
        }
        .btn-add{
            margin-right: 10px;
        }
        .order-rights li{
            line-height: 24px;
        }
        .order-rights li:nth-child(odd){
            background: rgba(0, 162, 255, .05);
        }
    </style>
    <div class="main-content">
        <div class="crumbs-wrapper">
            <a href="">已生效保单</a><i class="iconfont icon-gengduo"></i>
            <span>保单详情</span>
        </div>
        <div class="major">
            <div class="guarantee-wrapper clearfix">
                <table class="table-left" cellspacing="5" cellpadding="5">
                    <tr>
                        <td>保险名称</td>
                        <td>{{$data->product['product_name']}}</td>
                    </tr>
                    <tr>
                        <td>保障时间</td>
                        <td>{{strtok($data->warranty_rule->warranty['start_time'],' ')}}至{{strtok($data->warranty_rule->warranty['end_time'],' ')}}</td>
                    </tr>
                    <tr>
                        <td>保险分类</td>
                        <td>{{$data->product['json']['category']['name']}}</td>
                    </tr>
                    <tr>
                        <td>保险状态</td>
                        <td>
                            @if($data->warranty_rule->warranty['status'] == 0)
                                待生效
                                @elseif($data->warranty_rule->warranty['status'] == 1)
                                保障中
                                @elseif($data->warranty_rule->warranty['status'] == 2)
                                失效
                                @else
                                退保
                                @endif
                        </td>
                    </tr>
                    <tr>
                        <td>保费</td>
                        <td>{{$data->warranty_rule->warranty['premium']/100}}元</td>
                    </tr>
                </table>
                <table class="table-right">
                    <tr>
                        <td width="120px">保障权益</td>
                        <td>
                            <ul class="">
                                @if(isset($data->order_parameter))
                                    @foreach($data->order_parameter as $it => $item)
                                        @php $items = json_decode($item['parameter'],true); @endphp
                                        @php $protect_item = json_decode($items['protect_item'],true); @endphp
                                        @foreach($protect_item as $key => $val)
                                            <li>{{$val['name']}} {{$val['defaultValue']}}</li><br>
                                        @endforeach
                                    @endforeach
                                @else
                                    <li>暂无数据</li>
                                @endif
                            </ul>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="order-code">保单号：{{$data->warranty_rule->warranty['warranty_code']}}<span class="date">发起时间：{{strtok($data->warranty_rule->warranty['created_at'],' ')}}</span>
                @if(is_null($data->agent))

                    @else
                VIP专员：{{$data->agent->user['real_name']}}
                    @endif
            </div>
            <div>
                {{--<div class="fr"><button class="btn btn-add">添加</button><button class="btn red">删除</button></div>--}}
                <div class="search">
                    <i class="iconfont icon-sousuo"></i>
                    <input type="text" placeholder="请输入要搜索的姓名"/>
                    <button class="btn btn-ffae00">搜索</button>
                </div>
            </div>
            <table class="table-address">
                <thead>
                <tr>
                    <th width="60px"><input id="allSelect" type="checkbox" />全选</th>
                    <th width="60px">编号</th>
                    <th width="40px">被保人</th>
                    <th width="200px">身份证</th>
                    <th width="120px">手机号</th>
                    <th width="10px">操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach($data->warranty_recognizee as $v)
                <tr>
                    <td><input type="checkbox" /></td>
                    <td>{{$v['id']}}</td>
                    <td>{{$v['name']}}</td>
                    <td>{{$v['code']}}</td>
                    <td>{{$v['phone']}}</td>
                    <td>
                        {{--<button class="btn btn-edite">修改</button>--}}
                        <button value="{{$v['id']}}" class="btn-del red">删除</button>
                    </td>
                </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="paging-wrapper">
                <div class="total fr">在保人数：&nbsp;{{count($data->warranty_recognizee)}}人</div>
                <div id="pageToolbar"></div>
            </div>
        </div>
    </div>
    <script src="{{config('view_url.company_url').'js/lib/paging.js'}}"></script>
    <script type="text/javascript">
        $('.btn-del').click(function(){
            var id = $(this).val();
            $.ajax({
                url:'/staff/passStaff/'+id,
                type:'get',
                data:{data:'done'},
                success:function(res){
                    Mask.alert(res.msg);
                }
            })
        })
    </script>
    @stop