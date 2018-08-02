<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <link rel="stylesheet" href="{{ url('r_frontend/product/cyt/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{ url('r_frontend/product/cyt/css/fixed_order.css')}}">
    <script src="{{url('r_frontend/product/cyt/js/jquery-3.2.1.min.js')}}"></script>
    <script src="{{url('r_frontend/product/cyt/js/bootstrap.min.js')}}"></script>
    <style>

    </style>
</head>
<body>
    <div class="box col-md-6 col-md-offset-2">
        <div class="top col-md-12">
            <div class="top_left col-md-7 ">{{$product['product_name']}}</div>
            <div class="top_right col-md-3 col-md-offset-2">
                <img src="./img/1.jpg" alt="">
            </div>
        </div>
        <div class="underTop col-md-12">
            <div class="underTop_son col-md-3 col-md-offset-1">
                <div class="glyphicon glyphicon-ok">意外健康全覆盖</div>
            </div>
            <div class="underTop_son col-md-3">
                <div class="glyphicon glyphicon-ok">医疗重疾贴心呵护</div>
            </div>
            <div class="underTop_son col-md-3">
                <div class="glyphicon glyphicon-ok">15种少儿保障</div>
            </div>
        </div>
        <form action="/product/prepare_order" method="post">
            <div class="middle col-md-12">
                @foreach($parameter as $key=>$value)
                <div class="form-group">
                    @if($key=='_token'||$key=='product_id')
                        @else
                    <label  class="title col-sm-2 control-label">{{$key}}</label>
                    <input type="text" class="checked" disabled value="{{$value}}" name="fangan">
                    @endif
                </div>
                @endforeach
            </div>
            <div class="money col-md-12">
                保费：{{$tari}}
            </div>
            <input type="hidden" name="product_id" value="{{$parameter['product_id']}}">
            {{ csrf_field() }}
            <input type="submit" class="col-md-3 go">
        </form>
        <script>
            $(document).ready(function(){
                var data={};
                $("form").submit(function(){
                    $('input').each(function(i,item){
                        if ($(item).hasClass('checked')){
                            data[$(item).attr('name')]=$(item).val();
                        }
                    });
                    $.ajax({
                        url:'ajax.php?action=ok',
                        type:'post',
                        data:data,
                        async : false,
                        success: function(data){
                            $("#user_id").val(data);
                        }
                    });
                });
            })
        </script>

    </div>
</body>
</html>