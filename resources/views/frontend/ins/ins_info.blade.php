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
            <form action="{{ url('/insurance/prepare_order') }}" id="form" method="post">
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
                <input type="hidden" name="private_p_code" id="private_p_code" value="{{$private_p_code}}">
                <input type="hidden" name="ditch_id" value="{{ isset($ditch_id) ? $ditch_id : 0}}" >
                <input type="hidden" name="agent_id" value="{{ isset($agent_id) ? $agent_id : 0}}" >
                <input type="hidden" name="api_from_uuid" id="api_from_uuid" value="{{ $ins['api_from_uuid'] }}" >
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
    <script>
        $('body').on("click", ".choose-parameter li", function(){
            var csrf = $("input[name=_token]").val();
//            var p_code = $("input[name=p_code]").val();
            var old_potion = $('#old-option').val();
            var api_from_uuid = $('#api_from_uuid').val();
            var private_p_code = $('#private_p_code').val();

            var $this = $(this);
            var old_val = $this.parent().children('.label-active').attr('value');

            $this.parent().children('li').removeClass('label-active');
            $this.addClass('label-active');

            var $lis = ($('label').children('.label-active'));
            var new_val = '[';
            $lis.each(function(k, v){
                new_val += $(v).attr('value') + ',';
            })
            new_val=new_val.substring(0,new_val.length-1);
            new_val += ']';
//            console.log(new_val);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': csrf
                },
                type: "POST",
                url: '{{url('insurance/quote')}}',
                data: {
//                    'p_code': p_code,
                    'new_val': new_val,
                    'old_val': old_val,
                    'old_option': old_potion,
                    'api_from_uuid': api_from_uuid,
                    'private_p_code': private_p_code
                },
                success: function (data) {
                    $("#option").html(data);
                }

            });
        })
    </script>
@stop