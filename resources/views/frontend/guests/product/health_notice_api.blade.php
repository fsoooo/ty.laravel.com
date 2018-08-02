@extends('frontend.guests.guests_layout.base')
<link rel="stylesheet/less" href="{{config('view_url.view_url')}}css/process.less"/>
<script src="{{config('view_url.view_url').'js/lib/less.min.js'}}"></script>
<style>
    .green{
        font-size: 12px;
        color: green;
    }
    .red{
        font-size: 12px;
        color: red;
    }


</style>
@section('content')
<div class="wrapper step2">
    <div class="main notification clearfix">
        <div class="notification-left fl">
            <div class="notification-left-tip">
                <i class="iconfont icon-yduidunpaishixin"></i><span>为了保障您的权益，请填写真实有效的信息。您填写的内容仅供投保使用，对于您的信息我们会严格保密。</span>
            </div>
            <form class="form-horizontal" method="post"  id="form" action="{{ url('ins/sub_health_notice')}}">
                <input type="hidden" name="transNo" value="{{ $transNo }}">
                <input type="hidden" name="partnerId" value="{{ $partnerId }}">

                <input type="hidden" name="identification" value="{{ $identification }}">
                <input type="hidden" name="qaAnswer[healthyId]" value="{{ $healthId }}">
                <input type="hidden" name="moduleId" value="{{ $product_res['moduleId'] }}">
                <input type="hidden" name="keyCode" value="{{ $product_res['keyCode'] }}">
            <div class="notification-left-content">
                <h1 class="notification-left-title">{{ $product_res['moduleName'] }}</h1>
                <div class="notification-left-list">

                        {{ csrf_field()}}
                    <table class="health-content">
                        @foreach($product_res['healthyQuestions'] as $key=>$value)
                                <tr data-id="{{ $value['questionId'] }}">
                                    <td class="text">{{ $key + 1  }} . {{$value['content']}}</td>
                                </tr>
                                {{--层级关系--}}
                                <input type="hidden" name="question[{{$value['questionId']}}][parentId]" value="{{$value['parentId']}}">
                                <input type="hidden" name="question[{{$value['questionId']}}][questionSort]" value="{{$value['questionSort']}}">
                                @if(isset($value['healthyAnswers']))
                                    @foreach($value['healthyAnswers'] as $k=>$val)


                                        @if(isset($val['description']))
                                            <tr>
                                                <td>{{ $val['description'] }}</td>
                                            </tr>
                                        @endif

                                            {{--单选框    --}}
                                            @if($val['healthyAttribute']['attributeType'] == 9)
                                                <tr>
                                                    <td>
                                                        @foreach($val['healthyAttribute']['attributeValues'] as $v)
                                                            <label><input name="answer[{{ $val['questionIds'] }}][{{ $val['answerId'] }}][{{ $val['healthyAttribute']['keyCode'] }}]" type="radio" value="{{ $v['controlValue'] }}" /> {{ $v['attributeValue'] }} </label>
                                                        @endforeach
                                                    </td>
                                                </tr>
                                            @endif

                                            {{--文本框--}}
                                            @if($val['healthyAttribute']['attributeType'] == 3)
                                                <tr>
                                                    <td>
                                                        {{$val['healthyAttribute']['attributeName']}}
                                                        <input class="" type="text" name="answer[{{ $val['questionIds'] }}][{{ $val['answerId'] }}][{{ $val['healthyAttribute']['keyCode'] }}]" regex="{{$val['healthyAttribute']['regex']}}" msg="{{$val['healthyAttribute']['errorRemind']}}">
                                                        <span class="green">
                                                            {{ $val['healthyAttribute']['defaultRemind'] }}
                                                        </span>
                                                    </td>
                                                </tr>
                                            @endif

                                    @endforeach
                                @endif

                        @endforeach
                    </table>
                    <p class="notification-left-statement">
                        本投保人声明上述内容填写属实，如有隐瞒或告知不实，保险公司有权解除保险合同，对于合同解除前发生的任何事故，保险公司可不承保任何责任。
                    </p>
                    <div class="notification-left-operation">
                        <button id="btn-nexts"  class="btn btn-f18164">下一步</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
        <script>

                var inputs = $('.health-content input:visible[type="text"]');
                console.log(inputs);
                inputs.on('blur',function(){

                    var regex =  eval('/'+$(this).attr('regex')+'/');
                    var value = $(this).val();
                    if (regex){
                        var msg = $(this).attr('msg');
                        if (!regex.test(value)){
                            $(this).val("");
//                        Mask.alert(msg,2);
                            $(this).next().addClass('red');
                            $(this).next().text(msg);
                        } else {
                            $(this).next().removeClass('red');
                            $(this).next().text('输入完成');
                        }
                    }
                });

        </script>
        @include('frontend.guests.product.product_notice')
    </div>
</div>
@stop