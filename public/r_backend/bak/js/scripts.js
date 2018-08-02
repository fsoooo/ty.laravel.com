$(function($){setTimeout(function(){$('#content-wrapper > .row').css({opacity:1});},200);$('#sidebar-nav .dropdown-toggle').on('click',function(e){e.preventDefault();var $item=$(this).parent();if(!$item.hasClass('open')){$item.parent().find('.open .submenu').slideUp('fast');$item.parent().find('.open').toggleClass('open');}
$item.toggleClass('open');if($item.hasClass('open')){$item.children('.submenu').slideDown('fast');}
else{$item.children('.submenu').slideUp('fast');}});$('body').on('mouseenter','#page-wrapper.nav-small #sidebar-nav .dropdown-toggle',function(e){var $sidebar=$(this).parents('#sidebar-nav');if($(document).width()>=992){var $item=$(this).parent();$item.addClass('open');$item.children('.submenu').slideDown('fast');}});$('body').on('mouseleave','#page-wrapper.nav-small #sidebar-nav > .nav-pills > li',function(e){var $sidebar=$(this).parents('#sidebar-nav');if($(document).width()>=992){var $item=$(this);if($item.hasClass('open')){$item.find('.open .submenu').slideUp('fast');$item.find('.open').removeClass('open');$item.children('.submenu').slideUp('fast');}
$item.removeClass('open');}});$('#make-small-nav').click(function(e){$('#page-wrapper').toggleClass('nav-small');});$(window).smartresize(function(){if($(document).width()<=991){$('#page-wrapper').removeClass('nav-small');}});$('.mobile-search').click(function(e){e.preventDefault();$('.mobile-search').addClass('active');$('.mobile-search form input.form-control').focus();});$(document).mouseup(function(e){var container=$('.mobile-search');if(!container.is(e.target)&&container.has(e.target).length===0)
{container.removeClass('active');}});$('.fixed-leftmenu #col-left').nanoScroller({alwaysVisible:true,iOSNativeScrolling:false,preventPageScrolling:true,contentClass:'col-left-nano-content'});$("[data-toggle='tooltip']").each(function(index,el){$(el).tooltip({placement:$(this).data("placement")||'top'});});});$.fn.removeClassPrefix=function(prefix){this.each(function(i,el){var classes=el.className.split(" ").filter(function(c){return c.lastIndexOf(prefix,0)!==0;});el.className=classes.join(" ");});return this;};(function($,sr){var debounce=function(func,threshold,execAsap){var timeout;return function debounced(){var obj=this,args=arguments;function delayed(){if(!execAsap)
func.apply(obj,args);timeout=null;};if(timeout)
clearTimeout(timeout);else if(execAsap)
func.apply(obj,args);timeout=setTimeout(delayed,threshold||100);};}
jQuery.fn[sr]=function(fn){return fn?this.bind('resize',debounce(fn)):this.trigger(sr);};})(jQuery,'smartresize');



(function () {
    $('.table-responsive .iconfont').click(function () {
        var $this = $(this);
        var $input = $(this).parent().find('input');

        var status = $input.prop('checked');
        $input.prop('checked',!status)
        if(status){
            $this.removeClass('icon-radio-checked').addClass('icon-danxuan').css({'color':'#313131'})
        }else{
            $this.removeClass('icon-danxuan').addClass('icon-radio-checked').css({'color':'#7c2afd'})
        }
    });
    $('#btn-select').click(function () {
        var $input = $(this).parent().find('input');
        var status = $input.prop('checked');
        console.log(status)
        $input.prop('checked',!status);
        var ch=document.getElementsByName("choose");
        if(!status){
            for(var i=0;i<ch.length;i++)
            {
                ch[i].checked=true;
                $('.table-responsive .iconfont').removeClass('icon-danxuan').addClass('icon-radio-checked').css({'color':'#7c2afd'})
            }
        }else{
            for(var i=0;i<ch.length;i++)
            {
                ch[i].checked=false;
                $('.table-responsive .iconfont').removeClass('icon-radio-checked').addClass('icon-danxuan').css({'color':'#313131'})
            }
        }
    });
    var emailHeight = $('#email-box').height();
    console.log(emailHeight);
    var navHeight = $('#nav-col').height();
    if(emailHeight>navHeight){
        $('#nav-col').css({'height':emailHeight+35+'px'})
    }else{
        $('#email-box').css({'height':navHeight+'px'})
    }

    $('.main-box').css({'minHeight':890+'px'})

    // 左侧导航高度设置
    var height = document.documentElement.clientHeight || document.body.clientHeight;
    $('#col-left-inner').css({"height":height-80+'px'});





})()


