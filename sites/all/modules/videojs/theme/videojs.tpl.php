<?php
/**
 * Provide the HTML output of the videojs audio player.
 */

$autoplayattr = !empty($autoplay) ? ' autoplay="autoplay"' : '';

if (!empty($items)): ?>
<div class="video-js-box <?php print variable_get('videojs_skin', 'default') ?>" id="<?php echo check_plain($player_id) ?>">
  <video id="<?php echo check_plain($player_id); ?>-video" class="video-js"<?php echo $autoplayattr; ?> width="<?php echo $width ?>" height="<?php echo $height ?>" controls="controls" preload="auto" poster="<?php echo check_plain($poster) ?>">
<?php foreach ($items as $item): ?>
    <source src="<?php echo check_plain($item['url']) ?>" type="<?php echo check_plain($item['videotype']) ?>" />
<?php endforeach; ?>
<?php if (!empty($flash_player)): ?>
    <div class="vjs-flash-fallback"><?php echo $flash_player; ?></div>
<?php endif; ?>
    <div class="vjs-no-video">
      <strong>Download Video:</strong>
<?php foreach ($items as $item): ?>
      <a href="<?php echo check_plain($item['url']) ?>"><?php echo strtoupper(substr($item['filemime'], 6)); ?></a>,
<?php endforeach; ?>
    </div>
  </video>
</div>
<?php endif; ?>
