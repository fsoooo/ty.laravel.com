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
			<div class="row">
				<div class="select-wrapper radius">
						<form role="form" class="form-inline radius" style="overflow: hidden">
							<div class="form-group  col-lg-10">
								<div class="select-item">
									<label for="name">创建时间:</label>
									<div class="input-group date form_date">
										@if(isset($_GET['search_type'])&&$_GET['search_type']=='ins_up')
											<input id="date" class="form-control" name="ins_time" type="text" placeholder="{{$_GET['keyword']}}" readonly>
										@else
											<input id="date" class="form-control" name="ins_time" type="text" value="" placeholder="请选择" readonly>
										@endif
										<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
					                </div>
								</div>
								<div class="select-item">
									<label for="name">所属公司:</label>
									{{--<select class="form-control" id="ins_company_type">--}}
										{{--@if(count($categorys['company'])==0)--}}
											{{--<option>公司名称</option>--}}
										{{--@else--}}
											{{--@if(isset($_GET['search_type'])&&$_GET['search_type']=='ins_company_type')--}}
												{{--<option>{{$_GET['keyword']}}</option>--}}
												{{--@foreach($categorys['company'] as $key=>$value)--}}
													{{--@if(preg_match('/--/',$key))--}}
														{{--@if($value!=$_GET['keyword'])--}}
															{{--<option>{{preg_replace('/-/',' ',$value)}}</option>--}}
														{{--@endif--}}
													{{--@endif--}}
												{{--@endforeach--}}
											{{--@else--}}
												{{--@foreach($categorys['company'] as $key=>$value)--}}
													{{--@if(preg_match('/-/',$key))--}}
														{{--<option>{{preg_replace('/-/',' ',$value)}}</option>--}}
													{{--@endif--}}
												{{--@endforeach--}}
											{{--@endif--}}
										{{--@endif--}}
									{{--</select>--}}
									<select class="form-control"  id="ins_company">
										<option  @if(isset($_GET['search_type'])&&$_GET['search_type']=='ins_company') value="0" @endif>
											@if(isset($_GET['search_type'])&&$_GET['search_type']=='ins_company'){{$_GET['keyword']}}@else全部分类@endif
										</option>
										@if(count($companys)==0)
											<option value="0">全部分类</option>
										@else
											@if(isset($_GET['search_type'])&&$_GET['search_type']=='ins_company')
												<option>{{$_GET['keyword']}}</option>
												@foreach($companys as $key=>$value)
													@if($value!=$_GET['keyword'])
														<option>{{$value}}</option>
													@endif
												@endforeach
											@else
												@foreach($companys as $key=>$value)
													<option>{{$value}}</option>
												@endforeach
											@endif
										@endif
									</select>
								</div>
								<div class="select-item">
									<label for="name">产品分类:</label>
									@if(isset($categorys['insurance'])&&count($categorys['insurance'])>0)
										<select class="form-control" id="ins_main_type">
											<option  @if(isset($_GET['search_type'])&&$_GET['search_type']=='ins_main_type') value="0" @endif>
												@if(isset($_GET['search_type'])&&$_GET['search_type']=='ins_main_type'){{$_GET['keyword']}}@else全部分类@endif
											</option>
											@if(isset($_GET['search_type'])&&$_GET['search_type']=='ins_main_type')
												<option>{{$_GET['keyword']}}</option>
												@foreach($categorys['insurance'] as $key=>$value)
													@if(!preg_match('/-/',$key))
														@if($value!=$_GET['keyword'])
															<option>{{preg_replace('/-/',' ',$value)}}</option>
														@endif
													@elseif(!preg_match('/--/',$key))
														@if($value!=$_GET['keyword'])
															<option>
																@if(preg_match('/-/',preg_replace('/--/',' ',$value)))
																	{{preg_replace('/-/',' ',$value)}}
																@else
																	{{preg_replace('/--/',' ',$value)}}
																@endif</option>
															</option>
														@endif
													@elseif(!preg_match('/---/',$key))
														@if($value!=$_GET['keyword'])
															<option>{{preg_replace('/--/',' ',$value)}}</option>
														@endif
													@endif
												@endforeach
											@else
												@foreach($categorys['insurance'] as $key=>$value)
													@if(!preg_match('/-/',$key))
															<option>{{preg_replace('/-/',' ',$value)}}</option>
													@elseif(!preg_match('/--/',$key))
															<option>
																@if(preg_match('/-/',preg_replace('/--/',' ',$value)))
																	{{preg_replace('/-/',' ',$value)}}
																@else
																	{{preg_replace('/--/',' ',$value)}}
																@endif</option>
													@elseif(!preg_match('/---/',$key))
															<option>{{preg_replace('/--/',' ',$value)}}</option>
													@endif
												@endforeach
											@endif
										</select>
									{{--<select class="form-control" id="ins_main_type">--}}
										{{--@if(isset($_GET['search_type'])&&$_GET['search_type']=='ins_main_type')--}}
											{{--<option>{{$_GET['keyword']}}</option>--}}
											{{--@foreach($categorys['insurance'] as $key=>$value)--}}
												{{--@if(preg_match('/--/',$value)&&!preg_match('/---/',$value))--}}
													{{--@if($value!=$_GET['keyword'])--}}
														{{--<option>{{preg_replace('/-/',' ',$value)}}</option>--}}
													{{--@endif--}}
												{{--@endif--}}
											{{--@endforeach--}}
										{{--@else--}}
											{{--@foreach($categorys['insurance'] as $key=>$value)--}}
												{{--@if(preg_match('/--/',$value)&&!preg_match('/---/',$value))--}}
													{{--<option>{{preg_replace('/-/',' ',$value)}}</option>--}}
												{{--@endif--}}
											{{--@endforeach--}}
										{{--@endif--}}
									{{--</select>--}}
									{{--<select class="form-control" id="ins_main_type">--}}
										{{--@if(isset($_GET['search_type'])&&$_GET['search_type']=='ins_main_type')--}}
											{{--<option>{{$_GET['keyword']}}</option>--}}
											{{--@foreach($categorys['insurance'] as $key=>$value)--}}
												{{--@if(preg_match('/---/',$value))--}}
													{{--@if($value!=$_GET['keyword'])--}}
														{{--<option>{{preg_replace('/-/',' ',$value)}}</option>--}}
													{{--@endif--}}
												{{--@endif--}}
											{{--@endforeach--}}
										{{--@else--}}
											{{--@foreach($categorys['insurance'] as $key=>$value)--}}
												{{--@if(preg_match('/---/',$value))--}}
													{{--<option>{{preg_replace('/-/',' ',$value)}}</option>--}}
												{{--@endif--}}
											{{--@endforeach--}}
										{{--@endif--}}
									{{--</select>--}}
										@endif
								</div>
							</div>
							<div class="col-lg-2 text-right">
								<button type="button" id="all" class="btn btn-warning">选择全部</button>
								<button type="button"  class="btn btn-warning" data-toggle="modal"  id="product_sync">产品上架</button>
								{{--<button type="button"  class="btn btn-warning" data-toggle="modal" data-target="#addTask">上架产品</button>--}}
							</div>
						</form>
				</div>
			</div>
			<div class="row">
				<div class="ui-table">
					<div class="ui-table-header radius">
						<span class="col-md-1">
							<i id="selectAll" class="iconfont icon-weixuan"></i>
							全选
						</span>
						<span class="col-md-2">产品名称</span>
						<span class="col-md-2">产品分类</span>
						<span class="col-md-2">所属公司</span>
						<span class="col-md-2">方案佣金(基础)</span>
						<span class="col-md-1">基础保费</span>
						<span class="col-md-2 col-one">操作</span>
					</div>
					<div class="ui-table-body">
						<ul>
							@if(count($res)==0)
							<li class="ui-table-tr">
								<div class="col-md-1">
									<label>
										<i class="iconfont icon-weixuan"></i>
										<input hidden type="checkbox" />
									</label>
								</div>
								<div class="col-md-2 color-default">暂无产品数据...</div>
							</li>
							@else

								@foreach($res as $value)
									@if(!empty($value))
										@if(!in_array($value['id'],$product_up_id))
											<li class="ui-table-tr">
												<div class="col-md-1">
													<label>
														<i class="iconfont icon-weixuan"></i>
														<input hidden  type="checkbox"  value="{{$value['id']}}"/>
													</label>
												</div>
												<div class="col-md-2 color-default">{{$value['name']}}</div>
												<div class="col-md-2">{{$value['category']['name']}}</div>
												<div class="col-md-2">{{$value['company']['display_name']}}</div>
												<div class="col-md-2">{{$value['base_stages_way']}}<i class="percent">({{$value['base_ratio']}}%)</i></div>
												<div class="col-md-1">{{$value['base_price']/100}}</div>
												<div class="col-md-2 text-right">
													<a class="btn btn-primary" href="{{url('/backend/product/product_details_ing/'.$value['id'])}}">查看详情</a>
												</div>
											</li>
										@endif
									@endif
								@endforeach
							@endif
						</ul>
					</div>
				</div>

				<div class="modal fade" id="addTaskSync" role="dialog" aria-labelledby="myModalLabel">
					<div class="modal-dialog modal-alert" role="document">
						<div class="modal-content">
							<div class="modal-header notitle">
								<button type="button" class="refresh_close" data-dismiss="modal" aria-label="Close"><i class="iconfont icon-cancel"></i></button>
							</div>
							<div class="modal-body">
								<i class="iconfont icon-warning"></i>
								{{--<p>请确定是否要同步选中产品,再次同步产品会清除之前的数据</p>--}}
								<p>请确定是否要上架选中产品</p>
							</div>
							<div class="modal-footer">
								<button class="btn btn-primary" id="product_sync_up">是</button>
								<button id="btn-no-sync" class="btn btn-warning" data-dismiss="modal" aria-label="Close">否</button>
							</div>
						</div>
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

				<div class="modal fade" id="sync-success-up" role="dialog" aria-labelledby="myModalLabel">
					<div class="modal-dialog modal-alert" role="document">
						<div class="modal-content">
							<div class="modal-header notitle">
								<button type="button" class="refresh_close" data-dismiss="modal" aria-label="Close"><i class="iconfont icon-cancel"></i></button>
							</div>
							<div class="modal-body">
								<i class="iconfont icon-duihao"></i>
								<p>同步成功</p>
							</div>
							<div class="modal-footer">
								<a href="/backend/product/product_list" class="color-primary">回到产品列表</a>
								<a href="/backend/product/product_rank_list" class="color-default">回到产品管理</a>
							</div>
						</div>
					</div>
				</div>
				<div class="modal fade" id="sync-warning-up" role="dialog" aria-labelledby="myModalLabel">
					<div class="modal-dialog modal-alert" role="document">
						<div class="modal-content">
							<div class="modal-header notitle">
								<button type="button" class="refresh_close" data-dismiss="modal" aria-label="Close"><i class="iconfont icon-cancel"></i></button>
							</div>
							<div class="modal-body">
								<i class="iconfont icon-warning"></i>
								<p>同步失败</p>
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
				@if($totals>5&&count($res)!=0)
				@if($pages<5)
					<div class="row text-center">
						<ul class="pagination">
							<li @if($currentPage=='1')  class="disabled" @endif><a rel="next" href="{{Request::getPathinfo()}}?page={{$currentPage-1}}">«</a></li>
							@for($i=1;$i<=$pages;$i++)
								@if($i=='1')
									<li class="active" ><a href="{{Request::getPathinfo()}}?page={{$i}}">{{$i}}</a></li>
								@else
									<li id="page_{{$i}}"><a href="{{Request::getPathinfo()}}?page={{$i}}">{{$i}}</a></li>
								@endif
							@endfor
							<li @if($pages==$currentPage)  class="disabled" @endif><a rel="next" href="{{Request::getPathinfo()}}?page={{$currentPage+1}}">»</a></li>
						</ul>
					</div>
				@else
				<div class="row text-center">
					<ul class="pagination">
						<li @if($currentPage=='1')  class="disabled" @endif><a rel="next" href="{{Request::getPathinfo()}}?page={{$currentPage-1}}">«</a></li>
						@for($i=1;$i<=5;$i++)
							@if($i=='1')
								<li class="active" ><a href="{{Request::getPathinfo()}}?page={{$i}}">{{$i}}</a></li>
							@else
								<li id="page_{{$i}}"><a href="{{Request::getPathinfo()}}?page={{$i}}">{{$i}}</a></li>
							@endif
						@endfor
						{{--<li class="disabled"><a>...</a></li>--}}
{{--						<li id="{{$pages}}"><a href="{{Request::getPathinfo()}}?page={{$pages}}">{{$pages}}</a></li>--}}
						<li @if($pages==$currentPage)  class="disabled" @endif><a rel="next" href="{{Request::getPathinfo()}}?page={{$currentPage+1}}">»</a></li>
					</ul>
				</div>
				@endif
				@endif
				{{--分页--}}
			</div>
		</div>
		<script src="{{asset('r_backend/v2/js/lib/jquery-1.11.3.min.js')}}"></script>
		<script src="{{asset('r_backend/v2/js/common_backend.js')}}"></script>
		<script src="{{asset('r_backend/v2/js/lib/bootstrap-datetimepicker.min.js')}}"></script>
		<script src="{{asset('r_backend/v2/js/lib/bootstrap-datetimepicker.zh-CN.js')}}"></script>
		<script src="{{asset('r_backend/v2/js/lib/bootstrap.min.js')}}"></script>
		<script>
            $('#ins_main_type').on('click',function () {
                var ins_main_type = $('#ins_main_type').val();
                if(ins_main_type=='0'){
                    location.href='/backend/product/product_stay_on';
                }
            });
            $('#ins_company').on('click',function () {
                var ins_company_type = $('#ins_company').val();
                if(ins_company_type=='0'){
                    location.href='/backend/product/product_stay_on';
                }
            });
            setPage();
            var pages = "{{isset($_GET['page'])?$_GET['page']:$currentPage}}";
            var pag = "@if(isset($_GET['page'])){{$_GET['page']}}@endif";
            var total = "{{$pages}}";
            if(pages==total){
                $('#'+pages).addClass('active').siblings().removeClass('active');
			}
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
                    window.location.href = "/backend/product/product_stay_on?search_type=ins_up&keyword=" + $('#date').val();
                }else{
                    window.location.href = "/backend/product/product_stay_on?page="+pag+"&search_type=ins_up&keyword=" + $('#date').val();
				}
            });
            if(pag==undefined || pag=="" || pag==null){
                $('#ins_company_type').on('change',function () {
                    window.location.href = "/backend/product/product_stay_on?search_type=ins_company_type&keyword="+$('#ins_company_type').val();
                });
                $('#ins_company').on('change',function () {
                    window.location.href = "/backend/product/product_stay_on?search_type=ins_company&keyword="+$('#ins_company').val();
                });
                $('#ins_main_type').on('change',function () {
                    window.location.href = "/backend/product/product_stay_on?search_type=ins_main_type&keyword="+$('#ins_main_type').val();
                });
                $('#ins_other_type').on('change',function () {
                    window.location.href = "/backend/product/product_stay_on?search_type=ins_other_type&keyword="+$('#ins_other_type').val();
                });
			}else{
                $('#ins_company_type').on('change',function () {
                    window.location.href = "/backend/product/product_stay_on?page="+pag+"&search_type=ins_company_type&keyword="+$('#ins_company_type').val();
                });
                $('#ins_company').on('change',function () {
                    window.location.href = "/backend/product/product_stay_on?page="+pag+"&search_type=ins_company&keyword="+$('#ins_company').val();
                });
                $('#ins_main_type').on('change',function () {
                    window.location.href = "/backend/product/product_stay_on?page="+pag+"&search_type=ins_main_type&keyword="+$('#ins_main_type').val();
                });
                $('#ins_other_type').on('change',function () {
                    window.location.href = "/backend/product/product_stay_on?page="+pag+"&search_type=ins_other_type&keyword="+$('#ins_other_type').val();
                });
			}

//            产品同步
            $('#product_sync').on('click',function() {
                var product_ids = "";
                $("input[type='checkbox']:checkbox:checked").each(function () {
                    product_ids += $(this).val() + ','
                })
                console.log(product_ids);
                if (product_ids == ' ' || product_ids == '') {
                    $('#addTaskSync').modal('hide');
                    $('#select-warning-up').modal('show');
                    return false;
                } else {
                    $('#addTaskSync').modal('show');
                }
            });
            $('#product_sync_up').on('click',function() {
                var product_ids = "";
                $("input[type='checkbox']:checkbox:checked").each(function () {
                    product_ids += $(this).val() + ','
                });
                $.ajax( {
                    type : "get",
                    url : "/backend/product/add_product_lists",
                    dataType : 'json',
                    data : {ty_product_id:product_ids},
                    success:function(msg){
                        if(msg.status == 0){
                            $('#addTaskSync').modal('hide');
                            $('#up-success-up').modal('show');
                        }else{
                            $('#addTaskSync').modal('hide');
                            $('#up-warning-up').modal('show');
                        }
                    }
                });
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
                    data : {ty_product_id:product_ids},
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
