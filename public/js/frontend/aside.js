/**
 * Created by dell01 on 2017/7/17.
 */



//底部移动变色
var aside_footer_img = $('.aside-footer-img');
aside_footer_img.click(function () {
    console.log('sdf');
})

$.each(aside_footer_img,function(i,item){




    $(item).click(function(){
        console.log('sdf');
        $(this).css('background-color','blue');
    })
});