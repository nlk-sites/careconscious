<?php
?>
<div id="block-<?php print $block->module .'-'. $block->delta; ?>" class="clear-block block block-<?php print $block->module ?>">
<?php if (!empty($block->subject)): ?>
  <h2><?php print $block->subject ?></h2>
<?php endif;?>

  <div class="content">
    <?php print $block->content ?>
    <p style="text-align: center"><br />-or- <?php print l('Register Today for Free', 'user/register'); ?></p>
    <div class="clear"></div>
  </div>
</div>
