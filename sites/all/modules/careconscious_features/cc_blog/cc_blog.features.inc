<?php

/**
 * Implementation of hook_ctools_plugin_api().
 */
function cc_blog_ctools_plugin_api() {
  list($module, $api) = func_get_args();
  if ($module == "context" && $api == "context") {
    return array("version" => 3);
  }
}

/**
 * Implementation of hook_node_info().
 */
function cc_blog_node_info() {
  $items = array(
    'blog' => array(
      'name' => t('Blog Post'),
      'module' => 'features',
      'description' => '',
      'has_title' => '1',
      'title_label' => t('Title'),
      'has_body' => '1',
      'body_label' => t('Body'),
      'min_word_count' => '0',
      'help' => '',
    ),
  );
  return $items;
}

/**
 * Implementation of hook_views_api().
 */
function cc_blog_views_api() {
  return array(
    'api' => '2',
  );
}
