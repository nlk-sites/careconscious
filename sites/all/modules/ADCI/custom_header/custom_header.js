(function() {
  var custom_header_flag = 0;
  function custom_header_init() {
    if (custom_header_flag) return;
    
    var 
      button = $("#admin-menu li > a[href=" + Drupal.settings.custom_header.admin_menu + "]");
    
    button.attr('rel', Drupal.settings.custom_header.admin_menu_query);
    button.addClass('ajax_popup');
    
    if (button.length)
    custom_header_flag = 1;
  }
  
  Drupal.behaviors.custom_header = custom_header_init;
})();