<?

$numPerPage = 10;



	$currentLink = array();
	$q = "SELECT fl_forum_threads.*, fl_users.username, UNIX_TIMESTAMP( fl_forum_threads.insDate ) AS unixTime FROM fl_forum_threads LEFT JOIN fl_users ON fl_forum_threads.userId = fl_users.id WHERE fl_forum_threads.slug = '".addslashes($_GET["thread"])."' AND fl_forum_threads.newThread = 'YES' LIMIT 1";
	$currentLink["date"] = " class=\"current\"";
#echo $q;
	$mailArray = $DB->GetAssoc( $q, FALSE, TRUE );
#	for( $i = 0; $i < 155; $i++ )
#	{
#		$mailArray[ $i+20 ]["username"] = $i;
#	}


if ( count( $mailArray ) > 0 )
	{
	

		while ( list( $key, $value ) = each( $mailArray ) )
		{


			if (isset($_POST['addsvar'])) {
			  if (empty($_POST['text'])) {
				   echo "<script language='javascript'>alert('Blankt fält!'); self.location.href='?error';</script>";
			  } else {
			$post_id = $userProfile['id'];

			$sql = "INSERT INTO fl_forum_threads (insDate, newThread, catId, threadId, userId, headline, slug, text) VALUES(NOW(), 'NO', '".$mailArray[ $key ]["catId"]."', '".$mailArray[ $key ]["id"]."', '".$userProfile['id']."', '', '".$mailArray[ $key ]["slug"]."', '".$_POST['text']."')";
			mysql_query($sql);
			$sql = "UPDATE fl_forum_threads SET lastThreadUpdate = NOW() WHERE id = '".$mailArray[ $key ]["id"]."'";
			mysql_query($sql);
				

			   $body .= "<script language='javascript'>alert('Svaret skickat!');</script>";
			  }
			}

			if ($_POST['type'] == "editPost") {
			  if (empty($_POST['id'])) {
				  echo "<script language='javascript'>alert('Blankt fält!'); self.location.href='?error';</script>";
			  } else {
				$sql = "UPDATE fl_forum_threads SET text = '".$_POST['text']."', lastUpdate = NOW() WHERE id = '".$_POST['id']."'";
				mysql_query($sql);
				
				 $body .= "<script language='javascript'>alert('Inlägg redigerat!');</script>";

			  }
			}




if ( date("Y-m-d", $mailArray[ $key ]["unixTime"] ) == date( "Y-m-d" ) )
{
	// Message sent today
	$f_dat = "Idag kl " . date( "H:i", $mailArray[ $key ]["unixTime"] );
}
elseif ( date("Y-m-d", $mailArray[ $key ]["unixTime"] ) == date( "Y-m-d", ( time() - 86400 ) ) )
{
	// Message sent yesterday
	$f_dat = "Ig&aring;r kl " . date( "H:i", $mailArray[ $key ]["unixTime"] );
}
elseif ( date("Y", $mailArray[ $key ]["unixTime"] ) == date( "Y" ) )
{
	// Message sent this year
	$f_dat = date( "j M Y H:i", $mailArray[ $key ]["unixTime"] );
}
else
{
	$f_dat = date( "Y-m-d H:i", $mailArray[ $key ]["unixTime"] );
}

$q = "SELECT * FROM fl_images WHERE userId = " . (int)$mailArray[ $key ]["userId"] . " AND imageType = 'profileSmall'";
$mailImage = $DB->GetRow( $q, FALSE, TRUE );
if ( count( $mailImage ) > 0 )
{
	$avatar = "<img src=\"" . $baseUrl . "/user-photos/" . str_replace('http://www.flator.se/rwdx/user/', '', $mailImage["imageUrl"]) . "/profile-thumb/" . "\" border=\"0\"  />";

}
else
{
	$avatar = "<img src=\"" . $baseUrl . "/img/symbols/gif_avatars/person_avnatar_liten.gif\" border=\"0\" width=\"26\" height=\"29\" />";
}

$q = "SELECT * FROM fl_images WHERE userId = " . (int)$mailArray[ $key ]["userId"] . " AND imageType = 'profileMedium'";
$guestImage = $DB->GetRow( $q, FALSE, TRUE );
if ( count( $guestImage ) > 0 )
{
	$mediumAvatar = $guestImage["imageUrl"];
}
else
{
	$mediumAvatar = $baseUrl . "/img/symbols/gif_avatars/person_avantar_stor.gif";
}

$q = "SELECT *, UNIX_TIMESTAMP(insDate) AS unixTime FROM fl_status WHERE userId = " . (int)$mailArray[ $key ]["userId"] . " AND statusType = 'personalMessage' ORDER BY insDate DESC LIMIT 0,1";
$statusRow = $DB->GetRow( $q, FALSE, TRUE );
$mailArray[ $key ]["status"] = truncate(stripslashes($statusRow["statusMessage"]), 16, "..", TRUE, TRUE);


$q = "SELECT *, UNIX_TIMESTAMP(insDate) AS unixTime FROM fl_users_online WHERE userId = " . (int)$mailArray[ $key ]["userId"] . " ORDER BY insDate DESC LIMIT 0,1";
$onlineRow = $DB->GetRow( $q, FALSE, TRUE );
if ( ( time() - $onlineRow["unixTime"] ) < 900 && $onlineRow["unixTime"] > 0 )
{
	$mailArray[ $key ]["online"] = "Online";
}
else
{
	if ( $onlineRow["unixTime"] > 0 )
	{
		$mailArray[ $key ]["online"] = $onlineRow["unixTime"];
	}
	else
	{
		$mailArray[ $key ]["online"] = "never";
	}
}			

unset( $onlineTime );
if ( $mailArray[ $key ]["online"] == "Online" )
{
	$onlineTime = "<div class=\"email_date\">Online</div>";
} elseif ( $mailArray[ $key ]["online"] == "never" )
{
	$onlineTime = "<div class=\"email_date\">Aldrig inloggad</div>";
}
else
{
	// Possible date-types: Today, Yesterday, ThisYear, LastYear
	if ( date("Y-m-d", $mailArray[ $key ]["online"] ) == date( "Y-m-d" ) )
	{
		// Message sent today
		$onlineTime = "<div class=\"email_date\">" . "Idag kl " . date( "H:i", $mailArray[ $key ]["online"] ) . "</div>";
	}
	elseif ( date("Y-m-d", $mailArray[ $key ]["online"] ) == date( "Y-m-d", ( time() - 86400 ) ) )
	{
		// Message sent yesterday
		$onlineTime = "<div class=\"email_date\">" . "Ig&aring;r kl " . date( "H:i", $mailArray[ $key ]["online"] ) . "</div>";
	}
	elseif ( date("Y", $mailArray[ $key ]["online"] ) == date( "Y" ) )
	{
		// Message sent this year
		$onlineTime = "<div class=\"email_date\">" . date( "j M Y H:i", $mailArray[ $key ]["online"] ) . "</div>";
	}
	else
	{
		$onlineTime = "<div class=\"email_date\">" . date( "Y-m-d H:i", $mailArray[ $key ]["online"] ) . "</div>";
	}
}






$metaTitle = $mailArray[ $key ]["headline"]." - ".$forumCatSlug[$_GET["forumCat"]]["name"]." - "." - Flator.se";



	$body .= "<div id=\"center\">
<div id=\"divHeadSpace\" style=\"line-height:17px; border-bottom:none;\"><h3><span style=\"font-weight:normal;\">Diskutera </span> ".$mailArray[ $key ]["headline"]."<span style=\"font-weight:normal;\"> i forumet </span>".$forumCatSlug[$_GET["forumCat"]]["name"]."</h3></div>";

if ((int)$_GET["edit"] > 0) {


	$q = "SELECT fl_forum_threads.*, fl_users.username, UNIX_TIMESTAMP( fl_forum_threads.insDate ) AS unixTime FROM fl_forum_threads LEFT JOIN fl_users ON fl_forum_threads.userId = fl_users.id WHERE fl_forum_threads.id = '".(int)$_GET["edit"]."' LIMIT 1";
	$editPostArray = $DB->GetAssoc( $q, FALSE, TRUE );
if ( count( $editPostArray ) > 0 )
	{
		while ( list( $key2, $value2 ) = each( $editPostArray ) )
		{
			if ( $editPostArray[ $key2 ][ "userId" ] == $userProfile["id"] ) {
$body .= '
<form action="" method="post" name="editPost">'; 

$body .= '
<input type="hidden" name="id" value="'.$editPostArray[ $key2 ][ "id" ].'">
<input type="hidden" name="type" value="editPost">
Redigerar inlägg<br /><br />';
$body .= '<span onMouseOver="document.fetStil_edit.src=\'' . $baseUrl . '/img/symbols/forum/tf_bold_active.gif\'" onMouseOut="document.fetStil_edit.src=\'' . $baseUrl . '/img/symbols/forum/tf_bold.gif\'"><a href="#noexist" onClick="document.forms[\'editPost\']. elements[\'text\'].value=document.forms[\'editPost\']. elements[\'text\'].value+\'[b][/b]\'" style="font-weight: normal"><img src="' . $baseUrl . '/img/symbols/forum/tf_bold.gif" border="0" style="vertical-align:middle;" name="fetStil_edit"></a></span>
<span onMouseOver="document.kursivStil_edit.src=\'' . $baseUrl . '/img/symbols/forum/tf_italic_active.gif\'" onMouseOut="document.kursivStil_edit.src=\'' . $baseUrl . '/img/symbols/forum/tf_italic.gif\'"><a href="#noexist" onClick="document.forms[\'editPost\']. elements[\'text\'].value=document.forms[\'editPost\']. elements[\'text\'].value+\'[i][/i]\'" style="font-weight: normal"><img src="' . $baseUrl . '/img/symbols/forum/tf_italic.gif" border="0" style="vertical-align:middle;" name="kursivStil_edit"></a></span>
<span onMouseOver="document.underStruken_edit.src=\'' . $baseUrl . '/img/symbols/forum/tf_underline_active.gif\'" onMouseOut="document.underStruken_edit.src=\'' . $baseUrl . '/img/symbols/forum/tf_underline.gif\'"><a href="#noexist" onClick="document.forms[\'editPost\']. elements[\'text\'].value=document.forms[\'editPost\']. elements[\'text\'].value+\'[u][/u]\'" style="font-weight: normal"><img src="' . $baseUrl . '/img/symbols/forum/tf_underline.gif" border="0" style="vertical-align:middle;" name="underStruken_edit"></a></span>
<span onMouseOver="document.skapaLank_edit.src=\'' . $baseUrl . '/img/symbols/forum/tf_link_active.gif\'" onMouseOut="document.skapaLank_edit.src=\'' . $baseUrl . '/img/symbols/forum/tf_link.gif\'"><a href="#noexist" onClick="addurl(document.forms[\'editPost\'].elements[\'text\']);" style="font-weight: normal"><img src="' . $baseUrl . '/img/symbols/forum/tf_link.gif" border="0" style="vertical-align:middle;" name="skapaLank_edit"></a></span><br>';

$body .= '<textarea name="text" cols="50" rows="8">'.$editPostArray[ $key2 ][ "text" ].'</textarea><br />
<input type="submit" class="submit" name="andra" value="Ändra">
</form>
';
			}
		}
	}
}


if ((int)$_GET["offset"] < 1) {
$bodyContent .=  '<br>
<table style="width: 100%;" cellpadding="0" cellspacing="5">
<tbody><tr>
<td>
<table cellpadding="0" cellspacing="0" width="100%">

<tbody>

<tr>
<td style="width: 120px; vertical-align:top;">
<a href="'.($mailArray[ $key ]["username"] != "" ? $baseUrl.'/user/'.$mailArray[ $key ]["username"].'.html' : "#noexist").'">'.(strlen($mailArray[ $key ]["username"]) < 1 ? "Ej längre medlem" : $mailArray[ $key ]["username"]).'</a><br>
<div style="font-size:10px">' . $mailArray[ $key ]["status"] . "</div>" . $onlineTime . '<br>
<a href="javascript:void(null)" onClick="showImage2(\'popupMediumImage'.$key.'\',\'' . $mediumAvatar . '\', \'mediumProfileImage'.$key.'\');" style="font-weight: normal;">' . $avatar . '</a>';
$bodyContent .= "<div style=\"position:relative;\"><div id=\"popupMediumImage".$key."\" style=\"display: none; position:absolute;border: 2px solid #645d54; top: 0px; left: 0px; z-index: 101; background-color: #ffffff; \"><div style=\"margin: 0px;\"><div style=\"float: left; display: block;\"><a href=\"javascript:void(null)\" onclick=\"closeImage2('popupMediumImage".$key."');\"><img src=\"".$baseUrl."/img/symbols/gif_avatars/person_avantar_stor.gif\" id=\"mediumProfileImage".$key."\" border=\"0\" style=\"margin: 3px;\" /></a></div></div></div></div>";	
$bodyContent .= '
</td>

<td style="padding-left: 5px; vertical-align:top;" rowspan="2"><div style="border-bottom:1px dotted #c8c8c8; font-size:11px;"><b>Tråd: </b>'.$threadSubject.'</div><br>';
$text = $mailArray[ $key ]['text']." ";
$text = $parser->p($text, 1, 1, 1, 1, 1, 0);
//$text = nl2br($text);
$bodyContent .=  $text;
$bodyContent .=  '<br><br><br>
<i>'.($mailArray[ $key ]['lastUpdate'] != "0000-00-00 00:00:00" ? "Redigerad: ".$mailArray[ $key ]['lastUpdate'] : "").'</i>
</td>
</tr>

<tr>
<td style="width: 120px; vertical-align:top;">
</td>
</tr>
<tr>
<td style="border-bottom:1px dotted #c8c8c8; font-size:5px; line-height:5px;" colspan="2">&nbsp;</td>
</tr>
<tr>
<td colspan="2" style="padding-top:3px;">';
if ($userProfile['id'] == $mailArray[ $key ]['userId']){
$bodyContent .=  '<span style="float:left; font-size:11px;"><a href="'.$baseUrl.'/forum/'.$_GET["forumCat"].'/'.$_GET["thread"].'.html?edit='.$mailArray[ $key ]['id'].'">Redigera</a></span>';
}
$bodyContent .= '<span style="float:right; font-size:11px;"><b>Inlägg publicerat:</b>  '.$f_dat.'</span>';

$bodyContent .= '</td>

</tr>
</tbody></table>                
</td>
</tr></tbody></table><br>';
$printed++;
} else {
$bodyContent .= "<br>";
}

			$record = array();
			$record["views"] = ((int)$mailArray[ $key ]['views'] + 1);
			$DB->AutoExecute( "fl_forum_threads", $record, 'UPDATE', 'id = ' . $mailArray[ $key ]['id'] );
}}
$limitQuery = " LIMIT ".((int)$_GET["offset"] > 0 ? (int)$_GET["offset"].', '.$numPerPage : $numPerPage-1);

	$q = "SELECT fl_forum_threads.*, fl_users.username, UNIX_TIMESTAMP( fl_forum_threads.insDate ) AS unixTime FROM fl_forum_threads LEFT JOIN fl_users ON fl_forum_threads.userId = fl_users.id WHERE fl_forum_threads.slug = '".addslashes($_GET["thread"])."' AND fl_forum_threads.newThread = 'NO' ORDER BY id ASC".$limitQuery;
	$countQuery = "SELECT count(fl_forum_threads.id) FROM fl_forum_threads LEFT JOIN fl_users ON fl_forum_threads.userId = fl_users.id WHERE fl_forum_threads.slug = '".addslashes($_GET["thread"])."' AND fl_forum_threads.newThread = 'NO'";
