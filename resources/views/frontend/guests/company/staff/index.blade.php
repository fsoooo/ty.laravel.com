@extends('frontend.guests.company_home.base')

@section('content')
    <style>
        .table-wrapper{
            padding: 20px;
            height: 872px;
            background: #fff;
        }
        .table-address {
            width: 100%;
            border: 1px solid #d8d7d9;
            text-align: center;
        }

        .table-address th {
            color: #fff;
            background: #00a2ff;
        }

        .table-address tr {
            height: 60px;
            border-bottom: 1px solid #d8d7d9;
        }

        .table-address td {
            position: relative;
        }
        .table-address .btn-edite{
            margin-right: 6px;
        }

        .form-wrapper{
            width: 400px;
            margin: 60px auto;
        }
        select{
            width: 288px;
            background-position-x: 264px;
        }
        .select-date{
            display: inline-block;
            width: 130px;
            vertical-align: middle;
        }
        .error{
            height: 24px;
            display: block;
            margin-left: 74px;
        }
        .form-wrapper>li{margin-bottom: 0;}
    </style>
    <div class="table-nav">
        <span @if($type == 'done')class="active"@endif><a href="/staff/index/done">现有成员</a></span>
        <span @if($type == 'pass')class="active"@endif><a href="/staff/index/pass">已删减成员</a></span>
        <span @if($type == 'add')class="active"@endif ><a href="/staff/index/add">已添加成员</a></span>
    </div>
    <div class="table-wrapper">
        <div class="table-operation"><button class="btn btn-primary">增员</button><button class="btn btn-danger">减员</button></div>
        <table class="table-address">
            <thead>
            <tr>
                <th width="60px"><input id="allSelect" type="checkbox"/>全选</th>
                {{--<th width="60px">工号</th>--}}
                <th width="40px">姓名</th>
                <th width="200px">身份证号</th>
                <th width="100px">手机号码</th>
                @if($type == 'pass')

                @else
                    <th width="100px">保障方案</th>
                    <th width="100px">保障开始时间</th>
                    <th width="100px">保障结束时间</th>
                    <th width="100px">操作</th>
                @endif
            </tr>
            </thead>
            <tbody>
            @if($type == 'done')
                @foreach($data as $k=>$v)
                    <tr>
                        <td><input type="checkbox" myId = "{{$v->id}}" /></td>
                        {{--<td>01</td>--}}
                        <td>{{$v->name}}</td>
                        <td>{{$v->code}}</td>
                        <td>{{isset($v->phone)?$v->phone:'--'}}</td>
                        <td>{{$v->order->product->product_name}}</td>
                        <td>{{strtok($v->order['start_time'],' ')}}</td>
                        <td>{{isset($v->order['end_time'])?strtok($v->order['end_time'],' ') : date("Y-m-d",strtotime("+1 year",strtotime($v->order['start_time'])))}}</td>
                        <td><button class="btn btn-edite" myId = "{{$v->id}}">修改</button>
                            <button class="btn red del" myId = "{{$v->id}}">删除</button></td>
                    </tr>
                @endforeach
            @elseif($type == 'add')
                @foreach($data as $k=>$v)
                    <tr>
                        <td><input type="checkbox" myId = "{{$v->id}}"/></td>
                        {{--<td>01</td>--}}
                        <td>{{$v->name}}</td>
                        <td>{{$v->id_code}}</td>
                        <td>{{$v->phone}}</td>
                        <td>{{$v->product->product_name}}</td>
                        <td>{{$v->date}}</td>
                        <td>{{date("Y-m-d",strtotime("+1 year",strtotime($v['date'])))}}</td>
                        <td>
                            <button class="btn btn-edite" myId = "{{$v->id}}">修改</button>
                            <button class="btn red del" myId = "{{$v->id}}">删除</button>
                        </td>
                    </tr>
                @endforeach
            @else
                @foreach($data as $k=>$v)
                    <tr>
                        <td><input type="checkbox" myId = "{{$v->id}}"/></td>
                        {{--<td>01</td>--}}
                        <td>{{$v->name}}</td>
                        <td>{{$v->code}}</td>
                        <td>{{trim($v->phone)}}</td>
                    </tr>
                @endforeach
            @endif
            </tbody>
        </table>
        {{ $data->links() }}
    </div>
    {{--编辑--}}
    <div class="popup popup-person">
        <div class="popup-bg"></div>
        <div class="popup-wrapper">
            <div class="popup-title">编辑被保人<i class="iconfont icon-close fr"></i></div>
            <form action="/staff/editStaff" method="post" id="edit_form" enctype="multipart/form-data">
                {{ csrf_field() }}
            <div class="popup-content">
                <ul class="form-wrapper">
                    <li>
                        <span class="form-name"><i class="red">*</i>保障方案</span>
                        <select name="product" id="product">
                            <option value="" disabled selected>请选择</option>
                            @foreach($products as $k=>$v)
                                <option value="{{$v->ty_product_id}}">{{$v->product_name}}</option>
                            @endforeach
                        </select>
                        <i class="error"></i>
                    </li>
                    <li>
                        <span class="form-name"><i class="red">*</i>姓名</span>
                        <input id="name" type="text" maxlength="25" placeholder="长度不超过25个字节" name="name" />
                        <i class="error"></i>
                    </li>
                    <li>
                        <span class="form-name"><i class="red">*</i>证件类型</span>
                        <select name="id_type" id="id_type">
                            <option value="" disabled selected>请选择</option>
                            <option value="1">身份证</option>
                        </select>
                        <i class="error"></i>
                    </li>
                    <li>
                        <span class="form-name"><i class="red">*</i>证件号码</span>
                        <input id="idCard" type="text" placeholder="" name="id_code" />
                        <i class="error"></i>
                    </li>
                    <li>
                        <span class="form-name"><i class="red">*</i>电子邮箱</span>
                        <input id="email" type="text" placeholder="请填写有效邮箱地址" name="email" />
                        <i class="error"></i>
                    </li>
                    <li>
                        <span class="form-name"><i class="red">*</i>保障时间</span>
                        <div class="select-date">
                            <div class="laydate-icon" id="startDate">请选择</div>
                            <input hidden type="text" class="inputhidden" name="date"></input>
                        </div>
                        至
                        <div class="select-date">
                            2017-1-1
                        </div>
                        <i class="error"></i>
                    </li>
                </ul>
            </div>
            </form>
                <input type="hidden" name="staff_id" value="">
            <div class="popup-footer"><button type="submit" class="btn-00a2ff btn-save">保存</button></div>

        </div>
    </div>
    {{--添加--}}
    <div class="popup popup-batch">
        <div class="popup-bg"></div>
        <div class="popup-wrapper">
            <div class="popup-title">批量增员<i class="iconfont icon-close fr"></i></div>
            <form action="/staff/newlyStaff" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
            <div class="popup-content">
                <ul class="form-wrapper">
                    <li>
                        <span class="form-name"><i class="red">*</i>方案选择</span>
                        <select id="product_name" name="product_name">
                            <option value="" disabled selected>请选择</option>
                            @foreach($products as $k=>$v)
                                <option value="{{$v->ty_product_id}}">{{$v->product_name}}</option>
                            @endforeach
                        </select>
                        <i class="error"></i>
                    </li>
                    <li>
                        <span class="form-name"><i class="red">*</i>保障时间</span>
                        <div class="select-date">
                            <div class="laydate-icon" id="startDatetwo">请选择</div>
                            <input hidden type="text" class="inputhidden" name="date"></input>
                        </div>
                        <i class="error"></i>
                    </li>
                    <li>
                        <span class="form-name">下载模板</span>
                        <button class="btn-00a2ff btn-primary"><a href="" id="url">excel模板</a></button>
                        <i class="error"></i>
                    </li>
                    <li>
                        <span class="form-name"><i class="red">*</i>上传模板</span>
                        <a id="selectFile" class="btn-00a2ff btn-primary">选择文件</a>
                        <input hidden="hidden" type="file" onchange="upload(this);" name="upFile"/>
                        <input id="business" hidden type="text" class="inputhidden" name="file"></input>
                        <i class="error"></i>
                    </li>
                </ul>

            </div>
            <div class="popup-footer"><button type="submit" class="btn-00a2ff btn-save" id="done">上传</button></div>
                <input type="hidden" name="_token" value="{{csrf_token()}}">
            </form>
        </div>
        <input type="hidden" name="type" value="{{$type}}">
    </div>
    @stop
