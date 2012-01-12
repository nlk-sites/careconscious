<div class="view-tasks">
  <?php if(empty($todos)){?>
    <?php $cur_node = node_load(arg(1));?>
    <p>To view your customized family caregiver's plan, please <?php echo l('complete the Assessment', $cur_node->path, array('absolute' => TRUE, 'query' => 'quicktabs_'.str_replace(array('/', '-'), '_', $cur_node->path).'_qt=1'));?> for this principle.</p>
  <?php }else{?>
    <p>Based on your answers we've delivered a customized plan of action, recommended resources, and valuable service providers. It's what you need to do, what you need to do it, and who you need to help you on your journey, all in one place!</p>
    <?php foreach ($todos as $todo) { ?>
      <div class="views-row">
        <div class="views-field-body">
          <div class="field-content">
            <?php print $todo->body ? $todo->body : $todo->title; ?>
          </div>
        </div>
      </div>
    <?php }
  }?>
</div>