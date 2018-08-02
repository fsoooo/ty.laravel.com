<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>天眼互联-科技让保险无限可能</title>
    <link rel="stylesheet" href="{{config('view_url.agent_url')}}css/lib/iconfont.css" />
    <link rel="stylesheet" href="{{config('view_url.agent_url')}}css/common_agent.css" />
</head>
<body>
<!--记录沟通弹出层-->
<div class="popups-wrapper popups-handle popups-record" style="display: block;">
    <div class="popups">
        <div class="popups-title">
            <a href="/agent"><i class="iconfont icon-close"></i></a>
            <div class="select-header">
                <span class="select-item active">添加沟通记录</span>
                <span class="select-item">查看沟通记录</span>
            </div>
        </div>
        <div class="popups-content">
            <div class="content select-content">
                <div class="select-item" style="display: block;">
                    <div class="content">
                        <form action="">
                        <div class="section">
                            <div class="section-title">第一步,选择客户</div>
                            <div class="section-container">
                                <div class="search-outer">
                                    <div class="select-box">
                                        <label>
                                            <i class="iconfont icon-danxuanxuanzhong"></i>个人客户
                                            <input hidden checked type="radio" name="clientType1"/>
                                        </label>
                                        {{--<label>--}}
                                            {{--<i class="iconfont icon-danxuan"></i>企业客户--}}
                                            {{--<input hidden type="radio" name="clientType1"/>--}}
                                        {{--</label>--}}
                                    </div>

                                    <div class="search-wrapper">
                                    <select name="cust_select">
                                    <option value="1">姓名</option>
                                    <option value="2">身份证</option>
                                    <option value="3">手机号</option>
                                    <option value="4">邮箱</option>
                                    {{--<option>别名</option>--}}
                                    </select>
                                    <select class="hide">
                                    <option value="0">公司名称</option>
                                    <option value="1">统一信用代码</option>
                                    <option value="2">组织机构代码</option>
                                    <option value="3">营业执照编码</option>
                                    <option value="4">社会统一代码</option>
                                    </select>
                                    <input name="cust_search" value="" placeholder="搜索客户">
                                    <button id="cust_search" class="z-btn z-btn-default"><i class="iconfont icon-sousuo"></i></button>
                                    </div>
                                </div>
                                {{--<div class="z-btn-hollow reelect">重<br>选</div>--}}

                                <div id="client" class="table-wrapper client-wrapper">
                                    <!--个人客户-->
                                    <ul class="table-header">
                                        <li>
                                            <span class="col1"></span>
                                            <span class="col2">姓名</span>
                                            <span class="col3">性别</span>
                                            <span class="col4">出生日期</span>
                                            <span class="col5">职业</span>
                                            <span class="col6">证件号码</span>
                                            <span class="col7">电话号</span>
                                            <span class="col8">邮箱</span>
                                        </li>
                                    </ul>
                                    <!--企业客户-->
                                    <ul class="table-header hide">
                                        <li>
                                            <span style="width: 35px;height: 10px;"></span>
                                            <span style="width: 120px;">公司名称</span>
                                            <span style="width: 90px;">公司类型</span>
                                            <span style="width: 162px;">公司地址</span>
                                            <span style="width: 120px;">联系人</span>
                                            <span style="width: 120px;">联系方式</span>
                                            <span style="width: 160px;">邮箱</span>
                                        </li>
                                    </ul>
                                    <div class="table-body" style="overflow: hidden;">
                                        <!--个人客户-->
                                        <ul style="top: 0px; position: absolute;">
                                            @if(count($cust) == 0)
                                                <li>暂时没有可添加沟通记录的客户</li>
                                            @else
                                                @foreach($cust as $v)
                                                    <li>
                                            <span class="col1">
                                                <label>
                                                    <input hidden="" type="radio" name="client_id" value="{{$v['id']}}">
                                                    <i class="iconfont icon-duoxuan-weixuan"></i>
                                                </label>
                                            </span>
                                                        @if($v->real_name)
                                                            <span class="col2">{{$v->real_name}}</span>
                                                        @else
                                                            <span class="col2"> -- </span>
                                                        @endif
                                                        @if($v->type == 'user' && $v['code'])
                                                            @if(substr($v['code'],16,1)%2 == 1)
                                                                <span class="col3">男</span>
                                                            @else
                                                                <span class="col3">女</span>
                                                            @endif
                                                        @else
                                                            <span class="col3">--</span>
                                                        @endif
                                                        @if($v->type == 'user' && $v['code'])
                                                            <span class="col4">{{substr($v['code'],6,4)}}年{{substr($v['code'],10,2)}}月</span>
                                                        @else
                                                            <span class="col4">--</span>
                                                        @endif

                                                        @if($v->type == 'user' && $v->occupation)
                                                            <span class="col5"> {{$v->occupation}}</span>
                                                        @else
                                                            <span class="col5"> --</span>
                                                        @endif
                                                        @if($v->code)
                                                            <span class="col6">{{$v->code}}</span>
                                                        @else
                                                            <span class="col6"> -- </span>
                                                        @endif
                                                        @if($v->phone)
                                                            <span class="col7">{{$v->phone}}</span>
                                                        @else
                                                            <span class="col7"> -- </span>
                                                        @endif
                                                        @if($v['email'])
                                                            <span class="col8">{{$v['email']}}</span>
                                                        @else
                                                            <span class="col8"> -- </span>
                                                        @endif
                                                    </li>
                                                @endforeach
                                            @endif
                                        </ul>
                                        <!--企业客户-->
                                        <ul style="top: 0px; position: absolute;" class="hide">
                                            @if($count_company == 0)
                                                <li>暂时没有可以添加纪录的企业客户</li>
                                            @else
                                                @foreach($cust_company as $v)
                                                    <li>
                                                <span style="width: 35px;">
                                                    <label>
                                                        <input hidden type="radio" name="client_id" value="{{$v['id']}}"/>
                                                        <i class="iconfont icon-duoxuan-weixuan"></i>
                                                    </label>
                                                </span>
                                                        @if($v['real_name'])
                                                            <span style="width: 120px;">{{$v['real_name']}}</span>
                                                        @else
                                                            <span style="width: 120px;">--</span>
                                                        @endif
                                                        <span style="width: 90px;">IT行业</span>
                                                        @if($v['address'])
                                                            <span style="width: 162px;">{{$v['address']}}</span>
                                                        @else
                                                            <span style="width: 162px;">--</span>
                                                        @endif
                                                        @if($v->trueFirmInfo['ins_principal'])
                                                            <span style="width: 120px;">{{$v->trueFirmInfo['ins_principal']}}</span>
                                                        @else
                                                            <span style="width: 120px;">--</span>
                                                        @endif
                                                        @if($v->trueFirmInfo['ins_phone'])
                                                            <span style="width: 120px;">{{$v->trueFirmInfo['ins_phone']}}</span>
                                                        @else
                                                            <span style="width: 120px;">--</span>
                                                        @endif
                                                        @if($v['email'])
                                                            <span style="width: 160px;">{{$v['email']}}</span>
                                                        @else
                                                            <span style="width: 160px;">--</span>
                                                        @endif
                                                    </li>
                                                @endforeach
                                            @endif
                                        </ul>
                                        <div style="position:absolute;line-height:0;" class="zUIpanelScrollBox"></div><div style="position:absolute;line-height:0;" class="zUIpanelScrollBar"></div></div>
                                </div>
                            </div>
                        </div>
                        <div class="section">
                            <div class="section-title">第二步,选择产品</div>
                            <div class="section-container">
                                <div class="search-outer">
                                    <div class="search-wrapper">
                                    <select name="product_select">
                                    <option value="1">产品名称</option>
                                    <option value="2">公司名称</option>
                                    <option value="3">产品分类</option>
                                    <option value="4">佣金比率</option>
                                    {{--<option value="5">主险条款</option>--}}
                                    </select>
                                    <input name="product_search" value="" placeholder="搜索产品">
                                    <button class="z-btn z-btn-default"><i class="iconfont icon-sousuo"></i></button>
                                    </div>
                                </div>
                                {{--<div class="z-btn-hollow reelect">重<br>选</div>--}}
                                <div id="product" class="table-wrapper product-wrapper">
                                    <ul class="table-header">
                                        <li>
                                            <span class="col1"></span>
                                            <span class="col2">产品ID</span>
                                            <span class="col3">公司名称</span>
                                            <span class="col4">产品类型</span>
                                            <span class="col5">产品名称</span>
                                            {{--<span class="col6">主险</span>--}}
                                            <span class="col7">佣金比率</span>
                                            <span class="col8">保费</span>
                                        </li>
                                    </ul>
                                    <div class="table-body" style="overflow: hidden;">
                                        <ul style="top: 0px; position: absolute;">
                                            @if($count_product == 0)
                                                <li>暂时没有可以添加记录的产品</li>
                                            @else
                                                @foreach($product_list as $v)
                                                    <li>
                                                <span class="col1">
                                                    <label>
                                                        <input hidden="" type="radio" name="product_id" value="{{$v['ty_product_id']}}">
                                                        <i class="iconfont icon-duoxuan-weixuan"></i>
                                                    </label>
                                                </span>
                                                        <span class="col2">{{$v['id']}}</span>
                                                        <span class="col3">{{$v['company_name']}}</span>
                                                        <span class="col4">{{$v['jsons']['category']['name']}}</span>
                                                        <span class="col5">{{$v['product_name']}}</span>
                                                        {{--<span class="col6">鸿福至尊（分红型）</span>--}}
                                                        <span class="col7">{{$v['rate']['earning']}}%</span>
                                                        <span class="col8">{{$v['base_price']/100}}</span>
                                                    </li>
                                                @endforeach
                                            @endif
                                        </ul>
                                        <div style="position:absolute;line-height:0;" class="zUIpanelScrollBox"></div><div style="position:absolute;line-height:0;" class="zUIpanelScrollBar"></div></div>
                                </div>
                            </div>
                        </div>
                        <div class="section section-record">
                            <div class="section-title">第三步,记录详情</div>
                            <div class="section-container">
                                <div style="margin-bottom: 20px;">
                                    <span class="name">购买意向</span>
                                    <div class="satisfaction-wrapper">
                                        <span class="satisfaction">
                                            <i class="iconfont icon-icon-manyidu"></i>
                                            <i class="iconfont icon-icon-manyidu"></i>
                                            <i class="iconfont icon-icon-manyidu"></i>
                                            <i class="iconfont icon-icon-manyidu"></i>
                                            <i class="iconfont icon-icon-manyidu"></i>
                                        </span>
                                        <span class="score">0分</span>
                                        <input type="hidden" name="grade" value="">
                                    </div>
                                </div>
                                <div>
                                    <span class="name">沟通详情</span>
                                    <textarea id="details" name="content" placeholder="请输入沟通内容"></textarea>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <button id="addRecord" class="z-btn z-btn-positive">添加</button>
                        </form>
                    </div>
                </div>
                <div class="select-item look">
                    <div class="search-outer">
                        <div class="select-box">
                            <label>
                            <i class="iconfont icon-danxuanxuanzhong"></i>个人客户
                            <input hidden checked type="radio" name="clientType2"/>
                            </label>
                            {{--<label>--}}
                            {{--<i class="iconfont icon-danxuan"></i>企业客户--}}
                            {{--<input hidden type="radio" name="clientType2"/>--}}
                            {{--</label>--}}
                        </div>

                        {{--<div class="search-wrapper">--}}
                        {{--<select name="content_cust">--}}
                        {{--<option value="1">姓名</option>--}}
                        {{--<option value="2">身份证</option>--}}
                        {{--<option value="3">手机号</option>--}}
                        {{--<option value="4">邮箱</option>--}}
                        {{--<option>别名</option>--}}
                        {{--</select>--}}
                        {{--<select name="content_company" class="hide">--}}
                        {{--<option value="0">公司名称</option>--}}
                        {{--<option value="1">统一信用代码</option>--}}
                        {{--<option value="2">组织机构代码</option>--}}
                        {{--<option value="3">营业执照编码</option>--}}
                        {{--<option value="4">社会统一代码</option>--}}
                        {{--</select>--}}
                        {{--<input name="content_search" placeholder="搜索客户">--}}
                        {{--<button class="z-btn z-btn-default"><i id="search_content" class="iconfont icon-sousuo"></i></button>--}}
                        {{--</div>--}}
                    </div>

                    <div>
                        <table class="table-hover">
                            <tbody>
                            <thead>
                            <tr>
                                <th width="10%">沟通时间</th>
                                <th width="20%">客户</th>
                                <th width="25%">产品名称</th>
                                <th width="15%">购买意向</th>
                                <th width="30%">记录详情</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($count_data == 0)
                                <tr>
                                    <td>暂时没有添加过沟通记录</td>
                                </tr>
                            @else
                                @foreach($data as $value)
                                    <tr>
                                        <td>{{strtok($value['created_at'],' ')}}</td>
                                        @if($value->user['real_name'])
                                            <td>{{$value->user['real_name']}}</td>
                                        @else
                                            <td>--</td>
                                        @endif
                                        <td>{{$value->product['product_name']}}</td>
                                        <td class="color-positive">{{$value['grade']}}分</td>
                                        <td>{{$value['content']}}
                                            {{--<div class="operation">--}}
                                            {{--<div class="operation-item"><i class="iconfont icon-edit"></i><p>修改</p></div>--}}
                                            {{--<div class="operation-item"><i class="iconfont icon-delete"></i><p>删除</p></div>--}}
                                            {{--</div>--}}
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                            </tbody>
                        </table>
                    </div>
                    {{--分页--}}
                    <ul class="pagination">
                        {{$data->links()}}
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!--成功添加记录沟通弹出层-->
<div class="popups-wrapper popups-success">
    <div class="popups">
        <div class="popups-title">新增沟通记录 <a href="/agent"><i class="iconfont icon-close"></i></a></div>
        <div class="popups-content">
            <i class="iconfont icon-shenqingchenggong"></i>
            <p>添加成功</p>
            <div>
                <button class="z-btn z-btn-positive"><a href="/agent_sale/communication_base">继续添加沟通记录</a></button>
                <button class="z-btn-hollow"><a href="/agent_sale/communication_base">查看已添加沟通记录</a></button>
            </div>
        </div>
    </div>
