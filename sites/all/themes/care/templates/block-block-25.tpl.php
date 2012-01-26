<?php
?>
<div id="block-<?php print $block->module .'-'. $block->delta; ?>" class="clear-block block block-<?php print $block->module ?>">
<?php if (!empty($block->subject)): ?>
  <h2><?php print $block->subject ?></h2>
<?php endif;?>

  <div class="content">
    <?php print $block->content ?>
    <ul class="steps">
<li class="step"><span class="stepnum">1</span><b>Step One: Learn</b>
Watch the Video</li>
<li class="step"><span class="stepnum">2</span><b>Step Two: Assess</b>
Complete the Assessment</li>
<li class="step"><span class="stepnum">3</span><b>Step Three: Assist</b>
Review &amp; Print your Assist Plan</li>
</ul>
<div class='btn_todo'><?php echo l('View Dashboard', 'dashboard');?></div>
<div class='btn_todo next'><?php echo l('Start Next Principle', 'dashboard/principle-7');?></div>
<div class='btn_download'><?php echo l('Download & Print Lesson Six', 'printpdf/141448');?></div>
    <div class="clear"></div>
  </div>
</div>
