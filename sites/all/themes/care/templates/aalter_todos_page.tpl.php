<div class="view-tasks">
  <?php foreach ($todos as $todo) { ?>
    <div class="views-row">
      <?php
      $title = substr($todo->title, 0, 50);
	  if (strlen($title) < strlen($todo->title)) $title = substr($title,0, strrpos($title, ' ')).' ...';
      ?>
      <div class="views-field-title">
        <span class="field-content"><?php print $title ?></span>
      </div>
      <div class="views-field-body">
        <div class="field-content">
          <?php print $todo->format;?>
          <?php print $todo->body;?>
          <?php print $todo->body ? check_markup($todo->body, $todo->format) : $todo->title; ?>
        </div>
      </div>
    </div>
  <?php } ?>
</div>