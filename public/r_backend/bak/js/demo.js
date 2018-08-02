$(function($){var storage,fail,uid;try{uid=new Date;(storage=window.localStorage).setItem(uid,uid);fail=storage.getItem(uid)!=uid;storage.removeItem(uid);fail&&(storage=false);}catch(e){}
if(storage){try{var usedSkin=localStorage.getItem('config-skin');if(usedSkin!=''){$('#skin-colors .skin-changer').removeClass('active');$('#skin-colors .skin-changer[data-skin="'+usedSkin+'"]').addClass('active');}
var fixedHeader=localStorage.getItem('config-fixed-header');if(fixedHeader=='fixed-header'){$('body').addClass(fixedHeader);$('#config-fixed-header').prop('checked',true);}
var fixedFooter=localStorage.getItem('config-fixed-footer');if(fixedFooter=='fixed-footer'){$('body').addClass(fixedFooter);$('#config-fixed-footer').prop('checked',true);}
var boxedLayout=localStorage.getItem('config-boxed-layout');if(boxedLayout=='boxed-layout'){$('body').addClass(boxedLayout);$('#config-boxed-layout').prop('checked',true);}
var rtlLayout=localStorage.getItem('config-rtl-layout');if(rtlLayout=='rtl'){$('body').addClass(rtlLayout);$('#config-rtl-layout').prop('checked',true);}
var fixedLeftmenu=localStorage.getItem('config-fixed-leftmenu');if(fixedLeftmenu=='fixed-leftmenu'){$('body').addClass(fixedLeftmenu);$('#config-fixed-sidebar').prop('checked',true);if($('#page-wrapper').hasClass('nav-small')){$('#page-wrapper').removeClass('nav-small');}
$('.fixed-leftmenu #col-left').nanoScroller({alwaysVisible:true,iOSNativeScrolling:false,preventPageScrolling:true,contentClass:'col-left-nano-content'});}}
catch(e){console.log(e);}}
$('#config-tool-cog').on('click',function(){$('#config-tool').toggleClass('closed');});$('#config-fixed-header').on('change',function(){var fixedHeader='';if($(this).is(':checked')){$('body').addClass('fixed-header');fixedHeader='fixed-header';}
else{$('body').removeClass('fixed-header');if($('#config-fixed-sidebar').is(':checked')){$('#config-fixed-sidebar').prop('checked',false);$('#config-fixed-sidebar').trigger('change');location.reload();}}
writeStorage(storage,'config-fixed-header',fixedHeader);});$('#config-fixed-footer').on('change',function(){var fixedFooter='';if($(this).is(':checked')){$('body').addClass('fixed-footer');fixedFooter='fixed-footer';}
else{$('body').removeClass('fixed-footer');}
writeStorage(storage,'config-fixed-footer',fixedFooter);});$('#config-boxed-layout').on('change',function(){var boxedLayout='';if($(this).is(':checked')){$('body').addClass('boxed-layout');boxedLayout='boxed-layout';}
else{$('body').removeClass('boxed-layout');}
writeStorage(storage,'config-boxed-layout',boxedLayout);});$('#config-rtl-layout').on('change',function(){var rtlLayout='';if($(this).is(':checked')){rtlLayout='rtl';}
else{}
writeStorage(storage,'config-rtl-layout',rtlLayout);location.reload();});$('#config-fixed-sidebar').on('change',function(){var fixedSidebar='';if($(this).is(':checked')){if(!$('#config-fixed-header').is(':checked')){$('#config-fixed-header').prop('checked',true);$('#config-fixed-header').trigger('change');}
if($('#page-wrapper').hasClass('nav-small')){$('#page-wrapper').removeClass('nav-small');}
$('body').addClass('fixed-leftmenu');fixedSidebar='fixed-leftmenu';$('.fixed-leftmenu #col-left').nanoScroller({alwaysVisible:true,iOSNativeScrolling:false,preventPageScrolling:true,contentClass:'col-left-nano-content'});writeStorage(storage,'config-fixed-leftmenu',fixedSidebar);}
else{$('body').removeClass('fixed-leftmenu');writeStorage(storage,'config-fixed-leftmenu',fixedSidebar);location.reload();}});if(!storage){$('#config-fixed-header').prop('checked',false);$('#config-fixed-footer').prop('checked',false);$('#config-fixed-sidebar').prop('checked',false);$('#config-boxed-layout').prop('checked',false);$('#config-rtl-layout').prop('checked',false);}
$('#skin-colors .skin-changer').on('click',function(){$('body').removeClassPrefix('theme-');$('body').addClass($(this).data('skin'));$('#skin-colors .skin-changer').removeClass('active');$(this).addClass('active');writeStorage(storage,'config-skin',$(this).data('skin'));});});function writeStorage(storage,key,value){if(storage){try{localStorage.setItem(key,value);}
catch(e){console.log(e);}}}
$.fn.removeClassPrefix=function(prefix){this.each(function(i,el){var classes=el.className.split(" ").filter(function(c){return c.lastIndexOf(prefix,0)!==0;});el.className=classes.join(" ");});return this;};


