@extends('frontend.guests.guests_layout.base')
<link rel="stylesheet/less" href="{{config('view_url.view_url')}}css/process.less"/>
<script src="{{config('view_url.view_url').'js/lib/less.min.js'}}"></script>
@section('content')
<div class="wrapper step4">
    <form id="form" action="/ins/do_pay_settlement" method="post" >
    <div class="main payment">
        <div class="table-head">
            <span class="col1"></span>
            <span class="col2">产品名称</span>
            <span class="col3">投保形式</span>
            <span class="col4">购买份数</span>
            <span class="col5">保费</span>
        </div>
        <table cellspacing="0" cellpadding="0">
            <tr>
                <td class="col1">
                    <div class="payment-img">
                        <a href="{{$company['url']}}"><img src="{{env('TY_API_PRODUCT_SERVICE_URL')}}/{{$company['logo']}}" alt="" /></a>
                    </div>
                </td>
                <td class="col2">
                    <div>{{$product->product_name}}</div>
                    <div class="rights">
                        <span>保障权益<i class="iconfont icon-jiantou2"></i></span>
                        <ul class="tip">
                            @if(isset($parameter['protect_item']))
                                @php $items = json_decode($parameter['protect_item'], true); @endphp
                                @foreach($items as $it => $item)
                                    <li class="clearfix">
                                        <div class="col1">{{$item['name']}}</div>
                                        @if(isset($item['defaultValue'])) <div class="col2">{{$item['defaultValue']}}</div> @endif
                                    </li>
                                @endforeach
                            @else
                                @foreach(json_decode($product->clauses,true) as $clause)
                                    @foreach($clause['duties'] as $duty)
                                    {{--<li><span>{{$duty['name']}}</span>5万元</li>--}}
                                    <li><span>{{$duty['name']}}</span></li>
                                    @endforeach
                                @endforeach
                            @endif
                        </ul>
                    </div>
                </td>
                <td class="col3">
                    @if($order->claim_type)
                    <div>电子保单</div>
                    @endif
                </td>
                <td class="col4">
                    <div>1</div>
                </td>
                <td class="col5">
                    <div class="f18164">￥{{$order->premium}}</div>
                </td>
            </tr>
        </table>
        <div class="payment-way clearfix">
            <div class="payment-way-selection clearfix">
                <div class="fl radiobox">

                    {{ csrf_field() }}
                    <input type="hidden" name="union_order_code" value="{{$union_order_code}}">
                    <input type="hidden" name="private_p_code" value="{{$private_p_code}}">
                    <input type="hidden" name="premium" value="{{$order->premium}}">
                    <span>支付方式：</span>
                    @foreach($pay_way as $k => $way)
                            <input type="radio" name="way" value="{{$k}}"  onclick='get_pay_way("{{$k}}" )'/>{{$way}}
                    @endforeach
                </div>
                {{--<div class="cheap-wrapper fr radiobox">--}}
                    {{--<label><input type="checkbox" hidden/><i class="icon icon-checkbox"></i><span>使用优惠券</span></label>--}}
                    {{--<label><input type="checkbox" hidden/><i class="icon icon-checkbox"></i><span>使用账户余额</span></label>--}}
                {{--</div>--}}
            </div>
            {{--@if($bank!==0)--}}
            {{--<!--情况1：已绑定银行卡-->--}}
            <div class="payment-way-bankcard  situation1 radiobox clearfix" id="bank_pay" style="display: none">
                <div>请选择银行卡</div><br/>
                <select id="select_bank" style="width: 100px;height: 30px;color:#888888 ; border: 0.1px solid #D0D0D0;"></select>
                <input type="text" id="bank_number" name="bank_number" onblur="get_bank_info()" style="width: 450px">
                <div  id="bank_hidden"></div>
            </div>
                {{--<ul class="bankcard-list clearfix">--}}
                    {{--<li>--}}
                        {{--<label>--}}
                            {{--<input type="radio" name="card" hidden/>--}}
                            {{--<i class="iconfont icon-danxuan1"></i>--}}
                            {{--<div class="bankcard-img">--}}
                                {{--<img src="{{config('view_url.view_url')}}image/jianshe.png"/>--}}
                            {{--</div>--}}
                            {{--<span class="bankcard-id">***********4589</span>--}}
                        {{--</label>--}}
                    {{--</li>--}}
                    {{--<li>--}}
                        {{--<label>--}}
                            {{--<input type="radio" name="card" hidden/>--}}
                            {{--<i class="iconfont icon-danxuan1"></i>--}}
                            {{--<div class="bankcard-img">--}}
                                {{--<img src="{{config('view_url.view_url')}}image/gongshang.png"/>--}}
                            {{--</div>--}}
                            {{--<span class="bankcard-id">***********4589</span>--}}
                        {{--</label>--}}
                    {{--</li>--}}
                    {{--<li>--}}
                        {{--<label>--}}
                            {{--<input type="radio" name="card" hidden/>--}}
                            {{--<i class="iconfont icon-danxuan1"></i>--}}
                            {{--<div class="bankcard-img">--}}
                                {{--<img src="{{config('view_url.view_url')}}image/gongshang.png"/>--}}
                            {{--</div>--}}
                            {{--<span class="bankcard-id">***********4589</span>--}}
                        {{--</label>--}}
                    {{--</li>--}}
                    {{--@foreach($user_bank as $value)--}}
                        {{--<li>--}}
                            {{--<label>--}}
                                {{--<input type="radio" name="card" hidden/>--}}
                                {{--<i class="iconfont icon-danxuan1"></i>--}}
                                {{--<div class="bankcard-img">--}}
                                    {{--<img src="{{config('view_url.view_url')}}image/bank.png"/>--}}
                                {{--</div>--}}
                                {{--<span class="bankcard-name">{{$value['bank_name']}}</span>--}}
                                {{--<span class="bankcard-id">***********{{substr($value['bank_code'],-4)}}</span>--}}
                            {{--</label>--}}
                        {{--</li>--}}
                    {{--@endforeach--}}
                {{--</ul>--}}
                {{--<div class="payment-way-other fr clearfix">--}}
                    {{--<div class="btn-addcard">添加其他银行卡</div>--}}
                    {{--<div>--}}
                        {{--<label>--}}
                            {{--<input type="checkbox" hidden/>--}}
                            {{--<i class="icon icon-checkbox"></i>--}}
                            {{--<span>使用优惠券</span>--}}
                        {{--</label>--}}
                        {{--<span class="tips">当前无可用优惠券</span>--}}
                    {{--</div>--}}
                    {{--<div>--}}
                        {{--<label>--}}
                            {{--<input type="checkbox" hidden/>--}}
                            {{--<i class="icon icon-checkbox"></i>--}}
                            {{--<span>使用账户余额</span>--}}
                        {{--</label>--}}
                        {{--<span class="tips">当前账户可用余额为<i class="f18164">0</i>元</span>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
            {{--@else--}}
            {{--<!--情况2：暂无绑定银行卡-->--}}
            {{--<div class="payment-way-bankcard  situation2 clearfix">--}}
                {{--<div class="payment-way-without">--}}
                    {{--<div class="without-img">--}}
                        {{--<img src="{{config('view_url.view_url')}}image/nodata.png" alt="" />--}}
                    {{--</div>--}}
                    {{--<p class="without-text">您暂时还没有银行卡</p>--}}
                    {{--<div class="btn-addcard">添加银行卡</div>--}}
                {{--</div>--}}
                {{--<div class="payment-way-other fr clearfix">--}}
                    {{--<div>--}}
                        {{--<label>--}}
                            {{--<input type="checkbox" hidden/>--}}
                            {{--<i class="icon icon-checkbox"></i>--}}
                            {{--<span>使用优惠券</span>--}}
                        {{--</label>--}}
                        {{--<span class="tips">当前无可用优惠券</span>--}}
                    {{--</div>--}}
                    {{--<div>--}}
                        {{--<label>--}}
                            {{--<input type="checkbox" hidden/>--}}
                            {{--<i class="icon icon-checkbox"></i>--}}
                            {{--<span>使用账户余额</span>--}}
                        {{--</label>--}}
                        {{--<span class="tips">当前账户可用余额为<i class="f18164">0</i>元</span>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
            {{--@endif--}}
            <!--情况3：未登录绑定银行卡-->
            {{--<div class="payment-way-bankcard situation3">--}}
                {{--<div class="payment-way-binding">--}}
                    {{--<div class="select select-bankcard">--}}
                        {{--<span>选择银行卡</span>--}}
                        {{--<ul class="select-dropdown">--}}
                            {{--<li>中国建设银行</li>--}}
                            {{--<li>中国工商银行</li>--}}
                        {{--</ul>--}}
                    {{--</div>--}}
                    {{--<input type="text" placeholder="银行卡持卡人须为投保人" />--}}
                {{--</div>--}}
            {{--</div>--}}
        </div>
        <div class="payment-compute">
            <div class="fr clearfix">
                <div class="fl"><span class="payment-compute-name">合计：</span><span class="payment-compute-price">{{$order->premium}}</span><span class="payment-compute-unit">元</span></div>
                <button type="button" class="fl btn" id="gopay" onclick="do_bank()">去支付</button>
            </div>
        </div>
    </div>
</form>
</div>
<!--添加银行卡-->
{{--<div class="popup popup-addcard">--}}
    {{--<div class="popup-bg"></div>--}}
    {{--<form action="{{url('product/save_bank')}}" method="post" id="form" onsubmit="return checkBankInfo()">--}}
        {{--{{ csrf_field() }}--}}
        {{--<input type="hidden" name="user_name" value="{{$_COOKIE['user_name']}}">--}}
        {{--<input type="hidden" name="user_id" value="{{$_COOKIE['user_id']}}">--}}
    {{--<div class="popup-wrapper">--}}
        {{--<div class="popup-title"><span>添加银行卡</span></div>--}}
        {{--<div class="popup-content">--}}
            {{--<li>--}}
                {{--<span class="name">持卡人</span>--}}
                {{--<span>{{$_COOKIE['user_name']}}<i class="cl333">(持卡人必须为投保人本人)</i></span>--}}
            {{--</li>--}}
            {{--<li>--}}
                {{--<span class="name">银行</span>--}}
                {{--<div class="select">--}}
                    {{--<span>选择银行卡</span>--}}
                    {{--<ul class="select-dropdown">--}}
                        {{--@foreach($banks as $k=>$v)--}}
                        {{--<li>--}}
                            {{--<input type="hidden" name="number[]" value="{{$v->number}}">--}}
                            {{--<input type="hidden" name="code[]" value="{{$v->code}}">--}}
                            {{--<input type="hidden" name="bank_name[]" value="{{$v->name}}">--}}
                            {{--{{$v->name}}--}}
                        {{--</li>--}}
                        {{--@endforeach--}}
                    {{--</ul>--}}
                {{--</div>--}}
                {{--<span id="check_bank"></span>--}}
            {{--</li>--}}
            {{--<li>--}}
                {{--<span class="name">卡号</span>--}}
                {{--<input type="text" placeholder="请输入银行卡号" name="bank_code" onblur="checkBankInfo()"/>--}}
            {{--</li>--}}
            {{--<li class="popup-content-code">--}}
                {{--<span class="name">预留手机号</span>--}}
                {{--<input type="text" placeholder="请输入手机号" maxlength="11" name="bank_phone" style="width: 160px" onblur="checkBankInfo()"/>--}}
                {{--<button class="btn btn-f18164">发送验证码</button>--}}
            {{--</li>--}}
            {{--<li>--}}
                {{--<span class="name">验证码</span>--}}
                {{--<input type="text" placeholder="请输入验证码"  name="bank_check_code" style="width: 160px" onblur="checkBankInfo()"/>--}}
            {{--</li>--}}
        {{--</div>--}}
        {{--<div class="popup-footer">--}}
            {{--<button class="btn-small btn-confirm">确定</button>--}}
            {{--<button class="btn-small btn-cancel">取消</button>--}}
        {{--</div>--}}
    {{--</div>--}}
{{--</form>--}}
{{--</div>--}}
<script src="{{config('view_url.view_url')}}js/payment.js"></script>
<script>
  function get_pay_way(pay_way) {
      if(pay_way!=='cardPay'){
          $('#gopay').css({'background-color':'#888888','border':'1px solid #888888'});
          Mask.loding('正在支付,请稍等!');
      }
      var token = $("input[name=_token]").val();
//      var pay_way = $("input[name=way]").val();
//      var pay_way = 'wechatPay';
      var private_p_code = $("input[name=private_p_code]").val();
      var union_order_code = $("input[name=union_order_code]").val();
      $.post('/ins/get_pay_way_info',
          {"_token": token, 'pay_way': pay_way, 'union_order_code': union_order_code, 'private_p_code': private_p_code},
          function (data) {
              if (data.status == 200) {
                  var order_code = data.content.order_code;
                  var pay_way_data = data.content.pay_way_data;
                  if (typeof pay_way_data.banks !== 'undefined') {
                      var banks = pay_way_data.banks;
                      window.banks = banks;
                      $('#bank_pay').css('display', 'block');
                        for (var i in banks) {
                          $('#select_bank').append('<option value="' + banks[i].uuid + '-' + banks[i].code + '">' + banks[i].name + '</option>');
                      }
                  } else if (typeof pay_way_data.url !== 'undefined') {
                      var url = pay_way_data.url;
                      if(pay_way!=='wechatPay'){
                          window.open(url, 'newwindow', '');
                          setInterval("get_pay_res()",2000);
                      }else{
                          Mask.img(url);
                          setInterval("get_pay_res()",2000);
                      }
                  }
              } else {
                  alert(data.content);
              }
          }
      );
  }
function get_bank_info() {
   var bank_info = $('#select_bank option:selected') .val();
   var bank_infos = bank_info.split("-");
    $('#bank_hidden').html('<input type="hidden" name="bank_uuid" value="'+bank_infos[0]+'" ><input type="hidden" name="bank_code" value="'+bank_infos[1]+'" >');
}
//    function checkBankInfo() {
//        var o = {};
//        var a = $(form).serializeArray();
//        $.each(a, function () {
//            if (o[this.name] !== undefined) {
//                if (!o[this.name].push) {
//                    o[this.name] = [o[this.name]];
//                }
//                o[this.name].push(this.value || '');
//            } else {
//                o[this.name] = this.value || '';
//            }
//        });
//        if(o['bank_code']==''||o['bank_code']==null){
//            $('#check_bank').html('<font color="red">'+'请填写银行卡号'+'</font>');
//            return false;
//        }else if(o['bank_code'].length < 16){
//            $('#check_bank').html('<font color="red">'+'银行卡号不合规范'+'</font>');
//            return false;
//        }else if(o['bank_phone']==''||o['bank_phone']==null){
//            $('#check_bank').html('<font color="red">'+'请填写银行预留手机'+'</font>');
//            return false;
//        }else if(o['bank_phone'].length !== 11){
//            $('#check_bank').html('<font color="red">'+'手机号不合规范'+'</font>');
//            return false;
//        }else if(o['bank_check_code']==''||o['bank_check_code']==null){
//            $('#check_bank').html('<font color="red">'+'请输入验证码'+'</font>');
//            return false;
//        }else{
//            $('#check_bank').html('<font color="red">'+''+'</font>');
//            return true;
//        }
//    }
        var union_order_code = "{{$union_order_code}}";
        var token = $("input[name=_token]").val();
        function get_pay_res(){
            $.ajax({
                type: "post",
                dataType: "json",
                async: true,
                url: "/ins/get_pay_res",
                data: {union_order_code:union_order_code},
                headers: {
                    'X-CSRF-TOKEN':token
                },
                success: function (data) {
                    if(data.status=="200"){
                        window.location.href="/product/order_pay_success";
                    }else if(data.status=="500"){
//                        alert('支付失败');
//                        window.location = location;
                    }
                }
            });
        }
        function do_bank() {
            var bank_number = $('#bank_number').val();
            if(!bank_number||bank_number.length < 16){
                Mask.alert("请选择支付方式");
//                Mask.alert("请正确输入银行卡号11");
                return false;
            }else{
                $(form).submit();
            }
            return false;
        }
</script>
@stop