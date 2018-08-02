{{--业管后台标签管理顶部Tab模块--}}
<?php
$user_active =  preg_match("/user_label/",Request::getRequestUri()) ? "class=active" : '';
$product_active = preg_match("/product_label/",Request::getRequestUri()) ? "class=active" : '';
$agent_active = preg_match("/agent_label/",Request::getRequestUri()) ? "class=active" : '';
?>
<div class="nav-top-wrapper fl">
	<ul>
		<li {{$user_active}}>
			<a href="/backend/label/user_label">用户标签</a>
		</li>
		<li {{$agent_active}}>
			<a href="/backend/label/agent_label">代理人标签</a>
		</li>
		<li {{$product_active}}>
			<a href="/backend/label/product_label">产品标签</a>
		</li>
	</ul>
</div>

