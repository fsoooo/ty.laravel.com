@foreach($ins['insurance_attributes'] as $k => $v)
    @if($k ==2)
        @php $beibaoren_key = 0; @endphp
        {{--被保人信息表--}}
        @foreach($v['productAttributes'] as $vk => $vv)
            @if($vv['type'] == 1)
                <li class="pickerfour">
                    <span class="name">{{$vv['name']}}</span>
                    <input id="date"   style="font-size: 16px;color:#888888;" name="insurance_attributes[{{ $v['module_key'] }}][{{ $beibaoren_key }}][{{ $vv['ty_key'] }}]"  class="common-input" value="{{date('Y-m-d',time())}}">
                    <i class="iconfont icon-gengduo"></i>
                </li>
            @endif
            @if($vv['type'] == 3)
                <li class="approve">
                    <span class="name">{{$vv['name']}}</span>
                    <input id="name1" type="text" class="w320"  class="common-input" placeholder="{{$vv['name']}}" name="insurance_attributes[{{ $v['module_key'] }}][{{ $beibaoren_key }}][{{ $vv['ty_key'] }}]" >
                </li>
            @endif
            @if($vv['type']==5)
                <li class="pickerarea" data-options ="{{json_encode($ins['jobs'])}}">
                    <span class="name">{{$vv['name']}}</span>
                    <input id="areaText" type="text" placeholder="必填" />
                    <input type="hidden" class="areaValue"  id="job_val_{{$beibaoren_key}}" name="insurance_attributes[{{ $v['module_key'] }}][{{ $beibaoren_key }}][{{ $vv['ty_key'] }}]">
                    <i class="iconfont icon-gengduo"></i>
                </li>
            @endif
            @if($vv['type'] == 6)
                <li class="approve">
                    <span class="name">{{$vv['name']}}</span>
                    @foreach($vv['attributeValues'] as $ak => $av)
                        <input id="name1"  class="btn btn-default" name="insurance_attributes[{{ $v['module_key'] }}][{{ $beibaoren_key }}][{{ $vv['ty_key'] }}]"  value="{{$av['ty_value']}}" />{{$av['value']}}
                    @endforeach
                </li>
            @endif
            @if(in_array($vv['type'], [0, 9]))
                <li class="approve pickerone" data-options="{{json_encode($vv['attributeValues'])}}">
                    <span class="name">{{$vv['name']}}</span>
                    {{--<input id="certificateimg1" hidden="hidden" type="file" name="insurance_attributes[{{ $v['module_key'] }}][{{ $vv['ty_key'] }}]" onchange="upload('#certificateimg1');" accept="image/*" capture="camera"/>--}}
                    <input class="inputhidden" hidden="hidden" type="text"  name="insurance_attributes[{{ $v['module_key'] }}][{{ $beibaoren_key }}][{{ $vv['ty_key'] }}]"  value=""/>
                    <input id="certificatetype1" type="text" placeholder="请选择"/>
                    <i class="iconfont icon-gengduo"></i>
                </li>
            @endif
        @endforeach
        @php $beibaoren_key++; @endphp
        <a href="javascript:;" class="btn btn-confirm done">确定</a>
        @endif
@endforeach
<script src="{{config('view_url.view_url')}}mobile/js/lib/jquery-1.11.3.min.js"></script>
<script src="{{config('view_url.view_url')}}mobile/js/lib/mui.min.js"></script>
<script src="{{config('view_url.view_url')}}mobile/js/lib/mui.picker.all.js"></script>
<script src="{{config('view_url.view_url')}}mobile/js/common.js"></script>
<script src="{{config('view_url.view_url')}}mobile/js/applicant.js"></script>
<script>
    $(function(){
        $('body').on('click','.done',function(){
            var $arr = [];
            var token = $("input[name=_token]").val();
            $arr= $('form').serializeArray();
            var n = 2;
            $.ajax({
                url: "/ins/group_submit",
                type: "post",
                data: {'data':$arr,'n':n,'_token':token},
                dataType: "json",
                success: function (data) {
                    if (data['status'] == 200){
                        $(".fill-wrapper").html(data['data']);
                    }else{
                        alert('')
                    }
                }
            });
        })
    })
</script>
