@extends('frontend.agents.layout.agent_bases')
@section('content')
    <meta name="_token" content="{{ csrf_token() }}"/>
    <div id="content-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <ol class="breadcrumb">
                            <li><a href="/agent/">主页</a></li>
                            <li>销售管理</li>
                            <li><a href="{{ url('/agent_sale/product_list') }}">产品列表</a></li>
                            <li class="active"><a href="#">生成计划书</a></li>
                        </ol>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="main-box clearfix" style="min-height: 1100px;">
                            <div class="tabs-wrapper tabs-no-header">
                                <ul class="nav nav-tabs">
                                    {{--<li><a href="{{ url('/agent_sale/product_list') }}">我的产品</a></li>--}}
                                    {{--<li><a href="{{ url('/agent_sale/plan') }}">计划书管理</a></li>--}}
                                    <li class="active"><a href="#">生成计划书</a></li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane fade in active" id="tab-accounts">
                                        @include('frontend.agents.layout.alert_info')
                                        <h3><p>请选择参数</p></h3>
                                        <div class="panel-group accordion" id="operation">
                                            <div class="panel panel-default">
                                                <form id="form" method="post" action="{{ url('agent_sale/plan_submit') }}">
                                                    {{ csrf_field() }}
                                                <table id="user" class="table table-hover" style="clear: both">
                                                    <tbody>
                                                    <tr>
                                                        <td>计划书名称</td>
                                                        <td><input type="text" name="plan_name" id="plan-name" placeholder="请输入计划书名称" class="form-control"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>选择渠道</td>
                                                        <td>
                                                            <select name="ditch_id" id="" class="form-control">
                                                                <option value="0">选择渠道，可以为空</option>
                                                                @if($ditch_count == 0)
                                                                    <option value="0">暂无渠道</option>
                                                                @else
                                                                    @foreach($ditch_list as $value)
                                                                        <option value="{{ $value->ditch->id }}">{{ $value->ditch->name }}</option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                        </td>
                                                    </tr>
                                                    @foreach($ke as $k=>$v)
                                                        @if($k =="年龄")
                                                            <tr>
                                                                <td>{{$k}}</td>
                                                                <td>
                                                            @foreach($v as$key=>$values)
                                                                        <select name="age" class="form-control">
                                                                            @foreach($values as $value)
                                                                                @if($value==$values[0])
                                                                                    <option value="{{$value}}" selected  onclick='selectTariff()'>{{$value}}</option>
                                                                                @else
                                                                                    <option value="{{$value}}"  onclick='selectTariff()'>{{$value}}</option>
                                                                                @endif
                                                                            @endforeach
                                                                        </select>

                                                            @endforeach
                                                            </td>
                                                            </tr>
                                                        @else
                                                            <tr id="{{$k}}">
                                                                <td width="15%">{{$k}}</td>
                                                                <td width="15%" >
                                                            @foreach($v as$key=>$values)
                                                                @foreach($values as $value)
                                                                            <script>
                                                                                var v = "{{$value}}";
                                                                                var id = "{{$k}}";
                                                                                if(v =="#"||typeof(v)==undefined){
                                                                                    document.getElementById(id).style.display="none";
                                                                                }
                                                                            </script>
                                                                            @if($value == "#"||empty($value)||is_null($value))
                                                                                <script>
                                                                                    var v = "{{$value}}";
                                                                                    var id = "{{$k}}";
                                                                                    if(v =="#"||v==""||typeof(v)==undefined){
                                                                                        document.getElementById(id).style.display="none";
                                                                                    }
                                                                                </script>
                                                                            @else
                                                                                @if($value)
                                                                                    {{$value}}
                                                                                    <input type="radio"  style="display: inline-block;" checked  class="radio" name="{{$key}}" value="{{$value}}" onclick='selectTariff()'>
                                                                                @else
                                                                                    <input type="radio"  style="display: inline-block;" class="radio" name="{{$key}}" value="{{$value}}" onclick='selectTariff()'>
                                                                                @endif
                                                                            @endif
                                                                @endforeach
                                                            @endforeach
                                                                                </td>
                                                            </tr>
                                                        @endif
                                                    @endforeach
                                                    <tr>
                                                        <td>价格</td>
                                                        <td id="check">{{$taris}}</td>
                                                    </tr>
                                                    <div id="hidden"></div>
                                                    @if(isset($taris)&&!empty($taris))
                                                        <input type="hidden" id="tariff_hidden" name="tariff" value="{{$taris}}">
                                                    @endif

                                                    {{--<tr>--}}
                                                        {{--<td>价格</td>--}}
                                                        {{--<td id="price">0</td>--}}
                                                    {{--</tr>--}}
                                                    </tbody>
                                                </table>

                                                    @foreach($clauses as $v)
                                                        <input type="hidden" name="clause_ids" value="{{$v}}">
                                                        @endforeach
                                                    <input type="hidden" name="product_id" value="{{$product_detail['product_id']}}"/>

                                            </div>
                                        </div>
                                        <div style="font-size:20px; margin-left:20px;">关联条款</div>
                                        <div class="row">
                                            <?php $clause_ids = ''; ?>
                                            @foreach($clau as $ck => $cv)
                                                    @if($cv['type']=='main')

                                                        <?php
                                                        $clause_ids .= $cv['id'] . ',';
                                                        $bao_e = explode(',', $cv['coverage']);
                                                        ?>

                                                        <div style="margin-left:40px;font-size:14px;border:1px solid blanchedalmond; padding:10px;margin:10px;">
                                                            <input type="checkbox" name="main_clause_id_{{ $cv['id'] }}" value="{{$cv['id']}}">
                                                            <h4><b>主险条款</b></h4>
                                                            <input type="hidden" name="clause_beishu_{{$cv['id']}}" id="clause_beishu_{{$cv['id']}}" value="{{$cv['min_m']}}">
                                                            {{$cv['name']}}&nbsp;
                                                            可选保额：
                                                            <?php
                                                            $str = '<select name="money_'.$cv["id"].'" class="form-control bao_e_select" clause_id="'. $cv['id'] .'" jc_bao_e="'. $bao_e[0] .'" bao_e_beishu="1">';
                                                            foreach($bao_e as $bk => $v){
                                                                $str .= '<option name="bao_e" value="'. $v .'">' . $v . '元';
                                                            }
                                                            $str .= '</select>';
                                                            echo $str;
                                                            ?>
                                                            <div style="margin:10px;">
                                                                {{$cv['content']}}
                                                            </div>

                                                        </div>
                                                    @else

                                                        <?php
                                                        $clause_ids .= $cv['id'] . ',';
                                                        $bao_e = explode(',', $cv['coverage']);
                                                        ?>
                                                        <div style="margin-left:40px;font-size:14px;border:1px solid blanchedalmond; padding:10px;margin:10px;">
                                                            <input type="checkbox" name="attach_clause_id_{{ $cv['id'] }}" value="{{$cv['id']}}">
                                                            <h4><b>附加险条款</b></h4>
                                                            <input type="hidden" name="clause_beishu_{{$cv['id']}}" id="clause_beishu_{{$cv['id']}}" value="1">
                                                            {{$cv['name']}}&nbsp;
                                                            可选保额：
                                                            <?php
                                                            $str = '<select name="money_'.$cv["id"].'" class="bao_e_select" clause_id="'. $cv['id'] .'" jc_bao_e="'. $bao_e[0] .'" bao_e_beishu="1">';
                                                            foreach($bao_e as $bk => $v){
                                                                $str .= '<option name="bao_e" value="'. $v .'">' . $v . '元';
                                                            }
                                                            $str .= '</select>';
                                                            echo $str;
                                                            ?>
                                                            <div style="margin:10px;">
                                                                {{$cv['content']}}
                                                            </div>

                                                        </div>

                                                    @endif

                                                @endforeach
                                        </div>
                                    </div>
                                    </form>
                                    <button id="btn" class="btn btn-success" onclick="doParameters()">确认提交</button>
                                        <script>
                                            $('.bao_e_select').change(function(){
                                                var clause_id = $(this).attr('clause_id');
                                                input_name = "clause_beishu_" + clause_id;
                                                var input_obj = $("#"+ input_name +"");
                                                var jb_bao_e = $(this).attr('jc_bao_e');
                                                var select_bao_e = $(this).val();
                                                var num = select_bao_e / jb_bao_e;
                                                input_obj.val(num);
                                                selectTariff();
                                            });
                                            function selectTariff(){
                                                var result = {};
                                                var fieldArray = $('#form').serializeArray();
                                                for (var i = 0; i < fieldArray.length; i++) {
                                                    var field = fieldArray[i];
                                                    if (field.name in result) {
                                                        result[field.name] += ',' + field.value;
                                                    } else {
                                                        result[field.name] = field.value;
                                                    }
                                                }
                                                $.ajax( {
                                                    type : "get",
                                                    url : '/selecttariff',
                                                    dataType : 'json',
                                                    data :  result,
                                                    success:function(msg){
                                                        if(msg.status == 0){
                                                            var tariff = msg.tariff;
                                                            window.tariff = tariff;
                                                            $('#tariff_hidden').attr('disabled',true);
                                                            $('#hidden').html('<input type="text" name="tariff" value="'+tariff+'" >');
                                                            $('#check').html('<font color="black">'+tariff+'</font>');
                                                        }else{

                                                        }

                                                    }
                                                });
                                            }
                                            function doParameters() {
                                                var result = {};
                                                var fieldArray = $('#form').serializeArray();
                                                for (var i = 0; i < fieldArray.length; i++) {
                                                    var field = fieldArray[i];
                                                    if (field.name in result) {
                                                        result[field.name] += ',' + field.value;
                                                    } else {
                                                        result[field.name] = field.value;
                                                    }
                                                }
                                                var tari = 'tariff';
                                               result[tari] = tariff;


                                            }
                                            var btn = $('#btn');
                                            var plan_name = $('#plan-name');
                                            var form = $('#form');
                                            btn.click(function(){
                                                var plan_name_val = plan_name.val();
                                                if(plan_name_val == ''){
                                                    alert('计划书名称不能为空');
                                                    return false;
                                                }

                                                form.submit();

                                            })
                                        </script>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@stop







