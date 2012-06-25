<?php
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php print $language->language ?>" lang="<?php print $language->language ?>" dir="<?php print $language->dir ?>">
  <head>
    <?php print $head ?>
    <title><?php print $head_title ?></title>
    <?php print $styles ?>
    <?php print $scripts ?>
<script type="text/javascript">var switchTo5x=false;</script>
<script type="text/javascript" src="https://ws.sharethis.com/button/buttons.js"></script>
<script type="text/javascript">stLight.options({publisher: "ur-5a14b420-6e47-1983-f652-99d7d83f79bb"}); </script>
  </head>
<body class="<?php print $body_classes;?>">

  <div id="bg">
  <div id="bg_top">
  <div id="page-layout">
  <div id="header">
    <div id="logo">
        <?php
          if ($logo || $site_title) {
            print '<a href="'. check_url($base_path) .'" title="'. $site_title .'">';
            if ($logo) {
              print '<img src="'. check_url($logo) .'" alt="'. $site_title .'" />';
            }
            print $site_html .'</a>';
          }
        ?>
  </div>

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
          <div class="subhead_image">
          <?php print t($node->field_subhead_image[0]['view']); ?>
          </div>

          <?php if ($tabs): print '<div id="tabs-wrapper" class="clear-block">'; endif; ?>
          <?php if ($tabs): print '<ul class="tabs primary">'. $tabs .'</ul></div>'; endif; ?>
          <?php if ($tabs2): print '<ul class="tabs secondary">'. $tabs2 .'</ul>'; endif; ?>
          <?php if ($title): print '<h1'. ($tabs ? ' class="with-tabs"' : '') .'>'. $title .'</h1>'; endif; ?>

          <?php if ($show_messages && $messages): print $messages; endif; ?>
          <?php print $help; ?>
          <?php print $content ?>
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

      <?php if ($sidebar_third): ?>
        <div id="sidebar_third" class="sidebar">
          <?php print $sidebar_third ?>
          <div class="clear"></div>
        </div><!-- END: sidebar_third -->
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
  </div></div><!-- END: bg -->

      <?php if ($prefooter): ?>
        <div id="prefooter_outer">
          <div id="prefooter">
          <?php print $prefooter ?>
          <div class="clear"></div>
        </div></div><!-- END: prefooter -->
      <?php endif; ?>

  <div id="footer_outer">
    <div id="footer">
    <?php print $footer ?>
    <div class="clear"></div>
  </div></div>
<script type="text/javascript">
jQuery(function() {
	jQuery('.flowplayer-processed object').append('<param name="wmode" value="opaque" />');
});
</script>
  <?php print $closure ?>
  </body>
</html>
