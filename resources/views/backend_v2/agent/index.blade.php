@extends('backend_v2.layout.base')
@section('title')@parent 代理人管理 @stop
@section('head-more')
    <link rel="stylesheet" href="{{asset('r_backend/v2/css/agent.css')}}" />
@stop

@section('top_menu')
    @include('backend_v2.agent.top_menu')
    <div class="search-wrapper fr">
        <form action="{{url('/backend/agent/list')}}" method="get">
        @if(isset($request['work_status']))
        <input type="hidden" name="work_status" value="{{$request['work_status']}}">
        @endif
        @if(isset($request['pending_status']))
        <input type="hidden" name="pending_status" value="{{$request['pending_status']}}">
        @endif
        <select class="form-control" name="search_type">
        <option value="agent_name" @if(isset($request['search_type']) && $request['search_type'] == 'agent_name') selected @endif>姓名</option>
        <option value="job_number" @if(isset($request['search_type']) && $request['search_type'] == 'job_number') selected @endif>工号</option>
        </select>
        @if(isset($request['keyword']))
        <input type="text" name="keyword" value="{{$request['keyword']}}" />
        @else
        <input type="text" name="keyword" >
        @endif
        <button class="btn btn-primary"><i class="iconfont icon-sousuo"></i></button>
        </form>
    </div>
