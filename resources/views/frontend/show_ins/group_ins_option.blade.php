<?php
$selected = isset($selected_options['genes']) ? $selected_options['genes'] : $selected_options;
$s_arr = array();

foreach($selected as $k => $v){
    if(isset($v['protectItemId']) && ($v['protectItemId']>0)){
        $s_arr[$v['protectItemId']] = $v['value'];
    }else{
        $s_arr[$v['ty_key']] = $v['value'];
    }
}
?>
{{--{{dd($restrict_genes)}}--}}
<ul class="select-wrapper">
@foreach($restrict_genes as $k => $v)
    <?php
    $protectItemId = (isset($v['protectItemId']) && ($v['protectItemId'] > 0)) ? $v['protectItemId'] : 0;
    $ty_key = isset($v['ty_key']) ? $v['ty_key'] : '';
    ?>
    @if(isset($v['protectItemId']) && ($v['protectItemId'] > 0))
            <li>
                <span class="name">{{$v['name']}}</span>
                @foreach($v['values'] as $vk => $vv)
                    <?php $unit = isset($vv['unit']) ? $vv['unit'] : '' ?>
                    @if($vv['type'] == 1)
                        <span class='item {{$s_arr[$protectItemId] == ($vv['ty_value'] . $unit) ? 'active label-active' : ''}}' data-value='{"protectItemId":"{{$protectItemId}}","key":"{{$ty_key}}","value":"{{$vv['ty_value'] . $vv['unit']}}","sort":{{$v['sort']}}}'>
                               @if(isset($vv['name'])){{$vv['name'] . $unit}}@else{{$vv['ty_value'] . $unit}}@endif
                        </span>
                    @else
                        @for($i=$vv['min']; $i<=$vv['max']; $i+=$vv['step'])
                            <span class='item {{$s_arr[$protectItemId] == ($i . $unit) ? 'active label-active' : ''}}' data-value='{"protectItemId":"{{$protectItemId}}","key":"{{$ty_key}}","value":"{{$i . $vv['unit']}}","sort":{{$v['sort']}}}'>
                                    {{$i . $unit}}
                            </span>
                        @endfor
                    @endif
                @endforeach
            </li>
    @else
            <li>
                <span class="name">{{$v['name']}}</span>
                {{--列出来的选项--}}
                @if(in_array($v['type'], [2,3, 4, 6]))
                    @foreach($v['values'] as $vk => $vv)
                        <?php $unit = isset($vv['unit']) ? $vv['unit'] : '' ?>
                        @if($vv['type'] == 1)
                            <span class='item {{$s_arr[$v['ty_key']] == ($vv['ty_value'] . $unit) ?  'active label-active' : ''}}' data-value='{"protectItemId":"{{$protectItemId}}","key":"{{$ty_key}}","value":"{{$vv['ty_value'].$unit}}","sort":{{$v['sort']}}}'>
                               @if(isset($vv['name'])){{$vv['name'] . $unit}}@else{{$vv['ty_value'] . $unit}}@endif
                            </span>
                        @else
                            @for($i=$vv['min']; $i<=$vv['max']; $i+=$vv['step'])
                                <span class='item {{$s_arr[$v['ty_key']] == ($vv['ty_value'] . $unit) ? 'active label-active' : ''}}' data-value='{"protectItemId":"{{$protectItemId}}","key":"{{$ty_key}}","value":"{{$i.$unit}}","sort":{{$v['sort']}}}'>
                                    {{$i . $unit}}
                                </span>
                            @endfor
                        @endif
                    @endforeach
                @elseif (in_array($v['type'], [0]))
                    {{--下拉框--}}
                    <select class="item select_value">
                        @foreach ($v['values'] as $vk => $vv)
                            <?php $unit = isset($vv['unit']) ? $vv['unit'] : '';?>
                            @if($vv['type'] == 2)
                                @for($i = $vv['min']; $i <= $vv['max']; $i+=$vv['step'])
                                    <option value="" data-value='{"protectItemId":"{{$protectItemId}}","key":"{{$ty_key}}","value":"{{$i.$unit}}","sort":{{$v['sort']}}}' {{ $s_arr[$ty_key] == $i.$unit ? 'class=label-active' : '' }} {{ $s_arr[$ty_key] == $i.$unit ? 'selected' : '' }}>
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
                @elseif (in_array($v['type'], [1]))
                    @php $value = $s_arr[$v['ty_key']] ? $s_arr[$v['ty_key']] : date('Y-m-d',time()) @endphp
                @endif
            </li>
    @endif
@endforeach
</ul>


