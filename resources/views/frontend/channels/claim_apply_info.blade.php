<!DOCTYPE HTML>
<html>
<head>
<title>理赔应备材料</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=5.0" charset="UTF-8">
<link href="{{config('view_url.channel_url')}}css/service.css" rel="stylesheet"/>
<link href="{{config('view_url.channel_url')}}css/claim.css" rel="stylesheet"/>
    <script src="{{config('view_url.channel_url')}}js/baidu.statistics.js"></script>
</head>
<body style=" background-color:#fff; padding:3rem 0 2rem 0;">
<div class="header">
    	人身保险
        <img src="{{config('view_url.channel_url')}}imges/arrow-left.png" class="arrow-left2" onclick="back();">
        <img src="{{config('view_url.channel_url')}}imges/home.png" class="home" onclick="close_windows();">
</div>
<div style="margin-top: 2rem;">
    <table bgcolor="#FFFFFF" cellpadding="0" cellspacing="0" class="materialTable">
        <tr>
            <td width="33%" align="center" class="ulev-1 t-3 paddingAll border-b border-r">申请类型</td>
            <td width="66%" colspan="2" align="center" class="ulev-1 t-3 paddingAll border-b">应备材料</td>
        </tr>
        <tr>
            <td width="33%" align="center" class="ulev-1 t-3 paddingAll border-b border-r">门诊/住院费用</td>
            <td rowspan="5" width="33%" align="left" class="ulev-1 t-3 paddingAll border-r">
                <p>1、理赔申请书</p>
                <p>2、出险人有效身份证件</p>
                <p>3、出险人银行账户(出险人无法提供账户，请填写受益人账户，未成年人为其法定监护人)</p>
            </td>
            <td width="33%" align="left" class="ulev-1 t-3 paddingAll border-b">
                <p>1、病历/诊断证明/出院小结</p>
                <p>2、发票、费用清单或门诊处方</p>
            </td>
        </tr>
        <tr>
            <td width="33%" align="center" class="ulev-1 t-3 paddingAll border-b border-r">住院补贴</td>
            <td width="33%" align="left" class="ulev-1 t-3 paddingAll border-b">
                <p>诊断证明/出院小结</p>
            </td>
        </tr>
        <tr>
            <td width="33%" align="center" class="ulev-1 t-3 paddingAll border-b border-r">重大疾病</td>
            <td width="33%" align="left" class="ulev-1 t-3 paddingAll border-b">
                <p>1、诊断证明/出院小结</p>
                <p>2、病理报告或其他检查报告</p>
            </td>
        </tr>
        <tr>
            <td width="33%" align="center" class="ulev-1 t-3 paddingAll border-b border-r">身故</td>
            <td width="33%" align="left" class="ulev-1 t-3 paddingAll border-b">
                <p>1、受益人有效身份证件</p>
                <p>2、死亡证明</p>
            </td>
        </tr>
        <tr>
            <td width="33%" align="center" class="ulev-1 t-3 paddingAll border-r">残疾</td>
            <td width="33%" align="left" class="ulev-1 t-3 paddingAll">
                <p>诊断证明/出院小结</p>
            </td>
        </tr>
    </table>
    <p class="w95 ulev-3 t-3 line-height marginAuto">1、有效身份证件指由政府主管部门规定的证明其身份的证件，如：居民身份证、按规定可使用的有效护照、军官证、警官证、士兵证、户口薄等证件。</p>
    <p class="w95 ulev-3 t-3 line-height marginAuto paddingTB2">2、死亡证明材料包括：</p>
    <p class="w95 ulev-1 t-6 line-height marginAuto">(1)国务院卫生行政部门规定的医疗机构、公安部门或其他有权利机构出具的被保险人的死亡证明；</p>
    <p class="w95 ulev-1 t-6 line-height marginAuto paddingTB">(2)若非上述机构出具的死亡证明(如村委会/居委会)，则须同时提供合法有效的户籍注销证明。</p>
    <p class="w95 ulev-3 t-3 line-height marginAuto paddingTB2">3、因意外导致的保险事故，并经由公安机关等有权机构处理的需要提供意外事故证明。</p>
    <br><br>
    <a href="/channelsapi/claim_apply_way" onclick="downLipei();">
        <div class="tel24hour bgRed marginAuto">
            <img src="{{config('view_url.channel_url')}}imges/download.png">
            <span class="t-wh">理赔申请书下载</span>
        </div>
    </a>
</div>
<script src="{{config('view_url.channel_url')}}js/jquery-1.10.2.min.js" type="text/javascript"></script>
<script src="{{config('view_url.channel_url')}}js/main.js" type="text/javascript"></script>
</body>
</html>
