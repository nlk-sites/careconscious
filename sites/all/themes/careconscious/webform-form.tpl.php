<?php
// $Id: webform-form.tpl.php,v 1.1.2.4 2009/01/11 23:09:35 quicksketch Exp $

/**
 * @file
 * Customize the display of a complete webform.
 *
 * This file may be renamed "webform-form-[nid].tpl.php" to target a specific
 * webform on your site. Or you can leave it "webform-form.tpl.php" to affect
 * all webforms on your site.
 *
 * Available variables:
 * - $form: The complete form array.
 * - $nid: The node ID of the Webform.
 *
 * The $form array contains two main pieces:
 * - $form['submitted']: The main content of the user-created form.
 * - $form['details']: Internal information stored by Webform.
 */
?>
<?php
// Modified to surround main form with Herubin's javascript code which
// displays questions via survey_machine
$flash_preamble = <<<EOFP
<div id='theform'>
        <script type="text/javascript" language="JavaScript">
                mydiv3 = $('#theform').css({
                  opacity: 0/*,
                  overflow: 'hidden'*/
                });
        </script>
EOFP;

$url =  url('', array('absolute' => true)) ;

$profile = node_load(array(
  'uid' => $user->uid,
  'type' => 'profile_member',
));

$flashvars_arr = array(
  'thePerson' => $profile->field_first_name[0]['value'] . ' ' . $profile->field_last_name[0]['value'],
  'form_id' => $form['form_id']['#value'],
  'form_build_id' => $form['form_build_id']['#value'],
  'form_token' => $form['form_token']['#value'],
  'url' => url('node/' . $nid),
);

if ( $form['form_id']['#value'] == 'webform_client_form_121' || 'webform_client_form_71' || 'webform_client_form_120' || 'webform_client_form_121' || 'webform_client_form_122' || 'webform_client_form_123' || 'webform_client_form_124' || 'webform_client_form_125'){
  $person = db_fetch_object(db_query('
    SELECT wd.data, wc.extra
    FROM {webform_submissions} ws
    LEFT JOIN {webform_submitted_data} wd ON wd.sid = ws.sid && wd.cid = 2
    LEFT JOIN {webform_component} wc ON wc.nid = wd.nid && wc.cid = 2
    WHERE ws.uid = %d && ws.nid = 18
    ORDER BY ws.submitted DESC
  ',$user->uid));

  $person_extra = @unserialize($person->extra);

  foreach ( explode("\n",$person_extra['items']) as $val ){
		$peson_val = explode("|",$val);

    if ( $peson_val[0] == $person->data ){
      $flashvars_arr['thePerson'] = $peson_val[1];
      break;
    }
  }

}

$flashvars = array();

foreach ($flashvars_arr as $key => $value) {
  $flashvars[]= urlencode($key) . '=' . urlencode($value);
}

$flashvars = '&' . implode('&', $flashvars);


$flash_file = $form['form_id']['#value'] == 'webform_client_form_18' ? 'registration_machine-left.swf' : 'survey_machine.swf';

$flash_closing = <<<EOFC
</div>
<div id="flashid" style="width:968px;height:1250px;">
         <script type="text/javascript" language="JavaScript">
                document.getElementById('flashid').style.overflow = 'hidden';
                function setFlashWidth(divid, newW){
                        document.getElementById(divid).style.width = newW+"px";
                }
                function setFlashHeight(divid, newH){
                        document.getElementById(divid).style.height = newH+"px";
                }
                function setFlashSize(divid, newW, newH){
                        setFlashWidth(divid, newW);
                        setFlashHeight(divid, newH);
                }
                function canResizeFlash(){
                        var ua = navigator.userAgent.toLowerCase();
                        var opera = ua.indexOf("opera");
                        if( document.getElementById ){
                                if(opera == -1) return true;
                                else if(parseInt(ua.substr(opera+6, 1)) >= 7) return true;
                        }
                        return false;
                }
                var uagent = navigator.userAgent.toLowerCase();
                if (uagent.search('ipad')>-1 || uagent.search('ipod')>-1 || uagent.search('iphone')>-1 || uagent.search('android')>-1 || uagent.search('blackberry')>-1) {
                        mydiv2 = document.getElementById("flashid");
                        mydiv2.style['display'] = 'none';
                                                mydiv2.style['opacity'] = 0;
                } else {
                        e = canResizeFlash();
                        mydiv = document.getElementById("theform");
                        mydiv.style['display'] = 'none';
                                                mydiv.style['height'] = 0;
                        document.write('<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0" width="100%" height="100%" title="slideMovie" id="careform">'); 
						document.write('<param name="movie" value="${url}${flash_file}" />');
						document.write('<param name="quality" value="high" />');
						document.write('<param name="allowScriptAccess" value="always" />'); 
						document.write('<param name="FlashVars" value="allowResize='+e+'${flashvars}" />');
						document.write('<param name="allowResize" value="true" />'); 
						document.write('<param name="wmode" value="opaque" />');
						document.write('<embed src="${url}${flash_file}" width="100%" height="100%" quality="high" pluginspage="http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash" type="application/x-shockwave-flash" allowscriptaccess="always" flashvars="allowResize='+e+'${flashvars}" wmode="opaque"></embed>'); 
document.write('</object>');
                }
                mydiv4 = document.getElementById("theform");
                $(mydiv4).css('opacity', 1);
        </script>
</div>
EOFC;

  print $flash_preamble;

  // If editing or viewing submissions, display the navigation at the top.
  if (isset($form['submission_info']) || isset($form['navigation'])) {
    print drupal_render($form['navigation']);
    print drupal_render($form['submission_info']);
  }

  // Print out the main part of the form.
  // Feel free to break this up and move the pieces within the array.
  print drupal_render($form['submitted']);

  // Always print out the entire $form. This renders the remaining pieces of the
  // form that haven't yet been rendered above.
  print drupal_render($form);

  // Print out the navigation again at the bottom.
  if (isset($form['submission_info']) || isset($form['navigation'])) {
    unset($form['navigation']['#printed']);
    print drupal_render($form['navigation']);
  }

  print $flash_closing;

