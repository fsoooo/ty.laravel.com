<div>所有功能</div>
<ul>
    <li <?php if($option_type == 'order'){?> class="active" <?php }?>   ><span><a href="{{url('/order/index/all')}}">订单管理</a></span></li>
    <li <?php if($option_type == 'guarantee'){?> class="active" <?php }?>><span><a href="{{url('/guarantee/index/all')}}">保单管理</a></span></li>
</ul>