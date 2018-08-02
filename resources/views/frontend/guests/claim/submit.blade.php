@extends('frontend.guests.person_home.account.base')
@section('content')
    <meta name="_token" content="{{ csrf_token() }}"/>
    <div id="content-wrapper">
        <div class="row">
                <div class="row">
                    <div class="content">
                    <div class="col-lg-12">
                        <div class="main-box clearfix">
                            <div class="safety-content-right" style="margin-top: 90px;">
                            <div class="main-box-body">
                                <div class="table-responsive">
                                    <form action="{{ url('/claim/submit') }}" method="post" id="claim-form"  enctype="multipart/form-data">
                                        {{ csrf_field() }}
                                        <table id="claim-table" class="table table-hover" style="clear: both">
                                            <input type="text" name="order_id" value="{{ $order_id }}" hidden>
                                            <tr style="height: 50px;">
                                                <td width="15%">真实姓名 :</td>
                                                <td width="70%" colspan="2"><input  class="form-control" type="text"  placeholder="{{ $real_name[0]->real_name }}" value="{{ $real_name[0]->real_name }}" name="real_name" readonly="ture"></td>
                                            </tr>
                                            <tr style="height: 50px">
                                                <td width="15%">
                                                    联系电话 :
                                                </td>
                                                <td colspan="2">
                                                    <input class="form-control" type="text" placeholder="手机号码" name="phone">
                                                </td>
                                            </tr>
                                            <tr style="height: 50px">
                                                <td width="15%">收款账户 :</td>
                                                <td colspan="2">
                                                    <select class="form-control" name="type" id="type" style="width: 200px">
                                                        <option value="0" name="type">选择账户类型</option>
                                                        <option value="1" name="type">银行卡号</option>
                                                        <option value="2" name="type">支付宝账户</option>
                                                        <option value="3" name="type">微信</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr style="height: 50px" id="account-block" hidden>
                                                <td width="15%">收款账号 :</td>
                                                <td colspan="2"><input class="form-control" type="text" name="account" placeholder="" value=""></td>
                                            </tr>
                                            <tr style="height: 50px" id="bank-name" hidden>
                                                <td>开户行:</td>
                                                <td colspan="2"><input class="form-control" type="text" placeholder="" name="bank_name"></td>
                                            </tr>


                                            <div id="bill-block">
                                                <tr style="height: 60px">
                                                    <td>上传单据 :</td>
                                                    <td>
                                                        <input type="file" name="files" style="width: 170px;">
                                                    </td>
                                                    <td>
                                                        <input type="button" class="del-pic" value="删除">
                                                    </td>
                                                </tr>
                                            </div>
                                        </table>
                                    </form>
                                    <tr style="height: 50px">
                                        <td clspan="2">
                                            <button id="add-bill" onsubmit="return false;" style="width: 60px;">添加单据</button>
                                        </td>
                                    </tr>
                                    <tr style="height: 50px">
                                        <td colspan="2" style="text-align: center;">
                                            <input type="button" id="submit_btn" value="确认提交" style="width: 120px;">
                                        </td>
                                    </tr>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="/js/jquery-3.1.1.min.js"></script>
    <script>
        var bill_block = $('#bill-block');
        var bill_html = bill_block.html();

        var claim_table = $('#claim-table tbody');
        var del_pic = $('.del-pic');
        var add_bill_btn = $('#add-bill');
        index = 1;
        add_bill_btn.click(function(){
            index ++;
            var add_img_block = ' <tr style="height: 50px"><td width="15%">上传单据</td><td><input type="file" name="files'+index+'" style="width: 170px;"></td><td><input type="button" class="del-pic" value="删除"></td></tr>';
            claim_table.append(add_img_block);
        })

        claim_table.on('click','.del-pic',function(){//删除图片
            $(this).parent().parent().remove();
        })



        var form = $("#claim-form");
        var phone = $('input[name=phone]');
        var type = $('#type');
        var account = $('input[name=account]');
        var account_block = $('#account-block');
        var bank_name = $('#bank-name');
        //        var bank = $('.bank');
        var sub_btn = $('#submit_btn');
        //        var claim_checkbox = $('#claim_checkbox');
        type.change(function(){
            var typeval = type.val();
            if(typeval != 0){
                account_block.removeAttr('hidden');
                if(typeval == 1){
                    bank_name.removeAttr('hidden');
                }else{
                    bank_name.attr('hidden','');
                }
            }else {
                account_block.attr('hidden','');
            }
        })
        var claim_form = $('#claim-form');
        //正则表达式
        var phone_pattern = {{ config('pattern.phone') }};
        sub_btn.click(function(){
            var phoneval = phone.val();
            var typeval = type.val();
            var accountval = account.val();
            if(phoneval==''){
                alert('请输入手机号');
                phone.parent().addClass('has-error');
                return false;
            }else if(!phone_pattern.test(phoneval)){
                alert('手机号码格式错误');
                phone.parent().addClass('has-error');
                return false;
            }else if(typeval == 0){
                phone.parent().removeClass('has-error');
                alert('请选择账户类型');
                type.parent().addClass('has-error');
                return false;
            }else if(accountval == ''){
                alert('请输入收款账号');
                return false;
            }

            claim_form.submit();
        })
    </script>

@stop