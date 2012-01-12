<div class="view-tasks">
  <?php foreach ($todos as $todo) { ?>
    <div class="views-row">
      <div class="views-field-body">
        <div class="field-content">
          <?php print $todo->body ? $todo->body : $todo->title; ?>
        </div>
      </div>
    </div>
  <?php } ?>
</div>