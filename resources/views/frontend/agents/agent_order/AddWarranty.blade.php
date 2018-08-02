@extends('frontend.agents.layout.agent_bases')
@section('content')
    <meta name="_token" content="{{ csrf_token() }}"/>
    <style>

    </style>
    <div id="content-wrapper">
        <div class="big-img" style="display: none;">
            <img src="" alt="" id="big-img" style="width: 75%;height: 90%;">
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <ol class="breadcrumb">
                            <li><a href="/agent/">主页</a></li>
                            <li><a href="#">订单及任务管理</a></li>
                            <li class="active"><span>线下订单录入</span></li>
                        </ol>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="main-box clearfix" style="min-height: 1100px;">
                            <div class="tabs-wrapper tabs-no-header">
                                <ul class="nav nav-tabs">
                                    <li class="active"><a href="">订单录入</a></li>
                                    <li><a href="">查看已录入订单</a></li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane fade in active" id="tab-accounts">
                                        <h3><p>订单录入</p></h3>
                                        @include('frontend.agents.layout.alert_info')
                                        <div class="panel-group accordion" id="operation">
                                            <div class="panel panel-default">
                                                <form id="form" action="{{ url('/agent_task/add_order_submit') }}" method="post"  enctype="multipart/form-data">
                                                    {{ csrf_field() }}
                                                    <table id="table" class="table table-hover" style="clear: both">
                                                        {{--<tr>--}}
                                                            {{--<td width="30%">订单编号</td>--}}
                                                            {{--<td colspan="2">--}}
                                                                {{--<input type="text" class="form-control" placeholder="请输入订单编号" name="order_code">--}}
                                                            {{--</td>--}}
                                                        {{--</tr>--}}
                                                        {{--<tr>--}}
                                                            {{--<td>电子保单地址</td>--}}
                                                            {{--<td colspan="2">--}}
                                                                {{--<input type="text" name="url" placeholder="请输入电子保单地址,没有可不填" class="form-control">--}}
                                                            {{--</td>--}}
                                                        {{--</tr>--}}
                                                        <tr>
                                                            <td>保险产品</td>
                                                            <td colspan="2">
                                                                <select name="product_id" id="product" class="form-control">
                                                                    <option value="0">选择保险产品</option>
                                                                    @if($product_count == 0)
                                                                        <option value="0">暂无产品</option>
                                                                    @else
                                                                        @foreach($product_list as $value)
                                                                            <option value="{{ $value->id }}">{{ $value->product_name }}</option>
                                                                        @endforeach
                                                                    @endif
                                                                </select>
                                                            </td>
                                                        </tr>
                                                        <tr id="company" hidden>
                                                            <td>所属保险公司</td>
                                                            <td colspan="2">
                                                                <input type="text" name="company" id="company_input" disabled class="form-control" value="">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td width="30%">上传订单照片</td>
                                                            <td width="60%"><input type="file" name="pic"></td>
                                                            <td>
                                                                <input type="button" class="del-pic" value="删除">
                                                            </td>
                                                        </tr>
                                                    </table>
                                            </div>
                                        </div>
                                        <input type="button" id="add-pic-btn" class="btn btn-success" value="添加单据">
                                        <h3><p>投保人信息</p></h3>
                                        <div class="panel-group accordion" id="operation">
                                            <div class="panel panel-default">
                                                <table id="user" class="table table-hover" style="clear: both">
                                                    <tbody>
                                                    <tr>
                                                        <td width="15%">姓名</td>
                                                        <td width="60%">
                                                            <input type="text" class="form-control" placeholder="请输入投保人姓名" name="policy_name">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>证件类型</td>
                                                        <td>
                                                            <select name="policy_card_type" id="policy_card_type" class="form-control">
                                                                <option value="0">请选择证件</option>
                                                            </select>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>证件号码</td>
                                                        <td><input type="text" name="policy_code"  placeholder="请输入投保人证件号" class="form-control"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>手机号码</td>
                                                        <td><input type="text" name="policy_phone" placeholder="请输入投保人手机号码"  class="form-control"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>电子邮箱</td>
                                                        <td><input type="text" name="policy_email" placeholder="请输入投保人电子邮箱" class="form-control"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>职业</td>
                                                        <td>
                                                            <select name="policy_occupation" id="policy_occupation" class="form-control">
                                                                <option value="0">请选择职业</option>
                                                            </select>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div id="recognizee-block">
                                            <h3><p>被保人信息</p></h3>
                                            <div class="panel-group accordion" id="operation">
                                                <div class="panel panel-default">
                                                    <table id="user" class="table table-hover" style="clear: both">
                                                        <tbody>
                                                        <tr>
                                                            <td>与投保人关系</td>
                                                            <td>
                                                                <select name="recognizee_relation" id="" class="relation form-control">
                                                                    <option value="0">请选择关系</option>
                                                                </select>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td width="15%">姓名</td>
                                                            <td width="60%">
                                                                <input type="text" class="form-control" placeholder="请输入被保人姓名" name="recognizee_name">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>证件类型</td>
                                                            <td>
                                                                <select name="recognizee_card_type" id="recognizee_card_type"  class="form-control">
                                                                    <option value="">请选择证件</option>
                                                                </select>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>证件号码</td>
                                                            <td><input type="text" name="recognizee_code" placeholder="请输入证件号码"  class="form-control"></td>
                                                        </tr>
                                                        <tr>
                                                            <td>手机号码</td>
                                                            <td><input type="text" name="recognizee_phone" placeholder="请输入被保人手机号"  class="form-control"></td>
                                                        </tr>
                                                        <tr>
                                                            <td>电子邮箱</td>
                                                            <td><input type="text" name="recognizee_email" placeholder="请输入被保人电子邮箱" class="form-control"></td>
                                                        </tr>
                                                        <tr>
                                                            <td>职业</td>
                                                            <td>
                                                                <select name="recognizee_occupation" id="recognizee_occupation" class="form-control">
                                                                    <option value="0">请选择职业</option>
                                                                </select>
                                                            </td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <button id="btn" class="btn btn-success">添加</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="/js/jquery-3.1.1.min.js"></script>
    <script>
        $(function(){
           //获取标签
            var add_pic_btn = $('#add-pic-btn');
            var table = $('#table');
            var tbody = $('#table tbody');
            var btn = $('#btn');
            var form = $('#form');
            var del_pic = $('.del-pic');
            var i = 1;

            tbody.on('click','.del-pic',function(){//删除图片
                $(this).parent().parent().remove();
            })

            //添加图片
            add_pic_btn.click(function(){
                i++;
                var add_pic_dom = ' <tr><td width="30%">上传订单照片</td><td width="60%"><input type="file" name="pic'+i+'"></td><td><input type="button" class="del-pic" value="删除"></td></tr>'
                tbody.append(add_pic_dom);
            });



            //产品变化时变化
            var select_product = $('#product');
            var policy_card_type = $('#policy_card_type');
            var recognizee_card_type = $('#recognizee_card_type');
            var policy_occupation = $('#policy_occupation');
            var recognizee_occupation = $('#recognizee_occupation');
            var company = $("#company");
            var company_input = $('#company_input');
            var relation = $('.relation');

            select_product.change(function(){
                var select_product_val = $('#product option:selected').val();
                if(select_product_val == 0){
                    company_input.val('');
                    company.attr('hidden','');
                    policy_card_type.html('<option value="0">请选择证件</option>');
                    recognizee_card_type.html('<option value="0">请选择证件</option>');
                    policy_occupation.html('<option value="0">请选择职业</option>');
                    recognizee_occupation.html('<option value="0">请选择职业</option>');
                }else{//说明选择了产品，通过ajax获得证件类型，这也
                    $.ajax({
                        type: "post",
                        dataType: "json",
                        async: true,
                        //修改的地址，
                        url: "/agent_task/ajax/get_parameter",
                        data: 'product_id='+select_product_val,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                        },
                        success: function(data){
                            var status = data['status'];
                            if(status){
                                var data = data['data'];
                                var card_type_data = data['card_type'];
                                var occupation_data = data['occupation'];
                                var relation_data = data['relation'];

                                var card_type_len = card_type_data.length;
                                var occupation_len = occupation_data.length;
                                var relation_len = relation_data.length;

                                var card_html = '<option value="0">请选择证件</option>';
                                for(var i = 0;i<card_type_len;i++){
                                    card_html +='<option value="'+card_type_data[i]['id']+'">'+card_type_data[i]['name']+'</option>';
                                }
                                policy_card_type.html(card_html);
                                recognizee_card_type.html(card_html);

                                var occupation_html = '<option value="0">请选择职业</option>';
                                for(var k=0;k<occupation_len;k++){
                                    occupation_html += '<option value="'+occupation_data[k]['id']+'">'+occupation_data[k]['name']+'</option>';
                                }
                                policy_occupation.html(occupation_html);
                                recognizee_occupation.html(occupation_html);

                                var relation_html = '<option value="0">请选择关系</option>';
                                for(var j=0;j<relation_len;j++){
                                    relation_html += '<option value="'+relation_data[j]['id']+'">'+relation_data[j]['name']+'</option>';
                                }
                                relation.html(relation_html);


                                //显示所属公司
                                company.removeAttr('hidden');
                                company_input.val(data['company_name']);

                            }else {
                                alert(data['data']);
                            }
                        },error: function () {
                            alert("添加失败");
                        }
                    });
                }
            })




            //点击进行表单提交
            var btn = $('#btn');
            btn.click(function(){


                form.submit();
            });





        })

    </script>
@stop



