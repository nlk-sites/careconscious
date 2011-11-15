jQuery(function($){
  Drupal.behaviors.ajax_popup = function(context){
		var ajax_popup = $('a.ajax_popup', context);
		if (!ajax_popup.data('flag')) {
			ajax_popup.data('flag', true).click(function() { 
				var _this = $(this);
        ajax_popup_load(true, _this.attr('rel'), function(_ajax_popup) {
          if (_ajax_popup.find('form').length) {
            _ajax_popup.find('form input[type="submit"]').click(function() {
              var _submit = $(this);
              $('.body', _ajax_popup).append('<div class="overlay"/>');
              _submit.parents('form').submit(function(){
                var _form_values = $(this).serialize();
                _form_values = _form_values +'&op='+ _submit.attr('value');
                $.post(Drupal.settings.basePath +'ajax_popup/submit', _form_values, function(datas){
                  if (datas.status) {
                    if (datas.redirect) {
                      var _href = window.location.protocol +'//'+ window.location.host + datas.redirect;
                      window.location.href = _href;
                    }
                    if (datas.data) {
                      ajax_popup_load(null, datas);
                    }
                  } else {
                    ajax_popup_hide();
                  }
                });
                return false;
              });
            });
          }
        });
        return false;
			});
		}
    var ajax_popup_hiding = $('#popup_overlay', context);
    if (!ajax_popup_hiding.data('flag')) {
			ajax_popup_hiding.data('flag', true).click(function() { 
				ajax_popup_hide();
        return false;
			});
		}
	}
	
	Drupal.attachBehaviors($('body'));
});

function ajax_popup_load(ajax, params, callback) {
  var w = $(window);
	$('#ajax_popup').remove();
	jQuery(Drupal.settings.ajax_popup_box).appendTo('body');
	var a = $('#ajax_popup'),
      b = $('.content', a);
	$('.header span', a).click(function(){
		ajax_popup_hide();
	});
	a.css({ top: (((w.height()/2)-a.height()/2)), left: w.width() / 2 - (a.width() / 2) })
	.fadeIn('normal');
	popup_view = function (datas){
		if (datas.status){
			$('.header h1', a).html(datas.title);
			b.append(datas.data);
		}
		if (callback) callback(a);
		b.css({ width: 'auto', height: 'auto'}).removeClass('process_load').fadeIn('fast');
		a.css({ left: w.width() / 2 - b.width() / 2, top: (((w.height()/2)-a.height()/2)) });
	}
	if (ajax) {
		$.post(Drupal.settings.basePath +'ajax_popup/form', params, popup_view);
	} else {
		popup_view(params);
  }
}

function ajax_popup_hide(){
	$('#ajax_popup').fadeOut('normal');
}