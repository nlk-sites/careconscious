<?php
// $Id: template.php,v 1.16.2.1 2009/02/25 11:47:37 goba Exp $

/**
 * Sets the body-tag class attribute.
 *
 * Adds 'sidebar-left', 'sidebar-right' or 'sidebars' classes as needed.
 */
function phptemplate_body_class($left, $right) {
  if ($left != '' && $right != '') {
    $class = 'sidebars';
  }
  else {
    if ($left != '') {
      $class = 'sidebar-left';
    }
    if ($right != '') {
      $class = 'sidebar-right';
    }
  }

  if (isset($class)) {
    print ' class="'. $class .'"';
  }
}

function phptemplate_comment_post_forbidden($node) {
  global $user;
  static $authenticated_post_comments;

  if (!$user->uid) {
    if (!isset($authenticated_post_comments)) {
      // We only output any link if we are certain, that users get permission
      // to post comments by logging in. We also locally cache this information.
      $authenticated_post_comments = array_key_exists(DRUPAL_AUTHENTICATED_RID, user_roles(TRUE, 'post comments') + user_roles(TRUE, 'post comments without approval'));
    }

    if ($authenticated_post_comments) {
      // We cannot use drupal_get_destination() because these links
      // sometimes appear on /node and taxonomy listing pages.
      if (variable_get('comment_form_location_'. $node->type, COMMENT_FORM_SEPARATE_PAGE) == COMMENT_FORM_SEPARATE_PAGE) {
        $destination = 'destination='. rawurlencode("comment/reply/$node->nid#comment-form");
      }
      else {
        $destination = 'destination='. rawurlencode("node/$node->nid#comment-form");
      }

      if (variable_get('user_register', 1)) {
        // Users can register themselves.
        return t('<a href="@login">Login</a> or <a href="@register">register</a> to get started', array('@login' => url('user/login', array('query' => $destination)), '@register' => url('user/register', array('query' => $destination))));
      }
      else {
        // Only admins can add new users, no public registration.
        return t('<a href="@login">Login</a> to post comments', array('@login' => url('user/login', array('query' => $destination))));
      }
    }
  }
}

/**
 * Return a themed breadcrumb trail.
 *
 * @param $breadcrumb
 *   An array containing the breadcrumb links.
 * @return a string containing the breadcrumb output.
 */
function phptemplate_breadcrumb($breadcrumb) {
  if (!empty($breadcrumb)) {
    return '<div class="breadcrumb">'. implode(' › ', $breadcrumb) .'</div>';
  }
}

/**
 * Allow themable wrapping of all comments.
 */
function phptemplate_comment_wrapper($content, $node) {
  if (!$content || $node->type == 'forum') {
    return '<div id="comments">'. $content .'</div>';
  }
  else {
    return '<div id="comments"><h2 class="comments">'. t('Comments') .'</h2>'. $content .'</div>';
  }
}

/**
 * Override or insert PHPTemplate variables into the templates.
 */
function phptemplate_preprocess_page(&$vars) {
  $vars['tabs2'] = menu_secondary_local_tasks();

  // Hook into color.module
  if (module_exists('color')) {
    _color_page_alter($vars);
  }
  
  if ( ( arg(0) == 'user' ) && ( $vars['title'] != 'User account' ) ) {
	$vars['title'] = 'Your Account: '. $vars['title'];  
  }
}

/**
 * Returns the rendered local tasks. The default implementation renders
 * them as tabs. Overridden to split the secondary tasks.
 *
 * @ingroup themeable
 */
function phptemplate_menu_local_tasks() {
  return menu_primary_local_tasks();
}

function phptemplate_comment_submitted($comment) {
  return t('!datetime — !username',
    array(
      '!username' => theme('username', $comment),
      '!datetime' => format_date($comment->timestamp)
    ));
}

function phptemplate_node_submitted($node) {
  return t('!datetime — !username',
    array(
      '!username' => theme('username', $node),
      '!datetime' => format_date($node->created),
    ));
}

/**
 * Generates IE CSS links for LTR and RTL languages.
 */
function phptemplate_get_ie_styles() {
  global $language;

  $iecss = '<link type="text/css" rel="stylesheet" media="all" href="'. base_path() . path_to_theme() .'/fix-ie.css" />';
  if ($language->direction == LANGUAGE_RTL) {
    $iecss .= '<style type="text/css" media="all">@import "'. base_path() . path_to_theme() .'/fix-ie-rtl.css";</style>';
  }

  return $iecss;
}


