@extends('frontend.guests.person_home.base')
@section('content')
    <link rel="stylesheet" type="text/css" href="{{config('view_url.person_url')}}css/message.css"/>
    <div class="main-content">
        @if($count != 0)
        <div class="search-content clearfix">
            <span>所有消息<span class="fontsize">（共{{$count}}条，未读<span class="cor">{{$unlooked_count}}</span>条）</span></span>
            <div class="search-wrapper">
                <label>
                    <i class="iconfont icon-danxuan1"></i>
                    <input hidden checked type="checkbox" class="checkedC" onclick="Radiochoose(this)"/>
                    <span>只显示未读消息</span>
                </label>
            </div>
        </div>
        <table class="tabel-default">
            <thead>
            <tr>
                <th>
                    <label>
                        <i class="iconfont icon-radio_nor"></i>全选
                    </label>
                </th>
                <th>发送时间</th>
                <th>发件人</th>
                <th>内容</th>
                <th>操作</th>
            </tr>
            </thead>

            <!--暂无消息隐藏tbody-->
            <tbody class="tbodyprcture">
            @foreach($data as $v)
            <tr>
                <td>
                    <label>
                        <input hidden="" type="checkbox" onclick="Radiochoose(this)" value="{{$v['id']}}">
                        <i class="iconfont icon-radio_nor"></i>
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
                    @if($v['status'] != 3)
                    <i class="iconfont icon-weidu iccon" onclick="Radiochoose(this)"></i>
                    @else
                        <i class="iconfont icon-yidu iccon" onclick="Radiochoose(this)"></i>
                    @endif
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
        <div class="nonemessage">
            <div class="mesageicon">
                <i class="iconfont icon-zanwuxiaoxihui"></i>
            </div>
            <div class="mesageicon-text">
                <span>暂无消息</span>
            </div>
        </div>
        @endif
        <div class="leftquar">
            {{--<label>--}}
                {{--<i class="iconfont icon-danxuan1"></i>--}}
                {{--<input hidden checked type="checkbox" class="checkedC" onclick="Radiochoose(this)"/>--}}
                {{--<span>全选</span>--}}
            {{--</label>--}}
            <span class="leftquar-info">删除</span>&nbsp;<span>|</span>&nbsp;<span class="read">标记为已读</span>
        </div>
        <ul class="pagination">
            {{$data->links()}}
        </ul>
    </div>
    <input type="hidden" name="_token" value="{{csrf_token()}}">

    <script src="{{config('view_url.person_url')}}js/lib/jquery-1.11.3.min.js"></script>
    <script src="{{config('view_url.person_url')}}js/common.js"></script>
    {{--<script src="js/lib/xlsx.core.min.js"></script>--}}
    <script>
        var _token = $("input[name='_token']").val();
        //全选不全选的事件
        new Check('.main-content',{
            notCheckedClass: 'icon-radio_nor',
            checkedClass: 'icon-danxuanxuan',
        })


        //单个删除按钮
        $("#delete").click(function(){
            var id = $(this).find('input').val();
            $.ajax({
                url:'/message/delete_one/'+id,
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


        //单选按钮的点击
        function Radiochoose(_this){
            var label = $(_this).parent();
            var icon = label.find('.iconfont');
            if(icon.hasClass('icon-danxuan1')){
                icon.removeClass('icon-danxuan1').addClass('icon-radio_nor');
                _this.checked=false;
                console.log($(_this).prop('checked'));
            }else{
                icon.removeClass('icon-radio_nor').addClass('icon-danxuan1');
                _this.checked=true;
                console.log($(_this).prop('checked'));
            }
        }
        //查看详情
        $('.table-info ').on('click',function(){
            var $this = $(this);
            var $btn = $(this).find('.ta-info-i');
            var id = $(this).find('input').val();
            $.ajax({
                url:'/message/detail/'+id,
                type:'get',
                data:{},
                success:function(res){
                    $this.toggleClass('unfold').hasClass('unfold') ? $btn.html('查看详情<i class="iconfont icon-gengduo" style="color: #00a2ff;"></i>') : $btn.html('收起<i class="iconfont icon-up" style="color: #00a2ff;"></i>');
                }
            });
        });

        //页面最下面的删除和标记为已读的操作
        $('.leftquar-info').click(function(){
            var inputs=$('.tbodyprcture').find('input');
            var _arr=[];
            for (var i = 0; i < inputs.length; i++) {
                if(inputs[i].checked){
                    _arr.push(parseInt(inputs[i].value));
                }
            }
            $.ajax({
                url:'/message/delete',
                type:'post',
                data:{_token:_token,_arr:_arr},
                success:function(res){
                    alert(res['msg']);location.reload();
                }
            })
            console.log(_arr);
        });
        $('.read').click(function(){
            var inputs=$('.tbodyprcture').find('input');
            var _arr=[];
            for (var i = 0; i < inputs.length; i++) {
                if(inputs[i].checked){
                    _arr.push(parseInt(inputs[i].value));
                }
            }
            console.log(_arr);
            $.ajax({
                url:'/message/looked',
                type:'post',
                data:{_token:_token,_arr:_arr},
                success:function(res){
                    alert(res['msg']);location.reload();
                }
            })
            console.log("已读");
        });

        //只显示未读信息
        $('.search-wrapper').click(function(){
            location.href='/message/index'+'?search=unlooked';
        })
    </script>
    @stop