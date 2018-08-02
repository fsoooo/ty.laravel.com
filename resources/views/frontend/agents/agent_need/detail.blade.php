@extends('frontend.agents.agent_home.base')
@section('content')
    <link rel="stylesheet" href="{{config('view_url.agent_url')}}css/requirement.css" />
    <div class="content">
        <ul class="crumbs">
            <li><a href="/agent">首页</a><i class="iconfont icon-gengduo"></i></li>
            <li><a href="/agent_sale/agent_need">我的需求</a><i class="iconfont icon-gengduo"></i></li>
            <li><a href="/agent_sale/agent_need_lists">我的工单</a><i class="iconfont icon-gengduo"></i></li>
            <li>工单详情</li>
        </ul>
        <ul class="progress">
            <li class="progress-item active">
                <div class="progress-outer">
                    <div class="progress-inner">1</div>
                </div>
                <div class="progress-text">发起工单</div>
            </li>
            <li class="progress-item active">
                <div class="progress-outer">
                    <div class="progress-inner">2</div>
                </div>
                <div class="progress-text">阅读工单</div>
            </li>
            <li class="progress-item @if($data['status'] >= 2) active @endif ">
                <div class="progress-outer">
                    <div class="progress-inner">3</div>
                </div>
                <div class="progress-text">处理中</div>
            </li>
            <li class="progress-item  @if($data['status'] == 3) active @endif ">
                <div class="progress-outer">
                    <div class="progress-inner">4</div>
                </div>
                <div class="progress-text">处理完成</div>
            </li>
        </ul>
        <div class="work-list-detalis">
            <div class="info">
                <div class="line1"><span>{{strtok($data['created_at'],' ')}}</span><span>工单编号：{{$data['id']}}</span><a
                            href="/agent_sale/delete_need/{{$data['id']}}"><i class="iconfont icon-delete"></i></a></div>
                <div class="line2">
                    <div class="col1"><span>收件人：
                            @if($data['recipient_id'] == 0)
                                业管
                                @elseif($data['recipient_id'] == -1)
                            天眼后台
                                @else
                            --
                                @endif
                        </span><span>所属模块：
                            @if($data['module'] == 1)
                                客户
                            @elseif($data['module'] == 2)
                                产品
                            @elseif($data['module'] == 3)
                                计划书
                            @elseif($data['module'] == 4)
                                销售业绩
                            @elseif($data['module'] == 5)
                                销售任务
                            @elseif($data['module'] == 6)
                                活动
                            @elseif($data['module'] == 7)
                                消息
                            @elseif($data['module'] == 8)
                                评价
                            @elseif($data['module'] == 9)
                                账户设置
                            @else
                                --
                            @endif
                        </span></div>
                    <div class="col2">{{$data['title']}}</div>
                </div>
            </div>
            <div class="text">
                <div style="padding: 10px;">
                    {{$data->comment[0]['content']}}
                </div>
            </div>
        </div>
        <div style="margin: 20px 0;height: 60px; text-align: right;">
            <!--阅读工单进度显示start-->
            <button id="remind" type="button" class="z-btn z-btn-positive" style="width: 160px;">提醒查看工单</button>
            <!--阅读工单进度显示end-->
        </div>
        <div class="work-record-detalis">
            <div class="title">工单记录详情</div>
            <div class="record-list">
                <ul style="padding: 10px;">
                    @foreach($data->comments as $v)
                    <li><span>{{$v['created_at']}}</span>{{$v['content']}}</li>
                        @endforeach
                </ul>
            </div>
            <!--处理完成进度不显示start-->
            <form action="" method="">
            <div class="text">
                <input type="text" name="content" placeholder="输入与收件人沟通的内容进行沟通"/>
                <span id="send" class="z-btn">发送</span>
            </div>
            </form>
            <!--处理完成进度不显示end-->
        </div>
        <!--处理完成进度不显示start-->
        <button id="end_need" class="z-btn z-btn-positive" style="display:block;margin: 120px auto;width: 180px;">结束工单</button>
        <!--处理完成进度不显示end-->
    </div>
    <input type="hidden" name="time" value="{{strtotime($data['created_at'])}}">
    <input type="hidden" name="_token" value="{{csrf_token()}}">
    <input type="hidden" name="detail_id" value="{{$data['id']}}">
    <input type="hidden" name="send_id" value="{{$data['agent_id']}}">
    <input type="hidden" name="recipient_id" value="{{$data['recipient_id']}}">
    <script>
        $(".work-list-detalis .text").panel({iWheelStep: 32});
        $(".work-record-detalis .record-list").panel({iWheelStep: 32});

        var Ele = {
            remind : $('#remind'),
            btn_delete: $('.icon-delete'),
        };

        Ele.remind.click(function(){
            var time = $("input[name='time']").val();
            var time_now = Math.round(new Date().getTime()/1000);
            if (time_now - time <= 86400){
                // 发起工单未满24小时调用
                Mask.alert('发起工单24小时后才能提醒',3);
            }else{
//                 提醒成功之后调用
				var html = '<i class="iconfont icon-chenggong1" style="font-size: 24px;vertical-align: middle;margin-right: 10px;"></i>提醒成功，请耐心等待';
				Mask.alert(html,3);
            }

        });

        $("#send").click(function(){
            var data = $("input[name='content']").val();
            var _token = $("input[name='_token']").val();
            var id = $("input[name='detail_id']").val();
            var send_id = $("input[name='send_id']").val();
            var recipient_id = $("input[name='recipient_id']").val();
            $.ajax({
                url:'/agent_sale/agent_need_chat',
                type:'post',
                data:{_token:_token,data:data,id:id,send_id:send_id,recipient_id:recipient_id},
                success:function(res){
                    if(res['status'] == 200){
                        location.reload();
                    }else{
                        alert(res['msg']);
                    }
                }
            })
        })

        $("#end_need").click(function(){
            var id = $("input[name='detail_id']").val();
            var _token = $("input[name='_token']").val();
            $.ajax({
                url:'/agent_sale/agent_need_end/'+id,
                type:'get',
                data:{_token:_token},
                success:function(res){
                    alert(res['msg']);
                    location.reload();
                }
            })
        });
    </script>
@stop