{{-- 算费按钮 --}}
<button style="display: none;" id="quote-button"></button>
<input type="hidden" name="_token" value="{{csrf_token()}}">

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
<div class="cont-main-contentr">
    <div class="contentrs">
        <div class="content-s">保费计算</div>
        <div class="content-s1"></div>
        <ul class="formd">
            <li><span>员工人数</span></li>
            <li>
                <input type="number" name="count_people" value="" />
                <span>人</span>
            </li>
            <li>
                <span>保费</span><span style="color: #00a2ff;" id="money">{{$price/ 100 }}</span>元/人
            </li>
            <li>
                <span>保费共计:</span><span style="color: #00a2ff;" id="count"></span>
            </li>
        </ul>
        <button type="button" disabled>立即投保</button>
    </div>
</div>
<script src="{{config('view_url.view_url').'js/lib/jquery-1.11.3.min.js'}}"></script>
<script src="{{config('view_url.view_url').'js/lib/birth.js'}}"></script>
<script>
    $(function () {
//        $.ms_DatePicker({
//            YearSelector: ".sel_year",
//            MonthSelector: ".sel_month",
//            DaySelector: ".sel_day"
//        });
        var price  = $('#price').text();
    });
    $(function () {
        (function () {
            var app = {
                csrfToken: $("input[name=_token]").val(),
                requestType: 'post',
                requestUrl: '{{url('ins/group_ins/quote')}}',
                newVal: '',
                oldVal: '',
                oldOption: '',
                privatePCode: $('#private_p_code').val()
            };
            app.init = function() {
                var that = this;
                $('.select-wrapper span').on("click", function () {
                    var $this = $(this);
                        console.log($this.parents('.select-wrapper').find('span.label-active').index());
                    if ($this.siblings('span').length < 1 || $this.index() == $this.parents('.select-wrapper').find('li.span.label-active').index()) {
                        return ;
                    }
                    that.oldVal = $this.parent().children('.label-active').attr('data-value');   //变更选项的旧值
                    $this.parent().children('span').removeClass('label-active');
                    $this.addClass('label-active');
                    $("#quote-button").trigger('click');
                });
                $('.select_value').on('change',function(){
                    var $this = $(this);
                    that.oldVal = $this.children('.label-active').attr('value');   //变更选项的旧值
                    $("option:selected").addClass('label-active').siblings().removeClass('label-active');
                    $("#quote-button").trigger('click');
                });
//                日期
                $('.datetime').on('change',function(){
                    var year = $('.sel_year').find("option:selected").val();
                    var month = $('.sel_month').find("option:selected").val();
                    var day = $('.sel_day').find("option:selected").val();
                    // 补0
                    month < 10 && (month = '0' + month);
                    day < 10 && (day = '0' + day);
                    // 拼接
                    var date_str = year+'-'+month+'-'+day;
                    var $birthday = $('#bithday');
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
//                日期
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
                    var $span = $('.select-wrapper .label-active');
                    var new_val = '[';
                    $span.each(function(k, v){
                        new_val += $(v).attr('data-value') + ',';
                    });
                    new_val=new_val.substring(0,new_val.length-1);
                    new_val += ']';
                    that.newVal = new_val;
                    app.requestApi();
                });
            };
            app.requestApi = function () {
                var protect_item = $("#protect_item").val();
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
                            console.log(data);
                        $("#option").html(data.option_html);
                        $("#item").html(data.item_html);
                        Mask.close();
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        if(XMLHttpRequest.status == 400){
                            Mask.close();
                            Mask.alert('超出算费范围');
                        } else {
                            Mask.close();
                            Mask.alert('算费失败');
                        }
                    }
                });
            };
            app.init();
        })();
    });
</script>
<script>
    //必选保单的可选状态
    function Choose(_this){
        var that=$(_this);
        var label = $(_this).parent();
        var divObjs=label.parent();
        var lis=divObjs.parent();
        if(lis.hasClass('activee')){
            lis.removeClass('activee').addClass('choose');
            var inputs=lis.find('input');
            inputs.checked=false;
        }else{
            lis.addClass('activee').removeClass('choose');
            var inputs=lis.find('input');
//				inputs.checked=true;
        }
        aaa();
    }
    //立即投保的非空校验
    function aaa(){
        var inputs = $('.contentrs').find('input');  //找到右边的所以的input
        var btn = $('.contentrs').find('button')[0]; //找到button按钮
        inputs.each(function(index){
            if(!$(this).val()){
                btn.disabled = true;
                return false;
            }
            if(index == inputs.length-1){
                $("#count").html($('#money').html() * ($(this).val())+'元');
                btn.disabled = false;
            }
        });
    }
    $('.contentrs').find('input').bind('input porpertychange',function(){
        aaa();
    });
</script>