</div>
<input type="hidden" name="_token" value="{{csrf_token()}}">


<script src="{{config('view_url.agent_url')}}js/lib/jquery-1.11.3.min.js"></script>
<script src="{{config('view_url.agent_url')}}js/common_agent.js"></script>
<script>
    $(".table-body").panel({iWheelStep: 32});
    // 个人或企业客户
    selectData('.select-box','single',function(ele){
        var index = ele.index();
        var con = ele.parents('.select-item');
        if(index === 0){
            con.find('.hide').hide().prev().show();
        }else{
            con.find('.hide').show().prev().hide();
        }
    });
    check();// 多选
    new TabControl('.popups'); // 选项卡


    $('#addRecord').click(function(){
        var _token = $("input[name='_token']").val();
        var client_id = $("input[name='client_id']").val();
        var product_id = $("input[name='product_id']").val();
        var content = $("#details").val();
        var index =  parseFloat($('.satisfaction-wrapper .score').text());
        if(!isChecked('.client-wrapper')){
            Mask.alert('客户未选择，请选择',2);
        }else if(!isChecked('.product-wrapper')){
            Mask.alert('产品未选择，请选择',2);
        }else if(!$('#details').val()){
            Mask.alert('请输入沟通详情',2);
        }else{
            $.ajax({
                url:'/agent_sale/communication_add_submit',
                type:'post',
                data:{_token:_token,client_id:client_id,product_id:product_id,content:content,grade:index},
                success:function(res){
                    if (res['status'] == 200){
                        Popups.close('.popups-handle');
                        Popups.open('.popups-success');
                    }else{
                        alert(res['msg']);
                    }
                }
            })
        }
    });

    // 客户产品至少各选一项
    function isChecked(ele){
        var status = false;
        $(ele).find('input').each(function(){
            if($(this).prop('checked')){
                status = true;
                return false;
            }
        });
        return status;
    }

    // 评分
    $('.satisfaction-wrapper .iconfont').click(function(){
        $(this).prevAll().addClass('icon-manyi').removeClass('icon-icon-manyidu');
        $(this).addClass('icon-manyi').removeClass('icon-icon-manyidu');
        $(this).nextAll().addClass('icon-icon-manyidu').removeClass('icon-manyi');
        var index = $(this).index();
        $(this).parents('.satisfaction-wrapper').find('.score').text((index+1)+'分');
    });

    // 继续添加记录
    $('.popups-success .z-btn-positive').click(function(){
        Popups.close('.popups-success');
        Popups.open('.popups-handle');
    });

    $('.popups-title .icon-close').click(function(){
        window.parent.$(".link-wrapper").hide();
    });

    $('.iconfont .icon-sousuo').click(function(){
        var cust_select = $("input[name='cust_select']").val();
        var cust_search = $("input[name='cust_search']").val();
        var product_select = $("input[name='product_select']").val();
        var product_search = $("input[name='product_search']").val();
        location.href='/agent_sale/communication_base'+ '?cust_select='+cust_select+'&cust_search='+cust_search
        +'&product_select='+product_select+'&product_search='+product_search;
    });

    $("#search_content").click(function(){
        var content_cust =  $("input[name='content_cust']").val();
        var content_search = $("input[name='content_search']").val();
        location.href = '/agent_sale/communication_base'+'?content_cust='+content_cust+'&content_search='+content_search;
    })
</script>
</body>
</html>
