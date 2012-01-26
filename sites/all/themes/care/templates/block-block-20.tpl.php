<?php
?>
<div id="block-<?php print $block->module .'-'. $block->delta; ?>" class="clear-block block block-<?php print $block->module ?>">
<?php if (!empty($block->subject)): ?>
  <h2><?php print $block->subject ?></h2>
<?php endif;?>

  <div class="content">
    <?php //print $block->content ?>
    <h3 class="menu-title">Access the 8 Principles</h3>
<ul class="menu">
<?php

$ourprinciples = array('Learn the Landscape','Maintain Your Own Well Being','Manage Family Dynamics','Address Safety Issues','Recognize Residential Needs','Understand Legal and Financial Options','Help With Healthcare','Plan for Your Own Care');

$princ_node_ids = array(244,245,246,247,248,249,498,499);

foreach ($ourprinciples as $k => $v ) {
	$i = $k+1;
	?>
  <li class="item_principle<?php print $i ?>"><?php echo l($v,'dashboard/principle-'. $i); ?>
    <ul>
      <li class="icon_learn"><a href="/dashboard/principle-<?php print $i ?>?quicktabs_dashboard_principle_<?php print $i ?>_qt=0<?php /*#quicktabs-dashboard_principle_<?php print $i ?>_qt */ ?>">Learn</a></li>
      <li class="icon_assess"><a href="/dashboard/principle-<?php print $i ?>?quicktabs_dashboard_principle_<?php print $i ?>_qt=1<?php /*#quicktabs-dashboard_principle_<?php print $i ?>_qt */ ?>">Assess</a></li>
      <li class="icon_assist"><a href="/dashboard/principle-<?php print $i ?>?quicktabs_dashboard_principle_<?php print $i ?>_qt=2<?php /*#quicktabs-dashboard_principle_<?php print $i ?>_qt */ ?>">Assist</a></li>
    </ul>
    <?php
	print '<span class="'. (aalter_user_todos($princ_node_ids[$k]) ? '' :'no') .'check"></span>';
	?>
  </li>
<?php } ?>
</ul>
    <div class="clear"></div>
  </div>
</div>
