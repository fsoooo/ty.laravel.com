@extends('frontend.agents.agent_home.base')
@section('content')
    <link rel="stylesheet" href="{{config('view_url.agent_url')}}css/requirement.css" />

    <div>
        <ul class="tab">
            <li><a href="/agent_sale/agent_need">发起需求工单</a></li>
            <li class="active"><a href="/agent_sale/agent_need_lists">我的工单</a></li>
        </ul>
    </div>
    <div class="content">
        <div class="select-wrapper">
            <select class="fr" id="search">
                <option value="0" @if(!isset($_GET['search']) || $_GET['search'] == 0) selected @endif>所有工单</option>
                <option value="1" @if(isset($_GET['search']) && $_GET['search'] == 1) selected @endif>已结束工单</option>
                <option value="2" @if(isset($_GET['search']) && $_GET['search'] == 2) selected @endif>未结束工单</option>
            </select>
        </div>
        <ul class="work-list">
            @foreach($data as $v)
            <li>
                <div class="line1"><span>{{strtok($v['created_at'],' ')}}</span><span>工单编号：{{$v['id']}}</span><a
                            href="/agent_sale/delete_need/{{$v['id']}}"><i data-id="1" class="iconfont icon-delete"></i></a></div>
                <a href="/agent_sale/agent_need_detail/{{$v['id']}}">
                    <div class="line2">
                        <div class="col1"><span>收件人：
                                @if($v['recipient_id'] == 0)
                                    业管
                                    @else
                                天眼后台
                                    @endif
                            </span><span>所属模块：
                                @if($v['module'] == 1)
                                    客户
                                    @elseif($v['module'] == 2)
                                产品
                                @elseif($v['module'] == 3)
                                计划书
                                @elseif($v['module'] == 4)
                                销售业绩
                                @elseif($v['module'] == 5)
                                销售任务
                                @elseif($v['module'] == 6)
                                活动
                                @elseif($v['module'] == 7)
                                消息
                                @elseif($v['module'] == 8)
                                评价
                                @elseif($v['module'] == 9)
                                账户设置
                                    @else
                                    --
                                    @endif
                            </span></div>
                        <div class="col3">
                            @if($v['status'] == 1)
                                已发送
                                @elseif($v['status'] == 2)
                            交流中
                                @elseif($v['status'] == 3)
                            已结束
                                @else
                            --
                                @endif
                        </div>
                        <div class="col2">{{$v['title']}}</div>
                    </div>
                </a>
            </li>
                @endforeach
        </ul>
    </div>
    {{$data->links()}}
    <script>
        $('.icon-delete').click(function(){
            var id = $(this).data('id'); // 删除工单id
        });

        $("#search").change(function(){
            location.href='/agent_sale/agent_need_lists'+'?search='+$('#search').val();
        })
    </script>
    @stop