@extends('backend_v2.layout.base')
@section('title')@parent产品管理 @stop
@section('head-more')
	<link rel="stylesheet" href="{{asset('r_backend/v2/css/product.css')}}" />
@stop
@section('top_menu')
	@include('backend_v2.product.product_top')
@stop
@section('main')
	@php
		$sale_active = preg_match("/keyword=sale/",Request::getRequestUri()) ? "active" : '';
		$grade_active = preg_match("/keyword=grade/",Request::getRequestUri()) ? "active" : '';
	@endphp
		<div class="main-wrapper" >
			<div class="row" style="display: none">
				<div class="section">
					 <div class="col-xs-6">
					 	<a href="/backend/product/product_rank_list?search_type=rank_by_sale&keyword=sale" class="section-item @if($sale_active==""&&$grade_active=="") active @endif {{$sale_active}}">
					 		<h4 class="title">销量排行</h4>
					 	</a>
				    </div>
				    <div class="col-xs-6">
				    	<a href="/backend/product/product_rank_list?search_type=rank_by_grade&keyword=grade" class="section-item {{$grade_active}}">
				    		<h4 class="title">评分排行</h4>
				    	</a>
				    </div>
				</div>
			</div>
			@include('backend_v2.product.product_select')
			<div class="row">
			</div>
			<div class="row">
				<div class="ui-table">
					<div class="ui-table-header radius">
						<span class="col-md-1">排名</span>
						<span class="col-md-2">产品名称</span>
						<span class="col-md-1">产品分类</span>
						<span class="col-md-2">所属公司</span>
						<span class="col-md-2">产品/方案佣金</span>
						<span class="col-md-1">保费</span>
						<span class="col-md-1">销量</span>
						{{--<span class="col-md-1">评分</span>--}}
						<span class="col-md-1">佣金</span>
						<span class="col-md-1 col-one">操作</span>
					</div>
					<div class="ui-table-body">
						<ul class="rank-wrapper">
							@if(count($res)==0)
								<li class="ui-table-tr">
									<div class="col-md-1"><span class="label-rank">0</span></div>
									<div class="col-md-2 color-default">暂无产品数据...</div>
								</li>
							@else
								@foreach($product_sales_res as $key=> $v)
									@foreach($res as $value)
										@if(explode('.',$v)[1]==$value['ty_product_id'])
											<li class="ui-table-tr">
												<div class="col-md-1"><span class="label-rank">{{$key+1}}</span></div>
												<div class="col-md-2 color-default">{{$value['product_name']}}</div>
												<div class="col-md-1">{{json_decode($value['json'],true)['category']['name']}}</div>
												<div class="col-md-2">{{$value['company_name']}}</div>
												<div class="col-md-2">{{json_decode($value['json'],true)['base_stages_way']}}<i class="percent">({{json_decode($value['json'],true)['base_ratio']}}%)</i></div>
												<div class="col-md-1">{{json_decode($value['json'],true)['base_price']/100}}</div>
												<div class="col-md-1">{{explode('.',$v)[0]}}</div>
												{{--<div class="col-md-1">4.5/n</div>--}}
												@if(empty($value->market_ditch_relation))
													<div class="col-md-1">@if(isset( $value->market_ditch_relation[0]['rate']))￥{{$value['base_price']/100 * $value->market_ditch_relation[0]['rate']/100}}@else -- @endif</div>
												@else
													<div class="col-md-1"> -- </div>
												@endif
													<div class="col-md-1 text-right">
													<a class="btn btn-primary" href="{{url('/backend/product/product_details_on/'.$value['id'])}}">查看详情</a>
												</div>
											</li>
										@endif
									@endforeach
								@endforeach
							@endif
						</ul>
					</div>
					<div class="row text-center">
						{{$res->links()}}
					</div>
				</div>
			</div>
		</div>
		<script src="{{asset('r_backend/v2/js/lib/jquery-1.11.3.min.js')}}"></script>
		<script src="{{asset('r_backend/v2/js/common_backend.js')}}"></script>
		<script src="{{asset('r_backend/v2/js/lib/bootstrap-datetimepicker.min.js')}}"></script>
		<script src="{{asset('r_backend/v2/js/lib/bootstrap-datetimepicker.zh-CN.js')}}"></script>
		<script src="{{asset('r_backend/v2/js/lib/bootstrap.min.js')}}"></script>
	<script>
//        $('#ins_main_type').on('click',function () {
//            var ins_main_type = $('#ins_main_type').val();
//            if(ins_main_type=='0'){
//                location.href='/backend/product/product_rank_list';
//            }
//        });
//        $('#ins_company_type').on('click',function () {
//            var ins_company_type = $('#ins_company_type').val();
//            if(ins_company_type=='0'){
//                location.href='/backend/product/product_rank_list';
//            }
//        });
//        $('#ins_company').on('click',function () {
//            var ins_company_type = $('#ins_company').val();
//            if(ins_company_type=='0'){
//                location.href='/backend/product/product_rank_list';
//            }
//        });

        $('.refresh_close').on('click',function () {
            location.href = location;
        })
        new CheckTable('.ui-table');
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
            window.location.href = "/backend/product/product_rank_list?search_type=ins_up&keyword="+$('#date').val();
        });
        $('#ins_company_type').on('change',function () {
            window.location.href = "/backend/product/product_rank_list?search_type=ins_company_type&keyword="+$('#ins_company_type').val();
        });
        $('#ins_company').on('change',function () {
            window.location.href = "/backend/product/product_rank_list?search_type=ins_company&keyword="+$('#ins_company').val();
        });
        $('#ins_main_type').on('change',function () {
            window.location.href = "/backend/product/product_rank_list?search_type=ins_main_type&keyword="+$('#ins_main_type').val();
        });
        $('#ins_other_type').on('change',function () {
            window.location.href = "/backend/product/product_rank_list?search_type=ins_other_type&keyword="+$('#ins_other_type').val();
        });
	</script>
@stop