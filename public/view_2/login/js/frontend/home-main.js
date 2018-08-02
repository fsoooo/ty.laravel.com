
/**
 * Created by dell01 on 2017/7/20.
 */
$(function(){
    //获取标签
    var main_classify_left_li = $('.main-classify-left li'); //获取分类标签按钮
    var main_classify_right_block = $('.main-classify-right'); //右侧分类快

    $.each(main_classify_left_li,function(i,item){
        $(item).hover(function(){


            main_classify_left_li.addClass('li-no-choose');
            main_classify_left_li.eq(i).removeClass('li-no-choose');
            main_classify_left_li.eq(i).addClass('li-choose');
            main_classify_right_block.attr('hidden','');
            main_classify_right_block.eq(i).removeAttr('hidden');
        })
    })
})