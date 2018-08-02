@extends('frontend.guests.guests_layout.base')
<link rel="stylesheet/less" href="{{config('view_url.view_url')}}css/process.less"/>
<script src="{{config('view_url.view_url').'js/lib/less.min.js'}}"></script>
@section('content')
<div class="wrapper step2">
    <div class="main notification clearfix">
        <div class="notification-left fl">
            <div class="notification-left-tip">
                <i class="iconfont icon-yduidunpaishixin"></i><span>为了保障您的权益，请填写真实有效的信息。您填写的内容仅供投保使用，对于您的信息我们会严格保密。</span>
            </div>
            <div class="notification-left-content">
                <h1 class="notification-left-title">健康告知</h1>
                <div class="notification-left-list">
                    <table>
                        @foreach($health_res as $value)
                            @if(key_exists($value['condition'],$params))
                                @if(
                                $value['condition']=='age'
                                &&
                                intval($params[$value['condition']]) <= intval(explode('-',$value['condition_value'])[1])
                                &&
                                intval($params[$value['condition']]) >= intval(explode('-',$value['condition_value'])[0])
                                )
                                    <tr data-id="{{$value['id']}}">
                                        <td class="text">{{$value['order']}}.{{$value['content']}}</td>
                                        <td class="buttonbox"><button class="btn-small ">是</button><button class="btn-small ">否</button></td>
                                    </tr>
                                @endif
                            @endif
                        @endforeach
                    </table>
                    <p class="notification-left-statement">
                        本投保人声明上述内容填写属实，如有隐瞒或告知不实，保险公司有权解除保险合同，对于合同解除前发生的任何事故，保险公司可不承保任何责任。
                    </p>
                    <div class="notification-left-operation">
                        <button id="btn-all-yes" class="btn btn-small">全选是</button>
                        <button id="btn-all-no" class="btn btn-small">全选否</button>
                        <button id="btn-nexts"  class="btn btn-f18164">下一步</button>
                    </div>
                </div>
            </div>
        </div>
        @include('frontend.guests.product.product_notice')
    </div>
</div>
<script src="{{config('view_url.view_url')}}js/health.js"></script>
<script>
    var identification = "{{$identification}}";
    var health =<?php echo json_encode($health_res)?>;
    $('#btn-nexts').click(function(){
        var trs = $('.notification-left-list tr');
        trs.each(function(index){
            var value = $(this).find('.btn-small.active').text();
            if(value==""){
                Mask.alert('请对健康告知做出选择');
                return false;
            }
            var checked = $(this).find('.btn-small.active').text();
            if(health[index].checked !== checked){
                console.log("最先不匹配的索引是："+index);
                Mask.alert('您的健康告知不符合承保要求，拒绝承保！');
                return false;
            }
            if(index == trs.length-1){
                window.location.href = '/ins/insure/'+identification;
            }
        });
    });
</script>
@stop