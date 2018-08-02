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
                    <li><a href="{{ url('/backend/sell/ditch_agent/ditch/details/'.$id) }}">渠道详情</a></li>
                    <li><a href="{{ url('backend/sell/ditch_agent/agents/'.$id) }}">代理人</a></li>
                    <li><a href="{{ url('backend/sell/ditch_agent/active_products/'.$id) }}">活跃产品</a></li>
                    <li><a href="{{url('backend/task?ditch='.$id)}}">渠道任务</a></li>
                </ul>

                @include('backend.layout.alert_info')
                <div class="main-box-body clearfix">
                    <form action='{{url('/backend/sell/ditch_agent/active_products/'.$id)}}' method="get">
                        <table>
                            <tr>
                                <td>时间 : &nbsp;</td>
                                <td style="width:120px;">
                                   <div id="starttime" class="laydate-icon" id="startDate"></div>
                                    <input hidden type="text" id="designated-time" name="time">
                                </td>
                                <td>&nbsp; <input type="submit" id="search" value="搜索"></td>
                            </tr>

                        </table>
                    </form>
                    <div class="table-responsive">
                        <table class="table user-list table-hover">
                            <thead>
                            <tr>
                                <th><span>产品名称</span></th>
                                {{--<th><span>上架时间</span></th>--}}
                                <th><span>销售数量</span></th>
                                <th><span>销售金额</span></th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($product as $k => $v)
                                <tr>
                                    <td>
                                        {{$v->product_name}}
                                    </td>
                                    <td>
                                        {{$v->count}}
                                    </td>
                                    <td>
                                       {{$v->premium/100}}
                                    </td>
                                    <td>
                                        <a href="{{ url('backend/sell/ditch_agent/product_details/'.$v->id) }}">产品详情</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{--分页--}}
                    <div style="text-align: center;">
{{--                        {{ $product->links() }}--}}
                        {{ $product->appends(['time' => $time])->links() }}
                    </div>
                </div>
            </div>
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
    </script>
@stop

