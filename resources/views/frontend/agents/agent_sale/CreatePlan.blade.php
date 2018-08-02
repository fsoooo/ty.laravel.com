@extends('frontend.agents.layout.agent_bases')
@section('content')
    <meta name="_token" content="{{ csrf_token() }}"/>

    <div id="content-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <ol class="breadcrumb">
                            <li><a href="/agent/">主页</a></li>
                            <li>销售管理</li>
                            <li><a href="{{ url('/agent_sale/plan') }}">计划书管理</a></li>
                            <li class="active"><a href="{{ url('/agent_sale/plan') }}">计划书列表</a></li>
                        </ol>
                        @include('frontend.agents.layout.alert_info')

                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="{{ url('/agent_sale/plan') }}">计划书列表</a></li>
                        </ul>
                        <div class="main-box clearfix">
                            <header class="main-box-header clearfix">
                            </header>
                            <div class="main-box-body clearfix">
                                <div class="table-responsive">
                                    <form action="{{ url('/liability_demand/add_demand_submit') }}" method="post" id="form" >
                                        {{ csrf_field() }}
                                            <table id="user" class="table table-hover" style="clear: both">
                                            <tbody>
                                            <tr>
                                                <th>计划书名称</th>
                                                <th >关联产品名称</th>
                                                <th >所属保险公司</th>
                                                <th>网址</th>
                                                <th >创建时间</th>
                                                {{--<th >操作</th>--}}
                                            </tr>
                                            </tbody>
                                                @if($count == 0)
                                                    <tr>
                                                        <td colspan="6" style="text-align: center;">暂无计划书</td>
                                                    </tr>
                                                @else
                                                    @foreach($plan_list as $value)
                                                        <tr>
                                                            <td>{{$value->plan_name}}</td>
                                                            <td>{{$value->product->product_name}}</td>
                                                            <td>{{$value->product->company_name}}</td>
                                                            <td>{{ $value->url }}</td>
                                                            <td>{{$value->created_at }}</td>
                                                            <td></td>
                                                        </tr>
                                                    @endforeach
                                                @endif

                                        </table>
                                    </form>

                                    <script>
                                        function getData(page){
                                            window.location.href =  '/agent_sale/plan?page='+page;
//
                                        }
                                    </script>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <footer id="footer-bar" class="row">
            <p id="footer-copyright" class="col-xs-12">
                &copy; 2014 <a hr ef="http://www.adbee.sk/" target="_blank">Adbee digital</a>. Powered by Centaurus Theme.
            </p>
        </footer>
    </div>

    <script type="text/javascript" src="/js/jquery-3.1.1.min.js"></script>
    <scpitit src="{{ URL::asset('/org/uploadify/jquery.uploadify.min.js') }}"></scpitit>
    <script>
        $(function(){
            var traiff = $('.traiff');
            var demand_block = $('#demand-block');
            var clause_list = $('#clause-list');
            var btn = $('#button');
            var form = $('#form');
            clause_list.change(function(){
                var clause_val = $('#clause-list option:selected').val();
                $.ajax({//通过责任id查找所有的参数
                    type: "post",
                    dataType: "json",
                    async: true,
                    url: "/agent_sale/get_",
                    data: 'clause_id='+clause_val,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    success: function(data){
                        var len = data.length;
                        var content = data[0];
                        var left_td = '';
                        if(len){
                            $.each(data[0],function(key,item){
                                console.log(key);
                                left_td += '<tr><td width="15%">'+key+'</td></td><td><input type="text" class="form-control" name="'+key+'"></td></tr>'
                            })
                            left_td +=' <tr><td>需求描述</td><td><textarea name="demand_describe" id=""  rows="10" class="form-control" style="resize: none"></textarea></tr>'
                            traiff.html(left_td);
                        }
                        demand_block.html(left_td);

                    },error: function () {
//                        alert('添加失败');
                        console.log('sdf');
                    }
                });
                btn.click(function()
                {
                    form.submit();
                })
            })
        })
    </script>

@stop