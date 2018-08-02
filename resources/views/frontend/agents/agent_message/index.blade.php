<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta charset="UTF-8">
    <title>天眼互联-科技让保险无限可能</title>
    <link rel="stylesheet" href="{{config('view_url.agent_url')}}css/lib/iconfont.css" />
    <link rel="stylesheet" href="{{config('view_url.agent_url')}}css/common_agent.css" />
    <link rel="stylesheet" type="text/css" href="{{config('view_url.agent_url')}}css/message.css"/>
</head>

<body>
<div class="content">
    <div class="content-inside">
        <!--头部信息-->
        <div class="header-wrapper">
            <div class="header">
                <div class="header-left">
                    <div class="logo">
                        <img src="{{config('view_url.agent_url')}}img/logo.png"/>
                    </div>
                    <div class="welcome">
                        <i class="iconfont icon-chenggong"></i>您好，{{$_COOKIE['agent_name']}}

                        @if($authentication == 0 || $authentication == 1)
                                <!--未认证start-->
                        <div class="exit-wrapper">
                            <div class="exit-top">
                                <div class="avatar">
                                    <img src="{{config('view_url.agent_url')}}img/boy.png" alt="" />
                                </div>
                                <div class="info">
                                    <p class="status">未认证</p>
                                    <a href="/agent/account">实名认证后才可以进行相关操作及查看相关信息，马上去实名<i class="iconfont icon-gengduo"></i></a>
                                </div>
                            </div>
                            <div class="exit-bottom">
                                <a href="/agent/account">我的账户</a>&nbsp;|&nbsp;<span id="btn-exit"><a href="/agent_logout">退出</a></span>
                            </div>
                        </div>
                        <!--未认证end-->
                        @else
                                <!--已认证start-->
                        <div class="exit-wrapper">
                            <div class="exit-top">
                                <div class="avatar">
                                    <img src="{{config('view_url.agent_url')}}img/boy.png" alt="" />
                                </div>
                                <div class="info">
                                    <p class="status has">已认证</p>
                                    {{--<a href="performance.html">本月任务<i class="red">10万</i>元，已完成<i class="black">8万</i>元，本月剩余14天，查看业绩<i class="iconfont icon-gengduo"></i></a>--}}
                                </div>
                            </div>
                            <div class="exit-bottom">
                                <a href="/agent/account">我的账户</a>&nbsp;|&nbsp;<span id="btn-exit"><a href="/agent_logout">退出</a></span>
                            </div>
                        </div>
                        <!--已认证end-->
                        @endif

                    </div>
                    <a href="/agent_sale/agent_info">
                        @if($option == 'index')
                            @if(count($message_data) == 0)
                                <span class="iconfont icon-xinxi"></span>
                            @else
                                <span class="iconfont icon-xinxi have">
                                    <i class="remind">{{count($message_data)}}</i>
                                </span>
                            @endif
                        @endif
                    </a>

                </div>
                <div class="header-right">
                    <ul class="nav-wrapper">
                        <li><a href="/agent">首页</a></li>
                        {{--<li><a href=""></a>活动列表</li>--}}
                        <li><a href="/agent/account">账户设置</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="main clearfix">

            <div class="main-wrapper clearfix">
                <div class="main-content">
                    <div class="search-contents clearfix">
                        <div class="menus">
                            <a href="/agent">首页</a>
                            <i class="iconfont icon-gengduo"></i>
                            <a href="javascript:;">消息中心</a>
                        </div>
                        <div class="search-wrapper-l">
                            {{--<a href="javascript:;" style="padding-right: 35px;">所有消息<i class="remind">1</i></a>--}}
                            {{--<a href="javascript:;" class="line linestyle">系统消息</a>--}}
                            <a href="javascript:;" class="line linestyle">通知<i class="remind1">{{$unlooked_count}}</i></a>
                            {{--<a href="javascript:;" class="line">站内信</a>--}}
                        </div>
                        <div class="search-wrapper">
                            <label>
                                <i class="iconfont icon-danxuan"></i>
                                <input hidden checked type="checkbox" class="checkedC" onclick="Radiochoose1(this)"/>
                                <span>只显示未读消息</span>
                            </label>
                        </div>
                    </div>
                    @if($count != 0)
                    <table class="tabel-default">
                        <thead>
                        <tr>
                            <th>
                                <label>
                                    <i class="iconfont icon-danxuan"></i>全选
                                </label>
                            </th>
                            <th>发送时间</th>
                            <th>发件人</th>
                            <th>内容</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <!--暂无消息隐藏tbody-->
                        <tbody class="tbodymessage">
                        @foreach($data as $v)
                            <tr>
                            <td>
                                <label>
                                    <input hidden="" type="checkbox"  value="{{$v['id']}}">
                                    <i class="iconfont icon-danxuan"></i>
                                </label>
                            </td>
                            <td>{{$v['created_at']}}</td>
                            <td>
                                @if($v['send_id'] == 0)
                                    业管
                                    @else
                                        其他
                                    @endif
                            </td>
                            <td>
                                <i class="iconfont icon-weidu iccon"></i>
                                <span class="table-info unfold">
                                    {{$v->comments[0]['content']}}
                                    <span class="ta-info-i">查看详情<i class="iconfont icon-gengduo">
                                            <input type="hidden" value="{{$v['id']}}">
                                        </i></span>
                                </span>

                            </td>
                            <td><i id="delete" class="iconfont icon-delete">
                                    <input type="hidden" value="{{$v['id']}}">
                                </i></td>
                        </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                    <!--暂无消息的div-->
                    <div class="nonemessage" >
                        <img src="{{config('view_url.agent_url')}}img/消息中心-无消息_03.png"/>
                    </div>
                    @endif
                    <div class="leftquar">
                        <label>
                            {{--<i class="iconfont icon-danxuan"></i>--}}
                            {{--<input hidden checked type="checkbox" class="checkedC" onclick="Radiochoose1(this)"/>--}}
                            {{--<span>全选</span>--}}
                        </label>
                        <span class="leftquar-info">删除</span>&nbsp;<span>|</span>&nbsp;<span class="read">标记为已读</span>
                    </div>
                    <ul class="pagination">
                        {{$data->links()}}
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" name="_token" value="{{csrf_token()}}">
</div>
</body>

