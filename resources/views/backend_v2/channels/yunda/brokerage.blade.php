@extends('backend_v2.layout.base')
@section('title')@parent 佣金管理 @stop
@section('head-more')
    <link rel="stylesheet" href="{{asset('r_backend/v2/css/brokerage.css')}}" />
@stop

@section('top_menu')
    <div class="nav-top-wrapper fl">
        <ul>
            <li class="active">
                <a>佣金管理</a>
            </li>
        </ul>
    </div>
@stop
@section('main')
    <div id="product" class="main-wrapper">
        <div class="row">
            <div class="ui-table">
                <div class="ui-table-header radius">
                    <span class="col-md-2">产品名称</span>
                    <span class="col-md-2">上架时间</span>
                    <span class="col-md-1">基础保费</span>
                    <span class="col-md-1">默认缴别</span>
                    <span class="col-md-2">系统获益佣金比</span>
                    {{--<span class="col-md-1">设置佣金比</span>--}}
                    <span class="col-md-2">佣金（元）</span>
                    {{--<span class="col-md-2 col-one">操作</span>--}}
                </div>
                <div class="ui-table-body">
                    <ul>
                        @foreach($res as $k => $v)
                            <?php
                            $info = json_decode($v->json, true);
                            ?>
                                    <li class="ui-table-tr">
                                        <div class="col-md-2">{{ $v->product_name }}</div>
                                        <div class="col-md-2">{{ $v->created_at }}</div>
                                        <div class="col-md-1">{{ $info['base_price'] / 100}}元</div>
                                        <div class="col-md-1">{{ $info['base_stages_way'] }}</div>
                                        <div class="col-md-2">{{ $info['base_ratio'] . "%" }}</div>
                                        @if(count($v->brokerages) > 0)
                                            @if($v->brokerages[0]->ditch_id == $input['ditch_id'])
                                                <div class="col-md-1">{{$v->brokerages[0]->rate . "%"}}</div>
                                                <div class="col-md-1">{{ $info['base_price'] / 10000 * $v->brokerages[0]->rate }} 起</div>
                                            @else
                                                <div class="col-md-1">--</div>
                                            @endif
                                        @else
                                            <div class="col-md-1">--</div>
                                        @endif
                                        {{--<div class="col-md-2 text-right">--}}
                                            {{--<button class="btn btn-warning modal{{$k}}" adata-toggle="modal" data-target="#change">佣金设置</button>--}}
                                        {{--</div>--}}
                                    </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        <div class="row text-center">
            <div class="row text-center">
                {{ $res->links() }}
            </div>
        </div>
    </div>
@stop
@section('footer-more')
    <script>
        $('.btn').click(function(){
            var id = $(this).context.classList[2];
            $('.modal.'+ id).modal('show');
        });
        $('.select_top').change(function(){
            $("#sel-top").submit();
        })
    </script>
@stop