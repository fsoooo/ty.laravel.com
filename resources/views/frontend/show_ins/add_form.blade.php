@extends('frontend.guests.guests_layout.base')
<link rel="stylesheet/less" href="{{config('view_url.view_url')}}css/process.less"/>
<script src="{{config('view_url.view_url').'js/lib/less.min.js'}}"></script>
<script src="{{config('view_url.view_url').'js/lib/jquery-1.11.3.min.js'}}"></script>
<script src="{{config('view_url.view_url').'js/pc_applicant.js'}}"></script>
<style>
    select{width: 200px;height: 35px;font-size: 16px;color:#888888 ; border: 0.1px solid #D0D0D0;margin-right: 5px}
    .two{display:none;}
    .three{display:none;}
    .red{border:1px solid red;}
    /**/
    input::-webkit-input-placeholder { /* WebKit browsers */
        font-size:12px;
    }
    input:-moz-placeholder { /* Mozilla Firefox 4 to 18 */
        font-size:12px;
    }
    input::-moz-placeholder { /* Mozilla Firefox 19+ */
        font-size:12px;
    }
    input:-ms-input-placeholder { /* Internet Explorer 10+ */
        font-size:12px;
    }
</style>
@section('content')
    {{--0：下拉框 1：日历 2：日历+下拉框 3：文本输入框 4：地区 5：职业 6：文本 9:单选--}}

        <div class="wrapper step3">
            <div class="main notification clearfix">
                <div class="notification-left fl">
                    <div class="notification-left-tip">
                        <i class="iconfont icon-yduidunpaishixin"></i><span><b>为了保障您的权益，请填写真实有效的信息。您填写的内容仅供投保使用，对于您的信息我们会严格保密。</b></span>
                    </div>
                    <div class="notification-left-content">
                        <form class="form-horizontal" method="post"  id="form" action="{{ url('ins/confirmform')}}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <input type="hidden" name="identification" value="{{ $identification }}" >
                        <input type="hidden" name="product" value="{{json_encode($product)}}" >
                        <input type="hidden" name="ins" value="{{json_encode($ins)}}" >
                        <input type="hidden" name="json" value="{{json_encode($json)}}">
                        <?php
                        //dump(132);die;
                        ?>
                        @foreach($ins['insurance_attributes'] as $k => $v)
                            @php $beibaoren_key = -1; @endphp
                            @if($v['module_key'] == 'ty_base')
                                {{--基础信息--}}
                                <h3 class="title">{{ $v['name'] }}</h3>
                                @foreach($v['productAttributes'] as $vk => $vv)
                                    <div class="date">
                                        <span class="name"><i class="f18164">*</i>{{$vv['name']}}</span>
                                        @if($vv['type'] == 1)
                                            <input type="date" style="font-size: 16px;color:#888888;" regex="{{$vv['regex']?? ''}}" msg="{{$vv['errorRemind']?? ''}}" id="{{$vv['ty_key']}}" name="insurance_attributes[{{ $v['module_key'] }}][{{$vv['ty_key']}}]" class="common-input" value="">
                                        @endif
                                        @if($vv['type'] == 3)
                                            <input type="text" class="common-input" regex="{{$vv['regex']?? ''}}" msg="{{$vv['errorRemind']?? ''}}" placeholder="{{$vv['name']}}" name="insurance_attributes[{{ $v['module_key'] }}][{{ $vv['ty_key'] }}]" id="{{$vv['ty_key']}}" >
                                            <span class="error"></span>
                                        @endif
                                        @if($vv['type'] == 4)
                                            {{--todo 城市联动--}}
                                        @endif
                                        @if($vv['type'] == 5)
                                            {{--todo 职业联动--}}
                                        @endif
                                        @if($vv['type'] == 6)
                                            @foreach($vv['attributeValues'] as $ak => $av)
                                                <input class="common-input btn btn-default" regex="{{$vv['regex']?? ''}}" msg="{{$vv['errorRemind']?? ''}}" name="insurance_attributes[{{ $v['module_key'] }}][{{ $vv['ty_key'] }}]" value="{{$av['ty_value']}}" />{{$av['value']}}
                                            @endforeach
                                        @endif
                                        @if(in_array($vv['type'], [0, 9]))
                                            <select class="common-input code-select" name="insurance_attributes[{{ $v['module_key'] }}][{{ $vv['ty_key'] }}]">
                                                @foreach($vv['attributeValues'] as $ak => $av)
                                                    <option value="{{$av['ty_value']}}">{{$av['value']}}</option>
                                                @endforeach
                                            </select>
                                        @endif
                                        &nbsp;&nbsp;&nbsp;<span style="color: red">根据保险公司要求至少选择第二天作为起保日期</span>
                                    </div>
                                @endforeach
                                {{--基础信息--}}
                            @elseif ($v['module_key'] == 'ty_toubaoren')
                                {{--投保人信息--}}
                                <div class="person" id="{{ $v['module_key'] }}">
                                    <h3 class="title">{{ $v['name'] }}</h3>
                                    <ul>
                                        @foreach($v['productAttributes'] as $vk => $vv)
                                            <li id="{{$vv['type']}}">
                                                <span class="name"><i class="f18164">*</i>{{$vv['name']}}</span>
                                                @if($vv['type'] == 1)
                                                    <input type="date" regex="{{$vv['regex']?? ''}}" msg="{{$vv['errorRemind']?? ''}}" style="font-size: 16px;color:#888888;" id="{{$vv['ty_key']}}"  name="insurance_attributes[{{ $v['module_key'] }}][{{ $vv['ty_key'] }}]" class="common-input" value="{{date('Y-m-d',time())}}">
                                                @endif
                                                @if($vv['type'] == 3)
                                                    <input type="text" regex="{{$vv['regex']?? ''}}" msg="{{$vv['errorRemind']?? ''}}"  class="w320"  class="common-input" placeholder="{{$vv['name']}}" id="{{ $vv['ty_key'] }}" name="insurance_attributes[{{ $v['module_key'] }}][{{ $vv['ty_key'] }}]">
                                                    <span class="error"></span>
                                                @endif
                                                @if($vv['type'] == 4)
                                                    @if(isset($ins['area']))
                                                        @if(isset($ins['area'][40]['parent_code']))
                                                            <span class="area_box">
                                                            <span class="type_is_area"></span>
                                                            <input class="area" name="insurance_attributes[{{ $v['module_key'] }}][{{ $vv['ty_key'] }}]" style="display: none;" />
                                                            <select name="insurance_attributes[{{ $v['module_key'] }}][{{ $vv['ty_key'] }}][province]" class="province">
                                                                @foreach($ins['area'] as $item)
                                                                    @if($item['type']=='01')
                                                                        <option value="{{ $item['code'] }}" data-id="{{ $item['code'] }}">{{ $item['name'] }}</option>
                                                                    @endif
                                                                @endforeach
                                                            </select>
                                                            <select name="insurance_attributes[{{ $v['module_key'] }}][{{ $vv['ty_key'] }}][city]" class="city" >
                                                                @foreach($ins['area'] as $item)
                                                                    @if($item['type']=='02')
                                                                        <option value="{{ $item['code'] }}" data-id="{{$item['code']}}" data-parent="{{$item['parent_code'] }}">{{$item['name']}}</option>
                                                                    @endif
                                                                @endforeach
                                                            </select>
                                                            <select name="insurance_attributes[{{ $v['module_key'] }}][{{ $vv['ty_key'] }}][country]" class="country" >
                                                                @foreach($ins['area'] as $item)
                                                                    @if($item['type']=='03')
                                                                        <option value="{{ $item['code'] }}" data-parent="{{$item['parent_code']}}">{{$item['name']}}</option>
                                                                    @endif
                                                                @endforeach
                                                            </select>
                                                        </span>
                                                        @else
                                                            <span class="area_box">
                                                            <span class="type_is_area"></span>
                                                            <input class="area" name="insurance_attributes[{{ $v['module_key'] }}][{{ $vv['ty_key'] }}]" style="display: none;" />
                                                            <select name="" class="province">
                                                                @foreach($ins['area'] as $key => $item)
                                                                    <option value="{{ $item['code'] }}" data-id="{{ $key }}">{{ $item['name'] }}</option>
                                                                @endforeach
                                                            </select>
                                                            <select name="" class="city"></select>
                                                            <select name="" class="country"></select>
                                                        </span>
                                                        @endif
                                                    @endif
                                                @endif
                                                @if($vv['type'] == 5)
                                                    <?php
                                                    if(isset($ins['jobs'])){
                                                        $one = "<select class='one' id='one_". $beibaoren_key ."' sort_id='".$beibaoren_key."' >";
                                                        $two = '';
                                                        $three = '';
                                                        foreach($ins['jobs'] as $one_k => $one_v){
                                                            $one .= "<option value='". $one_v['id'] ."'>" . $one_v['name'] . "</option>";
                                                            if(isset($one_v['_child'])){
                                                                $two .= "<select class='two two_". $beibaoren_key ."' sort_id='".$beibaoren_key."' id='two_".$beibaoren_key. '_'. $one_v['id'] ."' >";
                                                                foreach($one_v['_child'] as $tow_k =>$two_v){
                                                                    $two .= "<option value='". $two_v['id'] ."'>" . $two_v['name'] . "</option>";
                                                                    if(isset($two_v['_child'])){
                                                                        $three .= "<select class='three three_". $beibaoren_key ."' id='three_".$beibaoren_key. '_'. $two_v['id'] ."' two_id='". $two_v['id'] ."' sort_id='".$beibaoren_key."' >";
                                                                        foreach($two_v['_child'] as $three_k => $three_v){
                                                                            $three .= "<option value='". $three_v['id'] ."'>" . $three_v['name'] . "</option>";
                                                                        }
                                                                        $three .= "</select>";
                                                                    }
                                                                }
                                                                $two .= "</select>";
                                                            }
                                                        }
                                                        $one .= "</select>";
                                                        echo $one;
                                                        echo $two;
                                                        echo $three;
                                                    }
                                                    ?>
                                                    <input type="hidden" id="job_val_{{$beibaoren_key}}" name="insurance_attributes[{{ $v['module_key'] }}][{{ $vv['ty_key'] }}]">
                                                    @if(isset($ins['job'])&&isset($ins['job'][count($ins['job'])-1]['parent_code']))
                                                        <input class="job" name="insurance_attributes[{{ $v['module_key'] }}][{{ $vv['ty_key'] }}]" style="display: none;" />
                                                        <select name="insurance_attributes[{{ $v['module_key'] }}][{{ $vv['ty_key'] }}][occupation]" class="occupation">
                                                            @foreach($ins['job'] as $item)
                                                                @if(!isset($item['parent_code']))
                                                                    <option value="{{$item['code'] }}" data-id="{{$item['code'] }}">{{ $item['name'] }}</option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                        <select name="insurance_attributes[{{ $v['module_key'] }}][{{ $vv['ty_key'] }}][job]" class="job">
                                                            @foreach($ins['job'] as $item)
                                                                @if(isset($item['parent_code']))
                                                                    <option value="{{ $item['code'] }}" data-parent="{{$item['parent_code']}}">{{$item['name']}}</option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                        </span>
                                                    @endif
                                                @endif
                                                @if($vv['type'] == 6)
                                                    @foreach($vv['attributeValues'] as $ak => $av)
                                                        <input  class="btn btn-default" regex="{{$vv['regex']?? ''}}" msg="{{$vv['errorRemind']?? ''}}" name="insurance_attributes[{{ $v['module_key'] }}][{{ $vv['ty_key'] }}]" value="{{$av['ty_value']}}" />{{$av['value']}}
                                                    @endforeach
                                                @endif
                                                @if(in_array($vv['type'], [0, 9]))
                                                    <select style="width: 170px;height: 35px;font-size: 16px;color:#888888 ; border: 0.1px solid #D0D0D0;" class="common-input code-select" name="insurance_attributes[{{ $v['module_key'] }}][{{ $vv['ty_key'] }}]" id="{{ $vv['ty_key'] }}">
                                                        @foreach($vv['attributeValues'] as $ak => $av)
                                                            <option value="{{$av['ty_value']}}" style="text-align:center ">{{$av['value']}}</option>
                                                        @endforeach
                                                    </select>
                                                @endif
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                                {{--投保人信息--}}
                            @elseif ($v['module_key'] == 'ty_beibaoren')
                                @php $beibaoren_key++; @endphp
                                {{--被保人信息表--}}
                                <div class="person other" id="{{ $v['module_key'] }}">
                                    <h3 class="title">{{ $v['name'] }}</h3>
                                    <ul>
                                        @foreach($v['productAttributes'] as $vk => $vv)
                                            <li id="{{'b'.$vv['type']}}">
                                                <span class="name"><i class="f18164">*</i>{{$vv['name']}}</span>
                                                @if($vv['type'] == 1)
                                                    <input type="date" regex="{{$vv['regex']?? ''}}" msg="{{$vv['errorRemind']?? ''}}" id="{{$vv['ty_key']}}"  style="font-size: 16px;color:#888888 ; " name="insurance_attributes[{{ $v['module_key'] }}][{{ $beibaoren_key }}][{{ $vv['ty_key'] }}]" class="common-input" value="{{date('Y-m-d',time())}}">
                                                @endif
                                                @if($vv['type'] == 3)
                                                    <input type="text" regex="{{$vv['regex']?? ''}}" msg="{{$vv['errorRemind']?? ''}}" class="common-input w320" placeholder="{{$vv['name']}}" id="{{ $vv['ty_key'] }}" name="insurance_attributes[{{ $v['module_key'] }}][{{ $beibaoren_key }}][{{ $vv['ty_key'] }}]">
                                                    <span class="error"></span>
                                                @endif
                                                @if($vv['type'] == 4)
                                                    @if(isset($ins['area']) && !empty($ins['area']))
                                                        @if(isset($ins['area'][40]['parent_code']))
                                                            <span class="area_box">
                                                            <span class="type_is_area"></span>
                                                            <input class="area" name="insurance_attributes[{{ $v['module_key'] }}][{{ $beibaoren_key }}][{{ $vv['ty_key'] }}]" style="display: none;" />
                                                            <select name="insurance_attributes[{{ $v['module_key'] }}][{{ $beibaoren_key }}][{{ $vv['ty_key'] }}][province]" class="province">
                                                                @foreach($ins['area'] as $item)
                                                                    @if($item['type']=='01')
                                                                        <option value="{{ $item['code'] }}" data-id="{{ $item['code'] }}">{{ $item['name'] }}</option>
                                                                    @endif
                                                                @endforeach
                                                            </select>
                                                            <select name="insurance_attributes[{{ $v['module_key'] }}][{{ $beibaoren_key }}][{{ $vv['ty_key'] }}][city]" class="city" >
                                                                @foreach($ins['area'] as $item)
                                                                    @if($item['type']=='02')
                                                                        <option value="{{ $item['code'] }}" data-id="{{$item['code']}}" data-parent="{{$item['parent_code'] }}">{{$item['name']}}</option>
                                                                    @endif
                                                                @endforeach
                                                            </select>
                                                            <select name="insurance_attributes[{{ $v['module_key'] }}][{{ $beibaoren_key }}][{{ $vv['ty_key'] }}][country]" class="country" >
                                                                @foreach($ins['area'] as $item)
                                                                    @if($item['type']=='03')
                                                                        <option value="{{ $item['code'] }}" data-parent="{{$item['parent_code']}}">{{$item['name']}}</option>
                                                                    @endif
                                                                @endforeach
                                                            </select>
                                                        </span>
                                                        @else
                                                            <span class="area_box">
                                                        <span class="type_is_area"></span>
                                                        <input class="area" name="insurance_attributes[{{ $v['module_key'] }}][{{ $beibaoren_key }}][{{ $vv['ty_key'] }}]" style="display: none;"/>
                                                        <select name="" class="province">
                                                            @foreach($ins['area'] as $key => $item)
                                                                <option value="{{ $item['code'] }}" data-id="{{ $key }}">{{ $item['name'] }}</option>
                                                            @endforeach
                                                        </select>
                                                        <select name="" class="city"></select>
                                                        <select name="" class="country"></select>
                                                    </span>
                                                        @endif
                                                    @endif
                                                @endif
                                                @if($vv['type'] == 5)
                                                    <?php
                                                    if(isset($ins['jobs'])){
                                                        $one = "<select class='one' id='one_". $beibaoren_key ."' sort_id='".$beibaoren_key."' >";
                                                        $two = '';
                                                        $three = '';
                                                        foreach($ins['jobs'] as $one_k => $one_v){
                                                            $one .= "<option value='". $one_v['id'] ."'>" . $one_v['name'] . "</option>";
                                                            if(isset($one_v['_child'])){
                                                                $two .= "<select class='two two_". $beibaoren_key ."' sort_id='".$beibaoren_key."' id='two_".$beibaoren_key. '_'. $one_v['id'] ."' >";
                                                                foreach($one_v['_child'] as $tow_k =>$two_v){
                                                                    $two .= "<option value='". $two_v['id'] ."'>" . $two_v['name'] . "</option>";
                                                                    if(isset($two_v['_child'])){
                                                                        $three .= "<select class='three three_". $beibaoren_key ."' id='three_".$beibaoren_key. '_'. $two_v['id'] ."' two_id='". $two_v['id'] ."' sort_id='".$beibaoren_key."' >";
                                                                        foreach($two_v['_child'] as $three_k => $three_v){
                                                                            $three .= "<option value='". $three_v['id'] ."'>" . $three_v['name'] . "</option>";
                                                                        }
                                                                        $three .= "</select>";
                                                                    }
                                                                }
                                                                $two .= "</select>";
                                                            }
                                                        }
                                                        $one .= "</select>";
                                                        echo $one;
                                                        echo $two;
                                                        echo $three;
                                                    }
                                                    ?>
                                                    <input type="hidden" id="job_val_{{$beibaoren_key}}" name="insurance_attributes[{{ $v['module_key'] }}][{{ $beibaoren_key }}][{{ $vv['ty_key'] }}]">
                                                    @if(isset($ins['job']) && isset($ins['job'][count($ins['job'])-1]['parent_code']))
                                                        <input class="job" name="insurance_attributes[{{ $v['module_key'] }}][{{ $beibaoren_key }}][{{ $vv['ty_key'] }}]" style="display: none;" />
                                                        <select name="insurance_attributes[{{ $v['module_key'] }}][{{ $beibaoren_key }}][{{ $vv['ty_key'] }}][occupation]" class="occupation">
                                                            @if($ins['job'])
                                                                @foreach($ins['job'] as $item)
                                                                    @if(!isset($item['parent_code']))
                                                                        <option value="{{$item['code'] }}" data-id="{{$item['code'] }}">{{ $item['name'] }}</option>
                                                                    @endif
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                        <select name="insurance_attributes[{{ $v['module_key'] }}][{{ $beibaoren_key }}][{{ $vv['ty_key'] }}][job]" class="job">
                                                            @foreach($ins['job'] as $item)
                                                                @if(isset($item['parent_code']))
                                                                    <option value="{{ $item['code'] }}" data-parent="{{$item['parent_code']}}">{{$item['name']}}</option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                        </span>
                                                    @endif
                                                @endif
                                                @if($vv['type'] == 6)
                                                    @foreach($vv['attributeValues'] as $ak => $av)
                                                        <input class="btn btn-default" regex="{{$vv['regex']?? ''}}" msg="{{$vv['errorRemind']?? ''}}" name="insurance_attributes[{{ $v['module_key'] }}][{{ $beibaoren_key }}][{{ $vv['ty_key'] }}]" value="{{$av['ty_value']}}" />{{$av['value']}}
                                                    @endforeach
                                                @endif
                                                @if(in_array($vv['type'], [0, 9]))
                                                    <select class="common-input code-select" name="insurance_attributes[{{ $v['module_key'] }}][{{ $beibaoren_key }}][{{ $vv['ty_key'] }}]" onclick="selct_self()" id="{{$vv['ty_key']}}" >
                                                        @foreach($vv['attributeValues'] as $ak => $av)
                                                            <option value="{{$av['ty_value']}}">{{$av['value']}}</option>
                                                        @endforeach
                                                    </select>
                                                @endif
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                                {{--被保人信息--}}
                            @else
                                {{--其他信息--}}
                                <div class="person" id="{{ $v['module_key'] }}">
                                    <h3 class="title">{{ $v['name'] }}</h3>
                                    <ul>
                                        @foreach($v['productAttributes'] as $vk => $vv)
                                            <li>
                                                <span class="name"><i class="f18164">*</i>{{$vv['name']}}</span>
                                                @if($vv['type'] == 1)
                                                    <input type="date" regex="{{$vv['regex']?? ''}}" msg="{{$vv['errorRemind']?? ''}}" style="font-size: 16px;color:#888888;" id="{{$vv['ty_key']}}"  name="insurance_attributes[{{ $v['module_key'] }}][{{ $vv['ty_key'] }}]" class="common-input" value="{{date('Y-m-d',time())}}">
                                                @endif
                                                @if(in_array($vv['type'], [3,4]))
                                                    <input type="text" regex="{{$vv['regex']?? ''}}" msg="{{$vv['errorRemind']?? ''}}"  class="w320"  class="common-input" placeholder="{{$vv['name']}}" id="{{ $vv['ty_key'] }}" name="insurance_attributes[{{ $v['module_key'] }}][{{ $vv['ty_key'] }}]">
                                                    <span class="error"></span>
                                                @endif
                                                {{--@if($vv['type'] == 4)--}}
                                                {{--@endif--}}
                                                @if($vv['type'] == 5)
                                                    <?php
                                                    if(isset($ins['jobs'])){
                                                        $one = "<select class='one' id='one_". $beibaoren_key ."' sort_id='".$beibaoren_key."' >";
                                                        $two = '';
                                                        $three = '';
                                                        foreach($ins['jobs'] as $one_k => $one_v){
                                                            $one .= "<option value='". $one_v['id'] ."'>" . $one_v['name'] . "</option>";
                                                            if(isset($one_v['_child'])){
                                                                $two .= "<select class='two two_". $beibaoren_key ."' sort_id='".$beibaoren_key."' id='two_".$beibaoren_key. '_'. $one_v['id'] ."' >";
                                                                foreach($one_v['_child'] as $tow_k =>$two_v){
                                                                    $two .= "<option value='". $two_v['id'] ."'>" . $two_v['name'] . "</option>";
                                                                    if(isset($two_v['_child'])){
                                                                        $three .= "<select class='three three_". $beibaoren_key ."' id='three_".$beibaoren_key. '_'. $two_v['id'] ."' two_id='". $two_v['id'] ."' sort_id='".$beibaoren_key."' >";
                                                                        foreach($two_v['_child'] as $three_k => $three_v){
                                                                            $three .= "<option value='". $three_v['id'] ."'>" . $three_v['name'] . "</option>";
                                                                        }
                                                                        $three .= "</select>";
                                                                    }
                                                                }
                                                                $two .= "</select>";
                                                            }
                                                        }
                                                        $one .= "</select>";
                                                        echo $one;
                                                        echo $two;
                                                        echo $three;
                                                    }
                                                    ?>
                                                    <input type="hidden" id="job_val_{{$beibaoren_key}}" name="insurance_attributes[{{ $v['module_key'] }}][{{ $beibaoren_key }}][{{ $vv['ty_key'] }}]">
                                                    @if(isset($ins['job'][count($ins['job'])-1]['parent_code']))
                                                        <input class="job" name="insurance_attributes[{{ $v['module_key'] }}][{{ $vv['ty_key'] }}]" style="display: none;" />
                                                        <select name="occupation" class="occupation">
                                                            @foreach($ins['job'] as $item)
                                                                @if(!isset($item['parent_code']))
                                                                    <option value="{{$item['code'] }}" data-id="{{$item['code'] }}">{{ $item['name'] }}</option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                        <select name="job" class="job">
                                                            @foreach($ins['job'] as $item)
                                                                @if(isset($item['parent_code']))
                                                                    <option value="{{ $item['code'] }}" data-id="{{$item['parent_code']}}">{{$item['name']}}</option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                        </span>
                                                    @endif
                                                @endif
                                                @if($vv['type'] == 6)
                                                    @foreach($vv['attributeValues'] as $ak => $av)
                                                        <input  class="btn btn-default" regex="{{$vv['regex']?? ''}}" msg="{{$vv['errorRemind']?? ''}}" name="insurance_attributes[{{ $v['module_key'] }}][{{ $vv['ty_key'] }}]" value="{{$av['ty_value']}}" />{{$av['value']}}
                                                    @endforeach
                                                @endif
                                                @if(in_array($vv['type'], [0, 9]))
                                                    <select style="width: 170px;height: 35px;font-size: 16px;color:#888888 ; border: 0.1px solid #D0D0D0;" class="common-input code-select" name="insurance_attributes[{{ $v['module_key'] }}][{{ $vv['ty_key'] }}]" id="{{ $vv['ty_key'] }}">
                                                        @foreach($vv['attributeValues'] as $ak => $av)
                                                            <option value="{{$av['ty_value']}}" style="text-align:center ">{{$av['value']}}</option>
                                                        @endforeach
                                                    </select>
                                                @endif
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                                {{--其他信息--}}
                            @endif
                        @endforeach
                        {{--紧急联系人--}}
                        <div class="contact">
                            <div class="contact-agreement">
                                <label>
                                    <i class="icon icon-checkbox"></i>
                                    <input type="checkbox" id="agree" hidden/>
                                    我已查看并同意
                                    @if(!empty($product_res['clauses']))
                                        @foreach(json_decode($product_res['clauses'],true) as $value)
                                            @if($value['type']=='main')
                                                <a href="{{env('TY_API_PRODUCT_SERVICE_URL')}}/{{substr($value['file_url'],0,1)=="/"?substr($value['file_url'],1):$value['file_url']}}" class="a4d790" target="_blank">保险条款</a>和
                                            @endif
                                        @endforeach
                                    @endif
                                    <a href="/insure_notice.pdf" class="a4d790" target="_blank">投保人申明</a>
                                </label>
                            </div>

                        </div>
                        {{--紧急联系人--}}
                        </form>
                        <div style="text-align: center;">
                            {{--<input type="submit" id="submit" class="btn btn-unusable" onclick="form_check()" value="提交投保单" disabled="disabled">--}}
                            <button type="button" id="submit" class="btn btn-unusable" disabled>提交投保单</button>
                            {{--<input type="submit" id="submit" class="btn btn-f18164" value="提交投保单" >--}}
                            {{--<button type="button" class="btn btn-f18164" onclick="form_check()" disabled>提交投保单</button>--}}
                            {{--<span><a onclick="selct_self()"><u>保存投保信息</u></a></span>--}}
                            <span id="checksave"></span>
                        </div>
                    </div>

                </div>
                @include('frontend.guests.product.product_notice')
            </div>
        </div>


    {{--<script>--}}
        {{--var name = "{{$user_true['name']}}";--}}
        {{--var code = "{{$user_true['code']}}";--}}
        {{--var phone = "{{$user_true['phone']}}";--}}
        {{--var email = "{{$user_true['email']}}";--}}
        {{--var address = "{{$user_true['address']}}";--}}
        {{--var occupation = "{{$user_true['occupation']}}";--}}
        {{--$(function () {--}}

{{--//            $('#ty_toubaoren_name').val(name);--}}
{{--//            $('#ty_toubaoren_phone').val(phone);--}}
{{--//            $('#ty_toubaoren_id_number').val(code);--}}
{{--//            $('#ty_toubaoren_email').val(email);--}}
{{--//            $('#ty_toubaoren_address').val(address);--}}
{{--//            $('#ty_toubaoren_occupation').val(occupation);--}}
{{--//            $("#agree").change(function(){--}}
{{--//                test = $("input[type='checkbox']").is(':checked');--}}
{{--//                if(test == true){--}}
{{--//                    $('#submit').removeAttr("disabled");--}}
{{--//                    $("#submit").css("background-color","#ffae00");--}}
{{--////--}}
{{--//                }else{--}}
{{--//                    $("#submit").removeAttr("style");--}}
{{--//                    $("#submit").attr("disabled", "disable");--}}
{{--//                }--}}
{{--//            });--}}

            {{--var inputs = $('.notification-left-content input:visible[type="text"]');--}}
            {{--inputs.on('blur',function(){--}}
                {{--var regex =  eval('/'+$(this).attr('regex')+'/');--}}
                {{--var value = $(this).val();--}}
                {{--if (regex){--}}
                    {{--var msg = $(this).attr('msg');--}}
                    {{--if (!regex.test(value)){--}}
                        {{--$(this).val("");--}}
{{--//                        Mask.alert(msg,2);--}}
                        {{--$(this).addClass('red');--}}
                        {{--$(this).attr('placeholder', msg);--}}
                    {{--} else {--}}
                        {{--$(this).removeClass('red');--}}
                    {{--}--}}
                {{--}--}}
            {{--});--}}
            {{--function checkInputs(){--}}
                {{--var status = false;--}}
                {{--inputs.each(function(index){--}}
                    {{--if(!$(this).val().trim()){--}}
                        {{--status = true;--}}
                        {{--return false;--}}
                    {{--}--}}
                {{--});--}}
                {{--return status;--}}
            {{--}--}}
            {{--function checkCheckbox(){--}}
                {{--var status = !$("input[type='checkbox']").prop('checked');--}}
                {{--return status;--}}
            {{--};--}}
            {{--$("#agree").change(function(){--}}
                {{--var status = checkInputs() || checkCheckbox();--}}
                {{--$("#submit").get(0).disabled = status;--}}
                {{--status == 0 ? $('#submit').removeAttr("disabled").css("background-color","#ffae00") : $("#submit").removeAttr("style").attr("disabled", "disable");--}}
            {{--});--}}
            {{--inputs.bind('input propertychange', function() {--}}
                {{--var status = checkInputs() || checkCheckbox();--}}
                {{--$("#submit").get(0).disabled = status;--}}
                {{--status == 0 ? $('#submit').removeAttr("disabled").css("background-color","#ffae00") : $("#submit").removeAttr("style").attr("disabled", "disable");--}}
            {{--});--}}


        {{--});--}}
        {{--$('#ty_relation').change(function () {--}}
            {{--relation = $('#ty_relation').val();--}}
            {{--if(relation=='1'){--}}
                {{--$('#ty_beibaoren_name').attr('readonly','readonly');--}}
                {{--$('#ty_beibaoren_phone').attr('readonly','readonly');--}}
                {{--$('#ty_beibaoren_id_number').attr('readonly','readonly');--}}
            {{--}else{--}}
                {{--$('#ty_beibaoren_name').removeAttr('readonly');--}}
                {{--$('#ty_beibaoren_name').val('');--}}
                {{--$('#ty_beibaoren_phone').removeAttr('readonly');--}}
                {{--$('#ty_beibaoren_phone').val('');--}}
                {{--$('#ty_beibaoren_id_number').removeAttr('readonly');--}}
                {{--$('#ty_beibaoren_id_number').val('');--}}
            {{--}--}}
        {{--});--}}
        {{--$(function(){--}}
            {{--$(".one").change(function(){--}}
                {{--var val = $(this).val();--}}
                {{--var sort_id = $(this).attr('sort_id');--}}
                {{--var class_obj_name = '.two_' + sort_id;--}}
                {{--$(class_obj_name).hide();--}}
                {{--var two_id = "#two_" + sort_id + '_' +val;--}}
                {{--$(two_id).show(function () {--}}
                    {{--$(two_id).trigger('change');--}}
                {{--});--}}
                {{--var three_class_obj_name = '.three_' + sort_id;--}}
{{--//                console.log(three_class_obj_name);--}}
                {{--$(three_class_obj_name).hide();--}}
                {{--var val_2 = $(two_id).prop('selectedIndex', 0).val();--}}
                {{--var input_val = val + '-' +val_2;--}}
                {{--console.log(input_val);--}}
                {{--$("#job_val_" + sort_id).val(input_val);--}}
            {{--});--}}
            {{--$(".two").change(function(){--}}
                {{--var val = $(this).val();--}}
                {{--var sort_id = $(this).attr('sort_id');--}}
                {{--var class_obj_name = '.three' + '_' +sort_id;--}}
                {{--$(class_obj_name).hide();--}}
                {{--var val_1 = $('#one_' + sort_id).val();--}}
                {{--var input_val = val_1 + '-' +val;--}}

                {{--var three_id = "#three_" + sort_id + '_' +val;--}}
                {{--if($(three_id).length > 0){--}}
                    {{--$(three_id).show();--}}
                    {{--var val_2 = $(three_id).prop('selectedIndex', 0).val();--}}
                    {{--input_val = input_val + '-' + val_2;--}}
                {{--}--}}

                {{--console.log(input_val);--}}
                {{--$("#job_val_" + sort_id).val(input_val);--}}
            {{--});--}}

            {{--$(".three").change(function(){--}}
                {{--var val = $(this).val();--}}
                {{--var sort_id = $(this).attr('sort_id');--}}
                {{--var two_id = $(this).attr('two_id');--}}
                {{--var val_1 = $('#one_' + sort_id).val();--}}
                {{--var val_2 = $('#two_' + sort_id + '_' +val_1).val();--}}
                {{--var input_val = val_1 + '-' + val_2 + '-' + val;--}}
                {{--console.log(input_val);--}}
                {{--$("#job_val_" + sort_id).val(input_val);--}}
            {{--});--}}
            {{--$('.one').trigger('change');--}}

            {{--// 地区渲染--}}
            {{--(function () {--}}
                {{--// 城市--}}
                {{--if ($('.area_box').length > 0) {--}}
                    {{--$('.area_box').each(function () {--}}
                                {{--@if(isset($ins['area']))--}}
                        {{--var area = '{!! json_encode($ins['area']) !!}';--}}
                        {{--@endif--}}
{{--console.log(area);--}}
                        {{--area = eval("("+area+")");--}}
                        {{--var cities = [];--}}
                        {{--console.log(area);--}}
                        {{--var that = this;--}}
                        {{--$(this).find('.province').on('change', function () {--}}
                            {{--var id = $(this).find(':selected').attr('data-id');--}}
                            {{--console.log('id is ' + id);--}}
                            {{--cities = area[id]['cities'];--}}
{{--//                city = eval("("+city+")");--}}
                            {{--console.log(cities);--}}
                            {{--var len = cities.length;--}}
                            {{--var html = '';--}}
                            {{--for(var i = 0; i < len; i++)　{--}}
                                {{--html += '<option value="'+cities[i]['code']+'" data-id="'+i+'">'+cities[i]['name']+'</option>';--}}
                            {{--}--}}
                            {{--console.log(html);--}}
                            {{--$(that).find('.city').html(html);--}}
                            {{--$(that).find('.city').trigger('change');--}}
                        {{--});--}}
                        {{--$(this).find('.city').on('change', function () {--}}
                            {{--var id = $(this).find(':selected').attr('data-id');--}}
                            {{--console.log('id is ' + id);--}}
                            {{--var countries = cities[id]['countries'];--}}
{{--//                city = eval("("+city+")");--}}
                            {{--console.log(countries);--}}
                            {{--var len = countries.length;--}}
                            {{--var html = '';--}}
                            {{--for(var i = 0; i < len; i++)　{--}}
                                {{--html += '<option value="'+countries[i]['code']+'" data-id="'+i+'">'+countries[i]['name']+'</option>';--}}
                            {{--}--}}
                            {{--console.log(html);--}}
                            {{--$(that).find('.country').html(html);--}}
                            {{--$(that).find('.country').trigger('change');--}}
                        {{--});--}}
                        {{--$(this).find('.city').on('change', function () {--}}
                            {{--var province_code = $(that).find('.province').val();--}}
                            {{--var city_code = $(that).find('.city').val();--}}
                            {{--var country_code = $(that).find('.country').val();--}}
                            {{--var area_code = province_code + ',' + city_code + ',' + country_code;--}}
                            {{--console.log('area code is ' + area_code);--}}
                            {{--$(that).find('.area').val(area_code);--}}
                        {{--});--}}
                        {{--$(this).find('.province').trigger('change');--}}
                    {{--});--}}
                {{--}--}}
            {{--})();--}}
            {{--//            var $html = $('.need-hidden').html();--}}
            {{--//            $('.need-hidden').html('');--}}
            {{--//            $("#shouyiren").change(function(){--}}
            {{--//                var val = $(this).find("option:selected").val();--}}
            {{--//                if(val == 1){--}}
            {{--//                    $(".need-hidden").html($html);--}}
            {{--//                }else{--}}
            {{--//                    $(".need-hidden").html('');--}}
            {{--//                }--}}
            {{--//            });--}}
            {{--var agree_status = $('#agree').val();--}}
            {{--//                $('#submit').attr("disabled", false);--}}


        {{--});--}}

        {{--// 证件类型--}}
        {{--var isIdentityCard = false;--}}
        {{--$('[id$=id_type]').on('change', function () {--}}
            {{--if ($(this).val() == 1) {--}}
                {{--isIdentityCard = true;--}}
                {{--$(this).parents('.person').find('[id$=birthday]').parents('li').hide();--}}
                {{--$(this).parents('.person').find('[id$=sex]').parents('li').hide();--}}
            {{--} else {--}}
                {{--$(this).parents('.person').find('[id$=birthday]').parents('li').show();--}}
                {{--$(this).parents('.person').find('[id$=sex]').parents('li').show();--}}
                {{--isIdentityCard = false;--}}
            {{--}--}}
        {{--});--}}
        {{--$('[id$=id_type]').trigger('change');--}}
        {{--$('[id$=id_number]').on('change', function () {--}}
            {{--var birthdayObj = $(this).parents('.person').find('[id$=birthday]');--}}
            {{--var sexObj = $(this).parents('.person').find('[id$=sex]');--}}
            {{--if (isIdentityCard) {--}}
                {{--birthdayObj.val(getId($(this).val().replace(/(^\s*)|(\s*$)/g, '')));--}}
                {{--sexObj.find('option[value='+getSex($(this).val())+']').attr('selected', true);--}}
            {{--}--}}
        {{--});--}}

        {{--function getId(idCard) {--}}
            {{--var birthday = "";--}}
            {{--if(idCard != null && idCard != ""){--}}
                {{--if(idCard.length == 15){--}}
                    {{--birthday = "19"+idCard.substr(6,6);--}}
                {{--} else if(idCard.length == 18){--}}
                    {{--birthday = idCard.substr(6,8);--}}
                {{--}--}}

                {{--birthday = birthday.replace(/(.{4})(.{2})/,"$1-$2-");--}}
            {{--}--}}

            {{--return birthday;--}}
        {{--}--}}

        {{--function getSex(psidno){--}}
            {{--var sexno,sex;--}}
            {{--if(psidno.length==18){--}}
                {{--sexno=psidno.substring(16,17)--}}
            {{--}else if(psidno.length==15){--}}
                {{--sexno=psidno.substring(14,15)--}}
            {{--}--}}
            {{--var tempid=sexno%2;--}}
            {{--if(tempid==0){--}}
                {{--sex=0;--}}
            {{--}else{--}}
                {{--sex=1;--}}
            {{--}--}}
            {{--return sex--}}
        {{--}--}}

        {{--function form_check() {--}}
            {{--$('[id$=id_number]').trigger('change');--}}
            {{--$('.w320').each(function (index) {--}}
                {{--var insure_value  = $(this).val();--}}
                {{--if(!insure_value||insure_value.length<1){--}}
                    {{--Mask.alert("请正确输入投保信息");--}}
                    {{--return false;--}}
                {{--}--}}

                {{--if(index == $('.w320').length-1){--}}
                    {{--$(form).submit();--}}
                {{--}--}}
            {{--});--}}
            {{--return false;--}}
        {{--}--}}
        {{--function selct_self() {--}}
            {{--var ty_toubaoren_name = $('#ty_toubaoren_name').val();--}}
            {{--var ty_toubaoren_id_number = $('#ty_toubaoren_id_number').val();--}}
            {{--var ty_toubaoren_phone = $('#ty_toubaoren_phone').val();--}}
            {{--$('.code-select option:selected').each(function (index) {--}}
                {{--var select_value  = $(this).text();--}}
                {{--if(select_value=='本人'){--}}
                    {{--$('#ty_beibaoren_name').val(ty_toubaoren_name);--}}
                    {{--$('#ty_beibaoren_phone').val(ty_toubaoren_phone);--}}
                    {{--$('#ty_beibaoren_id_number').val(ty_toubaoren_id_number);--}}
                    {{--$('#ty_beibaoren_name').attr('readonly','readonly');--}}
                    {{--$('#ty_beibaoren_phone').attr('readonly','readonly');--}}
                    {{--$('#ty_beibaoren_id_number').attr('readonly','readonly');--}}
                {{--}--}}
            {{--})--}}
        {{--}--}}

        {{--//省市县联动--}}
        {{--function Linked(options){--}}
            {{--this.defaults = {ele: null};--}}
            {{--this.options = $.extend({}, this.defaults, options);--}}
            {{--this.c = $(this.options.ele);--}}
            {{--this.level = this.c.find('select').eq(0);--}}
            {{--this.leve2 = this.c.find('select').eq(1);--}}
            {{--this.leve3 = this.c.find('select').eq(2);--}}
            {{--this.init();--}}
        {{--}--}}
        {{--Linked.prototype = {--}}
            {{--init: function(){--}}
                {{--var _this = this;--}}
                {{--var pid = _this.level.find('option').eq(0).data('id');--}}
                {{--var cid = _this.leve2.find('option:checked').data('id');--}}
                {{--_this.change(_this.leve2, pid);--}}
                {{--_this.change(_this.leve3, cid);--}}
                {{--_this.level.on('change',function(){--}}
                    {{--var id = $(this).find('option:checked').data('id');--}}
                    {{--_this.change(_this.leve2, id)--}}
                    {{--_this.leve2.change();--}}
                {{--});--}}
                {{--_this.leve2.on('change',function(){--}}
                    {{--var id = $(this).find('option:checked').data('id');--}}
                    {{--_this.change(_this.leve3, id);--}}
                {{--});--}}
            {{--},--}}
            {{--change: function(ele,pid){--}}
                {{--ele.find('option').each(function(){--}}
                    {{--var id = $(this).data('parent');--}}
                    {{--id !== pid ? $(this).hide() : $(this).show();--}}
                {{--});--}}
                {{--ele.find('option[data-parent='+ pid +']').eq(0).prop('selected',true);--}}
            {{--}--}}
        {{--}--}}
        {{--var ty_product_id = {{$product['ty_product_id']}};--}}
        {{--if(ty_product_id == 26){--}}
        {{--new Linked({ele: '#4'});--}}
        {{--new Linked({ele: '#5'});--}}
        {{--new Linked({ele: '#b4'});--}}
        {{--new Linked({ele: '#b5'});--}}
        {{--}--}}

        {{--// 投保时间范围校验--}}
        {{--function CheckDate(options){--}}
            {{--this.defaults = {};--}}
            {{--this.options = $.extend({}, this.defaults, options);--}}
            {{--this.ele = $(this.options.ele);--}}
            {{--this.init();--}}
        {{--}--}}
        {{--CheckDate.prototype = {--}}
            {{--init: function(){--}}
                {{--var _this = this;--}}
                {{--var range = _this.options.range;--}}
                {{--var defaultVal = this.ele.val();--}}
                {{--this.ele.change(function(){--}}
                    {{--var selectVal = new Date($(this).val()).getTime();--}}

                    {{--var now = new Date();--}}
                    {{--startVal = now.setDate(now.getDate()+range[0]-1);--}}
                    {{--var now = new Date(),--}}
                            {{--startText = _this.fmtDate(now.setDate(now.getDate()+range[0]));--}}

                    {{--var now = new Date(),--}}
                            {{--endVal = now.setDate(now.getDate()+range[1]),--}}
                            {{--endText = _this.fmtDate(endVal);--}}

                    {{--if(selectVal<startVal){--}}
                        {{--$(this).val(defaultVal);--}}
                        {{--Mask.alert('选择时间不可小于'+startText);--}}
                    {{--}else if(selectVal>endVal){--}}
                        {{--$(this).val(defaultVal);--}}
                        {{--Mask.alert('选择时间不可大于'+endText);--}}
                    {{--}else{--}}
                        {{--defaultVal = $(this).val();--}}
                    {{--}--}}
                {{--});--}}
            {{--},--}}
            {{--fmtDate: function(obj){--}}
                {{--var date =  new Date(obj);--}}
                {{--var y = 1900+date.getYear();--}}
                {{--var m = "0"+(date.getMonth()+1);--}}
                {{--var d = "0"+date.getDate();--}}
                {{--return y+"-"+m.substring(m.length-2,m.length)+"-"+d.substring(d.length-2,d.length);--}}
            {{--}--}}
        {{--}--}}

        {{--new CheckDate({--}}
            {{--ele: '#ty_start_date', // input元素--}}
            {{--range: [1,10] // 时间天数范围 今天2天后 连续10天--}}
        {{--})--}}




    {{--</script>--}}
@stop