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
</head>
<body>
<div class="main">
    <header id="header" class="mui-bar mui-bar-nav">
        <a class="iconfont icon-fanhui mui-pull-left mui-action-back"></a>
        <h1 class="mui-title">制作计划书</h1>
    </header>
    <form action="/agent_sale/add_plan_submit" method="post" id="form">
    <div class="mui-content">
        <div class="mui-scroll-wrapper">
            <div class="mui-scroll">
                <div class="form-wrapper">
                    <div class="title">被保人信息</div>
                    <ul class="init-client">
                        <li>
                            <span class="name">姓名</span>
                            <a href="/agent_sale/search_client" class="goTo zbtn zbtn-default">从客户列表导入</a>
                            <a href="javascript:;" class="clearStorage zbtn zbtn-hollow"><i class="iconfont icon-add"></i>添加新客户</a>
                        </li>
                    </ul>
                    <ul class="import-client">
                        <li>
                            <span class="name">姓名</span>
                            <input type="text" value="" id="cust_name" />
                            <a href="javascript:;" class="clearStorage zbtn zbtn-hollow"><i class="iconfont icon-add"></i>添加新客户</a>
                        </li>
                        <li>
                            <span class="name">性别</span>
                            <input type="text" value="" id="cust_sex" readonly/>
                            <a href="/agent_sale/search_client" class="goTo zbtn zbtn-default">重新导入</a>
                        </li>
                        <li>
                            <span class="name">年龄</span>
                            <input type="text" value="" id="cust_age" readonly/>
                        </li>
                    </ul>
                </div>
                <div class="form-wrapper">
                    <div class="title">产品信息</div>
                    <ul class="info init-product">
                        <li>
                            <span class="name">产品名称</span>
                            <a href="/agent_sale/search_product" class="goTo zbtn zbtn-default">从产品列表导入</a>
                        </li>
                    </ul>
                    <ul class="import-product">
                        <li>
                            <span class="name">产品名称</span>
                            <input type="text" value="" readonly id="product_name"/>
                            <a href="/agent_sale/search_product" class="goTo zbtn zbtn-default">重新导入</a>
                        </li>
                        <li class="radioBox">
                            <span class="name">产品期限</span>
                            <input type="text" value="" readonly id="product_date"/>
                        </li>
                        <li class="pickerDate">
                            <span class="name">保险金额</span>
                            <input type="text" value="" id="product_price" readonly/>
                        </li>
                        <li>
                            <span class="name">缴费期限</span>
                            <input type="text" value="" id="product_limit" readonly/>
                        </li>
                        <li>
                            <span class="name">首年保费</span>
                            <input type="text" value="" id="product_first" readonly/>
                        </li>
                    </ul>
                </div>
                <div class="form-wrapper">
                    <div class="title">产品卖点</div>
                    <ul class="points">
                        <li>
                            <i class="iconfont icon-shanchu"></i>
                            <span class="name">卖点一</span>
                            <input type="text" class="selling" placeholder="请输入详细的产品卖点" name='selling[]'/>
                            <i class="iconfont icon-xiugai"></i>
                        </li>
                    </ul>
                    <span id="addPoint" class="zbtn zbtn-hollow center "><i class="iconfont icon-add"></i>添加卖点</span>
                </div>
            </div>
        </div>
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="user" value="">
        <input type="hidden" name="product" value="">
        <input type="hidden" name="mobile" value="1">
        <input type="hidden" name="planName" value="" id="plan_name">
        <div class="button-box">
            <button  id="create" class="zbtn zbtn-default" disabled>生成计划书</button>
        </div>
    </div>
    </form>
</div>

