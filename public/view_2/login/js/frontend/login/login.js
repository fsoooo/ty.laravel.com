/**
 * Created by dell01 on 2017/7/21.
 */

$(function(){
	$('.relevance').eq(1).append($('#hzy_fast_login').children().clone())

    //切换登录方式
    var login_type_btn = $('.login-type li');
    var login_type_block = $('.login-type-block');

    $.each(login_type_btn,function(i,item){
        $(item).click(function(){
            login_type_btn.addClass('login-type-no-choose');
            login_type_btn.removeClass('login-type-choose');
            login_type_btn.eq(i).removeClass('login-type-no-choose');
            login_type_btn.eq(i).addClass('login-type-choose');
            login_type_block.attr('hidden','');
            login_type_block.eq(i).removeAttr('hidden');
        })
    });
    var pattern = $('.pattern');
    $('.pattern').slideToUnlock({
        height : 38,
        width : 298,
        text : '请按住滑块，拖动至最右边',
        succText : '验证通过',
        bgColor : '#eee',
        progressColor : '#00a2ff',//已经拖动的颜色
        succColor : '#00a2ff',  //成功的颜色
        textColor : '#333',     //字体的颜色
        succTextColor : '#fff',  //成功后的字体颜色
        handleColor : '#eee',   //北京颜色
        successFunc : function () {
            pattern.attr('type','1')
        }
    });
    //登录点击验证
    var btn = $('.login-button-input');
    var form = $('.form');

    btn.each(function(i,item){
        $(item).click(function(){
            if(i == 1){ //验证码
                var pattern_val = pattern.attr('type');
                if(pattern_val == 0){
                    Mask.alert('请滑动滑块验证');
                    return false;
                }
            }
            form.eq(i).submit();
        })
    })
})