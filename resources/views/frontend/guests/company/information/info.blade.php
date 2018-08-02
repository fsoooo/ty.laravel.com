@extends('frontend.guests.company_home.account.base')

@section('content')
    <form action="{{url('/information/company_submit')}}" method="post" enctype="multipart/form-data" >
        {{ csrf_field() }}
        <ul class="form-wrapper">
            <li>
                <span class="form-name">企业名称</span>
                <input id="tel" type="text" name="name" @if(isset($information['name'])) value="{{$information['name']}}" @else value="" @endif/>
                {{--<i class="error"></i>--}}
            </li>
            <li>
                {{--<span class="form-name">企业类型</span>--}}
                {{--<select id="enterpriseType" name="">--}}
                {{--<option value="" disabled selected>请选择</option>--}}
                {{--<option value="1">省/市</option>--}}
                {{--</select>--}}
                <div class="btn-wrapper">
                    <a class="btn-select @if(isset($data['credit_code']))active @endif">三证合一企业</a>
                    <a class="btn-select @if(!isset($data['credit_code']))active @endif">非三证合一企业</a>
                    <input hidden type="radio" value="0" name="id_type">
                    <input hidden type="radio" value="1" name="id_type">
                </div>
                <i class="error"></i>
            </li>
            <li class="hide">
                <span class="form-name">组织机构代码</span>
                <input type="text" name="code" @if(isset($data['code'])) value="{{$data['code']}}" @endif/>
                <i class="error"></i>
            </li>
            <li class="hide">
            <span class="form-name">营业执照编号</span>
            <input id="email" type="text" name="license_code" @if(isset($data['license_code'])) value="{{$data['license_code']}}" @endif/>
            <i class="error"></i>
            </li>
            <li class="hide">
            <span class="form-name">纳税人识别号</span>
            <input id="email" type="text"  name="tax_code" @if(isset($data['tax_code'])) value="{{$data['tax_code']}}" @endif/>
            <i class="error"></i>
            </li>
            <li>
                <span class="form-name">统一信用代码</span>
                <input id="email" type="text" name="credit_code" @if(isset($data['credit_code'])) value="{{$data['credit_code']}}" @endif/>
                <i class="error"></i>
            </li>

            <li>
                <span class="form-name">企业所在地址</span>
                <select id="province" name="province"></select>
                <select id="city" name="city"></select>
                <i class="error"></i>
            </li>
            <li>
                <span class="form-name"></span>
                <textarea placeholder="请输入详细地址" name="inAddress"></textarea>
            </li>
            <li>
                <span class="form-name">营业执照</span>
                <a href="javascript:;" style="text-align: center" class="btn-primary-hollow btn-upload">上传照片</a>
                <div class="company-img-wrapper">
                    <div class="company-img-item">
                        <div class="company-img">
                            <img src="{{config('view_url.company_url').'image/yingye.png'}}" alt="" />
                        </div>
                        <div class="company-img-tips">营业执照样本展示</div>
                    </div>
                    <div class="company-img-item">
                        <div class="company-img upload-wrapper"></div>
                        @if(isset($trueInfo['license_img']))
                            <img src="{{url($trueInfo['license_img'])}}" alt="">
                        @endif
                        <div class="company-img-tips yellow"></div>
                    </div>
                </div>
                <input hidden="hidden" type="file" onchange="upload(this);" accept="image/*" name="upFile" />
                <input id="business" hidden type="text" class="inputhidden"></input>
                <i class="error"></i>
            </li>
        </ul>
        <button class="btn-00a2ff btn-save">保存</button>
    </form>
{{--    <script src="{{config('view_url.company_url').'js/lib/profession.js'}}"></script>--}}


@stop


