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
                            <li><a href="{{ url('/agent_sale/product_list') }}">产品列表</a></li>
                            <li class="active"><a href="{{ url('liability_demand/my_demand/no_deal') }}">产品详情</a></li>
                        </ol>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="{{ url('liability_demand/my_demand/no_deal') }}">产品详情</a></li>
                        </ul>
                        <div class="main-box clearfix">
                            <header class="main-box-header clearfix">
                                <h2></h2>
                            </header>
                            <div class="main-box-body clearfix">
                                <div class="table-responsive">
                                    <form action="{{ url('/liability_demand/add_demand_submit') }}" method="post" id="form" >
                                        {{ csrf_field() }}
                                        <table id="user" class="table table-hover" style="clear: both">
                                            <tbody>
                                            <tr>
                                                <td width="15%">产品名称</td>
                                                <td width="65%">
                                                    {{ $product_detail->product_name }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="15%">产品分类</td>
                                                <td width="65%">
                                                    @foreach($product_detail->product_label as $value)
                                                        {{ $value->name }}&nbsp;&nbsp;&nbsp;&nbsp;
                                                    @endforeach
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>所属公司</td>
                                                <td>
                                                    {{$product_detail->company_name}}
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </form>
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
            var clause_list = $('#clause-list');
            clause_list.change(function(){
                var clause_val = $('#clause-list option:selected').val();
                alert(clause_val);
                $.ajax({//通过责任id查找所有的参数
                    type: "post",
                    dataType: "json",
                    async: true,
                    url: "/agent/",
                    data: 'code='+code_val,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    success: function(data){
                        var status = data['status'];
                        if(status == 200){
                            var cust_id = data['data'];


                        }else {
                            form.submit();
                        }
                    },error: function () {
                        alert('添加失败');
                    }
                });
            })
        })
    </script>

@stop