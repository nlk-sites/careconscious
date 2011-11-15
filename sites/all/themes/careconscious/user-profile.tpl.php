<?php
/* read todo items */

/* get_user_tags  -  see aalter module  */
$aUserTags = get_user_tags($account);

// $aUserTags = array();
//print_r($aUserTags);exit;
$todo_items = array();

$uid = arg(1);

$last_submission = db_fetch_object(db_query('
  SELECT n.nid, n.title
  FROM {webform_submissions} ws
  INNER JOIN {content_type_webform} cb ON cb.nid = ws.nid
  INNER JOIN {node} n ON n.nid = cb.field_principle_nid_nid
  WHERE ws.uid = %d
  ORDER BY ws.submitted DESC
  LIMIT 0, 1
', $uid));  

$last_submission->number = explode(' ', $last_submission->title);
$last_submission->number = intval($last_submission->number[1]);

$todolists_ids = array();
$result = @db_query("
    SELECT
      n.nid, n.type, nr.title, nr.body,
      ct.field_tags_value AS tags, np.title AS p_title
    FROM
      {node} n
    LEFT JOIN {content_type_todo} ct ON ct.nid = n.nid
    LEFT JOIN {node_revisions} nr ON nr.nid = n.nid
    RIGHT JOIN {node} np ON np.nid = ct.field_parent_principle_nid
    WHERE
      n.type = 'todo' && ct.field_parent_principle_nid = %d
    GROUP BY 
      n.nid
    ORDER BY
      n.changed DESC
  ", $last_submission->nid);
 
while ($node = @db_fetch_object($result)) {
	//print_r($node);exit;
	if ($node->type != 'todo') {
    continue;
  }
//    $router_item = menu_get_item("node/".$node->vid);

  $atags = explode(" ", $node->tags);
  if (is_array($atags) && count($atags)) {
  
    foreach ($atags as $key => $val) {
      $val = str_replace(',', '', $val);
      if (isset($aUserTags[$val])) {
      
        //$todo_items_cnt .= '<li>'.$router_item['page_arguments'][0]->title.'</li>';
        // print_r($router_item['page_arguments']);exit;
        
        $group = $node->p_title;
        // $value = $node->body ? $node->body : $node->title;
        $value = $node->title;
        $todo_items[$group][] = '<li>' . $value . '</li>';
        break;
      }
    }
  }
	
}

// print_r($todo_items);exit;

$todo_items_cnt = "";

if (count($todo_items)) {
	
	$rows_limit = 6;

	foreach ($todo_items as $key => $val) {
		if ($rows_limit == 0) {
			continue;
		}
		$rows_limit --;

		$todo_items_cnt .= ( '<font style="font-size: 12px;">' . $key . '</font><br> <ul>');

		foreach ($val as $skey => $sval) {
			if ($rows_limit == 0) {
				continue;
			}
			$rows_limit --;
			$todo_items_cnt .= $sval;
		}

		$todo_items_cnt .='</ul>';
	}
}

$completed_principles = array();
foreach ($aUserTags as $tag) {
	if (preg_match('|P(\d+)_Q\d+_.*|', $tag, $matches)) {
    $completed_principles[$matches[1]] = true;
	}
}


$full_name = check_plain(
				$account->member_data->field_first_name[0]['value'] . ' ' .
				$account->member_data->field_last_name[0]['value']);
drupal_set_title($full_name);

$own_profile = $user->uid == $account->uid;

$owner_desc = $own_profile ? 'My' : check_plain($account->member_data->field_first_name[0]['value']) . "'s";
?>

<div class="profile">
<div class="greeting">
</div>

  <div class="profile-navigation-holder">
    <div class="profile-navigation">
          <div class="nav-profile"><?= l('Caregiving Tasks', 'user/' . $account->uid . '/todos') ?></div>
          <div class="nav-profile"><?= l('Resources', 'user/' . $account->uid . '/resources') ?></div>
          <!--<div class="nav-profile"><?= l('Service Providers', 'providers') ?></div>-->
          <div class="nav-profile"><?= l('Expert Questions', 'user/' . $account->uid . '/questions') ?></div>
          <div class="nav-profile"><?= l('My Community Posts', 'user/' . $account->uid . '/posts') ?></div>
    </div>
  </div>
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
						<li><a href="/user/<?php print $account->uid ?>/edit">Edit Account</a></li>
					</ul>	
					<p class="teeny">Change password or add a photo</p>
					
					<ul>	
						<li><a href="http://careconscious.com/content/program-registration">Edit Profile</a></li>
					</ul>	
					<p class="teeny">Update your profile questions</p>
				</div>	
        
        <div id="profilePrinciples">
				<div class="sectionTitlePrinciplesCompleted">
					<div class="sectionTitleLeft"><h3>Complete the Program</h3></div>
				</div>
				<div class="sectionContentShell">
					<div class="sectionContentItem">
							<?php /* <ol>
							  <li class="principleComplete">Know your world</li>
							  <li class="principleComplete">Give and get emotional social support</li>
							  <li class="principleComplete">Work with family dynamics</li>
							  <li>Safety Matters</li>
							  <li>Understand residential wants and needs</li>
							  <li>Plan properly</li>
							  <li>Helping with healthcare</li>
							  <li>Talk, even about the tough stuff</li>
							  </ol> */ ?>
						<?php
						// Because principles are hardcoded, completion status hardcoded too. On refactoring, see header of this template
						?>
						<table class="principles">
							<tr class="principle<?=isset($completed_principles[1])?' principleComplete':''?>">
								<td class="col-1">1.</td>
								<td><a href="/content/principle-1-intro">Know your world</a><?=isset($completed_principles[1])?' <br /><a href="/content/principle-1-intro"><img class="completed-profile" src="/imgs/video-icon.jpg" title="Re-watch video" border="0"></a> <a href="/content/principle-1"><img class="completed-profile" src="/imgs/question-icon.jpg" title="Re-submit questions" border="0"></a>':''?></td>
							</tr>
							<tr class="principle<?=isset($completed_principles[2])?' principleComplete':''?>">
								<td class="col-1">2.</td>
								<td><a href="/content/principle-2-intro">Maintain emotional stability</a><?=isset($completed_principles[2])?' <br /><a href="/content/principle-2-intro"><img class="completed-profile" src="/imgs/video-icon.jpg" title="Re-watch video" border="0"></a> <a href="/content/principle-2"><img class="completed-profile" src="/imgs/question-icon.jpg" title="Re-submit questions" border="0"></a>':''?></td>
							</tr>
							<tr class="principle<?=isset($completed_principles[3])?' principleComplete':''?>">
								<td class="col-1">3.</td> 
								<td><a href="/content/principle-3-intro">Deal with family dynamics</a><?=isset($completed_principles[3])?' <br /><a href="/content/principle-3-intro"><img class="completed-profile" src="/imgs/video-icon.jpg" title="Re-watch video" border="0"></a> <a href="/content/principle-3"><img class="completed-profile" src="/imgs/question-icon.jpg" title="Re-submit questions" border="0"></a>':''?></td>
							</tr>
							<tr class="principle<?=isset($completed_principles[4])?' principleComplete':''?>">
								<td class="col-1">4.</td>
								<td><a href="/content/principle-4-intro">Safety matters</a><?=isset($completed_principles[4])?' <br /><a href="/content/principle-4-intro"><img class="completed-profile" src="/imgs/video-icon.jpg" title="Re-watch video" border="0"></a> <a href="/content/principle-4"><img class="completed-profile" src="/imgs/question-icon.jpg" title="Re-submit questions" border="0"></a>':''?></td>
							</tr>
							<tr class="principle<?=isset($completed_principles[5])?' principleComplete':''?>">
								<td class="col-1">5.</td>
								<td><a href="/content/principle-5-intro">Understand residential needs</a><?=isset($completed_principles[5])?' <br /><a href="/content/principle-5-intro"><img class="completed-profile" src="/imgs/video-icon.jpg" title="Re-watch video" border="0"></a> <a href="/content/principle-5"><img class="completed-profile" src="/imgs/question-icon.jpg" title="Re-submit questions" border="0"></a>':''?></td>
							</tr>
							<tr class="principle<?=isset($completed_principles[6])?' principleComplete':''?>">
								<td class="col-1">6.</td>
								<td><a href="/content/principle-6-intro">Plan properly</a><?=isset($completed_principles[6])?' <br /><a href="/content/principle-6-intro"><img class="completed-profile" src="/imgs/video-icon.jpg" title="Re-watch video" border="0"></a> <a href="/content/principle-6"><img class="completed-profile" src="/imgs/question-icon.jpg" title="Re-submit questions" border="0"></a>':''?></tr>
							<tr class="principle<?=isset($completed_principles[7])?' principleComplete':''?>">
								<td class="col-1">7.</td>
								<td><a href="/content/principle-7-intro">Help with healthcare</a><?=isset($completed_principles[7])?' <br /><a href="/content/principle-7-intro"><img class="completed-profile" src="/imgs/video-icon.jpg" title="Re-watch video" border="0"></a> <a href="/content/principle-7"><img class="completed-profile" src="/imgs/question-icon.jpg" title="Re-submit questions" border="0"></a>':''?></td>
							</tr>
							<tr class="principle<?=isset($completed_principles[8])?' principleComplete':''?>">
								<td class="col-1">8.</td>
								<td><a href="/content/principle-8-intro">End the cycle of generational dependency</a><?=isset($completed_principles[8])?' <br /><a href="/content/principle-8-intro"><img class="completed-profile" src="/imgs/video-icon.jpg" title="Re-watch video" border="0"></a> <a href="/content/principle-8"><img class="completed-profile" src="/imgs/question-icon.jpg" title="Re-submit questions" border="0"></a>':''?></td>
							</tr>
						</table>
					</div>
				</div>
			</div>
        
<?php endif ?>
			</div>	
	
			<div id="profileColumn2">	
			<?php if ($own_profile && $account->roles[4]): # Role 4 is Care Provider ?>
      
      <div class="profileRecentActivity" id="profileRecentToDos">	
					<div class="sectionTitle">	
						<div class="sectionTitleLeft"><h3>My Caregiving Tasks</h3></div>	
						<div class="sectionTitleRight"><?= l('View all', 'user/' . $account->uid . '/todos') ?></div>
					</div>	
					<div class="sectionContentShell">	
						<div class="sectionContentItem">	
	
<?php if ($todo_items_cnt != "") { ?>
								<div class="content">		
<?php echo $todo_items_cnt; ?>
<?= l('View additional Tasks', 'user/' . $account->uid . '/todos') ?>
								</div>		
		
<?php
							} else {
								echo '<p>No To-Dos</p>';
							}
?>
				
									</div>				
								</div>				
				</div>		
      
				<div id="profileColumn2Shell1">	
					<div id="profileNewResources">	
						<div class="sectionTitle">	
							<div class="sectionTitleLeft"><h3>New Resources, just for you!</h3></div>	
						<div class="sectionTitleRight"><?= l('View all', 'user/' . $account->uid . '/resources') ?></div>
						</div>	
						
						<div class="sectionContentShell">	
							<div class="sectionContentItem">
<?php
				//71 - Principle 6 Form ID

				$parsed_data = array();
				$submitted_data = array();
				//$form_submitted = array();
				

				if (is_array($aUserTags) && count($aUserTags)) {
					/*$sql = "SELECT `sid` FROM `search_index` WHERE `type`='node' AND `word` IN (" . implode(",", $aUserTags) . ")";
					$res = db_query($sql) or die(mysql_error());
					//if (mysql_num_rows($res)){
					while ($row = db_fetch_object($res)) {
						$parsed_data[] = $row->sid;
						$submitted_data[] = $form_submitted;
					}
					//}*/
					$terms = array();
					foreach ($aUserTags as $tag) {
						// if ($GLOBALS['user']->uid == 1) {
              // print_r(123);
              // print_r(substr($tag, 2, 1));
            // }
            if (substr($tag, 2, 1) != $last_submission->number) {
              continue;
            }
            $term = taxonomy_get_term_by_name(trim($tag, "'"));
						if ($term[0]->tid) {
							$terms[] = $term[0]->tid;
						}
						//db_fetch_object(taxonomy_select_nodes(array($term[0]->tid)));
					}
				}

//exit;

				if (is_array($terms) && count($terms)) {
					/*$sql = "SELECT `title` as `res_title`, `uid`, `vid`, `nid` as `res_nid`, `teaser` as `res_teaser`, `timestamp` as `res_date`, `format` as `res_format` FROM `node_revisions` 
WHERE `nid` IN (" . implode(",", $parsed_data) . ")  ORDER BY res_date DESC LIMIT 3";
					$result = db_query($sql, array($account->uid, $account->uid, $account->uid));*/
					$result = taxonomy_select_nodes($terms);

					$first = 'first-recommendation';
					$txt = array();
					$txt_date = array();
					while ($node = db_fetch_object($result)) {
						$row = node_load($node->nid);
            if ($row->type == 'todo') {
              continue;
            }
						$submitted_data[] = $row->created;
						$parsed_data[] = $row->nid;
						$row->res_teaser = $row->teaser;
						$row->res_date = $row->created;
						$row->res_format = $row->format;
						$row->res_title = $row->title;
						$row->res_nid = $row->nid;
						
						$link = l($row->res_title, 'node/' . $row->res_nid);

						$row->res_teaser = str_replace("[list]", "", $row->res_teaser);
						$row->res_teaser = str_replace("[u]", "", $row->res_teaser);
						$row->res_teaser = str_replace("[/list]", "", $row->res_teaser);
						$row->res_teaser = str_replace("[/u]", "", $row->res_teaser);

						$alter = array(
							'max_length' => 200,
							'word_boundary' => true,
							'ellipsis' => true,
							'html' => true,
						);

						$row->res_teaser = preg_replace('#\\[img_assist[^\\]]*\\]#', '', $row->res_teaser);
						$row->res_teaser = views_trim_text($alter,
										strip_tags($row->res_teaser));

						$txt[$row->nid] = "
<div class='recommendation $first'>
  <div class='recommendation-header'>
    <p>$link</p>
  </div>
  <div class='recommendation-body'>
    <p>$row->res_teaser</p>
  </div>
</div>";
						$txt_date[$row->nid] = $row->res_date;
						$first = '';
					}


					
					  /*print_r($parsed_data);
					  print_r($submitted_data);
					  print_r($txt_date);
					  print_r($txt); */

					$all_data_sorted = array();

					foreach ($parsed_data as $key => $val) {

						if ($submitted_data[$key] > $txt_date[$val]) {
							for ($c = 0; $c < 1024; $c++) {
								if (isset($all_data_sorted[$submitted_data[$key] + $c])) {
									continue;
								} else {
									$all_data_sorted[$submitted_data[$key] + $c] = $txt[$val];
									break;
								}
							}
						} else {

							for ($c = 0; $c < 1024; $c++) {
								if (isset($all_data_sorted[$txt_date[$val] + $c])) {
									continue;
								} else {
									$all_data_sorted[$txt_date[$val] + $c] = $txt[$val];
									break;
								}
							}
						}
					}

					ksort($all_data_sorted, SORT_NUMERIC);
					$all_data_sorted = array_reverse($all_data_sorted);
					$all_data_sorted = array_slice($all_data_sorted, 0, 3);

					//echo $all_data_sorted;exit;
				}
				if ($first) {
					echo $txt . "
<div class='no-recommendation'>
  <p>Nothing to recommend</p>
</div>";
				} else {
					if (is_array($all_data_sorted)) {
						echo implode("", $all_data_sorted);
						echo '<div class="additional">'.l('View additional Resources', 'user/' . $account->uid . '/resources').'</div>';
					} else {
						echo $txt . "
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
			
<?php endif # $own_profile && $account->roles[4]  ?>
        
        <div class="profileRecentActivity" id="profileProviders">	
					<div class="sectionTitle">	
						<div class="sectionTitleLeft"><h3>Service Providers</h3></div>	
						<!--<div class="sectionTitleRight"><?= l('View all', 'providers') ?></div>-->
					</div>	
					<div class="sectionContentShell">	
						<div class="sectionContentItem">	
							<p>Service provider recommendations for you are coming soon!</p>	
						</div>	
					</div>	
				</div>	
							<div class="profileRecentActivity" id="profileRecentQuestions">				
								<div class="sectionTitle">				
									<div class="sectionTitleLeft"><h3><?php echo $owner_desc ?> Questions to Experts</h3></div>
						<div class="sectionTitleRight"><?= l('View all', 'user/' . $account->uid . '/questions') ?></div>
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
						<div class="sectionTitleRight"><?= l('View all', 'user/' . $account->uid . '/posts') ?></div>
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
	
			</div>	
		</div>	
	
	</div>	