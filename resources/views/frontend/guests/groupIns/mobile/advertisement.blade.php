<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>天眼互联-科技让保险无限可能</title>
    <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
    <link rel="stylesheet" href="{{config('view_url.mobile_group_ins')}}css/common.css" />
    <link rel="stylesheet" href="{{config('view_url.mobile_group_ins')}}css/tiaoguo.css" />
    <style type="text/css">
        body{
            background: #fff;
        }
        .notfound{margin: 2.5rem auto .4rem;width: 60%;position: relative;}
        .text-wrapper{font-size: .36rem;line-height: .38rem;text-align: center;}
        .text-wrapper p{
            margin: .3rem 0;
        }
        .btn-return{
            margin-top: 1.5rem;
            padding: .15rem .3rem;
            background: #00A2FF;
            border: 1px solid #00A2FF;
            border-radius: 5px;
            color: #fff;
            text-align: center;
        }
    </style>
</head>

<body>
<div class="notfound">
    <img src="{{config('view_url.mobile_group_ins')}}image/广告业_03.png"/>
    <div class="circleProgress_wrapper">跳过
        <div class="wrapper right">
            <div class="circleProgress rightcircle"></div>
        </div>
        <div class="wrapper left">
            <div class="circleProgress leftcircle"></div>
        </div>
    </div>
</div>

<div class="text-wrapper">
    <p>保险小白，没时间和经验？</p>
    <p>天眼互联，带你走向保险的新时代</p>
    <button class="btn-return">马上参与</button>
</div>
<script src="{{config('view_url.mobile_group_ins')}}js/lib/jquery-1.11.3.min.js"></script>
<script src="{{config('view_url.mobile_group_ins')}}js/lib/mui.min.js"></script>
<script src="{{config('view_url.mobile_group_ins')}}js/common.js"></script>
<script type="text/javascript">
    $('.circleProgress_wrapper ').click(function(){
        location.href="/ins/add_beibaoren_info/"+{{$identification}}
    });
    $('.btn-return').click(function(){
        location.href="/ins/add_beibaoren_info/"+{{$identification}}
    });
</script>
</body>
</html>