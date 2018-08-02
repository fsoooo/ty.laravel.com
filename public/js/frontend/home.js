/**
 * Created by dell01 on 2017/6/16.
 */


$(function(){

    $(window).scroll(function(){
        //console.log($(document).scrollTop());
        //判断鼠标滚轮滚动


        var scrollTop = $(document).scrollTop();
        console.log(scrollTop);

        if(scrollTop>100)
        {
            changeTop();
        }else {
            returnTop();
        }

        if(scrollTop>111)
        {
            changeNav();
        }else {
            returnNav();
        }



    })


    //获取参数
    var top = $('.top');
    var logo = $('.logo');
    var top_nav = $('.top-nav');





    var main_nav = $('.main-nav');



    //封装一个方法，用来修改顶部搜索框
    function changeTop()
    {
        top.css('position','fixed');
    }
    //封装一个方法，用来还原顶部搜索框
    function returnTop()
    {
        top.css('position','relation');
    }


    //封装一个方法，修改导航条
    function changeNav()
    {
        //主体部分导航消失
        main_nav.css('display','none');
        //top部分导航显现
        top_nav.css('display','')
        //logo便样式
        logo.css({'width':'50px','top':0});
    }
    //封装一个方法，还原导航条
    function returnNav()
    {
        //主体部分导航显现
        main_nav.css('display','block');
        //top部分导航消失
        top_nav.css('display','none');
        //logo
    }

})

