@extends('backend.layout.base')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{asset('r_backend/css/libs/nifty-component.css')}}"/>
@endsection
@section('content')
    <div id="content-wrapper">
        <div class="col-lg-12">
            <div class="row">
                <div class="col-lg-12">
                    <ol class="breadcrumb">
                        <li><a href="{{ url('/backend') }}">主页</a></li>
                        <li><span>销售管理</span></li>
                        <li><span>代理人渠道管理</span></li>
                        <li><span><a href="/backend/sell/ditch_agent/ditches">渠道管理</a></span></li>
                        <li class="active"><span>渠道列表</span></li>
                    </ol>
                </div>
            </div>
            <div class="main-box clearfix">
                <header class="main-box-header clearfix">
                    <h2 class="pull-left">渠道列表</h2>
                    <div class="filter-block pull-right" style="margin-right: 20px;">
                        <button class="md-trigger btn btn-primary mrg-b-lg" data-modal="modal-8">新建渠道</button>
                    </div>
                </header>
                <ul class="nav nav-tabs">
                    <li class="active"><a href="{{ url('backend/sell/ditch_agent/ditches') }}">渠道详情</a></li>
                    <li><a href="{{ url('backend/sell/ditch_agent/agents/'.$id) }}">代理人</a></li>
                    <li><a href="{{ url('backend/sell/ditch_agent/active_products/'.$id) }}">活跃产品</a></li>
                    <li><a href="{{url('backend/task?ditch='.$id)}}">渠道任务</a></li>
                </ul>
                <div class="main-box-body clearfix">
                    <div class="table-responsive">
                        <table class="table user-list table-hover">
                            <tbody>
                            <tr>
                                <td>渠道名称:{{$ditch->name}}</td>
                            </tr>
                            <tr>
                                <td>渠道地址:{{$ditch->address}}</td>
                            </tr>
                            <tr>
                                <td>联系电话: {{$ditch->phone}}</td>
                                {{--<td><button>渠道佣金设置</button></td>--}}
                                <td><a href="{{url('backend/task?ditch='.$id)}}">渠道统计</a></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <hr>
                    <div class="table-responsive">
                    <h2>历史销售记录</h2>

                        <form action='{{url('/backend/sell/ditch_agent/ditch/details/'.$id)}}' method="get">
                            <table>
                                {{--<tr>--}}
                                  {{--<td>时间:</td>--}}
                                    {{--<td style="width: 120px;">--}}
                                        {{--<div id="starttime" class="laydate-icon" id="startDate"></div>--}}
                                        {{--<input hidden type="text" id="designated-time" name="up_time">--}}
                                    {{--</td>--}}
                                    {{--<td>至</td>--}}
                                    {{--<td style="width: 120px;">--}}
                                        {{--<div id="starttim" class="laydate-icon" id="startDate"></div>--}}
                                        {{--<input hidden type="text" id="designated-time" name="end_time">--}}
                                    {{--</td>--}}
                                {{--</tr>--}}
                                {{--<tr>--}}
                                    {{--<td>产品类型: <input type="text" name="type"></td>--}}
                                {{--</tr>--}}
                                <tr>
                                    <td>产 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;品: <input type="text" name="name"></td>
                                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" id="search" value="搜索"></td>
                                </tr>
                            </table>
                        </form>
<br>
                        <table class="table user-list table-hover">
                            <tbody>
                            <th>保单号</th>
                            <th>产品名称</th>
                            <th>产品类型</th>
                            <th>保障时间</th>
                            <th>投保人</th>
                            <th>保费</th>
                            <th>代理人</th>
                            <th>代理人佣金</th>
                            {{--<th>操作</th>--}}
                            @foreach($product as $value)
                                <tr>
                                <td>{{$value->warranty_code}}</td>
                                <td>{{$value->product_name}}</td>
                                <td>
                                    @if($value->insure_type==1)
                                        个险
                                    @else
                                        团险
                                    @endif
                                </td>
                                <td>{{$value->start_time}}</td>
                                <td>{{$value->name}}</td>
                                <td>{{$value->premium}}</td>
                                <td>{{$value->real_name}}</td>
                                <td>{{$value->user_earnings}}</td>
                                {{--<td>查看详情</td>--}}
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{--分页--}}
                        <div style="text-align: center;">
                            {{ $product->links() }}
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="md-modal md-effect-8 md-hide" id="modal-8">
            <div class="md-content">
                <div class="modal-header">
                    <button class="md-close close">×</button>
                    <h4 class="modal-title">渠道添加</h4>
                </div>
                <div class="modal-body">
                    <form role="form" id="add_ditch" action='{{url('backend/sell/ditch_agent/post_add_ditch')}}' method="post">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="exampleInputPassword1">渠道名称</label>
                            <input class="form-control" name="name" placeholder="" type="text">
                        </div>
                        <div class="form-group">
                            <label for="exampleTextarea">渠道类型</label>
                            <select class="form-control" name="type" id="ditch_type">
                                <option value="internal_group">内部分组</option>
                                <option value="external_group">外部合作</option>
                                <option value="son_group">附属公司</option>
                            </select>
                        </div>
                        <div class='code hide'>
                            <div class="form-group">
                                <label for="exampleTextarea">组织机构代码</label>
                                <input class="form-control" name="group_code" placeholder="渠道组织机构代码" type="text">
                            </div>
                            <div class="form-group">
                                <label for="exampleTextarea">信用码</label>
                                <input class="form-control" name="credit_code" placeholder="渠道信用码" type="text">
                            </div>
                            <div class="form-group">
                                <label for="exampleTextarea">联系电话</label>
                                <input class="form-control" name="phone" placeholder="联系电话" type="text">
                            </div>
                            <div class="form-group">
                                <label for="exampleTextarea">联系地址</label>
                                <input class="form-control" name="address" placeholder="联系地址" type="text">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" id="form-submit" class="btn btn-primary">确认提交</button>
                </div>
            </div>
        </div>
        <div class="md-overlay"></div>
    </div>
@stop
@section('foot-js')
    <script src="/r_backend/calendar/js/jquery-1.11.3.min.js"></script>
    <script src="/r_backend/calendar/js/laydate.js"></script>
    <script type="text/javascript">
        laydate({
            elem: '#starttime',
            choose: function(datas) {
                $(this.elem).parent().find('input:hidden').val(datas);
                console.log($(this.elem).parent().find('input:hidden').val())
            }
        });
        laydate({
            elem: '#starttim',
            choose: function(datas) {
                $(this.elem).parent().find('input:hidden').val(datas);
                console.log($(this.elem).parent().find('input:hidden').val())
            }
        });
    </script>
@stop

