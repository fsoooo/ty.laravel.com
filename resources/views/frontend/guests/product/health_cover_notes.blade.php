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
                    <h1 class="notification-left-title">{{ $product_res['moduleName'] }}</h1>
                    <div class="notification-left-list">
                        <div class="notice-list list1">


                            {{$product_res['healthyQuestions']}}
                        </div>
                        {{--<ul>--}}
                            {{--<li>1、投保前请您仔细阅读：<a href="/ins/insure_clause/{{$identification}}" target="_blank">产品条款</a>--}}
                                {{--<a href="#">保险金赔付比例</a><a href="#">赔偿方式 </a><a href="#">客户告知书 </a><a href="#">保单样本</a></li>--}}
                        {{--</ul>--}}
                        <div class="notification-left-operation">
                            <div class="notification-left-agreement"><label><input class="btn-agreement" type="checkbox" hidden /><i class="icon icon-checkbox"></i><span>我已查看并同意投保告知所有内容</span></label></div>
                            <button disabled="disabled" class="btn btn-unusable">下一步</button>
                        </div>
                    </div>
                </div>
            </div>
            @include('frontend.guests.product.product_notice')
        </div>
    </div>
    <script src="{{config('view_url.view_url')}}js/insurance.js"></script>
        <script>
            var identification = "{{$identification}}";
            $('.btn').click(function(){
                @if($res == 2)
                    window.location.href = '/ins/insure/'+identification;
                @else
//                      window.location.href = '/ins/insure/'+identification;
                    location.href='health_notice/'+identification; //如果产品有健康告知调整到健康告知页面,如果没有直接跳转到投保属性页面
                @endif
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

            // 投保须知-健康告知格式转换
            function changeInfo(cont){
                var html = '<ul>';
                cont = cont.replace(/\d\./g,"//").split('//');
                var arr = [];
                for (var i=0,l=cont.length;i<l;i++) {
                    if(!cont[i].trim()){continue;}
                    arr = cont[i].replace(/\d、/g,"//").split('//');
                    for(var j=0,len=arr.length;j<len;j++){
                        if(len == 1){
                            html += '<li><span>'+ (i) + '.</span>' +arr[j] +'</li>';
                        }else{
                            if(!arr[j].trim()){continue;}
                            if(j==1){
                                html += '<li><span>'+ (i) + '.</span>' + (j) + '、' +arr[j] +'</li>';
                            }else{
                                html += '<li class="level2"><span>'+ (j) + '、</span>' +arr[j] +'</li>';
                            }
                        }
                    }
                }
                html += '</ul>';
                return html;
            }

            $(".list1").html(changeInfo($('.list1').text()));
    </script>
@stop