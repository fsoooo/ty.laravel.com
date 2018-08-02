@extends('backend.layout.base')
@section('content')
    <meta name="_token" content="{{ csrf_token() }}"/>
    <div id="content-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <ol class="breadcrumb">
                            <li><a href="{{ url('/backend') }}">主页</a></li>
                            <li><span>公司认证</span></li>
                        </ol>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="main-box clearfix" style="min-height: 1100px;">
                            <div class="tabs-wrapper tabs-no-header">
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="{{url('backend/authentication/index/untreated')}}">公司认证列表</a></li>
                                <li><a href="{{url('backend/authentication/approvePerson')}}">个人认证</a></li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane fade in active" id="tab-accounts">
                                    @include('backend.layout.alert_info')
                                    <div class="panel-group accordion" id="account">
                                        <div class="panel panel-default">
                                    <table id="user" class="table table-hover" style="clear: both">
                                        <thead>
                                        <tr>
                                            <th style="text-align: center">公司名称</th>
											<th style="text-align: center">三合一码</th>
											<th style="text-align: center">法人姓名</th>
											<th style="text-align: center">营业执照</th>
											<th style="text-align: center">认证状态</th>
											@if($handle == 1)
												<th style="text-align: center">操作</th>
											@endif
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if($count == 0)
                                            <tr>
                                                <td colspan="7" style="text-align: center;">暂无符合要求的客户</td>
                                            </tr>
                                        @else
                                            @foreach($res as $value)
                                                <tr>
													<td style="text-align: center">{{ $value->name }}</td>
													<td style="text-align: center">{{ $value->code }}</td>
													<td style="text-align: center">{{ $value->boss }}</td>
													{{--{{dd($value->license_img)}}--}}
													<td style="text-align: center"><img src="{{url($value->license_img)}}" alt="" style="width: 200px"></td>
                                                    @if($value->status == 1)
														<td style="text-align: center">未处理</td>
													@elseif($value->status == 2)
														<td style="text-align: center">认证通过</td>
													@else
														<td style="text-align: center">认证未通过</td>
													@endif
													@if($handle == 1)
														<td style="text-align: center"><a href="{{url('backend/authentication/deal/'.$value->id)}}"><button type="button" class="btn btn-success">处理</button></a></td>
													@endif
                                                </tr>
                                            @endforeach
                                        @endif
                                        </tbody>
                                    </table>
                                            {{--{{ $list->links() }}--}}
                                </div>
                            </div>
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

        <script src="/js/jquery-3.1.1.min.js"></script>
        <script>
            var distribute_btn = $('.distribute-btn');
            distribute_btn.click(function(){
                var code = $(this).attr('cust');
                var cust_id = $(this).attr('cust_id');
                $.ajax({
                    type: "post",
                    dataType: "json",
                    async: true,
                    //修改的地址，
                    url: "/backend/relation/is_distribution_ajax",
                    data: 'code='+code,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    success: function(data){
                        var status = data['status'];
                        if(status == 200){
                            if(confirm("该客户已经被分配,是否重新分配")){
                                location.href = '/backend/relation/distribute/free/'+cust_id;
                            }
                        }else {
                            location.href = '/backend/relation/distribute/free/'+cust_id;
                        }
                    },error: function () {
                        alert("添加失败");
                    }
                });
            })



            //删除客户
            var del_cust = $('.del-cust');
            del_cust.each(function (i,item) {
                $(item).click(function(){
                    var del_name = $(item).attr('name');
                    var del_cust_id = $(item).attr('id');
                    if(confirm('确定要删除客户 '+del_name+' 吗?')){
                        $.ajax({
                            type: "post",
                            dataType: "json",
                            async: true,
                            //修改的地址，
                            url: "/backend/relation/del_cust",
                            data: 'cust_id='+del_cust_id,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                            },
                            success: function(data){
                                var status = data['status'];
                                if(status == 200){
                                    alert('删除成功');
                                    location.reload();
                                }else {
                                    alert('删除失败');
                                }
                            },error: function () {
                                alert("删除失败");
                            }
                        });
                    }
                })
            })
        </script>

@stop