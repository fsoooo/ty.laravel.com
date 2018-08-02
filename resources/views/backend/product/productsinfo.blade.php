@extends('backend.layout.base')
@section('content')
    <div id="content-wrapper" class="email-inbox-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <div id="email-box" class="clearfix">
                    <div class="row">
                        <div class="col-lg-12">
                            <ol class="breadcrumb">
                                <li><a href="{{ url('/backend') }}">主页</a></li>
                                <li ><span>产品管理</span></li>
                                <li><span><a href="/backend/product/productlists">产品池</a></span></li>
                                <li class="active"><span>产品池产品详情</span></li>
                            </ol>
                            <div id="email-detail" class="email-detail-nano" style="min-height:1200px;">
                                <div class="email-detail-nano-content">
                                    <div id="email-detail-inner">
                                        @if(empty($json))
                                            <h1>数据解析错误！！，调试中...</h1>
                                        @else
                                            <div id="email-detail-subject" class="clearfix">
                                            <span class="subject">
                                                <img  src="{{config('curl_product.company_logo_url')}}/{{substr($json['res']['company']['logo'],0,1)=="/"?substr($json['res']['company']['logo'],1):$json['res']['company']['logo']}}" style="height: 40px;width:80px;">
                                                保险公司:<a href="{{$json['res']['company']['url']}}">{{$json['res']['company']['name']}}</a></span>
                                                <span class="subject">保险公司Email:{{$json['res']['company']['email']}}</span>
                                                <span class="subject">保险公司编号:{{$json['res']['company']['code']}}</span>
                                                <span id="check"></span>
                                            </div>
                                            <div id="email-detail-sender" class="clearfix">
                                                <div class="users">
                                                    <div class="from clearfix">
                                                        <div class="name">
                                                            <h1>产品名称：{{$json['res']['name']}}</h1>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tools">
                                                    <div class="date">
                                                        产品发布时间：{{$json['res']['created_at']}}
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="email-body">
                                                <ul>
                                                    <li>产品全称：{{$json['res']['display_name']}}</li>
                                                    <li>产品介绍：{{$json['res']['content']}}</li>
                                                    <li>险种：{{$json['res']['category']['name']}}</li>
                                                    <li>佣金比：
                                                        <table>
                                                            <tr>
                                                                <td style="width:200px;">缴期方式(0为趸交)</td>
                                                                <td>比例(%)</td>
                                                            </tr>
                                                            @foreach($json['res']['brokerage'] as $k => $v)
                                                                <tr>
                                                                    <td>{{$v['by_stages_way'] . $v['pay_type_unit']}}</td>
                                                                    <td>{{$v['ratio_for_agency']}}</td>
                                                                </tr>
                                                            @endforeach
                                                        </table>
                                                    </li>
                                                </ul>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop