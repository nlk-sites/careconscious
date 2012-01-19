jQuery(function($) {
	if ( $('#sidebar_second ul.steps').size() > 0 ) {
		$('#content .quicktabs_tabs a').each(function(i) {
			$(this).bind('click' ,function() {
				$('#sidebar_second ul.steps li:eq('+i+')').addClass('on').siblings('.on').removeClass('on');
			});
			if ( $(this).parent().hasClass('active') ) {
				$('#sidebar_second ul.steps li:eq('+i+')').addClass('on');
			}
		});
		$('#sidebar_second ul.steps li').each(function(i) {
			$(this).click(function() {
				$('#content .quicktabs_tabs a:eq('+i+')').trigger('click');
			});
		});
	}
});