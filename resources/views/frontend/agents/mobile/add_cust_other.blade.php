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
    <div class="mui-content">
        <form id="form_submit" action="/agent_sale/make_add_other_submit" method="post">
            <input type="hidden" name="_token" value="{{csrf_token()}}">
        <div class="mui-scroll-wrapper">
            <div class="mui-scroll">
                <div class="form-wrapper">
                    <ul>
                        <li class="zbtn-dropdown" data-options='[
                        {"value": "2","text": "妻子"},
                        {"value": "3","text": "丈夫"},
                        {"value": "4","text": "儿子"},
                        {"value": "5","text": "女儿"},
                        {"value": "6","text": "父亲"},
                        {"value": "7","text": "母亲"},
                        {"value": "8","text": "兄弟"},
                        {"value": "9","text": "姐妹"},
                        {"value": "10","text": "祖父/祖母/外祖父/外祖母"},
                        {"value": "11","text": "孙子/孙女/外孙/外孙女"},
                        {"value": "12","text": "叔父/伯父/舅舅"},
                        {"value": "13","text": "婶/姨/姑"},
                        {"value": "14","text": "侄子/侄女/外甥/外甥女"}
                        ]'>
                            <span class="name" style="width: 44%;">被保人是投保人的</span>
                            <input class="mustFill"  style="width: 40%;" type="text" />
                            <input hidden type="text" name="relation" />
                            <i class="iconfont icon-gengduo"></i>
                        </li>
                    </ul>

                </div>
                <div class="form-wrapper">
                    <div class="title">投保人信息</div>
                    <ul>
                        <li>
                            <span class="name">姓名</span>
                            <input class="mustFill" id="otherName" name="toubaoren_name" type="text" placeholder="必填" />
                        </li>
                        <li>
                            <span class="name">手机号码</span>
                            <input class="mustFill" id="otherTel" name="toubaoren_phone" type="tel" maxlength="11" placeholder="必填" />
                        </li>
                        <li>
                            <span class="name">电子邮箱</span>
                            <input class="mustFill" id="otherEmail" name="toubaoren_email" type="email" placeholder="必填" />
                        </li>
                        <li>
                            <span class="name">其他信息</span>
                            <input type="text" name="toubaoren_other" placeholder="投保人其他信息说明" />
                        </li>

                    </ul>
                </div>
                <div class="form-wrapper">
                    <div class="title">被保人信息</div>
                    <ul>
                        <li>
                            <span class="name">姓名</span>
                            <input class="mustFill" name="beibaoren_name" id="selfName" type="text" placeholder="必填" />
                        </li>
                        <li>
                            <span class="name">身份证号</span>
                            <input class="mustFill" id="selfIdCard" name="beibaoren_code" type="number" placeholder="必填" />
                        </li>
                        <li class="radioBox">
                            <span class="name">性别</span>
                            <div class="select-box">
                                <span class="zbtn-select active">女</span>
                                <span class="zbtn-select">男</span>
                            </div>
                            <div class="select-value">
                                <input checked type="radio" value="0" name="sex"/>
                                <input type="radio" value="1" name="sex"/>
                            </div>
                        </li>
                        <li class="pickerDate">
                            <span class="name">出生日期</span>
                            <input class="mustFill" type="text" placeholder="请选择" />
                            <i class="iconfont icon-gengduo"></i>
                            <input hidden class="inputhidden" type="text" name="beibaoren_birthday" />
                        </li>
                        <li>
                            <span class="name">职业</span>
                            <input class="mustFill" type="text" name="beibaoren_occupation" placeholder="必填" />
                        </li>
                        <li>
                            <span class="name">手机号码</span>
                            <input class="mustFill" id="selfTel" name="beibaoren_phone" type="tel" maxlength="11" placeholder="必填" />
                        </li>
                        <li>
                            <span class="name">电子邮箱</span>
                            <input class="mustFill" id="selfEmail" name="beibaoren_email" type="email" placeholder="必填" />
                        </li>
                        <li>
                            <span class="name">其他信息</span>
                            <input type="text" name="beibaoren_other" placeholder="投保人其他信息说明" />
                        </li>

                    </ul>
                </div>
                <div class="form-wrapper form-info">
                    <div class="title">产品信息</div>
                    <ul class="init-product">
                        <li>
                            <span class="name">产品名称</span>
                            <a href="/agent_sale/search_product" class="zbtn zbtn-default">从产品列表导入</a>
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
                            <input type="text" value="一年" readonly/>
                        </li>
                        <li class="pickerDate">
                            <span class="name">保险金额</span>
                            <input type="text" value="" readonly id="product_price"/>
                        </li>
                        <li>
                            <span class="name">缴费期限</span>
                            <input type="text" value="" readonly id="year_limit"/>
                        </li>
                        <li>
                            <span class="name">首年保费</span>
                            <input type="text" value="" id="first_money" readonly/>
                        </li>
                    </ul>
                </div>
                <div class="form-wrapper form-points">
                    <div class="title">产品卖点</div>
                    <ul class="points">
                        <li>
                            <i class="iconfont icon-shanchu"></i>
                            <span class="name">卖点一</span>
                            <input type="text" placeholder="请输入详细的产品卖点" name="selling[]" />
                            <i class="iconfont icon-xiugai"></i>
                        </li>
                    </ul>
                    <span id="addPoint" class="zbtn zbtn-hollow center"><i class="iconfont icon-add"></i>添加卖点</span>
                </div>
            </div>
        </div>
            <input type="hidden" name="product" value="">
            <input type="hidden" name="planName" value="" id="plan_name">
            <input type="hidden" name="ty_product_id" value="" id="ty_product_id">
        </form>
        <div class="button-box">
            <button id="create" class="zbtn zbtn-default">生成计划书</button>
        </div>
    </div>
