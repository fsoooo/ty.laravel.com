@extends('backend_v2.layout.base')
@section('title')@parent产品管理 @stop
@section('head-more')
	<link rel="stylesheet" href="{{asset('r_backend/v2/css/product.css')}}" />
@stop

@section('top_menu')
	@include('backend_v2.product.product_top')
	<form action="{{url('/backend/product/product_list')}}" method="get">
	<div class="search-wrapper fr">
		<select class="form-control"  name="search_type">
			<option  value="ins_name" @if(isset($request['search_type']) && $request['search_type'] == 'ins_name') selected @endif>产品名称</option>
			<option  value="ins_up" @if(isset($request['search_type']) && $request['search_type'] == 'ins_up') selected @endif>上架时间</option>
			<option  value="ins_company" @if(isset($request['search_type']) && $request['search_type'] == 'ins_company') selected @endif>所属公司</option>
			<option  value="ins_type" @if(isset($request['search_type']) && $request['search_type'] == 'ins_type') selected @endif>产品分类</option>
		</select>
		@if(isset($request['keyword']))
			<input type="text" name="keyword" value="{{$request['keyword']}}" />
		@else
			<input type="text" name="keyword" >
		@endif
		<button class="btn btn-primary"><i class="iconfont icon-sousuo"></i></button>
	</div>
	</form>
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
						<span class="col-md-2">所属公司</span>
						<span class="col-md-1">方案佣金(基础)</span>
						<span class="col-md-1">产品/方案销量(件)</span>
						<span class="col-md-1">件均保费</span>
						<span class="col-md-1">基础保费</span>
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
										<div class="col-md-2">{{$value['company_name']}}</div>
										<div class="col-md-1">{{json_decode($value['json'],true)['base_stages_way']}}<i class="percent">({{json_decode($value['json'],true)['base_ratio']}}%)</i></div>
										@php
 											$warranty = DB::table('warranty_rule')
														->where('ty_product_id',$value['ty_product_id'])
														->leftjoin('warranty', 'warranty_rule.warranty_id', '=', 'warranty.id')
														->select(DB::raw('SUM(com_warranty.premium) as premium'),DB::raw('count(ty_product_id) as num'))
														->get();
										@endphp
										@foreach($warranty as $val)
										<div class="col-md-1">{{$val->num}}</div>
										<div class="col-md-1">@if($val->num != 0){{ceil(($val->premium/100)/$val->num)}} @else 0 @endif</div>
										@endforeach
										<div class="col-md-1">{{json_decode($value['json'],true)['base_price']/100}}</div>
										<div class="col-md-1 text-right">
											<a class="btn btn-primary" href="{{url('/backend/product/product_details_on/'.$value['id'])}}">查看详情</a>
										</div>
									</li>
								@endforeach
							@endif
						</ul>
					</div>
				</div>
				{{--确认下架--}}
				<div class="modal fade" id="addTask" role="dialog" aria-labelledby="myModalLabel">
					<div class="modal-dialog modal-alert" role="document">
						<div class="modal-content">
							<div class="modal-header notitle">
								<button type="button" class="refresh_close" data-dismiss="modal" aria-label="Close"><i class="iconfont icon-cancel"></i></button>
							</div>
							<div class="modal-body">
								<i class="iconfont icon-warning"></i>
								<p>请确定是否要下架选中产品</p>
							</div>
							<div class="modal-footer">
								<button class="btn btn-primary" id="product_up">是</button>
								<button id="btn-no-up" class="btn btn-warning" data-dismiss="modal" aria-label="Close">否</button>
							</div>
						</div>
					</div>
				</div>
				{{--下架成功--}}
				<div class="modal fade" id="success-down" role="dialog" aria-labelledby="myModalLabel">
					<div class="modal-dialog modal-alert" role="document">
						<div class="modal-content">
							<div class="modal-header notitle">
								<button type="button" class="refresh_close" data-dismiss="modal" aria-label="Close"><i class="iconfont icon-cancel"></i></button>
							</div>
							<div class="modal-body">
								<i class="iconfont icon-duihao"></i>
								<p>下架成功</p>
							</div>
							<div class="modal-footer">
								<a href="/backend/product/product_list" class="color-primary">回到产品列表</a>
								<a href="/backend/product/product_rank_list" class="color-default">回到产品管理</a>
							</div>
						</div>
					</div>
				</div>
				{{--下架失败--}}
				<div class="modal fade" id="warning-down" role="dialog" aria-labelledby="myModalLabel">
					<div class="modal-dialog modal-alert" role="document">
						<div class="modal-content">
							<div class="modal-header notitle">
								<button type="button" class="refresh_close" data-dismiss="modal" aria-label="Close"><i class="iconfont icon-cancel"></i></button>
							</div>
							<div class="modal-body">
								<i class="iconfont icon-warning"></i>
								<p>下架失败</p>
							</div>
							<div class="modal-footer">
								<a href="/backend/product/product_list" class="color-primary">回到产品列表</a>
								<a href="/backend/product/product_rank_list" class="color-default">回到产品管理</a>
							</div>
						</div>
					</div>
				</div>
				{{--提示--}}
				<div class="modal fade" id="select-warning-down" role="dialog" aria-labelledby="myModalLabel">
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
				<div class="row text-center">
					{{$res->links()}}
				</div>
			</div>
		</div>
		<script src="{{asset('r_backend/v2/js/lib/jquery-1.11.3.min.js')}}"></script>
		<script src="{{asset('r_backend/v2/js/common_backend.js')}}"></script>
		<script src="{{asset('r_backend/v2/js/lib/bootstrap-datetimepicker.min.js')}}"></script>
		<script src="{{asset('r_backend/v2/js/lib/bootstrap-datetimepicker.zh-CN.js')}}"></script>
		<script src="{{asset('r_backend/v2/js/lib/bootstrap.min.js')}}"></script>
		<script>
            var pag = "@if(isset($_GET['page'])){{$_GET['page']}}@endif";
            $('.refresh_close').on('click',function () {
                location.href = location;
            })
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
                if(pag==undefined || pag=="" || pag==null) {
                    window.location.href = "/backend/product/product_list?search_type=ins_up&keyword=" + $('#date').val();
                }else{
                    window.location.href = "/backend/product/product_list?page="+pag+"&search_type=ins_up&keyword=" + $('#date').val();
                }
            });
            if(pag==undefined || pag=="" || pag==null) {
                $('#ins_company_type').on('change', function () {
                    window.location.href = "/backend/product/product_list?search_type=ins_company_type&keyword=" + $('#ins_company_type').val();
                });
                $('#ins_company').on('change', function () {
                    window.location.href = "/backend/product/product_list?search_type=ins_company&keyword=" + $('#ins_company').val();
                });
                $('#ins_main_type').on('change', function () {
                    window.location.href = "/backend/product/product_list?search_type=ins_main_type&keyword=" + $('#ins_main_type').val();
                });
                $('#ins_other_type').on('change', function () {
                    window.location.href = "/backend/product/product_list?search_type=ins_other_type&keyword=" + $('#ins_other_type').val();
                });
            }else{
                $('#ins_company_type').on('change', function () {
                    window.location.href = "/backend/product/product_list?page="+pag+"&search_type=ins_company_type&keyword=" + $('#ins_company_type').val();
                });
                $('#ins_company').on('change', function () {
                    window.location.href = "/backend/product/product_list?page="+pag+"&search_type=ins_company&keyword=" + $('#ins_company').val();
                });
                $('#ins_main_type').on('change', function () {
                    window.location.href = "/backend/product/product_list?page="+pag+"&search_type=ins_main_type&keyword=" + $('#ins_main_type').val();
                });
                $('#ins_other_type').on('change', function () {
                    window.location.href = "/backend/product/product_list?page="+pag+"&search_type=ins_other_type&keyword=" + $('#ins_other_type').val();
                });
			}
            //            产品下架
            $('#product_down').on('click',function() {
                var product_ids ="";
                $("input[type='checkbox']:checkbox:checked").each(function(){
                    product_ids+=$(this).val()+','
                })
                console.log(product_ids);
                if(product_ids==' '||product_ids==''){
                    $('#addTask').modal('hide');
                    $('#select-warning-down').modal('show');
                    return false;
                }
                $.ajax( {
                    type : "get",
                    url : "/backend/product/add_product_down",
                    dataType : 'json',
                    data : {id:product_ids},
                    success:function(msg){
                        if(msg.status == 0){
                            $('#addTask').modal('hide');
                            $('#success-down').modal('show');
                        }else{
                            $('#addTaskDown').modal('hide');
                            $('#warning-down').modal('show');
                        }
                    }
                });
            });
          $('#ins_main_type').on('click',function () {
			 var ins_main_type = $('#ins_main_type').val();
			 if(ins_main_type=='0'){
				 location.href='/backend/product/product_list';
			 }
          });
            $('#ins_company_type').on('click',function () {
                var ins_company_type = $('#ins_company_type').val();
                if(ins_company_type=='0'){
                    location.href='/backend/product/product_list';
                }
            });
            $('#ins_company').on('click',function () {
                var ins_company_type = $('#ins_company').val();
                if(ins_company_type=='0'){
                    location.href='/backend/product/product_list';
                }
            });


		</script>
@stop