<?php


/*read todo items*/

  $aUserTags = get_user_tags($account);
 // $aUserTags = array();
  //print_r($aUserTags);exit;
  $todo_items = array();
  
 $todolists_ids = array();
 $result = db_query("SELECT * FROM `node` WHERE `type` = 'todo' ORDER BY `changed` DESC");
 while ($node = db_fetch_object($result)) {
 	
 	//print_r($node);exit;
 	if ($node->type == 'todo'){
 		
      $router_item = menu_get_item("node/".$node->vid);
      
      $atags = explode(" ", $router_item['page_arguments'][0]->field_tags[0]['value']);
    //  print_r($router_item);exit;
      if (is_array($atags) && count($atags)){
      	
      	foreach ($atags as $key => $val){
      		
      		if (isset($aUserTags[$val])){
      		 //$todo_items_cnt .= '<li>'.$router_item['page_arguments'][0]->title.'</li>';
      		 
      		// print_r($router_item['page_arguments']);exit;
      		 
      			
      		 $todo_items[$router_item['page_arguments'][0]->field_parent_principle[0]['value']][] = '<li>'.$router_item['page_arguments'][0]->title.'</li>';
      		 break;
      		}
      		
      	}
      	
       }
       
       
 	 }
   }  
   
  // print_r($todo_items);exit;
   
 $todo_items_cnt = "";
 
 if(count($todo_items)){
 	
   foreach ($todo_items as $key=>$val){
   	
      $todo_items_cnt .= ('<font style="margin-left: 18px; font-size: 15px;">'.$key.'</font><br> <ul>');
   	
       foreach ($val as $skey=>$sval){
      	   $todo_items_cnt .= $sval;
        }
      
      $todo_items_cnt .='</ul>';
      
     }
   
  }



  $full_name = check_plain(
    $account->member_data->field_first_name[0]['value'] . ' ' .
    $account->member_data->field_last_name[0]['value']);
  drupal_set_title($full_name);

  $own_profile = $user->uid == $account->uid;

  $owner_desc = $own_profile
    ? 'Your'
    : check_plain($account->member_data->field_first_name[0]['value']) . "'s";
?>

<div class="profile">

<div id="profileShell">
  <div id="profileHeader">
    <div id="profileHeaderName"><?php print $full_name ?></div>
    <div id="profileHeaderInfo">Member since <?php print format_date($account->created, 'custom', 'F j, Y'); ?></div>
  </div>

  <div id="profileColumn1">
    <?php print $account->content['user_picture']['#value']; ?>
    <?php if ($own_profile): ?>
    <div id="profileColumn1Settings">
      <h3>Account Info</h3>
      <ul>
        <li><a href="/user/<?php print $account->uid ?>/edit">Edit Profile</a></li>
      </ul>
    </div>
    <?php endif ?>
  </div>

  <div id="profileColumn2">
  <?php if ($own_profile && $account->roles[4]): # Role 4 is Care Provider ?>
    <div id="profileColumn2Shell1">
      <div id="profileNewResources">
        <div class="sectionTitle">
          <div class="sectionTitleLeft"><h3>New Resources, just for you!</h3></div>
        </div>
        <div class="sectionContentShell">
          <div class="sectionContentItem">
<?php

  //71 - Principle 6 Form ID
  
   $parsed_data = array();
   $submitted_data = array();
   //$form_submitted = array();
   
   if (is_array($aUserTags) && count($aUserTags)){
     $sql = "SELECT `sid` FROM `search_index` WHERE `type`='node' AND `word` IN (".implode(",", $aUserTags).")";
     $res = db_query($sql) or die(mysql_error());
     //if (mysql_num_rows($res)){
       while($row = db_fetch_object($res)){
      	 $parsed_data[] = $row->sid;
      	 $submitted_data[] = $form_submitted;
        }
      //}
   }
      
//exit;
   
