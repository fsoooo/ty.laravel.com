@extends('backend_v2.layout.base')
@section('title')@parent 佣金管理 @stop
@section('head-more')
    <link rel="stylesheet" href="{{asset('r_backend/v2/css/brokerage.css')}}" />
@stop

@section('top_menu')
    @include('backend_v2.brokerage.top_menu')
@stop
@section('main')
    <div id="product" class="main-wrapper">
        <div class="row">
            <div class="select-wrapper radius">
                <form role="form" class="form-inline radius" id="sel-top" action="{{url('/backend/set_brokerage/agent_brokerage')}}">
                    <div class="form-group">
                        <div class="select-item">
                            <label for="name">产品类型:</label>
                            <select class="form-control select_top" name="ty_product_id">
                                <option value="0">全部产品</option>
                                @foreach($products as $k => $v)
                                    <option value="{{$v->ty_product_id}}" @if(isset($input['ty_product_id']) && $input['ty_product_id'] == $v->ty_product_id) selected @endif>
                                        {{$v->product_name}}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="select-item">
                            <label for="name">选择渠道:</label>
                            <select class="form-control select_top" id="select_ditch" name="ditch_id">
                                {{--<option value="0">全部渠道</option>--}}
                                @foreach($ditches as $k => $v)
                                    <option value="{{$v->id}}" @if(isset($input['ditch_id']) && $input['ditch_id'] == $v->id) selected @endif>
                                        {{$v->name}}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="select-item">
                            <label for="name">选择代理人:</label>
                            <select class="form-control select_top" id="select_agent" name="agent_id">
                                @foreach($agents as $k => $v)
                                    <option value="{{$v->id}}" @if(isset($input['agent_id']) && $input['agent_id'] == $v->id) selected @endif>
                                        {{$v->user->name}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="ui-table">
                <div class="ui-table-header radius">
                    <span class="col-md-2">产品名称</span>
                    <span class="col-md-2">上架时间</span>
                    <span class="col-md-1">基础保费</span>
                    <span class="col-md-1">默认缴别</span>
                    <span class="col-md-2">系统获益佣金比</span>
                    <span class="col-md-1">设置佣金比</span>
                    <span class="col-md-1">佣金（元）</span>
                    <span class="col-md-2 col-one">操作{{$input['agent_id']}}</span>
                </div>
                <div class="ui-table-body">
                    <ul>
                        @if(!$input['agent_id'])
                            <li>无该渠道相关的代理人信息！</li>
                        @else
                            @foreach($res as $k => $v)
                                <?php
                                $info = json_decode($v->json, true);
                                ?>
                                @if(isset($input['ditch_id']) && $input['ditch_id']>0)
                                    <li class="ui-table-tr">
                                        <div class="col-md-2">{{ $v->product_name }}</div>
                                        <div class="col-md-2">{{ $v->created_at }}</div>
                                        <div class="col-md-1">{{ $info['base_price'] / 100}}元</div>
                                        <div class="col-md-1">{{ $info['base_stages_way'] }}</div>
                                        <div class="col-md-2">{{ $info['base_ratio'] . "%" }}</div>
                                        @if(count($v->brokerages) > 0)
                                            {{--@foreach($v->brokerages as $bk => $bv)--}}
                                            @if($v->brokerages[0]->ditch_id == $input['ditch_id'])
                                                <div class="col-md-1">{{$v->brokerages[0]->rate . "%"}}</div>
                                                <div class="col-md-1">{{ $info['base_price'] / 10000 * $v->brokerages[0]->rate }} 起</div>
                                            @else
                                                <div class="col-md-1">暂未设置</div>
                                                <div class="col-md-1">--</div>
                                            @endif
                                            {{--@endforeach--}}
                                        @else
                                            <div class="col-md-1">暂未设置</div>
                                            <div class="col-md-1">--</div>
                                        @endif
                                        <div class="col-md-2 text-right">
                                            <button class="btn btn-warning modal{{$k}}" adata-toggle="modal" data-target="#change">佣金设置</button>
                                        </div>
                                    </li>
                                @else
                                    {{--@foreach($ditches as $dk => $dv)--}}
                                    {{--<li class="ui-table-tr">--}}
                                    {{--<div class="col-md-2">{{ $v->product_name }}</div>--}}
                                    {{--<div class="col-md-2">{{ $v->created_at }}</div>--}}
                                    {{--<div class="col-md-1">{{ $info['base_price'] / 100}}元</div>--}}
                                    {{--<div class="col-md-1">{{ $info['base_stages_way'] }}</div>--}}
                                    {{--<div class="col-md-2">{{ $info['base_ratio'] . "%" }}</div>--}}
                                    {{--@if(count($v->brokerages) > 0)--}}
                                    {{--@if($v->brokerages[0]->ditch_id == $dv->id)--}}
                                    {{--<div class="col-md-1">{{$v->brokerages[0]->rate . "%"}}</div>--}}
                                    {{--<div class="col-md-1">{{ $info['base_price'] / 10000 * $v->brokerages[0]->rate }} 起</div>--}}
                                    {{--@else--}}
                                    {{--<div class="col-md-1">暂未设置</div>--}}
                                    {{--<div class="col-md-1">--</div>--}}
                                    {{--@endif--}}
                                    {{--@else--}}
                                    {{--<div class="col-md-1">暂未设置</div>--}}
                                    {{--<div class="col-md-1">--</div>--}}
                                    {{--@endif--}}
                                    {{--<div class="col-md-2 text-right">--}}
                                    {{--<button class="btn btn-warning modal{{$k}}" adata-toggle="modal" data-target="#change">佣金设置</button>--}}
                                    {{--</div>--}}
                                    {{--</li>--}}
                                    {{--@endforeach--}}
                                @endif
                            @endforeach
                        @endif
                    </ul>
                </div>
            </div>
        </div>

        <div class="row text-center">
            {{ $res->appends([
            'ty_product_id' => isset($input['ty_product_id'])?$input['ty_product_id']:NULL,
            'ditch_id'=>isset($input['ditch_id'])?$input['ditch_id']:NULL,
            'agent_id'=>isset($input['agent_id'])?$input['agent_id']:NULL,
            ])->links() }}
        </div>
    </div>
    @foreach($res as $k => $v)
        <?php
        $info = json_decode($v->json, true);
        $p_brokerage = $info['brokerage'];

        ?>
    <div class="modal fade modal{{$k}}" id="change" role="dialog" aria-labelledby="myModalLabel">
        <form action="{{url('/backend/set_brokerage/set_brokerage_post')}}" method="post">
            <div class="modal-dialog modal-borkerage" role="document">
                <div class="modal-content">
                    <div class="modal-header notitle">
                        <button type="button" class="" data-dismiss="modal" aria-label="Close"><i class="iconfont icon-cancel"></i></button>
                    </div>
                    <div class="modal-body">
                        <table>
                            <tr>
                                <th width="96px">缴别</th>
                                <th width="176px">系统收益佣金比</th>
                                <th width="76px">设置佣金比</th>
                            </tr>
                            @foreach($p_brokerage as $bk => $bv)
                                @if(count($v->brokerages))
                                    @foreach($v->brokerages as $dk => $dv)
                                        @if($dv->by_stages_way == $bv['by_stages_way'] . $bv['pay_type_unit'])
                                            <tr>
                                                <td>{{$bv['by_stages_way'] . $bv['pay_type_unit']}}</td>
                                                <td>{{ $bv['ratio_for_agency'] . '%'}}</td>
                                                <td>
                                                    <input type="text" name="brokerage[]" value="{{$dv->rate}}" >%
                                                    <input class="ditch-id" name="ditch_id[]" type="hidden" value="{{ $dv->ditch_id }}">
                                                    <input class="ditch-id" name="agent_id[]" type="hidden" value="{{ $dv->agent_id }}">
                                                    <input class="by-stages-way" name="by_stages_way[]" type="hidden" value="{{$bv['by_stages_way'].$bv['pay_type_unit']}}">
                                                    <input type="hidden" name="ty_product_id[]" value="{{$v->ty_product_id}}">
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                @else
                                    <tr>
                                        <td>{{$bv['by_stages_way'] . $bv['pay_type_unit']}}</td>
                                        <td>{{ $bv['ratio_for_agency'] . '%'}}</td>
                                        <td>
                                            <input type="text" name="brokerage[]" value="" >%
                                            <input class="ditch-id" name="ditch_id[]" type="hidden" value="{{ $input['ditch_id'] }}">
                                            <input class="ditch-id" name="agent_id[]" type="hidden" value="{{ $input['agent_id'] }}">
                                            <input class="by-stages-way" name="by_stages_way[]" type="hidden" value="{{$bv['by_stages_way'].$bv['pay_type_unit']}}">
                                            <input type="hidden" name="ty_product_id[]" value="{{$v->ty_product_id}}">
                                        </td>

                                    </tr>
                                @endif

                            @endforeach
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button id="btn-yes" class="btn btn-primary">确定修改</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    @endforeach
@stop
@section('footer-more')
    <script>
        $('.btn').click(function(){
            var id = $(this).context.classList[2];
            $('.modal.'+ id).modal('show');
        });
        $('.select_top').change(function(){
            var type = $(this).attr('id');
            if(type == 'select_ditch'){
                $('#select_agent').remove();
            }
            $("#sel-top").submit();
        })
    </script>
@stop