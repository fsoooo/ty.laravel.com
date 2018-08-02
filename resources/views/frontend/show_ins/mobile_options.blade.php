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

    @if($protectItemId < 1)
        <div class="introduce-parameter-row clearfix" @if(!$v['display']) style="display: none;" @endif>
            <ul class="content-list">
                @if(in_array($v['type'], [2, 3, 4, 6]))
                    <li class="clearfix">
                        <span class="bold">{{$v['name']}}</span>
                        <div class="select-box">
                            @foreach($v['values'] as $vk => $vv)
                                <?php $unit = isset($vv['unit']) ? $vv['unit'] : '' ?>
                                @if($vv['type'] == 1)
                                    <button type="button" class='btn-select {{$s_arr[$v['ty_key']] == ($vv['ty_value'] . $unit) ? 'label-active' : ''}}' data-value='{"protectItemId":"{{$protectItemId}}","key":"{{$ty_key}}","value":"{{$vv['ty_value'].$unit}}","sort":{{$v['sort']}}}'>
                                        @if(isset($vv['name'])){{$vv['name'] . $unit}}@else{{$vv['ty_value'] . $unit}}@endif
                                    </button>
                                @else
                                    @for($i=$vv['min']; $i<=$vv['max']; $i+=$vv['step'])
                                        <button type="button"  class='btn-select {{$s_arr[$ty_key] == ($i . $unit) ? 'label-active' : ''}}' data-value='{"protectItemId":"{{$protectItemId}}","key":"{{$ty_key}}","value":"{{$i.$unit}}","sort":{{$v['sort']}}}'>
                                            {{$i . $unit}}
                                        </button>
                                    @endfor
                                @endif
                            @endforeach
                        </div>
                    </li>
                @elseif (in_array($v['type'], [0]))
                    <div class="introduce-parameter-row clearfix" >
                        <ul class="content-list">
                            <li class="clearfix ">
                                <span class="bold">{{$v['name']}}</span>
                                <div class="select-box">
                                    @foreach ($v['values'] as $vk => $vv)
                                        <?php $unit = isset($vv['unit']) ? $vv['unit'] : '' ?>
                                        @if($vv['type'] == 2)
                                            @for($i = $vv['min']; $i <= $vv['max']; $i+=$vv['step'])
                                                <button type="button"  class='btn-select {{ $s_arr[$ty_key] == $i.$unit ? 'label-active' : '' }}' data-value='{"protectItemId":"{{$protectItemId}}","key":"{{$ty_key}}","value":"{{$i.$unit}}","sort":{{$v['sort']}}}' {{ $s_arr[$ty_key] == $i.$unit ? 'selected' : '' }}   >
                                                    @if(!empty($vv['name']))
                                                        {{$vv['name'] . $unit}}
                                                    @else
                                                        {{$i.$unit}}
                                                    @endif
                                                </button>
                                            @endfor
                                        @else
                                            <button type="button"  class='btn-select {{ $s_arr[$ty_key] == ($vv['ty_value'] . $unit) ? 'label-active' : '' }}' data-value='{"protectItemId":"{{$protectItemId}}","key":"{{$ty_key}}","value":"{{$vv['ty_value'].$unit}}","sort":{{$v['sort']}}}' {{ $s_arr[$ty_key] == ($vv['ty_value'] . $unit) ? 'selected' : '' }} >
                                                @if(!empty($vv['name']))
                                                    {{$vv['name'] . $unit}}
                                                @else
                                                    {{$vv['ty_value'] . $unit}}
                                                @endif
                                            </button>
                                        @endif
                                    @endforeach
                                    {{--<i class="iconfont icon-gengduo"></i>--}}
                                </div>
                            </li>
                        </ul>
                    </div>
                @elseif (in_array($v['type'], [1]))
                    <li class="pickerfour">
                        <span class="bold">{{$v['name']}}</span>
                        <input id="date" type="text"  value="{{ $s_arr[$v['ty_key']] ?: '' }}"   placeholder="请选择">
                        <input  type="hidden"  value="{{ $s_arr[$v['ty_key']] ?: '' }}"   class="label-active" data-value='{"protectItemId":"{{$protectItemId}}","key":"{{$v['ty_key']}}","value":"{{$s_arr[$v['ty_key']]}}","sort":{{$v['sort']}}}'>
                        <i class="iconfont icon-gengduo"></i>
                    </li>
                @endif
				
            </ul>
        </div>
    @else
        <div class="introduce-parameter-row clearfix" @if(!$v['display']) style="display: none;" @endif>
            <ul class="content-list">
                <li class="clearfix">
                    <span class="bold">{{$v['name']}}</span>
                    <div class="select-box">
                        @foreach($v['values'] as $vk => $vv)
                            @if($vv['type'] == 1)
                                <button type="button"  class='btn-select {{$s_arr[$protectItemId] == ($vv['ty_value'] . $unit) ? 'label-active' : ''}}' data-value='{"protectItemId":"{{$protectItemId}}","key":"{{$ty_key}}","value":"{{$vv['ty_value'] . $vv['unit']}}","sort":{{$v['sort']}}}'>
                                    @if(isset($vv['name'])){{$vv['name'] . $unit}}@else{{$vv['ty_value'] . $unit}}@endif
                                </button>
                            @else
                                @for($i=$vv['min'];$i<=$vv['max'];$i+=$vv['step'])
                                    <button type="button"  class='btn-select {{$s_arr[$protectItemId] == ($i . $vv['unit']) ? 'label-active' : ''}}' data-value='{"protectItemId":"{{$protectItemId}}","key":"{{$ty_key}}","value":"{{$i . $vv['unit']}}","sort":{{$v['sort']}}}'>
                                        {{$i . $vv['unit']}}
                                    </button>
                                @endfor
                            @endif
                        @endforeach
                    </div>
                </li>
            </ul>
        </div>
    @endif
