@extends('frontend.guests.frontend_layout.policy_base')
<link rel="stylesheet" href="{{ url(config('resource.position.css').'/frontend/product/product-policy.css') }}">
@section('content')
    <div class="main-block">
        <div class="main-left">
            <div class="main-left-inform">
                <img src="" alt=""><span> 为了保障您的权益，请填写真实有效的信息。您填写的内容仅供投保使用，对于您的信息我们会严格保密。</span>
            </div>
            <form class="form-horizontal" method="post"  id="form" action="/order/change_submit" onsubmit="return toVaild()">
                {{ csrf_field() }}
                <input type="hidden" name="union_order_code" value="{{$union_order_code}}">
                <div class="relation">
                    <div class="input-block">
                        <label for="">为谁投保</label>
                        <select  class="common-input" name="holdInsRelation">
                            @foreach($relation as $value)
                                    <option value="{{$value->number}}">{{$value->name}}</option>
                            @endforeach
                        </select>
                        <span class="error-message"></span>
                    </div>
                    <div class="input-block">
                        <label for="">起保日期</label>
                        <input type="date" name="startTime" class="common-input" value="{{$warranty_res['start_time']}}">
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
                        <input type="text" class="common-input" placeholder="投保人姓名" name="holderName" value="{{$policy['name']}}">
                        <span class="error-message"></span>
                    </div>
                    <div class="input-block">
                        <label for="">证件类型</label>
                        <select class="common-input code-select" name="holderIdType">>
                            @foreach($card_type as $value)
                                @if($policy['card_type']==$value->number)
                                    <option value="{{$value->number}}" selected>{{$value->name}}</option>
                                @endif
                            @endforeach
                        </select>
                        <input type="text" class="code-input" placeholder="请输入证件号" name="holderIdNumber" value="{{$policy['code']}}">
                        <span class="error-message"></span>
                    </div>
                    <div class="input-block">
                        <label for="">详细地址</label>
                        <input type="text" class="common-input" placeholder="详细地址" name="holderAddress" value="北京市东城区夕照寺中街14号">
                        <span class="error-message"></span>
                    </div>
                    <div class="input-block">
                        <label for="">职业</label>
                        <select class="common-input" name="holderOccupation">
                            @foreach($occupation as $value)
                                @if($policy['occupation']==$value->number)
                                <option value="{{$value->number}}" select>{{$value->name}}</option>
                                @endif
                            @endforeach
                        </select>
                        <span class="error-message"></span>
                    </div>
                    <div class="input-block">
                        <label for="">手机号</label>
                        <input type="text" class="common-input" placeholder="手机号码" name="holderPhone" value="{{$policy['phone']}}">
                        <span class="error-message"></span>
                    </div>
                    <div class="input-block">
                        <label for="">电子邮箱</label>
                        <input type="email" class="common-input email-input" placeholder="邮箱地址" name="holderEmail" value="{{$policy['email']}}">
                        <span class="error-message"></span>
                    </div>
                    <div class="default-connect input-block">
                        <label for=""></label>
                        <input type="checkbox" name="holderDefault">
                        <span>设为默认联系人</span>
                    </div>
                </div>

                @foreach($recognizees as $recognizee)
                <div class="recognizee-message">
                    <div class="main-left-message-title">
                        <span>被保人信息</span>
                    </div>
                    <div class="input-block">
                        <label for="">姓名</label>
                        <input type="text" class="common-input"  placeholder="被保人姓名" name="insuredName" value="{{$recognizee['name']}}">
                        <span class="error-message"></span>
                    </div>
                    <div class="input-block">
                        <label for="">证件类型</label>
                        <select class="common-input code-select" name="insureIdType">
                            @foreach($card_type as $value)
                                @if($recognizee['card_type']==$value->number)
                                    <option value="{{$value->number}}" selected>{{$value->name}}</option>
                                @endif
                            @endforeach
                        </select>
                        <input type="text" class="code-input" placeholder="请输入证件号" name="insuredIdNumber" value="{{$recognizee['code']}}">
                        <span class=""></span>
                    </div>
                    <div class="input-block">
                        <label for="">手机号</label>
                        <input type="text" class="common-input" placeholder="选择添加" name="insuredPhone" value="{{$recognizee['phone']}}">
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
                @endforeach
                {{--<div class="urgent-connect">--}}
                    {{--<div class="main-left-message-title">--}}
                        {{--<img src="" alt=""><span>添加紧急联系人</span>--}}
                    {{--</div>--}}
                {{--</div>--}}
                <div class="policy-confirm">
                    <input type="checkbox">
                    <span>我已查看并同意 <a href="">变更须知</a> 和 <a href="">投保人申明</a></span>
                </div>
                <div class="policy-submit">
                    <input type="submit" value="确认变更">
                    {{--<span><a onclick="doSaveForm2()"><u>保存投保信息</u></a></span>--}}
                </div>
            </form>
                <script>
