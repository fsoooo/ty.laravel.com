<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>天眼互联-科技让保险无限可能</title>
    <meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
    <link rel="stylesheet" href="{{config('view_url.mobile_group_ins')}}css/lib/mui.min.css">
    <link rel="stylesheet" href="{{config('view_url.mobile_group_ins')}}css/lib/mui.picker.all.css" />
    <link rel="stylesheet" href="{{config('view_url.mobile_group_ins')}}css/lib/iconfont.css" />
    <link rel="stylesheet" href="{{config('view_url.mobile_group_ins')}}css/common.css" />
    <style>
        body {background: #fff;}
        .mui-scroll-wrapper {top: .8rem;bottom: .8rem;}
        .mui-bar-nav {background: #025a8d;}
        .mui-icon-back,.mui-title {color: rgba(255, 255, 255, .8);}
        .applicant-wrapper {background: #fff;margin-bottom: .8rem;padding-bottom: .3rem;}
        .applicant-wrapper ul {padding: 0 .3rem;}
        .applicant-wrapper li {height: 1rem;line-height: 1rem;position: relative;border-bottom: 1px solid #dcdcdc;}
        .applicant-wrapper li .iconfont {position: absolute;top: 0;right: 0;z-index: 1;font-size: .36rem;color: #00a2ff;}
        .applicant-partone li:last-child {border-bottom: none;}
        .applicant-wrapper li input {padding-left: 1.85rem;font-size: .28rem;border: none;}
        .name {position: absolute;top: 0;left: 0;font-size: .28rem;color: #313131;}
        .applicant-wrapper li.mui-table-view-cell {border-bottom: none;}
        .mui-table-view-cell:after {background: none;}
        .mui-scroll-wrapper {top: .9rem;bottom: .98rem;}
        .applicant-parttwo li:last-child {border-bottom: none;}
        .applicant-info p{padding: 0 .3rem;margin: .16rem 0;font-size: .24rem;color: #ADADAD;}
        /*信息提交成功*/
        .payment-header {
            padding: 3.5rem 0 .54rem;
            background: #fff;
            text-align: center;
            color: #FFAE00;
            font-size: .32rem;
        }
        .payment-header>i {
            margin-bottom: .3rem;
            font-size: 1.45rem;
        }
        .payment-header>p {
            margin-top: .2rem;
        }
        .submit-btn{
            color: #fff;
        }
        .labelstyle{
            padding-left: 2rem;
        }
        .z-btn-hollow{
            margin-right: .3rem;
        }
        .z-btn-selected{
            border: 1px solid #ccc;
            padding: .15rem .3rem;
            border-radius: 19%;
        }
        .selected{
            color: #00A2FF;
            border-color: #00A2FF;
        }
    </style>
</head>

<body>
<div class="main">
    <header class="mui-bar mui-bar-nav">
        <a class="mui-icon mui-icon-back mui-pull-left mui-action-back"></a>
        <h1 class="mui-title">被保人信息填写</h1>
    </header>
    <div class="mui-content">
            <div class="mui-scroll-wrapper">
                <div class="mui-scroll">
                    <div class="payment-header" style="display: none;">
                        <i class="iconfont icon-chenggong2"></i>
                        <p>信息提交成功</p>
                    </div>
                </div>
            </div>
            <div class="buttonbox">
                <button class="btn submit-btn" disabled="disabled">提交信息</button>
            </div>
    </div>
</div>

<script src="{{config('view_url.mobile_group_ins')}}js/lib/jquery-1.11.3.min.js"></script>
<script src="{{config('view_url.mobile_group_ins')}}js/lib/mui.min.js"></script>
<script src="{{config('view_url.mobile_group_ins')}}js/common.js"></script>
<script src="{{config('view_url.mobile_group_ins')}}js/preview.js"></script>
<script src="{{config('view_url.mobile_group_ins')}}js/lib/mui.picker.all.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">
    $('.payment-header').show();
    $('.buttonbox').hide();


</script>
</body>

</html>