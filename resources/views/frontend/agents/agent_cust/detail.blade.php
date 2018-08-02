@extends('frontend.agents.agent_home.base')
@section('content')
    <link rel="stylesheet" href="{{config('view_url.agent_url')}}css/agent.css" />
    <div class="content">

        <ul class="crumbs">
            <li><a href="#">我的客户</a><i class="iconfont icon-gengduo"></i></li>
            <li><a href="#">未投保客户</a><i class="iconfont icon-gengduo"></i></li>
            <li>查看详情</li>
        </ul>

        <!--客户页面显示-->
        <div class="user-wrapper">
            <div class="user-img">
                <img src="{{config('view_url.agent_url')}}img/girl.png" alt="" />
            </div>
            <a href="/agent_sale/add_plan" class="z-btn z-btn-positive">制作计划书</a>
            <p class="user-info"><span>{{$res->name}}</span><span>@if( isset($res->code) && substr($res->code,16,1)%2 == 1)男@elseif(isset($res->code) && substr($res->code,16,1)%2 == 0) 女 @else -- @endif</span><span>@if(isset($res->code)){{date('Y',time()) - substr($res->code,6,4)}}岁 @else -- @endif</span><span>{{$res->occupation}}</span></p>
        </div>
        <!--客户页面显示-->
        <table class="table-gary">
            <tbody>
            <tr>
                <td>证件类型</td>
                <td>身份证</td>
                <td>邮箱地址</td>
                <td>@if(isset($res->email)){{$res->email}} @else -- @endif</td>
            </tr>
            <tr>
                <td>证件号码</td>
                <td> @if(isset($res->code)) {{$res->code}} @else -- @endif</td>
                <td>购买保障</td>
                <td>{{count($data)}}种</td>
            </tr>
            <tr>
                <td>联系方式</td>
                <td>{{$res->phone}}</td>
                <td>保费总计</td>
                <td>{{$res['price']/100}}元</td>
            </tr>
            <tr>
                <td>其他信息</td>
                <td colspan="3"></td>
            </tr>
            </tbody>
        </table>
        <div class="table-wrapper">
            <h4 class="title">沟通记录</h4>
            <ul class="table-header">
                <li>
                    <span class="col1">沟通时间</span>
                    <span class="col2">记录</span>
                    <span class="col3">沟通产品</span>
                    <span class="col4">购买意向</span>
                </li>
            </ul>
            <div class="table-body">
                <ul>
                    <li>
									<span class="col1">2017-01-05
									</span>
                        <span class="col2">初次沟通，客户家境富裕，担心家中被盗，但对保险比较排斥。</span>
                        <span class="col3 color-default"><a href="#">产品名称一</a></span>
									<span class="col4">
										<i class="iconfont icon-manyi"></i>
										<i class="iconfont icon-manyi"></i>
										<i class="iconfont icon-icon-manyidu"></i>
										<i class="iconfont icon-icon-manyidu"></i>
										<i class="iconfont icon-icon-manyidu"></i>
									</span>
                    </li>
                    <li>
									<span class="col1">2017-01-05
									</span>
                        <span class="col2">初次沟通，客户家境富裕，担心家中被盗，但对保险比较排斥。</span>
                        <span class="col3 color-default"><a href="#">产品名称一</a></span>
									<span class="col4">
										<i class="iconfont icon-manyi"></i>
										<i class="iconfont icon-manyi"></i>
										<i class="iconfont icon-icon-manyidu"></i>
										<i class="iconfont icon-icon-manyidu"></i>
										<i class="iconfont icon-icon-manyidu"></i>
									</span>
                    </li>
                    <li>
									<span class="col1">2017-01-05
									</span>
                        <span class="col2">初次沟通，客户家境富裕，担心家中被盗，但对保险比较排斥。</span>
                        <span class="col3 color-default"><a href="#">产品名称一</a></span>
									<span class="col4">
										<i class="iconfont icon-manyi"></i>
										<i class="iconfont icon-manyi"></i>
										<i class="iconfont icon-icon-manyidu"></i>
										<i class="iconfont icon-icon-manyidu"></i>
										<i class="iconfont icon-icon-manyidu"></i>
									</span>
                    </li>
                    <li>
									<span class="col1">2017-01-05
									</span>
                        <span class="col2">初次沟通，客户家境富裕，担心家中被盗，但对保险比较排斥。</span>
                        <span class="col3 color-default"><a href="#">产品名称一</a></span>
									<span class="col4">
										<i class="iconfont icon-manyi"></i>
										<i class="iconfont icon-manyi"></i>
										<i class="iconfont icon-icon-manyidu"></i>
										<i class="iconfont icon-icon-manyidu"></i>
										<i class="iconfont icon-icon-manyidu"></i>
									</span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="table-wrapper">
            <h4 class="title">购买记录</h4>
            <table>
                <thead>
                <tr>
                    <th>日期</th>
                    <!--客户页面显示-->
                    <th>客户关系</th>
                    <!--企业页面显示-->
                    <!--<th>联系人</th>-->
                    <th>保险公司</th>
                    <th>产品名称</th>
                    <th>计划书</th>
                    <th>保障期限</th>
                    <th>佣金比率</th>
                    <th>保费(元)</th>
                    <th>保额(元)</th>
                    <th>保单状态</th>
                </tr>
                </thead>

                <tbody>
                    @if($count == 0)
                        <!--无记录时显示-->
                <tr class="no-datas">
                    <td colspan="10">
                        <i class="iconfont icon-wujilu"></i>
                        <p>暂无购买记录</p>
                    </td>
                </tr>
                @else
                    @foreach($data as $v)
                        <tr>
                    <td>{{$v->deal_time}}</td>
                    <td>@if($v->relation == 1)本人
                        @elseif($v->relation == 2)妻子
                        @elseif($v->relation == 3)丈夫
                        @elseif($v->relation == 4)儿子
                        @elseif($v->relation == 5)女儿
                        @elseif($v->relation == 6)父亲
                        @elseif($v->relation == 7)母亲
                        @elseif($v->relation == 8)兄弟
                        @elseif($v->relation == 9)姐妹
                        @elseif($v->relation == 10)祖父/祖母/外祖父/外祖母
                        @elseif($v->relation == 11)孙子/孙女/外孙/外孙女
                        @elseif($v->relation == 12)叔父/伯父/舅舅
                        @elseif($v->relation == 13)婶/姨/姑
                        @else侄子/侄女/外甥/外甥女</td>@endif
                    <td><img src="{{env('TY_API_PRODUCT_SERVICE_URL').'/'.$v->json['company']['logo']}}" alt="" /></td>
                    <td>{{$v->product_name}}</td>
                    <td class="color-default"><a href="produced_details.html">{{$v->plan_name->name}}</a></td>
                    <td>一年</td>
                    <td>{{$v->brokerage['earning']}}%</td>
                    <td>{{$v->premium/100}}</td>
                    <td>@foreach($v->clause->content['option']['protect_items'] as $vv) {{$vv['defaultValue']}}&nbsp;&nbsp;&nbsp; @endforeach</td>
                    <td class="color-default"><a href="#">生效中</a></td>
                </tr>
                @endforeach
                @endif


                <!--无记录时显示-->
                <!--<tr class="no-datas">
                    <td colspan="10">
                        <i class="iconfont icon-wujilu"></i>
                        <p>暂无购买记录</p>
                    </td>
                </tr>-->
                </tbody>
            </table>
            <ul class="pagination">
                {{$data->links()}}
            </ul>
        </div>
    </div>


    <script>
        $(".table-body").panel({iWheelStep: 32});

    </script>
@stop