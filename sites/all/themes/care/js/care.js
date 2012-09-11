jQuery(function($) {
	if ( $('#user-login-form').size() > 0 ) {
		var ac = $('#user-login-form').attr('action');
		ac = ac.substr(0,ac.lastIndexOf('?destination='));
		$('#user-login-form').attr('action', ac );
		
		if ( ( $('#sidebar_second .messages').size() > 0 ) && ( $('#quicktabs_tabpage_register_login_1').size() > 0 ) ) {
			$('#sidebar_second .messages').prependTo('#user-login-form');
			$('#quicktabs-tab-register_login-1').click();
		}
	}
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

 $(window).load(function(){
    $('#block-block-56').sticky({ topSpacing: 25 });
    $('#block-block-61').sticky({ topSpacing: 25 });
  });