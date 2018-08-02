$(function(){
	
	$(".modal-label .modal-body").panel({iWheelStep:32});
	
	// 切换标签组
	$('.label-section span').click(function(){
		$(this).addClass('active').siblings().removeClass('active');
	})
	
	// 标签按钮是否可用
	$('.label-bottom input').bind('input propertychange', function() { 
		$('#addLabel')[0].disabled = !$(this).val();
	});
	
	// 删除标签
	$('.label-middle .icon-quxiao').click(function(){
		$(this).parent().remove();
	});
	
	// 编辑标签组
	$('#editGroup').click(function(){
		$('.modal-label').modal('show');
	});
	
	$('#addGroup').click(function(){
		var index = $('.modal-body li').length + 1; // 添加组的索引
		var html = '<li><span class="name">标签组'+ index +'：</span><input type="text" value="" maxlength="10"><button type="button" class="btn btn-default">删除组</button></li>';
		$('.group-wrapper').append(html);
		delGroup(); 
	});
	
	// 删除组事件
	function delGroup(){
		$('.group-wrapper .btn').click(function(){
			var curindex = $(this).parent().find('.name').text().match(/\d/)[0]; // 当前组的索引
			
			$(this).parent().nextAll().each(function(){
				$(this).find('.name').text('标签组' + curindex++ + '：')
			});
			
			$(this).parent().remove();
		});
	}
	
});


