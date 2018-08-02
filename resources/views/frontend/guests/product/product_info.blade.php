@extends('frontend.guests.guests_layout.base')
<link rel="stylesheet/less" href="{{config('view_url.view_url')}}css/details.less" />
<script src="{{config('view_url.view_url')}}js/lib/less.min.js"></script>
<style>
    select{height: 30px;color: #888888;border: 0.1px solid #D0D0D0;margin-right: 15px}
</style>
@section('content')
    <div class="wrapper-top">
        <div class="main">
            <!--路径导航-->
            <ol class="breadcrumb clearfix">
                <li><a href="/">天眼互联</a><i class="iconfont icon-gengduo"></i></li>
                <li>{{$product_info->product_name}}</li>
            </ol>
        </div>
    </div>
    <div class="anchorlink-wrapper">
        <div class="main">
            <div class="anchorlink-box">
                <div class="anchorlink-item active">保障详情</div>
                <div class="anchorlink-item">拥有权益</div>
                <div class="anchorlink-item">用户评价</div>
            </div>
        </div>
    </div>

    <div class="wrapper-bottom">
        <div class="main">
            <div class="product">
                <form action="{{ url('/ins/prepare_order') }}" id="form" method="post">
                    <div class="product-introduce">
                        <h1 class="introduce-name">{{$product_info->product_name}}
                            <img  src="{{config('curl_product.company_logo_url')}}/{{substr($json['company']['logo'],0,1)=="/"?substr($json['company']['logo'],1):$json['company']['logo']}}" style="float: right;margin-right: 30px;width: initial;height: 34px;">
                        </h1>
                        <ul class="introduce-classify clearfix">
                            @if(!empty($product_info->label))
                                @foreach($product_info->label as $value)
                                    @if(!empty($value->labels)&&count($value->labels)!=0)
                                        @foreach($value->labels as $v)
                                            <li><i class="iconfont icon-fuxuankuang"></i>{{$v['name']}}</li>
                                        @endforeach
                                    @endif
                                @endforeach
                            @endif
                        </ul>
                        <div class="introduce-parameter">

                                {{ csrf_field() }}
                                <input type="hidden" name="private_p_code" id="private_p_code" value="{{$ins->private_p_code}}">
                                <input type="hidden" name="ditch_id" value="{{ isset($_GET['ditch_id']) ? $_GET['ditch_id'] : 0}}" >
                                <input type="hidden" name="agent_id" value="{{ isset($_GET['agent_id']) ? $_GET['agent_id'] : 0}}" >
                                <input type="hidden" name="plan_id" value="{{ isset($_GET['plan_id']) ? $_GET['plan_id'] : 0}}" >
                                <input type="hidden" name="health_verify" value="{{ $health_verify }}" >
                                <div id="option">
                                    @php
                                        echo $option_html;
                                    @endphp
                                </div>
                                <div id="hidden"></div>
                                <input type="hidden" name="ty_product_id" value="{{$product_info->ty_product_id}}">
                                <div class="introduce-button">
                                    <a><button type="button" class="btn btn-f18164" id="do_forms">立即投保</button></a>
                                    <a href="javascript:void(0)"><button class="btn btn-a4d790">加入购物车</button></a>
                                    <!--<span class="product-btn-order">预约顾问</span>-->
                                </div>

                        </div>
                    </div>
                    <div id="item" style="margin:30px 0">
                        {{--@if($product_info->product_number == 'Hg012C0100')--}}
                            {{--<img src="{{config('view_url.view_url')}}/image/duty_116663.jpg" style="width: 850px;height:602px">--}}
                        {{--@endif--}}
                            @php echo $item_html;@endphp
                    </div>
                </form>
                <div>
                    <h3 class="section-title">保险条款</h3>
                    <div class="content-tableview">
                        <table class="content-table-detail">
                            <tbody>
                            @if(!empty($clauses))
                                {{--主条款--}}
                                <tr style="border-bottom: 2px dashed #dff1d8;">
                                    <th rowspan="1">主条款</th>
                                    <td>
                                        @foreach($clauses as $value)
                                            @if($value['type']=='main')
                                                <div>
                                                    <a href="{{env('TY_API_PRODUCT_SERVICE_URL')}}/{{substr($value['file_url'],0,1)=="/"?substr($value['file_url'],1):$value['file_url']}}" target="_blank">{{$value['name']}}</a>
                                                    <i class="iconfont icon-pdf"></i>
                                                    <div class="fr">
                                                        <a href="{{env('TY_API_PRODUCT_SERVICE_URL')}}/{{substr($value['file_url'],0,1)=="/"?substr($value['file_url'],1):$value['file_url']}}" class="content-table-tdlabel-1" target="_blank">下载</a>
                                                        <span class="content-table-tdlabel-2">|</span>
                                                        <a href="{{env('TY_API_PRODUCT_SERVICE_URL')}}/{{substr($value['file_url'],0,1)=="/"?substr($value['file_url'],1):$value['file_url']}}" class="content-table-tdlabel-2" target="_blank">查看</a>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    </td>
                                </tr>
                                {{--附加条款--}}
                                <tr>
                                    <th class="addition-clause">附加条款</th>
                                    <td>
                                        @foreach($clauses as $value)
                                            @if($value['type']=='attach')
                                                <div>
                                                    <a href="{{env('TY_API_PRODUCT_SERVICE_URL')}}/{{substr($value['file_url'],0,1)=="/"?substr($value['file_url'],1):$value['file_url']}}" target="_blank">{{$value['name']}}</a>
                                                    <i class="iconfont icon-pdf"></i>
                                                    <div class="fr">
                                                        <a href="{{env('TY_API_PRODUCT_SERVICE_URL')}}/{{substr($value['file_url'],0,1)=="/"?substr($value['file_url'],1):$value['file_url']}}" class="content-table-tdlabel-1" target="_blank">下载</a>
                                                        <span class="content-table-tdlabel-2">|</span>
                                                        <a href="{{env('TY_API_PRODUCT_SERVICE_URL')}}/{{substr($value['file_url'],0,1)=="/"?substr($value['file_url'],1):$value['file_url']}}" class="content-table-tdlabel-2" target="_blank">查看</a>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    </td>
                                </tr>
                            @endif

                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="product-possess">
                    <h3 class="section-title">您拥有的权益</h3>
                    <div class="product-possess-wrapper">
                        <ul class="clearfix">
                            <li class="clearfix">
                                <div class="product-possess-img fl">
                                    <img src="{{config('view_url.view_url')}}image/154994202374191399.png" alt="" />
                                </div>
                                <div class="product-possess-content fl">
                                    <div class="possess-name">索赔</div>
                                    <p class="possess-text">指当被保险标的遭受承保责任范围内的风险损失或伤害时,被保险人有权向保险人提出索赔。</p>
                                </div>
                            </li>

                            <li class="clearfix">
                                <div class="product-possess-img fl">
                                    <img src="{{config('view_url.view_url')}}image/154994202374191399.png" alt="" />
                                </div>
                                <div class="product-possess-content fl">
                                    <div class="possess-name">退保</div>
                                    <p class="possess-text">保险合同沒有完全履行时,经投保人和被保险人申请,保险人同意,解除双方由合同确定的法律关系,保险人按合同的约定退还保险单的现金价值。</p>
                                </div>
                            </li>
                            <li class="clearfix">
                                <div class="product-possess-img fl">
                                    <img src="{{config('view_url.view_url')}}image/154994202374191399.png" alt="" />
                                </div>
                                <div class="product-possess-content fl">
                                    <div class="possess-name">保全</div>
                                    <p class="possess-text">在保单有效期内,经投保人和保险人协商同意,可以修改保单的有关内容。</p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="product-evaluate">
                    <h3 class="section-title">用户评价</h3>
                    <div class="description clearfix">
                        <div class="description-left fl">
                            <div class="description-rate">100%</div>
                            <div class="description-text">好评率</div>
                        </div>
                        <div class="description-right fl">
                            <span class="tag">好(22)</span>
                            <span class="tag">性价比高(8)</span>
                            <span class="tag">好(22)</span>
                            <span class="tag">很好用(8)</span>
                            <span class="tag">省心放心(8)</span>
                        </div>
                    </div>
                    <!-- UY BEGIN -->
                    {{--<div id="uyan_frame"></div>--}}
                    {{--<script type="text/javascript" src="http://v2.uyan.cc/code/uyan.js?uid=2141334"></script>--}}
                    <!-- UY END -->
                <!--<div class="tabControl">
									<div class="tabControl-nav">
										<span>用户评价55</span>
										<span>理赔反馈55</span>
									</div>
									<div class="tabControl-wrapper">
										<ul class="active">
											<li class="clearfix">
												<div class="tabControl-img fl">
													<img src="{{config('view_url.view_url')}}image/546880771452609376.png" alt="" />
												</div>
												<div class="tabControl-content fl">
													<div>
														断**线
														<i class="iconfont icon-shoucangwujiaoxing"></i>
														<i class="iconfont icon-shoucangwujiaoxing"></i>
														<i class="iconfont icon-shoucangwujiaoxing"></i>
														<i class="iconfont icon-shoucangwujiaoxing"></i>
														<i class="iconfont icon-shoucangwujiaoxing"></i>
													</div>
													<div class="tabControl-text">
														客服周云女士非常耐心，而且提供的信息很专业，能根据客户的实际情况提供恰当的险种。半年前无意中接触了保险网，对不太了解，半年后自己陆续买了一些保险后再来看惠泽，发现提供的险种非常实用有针对性。如果需要理赔，希望能像投保时一样顺利，但是不希望有理赔的情况出现，希望是把这点小钱捐助给了有需要的人吧。
													</div>
												</div>
											</li>
											<li class="clearfix">
												<div class="tabControl-img fl">
													<img src="{{config('view_url.view_url')}}image/546880771452609376.png" alt="" />
												</div>
												<div class="tabControl-content fl">
													<div>
														断**线
														<i class="iconfont icon-shoucangwujiaoxing"></i>
														<i class="iconfont icon-shoucangwujiaoxing"></i>
														<i class="iconfont icon-shoucangwujiaoxing"></i>
														<i class="iconfont icon-shoucangwujiaoxing"></i>
														<i class="iconfont icon-shoucangwujiaoxing"></i>
													</div>
													<div class="tabControl-text">
														客服周云女士非常耐心，而且提供的信息很专业，能根据客户的实际情况提供恰当的险种。半年前无意中接触了保险网，对不太了解，半年后自己陆续买了一些保险后再来看惠泽，发现提供的险种非常实用有针对性。如果需要理赔，希望能像投保时一样顺利，但是不希望有理赔的情况出现，希望是把这点小钱捐助给了有需要的人吧。
													</div>
												</div>
											</li>
										</ul>
										<ul>
											<li>暂无信息</li>
										</ul>
									</div>
								</div>-->
                </div>
            </div>
            <div class="product-right">
                {{--<div class="product-right-top" style="display: none">--}}
                    {{--<div class="product-right-info clearfix">--}}
                        {{--<div class="product-right-num fl">--}}
                            {{--<div class="cl999">销量</div>--}}
                            {{--<div class="a4d790">1489</div>--}}
                        {{--</div>--}}
                        {{--<div class="product-right-rate fl">--}}
                            {{--<div class="cl999">满意度</div>--}}
                            {{--<div class="f18164">100%</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="product-right-impression">--}}
                        {{--<div class="name">买家印象</div>--}}
                        {{--<div>--}}
                            {{--<span class="tag">产品很好(22)</span>--}}
                            {{--<span class="tag">性价比高(8)</span>--}}
                            {{--<span class="tag">省心放心(8)</span>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="product-right-service">--}}
                        {{--<div class="name">服务与承诺</div>--}}
                        {{--<ul>--}}
                            {{--<li><i class="icon icon-wujiaoxing"></i>电子保单</li>--}}
                            {{--<li><i class="icon icon-wujiaoxing"></i>理赔协助</li>--}}
                            {{--<li><i class="icon icon-wujiaoxing"></i>24小时在线服务</li>--}}
                        {{--</ul>--}}
                    {{--</div>--}}
                {{--</div>--}}
                <div class="product-right-bottom">
                    <div class="name">保费</div>
                    <div class="f18164">￥<span class="price" id="price2"></span></div>
                    <button class="btn btn-f18164" id="do_form"><a class="f18164" style="color: white">立即投保</a></button>
                    <button class="btn btn-a4d790"><a href="javascript:void(0)">加入购物车</a></button>
                </div>

            </div>
        </div>
    </div>
    <script src="{{config('view_url.view_url')}}js/lib/laydate.js"></script>
    <script src="{{config('view_url.view_url')}}js/details.js"></script>
    <script>
    $(function () {
    var price  = $('#price1').text();
    console.log(price);
    $('#price2').html(price);
    });
    $('#do_form').on('click',function () {
        var price  = $('#price1').text();
        if(!price){
           Mask.alert('投保年龄不符，请注意出生日期');
        }else{
            $('#form').submit();
        }
    });
    $('#do_forms').on('click',function () {
        var price  = $('#price1').text();
        if(!price){
            Mask.alert('投保年龄不符，请注意出生日期');
        }else{
            $('#form').submit();
        }
    });
    </script>
@stop

