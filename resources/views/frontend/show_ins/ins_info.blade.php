@extends('frontend.guests.frontend_layout.base')
<link rel="stylesheet" href="{{ url(config('resource.position.css').'/frontend/product/product-info.css') }}">
<style>
    .product-parameter li{float: left;padding:1px 2px;width:100px;margin-right: 7px; border:1px solid #cccccc;}
    li.label-active {border:2px solid #ffa700;}
</style>
@section('content')
    <div class="main-top">
        <div class="main-top-block">
            <div class="main-top-position">
                <a href=""><span>某某保险网</span></a> > <a href=""><span>儿童保险</span></a>
            </div>
            <div class="main-top-classify">
                <ul>
                    <a href=""><li class='choose'>保障详情</li></a>
                    <a href=""><li class='no_choose'>典型案例</li></a>
                    <a href=""><li class='no_choose'>理赔指引</li></a>
                    <a href=""><li class='no_choose'>常见问题</li></a>
                    <a href=""><li class='no_choose'>用户问题（55）</li></a>
                </ul>
            </div>
        </div>
    </div>
    <div class="main-middle">
        <div class="main-middle-left">
            {{--产品名称--}}
            <div class="product-name">
                {{--{{$res['name']}}--}}
            </div>
            {{--产品名称--}}
            {{--标签--}}
            <div class="product-classify">
                @if(!empty($labels))
                    <ul>
                        @foreach($labels as $label)
                            <li>
                                <img src="" alt="">
                                <span>{{$label['name']}}</span>
                            </li>
                        @endforeach
                    </ul>
                @endif
                <div class="ClearFix"></div>
            </div>
            {{--标签--}}
            <form action="{{ url('/ins/prepare_order') }}" id="form" method="post">
                {{--产品参数--}}
                <div class="product-parameter">
                    <div id="option">
                        @php
                            echo $option_html;
                        @endphp
                    </div>
                    <div class="choose-parameter-button">
                        <button class="go" type="submit">立即投保</button>
                        <button class="car" type="button">加入购物车</button>
                    </div>
                    <div class="ClearFix"></div>
                </div>
                {{--条款--}}
                <div class="product-guarantee">
                    <div class="guarantee-title">
                        <span>保障权益</span>
                    </div>
                </div>
                {{ csrf_field() }}
                {{--todo--}}
                <input type="hidden" name="private_p_code" id="private_p_code" value="{{$ins->private_p_code}}">
                <input type="hidden" name="ditch_id" value="{{ isset($ditch_id) ? $ditch_id : 0}}" >
                <input type="hidden" name="agent_id" value="{{ isset($agent_id) ? $agent_id : 0}}" >
                {{--<input type="hidden" name="api_from_uuid" id="api_from_uuid" value="{{ $ins['api_from_uuid'] }}" >--}}
                <div id="hidden"></div>
            </form>


            <div class="rights">
                <div class="rights-title">
                    <span>您拥有的权益</span>
                </div>
                <div class="rights-list">
                    <div class="rights-detail">
                        <div class="rights-logo">

                        </div>
                        <div class="rights-content">
                            <div class="rights-content-title">
                                退保
                            </div>
                            <div class="rights-content-content">
                                保险合同沒有完全履行时,经投保人和被保险人申请,保险人同意,解除双方由合同确定的法律关系,保险人按合同的约定退还保险单的现金价值。
                            </div>
                        </div>

                    </div>
                    <div class="rights-detail">
                        <div class="rights-logo">

                        </div>
                        <div class="rights-content">
                            <div class="rights-content-title">
                                退保
                            </div>
                            <div class="rights-content-content">
                                保险合同沒有完全履行时,经投保人和被保险人申请,保险人同意,解除双方由合同确定的法律关系,保险人按合同的约定退还保险单的现金价值。
                            </div>
                        </div>

                    </div>
                </div>
                <div class="ClearFix"></div>
            </div>
            <div class="inform">
                @if(!empty($res['person']))
                    <div class="inform-title">
                        <span>产品解读</span>
                    </div>
                    <div class="inform-content">
                        <div class="inform-detail">
                            <?php echo $res['person']?>
                        </div>
                    </div>
                @endif
                <div class="ClearFix"></div>
            </div>

            <div class="evaluate">

            </div>
        </div>
    </div>
@stop

{{--@section('js')--}}
    {{--<script src="https://cdn.bootcss.com/moment.js/2.18.1/moment.min.js"></script>--}}
    {{--<script src="https://cdn.bootcss.com/moment.js/2.18.1/locale/zh-cn.js"></script>--}}
    {{--<script src="https://cdn.bootcss.com/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>--}}

{{--@endsection--}}
{{--@section('css')--}}
    {{--<link href="https://cdn.bootcss.com/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css" rel="stylesheet">--}}
{{--@endsection--}}