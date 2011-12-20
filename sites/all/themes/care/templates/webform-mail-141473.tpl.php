<?php
  $hash = md5("fretdsfte");
  ob_start();
  print "--".$hash."\n"
  ."Content-Type: text/plain; charset=ISO-8859-1\n";
?>
Thank you for submitting your contact info.  You may sign up for an account at <?php echo l('user/register');?>.

<?php

    print "--".$hash."\n"
      ."Content-Type: application/pdf; name=8_Principles_Overview.pdf"."\n"
      ."Content-Disposition: attachment; filename=8_Principles_Overview.pdf"."\n"
      ."Content-Transfer-Encoding: base64\n\n"
      .chunk_split(base64_encode(file_get_contents('sites/default/files/8_Principles_Overview.pdf')))."\n";

   print "--".$hash."--";
   print(ob_get_clean());
?>