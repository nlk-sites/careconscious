<div class="view-tasks">
  <?php $cur_node = node_load(arg(1));?>
  <?php if(empty($todos)){?>
    <p>To receive your customized family caregiver's plan, you must <?php echo l('complete the Assessment questions', $cur_node->path, array('absolute' => TRUE, 'query' => 'quicktabs_'.str_replace(array('/', '-'), '_', $cur_node->path).'_qt=1'));?>  for this principle. Go to the assessment tab above.</p>
  <?php }else{?>
    <?php $principle_num = node_load($cur_node->field_principle_nid[0]['nid'])->field_principle_number[0]['value'];?>
    <p><b>Your Family Caregiver's Plan for Principle <?php echo $principle_num;?></b></p>
    <p>
      Based on your answers we've delivered your customized Family Caregiver's Plan for <?php echo $cur_node->title; ?>, which includes the important tasks to complete and recommended advice and resources to help you complete those tasks. It's what you need to do and what you need to do it, all in one place.  
    </p>
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