@stop
@section('main')
    <div id="agent" class="main-wrapper">
        @if(isset($request['work_status']) && $request['work_status'])
            <div class="row">
                <div class="select-wrapper radius">
                    <div class="form-inline radius">
                        <div class="fr">
                            <button class="btn btn-warning" data-toggle="modal" data-target="#addAgent">新增代理人<i class="iconfont icon-add"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <div class="row">
            <form action="{{url('/backend/agent/list')}}" method="get" id="search_agent">
            <div class="ui-table">
                @if(isset($request['work_status']))
                    <input type="hidden" name="work_status" value="{{$request['work_status']}}">
                @endif
                @if(isset($request['pending_status']))
                    <input type="hidden" name="pending_status" value="{{$request['pending_status']}}">
                @endif
                @if(isset($request['search_type']))
                    <input type="hidden" name="search_type" value="{{$request['search_type']}}">
                @endif
                @if(isset($request['keyword']))
                    <input type="hidden" name="keyword" value="{{$request['keyword']}}">
                @endif
                <div class="ui-table-header radius">
                    <span class="col-md-1">工号</span>
                    <span class="col-md-1">姓名</span>
						<span class="col-md-2">
							<select class="form-control search_agents" name="ditch_id">
                                {{--<option value="" disabled>请选择</option>--}}
                                <option value="0">所有渠道</option>
                                @foreach($ditches as $k => $d)
                                    <option value="{{$d->id}}" @if(isset($request['ditch_id']) && $request['ditch_id'] == $d->id) selected @endif>{{$d->name}}</option>
                                @endforeach
                            </select>
						</span>
						<span class="col-md-2">
							<select class="form-control search_agents" name="certification_status">
                                <option selected value="-1" >实名状态</option>
                                <option value="1" @if(isset($request['certification_status']) && $request['certification_status'] == 1) selected @endif>已实名</option>
                                <option value="0" @if(isset($request['certification_status']) && $request['certification_status'] == 0) selected @endif>未实名</option>
                            </select>
						</span>
                    <span class="col-md-3">客户人数</span>
                    <span class="col-md-3 col-two">操作</span>
                </div>
                <div class="ui-table-body">
                    <ul>
                        <?php $url = ''; ?>
                        @foreach($request as $ak => $av)
                            <?php $url .= $ak . '='. $av . "&"; ?>
                        @endforeach
                        <?php $url = trim($url, '&') ?>
                        @foreach($agents as $k => $a)
                        <li class="ui-table-tr">
                            <div class="col-md-1"> {{$a->job_number}} </div>
                            <div class="col-md-1 color-default"> {{$a->user->name}} </div>
                            <div class="col-md-2"> {{count($a->ditches) ? $a->ditches[0]->name : ''}} </div>
                            @if($a->certification_status)
                                <div class="col-md-2 notReal isReal">
                                    <i class="iconfont icon-shiming"></i>已实名
                                </div>
                            @else
                                <div class="col-md-2 notReal notReal">
                                    <i class="iconfont icon-shiming"></i>未实名
                                </div>
                            @endif
                            <div class="col-md-3 color-default">{{ count($a->customers) }}</div>
                            <div class="col-md-3 text-right">
                                @if(isset($request['work_status']) && $request['work_status'] && !$a->certification_status)
                                <button class="btn btn-warning">提醒实名</button>
                                @endif
                                    <a href="{{url('/backend/agent/agent_info/' . $a->id . '?' .$url)}}"><button class="btn btn-primary" type="button">查看详情</button></a>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            </form>
        </div>
        <div class="row" style="text-align: center">
            {{ $agents->appends([
            'work_status' => isset($request['work_status'])&& !is_null($request['work_status'])?$request['work_status']:NULL,
            'pending_status'=>isset($request['pending_status'])&& !is_null($request['pending_status'])?$request['pending_status']:NULL,
            'ditch_id'=>isset($request['ditch_id'])&& !is_null($request['ditch_id'])?$request['ditch_id']:NULL,
            'certification_status'=>isset($request['certification_status'])&& !is_null($request['certification_status'])?$request['certification_status']:NULL,
            ])->links() }}
        </div>
    </div>

    <form class="form-horizontal" action="{{url('/backend/agent/add_agent_post')}}" method="post" id="add-agent-form">
        <input type="hidden" name="add_agent_ditch_id" id="add_agent_ditch_id" value="0">
        {{ csrf_field() }}
    <div class="modal fade" id="addAgent" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-step-one" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="" data-dismiss="modal" aria-label="Close"><i class="iconfont icon-guanbi"></i></button>
                    <h4 class="modal-title">新增代理人</h4>
                </div>
                <div class="modal-body">
                        <div class="form-group">
                            <div class="col-sm-12">
                                <input type="text" class="form-control" placeholder="姓名" name="name">
                            </div>
                        </div>
                        {{--<div class="form-group">--}}
                            {{--<div class="col-sm-12">--}}
                                {{--<input type="text" class="form-control" placeholder="手机号" name="phone">--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<div class="form-group">--}}
                            {{--<div class="col-sm-12">--}}
                                {{--<input type="text" class="form-control" placeholder="邮箱" name="email">--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        <div class="form-group">
                            <div class="col-sm-12">
                                <input id="tel" type="text" class="form-control" maxlength="11" placeholder="手机号" name="phone">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <input id="email" type="text" class="form-control" placeholder="邮箱" name="email"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <input type="text" class="form-control" placeholder="工号" name="job_number">
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button id="add" type="button" class="btn btn-primary" disabled>下一步</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addStepTwo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-step-two" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="" data-dismiss="modal" aria-label="Close"><i class="iconfont icon-guanbi"></i></button>
                    <h4 class="modal-title">新增代理人</h4>
                </div>
                <div class="modal-body">
                    <div class="title">选择渠道</div>
                    <div class="agent-info">
                        <ul>
                            @foreach($ditches as $dk => $dv)
                                <li @if(count($dv->agents)>=15) class="disabled" @endif ditch_id="{{$dv->id}}">{{$dv->name}}<span class="fr">{{count($dv->agents)}}/15</span></li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="form-horizontal">
                        <div class="title">新建一个渠道</div>
                        <input type="text" class="form-control" placeholder="渠道名称" id="ditch_name" maxlength="30">
                        <button type="button" id="addChannelName" class="btn btn-primary" disabled>添加</button>
                        <span style="display:none;color: red" id="add-ditch-error">渠道名称已存在</span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="last" type="button" class="btn btn-warning">上一步</button>
                    <button id="finish" type="button" class="btn btn-primary" disabled>完成</button>
                </div>
            </div>
        </div>
    </div>
    </form>
@stop
@section('footer-more')
    <script src="{{asset('r_backend/v2/js/agent.js')}}"></script>
    <script>
        $('#addAgent input').bind('input propertychange', function() {
            document.getElementById('add').disabled = !checkMustFill('#addAgent input');
        });
        $(".search_agents").change(function(){
            $("#search_agent").submit();
        });
        $("#finish").click(function(){
            $("#add-agent-form").submit();
        })
    </script>
@stop