<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>天眼互联-科技让保险无限可能</title>
    <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
    <link rel="stylesheet" href="{{config('view_url.view_url')}}mobile/css/lib/mui.min.css">
    <link rel="stylesheet" href="{{config('view_url.view_url')}}mobile/css/lib/mui.picker.all.css">
    <link rel="stylesheet" href="{{config('view_url.view_url')}}mobile/css/lib/iconfont.css" />
    <link rel="stylesheet" href="{{config('view_url.view_url')}}mobile/css/common.css" />
    <link rel="stylesheet" href="{{config('view_url.view_url')}}mobile/css/information.css" />
    <style>
        body {background: #fff;}
        .mui-scroll-wrapper {top: .8rem;bottom: .8rem;}
        .mui-bar-nav {background: #025a8d;}
        .mui-icon-back,.mui-title {color: rgba(255, 255, 255, .8);}
        .applicant-wrapper {background: #fff;margin-bottom: .8rem;padding-bottom: .3rem;}
        .applicant-wrapper ul {padding: 0 .3rem;}
        .applicant-wrapper li {height: 1rem;line-height: 1rem;position: relative;border-bottom: 1px solid #dcdcdc;}
        .applicant-wrapper li .iconfont {position: absolute;top: 0;right: 0;z-index: 1;font-size: .36rem;color: #00a2ff;}
        .applicant-partone li:last-child {border-bottom: none;}
        .applicant-wrapper li input {padding-left: 2rem;font-size: .28rem;border: none;}
        .name {position: absolute;top: 0;left: 0;font-size: .28rem;color: #313131;width: 1.9rem;z-index: 100}
        .applicant-wrapper li.mui-table-view-cell {border-bottom: none;}
        .mui-table-view-cell:after {background: none;}
        .buttonbox button[disabled]{background-color: #dddddd;}
        .applicant-wrapper li.title{font-size: 0.3rem;font-weight: bold;margin-bottom: -.3rem;border-bottom: none;}
    </style>
</head>
<form class="form-horizontal" method="post"  id="form" action="{{ url('ins/group_submit')}}">
    {{ csrf_field()}}
    <input type="hidden" name="identification" value="{{ $identification }}" >
    <input type="hidden" name="product" value="{{json_encode($product)}}">
    <input type="hidden" name="ins" value="{{json_encode($ins)}}" >
    <input type="hidden" name="json" value="{{json_encode($json)}}" >
    <header class="mui-bar mui-bar-nav">
        <a class="mui-icon mui-icon-back mui-pull-left mui-action-back"></a>
        <h1 class="mui-title">填写投保信息</h1>
    </header>
    <div class="mui-content">
        <div class="mui-scroll-wrapper">
            <div class="mui-scroll">
                <div class="applicant-wrapper">
                    <ul class="applicant-partone">
                        @foreach($ins['insurance_attributes'] as $k => $v)
                            @php $beibaoren_key = -1; @endphp
                            @if($v['module_key'] == 'ty_base')
                                {{--基础信息--}}
                                <li class="title">
                                    <span>{{ $v['name'] }}</span>
                                </li>
                                @foreach($v['productAttributes'] as $vk => $vv)
                                    @if($vv['type'] == 1)
                                        {{--<li class="pickerfour">--}}
                                        {{--<span class="name">保障时间</span><input id="date" type="text" placeholder="必填" />--}}
                                        {{--<i class="iconfont icon-gengduo"></i>--}}
                                        {{--</li>--}}
                                        <li class="pickerfour">
                                            <span class="name">{{$vv['name']}}</span>
                                            <input id="date"   style="font-size: 16px;color:#888888;" name="insurance_attributes[{{ $v['module_key'] }}][{{$vv['ty_key']}}]" class="common-input" value="{{date('Y-m-d',time())}}">
                                            <i class="iconfont icon-gengduo"></i>
                                        </li>
                                    @endif
                                    @if($vv['type'] == 3)
                                        <li class="pickerfour">
                                            <span class="name">{{$vv['name']}}</span>
                                            <input id="name1"  type="text" class="common-input" placeholder="{{$vv['name']}}" name="insurance_attributes[{{ $v['module_key'] }}][{{ $vv['ty_key'] }}]">
                                        </li>
                                    @endif
                                    @if($vv['type'] == 4)
                                        {{--todo 城市联动--}}
                                    @endif
                                    @if($vv['type'] == 5)
                                        {{--todo 职业联动--}}
                                    @endif
                                    @if($vv['type'] == 6)
                                        @foreach($vv['attributeValues'] as $ak => $av)
                                            <li class="pickerfour">
                                                <span class="name">{{$vv['name']}}</span>
                                                <input id="name1" class="common-input btn btn-default" name="insurance_attributes[{{ $v['module_key'] }}][{{ $vv['ty_key'] }}]" value="{{$av['ty_value']}}" />{{$av['value']}}
                                            </li>
                                        @endforeach
                                    @endif
                                    @if(in_array($vv['type'], [0, 9]))
                                        <li class="approve pickerone" data-options="{{json_encode($vv['attributeValues'])}}">
                                            <span class="name">{{$vv['name']}}</span>
                                            <input id="certificateimg1" hidden="hidden" type="file" name="insurance_attributes[{{ $v['module_key'] }}][{{ $vv['ty_key'] }}]" onchange="upload('#certificateimg1');" accept="image/*" capture="camera"/>
                                            <input class="inputhidden" hidden="hidden" type="text"  name="holderIdType" value=""/>
                                            <input id="certificatetype1" type="text" placeholder="请选择"/>
                                            <i class="iconfont icon-gengduo"></i>
                                        </li>
                                    @endif
                                @endforeach
                                {{--基础信息--}}
                            @elseif ($v['module_key'] == 'ty_toubaoren')
                                {{--投保人信息--}}
                                <li class="title">
                                    <span>{{ $v['name'] }}</span>
                                </li>
                                @foreach($v['productAttributes'] as $vk => $vv)
                                    @if($vv['type'] == 1)
                                        <li class="pickerfour">
                                            <span class="name">{{$vv['name']}}</span>
                                            <input id="date"   style="font-size: 16px;color:#888888;" name="insurance_attributes[{{ $v['module_key'] }}][{{$vv['ty_key']}}]" class="common-input" value="{{date('Y-m-d',time())}}">
                                            <i class="iconfont icon-gengduo"></i>
                                        </li>
                                    @endif
                                    @if($vv['type'] == 3)
                                        <li class="approve">
                                            <span class="name">{{$vv['name']}}</span>
                                            <input id="name1" type="text" class="w320"  class="common-input" placeholder="{{$vv['name']}}" name="insurance_attributes[{{ $v['module_key'] }}][{{ $vv['ty_key'] }}]">
                                        </li>
                                    @endif
                                    @if($vv['type'] == 6)
                                        <li class="approve">
                                            <span class="name">{{$vv['name']}}</span>
                                            @foreach($vv['attributeValues'] as $ak => $av)
                                                <input id="name1"  class="btn btn-default" name="insurance_attributes[{{ $v['module_key'] }}][{{ $vv['ty_key'] }}]" value="{{$av['ty_value']}}" />{{$av['value']}}
                                            @endforeach
                                        </li>
                                    @endif
                                    @if(in_array($vv['type'], [0, 9]))
                                        <li class="approve pickerone" data-options="{{json_encode($vv['attributeValues'])}}">
                                            <span class="name">{{$vv['name']}}</span>
                                            {{--<input id="certificateimg1" hidden="hidden" type="file" name="insurance_attributes[{{ $v['module_key'] }}][{{ $vv['ty_key'] }}]" onchange="upload('#certificateimg1');" accept="image/*" capture="camera"/>--}}
                                            <input class="inputhidden" hidden="hidden" type="text"  name="insurance_attributes[{{ $v['module_key'] }}][{{ $vv['ty_key'] }}]" value=""/>
                                            <input id="certificatetype1" type="text" placeholder="请选择"/>
                                            <i class="iconfont icon-gengduo"></i>
                                        </li>
                                    @endif
                                @endforeach
                                {{--投保人信息--}}
                            @elseif ($v['module_key'] == 'ty_beibaoren')
                                <li class="title">
                                    <span>{{ $v['name'] }}</span>
                                </li>
                                @php $beibaoren_key++; @endphp

                                <div class="section3">
                                    <button class="btn btn-add fr" id="add">添加</button>
                                </div>
                            @endif
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <div class="buttonbox">
            <button class="btn" id="next">下一步</button>
        </div>
    </div>
    {{--弹出的被保人信息录入部分--}}
    <div class="mui-popover" id="sds">
        <i class="iconfont icon-guanbi"></i>
        <div class="fill-wrapper">
            {{--被保人信息表--}}
            @php
                echo $group_ins
            @endphp
        </div>

    </div>
</form>

<script src="{{config('view_url.view_url')}}mobile/js/lib/jquery-1.11.3.min.js"></script>
<script src="{{config('view_url.view_url')}}mobile/js/lib/mui.min.js"></script>
<script src="{{config('view_url.view_url')}}mobile/js/lib/mui.picker.all.js"></script>
<script src="{{config('view_url.view_url')}}mobile/js/common.js"></script>
<script src="{{config('view_url.view_url')}}mobile/js/applicant.js"></script>
<script>
        {{--$("#mui-popover").html({{$group_ins}});--}}
        $(function(){
            $('.btn-add').on('tap',function(){
                mui('.mui-popover').popover('show');
            });
            $('#next').click(function(){
                var token = $("input[name=_token]").val();
                var n = 1;
                $.ajax({
                    url: "/ins/group_submit",
                    type: "post",
                    data: {'_token':token},
                    dataType: "json",
                    success: function (data) {
                        if (data['status'] != 200){
                            alert(data['data']);
                        }
                    }
                });
            })
        })

</script>
</body>
</html>