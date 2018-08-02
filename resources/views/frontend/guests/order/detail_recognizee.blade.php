<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>天眼互联-科技让保险无限可能</title>
    <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
    <link rel="stylesheet" href="{{config('view_url.view_url')}}mobile/personal/css/lib/mui.min.css">
    <link rel="stylesheet" href="{{config('view_url.view_url')}}mobile/personal/css/lib/iconfont.css" />
    <link rel="stylesheet" href="{{config('view_url.view_url')}}mobile/personal/css/common.css" />
    <style>
        .division{height: .5rem;line-height: .5rem;padding-left: .4rem;}
        .mui-scroll-wrapper {top: 1.4rem;bottom: 0;background: #f4f4f4;}
        .mui-bar-nav {background: #025a8d;}.applicant-wrapper {background: #fff;}.applicant-partone{padding: 0 .3rem;}
        .applicant-partone li {height: 1rem;line-height: 1rem;position: relative;border-bottom: 1px solid #dcdcdc;}
        .applicant-partone li:last-child{border-bottom: none;}.user-wrapper{padding: 0 .3rem;height: 1.6rem;line-height: 1.6rem;}
        .user-header-img{margin-top: .18rem;width: .62rem;height: .62rem;border-radius: 50%;display: inline-block;margin-right: .2rem;}.user-wrapper li{position: relative;}
        .user-name{display: inline-block;vertical-align: top;}.mui-icon.mui-icon-plusempty{font-size: .6rem;color: #fff;}
        .header-wrapper{padding: 0 .4rem;height: .55rem;line-height: .55rem;background: #fff;color: #adadad;}
        .user-name,.user-sex,.user-id{display: inline-block;}.user-name{width: 1.7rem;}.user-sex{width: 1rem;color: #adadad;}
        .user-id{width: 3.36rem;color: #adadad;}.total{line-height:3;text-align: center;color: #adadad;}
        input[type=checkbox]{visibility: hidden;position: absolute;right: 0;}
        .iconfont{position: absolute;top: 0;right: 0;color: #ffae00;}.buttonbox .btn {background: #ffae00;color: #fff;}
        .btn-small{margin-top: .2rem;width: 1rem;height: .5rem;line-height: .5rem;color: #fff;border: 1px solid #fff;border-radius: 5px;}
        .operation-wrapper{display: none;position: absolute;top: .9rem;right: 0;width: 2.6rem;padding: 0 .2rem;background: #00a2ff;}
        .operation-wrapper>span{position: relative;top: 1px;display: block;height: .83rem;line-height: .83rem;border-bottom: 1px solid #fff;font-size: .32rem;color: #fff;text-align: center;}
        .operation-wrapper>span>a{color: #fff;}
        .iconfont.icon-danxuan1,.buttonbox{display: none;}#cancel{display: none;}
    </style>
</head>

<body>
<div class="main">
    <header class="mui-bar mui-bar-nav">
        <a class="mui-icon mui-icon-back mui-pull-left mui-action-back"></a>
        <h1 class="mui-title">参保人员</h1>
        <div>
            <button id="edite" class="btn-small fr">编辑</button>
            <button id="cancel" class="btn-small fr">取消</button>
        </div>
        <div class="operation-wrapper">
            <span><a href="/order/detail_recognizee_add/{{$data[0]['order_id']}}">添加被保人</a></span>
            <span id="delete">删除被保人</span>
        </div>
    </header>
    <div class="mui-content">
        <div class="header-wrapper">
            <span class="user-name">姓名</span><span class="user-sex">性别</span><span class="user-id">身份证号</span>
        </div>
        <div class="mui-scroll-wrapper">
            <div class="mui-scroll">
                <div>
                    <div>
                        {{--<div class="division">A</div>--}}
                        <div class="applicant-wrapper">
                            <ul class="applicant-partone">
                                @foreach($data as $v)
                                <li>
                                    <div class="user-name">{{$v['name']}}</div>
                                    <div class="user-sex">@if(substr($v['code'],16,1)%2 == 1) 男@elseif(substr($v['code'],16,1)%2 == 0) 女@else -- @endif</div>
                                    <div class="user-id">{{$v['code']}}</div>
                                    <i class="iconfont icon-danxuan1"></i>
                                    <input type="checkbox" />
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="total">共{{count($data)}}位被保人</div>

            </div>
            <div class="buttonbox">
                <button id="deletePerson" class="btn">删除</button>
            </div>
        </div>
    </div>
</div>

<script src="{{config('view_url.view_url')}}mobile/personal/js/lib/jquery-1.11.3.min.js"></script>
<script src="{{config('view_url.view_url')}}mobile/personal/js/lib/mui.min.js"></script>
<script src="{{config('view_url.view_url')}}mobile/personal/js/common.js"></script>
<script>
    var operationStatus;
    $('.applicant-partone>li').on('tap',function(){
        if(operationStatus === 'delete'){
            var status = $(this).find('input').prop('checked');
            if(status){
                $(this).find('input').prop('checked',false);
                $(this).find('.iconfont').removeClass('icon-danxuan2').addClass('icon-danxuan1');
            }else{
                $(this).find('input').prop('checked',true);
                $(this).find('.iconfont').removeClass('icon-danxuan1').addClass('icon-danxuan2');
            }
        }
    });

    var Ele = {
        edite : $('#edite'),
        operationWrapper: $('.operation-wrapper'),
        iconfont : $('.iconfont'),
        muiScrollWrapper: $('.mui-scroll-wrapper'),
        buttonbox : $('.buttonbox')
    }

    Ele.edite.on('tap',function(){
        Ele.operationWrapper.show();
    });
    $('#delete').on('tap',function(){
        operationStatus = 'delete';
        Ele.operationWrapper.hide();
        Ele.iconfont.show();
        Ele.buttonbox.show();
        Ele.edite.hide().next().show();
        Ele.muiScrollWrapper.css({'bottom':'.9rem'})
    });
    $('#cancel').on('tap',function(){
        Ele.iconfont.hide();
        Ele.buttonbox.hide();
        Ele.edite.show().next().hide();
        Ele.muiScrollWrapper.css({'bottom':'0'});
    });
</script>
</body>

</html>