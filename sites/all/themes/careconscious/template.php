<?php

function careconscious_comment_submitted($comment) {
  return t('Submitted by !username',
    array(
      '!username' => theme('username', $comment),
    ));
}

function careconscious_node_submitted($node){
  return t('Submitted by !username',
    array(
       '!username' => theme('username', $node),
    ));
}

function careconscious_preprocess_user_profile(&$vars){
  $account = $vars['account'];
  $full_name = $account->content->field_first_name_field[0]['view'];
  $vars['xyzzy'] = $full_name;
  $vars['full_name'] = $full_name;
  $vars['profile'] = 'No profile for you!';
  $vars['user_profile'] = 'No profile for you!';
  $vars['my_account'] = $account;
  $account->member_data = content_profile_load('profile_member', $account->uid);
  $account->cp_data = content_profile_load('profile_cp', $account->uid);
  $account->expert_data = content_profile_load('profile_expert', $account->uid);
  drupal_set_title($full_name);
}

function careconscious_preprocess_page(&$vars) {
  if (arg(0) == 'community'){
    $vars['breadcrumb'] = '';
  }
  if (arg(0) == 'node' && $vars['node']->type == 'intro'  && !arg(2)) {
    $vars['body_classes'] .= ' fullscreen';
  }
  if ( arg(0) == 'node' && arg(1) && !arg(2) && $vars['node']->type == 'webform') {
    $vars['title'] = '';
  }
  if (arg(0) == 'user' && is_numeric(arg(1)) && arg(2) == 'todos' && is_numeric(arg(3))) {
    $vars['help'] = substr($vars['help'], 0, -6) . 
                      '<span class="send_node">' . 
                        l(t('Email to a friend'), 'send/send_node/' . arg(3),
                          array('attributes' => array('class' => 'send-link send-send_node'))) .
                      '</span></div>';
  }
}

function phptemplate_breadcrumb($breadcrumb){
  if (arg(0) != 'node' || !is_numeric(arg(1)) || (!$node = db_result(db_query('SELECT n.type FROM {node} n WHERE n.nid = %d', arg(1)))) || $node != 'resource') {
    return false;
  }
  $links = array();
  
  $links[] = l(t('Back'), '', array('attributes' => array('onclick' => 'javascript:history.back(); return false;')));
  
  /*
  $path = '';

  // Get URL arguments
  $arguments = explode('/', request_uri());

  // Remove empty values
  foreach ($arguments as $key => $value) {
    if (empty($value)) {
      unset($arguments[$key]);
    }
  }
  $arguments = array_values($arguments);

  // Add 'Home' link
  $links[] = l(t('Home'), '<front>');

  // Add other links
  if (!empty($arguments)) {
    foreach ($arguments as $key => $value) {
      // Don't make last breadcrumb a link
      
      if ($key == (count($arguments) - 1)) {
        $links[] = t(drupal_get_title());
      } else {
        if ($value == 'content')
          continue;
        if (!empty($path)) {
          $path .= '/'. $value;
        } else {
          $path .= $value;
        }
        $links[] = l(t(drupal_ucfirst($value)), $path);
      }
    }
  }
  */

  // Set custom breadcrumbs
  drupal_set_breadcrumb($links);

  // Get custom breadcrumbs
  $breadcrumb = drupal_get_breadcrumb();

  // Hide breadcrumbs if only 'Home' exists
  
  return '<div class="breadcrumb">'. implode(' &raquo; ', $breadcrumb) .'</div>';
}

function careconscious_preprocess_node(&$vars) {
  if ($vars['type'] == 'resource') {
    $vars['node']->links[''] = array(
      'title' => l('', '', array('attributes' => array('onclick' => 'window.history.back(); return false;'))),
      'html' => true
    );
    
    $vars['links'] = theme_links($vars['node']->links, $attributes = array('class' => 'links'));
  }
}

function phptemplate_preprocess_page(&$vars) {  
  if (arg(0) !== 'node') return;
  
  $vars['body_classes'] .= ' ' .
      preg_replace('![^abcdefghijklmnopqrstuvwxyz0-9-_]+!s', '',
                   'node-nid-'. form_clean_id(drupal_strtolower(arg(1))));
}

function careconscious_preprocess_views_view(&$vars) {
  if (isset($vars['view']->name)) {
    $function = 'careconscious_preprocess_views_view__'.$vars['view']->name; 
    if (function_exists($function)) {
     $function($vars);
    }
  }
} 

function careconscious_preprocess_views_view__resources(&$vars) {
 
}