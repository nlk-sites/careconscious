<?php

/**
 * Theme and preprocess functions for the videojs module.
 */

/**
 * Preprocess function for videojs.tpl.php when using a playlist.
 */
function template_preprocess_videojs_formatter_videojs(&$vars) {
  $codecs = array(
    'video/mp4' => array(
      array('width' => '720', 'height' => '576', 'type' => "video/mp4; codecs='avc1.42E01E, mp4a.40.2'"), // Profile: Baseline, Level: 3.0
      array('width' => '1280', 'height' => '720', 'type' => "video/mp4; codecs='avc1.4D401F, mp4a.40.2'"), // Profile: Main, Level: 3.1
      array('width' => '1920', 'height' => '1088', 'type' => "video/mp4; codecs='avc1.640029, mp4a.40.2'"), // Profile: High, Level: 4.1 
      array('width' => '2048', 'height' => '2048', 'type' => "video/mp4; codecs='avc1.58A033, mp4a.40.2'") // Profile: Extended, Level: 5.1 
    ),
    'video/webm' => 'video/webm; codec="vp8, vorbis"',
    'application/octet-stream' => 'video/webm; codec="vp8, vorbis"',
    'video/ogg' => 'video/ogg; codec="theora, vorbis"',
    'application/ogg' => 'video/ogg; codec="theora, vorbis"',
    'video/quicktime' => 'video/mp4; codecs="avc1.42E01E, mp4a.40.2"'
  );

  videojs_add();
  $vars['width'] = intval(variable_get('videojs_width', 640));
  $vars['height'] = intval(variable_get('videojs_height', 264));
  $field_name = $vars['element']['#field_name'];
  $node = $vars['element']['#node'];
  $items_mp4 = array();
  $items_others = array();
  foreach ((array) $node->$field_name as $item) {
    // Skip unplayable items.
    if (!isset($codecs[$item['filemime']])) {
      continue;
    }

    if (!isset($item['url'])) {
      $item['url'] = _videojs_create_url($item['filepath']);
    }

    // Special treatment for mp4 type due to different capabilities.
    if ($item['filemime'] == 'video/mp4') {
      // Check if Video module present and dimensions are assigned
      if (isset($item['data']['dimensions'])) {
        list($width, $height) = explode('x', $item['data']['dimensions'], 2); // i.e. 560x314
        foreach ($codecs['video/mp4'] as $resolution) {
          $item['videotype'] = $resolution['type'];
          if (($width < $resolution['width']) && ($height < $resolution['height']))
            break;
        }
      } else
        $item['videotype'] = $codecs['video/mp4'][0]['type']; // dimensions info not exist, assign default
      $items_mp4[] = $item;
    } else {
      $item['videotype'] = $codecs[$item['filemime']];
      $items_others[] = $item;
    }
  }
  $vars['items'] = array_merge($items_mp4, $items_others); // mp4 listed first

  $vars['player_id'] = 'videojs-' . $vars['element']['#node']->nid . '-' . str_replace('_', '-', $vars['element']['#field_name']);

  $poster_field = variable_get('videojs_' . $node->type, 'video_module');
  if ($poster_field == 'video_module') {
    if (module_exists('video') && isset($vars['items'][0]['data'])) {
      // Video module present, retriving description and poster image from first video
      $vars['poster'] = _videojs_create_url($vars['items'][0]['data']['video_thumb']);
    }
  }
  else {
    // Grab any poster image from a field defined in videojs admin settings
    if (!empty($node->$poster_field)) {
      $image = $node->{$poster_field}[0]; // take the first image from field
      $vars['poster'] = _videojs_create_url($image['filepath']);
    }
  }

  // Special treatment for 'video/flv', if one is exist use it as flash fallback, otherwise first mp4
  foreach ($vars['items'] as $item) {
    if ($item['filemime'] == 'video/flv') {
      $vars['flash'] = $item['url'];
      break;
    }
  }
  if (!isset($vars['flash']) && !empty($items_mp4)) {
    $vars['flash'] = $items_mp4[0]['url'];
  }

  if (empty($vars['flash_player']) && !empty($vars['flash'])) {
    $vars['flash_player'] = _videojs_flashplayer($vars['flash'], $vars['width'], $vars['height'], $vars['poster'], $vars['player_id']);
  }
}

