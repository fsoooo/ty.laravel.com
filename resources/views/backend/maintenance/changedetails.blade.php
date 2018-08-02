@extends('frontend.guests.frontend_layout.policy_bases')
<link rel="stylesheet" href="{{ url(config('resource.position.css').'/frontend/product/product-policy.css') }}">
@section('content')

    <div class="main-block">
        <div>
            <a href="/backend/maintenance/change_data/user"><<返回</a>
        </div><br/>
        <div class="main-left">
            <div class="main-left-inform">
                <img src="" alt=""><span> 为了保障您的权益，您填写的内容仅供投保使用，对于您的信息我们会严格保密。（红色为修改后的无内容）</span>
            </div>
            @include('frontend.guests.layout.alert_info')
            <form class="form-horizontal" id="myForm" action="/order/submit_change" onsubmit="return toVaild()">
                {{ csrf_field() }}
                <input type="hidden" name="union_order_code" value="{{$union_order_code}}">
                <input type="hidden" name="input" value="{{json_encode($input)}}">
                <input type="hidden" name="change_res" value="{{json_encode($res)}}">
                <input type="hidden" name="save_input" value="{{json_encode($save_input)}}">
                <div class="relation">
                    <div class="input-block">
                        <label for="">为谁投保</label>
                        <select  class="common-input" name="holdInsRelation">
                            @foreach($relation as $value)
                                @if($save_input['holdInsRelation']==$value->number)
                                    @if(array_key_exists('holdInsRelation',$res))
                                        <option value="{{$value->number}}" style="color: red">{{$value->name}}</option>
                                    @else
                                        <option value="{{$value->number}}">{{$value->name}}</option>
                                    @endif
                                @endif
                            @endforeach
                        </select>
                        <span class="error-message"></span>
                    </div>
                    <div class="input-block">
                        <label for="">起保日期</label>
                        @if(array_key_exists('startTime',$res))
                            <input type="date" name="startTime" class="common-input" value="{{$save_input['startTime']}}">
                            <input type="date" name="startTime" class="common-input" value="{{$res['startTime']}}" style="color: red">
                        @else
                            <input type="date" name="startTime" class="common-input" value="{{$save_input['startTime']}}">
                        @endif

                        <span class="error-message"></span>
                    </div>
                </div>

                <div class="policy-message">
                    <div class="main-left-message-title">
                        {{--<span>你的信息</span>--}}
                        <span>投保人信息</span>
                    </div>
                    <div class="input-block">
                        <label for="">姓名</label>
                        @if(array_key_exists('holderName',$res))
                            <input type="text" class="common-input" placeholder="投保人姓名" name="holderName" value="{{$save_input['holderName']}}" >
                            <input type="text" class="common-input" placeholder="投保人姓名" name="holderName" value="{{$res['holderName']}}" style="color: red">
                        @else
                            <input type="text" class="common-input" placeholder="投保人姓名" name="holderName" value="{{$save_input['holderName']}}">
                        @endif
                        <span class="error-message"></span>
                    </div>
                    <div class="input-block">
                        <label for="">证件类型</label>
                        <select class="common-input code-select" name="holderIdType">>
                            @foreach($card_type as $value)
                                @if($save_input['holderIdType']==$value->number)
                                    @if(array_key_exists('holderIdType',$res))
                                        <option value="{{$value->number}}" style="color: red">{{$value->name}}</option>
                                    @else
                                        <option value="{{$value->number}}">{{$value->name}}</option>
                                    @endif
                                @endif
                            @endforeach
                        </select>
                        @if(array_key_exists('holderIdNumber',$res))
                            <input type="text" class="code-input" placeholder="请输入证件号" name="holderIdNumber" value="{{$save_input['holderIdNumber']}}">
                            <input type="text" class="code-input" placeholder="请输入证件号" name="holderIdNumber" value="{{$res['holderIdNumber']}}" style="color: red">
                        @else
                            <input type="text" class="code-input" placeholder="请输入证件号" name="holderIdNumber" value="{{$save_input['holderIdNumber']}}">
                        @endif
                        <span class="error-message"></span>
                    </div>
                    <div class="input-block">
                        <label for="">详细地址</label>
                        @if(array_key_exists('holderAddress',$res))
                            <input type="text" class="common-input" placeholder="详细地址" name="holderAddress" value="{{$save_input['holderAddress']}}">
                            <input type="text" class="common-input" placeholder="详细地址" name="holderAddress" value="{{$save_input['holderAddress']}}" style="color: red">
                        @else
                            <input type="text" class="common-input" placeholder="详细地址" name="holderAddress" value="{{$save_input['holderAddress']}}">
                        @endif
                        <span class="error-message"></span>
                    </div>
                    <div class="input-block">
                        <label for="">职业</label>
                        <select class="common-input" name="holderOccupation">
                            @foreach($occupation as $value)
                                @if($save_input['holderOccupation']==$value->number)

                                    @if(array_key_exists('holderOccupation',$res))
                                        <option value="{{$value->number}}" style="color: red">{{$value->name}}</option>
                                    @else
                                        <option value="{{$value->number}}">{{$value->name}}</option>
                                    @endif
                                @endif
                            @endforeach
                        </select>
                        <span class="error-message"></span>
                    </div>
                    <div class="input-block">
                        <label for="">手机号</label>
                        @if(array_key_exists('holderPhone',$res))
                            <input type="text" class="common-input" placeholder="手机号码" name="holderPhone" value="{{$save_input['holderPhone']}}" >
                            <input type="text" class="common-input" placeholder="手机号码" name="holderPhone" value="{{$save_input['holderPhone']}}" style="color: red">
                        @else
                            <input type="text" class="common-input" placeholder="手机号码" name="holderPhone" value="{{$save_input['holderPhone']}}">
                        @endif
                        {{--<input type="text" class="common-input" placeholder="手机号码" name="holderPhone" value="{{$save_input['holderPhone']}}">--}}
                        <span class="error-message"></span>
                    </div>
                    <div class="input-block">
                        <label for="">电子邮箱</label>
                        @if(array_key_exists('holderEmail',$res))
                            <input type="text" class="common-input" placeholder="邮箱地址" name="holderEmail" value="{{$save_input['holderEmail']}}" >
                            <input type="text" class="common-input" placeholder="邮箱地址" name="holderEmail" value="{{$save_input['holderEmail']}}" style="color: red">
                        @else
                            <input type="text" class="common-input" placeholder="邮箱地址" name="holderEmail" value="{{$save_input['holderEmail']}}">
                        @endif
                        {{--<input type="email" class="common-input email-input" placeholder="邮箱地址" name="holderEmail" value="{{$save_input['holderEmail']}}">--}}
                        <span class="error-message"></span>
                    </div>
                    <div class="default-connect input-block">
                        <label for=""></label>
                        <input type="checkbox" name="holderDefault">
                        <span>设为默认联系人</span>
                    </div>
                </div>


                <div class="recognizee-message">
                    <div class="main-left-message-title">
                        <span>被保人信息</span>
                    </div>
                    <div class="input-block">
                        <label for="">姓名</label>
                        @if(array_key_exists('insuredName',$res))
                            <input type="text" class="common-input" placeholder="被保人姓名" name="insuredName" value="{{$save_input['insuredName']}}" >
                            <input type="text" class="common-input" placeholder="被保人姓名" name="insuredName" value="{{$save_input['insuredName']}}" style="color: red">
                        @else
                            <input type="text" class="common-input" placeholder="被保人姓名" name="insuredName" value="{{$save_input['insuredName']}}">
                        @endif
                        {{--<input type="text" class="common-input"  placeholder="被保人姓名" name="insuredName" value="{{$save_input['insuredName']}}">--}}
                        <span class="error-message"></span>
                    </div>
                    <div class="input-block">
                        <label for="">证件类型</label>
                        <select class="common-input code-select" name="insureIdType">
                            @foreach($card_type as $value)
                                @if($save_input['insureIdType']==$value->number)
                                    @if(array_key_exists('insureIdType',$res))
                                        <option value="{{$value->number}}" style="color: red">{{$value->name}}</option>
                                    @else
                                        <option value="{{$value->number}}">{{$value->name}}</option>
                                    @endif
                                @endif
                            @endforeach
                        </select>
                        @if(array_key_exists('insuredIdNumber',$res))
                            <input type="text" class="code-input" placeholder="请输入证件号" name="insuredIdNumber" value="{{$save_input['insuredIdNumber']}}">
                            <input type="text" class="code-input" placeholder="请输入证件号" name="insuredIdNumber" value="{{$save_input['insuredIdNumber']}}" style="color: red">
                        @else
                            <input type="text" class="code-input" placeholder="请输入证件号" name="insuredIdNumber" value="{{$save_input['insuredIdNumber']}}">
                        @endif
                        {{--<input type="text" class="code-input" placeholder="请输入证件号" name="insuredIdNumber" value="{{$save_input['insuredIdNumber']}}">--}}
                        <span class=""></span>
                    </div>
                    <div class="input-block">
                        <label for="">手机号</label>
                        @if(array_key_exists('insuredPhone',$res))
                            <input type="text" class="common-input" placeholder="选择添加" name="insuredPhone" value="{{$save_input['insuredPhone']}}">
                            <input type="text" class="common-input" placeholder="选择添加" name="insuredPhone" value="{{$save_input['insuredPhone']}}" style="color: red">
                        @else
                            <input type="text" class="common-input" placeholder="选择添加" name="insuredPhone" value="{{$save_input['insuredPhone']}}">
                        @endif
                        {{--<input type="text" class="common-input" placeholder="选择添加" name="insuredPhone" value="{{$save_input['insuredPhone']}}">--}}
                        <span class="error-message"></span>
                    </div>
                    <div class="input-block">
                        <label for="">缴别[年]</label>
                        <select class="common-input" name="insuredPayWay">
                            <option value="10">10年</option>
                            <option value="15">15年</option>
                            <option value="1">一次付清</option>
                        </select>
                        <span class="error-message"></span>
                    </div>
                    <div class="input-block">
                        <label for="">基本保额倍数</label>
                        <select class="common-input" name="coverageMultiples">
                            <option value="100">100</option>
                            <option value="200">200</option>
                            <option value="300">300</option>
                        </select>
                        <span class="error-message"></span>
                    </div>
                    <div class="input-block">
                        <label for="">保期类型</label>
                        <select  class="common-input" name="durationPeriodType">
                            <option value="0">终身</option>
                        </select>
                        <span class="error-message"></span>
                    </div>
                    <div class="input-block">
                        <label for="">保期值</label>
                        <select class="common-input" name="durationPeriodTypes">
                            <option value="0">终身</option>
                        </select>
                        <span class="error-message"></span>
                    </div>
                    <div class="input-block">
                        <label for="">受益人</label>
                        <select class="common-input">
                            <option value="">法定继承人</option>
                        </select>
                        <span class="error-message"></span>
                    </div>
                </div>
            </form>
            <script>

                function change() {
                    $('input[type=text]').attr("disabled","disabled")
                    $('input[type=date]').attr("disabled","disabled")
                    $('input[type=radio]').attr("disabled","disabled")
                    $('input[type=checkbox]').attr("disabled","disabled")
                    $('select').attr("disabled","disabled")
                }
                window.onload=change;
            </script>
        </div>
        <div class="ClearFix"></div>
    </div>
@stop
