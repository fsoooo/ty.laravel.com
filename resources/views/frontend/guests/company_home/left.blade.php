<div>所有功能</div>
<ul>
    <li <?php if($option_type == 'order'){?> class="active" <?php }?> ><span><a href="{{url('/order/index/all')}}">订单管理</a></span></li>
    <li <?php if($option_type == 'guarantee'){?> class="active" <?php }?> ><span><a href="{{url('/guarantee/index/all')}}">保单管理</a></span></li>
    <li <?php if($option_type == 'staff'){?> class="active" <?php }?> ><a href="{{url('/staff/index/done')}}"><span>员工管理</span></a></li>
    <li <?php if($option_type == 'data'){?> class="active" <?php }?>><a href="/information/datas"><span>数据统计</span></a></li>
</ul>