/**
 * Preprocess function for videojs.tpl.php when displaying a view as a playlist.
 */
function template_preprocess_videojs_view(&$vars) {
  videojs_add();
  $vars['player_id'] = 'videojs-view-' . str_replace('_', '-', $vars['view']->name);
}

/**
 * Preprocess function for videojs.tpl.php when displaying a view as a playlist.
 */
function template_preprocess_videojs(&$vars) {
  videojs_add();
  $vars['player_id'] = 'videojs-' . str_replace('_', '-', $vars['player_id']);
  $vars['poster'] = _videojs_create_url($vars['items']['thumbnail']['filepath']);
  $vars['width'] = intval($vars['attributes']['width']);
  $vars['height'] = intval($vars['attributes']['height']);
  $vars['autoplay'] = !!variable_get('videojs_autoplay', FALSE);
  $items_mp4 = array();
  $items_others = array();
  $codecs = array(
    'video/mp4' => array(
      array('width' => '720', 'height' => '576', 'type' => "video/mp4; codecs='avc1.42E01E, mp4a.40.2'"), // Profile: Baseline, Level: 3.0
      array('width' => '1280', 'height' => '720', 'type' => "video/mp4; codecs='avc1.4D401F, mp4a.40.2'"), // Profile: Main, Level: 3.1
      array('width' => '1920', 'height' => '1088', 'type' => "video/mp4; codecs='avc1.640029, mp4a.40.2'"), // Profile: High, Level: 4.1 
      array('width' => '2048', 'height' => '2048', 'type' => "video/mp4; codecs='avc1.58A033, mp4a.40.2'") // Profile: Extended, Level: 5.1 
    ),
    'video/webm' => "video/webm; codec='vp8, vorbis'",
    'application/octet-stream' => "video/webm; codec='vp8, vorbis'",
    'video/ogg' => "video/ogg; codec='theora, vorbis'",
    'application/ogg' => "video/ogg; codec='theora, vorbis'",
    'video/quicktime' => "video/mp4; codecs='avc1.42E01E, mp4a.40.2'"
  );
  foreach ($vars['items'] as $item) {
    // Skip unplayable items.
    if (!isset($codecs[$item['filemime']])) {
      continue;
    }

    if (!isset($item['url'])) {
      $item['url'] = _videojs_create_url($item['filepath']);
    }

    // Special treatment for mp4 type due to different capabilities.
    if ($item['filemime'] == 'video/mp4') {
      // Check if Video module present and dimensions are assigned
      if (isset($item['data']['dimensions'])) {
        list($width, $height) = explode('x', $item['data']['dimensions'], 2); // i.e. 560x314
        foreach ($codecs['video/mp4'] as $resolution) {
          $item['videotype'] = $resolution['type'];
          if (($width < $resolution['width']) && ($height < $resolution['height']))
            break;
        }
      } else
        $item['videotype'] = $codecs['video/mp4'][0]['type']; // dimensions info not exist, assign default
      $items_mp4[] = $item;
    } else {
      $item['videotype'] = $codecs[$item['filemime']];
      $items_others[] = $item;
    }
  }
  $vars['items'] = array_merge($items_mp4, $items_others); // mp4 listed first

  // Special treatment for 'video/flv', if one is exist use it as flash fallback, otherwise first mp4
  foreach ($vars['items'] as $item) {
    if ($item['filemime'] == 'video/flv') {
      $vars['flash'] = $item['url'];
      break;
    }
  }
  if (!isset($vars['flash']) && !empty($items_mp4)) {
    $vars['flash'] = $items_mp4[0]['url'];
  }

  if (empty($vars['flash_player']) && !empty($vars['flash'])) {
    $vars['flash_player'] = _videojs_flashplayer($vars['flash'], $vars['width'], $vars['height'], $vars['poster'], $vars['player_id']);
  }
}

