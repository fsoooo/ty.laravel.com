<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta charset="UTF-8">
    <title>天眼互联-科技让保险无限可能</title>
    <link rel="stylesheet" href="{{config('view_url.pc_group_ins')}}css/lib/iconfont.css" />
    <link rel="stylesheet" href="{{config('view_url.pc_group_ins')}}css/lib/swiper-3.4.2.min.css" />
    <link rel="stylesheet/less" href="{{config('view_url.pc_group_ins')}}css/index.less" />
    <link rel="stylesheet" href="{{config('view_url.pc_group_ins')}}css/productdetail.css" />
    <link rel="stylesheet/less" href="{{config('view_url.view_url')}}css/details.less" />
    <script src="{{config('view_url.pc_group_ins')}}js/lib/less.min.js"></script>
    <style>
        select{height: 30px;color: #888888;border: 0.1px solid #D0D0D0;margin-right: 15px}
    </style>
</head>
<body>
<div class="contents">
    <div class="contents-inside">
        <!--头部信息-->
        <div class="header">
            <div class="header-wrapper">
                <div class="header-top clearfix">
                    <div class="header-content">
                        @if(isset($_COOKIE['login_type']))
                            <span>
                                <a href="/information" class="btn-login">个人中心</a>
                                <a class="btn-register" href="/logout">退出</a>
                            </span>
                        @else
                            <span>
                                您好，请
                                <a href="/login" class="btn-login">登录</a>
                                <a class="btn-register" href="/register_front">免费注册</a>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="header-bottom clearfix">
                    <div class="header-bottom-logo">
                        <img src="{{config('view_url.pc_group_ins')}}image/main_LOGO.png" />
                    </div>
                    <ul class="nav-bottom">
                        <li><a href="/">首页</a></li>
                        <li><a href="/product_list">产品列表</a></li>
                        <li><a href="/groupIns/index">团险</a></li>
                        {{--<li><a href="#">首页</a></li>--}}
                        {{--<li><a href="#">推荐</a></li>--}}
                        {{--<li><a href="#">专题</a></li>--}}
                        {{--<li><a href="#">定制</a></li>--}}
                        {{--<li><a href="#">理赔</a></li>--}}
                        {{--<li><a href="productsdetail.html">产品详情</a></li>--}}
                    </ul>

                    {{--<div class="header-bottom-right">--}}
                        {{--<div class="search">--}}
                            {{--<input type="text" name="" class="head-search-block" placeholder="请输入关键字">--}}
                            {{--<input type="button" class="head-search-btn">--}}
                            {{--<i class="icon icon-rank"></i>--}}
                        {{--</div>--}}
                        {{--<div class="shopping">--}}
                            {{--<a href="#">--}}
                                {{--<i class="iconfont icon-gouwuche"></i>--}}
                                {{--<span>我的购物车</span>--}}
                            {{--</a>--}}
                        {{--</div>--}}
                        {{--<div class="private">--}}
                            {{--<a href="#">--}}
                                {{--<i class="iconfont icon-yonghu"></i>--}}
                                {{--<span>个人中心</span>--}}
                            {{--</a>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                </div>
            </div>
        </div>
        <!--头部信息-->
        <div class="headers">
            <div class="headers-wrapper">
                <div class="headers-top clearfix">
                    <ul class="menu w">
                        <li>
                            <a href="javascript:;">天眼互联</a>
                            <i class="iconfont icon-gengduo"></i>
                        </li>
                        <li>
                            <a href="javascript:;">天眼团体健康限</a>
                        </li>
                    </ul>
                    <div class="menu-info w">
                        <a href="javascript:;">保障详情</a>
                    </div>
                </div>
                <div class="headers-moddle clearfix">
                    <div class="swiper-container clearfix">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide"><img src="{{config('view_url.pc_group_ins')}}image/被保险超市详情页_02.png" alt="" /></div>
                        </div>
                    </div>
                </div>
                <div class="headers-bottom clearfix">
                    <div class="headers-bottom-top">
                        <div class="progresscliam1">
                            <div class="hengl"></div>
                            <div class="dianl"></div><span>天眼团体健康险保障计划</span>
                            <div class="dian"></div>
                            <div class="heng"></div>
                        </div>
                    </div>
                    <div class="headers-bottom-bom">
                        <div class="bom-main">
                            <p>马拉松是一项高负荷、大强度、长距离的竞技运动，也是一项高风险的竞技项目，对参赛者身体状况有较高的要求。对于组织方、场地方来说，因比赛准备不足、软硬件出现问题等导致的运动员意外事故，也将会承担连带责任。</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!--中间内容-->
        <form action="{{ url('/ins/group_ins/prepare_order') }}" id="form" method="post">
            {{ csrf_field() }}
            <input type="hidden" name="private_p_code" id="private_p_code" value="{{$ins->private_p_code}}">
            <input type="hidden" name="ditch_id" value="{{ isset($_GET['ditch_id']) ? $_GET['ditch_id'] : 0}}" >
            <input type="hidden" name="agent_id" value="{{ isset($_GET['agent_id']) ? $_GET['agent_id'] : 0}}" >
            <input type="hidden" name="plan_id" value="{{ isset($_GET['plan_id']) ? $_GET['plan_id'] : 0}}" >
            <input type="hidden" name="ty_product_id" value="{{$product_info->ty_product_id}}">
        <div class="cont-main">
            <div class="cont-main-wrapper w">
                <div class="progresscliam2">
                    <div class="hengl"></div>
                    <div class="dianl"></div><span>您将享什么样的福利</span>
                    <div class="dian"></div>
                    <div class="heng"></div>
                </div>
                <div id="option" class="cont-main-content">

                    @php
                    echo $option_html;
                    @endphp

                    {{--{{dd($option_html);}}--}}

                </div>
            </div>
        </div>
        <div class="cont-main1">
            @if(!empty($clauses))
            <div class="cont-main1-wrapper w">
                <spqn>保险条款</spqn>
            </div>
            <div class="cont-main1-wrapper1 w clearfix" style="border-bottom: none;">
                <span>主条款</span>
                <div class="file">
                    @foreach($clauses as $value)
                        @if($value['type']=='main')
                            <div class="file-left"><a href="{{env('TY_API_PRODUCT_SERVICE_URL')}}/{{substr($value['file_url'],0,1)=="/"?substr($value['file_url'],1):$value['file_url']}}">{{$value['name']}}</a></div>
                            <div class="file-right"><a href="{{env('TY_API_PRODUCT_SERVICE_URL')}}/{{substr($value['file_url'],0,1)=="/"?substr($value['file_url'],1):$value['file_url']}}">下载</a><span>|</span><a href="{{env('TY_API_PRODUCT_SERVICE_URL')}}/{{substr($value['file_url'],0,1)=="/"?substr($value['file_url'],1):$value['file_url']}}">查看</a></div>
                        @endif
                    @endforeach
                </div>
            </div>
            @foreach($clauses as $value)
                @if($value['type']=='attach')
                <div class="cont-main1-wrapper1 w clearfix">
                    <span>附加条款</span>
                    <div class="file">
                        <div class="file-left"><a href="{{env('TY_API_PRODUCT_SERVICE_URL')}}/{{substr($value['file_url'],0,1)=="/"?substr($value['file_url'],1):$value['file_url']}}">{{$value['name']}}</a></div>
                        <div class="file-right"><a href="{{env('TY_API_PRODUCT_SERVICE_URL')}}/{{substr($value['file_url'],0,1)=="/"?substr($value['file_url'],1):$value['file_url']}}">下载</a><span>|</span><a href="{{env('TY_API_PRODUCT_SERVICE_URL')}}/{{substr($value['file_url'],0,1)=="/"?substr($value['file_url'],1):$value['file_url']}}">查看</a></div>
                    </div>
                </div>
                @endif
            @endforeach
            @endif
            <div class="cont-main1-wrapper2 w" style="margin-top: 30px;">
                <input hidden text="number" id="min" value="{{$min_math}}"/> <input hidden text="number" id="max" value="{{$max_math}}"/>
                @php
                echo $item_html;
                @endphp
            </div>
        </div>
        </form>
        <div class="cont-main2">
            <div class="cont-main1-wrapper3 w">
                <span>投保案例</span>
                <ul>
                    <li><span style="font-size: 16px; font-weight: 700;">处于创业初期的A企业，用极低的投入为员工在天眼互联购买了太保 · 基础版的医疗补充福利。</span></li>
                    <li><span>1.A公司员工张某在周三团体活动中的时候不幸左腿受伤，送去医院治疗痊愈，社保分割后，花费了6000元。其中，400元自费药品。
   跟据员福保·基础版的保障责任，此次可报销（6000-400）x100%=5400元。</span></li>
                    <li><span style="display:block;margin-top: 10px;">2.A公司员工田某感冒发烧了，在医院门诊就医，花费了1200元。因未超过门诊的起付线（社保门诊起付线为1800），则1200元全部不能进行社保报销。
  按照员福保·基础版的保障范围，商业保险可报销（1200-500）x70%=490元。</span></li>
                </ul>
            </div>
        </div>
        <div class="cont-main3">
            <div class="progresscliam3">
                <div class="hengl"></div>
                <div class="dianl"></div><span>业务流程</span>
                <div class="dian"></div>
                <div class="heng"></div>
            </div>
            <div class="progresscliam w">
                <div class="info">
                    <i class="iconfont icon-baodanyangben" style="color: #00a2ff;"></i>
                    <p style="color: #00a2ff;">投保流程</p>
                </div>
                <ul class="progress">
                    <li class="progress-item active">
                        <div class="progress-outer">
                            <div class="progress-inner"></div>
                        </div>
                        <div class="yangshi">填写保单</div>
                    </li>
                    <li class="progress-item active">
                        <div class="progress-outer">
                            <div class="progress-inner"></div>
                        </div>
                        <div class="yangshi">缴纳保费</div>
                    </li>
                    <li class="progress-item active">
                        <div class="progress-outer">
                            <div class="progress-inner"></div>
                        </div>
                        <div class="yangshi">在线审核</div>
                    </li>
                    <li class="progress-item active">
                        <div class="progress-outer">
                            <div class="progress-inner"></div>
                        </div>
                        <div class="yangshi">处理完成</div>
                    </li>
                </ul>
            </div>
            <div class="progresscliam w">
                <div class="info">
                    <i class="iconfont icon-baodanyangben" style="color: #ffa800;"></i>
                    <p style="color: #ffa800;">理赔流程</p>
                </div>
                <ul class="progress">
                    <li class="progress-item actives">
                        <div class="progress-outer">
                            <div class="progress-inner"></div>
                        </div>
                        <div class="yangshi">申请理赔</div>
                    </li>
                    <li class="progress-item actives">
                        <div class="progress-outer">
                            <div class="progress-inner"></div>
                        </div>
                        <div class="yangshi">在线审核</div>
                    </li>
                    <li class="progress-item actives">
                        <div class="progress-outer">
                            <div class="progress-inner"></div>
                        </div>
                        <div class="yangshi">赔款给付</div>
                    </li>
                    <li class="progress-item actives">
                        <div class="progress-outer">
                            <div class="progress-inner"></div>
                        </div>
                        <div class="yangshi">处理完成</div>
                    </li>
                </ul>
            </div>
            <div class="progresscliam w">
                <div class="info">
                    <i class="iconfont icon-baodanyangben" style="color: #85d53d;"></i>
                    <p style="color: #85d53d;">保单验真</p>
                </div>
                <ul class="progress">
                    <li class="progress-item activef">
                        <div class="progress-outer">
                            <div class="progress-inner"></div>
                        </div>
                        <div class="yangshi">上传保单</div>
                    </li>
                    <li class="progress-item activef">
                        <div class="progress-outer">
                            <div class="progress-inner"></div>
                        </div>
                        <div class="yangshi">在线审核</div>
                    </li>
                    <li class="progress-item activef">
                        <div class="progress-outer">
                            <div class="progress-inner"></div>
                        </div>
                        <div class="yangshi">处理完成</div>
                    </li>
                </ul>
            </div>
        </div>

    </div>
</div>
</body>

<script src="{{config('view_url.pc_group_ins')}}js/lib/jquery-1.11.3.min.js"></script>
<script src="{{config('view_url.pc_group_ins')}}js/common.js"></script>
<script src="{{config('view_url.pc_group_ins')}}js/lib/swiper-3.4.2.min.js"></script>
<script>
    $('.cont-main-contentr button').click(function(){
        var min = parseInt($('#min').val());
        var max = parseInt($('#max').val());
        var num = parseInt($('input[name="count_people"]').val());
        if(min>num){
            Mask.alert('投保人数不能小于'+min+'人');
            return;
        }
        if(max<num){
            Mask.alert('投保人数不能大于'+max+'人');
            return;
        }
        $('#form').submit();

    })
</script>
</html>