@extends('backend.layout.base')
@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('r_backend/css/libs/nifty-component.css')}}"/>
@endsection
@section('content')
<div id="content-wrapper">
    <div class="col-lg-12">
        <div class="row">
            <div class="col-lg-12">
                <ol class="breadcrumb">
                    <li><a href="{{ url('/backend') }}">主页</a></li>
                    <li><span>发票管理</span></li>
                    <li><span>发票列表</span></li>
                </ol>
            </div>
        </div>
        <div class="main-box clearfix">
            <header class="main-box-header clearfix">
                <h2 class="pull-left">发票列表</h2>
                <div class="filter-block pull-right" style="margin-right: 20px;">
                    <button class="md-trigger btn btn-primary mrg-b-lg" data-modal="modal-8">新建发票</button>
                </div>
            </header>
            @include('backend.layout.alert_info')
            <div class="main-box-body clearfix">
                <div class="table-responsive">
                    <table class="table user-list table-hover">
                        <thead>
                        <tr>
                            <th><span>收件人姓名</span></th>
                            <th class="text-center"><span>收件人电话</span></th>
                            <th class="text-center"><span>发票收件地址</span></th>
                            <th class="text-center"><span>状态</span></th>
                            <th class="text-center"><span>发票类型</span></th>
                            <th class="text-center"><span>发票抬头</span></th>
                            {{--<th>操作</th>--}}
                        </tr>
                        </thead>
                        <tbody>
						@if($count == 0)
							<tr>
								<td colspan="8" style="text-align: center;">暂无发票信息</td>
							</tr>
						@else
							@foreach($data as $k => $v)
							<tr>
								<td>
									{{$v->name}}
								</td>
								<td class="text-center">
									{{$v->phone}}
								</td>
								<td class="text-center">
									{{$v->address}}
								</td>
								@if($v->status ==1)
									<td class="text-center">
										已发
									</td>
								@else
									<td class="text-center">
										未发
									</td>
								@endif
								@if($v->type == 1)
									<td class="text-center">
										普通发票
									</td>
								@else
									<td class="text-center">
										专用发票
									</td>
								@endif
								<td class="text-center">
									{{$v->real_name}}
								</td>
							</tr>
							@endforeach
						@endif
                        </tbody>
                    </table>
                </div>
                {{--分页--}}
                <div style="text-align: center;">
                    {{ $invoice->links() }}
                </div>
            </div>
        </div>
    </div>

    <div class="md-modal md-effect-8 md-hide" id="modal-8">
        <div class="md-content">
            <div class="modal-header">
                <button class="md-close close">×</button>
                <h4 class="modal-title">发票添加</h4>
            </div>
            <div class="modal-body">
                <form role="form" id="add_ditch" action='{{url('backend/invoice/submit')}}' method="post">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="exampleInputEmail1">收件人姓名</label>
                        <input class="form-control" name="name" placeholder="收件人姓名" type="text">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">收件人电话</label>
                        <input class="form-control" name="phone" placeholder="收件人电话" type="text">
                    </div>
                    <div class="form-group">
                        <label for="exampleTextarea">收件人地址</label>
                        <input class="form-control" name="address" placeholder="收件人地址" type="text">
                    </div>
                    <div class="form-group">
                        <label for="exampleTextarea">发票抬头</label>
                        <select class="form-control" name="user_id" id="ditch_type">
							@foreach($user as $v)
                            	<option value="{{$v->id}}">{{$v->real_name}}</option>
							@endforeach
                        </select>
                    </div>
					<div class="form-group">
						<label for="exampleTextarea">发票类型</label>
						<select class="form-control" name="type" id="">
							<option value="1">普通发票</option>
							<option value="2">专用发票</option>
						</select>
					</div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="form-submit" class="btn btn-primary">确认提交</button>
            </div>
        </div>
    </div>
    <div class="md-overlay"></div>
</div>
@stop
@section('foot-js')
<script charset="utf-8" src="/r_backend/js/modernizr.custom.js"></script>
<script charset="utf-8" src="/r_backend/js/classie.js"></script>
<script charset="utf-8" src="/r_backend/js/modalEffects.js"></script>
<script>
    $(function(){
        $submit = $("#form-submit");
        $submit.click(function(){
            var $name = $("input[name=name]").val();
            var $name_role = /^[\u4e00-\u9fa5\(\)-_]{2,4}$/;
            var $name_check = $name_role.test($name);
            if(!$name_check){
                $("input[name=name]").val('');
                $("input[name=name]").parent().addClass("has-error");
            }else{
                $("input[name=name]").parent().removeClass("has-error");
            }

            var $display_name = $("input[name=phone]").val();
            var $display_role = /^[\u4e00-\u9fa5\(\)-_]{11}$/;
            var $display_check = $display_role.test($display_name);
            if(!$display_check){
                $("input[name=phone]").val('');
                $("input[name=phone]").parent().addClass("has-error");
            }else{
                $("input[name=phone]").parent().removeClass("has-error");
            }

            var $address = $("input[name=address]").val();
            var $address_role = /[0-9A-Za-z\u4e00-\u9fa5\(\)-_]{4,100}$/;
            var $address_check = $address_role.test($address);
            if(!$address_check){
                $("input[name=address]").val('');
                $("input[name=address]").parent().addClass("has-error");
            }else{
                $("input[name=address]").parent().removeClass("has-error");
            }

            if($name_check && $display_check && $address_check){
                $("#add_ditch").submit();
            }else{
                alert("请根据输入框提示填写相关内容");
            }

        })
    })
</script>
@stop

