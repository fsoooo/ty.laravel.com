<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>天眼互联-科技让保险无限可能</title>
    <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
    <link rel="stylesheet" href="{{config('view_url.view_url')}}mobile/personal/css/lib/mui.min.css">
    {{--<link rel="stylesheet" href="{{config('view_url.view_url')}}mobile/personal/css/lib/mui.picker.all.css">--}}
    <link rel="stylesheet" href="{{config('view_url.view_url')}}mobile/personal/css/lib/iconfont.css" />
    <link rel="stylesheet" href="{{config('view_url.view_url')}}mobile/personal/css/common.css" />
    <link rel="stylesheet" href="{{config('view_url.view_url')}}mobile/personal/css/information.css" />
    <style>
        .mui-bar-nav~.mui-content{padding-top: .9rem;}
        .mui-scroll-wrapper {top: 2.8rem;bottom: 0;}
        .mui-bar-nav {background: #025a8d;}
        .mui-icon-back,.mui-title {color: rgba(255, 255, 255, .8);}
        .mui-pull-right{margin-top: -.2rem;font-size: 1rem!important;color: #fff;}
        .menu-wrapper{height: .88rem;line-height: .88rem;font-size: 0;background: #fff;}
        .menu-wrapper>span{font-size: .26rem;display: inline-block;width: 50%;text-align: center;}
        .menu-wrapper>span.active{position: relative;color: #00A2FF;}
        .menu-wrapper>span.active:after{position: absolute;bottom: .1rem;left: 1.2rem;content: '';width: 1.4rem;height: .06rem;border-radius: 15px;background: #00A2FF;}
        .search-wrapper{position: relative;padding: 0 .6rem;height: 1rem;line-height: 1rem;background: #fff;}
        .search-wrapper .iconfont{position: absolute;left: 0.8rem;top: 0;font-size: .3rem;}
        input[type=text].search{padding-left: .8rem;background: #f4f4f4;border: none;}
        .recognizee-wrapper {padding: .2rem;}
        .recognizee-wrapper li {border-bottom: 1px solid #dcdcdc;}.recognizee-name {font-size: .28rem;font-weight: bold;}.recognizee-name span {margin-left: .48rem;font-size: .24rem;color: #adadad;font-weight: normal;}.recognizee-title {font-size: .28rem;color: #00A2FF;}.recognizee-date {color: #adadad;}.btn-wrapper .btn {width: 1.2rem;}
    </style>
</head>

<body>
<div class="main">
    <header class="mui-bar mui-bar-nav">
        <a class="mui-icon mui-icon-back mui-pull-left mui-action-back"></a>
        <h1 class="mui-title">人员管理</h1>
        <i id="add_staff" class="mui-icon mui-icon-plusempty mui-pull-right"></i>
    </header>
    <div class="mui-content">
        <div class="search-wrapper">
            <i class="iconfont icon-sousuo"></i>
            <input class="search" type="text" placeholder="点击搜索" />
        </div>
        <div class="menu-wrapper">
            <span class="active">现有成员</span>
            <!--<span>待审核成员</span>-->
            <span>已删减成员</span>
        </div>
        <div class="mui-scroll-wrapper">
            <div class="mui-scroll">
                <div class="division"></div>
                <ul class="recognizee-wrapper">
                    @if($count == 0)
                        <li>
                            暂时没有添加人员
                        </li>
                    @else
                        @foreach($data as $k=>$v)
                            <li>
                                <div class="recognizee-name">{{$v->name}}<span></span>
                                    <span><i class="iconfont icon-shenfenzheng"></i>{{$v->phone}}</span>
                                    <span><i class="iconfont icon-shouji"></i>{{$v->code}}</span>
                                </div>
                                <div class="recognizee-operation">
                                    <div class="btn-wrapper fr">
                                        <button class="btn btn-edite" id="{{$v->id}}">删除</button>
                                        <button class="btn btn-delete" id="{{$v->id}}">修改</button>
                                    </div>
                                    <div class="recognizee-title">{{$v->product_name}}</div>
                                    <div class="recognizee-date">{{$v->start_time}}</div>
                                </div>
                            </li>
                        @endforeach
                    @endif
                </ul>
            </div>
        </div>
    </div>
</div>
<input type="hidden" name="_token" value="{{csrf_token()}}">

<script src="{{config('view_url.view_url')}}mobile/personal/js/lib/jquery-1.11.3.min.js"></script>
<script src="{{config('view_url.view_url')}}mobile/personal/js/lib/mui.min.js"></script>
{{--<script src="{{config('view_url.view_url')}}mobile/personal/js/lib/mui.picker.all.js"></script>--}}
<script src="{{config('view_url.view_url')}}mobile/personal/js/common.js"></script>
<script>
    $('.menu-wrapper>span').on('tap',function(){
        $(this).addClass('active').siblings().removeClass('active');
    });
    $("#add_staff").click(function(){
        location.href='/cpersonal/staffadd';
    })
    $('.btn-edite').click(function(){
        var id = $(this).attr('id');
        var _token = $("input[name='_token']").val();
        $.ajax({
            url:'/cpersonal/staff_delete/'+id,
            type:'post',
            data:{_token:_token},
            success:function(res){

            }

        })
    })
</script>
</body>

</html>



















