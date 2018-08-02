<div id="nav-col">
    <section id="col-left" class="col-left-nano">
        <div id="col-left-inner" class="col-left-nano-content">
            <div id="user-left-box" class="clearfix hidden-sm hidden-xs">
                    @if(isset($_COOKIE['user_img']))
                        <img alt="" src="{{$_COOKIE['user_img']}}"/>
                    @else
                        <img alt="" src="/r_backend/img/samples/scarlet-159.png"/>
                    @endif

                <div class="user-box">
                                <span class="name">
                                    @if(isset($_COOKIE['user_name']))
                                        {{ $_COOKIE['user_name'] }}
                                    @else
                                        客户
                                    @endif

                                    <br />
                                    {{--{{Auth::guard('admin')->user()->display_name}}--}}
                                </span>
                                <span class="status">
                                    <i class="fa fa-circle"></i> Online
                                </span>
                </div>
            </div>
            <div class="collapse navbar-collapse navbar-ex1-collapse" id="sidebar-nav">
                <ul class="nav nav-pills nav-stacked">
                    @if(isset($_COOKIE['login_type']))
                    @if($_COOKIE['login_type'] == 'user')
                        @include('frontend.guests.layout.user_menu')
                    @elseif($_COOKIE['login_type'] == 'company')
                        @include('frontend.guests.layout.company_menu')
					@else
						@include('frontend.guests.layout.group_menu')
                    @endif
                    @else
                        @include('frontend.guests.layout.user_menu')
                    @endif
                </ul>
            </div>
        </div>
    </section>
</div>
