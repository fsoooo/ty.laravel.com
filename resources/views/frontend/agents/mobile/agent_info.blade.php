<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>天眼互联-科技让保险无限可能</title>
    <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
    <link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/lib/mui.min.css">
    <link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/lib/mui.picker.all.css">
    <link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/lib/iconfont.css" />
    <link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/common_agent.css" />
    <link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/make.css" />
    <style type="text/css">
        .mui-content .mui-scroll-wrapper {
            top: .9rem;
            bottom: 0rem;
        }
        /*时间div的样式*/
        .main .mui-content .lineinfo{
            position: relative;
            height: 0.48rem;
            background: #f4f4f4;
            text-align: center;
            line-height: 0.48rem;
            font-size: 0.24rem;
        }
        .main .mui-content .lineinfo i{
            color: #e4e4e4;
        }
        /*内容div的样式*/
        .main .mui-content .contentinfo{
            height: 1.76rem;
            background: #fff;
            padding:.28rem ;
            position: relative;
        }
        .main .mui-content .contentinfo>span:nth-child(1){
            font-size: .28rem;
            color: #313131;
        }
        .main .mui-content .contentinfo .content-s{
            margin-top: .28rem;
            font-size: .24rem;
            color: #959595;
        }

        .main .mui-content .contentinfo .content-s>span:nth-child(1){
            display: inline-block;
            width: 6.2rem;
        }
        .main .mui-content .contentinfo .content-s i{
            display: inline-block;
            font-size: .3rem;
            margin-top: -.2rem;
        }
        /*编辑信息列表的样式*/
        .mask {
            display: none;
            position: absolute;
            background: rgba(0, 0, 0, 0.1);
            top: 0;
            left: 0;
            bottom: 0;
            right: 0;
            z-index: 100;
        }
        /*编辑下面的俩个按钮*/
        .buttonbox,.two-button-box {
            position: fixed;
            bottom: 0;
            width: 100%;
            height: 1rem;
            line-height: 1rem;
            z-index: 100;
            box-shadow: 0px 1px 18px 2px rgba(2, 90, 141, 0.1);
            overflow: hidden;
            background: #fff;
        }
        .two-button-box .zbtn {
            float: left;
            width: 50%;
            height: 1rem;
            line-height: 1rem;
            font-size: .36rem;
            border-radius: 0;
            -moz-border-radius: 0;
            -webkit-border-radius: 0;
            -o-border-radius: 0;

        }
        .mask .iconfont{
            padding: .2rem;
            position: absolute;
            right: .2rem;
            z-index: 101;
            top: 0.5rem;
            font-size: .4rem;
        }
        .zbtn-default {
            background: #00a2ff;
            color: #fff;
        }
        .zbtn-positive {
            background: #fff;
            color: #00A2FF;
            border: 1px solid #00a2ff;
        }
        .zbtn:disabled {
            background: #d8d7d9;
        }
        button:disabled{
            opacity: .6;
        }
        .buttonbox .btn{
            background: #fff;
            color: #00A2FF;
            width: 100%;
            font-size: .32rem;
        }
        .icon-weixuanze{
            color: #fff;
        }
        .icon-queding{
            color: #ffae00;
        }
    </style>
</head>