<script src="{{config('view_url.company_url').'js/lib/jquery-1.11.3.min.js'}}"></script>
<script src="{{config('view_url.company_url').'js/lib/laydate.js'}}"></script>
<script src="{{config('view_url.company_url').'js/lib/area.js'}}"></script>
<script src="{{config('view_url.company_url').'js/common.js'}}"></script>
<script>
    var upload = function(e){
        var _this = $(e);
//        console.log(_this);
        var $c = _this.parent().find('input[type=file]')[0];
        var file = $c.files[0],reader = new FileReader();
        reader.readAsDataURL(file);
        reader.onload = function(e){
//            console.log(e.target.result)
            _this.parent().find('.inputhidden').val(e.target.result);
        };
    };
    $(function(){
        var data = $("input[name='type']").val();
        $('.btn-danger').click(function(){
            if(!$('input:checked').length){
                Mask.alert('请选择要拒绝的员工',2)
            }
            var data = new Array();
            data. push($('input:checked').attr('myId'));
            console.log(data);
            $.ajax({
                url:'/staff/passStaff',
                type:'get',
                data:''
            })
        });
        $('#selectFile').click(function(){
            $(this).parent().find('input').click();
        });

        $('.btn-save').click(function(){
            $('.form-wrapper .error').html('');
            if (checkCorrect($('#name'),nameReg)&&checkCorrect($('#idCard'),IdCardReg) &&checkCorrect($('#email'),emailReg)){
                $("#edit_form").submit();
            }


            var mustArry = $('.form-wrapper input');
            mustArry.each(function(){
                checkEmpty(this);
            });
            var selectArry = $('.form-wrapper select');
            selectArry.each(function(){
                checkEmpty(this);
            });
            checkEmpty($('#endDate').parent().find('.inputhidden'));
        });
        $('.del').click(function(){
            var id = $(this).attr('myId');
            $.ajax({
                url:'/staff/passStaff/'+id,
                type:'get',
                data:{data:data},
                succcess:function(res){
                    alert(res.msg);
                    location.reload();
                }
            })
        });

        $('.btn-edite').click(function(){
            var id = $(this).attr('myId');
            var _token = $("input[name='_token']").val();
            $.ajax({
                url:'/staff/edit_person/'+id,
                type:'post',
                data:{_token:_token},
                success:function(res){
                    var product = res.data.order.product.product_name; //保障方案文本
                    var id_type = '身份证'; //证件类型文本
                    $('#product option:contains("'+product+'")').attr('selected', true);
                    $('#id_type option:contains("'+id_type+'")').attr('selected', true);
                    $('#name').val(res.data.name);
                    $('#email').val(res.data.email);
                    $('#idCard').val(res.data.code);
                    console.log(res);
                }
            })
            $("input[name=staff_id]").attr('value',id);
            new Popup('.popup-person');
            $('.form-wrapper .error').html('');
        });

        $('.btn-primary').click(function(){
            new Popup('.popup-batch');
            $('.form-wrapper .error').html('');
        });


        $('#product_name').change(function(){
            var id = $('#product_name').val();
            $.ajax({
                url:'/staff/get_url/'+id,
                type:'get',
                data:{},
                success:function(res){
                    var url = "{{ env('TY_API_PRODUCT_SERVICE_URL').'/'}}" + res;
                    $('#url').attr('href',url);
                }
            })
        })
        {{--$('#done').click(function(){--}}
            {{--var data = $('form').serializeArray();--}}
            {{--$.ajax({--}}
                {{--url:"{{url('/staff/newlyStaff')}}",--}}
                {{--type:"POST",--}}
                {{--data:data,--}}
                {{--success:function(res){--}}
                    {{--if (res['status'] == 200){--}}
                        {{--alert(res['msg']);--}}
                        {{--location.reload();--}}
                    {{--}else{--}}
                        {{--alert(res['msg']);--}}
                    {{--}--}}
                {{--}--}}
            {{--});--}}
        {{--});--}}
    });
    setTimeout(function(){
        laydate({
            elem: '#startDate',
            choose: function(datas) {
    //            console.log(datas)
                $('#startDate').parent().find('.inputhidden').val(datas)
            }
        });
    },1000);
    setTimeout(function(){
        laydate({
            elem: '#startDatetwo',
            choose: function(datas) {
                console.log(datas)
                $('#startDatetwo').parent().find('.inputhidden').val(datas)
            }
        });
    },2000);


</script>