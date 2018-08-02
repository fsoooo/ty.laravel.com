@extends('frontend.guests.guests_layout.base')
<link rel="stylesheet/less" href="{{config('view_url.view_url')}}css/process.less"/>
<script src="{{config('view_url.view_url').'js/lib/less.min.js'}}"></script>
@section('content')
    @if(!is_null($form))
        <form class="form-horizontal" method="post"  id="form" action="{{ url('product/confirmform')}}" onsubmit="return toVaild()">
            {{ csrf_field()}}
            <input type="text" name="ty_product_id" value="{{ $product['ty_product_id']}}" hidden>
            <input type="text" name="identification" value="{{ $identification }}" hidden>
            <input type="text" name="product_number" value="{{ $product['product_number'] }}" hidden>
            <input type="text" name="forminfo_id" value="{{ $form['id'] }}" hidden>
            <input type="text" name="uuid" value="{{ $uuid }}" hidden>
            <span id="holderIdType"></span>
            <span id="holderOccupation"></span>
            <span id="holdInsRelation"></span>
            <span id="insuredIdType"></span>
            <span id="insuredOccupation"></span>
            <div class="wrapper step3">
                <div class="main notification clearfix">
                    <div class="notification-left fl">
                        <div class="notification-left-tip">
                            <i class="iconfont icon-yduidunpaishixin"></i><span>为了保障您的权益，请填写真实有效的信息。您填写的内容仅供投保使用，对于您的信息我们会严格保密。</span>
                        </div>
                        <div class="notification-left-content">
                            <div class="date">
                                <span class="name"><i class="f18164">*</i>起保日期</span>
                                <input type="text" name="startTime" class="inline laydate-icon" id="starttime" value="{{$form['startTime']}}">
                                <span>自起保日期<i class="cl333 time-start">2017-07-14零时起</i>至<i class="cl333 time-end">2017-07-17二十四时</i>止（北京时间）</span>
                            </div>

                            <div class="person">
                                <h3 class="title">您的信息</h3>
                                <ul>
                                    <li>
                                        <span class="name"><i class="f18164">*</i>姓名</span>
                                        <input type="text" name="holderName" value="{{$form['holderName']}}"/>
                                        <span class="error"></span>
                                    </li>
                                    <li>
                                        <span class="name"><i class="f18164">*</i>证件类型</span>
                                        <div class="select certificate-type">
                                            <span>身份证</span>
                                            <ul class="select-dropdown">
                                                @foreach($card_type as $value)
                                                    <li data-name='holderIdType' data-value='{{$value->number}}'>{{$value->name}}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                        <input class="w320" type="text"  name="holderIdNumber" value="{{$form['holderIdNumber']}}"/>
                                        <span class="error"></span>
                                    </li>
                                    <li class="person-show-hide">
                                        <span class="name"><i class="f18164">*</i>出生日期</span>
                                        <input type="text" class="inline laydate-icon" id="birthday" name="birthday" placeholder="请选择出生日期" value="{{$form['birthday']}}">
                                    </li>
                                    <li class="person-show-hide radiobox">
                                        <span class="name"><i class="f18164">*</i>性别</span>
                                        <label>
                                            <input type="radio" name="sex" value="m" checked hidden/>
                                            <i class="iconfont icon-danxuan2"></i><span>男</span>
                                        </label>
                                        <label>
                                            <input type="radio" name="sex" value="w" hidden/>
                                            <i class="iconfont icon-danxuan1"></i><span>女</span>
                                        </label>
                                    </li>
                                    <li>
                                        <span class="name"><i class="f18164">*</i>手机号码</span>
                                        <input type="text" name="holderPhone" value="{{$form['holderPhone']}}"/>
                                        <span class="error"></span>
                                    </li>
                                    <li>
                                        <span class="name"><i class="f18164">*</i>电子邮箱</span>
                                        <input type="email" name="holderEmail"  value="{{$form['holderEmail']}}"/>
                                        <span class="error"></span>
                                    </li>
                                    <li>
                                        <span class="name"><i class="f18164">*</i>职业</span>
                                        <div class="select profession1">
                                            <span>请选择</span>
                                            <ul class="select-dropdown">
                                                @foreach($occupation as $value)
                                                        <li data-name='holderOccupation' data-value='{{$value->number}}'>{{$value->name}}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </li>

                                    <li>
                                        <span class="name"><i class="f18164">*</i>受益人信息</span>
                                        <div class="select benefit1">
                                            <span>法定继承人</span>
                                            <ul class="select-dropdown">
                                                <li>法定继承人</li>
                                                <li>法定受益人</li>
                                            </ul>
                                        </div>
                                    </li>
                                    <li class="save">
                                        <label>
                                            <i class="icon icon-checkbox-selected"></i>
                                            <input type="checkbox" name="holderDefault" hidden checked/>
                                            保存为默认联系人
                                        </label>
                                    </li>
                                </ul>
                            </div>
                            <div class="person person-other">
                                <h3 class="title">被保人信息</h3>
                                <ul>
                                    <li>
                                        <span class="name"><i class="f18164">*</i>为谁投保</span>
                                        <div class="select insure">
                                            <span>本人</span>
                                            <ul class="select-dropdown">
                                                @foreach($relation as $value)
                                                    <li data-name='holdInsRelation' data-value='{{$value->number}}'>{{$value->name}}</li>
                                                @endforeach
                                                <li>其他</li>
                                            </ul>
                                        </div>
                                    </li>
                                </ul>
                                <ul class="person-other-content">
                                    <li>
                                        <span class="name"><i class="f18164">*</i>姓名</span>
                                        <input type="text"  name="insuredName" value="{{$form['insuredName']}}" />
                                        <span class="error"></span>
                                    </li>
                                    <li>
                                        <span class="name"><i class="f18164">*</i>证件类型</span>
                                        <div id="type" class="select type2">
                                            <span>身份证</span>
                                            <ul class="select-dropdown">
                                                @foreach($card_type as $value)
                                                    <li data-name='insuredIdType' data-value='{{$value->number}}'>{{$value->name}}</li>
                                                @endforeach
                                                <li>其他</li>
                                            </ul>
                                        </div>
                                        <input type="text" class="w320" name="insuredIdNumber" value="{{$form['insuredIdNumber']}}"/>
                                        <span class="error"></span>
                                    </li>
                                    <li>
                                        <span class="name"><i class="f18164">*</i>手机号码</span>
                                        <input type="text"  name="insuredPhone" value="{{$form['insuredPhone']}}"/>
                                        <span class="error"></span>
                                    </li>
                                    <li>
                                        <span class="name"><i class="f18164">*</i>电子邮箱</span>
                                        <input type="email" name="insuredEmail" value="{{$form['insuredEmail']}}"/>
                                        <span class="error"></span>
                                    </li>
                                    <li>
                                        <span class="name"><i class="f18164">*</i>职业</span>
                                        <div class="select profession2">
                                            <span>请选择</span>
                                            <ul class="select-dropdown">
                                                @foreach($occupation as $value)
                                                    <li data-name='insuredOccupation' data-value='{{$value->number}}'>{{$value->name}}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </li>
                                    <li>
                                        <span class="name"><i class="f18164">*</i>受益人信息</span>
                                        <div class="select benefit2">
                                            <span>法定继承人</span>
                                            <ul class="select-dropdown">
                                                <li><input type="hidden" name="beneficiary" value="1">法定继承人</li>
                                                <li>法定受益人</li>
                                            </ul>
                                        </div>
                                    </li>
                                    <li class="save">
                                        <label>
                                            <i class="icon icon-checkbox-selected"></i>
                                            <input type="checkbox" name="insureDefault" hidden checked/>
                                            保存为默认联系人
                                        </label>
                                    </li>
                                </ul>
                            </div>
                            <div class="contact">
                                <h3 class="title">紧急联系人（选填）<span class="btn-add"><i class="iconfont icon-close"></i></span></h3>
                                <ul class="contact-wrapper">
                                    <li>
                                        <span class="name">手机号码</span>
                                        <input type="text"  name="urgentPhone" value="{{$form['urgentPhone']}}"/>
                                        <span class="error"></span>
                                    </li>
                                    <li>
                                        <span class="name">电子邮箱</span>
                                        <input type="email" name="urgentEmail" value="{{$form['urgentEmail']}}"/>
                                        <span class="error"></span>
                                    </li>
                                </ul>
                                <div class="contact-agreement">
                                    <label>
                                        <i class="icon icon-checkbox"></i>
                                        <input type="checkbox" hidden/>
                                        我已查看并同意<a href="#" class="a4d790">保险条款</a>和<a href="#" class="a4d790">投保人申明</a>
                                    </label>
                                </div>
                                <div>
                                    <input type="submit" id="submit" class="btn btn-unusable" value="提交投保单" disabled="disabled">
                                    <span><a onclick="doSaveForm1()"><u>保存投保信息</u></a></span>
                                    <span id="checksave"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @include('frontend.guests.product.product_notice')
                </div>
            </div>
        </form>
    @else
    <form class="form-horizontal" method="post"  id="form" action="{{ url('product/confirmform')}}" onsubmit="return toVaild()">
        {{ csrf_field() }}
        <input type="text" name="ty_product_id" value="{{ $product['ty_product_id']}}" hidden>
        <input type="text" name="identification" value="{{ $identification }}" hidden>
        <input type="text" name="product_number" value="{{ $product['product_number'] }}" hidden>
        {{--<input type="text" name="forminfo_id" value="{{ $forminfo['id'] }}" hidden>--}}
        <input type="text" name="uuid" value="{{ $uuid }}" hidden>
    <div class="wrapper step3">
        <div class="main notification clearfix">
            <div class="notification-left fl">
                <div class="notification-left-tip">
                    <i class="iconfont icon-yduidunpaishixin"></i><span>为了保障您的权益，请填写真实有效的信息。您填写的内容仅供投保使用，对于您的信息我们会严格保密。</span>
                </div>
                <div class="notification-left-content">
                    <div class="date">
                        <span class="name"><i class="f18164">*</i>起保日期</span>
                        <input type="text" name="startTime" class="inline laydate-icon" id="starttime" value="{{date('Y-m-d',time())}}">
                        <span>自起保日期<i class="cl333 time-start">2017-07-14零时起</i>至<i class="cl333 time-end">2017-07-17二十四时</i>止（北京时间）</span>
                    </div>
                    @if(is_null($person_code))
                    <div class="person">
                        <h3 class="title">您的信息</h3>
                        <ul>
                            <li>
                                <span class="name"><i class="f18164">*</i>姓名</span>
                                <input type="text" name="holderName" />
                                <span class="error"></span>
                            </li>
                            <li>
                                <span class="name"><i class="f18164">*</i>证件类型</span>
                                <div class="select certificate-type">
                                    <span>身份证</span>
                                    <ul class="select-dropdown">
                                        @foreach($card_type as $value)
                                            <li data-name='holderIdType' data-value='{{$value->number}}'>{{$value->name}}</li>

                                        @endforeach
                                        <li>其他</li>
                                    </ul>
                                </div>
                                <input class="w320" type="text"  name="holderIdNumber" />
                                <span class="error"></span>
                            </li>
                            <li class="person-show-hide">
                                <span class="name"><i class="f18164">*</i>出生日期</span>
                                <input type="text" class="inline laydate-icon" id="birthday" name="birthday" placeholder="请选择出生日期">
                            </li>
                            <li class="person-show-hide radiobox">
                                <span class="name"><i class="f18164">*</i>性别</span>
                                <label>
                                    <input type="radio" name="sex" value="m" checked hidden/>
                                    <i class="iconfont icon-danxuan2"></i><span>男</span>
                                </label>
                                <label>
                                    <input type="radio" name="sex" value="w" hidden/>
                                    <i class="iconfont icon-danxuan1"></i><span>女</span>
                                </label>
                            </li>
                            <li>
                                <span class="name"><i class="f18164">*</i>手机号码</span>
                                <input type="text" name="holderPhone"/>
                                <span class="error"></span>
                            </li>
                            <li>
                                <span class="name"><i class="f18164">*</i>电子邮箱</span>
                                <input type="email" name="holderEmail" />
                                <span class="error"></span>
                            </li>
                            <li>
                                <span class="name"><i class="f18164">*</i>职业</span>
                                <div class="select profession1">
                                    <span>请选择</span>
                                    <ul class="select-dropdown">
                                        @foreach($occupation as $value)
                                            <li data-name='holderOccupation' data-value='{{$value->number}}'>{{$value->name}}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </li>

                            <li>
                                <span class="name"><i class="f18164">*</i>受益人信息</span>
                                <div class="select benefit1">
                                    <span>法定继承人</span>
                                    <ul class="select-dropdown">
                                        <li>法定继承人</li>
                                        <li>法定受益人</li>
                                    </ul>
                                </div>
                            </li>
                            <li class="save">
                                <label>
                                    <i class="icon icon-checkbox-selected"></i>
                                    <input type="checkbox" name="holderDefault" hidden checked/>
                                    保存为默认联系人
                                </label>
                            </li>
                        </ul>
                    </div>
                    @else
                        <div class="person">
                            <h3 class="title">您的信息</h3>
                            <ul>
                                <li>
                                    <span class="name"><i class="f18164">*</i>姓名</span>
                                    <input type="text" name="holderName" value="{{$user_info['real_name']}}"/>
                                    <span class="error"></span>
                                </li>
                                <li>
                                    <span class="name"><i class="f18164">*</i>证件类型</span>
                                    <div class="select certificate-type">
                                        <span>身份证</span>
                                        <ul class="select-dropdown">
                                            @foreach($card_type as $value)
                                                <li data-name='holderIdType' data-value='{{$value->number}}'>{{$value->name}}</li>
                                            @endforeach
                                            <li>其他</li>
                                        </ul>
                                    </div>
                                    <input class="w320" type="text"  name="holderIdNumber" value="{{$user_info['code']}}" />
                                    <span class="error"></span>
                                </li>
                                <li class="person-show-hide">
                                    <span class="name"><i class="f18164">*</i>出生日期</span>
                                    <input type="text" class="inline laydate-icon" id="birthday" name="birthday" placeholder="请选择出生日期">
                                </li>
                                <li class="person-show-hide radiobox">
                                    <span class="name"><i class="f18164">*</i>性别</span>
                                    <label>
                                        <input type="radio" name="sex" value="m" checked hidden/>
                                        <i class="iconfont icon-danxuan2"></i><span>男</span>
                                    </label>
                                    <label>
                                        <input type="radio" name="sex" value="w" hidden/>
                                        <i class="iconfont icon-danxuan1"></i><span>女</span>
                                    </label>
                                </li>
                                <li>
                                    <span class="name"><i class="f18164">*</i>手机号码</span>
                                    <input type="text" name="holderPhone" value="{{$user_info['phone']}}"/>
                                    <span class="error"></span>
                                </li>
                                <li>
                                    <span class="name"><i class="f18164">*</i>电子邮箱</span>
                                    <input type="email" name="holderEmail" value="{{$user_info['email']}}"/>
                                    <span class="error"></span>
                                </li>
                                <li>
                                    <span class="name"><i class="f18164">*</i>职业</span>
                                    <div class="select profession1">
                                        <span>请选择</span>
                                        <ul class="select-dropdown">
                                            @foreach($occupation as $value)
                                                <li data-name='holderOccupation' data-value='{{$value->number}}'>{{$value->name}}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </li>

                                <li>
                                    <span class="name"><i class="f18164">*</i>受益人信息</span>
                                    <div class="select benefit1">
                                        <span>法定继承人</span>
                                        <ul class="select-dropdown">
                                            <li>法定继承人</li>
                                            <li>法定受益人</li>
                                        </ul>
                                    </div>
                                </li>
                                <li class="save">
                                    <label>
                                        <i class="icon icon-checkbox-selected"></i>
                                        <input type="checkbox" name="holderDefault" hidden checked/>
                                        保存为默认联系人
                                    </label>
                                </li>
                            </ul>
                        </div>
                    @endif
                    <div class="person person-other">
                        <h3 class="title">被保人信息</h3>
                        <ul>
                            <li>
                                <span class="name"><i class="f18164">*</i>为谁投保</span>
                                <div class="select insure">
                                    <span>本人</span>
                                    <ul class="select-dropdown">
                                        @foreach($relation as $value)
                                            <li data-name='holdInsRelation' data-value='{{$value->number}}'>{{$value->name}}</li>
                                        @endforeach
                                        <li>其他</li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                        <ul class="person-other-content">
                            <li>
                                <span class="name"><i class="f18164">*</i>姓名</span>
                                <input type="text"  name="insuredName" />
                                <span class="error"></span>
                            </li>
                            <li>
                                <span class="name"><i class="f18164">*</i>证件类型</span>
                                <div id="type" class="select type2">
                                    <span>身份证</span>
                                    <ul class="select-dropdown">
                                        @foreach($card_type as $value)
                                            <li data-name='insuredIdType' data-value='{{$value->number}}'>{{$value->name}}</li>
                                        @endforeach
                                        <li>其他</li>
                                    </ul>
                                </div>
                                <input type="text" class="w320" name="insuredIdNumber"/>
                                <span class="error"></span>
                            </li>
                            <li>
                                <span class="name"><i class="f18164">*</i>手机号码</span>
                                <input type="text"  name="insuredPhone"/>
                                <span class="error"></span>
                            </li>
                            <li>
                                <span class="name"><i class="f18164">*</i>电子邮箱</span>
                                <input type="email" name="insuredEmail" />
                                <span class="error"></span>
                            </li>
                            <li>
                                <span class="name"><i class="f18164">*</i>职业</span>
                                <div class="select profession2">
                                    <span>请选择</span>
                                    <ul class="select-dropdown">
                                        @foreach($occupation as $value)
                                            <li data-name='insuredOccupation' data-value='{{$value->number}}'>{{$value->name}}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </li>
                            <li>
                                <span class="name"><i class="f18164">*</i>受益人信息</span>
                                <div class="select benefit2">
                                    <span>法定继承人</span>
                                    <ul class="select-dropdown">
                                        <li><input type="hidden" name="beneficiary" value="1">法定继承人</li>
                                        <li>法定受益人</li>
                                    </ul>
                                </div>
                            </li>
                            <li class="save">
                                <label>
                                    <i class="icon icon-checkbox-selected"></i>
                                    <input type="checkbox" name="insureDefault" hidden checked/>
                                    保存为默认联系人
                                </label>
                            </li>
                        </ul>
                    </div>
                    <div class="contact">
                        <h3 class="title">紧急联系人（选填）<span class="btn-add"><i class="iconfont icon-close"></i></span></h3>
                        <ul class="contact-wrapper">
                            <li>
                                <span class="name">手机号码</span>
                                <input type="text"  name="urgentPhone"/>
                                <span class="error"></span>
                            </li>
                            <li>
                                <span class="name">电子邮箱</span>
                                <input type="email" name="urgentEmail"/>
                                <span class="error"></span>
                            </li>
                        </ul>
                        <div class="contact-agreement">
                            <label>
                                <i class="icon icon-checkbox"></i>
                                <input type="checkbox" hidden/>
                                我已查看并同意<a href="#" class="a4d790">保险条款</a>和<a href="#" class="a4d790">投保人申明</a>
                            </label>
                        </div>
                        <div>
                            <input type="submit" id="submit" class="btn btn-unusable" value="提交投保单" disabled="disabled">
                            <span><a onclick="doSaveForm1()"><u>保存投保信息</u></a></span>
                            <span id="checksave"></span>
                        </div>
                    </div>
                </div>
            </div>
            @include('frontend.guests.product.product_notice')
        </div>
    </div>
        <span id="holderIdType"></span>
        <span id="holderOccupation"></span>
        <span id="holdInsRelation"></span>
        <span id="insuredIdType"></span>
        <span id="insuredOccupation"></span>
    </form>
    @endif
