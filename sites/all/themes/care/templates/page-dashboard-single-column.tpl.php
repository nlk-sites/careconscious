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
      <?php if ($content_top): ?>
        <div id="content_top">
          <?php print $content_top ?>
          <div class="clear"></div>
        </div><!-- END: content_top -->
      <?php endif; ?>

    <div id="main_content_single">

      <?php //if ($tabs): print '<div id="tabs-wrapper" class="clear-block">'; endif; ?>
      <?php //if ($tabs): print '<ul class="tabs primary">'. $tabs .'</ul></div>'; endif; ?>
      <?php //if ($tabs2): print '<ul class="tabs secondary">'. $tabs2 .'</ul>'; endif; ?>
      <?php if ($title): print '<h1'. ($tabs ? ' class="with-tabs"' : '') .'>'. $title .'</h1>'; endif; ?>

      <div id="content">
          <?php if ($show_messages && $messages): print $messages; endif; ?>
          <?php print $content ?>
          <div class="clear"></div>
      </div><!-- END: content -->

      </div><!-- END: main_content -->

      <?php if ($content_bottom): ?>
        <div id="content_bottom">
          <?php print $content_bottom ?>
          <div class="clear"></div>
        </div><!-- END: content_bottom -->
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