/**
 *  Get flash player fallback
 */
function _videojs_flashplayer($url, $width, $height, $poster, $player_id) {
  $autoplay = !!variable_get('videojs_autoplay', FALSE);
  $extraheight = variable_get('videojs_flowplayer_extraplayerheight', 24);
  
  if (module_exists('swftools')) {
    $options = array(
      'params' => array(
        'width' => $width,
        'height' => $height + $extraheight,
      ),
    );
    if ($poster) {
      $options['othervars'] = array(
        //@todo: swftools bug, can't enable this until they fix their pathing for the images.
        'image' => $poster,
        'class' => 'vjs-flash-fallback',
      );
    }
    return swf($url, $options);
  }
  elseif (module_exists('flowplayer')) {
    // kjh: use a playlist to display the thumbnail if not auto playing
    if (!$autoplay && $poster) {
      $options = array('playlist' => array($poster,
          array('url' => urlencode($url),
            'autoPlay' => $autoplay,
            'autoBuffering' => TRUE,
          ),
        ),
      );
    }
    else {
      $options = array(
        'clip' => array('url' => urlencode($url),
          'autoPlay' => $autoplay,
          'autoBuffering' => TRUE,
        ),
      );
    }
    return theme(
        'flowplayer', $options, 'vjs-flash-fallback',
        array('style' => 'width:'. $width .'px;height:'. ($height + $extraheight) .'px;')
    );
  }
  else {
    $flashvars = array('playlist' => array());

    if (!empty($poster)) {
      $flashvars['playlist'][] = $poster;
    }

    $flashvars['playlist'][] = array(
        'url' => $flash,
        'autoPlay' => FALSE,
        'autoBuffering' => TRUE,
    );

    if (function_exists('json_encode')) {
      // json_encode() works better wrt & in URLs
      $flashvars = rawurlencode(json_encode($flashvars));
    }
    else {
      $flashvars = rawurlencode(drupal_to_js($flashvars));
    }

    $flowplayer = 'http://releases.flowplayer.org/swf/flowplayer-3.2.7.swf';

    $posterhtml = '';
    if (!empty($poster)) {
      $posterhtml = '<img src="'. check_plain($poster) .'" width="'. $width .'" height="'. $height .'" alt="Poster Image" title="No video playback capabilities." />';
    }
    
    $wmode = variable_get('videojs_wmode', '');
    $wmodehtml = '';
    $wmodeparam = '';
    if (!empty($wmode)) {
      $wmodehtml = ' wmode="'. check_plain($wmode) .'"';
      $wmodeparam = '<param name="wmode" value="'. check_plain($wmode) .'" />';
    }
    
    return
'<object class="vjs-flash-fallback" width="'. $width .'" height="'. $height .'" type="application/x-shockwave-flash" data="'. $flowplayer .'" id="object-'. check_plain($player_id) .'">
  <param name="movie" value="'. $flowplayer .'" />
  <param name="allowfullscreen" value="true" />
  <param name="flashvars" value="config='. $flashvars .'" />
  '. $wmodeparam .'
  <embed id="flash-'. check_plain($player_id) .'"
    name="flash-'. check_plain($player_id) .'"
    src="'. $flowplayer .'"
    width="'. $width .'"
    height="'. $height .'"
    type="application/x-shockwave-flash"
    allowscriptaccess="always"
    allowfullscreen="true"
    '. $wmodehtml .'
    flashvars="config='. $flashvars .'" />
'. $posterhtml .'
</object>';
  }
}

function _videojs_create_url($filepath) {
  if (strncmp($filepath, 'http:', 5) === 0 || strncmp($filepath, 'https:', 6) === 0) {
    return $filepath;
  }
  
  return file_create_url(drupal_urlencode($filepath));
}