<script src="{{config('view_url.agent_url')}}js/lib/jquery-1.11.3.min.js"></script>
<script src="{{config('view_url.agent_url')}}js/common_agent.js"></script>
<script>
    var _token = $("input[name='_token']").val();
    //全选不全选的事件
    new Check('.tabel-default',{
        notCheckedClass: 'icon-danxuan',
        checkedClass: 'icon-danxuanxuanzhong',
    })

    //单个删除按钮
    $("#delete").click(function(){
        var id = $(this).find('input').val();
        $.ajax({
            url:'/agent_sale/agent_info_delete_one/'+id,
            type:'get',
            data:{},
            success:function(res){
                if (res['status'] == 200){
                    alert(res['msg'])
                }else{
                    alert(res['msg'])
                }
                location.reload();
            }
        })
    });

    //单独的俩个单选按钮
    function Radiochoose1(_this){
        var label = $(_this).parent();
        var icon = label.find('.iconfont');
        if(icon.hasClass('icon-danxuan')){
            icon.removeClass('icon-danxuan').addClass('icon-danxuanxuanzhong');
            _this.checked=true;
        }else{
            icon.removeClass('icon-danxuanxuanzhong').addClass('icon-danxuan');
            _this.checked=false;
        }
    }
    //查看详情
    $('.table-info ').on('click',function(){
        var $this = $(this);
        var $btn = $(this).find('.ta-info-i');
        var id = $(this).find('input').val();
        $.ajax({
            url:'/agent_sale/agent_info_looked/'+id,
            type:'get',
            data:{},
            success:function(res){
                $this.toggleClass('unfold').hasClass('unfold') ? $btn.html('查看详情<i class="iconfont icon-gengduo" style="color: #00a2ff;"></i>') : $btn.html('收起<i class="iconfont icon-up" style="color: #00a2ff;"></i>');
            }
        });
    });
    //页面最下面的删除和标记为已读的操作
    $('.leftquar-info').click(function(){
        var inputs=$('.tbodymessage').find('input');
        var _arr=[];
        for (var i = 0; i < inputs.length; i++) {
            console.log(inputs[i].checked)
            if(inputs[i].checked){
                _arr.push(parseInt(inputs[i].value));
            }
        }
        console.log(_arr);
        $.ajax({
            url:'/agent_sale/agent_info_delete',
            type:'post',
            data:{_token:_token,_arr:_arr},
            success:function(res){
                alert(res['msg']);location.reload();
            }
        })
    });

    $('.read').click(function(){
        var inputs=$('.tbodymessage').find('input');
        var _arr=[];
        for (var i = 0; i < inputs.length; i++) {
            console.log(inputs[i].checked)
            if(inputs[i].checked){
                _arr.push(parseInt(inputs[i].value));
            }
        }
        console.log(_arr);
        $.ajax({
            url:'/agent_sale/change_info_status',
            type:'post',
            data:{_token:_token,_arr:_arr},
            success:function(res){
                alert(res['msg']);location.reload();
            }
        })
    });

    //只显示未读信息
    $('.search-wrapper').click(function(){
        location.href='/agent_sale/agent_info'+'?search=unlooked';
    })
</script>


</html>