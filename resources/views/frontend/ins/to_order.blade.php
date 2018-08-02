@extends('frontend.guests.frontend_layout.policy_base')
<link rel="stylesheet" href="{{ url(config('resource.position.css').'/frontend/product/product-policy.css') }}">
<style>
    .hidden{display:none;}
</style>
@section('content')
    {{--0：下拉框 1：日历 2：日历+下拉框 3：文本输入框 4：地区 5：职业 6：文本 9:单选--}}
    <div class="main-block">
        <div class="main-left">
            <div class="main-left-inform">
                <img src="" alt=""><span> {{$json['name']}}</span>
            </div>
            <form class="form-horizontal" method="post"  id="form" action="{{ url('insurance/insure_post')}}">
                {{ csrf_field() }}
                <input type="text" name="identification" value="{{ $identification }}" hidden >
                <input type="text" name="api_from_uuid" value="{{ $ins['api_from_uuid'] }}" hidden >
                @foreach($ins['attr']['attrModules'] as $k => $v)
                    @php $required = 0; @endphp
                    @foreach($v['productAttributes'] as $vk => $vv)
                        @php $required += $vv['required']; @endphp
                    @endforeach
                    @if(!$required)
                        @php continue; @endphp
                    @endif
                    <div class="policy-message">
                        <div class="main-left-message-title">
                            {{--<span>你的信息</span>--}}
                            <span>{{$v['name']}}</span>
                        </div>
                        @if($v['name'] == '受益人信息')
                            <div class="input-block">
                                <label for="">受益人</label>
                                <select class="common-input code-select" id="shouyiren">
                                    <option value="0" selected>法定继承人</option>
                                    <option value="1">其他</option>
                                </select>
                            </div>
                            <div class="need-hidden">
                                @foreach($v['productAttributes'] as $vk => $vv)
                                    {{--@if($vv['required'] == 1)--}}
                                    <div class="input-block">
                                        <label for="">{{$vv['name']}}</label>
                                        @if($vv['type'] == 1)
                                            <input type="date" name="{{$vv['apiName']. '-' .$v['moduleId']}}" class="common-input">
                                        @endif
                                        @if($vv['type'] == 3)
                                            <input type="text" class="common-input" placeholder="{{$vv['name']}}" name="{{$vv['apiName']. '-' .$v['moduleId']}}">
                                            <span class="error-message"></span>
                                        @endif
                                        @if(in_array($vv['type'], [0, 9]))
                                            <select class="common-input code-select" name="{{$vv['apiName']. '-' .$v['moduleId']}}">
                                                @foreach($vv['attributeValues'] as $ak => $av)
                                                    <option value="{{$av['controlValue']}}">{{$av['value']}}</option>
                                                @endforeach
                                            </select>
                                        @endif
                                    </div>
                                    {{--@endif--}}
                                @endforeach
                                {{--@php continue; @endphp--}}
                            </div>

                    @else
                        @foreach($v['productAttributes'] as $vk => $vv)
                            {{--@if($vv['required'] == 1)--}}
                            <div class="input-block">
                                <label for="">{{$vv['name']}}</label>
                                @if($vv['type'] == 1)
                                    <input type="date" name="{{$vv['apiName']. '-' .$v['moduleId']}}" class="common-input">
                                @endif
                                @if($vv['type'] == 3)
                                    <input type="text" class="common-input" placeholder="{{$vv['name']}}" name="{{$vv['apiName']. '-' .$v['moduleId']}}">
                                    <span class="error-message"></span>
                                @endif
                                @if(in_array($vv['type'], [0, 9]))
                                    <select class="common-input code-select" name="{{$vv['apiName']. '-' .$v['moduleId']}}">
                                        @foreach($vv['attributeValues'] as $ak => $av)
                                            <option value="{{$av['controlValue']}}">{{$av['value']}}</option>
                                        @endforeach
                                    </select>
                                @endif
                            </div>
                            {{--@endif--}}
                        @endforeach
                    @endif
                    </div>
                @endforeach
                <div class="policy-confirm">
                    <input type="checkbox" checked>
                    <span>我已查看并同意 <a href="">保险条款</a> 和 <a href="">投保人申明</a></span>
                </div>
                <div class="policy-submit">
                    <input type="submit" value="提交投保单">
                    <span><u>保存投保信息</u></span>
                </div>
            </form>
        </div>

    </div>

    <script>
        $(function(){
            var $html = $('.need-hidden').html();
            $('.need-hidden').html('');
            $("#shouyiren").change(function(){
                var val = $(this).find("option:selected").val();
                if(val == 1){
                    $(".need-hidden").html($html);
                }else{
                    $(".need-hidden").html('');
                }
            });
        })
    </script>
@stop
