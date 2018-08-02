@extends('backend_v2.layout.base')
@section('title')@parent产品管理 @stop
@section('head-more')
	<link rel="stylesheet" href="{{asset('r_backend/v2/css/product.css')}}" />
@stop

@section('top_menu')
	@include('backend_v2.product.product_top')
@stop
@section('main')
		<div id="product" class="main-wrapper">
			@include('backend_v2.product.product_select')
			<div class="row">
				<div class="ui-table">
					<div class="ui-table-header radius">
						<span class="col-md-1">
							<i id="selectAll" class="iconfont icon-weixuan"></i>
							全选
						</span>
						<span class="col-md-1">上架时间</span>
						<span class="col-md-2">产品名称</span>
						<span class="col-md-1">产品分类</span>
						<span class="col-md-3">所属公司</span>
						<span class="col-md-1">产品/方案佣金</span>
						<span class="col-md-1">件均保费</span>
						<span class="col-md-1">保费区间</span>
						<span class="col-md-1 col-one">操作</span>
					</div>
					<div class="ui-table-body">
						<ul>
							@if(count($res)==0)
								<li class="ui-table-tr">
									<div class="col-md-1">
									</div>
									<div class="col-md-2 color-default">暂无产品数据...</div>
								</li>
							@else
								@foreach($res as $value)
									<li class="ui-table-tr">
										<div class="col-md-1">
											<label>
												<i class="iconfont icon-weixuan"></i>
												<input hidden  type="checkbox"  value="{{$value['ty_product_id']}}"/>
											</label>
										</div>
										<div class="col-md-1">{{date('Y-m-d',strtotime($value['created_at']))}}</div>
										<div class="col-md-2 color-default">{{$value['product_name']}}</div>
										<div class="col-md-1">{{json_decode($value['json'],true)['category']['name']}}</div>
										<div class="col-md-3">{{$value['company_name']}}</div>
										<div class="col-md-1">5000<i class="percent">(20%)</i></div>
										<div class="col-md-1">3000</div>
										<div class="col-md-1">20万-30万</div>
										<div class="col-md-1 text-right">
											<a class="btn btn-primary" href="{{url('/backend/product/product_sold_out_details/'.$value['id'])}}">查看详情</a>
										</div>
									</li>
								@endforeach
							@endif
						</ul>
					</div>
				</div>
				<div class="modal fade" id="addTask" role="dialog" aria-labelledby="myModalLabel">
					<div class="modal-dialog modal-alert" role="document">
						<div class="modal-content">
							<div class="modal-header notitle">
								<button type="button" class="refresh_close" data-dismiss="modal" aria-label="Close"><i class="iconfont icon-cancel"></i></button>
							</div>
							<div class="modal-body">
								<i class="iconfont icon-warning"></i>
								<p>请确定是否要上架选中产品</p>
							</div>
							<div class="modal-footer">
								<button class="btn btn-primary" id="product_up">是</button>
								<button id="btn-no-up" class="btn btn-warning" data-dismiss="modal" aria-label="Close">否</button>
							</div>
						</div>
					</div>
				</div>

				<div class="modal fade" id="up-success-up" role="dialog" aria-labelledby="myModalLabel">
					<div class="modal-dialog modal-alert" role="document">
						<div class="modal-content">
							<div class="modal-header notitle">
								<button type="button" class="refresh_close" data-dismiss="modal" aria-label="Close"><i class="iconfont icon-cancel"></i></button>
							</div>
							<div class="modal-body">
								<i class="iconfont icon-duihao"></i>
								<p>上架成功</p>
							</div>
							<div class="modal-footer">
								<a href="/backend/product/product_list" class="color-primary">回到产品列表</a>
								<a href="/backend/product/product_rank_list" class="color-default">回到产品管理</a>
							</div>
						</div>
					</div>
				</div>

				<div class="modal fade" id="up-warning-up" role="dialog" aria-labelledby="myModalLabel">
					<div class="modal-dialog modal-alert" role="document">
						<div class="modal-content">
							<div class="modal-header notitle">
								<button type="button" class="refresh_close" data-dismiss="modal" aria-label="Close"><i class="iconfont icon-cancel"></i></button>
							</div>
							<div class="modal-body">
								<i class="iconfont icon-warning"></i>
								<p>上架失败</p>
							</div>
							<div class="modal-footer">
								<a href="/backend/product/product_list" class="color-primary">回到产品列表</a>
								<a href="/backend/product/product_rank_list" class="color-default">回到产品管理</a>
							</div>
						</div>
					</div>
				</div>

				<div class="modal fade" id="select-warning-up" role="dialog" aria-labelledby="myModalLabel">
					<div class="modal-dialog modal-alert" role="document">
						<div class="modal-content">
							<div class="modal-header notitle">
								<button type="button" class="refresh_close" data-dismiss="modal" aria-label="Close"><i class="iconfont icon-cancel"></i></button>
							</div>
							<div class="modal-body">
								<i class="iconfont icon-warning"></i>
								<p>请选择您要操作的产品</p>
							</div>
							<div class="modal-footer">
								<a href="/backend/product/product_list" class="color-primary">回到产品列表</a>
								<a href="/backend/product/product_rank_list" class="color-default">回到产品管理</a>
							</div>
						</div>
					</div>
				</div>
				{{--分页--}}
				<div class="row text-center">
					{{$res->links()}}
				</div>
				{{--分页--}}
			</div>
		</div>
		<script src="{{asset('r_backend/v2/js/lib/jquery-1.11.3.min.js')}}"></script>
		<script src="{{asset('r_backend/v2/js/common_backend.js')}}"></script>
		<script src="{{asset('r_backend/v2/js/lib/bootstrap-datetimepicker.min.js')}}"></script>
		<script src="{{asset('r_backend/v2/js/lib/bootstrap-datetimepicker.zh-CN.js')}}"></script>
		<script>
            $('.refresh_close').on('click',function () {
                location.href = location;
            })
			$('.form_date').datetimepicker({
		        language:  'zh-CN',
		        format: 'yyyy-mm-dd',
		        todayBtn:  1,
				autoclose: 1,
				todayHighlight: true,
				minView: 2,
				endDate: new Date()
		    }).on('changeDate',function(){
		    	console.log('00');
		    	console.log($('#date').val());
                window.location.href = "/backend/product/product_sold_out?search_type=ins_up&keyword="+$('#date').val();
		    });
            $('#ins_company_type').on('change',function () {
                window.location.href = "/backend/product/product_sold_out?search_type=ins_company_type&keyword="+$('#ins_company_type').val();
            });
            $('#ins_company').on('change',function () {
                window.location.href = "/backend/product/product_sold_out?search_type=ins_company&keyword="+$('#ins_company').val();
            });
            $('#ins_main_type').on('change',function () {
                window.location.href = "/backend/product/product_sold_out?search_type=ins_main_type&keyword="+$('#ins_main_type').val();
            });
            $('#ins_other_type').on('change',function () {
                window.location.href = "/backend/product/product_sold_out?search_type=ins_other_type&keyword="+$('#ins_other_type').val();
            });
            new CheckTable('.ui-table');
            $('#all').click(function(){
                $('#selectAll').removeClass('icon-weixuan').addClass('icon-xuanze');
                $('.ui-table-tr .iconfont').trigger('click');
                if($('#selectAll').hasClass('icon-xuanze')){
                    $(this).text('取消选择');
                }else{
                    $(this).text('选择全部');
                }
            });
            //            产品上架
            $('#product_up').on('click',function() {
                var product_ids ="";
                $("input[type='checkbox']:checkbox:checked").each(function(){
                    product_ids+=$(this).val()+','
                })
                console.log(product_ids);
                if(product_ids==' '||product_ids==''){
                    $('#addTask').modal('hide');
                    $('#select-warning-up').modal('show');
                    return false;
                }
                $.ajax( {
                    type : "get",
                    url : "/backend/product/add_product_up",
                    dataType : 'json',
                    data : {id:product_ids},
                    success:function(msg){
                        if(msg.status == 0){
                            $('#addTask').modal('hide');
                            $('#up-success-up').modal('show');
                        }else{
                            $('#addTaskUp').modal('hide');
                            $('#up-warning-up').modal('show');
                        }
                    }
                });
            });
		</script>
@stop