function phptemplate_flowplayer($config = NULL, $id = 'flowplayer', $attributes = array(), $contents = '') {
  // Prepare the ID.
  $id = form_clean_id($id);

  // Prepare the attributes, passing in the flowplayer class.
  if (isset($attributes['class'])) {
    $attributes['class'] .= ' flowplayer';
  }
  else {
    $attributes['class'] = 'flowplayer';
  }
  if ( isset($attributes['style']) ) $attributes['style'] = str_replace('position: absolute;', '',$attributes['style']);
  $attributes = drupal_attributes($attributes);
  
  $config['playlist'][1]['onFinish'] = 'clip_started=function(){var assess_tab = jQuery("div.content li.qtab-1 a"); if(assess_tab.length){assess_tab.trigger("click");}}';

  // Add the JavaScript to handle the element.
  flowplayer_add('#'. $id, $config);
  /*
  drupal_add_js('jQuery(document).ready(function () {
    var player = $("#'.$id.'");
	player.children("object").append("<param name=\"wmode\" value=\"opaque\" />");
	var phtm = player.html();
	player.empty().html(phtm);
	
  });', 'inline');
  */
  // Return the markup.
  return "<div id='$id' $attributes>$contents</div>";
}

function phptemplate_form_element($element, $value) {
  // This is also used in the installer, pre-database setup.
  $t = get_t();

  $output = '<div class="form-item"';
  if (!empty($element['#id'])) {
    $output .= ' id="'. $element['#id'] .'-wrapper"';
  }
  $output .= ">\n";
  $required = !empty($element['#required']) ? '<span class="form-required" title="'. $t('This field is required.') .'">*</span>' : '';

  if (!empty($element['#title'])) {
    $title = $element['#title'];
    if (!empty($element['#id'])) {
      $output .= ' <label for="'. $element['#id'] .'">'. $t('!title !required', array('!title' => filter_xss_admin($title), '!required' => $required)) ."</label>\n";
    }
    else {
      $output .= ' <label>'. $t('!title !required', array('!title' => filter_xss_admin($title), '!required' => $required)) ."</label>\n";
    }
  }

  $output .= " $value\n";

  if (!empty($element['#description'])) {
    $output .= ' <div class="description">'. $element['#description'] ."</div>\n";
  }

  $output .= "</div>\n";

  return $output;
}

/**
 * Formats the cart contents table on the checkout page.
 *
 * @param $show_subtotal
 *   TRUE or FALSE indicating if you want a subtotal row displayed in the table.
 *
 * @return
 *   The HTML output for the cart review table.
 *
 * @ingroup themeable
 */
function care_cart_review_table($show_subtotal = TRUE) {
  $subtotal = 0;

  // Set up table header.
  $header = array(
    array('data' => t('Qty'), 'class' => 'qty'),
    array('data' => t('Products'), 'class' => 'products'),
    array('data' => t('Price'), 'class' => 'price'),
  );

  $context = array();

  // Set up table rows.
  $contents = uc_cart_get_contents();
  foreach ($contents as $item) {
    $price_info = array(
      'price' => $item->price,
      'qty' => $item->qty,
    );

    $context['revision'] = 'altered';
    $context['type'] = 'cart_item';
    $context['subject'] = array(
      'cart' => $contents,
      'cart_item' => $item,
      'node' => node_load($item->nid),
    );

    $total = uc_price($price_info, $context);
    $subtotal += $total;

    $description = check_plain($item->title) . uc_product_get_description($item);

    // Remove node from context to prevent the price from being altered.
    $context['revision'] = 'themed-original';
    $context['type'] = 'amount';
    unset($context['subject']);
    $rows[] = array(
      array('data' => t('@qty', array('@qty' => $item->qty)), 'class' => 'qty'),
      array('data' => $description, 'class' => 'products'),
      array('data' => uc_price($total, $context), 'class' => 'price'),
    );
  }

  // Add the subtotal as the final row.
  if ($show_subtotal) {
    $context = array(
      'revision' => 'themed-original',
      'type' => 'amount',
    );
    $rows[] = array(
      'data' => array(array('data' => '<span id="subtotal-title">' . t('Subtotal:') . '</span> ' . uc_price($subtotal, $context), 'colspan' => 3, 'class' => 'subtotal')),
      'class' => 'subtotal',
    );
  }

  return theme('table', $header, $rows, array('class' => 'cart-review'));
}

/**
 * Themes cart items on the checkout review order page.
 *
 * @param $items
 *   An associative array containing cart items, with keys:
 *   - qty: Quantity in cart.
 *   - title: Item title.
 *   - price: Item price.
 *   - desc: Item description.
 *
 * @return
 *   A string of HTML for the page contents.
 *
 * @ingroup themeable
 */
function care_uc_checkout_pane_cart_review($items) {
  $context = array(
    'revision' => 'themed',
    'type' => 'cart_item',
    'subject' => array(),
  );

  $rows = array();

  foreach ($items as $item) {
    $price_info = array(
      'price' => $item->price,
      'qty' => $item->qty,
    );

    $context['subject'] = array(
      'cart' => $items,
      'cart_item' => $item,
      'node' => node_load($item->nid),
    );

    $rows[] = array(
      array('data' => $item->qty, 'class' => 'qty'),
      array('data' => check_plain($item->title) . uc_product_get_description($item), 'class' => 'products'),
      array('data' => uc_price($price_info, $context), 'class' => 'price'),
    );
  }

  return theme('table', NULL, $rows, array('class' => 'cart-review'));
}

