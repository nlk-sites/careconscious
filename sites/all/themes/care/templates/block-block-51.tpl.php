<?php
// FAKE
?>
<div id="block-quicktabs-register_login" class="clear-block block block-<?php print $block->module ?> blogtop">
  <div class="content">
    <ul class="quicktabs_tabs">
    	<?php
		global $user;
		if ( $user->uid ) { ?>
    	<li class="active first">
        	<a href="/dashboard">View Dashboard</a>
        </li>
        <?php } else { ?>
    	<li class="active first">
        	<a href="/" class="active">Get Started Now</a>
        </li>
    	<li class="last">
        	<a href="/user">Member Login</a>
        </li>
		<?php } ?>
    </ul>
    <div class="clear"></div>
  </div>
</div>
