
<!--页脚-->

	<div class="footer-top">
		<ul class="clearfix">
			<li class="footer-list1">
				<div class="footer-img">
					<img src="{{config('view_url.view_url')}}image/footer.png" alt="" />
				</div>
				<ul class="footer-list clearfix">
					<li id="phone">电话  13521895246</li>
					<li id="email">邮箱  open@inschos.com</li>
					<li id="address">地址  北京市东城区夕照寺中街14号</li>
				</ul>
			</li>
			<li class="footer-list2">
				<ul class="footer-list">
					<li><a href="/about" target="_blank">关于我们</a></li>
					<li><a>帮助中心</a></li>
					<li><a href="/guide" target="_blank">指引流程</a></li>
				</ul>
			</li>
		</ul>
	</div>
	<div class="footer-bottom">
		<div>
			<span id="permit">保险业务经营许可证：269633000000800</span>
			<span id="license">xxx保险经纪有限公司：9112011608300716X9 </span>
		</div>
		<div id="copyright">版权所有 ©2017xxx保险经纪有限公司</div>
	</div>
<script>
    $(function () {
        $.ajax({
            url: '/setting?name=phone',
        }).done(function(data) {
            if(data != ''){
                document.getElementById("phone").innerHTML='电话  '+data;
            }
        });
        $.ajax({
            url: '/setting?name=email',
        }).done(function(data) {
            if(data != ''){
                document.getElementById("email").innerHTML='邮箱  '+data;
            }
        });
        $.ajax({
            url: '/setting?name=address',
        }).done(function(data) {
            if(data != ''){
                document.getElementById("address").innerHTML='地址  '+data;
            }
        });
        $.ajax({
            url: '/setting?name=permit',
        }).done(function(data) {
            if(data != ''){
                document.getElementById("permit").innerHTML='保险业务经营许可证：'+data;
            }
        });
        $.ajax({
            url: '/setting?name=license',
        }).done(function(data) {
            if(data != ''){
                document.getElementById("license").innerHTML=data;
            }
        });
        $.ajax({
            url: '/setting?name=copyright',
        }).done(function(data) {
            if(data != ''){
                document.getElementById("copyright").innerHTML='版权所有 ©'+data;
            }
        });
    });
</script>
