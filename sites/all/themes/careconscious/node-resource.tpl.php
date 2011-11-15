<?php
// $Id: node.tpl.php,v 1.4.2.1 2009/08/10 10:48:33 goba Exp $
if ($node->field_callout[0]['value']) {
  drupal_add_js(array('callout' => $node->field_callout[0]['value']), 'setting');
}
if ($teaser && $_GET['q'] == 'taxonomy/term/455') {
  $read_more = l(t('Read more'), 'node/'. $node->nid);
}
?>
<div id="node-<?php print $node->nid; ?>" class="node<?php if ($sticky) { print ' sticky'; } ?><?php print ' node-resource'; ?><?php if ($teaser) { print ' teaser'; } ?><?php if ($read_more) { print ' resource'; } ?><?php if (!$status) { print ' node-unpublished'; } ?> clear-block">
<?php if ($links && arg(0) == 'node' && arg(1) == $node->nid && !arg(2)) { print $links; }?>
<?php print $picture ?>

<?php if (!$page): ?>
  <h2><a href="<?php print $node_url ?>" title="<?php print $title ?>"><?php print $title ?></a></h2>
<?php endif; ?>

  <div class="meta">
  <?php if ($submitted): ?>
    <span class="submitted"><?php print $submitted ?></span>
  <?php endif; ?>

  <?php if ($terms): ?>
   
  <?php endif;?>
  
  </div>

  <div class="content">
  <?php print check_markup($node->content['body']['#value'], $node->format); ?>
  </div>
  <?php print $read_more; ?>
</div>