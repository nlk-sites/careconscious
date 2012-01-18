<?php
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php print $language->language ?>" lang="<?php print $language->language ?>" dir="<?php print $language->dir ?>">
  <head>
    <?php print $head ?>
    <title><?php print $head_title ?></title>
    <?php print $styles ?>
    <?php print $scripts ?>
  </head>
<body class="<?php print $body_classes;?>">

  <div id="bg">
  <div id="page-layout">
  <div id="header">

    <?php print $header; ?>

  </div><!-- END: header -->

<div id="main_outer">
  <div id="main">

      <?php if ($left): ?>
        <div id="sidebar_first" class="sidebar">
          <?php print $left ?>
          <div class="clear"></div>
        </div><!-- END: sidebar -->
      <?php endif; ?>

    <div id="main_content">
      <?php if ($content_top): ?>
        <div id="content_top">
          <?php print $content_top ?>
          <div class="clear"></div>
        </div><!-- END: content_top -->
      <?php endif; ?>
      <div id="content">
          <?php //if ($tabs): print '<div id="tabs-wrapper" class="clear-block">'; endif; ?>
          <?php //if ($tabs): print '<ul class="tabs primary">'. $tabs .'</ul></div>'; endif; ?>
          <?php //if ($tabs2): print '<ul class="tabs secondary">'. $tabs2 .'</ul>'; endif; ?>
          <?php if ($title): print '<h1'. ($tabs ? ' class="with-tabs"' : '') .'>'. $title .'</h1>'; endif; ?>

          <?php //if ($show_messages && $messages): print $messages; endif; ?>
          <?php print $content;
		  
          global $user;
		  if ( (arg(1) == 141443) && in_array( 'getstarted', $user->roles) ) { ?>
			  <div id="getstartedhere">
              <a href="#" class="x">x</a>
              <h2><strong>Get Started Here.</strong><br />
              Select a principle from the column to the left.</h2>
              <img src="<?php echo base_path() . path_to_theme() ?>/images/getstarted.png" alt="Watch the Video : Do the Assessment : Get Your Own Custom Checklist" />
              <p><em><strong>By the way, we don't expect you to complete all 8 principles at once.</strong> Start with the one that best suits your current needs, and simply complete other principles as time allows.</em></p>
              </div>
              <script type="text/javascript">
			  jQuery(function() {
				 jQuery('#main_content .block').append('<div class="fader" />');
				 jQuery('#getstartedhere a.x').click(function() {
					jQuery('#main_content .block .fader, #getstartedhere').remove();
					return false; 
				 });
				 jQuery('#content').css('position','relative');
				 jQuery('#getstartedhere, #main_content .block .fader').fadeIn();
			  });
			  </script>
		  <?php } ?>
          <div class="clear"></div>
      </div><!-- END: content -->

      <?php if ($content_bottom): ?>
        <div id="content_bottom">
          <?php print $content_bottom ?>
          <div class="clear"></div>
        </div><!-- END: content_bottom -->
      <?php endif; ?>

      </div><!-- END: main_content -->

      <?php if ($right): ?>
        <div id="sidebar_second" class="sidebar">
          <?php print $right ?>
          <div class="clear"></div>
        </div><!-- END: sidebar -->
      <?php endif; ?>

      <?php if ($postscript): ?>
        <div id="postscript">
          <?php print $postscript ?>
          <div class="clear"></div>
        </div><!-- END: postscript -->
      <?php endif; ?>
    <div class="clear"></div>
    </div></div><!-- END: main -->
  </div><!-- END: page layout -->
  </div><!-- END: bg -->

  <div id="footer_outer">
    <div id="footer">
    <?php print $footer ?>
    <div class="clear"></div>
  </div></div>

  <?php print $closure ?>
  </body>
</html>