#echo 	$countQuery;
	#echo $q;
	$currentLink["date"] = " class=\"current\"";


	$countResult = $DB->GetRow( $countQuery, FALSE, TRUE );

	$mailArray = $DB->GetAssoc( $q, FALSE, TRUE );

	if ( count( $mailArray ) > 0 )
	{
		while ( list( $key, $value ) = each( $mailArray ) )
		{

	




			if ( date("Y-m-d", $mailArray[ $key ]["unixTime"] ) == date( "Y-m-d" ) )
			{
				// Message sent today
				$f_dat = "Idag kl " . date( "H:i", $mailArray[ $key ]["unixTime"] );
			}
			elseif ( date("Y-m-d", $mailArray[ $key ]["unixTime"] ) == date( "Y-m-d", ( time() - 86400 ) ) )
			{
				// Message sent yesterday
				$f_dat = "Ig&aring;r kl " . date( "H:i", $mailArray[ $key ]["unixTime"] );
			}
			elseif ( date("Y", $mailArray[ $key ]["unixTime"] ) == date( "Y" ) )
			{
				// Message sent this year
				$f_dat = date( "j M Y H:i", $mailArray[ $key ]["unixTime"] );
			}
			else
			{
				$f_dat = date( "Y-m-d H:i", $mailArray[ $key ]["unixTime"] );
			}

			$q = "SELECT * FROM fl_images WHERE userId = " . (int)$mailArray[ $key ]["userId"] . " AND imageType = 'profileSmall'";
			$mailImage = $DB->GetRow( $q, FALSE, TRUE );
			if ( count( $mailImage ) > 0 )
			{
				$avatar = "<img src=\"" . $baseUrl . "/user-photos/" . str_replace('http://www.flator.se/rwdx/user/', '', $mailImage["imageUrl"]) . "/profile-thumb/" . "\" border=\"0\"  />";

			}
			else
			{
				$avatar = "<img src=\"" . $baseUrl . "/img/symbols/gif_avatars/person_avnatar_liten.gif\" border=\"0\" width=\"26\" height=\"29\" />";
			}

			$q = "SELECT * FROM fl_images WHERE userId = " . (int)$mailArray[ $key ]["userId"] . " AND imageType = 'profileMedium'";
			$guestImage = $DB->GetRow( $q, FALSE, TRUE );
			if ( count( $guestImage ) > 0 )
			{
				$mediumAvatar = $guestImage["imageUrl"];
			}
			else
			{
				$mediumAvatar = $baseUrl . "/img/symbols/gif_avatars/person_avantar_stor.gif";
			}
			
			$q = "SELECT *, UNIX_TIMESTAMP(insDate) AS unixTime FROM fl_status WHERE userId = " . (int)$mailArray[ $key ]["userId"] . " AND statusType = 'personalMessage' ORDER BY insDate DESC LIMIT 0,1";
			$statusRow = $DB->GetRow( $q, FALSE, TRUE );
			$mailArray[ $key ]["status"] = truncate(stripslashes($statusRow["statusMessage"]), 16, "..", TRUE, TRUE);


			$q = "SELECT *, UNIX_TIMESTAMP(insDate) AS unixTime FROM fl_users_online WHERE userId = " . (int)$mailArray[ $key ]["userId"] . " ORDER BY insDate DESC LIMIT 0,1";
			$onlineRow = $DB->GetRow( $q, FALSE, TRUE );
			if ( ( time() - $onlineRow["unixTime"] ) < 900 && $onlineRow["unixTime"] > 0 )
			{
				$mailArray[ $key ]["online"] = "Online";
			}
			else
			{
				if ( $onlineRow["unixTime"] > 0 )
				{
					$mailArray[ $key ]["online"] = $onlineRow["unixTime"];
				}
				else
				{
					$mailArray[ $key ]["online"] = "never";
				}
			}			

			unset( $onlineTime );
			if ( $mailArray[ $key ]["online"] == "Online" )
			{
				$onlineTime = "<div class=\"email_date\">Online</div>";
			} elseif ( $mailArray[ $key ]["online"] == "never" )
			{
				$onlineTime = "<div class=\"email_date\">Aldrig inloggad</div>";
			}
			else
			{
				// Possible date-types: Today, Yesterday, ThisYear, LastYear
				if ( date("Y-m-d", $mailArray[ $key ]["online"] ) == date( "Y-m-d" ) )
				{
					// Message sent today
					$onlineTime = "<div class=\"email_date\">" . "Idag kl " . date( "H:i", $mailArray[ $key ]["online"] ) . "</div>";
				}
				elseif ( date("Y-m-d", $mailArray[ $key ]["online"] ) == date( "Y-m-d", ( time() - 86400 ) ) )
				{
					// Message sent yesterday
					$onlineTime = "<div class=\"email_date\">" . "Ig&aring;r kl " . date( "H:i", $mailArray[ $key ]["online"] ) . "</div>";
				}
				elseif ( date("Y", $mailArray[ $key ]["online"] ) == date( "Y" ) )
				{
					// Message sent this year
					$onlineTime = "<div class=\"email_date\">" . date( "j M Y H:i", $mailArray[ $key ]["online"] ) . "</div>";
				}
				else
				{
					$onlineTime = "<div class=\"email_date\">" . date( "Y-m-d H:i", $mailArray[ $key ]["online"] ) . "</div>";
				}
			}

							

						$bodyContent .=  '
			<table style="width: 100%;" cellpadding="0" cellspacing="5">
			<tbody><tr>
			<td>
			<table cellpadding="0" cellspacing="0" width="100%">

			<tbody>

			<tr>
			<td style="width: 120px; vertical-align:top;">

			<a href="'.($mailArray[ $key ]["username"] != "" ? $baseUrl.'/user/'.$mailArray[ $key ]["username"].'.html' : "#noexist").'">'.(strlen($mailArray[ $key ]["username"]) < 1 ? "Ej längre medlem" : $mailArray[ $key ]["username"]).'</a><br>
			<div style="font-size:10px">' . $mailArray[ $key ]["status"] . "</div>" . $onlineTime . '<br>

			<a href="javascript:void(null)" onClick="showImage2(\'popupMediumImage'.$key.'\',\'' . $mediumAvatar . '\', \'mediumProfileImage'.$key.'\');" style="font-weight: normal;">' . $avatar . '</a>';
			$bodyContent .= "<div style=\"position:relative;\"><div id=\"popupMediumImage".$key."\" style=\"display: none; position:absolute;border: 2px solid #645d54; top: 0px; left: 0px; z-index: 101; background-color: #ffffff; \"><div style=\"margin: 0px;\"><div style=\"float: left; display: block;\"><a href=\"javascript:void(null)\" onclick=\"closeImage2('popupMediumImage".$key."');\"><img src=\"".$baseUrl."/img/symbols/gif_avatars/person_avantar_stor.gif\" id=\"mediumProfileImage".$key."\" border=\"0\" style=\"margin: 3px;\" /></a></div></div></div></div>";	
			$bodyContent .= '
			</td>

			<td style="padding-left: 5px; vertical-align:top;" rowspan="2"><div style="border-bottom:1px dotted #c8c8c8; font-size:11px;"><b>Tråd: </b>'.$threadSubject.'</div><br>';
			$text = $mailArray[ $key ]['text']." ";
			$text = $parser->p($text, 1, 1, 1, 1, 1, 0);
			//$text = nl2br($text);
			$bodyContent .=  $text;
			$bodyContent .=  '<br><br><br>
			<i>'.($mailArray[ $key ]['lastUpdate'] != "0000-00-00 00:00:00" ? "Redigerad: ".$mailArray[ $key ]['lastUpdate'] : "").'</i>
			</td>
			</tr>

			<tr>
			<td style="width: 120px; "></td>
			</tr>
			<tr>
			<td style="border-bottom:1px dotted #c8c8c8; font-size:5px; line-height:5px;" colspan="2">&nbsp;</td>
			</tr>
			<tr>
			<td colspan="2" style="padding-top:3px;">';
			if ($userProfile['id'] == $mailArray[ $key ]['userId']){
			$bodyContent .=  '<span style="float:left; font-size:11px;"><a href="'.$baseUrl.'/forum/'.$_GET["forumCat"].'/'.$_GET["thread"].'.html?edit='.$mailArray[ $key ]['id'].'">Redigera</a></span>';
			}
			$bodyContent .= '<span style="float:right; font-size:11px;"><b>Inlägg publicerat:</b>  '.$f_dat.'</span>';

			$bodyContent .= '</td>

			</tr>
			</tbody></table>                
			</td>
			</tr></tbody></table><br>';


			$printed++;



		}



	}
	else
	{

	}
			$body .= pagingButtons($countResult[0]+1, $numPerPage, (int)$_GET["offset"], (int)$printed,  $baseUrl . "/forum/".$_GET["forumCat"].'/'.$_GET["thread"].".html?visa");
			$body .= $bodyContent;
			$body .= pagingButtons($countResult[0]+1, $numPerPage, (int)$_GET["offset"], (int)$printed,  $baseUrl . "/forum/".$_GET["forumCat"].'/'.$_GET["thread"].".html?visa");



