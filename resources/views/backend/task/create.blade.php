@extends('backend.layout.base')
<link rel="stylesheet" type="text/css" href="{{asset('r_backend/css/libs/nifty-component.css')}}"/>
@section('content')
    <div id="content-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <div class="main-box clearfix" style="min-height: 1100px;">
                    <div class="tabs-wrapper tabs-no-header">
                        <ul class="nav nav-tabs">
                            @include('backend.task.nav', ['nav' => 'create'])
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade in active" id="tab-accounts">
                                @include('backend.layout.alert_info')
                                <div class="panel-group accordion" id="operation">
                                    <div class="panel panel-default">
                                        <form action="{{ route('backend.task.store') }}" method="post" id="form">
                                            {{ csrf_field() }}
                                            <table id="user" class="table table-hover" style="clear: both">
                                                <tbody>
                                                <tr id="tr-money">
                                                    <td>任务额度</td>
                                                    <td><input type="text" name="money" placeholder="请输入任务应完成的销售额" class="form-control"></td>
                                                </tr>
                                                <tr>
                                                    <td>时间</td>
                                                    <td>
                                                        <select name="type" class="form-control">
                                                            <option value="0">年任务</option>
                                                            <option value="1">季度任务</option>
                                                            <option value="2">月任务</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr id="tr-type-1" hidden>
                                                    <td>选择季度</td>
                                                    <td>
                                                        <select multiple name="season[]" class="form-control">
                                                            <option value="1">第一季度</option>
                                                            <option value="2">第二季度</option>
                                                            <option value="3">第三季度</option>
                                                            <option value="4">第四季度</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr id="tr-type-2" hidden>
                                                    <td>选择月份</td>
                                                    <td>
                                                        <select multiple name="months[]" class="form-control">
                                                            @for($i=1; $i<=12; $i++)
                                                                <option value="{{ $i }}">第{{ $i }}月份</option>
                                                            @endfor
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <button id="btn" class="btn btn-success">添加</button>
                                                    </td>
                                                    <td></td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </form>
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
    <script charset="utf-8" src="/r_backend/js/modernizr.custom.js"></script>
    <script charset="utf-8" src="/r_backend/js/classie.js"></script>
    <script charset="utf-8" src="/r_backend/js/modalEffects.js"></script>
    <script>
        $(function () {
            $('select[name=type]').on('change', function (event) {
                event.preventDefault();

                $('[id^="tr-type"]').hide();
                $('#tr-type-' + $(this).val()).show();
            });
        });
//        $(function(){
//            //条件
//            var start_time_block = $('#start-time-block');
//            var end_time_block = $('#end-time-block');
//            var start_time = $('#start_time');
//            var end_time = $('#end_time');
//            function time_block_hidden()
//            {
//                start_time_block.attr('hidden','');
//                end_time_block.attr('hidden','');
//            }
//            function time_block_show()
//            {
//                start_time_block.removeAttr('hidden');
//                end_time_block.removeAttr('hidden');
//            }
//            function reset_time_block()
//            {
//                start_time.val('');
//                end_time.val('');
//            }
//            //设置任务类型
//            var task_type = $('#task-type');
//            task_type.change(function () {
//                var task_type_val = $('#task-type option:selected').val();
//                reset_time_block();
//                if(task_type_val == 4){
//                    time_block_show();
//                }else{
//                    time_block_hidden();
//                }
//            });
//
//                //进行验证发送
//                var name = $('input[name=name]');
//                var task_type = $('input[name=task_type]');
//                var start_time = $('#start-time');
//                var end_time = $('#end-time');
//
//
//
//                var btn = $('#btn');
//                var form =  $('#form');
//                btn.click(function(){
//                    var task_type_val = $('#task-type option:selected').val();
//                    var start_time_val = start_time.val();
//                    var end_time_val = end_time.val();
//                    //进行任务名称验证
//                    var name_val = name.val();
//                    if(name_val == ''){
//                        name.parent().addClass("has-error");
//                        alert('请输入任务名称');
//                        return false;
//                    }else if(task_type_val == 0){
//                        name.parent().removeClass("has-error");
//                        task_type.parent().addClass("has-error");
//                        alert('请选择任务分组');
//                        return false;
//                    }else if(task_type_val == '4'){//特定条件任务，对时间进行判断
//                        var end = end_time_val>start_time_val;
//                       if(end){
//                           form.submit();
//                       }else{
//                           alert('结束时间不能小于开始时间');
//                       }
//                    }else if(task_type_val != 4){
//                        $.ajax({
//                            type: "post",
//                            dataType: "json",
//                            async: true,
//                            //修改的地址，
//                            url: "/backend/task/check_task_ajax",
//                            data: 'task_type='+task_type_val,
//                            headers: {
//                                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
//                            },
//                            success: function(data){
//                                var status = data['status'];
//                                if(status == 200){
//                                    if(confirm('该种任务类型只能有一种生效，继续操作将使其他同类型失效，是否继续')){
//                                        form.submit();
//                                    }else{
//
//                                    }
//                                }else {
//                                    form.submit();
//                                }
//                            },error: function () {
//                                alert('错误');
//                            }
//                        });
//                    }else {
//                        form.submit();
//                    }
//                })
//
//        })
    </script>
@stop