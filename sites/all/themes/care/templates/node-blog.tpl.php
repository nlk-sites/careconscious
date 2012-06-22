<?php
?>
<div id="node-<?php print $node->nid; ?>" class="node<?php if ($sticky) { print ' sticky'; } ?><?php if (!$status) { print ' node-unpublished'; } ?>">

<?php print $picture ?>

<?php if ($page == 0): ?>
  <h1><a href="<?php print $node_url ?>" title="<?php print $title ?>"><?php print $title ?></a></h1>
<?php endif; ?>
<pre style="display:none"><?php print_r($node); ?></pre>
	<div class="byline clear-block">
    <?php
	$postdate = format_date(strtotime($node->field_date[0]['value']),'custom', 'F d, Y');
	echo $postdate .' : ';
	$firsttax = array_shift($node->taxonomy);
	print l( $firsttax->name, 'taxonomy/term/'. $firsttax->tid );
	?>
    </div>
  <div class="content clear-block">
    <?php print $content ?>
  </div>

  <div class="clear-block">
    <div class="meta">
    <?php if ($taxonomy): ?>
      <div class="terms"><?php //print $terms ?></div>
    <?php endif;?>
    </div>

    <?php if ($links): ?>
      <div class="links"><?php print $links; ?></div>
    <?php endif; ?>
  </div>

</div>