<script src="{{config('view_url.view_url')}}js/lib/laydate.js"></script>
<script src="{{config('view_url.view_url')}}js/information1.js"></script>
    <script>
//        var holderIdType,holderOccupation,holdInsRelation,insuredIdType,insuredOccupation;

        $('.select-dropdown li').click(function() {
            var name = $(this).attr('data-name');
            var value = $(this).attr('data-value');
            switch (name){
                case 'holderIdType':
//                    holderIdType = value;
                    $('#holderIdType').html('<input type="hidden" name="holderIdType" value="'+value+'" >');
                    break;
                case 'holderOccupation':
//                    holderOccupation = value;
                    $('#holderOccupation').html('<input type="hidden" name="holderOccupation" value="'+value+'" >');
                    break;
                case 'holdInsRelation':
//                    holdInsRelation = value;
                    $('#holdInsRelation').html('<input type="hidden" name="holdInsRelation" value="'+value+'" >');
                    break;
                case 'insuredIdType':
//                    insuredIdType = value;
                    $('#insuredIdType').html('<input type="hidden" name="insuredIdType" value="'+value+'" >');
                    break;
                case 'insuredOccupation':
//                    insuredOccupation = value;
                    $('#insuredOccupation').html('<input type="hidden" name="insuredOccupation" value="'+value+'" >');
                    break;
                default:
                    break;
            }
//            var q = {holderIdType:holderIdType,holderOccupation:holderOccupation,holdInsRelation:holdInsRelation,insuredIdType:insuredIdType,insuredOccupation:insuredOccupation};
//            window.p = q;
        });

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

        console.log(o['holderDefault']);
        console.log(o['insureDefault']);
        //被保人
        var startTime = o['startTime'];
        //投保人
        var holderName = o['holderName'];
        var holderIdType = o['holderIdType'];
        var holderIdNumber = o['holderIdNumber'];
        var birthday = o['holderIdNumber'];
        var holderAddress = o['holderAddress'];
        var holderPhone= o['holderPhone'];
        var holderEmail= o['holderEmail'];
        var holderDefault= o['holderDefault'];
        var holderOccupation = o['holderOccupation'];
        //和投保人关系
        var holdInsRelation = o['holdInsRelation'];
        //被保人
        var insuredName = o['insuredName'];
        var insuredIdType = o['insuredIdType'];
        var insuredIdNumber= o['insuredIdNumber'];
        var insuredPhone= o['insuredPhone'];
        var insuredOccupation = o['insuredOccupation'];
        var insureDefault = o['insureDefault'];
        //紧急联系人
        var urgentPhone = o['urgentEmail'];
        var urgentEmail = o['urgentEmail'];


        //正则匹配邮箱
        var myreg = /^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;
        function doSaveForm1() {
            $.ajax( {
                type : "get",
                url : '/saveforminfo',
                dataType : 'json',
                data :o,
                success:function(msg){
                    if(msg.status == 0){
                        $('#checksave').html('<font color="green">'+'保存成功'+'</font>');
                    }else{
                        $('#checksave').html('<font color="red">'+'操作失败，请重新尝试'+'</font>');
                    }
                }
            });
        }
        function toVaild() {
//            if (startTime == null || startTime == undefined || startTime == '') {
//                alert('请正确填写起保日期—'+'如'+'2017-07-09');
//                return false;
//            } else if (holderName == null || holderName == undefined || holderName == '') {
//                alert('请正确填写投保人姓名');
//                return false;
//            }else if (holderIdNumber == null || holderIdNumber == undefined || holderIdNumber == ''){
//                alert('请正确填写投保人证件号码！');
//                return false;
//            }else if(holderIdNumber.length !== 18) {
//                alert('投保人证件号码不符合要求！');
//                return false;
//            }else if (holderPhone == null || holderPhone == undefined || holderPhone == '') {
//                alert('请正确填写投保人联系方式');
//                return false;
//            }else if(holderPhone.length !== 11) {
//                alert('投保人联系方式不符合要求！');
//                return false;
//            }else if (holderEmail == null || holderEmail == undefined || holderEmail == '') {
//                alert('请正确填写投保人邮箱地址！！');
//                return false;
//            }else if(!myreg.test(holderEmail)) {
//                alert('请输入有效的E_mail！');
//                return false;
//            }
////            }else if(holderDefault == on){
//
//                var params  = {
//                    user_name:o['holderName'],
//                    id_type:o['holderIdType'],
//                    id_code:o['holderIdNumber'],
//                    user_phone:o['holderPhone'],
//                    user_email:o['holderEmail']
//                    user_occupation:o['holderOccupation']
//                };
//                $.ajax( {
//                    type : "get",
//                    url : '/saveusercontact',
//                    dataType : 'json',
//                    data :params,
//                    success:function(msg){
//                        if(msg.status == 0){
//                            alert('保存成功');
//                            window.location = location;
//                        }else{
//                            alert('操作失败，请重新尝试！');
//                        }
//                    }
//                });
//            }
//            if (insuredName == null || insuredName == undefined || insuredName == '') {
//                alert('请正确填写被保人姓名！！');
//                return false;
//            }else if (insuredIdNumber == null || insuredIdNumber == undefined || insuredIdNumber == '') {
//                alert('请正确填写被保人证件号！！');
//                return false;
//            }else  if(insuredIdNumber.length !== 18) {
//                alert('被保人证件号码不符合要求！');
//                return false;
//            }else {
//                return true;
//            }
            return true;
        }
</script>
@stop