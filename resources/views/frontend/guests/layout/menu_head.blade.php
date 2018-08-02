<meta name="_token" content="{{ csrf_token() }}"/>
<div class="container">
    <a href="/" id="logo" class="navbar-brand">
        <img src="/r_backend/img/logo.png" alt="" class="normal-logo logo-white"/>
        <img src="/r_backend/img/logo-black.png" alt="" class="normal-logo logo-black"/>
        <img src="/r_backend/img/logo-small.png" alt="" class="small-logo hidden-xs hidden-sm hidden"/>
    </a>
    <div class="clearfix">
        <button class="navbar-toggle" data-target=".navbar-ex1-collapse" data-toggle="collapse" type="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="fa fa-bars"></span>
        </button>
        <div class="nav-no-collapse navbar-left pull-left hidden-sm hidden-xs">
            <ul class="nav navbar-nav pull-left">
                <li>
                    <a class="btn" id="make-small-nav">
                        <i class="fa fa-bars"></i>
                    </a>
                </li>
            </ul>
        </div>
        <div class="nav-no-collapse pull-right" id="header-nav">
            <ul class="nav navbar-nav pull-right">
                <li class="dropdown hidden-xs">
                    <a class="btn dropdown-toggle" data-toggle="dropdown" id="message-block">
                        <i class="fa fa-envelope-o"></i>
                    </a>
                    <ul class="dropdown-menu notifications-list messages-list">
                        <li class="pointer">
                            <div class="pointer-inner">
                                <div class="arrow"></div>
                            </div>
                        </li>
                        <li class="item">
                            <a href="#" id="nav-message-url">
                                {{--<img src="/r_backend/img/samples/messages-photo-3.png" alt=""/>--}}
                                <span class="content" style="width: 100%;" id="message-nav">
                                    <span class="content-headline" id="nav-message-title">
                                            站内信...
                                    </span>
                                    <span class="content-text" id="nav-message-content">
                                        {{--Look, just because I don't be givin' no man a foot massage don't make it--}}
                                        {{--right for Marsellus to throw...--}}
                                    </span>
                                </span>
                                {{--<span class="time"><i class="fa fa-clock-o"></i>13 min.</span>--}}
                            </a>
                        </li>
                        <li class="item-footer">
                            <a href="{{ url('/message/get_unread')}}">
                                查看所有消息
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="dropdown profile-dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        @if(isset($_COOKIE['user_img']))
                            <img alt="" src="{{$_COOKIE['user_img']}}"/>
                        @else
                            <img alt="" src="/r_backend/img/samples/scarlet-159.png"/>
                        @endif
                        <span class="hidden-xs">
                            @if(isset($_COOKIE['user_name']))
                            {{ $_COOKIE['user_name'] }}
                            @endif
                        </span> <b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href=""><i class="fa fa-user"></i>Profile</a></li>
                        <li><a href="#"><i class="fa fa-cog"></i>Settings</a></li>
                        <li><a href="{{url('/logout')}}"><i class="fa fa-power-off"></i>Logout</a></li>
                    </ul>
                </li>
                <li class="hidden-xxs">
                    <a class="btn" href="{{url('/logout')}}">
                        <i class="fa fa-power-off"></i>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
<script src="/js/jquery-3.1.1.min.js"></script>
<script>
//    $(function(){
//        ajax();
//        var myMessage=$("#myMessage");
//        var message_count = $('#message_count');
//        var message_block = $('#message-block');
//        var message_nav = $('#message-nav');
//        var message_title = $('#nav-message-title');
//        var message_content = $('#nav-message-content');
//        var message_url = $('#nav-message-url');
//        function ajax(){
//            $.ajax({
//                type: "post",
//                dataType: "json",
//                async: true,
//                url: "/message/get_my_message",
//                data: "",
//                headers: {
//                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
//                },
//                success: function (data) {
//                    var status=data["status"];
//                    var data1=data["data"];
//                    if(status=="200"){
//                        console.log(data1);
//                        var message_html = '<i class="fa fa-envelope-o"></i><span class="count" id="message_count">'+data1["count"]+'</span>';
//                        message_block.html(message_html);
//                        message_title.html('发件人：'+data1['message']['send_name']);   //发件人
//                        message_content.html('标题：'+data1['message']['title']);
//                        message_url.attr('href',data1['message']['url'])
//                        myMessage.html("您有"+data1+"条新消息");
//                    }else{
//                        message_title.html('暂无新消息');   //发件人
//                        message_content.html('');
//                        message_url.attr('href','#');
//                        myMessage.html("暂时没有新消息");
//                    }
//                },error: function () {
//                    message_title.html('暂无新消息');   //发件人
//                    message_content.html('');
//                    message_url.attr('href','#');
//                    myMessage.html("暂无")
//                }
//            });
//        }
//        setInterval(ajax,10000);
//    })

</script>