</div>

<script src="{{config('view_url.agent_mob')}}js/lib/jquery-1.11.3.min.js"></script>
<script src="{{config('view_url.agent_mob')}}js/lib/mui.min.js"></script>
<script src="{{config('view_url.agent_mob')}}js/lib/mui.picker.all.js"></script>
<script src="{{config('view_url.agent_mob')}}js/common_agent.js"></script>
<script>

    // 初始化
    var productId = sessionStorage.getItem('productId');
    if(productId){
        var product_token = $("input[name='_token']").val();
        $.ajax({
            url:'/agent_sale/product_detail/'+productId,
            type:'post',
            data:{'id' : productId,'_token':product_token},
            success:function(res){
                $('#product_name').val(JSON.parse(res).product_name);
                $('#plan_name').val(JSON.parse(res).product_name);
                $('#ty_product_id').val(productId);
                if (JSON.parse(res).base_stages_way.replace(/[^0-9]/ig,'') == 0){
                    $('#year_limit').val('一年');
                    $('#first_money').val(JSON.parse(res).price+'元');
                }else{
                    $('#year_limit').val(JSON.parse(res).base_stages_way);
                    $('#first_money').val(JSON.parse(res).price/JSON.parse(res).base_stages_way.replace(/[^0-9]/ig,'')+'元');
                }
                $('#product_price').val(JSON.parse(res).price+'元');
            }
        });
        $('.import-product').show();
        $('.init-product').hide();
    }
    check();
    selectData('.radioBox','single');
    // 添加卖点
    addPoints('#addPoint',function(){
        check();
        $('input').bind('input propertychange', function() {
            check();
        });
    });

    pickerDate('.pickerDate',function(){
        check();
    });
    dataPicker('.zbtn-dropdown',function(){
        check();
    });

    // 实时监听必填项
    $('input').bind('input propertychange', function() {
        check();
    });
    function check(){
        if(!checkMustFill('.mustFill')|| !productId || !$('.points li:first input').val()){
            $('#create').prop('disabled',true);
        }else{
            $('#create').prop('disabled',false);
        }
    }
    // 点击提交数据
    $('#create').on('tap',function(){
        checkReg();
    });

    function checkReg(){
        if(!checkCorrect($('#otherName'),nameReg) || !checkCorrect($('#otherTel'),telReg) || !checkCorrect($('#otherEmail'),emailReg)
                || !checkCorrect($('#selfName'),nameReg) || !checkCorrect($('#selfTel'),telReg) || !checkCorrect($('#selfEmail'),emailReg)){
            console.log('校验不通过,不提交数据');
        }else{
            $("#form_submit").submit();
            console.log('校验通过,提交数据');
        }
    }

    $('.goTo').on('tap',function(){
        var frommUrl = window.location;
        sessionStorage.setItem('frommUrl',frommUrl);
    });

</script>
</body>
</html>
