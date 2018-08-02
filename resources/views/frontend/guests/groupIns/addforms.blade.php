    @extends('frontend.guests.guests_layout.base')
    <link rel="stylesheet/less" href="{{config('view_url.view_url')}}css/process.less"/>
    <script src="{{config('view_url.view_url').'js/lib/less.min.js'}}"></script>
    @section('content')
    <div class="wrapper step3">
        <div class="main notification clearfix">
            <div class="notification-left fl">
                <div class="notification-left-tip">
                    <i class="iconfont icon-yduidunpaishixin"></i><span>为了保障您的权益，请填写真实有效的信息。您填写的内容仅供投保使用，对于您的信息我们会严格保密。</span>
                </div>
				<form action="{{url('/groupInsFormSubmit')}}" method="post" enctype="multipart/form-data">
					{{ csrf_field()}}
                	<div class="notification-left-content">
                    <div class="date">
                        <span class="name"><i class="f18164">*</i>起保日期</span>
                        <div class="inline laydate-icon" id="starttime"></div>
                        <span>自起保日期<i class="cl333 time-start">2017-07-14零时起</i>至<i class="cl333 time-end">2017-07-17二十四时止</i>（北京时间）</span>
                    </div>
                    <div class="person">
                        <h3 class="title">投保人信息</h3>
                        <ul>
                            <li>
                                <span class="name"><i class="f18164">*</i>姓名</span>
								{{--@if($type->type == 'user'&& $person->code)--}}
{{--                                	<input type="text" name="name" value="{{$person->name}}" />--}}
								{{--@else--}}
									<input type="text" name="name">
								{{--@endif--}}
                                <!--<button class="btn-choose"><i class="iconfont icon-credentials_icon"></i>选择联系人</button>
                                <span class="error"></span>-->
                            </li>
                            <li>
                                <span class="name"><i class="f18164">*</i>证件类型</span>
                                <div class="select certificate-type">
                                    <span>身份证</span>
                                    <ul class="select-dropdown">
                                        <li>身份证</li>
                                        <li>护照</li>
                                        <li>军官证</li>
                                        <li>其他</li>
                                        <li>台胞证</li>
                                    </ul>
                                </div>
                                <input class="w320" type="text" />
                                <span class="error"></span>
                            </li>
                            <li class="person-show-hide">
                                <span class="name"><i class="f18164">*</i>出生日期</span>
                                <div class="inline laydate-icon" id="birthday">请选择出生日期</div>
                            </li>
                            <li class="person-show-hide radiobox">
                                <span class="name"><i class="f18164">*</i>性别</span>
                                <label>
                                    <input type="radio" name="sex" checked hidden/>
                                    <i class="iconfont icon-danxuan2"></i><span>男</span>
                                </label>
                                <label>
                                    <input type="radio" name="sex" hidden/>
                                    <i class="iconfont icon-danxuan1"></i><span>女</span>
                                </label>
                            </li>
                            <li>
                                <span class="name"><i class="f18164">*</i>手机号码</span>
                                <input type="text" />
                                <span class="error"></span>
                            </li>
                            <li>
                                <span class="name"><i class="f18164" >*</i>电子邮箱</span>
                                <input type="email" />
                                <span class="error"></span>
                            </li>
                            <li class="save">
                                <label>
                                    <i class="icon icon-checkbox-selected"></i>
                                    <input type="checkbox" hidden checked/>
                                    保存为默认联系人
                                </label>
                            </li>
							{{--<a href="">叮咚</a>--}}
                        </ul>
                    </div>
                    <div class="operation clearfix">
                        <h3 class="title fl">被保险人信息1/100</h3>
                        <ul class="clearfix fr">
                            <li class="btn-operation-add">
                                <i class="iconfont icon-tianjiayonghu1"></i><span>新增被保险人</span>
                            </li>
                            <li class="btn-operation-contact">
                                <i class="iconfont icon-tianjiayonghu1"></i><span>导入常用联系人</span>
                            </li>
                            <li class="btn-operation-recognizee">
                                <i class="iconfont icon-tianjiaduoren "></i><span id="hitMe" onclick="dofile()">批量导入被保险人</span>
								<input type="file" style="display: none" id="hidInput" name="license">
                            </li>
                        </ul>
                    </div>
                    <div class="personlist">
                        <table cellpadding="0" cellspacing="0">
                            <tr>
                                <th style="width:80px">为谁投保</th>
                                <th style="width:75px">姓名</th>
                                <th style="width:95px">证件类型</th>
                                <th style="width:170px">证件号码</th>
                                <th style="width:60px">性别</th>
                                <th style="width:90px">出生日期</th>
                                <th style="width:140px">手机号码</th>
                            </tr>
                            <tr>
                                <td>
                                    <div class="select">
                                        <span>其他</span>
                                        <ul class="select-dropdown">
                                            <li>配偶</li>
                                            <li>兄弟</li>
                                            <li>子女</li>
                                            <li>其他</li>
                                        </ul>
                                    </div>
                                </td>
                                <td>
                                    <input type="text" />
                                </td>
                                <td>
                                    <div class="select">
                                        <span>身份证</span>
                                        <ul class="select-dropdown">
                                            <li>身份证</li>
                                            <li>护照</li>
                                            <li>军官证</li>
                                            <li>其他</li>
                                            <li>台胞证</li>
                                        </ul>
                                    </div>
                                </td>
                                <td>
                                    <input type="text" />
                                </td>
                                <td>
                                    <div class="select type">
                                        <span>男</span>
                                        <ul class="select-dropdown">
                                            <li>男</li>
                                            <li>女</li>
                                        </ul>
                                    </div>
                                </td>
                                <td>
                                    <input type="text" />
                                </td>
                                <td>
                                    <input type="text" />
                                    <i class="iconfont icon-close"></i>
                                </td>
                            </tr>
                        </table>
                    </div>

                    <div class="favoree">
                        <h3 class="title">受益人信息</h3>
                        <div>
                            <button>受益人信息</button>
                            <button>法定继承人</button>
                            <div class="iconfont icon-tishi">
                                <div class="tip">法定（依照《中华人民共和国继承法》规定，第一顺序的继承人为配偶、父母、子女。第二顺序的继承人为兄弟姐妹、祖父母、外祖父母。继承开始后，由第一顺序继承人继承，没有第一顺序继承人继承的，由第二顺序继承人继承。</div>
                            </div>
                        </div>
                    </div>
                    <div class="contact">
                        <h3 class="title">紧急联系人（选填）<span class="btn-add"><i class="iconfont icon-close"></i></span></h3>
                        <ul class="contact-wrapper">
                            <li>
                                <span class="name">手机号码</span>
                                <input type="text" />
                            </li>
                            <li>
                                <span class="name">电子邮箱</span>
                                <input type="email" />
                            </li>
                        </ul>
                        <div class="contact-agreement">
                            <label>
                                <i class="icon icon-checkbox"></i>
                                <input type="checkbox" hidden/>
                                我已查看并同意<a href="#" class="a4d790">保险条款</a>和<a href="#" class="a4d790">投保人申明</a>
                            </label>
                        </div>
                        <div>
                            <button type="submit" id="submit" class="btn btn-unusable" disabled="disabled">提交投保单</button>
                            <!--<button class="btn-save">保存投保信息</button>-->
                        </div>
                    </div>
                </div>
				</form>

            </div>
            @include('frontend.guests.product.product_notice')
        </div>
    </div>

    <script src="{{config('view_url.view_url')}}js/lib/laydate.js"></script>
    <script src="{{config('view_url.view_url')}}js/information2.js"></script>
	<script>
//		$(document).ready(function(){
//			$('#hitMe').click(function(){
//				$('#hidInput').click();
//			})
//		})
		function dofile(){
			return  $("#hidInput").click();
		}
	</script>
    @stop