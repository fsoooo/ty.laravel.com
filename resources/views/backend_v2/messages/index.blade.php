@extends('backend_v2.layout.base')
@section('title')@parent 消息管理 @stop
@section('head-more')
    <link rel="stylesheet" href="{{asset('r_backend/v2/css/message.css')}}" />
@stop
@section('top_menu')
        <div class="nav-top-wrapper fl">
            <ul>
                <li class="active">
                    <a href="javascript:;" >通知</a>
                </li>
            </ul>
        </div>
@stop
@section('main')
<div class="main-wrapper">
    <div class="row">
        <div class="section section-5">
            <div class="col-md-3 col-xs-6" >
                <div class="section-item">
                    <h4 class="title">通知发布量</h4>
                    <div class="num">{{$count}}</div>
                </div>
            </div>
            <div class="col-md-3 col-xs-6" >
                <div class="section-item">
                    <h4 class="title">通知阅读率</h4>
                    <div class="num">{{$percentage}}%</div>
                </div>
            </div>
            {{--<div class="col-md-3 col-xs-6" >--}}
                {{--<div class="section-item">--}}
                    {{--<h4 class="title">短信发布量</h4>--}}
                    {{--<div class="num">90</div>--}}
                {{--</div>--}}
            {{--</div>--}}
            {{--<div class="col-md-3 col-xs-6">--}}
                {{--<div class="section-item">--}}
                    {{--<h4 class="title">短信套餐</h4>--}}
                    {{--<div class="num"><span class="color-primary">10</span>/100</div>--}}
                {{--</div>--}}
            {{--</div>--}}
            {{--<div class="col-md-3 col-xs-6">--}}
                {{--<div class="section-item">--}}
                    {{--<h4 class="title">短信模板</h4>--}}
                    {{--<div class="num">10</div>--}}
                {{--</div>--}}
            {{--</div>--}}
        </div>
    </div>
    <div class="row">
        <div class="section section-5 operation">
            <div class="col-md-3 col-xs-6">
                <button class="section-item" data-toggle="modal" data-target="#noticeModal">发送通知</button>
            </div>
            {{--<div class="col-md-3 col-xs-6">--}}
                {{--<button class="section-item" data-toggle="modal" data-target="#messModal">发送短信</button>--}}
            {{--</div>--}}
            {{--<div class="col-md-3 col-xs-6">--}}
                {{--<button class="section-item">添加模板</button>--}}
            {{--</div>--}}
        </div>
    </div>
    <div class="row">
        <div class="section">
            <div class="col-md-4 col-xs-6">
                <div class="section-item active">通知记录</div>
            </div>
            {{--<div class="col-md-4 col-xs-6">--}}
                {{--<div class="section-item">短信记录</div>--}}
            {{--</div>--}}
            {{--<div class="col-md-4 col-xs-6">--}}
                {{--<div class="section-item">模板内容</div>--}}
            {{--</div>--}}
        </div>
    </div>

    <!--通知记录显示start-->
    <div class="row">
        <div class="ui-table table-single-line">
            <div class="ui-table-header radius">
                <span class="col-md-2">时间</span>
                <span class="col-md-1">收件人</span>
                <span class="col-md-5">通知内容</span>
                <span class="col-md-2">查看率</span>
                <span class="col-md-2 col-one">操作</span>
            </div>
            <div class="ui-table-body">
                <ul>
                    @if($count == 0)
                        <li>未发布消息</li>
                    @else
                        @foreach($data as $v)
                    <li class="ui-table-tr">
                        <div class="col-md-2">{{$v['created_at']}}</div>
                        <div class="col-md-1">
                            @if($v['accept_type'] == 3)
                                代理人
                                @else
                            客户
                                @endif
                        </div>
                        <div class="col-md-5 ellipsis">
                            {{$v->comments[0]['content']}}
                        </div>
                        <div class="col-md-2">{{$v['percentage']}}%</div>
                        <div class="col-md-2 text-right">
                            <a href="/backend/sms/msg_detail/{{$v['id']}}" class="btn btn-primary">查看</a>
                        </div>
                    </li>
                        @endforeach
                        @endif
                </ul>
            </div>
        </div>
    </div>
    <!--通知记录显示end-->

    <!--短信记录显示start-->
    {{--<div class="row">--}}
        {{--<div class="ui-table table-single-line">--}}
            {{--<div class="ui-table-header radius">--}}
                {{--<span class="col-md-2">时间</span>--}}
                {{--<span class="col-md-2">收件人</span>--}}
                {{--<span class="col-md-6">内容</span>--}}
                {{--<span class="col-md-2 col-one">操作</span>--}}
            {{--</div>--}}
            {{--<div class="ui-table-body">--}}
                {{--<ul>--}}
                    {{--<li class="ui-table-tr">--}}
                        {{--<div class="col-md-2">2017-09-21 10:04:56</div>--}}
                        {{--<div class="col-md-2">手冢治虫（18322614787）</div>--}}
                        {{--<div class="col-md-6 ellipsis">感谢您的注册，本次注册验证码为45786，请于3分钟内正确输入，切勿泄露他人。</div>--}}
                        {{--<div class="col-md-2 text-right">--}}
                            {{--<a href="html/message/message_details.html" class="btn btn-primary">查看</a>--}}
                        {{--</div>--}}
                    {{--</li>--}}
                    {{--<li class="ui-table-tr">--}}
                        {{--<div class="col-md-2">2017-09-21 10:04:56</div>--}}
                        {{--<div class="col-md-2">群发（客户）</div>--}}
                        {{--<div class="col-md-6 ellipsis">对于测试产品一的理赔范围描述不清楚，有些描述术语专业性太强…</div>--}}
                        {{--<div class="col-md-2 text-right">--}}
                            {{--<a href="html/message/message_details.html" class="btn btn-primary">查看</a>--}}
                        {{--</div>--}}
                    {{--</li>--}}
                {{--</ul>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}
    <!--短信记录显示end-->

    <!--模板内容显示start-->
    {{--<div class="row">--}}
        {{--<div class="ui-table table-single-line">--}}
            {{--<div class="ui-table-header radius">--}}
                {{--<span class="col-md-2">模板编码</span>--}}
                {{--<span class="col-md-2">模板名称</span>--}}
                {{--<span class="col-md-6">内容</span>--}}
                {{--<span class="col-md-2 col-one">操作</span>--}}
            {{--</div>--}}
            {{--<div class="ui-table-body">--}}
                {{--<ul>--}}
                    {{--<li class="ui-table-tr">--}}
                        {{--<div class="col-md-2">6405</div>--}}
                        {{--<div class="col-md-2">注册验证</div>--}}
                        {{--<div class="col-md-6 ellipsis">感谢您的注册，本次注册验证码为45786，请于3分钟内正确输入，切勿泄露他人。</div>--}}
                        {{--<div class="col-md-2 text-right">--}}
                            {{--<button class="btn btn-primary">发送</button>--}}
                        {{--</div>--}}
                    {{--</li>--}}
                {{--</ul>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}
    <!--模板内容显示end-->
{{--分页--}}
    <div class="row text-center">
        <ul class="pagination">
            {{$data->links()}}
        </ul>
    </div>
</div>

<!--添加模板-->
<div class="modal fade" id="messModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header notitle">
                <button type="button" class="" data-dismiss="modal" aria-label="Close"><i class="iconfont icon-cancel"></i></button>
            </div>
            <div class="modal-body clearfix">
                <div class="fl">
                    <ul class="left-wrapper">
                        <li><span class="name">短信模板</span>
                            <select class="form-control">
                                <option value="">6041 注册验证</option>
                                <option value="">6042 注册验证</option>
                                <option value="">6043 注册验证</option>
                            </select>
                        </li>
                        <li><span class="name">收件人</span><i class="iconfont icon-tianjia"></i></li>
                        <li><span class="name">1</span><input type="text" class="mo"/></li>
                        <li><span class="name">2</span><input type="text"  class="mo"/></li>
                    </ul>
                    <div class="person-select">
                        <div class="select-header">
                            <span class="select-item active">代理人</span>
                            <span class="select-item">客户</span>
                        </div>
                        <div class="select-content">
                            <div class="select-item">
                                <div class="person-list select1">
                                    <ul>
                                        <li>
                                            <label class="all">
                                                <span>全选</span>
                                                <i class="iconfont icon-weixuan"></i>
                                            </label>
                                        </li>
                                        <li>
                                            <label>
                                                <span>张小张</span><span>18322222222</span>
                                                <i class="iconfont icon-weixuan"></i><input hidden type="checkbox" />
                                            </label>
                                        </li>
                                        <li>
                                            <label>
                                                <span>张小张</span><span>18322222222</span>
                                                <i class="iconfont icon-weixuan"></i><input hidden type="checkbox" />
                                            </label>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="select-item" style="display: none;">
                                <div class="person-list select2">
                                    <ul>
                                        <li>
                                            <label class="all">
                                                <span>全选</span>
                                                <i class="iconfont icon-weixuan"></i>
                                            </label>
                                        </li>
                                        <li>
                                            <label>
                                                <span>张小张1</span><span>18322222222</span>
                                                <i class="iconfont icon-weixuan"></i><input hidden type="checkbox" />
                                            </label>
                                        </li>
                                        <li>
                                            <label>
                                                <span>张小张1</span><span>18322222222</span>
                                                <i class="iconfont icon-weixuan"></i><input hidden type="checkbox" />
                                            </label>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <p class="tips">所选人数不得高于短信套餐剩余数</p>
                    </div>
                </div>
                <div class="fr">
                    <span class="name vtop">预览</span>
                    <textarea class="modal-text">感谢您的注册，本次注册验证码为{1}，请于{2}分钟内正确输入，切勿泄露他人。</textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" disabled>确认</button>
            </div>
        </div>
    </div>
</div>

<!--发送通知-->
<div class="modal fade" id="noticeModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header notitle">
                <button type="button" class="" data-dismiss="modal" aria-label="Close"><i class="iconfont icon-cancel"></i></button>
            </div>
            <form id="msg_form" action="/backend/sms/msg_submit" method="post">
                <input type="hidden" name="_token" value="{{csrf_token()}}">
            <div class="modal-body">
                <div class="person">
                    <span>收件人</span>
                    <ul>
                        <li>
                            <label>
                                <span class="iconfont  active">代理人</span>
                                <input hidden type="radio" value="0" checked name="rec"/>
                            </label>
                        </li>
                        <li>
                            <label>
                                <span class="iconfont">客户</span>
                                <input hidden type="radio" value="1" name="rec"/>
                            </label>
                        </li>
                    </ul>
                </div>
                <textarea id="content" name="content"></textarea>
                <div>
                    <span>定时发送</span>
                    <div class="input-group date form_date">
                        <input id="date" style="color: #333;" class="form-control" name="timing" type="text" value="" placeholder="请选择" readonly>
                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                    </div>
                </div>

            </div>
            </form>
            <div class="modal-footer text-right">
                <button id="submit" class="btn btn-primary" disabled>确认</button>
            </div>
        </div>
    </div>
</div>
{{--<script src="{{asset('r_backend/v2/js/lib/jquery-1.11.3.min.js')}}"></script>--}}
{{--<script src="{{asset('r_backend/v2/js/lib/bootstrap.min.js')}}"></script>--}}
<script src="{{asset('r_backend/v2/js/lib/bootstrap-datetimepicker.js')}}"></script>
<!--<script src="js/lib/bootstrap-datetimepicker.min.js"></script>-->
<script src="{{asset('r_backend/v2/js/lib/bootstrap-datetimepicker.zh-CN.js')}}"></script>
<script src="{{asset('r_backend/v2/js/common_backend.js')}}"></script>
<script>
    $('.form_date').datetimepicker({
        language:  'zh-CN',
        weekStart: 1,
        todayHighlight: 1,
        startView: 2,
        forceParse: 0,
        minuteStep: 1,
        startDate: new Date(),
        format: 'yyyy-mm-dd hh:ii:ss'
    }).on('changeSecond',function(){
        isDisable_notice();
        console.log($('#date').val());
    });
    // 监听发送通知确认按钮
    function isDisable_notice(){
        if(!$('#noticeModal textarea').val() || !$('#date').val()){
            $('#noticeModal .modal-footer .btn').prop('disabled',true);
            $("#submit").click(function(){
                $('#msg_form').submit();
            })
        }else{
            $('#noticeModal .modal-footer .btn').prop('disabled',false);
        }
    }
    $(function(){
        $('.modal').on('show.bs.modal', function (e) {
            var target = e.target.id;
            $('.operation .section-item[data-target="#'+ target +'"]').addClass('active');

        });
        $('.modal').on('hide.bs.modal', function (e) {
            $('.operation .section-item').removeClass('active');
        });
        var Ele = {
            notice_add: $('#noticeModal .modal-footer .btn'),
            notice_cont: $('#noticeModal textarea'),
            tmplt_add: $('#messModal .modal-footer .btn'),
            tmplt_item: $('.mo'),
            tmplt_cont: $('.modal-text'),
            tmplt_person: $('.person-select'),
        }

        //************发送通知
        new Check({
            ele: '#noticeModal',
            notCheckedClass: 'not',
            checkedClass: 'active',
        });
        Ele.notice_cont.bind('input propertychange', function() {
            isDisable_notice();
        });


        //************发送短信
        $(".person-list").panel({iWheelStep:32});
        new TabControl('.person-select');
        new Check({
            ele: '.select1',
            type: 1,
            callback: function(){
                isDisable_mess();
            }
        })
        new Check({
            ele: '.select2',
            type: 1,
            callback: function(){
                isDisable_mess();
            }
        });
        update();
        // 收件人选择显隐
        $('.icon-tianjia').click(function(){
            Ele.tmplt_person.fadeIn();
        });
        $('body').on('click',function(e){
            if(!$(e.target).parents('.person-select').length && !$(e.target).is('.icon-tianjia')){
                Ele.tmplt_person.fadeOut();
            }
        });

        // 短信实时预览
        function update(){
            var mes = [];
            Ele.tmplt_item.each(function(index){
                mes.push("{"+ (index+1) +"}");
            });
            var content = Ele.tmplt_cont.text().replace(/\{\d\}/g,"/").split('/');

            Ele.tmplt_item.bind('input propertychange', function() {
                Ele.tmplt_item.each(function(index){
                    var val = $(this).val();
                    val === "" ? mes[index] = "{"+ (index+1) +"}" : mes[index] = val;
                });

                var str = content[0];
                $.each(content, function(index){
                    if(index==content.length-1)return;
                    str += mes[index] + content[index+1];
                });
                Ele.tmplt_cont.text(str);
                isDisable_mess();
            });
        }
        // 监听发送短信确认按钮
        function isDisable_mess(){
            var len = $('.person-select input:checked').length;
            var inputs = false;
            Ele.tmplt_item.each(function(index){
                if(!$(this).val()){return false;}
                if(index == Ele.tmplt_item.length-1){
                    inputs = true;
                }
            });
            if(!len||!inputs){
                Ele.tmplt_add.prop('disabled',true);
            }else{
                Ele.tmplt_add.prop('disabled',false);
            }
        }
    })

</script>
@stop
