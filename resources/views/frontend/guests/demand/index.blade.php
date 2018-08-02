@extends('frontend.guests.layout.bases')
@section('content')
    <meta name="_token" content="{{ csrf_token() }}"/>
    {{--<link rel="stylesheet" href="{{ URL::asset('/org/uploadify/uploadify.css') }}">--}}
    <style>
        tr,td{
            text-align: center;
        }
    </style>
    <div id="content-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <ol class="breadcrumb">
                            <li><a href="#">前台</a></li>
                            <li class="active"><span>需求申请</span></li>
                        </ol>
                        @include('frontend.guests.layout.alert_info')
                        <h1>需求申请</h1>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#">需求申请</a></li>
                        </ul>
                        <div class="main-box clearfix">
                            <header class="main-box-header clearfix">
                                <h2></h2>
                            </header>
                            <div class="main-box-body clearfix">
                                <div class="table-responsive">
                                    <form action="{{ url('/liability_demand/add_demand_submit') }}" method="post" id="form" >
                                        {{ csrf_field() }}
                                        <table class="table table-hover" style="clear: both">
                                            <tr>
                                                <td width="15%">选择责任</td>
                                                <td>
                                                      <select name="clause_id" id="clause-list" class="form-control">
                                                        <option value="0">请选择责任</option>
                                                        @if(!$clause_list == 0)
                                                            @foreach($clause_list as $value)
                                                                <option value="{{ $value->id }}">{{ $value->name }}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </td>
                                            </tr>
                                        </table>
                                        <table id="demand-block" class="table table-hover" style="clear: both">
                                        </table>
                                    </form>
                                    <tr>
                                        <td colspan="2" style="text-align: center;">
                                            <input type="button" id="button" value="提交">
                                        </td>
                                    </tr>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <footer id="footer-bar" class="row">
            <p id="footer-copyright" class="col-xs-12">
                &copy; 2014 <a href="http://www.adbee.sk/" target="_blank">Adbee digital</a>. Powered by Centaurus Theme.
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
                if(clause_val != 0){
                    $.ajax({//通过责任id查找所有的参数
                        type: "post",
                        dataType: "json",
                        async: true,
                        url: "/liability_demand/get_traiff",
                        data: 'clause_id='+clause_val,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                        },
                        success: function(data){
                            var status = data['status'];
                            var content = data['data'];
                            var left_td = '';

                            if(status == 200)
                            {
                                $.each(content,function(key,item){
                                    left_td += '<tr><td width="15%">'+item+'</td></td><td><input type="text" class="form-control" name="'+key+'"></td></tr>'
                                });
                                left_td +=' <tr><td>需求描述</td><td><textarea name="demand_describe" id=""  rows="10" class="form-control" style="resize: none"></textarea></tr>'
                                traiff.html(left_td);
                                demand_block.html(left_td);
                            }else{
                                alert(content);
                                location.reload();
                            }
                        },error: function () {
                            alert('查询失败');
                            locatin.reload();
                        }
                    });
                    btn.click(function()
                    {
                        form.submit();
                    })
                }else {
                    location.reload();
                }
            })
        })
    </script>

@stop