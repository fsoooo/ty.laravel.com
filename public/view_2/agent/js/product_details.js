
$('.evaluate-right .z-btn:gt(7)').hide();

// 查看保障权益详情
$('.equity-list .more').click(function(){
	$(this).toggleClass('unfold');
	if($(this).hasClass('unfold')){
		var html = '收起<i class="iconfont icon-zhankai"></i>';
		$(this).html(html).parent().next().show();
		
	}else{
		var html = '查看详情<i class="iconfont icon-gengduo"></i>';
		$(this).html(html).parent().next().hide();
	}
});

// 查看更多评价标签
$('#moreLabel').click(function(){
	$(this).toggleClass('fold');
	
	if($(this).hasClass('fold')){
		$(this).removeClass('icon-gengduo').addClass('icon-shangla');
		$('.evaluate-right .z-btn:gt(7)').show();
	}else{
		$(this).removeClass('icon-shangla').addClass('icon-gengduo');
		
		$('.evaluate-right .z-btn:gt(7)').hide();
	}
	
});

// 查看全部评价
$('.evaluate-wrapper .fold').click(function(){
	$(this).hide();
	$('.evaluate-list').hide();
	$('.evaluate-all .more').show();
})

$('.evaluate-all .more').click(function(){
	$(this).hide();
	$('.fold').show();
	$('.evaluate-list').show();
});

// 发送给客户
$('#sendToCustomer').click(function(){
	Popups.open('.popups-way',function(){
		$('#email').val('').parent().hide();
	});
	$('#sendEmail').click(function(){
		Popups.open('.popups-success');
		Popups.close('.popups-way');
	});
});
$('.icon-youxiang').click(function(){
	$('.way-email').show();
});
$('input').bind('input propertychange', function() {
    if(emailReg.test($('#email').val())){
    		$('#sendEmail').prop('disabled',false);
    }else{
    		$('#sendEmail').prop('disabled',true);
    }
});