$body .= '<br /><br /><form action="" method="post" name="svara">';
$body .= '<span onMouseOver="document.fetStil.src=\'' . $baseUrl . '/img/symbols/forum/tf_bold_active.gif\'" onMouseOut="document.fetStil.src=\'' . $baseUrl . '/img/symbols/forum/tf_bold.gif\'"><a href="#noexist" onClick="document.forms[\'svara\']. elements[\'text\'].value=document.forms[\'svara\']. elements[\'text\'].value+\'[b][/b]\'" style="font-weight: normal"><img src="' . $baseUrl . '/img/symbols/forum/tf_bold.gif" border="0" style="vertical-align:middle;" name="fetStil"></a></span>
<span onMouseOver="document.kursivStil.src=\'' . $baseUrl . '/img/symbols/forum/tf_italic_active.gif\'" onMouseOut="document.kursivStil.src=\'' . $baseUrl . '/img/symbols/forum/tf_italic.gif\'"><a href="#noexist" onClick="document.forms[\'svara\']. elements[\'text\'].value=document.forms[\'svara\']. elements[\'text\'].value+\'[i][/i]\'" style="font-weight: normal"><img src="' . $baseUrl . '/img/symbols/forum/tf_italic.gif" border="0" style="vertical-align:middle;" name="kursivStil"></a></span>
<span onMouseOver="document.underStruken.src=\'' . $baseUrl . '/img/symbols/forum/tf_underline_active.gif\'" onMouseOut="document.underStruken.src=\'' . $baseUrl . '/img/symbols/forum/tf_underline.gif\'"><a href="#noexist" onClick="document.forms[\'svara\']. elements[\'text\'].value=document.forms[\'svara\']. elements[\'text\'].value+\'[u][/u]\'" style="font-weight: normal"><img src="' . $baseUrl . '/img/symbols/forum/tf_underline.gif" border="0" style="vertical-align:middle;" name="underStruken"></a></span>
<span onMouseOver="document.skapaLank.src=\'' . $baseUrl . '/img/symbols/forum/tf_link_active.gif\'" onMouseOut="document.skapaLank.src=\'' . $baseUrl . '/img/symbols/forum/tf_link.gif\'"><a href="#noexist" onClick="addurl(document.forms[\'svara\'].elements[\'text\']);" style="font-weight: normal"><img src="' . $baseUrl . '/img/symbols/forum/tf_link.gif" border="0" style="vertical-align:middle;" name="skapaLank"></a></span>';

