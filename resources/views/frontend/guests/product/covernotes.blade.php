@extends('frontend.guests.frontend_layout.policy_base')
<link rel="stylesheet" href="{{ url(config('resource.position.css').'/frontend/product/covernotes.css') }}">
@section('content')
    <div class="main-block">
        <div class="main-left">
            <div class="main-left-inform">
                <span class="cover">投保须知</span>
            </div>
                <div class="relation">
                    <div class="input-block">
                        <p>1.投保前请您仔细阅读：  产品条款   保险金赔付比例   赔偿方式   客户告知书   保单样本   查看费率表</p>
                        <p>2.责任免除、保险责任、犹豫期、费用扣除、退保、保险单现金价值、投保人、被保险人义务等内容详见产品条款， 请务必仔细阅读产品条款及电子保单的特别约定。</p>
                        <p>3.本产品由平安养老保险股份有限公司承保,目前该公司在北京市、上海市、天津市、重庆市、安徽省、福建省、甘肃省、广东省、广西壮族自治区、贵州省、海南省、河北省、河南省、黑龙江省、湖北省、湖南省、吉林省、江苏省、江西省、辽宁省、内蒙古自治区、宁夏回族自治区、青海省、山东省、山西省、陕西省、四川省、新疆维吾尔自治区、云南省、浙江省设有分支机构。本产品仅限深圳地区的客户购买,客户从慧择保险网购买,后续理赔等相关事务均可由慧择保险网协助您办理。</p>
                        <p>4.本产品A款承保出生满30日-5周岁(含30天和5周岁)的幼儿,B款承保6-18周岁(含6和18周岁)身体健康的儿童及各类大、中、小学及中等专业学校全日制在册学生,由其父母或法定监护人作为投保人,保障境内。</p>
                        <p>5.本产品包含15种重大疾病保障,等待期后医院确认被保险人初次罹患条款规定的15种重大疾病给付重大疾病保险金,详见重大疾病说明。</p>
                        <p>6.本产品的少儿重疾有30天的等待期,意外伤害无等待期。</p>
                        <p>7.病毒性肝炎患者、大小三阳及乙肝病毒携带者客户可以投保本产品,但是客户因为上述疾病导致的治疗属于除外责任。</p>
                        <p>8.没有参加深圳少儿医保,医疗费用超过人民币300元部分按60%赔付,已参加深圳少儿医保,在扣除300元次免赔额后按100%进行赔付,赔付金额最高以8万为限。</p>
                        <p>9.本产品仅提供电子保单。</p>
                        <p>10.外籍人士在购买意外险需要为常住中国,至少在中国居住半年以上才可以投保,80%工作时间在中国大陆境内。</p>
                        <p>11.本产品支持全国通赔。</p>
                        <p>12.经天眼互联购买的顾客,若发生保险事故,天眼互联(热线:4006-366-366)将提供协助理赔服务。</p>
                        <p>13.未成年人累计意外身故保额以保监会规定为准。</p>
                    </div>
                </div>
                <div class="policy-confirm">
                    <input type="checkbox" id="check">
                    <span>我已查看并同意 <a href="">投保须知</a></span>
                </div>
                <div class="policy-submit">
                    <input type="submit" value="下一步" onclick="doorder()" style="background-color:#cccccc;" disabled="disabled" id="next">
                </div>
            <div class="policy-submit">
                <input type="submit" value="test下一步" onclick="set_order()">
            </div>
        </div>
    </div>
        <script>
            function  doorder() {
                var identification = "{{$identification}}";
                window.location.href = '/product/insure/'+identification;
            }
            //todo
            function set_order(){
                var identification = "{{$identification}}";
                window.location.href = '/insurance/insure/'+identification;
            }
        </script>
@stop

<script src="/js/jquery-3.1.1.min.js"></script>

<script>
    $(function () {
        $("#check").change(function(){
            test = $("input[type='checkbox']").is(':checked');
            if(test == true){
                $('#next').removeAttr("disabled");
                $("#next").removeAttr("style");
            }else{
                $("#next").css("background-color","#cccccc");
                $("#next").attr("disabled", "disable");
            }
        });
    });

</script>