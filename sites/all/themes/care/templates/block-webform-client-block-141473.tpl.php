<?php
?>
<div id="block-<?php print $block->module .'-'. $block->delta; ?>" class="clear-block block block-<?php print $block->module ?>">
<?php if (!empty($block->subject)): ?>
  <h2><?php print $block->subject ?></h2>
<?php endif;?>

  <div class="content">
    <?php print $block->content;
	/*<p style="text-align: center"><br />-or- <?php print l('Register Today for Free', 'user/register'); ?></p>*/
	 ?>
    <div class="clear"></div>
  </div>
</div>
<script>
    $(document).ready(function(){
        var webform = $('#webform-client-form-141473');
        var captcha = webform.find('fieldset.captcha');
        captcha.hide();
        webform.find(':input').change(function(){captcha.show();});
        <?php foreach(array('name' => 'Name', 'email' => 'Email', 'zip-code' => 'Zip Code') as $webform_field => $webform_field_value){?>
            $('#edit-submitted-<?php echo $webform_field;?>').focus(function(){
                if($(this).val() == '<?php echo $webform_field_value;?>'){
                    $(this).val('');
                }
            });
            $('#edit-submitted-<?php echo $webform_field;?>').blur(function(){
                if($(this).val() == ''){
                    $(this).val('<?php echo $webform_field_value;?>');
                }
            });
        <?php }?>
    });
</script>