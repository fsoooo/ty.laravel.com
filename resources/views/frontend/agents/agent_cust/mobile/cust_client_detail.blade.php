<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>详细资料</title>
    <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
    <link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/lib/mui.min.css">
    <link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/lib/iconfont.css" />
    <link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/common_agent.css" />
    <link rel="stylesheet" href="{{config('view_url.agent_mob')}}css/client.css" />
</head>
<body id="details">
<div class="main">
    <header id="header" class="mui-bar mui-bar-nav">
        <a class="iconfont icon-fanhui mui-pull-left mui-action-back"></a>
        <h1 class="mui-title">详细资料</h1>
    </header>
    <div class="mui-content">

        <!--个人页面显示-->
        <div class="header">
            <div class="header-operation">
                <a href="/agent_sale/edit_cust/{{$id}}"><i class="iconfont icon-edit"></i></a>
                <a href="/agent_sale/delete_cust/{{$id}}"><i class="iconfont icon-delete"></i></a>
            </div>
            <div class="header-content">
                <div class="header-img">
                    <img src="{{config('view_url.agent_mob')}}img/boy.png">
                </div>
                <p class="line1"><span class="header-name">{{$res['name']}}</span><i class="iconfont icon-nan"></i></p>
                <p class="line2">{{substr($res['code'],6,4)}}年{{substr($res['code'],10,2)}}月{{substr($res['code'],12,2)}}日</p>
                <p class="line3"><i class="iconfont icon-dianhua"></i>{{$res['phone']}}</p>
            </div>
        </div>
        <div class="form-wrapper">
            <ul>
                <li>
                    <span class="name">证件类型</span>
                    <input type="text" value="身份证" readonly>
                </li>
                <li>
                    <span class="name">证件号码</span>
                    <input type="text" value="{{$res['code']}}" readonly>
                </li>
                <li>
                    <span class="name">职业</span>
                    @if(isset($res['occupation']))
                    <input type="text" value="{{$res['occupation']}}" readonly>
                        @else
                        <input type="text" value="--" readonly>
                    @endif
                </li>
                <li>
                    <span class="name">电子邮箱</span>
                    <input type="text" value="{{$res['email']}}" readonly>
                </li>
                <li>
                    <span class="name">其他信息</span>
                    <input type="text" value="" readonly>
                </li>
            </ul>
        </div>

        <!--企业页面显示-->
        <!--<div class="header">
					<div class="header-operation"><i class="iconfont icon-edit"></i><i class="iconfont icon-delete"></i></div>
					<div class="header-content">
						<div class="header-img">
							<img src="img/merchant.png">
						</div>
						<p class="line1"><span class="header-name">天小眼互联网公司</span></p>
						<p class="line2">企业类型：IT</p>
						<p class="line3"><i class="iconfont icon-dianhua"></i>15694584568</p>
					</div>
				</div>
				<div class="form-wrapper">
					<ul>
						<li>
							<span class="name">工商注册号</span>
							<input type="text" value="1665454646631231231" readonly>
						</li>
						<li>
							<span class="name">企业为</span>
							<input type="text" value="三证合一企业" readonly>
						</li>
						<li>
							<span class="name">社会统一代码</span>
							<input type="text" value="1665454646631231231" readonly>
						</li>
						<li>
							<span class="name">联系人姓名</span>
							<input type="text" value="天小眼" readonly>
						</li>
						<li>
							<span class="name">联系人邮箱</span>
							<input type="text" value="154654895@qq.com" readonly>
						</li>
						<li>
							<span class="name">企业所在地址</span>
							<input type="text" value="北京市  东城区" readonly>
						</li>
						<li>
							<span class="name">企业详细地址</span>
							<input type="text" value="SK大厦" readonly>
						</li>
						<li>
							<span class="name">其他信息</span>
							<input type="text" value="" readonly>
						</li>
					</ul>
				</div>-->

        <!--团体页面显示-->
        <!--<div class="header">
					<div class="header-operation"><i class="iconfont icon-edit"></i><i class="iconfont icon-delete"></i></div>
					<div class="header-content">
						<div class="header-img">
							<img src="img/merchant.png">
						</div>
						<p class="line1"><span class="header-name">福瑞苑足球队</span></p>
						<p class="line2">龙潭湖街道办事处</p>
						<p class="line3"><i class="iconfont icon-dianhua"></i>15694584568</p>
					</div>
				</div>
				<div class="form-wrapper">
					<ul>
						<li>
							<span class="name">登记证号</span>
							<input type="text" value="1665454646631231231" readonly>
						</li>
						<li>
							<span class="name">组织类型</span>
							<input type="text" value="民办非企业单位" readonly>
						</li>
						<li>
							<span class="name">统一信用代码</span>
							<input type="text" value="1665454646631231231" readonly>
						</li>
						<li>
							<span class="name">联系人姓名</span>
							<input type="text" value="天小眼" readonly>
						</li>
						<li>
							<span class="name">联系人邮箱</span>
							<input type="text" value="154654895@qq.com" readonly>
						</li>
						<li>
							<span class="name">组织/团体地址</span>
							<input type="text" value="北京市  东城区" readonly>
						</li>
						<li>
							<span class="name">详细地址</span>
							<input type="text" value="SK大厦" readonly>
						</li>
						<li>
							<span class="name">其他信息</span>
							<input type="text" value="" readonly>
						</li>
					</ul>
				</div>-->

    </div>
</div>
<div class="mui-popover popover-call">
    <div class="popover-wrapper">
        <div class="popover-content">
            <p>天小眼</p>
            <p class="tel">156-4568-5625</p>
        </div>
        <div class="popover-footer">
            <a href="sms:156-4568-5625" class="zbtn zbtn-hollow">短信</a>
            <a href="tel:156-4568-5625" class="zbtn zbtn-default">呼叫</a>
        </div>
    </div>
</div>
<script src="{{config('view_url.agent_mob')}}js/lib/jquery-1.11.3.min.js"></script>
<script src="{{config('view_url.agent_mob')}}js/lib/mui.min.js"></script>
<script src="{{config('view_url.agent_mob')}}js/common_agent.js"></script>
<script>
    $('.line3').on('tap',function(){
        mui('.popover-call').popover('toggle');
    })
</script>
</body>
</html>
