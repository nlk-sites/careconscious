<?php if( !count($principles) ){ ?>
  <p><?php echo t('No additional to-dos to display') ?></p>
<?php } else {?>
  <div class="block-views">
    <h2>My Caregiving Tasks</h2>
    <?php echo l('View all', 'dashboard/user-tasks');?>
    <div class="content">
      <?php foreach ($principles as $group => $principle) {?>
        <div>
          <div>Principle <?php echo $principle->principle_number;?></div>
          <h3 class="principle-title"><?php echo $principle->p_title;?></h3>
          <ul>
            <?php if(isset($todos[$principle->p_nid]) && !empty($todos[$principle->p_nid])){
              $p_todos = $todos[$principle->p_nid];
              $i = 1;
              foreach($p_todos as $t){
                $body = str_get_html($t->body);
                $lis = $body->find('li');
                foreach($lis as $l){
                  echo $l;
                  if($i++ >= 3){
                    break 2;
                  }
                }
              }
            }?>
          </ul>
          <?php echo l('View Additional Tasks', 'dashboard/principle-'.$principle->principle_number, array('query' => 'quicktabs_dashboard_principle_'.$principle->principle_number.'_qt=2'));?>
        </div>
      <?php }?>
    </div>
  </div>
<?php } ?>