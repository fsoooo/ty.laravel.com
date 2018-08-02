@extends('frontend.guests.guests_layout.base')
<link rel="stylesheet/less" href="{{config('view_url.view_url')}}css/clause.less"/>
<script src="{{config('view_url.view_url').'js/lib/less.min.js'}}"></script>
@section('content')
    <div class="wrapper">
        <div class="main">
            <div class="content-topview">
                <div class="content-topview-image">
                    <a href="/brand/detail/1076" target="_blank">
                        <img src="{{env('TY_API_PRODUCT_SERVICE_URL')}}{{json_decode($data['product_res']['json'],true)['company']['logo']}}">
                    </a>
                </div>
                <h1 class="content-topview-title">{{$data['product_res']['product_name']}}</h1>
            </div>

            @if(count(json_decode($data['product_res']['clauses'],true))=='0')
                <div class="intro-label">暂无数据</div>
            @else
                <div class="intro-label">保险条款</div>
                <div class="content-tableview">
                    <table class="content-table-detail">
                        <tbody>
                        @foreach(json_decode($data['product_res']['clauses'],true) as $clause)
                            @if($clause['type']=='main')
                                <tr>
                                    <th rowspan="1">主条款</th>
                                    <td>
                                        <a href="{{env('TY_API_PRODUCT_SERVICE_URL')}}/{{substr($clause['file_url'],0,1)=="/"?substr($clause['file_url'],1):$clause['file_url']}}" target="_blank">{{$clause['name']}}</a>
                                        <i class="iconfont icon-pdf"></i>
                                        <div class="fr">
                                            <a href="{{env('TY_API_PRODUCT_SERVICE_URL')}}/{{substr($clause['file_url'],0,1)=="/"?substr($clause['file_url'],1):$clause['file_url']}}" target="_blank" class="content-table-tdlabel-1">下载</a>
                                            <span class="content-table-tdlabel-2">|</span>
                                            <a href="{{env('TY_API_PRODUCT_SERVICE_URL')}}/{{substr($clause['file_url'],0,1)=="/"?substr($clause['file_url'],1):$clause['file_url']}}" target="_blank" class="content-table-tdlabel-2">查看</a>
                                        </div>
                                    </td>
                                </tr>
                            @else
                                <tr>
                                    <th class="addition-clause">附加条款</th>
                                    <td>
                                        <a href="{{env('TY_API_PRODUCT_SERVICE_URL')}}/{{substr($clause['file_url'],0,1)=="/"?substr($clause['file_url'],1):$clause['file_url']}}" target="_blank">{{$clause['name']}}</a>
                                        <i class="iconfont icon-pdf"></i>
                                        <div class="fr">
                                            <a href="{{env('TY_API_PRODUCT_SERVICE_URL')}}/{{substr($clause['file_url'],0,1)=="/"?substr($clause['file_url'],1):$clause['file_url']}}" target="_blank" class="content-table-tdlabel-1">下载</a>
                                            <span class="content-table-tdlabel-2">|</span>
                                            <a href="{{env('TY_API_PRODUCT_SERVICE_URL')}}/{{substr($clause['file_url'],0,1)=="/"?substr($clause['file_url'],1):$clause['file_url']}}" target="_blank" class="content-table-tdlabel-2">查看</a>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                        </tbody>
                    </table>
                </div>
        </div>
            @endif

    </div>

    <script type="text/javascript">
        $(function() {
            var rowspannum = $('.content-table-detail tr').length - 1;
            $('.addition-clause').attr('rowspan', rowspannum)
        });
    </script>
    @stop