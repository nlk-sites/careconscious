<?php if( !count($todos) ){ ?>
  <p><?= t('No additional to-dos to display') ?></p>
<?php } else { ?>
 <h2 class=principle-title><?= filter_xss($principle->p_title, $principle->p_format) ?></h2>
 <div id="task">
   <ul>
    <?php foreach ($todos as $todo) { ?>
<li>
  <?php
    $title = substr($todo->title, 0, 50);
		if (strlen($title) < strlen($todo->title)) $title = substr($title,0, strrpos($title, ' ')).' ...';
  ?>
  <div class="title"><?= $title ?></div>
  <div class="description shadow">
        <?= $todo->body ? check_markup($todo->body, $todo->format) : $todo->title ?>
  </div>
</li>
    <?php } ?>
   </ul>
 </div>
<?php } ?>