<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>记录沟通</title>
    <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
    <link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/lib/mui.min.css">
    <link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/lib/iconfont.css" />
    <link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/common_agent.css" />
    <link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/client.css" />
    <link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/record.css" />
    <style>
        .mui-popover{top: initial;left: 0;}
    </style>
</head>

<body>
<header id="header" class="mui-bar mui-bar-nav">
    <a class="iconfont icon-fanhui mui-pull-left mui-action-back"></a>
    <h1 class="mui-title">记录沟通</h1>
</header>
<div id="record">
    <div class="outer-nav">
        <div id="" class="tab-wrapper">
            <a class="active">添加沟通记录</a>
            <a class="" href="/agent_sale/communication">查看沟通记录</a>
        </div>
    </div>
    <div class="outer">
        <div class="mui-control-content mui-active">
            <div  class="mui-scroll-wrapper">
                <div class="mui-scroll">
                    <div class="division"></div>
                    <div class="form-wrapper add-wrapper">
                        <ul>
                            <li id="addClient" class="init-client">
                                <a href="#picture">
                                    <div class="list-img">
                                        <img src="{{config('view_url.agent_mob')}}img/add.png" alt="">
                                    </div>
                                    <span>添加客户</span>
                                    <i class="iconfont icon-gengduo"></i>
                                </a>
                            </li>
                            <li id="addClient" class="import-client" style="display: none;">
                                <a href="#picture">
                                    <div class="list-img">
                                        <img src="{{config('view_url.agent_mob')}}img/boy.png" alt="">
                                    </div>
                                    <span id="client_name" class="name"></span>
                                    <i class="iconfont icon-shanchu1"></i>
                                </a>
                            </li>
                            <li class="init-product">
                                <a href="/agent_sale/search_product">
                                    <div class="list-img">
                                        <img src="{{config('view_url.agent_mob')}}img/add.png" alt="">
                                    </div>
                                    <span>添加产品</span>
                                    <i class="iconfont icon-gengduo"></i>
                                </a>
                            </li>
                            <li class="import-product" style="display: none;">
                                <a href="product_list.html">
                                    <div class="list-img">
                                        <img src="{{config('view_url.agent_mob')}}img/boy.png" alt="">
                                    </div>
                                    <span id="product_name" class="name"></span>
                                    <i class="iconfont icon-shanchu1"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="division"></div>
                    <div class="form-wrapper content-wrapper">
                        <ul>
                            <li>
                                <span class="name">购买意向</span>
                                <div id="startTwo"  class="block clearfix" >
                                    <div class="star_score"></div>
                                    <p style="float:left;"><span class="fenshu">0</span>分</p>
                                    <input hidden type="text" name="grade" value="" />
                                </div>
                            </li>
                            <li>
                                <span class="name">沟通内容</span>
                                <textarea id="content" name="content" placeholder="请输入沟通详情"></textarea>
                            </li>
                        </ul>
                        @if(isset($_GET['communication_id']))
                            <input type="hidden" name="communication_id" value="{{$_GET['communication_id']}}">
                            @endif
                    </div>
                    <div class="button-box">
                        <button id="add" class="zbtn zbtn-default" disabled>添加</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="picture" class="mui-popover mui-popover-action mui-popover-bottom">
    <ul class="mui-table-view">
        <li class="mui-table-view-cell">
            <a class="goTo_list" href="javascript:;">从客户列表选择</a>
        </li>
        <li class="mui-table-view-cell">
            <a class="goTo_person" href="javascript:;">手动添加新客户 </a>
        </li>
    </ul>
    <ul class="mui-table-view">
        <li class="mui-table-view-cell">
            <a href="#picture" class="cannel">取消</a>
        </li>
    </ul>
    <input type="hidden" name="_token" value="{{csrf_token()}}">
</div>
<script src="{{config('view_url.agent_mob')}}js/lib/jquery-1.11.3.min.js"></script>
<script src="{{config('view_url.agent_mob')}}js/lib/mui.min.js"></script>
<script src="{{config('view_url.agent_mob')}}js/lib/startScore.js"></script>
<script src="{{config('view_url.agent_mob')}}js/common_agent.js"></script>
<script>
    @if(isset($_GET['communication_id']))
        sessionStorage.setItem('clientId',JSON.parse({{$data['user_id']}}));
        sessionStorage.setItem('productId',JSON.parse({{$data['ty_product_id']}}));
        $("input[name='grade']").val(JSON.parse({{$data['grade']}}));
        $("#content").html(JSON.parse({{$data['content']}}));
    @endif
    console.log(sessionStorage);
    // 初始化——控制添加/已添加客户产品的显隐
    var clientId = sessionStorage.getItem('clientId'),
            productId = sessionStorage.getItem('productId');
    var _token = $("input[name='_token']").val();
    if(clientId){
        $.ajax({
            url:'/agent_sale/cust_detail/'+clientId,
            type:'post',
            data:{'id' : clientId,'_token':_token},
            success:function(res){
                $("#client_name").html(JSON.parse(res).name);
            }
        });
        $('.import-client').show();
        $('.init-client').hide();
    }
    if(productId){
        $.ajax({
            url:'/agent_sale/product_detail/'+productId,
            type:'post',
            data:{'id' : productId,'_token':_token},
            success:function(res) {
                $('#product_name').html(JSON.parse(res).product_name);
                $('.import-product').show();
                $('.init-product').hide();
            }
        });
    }
    // 跳转列表
    $('.goTo_list').on('tap',function(){
        var frommUrl = window.location;
        sessionStorage.setItem('frommUrl',frommUrl);
        location.href='/agent_sale/search_client';
    });
    $('.goTo_person').on('tap',function(){
        var frommUrl = window.location;
        sessionStorage.setItem('frommUrl',frommUrl);
        location.href='/agent_sale/communication_add_client';
    });
    // 添加客户
    $('#addClient').on('tap',function(){
        mui('#popover').popover('toggle');
    });

    // 购买意向评分
    scoreFun($("#startTwo"),{},function(){
        isDisabled();
    });

    // 按钮是否可点击
    function isDisabled(){
        if($('.import-client').is(':visible') && $('.import-product').is(':visible')){
            $('#add').prop('disabled',false)
        }
    }

    //数据提交
    $("#add").click(function(){
        var grade = $("input[name='grade']").val();
        var content = $("#content").val();
        @if(!isset($_GET['communication_id']))
        $.ajax({
            url:'/agent_sale/communication_add_submit',
            type:'post',
            data:{_token:_token,grade:grade,content:content,client_id:clientId,product_id:productId},
            success:function(res){
                sessionStorage.removeItem('clientId');
                sessionStorage.removeItem('productId');
                sessionStorage.removeItem('frommUrl');
                alert(res['msg']);
                location.href='/agent_sale/communication';
            }
        });
        @else
        var communication_id = $("input[name='communication_id']").val();
        $.ajax({
            url:'/agent_sale/communication_add_submit',
            type:'post',
            data:{_token:_token,communication_id:communication_id,grade:grade,content:content,client_id:clientId,product_id:productId},
            success:function(res){
                sessionStorage.removeItem('clientId');
                sessionStorage.removeItem('productId');
                sessionStorage.removeItem('frommUrl');
                alert(res['msg']);
                location.href='/agent_sale/communication';
            }
        });
        @endif



    })


</script>
</body>
</html>