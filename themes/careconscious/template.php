<?php

function careconscious_comment_submitted($comment) {
  return t('Submitted by !username',
    array(
      '!username' => theme('username', $comment),
    ));
}

function careconscious_node_submitted($node){
  if ($node->field_anon[0][value]) {
    return 'Submitted by Anonymous';
  } else {
    return t('Submitted by !username',
      array(
         '!username' => theme('username', $node),
       ));
  }
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
  if (arg(0) == 'node' && arg(1) == '146') {
    $vars['body_classes'] .= ' fullscreen';
  }
}