<script src="{{config('view_url.agent_mob')}}js/lib/jquery-1.11.3.min.js"></script>
<script src="{{config('view_url.agent_mob')}}js/lib/mui.min.js"></script>
<script src="{{config('view_url.agent_mob')}}js/lib/mui.picker.all.js"></script>
<script src="{{config('view_url.agent_mob')}}js/common_agent.js"></script>
<script type="text/javascript">
    //			location.reload();
    var clientId = sessionStorage.getItem('clientId'),
            productId = sessionStorage.getItem('productId');
    if(clientId){
        var type = 'client';
        var _token = $("input[name='_token']").val();
        $.ajax({
            url:'/agent_sale/cust_detail/'+clientId,
            type:'post',
            data:{'id' : clientId,'_token':_token},
            success:function(res){
                $('#cust_name').val(JSON.parse(res).name);
                $('#cust_sex').val(JSON.parse(res).sex);
                $('#cust_age').val(JSON.parse(res).age);
            }
        });
        $('.import-client').show();
        $('.init-client').hide();
        $("input[name='user']").val(clientId);
    }
    if(productId){
        var product_type = 'product';
        var product_token = $("input[name='_token']").val();
        $.ajax({
            url:'/agent_sale/product_detail/'+productId,
            type:'post',
            data:{'id' : productId,'_token':product_token},
            success:function(res){
                console.log(JSON.parse(res));
                $('#product_name').val(JSON.parse(res).product_name);
                $('#plan_name').val(JSON.parse(res).product_name);
                if (JSON.parse(res).base_stages_way.replace(/[^0-9]/ig,"") == 0){
                    $("#product_date").val('一年');
                    $("#product_price").val(JSON.parse(res).base_price/100+'元');
                    $("#product_limit").val('趸交');
                    $("#product_first").val(JSON.parse(res).base_price/100+'元');
                }else{
                    $("#product_date").val(JSON.parse(res).base_stages_way);
                    $("#product_price").val(JSON.parse(res).base_price/100+'元');
                    $("#product_limit").val(JSON.parse(res).base_stages_way);
                    $("#product_first").val(JSON.parse(res).base_price/100/JSON.parse(res).base_stages_way.replace(/[^0-9]/ig,"")+'元');
                }

            }
        });
        $('.import-product').show();
        $('.init-product').hide();
        $("input[name='product']").val(productId);
    }
    // 添加卖点
    addPoints('#addPoint');

    var client = $('.import-client').is(':visible');
    var product = $('.import-product').is(':visible');
    var point = $('.points .added').length;

    $('.points li:first-child input').bind('input propertychange', function() {
        if(!$(this).val()){
            $('#create').prop('disabled',true);
        }else{

            if(client&&product){
                $('#create').prop('disabled',false);
            }
        }
    });
//    $('#create').on('tap',function(){
//        console.log('OK');
//        $("input[name='user']").val(client);
//        $("input[name='product']").val(product);
//        var _token = $("input[name='_token']").val();
//        d={};
//        $("input[name='selling']").each(function(i,el){
//            d[el.name] = $(this).val();
//        });
//        console.log()
//        var selling = $('#form').serialize();
//        console.log(selling);
//        $.ajax({
//            url:'/agent_sale/add_plan_submit',
//            type:'post',
//            data:{'user':clientId,'product':productId,'selling':selling,'_token':_token},
//            success:function(res){
//
//            }
//        });
////        window.location.href = 'plan_agent.html';
//    });


    //跳转清除srotage
    $('.clearStorage').click(function(){
        sessionStorage.removeItem('productId');
        location.href = '/agent_sale/make_add';
    })

    $('.goTo').on('tap',function(){
        var frommUrl = window.location;
        sessionStorage.setItem('frommUrl',frommUrl);
    });
    function addPoints(ele,callback){
        $(ele).on('tap',function(){
            if(!$('.points li:last-child input').val()){
                return;
            }

            $('.points .name').hide();
            $('.points input').addClass('added');
            $('.points .iconfont').show();

            var html = '<li>\
						<i class="iconfont icon-shanchu"></i>\
						<span class="name">卖点</span>\
						<input type="text" class="selling" placeholder="请输入详细的产品卖点" name="selling[]" />\
						<i class="iconfont icon-xiugai"></i>\
					</li>';
            $('.points').append(html);
            $('.icon-shanchu').on('tap',function(){
                $(this).parent().remove();
                if(typeof callback === 'function'){
                    callback();
                }
            });

            if(typeof callback === 'function'){
                callback();
            }
        });
    }
</script>
</body>
</html>
