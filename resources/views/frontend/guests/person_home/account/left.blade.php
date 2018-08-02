<div>所有功能</div>
<ul>
    <li @if($option_type == 'information') class="active" @endif><a href="{{url('/information/guest_info')}}"><span>个人信息</span></a></li>
    <li @if($option_type == 'approvePerson') class="active" @endif><a href="{{url('/information/approvePerson')}}"><span>实名认证</span></a></li>
    <li @if($option_type == 'safety') class="active" @endif><a href="{{url('/information/home_page')}}"><span>账号安全</span></a></li>
    {{--<li><a href="safety.html"><span>账户安全</span></a></li>--}}
    {{--<li><a href="binding.html"><span>账号绑定</span></a></li>--}}
    {{--<li><a href="address.html"><span>常用地址</span></a></li>--}}
    {{--<li><a href="contact.html"><span>常用联系人</span></a></li>--}}
    {{--<li><a href="bank.html"><span>银行卡设置</span></a></li>--}}
    {{--<li><a href="consume.html"><span>消费记录</span></a></li>--}}
</ul>