if (is_array($parsed_data) && count($parsed_data)){
$sql = "SELECT `title` as `res_title`, `uid`, `vid`, `nid` as `res_nid`, `teaser` as `res_teaser`, `timestamp` as `res_date`, `format` as `res_format` FROM `node_revisions` 
WHERE `vid` IN (".implode(",", $parsed_data).")  ORDER BY res_date DESC LIMIT 3";
$result = db_query($sql, array($account->uid, $account->uid, $account->uid));

$first = 'first-recommendation';
$txt = array();
$txt_date = array();
while ($row = db_fetch_object($result)) {
  $link = l($row->res_title, 'node/' . $row->res_nid);
  
  $row->res_teaser = str_replace("[list]", "", $row->res_teaser);
  $row->res_teaser = str_replace("[u]", "", $row->res_teaser);
  $row->res_teaser = str_replace("[/list]", "", $row->res_teaser);
  $row->res_teaser = str_replace("[/u]", "", $row->res_teaser);
  
  $txt[$row->vid] = "
<div class='recommendation $first'>
  <div class='recommendation-header'>
    <p>$link</p>
  </div>
  <div class='recommendation-body'>
    <p>$row->res_teaser</p>
  </div>
</div>";
  $txt_date[$row->vid] = $row->res_date;
  $first = '';
}


/*
 print_r($parsed_data);
  print_r($submitted_data);
 print_r($txt_date);
  print_r($txt);*/
  
 $all_data_sorted = array();
 
 foreach ($parsed_data as $key => $val)
  {
 	
    if ($submitted_data[$key] > $txt_date[$val])
 	{
 	 for ($c = 0; $c < 1024; $c++)
 	  {
 	    if (isset($all_data_sorted[$submitted_data[$key]+$c])){
 	  	  continue;
 	     }else{
 	      $all_data_sorted[$submitted_data[$key]+$c] = $txt[$val];
 	      break;
 	     }
 	  }
 	}else{
 		
 	 for ($c = 0; $c < 1024; $c++)
 	  {
 	    if (isset($all_data_sorted[$txt_date[$val]+$c])){
 	  	  continue;
 	     }else{
 	      $all_data_sorted[$txt_date[$val]+$c] = $txt[$val];
 	      break;
 	     }
 	  }
 	  
 	}
 	
  }
  
  ksort($all_data_sorted, SORT_NUMERIC);
  $all_data_sorted = array_reverse($all_data_sorted);
  
  //echo $all_data_sorted;exit;
}
if ($first) {
  echo $txt."
<div class='no-recommendation'>
  <p>Nothing to recommend</p>
</div>";
}else{
	if (is_array($all_data_sorted)){
	 echo implode("", $all_data_sorted);
	}else{
		  echo $txt."
<div class='no-recommendation'>
  <p>Nothing to recommend</p>
</div>";
	}
}
?>
          </div>
        </div>
      </div>
    </div>
    <div id="profilePrinciples">
      <div class="sectionTitle">
        <div class="sectionTitleLeft"><h3>Principles Completed</h3></div>
      </div>
      <div class="sectionContentShell">
        <div class="sectionContentItem">
          <ol>
            <li class="principleComplete">Know your world</li>
            <li class="principleComplete">Give and get emotional social support</li>
            <li class="principleComplete">Work with family dynamics</li>
            <li>Safety Matters</li>
            <li>Understand residential wants and needs</li>
            <li>Plan properly</li>
            <li>Helping with healthcare</li>
            <li>Talk, even about the tough stuff</li>
          </ol>
        </div>
      </div>
    </div>
  <?php endif # $own_profile && $account->roles[4] ?>
  
  <div class="profileRecentActivity" id="profileRecentToDos">
      <div class="sectionTitle">
        <div class="sectionTitleLeft"><h3>To-Dos for You</h3></div>
        <div class="sectionTitleRight"><a href="/user/<?php print $account->uid ?>/posts">View all</a></div>
      </div>
      <div class="sectionContentShell">
        <div class="sectionContentItem">

           <?php if($todo_items_cnt != ""){?>
           	 <div class="content"> <?php echo $todo_items_cnt;?></div>
           <?php }else{
              echo '<p>No To-Dos</p>';
           }?>

        </div>
      </div>
    </div>

    <div class="profileRecentActivity" id="profileRecentQuestions">
      <div class="sectionTitle">
        <div class="sectionTitleLeft"><h3><?php echo $owner_desc ?> Questions to Experts</h3></div>
        <div class="sectionTitleRight"><a href="/user/<?php print $account->uid ?>/questions">View all</a></div>
      </div>
      <div class="sectionContentShell">
        <div class="sectionContentItem">
          <?php
          $items = views_embed_view('user_questions', 'default', $account->uid);
          print $items;
          ?>
        </div>
      </div>
    </div>

    <div class="profileRecentActivity" id="profileRecentPosts">
      <div class="sectionTitle">
        <div class="sectionTitleLeft"><h3><?php echo $owner_desc ?> Posts</h3></div>
        <div class="sectionTitleRight"><a href="/user/<?php print $account->uid ?>/posts">View all</a></div>
      </div>
      <div class="sectionContentShell">
        <div class="sectionContentItem">
          <?php
          $items = views_embed_view('user_posts', 'default', $account->uid);
          print $items;
          ?>
        </div>
      </div>
    </div>

    <div class="profileRecentActivity" id="profileProviders">
      <div class="sectionTitle">
        <div class="sectionTitleLeft"><h3>Service Providers</h3></div>
        <div class="sectionTitleRight"><a href="/providers">View all</a></div>
      </div>
      <div class="sectionContentShell">
        <div class="sectionContentItem">
          <p>Click 'View all' to see Service Providers</p>
        </div>
      </div>
    </div>

  </div>
