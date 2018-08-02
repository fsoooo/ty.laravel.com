<div>所有功能</div>
<ul>
    <li <?php if($option_type == 'information'){?> class="active" <?php }?>   ><span><a href="{{url('/information/guest_info')}}">企业信息</a></span></li>
    <li <?php if($option_type == 'safety'){?> class="active" <?php }?>><span><a href="{{url('/information/home_page')}}">账户安全</a></span></li>
</ul>
