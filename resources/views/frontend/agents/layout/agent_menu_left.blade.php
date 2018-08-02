<div id="nav-col">
    <section id="col-left" class="col-left-nano">
        <div id="col-left-inner" class="col-left-nano-content">
            <div id="user-left-box" class="clearfix hidden-sm hidden-xs">
                <img alt="" src="/r_backend/img/samples/scarlet-159.png"/>
                <div class="user-box">
                                <span class="name">
                                    {{ $_COOKIE['agent_name'] }}<br />
                                    {{--{{Auth::guard('admin')->user()->display_name}}--}}
                                </span>
                                <span class="status">
                                    <i class="fa fa-circle"></i> Online
                                </span>
                </div>
            </div>
            <div class="collapse navbar-collapse navbar-ex1-collapse" id="sidebar-nav">
                <ul class="nav nav-pills nav-stacked">
                        @include('frontend.agents.layout.agent_menu')
                </ul>
            </div>
        </div>
    </section>
</div>
