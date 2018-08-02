<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <link rel="stylesheet" href="{{url('r_frontend/product/cyt/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{url('r_frontend/product/cyt/css/product_list.blade.css')}}">
    <script src="{{url('r_frontend/product/cyt/js/jquery-3.2.1.min.js')}}"></script>
    <script src="{{url('r_frontend/product/cyt/js/bootstrap.min.js')}}"></script>
    <style>

    </style>
</head>
<body>
    <div class="box col-md-offset-2 col-md-8" style="position: relative;">
        <div class="logo col-md-3 ">
            <img src="./img/1.jpg" alt="">
        </div>
        <div class="title col-md-5">
            中国人寿中国人寿中国人寿中国人寿中国人寿
        </div>
        <div class="content_fa col-md-8" style="float: right">
            @foreach($data as $v)
            <div class="content col-md-6">
                <div class="argument col-md-3">
                    {{$v->product_name}}：
                </div>
                <div class="value col-md-6" style="margin-top: 5px">
                    14-23
                </div>
                {{--@foreach($isNot as $kk=>$vv)--}}
                    {{--@if($v->product_name==$kk && $v->)--}}
                <div class="sign glyphicon glyphicon-ok col-md-2" style="margin-top: 5px"></div>
            </div>
            @endforeach
        </div>
    </div>
</body>
</html>