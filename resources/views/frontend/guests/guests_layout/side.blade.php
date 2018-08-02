		{{--<!--侧边栏-->--}}
		{{--<div class="sidebar sidebar-top">--}}
			{{--<ul>--}}
				{{--<li>--}}
					{{--<div class="sidebar-text">在线客服</div>--}}
					{{--<i class="icon icon-main-talker"></i>--}}
				{{--</li>--}}
				{{--<li>--}}
					{{--<div class="sidebar-text">站内信</div>--}}
					{{--<i class="icon icon-main-mail"></i>--}}
				{{--</li>--}}
				{{--<li class="sidebar-top-shoppingcart"><i class="iconfont icon-gouwuche"></i><span>购物车</span></li>--}}
			{{--</ul>--}}
		{{--</div>--}}
		{{--<div class="sidebar index-sidebar">--}}
			{{--<ul>--}}
				{{--<li class="active">--}}
					{{--<div class="sidebar-text sidebar-img">--}}
						{{--<div class="code-img">--}}
							{{--<img src="{{config('view_url.view_url')}}image/微信图片_20170803113628.png" alt="" />--}}
						{{--</div>--}}
						{{--<div>扫码下载手机端APP</div>--}}
						{{--<div>实时跟踪保单信息</div>--}}
					{{--</div>--}}
					{{--<i class="icon icon-code"></i>--}}
				{{--</li>--}}
				{{--<li class="active">--}}
					{{--<div class="sidebar-text">意见反馈</div>--}}
					{{--<i class="icon icon-comment"></i>--}}
				{{--</li>--}}
				{{--<li class="active btn-returntop">--}}
					{{--<div class="sidebar-text">返回顶部</div>--}}
					{{--<i class="icon icon-top"></i>--}}
				{{--</li>--}}
			{{--</ul>--}}
		{{--</div>--}}
		{{--<!--侧边栏-->--}}
		<div class="sidebar index-sidebar" id="goTop">
			<ul>
				<li class="active btn-returntop">
				    <i class="iconfont icon-zhiding"></i>
				</li>
			</ul>
		</div>
		<script type="text/javascript">
            $(window).scroll(function(){
                var sc=$(window).scrollTop();
                var rwidth=$(window).width()+$(document).scrollLeft();
                var rheight=$(window).height()+$(document).scrollTop();
                if(sc>0){
                    $("#goTop").css("display","block");
                    $("#goTop").css("left",(rwidth-80)+"px");
                    $("#goTop").css("top",(rheight-120)+"px");
                }else{
                    $("#goTop").css("display","none");
                }
            });
            $("#goTop").click(function(){
                $('body,html').animate({scrollTop:0},300);
            });
		</script>