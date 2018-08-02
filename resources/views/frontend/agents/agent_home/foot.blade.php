<!--公共JS-->

<script>
    //******** start-侧边栏-记录沟通

    $('#record').click(function(){
        $('.popups-handle').show();
    });
    $('.popups-handle .icon-close').click(function(){
        $('.popups-handle').hide();
    })

    // 沟通记录
    $(".table-body").panel({iWheelStep: 32});
    selectData('.select-box','single');// 单选
    check();// 多选
    new TabControl('.popups'); // 选项卡


    $('#addRecord').click(function(){
        if(!isChecked('.client-wrapper')){
            Mask.alert('客户未选择，请选择',2);
        }else if(!isChecked('.product-wrapper')){
            Mask.alert('产品未选择，请选择',2);
        }else if(!$('#details').val()){
            Mask.alert('请输入沟通详情',2);
        }else{
            Popups.close('.popups-handle');
            Popups.open('.popups-success');
        }
    });

    // 客户产品至少各选一项
    function isChecked(ele){
        var status = false;
        $(ele).find('input').each(function(){
            if($(this).prop('checked')){
                status = true;
                return false;
            }
        });
        return status;
    }

    // 评分
    $('.satisfaction-wrapper .iconfont').click(function(){
        $(this).prevAll().addClass('icon-manyi').removeClass('icon-icon-manyidu');
        $(this).addClass('icon-manyi').removeClass('icon-icon-manyidu');
        $(this).nextAll().addClass('icon-icon-manyidu').removeClass('icon-manyi');
        var index = $(this).index();
        $(this).parents('.satisfaction-wrapper').find('.score').text((index+1)+'分');
    });

    // 继续添加记录
    $('.popups-success .z-btn-positive').click(function(){
        $('.popups-success').show();
        $('.popups-handle').hide();
    });

    //******** end-侧边栏-记录沟通
</script>