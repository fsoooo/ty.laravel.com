@extends('frontend.agents.layout.agent_bases')
@section('content')
    <meta name="_token" content="{{ csrf_token() }}"/>
    <style>
        th,td{
            text-align: center;
        }
    </style>
    <div id="content-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <h1>这里是代理人<a href="/agent/">主页</a></h1>
                    </div>
                </div>
                {{--<div class="row">--}}
                    {{--<div class="col-lg-12">--}}
                        {{--<div class="main-box clearfix" style="min-height: 1100px;">--}}
                            {{--<div class="tabs-wrapper tabs-no-header">--}}

                                {{--<div class="tab-content">--}}
                                    {{--<div class="tab-pane fade in active" id="tab-accounts">--}}

                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
            </div>
        </div>
    </div>
@stop

