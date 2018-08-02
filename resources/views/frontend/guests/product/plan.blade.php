@extends('frontend.guests.frontend_layout.base')
<link rel="stylesheet" href="{{ url(config('resource.position.css').'/frontend/product/product-info.css') }}">
@section('content')
    <div class="main-top">
        <div class="main-top-block">
            <div class="main-top-position">
                <a href=""><span>某某保险网</span></a> > <a href=""><span>儿童保险</span></a>
            </div>
            <div class="main-top-classify">
                <ul>
                    <a href=""><li class='choose'>保障详情</li></a>
                    <a href=""><li class='no_choose'>典型案例</li></a>
                    <a href=""><li class='no_choose'>理赔指引</li></a>
                    <a href=""><li class='no_choose'>常见问题</li></a>
                    <a href=""><li class='no_choose'>用户问题（55）</li></a>
                </ul>
            </div>
        </div>
    </div>
    <div class="main-middle">
        <div class="main-middle-left">
            {{--产品名称--}}
            <div class="product-name">
                {{$res['name']}}
            </div>
            {{--产品名称--}}
            {{--标签--}}
            <div class="product-classify">
                @if(!empty($labels))
                    <ul>
                        @foreach($labels as $label)
                            <li>
                                <img src="" alt="">
                                <span>{{$label['name']}}</span>
                            </li>
                        @endforeach
                    </ul>
                @endif
                <div class="ClearFix"></div>
            </div>
            {{--标签--}}
            <form action="{{ url('/product/prepare_order') }}" id="form" method="post" onSubmit="return check();">
                {{--产品参数--}}
                <div class="product-parameter">
                    @foreach($ke as $k=>$v)
                        @if($k =="年龄")
                            {{--下拉框--}}
                            <div class="choose-parameter">
                                <div class="parameter-name" id="{{$k}}">
                                    {{$k}}
                                </div>
                                <div class="parameter-detail">
                                    @foreach($v as$key=>$values)
                                        <select name="age" style="font-family: 微软雅黑;color: rgb(52,152,219)">
                                            @foreach($values as $value)
                                                @if($value==$plan_detail['age'])
                                                    <option value="{{$value}}" onclick="selectTariff({{$value}})" selected>{{$value}}</option>
                                                @endif
                                            @endforeach
                                        </select>

                                    @endforeach
                                </div>
                            </div>
                            {{--下拉框--}}
                        @else
                            {{--单选框--}}
                            <div class="choose-parameter" id="{{$k}}">
                                <div class="parameter-name" >
                                    {{$k}}
                                </div>
                                <div class="parameter-detail">
                                    <ul>
                                        @foreach($v as$key=>$values)
                                            @foreach($values as $value)
                                                @if(in_array($value,$plan_detail))
                                                    <li id="{{$value}}"  style="border: 2px solid #ff4f00;font-size: 18px" >
                                                        @if($value == "#"||empty($value)||is_null($value))
                                                            <script>
                                                                var v = "{{$value}}";
                                                                var id = "{{$k}}";
                                                                if(v =="#"||v==""||typeof(v)==undefined){
                                                                    document.getElementById(id).style.display="none";
                                                                }
                                                            </script>
                                                        @else
                                                            <label for="radio{{$value}}" id="label{{$value}}" >
                                                                {{$value}}
                                                                <input type="radio" id="radio{{$value}}" checked  class="radio" name="{{$key}}" value="{{$value}}" onclick="selectTariff()" hidden>
                                                            </label>
                                                        @endif
                                                    </li>
                                                @else
                                                        @if($value == "#"||empty($value)||is_null($value))
                                                            <script>
                                                                var v = "{{$value}}";
                                                                var id = "{{$k}}";
                                                                if(v =="#"||v==""||typeof(v)==undefined){
                                                                    document.getElementById(id).style.display="none";
                                                                }
                                                            </script>
                                                        @endif
                                                @endif
                                            @endforeach
                                        @endforeach
                                        <a href="">计划对比</a>
                                    </ul>
                                    <div class="ClearFix"></div>
                                </div>
                            </div>
                            {{--单选框--}}
                        @endif
                    @endforeach
                    {{--保费--}}
                    <div class="choose-parameter">
                        <div class="parameter-name">
                            保费
                        </div>
                        <div class="parameter-detail">
                            <span class="price-unit">￥</span>
                            <span class="price-money" id="check">{{$plan_detail['tariff']}}</span>
                        </div>
                    </div>
                    @if(isset($plan_detail['tariff'])&&!empty($plan_detail['tariff']))
                        <input type="hidden" name="tariff" value="{{$plan_detail['tariff']}}">
                    @endif
                    {{--保费--}}
                    <div class="choose-parameter-button">
                        <button class="go" onclick="check()">立即投保</button>
                        <button class="car">加入购物车</button>
                    </div>
                    <div class="ClearFix"></div>
                </div>
                {{--条款--}}
                <div class="product-guarantee">
                    <div class="guarantee-title">
                        <span>保障权益</span>
                    </div>
                    <?php $clause_ids = ''; ?>
                    @foreach($res['clauses'] as $ck => $cv)
                        <div class="guarantee-list">
                            <?php
                            $clause_ids .= $cv['id'] . ',';
                            $bao_e = explode(',', $cv['coverage']);
                            ?>
                            <input type="hidden" name="clause_beishu_{{$cv['id']}}" id="clause_beishu_{{$cv['id']}}" value="{{$cv['min_m']}}">
                            <div class="guarantee-classify">
                                <span>{{$cv['name']}}</span>
                            </div>
                            <div class="guarantee-content">
                                <div class="guarantee-logo" >
                                    <img src="#">
                                </div>
                                <div class="guarantee-name">
                                    <span>{{$cv['display_name']}}</span>
                                </div>
                                <div class="guarantee-price">
                            <span>
                                <?php

                                        $str = '<select class="bao_e_select" clause_id="'. $cv['id'] .'" jc_bao_e="'. $bao_e[0] .'" bao_e_beishu="1">';
                                        if($cv['min_m'] != 1)
                                            unset($bao_e[0]);
                                        foreach($bao_e as $bk => $v){

                                            $str .= '<option name="bao_e" value="'. $v .'">' . $v . '元';
                                        }
                                        $str .= '</select>';
                                        echo $str
                                ?></span>
                                </div>
                                <div class="guarantee-brief">
                                    {{$cv['content']}}<br/><br/>
                                    <a target="_blank" href="{{config('curl_product.product_info_url')}}{{$cv['file_url']}}">查看条款</a>
                                </div>
                            </div>
                            @endforeach
                            {{--<div class="guarantee-content">--}}
                            {{--<div class="guarantee-logo">--}}
                            {{--</div>--}}
                            {{--<div class="guarantee-name">--}}
                            {{--意外身故/伤残--}}
                            {{--</div>--}}
                            {{--<div class="guarantee-price">--}}
                            {{--<span>50万元</span>--}}
                            {{--</div>--}}
                            {{--<div class="guarantee-brief">--}}
                            {{--在保险期间内，若被保险人因遭受意外伤害事故，且自意外伤害事故发生之日起90天内，在我国境内（不包括港澳台地区）二级以上（含二级）医院或者保险公司指定或认可的医疗机构进行治疗的，保险公司给付被保险人所支出的必要合理的、符合当地基本医疗保险主管部门规定可报销的医疗费用，0免赔，100%赔付。累计达到保险金额时，本附加保险合同终止。（门诊治疗者以15日为限；住院治疗者至出院之日止，最长以90日为限。）--}}
                            {{--</div>--}}
                            {{--</div>--}}
                            {{--<div class="guarantee-content">--}}
                            {{--<div class="guarantee-logo">--}}
                            {{--</div>--}}
                            {{--<div class="guarantee-name">--}}
                            {{--意外身故/伤残--}}
                            {{--</div>--}}
                            {{--<div class="guarantee-price">--}}
                            {{--<span>50万元</span>--}}
                            {{--</div>--}}
                            {{--<div class="guarantee-brief">--}}
                            {{--在保险期间内，若被保险人因遭受意外伤害事故，且自意外伤害事故发生之日起90天内，在我国境内（不包括港澳台地区）二级以上（含二级）医院或者保险公司指定或认可的医疗机构进行治疗的，保险公司给付被保险人所支出的必要合理的、符合当地基本医疗保险主管部门规定可报销的医疗费用，0免赔，100%赔付。累计达到保险金额时，本附加保险合同终止。（门诊治疗者以15日为限；住院治疗者至出院之日止，最长以90日为限。）--}}
                            {{--</div>--}}
                            {{--</div>--}}
                        </div>
                </div>
                {{ csrf_field() }}
                <input type="hidden" name="clause_ids" value="{{$clause_ids}}">
                <input type="hidden" name="product_id" value="{{$_GET['product_id']}}"/>
                <input type="text" name="ditch_id" value="{{ $ditch_id }}" hidden>
                <input type="text" name="agent_id" value="{{ $agent_id }}" hidden>
                <div id="hidden"></div>
            </form>


            <div class="rights">
                <div class="rights-title">
                    <span>您拥有的权益</span>
                </div>
                <div class="rights-list">
                    <div class="rights-detail">
                        <div class="rights-logo">

                        </div>
                        <div class="rights-content">
                            <div class="rights-content-title">
                                退保
                            </div>
                            <div class="rights-content-content">
                                保险合同沒有完全履行时,经投保人和被保险人申请,保险人同意,解除双方由合同确定的法律关系,保险人按合同的约定退还保险单的现金价值。
                            </div>
                        </div>

                    </div>
                    <div class="rights-detail">
                        <div class="rights-logo">

                        </div>
                        <div class="rights-content">
                            <div class="rights-content-title">
                                退保
                            </div>
                            <div class="rights-content-content">
                                保险合同沒有完全履行时,经投保人和被保险人申请,保险人同意,解除双方由合同确定的法律关系,保险人按合同的约定退还保险单的现金价值。
                            </div>
                        </div>

                    </div>
                </div>
                <div class="ClearFix"></div>
            </div>
            <div class="inform">
                @if(!empty($res['person']))
                    <div class="inform-title">
                        <span>产品解读</span>
                    </div>
                    <div class="inform-content">
                        <div class="inform-detail">
                            <?php echo $res['person']?>
                        </div>
                    </div>
                @endif
                <div class="ClearFix"></div>
            </div>

            <div class="evaluate">
                <div class="evaluate-title">
                    <span>用户评价</span>
                </div>
                <div class="evaluate-top">
                    <div class="evaluate-rate">
                        <div class="rate">
                            100%
                        </div>
                        <div class="rate-describe">
                            好评率
                        </div>
                    </div>
                    <div class="evaluate-classify">
                        <ul>
                            <a href=""><li>性价比高(7)</li></a>
                            <a href=""><li>性价比高(7)</li></a>
                            <a href=""><li>性价比高(7)</li></a>
                            <a href=""><li>性价比高(7)</li></a>
                            <a href=""><li>性价比高(7)</li></a>
                            <a href=""><li>性价比高(7)</li></a>
                            <a href=""><li>性价比高(7)</li></a>

                        </ul>
                    </div>
                    <div class="evaluate-release">
                        <button>撰写评论</button>
                    </div>
                </div>
                <div class="evaluate-list">
                    <div class="evaluate-list-nav">
                        <ul>
                            <li class="evaluate-list-choose">全部评论 39</li>
                            <li>产品评论 38</li>
                            <li>理赔反馈</li>
                            <div class="ClearFix"></div>
                        </ul>
                    </div>


                    <div class="pppp">
                        <div class="evaluate-list-content">
                            <div class="portrait">

                            </div>
                            <div class="evaluate-list-detail">
                                <div class="evaluate-user">
                                    <div class="user-name">
                                        jmj***
                                    </div>
                                    <div class="user-score">

                                    </div>
                                    <div class="user-time">
                                        2071-10-10
                                    </div>
                                </div>

                                <div class="user-content">
                                    非常喜欢这款保险，实惠，买个放心。 非常喜欢这款保险，实惠，买个放心。 非常喜欢这款保险，实惠，买个放心。 非常喜欢这款保险，实惠，买个放心。 非常喜欢这款保险，实惠，买个放心。 非常喜欢这款保险，实惠，买个放心。 非常喜欢这款保险，实惠，买个放心。 非常喜欢这款保险，实惠，买个放心。 非常喜欢这款保险，实惠，买个放心。 非常喜欢这款保险，实惠，买个放心。
                                </div>
                            </div>
                            <div class="ClearFix"></div>
                        </div>
                        <div class="evaluate-list-content">
                            <div class="portrait">

                            </div>
                            <div class="evaluate-list-detail">
                                <div class="evaluate-user">
                                    <div class="user-name">
                                        jmj***
                                    </div>
                                    <div class="user-score">

                                    </div>
                                    <div class="user-time">
                                        2071-10-10
                                    </div>
                                </div>

                                <div class="user-content">
                                    非常喜欢这款保险，实惠，买个放心。 非常喜欢这款保险，实惠，买个放心。 非常喜欢这款保险，实惠，买个放心。 非常喜欢这款保险，实惠，买个放心。 非常喜欢这款保险，实惠，买个放心。 非常喜欢这款保险，实惠，买个放心。 非常喜欢这款保险，实惠，买个放心。 非常喜欢这款保险，实惠，买个放心。 非常喜欢这款保险，实惠，买个放心。 非常喜欢这款保险，实惠，买个放心。
                                </div>
                            </div>
                            <div class="ClearFix"></div>
                        </div>
                        <div class="evaluate-list-content">
                            <div class="portrait">

                            </div>
                            <div class="evaluate-list-detail">
                                <div class="evaluate-user">
                                    <div class="user-name">
                                        jmj***
                                    </div>
                                    <div class="user-score">

                                    </div>
                                    <div class="user-time">
                                        2071-10-10
                                    </div>
                                </div>

                                <div class="user-content">
                                    非常喜欢这款保险，实惠，买个放心。 非常喜欢这款保险，实惠，买个放心。 非常喜欢这款保险，实惠，买个放心。 非常喜欢这款保险，实惠，买个放心。 非常喜欢这款保险，实惠，买个放心。 非常喜欢这款保险，实惠，买个放心。 非常喜欢这款保险，实惠，买个放心。 非常喜欢这款保险，实惠，买个放心。 非常喜欢这款保险，实惠，买个放心。 非常喜欢这款保险，实惠，买个放心。
                                </div>
                            </div>
                            <div class="ClearFix"></div>
                        </div>
                        <div class="evaluate-list-content">
                            <div class="portrait">

                            </div>
                            <div class="evaluate-list-detail">
                                <div class="evaluate-user">
                                    <div class="user-name">
                                        jmj***
                                    </div>
                                    <div class="user-score">

                                    </div>
                                    <div class="user-time">
                                        2071-10-10
                                    </div>
                                </div>

                                <div class="user-content">
                                    非常喜欢这款保险，实惠，买个放心。 非常喜欢这款保险，实惠，买个放心。 非常喜欢这款保险，实惠，买个放心。 非常喜欢这款保险，实惠，买个放心。 非常喜欢这款保险，实惠，买个放心。 非常喜欢这款保险，实惠，买个放心。 非常喜欢这款保险，实惠，买个放心。 非常喜欢这款保险，实惠，买个放心。 非常喜欢这款保险，实惠，买个放心。 非常喜欢这款保险，实惠，买个放心。
                                </div>
                            </div>
                            <div class="ClearFix"></div>
                        </div>
                        <div class="more">
                            <a href="">查看更多</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{--<div class="main-middle-right">--}}
        {{--<div class="main-middle-right-top">--}}
        {{--<div class="sale">--}}
        {{--<p class="name">销量</p>--}}
        {{--<p class="count">1489</p>--}}
        {{--</div>--}}
        {{--<div class="satisfied">--}}
        {{--<p class="name">满意度</p>--}}
        {{--<p class="count">100%</p>--}}
        {{--</div>--}}
        {{--</div>--}}
        {{--<div class="main-middle-right-evaluate">--}}
        {{--<div class="title">--}}
        {{--买家印象--}}
        {{--</div>--}}
        {{--<div class="classify">--}}
        {{--<p><span>好（10）</span></p>--}}
        {{--<p><span>好（10）</span></p>--}}
        {{--<p><span>好（10）</span></p>--}}
        {{--<p><span>好（10）</span></p>--}}
        {{--</div>--}}
        {{--</div>--}}
        {{--<div class="main-middle-right-service">--}}
        {{--<div class="title">--}}
        {{--服务与承诺--}}
        {{--</div>--}}
        {{--<div class="content">--}}
        {{--<div class="service-logo">--}}

        {{--</div>--}}
        {{--<div class="service-describe">--}}
        {{--描述--}}
        {{--</div>--}}
        {{--</div>--}}
        {{--<div class="content">--}}
        {{--<div class="service-logo">--}}

        {{--</div>--}}
        {{--<div class="service-describe">--}}
        {{--描述--}}
        {{--</div>--}}
        {{--</div>--}}
        {{--<div class="content">--}}
        {{--<div class="service-logo">--}}

        {{--</div>--}}
        {{--<div class="service-describe">--}}
        {{--描述--}}
        {{--</div>--}}
        {{--</div>--}}
        {{--<div class="content">--}}
        {{--<div class="service-logo">--}}
        {{--</div>--}}
        {{--<div class="service-describe">--}}
        {{--描述--}}
        {{--</div>--}}
        {{--</div>--}}
        {{--</div>--}}
        {{--</div>--}}
    </div>
    <script>
        function  check() {
            return true;
        }
    </script>
@stop