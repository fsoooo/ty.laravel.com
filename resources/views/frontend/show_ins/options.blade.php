<?php
    $selected = isset($selected_options['genes']) ? $selected_options['genes'] : $selected_options;
    $s_arr = array();
        //todo
//        dd($selected);
//    foreach($selected as $k => $v){
//        if(isset($v['ty_key'])){
//            $s_arr[$v['ty_key']] = $v['value'];
//        } else {
//            $s_arr[$v['protectItemId']] = $v['value'];
//        }
//    }

    foreach($selected as $k => $v){
        if(isset($v['protectItemId']) && ($v['protectItemId']>0)){
            $s_arr[$v['protectItemId']] = $v['value'];
        }else{
            $s_arr[$v['ty_key']] = $v['value'];
        }
    }

    //多个时间初始化
    $sel_date = [];
//        dd($restrict_genes);
?>
        {{--
        类型
        0：下拉框
        1：日历
        2：日历+下拉框
        3：文本输入框
        4：地区
        5：职业
        6：文本
        --}}
@foreach($restrict_genes as $k => $v)
    <?php
    $protectItemId = (isset($v['protectItemId']) && ($v['protectItemId'] > 0)) ? $v['protectItemId'] : 0;
    $ty_key = isset($v['ty_key']) ? $v['ty_key'] : '';
    ?>
            @if(isset($v['protectItemId']) && ($v['protectItemId'] > 0))

                <div class="introduce-parameter-row clearfix" protectItemId="{{$v['protectItemId']}}" for="protectItemId" @if(!$v['display']) style="display: none;" @endif>
                    <span class="introduce-parameter-title">{{$v['name']}}</span>
                    <div class="introduce-parameter-content">
                        <ul class="fl clearfix">
                            @foreach($v['values'] as $vk => $vv)
                                <?php $unit = isset($vv['unit']) ? $vv['unit'] : '' ?>
                                @if($vv['type'] == 1)
                                    <li class='product-type  {{$s_arr[$protectItemId] == ($vv['ty_value'] . $unit) ? 'label-active' : ''}}' data-value='{"protectItemId":"{{$protectItemId}}","key":"{{$ty_key}}","value":"{{$vv['ty_value'] . $vv['unit']}}","sort":{{$v['sort']}}}'>
                                        @if(isset($vv['name'])){{$vv['name'] . $unit}}@else{{$vv['ty_value'] . $unit}}@endif
                                    </li>
                                @else
                                    @for($i=$vv['min'];$i<=$vv['max'];$i+=$vv['step'])
                                        <li class='product-type {{$s_arr[$protectItemId] == ($i . $unit) ? 'label-active' : ''}}' data-value='{"protectItemId":"{{$protectItemId}}","key":"{{$ty_key}}","value":"{{$i . $vv['unit']}}","sort":{{$v['sort']}}}'>
                                            {{$i . $unit}}
                                        </li>
                                    @endfor
                                @endif
                            @endforeach
                        </ul>
                    </div>
                </div>
            @else

                <div class="introduce-parameter-row clearfix" @if(!$v['display']) style="display: none;" @endif>
                    <span class="introduce-parameter-title">{{$v['name']}}</span>
                    {{--惠泽地区渲染暂停使用--}}
                    {{--@if(in_array($v['type'], [400]))--}}
                        {{--<div class="introduce-parameter-content">--}}
                            {{--<span class="area_box">--}}
                                {{--<span class="type_is_area"></span>--}}
                                {{--<input class="area" style="display: none;"/>--}}
                                {{--<select name="province" class="province">--}}
                                    {{--@foreach($v['subRestrictGenes'][0]['values'] as $vk => $vv)--}}
                                        {{--<option {{$vv['value'] == $v['subRestrictGenes'][0]['defaultValue'] ? 'selected="selected"' : ''}} value="{{$vv['value']}}" data-id="{{$vk}}">{{$vv['name']}}</option>--}}
                                    {{--@endforeach--}}

                                {{--</select>--}}
                                {{--<select name="city" class="city">--}}
                                    {{--@foreach($v['values'] as $vk => $vv)--}}
                                        {{--<option {{$vv['ty_value'] == $v['defaultValue'] ? 'selected="selected"' : ''}} value="{{$vv['ty_value']}}" data-id="{{$vk}}">{{$vv['name']}}</option>--}}
                                    {{--@endforeach--}}
                                {{--</select>--}}
                            {{--</span>--}}
                        {{--</div>--}}
                    {{--@elseif(in_array($v['type'], [2,3,4,6]))--}}
                    @if(in_array($v['type'], [2,3,4,6]))
                        <div class="introduce-parameter-content">
                            <ul class="fl clearfix">
                                @foreach($v['values'] as $vk => $vv)
                                    <?php $unit = isset($vv['unit']) ? $vv['unit'] : '' ?>
                                    @if($vv['type'] == 1)
                                        <li class='product-type  {{$s_arr[$v['ty_key']] == ($vv['ty_value'] . $unit) ? 'label-active' : ''}}' data-value='{"protectItemId":"{{$protectItemId}}","key":"{{$ty_key}}","value":"{{$vv['ty_value'].$unit}}","sort":{{$v['sort']}}}'>
                                            @if(isset($vv['name'])){{$vv['name'] . $unit}}@else{{$vv['ty_value'] . $unit}}@endif
                                        </li>
                                        {{--@if($v['name']=='承保年龄')<div class="inline laydate-icon" id="starttime">请选择出生日期</div>@endif--}}
                                    @else
                                        @for($i=$vv['min']; $i<=$vv['max']; $i+=$vv['step'])
                                            <li class='product-type  {{$s_arr[$ty_key] == ($i . $unit) ? 'label-active' : ''}}' data-value='{"protectItemId":"{{$protectItemId}}","key":"{{$ty_key}}","value":"{{$i.$unit}}","sort":{{$v['sort']}}}'>
                                                {{$i . $unit}}
                                            </li>
                                        @endfor
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    @elseif (in_array($v['type'], [0]))
                        {{--下拉框--}}
                        <div class="introduce-parameter-content">
                            <select style="width: 170px;height: 35px;font-size: 16px;color:#888888 ; border: 0.1px solid #D0D0D0" class="select_value">
                                @foreach ($v['values'] as $vk => $vv)
                                    <?php $unit = isset($vv['unit']) ? $vv['unit'] : '' ?>
                                    @if($vv['type'] == 2)
                                        @for($i = $vv['min']; $i <= $vv['max']; $i+=$vv['step'])
                                            <option data-value='{"protectItemId":"{{$protectItemId}}","key":"{{$ty_key}}","value":"{{$i.$unit}}","sort":{{$v['sort']}}}' {{ $s_arr[$ty_key] == $i.$unit ? 'class=label-active' : '' }} {{ $s_arr[$ty_key] == $i.$unit ? 'selected' : '' }}>
                                                @if(!empty($vv['name']))
                                                    {{$vv['name'] . $unit}}
                                                @else
                                                    {{$i.$unit}}
                                                @endif
                                            </option>
                                        @endfor
                                    @else
                                        <option data-value='{"protectItemId":"{{$protectItemId}}","key":"{{$ty_key}}","value":"{{$vv['ty_value'].$unit}}","sort":{{$v['sort']}}}' {{ $s_arr[$ty_key] == ($vv['ty_value'] . $unit) ? 'selected' : '' }} {{ $s_arr[$ty_key] == ($vv['ty_value'] . $unit) ? 'class=label-active' : '' }}>
                                            @if(isset($vv['name']))
                                                {{$vv['name'] . $unit}}
                                            @else
                                                {{$vv['ty_value'] . $unit}}
                                            @endif
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                            <input class="inputhidden" type="hidden" value="" />
                            {{--@endif--}}
                        </div>
                    @elseif (in_array($v['type'], [1]))
                        @php
                            $value = $s_arr[$v['ty_key']] ? $s_arr[$v['ty_key']] : date('Y-m-d',time());
                            $sel_date[] = $ty_key;
                        @endphp

                        <div class="introduce-parameter-content">
                            <ul class="fl clearfix">
                                <li id="bithday_value">
                                    <input id="bithday" class="label-active" value="{{ $value }}" data-value='{"key":"{{$ty_key}}","value":"{{ $value }}","sort":{{$v['sort']}}}' type="hidden">
                                </li>
                            </ul>
                        </div>
                        <select class="datetime sel_year sel_year_{{$ty_key}}"  rel="{{date('Y', strtotime($value))}}"></select>
                        <select class="datetime sel_month sel_month_{{$ty_key}}"  rel="{{date('m',strtotime($value))}}"></select>
                        <select class="datetime sel_day sel_day_{{$ty_key}}"  rel="{{date('d',strtotime($value))}}"></select>
                    @endif
                </div>

            @endif
