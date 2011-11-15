$(function(){
  $('.read_more_link').click(function(){
    var a = $(this),
        b = a.hasClass('active'),
        c = a.parents('.read_more').find('.read_more_content');
    if (b) {
      a.removeClass('active').html('Read more >');
      c.slideUp('normal');
    } else {
      a.addClass('active').html('Read less >');
      c.slideDown('normal');
    }
    return false;
  });
  
  if (Drupal.settings.callout) {
    var a = $('p:contains(' + Drupal.settings.callout + ')'),
        b = $('.field-field-callout').hide().clone();
    a.before(b.show());
  }
  $('input.empty').each(function(){
    var _this = $(this);
    empty_field('load', _this);
    
    _this.click(function() {
      empty_field('click', $(this));
    }).focus(function() {
      empty_field('focus', $(this));
    }).blur(function() {
      empty_field('blur', $(this));
    })
  });
});

function empty_field(op, _this) {
  var phrase = _this.attr('data-phrase');
  switch (op) {
    case 'focus' :
    case 'click' :
      if (_this.val() == phrase) {
        _this.val('');
      }
      _this.removeClass('empty');
    break;
    case 'load' :
    case 'blur' :
      if (!_this.val()) {
        _this.addClass('empty').val(phrase);
      }
    break;
  }
}

function join_text() {
  var a = $('.join_text');
  if (a.hasClass('hidden')) {
    a.removeClass('hidden').show();
  } else {
    a.addClass('hidden').hide();
  }
};