//                    function doSaveForm2() {
//                        var o = {};
//                        var a = $(form).serializeArray();
//                        $.each(a, function () {
//                            if (o[this.name] !== undefined) {
//                                if (!o[this.name].push) {
//                                    o[this.name] = [o[this.name]];
//                                }
//                                o[this.name].push(this.value || '');
//                            } else {
//                                o[this.name] = this.value || '';
//                            }
//                        });
//
//                        $.ajax( {
//                            type : "get",
//                            url : '/saveforminfo',
//                            dataType : 'json',
//                            data :o,
//                            success:function(msg){
//                                if(msg.status == 0){
//                                    alert('保存成功');
//                                    window.location = location;
//                                }else{
//                                    alert('操作失败，请重新尝试！');
//                                }
//                            }
//                        });
//                    }
                    </script>
        </div>
        {{----}}
        {{--<div class="main-right">--}}
            {{--<div class="main-right-top">--}}
                {{--<div class="main-right-logo">--}}
                    {{--<img src="{{env('TY_API_PRODUCT_SERVICE_URL')}}{{$product['company_logo']}}" style="width: 230px;height: 60px;">--}}
                {{--</div>--}}
                {{--<div class="main-right-company">--}}
                    {{--{{$product['product_name']}}--}}
                {{--</div>--}}
            {{--</div>--}}
            {{--<div class="main-right-middle">--}}
                {{--@foreach($parameter as $key=>$value)--}}
                    {{--@if($key <> '费率')--}}
                        {{--<div class="detail">--}}
                    {{--<span  class="detail-title">--}}
                        {{--{{$key}}--}}
                    {{--</span>--}}
                            {{--<span   class="detail-content">--}}
                      {{--{{$value}}--}}
                    {{--</span>--}}
                            {{--<div class="ClearFix"></div>--}}
                        {{--</div>--}}
                    {{--@else--}}
                        {{--<div class="price">--}}
                            {{--<span class="name">价格</span>--}}
                            {{--<span class="count">￥{{$value}}</span>--}}
                            {{--<div class="ClearFix"></div>--}}
                        {{--</div>--}}
                        {{--<div class="number">--}}
                            {{--<span class="name">份数</span>--}}
                            {{--<span class="count">1</span>--}}
                            {{--<div class="ClearFix"></div>--}}
                        {{--</div>--}}
                        {{--<div class="sum">--}}
                            {{--<span class="name">合计</span>--}}
                            {{--<span class="count">￥{{$value}}</span>--}}
                            {{--<div class="ClearFix"></div>--}}
                        {{--</div>--}}
                    {{--@endif--}}
                {{--@endforeach--}}
                {{--<div class="detail">--}}
                    {{--<span class="detail-title">--}}
                        {{--保障期限--}}
                    {{--</span>--}}
                    {{--<span class="detail-content">--}}
                        {{--2年--}}
                    {{--</span>--}}
                    {{--<div class="ClearFix"></div>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
        <div class="ClearFix"></div>
    </div>

    <script>
        function toVaild(){
            var o = {};
            var a = $(form).serializeArray();
            $.each(a, function () {
                if (o[this.name] !== undefined) {
                    if (!o[this.name].push) {
                        o[this.name] = [o[this.name]];
                    }
                    o[this.name].push(this.value || '');
                } else {
                    o[this.name] = this.value || '';
                }
            });
            //被保人
            var startTime = o['startTime'];
            //投保人
            var holderName = o['holderName'];
            var holderIdNumber = o['holderIdNumber'];
            var holderAddress = o['holderAddress'];
            var holderPhone= o['holderPhone'];
            var holderEmail= o['holderEmail'];
            var holderDefault= o['holderDefault'];
            //被保人
            var insuredName = o['insuredName'];
            var insuredIdNumber= o['insuredIdNumber'];
            var insuredPhone= o['insuredPhone'];
            //正则匹配邮箱
            var myreg = /^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;
            if (startTime == null || startTime == undefined || startTime == '') {
                alert('请正确填写起保日期—'+'如'+'2017-07-09');
                return false;
            } else if (holderName == null || holderName == undefined || holderName == '') {
                alert('请正确填写投保人姓名');
                return false;
            }else if (holderIdNumber == null || holderIdNumber == undefined || holderIdNumber == ''){
                alert('请正确填写投保人证件号码！');
                return false;
            }else if(holderIdNumber.length !== 18) {
                alert('投保人证件号码不符合要求！');
                return false;
            }else if (holderAddress == null || holderAddress == undefined || holderAddress == '') {
                alert('请正确填写投保人详细住址！！');
                return false;
            }else if (holderPhone == null || holderPhone == undefined || holderPhone == '') {
                alert('请正确填写投保人联系方式');
                return false;
            }else if(holderPhone.length !== 11) {
                alert('投保人联系方式不符合要求！');
                return false;
            }else if (holderEmail == null || holderEmail == undefined || holderEmail == '') {
                alert('请正确填写投保人邮箱地址！！');
                return false;
            }else if(!myreg.test(holderEmail))
            {
                alert('请输入有效的E_mail！');
                return false;
            }else if (insuredName == null || insuredName == undefined || insuredName == '') {
                alert('请正确填写被保人姓名！！');
                return false;
            }else if (insuredIdNumber == null || insuredIdNumber == undefined || insuredIdNumber == '') {
                alert('请正确填写被保人证件号！！');
                return false;
            }else  if(insuredIdNumber.length !== 18) {
                alert('被保人证件号码不符合要求！');
                return false;
            }else {
                return true;
            }
        }
    </script>
@stop
