<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>天眼互联-科技让保险无限可能</title>
    <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
    <link rel="stylesheet" href="{{config('view_url.mobile_group_ins')}}css/lib/mui.min.css">
    <link rel="stylesheet" href="{{config('view_url.mobile_group_ins')}}css/lib/iconfont.css" />
    <link rel="stylesheet" href="{{config('view_url.mobile_group_ins')}}css/common.css" />
    <link rel="stylesheet" type="text/css" href="{{config('view_url.mobile_group_ins')}}css/preview_confirm.css"/>
</head>

<body>
<div class="main">
    <header class="mui-bar mui-bar-nav">
        <a class="mui-icon mui-icon-back mui-pull-left mui-action-back"></a>
        <h1 class="mui-title">信息预览</h1>
    </header>
    <div class="mui-content">
        <div class="mui-scroll-wrapper">
            <div class="mui-scroll">
                @foreach(json_decode($input['ins'],true)['insurance_attributes'] as $k => $v)
                    @if(key_exists($v['module_key'],json_decode($insurance_attributes,true)))
                        @php $beibaoren_key = -1; @endphp
                        <div class="form-wrapper form-insure">
                            <div class="title">{{ $v['name'] }}</div>
                            <ul class="import-client" style="display: block;">
                                @foreach(json_decode($insurance_attributes,true)[$v['module_key']] as $key => $values)
                                    @if(is_array($values))
                                    @else
                                        @foreach($v['productAttributes'] as $vk => $vv)
                                            @if($key== $vv['ty_key'])
                                            <li>
                                                <span class="name">{{$vv['name']}}</span>
                                                @if($vv['type'] == 1)
                                                    <input type="text" value="{{$values}}" readonly/>
                                                @endif
                                                @if($vv['type'] == 3)
                                                    <input type="text" value="{{$values}}" readonly/>
                                                @endif
                                                @if($vv['type'] == 4)
                                                    <input type="text" value="" readonly/>
                                                    @php
                                                    if(!strstr($values,',')&&is_string($values)){
                                                    echo $values;
                                                    }else{
                                                    list($proCode, $cityCode, $countryCode) = explode(',', $values);
                                                    $proName = '';
                                                    $cityName = '';
                                                    $countryName = '';
                                                    foreach (json_decode($input['ins'],true)['area'] as $province) {
                                                    if ($province['code'] == $proCode) {
                                                    $proName = $province['name'];
                                                    foreach ($province['cities'] as $city) {
                                                    if ($city['code'] == $cityCode) {
                                                    $cityName = $city['name'];
                                                    foreach ($city['countries'] as $country) {
                                                    if ($country['code'] == $countryCode) {
                                                    $countryName = $country['name'];
                                                    }
                                                    }
                                                    }
                                                    }
                                                    }
                                                    }
                                                    echo $proName . ',' . $cityName . ',' . $countryName;
                                                    }
                                                    @endphp

                                                @endif
                                                @if($vv['type'] == 5)
                                                    @if(!empty($values)||!is_null($values))
                                                    <input type="text" value="" readonly/>
                                                        @php
                                                        $job_id = explode('-',$values);
                                                        $job_name = [];
                                                        foreach (json_decode($input['ins'],true)['jobs'] as $one){
                                                        if($one['id']==$job_id[0]){
                                                        $job_name[0] = $one['name'];
                                                        if(isset($one['_child'])){
                                                        foreach ($one['_child'] as $two){
                                                        if($two['id']==$job_id[1]){
                                                        $job_name[1] = $two['name'];
                                                        if(isset($two['_child'])){
                                                        foreach ($two['_child'] as $three){
                                                        if($three['id']==$job_id[2]){
                                                        $job_name[2] = $three['name'];
                                                        }
                                                        }
                                                        }
                                                        }
                                                        }
                                                        }
                                                        }
                                                        }
                                                        echo implode('-',$job_name);@endphp
                                                    @endif
                                                @endif
                                                @if($vv['type'] == 6)
                                                    <input type="text" value="{{$values}}" readonly/>
                                                @endif
                                                @if(in_array($vv['type'], [0, 9]))
                                                    @foreach($vv['attributeValues'] as $ak => $av)
                                                        @if($values ==$av['ty_value'])
                                                            <input type="text" value="{{$av['value']}}" readonly/>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </li>
                                            @endif
                                        @endforeach
                                    @endif
                                @endforeach
                            </ul><ul class="import-client" style="display: block;">
                            @if($v['module_key'] == 'ty_beibaoren')
                                @foreach($insured_lists as $ik => $iv)
                                <li>
                                    <span class="name">被保人</span>
                                    <input type="text" value="{{$iv['ty_beibaoren_name']}}" readonly/>
                                </li>
                                @endforeach
                            @endif</ul>
                        </div>
                    @endif
                @endforeach
                <div class="form-wrapper">
                    <div class="title">产品信息</div>
                    <ul class="import-product" style="display: block;">
                        <li>
                            <span class="name">产品名称</span>
                            <input id="pname" type="text" value="{{$product_data['product_name']}}" readonly/>
                        </li>
                        {{--<li class="show">--}}
                            {{--<span class="name">产品期限</span>--}}
                            {{--<input type="text" value="保至100周岁" readonly/>--}}
                        {{--</li>--}}
                        <li class="pickerDate">
                            <span class="name">保险金额</span>
                            <input id="pprice" type="text" value="{{$final_price/100}}元" readonly/>
                        </li>
                        <li class="show">
                            <span class="name">缴费期限</span>
                            @if(preg_replace('/\D/s','',$product_data['base_stages_way']) == 0)
                            <input type="text" value="趸交" readonly/>
                                @else
                                <input type="text" value="{{preg_replace('/\D/s','',$product_data['base_stages_way'])}}年缴" readonly/>
                                @endif
                        </li>
                        <li class="show">
                            <span class="name">首年保费</span>
                            @if(preg_replace('/\D/s','',$product_data['base_stages_way']) == 0)
                                <input type="text" value="{{$final_price/100}}元" readonly/>
                            @else
                                <input type="text" value="{{$final_price/100/preg_replace('/\D/s','',$product_data['base_stages_way'])}}元" readonly/>
                            @endif
                        </li>
                    </ul>
                </div>
                {{--<div class="form-wrapper">--}}
                    {{--<div class="title">保单拍照上传<span class="color-positive" style="font-size: .2rem;">（一次最多上传10张图片，大小不超过5M）</span></div>--}}
                    {{--<ul class="photos-wrapper">--}}
                        {{--<li class="photos-item">--}}
                            {{--<img src="image/img-underline.png" alt="" />--}}
                        {{--</li>--}}
                    {{--</ul>--}}
                {{--</div>--}}
            </div>
        </div>
        <form action="/ins/group_ins/insure_post" id="form_data" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <input type="hidden" name="input" value="{{json_encode($input)}}">
            <input type="hidden" name="insurance_attributes" value="{{$insurance_attributes}}">
            <input type="hidden" name="identification" value="{{$identification}}">
        </form>
        <div class="buttonsbox">
            <button class="btn btn-edit" id="back" type="button">修改</button>
            <button class="btn btn-back" id="next">下一步</button>
        </div>
    </div>
</div>

<script src="{{config('view_url.mobile_group_ins')}}js/lib/jquery-1.11.3.min.js"></script>
<script src="{{config('view_url.mobile_group_ins')}}js/lib/mui.min.js"></script>
<script src="{{config('view_url.mobile_group_ins')}}js/common.js"></script>
<script>
    $("#back").on('click',function(){
        window.history.back();
    })
    $("#next").on('click',function(){
        $("#form_data").submit();
    })
</script>
</body>

</html>











