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
                    <div class="person">
                        <h3 class="title">保单信息</h3>
                        <table class="content-table-detail">
                            <tbody>
                            <tr>
                                <th>投保计划</th>
                                <td>国华测试产品</td>
                            </tr>
                            <tr>
                                <th>保障期间</th>
                                <td>1年</td>
                            </tr>
                            <tr>
                                <th>起保日期</th>
                                <td>{{date("Y-m-d",time())}}</td>
                            </tr>
                            <tr>
                                <th>终止日期</th>
                                <td>{{date('Y-m-d', strtotime("+1 year"))}}</td>
                            </tr>
                            <tr>
                                <th>保单形式</th>
                                <td>电子保单</td>
                            </tr>
                            <tr>
                                <th>投保份数</th>
                                <td>1</td>
                            </tr>
                            <tr>
                                <th>保额</th>
                                {{--<td class="f18164">￥<span class="price">{{$parameter['tariff']}}.00 </span></td>--}}
                            </tr>
                            <tr>
                                <th>保费</th>
{{--                                <td class="f18164">￥<span class="price">{{$parameter['tariff']}}.00 </span></td>--}}
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="person">
                        <h3 class="title">投保人信息</h3>
                        {{--<table class="content-table-detail">--}}
                            {{--<tbody>--}}
                            {{--<tr>--}}
                                {{--<th>姓名</th>--}}
                                {{--<td>{{$input['holderName']}}</td>--}}
                            {{--</tr>--}}
                            {{--<tr>--}}
                                {{--<th>证件类型</th>--}}
                                {{--@if(isset($input['holderIdType']))--}}
                                    {{--@foreach($card_type as $value)--}}
                                        {{--@if($value->number==$input['holderIdType'])--}}
                                            {{--<td>{{$value['name']}}</td>--}}
                                        {{--@endif--}}
                                    {{--@endforeach--}}
                                {{--@endif--}}
                            {{--</tr>--}}
                            {{--<tr>--}}
                                {{--<th>证件号</th>--}}
                                {{--<td>{{$input['holderIdNumber']}}</td>--}}
                            {{--</tr>--}}
                            {{--<tr>--}}
                                {{--<th>手机号码</th>--}}
                                {{--<td>{{$input['holderPhone']}}</td>--}}
                            {{--</tr>--}}
                            {{--<tr>--}}
                                {{--<th>电子邮箱</th>--}}
                                {{--<td>{{$input['holderEmail']}}</td>--}}
                            {{--</tr>--}}
                            {{--<tr>--}}
                                {{--<th>职业</th>--}}
                                {{--@if(isset($input['holderOccupation']))--}}
                                    {{--@foreach($occupation as $value)--}}
                                        {{--@if($value->number==$input['holderOccupation'])--}}
                                            {{--<td>{{$value['name']}}</td>--}}
                                        {{--@endif--}}
                                    {{--@endforeach--}}
                                {{--@endif--}}
                            {{--</tr>--}}
                            {{--</tbody>--}}
                        {{--</table>--}}
                    </div>
                    <div class="person">
                        <h3 class="title">被保人信息</h3>
                        <table class="content-table-detail">
                            {{--<tbody>--}}
                            {{--<tr>--}}
                                {{--<th>姓名</th>--}}
                                {{--<td>{{$input['insuredName']}}</td>--}}
                            {{--</tr>--}}
                            {{--<tr>--}}
                                {{--<th>证件类型</th>--}}
                                {{--@if(isset($input['insuredIdType']))--}}
                                    {{--@foreach($card_type as $value)--}}
                                        {{--@if($value->number==$input['insuredIdType'])--}}
                                            {{--<td>{{$value['name']}}</td>--}}
                                        {{--@endif--}}
                                    {{--@endforeach--}}
                                {{--@endif--}}
                            {{--</tr>--}}
                            {{--<tr>--}}
                                {{--<th>证件号</th>--}}
                                {{--<td>{{$input['insuredIdNumber']}}</td>--}}
                            {{--</tr>--}}
                            {{--<tr>--}}
                                {{--<th>手机号码</th>--}}
                                {{--<td>{{$input['insuredPhone']}}</td>--}}
                            {{--</tr>--}}
                            {{--<tr>--}}
                                {{--<th>电子邮箱</th>--}}
                                {{--<td>{{$input['holderEmail']}}</td>--}}
                            {{--</tr>--}}
                            {{--<tr>--}}
                                {{--<th>职业</th>--}}
                                {{--@if(isset($input['insuredOccupation']))--}}
                                    {{--@foreach($occupation as $value)--}}
                                        {{--@if($value->number==$input['insuredOccupation'])--}}
                                            {{--<td>{{$value['name']}}</td>--}}
                                        {{--@endif--}}
                                    {{--@endforeach--}}
                                {{--@endif--}}
                            {{--</tr>--}}
                            {{--<tr>--}}
                                {{--<th>与投保人关系</th>--}}
                                {{--@if(isset($input['holdInsRelation']))--}}
                                    {{--@foreach($relations as $relation)--}}
                                        {{--@if($relation->number==$input['holdInsRelation'])--}}
                                            {{--<td>{{$relation['name']}}</td>--}}
                                        {{--@endif--}}
                                    {{--@endforeach--}}
                                {{--@endif--}}
                            {{--</tr>--}}
                            {{--<tr>--}}
                                {{--<th>受益人信息</th>--}}
                                {{--<td>{{$input['beneficiary']}}</td>--}}
                            {{--</tr>--}}
                            {{--</tbody>--}}
                        </table>
                    </div>
                    <div class="buttonbox"><button class="btn btn-a4d790" onclick="self.location=document.referrer;">修改信息</button><button class="btn btn-f18164" onclick="insureSubmit()">提交订单</button></div>
                </div>
            </div>
            @include('frontend.guests.product.product_notice')
        </div>
    </div>
    <form class="form-horizontal" method="post"  id="form" action="{{ url('product/insure_submit')}}">
        {{ csrf_field() }}
        {{--<input type="hidden" name="input" value="{{$inputs}}">--}}
    </form>
    <script src="{{config('view_url.view_url')}}js/lib/laydate.js"></script>
    <script src="{{config('view_url.view_url')}}js/information1.js"></script>
    <script>
        function insureSubmit() {
            $(form).submit();
        }
    </script>
@stop