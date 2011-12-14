<?php if( !count($principles) ){ ?>
  <p><?php echo t('No additional to-dos to display') ?></p>
<?php } else {?>
  <div class="mytasks-header">These tasks act like a road map and will point you in the right direction through-out your caregiving journey. Print them out or come back to your user profile to review them anytime. Click on a Principle below to see the tasks associated with that Principle.</div>
  <?php foreach ($principles as $group => $principle) {?>
    <div class="tasks-lists-main">
      <div class="tasks-header">
        <div class="tasks-principle">Principle <?php echo $principle->principle_number;?></div>
        <h3 class="principle-title"><?php echo l($principle->p_title, 'dashboard/principle-'.$principle->principle_number, array('query' => 'quicktabs_dashboard_principle_'.$principle->principle_number.'_qt=2'))?></h3>
      </div>
      <ul>
        <?php if(isset($todos[$principle->p_nid]) && !empty($todos[$principle->p_nid])){
          $p_todos = $todos[$principle->p_nid];
          $i = 1;
          foreach($p_todos as $t){
            $body = str_get_html($t->body);
            $lis = $body->find('li');
            foreach($lis as $l){
              echo $l;
              if($i++ >= 4){
                break 2;
              }
            }
          }
        }?>
      </ul>
      <div class="more-link"><?php echo l('View All', 'dashboard/principle-'.$principle->principle_number, array('query' => 'quicktabs_dashboard_principle_'.$principle->principle_number.'_qt=2'))?></div>
    </div>
  <?php }
} ?>