@endforeach
{{-- 算费按钮 --}}
<button style="display: none;" id="quote-button"></button>
{{--算费参数结束--}}
{{--保费--}}
<input type="hidden" id="old-option" name="option" value="{{json_encode($restrict_genes, JSON_UNESCAPED_UNICODE)}}">
<input type="hidden" id="selected" name="selected" value="{{json_encode($selected_options, JSON_UNESCAPED_UNICODE)}}">
<input type="hidden" id="price" name="price" value="{{$price}}">
{{--保费--}}
<div class="introduce-parameter-row clearfix" hidden>
    <span class="introduce-parameter-title">保费</span>
    <div class="introduce-parameter-content" >
        <span class="f18164"  >￥</span><span class="pirce" id="price">{{$price  / 100 . '.00'}} </span>
    </div>
</div>
<script src="{{config('view_url.view_url').'js/lib/jquery-1.11.3.min.js'}}"></script>
<script>
    var price = "{{$price  / 100}}";
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
                $('.introduce-parameter-row ul li button').on("click", function () {
                    var $this = $(this);
                    that.oldVal = $this.parent().children('.label-active').attr('data-value');   //变更选项的旧值
                    $this.parent().children('button').removeClass('label-active');
                    $this.addClass('label-active');
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
				$('.pickerfour').on('tap',function() {
					var _this = $(this);
					var picker = new mui.DtPicker({
						"type": "date",
						"beginYear":1900
					});
					picker.show(function(rs) {
						_this.find("input[type='text']").val(rs.text);
						_this.find("input[type='hidden']").val(rs.text);
                        var val = JSON.parse(_this.find("input[type='hidden']").attr('data-value'));
                        val.value = rs.text;
                        that.oldVal = JSON.stringify(val);
                        _this.find("input[type='hidden']").attr('data-value',that.oldVal);
//                    console.log(that.oldVal);
                    $("#quote-button").trigger('click');
					});
//                    that.oldVal = _this.find("input[type='hidden']").attr('data-value');   //变更选项的旧值
//                    console.log(that.oldVal);
//                    $("#quote-button").trigger('click');
				});
                $('#quote-button').on('click', function (event) {
                    event.preventDefault();
                    that.oldOption = $('#old-option').val();
                    //拼接当前所有选项被选中的值，组成新值
                    var $lis = $('.label-active');
                    var new_val = '[';
                    $lis.each(function(k, v){
                        new_val += $(v).attr('data-value') + ',';
                    });
                    new_val=new_val.substring(0,new_val.length-1);
                    new_val += ']';
                    that.newVal = new_val;
//                    console.log('new:'+that.newVal);
//                    console.log('old:'+that.oldVal);
//                    console.log(that.oldOption);
                    app.requestApi();
                });
            };
            app.requestApi = function () {
                var protect_item = $("#protect_item").val();
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
                        $("#option").html(data.option_html);
                        $("#item ul").html(data.item_html);
                        $("#show_price").html('￥'+price);
                    }
                });
            };
            app.init();
        })();
    });
</script>