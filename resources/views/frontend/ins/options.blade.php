{{--类型 0：下拉框 1：日历 2：日历+下拉框 3：文本输入框 4：地区 5：职业 6：文本--}}
{{--算费参数--}}
    @php
        $checked_arr = array();
        foreach($priceArgs['genes'] as $pk => $pv){
            if(empty($pv['key'])){
                $checked_arr[$pv['protectItemId']] = $pv['value'];
            }else{
                $checked_arr[$pv['key']] = $pv['value'];
            }
        }
    {{--dd($checked_arr);--}}
    @endphp
@foreach($option as $k => $v)
    <div class="choose-parameter">
        <div class="parameter-name">
            {{$v['name']}}
        </div>
        <div class="parameter-detail">
            @if(!$v['display'])
             @php continue; @endphp
            @endif

            @if(in_array($v['type'], [0, 3, 4, 6]))
                @if(!empty($v['key']))
                    <label for="{{$v['key']}}">
                        @foreach($v['values'] as $vk => $vv)
                            @php
                                $str = !empty($vv['unit']) ? $vv['unit'] : '';
                            @endphp
                            @if($vv['type'] == 1)
                                @php
                                    $class = '';
                                    if($vv['value'].$str == $checked_arr[$v['key']]){
                                        $class = 'label-active';
                                    }
                                @endphp
                                <li class='{{$class}}' value='{"key":"{{$v['key']}}","value":"{{$vv['value'] . $str}}","sort":{{$v['sort']}}}'>{{$vv['value'] . $str}}</li>
                            @else
                                @for($i=$vv['min'];$i<=$vv['max'];$i+=$vv['step'])
                                    @php
                                        $class = '';
                                        if($i.$str == $checked_arr[$v['key']]){
                                            $class = 'label-active';
                                        }
                                    @endphp
                                    <li class='{{$class}}' value='{"key":"{{$v['key']}}","value":"{{$i . $str}}","sort":{{$v['sort']}}}'>{{$i . $str}}</li>
                                @endfor
                            @endif
                        @endforeach
                    </label>
                @else
                    <label protectItemId="{{$v['protectItemId']}}" for="protectItemId">
                        @foreach($v['values'] as $vk => $vv)
                            @php
                                $str = !empty($vv['unit']) ? $vv['unit'] : '';
                            @endphp
                            @if($vv['type'] == 1)
                                @php
                                    $class = '';
                                    if($vv['value'].$str == $checked_arr[$v['protectItemId']]){
                                        $class = 'label-active';
                                    }
                                @endphp
                                <li class='{{$class}}' value='{"protectItemId":"{{$v['protectItemId']}}","value":"{{$vv['value'] . $str}}","sort":{{$v['sort']}}}'>{{$vv['value'] . $str}}</li>
                                {{--<li class='{{$class}}'>{{$vv['value'] . $str}}</li>--}}
                            @else
                                @for($i=$vv['min'];$i<=$vv['max'];$i+=$vv['step'])
                                    @php
                                    $class = '';
                                    if($i.$str == $checked_arr[$v['protectItemId']]){
                                        $class = 'label-active';
                                    }
                                    @endphp
                                    <li class='{{$class}}' value='{"protectItemId":"{{$v['protectItemId']}}","value":"{{$i . $str}}","sort":{{$v['sort']}}}'>{{$i . $str}}</li>
                                    {{--<li class='{{$class}}'>{{$i . $str}}</li>--}}
                                @endfor
                            @endif
                        @endforeach
                    </label>
                @endif
            @endif

        </div>
    </div>
@endforeach
{{--算费参数结束--}}
{{--保费--}}
<input type="hidden" id="old-option" name="option" value="{{json_encode($option)}}">
<input type="hidden" id="priceArgs" name="priceArgs" value="{{json_encode($priceArgs)}}">
<input type="hidden" id="price" name="price" value="{{$price}}">
<div class="choose-parameter">
    <div class="parameter-name">
        保费
    </div>
    <div class="parameter-detail">
        <span class="price-unit">￥</span>
        <span class="price-money" id="check">{{$price  / 100 . '.00'}} </span>
    </div>
</div>
