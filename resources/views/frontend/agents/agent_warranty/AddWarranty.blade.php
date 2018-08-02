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
                            <li class="active"><span>线下保单录入</span></li>
                        </ol>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="main-box clearfix" style="min-height: 1100px;">
                            <div class="tabs-wrapper tabs-no-header">
                                <ul class="nav nav-tabs">
                                    <li class="active"><a href="#">线下保单录入</a></li>
                                    <li><a href="{{ url('/agent_task/warranty_list') }}">查看已录入保单</a></li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane fade in active" id="tab-accounts">
                                        <h3><p>保单录入</p></h3>
                                        @include('frontend.agents.layout.alert_info')
                                        <div class="panel-group accordion" id="operation">
                                            <div class="panel panel-default">
                                                <form id="form" action="{{ url('/agent_task/add_warranty_submit') }}" method="post"  enctype="multipart/form-data">
                                                    {{ csrf_field() }}
                                                    <table id="table" class="table table-hover" style="clear: both">
                                                        <tr>
                                                            <td>保单编号</td>
                                                            <td colspan="2">
                                                                <input type="text" name="warranty_code" placeholder="请输入保单编号" class="form-control">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>请输入电子保单下载地址</td>
                                                            <td colspan="2">
                                                                <input type="text" name="warranty_url" placeholder="请输入电子保单下载地址，没有可以为空" class='form-control'>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td>选择订单</td>
                                                            <td colspan="2">
                                                                <select name="order_id" id="select-order" class="form-control">
                                                                    <option value="0">请选择订单</option>
                                                                    @if( $count == 0 )
                                                                        <option value="0">暂无未绑定保单的订单</option>
                                                                    @else
                                                                        @foreach($order_list as $value)
                                                                            <option value="{{ $value->id }}">{{ $value->order_code }}</option>
                                                                        @endforeach
                                                                    @endif
                                                                </select>
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
                                        <button id="btn" class="btn btn-success">确认提交</button>

                                        <div class="order_detail" id="order-detail" hidden>
                                            <h3><p>投保人信息</p></h3>
                                            <div class="panel-group accordion" id="operation">
                                                <div class="panel panel-default">
                                                    <table id="user" class="table table-hover" style="clear: both">
                                                        <tbody>
                                                        <tr>
                                                            <td width="15%">产品名称</td>
                                                            <td width="60%" id="order-product"></td>
                                                        </tr>
                                                        <tr>
                                                            <td>所属保险公司</td>
                                                            <td id="order-company"></td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
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
           //获取标签  ,进行单据提交录入
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


            //获取dom
            var select_order = $('#select-order');
            var order_detail = $('#order-detail');  //订单详情框
            var order_product = $('#order-product');  //产品详情
            var order_company = $('#order-company');  //产品所属公司


            select_order.change(function(){
                var select_order_val = $('#select-order option:selected').val();
               if(select_order_val == 0){
                    order_detail.attr('hidden','');
               }else{
                    order_detail.removeAttr('hidden');
                   $.ajax({
                       type: "post",
                       dataType: "json",
                       async: true,
                       //修改的地址，
                       url: "/agent_task/ajax/get_order_detail",
                       data: 'order_id='+select_order_val,
                       headers: {
                           'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                       },
                       success: function(data){
                           var status = data['status'];
                           if(status == 200){  //说明返回数据成功
                               var data = data['data']['product'];
                               order_product.html(data['product_name']);
                               order_company.html(data['company_name']);
                           }else {
                               alert(data['data']);
                           }
                       },error: function () {
                           alert("添加失败");
                       }
                   });



               }
            });

            var warranty_code = $('input[name=warranty_code]');
            var order_id = $('input[name=order_id]');
            //提交验证
            btn.click(function(){
                var warranty_code_val = warranty_code.val();
                var order_id_val = $('#select-order option:selected').val();


                if(warranty_code_val == ''){
                    alert('请输入保单编号');
                    return false;
                }else if(order_id_val == 0){
                    alert('请选择订单');
                    return false;
                }


                form.submit();
            });




        })

    </script>
@stop



