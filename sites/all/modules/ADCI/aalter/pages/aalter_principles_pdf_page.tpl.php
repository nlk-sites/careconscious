<?php if( !count($principles) ){ ?>
  <p><?= t('No additional to-dos to display') ?></p>
<?php } else { ?>
  <?php foreach ($principles as $group => $principle) { ?>
    <h3 class=principle-title><?php echo l(filter_xss($principle->p_title), 'user/'.$user->uid.'/todos/'.$principle->p_nid)?></h3>
  <?php } ?>
<?php } ?>