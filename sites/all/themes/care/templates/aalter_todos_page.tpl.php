<div class="view-tasks">
  <?php if(empty($todos)){?>
    <p>To view your customized family caregiver's plan, please <a href="#" onClick="$('li.qtab-1 a').click(); return false;">complete the Assessment</a> for this principle.</p>
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