var agentColors = ['#5793f3', '#dadada', '#675bba'];
// 代理活跃人数折线图
agentOption = {
    title: {
        text: '代理活跃人数',
        textStyle: {
            fontWeight : 'normal'
        }
    },
    color: agentColors,
    tooltip: {
        trigger: 'none',
        axisPointer: {
            type: 'cross'
        }
    },
    xAxis: [{
            type: 'category',
            axisTick: {
                alignWithLabel: true
            },
            axisLine: {
                onZero: false,
                lineStyle: {
                    color: agentColors[1]
                }
            },
            axisPointer: {
                label: {
                    formatter: function(params) {
                        return '月份  ' + params.value +
                            (params.seriesData.length ? '：' + params.seriesData[0].data : '');
                    }
                }
            },
            data: ["一月", "二月", "三月", "四月", "五月", "六月"]
        },
        {
            axisLine: {
                onZero: false,
                lineStyle: {
                    color: agentColors[1]
                }
            },
            data: []
        }
    ],
    yAxis: [{
        type: 'value',
        min: 0,
        max: 8000,
        axisLine: {
            onZero: false,
            lineStyle: {
                color: agentColors[1]
            }
        },

    }],
    series: [{
        name: '代理活跃人数',
        type: 'line',
        xAxisIndex: 1,
        smooth: true,
        data: [4000, 3880, 3600, 5000, 6000, 5600]
    }
    ]
};
var agentChart = echarts.init(document.getElementById('agent'));
agentChart.setOption(agentOption);

// 人均保费额柱状图
premiumAmountOption = {
    title: {
        text: '人均保费额',
        textStyle: {
            fontWeight : 'normal'
        }
    },
    color: ['#3398DB'],
    tooltip : {
        trigger: 'axis',
        axisPointer : {
            type : 'shadow'
        }
    },
    grid: {
        left: '3%',
        right: '4%',
        bottom: '3%',
        containLabel: true
    },
    xAxis : [
        {
            type : 'category',
            data : ['一月', '二月', '三月', '四月', '五月', '六月', '七月','八月'],
            axisTick: {
                alignWithLabel: true
            },
            axisLine: {
                onZero: false,
                lineStyle: {
                    color: agentColors[1]
                }
            },
        }
    ],
    yAxis : [
        {
            type : 'value',
            min: 0,
            max: 80,
            axisLine: {
                onZero: false,
                lineStyle: {
                    color: agentColors[1]
                }
            }
        }
    ],
    series : [
        {
            name:'人均保费额',
            type:'bar',
            barWidth: '10%',
            data:[10, 52, 20, 33, 39, 33, 20,33]
        }
    ]
};

var premiumAmountChart = echarts.init(document.getElementById('premiumAmount'));
premiumAmountChart.setOption(premiumAmountOption);

// 佣金管理饼图
commissionOption = {
    title: {
        text: '佣金管理',
        textStyle: {
            fontWeight : 'normal'
        }
    },
    color: ['#7ed321', '#a800ff', '#f93771', '#42e1f1'],
    legend: {
        orient: 'vertical',
        x: 'right',
        left: '60%',
        top : 'middle',
        data: ['上周末结转佣金', '本周佣金总额', '上周已结转佣金', '本月已结转佣金']
    },
    series: [

        {
            name: '佣金管理',
            type: 'pie',
            radius: ['50%', '54%'],
            center: ['30%', '50%'],
            avoidLabelOverlap: false,
            label: {
                normal: {
                    show: false,
                    position: 'center'
                },
                emphasis: {
                    show: true,
                    textStyle: {
                        fontSize: '30',
                        fontWeight: 'bold'
                    }
                }
            },
            labelLine: {
                normal: {
                    show: false
                }
            },
            data: [{
                value: 335,
                name: '上周末结转佣金'
            },
                {
                    value: 310,
                    name: '本周佣金总额'
                },
                {
                    value: 234,
                    name: '上周已结转佣金'
                },
                {
                    value: 135,
                    name: '本月已结转佣金'
                }
            ],
            itemStyle: {
                normal: {
                    label: {
                        show: true,
                        formatter: '{d}%'
                    },
                    labelLine: {
                        show: true
                    }
                }
            }
        }
    ]
};
var commissionChart = echarts.init(document.getElementById('commission'));
commissionChart.setOption(commissionOption);


// var people = 600; // 总人数
// var add = 45; // 新增人数
// $('.total').text(people+'人');
// $('.box').text('新增'+ add +'人');
$('.add').width(add/people * $('.add-wrapper').width());

window.onresize = function () {
    agentChart.resize();
    premiumAmountChart.resize();
}

// json格式转换
function changeJsonData(json, type) {
    var Obj = JSON.parse(json);
    var Arr = [];
    for(item in Obj) {
        var bank = {};
        bank.id = Obj[item].ty_value;
        bank.text = Obj[item].value;
        if(type == "bank"){
            bank.code = Obj[item].code;
        }
        Arr.push(bank)
    }
    console.log(Arr)
    return Arr;
}