@extends('backend_v2.layout.base')
@section('title')@parent 个性设置 @stop
@section('head-more')
	<link rel="stylesheet" href="{{asset('r_backend/v2/css/edit.css')}}" />
	<link rel="stylesheet" href="{{asset('r_backend/v2/css/lib/iconfont.css')}}" />
@stop
@section('main')
	@if (session('message'))
		<div class="alert alert-success">
			{{ session('message') }}
		</div>
	@endif
		<div class="main-wrapper">
			<form id="form_setting" action="{{url('/backend/setting/save')}}" method="post" enctype="multipart/form-data">
			<div class="row">
				<h3 class="title">网站LOGO</h3>
				<div class="default-div">
					<div class="logo-default" style="background-image: @if(isset($setting['logo']))url({{asset('upload/'.$setting['logo'])}});@else url({{asset('r_backend/v2/img/logo-login.png')}});@endif"></div>
					<div class="product-img">
						<p>建议图片大小不大于30kb</p>
						<div id="btn-upload" class="btn btn-warning">上传logo</div>
						<input hidden onchange="img(this,30*1024,upLoadImgC);" accept="image/*" type="file">
						<input hidden type="text"  name="logo" value="@if(isset($setting['logo'])){{$setting['logo']}}@endif">
					</div>
				</div>
				<h3 class="title">保险超市banner</h3>
				<div class="default-div">
					<ul class="img-wrapper gridly">
						<li>
							<div class="img" style="background-image: @if(isset($setting['insurance_banner0']))url({{asset('upload/'.$setting['insurance_banner0'])}});@else url({{asset('r_backend/v2/img/add.png')}});@endif"></div>
							<input hidden="hidden" onchange="img(this,1024*1024,upLoadLimitC);" accept="image/*" type="file">
							<input hidden type="text"  name="insurance_banner0" value="@if(isset($setting['insurance_banner0'])){{$setting['insurance_banner0']}}@endif">
						</li>
						<li>
							<div class="img" style="background-image: @if(isset($setting['insurance_banner1']))url({{asset('upload/'.$setting['insurance_banner1'])}});@else url({{asset('r_backend/v2/img/add.png')}});@endif"></div>
							<input hidden onchange="img(this,1024*1024,upLoadLimitC);" accept="image/*" type="file">
							<input hidden type="text"  name="insurance_banner1" value="@if(isset($setting['insurance_banner1'])){{$setting['insurance_banner1']}}@endif">
						</li>
						<li>
							<div class="img" style="background-image: @if(isset($setting['insurance_banner2']))url({{asset('upload/'.$setting['insurance_banner2'])}});@else url({{asset('r_backend/v2/img/add.png')}});@endif"></div>
							<input hidden onchange="img(this,1024*1024,upLoadLimitC);" accept="image/*" type="file">
							<input hidden="" type="text"  name="insurance_banner2" value="@if(isset($setting['insurance_banner2'])){{$setting['insurance_banner2']}}@endif">
						</li>
					</ul>
				</div>
				<h3 class="title">代理人banner</h3>
				<div class="default-div">
					<ul class="img-wrapper">
						<li>
							<div class="img" style="background-image: @if(isset($setting['agency_banner0']))url({{asset('upload/'.$setting['agency_banner0'])}});@else url({{asset('r_backend/v2/img/add.png')}});@endif"></div>
							<input hidden="hidden" onchange="img(this,1024*1024,upLoadLimitC);" accept="image/*" type="file">
							<input hidden type="text" name="agency_banner0" value="@if(isset($setting['agency_banner0'])){{$setting['agency_banner0']}}@endif">
						</li>
					</ul>
				</div>
				<h3 class="title">尾部信息</h3>
				<div class="default-div">
					<ul>
						<li class="col-sm-6"><span class="name">电话：</span><input type="text" name="phone" placeholder="18611111111" value="@if(isset($setting['phone'])){{$setting['phone']}}@endif"/></li>
						<li class="col-sm-6"><span class="name">邮箱：</span><input type="text" name="email" placeholder="xxx@inschos.com" value="@if(isset($setting['email'])){{$setting['email']}}@endif"/></li>
						<li class="col-sm-6"><span class="name">地址：</span><input type="text" name="address" placeholder="北京市东城区夕照寺中街14号" value="@if(isset($setting['address'])){{$setting['address']}}@endif"/></li>
						<li class="col-sm-6"><span class="name">保险业务经营许可证：</span><input type="text" name="permit" placeholder="269633000000800" value="@if(isset($setting['permit'])){{$setting['permit']}}@endif"/></li>
						<li class="col-sm-6"><span class="name">保险业务经营执照：</span><input type="text" name="license" placeholder="xxx保险经纪有限公司：9112011608300716X9" value="@if(isset($setting['license'])){{$setting['license']}}@endif"/></li>
						<li class="col-sm-6"><span class="name">版权所有：</span><input type="text" name="copyright" placeholder="2017xxx保险经纪有限公司" value="@if(isset($setting['copyright'])){{$setting['copyright']}}@endif"/></li>
					</ul>
					<div>
					</div>
				</div>
				<h3 class="title">关于我们</h3>
				<div class="default-div">
					<div id="content"></div>
					<input type="hidden" name="aboutUs" id="aboutUs" value="@if(isset($setting['aboutUs'])){{$setting['aboutUs']}}@endif"/>
				</div>
			</div>
			<div class="row text-center">
				{{--<button id="submit" class="btn btn-primary" style="width: 200px;">确定</button>--}}
				<button class="btn btn-primary" style="width: 200px;">确定</button>
			</div>
			<br/><br/><br/><br/><br/><br/>
			</form>
		</div>


