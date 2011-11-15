<?php

function custom_header_admin_settings() {
  $form = array();
  
  $form = system_settings_form($form);  $form['#submit'][] = 'custom_header_admin_settings_submit';
  return $form;
}function custom_header_admin_settings_submit($form, $form_state) {  }