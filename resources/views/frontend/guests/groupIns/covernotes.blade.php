@extends('frontend.guests.guests_layout.base')
<link rel="stylesheet/less" href="{{config('view_url.view_url')}}css/process.less"/>
<script src="{{config('view_url.view_url').'js/lib/less.min.js'}}"></script>
@section('content')
    <div class="wrapper step1">
        <div class="main notification clearfix">
            <div class="notification-left fl">
                <div class="notification-left-tip">
                    <i class="iconfont icon-yduidunpaishixin"></i><span>为了保障您的权益，请填写真实有效的信息。您填写的内容仅供投保使用，对于您的信息我们会严格保密。</span>
                </div>
                <div class="notification-left-content">
                    <h1 class="notification-left-title">投保告知</h1>
                    <div class="notification-left-list">
                        <ul>
                            <li>1、投保前请您仔细阅读：<a href="/product/insure_clause">产品条款</a><a href="#">保险金赔付比例</a><a href="#">赔偿方式 </a><a href="#">客户告知书 </a><a href="#">保单样本</a></li>
                            <li>2、责任免除、保险责任、犹豫期、费用扣除、退保、保险单现金价值、投保人、被保险人义务等内容详见产品条款， 请务必仔细阅读产品条款及电子保单的特别约定。</li>
                            <li>3、本产品仅承保1-3类职业人员。凡从事高空作业工作人员,均不可作为被保险人投保本产品。高空作业定义:根据 GB/T3608《高处作业分级》国家标准的规定，凡在有可能坠落的高处进行施工作业，当坠落高度距离基准面在2米及2米以上时，该项作业即称为高空 (高处)作业。</li>
                            <li>4、本产品仅承保中华人民共和国境内合法经营的二级及以上公立医院或保险公司认可的其他医疗机构,请注意:北京平谷区、怀柔区、密云县的所有医院的就医均不予理赔。</li>
                        </ul>
                        <div class="notification-left-operation">
                            <div class="notification-left-agreement"><label><input class="btn-agreement" type="checkbox" hidden /><i class="icon icon-checkbox"></i><span>我已查看并同意投保告知所有内容</span></label></div>
                            <button disabled="disabled" class="btn btn-unusable">下一步</button>
                        </div>
                    </div>
                </div>
            </div>
            @include('frontend.guests.groupIns.product_notice')
        </div>
    </div>
    <script src="{{config('view_url.view_url')}}js/insurance.js"></script>
        <script>
            var identification = "{{$identification}}";
            $('.btn').click(function(){
                location.href='groupInsForm/'+identification;
            })
            {{--function  doorder() {--}}
                {{--var identification = "{{$identification}}";--}}
                {{--window.location.href = '/product/insure/'+identification;--}}
            {{--}--}}
            {{--//todo--}}
            {{--function set_order(){--}}
                {{--var identification = "{{$identification}}";--}}
                {{--window.location.href = '/insurance/insure/'+identification;--}}
            {{--}--}}
    </script>
@stop