@endforeach
{{-- 算费按钮 --}}
<button style="display: none;" id="quote-button"></button>
{{--算费参数结束--}}
{{--保费--}}
<input type="hidden" id="old-option" name="option" value="{{json_encode($restrict_genes, JSON_UNESCAPED_UNICODE)}}">
<input type="hidden" id="selected" name="selected" value="{{json_encode($selected_options, JSON_UNESCAPED_UNICODE)}}">
@if(!is_numeric($price)&&is_string($price))
    <input type="hidden" id="price" name="price" value="0">
@elseif(is_numeric($price))
    <input type="hidden" id="price" name="price" value="{{$price}}">
@else
    <input type="hidden" id="price" name="price" value="0">
@endif

{{--保费--}}
<div class="introduce-parameter-row clearfix">
    <span class="introduce-parameter-title">保费</span>
    <div class="introduce-parameter-content">
        @if(!is_numeric($price)&&is_string($price))
            <span class="f18164">
            {{$price}}
            </span>
        @elseif(is_numeric($price))
            <span class="f18164">￥</span><span class="pirce" id="price1">
                {{$price  / 100 }}
            </span>
        @endif
    </div>
</div>
<script src="{{config('view_url.view_url').'js/lib/jquery-1.11.3.min.js'}}"></script>
<script src="{{config('view_url.view_url').'js/lib/birth.js'}}"></script>
<script>
$(function () {
    //多个时间循环初始化
    @foreach($sel_date as $vo)
    $.ms_DatePicker({
        YearSelector: ".sel_year_{{$vo}}",
        MonthSelector: ".sel_month_{{$vo}}",
        DaySelector: ".sel_day_{{$vo}}"
    });
    @endforeach

    var sel_day = $('.sel_day.intro');
    console.log(sel_day);
    var price  = $('#price1').text();
    $('#price2').text(price);
});
        $(function () {
            (function () {
                var app = {
                    csrfToken: $("input[name=_token]").val(),
                    requestType: 'post',
                    requestUrl: '{{url('ins/quote')}}',
                    newVal: '',
                    oldVal: '',
                    oldOption: '',
                    privatePCode: $('#private_p_code').val()
                };
                app.init = function() {
                    var that = this;
                    $('.introduce-parameter-content li').on("click", function () {
                        var $this = $(this);
//                        console.log($this.siblings('li').length);
                        if ($this.siblings('li').length < 1 || $this.index() == $this.parents('.introduce-parameter-content').find('li.label-active').index()) {
                            return ;
                        }
                        that.oldVal = $this.parent().children('.label-active').attr('data-value');   //变更选项的旧值
                        $this.parent().children('li').removeClass('label-active');
                        $this.addClass('label-active');
                        $("#quote-button").trigger('click');
                    });
                    $('.select_value').on('change',function(){
                        var $this = $(this);
                        that.oldVal = $this.children('.label-active').attr('data-value');   //变更选项的旧值
                        $("option:selected").addClass('label-active').siblings().removeClass('label-active');
                        $("#quote-button").trigger('click');
                    });
                    $('.datetime').on('change',function(){
                        var $this = $(this).parent();
                        var year = $this.children('.sel_year').find("option:selected").val();
                        var month = $this.children('.sel_month').find("option:selected").val();
                        var day = $this.children('.sel_day').find("option:selected").val();
                        // 补0
                        month < 10 && (month = '0' + month);
                        day < 10 && (day = '0' + day);
                        // 拼接
                        var date_str = year+'-'+month+'-'+day;
                        var $birthday = $this.children('.introduce-parameter-content').children().children().children();
                        // 原来的data-value
                        var data_value = $birthday.attr('data-value');
                        that.oldVal = data_value;   //变更选项的旧值
                        data_value = JSON.parse(data_value);
                        data_value['value'] = date_str;
                        $birthday.attr('data-value', JSON.stringify(data_value));
                        {{--that.oldVal = "{{date('Y-m-d',time())}}";   //变更选项的旧值--}}
                        $birthday.val(date_str);
                        $("#quote-button").trigger('click');
                    });
                    $('#starttime').on("click", function (event) {
                        var $this = $(this);
                        var value = $this.val().replace(/(\d{4,}).?(\d{2,}).?(\d{2,}).+/, "$1-$2-$3");
                        var data_value = $this.attr('data-value');
                        that.oldVal = data_value;   //变更选项的旧值
                        data_value = JSON.parse(data_value);
                        data_value['value'] = value;
                        $this.attr('data-value', JSON.stringify(data_value));
                        $("#quote-button").trigger('click');
                    });
                    $('#quote-button').on('click', function (event) {
                        event.preventDefault();
                        that.oldOption = $('#old-option').val();
                        //拼接当前所有选项被选中的值，组成新值
                        var $lis = $('.introduce-parameter-content .label-active');
                        var new_val = '[';
                        $lis.each(function(k, v){
                            new_val += $(v).attr('data-value') + ',';
                        });
                        new_val=new_val.substring(0,new_val.length-1);
                        new_val += ']';
                        that.newVal = new_val;
//                        console.log(that.oldVal);
//                        console.log(that.newVal);
//                        console.log(that.oldOption);
                        app.requestApi();
                    });
                };
                app.requestApi = function () {
                    var protect_item = $("#protect_item").val();
    //                    console.log(this.newVal);
//                    console.log(this.oldVal);
//                    console.log(this.oldOption);
                    Mask.loding('正在算费');
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': this.csrfToken
                        },
                        type: this.requestType,
                        url: this.requestUrl,
                        data: {
                            'new_val': this.newVal,
                            'old_val': this.oldVal,
                            'old_option': this.oldOption,
                            'private_p_code': this.privatePCode,
                            'old_protect_item': protect_item
                        },
                        success: function (data) {
//                            console.log(data);
                            $("#option").html(data.option_html);
                            $("#item").html(data.item_html);
                            Mask.close();
                        },

                        error: function (XMLHttpRequest, textStatus, errorThrown) {
//                            alert(XMLHttpRequest.status);
//                            alert(XMLHttpRequest.readyState);
//                            alert(errorThrown);
                            if(XMLHttpRequest.status == 400){
                                Mask.close();
                                Mask.alert('超出算费范围');
                            } else {
                                Mask.close();
                                Mask.alert('算费失败');
                            }


//                            Mask.close();
//                            Mask.alert('超出算费');
                        }
                    });
                };
                app.init();
            })();
        });
</script>
