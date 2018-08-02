<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>天眼互联-科技让保险无限可能</title>
    <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
    <link rel="stylesheet" href="{{config('view_url.mobile_group_ins')}}css/lib/mui.min.css">
    <link rel="stylesheet" href="{{config('view_url.mobile_group_ins')}}css/lib/mui.picker.all.css">
    <link rel="stylesheet" href="{{config('view_url.mobile_group_ins')}}css/lib/iconfont.css" />
    <link rel="stylesheet" href="{{config('view_url.mobile_group_ins')}}css/common.css" />
    <style>
        .mui-scroll-wrapper{background: #fff;}
        .comTypeTwo{display: none;}
        .choose{
            width: 70%;
            padding: 0px 15px;
        }
    </style>
</head>

<body>
<div class="main">
    <header class="mui-bar mui-bar-nav">
        <a class="mui-icon mui-icon-back mui-pull-left mui-action-back"></a>
        <h1 class="mui-title">企业信息</h1>
    </header>
    <div class="mui-content">
        <form action="/ins/mobile_group_ins/insure_mobile_company_info/{{$identification}}" method="post">
        <div class="mui-scroll-wrapper">
            <div class="mui-scroll">
                <div class="form-wrapper">
                    <ul>
                        @foreach($ins['insurance_attributes'] as $k => $v)
                            @if($v['module_key'] == 'ty_toubaoren')
                                @foreach($v['productAttributes'] as $vk => $vv)
                                    @if($vv['type'] == 1)
                                        <li>
                                            <span class="name">{{$vv['name']}}</span>
                                            <input class="mustFill" name="insurance_attributes[{{ $v['module_key'] }}][{{$vv['ty_key']}}]" value="{{date('Y-m-d',time())}}" placeholder="必填" />
                                        </li>
                                    @endif
                                    @if($vv['type'] == 3)
                                            <li>
                                                <span class="name">{{$vv['name']}}</span>
                                                <input class="mustFill" name="insurance_attributes[{{ $v['module_key'] }}][{{ $vv['ty_key'] }}]" placeholder="{{$vv['name']}}" />
                                            </li>
                                    @endif
                                    @if($vv['type'] == 6)
                                        <li>
                                            <span class="name">{{$vv['name']}}</span>
                                            @foreach($vv['attributeValues'] as $ak => $av)
                                                <input  class="btn btn-default" name="insurance_attributes[{{ $v['module_key'] }}][{{ $vv['ty_key'] }}]" value="{{$av['ty_value']}}" />{{$av['value']}}
                                            @endforeach
                                        </li>
                                    @endif
                                    @if(in_array($vv['type'], [0, 9]))
                                            <li>
                                                <span class="name">{{$vv['name']}}</span>
                                                <select class="choose" name="insurance_attributes[{{ $v['module_key'] }}][{{ $vv['ty_key'] }}]" id="{{ $vv['ty_key'] }}">
                                                    @foreach($vv['attributeValues'] as $ak => $av)
                                                        <option value="{{$av['ty_value']}}">{{$av['value']}}</option>
                                                    @endforeach
                                                </select>
                                                <i class="iconfont icon-gengduo"></i>
                                            </li>
                                    @endif
                                @endforeach
                            @endif
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
            <input type="hidden" name="_token" value="{{csrf_token()}}">
            <input type="hidden" name="ins" value="{{json_encode($ins)}}">

        <div class="buttonbox">
            <button class="btn btn-next" disabled="disabled">下一步</button>
        </div>
        </form>
    </div>
</div>

<script src="{{config('view_url.mobile_group_ins')}}js/lib/jquery-1.11.3.min.js"></script>
<script src="{{config('view_url.mobile_group_ins')}}js/lib/area.js"></script>
<script src="{{config('view_url.mobile_group_ins')}}js/lib/mui.min.js"></script>
<script src="{{config('view_url.mobile_group_ins')}}js/lib/mui.picker.all.js"></script>
<script src="{{config('view_url.mobile_group_ins')}}js/common.js"></script>
<script src="{{config('view_url.mobile_group_ins')}}js/applicant.js"></script>
<script>
    var company_type = 0; // 企业是否为三证合一企业

    areaPicker('.areaPicker',function(){
        company_type === 0 ? check1() : check2();
    });


    selectData('.radioBox','single');

    $('.zbtn-select').click(function() {
        company_type = $(this).index();
        if(company_type == 0){
            $('.comTypeOne').show();
            $('.comTypeTwo').hide();
        }else{
            $('.comTypeOne').hide();
            $('.comTypeTwo').show();
        }
        company_type === 0 ? check1() : check2();
    });

    // 实时监听必填项
    $('input').bind('input propertychange', function() {
        company_type === 0 ? check1() : check2();
    });
    function check1(){
        if(!checkMustFill('.mustFill')){
            $('.btn-next').prop('disabled',true);
        }else{
            $('.btn-next').prop('disabled',false);
        }
    }
    function check2(){
        if(!checkMustFill('.mustFill') || !checkMustFill('.comTypeTwo input')){
            $('.btn-next').prop('disabled',true);
        }else{
            $('.btn-next').prop('disabled',false);
        }
    }
    {{--// 点击提交数据--}}
    {{--$('.btn-next').on('tap',function(){--}}
        {{--var inputDOM = document.querySelectorAll('input');--}}
        {{--var selectDOM = document.querySelectorAll('select');--}}
        {{--var json = Array();--}}
        {{--for (var i = 0, len = inputDOM.length; i < len; i++){--}}
            {{--json.push({"name": inputDOM[i].name, "value": inputDOM[i].value});--}}
        {{--}--}}
        {{--var str = JSON.stringify(json);--}}
        {{--var json1 = Array();--}}
        {{--for (var j = 0, len1 = selectDOM.length; j< len1; j++){--}}
            {{--json1.push({"name": selectDOM[j].name, "value": selectDOM[j].value});--}}
        {{--}--}}
        {{--var str1 = JSON.stringify(json1);--}}
        {{--sessionStorage.setItem("oneStepdata",str);--}}
        {{--sessionStorage.setItem("oneStepdataselect",str1);--}}
        {{--sessionStorage.setItem("oneStepdata"+{{$_COOKIE['user_id']}}+'_'+{{$identification}},str);--}}
        {{--location.href = '/ins/group_ins/insure_mobile_company_info/'+{{$identification}};--}}
    {{--});--}}


</script>

</body>

</html>