<script src="{{asset('r_backend/v2/js/lib/jquery-1.11.3.min.js')}}"></script>
<script src="{{asset('r_backend/v2/js/lib/bootstrap.min.js')}}"></script>
<script src="{{asset('r_backend/v2/js/lib/wangEditor.min.js')}}"></script>
<script src="{{asset('r_backend/v2/js/common_backend.js')}}"></script>
		<script>
            $(function(){
                var editor = new wangEditor('#content')
                editor.customConfig.uploadImgShowBase64 = true;
                editor.customConfig.onchange = function (html) {
                    $('input[name="aboutUs"]').val(html);
                }
                editor.create();
                var html = $("#aboutUs").val();
                if(html){
                    editor.txt.html(html);
                }
                $('.btn-primary').click(function(){
                    var content = editor.txt.html(); // 编辑器内容
                });

                $('#btn-upload').click(function(){
                    $('.product-img').find('input:hidden').eq(0).click();
                });

                // 图片排序
                $('.gridly').gridly({
                    base: 10,
                    columns: 30,
                    callbacks:{ reordered: function(e){
                        $.each(e,function(index){
                            $(this).find('input:hidden').eq(1).attr('name','insurance_banner'+index);
                        });
                    } }
                });
                // 上传banner
                $('.img-wrapper .img').click(function(){
                    $(this).parent().find('input:hidden').eq(0).click();
                });
            })

            // logo回调
            function upLoadImgC(url,parent){
                $('.logo-default').css('background-image','url('+'../../upload/'+url +')');
                var $targetEle = parent.find('input:hidden').eq(1);
                $targetEle.val(url);
            }
            // banner回调
            function upLoadLimitC(url,parent){
                parent.find('.img').css('background-image','url('+'../../upload/'+url +')');
                var $targetEle = parent.find('input:hidden').eq(1);
                $targetEle.val(url);
            }
            function img(ele,size,callback){
                var _this = $(ele).parent();
                var $c = _this.find('input[type=file]')[0];
                var file = $c.files[0],reader = new FileReader();
                var max_size = 1;
                if(!/\/(png|jpeg|PNG|JPEG|jpg|JPG)$/.test(file.type)){
                    Mask.alert('图片支持jpg,png格式',2);
                    return false;
                }
                if(file.size>size){
                    var msg = size > 1024*1024 ? size/(1024*1024) : size/1024;
                    if(size > 1024*1024){
                        Mask.alert('单个文件大小必须小于等于'+ msg +'MB',2);
                    }else{
                        Mask.alert('单个文件大小必须小于等于'+ msg +'kb',2);
                    }
                    return false;
                }
                reader.readAsDataURL(file);
                reader.onload = function(e){
                    var data = e.target.result;
                    $.ajax({
                        type: 'POST',
                        url: "/backend/setting/uploadImage",
                        data: {
                            "url": data
                        },
                        success: function(data) {
                            callback(data,_this);
                        },
                        error: function() {
                            Mask.alert("网络请求错误!");
                        }
                    });

                };
            }
		</script>
@stop