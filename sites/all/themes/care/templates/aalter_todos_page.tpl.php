<div class="view-tasks">
  <?php if(empty($todos)){?>
    <p>To receive your customized family caregiver's plan, you must <a href="#" onClick="$('li.qtab-1 a').click(); return false;">complete the Assessment questions</a> for this principle. Go to the assessment tab above.</p>
  <?php }else{?>
    <?php $cur_node = node_load(arg(1));
    $principle_num = node_load($cur_node->field_principle_nid[0]['nid'])->field_principle_number[0]['value'];?>
    <div class="assisthdr p<?php echo $principle_num;?>"><div class="cp">Your Family<br />Caregiver's Plan</div><div class="pn"><span class="p">Principle</span><span class="n"><?php echo $principle_num;?></span></div></div>
    <p class="assistfp"><strong class="p<?php echo $principle_num;?>"><?php echo $cur_node->title; ?>:</strong> Based on your answers we've delivered your customized Family Caregiver's Plan , which includes the important tasks to complete and recommended advice and resources to help you complete those tasks.</p>
    <?php foreach ($todos as $todo) { ?>
      <div class="views-row">
        <div class="views-field-body">
          <div class="field-content assist">
            <?php print $todo->body ? $todo->body : $todo->title; ?>
          </div>
        </div>
      </div>
    <?php }
  }?>
</div>