<body>
<div class="main">
    <header id="header" class="mui-bar mui-bar-nav">
        <a class="iconfont icon-fanhui mui-pull-left mui-action-back"></a>
        <h1 class="mui-title">消息中心</h1>
    </header>
    <div class="mui-content scene">
        <div class="mui-scroll-wrapper">
            <div class="mui-scroll">
                @foreach($data as $v)
                        <!--时间的div-->
                <div class="lineinfo">
                    <i class="iconfont icon-weidu" style="color: #00a2ff;"></i>
                    <span>{{$v['created_at']}}</span>
                    <div class="mask"></div>
                </div>
                <!--内容的div-->
                <div class="contentinfo">
                    <span>
                        @if($v['send_id'] == 0)
                            业管
                        @else
                            其他
                        @endif
                    </span>
                    <a href="/agent_sale/agent_info_detail/{{$v['id']}}">
                        <div class="content-s">
                        <span>
                            {{$v->comments[0]['content']}}
                        </span>
                            <i class="iconfont icon-gengduo"></i>
                        </div>
                    </a>
                    <form id="form" action="" method="post">
                        <div class="mask">
                            <label>
                                <input hidden="" type="radio" name="record[]" value="{{$v['id']}}" onclick="Radiochoose(this);">
                                <i class="iconfont icon-weixuanze"></i>
                            </label>
                        </div>
                    </form>
                </div>
                @endforeach
            </div>
        </div>
        <div class="buttonbox">
            <button class="btn btn-next">编辑&nbsp;<i class="iconfont icon-editing"></i></button>
        </div>
        <div class="two-button-box" style="display: none;">
            <button disabled id="delete" type="button" class="zbtn zbtn-default">删除</button>
            <button disabled id="looked" type="button" class="zbtn zbtn-positive disabled">标记为已读</button>
        </div>
    </div>
</div>
<input type="hidden" name="_token" value="{{csrf_token()}}">

<script src="{{config('view_url.agent_mob')}}js/lib/jquery-1.11.3.min.js"></script>
<script src="{{config('view_url.agent_mob')}}js/lib/mui.min.js"></script>
<script src="{{config('view_url.agent_mob')}}js/lib/mui.picker.all.js"></script>
<script src="{{config('view_url.agent_mob')}}js/common_agent.js"></script>
<script>
    //查看详情的链接跳转
    $('.content-s').click(function(){
        location.href='messagedetail.html';
    });
    //编辑的链接跳转
    $('.btn-next').click(function(){
        $('.mask,.two-button-box').show();
    });
    // 删除修改按钮是否禁用
    $('.mask').click(function(){
        if($('.icon-queding').length){
            $('.two-button-box .zbtn').prop('disabled',false).removeClass('disabled');
        }
    });
    //编辑模态框的单选按钮的点击
    function Radiochoose(_this){
        var label = $(_this).parent();
        var icon = label.find('.iconfont');
        if(icon.hasClass('icon-weixuanze')){
            icon.addClass('icon-queding').removeClass('icon-weixuanze');
            _this.checked=true;
            console.log($(_this).prop('checked'));
        }else{
            icon.removeClass('icon-queding').addClass('icon-weixuanze');
            _this.checked=false;
            console.log($(_this).prop('checked'));
        }
    }
    //删除实现
    $('#delete').click(function(){
        var inputs=$('.mask').find('input');
        var _arr=[];
        var _token = $("input[name='_token']").val();
        for (var i = 0; i < inputs.length; i++) {
            if(inputs[i].checked){
                _arr.push(parseInt(inputs[i].value));
            }
        }
        //删除
        $.ajax({
            url:'/agent_sale/agent_info_delete',
            type:'post',
            data:{_token:_token,_arr:_arr},
            success:function(res){
                if (res['status'] == 200){
                    alert(res['msg']);location.href='/agent_sale/agent_info';
                }else{
                    alert(res['msg']);history.back();
                }
            }
        })
    });
    //标记已读
    $('#looked').click(function(){
        var inputs=$('.mask').find('input');
        var _arr=[];
        var _token = $("input[name='_token']").val();
        for (var i = 0; i < inputs.length; i++) {
            if(inputs[i].checked){
                _arr.push(parseInt(inputs[i].value));
            }
        }
        //标记已读
        $.ajax({
            url:'/agent_sale/change_info_status',
            type:'post',
            data:{_token:_token,_arr:_arr},
            success:function(res){
                if (res['status'] == 200){
                    alert(res['msg']);location.href='/agent_sale/agent_info';
                }else{
                    alert(res['msg']);history.back();
                }
            }
        })
    });




</script>
</body>

</html>