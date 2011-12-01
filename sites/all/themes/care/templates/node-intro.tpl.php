<div id="node-<?php print $node->nid; ?>" class="node<?php if ($sticky) { print ' sticky'; } ?><?php if (!$status) { print ' node-unpublished'; } ?> clear-block">
 <div class="content">
    <?php
      $principle = $node->field_principle_id[0]['value'];
      $file_name = $node->field_file_name[0]['value'];
      $file_mov_name = $node->field_file_mov_name[0]['value'];
      module_load_include('inc', 'webform', 'includes/webform.submissions');
      $rep = webform_get_submission_count($principle, $GLOBALS['user']->uid) > 0 ? 'yes' : 'no';
    ?>
    <div align="center">
<?php
  $iOS = (bool) strpos($_SERVER['HTTP_USER_AGENT'], 'iPad');
  $iOS = (bool) strpos($_SERVER['HTTP_USER_AGENT'], 'iPhone');
  if ($_GET['iOS'] == '1') {
    $iOS = TRUE;
  }
  if ($iOS) {
?>
  <script>
    jQuery(function($) {
      var
        player = $('#player');
      player.bind('ended', function(e) {
        window.location.href = "<?php print url('node/'. $principle, array('absolute' => true)); ?>";
      }, true);
    });
  </script>
  <video id="player" width="610" height="365" controls autobuffer autoplay='true'>
     <source src='<?= base_path() .'movs/'. $file_mov_name ?>' type='video/mp4'/>
  </video>
<?php
  } else {
?>
      <script type="text/javascript">
      function getSize() {
              var winH = 600;
              if (parseInt(navigator.appVersion)>3) {
                      if (navigator.appName=="Netscape") {
                              winH = window.innerHeight;
                      }
                      if (navigator.appName.indexOf("Microsoft")!=-1) {
                              winH = document.body.offsetHeight;
                      }
              }
              return winH
      }
      </script>
      <object style="display: block" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0" width="610" height="365">
      <param name="movie" value="<?= url('video_player.swf') ?>" />
      <param name="quality" value="high" />
      <param name="Flashvars" value="vid=<?= url($file_name) ?>&rep=<?= $rep ?>&link=<?= url('node/' .$principle) ?>" />
      <param name="allowScriptAccess" value="always" />
      <script language="JavaScript">
if (navigator.mimeTypes && navigator.mimeTypes["application/x-shockwave-flash"]){
  document.write('<embed src="<?= url('video_player.swf') ?>" width="610" height="365" quality="high" pluginspage="http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash" type="application/x-shockwave-flash" flashvars="vid=<?= url($file_name) ?>&rep=<?= $rep ?>&link=<?= url('node/' .$principle) ?>" allowscriptaccess="always"></embed>');
}
else {
  document.write('\
      <object classid="clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B" codebase="http://www.apple.com/qtactivex/qtplugin.cab" width="968" height="544">\
        <param name="src" value="<?= url('movs/' . $file_mov_name) ?>" />\
        <param name="controller" value="true" />\
        <object type="video/quicktime" data="<?= url('movs/' . $file_mov_name) ?>" width="968" height="544" class="mov">\
          \
        </object>\
      </object>\
    ');
}
</script>
      </object>
<?php } ?>
    </div>
  </div>
</div>