$body .= '
<br>';
$body .= '<textarea cols="60" rows="10" name="text"></textarea><br />
<input type="submit" class="submit" name="addsvar" value="Svara">
</form>';


	$body.= "<div id=\"divFooterSpace\">";
/*
	// Paging
	if ( count( $mailArray ) > $numPerPage )
	{
		if ( (int)$_GET["offset"] > 0 )
		{
			$body.= "<div id=\"previous\"><a href=\"" . $baseUrl . "/inbox.html?offset=" . ( (int)$_GET["offset"] - $numPerPage ) . "&sortBy=" . (int)$_GET["sortBy"] . "\">F&ouml;reg&aring;ende sida</a></div>";
		}
		else
		{
			$body.= "<div id=\"previous\">&nbsp;</div>\n";
		}
		$body.= "<div id=\"middle\" style=\"text-align: center\"><b>" . $i2 . "</b> av <b>". count( $mailArray ) . "</b></div>\n";
		if ( $i < count( $mailArray ) )
		{
			$body.= "<div id=\"next\"><a href=\"" . $baseUrl . "/inbox.html?offset=" . $i . "&sortBy=" . (int)$_GET["sortBy"] . "\">N&auml;sta sida</a></div>";
		}
	}
	else
	{
		$body.= "<div id=\"previous\">&nbsp;</div><div id=\"middle\" style=\"text-align: center\"><b>" . count( $mailArray ) . "</b> av <b>" . count( $mailArray ) . "</b></div>\n";		
	}
*/
	$body.= "&nbsp;</div></p></form>

</div>

<div id=\"right\">";
$body.= rightMenu('myAccount');
$body.= "</div>";
?>