</div>

</div>


<?php 

function get_user_tags($account){
	
 $tmpparsed_data = array();
 $form_ids = array();
 $form_principle = array();
 $result = db_query("SELECT n . * , r . * FROM `node` AS n INNER JOIN `node_revisions` r ON n.vid = r.vid WHERE n.type = 'webform' AND n.`title` LIKE 'Principle %'");
 while ($node = db_fetch_object($result)) {
 	if ($node->type == 'webform'){
     $form_ids[] = $node->vid;
     $pieces = explode(" ", $node->title);
     $form_principle[] = $pieces[1];
 	 }
   }

   if (is_array($form_ids) && count($form_ids)){
   	
   	foreach ($form_ids as $key => $val){
  
  $sql = "SELECT `sid`, `submitted` FROM `webform_submissions` WHERE `uid`='".$account->uid."' AND `nid`='".$val."'";
  $res = db_query($sql) or die(mysql_error());
  
  $the_data = db_fetch_object($res);
  //echo $the_data->sid;exit;
  
  if($the_data->sid == ""){
  	continue;
   }

  @$sid = $the_data->sid;
  @$form_submitted = $the_data->submitted;
  
   if($sid == ""){
  	continue;
   }

  $path = "node/".$val."/submission/".$sid;
  
  if (!isset($router_items[$path])) {
    $original_map = arg(NULL, $path);
    $parts = array_slice($original_map, 0, MENU_MAX_PARTS);
    list($ancestors, $placeholders) = menu_get_ancestors($parts);
    if ($router_item = db_fetch_array(db_query_range('SELECT * FROM {menu_router} WHERE path IN ('. implode (',', $placeholders) .') ORDER BY path DESC', $ancestors, 0, 1))) {
      $map = _menu_translate($router_item, $original_map);
      if ($router_item['access']) {
        $router_item['map'] = $map;
        $router_item['page_arguments'] = array_merge(menu_unserialize($router_item['page_arguments'], $map), array_slice($map, $router_item['number_parts']));
      }
    }
    $router_items[$path] = $router_item;
  }


  	$my_array = $router_items["node/".$val."/submission/".$sid]['page_arguments'][1]->data;
//print_r($router_items["node/".$val."/submission/".$sid]['page_arguments']);exit;
  if (is_array($my_array) && count($my_array)){
    foreach ($my_array as $key1 => $val1){
      //format: p3q7yes (for test)
      $tag = "p".$form_principle[$key]."q".$key1.(($val1['value'][0] != "0")?'no':'yes');
      $tmpparsed_data[$tag] = "'".$tag."'";
      
      //format: P6Q10yes
      $tag = "P".$form_principle[$key]."Q".$key1.(($val1['value'][0] != "0")?'no':'yes');
      $tmpparsed_data[$tag] = "'".$tag."'";
      
      //format: P610yes
      $tag = "P".$form_principle[$key].$key1.(($val1['value'][0] != "0")?'no':'yes');
      $tmpparsed_data[$tag] = "'".$tag."'";
      
      //format: P6-Q10-yes
      $tag = "P".$form_principle[$key]."-Q".$key1."-".(($val1['value'][0] != "0")?'no':'yes');
      $tmpparsed_data[$tag] = "'".$tag."'";
      
      //format: P6_10_yes
      $tag = "P".$form_principle[$key]."_".$key1."_".(($val1['value'][0] != "0")?'no':'yes');
      $tmpparsed_data[$tag] = "'".$tag."'";
      
      //format: P6_Q10_yes
      $tag = "P".$form_principle[$key]."_Q".$key1."_".(($val1['value'][0] != "0")?'no':'yes');
      $tmpparsed_data[$tag] = "'".$tag."'";
      
      //format: P6_10_0
      $tag = "P".$form_principle[$key]."_".$key1."_".$val1['value'][0];
      $tmpparsed_data[$tag] = "'".$tag."'";
      
      //format: P6-Q10-0
      $tag = "P".$form_principle[$key]."-Q".$key1."-".$val1['value'][0];
      $tmpparsed_data[$tag] = "'".$tag."'";
     }
   }
  }//foreach
 }


 return $tmpparsed_data;
}


?>
