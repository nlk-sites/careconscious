<?php if( !count($resources) ){ ?>
  <p><?= t('No resources to display') ?></p>
<?php } else { ?>
<div class="accordion">
<?php foreach ($resources as $res) { ?>
  <h3 class="principle-title"><?= filter_xss($res->title) ?></h3>
  <div class="content"><?= check_markup($res->teaser) ?><br /><a href="<?= url('node/'.$res->nid) ?>">Read more</a><br /><br /></div>
<?php } ?>
</div>
<script type="text/javascript">
	$(function() {
		$( ".accordion" ).accordion({
			autoHeight: false,
			navigation: true
		});
	});
</script>
<?php } ?>