@extends('frontend.guests.guests_layout.base')
<link rel="stylesheet/less" href="{{config('view_url.view_url')}}css/process.less"/>
<script src="{{config('view_url.view_url').'js/lib/less.min.js'}}"></script>
@section('content')
    <div class="wrapper step5">
        <div class="main notification clearfix">
            <div class="notification-left fl">
                <div class="notification-left-tip">
                    <i class="iconfont icon-yduidunpaishixin"></i><span>为了保障您的权益，请填写真实有效的信息。您填写的内容仅供投保使用，对于您的信息我们会严格保密。</span>
                </div>
                <div class="notification-left-content">
                    @foreach(json_decode($input['ins'],true)['insurance_attributes'] as $k => $v)
                        @if(key_exists($v['module_key'],json_decode($insurance_attributes,true)))
                            @php $beibaoren_key = -1; @endphp
                            <div class="person">
                                <h3 class="title">{{ $v['name'] }}</h3>
                                <table class="content-table-detail">
                                    <tbody>
                                    @foreach(json_decode($insurance_attributes,true)[$v['module_key']] as $key => $values)
                                        @if(is_array($values))
                                            @foreach($values as $ks=>$vs)
                                                @foreach($v['productAttributes'] as $vk => $vv)
                                                    @if($ks==$vv['ty_key'])
                                                        <tr>
                                                            <th>{{$vv['name']}}</th>
                                                            @if($vv['type'] == 1)
                                                                <td>{{$vs}}</td>
                                                            @endif
                                                            @if($vv['type'] == 3)
                                                                <td>{{$vs}}</td>
                                                            @endif
                                                            @if($vv['type'] == 4)
                                                                <td>
                                                                    @if(!isset(json_decode($input['ins'],true)['area'][0]))
                                                                            @php
                                                                                $proCode = $vs['province'];
                                                                                $cityCode = $vs['city'];
                                                                                $countryCode = $vs['country'];
                                                                                $proName = '';
                                                                                $cityName = '';
                                                                                $countryName = '';
                                                                                foreach (json_decode($input['ins'],true)['area'] as $value) {
                                                                                   if($value['type']=='01'&&$value['code']==$proCode){
                                                                                        $proName = $value['name'];
                                                                                   }
                                                                                    if($value['type']=='02'&&$value['code']==$cityCode){
                                                                                        $cityName = $value['name'];
                                                                                   }
                                                                                    if($value['type']=='03'&&$value['code']==$countryCode){
                                                                                        $countryName = $value['name'];
                                                                                   }
                                                                                }

                                                                                echo $proName . ' ' . $cityName . ' ' . $countryName;
                                                                            @endphp
                                                                    @else
                                                                    @php
                                                                        list($proCode, $cityCode, $countryCode) = explode(',', $vs);
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
                                                                        echo $proName . ' ' . $cityName.' '. $countryName ;
                                                                    @endphp
                                                                    @endif
                                                                </td>
                                                            @endif
                                                            @if($vv['type'] == 5)
                                                                <td>
                                                                  @if(!isset(json_decode($input['ins'],true)['jobs'])&&isset(json_decode($input['ins'],true)['job']))
                                                                        @php
                                                                            $occupationCode = $vs['occupation'];
                                                                            $jobCode = $vs['job'];
                                                                            $occupationName = '';
                                                                            $jobName = '';
                                                                            foreach (json_decode($input['ins'],true)['job'] as $value) {

                                                                                if($value['code']==$occupationCode){
                                                                                    $occupationName = $value['name'];
                                                                               }
                                                                                if($value['code']==$jobCode){
                                                                                    $jobName = $value['name'];
                                                                               }
                                                                            }

                                                                            echo $occupationName . ' ' . $jobName ;
                                                                        @endphp

                                                                    @else
                                                                    @if(!empty($vs)||!is_null($vs))
                                                                    @php
                                                                        $job_id = explode('-',$vs);
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
                                                                    echo implode('-',$job_name);
                                                                    @endphp
                                                                    @endif
                                                                    @endif
                                                                </td>
                                                            @endif
                                                            @if($vv['type'] == 6)
                                                                <td>{{$vs}}</td>
                                                            @endif
                                                            @if(in_array($vv['type'], [0, 9]))
                                                                @foreach($vv['attributeValues'] as $ak => $av)
                                                                    @if($vs ==$av['ty_value'])
                                                                    <td>{{$av['value']}}</td>
                                                                    @endif
                                                                @endforeach
                                                            @endif
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            @endforeach
                                        @else
                                            @foreach($v['productAttributes'] as $vk => $vv)
                                            @if($key== $vv['ty_key'])
                                            <tr>
                                                <th>{{$vv['name']}}</th>
                                                @if($vv['type'] == 1)
                                                    <td>{{$values}}</td>
                                                @endif
                                                @if($vv['type'] == 3)
                                                    <td>{{$values}}</td>
                                                @endif
                                                @if($vv['type'] == 4)
                                                    <td>
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

                                                    </td>
                                                @endif
                                                @if($vv['type'] == 5)
                                                    <td>
                                                        @if(!empty($values)||!is_null($values))
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
                                                            echo implode('-',$job_name);
                                                            @endphp
                                                        @endif
                                                    </td>
                                                @endif
                                                @if($vv['type'] == 6)
                                                    <td>{{$values}}</td>
                                                @endif
                                                @if(in_array($vv['type'], [0, 9]))
                                                    @foreach($vv['attributeValues'] as $ak => $av)
                                                        @if($values ==$av['ty_value'])
                                                            <td>{{$av['value']}}</td>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </tr>
                                            @endif
                                            @endforeach
                                        @endif
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    @endforeach
                    <div class="buttonbox"><button class="btn btn-a4d790" onclick="window.history.go(-1)">修改信息</button><button class="btn btn-f18164" onclick="insureSubmit()">提交订单</button></div>
                </div>
            </div>
            @include('frontend.guests.product.product_notice')
        </div>
    </div>
    <form class="form-horizontal" method="post"  id="form" action="{{ url('ins/insure_post')}}" enctype="multipart/form-data">
        {{ csrf_field() }}
        <input type="hidden" name="input" value="{{json_encode($input)}}">
        <input type="hidden" name="insurance_attributes" value="{{$insurance_attributes}}">
        <input type="hidden" name="identification" value="{{$identification}}">
        {{--@if(isset($b_path))--}}
            {{--<input type="hidden" name="b_file" value="{{$file_data}}">--}}
        {{--@endif--}}
    </form>
    <script src="{{config('view_url.view_url')}}js/lib/laydate.js"></script>
    <script src="{{config('view_url.view_url')}}js/information1.js"></script>
    <script>
        $(function () {
            var td  = $("table td").text();
            console.log(td);
        });
        function insureSubmit() {
            $(form).submit();
        }
    </script>
@stop