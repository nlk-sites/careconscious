<?php if( !count($principles) ){ ?>
  <div class="block-views">
    <h2>My Caregiving Tasks</h2>
    <div class="content">
   <div class="tasks-lists" style="border-right:none"><p><?php echo t('No additional to-dos to display') ?></p></div>
    </div>
  </div>
<?php } else {?>
  <div class="block-views">
    <h2>My Caregiving Tasks</h2>
    <div class="more-link"><?php echo l('View all', 'dashboard/user-tasks');?></div>
    <div class="content">
      <?php foreach ($principles as $group => $principle) {?>
        <div class="tasks-lists" id="tasks-lists-p<?php echo $principle->principle_number;?>">
          <div class="tasks-principle">Principle <?php echo $principle->principle_number;?></div>
          <h3 class="principle-title"><?php echo $principle->p_title;?></h3>
          <ul>
            <?php if(isset($todos[$principle->p_nid]) && !empty($todos[$principle->p_nid])){
              $p_todos = $todos[$principle->p_nid];
              $i = 1;
              foreach($p_todos as $t){
                echo '<li>'.l($t->title, 'node/'.$t->nid).'</li>';
                if($i++ >= 3){
                  break;
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